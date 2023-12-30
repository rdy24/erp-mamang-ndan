<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use App\Models\JobPosition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public function index()
    {
        $title = 'Hapus Employee';
        $text = "Apakah anda yakin ingin menghapus Employee ini?";
        confirmDelete($title, $text);
        $employees = Employee::with(['department', 'jobPosition'])
                        ->when(request()->search, function($employees) {
                            $employees = $employees->where('name', 'like', "%" . request()->search . "%");
                        })
                        ->when(request()->department_id, function($employees) {
                            $employees = $employees->where('department_id', request()->department_id);
                        })
                        ->paginate(5);

        return view('pages.employees.index', [
            'employees' => $employees,
        ]);
    }

    public function create()
    {
        $jobPositions = JobPosition::all();
        $departments = Department::all();
        return view('pages.employees.create', [
            'jobPositions' => $jobPositions,
            'departments' => $departments,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:employees,name',
            'email' => 'required|email|unique:employees,email',
            'phone_number' => 'required|numeric|unique:employees,phone_number',
            'address' => 'required',
            'department_id' => 'required|exists:departments,id',
            'job_position_id' => 'required|exists:job_positions,id',
        ]);

        if ($request->hasFile('photo')) {
            $request->validate([
                'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            $photo = $request->file('photo');
            $photoName = time() . '.' . $photo->extension();
            $photo->move(public_path('uploads/employee'), $photoName);
        } else {
            $photoName = null;
        }

        Employee::create([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'department_id' => $request->department_id,
            'job_position_id' => $request->job_position_id,
            'photo' => $photoName,
        ]);

        return redirect()->route('dashboard.employees.index')->with('success', 'Employee created successfully!');
    }

    public function edit(Employee $employee)
    {
        $jobPositions = JobPosition::all();
        $departments = Department::all();
        return view('pages.employees.edit', [
            'employee' => $employee,
            'jobPositions' => $jobPositions,
            'departments' => $departments,
        ]);
    }

    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'address' => 'required',
            'department_id' => 'required|exists:departments,id',
            'job_position_id' => 'required|exists:job_positions,id',
        ]);

        if ($request->email != $employee->email) {
            $request->validate([
                'email' => 'required|email|unique:employees,email',
            ]);
        }

        if ($request->phone_number != $employee->phone_number) {
            $request->validate([
                'phone_number' => 'required|numeric|unique:employees,phone_number',
            ]);
        }

        if ($request->name != $employee->name) {
            $request->validate([
                'name' => 'required|unique:employees,name',
            ]);
        }
        
        if ($request->hasFile('photo')) {
            $request->validate([
                'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            $photo = $request->file('photo');
            $photoName = time() . '.' . $photo->extension();
            $photo->move(public_path('uploads/employee'), $photoName);

            if ($employee->photo) {
                Storage::delete('public/uploads/employee' . $employee->photo);
            }
        } else {
            $photoName = $employee->photo;
        }

        $employee->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'department_id' => $request->department_id,
            'job_position_id' => $request->job_position_id,
            'photo' => $photoName,
        ]);

        return redirect()->route('dashboard.employees.index')->with('success', 'Employee updated successfully!');
    }

    public function destroy(Employee $employee)
    {
        if ($employee->photo) {
            Storage::delete('public/uploads/employee' . $employee->photo);
        }
        $employee->delete();

        return redirect()->route('dashboard.employees.index')->with('success', 'Employee deleted successfully!');
    }

    public function print()
    {
        $employees = Employee::all();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pages.employees.print', ['employees' => $employees]);

        return $pdf->stream('employees.pdf');
    }
}
