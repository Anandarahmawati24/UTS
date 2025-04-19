<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ukmModel extends Model
{
    use HasFactory;
       // Nama tabel yang digunakan
       protected $table = 'm_ukm';

       // Primary key dari tabel
       protected $primaryKey = 'id_ukm';
   
       // Jika tidak menggunakan timestamps (created_at dan updated_at)
       public $timestamps = true;
   
       // Kolom-kolom yang boleh diisi
       protected $fillable = [
           'nama_ukm',
           'id_kategori',
           'email',
           'alamat',
           'deskripsi',
           'tanggal_berdiri',
           'status'
       ];
   
       // Relasi ke tabel kategori UKM
       public function kategori()
       {
           return $this->belongsTo(KategoriUkmModel::class, 'id_kategori');
       }
}
