<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class m_kategori extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['id_kategori' => 1, 'nama_kategori' => 'Olahraga', 'created_at' => now(), 'updated_at' => now()],
            ['id_kategori' => 2, 'nama_kategori' => 'Seni & Budaya', 'created_at' => now(), 'updated_at' => now()],
            ['id_kategori' => 3, 'nama_kategori' => 'Teknologi', 'created_at' => now(), 'updated_at' => now()],
            ['id_kategori' => 4, 'nama_kategori' => 'Kewirausahaan', 'created_at' => now(), 'updated_at' => now()],
            ['id_kategori' => 5, 'nama_kategori' => 'Religi', 'created_at' => now(), 'updated_at' => now()],
        ];
        DB::table('kategori_ukm')->insert($data);
        
    }
}
