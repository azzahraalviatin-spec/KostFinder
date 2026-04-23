<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'semua');
        $allowedStatuses = ['pending', 'diterima', 'ditolak', 'selesai'];

        if (!in_array($status, $allowedStatuses, true) && $status !== 'semua') {
            $status = 'semua';
        }

        $allBookings = $this->ownerBookingsQuery()->get();
        $bookings = $status === 'semua'
            ? $allBookings
            : $allBookings->where('status_booking', $status)->values();

        return view('owner.booking', [
            'allBookings' => $allBookings,
            'bookings' => $bookings,
            'activeStatus' => $status,
        ]);
    }

    public function show(Booking $booking)
    {
        $booking = $this->findOwnerBooking($booking->getKey());

        return view('owner.booking-show', compact('booking'));
    }

    public function terima(Booking $booking)
    {
        $booking = $this->findOwnerBooking($booking->getKey());
        $booking->update(['status_booking' => 'diterima']);

        return back()->with('success', 'Booking berhasil diterima!');
    }

    public function tolak(Request $request, Booking $booking)
    {
        $request->validate([
            'alasan_batal' => 'nullable|string|max:300',
        ]);
    
        $booking = $this->findOwnerBooking($booking->getKey());
        $booking->update([
            'status_booking' => 'ditolak',
            'alasan_batal'   => $request->alasan_batal ?? 'Tidak ada alasan yang diberikan.',
        ]);
    
        return back()->with('success', 'Booking berhasil ditolak!');
    }

    public function selesai(Booking $booking)
    {
        $booking = $this->findOwnerBooking($booking->getKey());
        $booking->update(['status_booking' => 'selesai']);

        return back()->with('success', 'Booking ditandai selesai!');
    }

    private function ownerBookingsQuery()
    {
        $ownerId = auth()->id();

        return Booking::whereHas('room.kost', function ($query) use ($ownerId) {
            $query->where('owner_id', $ownerId);
        })->with(['user', 'room.kost', 'room.mainImage'])->latest();
    }

    private function findOwnerBooking($bookingId): Booking
    {
        return $this->ownerBookingsQuery()
            ->where('id_booking', $bookingId)
            ->firstOrFail();
    }
}
