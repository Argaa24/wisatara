<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriTur extends Model
{
    use HasFactory;

    protected $table = 'kategori_tur';
    protected $primaryKey = 'id_kategori';
    protected $guarded = [];

    public function paketTur()
    {
        return $this->hasMany(PaketTur::class, 'id_kategori', 'id_kategori');
    }
}
