<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'bookings';
    protected $primaryKey = 'id_booking';

    protected $casts = [
        'tanggal_masuk'   => 'date',
        'tanggal_selesai' => 'date',
    ];

    protected $fillable = [
        'user_id',
        'room_id',
        'tanggal_masuk',
        'tanggal_selesai',
        'durasi_sewa',
        'tipe_durasi',
        'jumlah_durasi',
        'catatan',
        'total_harga',
        'total_bayar',
        'komisi_admin',
        'pendapatan_owner',
        'metode_pembayaran',
        'status_booking',
        'status_pembayaran',
        'bukti_pembayaran',
        'alasan_batal',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', 'id_room');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function review()
    {
        return $this->hasOne(\App\Models\Review::class, 'booking_id', 'id_booking');
    }
}