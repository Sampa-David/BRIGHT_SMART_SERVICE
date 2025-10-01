<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run()
    {
        $departments = [
            'Management',
            'Development',
            'Design',
            'Marketing',
            'Support'
        ];

        foreach ($departments as $department) {
            Department::create(['name' => $department]);
        }
    }
}