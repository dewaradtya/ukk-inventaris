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
            ['name' => 'Laptop', 'code' => 'ELEC-LAP', 'information' => 'Perangkat komputer portabel untuk pekerja.'],
            ['name' => 'Kursi', 'code' => 'FURN-CHAIR', 'information' => 'Kursi kantor yang nyaman untuk penggunaan jangka panjang.'],
            ['name' => 'Meja', 'code' => 'FURN-TABLE', 'information' => 'Meja kerja dengan berbagai ukuran.'],
            ['name' => 'Printer', 'code' => 'ELEC-PRT', 'information' => 'Perangkat untuk mencetak dokumen.'],
            ['name' => 'Proyektor', 'code' => 'ELEC-PROJ', 'information' => 'Perangkat untuk menampilkan presentasi atau video.'],
            ['name' => 'Scanner', 'code' => 'ELEC-SCN', 'information' => 'Perangkat untuk memindai dokumen.'],
            ['name' => 'AC', 'code' => 'ELEC-AC', 'information' => 'Pendingin ruangan dengan efisiensi energi tinggi.'],
            ['name' => 'TV', 'code' => 'ELEC-TV', 'information' => 'Televisi untuk ruang rapat atau ruang tunggu.'],
            ['name' => 'Telepon', 'code' => 'ELEC-PHONE', 'information' => 'Perangkat telekomunikasi untuk keperluan kantor.'],
            ['name' => 'Buku', 'code' => 'BOOK-REFERENCE', 'information' => 'Buku referensi untuk kepentingan riset atau pembelajaran.']
        ];

        foreach ($types as $type) {
            Type::create($type);
        }
    }
}
