<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
            $users = User::doesntHave('employee')
                ->whereHas('level', function ($query) {
                    $query->where('name', 'User');
                })
                ->get();
        }

        return view('pages.admin.employee.index', compact('employees', 'users'));
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
            'address' => 'required',
        ]);

        $userRole = auth()->user()->level->name;

        if ($userRole === 'User') {
            $user = auth()->user();
            $employee = Employee::create([
                'name' => $request->name,
                'nip' => $request->nip,
                'address' => $request->address,
                'id_user' => $user->id,
            ]);
        } elseif ($userRole === 'Admin') {
            $request->validate([
                'user_id' => 'required|exists:users,id',
            ]);

            $selectedUser = User::findOrFail($request->user_id);
            $employee = Employee::create([
                'name' => $request->name,
                'nip' => $request->nip,
                'address' => $request->address,
                'id_user' => $selectedUser->id,
            ]);
        }

        return redirect()->route('employee.index')->with('success', 'Pegawai berhasil ditambahkan');
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

        $users = User::whereDoesntHave('employee')
            ->orWhereHas('employee', function ($query) use ($employee) {
                $query->where('id', $employee->id);
            })
            ->whereHas('level', function ($query) {
                $query->where('name', 'User');
            })
            ->get();

        return view('pages.admin.employee.edit', [
            'employee' => $employee,
            'users' => $users,
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

        $employee->update([
            'name' => $request->name,
            'nip' => $request->nip,
            'address' => $request->address,
        ]);

        $userRole = auth()->user()->level->name;

        if ($userRole === 'User') {
            $user = auth()->user();
            $employee->update(['id_user' => $user->id]);
        } elseif ($userRole === 'Admin') {
            $request->validate([
                'user_id' => 'required|exists:users,id',
            ]);

            $selectedUser = User::findOrFail($request->user_id);
            $employee->update(['id_user' => $selectedUser->id]);
        }

        return redirect()->route('employee.index')->with('success', 'Pegawai berhasil diperbarui');
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
