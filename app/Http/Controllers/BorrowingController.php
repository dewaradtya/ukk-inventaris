<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Employee;
use App\Models\Inventory;
use App\Models\LoanDetail;
use Illuminate\Http\Request;

class BorrowingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->level->name === 'User') {
            $employee = Employee::where('id_user', $user->id)->first();

            $borrowings = $employee
                ? Borrowing::where('id_employee', $employee->id)->with('employee')->paginate(10)
                : Borrowing::where('id', null)->paginate(10);
        } else {
            $borrowings = Borrowing::with('employee')->paginate(10);
        }

        return view('pages.admin.borrowing.index', [
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
        $employees = Employee::all();
        return view('pages.admin.borrowing.create', [
            'employees' => $employees,
        ]);
    }

    /**
     * Menyimpan borrowing baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'borrow_date' => 'required|date',
            'id_inventories' => 'required|array',
            'id_inventories.*' => 'exists:inventories,id',
            'amount' => 'required|array',
            'amount.*' => 'integer|min:1',
        ]);

        if (auth()->user()->level->name === 'User') {
            $employee = Employee::where('id_user', auth()->user()->id)->first();
            if (!$employee) {
                return redirect()->back()->with('error', 'Mohon isi data pegawai terlebih dahulu.');
            }
            $idEmployee = $employee->id;
        } else {
            $request->validate([
                'id_employee' => 'required|exists:employees,id',
            ]);
            $idEmployee = $request->id_employee;
        }

        $returnDate = date('Y-m-d', strtotime($request->borrow_date . ' +7 days'));

        $borrowing = Borrowing::create([
            'borrow_date' => $request->borrow_date,
            'return_date' => $returnDate,
            'loan_status' => 'borrow',
            'id_employee' => $idEmployee,
        ]);

        foreach ($request->id_inventories as $key => $inventoryId) {
            LoanDetail::create([
                'id_borrowing' => $borrowing->id,
                'id_inventories' => $inventoryId,
                'amount' => $request->amount[$key],
            ]);

            $inventory = Inventory::find($inventoryId);
            $inventory->amount -= $request->amount[$key];
            $inventory->save();
        }

        return redirect()->route('borrowing.index')->with('success', 'Borrowing dan Loan Detail berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $borrowing = Borrowing::findOrFail($id);
        $employees = Employee::all();
        $inventories = Inventory::all();

        return view('pages.admin.borrowing.edit', [
            'borrowing' => $borrowing,
            'employees' => $employees,
            'inventories' => $inventories,
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
            'id_inventories' => 'required|array',
            'id_inventories.*' => 'exists:inventories,id',
            'amount' => 'required|array',
            'amount.*' => 'integer|min:1',
        ]);

        $borrowing = Borrowing::findOrFail($id);

        if (auth()->user()->level->name === 'User') {
            $employee = Employee::where('id_user', auth()->user()->id)->first();

            if (!$employee) {
                return redirect()->back()->with('error', 'Mohon isi data pegawai terlebih dahulu.');
            }

            $idEmployee = $employee->id;
        } else {
            $request->validate([
                'id_employee' => 'required|exists:employees,id',
            ]);
            $idEmployee = $request->id_employee;
        }

        foreach ($borrowing->loanDetails as $loanDetail) {
            $inventory = Inventory::find($loanDetail->id_inventories);
            if ($inventory) {
                $inventory->increment('amount', $loanDetail->amount);
            }
        }

        $borrowing->loanDetails()->delete();

        $borrowing->update([
            'borrow_date' => $request->borrow_date,
            'return_date' => $request->return_date,
            'id_employee' => $idEmployee,
        ]);

        foreach ($request->id_inventories as $index => $inventoryId) {
            $amount = $request->amount[$index];
            $inventory = Inventory::find($inventoryId);

            if ($inventory && $inventory->amount >= $amount) {
                $inventory->decrement('amount', $amount);
            } else {
                return redirect()->back()->with('error', 'Stok inventaris tidak mencukupi.');
            }

            $borrowing->loanDetails()->create([
                'id_inventories' => $inventoryId,
                'amount' => $amount,
            ]);
        }

        return redirect()->route('borrowing.index')->with('success', 'Borrowing berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $borrowing = Borrowing::findOrFail($id);
        foreach ($borrowing->loanDetails as $loanDetail) {
            $inventory = Inventory::find($loanDetail->id_inventories);

            $inventory->increment('amount', $loanDetail->amount);
        }

        $borrowing->loanDetails()->delete();

        $borrowing->delete();

        return redirect()->route('borrowing.index')->with('success', 'Data berhasil dihapus!');
    }

    public function updateStatus(Request $request, $id)
    {
        $borrowing = Borrowing::findOrFail($id);

        if (!in_array($request->loan_status, ['borrow', 'return'])) {
            return response()->json(['success' => false], 400);
        }

        if ($request->loan_status === 'return' && $borrowing->loan_status !== 'return') {
            foreach ($borrowing->loanDetails as $loanDetail) {
                $inventory = Inventory::find($loanDetail->id_inventories);
                if ($inventory) {
                    $inventory->increment('amount', $loanDetail->amount);
                }
            }
        }

        $borrowing->loan_status = $request->loan_status;
        $borrowing->save();

        return redirect()->route('borrowing.index')->with('success', 'Borrowing berhasil diperbarui');
    }
}
