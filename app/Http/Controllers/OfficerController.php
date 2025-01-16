<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\Officer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class OfficerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $officers = Officer::all();
        $levels = Level::all();
    
        return view('pages.officer.index', [
            'officers' => $officers,
            'levels' => $levels,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $levels = Level::all(); // Perbaikan case sensitivity
        return view('pages.officer.create', [
            'levels' => $levels,
        ]);
    }

    /**
     * Menyimpan officer baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => ['required', 'max:50'],
            'password' => ['required', 'min:5', 'max:20'],
            'name' => ['required', 'max:50'],
            'id_level' => 'required|exists:levels,id',
        ]);

        Officer::create([
            'username' => $request->username,            
            'password' => Hash::make($request->password),
            'name' => $request->name,
            'id_level' => $request->id_level,
        ]);

        return redirect()->route('officer.index')->with('success', 'Officer berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $officer = Officer::findOrFail($id);
        $levels = Level::all(); // Perbaikan case sensitivity
        return view('pages.officer.edit', [
            'officer' => $officer,
            'levels' => $levels,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $officer = Officer::findOrFail($id);

        // Validasi input
        $request->validate([
            'username' => ['required', 'max:50'],
            'password' => ['nullable', 'min:5', 'max:20'],
            'name' => ['required', 'max:50'],
            'id_level' => 'required|exists:levels,id',
        ]);

        $officer->update([
            'username' => $request->username,            
            'password' => $request->password ? Hash::make($request->password) : $officer->password, // Hash password jika diubah
            'name' => $request->name,
            'id_level' => $request->id_level,
        ]);

        return redirect()->route('officer.index')->with('success', 'Officer berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $officer = Officer::findOrFail($id);
        $officer->delete();

        return redirect()->route('officer.index')->with('success', 'Data berhasil dihapus!');
    }
}
