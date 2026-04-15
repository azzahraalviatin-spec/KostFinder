<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use App\Models\User;

class OwnerBaruNotification extends Notification
{
    public function __construct(public User $owner) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'type'     => 'owner_baru',
            'icon'     => '👤',
            'judul'    => 'Owner Baru Mendaftar',
            'pesan'    => $this->owner->name . ' baru saja mendaftar sebagai owner, perlu diverifikasi!',
            'url'      => route('admin.owners'),
            'owner_id' => $this->owner->id,
        ];
    }
}