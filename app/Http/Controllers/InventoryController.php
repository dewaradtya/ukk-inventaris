<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Officer;
use App\Models\Room;
use App\Models\Type;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inventories = Inventory::with(['type', 'room', 'officer'])->get();
        $types = Type::all();
        $rooms = Room::all();
        $officers = Officer::all();

        return view('pages.inventory.index', compact('inventories', 'types', 'rooms', 'officers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types = Type::all();
        $rooms = Room::all();
        $officers = Officer::all();
        return view('pages.inventory.create', [
            'types' => $types,
            'rooms' => $rooms,
            'officers' => $officers,
        ]);
    }

    /**
     * Menyimpan inventory baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'condition' => 'required|string',
            'amount' => 'required|integer|min:1',
            'register_date' => 'required|date',
            'code' => 'required|string|unique:inventories,code',
            'id_type' => 'required|exists:types,id',
            'id_room' => 'required|exists:rooms,id',
            'id_officer' => 'required|exists:officers,id',
        ]);

        Inventory::create([
            'name' => $request->name,
            'condition' => $request->condition,
            'amount' => $request->amount,
            'register_date' => $request->register_date,
            'code' => $request->code,
            'id_type' => $request->id_type,
            'id_room' => $request->id_room,
            'id_officer' => $request->id_officer,
        ]);

        return redirect()->route('inventory.index')->with('success', 'Inventory berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $inventory = Inventory::findOrFail($id);
        $types = Type::all();
        $rooms = Room::all();
        $officers = Officer::all();
        return view('pages.inventory.edit', [
            'inventory' => $inventory,
            'types' => $types,
            'rooms' => $rooms,
            'officers' => $officers,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'condition' => 'required|string',
            'amount' => 'required|integer|min:1',
            'register_date' => 'required|date',
            'code' => 'required|unique:rooms,code,' . $id,
            'id_type' => 'required|exists:types,id',
            'id_room' => 'required|exists:rooms,id',
            'id_officer' => 'required|exists:officers,id',
        ]);

        $inventory = Inventory::findOrFail($id);

        $inventory->update([
            'name' => $request->name,
            'condition' => $request->condition,
            'amount' => $request->amount,
            'register_date' => $request->register_date,
            'code' => $request->code,
            'id_type' => $request->id_type,
            'id_room' => $request->id_room,
            'id_officer' => $request->id_officer,
        ]);

        return redirect()->route('inventory.index')->with('success', 'inventory berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $inventory = Inventory::findOrFail($id);
        $inventory->delete();

        return redirect()->route('inventory.index')->with('success', 'Data berhasil dihapus!');
    }
}
