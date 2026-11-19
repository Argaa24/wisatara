<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemanduLokal extends Model
{
    use HasFactory;

    protected $table = 'pemandu_lokal';
    protected $primaryKey = 'id_pemandu';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function kota()
    {
        return $this->belongsTo(KotaDestinasi::class, 'id_kota', 'id_kota');
    }

    public function bahasa()
    {
        return $this->belongsToMany(Bahasa::class, 'bahasa_pemandu', 'id_pemandu', 'id_bahasa')
            ->withPivot('tingkat_kefasihan');
    }

    public function paketTur()
    {
        return $this->hasMany(PaketTur::class, 'id_pemandu', 'id_pemandu');
    }

    public function reservasi()
    {
        return $this->hasMany(ReservasiTur::class, 'id_pemandu', 'id_pemandu');
    }

    public function ulasan()
    {
        return $this->hasMany(UlasanTur::class, 'id_pemandu', 'id_pemandu');
    }

    public function getRataRataRatingAttribute()
    {
        return round($this->ulasan()->avg('rating') ?? 5.0, 1);
    }
}
