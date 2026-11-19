<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaketTur extends Model
{
    use HasFactory;

    protected $table = 'paket_tur';
    protected $primaryKey = 'id_paket';
    protected $guarded = [];

    protected $casts = [
        'bisa_kustom' => 'boolean',
        'harga_per_orang' => 'decimal:2',
    ];

    public function pemandu()
    {
        return $this->belongsTo(PemanduLokal::class, 'id_pemandu', 'id_pemandu');
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriTur::class, 'id_kategori', 'id_kategori');
    }

    public function kota()
    {
        return $this->belongsTo(KotaDestinasi::class, 'id_kota', 'id_kota');
    }

    public function itinerary()
    {
        return $this->hasMany(RuteItinerary::class, 'id_paket', 'id_paket')->orderBy('urutan_ke');
    }

    public function reservasi()
    {
        return $this->hasMany(ReservasiTur::class, 'id_paket', 'id_paket');
    }
}
