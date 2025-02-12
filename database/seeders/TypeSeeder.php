<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Type;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            ['name' => 'Komputer', 'code' => 'LAB-COMP', 'information' => 'Komputer untuk laboratorium komputer SMK.'],
            ['name' => 'Laptop', 'code' => 'LAB-LAP', 'information' => 'Laptop untuk keperluan guru dan siswa.'],
            ['name' => 'Proyektor', 'code' => 'LAB-PROJ', 'information' => 'Perangkat untuk presentasi di kelas dan laboratorium.'],
            ['name' => 'Papan Tulis', 'code' => 'CLS-WB', 'information' => 'Papan tulis untuk kegiatan belajar mengajar.'],
            ['name' => 'Meja Guru', 'code' => 'CLS-TABLE', 'information' => 'Meja guru di ruang kelas.'],
            ['name' => 'Kursi Siswa', 'code' => 'CLS-CHAIR', 'information' => 'Kursi untuk siswa di kelas.'],
            ['name' => 'Meja Siswa', 'code' => 'CLS-STABLE', 'information' => 'Meja untuk siswa di ruang kelas.'],
            ['name' => 'Buku Pelajaran', 'code' => 'LIB-BOOK', 'information' => 'Buku pelajaran untuk perpustakaan sekolah.'],
            ['name' => 'Alat Praktikum', 'code' => 'LAB-TOOLS', 'information' => 'Alat untuk keperluan praktikum siswa.'],
            ['name' => 'Mikroskop', 'code' => 'LAB-MICRO', 'information' => 'Mikroskop untuk laboratorium biologi.'],
            ['name' => 'Mesin Bubut', 'code' => 'WK-LATHE', 'information' => 'Mesin bubut untuk praktik teknik permesinan.'],
            ['name' => 'Mesin CNC', 'code' => 'WK-CNC', 'information' => 'Mesin CNC untuk praktik manufaktur.'],
            ['name' => 'Peralatan Las', 'code' => 'WK-WELD', 'information' => 'Peralatan las untuk keperluan praktik teknik pengelasan.'],
            ['name' => 'Server Jaringan', 'code' => 'NET-SVR', 'information' => 'Server jaringan untuk laboratorium TKJ.'],
            ['name' => 'Router dan Switch', 'code' => 'NET-DEV', 'information' => 'Router dan switch untuk pembelajaran jaringan komputer.'],
            ['name' => 'AC Kelas', 'code' => 'CLS-AC', 'information' => 'AC untuk ruang kelas dan laboratorium.'],
            ['name' => 'TV Interaktif', 'code' => 'CLS-TV', 'information' => 'TV interaktif untuk pembelajaran digital.'],
            ['name' => 'Speaker', 'code' => 'CLS-SPK', 'information' => 'Speaker untuk keperluan penyampaian materi di kelas.'],
            ['name' => 'Peralatan Tata Boga', 'code' => 'CATERING-EQ', 'information' => 'Peralatan untuk praktik tata boga.'],
            ['name' => 'Peralatan Tata Busana', 'code' => 'FASHION-EQ', 'information' => 'Peralatan untuk praktik tata busana.']
        ];

        foreach ($types as $type) {
            Type::create($type);
        }
    }
}
