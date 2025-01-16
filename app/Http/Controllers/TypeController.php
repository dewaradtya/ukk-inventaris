<?php

namespace App\Http\Controllers;

use App\Models\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $types = Type::all();
        return view('pages.type.index', [
            'types' => $types
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.type.create');
    }

    /**
     * Menyimpan type baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required|unique:types',
            'information' => 'required'
        ]);

        $types = Type::create([
            'name' => $request->name,
            'code' => $request->code,
            'information' => $request->information
        ]);

        return redirect()->route('type.index')->with('success', 'type berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $type = Type::findOrFail($id);
        return view('pages.type.edit', [
            'type' => $type,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required|unique:types,code,' . $id,
            'information' => 'required',
        ]);

        $type = Type::findOrFail($id);

        $type->name = $request->name;
        $type->code = $request->code;
        $type->information = $request->information;
        $type->save();

        return redirect()->route('type.index')->with('success', 'Type berhasil diperbarui');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $types = Type::findOrFail($id);
        $types->delete();

        return redirect()->route('type.index')->with('success', 'Data berhasil dihapus!');
    }
}
