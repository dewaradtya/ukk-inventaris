<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Inventory;
use App\Models\Type;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = Type::all();
        $rooms = Room::all();
        $users = User::all();

        $inventories = [
            ['name' => 'Laptop Dell XPS 13', 'condition' => 'baik', 'amount' => 10, 'code' => 'LAB-LAP-001', 'id_type' => $types->where('name', 'Laptop')->first()->id, 'id_room' => $rooms->where('name', 'Laboratorium Komputer')->first()->id, 'id_user' => $users->first()->id, 'register_date' => now()],
            ['name' => 'Router Mikrotik RB750', 'condition' => 'baik', 'amount' => 5, 'code' => 'NET-DEV-001', 'id_type' => $types->where('name', 'Router dan Switch')->first()->id, 'id_room' => $rooms->where('name', 'Laboratorium Jaringan')->first()->id, 'id_user' => $users->first()->id, 'register_date' => now()],
            ['name' => 'Meja Guru Kayu', 'condition' => 'baik', 'amount' => 20, 'code' => 'CLS-TABLE-001', 'id_type' => $types->where('name', 'Meja Guru')->first()->id, 'id_room' => $rooms->where('name', 'Ruang Kelas 10 TKJ')->first()->id, 'id_user' => $users->first()->id, 'register_date' => now()],
            ['name' => 'AC Panasonic', 'condition' => 'baik', 'amount' => 3, 'code' => 'CLS-AC-001', 'id_type' => $types->where('name', 'AC Kelas')->first()->id, 'id_room' => $rooms->where('name', 'Laboratorium Multimedia')->first()->id, 'id_user' => $users->first()->id, 'register_date' => now()],
            ['name' => 'Buku Panduan Teknik', 'condition' => 'baik', 'amount' => 100, 'code' => 'LIB-BOOK-001', 'id_type' => $types->where('name', 'Buku Pelajaran')->first()->id, 'id_room' => $rooms->where('name', 'Perpustakaan')->first()->id, 'id_user' => $users->first()->id, 'register_date' => now()],
        ];

        foreach ($inventories as $inventory) {
            Inventory::create($inventory);
        }
    }
}
