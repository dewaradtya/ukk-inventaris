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
        $inventories = Inventory::all();
        $types = Type::all();
        $rooms = Room::all();
        $officers = Officer::all();

        return view('pages.inventory.index', [
            'inventories' => $inventories,
            'types' => $types,
            'rooms' => $rooms,
            'officers' => $officers,
        ]);
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
        // Validasi input
        $request->validate([
            'borrow_date' => 'required|date',
            'return_date' => 'nullable|date|after_or_equal:borrow_date',
            'loan_status' => 'required|string',
            'id_employee' => 'required|exists:employees,id',
        ]);

        Inventory::create([
            'borrow_date' => $request->borrow_date,
            'return_date' => $request->return_date,
            'loan_status' => $request->loan_status,
            'id_employee' => $request->id_employee,
        ]);

        return redirect()->route('inventory.index')->with('success', 'inventory berhasil ditambahkan');
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
            'borrow_date' => 'required|date',
            'return_date' => 'nullable|date|after_or_equal:borrow_date',
            'loan_status' => 'required|string',
            'id_employee' => 'required|exists:employees,id',
        ]);

        $inventory = Inventory::findOrFail($id);

        $inventory->update([
            'borrow_date' => $request->borrow_date,
            'return_date' => $request->return_date,
            'loan_status' => $request->loan_status,
            'id_employee' => $request->id_employee,
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
