<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\User;

class EmployeeService
{
    public function createEmployee(array $data, $userRole)
    {
        if ($userRole === 'Peminjam') {
            $user = auth()->user();
            return Employee::create([
                'name' => $data['name'],
                'nip' => $data['nip'],
                'address' => $data['address'],
                'id_user' => $user->id,
            ]);
        } elseif ($userRole === 'Admin') {
            return Employee::create([
                'name' => $data['name'],
                'nip' => $data['nip'],
                'address' => $data['address'],
                'id_user' => $data['user_id'],
            ]);
        }
    }

    public function updateEmployee(Employee $employee, array $data, $userRole)
    {
        $employee->update([
            'name' => $data['name'],
            'nip' => $data['nip'],
            'address' => $data['address'],
        ]);

        if ($userRole === 'Peminjam') {
            $user = auth()->user();
            $employee->update(['id_user' => $user->id]);
        } elseif ($userRole === 'Admin') {
            $employee->update(['id_user' => $data['user_id']]);
        }

        return $employee;
    }

    public function deleteEmployee(Employee $employee)
    {
        return $employee->delete();
    }

    public function getUsersWithoutEmployee()
    {
        return User::doesntHave('employee')
            ->whereHas('level', function ($query) {
                $query->where('name', 'Peminjam');
            })
            ->get();
    }

    public function getUsersForEmployee(Employee $employee)
    {
        return User::whereDoesntHave('employee')
            ->orWhereHas('employee', function ($query) use ($employee) {
                $query->where('id', $employee->id);
            })
            ->whereHas('level', function ($query) {
                $query->where('name', 'Peminjam');
            })
            ->get();
    }
}
