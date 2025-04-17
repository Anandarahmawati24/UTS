<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ukmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id_ukm' => 1,
                'nama_ukm' => 'UKM Futsal',
                'id_kategori' => 1, // Olahraga
                'email' => 'futsal@ukm.com',
                'alamat' => 'Gedung Olahraga Polinema',
                'deskripsi' => 'UKM Futsal merupakan tempat berkumpulnya mahasiswa yang menyukai olahraga futsal.',
                'tanggal_berdiri' => '2015-08-12',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_ukm' => 2,
                'nama_ukm' => 'UKM Seni Tari',
                'id_kategori' => 2, // Seni & Budaya
                'email' => 'senitari@ukm.com',
                'alamat' => 'Gedung Kesenian Polinema',
                'deskripsi' => 'UKM Seni Tari mengembangkan minat mahasiswa di bidang seni pertunjukan tradisional dan modern.',
                'tanggal_berdiri' => '2012-03-20',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_ukm' => 3,
                'nama_ukm' => 'UKM Robotika',
                'id_kategori' => 3, // Teknologi
                'email' => 'robotika@ukm.com',
                'alamat' => 'Lab Teknologi Polinema',
                'deskripsi' => 'UKM Robotika mewadahi mahasiswa yang memiliki minat dalam dunia teknologi dan robot.',
                'tanggal_berdiri' => '2017-09-05',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('m_ukm')->insert($data);
    }
}
