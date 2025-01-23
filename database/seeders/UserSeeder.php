<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id' => 1,
            'name' => 'admin',
            'username' => 'mas admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('secret'),
            'id_level' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
