<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'rooms';
    protected $primaryKey = 'id_room';

    protected $fillable = [
        'kost_id',
        'nomor_kamar',
        'harga_per_bulan',
        'harga_harian',
        'aktif_bulanan',
        'aktif_harian',
        'status_kamar',
        'tipe_kamar',
        'ukuran',
        'deskripsi',
        'fasilitas',
    ];

    protected $casts = [
        'fasilitas' => 'array',
    ];

    public function kost()
    {
        return $this->belongsTo(Kost::class, 'kost_id', 'id_kost');
    }

    public function images()
    {
        return $this->hasMany(RoomImage::class, 'room_id', 'id_room');
    }

    public function mainImage()
    {
        return $this->hasOne(RoomImage::class, 'room_id', 'id_room')->where('is_utama', 1);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'room_id', 'id_room');
    }
}