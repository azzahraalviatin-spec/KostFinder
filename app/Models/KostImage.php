<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KostImage extends Model
{
    protected $table = 'kost_images';

    protected $fillable = [
        'kost_id',
        'image_path',
        'sort_order',
        'kategori',
    ];

    public function kost()
    {
        return $this->belongsTo(Kost::class, 'kost_id', 'id_kost');
    }

    public function getImageUrlAttribute()
    {
        return asset('storage/' . $this->image_path);
    }
}