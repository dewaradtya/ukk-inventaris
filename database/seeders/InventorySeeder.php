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
            ['name' => 'Laptop Dell XPS 13', 'condition' => 'Hilang', 'amount' => 10, 'code' => 'ELEC-LAP-001', 'id_type' => $types->where('name', 'Laptop')->first()->id, 'id_room' => $rooms->first()->id, 'id_user' => $users->first()->id, 'register_date' => now(),],
            ['name' => 'Kursi Kantor Ergonomis', 'condition' => 'Rusak', 'amount' => 50, 'code' => 'FURN-CHAIR-001', 'id_type' => $types->where('name', 'Kursi')->first()->id, 'id_room' => $rooms->first()->id, 'id_user' => $users->first()->id, 'register_date' => now(),],
            ['name' => 'Meja Kerja Kayu', 'condition' => 'Baik', 'amount' => 20, 'code' => 'FURN-TABLE-001', 'id_type' => $types->where('name', 'Meja')->first()->id, 'id_room' => $rooms->first()->id, 'id_user' => $users->first()->id, 'register_date' => now(),],
            ['name' => 'Printer Epson L3110', 'condition' => 'Hilang', 'amount' => 5, 'code' => 'ELEC-PRT-001', 'id_type' => $types->where('name', 'Printer')->first()->id, 'id_room' => $rooms->first()->id, 'id_user' => $users->first()->id, 'register_date' => now(),],
            ['name' => 'Proyektor BenQ', 'condition' => 'Rusak', 'amount' => 3, 'code' => 'ELEC-PROJ-001', 'id_type' => $types->where('name', 'Proyektor')->first()->id, 'id_room' => $rooms->first()->id, 'id_user' => $users->first()->id, 'register_date' => now(),],
            ['name' => 'Scanner Canon LiDE 300', 'condition' => 'Baik', 'amount' => 7, 'code' => 'ELEC-SCN-001', 'id_type' => $types->where('name', 'Scanner')->first()->id, 'id_room' => $rooms->first()->id, 'id_user' => $users->first()->id, 'register_date' => now(),],
            ['name' => 'AC Panasonic', 'condition' => 'Hilang', 'amount' => 2, 'code' => 'ELEC-AC-001', 'id_type' => $types->where('name', 'AC')->first()->id, 'id_room' => $rooms->first()->id, 'id_user' => $users->first()->id, 'register_date' => now(),],
            ['name' => 'TV Samsung 50" 4K', 'condition' => 'Baik', 'amount' => 4, 'code' => 'ELEC-TV-001', 'id_type' => $types->where('name', 'TV')->first()->id, 'id_room' => $rooms->first()->id, 'id_user' => $users->first()->id, 'register_date' => now(),],
            ['name' => 'Telepon Panasonic KX-NT560', 'condition' => 'Rusak', 'amount' => 8, 'code' => 'ELEC-PHONE-001', 'id_type' => $types->where('name', 'Telepon')->first()->id, 'id_room' => $rooms->first()->id, 'id_user' => $users->first()->id, 'register_date' => now(),],
            ['name' => 'Buku Panduan Teknik', 'condition' => 'Hilang', 'amount' => 100, 'code' => 'BOOK-REFERENCE-001', 'id_type' => $types->where('name', 'Buku')->first()->id, 'id_room' => $rooms->first()->id, 'id_user' => $users->first()->id, 'register_date' => now(),],
        ];

        foreach ($inventories as $inventory) {
            Inventory::create($inventory);
        }
    }
}
