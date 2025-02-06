<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employees = [
            ['name' => 'Dewa', 'nip' => '123456789', 'address' => 'Jl. pertama, Kota Pasuruan', 'id_user' => 3],
        ];

        foreach ($employees as $employee) {
            Employee::create($employee);
        }
    }
}
