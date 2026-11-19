<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UlasanTur extends Model
{
    use HasFactory;

    protected $table = 'ulasan_tur';
    protected $primaryKey = 'id_ulasan';
    protected $guarded = [];

    protected $casts = [
        'tgl_ulasan' => 'date',
        'rating' => 'integer',
    ];

    public function reservasi()
    {
        return $this->belongsTo(ReservasiTur::class, 'id_reservasi', 'id_reservasi');
    }

    public function wisatawan()
    {
        return $this->belongsTo(Wisatawan::class, 'id_wisatawan', 'id_wisatawan');
    }

    public function pemandu()
    {
        return $this->belongsTo(PemanduLokal::class, 'id_pemandu', 'id_pemandu');
    }
}
