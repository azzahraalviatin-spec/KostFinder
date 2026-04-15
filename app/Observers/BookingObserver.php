<?php

namespace App\Observers;

use App\Models\Booking;
use App\Models\Room;

class BookingObserver
{
    public function created(Booking $booking): void
    {
        $this->updateRoomStatus($booking->room_id);
    }

    public function updated(Booking $booking): void
    {
        $this->updateRoomStatus($booking->room_id);
    }

    public function deleted(Booking $booking): void
    {
        $this->updateRoomStatus($booking->room_id);
    }

    private function updateRoomStatus(int $roomId): void
    {
        $room = Room::find($roomId);
        if (!$room) return;

        $adaBookingAktif = Booking::where('room_id', $roomId)
            ->whereIn('status_booking', ['diterima', 'pending'])
            ->exists();

            $room->status_kamar = $adaBookingAktif ? 'terisi' : 'tersedia';
        $room->save();
    }
}