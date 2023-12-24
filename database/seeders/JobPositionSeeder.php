<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobPositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jobPositions = [
            'Manufacturing' => ['Production Manager', 'Production Supervisor', 'Production Operator'],
            'Purchase' => ['Purchase Manager', 'Purchase Supervisor', 'Purchase Operator'],
            'Sales' => ['Sales Manager', 'Sales Supervisor', 'Sales Operator'],
            'Accounting' => ['Accounting Manager', 'Accounting Supervisor', 'Accounting Operator'],
            'HRD' => ['HRD Manager', 'HRD Supervisor', 'HRD Operator'],
        ];

        foreach ($jobPositions as $department => $jobPosition) {
            $department = \App\Models\Department::where('name', $department)->first();

            foreach ($jobPosition as $position) {
                \App\Models\JobPosition::create([
                    'department_id' => $department->id,
                    'name' => $position,
                ]);
            }
        }
    }
}
