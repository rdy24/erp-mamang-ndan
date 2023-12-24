<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\JobPosition;
use Illuminate\Http\Request;

class JobPositionController extends Controller
{
    public function index()
    {
        $title = 'Hapus Job Position';
        $text = "Apakah anda yakin ingin menghapus Job Position ini?";
        confirmDelete($title, $text);

        $jobPositions = JobPosition::with(['department'])->get();
        return view('pages.job-positions.index', [
            'jobPositions' => $jobPositions,
        ]);
    }

    public function create()
    {
        $departments = Department::all();
        return view('pages.job-positions.create', [
            'departments' => $departments,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:job_positions,name',
            'department_id' => 'required|exists:departments,id',
        ]);

        JobPosition::create([
            'name' => $request->name,
            'department_id' => $request->department_id,
        ]);

        return redirect()->route('dashboard.job-positions.index')->with('success', 'Job Position created successfully!');
    }

    public function show(JobPosition $jobPosition)
    {
        return view('pages.job-positions.show', [
            'jobPosition' => $jobPosition,
        ]);
    }

    public function edit(JobPosition $jobPosition)
    {
        $departments = Department::all();
        return view('pages.job-positions.edit', [
            'jobPosition' => $jobPosition,
            'departments' => $departments,
        ]);
    }

    public function update(Request $request, JobPosition $jobPosition)
    {
        $request->validate([
            'name' => 'required|unique:job_positions,name,' . $jobPosition->id,
            'department_id' => 'required|exists:departments,id',
        ]);

        $jobPosition->update([
            'name' => $request->name,
            'department_id' => $request->department_id,
        ]);

        return redirect()->route('dashboard.job-positions.index')->with('success', 'Job Position updated successfully!');
    }

    public function destroy(JobPosition $jobPosition)
    {
        $jobPosition->delete();

        return redirect()->route('dashboard.job-positions.index')->with('success', 'Job Position deleted successfully!');
    }

    public function getJobPositionByDepartmentId($id)
    {
        $jobPositions = JobPosition::where('department_id', $id)->get();

        return response()->json([
            'jobPositions' => $jobPositions,
        ]);
    }
}
