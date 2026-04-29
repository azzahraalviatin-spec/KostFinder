<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OwnerReview extends Model
{
    protected $table = 'owner_reviews';

    protected $fillable = [
        'user_id',
        'kota',
        'lokasi_kos',
        'rating',
        'ulasan',
        'status'
    ];

    // Relasi ke user (pemilik kos)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scope: ambil hanya yang sudah diapprove admin
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }
}