<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kategoriUkmModel extends Model
{
    use HasFactory;
    protected $table = 'kategori_ukm';
    protected $primaryKey = 'id_kategori';
    public $timestamps = false;

    protected $fillable = ['nama_kategori'];

    // Relasi ke UKM
    public function ukm()
    {
        return $this->hasMany(UkmModel::class, 'id_kategori');
    }  
}