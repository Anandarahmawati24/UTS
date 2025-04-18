<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LevelModel extends Model
{
    use HasFactory;
    protected $table = 'm_level';
    protected $primaryKey = 'id_level';

    protected $fillable = [
        'level_kode',
        'level_nama',
    ];
    
    // Tambahkan relasi ke user
    public function users()
    {
        return $this->hasMany(UserModel::class, 'id_level', 'id_level');
    }
}
