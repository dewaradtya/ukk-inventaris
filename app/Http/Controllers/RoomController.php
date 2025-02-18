<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoomStoreRequest;
use App\Http\Requests\RoomUpdateRequest;
use App\Services\RoomService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class RoomController extends Controller
{
    protected $roomService;

    public function __construct(RoomService $roomService)
    {
        $this->roomService = $roomService;
    }

    public function index(Request $request)
    {
        $rooms = $this->roomService->getAllRooms($request->search);
        return view('pages.admin.room.index', compact('rooms'));
    }

    public function create()
    {
        return view('pages.admin.room.create');
    }

    public function store(RoomStoreRequest $request)
    {
        $this->roomService->createRoom($request->validated());
        return redirect()->route('room.index')->with('success', 'Room berhasil ditambahkan');
    }

    public function edit(string $id)
    {
        $room = $this->roomService->getRoomById($id);
        return view('pages.admin.room.edit', compact('room'));
    }

    public function update(RoomUpdateRequest $request, string $id)
    {
        $this->roomService->updateRoom($id, $request->validated());
        return redirect()->route('room.index')->with('success', 'Room berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        if (!$this->roomService->deleteRoom($id)) {
            return redirect()->back()->with('error', 'Data tidak dapat dihapus karena sedang digunakan di Inventory!');
        }
        return redirect()->route('room.index')->with('success', 'Data berhasil dihapus!');
    }

    public function export(Request $request)
    {
        $file = $this->roomService->exportRooms($request->query('ids'));
        return Excel::download($file, 'Ruang Inventaris.xlsx');
    }
}