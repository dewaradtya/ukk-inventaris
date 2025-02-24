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

    public function proof(string $id)
    {
        $borrowing = Borrowing::with([
            'employee',
            'loanDetails.inventory',
            'loanDetails.fine',
            'fine'
        ])
            ->where('id', $id)
            ->where('loan_status', 'return')
            ->firstOrFail();

        return $this->returnService->generateProof($borrowing);
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
