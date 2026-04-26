<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomImage extends Model
{
    protected $fillable = [
        'room_id',
        'foto_path',
        'judul',
        'tipe_foto',  // 'kamar' atau 'fasilitas'
        'is_utama',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', 'id_room');
    }
}