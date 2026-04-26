<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kost extends Model
{
    protected $table = 'kosts';
    protected $primaryKey = 'id_kost';

    protected $fillable = [
        'owner_id',
        'nama_kost',
        'alamat',
        'kota',
        'tipe_kost',
        'deskripsi',
        'fasilitas',
        'aturan',
        'foto_utama',
        'harga_mulai',
        'harga_sampai',
        'ada_harian',
        'harga_harian_mulai',
        'harga_harian_sampai',
        'latitude',
        'longitude',
        'status',
        'is_verified',
    ];

    protected $casts = [
        'fasilitas' => 'array',
        'aturan' => 'array',
    ];
    

    public function getFotoUtamaUrlAttribute()
    {
        if ($this->foto_utama) {
            return asset('storage/' . $this->foto_utama);
        }
        return asset('images/default-kost.jpg');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }

    public function rooms()
    {
        return $this->hasMany(Room::class, 'kost_id', 'id_kost');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'kost_id', 'id_kost');
    }

    public function images()
    {
        return $this->hasMany(KostImage::class, 'kost_id', 'id_kost')
                    ->orderBy('sort_order', 'asc');
    }

    // TAMBAHAN BARU
    public function bookings()
    {
        return $this->hasManyThrough(
            Booking::class,
            Room::class,
            'kost_id',
            'room_id',
            'id_kost',
            'id_room'
        );
    }
    public function generalFacilities()
    {
        return $this->hasMany(KostFacility::class, 'kost_id', 'id_kost');
    }
    
}