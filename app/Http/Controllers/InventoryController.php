<?php

namespace App\Http\Controllers;

use App\Exports\InventoryExport;
use App\Http\Requests\InventoryStoreRequest;
use App\Http\Requests\InventoryUpdateRequest;
use App\Models\Inventory;
use App\Models\User;
use App\Models\Room;
use App\Models\Type;
use App\Services\InventoryService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class InventoryController extends Controller
{
    protected $inventoryService;

    public function __construct(InventoryService $inventoryService)
    {
        $this->inventoryService = $inventoryService;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['search', 'condition', 'type', 'room']);
        $inventories = $this->inventoryService->getInventories($filters);

        $types = Type::all();
        $rooms = Room::all();
        $users = User::all();

        return view('pages.admin.inventory.index', compact('inventories', 'types', 'rooms', 'users'));
    }

    public function create()
    {
        $types = Type::all();
        $rooms = Room::all();
        $users = User::all();
        return view('pages.admin.inventory.create', compact('types', 'rooms', 'users'));
    }

    public function store(InventoryStoreRequest $request)
    {
        try {
            $this->inventoryService->storeInventory($request->validated());
            return redirect()->route('inventory.index')->with('success', 'Inventory berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function edit(string $id)
    {
        $inventory = Inventory::findOrFail($id);
        $types = Type::all();
        $rooms = Room::all();
        $users = User::all();
        return view('pages.admin.inventory.edit', compact('inventory', 'types', 'rooms', 'users'));
    }

    public function update(InventoryUpdateRequest $request, string $id)
    {
        try {
            $this->inventoryService->updateInventory($id, $request->validated());
            return redirect()->route('inventory.index')->with('success', 'Inventory berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        try {
            $this->inventoryService->deleteInventory($id);
            return redirect()->route('inventory.index')->with('success', 'Data berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function export(Request $request)
    {
        $inventoryIds = $request->query('ids');

        if ($inventoryIds) {
            $inventoryIdsArray = explode(',', $inventoryIds);
            $inventories = Inventory::with(['type', 'room', 'user'])
                ->whereIn('id', $inventoryIdsArray)
                ->get(['name', 'code', 'condition', 'amount', 'register_date', 'id_type', 'id_room', 'id_user']);
        } else {
            $inventories = Inventory::with(['type', 'room', 'user'])
                ->get(['name', 'code', 'condition', 'amount', 'register_date', 'id_type', 'id_room', 'id_user']);
        }

        return Excel::download(new InventoryExport($inventories), 'inventory.xlsx');
    }
}