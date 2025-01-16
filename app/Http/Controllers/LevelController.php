<?php

namespace App\Http\Controllers;

use App\Models\Level;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $levels = Level::all();
    
        return view('pages.level.index', [
            'levels' => $levels,
        ]);
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.level.create');
    }

    /**
     * Menyimpan officer baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([            
            'name' => ['required', 'max:50'],
        ]);

        Level::create([
            'name' => $request->name,
        ]);

        return redirect()->route('level.index')->with('success', 'officer berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $level = Level::findOrFail($id);
        return view('pages.level.edit', [
            'level' => $level,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([            
            'name' => ['required', 'max:50'],
        ]);

        $officer = Level::findOrFail($id);

        $officer->update([
            'name' => $request->name,
        ]);

        return redirect()->route('level.index')->with('success', 'officer berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $officer = Level::findOrFail($id);
        $officer->delete();

        return redirect()->route('level.index')->with('success', 'Data berhasil dihapus!');
    }
}
