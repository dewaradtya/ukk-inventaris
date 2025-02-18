<?php

namespace App\Services;

use App\Exports\TypeExport;
use App\Models\Inventory;
use App\Models\Type;
use Maatwebsite\Excel\Facades\Excel;

class TypeService
{
    public function getAllTypes($search)
    {
        return Type::when($search, function ($query, $search) {
            $query->where('name', 'like', "%$search%")
                ->orWhere('code', 'like', "%$search%");
        })->latest()->paginate(10);
    }

    public function createType(array $data)
    {
        return Type::create($data);
    }

    public function getTypeById(string $id)
    {
        return Type::findOrFail($id);
    }

    public function updateType(string $id, array $data)
    {
        return Type::findOrFail($id)->update($data);
    }

    public function deleteType(string $id)
    {
        if (Inventory::where('id_type', $id)->exists()) {
            return false;
        }
        return Type::findOrFail($id)->delete();
    }

    public function exportTypes($typeIds)
    {
        $types = $typeIds ? Type::whereIn('id', explode(',', $typeIds))->get(['name', 'code', 'information'])
            : Type::all(['name', 'code', 'information']);

        return new TypeExport($types);
    }
}
