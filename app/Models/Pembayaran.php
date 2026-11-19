<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';
    protected $primaryKey = 'id_pembayaran';
    protected $guarded = [];

    protected $casts = [
        'waktu_bayar' => 'datetime',
        'jumlah_bayar' => 'decimal:2',
    ];

    public function reservasi()
    {
        return $this->belongsTo(ReservasiTur::class, 'id_reservasi', 'id_reservasi');
    }
}
