<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class levelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['id_level' => 1, 'level_kode' => 'ADM', 'level_nama' => 'Administrator', 'created_at' => now(), 'updated_at' => now()],
            ['id_level' => 2, 'level_kode' => 'MHS', 'level_nama' => 'Mahasiswa', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('m_level')->insert($data);
    }
}
