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
            [
                'id' => 1,
                'name' => 'admin',
                'username' => 'mas admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('12345678'),
                'id_level' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 2,
                'name' => 'operator',
                'username' => 'mas operator',
                'email' => 'operator@gmail.com',
                'password' => Hash::make('12345678'),
                'id_level' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 3,
                'name' => 'dewa',
                'username' => 'dewa asik',
                'email' => 'dewarochman26@gmail.com',
                'password' => Hash::make('12345678'),
                'id_level' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
