<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecentlyViewedKost extends Model
{
    protected $fillable = ['user_id', 'kost_id'];

    public function kost()
    {
        return $this->belongsTo(Kost::class, 'kost_id', 'id_kost');
    }
}
