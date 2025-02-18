<?php

namespace App\Http\Controllers;

use App\Services\EmployeeService;
use App\Http\Requests\EmployeeStoreRequest;
use App\Http\Requests\EmployeeUpdateRequest;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    protected $employeeService;

    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    public function index(Request $request)
    {
        $query = Employee::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('nip', 'like', '%' . $request->search . '%');
        }

        $employees = $query->paginate(10);

        $users = [];
        if (auth()->user()->level->name === 'Admin') {
            $users = $this->employeeService->getUsersWithoutEmployee();
        }

        return view('pages.admin.employee.index', compact('employees', 'users'));
    }

    public function create()
    {
        return view('pages.admin.employee.create');
    }

    public function store(EmployeeStoreRequest $request)
    {
        $validated = $request->validated();
        $userRole = auth()->user()->level->name;

        $this->employeeService->createEmployee($validated, $userRole);

        return redirect()->route('employee.index')->with('success', 'Pegawai berhasil ditambahkan');
    }

    public function edit(string $id)
    {
        $employee = Employee::findOrFail($id);
        $users = $this->employeeService->getUsersForEmployee($employee);

        return view('pages.admin.employee.edit', compact('employee', 'users'));
    }

    public function update(EmployeeUpdateRequest $request, string $id)
    {
        $validated = $request->validated();
        $employee = Employee::findOrFail($id);
        $userRole = auth()->user()->level->name;

        $this->employeeService->updateEmployee($employee, $validated, $userRole);

        return redirect()->route('employee.index')->with('success', 'Pegawai berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        $employee = Employee::findOrFail($id);

        $this->employeeService->deleteEmployee($employee);

        return redirect()->route('employee.index')->with('success', 'Data berhasil dihapus!');
    }
}
