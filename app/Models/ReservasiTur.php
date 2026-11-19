<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservasiTur extends Model
{
    use HasFactory;

    protected $table = 'reservasi_tur';
    protected $primaryKey = 'id_reservasi';
    protected $guarded = [];

    protected $casts = [
        'tgl_tur' => 'date',
        'total_harga' => 'decimal:2',
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

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'id_reservasi', 'id_reservasi');
    }

    public function ulasan()
    {
        return $this->hasOne(UlasanTur::class, 'id_reservasi', 'id_reservasi');
    }
}
