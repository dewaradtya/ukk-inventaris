<?php

namespace App\Http\Controllers;

use App\Exports\ReturnExport;
use App\Models\Borrowing;
use App\Models\Employee;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportBorrowingController extends Controller
{
    public function index(Request $request)
    {
        $borrowings = Borrowing::with(['employee', 'loanDetails.inventory'])->get();
        $employees = Employee::all();

        return view('pages/admin/report/index', compact('borrowings', 'employees'));
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

        return Excel::download(new ReturnExport($borrowings), 'Seluruh-Peminjaman.xlsx');
    }
}
