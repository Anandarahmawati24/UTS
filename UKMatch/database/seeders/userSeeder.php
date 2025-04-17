<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'user_id' => 1,
                'id_level' => 1, // Administrator
                'username' => 'admin1',
                'nama' => 'Admin Satu',
                'password' => Hash::make('admin123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'id_level' => 2, // Mahasiswa
                'username' => 'mahasiswa1',
                'nama' => 'Budi Santoso',
                'password' => Hash::make('budi123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3,
                'id_level' => 2, // Mahasiswa
                'username' => 'mahasiswa2',
                'nama' => 'Siti Aminah',
                'password' => Hash::make('siti123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('m_user')->insert($data);
    }
}
