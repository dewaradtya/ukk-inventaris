<?php

namespace App\Http\Controllers;

use App\Http\Requests\FinePaymentRequest;
use App\Models\Fine;
use App\Services\FineService;
use Illuminate\Http\Request;

class FineController extends Controller
{
    protected FineService $fineService;

    public function __construct(FineService $fineService)
    {
        $this->fineService = $fineService;
    }

    public function index(Request $request)
    {
        $totals = $this->fineService->calculateTotals();

        return view('pages.admin.fine.index', [
            'fines' => $this->fineService->getFines(auth()->user()),
            'totalFines' => $totals['totalFines'],
            'totalPaid' => $totals['totalPaid'],
            'totalUnpaid' => $totals['totalUnpaid'],
            'totalEmployees' => $totals['totalEmployees'],
        ]);
    }

    public function payFine(FinePaymentRequest $request, $id)
    {
        $fine = Fine::findOrFail($id);

        try {
            $this->fineService->processFinePayment($fine, $request->validated());
            return redirect()->route('fine.index')->with('success', 'Denda berhasil dibayar.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        $fine = Fine::findOrFail($id);
        $this->fineService->deleteFine($fine);

        return redirect()->route('fine.index')->with('success', 'Data berhasil dihapus!');
    }
}
