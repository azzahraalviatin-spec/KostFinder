<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use App\Models\Review;

class ReviewBaruNotification extends Notification
{
    public function __construct(public Review $review) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'type'      => 'review_baru',
            'icon'      => '⭐',
            'judul'     => 'Review Baru Masuk',
            'pesan'     => $this->review->user->name . ' memberikan ulasan bintang ' . $this->review->rating . ' untuk ' . $this->review->kost->nama_kost,
            'url'       => route('admin.kosts'),
            'review_id' => $this->review->id,
        ];
    }
}