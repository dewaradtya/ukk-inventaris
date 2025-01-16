<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Employee; // Pastikan Employee model diimport
use Illuminate\Http\Request;

class BorrowingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $borrowings = Borrowing::all();
        $employees = Employee::all();
    
        return view('pages.borrowing.index', [
            'borrowings' => $borrowings,
            'employees' => $employees,
        ]);
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = Employee::all();
        return view('pages.borrowing.create', [
            'employees' => $employees,
        ]);
    }

    /**
     * Menyimpan borrowing baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'borrow_date' => 'required|date',
            'return_date' => 'nullable|date|after_or_equal:borrow_date',
            'loan_status' => 'required|string',
            'id_employee' => 'required|exists:employees,id',
        ]);

        Borrowing::create([
            'borrow_date' => $request->borrow_date,
            'return_date' => $request->return_date,
            'loan_status' => $request->loan_status,
            'id_employee' => $request->id_employee,
        ]);

        return redirect()->route('borrowing.index')->with('success', 'Borrowing berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $borrowing = Borrowing::findOrFail($id);
        $employees = Employee::all();
        return view('pages.borrowing.edit', [
            'borrowing' => $borrowing,
            'employees' => $employees,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'borrow_date' => 'required|date',
            'return_date' => 'nullable|date|after_or_equal:borrow_date',
            'loan_status' => 'required|string',
            'id_employee' => 'required|exists:employees,id',
        ]);

        $borrowing = Borrowing::findOrFail($id);

        $borrowing->update([
            'borrow_date' => $request->borrow_date,
            'return_date' => $request->return_date,
            'loan_status' => $request->loan_status,
            'id_employee' => $request->id_employee,
        ]);

        return redirect()->route('borrowing.index')->with('success', 'Borrowing berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $borrowing = Borrowing::findOrFail($id);
        $borrowing->delete();

        return redirect()->route('borrowing.index')->with('success', 'Data berhasil dihapus!');
    }
}
