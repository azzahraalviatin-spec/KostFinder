<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Notifications\BookingStatusNotification;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $status          = $request->query('status', 'semua');
        $allowedStatuses = ['pending', 'diterima', 'ditolak', 'selesai', 'dibatalkan'];

        if (!in_array($status, $allowedStatuses, true) && $status !== 'semua') {
            $status = 'semua';
        }

        $allBookings = $this->ownerBookingsQuery()->get();
        $bookings    = $status === 'semua'
            ? $allBookings
            : $allBookings->where('status_booking', $status)->values();

        return view('owner.booking', [
            'allBookings'  => $allBookings,
            'bookings'     => $bookings,
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

        // 🔔 NOTIFIKASI KE USER
        $booking->user->notify(new BookingStatusNotification($booking));

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

        // 🔔 NOTIFIKASI KE USER
        $booking->user->notify(new BookingStatusNotification($booking));

        return back()->with('success', 'Booking berhasil ditolak!');
    }

    public function selesai(Booking $booking)
    {
        $booking = $this->findOwnerBooking($booking->getKey());

        // ── HITUNG PENDAPATAN ──
        // Ambil total_harga dari booking, fallback ke harga kamar × durasi
        $totalHarga = $booking->total_harga
            ?? (($booking->room->harga ?? 0) * ($booking->durasi_sewa ?? 1));

        // Ambil komisi dari settings, default 10% jika tidak ada
        $settings = \App\Models\Setting::first();
        $persenKomisi = $settings ? ($settings->komisi_admin / 100) : 0.10;

        $komisiAdmin      = round($totalHarga * $persenKomisi);
        $pendapatanOwner  = $totalHarga - $komisiAdmin;

        $booking->update([
            'status_booking'    => 'selesai',
            'komisi_admin'      => $komisiAdmin,
            'pendapatan_owner'  => $pendapatanOwner,
        ]);

        return back()->with('success', 'Booking ditandai selesai! Pendapatan Rp ' . number_format($pendapatanOwner, 0, ',', '.') . ' telah dicatat.');
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