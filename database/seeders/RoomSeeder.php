<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rooms = [
            ['name' => 'Ruang Kerja 1', 'code' => 'RK-001', 'information' => 'Ruang kerja utama untuk pegawai.'],
            ['name' => 'Ruang Kerja 2', 'code' => 'RK-002', 'information' => 'Ruang kerja tambahan untuk pegawai baru.'],
            ['name' => 'Ruang Meeting', 'code' => 'RM-001', 'information' => 'Ruangan untuk pertemuan dan diskusi.'],
            ['name' => 'Gudang Utama', 'code' => 'GD-001', 'information' => 'Gudang utama untuk menyimpan inventaris barang.'],
            ['name' => 'Laboratorium Teknologi', 'code' => 'LT-001', 'information' => 'Laboratorium untuk riset dan pengujian alat teknologi.'],
            ['name' => 'Ruang Penyimpanan', 'code' => 'RP-001', 'information' => 'Ruang untuk menyimpan barang-barang cadangan.'],
            ['name' => 'Server Room', 'code' => 'SR-001', 'information' => 'Ruang untuk server dan perangkat IT.'],
        ];

        foreach ($rooms as $room) {
            Room::create($room);
        }
    }
}
