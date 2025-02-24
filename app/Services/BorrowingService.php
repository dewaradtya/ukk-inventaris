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
        $query = Borrowing::whereIn('loan_status', ['pending', 'borrow', 'rejected']);

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

            $userLevel = Auth::user()->level->name;
            $loanStatus = ($userLevel === 'Admin' || $userLevel === 'Operator') ? 'borrow' : 'pending';

            $borrowing = Borrowing::create([
                'borrow_date' => $data['borrow_date'],
                'return_date' => $returnDate,
                'loan_status' => $loanStatus,
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
                    'condition_borrowed' => $inventory->condition,
                ]);

                if ($loanStatus === 'borrow') {
                    $inventory->decrement('amount', $requestedAmount);
                }
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

                if (!$inventory) {
                    throw new \Exception('Inventaris tidak ditemukan.');
                }

                if ($inventory->amount < $amount) {
                    throw new \Exception('Stok inventaris tidak mencukupi.');
                }

                $conditionBorrowed = $data['condition_borrowed'][$index] ?? $inventory->condition;

                $inventory->decrement('amount', $amount);

                $borrowing->loanDetails()->create([
                    'id_inventories' => $inventoryId,
                    'amount' => $amount,
                    'condition_borrowed' => $conditionBorrowed,
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
        $borrowing = Borrowing::where('id', $id)
            ->whereIn('loan_status', ['pending', 'borrow', 'rejected'])
            ->firstOrFail();

        foreach ($borrowing->loanDetails as $loanDetail) {
            $inventory = Inventory::find($loanDetail->id_inventories);
            if ($inventory) {
                $inventory->increment('amount', $loanDetail->amount);
            }
        }

        $borrowing->loanDetails()->delete();
        $borrowing->delete();
    }

    public function updateBorrowingStatus($id, $status, $conditionReturned = [])
    {
        $borrowing = Borrowing::where('id', $id)
            ->where('loan_status', 'borrow')
            ->firstOrFail();

        if ($status === 'return' && $borrowing->loan_status !== 'return') {
            DB::transaction(function () use ($borrowing, $conditionReturned) {
                $fineAmount = 0;
                $fineSetting = FineSetting::first();

                $isLost = false;
                $isDamaged = false;
                $isLostFineApplied = false;

                foreach ($borrowing->loanDetails as $loanDetail) {
                    $inventory = Inventory::find($loanDetail->id_inventories);
                    $condition = $conditionReturned[$loanDetail->id] ?? 'baik';

                    if ($inventory) {
                        if ($condition === 'baik') {
                            $inventory->increment('amount', $loanDetail->amount);
                        } elseif (in_array($condition, ['rusak', 'hilang'])) {
                            $existingInventory = Inventory::where('name', $inventory->name)
                                ->where('condition', $condition)
                                ->where('id_type', $inventory->id_type)
                                ->where('id_room', $inventory->id_room)
                                ->first();

                            if ($existingInventory) {
                                $existingInventory->increment('amount', $loanDetail->amount);
                            } else {
                                $newCode = $inventory->code . '-' . strtoupper(substr($condition, 0, 1));
                                $counter = 1;
                                while (Inventory::where('code', $newCode)->exists()) {
                                    $newCode = $inventory->code . '-' . strtoupper(substr($condition, 0, 1)) . '-' . $counter;
                                    $counter++;
                                }

                                Inventory::create([
                                    'name' => $inventory->name,
                                    'condition' => $condition,
                                    'amount' => $loanDetail->amount,
                                    'register_date' => now(),
                                    'code' => $newCode,
                                    'id_type' => $inventory->id_type,
                                    'id_room' => $inventory->id_room,
                                    'id_user' => $inventory->id_user,
                                ]);
                            }

                            if ($condition === 'hilang' && !$isLostFineApplied) {
                                $isLost = true;
                                $fineAmount += $loanDetail->amount * optional($fineSetting)->lost_fee;
                                $isLostFineApplied = true;
                            } elseif ($condition === 'rusak') {
                                $isDamaged = true;
                                $fineAmount += $loanDetail->amount * optional($fineSetting)->damage_fee;
                            }
                        }
                    }

                    $loanDetail->condition_returned = $condition;
                    $loanDetail->save();
                }

                $borrowing->actual_return_date = now();
                $borrowing->loan_status = 'return';
                $borrowing->is_lost = $isLost;
                $borrowing->is_damage = $isDamaged;
                $borrowing->save();

                $fineAmount += $this->calculateFine($borrowing);

                if ($fineAmount > 0) {
                    Fine::create([
                        'borrowing_id' => $borrowing->id,
                        'fine_amount' => $fineAmount,
                        'status' => 'unpaid',
                    ]);
                }
            });
        }

        return $borrowing;
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
            $fineAmount += $lateDays * optional($fineSetting)->late_fee;
        }

        return $fineAmount;
    }

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

    public function confirmBorrowing($id, $status)
    {
        DB::beginTransaction();

        try {
            $borrowing = Borrowing::findOrFail($id);

            if ($status === 'approved') {
                $borrowing->loan_status = 'borrow';

                foreach ($borrowing->loanDetails as $loanDetail) {
                    $inventory = Inventory::find($loanDetail->id_inventories);
                    $inventory->decrement('amount', $loanDetail->amount);
                }
            } else {
                $borrowing->loan_status = 'rejected';
            }

            $borrowing->save();

            DB::commit();
            return ['success' => true, 'message' => 'Status peminjaman berhasil diperbarui.'];
        } catch (\Exception $e) {
            DB::rollBack();
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
