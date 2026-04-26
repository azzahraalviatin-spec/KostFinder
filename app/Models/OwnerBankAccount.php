<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OwnerBankAccount extends Model
{
    protected $fillable = [
        'user_id',
        'nama_bank',
        'nomor_rekening',
        'nama_pemilik',
        'is_primary',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
