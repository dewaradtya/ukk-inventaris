<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Employee;
use App\Models\Inventory;
use Illuminate\Http\Request;

class ReturnController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->level->name === 'Peminjam') {
            $employee = Employee::where('id_user', $user->id)->first();

            $borrowings = $employee
                ? Borrowing::where('id_employee', $employee->id)
                ->where('loan_status', 'return')
                ->with('employee')
                ->paginate(10)
                : Borrowing::where('id', null)->paginate(10);
        } else {
            $borrowings = Borrowing::where('loan_status', 'return')
                ->with('employee')
                ->paginate(10);
        }

        return view('pages.admin.return.index', [
            'borrowings'  => $borrowings,
            'employees'   => Employee::all(),
            'inventories' => Inventory::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
