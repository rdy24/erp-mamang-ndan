<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = ['Manufacturing', 'Purchase', 'Sales', 'Accounting', 'HRD'];

        foreach ($departments as $department) {
            \App\Models\Department::create([
                'name' => $department,
            ]);
        }
    }
}
