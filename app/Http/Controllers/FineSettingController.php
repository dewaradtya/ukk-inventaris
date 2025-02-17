<?php

namespace App\Http\Controllers;

use App\Models\FineSetting;
use Illuminate\Http\Request;

class FineSettingController extends Controller
{
    public function index()
    {
        $fineSetting = FineSetting::firstOrCreate([]);
        return view('pages.admin.fine.settings', compact('fineSetting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'late_fee' => 'required|numeric|min:1',
            'lost_fee' => 'required|numeric|min:1',
        ]);

        $fineSetting = FineSetting::first();
        $fineSetting->update($request->only(['late_fee', 'lost_fee']));

        return redirect()->route('fine.settings')->with('success', 'Pengaturan denda berhasil diperbarui.');
    }
}
