<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keluhan extends Model
{
    protected $table = 'keluhans';
    protected $primaryKey = 'id_keluhan';

    protected $fillable = [
        'booking_id',
        'jenis',
        'deskripsi',
        'foto',
        'status'
    ];

    // RELASI KE BOOKING (CUKUP 1 INI!)
    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'id_booking');
    }
}