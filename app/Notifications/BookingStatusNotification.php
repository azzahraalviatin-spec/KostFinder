<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use App\Models\Booking;

class BookingStatusNotification extends Notification
{
    public function __construct(public Booking $booking) {}

    public function via($notifiable): array
    {
        // 🔍 CEK PENGATURAN USER
        if (!$notifiable->notif_booking) {
            return [];
        }
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        $status = $this->booking->status_booking;
        $icon   = $status === 'diterima' ? '✅' : '❌';
        $judul  = $status === 'diterima' ? 'Booking Diterima' : 'Booking Ditolak';
        
        return [
            'type'       => 'booking_status',
            'icon'       => $icon,
            'judul'      => $judul,
            'pesan'      => 'Booking kamu di ' . ($this->booking->room->kost->nama_kost ?? 'Kost') . ' telah ' . $status,
            'url'        => route('user.booking.index'),
            'booking_id' => $this->booking->id_booking,
        ];
    }
}
