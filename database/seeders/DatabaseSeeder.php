<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'username' => 'admin',
            'password' => Hash::make ('admin'),
            'nama' => 'Satrio Augistiawan',
            'role' => 'admin'
        ]);
        DB::table('users')->insert([
            'username' => 'kasir',
            'password' => Hash::make ('kasir'),
            'nama' => 'Udin Gaclek',
            'role' => 'kasir'
        ]);
        DB::table('users')->insert([
            'username' => 'owner',
            'password' => Hash::make ('owner'),
            'nama' => 'Satset Augs',
            'role' => 'owner'
        ]);
    }
}
