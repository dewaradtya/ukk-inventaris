<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Employee;
use App\Models\Fine;
use Illuminate\Http\Request;

class FineController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

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

        $fines = $query->paginate(10);
        $totalFines = $query->sum('fine_amount');
        $totalPaid = $query->sum('paid_amount');
        $totalUnpaid = $query->get()->sum(function ($fine) {
            return $fine->remaining_amount;
        });
        $totalEmployees = Employee::count();

        return view('pages.admin.fine.index', compact('fines', 'totalFines', 'totalPaid', 'totalUnpaid', 'totalEmployees'));
    }

    public function payFine(Request $request, $id)
    {
        $fine = Fine::findOrFail($id);

        $request->validate([
            'payment_amount' => 'required|numeric|min:1',
            'payment_proof' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $paymentAmount = $request->payment_amount;
        $remainingAmount = $fine->fine_amount - $fine->paid_amount;

        if ($paymentAmount > $remainingAmount) {
            return redirect()->back()->with('error', 'Jumlah pembayaran melebihi sisa denda.');
        }

        if ($request->hasFile('payment_proof')) {
            if ($fine->payment_proof) {
                \Storage::disk('public')->delete($fine->payment_proof);
            }

            $proofPath = $request->file('payment_proof')->store('img/payment_proofs', 'public');
            $fine->payment_proof = $proofPath;
        }

        $fine->paid_amount += $paymentAmount;

        $fine->status = $fine->paid_amount >= $fine->fine_amount ? 'paid' : 'partial';
        $fine->save();

        return redirect()->route('fine.index')->with('success', 'Denda berhasil dibayar.');
    }

    public function destroy(string $id)
    {
        $fines = Fine::findOrFail($id);
        $fines->delete();

        return redirect()->route('fine.index')->with('success', 'Data berhasil dihapus!');
    }
}
