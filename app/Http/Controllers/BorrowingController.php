<?php

namespace App\Http\Controllers;

use App\Exports\BorrowingExport;
use App\Models\Borrowing;
use App\Models\Employee;
use App\Models\Fine;
use App\Models\FineSetting;
use App\Models\Inventory;
use App\Models\LoanDetail;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class BorrowingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $search = $request->input('search');

        $query = Borrowing::where('loan_status', 'borrow');

        if ($user->level->name === 'Peminjam') {
            $employee = Employee::where('id_user', $user->id)->first();

            if ($employee) {
                $query->where('id_employee', $employee->id);
            } else {
                $query->where('id', null);
            }
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('employee', function ($subQuery) use ($search) {
                    $subQuery->where('name', 'like', "%{$search}%");
                })->orWhereHas('loanDetails.inventory', function ($subQuery) use ($search) {
                    $subQuery->where('name', 'like', "%{$search}%");
                });
            });
        }

        $borrowings = $query->with('employee', 'loanDetails.inventory')->paginate(10);

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

        if (auth()->user()->level->name === 'Peminjam') {
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

        $activeBorrowings = Borrowing::where('id_employee', $idEmployee)
            ->where('loan_status', 'borrow')
            ->count();

        if ($activeBorrowings >= 3) {
            return redirect()->back()->with('error', 'Anda sudah memiliki 3 peminjaman aktif. Kembalikan salah satu sebelum meminjam lagi.');
        }

        $returnDate = date('Y-m-d', strtotime($request->borrow_date . ' +7 days'));

        DB::beginTransaction();

        try {
            $borrowing = Borrowing::create([
                'borrow_date' => $request->borrow_date,
                'return_date' => $returnDate,
                'loan_status' => 'borrow',
                'id_employee' => $idEmployee,
            ]);

            foreach ($request->id_inventories as $key => $inventoryId) {
                $inventory = Inventory::find($inventoryId);
                $requestedAmount = $request->amount[$key];

                if ($inventory->amount < $requestedAmount) {
                    return redirect()->back()->with('error', "Stok untuk {$inventory->name} tidak mencukupi. Tersedia: {$inventory->amount}");
                }

                LoanDetail::create([
                    'id_borrowing' => $borrowing->id,
                    'id_inventories' => $inventoryId,
                    'amount' => $requestedAmount,
                ]);

                $inventory->amount -= $requestedAmount;
                $inventory->save();
            }

            DB::commit();

            return redirect()->route('borrowing.index')->with('success', 'Borrowing dan Loan Detail berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat meminjam. Silakan coba lagi.');
        }
    }

    public function show(string $id)
    {
        //
    }

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
            'id_inventories' => 'required|array',
            'id_inventories.*' => 'exists:inventories,id',
            'amount' => 'required|array',
            'amount.*' => 'integer|min:1',
        ]);

        $borrowing = Borrowing::findOrFail($id);

        if (auth()->user()->level->name === 'Peminjam') {
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

        $updateData = [
            'borrow_date' => $request->borrow_date,
            'id_employee' => $idEmployee,
        ];

        if (auth()->user()->level->name === 'Admin') {
            $request->validate([
                'return_date' => 'nullable|date|after_or_equal:borrow_date',
            ]);
            $updateData['return_date'] = $request->return_date;
        }

        $borrowing->update($updateData);

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

        $request->validate([
            'loan_status' => 'required|in:borrow,return',
        ]);

        if ($request->loan_status === 'return' && !in_array(auth()->user()->level->name, ['Admin', 'Operator'])) {
            return redirect()->back()->with('error', 'Hanya Admin dan Operator yang dapat mengonfirmasi pengembalian.');
        }

        if ($request->loan_status === 'return' && $borrowing->loan_status !== 'return') {
            foreach ($borrowing->loanDetails as $loanDetail) {
                $inventory = Inventory::find($loanDetail->id_inventories);
                if ($inventory) {
                    $inventory->increment('amount', $loanDetail->amount);
                }
            }

            $borrowing->actual_return_date = now();
            $borrowing->save();

            $fineAmount = $this->calculateFine($borrowing);

            if ($fineAmount > 0) {
                Fine::create([
                    'borrowing_id' => $borrowing->id,
                    'fine_amount' => $fineAmount,
                    'status' => 'unpaid',
                ]);
            }
        }

        $borrowing->loan_status = $request->loan_status;
        $borrowing->save();

        return redirect()->route('borrowing.index')->with('success', 'Status peminjaman berhasil diperbarui.');
    }

    private function calculateFine($borrowing)
    {
        if (!$borrowing->actual_return_date || !$borrowing->return_date) {
            return 0;
        }

        $fineSetting = FineSetting::first();

        if (!$fineSetting) {
            return 0;
        }

        $lateDays = Carbon::parse($borrowing->return_date)->diffInDays($borrowing->actual_return_date, false);
        $fineAmount = 0;

        if ($lateDays > 0) {
            $fineAmount = $lateDays * $fineSetting->late_fee;
        }

        if ($borrowing->is_lost) {
            $fineAmount += $fineSetting->lost_fee;
        }

        return $fineAmount;
    }


    public function export(Request $request)
    {
        $borrowingIds = $request->query('ids');

        if ($borrowingIds) {
            $borrowingIdsArray = explode(',', $borrowingIds);
            $borrowings = Borrowing::with(['employee', 'loanDetails.inventory'])
                ->whereIn('id', $borrowingIdsArray)
                ->get();
        } else {
            $borrowings = Borrowing::with(['employee', 'loanDetails.inventory'])
                ->get();
        }

        return Excel::download(new BorrowingExport($borrowings), 'borrowing.xlsx');
    }

    public function proof(string $id)
    {
        $borrowing = Borrowing::with('employee', 'loanDetails.inventory')->findOrFail($id);

        $pdf = Pdf::loadView('pages.admin.borrowing.proof', compact('borrowing'));

        return $pdf->stream('bukti_peminjaman.pdf');
    }
}
