<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bahasa extends Model
{
    use HasFactory;

    protected $table = 'bahasa';
    protected $primaryKey = 'id_bahasa';
    protected $guarded = [];

    public function pemandu()
    {
        return $this->belongsToMany(PemanduLokal::class, 'bahasa_pemandu', 'id_bahasa', 'id_pemandu')
            ->withPivot('tingkat_kefasihan');
    }
}
