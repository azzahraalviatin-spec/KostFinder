<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KostFacility extends Model
{
    use HasFactory;

    protected $fillable = ['kost_id', 'nama', 'foto'];

    public function kost()
    {
        return $this->belongsTo(Kost::class, 'kost_id', 'id_kost');
    }
}
