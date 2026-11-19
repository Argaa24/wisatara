<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavoritWisatawan extends Model
{
    use HasFactory;

    protected $table = 'favorit_wisatawan';
    protected $primaryKey = 'id_favorit';
    protected $guarded = [];

    protected $casts = [
        'tgl_simpan' => 'datetime',
    ];

    public function wisatawan()
    {
        return $this->belongsTo(Wisatawan::class, 'id_wisatawan', 'id_wisatawan');
    }

    public function paket()
    {
        return $this->belongsTo(PaketTur::class, 'id_paket', 'id_paket');
    }

    public function pemandu()
    {
        return $this->belongsTo(PemanduLokal::class, 'id_pemandu', 'id_pemandu');
    }
}
