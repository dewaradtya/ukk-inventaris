<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = Room::all();
        return view('pages.admin.room.index', [
            'rooms' => $rooms
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.room.create');
    }

    /**
     * Menyimpan room baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required|unique:rooms',
            'information' => 'required'
        ]);

        $rooms = Room::create([
            'name' => $request->name,
            'code' => $request->code,
            'information' => $request->information
        ]);

        return redirect()->route('room.index')->with('success', 'room berhasil ditambahkan');
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
        $room = Room::findOrFail($id);
        return view('pages.admin.room.edit', [
            'room' => $room,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required|unique:rooms,code,' . $id,
            'information' => 'required'
        ]);

        $room = Room::findOrFail($id);

        $room->name = $request->name;
        $room->code = $request->code;
        $room->information = $request->information;
        $room->save();

        return redirect()->route('room.index')->with('success', 'Room berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $room = Room::findOrFail($id);
        $room->delete();

        return redirect()->route('room.index')->with('success', 'Data berhasil dihapus!');
    }
}
