<?php

namespace App\Http\Controllers;

use App\Exports\BorrowingExport;
use App\Exports\ReturnExport;
use App\Http\Requests\ReturnUpdateRequest;
use App\Models\Borrowing;
use App\Models\Employee;
use App\Models\Inventory;
use App\Services\ReturnService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReturnController extends Controller
{
    protected $returnService;

    public function __construct(ReturnService $returnService)
    {
        $this->returnService = $returnService;
    }

    public function index()
    {
        return view('pages.admin.return.index', [
            'returns'  => $this->returnService->getReturns(auth()->user()),
            'employees' => Employee::all(),
            'inventories' => Inventory::all(),
        ]);
    }

    public function edit(string $id)
    {
        return view('pages.admin.return.edit', [
            'return' => Borrowing::findOrFail($id),
            'employees' => Employee::all(),
            'inventories' => Inventory::all(),
        ]);
    }

    public function update(ReturnUpdateRequest $request, $id)
    {
        $borrowing = Borrowing::findOrFail($id);
        $this->returnService->updateLoanStatus($borrowing, $request->loan_status);

        return redirect()->route('return.index')->with('success', 'Status pengembalian berhasil diperbarui.');
    }

    public function proof(string $id)
    {
        return $this->returnService->generateProof(Borrowing::with('employee', 'loanDetails.inventory')->findOrFail($id));
    }

    public function export(Request $request)
    {
        $returnIds = $request->query('ids');

        if ($returnIds) {
            $returnIdsArray = explode(',', $returnIds);
            $returns = Borrowing::with(['employee', 'loanDetails.inventory'])
                ->whereIn('id', $returnIdsArray)
                ->get();
        } else {
            $returns = Borrowing::with(['employee', 'loanDetails.inventory'])
                ->get();
        }

        return Excel::download(new ReturnExport($returns), 'Pengembalian.xlsx');
    }
}
