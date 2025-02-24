<?php

namespace Database\Seeders;

use App\Models\FineSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FineSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            ['late_fee'=> 500, 'lost_fee' => 50000, 'damage_fee' => 30000],
        ];

        foreach ($types as $type) {
            FineSetting::create($type);
        }
    }
}
