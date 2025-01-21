<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::all();
        return view('pages.admin.employee.index', [
            'employees' => $employees
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.employee.create');
    }

    /**
     * Menyimpan employee baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'nip' => 'required|unique:employees',
            'address' => 'required'
        ]);

        $employees = Employee::create([
            'name' => $request->name,
            'nip' => $request->nip,
            'address' => $request->address
        ]);

        return redirect()->route('employee.index')->with('success', 'employee berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $employee = Employee::findOrFail($id);
        return view('pages.admin.employee.edit', [
            'employee' => $employee,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'nip' => 'required|unique:employees,nip,' . $id,
            'address' => 'required',
        ]);

        $employee = Employee::findOrFail($id);

        $employee->name = $request->name;
        $employee->nip = $request->nip;
        $employee->address = $request->address;
        $employee->save();

        return redirect()->route('employee.index')->with('success', 'employee berhasil diperbarui');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $employees = Employee::findOrFail($id);
        $employees->delete();

        return redirect()->route('employee.index')->with('success', 'Data berhasil dihapus!');
    }
}
