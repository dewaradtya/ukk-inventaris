<?php

namespace App\Services;

use App\Models\Borrowing;
use App\Models\Employee;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Pagination\LengthAwarePaginator;

class ReturnService
{
    public function getReturns($user): LengthAwarePaginator
    {
        if ($user->level->name === 'Peminjam') {
            $employee = Employee::where('id_user', $user->id)->first();

            return $employee
                ? Borrowing::where('id_employee', $employee->id)
                    ->where('loan_status', 'return')
                    ->with('employee')
                    ->paginate(10)
                : Borrowing::where('id', null)->paginate(10);
        }

        return Borrowing::where('loan_status', 'return')
            ->with('employee')
            ->paginate(10);
    }

    public function updateLoanStatus(Borrowing $borrowing, string $loanStatus): void
    {
        $borrowing->update(['loan_status' => $loanStatus]);
    }

    public function generateProof(Borrowing $borrowing)
    {
        return Pdf::loadView('pages.admin.return.proof', compact('borrowing'))
            ->stream('bukti_pengembalian.pdf');
    }
}
