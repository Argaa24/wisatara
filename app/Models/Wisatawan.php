<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wisatawan extends Model
{
    use HasFactory;

    protected $table = 'wisatawan';
    protected $primaryKey = 'id_wisatawan';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function reservasi()
    {
        return $this->hasMany(ReservasiTur::class, 'id_wisatawan', 'id_wisatawan');
    }

    public function favorit()
    {
        return $this->hasMany(FavoritWisatawan::class, 'id_wisatawan', 'id_wisatawan');
    }

    public function ulasan()
    {
        return $this->hasMany(UlasanTur::class, 'id_wisatawan', 'id_wisatawan');
    }
}
