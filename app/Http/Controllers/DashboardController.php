<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Employee;
use App\Models\Inventory;
use App\Models\LoanDetail;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->level->name === 'Peminjam') {
            $employee = Employee::where('id_user', $user->id)->first();
            $borrowings = $employee ? Borrowing::where('id_employee', $employee->id)->get() : collect();
        } else {
            $borrowings = Borrowing::all();
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
            'totalBorrowings'   => $borrowings->count(),
            'totalBorrowed'     => $borrowings->where('loan_status', 'borrow')->count(),
            'totalReturned'     => $borrowings->where('loan_status', 'return')->count(),
            'totalUsers'        => Employee::count(),
            'mostBorrowedInventories' => $inventoryBorrowedCounts
        ]);
    }
}
