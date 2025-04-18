<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    use HasFactory;

    protected $table = 'm_user';
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'username',
        'nama',
        'password',
        'id_level'
    ];

    protected $hidden = [
        'password',
    ];

    /**
     * Get the level that owns the user.
     */
    public function level()
    {
        return $this->belongsTo(LevelModel::class, 'id_level', 'id_level');
    }
}