<?php

namespace App\Http\Controllers;

use App\Exports\InventoryExport;
use App\Models\Inventory;
use App\Models\user;
use App\Models\Room;
use App\Models\Type;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Inventory::with(['type', 'room', 'user']);

        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->orWhereHas('type', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('room', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('condition')) {
            $query->where('condition', $request->condition);
        }

        if ($request->filled('type')) {
            $query->where('id_type', $request->type);
        }

        if ($request->filled('room')) {
            $query->where('id_room', $request->room);
        }

        $inventories = $query->paginate(10)->appends($request->query());
        $types = Type::all();
        $rooms = Room::all();
        $users = User::all();

        return view('pages.admin.inventory.index', compact('inventories', 'types', 'rooms', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types = Type::all();
        $rooms = Room::all();
        $users = User::all();
        return view('pages.admin.inventory.create', [
            'types' => $types,
            'rooms' => $rooms,
            'users' => $users,
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
        ]);

        $userId = auth()->user()->id;

        Inventory::create([
            'name' => $request->name,
            'condition' => $request->condition,
            'amount' => $request->amount,
            'register_date' => $request->register_date,
            'code' => $request->code,
            'id_type' => $request->id_type,
            'id_room' => $request->id_room,
            'id_user' => $userId,
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
        $users = User::all();
        return view('pages.admin.inventory.edit', [
            'inventory' => $inventory,
            'types' => $types,
            'rooms' => $rooms,
            'users' => $users,
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
        ]);

        $inventory = Inventory::findOrFail($id);

        $userId = auth()->user()->id;

        $inventory->update([
            'name' => $request->name,
            'condition' => $request->condition,
            'amount' => $request->amount,
            'register_date' => $request->register_date,
            'code' => $request->code,
            'id_type' => $request->id_type,
            'id_room' => $request->id_room,
            'id_user' => $userId,
        ]);

        return redirect()->route('inventory.index')->with('success', 'Inventory berhasil diperbarui');
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

    public function export(Request $request)
    {
        $inventoryIds = $request->query('ids');

        if ($inventoryIds) {
            $inventoryIdsArray = explode(',', $inventoryIds);
            $inventorys = Inventory::with(['type', 'room', 'user'])
                ->whereIn('id', $inventoryIdsArray)
                ->get(['name', 'code', 'condition', 'amount', 'register_date', 'id_type', 'id_room', 'id_user']);
        } else {
            $inventorys = Inventory::with(['type', 'room', 'user'])
                ->get(['name', 'code', 'condition', 'amount', 'register_date', 'id_type', 'id_room', 'id_user']);
        }

        return Excel::download(new InventoryExport($inventorys), 'inventory.xlsx');
    }
}
