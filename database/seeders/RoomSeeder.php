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
            ['name' => 'Ruang Kelas 10 TKJ', 'code' => 'CLS-10TKJ', 'information' => 'Ruang kelas untuk siswa kelas 10 jurusan TKJ.'],
            ['name' => 'Ruang Kelas 11 TKJ', 'code' => 'CLS-11TKJ', 'information' => 'Ruang kelas untuk siswa kelas 11 jurusan TKJ.'],
            ['name' => 'Ruang Kelas 12 TKJ', 'code' => 'CLS-12TKJ', 'information' => 'Ruang kelas untuk siswa kelas 12 jurusan TKJ.'],
            ['name' => 'Ruang Kelas 10 RPL', 'code' => 'CLS-10RPL', 'information' => 'Ruang kelas untuk siswa kelas 10 jurusan RPL.'],
            ['name' => 'Ruang Kelas 11 RPL', 'code' => 'CLS-11RPL', 'information' => 'Ruang kelas untuk siswa kelas 11 jurusan RPL.'],
            ['name' => 'Ruang Kelas 12 RPL', 'code' => 'CLS-12RPL', 'information' => 'Ruang kelas untuk siswa kelas 12 jurusan RPL.'],
            ['name' => 'Laboratorium Komputer', 'code' => 'LAB-COMP', 'information' => 'Laboratorium komputer untuk praktik siswa.'],
            ['name' => 'Laboratorium Jaringan', 'code' => 'LAB-NET', 'information' => 'Laboratorium jaringan untuk praktik instalasi dan konfigurasi.'],
            ['name' => 'Laboratorium Multimedia', 'code' => 'LAB-MULTI', 'information' => 'Laboratorium multimedia untuk editing dan produksi konten.'],
            ['name' => 'Workshop Teknik Mesin', 'code' => 'WS-TM', 'information' => 'Workshop untuk praktik teknik permesinan.'],
            ['name' => 'Workshop Teknik Kendaraan Ringan', 'code' => 'WS-TKR', 'information' => 'Workshop untuk praktik teknik kendaraan ringan.'],
            ['name' => 'Workshop Teknik Pengelasan', 'code' => 'WS-WELD', 'information' => 'Workshop untuk praktik teknik pengelasan.'],
            ['name' => 'Ruang Guru', 'code' => 'RG-001', 'information' => 'Ruang khusus untuk guru mengajar dan beristirahat.'],
            ['name' => 'Perpustakaan', 'code' => 'LIB-001', 'information' => 'Ruang perpustakaan untuk membaca dan meminjam buku.'],
            ['name' => 'Aula Sekolah', 'code' => 'AULA-001', 'information' => 'Aula untuk kegiatan sekolah dan acara resmi.'],
            ['name' => 'Kantin Sekolah', 'code' => 'CANTEEN-001', 'information' => 'Kantin tempat makan bagi siswa dan guru.'],
            ['name' => 'Ruang BK', 'code' => 'BK-001', 'information' => 'Ruang Bimbingan Konseling untuk siswa.'],
            ['name' => 'Ruang Kepala Sekolah', 'code' => 'RK-001', 'information' => 'Ruang kerja kepala sekolah.'],
            ['name' => 'Ruang Tata Usaha', 'code' => 'TU-001', 'information' => 'Ruang tata usaha untuk administrasi sekolah.'],
            ['name' => 'Gudang Sekolah', 'code' => 'GD-001', 'information' => 'Gudang penyimpanan barang inventaris sekolah.'],
        ];

        foreach ($rooms as $room) {
            Room::create($room);
        }
    }
}
