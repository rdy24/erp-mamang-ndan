<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $title = 'Hapus Department';
        $text = "Apakah anda yakin ingin menghapus Department ini?";
        confirmDelete($title, $text);
        $departments = Department::with(['jobPositions', 'employees'])->get();

        return view('pages.departments.index', [
            'departments' => $departments,
        ]);
    }

    public function create()
    {
        return view('pages.departments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:departments,name',
        ]);

        Department::create([
            'name' => $request->name,
        ]);

        return redirect()->route('dashboard.departments.index')->with('success', 'Department created successfully!');
    }

    public function show(Department $department)
    {
        return view('pages.departments.show', [
            'department' => $department,
        ]);
    }

    public function edit(Department $department)
    {
        return view('pages.departments.edit', [
            'department' => $department,
        ]);
    }

    public function update(Request $request, Department $department)
    {
        $request->validate([
            'name' => 'required|unique:departments,name,' . $department->id,
        ]);

        $department->update([
            'name' => $request->name,
        ]);

        return redirect()->route('dashboard.departments.index')->with('success', 'Department updated successfully!');
    }

    public function destroy(Department $department)
    {
        $department->delete();

        return redirect()->route('dashboard.departments.index')->with('success', 'Department deleted successfully!');
    }

    public function print()
    {
        $departments = Department::all();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pages.departments.print', ['departments' => $departments]);

        return $pdf->stream('departments.pdf');
    }
}
