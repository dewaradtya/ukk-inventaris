<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Employee;
use App\Models\Inventory;
use App\Models\LoanDetail;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $inventorys = Inventory::all();

        if ($user->level->name === 'Peminjam') {
            $employee = Employee::where('id_user', $user->id)->first();
            $borrowings = $employee ? Borrowing::where('id_employee', $employee->id)->get() : collect();
        } else {
            $borrowings = Borrowing::all();
        }

        $monthlyBorrowings = Borrowing::selectRaw('YEAR(borrow_date) as year, MONTH(borrow_date) as month, COUNT(*) as total')
            ->groupByRaw('YEAR(borrow_date), MONTH(borrow_date)')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc');

        $monthlyReturns = Borrowing::selectRaw('YEAR(actual_return_date) as year, MONTH(actual_return_date) as month, COUNT(*) as total')
            ->whereNotNull('actual_return_date')
            ->where('borrowings.loan_status', 'return')
            ->groupByRaw('YEAR(actual_return_date), MONTH(actual_return_date)')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc');

        if ($user->level->name === 'Peminjam') {
            $monthlyBorrowings->where('id_employee', $employee->id);
            $monthlyReturns->where('id_employee', $employee->id);
        }

        $monthlyBorrowings = $monthlyBorrowings->get();
        $monthlyReturns = $monthlyReturns->get();

        $labels = [];
        $borrowedData = [];
        $returnedData = [];
        $borrowers = [];

        foreach ($monthlyBorrowings as $borrowing) {
            $labels[] = \Carbon\Carbon::createFromDate($borrowing->year, $borrowing->month, 1)->format('M Y');
            $borrowedData[] = $borrowing->total;

            $borrowers[] = Borrowing::whereYear('borrow_date', $borrowing->year)
                ->whereMonth('borrow_date', $borrowing->month)
                ->with('employee')
                ->get();
        }

        $latestBorrowers = Borrowing::with('employee')
            ->orderBy('borrow_date', 'desc')
            ->take(5)
            ->get();

        foreach ($monthlyReturns as $return) {
            $returnedData[] = $return->total;
        }

        for ($i = 0; $i < count($labels); $i++) {
            if (!isset($returnedData[$i])) {
                $returnedData[$i] = 0;
            }
        }

        $inventoryBorrowedCounts = LoanDetail::select('id_inventories')
            ->join('borrowings', 'loan_details.id_borrowing', '=', 'borrowings.id')
            ->where('borrowings.loan_status', 'borrow')
            ->selectRaw('SUM(loan_details.amount) as total_borrowed')
            ->groupBy('id_inventories')
            ->orderByDesc('total_borrowed')
            ->with('inventory')
            ->get();

        $totalBorrowedItems = $inventoryBorrowedCounts->sum('total_borrowed');

        $inventoryBorrowedCounts->transform(function ($item) use ($totalBorrowedItems) {
            $item->borrow_percentage = $totalBorrowedItems > 0
                ? round(($item->total_borrowed / $totalBorrowedItems) * 100, 2)
                : 0;
            return $item;
        });

        return view('dashboard', [
            'totalInventorys'   => $inventorys->count(),
            'totalBorrowed'     => $borrowings->where('loan_status', 'borrow')->count(),
            'totalReturned'     => $borrowings->where('loan_status', 'return')->count(),
            'totalUsers'        => Employee::count(),
            'borrowers'         => $borrowers,
            'latestBorrowers'   => $latestBorrowers,
            'mostBorrowedInventories' => $inventoryBorrowedCounts,
            'monthlyLabels'     => $labels,
            'monthlyBorrowedData'  => $borrowedData,
            'monthlyReturnedData' => $returnedData,
        ]);
    }
}
