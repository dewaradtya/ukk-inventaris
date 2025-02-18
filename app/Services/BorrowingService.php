<?php

namespace App\Services;

use App\Models\Borrowing;
use App\Models\Employee;
use App\Models\Inventory;
use App\Models\LoanDetail;
use App\Models\Fine;
use App\Models\FineSetting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BorrowingService
{
    public function getBorrowings($search)
    {
        $query = Borrowing::where('loan_status', 'borrow');

        if (Auth::user()->level->name === 'Peminjam') {
            $employee = Employee::where('id_user', Auth::id())->first();
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

        return $query->with('employee', 'loanDetails.inventory')->paginate(10);
    }

    public function storeBorrowing($data)
    {
        DB::beginTransaction();

        try {
            $idEmployee = $this->getEmployeeId($data);

            $activeBorrowings = Borrowing::where('id_employee', $idEmployee)
                ->where('loan_status', 'borrow')
                ->count();

            if ($activeBorrowings >= 3) {
                throw new \Exception('Anda sudah memiliki 3 peminjaman aktif. Kembalikan salah satu sebelum meminjam lagi.');
            }

            $returnDate = date('Y-m-d', strtotime($data['borrow_date'] . ' +7 days'));

            $borrowing = Borrowing::create([
                'borrow_date' => $data['borrow_date'],
                'return_date' => $returnDate,
                'loan_status' => 'borrow',
                'id_employee' => $idEmployee,
            ]);

            foreach ($data['id_inventories'] as $key => $inventoryId) {
                $inventory = Inventory::find($inventoryId);
                $requestedAmount = $data['amount'][$key];

                if ($inventory->amount < $requestedAmount) {
                    throw new \Exception("Stok untuk {$inventory->name} tidak mencukupi. Tersedia: {$inventory->amount}");
                }

                LoanDetail::create([
                    'id_borrowing' => $borrowing->id,
                    'id_inventories' => $inventoryId,
                    'amount' => $requestedAmount,
                ]);

                $inventory->decrement('amount', $requestedAmount);
            }

            DB::commit();
            return $borrowing;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updateBorrowing($id, $data)
    {
        DB::beginTransaction();

        try {
            $borrowing = Borrowing::findOrFail($id);
            $idEmployee = $this->getEmployeeId($data);

            foreach ($borrowing->loanDetails as $loanDetail) {
                $inventory = Inventory::find($loanDetail->id_inventories);
                if ($inventory) {
                    $inventory->increment('amount', $loanDetail->amount);
                }
            }

            $borrowing->loanDetails()->delete();

            $updateData = [
                'borrow_date' => $data['borrow_date'],
                'id_employee' => $idEmployee,
            ];

            if (Auth::user()->level->name === 'Admin') {
                $updateData['return_date'] = $data['return_date'] ?? null;
            } else {
                $updateData['return_date'] = date('Y-m-d', strtotime($data['borrow_date'] . ' +7 days'));
            }

            $borrowing->update($updateData);

            foreach ($data['id_inventories'] as $index => $inventoryId) {
                $amount = $data['amount'][$index];
                $inventory = Inventory::find($inventoryId);

                if ($inventory && $inventory->amount >= $amount) {
                    $inventory->decrement('amount', $amount);
                } else {
                    throw new \Exception('Stok inventaris tidak mencukupi.');
                }

                $borrowing->loanDetails()->create([
                    'id_inventories' => $inventoryId,
                    'amount' => $amount,
                ]);
            }

            DB::commit();
            return $borrowing;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function deleteBorrowing($id)
    {
        $borrowing = Borrowing::findOrFail($id);

        foreach ($borrowing->loanDetails as $loanDetail) {
            $inventory = Inventory::find($loanDetail->id_inventories);
            if ($inventory) {
                $inventory->increment('amount', $loanDetail->amount);
            }
        }

        $borrowing->loanDetails()->delete();
        $borrowing->delete();
    }

    public function updateBorrowingStatus($id, $status)
    {
        $borrowing = Borrowing::findOrFail($id);

        if ($status === 'return' && $borrowing->loan_status !== 'return') {
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

        $borrowing->loan_status = $status;
        $borrowing->save();
    }

    /**
     * Menghitung denda.
     */
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

    /**
     * Mendapatkan ID employee berdasarkan role user.
     */
    private function getEmployeeId($data)
    {
        if (Auth::user()->level->name === 'Peminjam') {
            $employee = Employee::where('id_user', Auth::id())->first();
            if (!$employee) {
                throw new \Exception('Mohon isi data pegawai terlebih dahulu.');
            }
            return $employee->id;
        } else {
            return $data['id_employee'];
        }
    }
}