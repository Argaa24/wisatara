<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KotaDestinasi extends Model
{
    use HasFactory;

    protected $table = 'kota_destinasi';
    protected $primaryKey = 'id_kota';
    protected $guarded = [];

    public function pemandu()
    {
        return $this->hasMany(PemanduLokal::class, 'id_kota', 'id_kota');
    }

    public function paketTur()
    {
        return $this->hasMany(PaketTur::class, 'id_kota', 'id_kota');
    }
}
