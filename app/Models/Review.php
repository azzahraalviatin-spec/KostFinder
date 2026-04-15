<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'user_id','kost_id','booking_id',
        'rating','rating_kebersihan','rating_fasilitas',
        'rating_lokasi','rating_harga','komentar','foto_review'
    ];

    protected $casts = ['foto_review' => 'array'];

    public function kost() { return $this->belongsTo(Kost::class, 'kost_id', 'id_kost'); }
    public function user() { return $this->belongsTo(User::class); }
    public function booking() { return $this->belongsTo(Booking::class, 'booking_id', 'id_booking'); }
}