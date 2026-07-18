<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Employee;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (range(1, 5) as $i) {

            Employee::create([
                'name' => "Employee {$i}",
                'email' => "employee{$i}@mail.com",
                'phone' => '018' . rand(10000000,99999999),
                'kpi_score' => rand(0,20),
            ]);
        }
    }
}
