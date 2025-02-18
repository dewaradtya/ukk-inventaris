<?php

namespace App\Services;

use App\Exports\RoomExport;
use App\Models\Inventory;
use App\Models\Room;
use Maatwebsite\Excel\Facades\Excel;

class RoomService
{
    public function getAllRooms($search)
    {
        return Room::when($search, function ($query, $search) {
            $query->where('name', 'like', "%$search%")
                ->orWhere('code', 'like', "%$search%");
        })->latest()->paginate(10);
    }

    public function createRoom(array $data)
    {
        return Room::create($data);
    }

    public function getRoomById(string $id)
    {
        return Room::findOrFail($id);
    }

    public function updateRoom(string $id, array $data)
    {
        return Room::findOrFail($id)->update($data);
    }

    public function deleteRoom(string $id)
    {
        if (Inventory::where('id_room', $id)->exists()) {
            return false;
        }
        return Room::findOrFail($id)->delete();
    }

    public function exportRooms($roomIds)
    {
        $rooms = $roomIds ? Room::whereIn('id', explode(',', $roomIds))->get(['name', 'code', 'information'])
            : Room::all(['name', 'code', 'information']);

        return new RoomExport($rooms);
    }
}
