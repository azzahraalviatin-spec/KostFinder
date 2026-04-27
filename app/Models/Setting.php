<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'notif_booking',
        'notif_user',
        'whatsapp_cs',
        'email_support',
        'instagram_link',
        'tiktok_link',
        'komisi_admin',
        'facebook_link',
        'alamat_kantor',
    ];
}
