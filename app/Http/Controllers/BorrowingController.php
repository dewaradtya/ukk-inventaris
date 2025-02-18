<?php

namespace App\Http\Controllers;

use App\Exports\BorrowingExport;
use App\Http\Requests\BorrowingStoreRequest;
use App\Http\Requests\BorrowingUpdateRequest;
use App\Models\Borrowing;
use App\Models\Employee;
use App\Models\Inventory;
use App\Services\BorrowingService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class BorrowingController extends Controller
{
    protected $borrowingService;

    public function __construct(BorrowingService $borrowingService)
    {
        $this->borrowingService = $borrowingService;
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $borrowings = $this->borrowingService->getBorrowings($search);

        return view('pages.admin.borrowing.index', [
            'borrowings'  => $borrowings,
            'employees'   => Employee::all(),
            'inventories' => Inventory::all(),
        ]);
    }

    public function create()
    {
        return view('pages.admin.borrowing.create', [
            'employees' => Employee::all(),
        ]);
    }

    public function store(BorrowingStoreRequest $request)
    {
        try {
            $this->borrowingService->storeBorrowing($request->validated());
            return redirect()->route('borrowing.index')->with('success', 'Borrowing dan Loan Detail berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function edit(string $id)
    {
        $borrowing = Borrowing::findOrFail($id);
        return view('pages.admin.borrowing.edit', [
            'borrowing' => $borrowing,
            'employees' => Employee::all(),
            'inventories' => Inventory::all(),
        ]);
    }

    public function update(BorrowingUpdateRequest $request, string $id)
    {
        try {
            $this->borrowingService->updateBorrowing($id, $request->validated());
            return redirect()->route('borrowing.index')->with('success', 'Borrowing berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        try {
            $this->borrowingService->deleteBorrowing($id);
            return redirect()->route('borrowing.index')->with('success', 'Data berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $this->borrowingService->updateBorrowingStatus($id, $request->loan_status);
            return redirect()->route('borrowing.index')->with('success', 'Status peminjaman berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
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

        return Excel::download(new BorrowingExport($borrowings), 'Peminjaman.xlsx');
    }

    public function proof(string $id)
    {
        $borrowing = Borrowing::with('employee', 'loanDetails.inventory')->findOrFail($id);
        $pdf = Pdf::loadView('pages.admin.borrowing.proof', compact('borrowing'));
        return $pdf->stream('bukti_peminjaman.pdf');
    }
}