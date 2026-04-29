<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use App\Models\Booking;

class BookingDibatalkanNotification extends Notification
{
    public function __construct(public Booking $booking) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'type'    => 'booking_dibatalkan',
            'icon'    => '❌',
            'judul'   => 'Booking Dibatalkan',
            'pesan'   => $this->booking->user->name . ' membatalkan booking kamar ' . $this->booking->room->nomor_kamar,
            'url'     => route('admin.bookings'),
            'booking_id' => $this->booking->id_booking,
        ];
    }
}