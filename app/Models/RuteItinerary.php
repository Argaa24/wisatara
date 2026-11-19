<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RuteItinerary extends Model
{
    use HasFactory;

    protected $table = 'rute_itinerary';
    protected $primaryKey = 'id_itinerary';
    protected $guarded = [];

    public function paket()
    {
        return $this->belongsTo(PaketTur::class, 'id_paket', 'id_paket');
    }
}
