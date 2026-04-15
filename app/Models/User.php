<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'no_hp',
        'email',
        'password',
        'google_id',
        'foto_profil',
        'kota',
        'notif_booking', 'notif_cancel', 'notif_pembayaran', 'notif_promo',
        'role',
        'status_akun',
        'jenis_kelamin',
'tanggal_lahir',
'kontak_darurat',
'pekerjaan',
'instansi',
'pendidikan',
'status_pernikahan',
'notif_info_umum',
'notif_data_diri',
'notif_aktivitas',
'notif_pencarian',
'notif_chat',
'jenis_identitas',
'foto_ktp',
'foto_selfie',
'status_verifikasi_identitas',
'catatan_verifikasi',
'foto_kepemilikan',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function ownerReview()
{
    return $this->hasOne(\App\Models\OwnerReview::class);
}
}
