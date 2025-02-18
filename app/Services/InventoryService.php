<?php

namespace App\Services;

use App\Models\Inventory;
use App\Models\LoanDetail;
use Illuminate\Support\Facades\Auth;

class InventoryService
{
    public function getInventories($filters)
    {
        $query = Inventory::with(['type', 'room', 'user'])->latest();

        if (isset($filters['search']) && $filters['search'] !== '') {
            $search = $filters['search'];
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

        if (isset($filters['condition'])) {
            $query->where('condition', $filters['condition']);
        }

        if (isset($filters['type'])) {
            $query->where('id_type', $filters['type']);
        }

        if (isset($filters['room'])) {
            $query->where('id_room', $filters['room']);
        }

        return $query->paginate(10)->appends($filters);
    }

    public function storeInventory($data)
    {
        $data['id_user'] = Auth::id();
        return Inventory::create($data);
    }

    public function updateInventory($id, $data)
    {
        $inventory = Inventory::findOrFail($id);
        $data['id_user'] = Auth::id();
        $inventory->update($data);
        return $inventory;
    }

    public function deleteInventory($id)
    {
        $inventory = Inventory::findOrFail($id);
        $isUsed = LoanDetail::where('id_inventories', $id)->exists();
        if ($isUsed) {
            throw new \Exception('Data tidak dapat dihapus karena sedang digunakan di Peminjaman!');
        }
        $inventory->delete();
    }
}