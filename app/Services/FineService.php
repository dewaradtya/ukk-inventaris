<?php

namespace App\Services;

use App\Models\Fine;
use App\Models\Employee;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;

class FineService
{
    public function getFines($user): LengthAwarePaginator
    {
        $query = Fine::with('borrowing.employee');

        if ($user->level->name === 'Peminjam') {
            $employee = Employee::where('id_user', $user->id)->first();
            if ($employee) {
                $query->whereHas('borrowing', function ($q) use ($employee) {
                    $q->where('id_employee', $employee->id);
                });
            } else {
                $query->where('id', null);
            }
        }

        return $query->paginate(10);
    }

    public function calculateTotals()
    {
        $query = Fine::query();

        return [
            'totalFines' => $query->sum('fine_amount'),
            'totalPaid' => $query->sum('paid_amount'),
            'totalUnpaid' => $query->get()->sum(fn($fine) => $fine->remaining_amount),
            'totalEmployees' => Employee::count(),
        ];
    }

    public function processFinePayment(Fine $fine, array $data): void
    {
        $paymentAmount = $data['payment_amount'];
        $remainingAmount = $fine->fine_amount - $fine->paid_amount;

        if ($paymentAmount > $remainingAmount) {
            throw new \Exception('Jumlah pembayaran melebihi sisa denda.');
        }

        if (isset($data['payment_proof'])) {
            if ($fine->payment_proof) {
                Storage::disk('public')->delete($fine->payment_proof);
            }

            $proofPath = $data['payment_proof']->store('img/payment_proofs', 'public');
            $fine->payment_proof = $proofPath;
        }

        $fine->paid_amount += $paymentAmount;
        $fine->status = $fine->paid_amount >= $fine->fine_amount ? 'paid' : 'partial';
        $fine->save();
    }

    public function deleteFine(Fine $fine): void
    {
        $fine->delete();
    }
}
