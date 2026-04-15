<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Booking;

class BookingController extends Controller
{
    public function index()
    {
        $owner_id = auth()->id();
        $bookings = Booking::whereHas('room.kost', function($q) use ($owner_id) {
            $q->where('owner_id', $owner_id);
        })->with(['user', 'room.kost'])->latest()->get();

        $bookingsJson = $bookings->mapWithKeys(function($b) {
            return [$b->id => [
                'id'      => $b->id,
                'penyewa' => $b->user->name ?? '—',
                'email'   => $b->user->email ?? '—',
                'telepon' => $b->user->telepon ?? '—',
                'kost'    => optional(optional($b->room)->kost)->nama_kost ?? '—',
                'kamar'   => optional($b->room)->nomor_kamar ?? '—',
                'masuk'   => $b->tanggal_masuk ? \Carbon\Carbon::parse($b->tanggal_masuk)->format('d M Y') : '—',
                'durasi'  => $b->durasi_sewa . ' bulan',
                'status'  => $b->status_booking,
                'catatan' => $b->catatan ?? '—',
            ]];
        });

        return view('owner.booking', compact('bookings', 'bookingsJson'));
    }

    public function terima(Booking $booking)
    {
        $booking->update(['status_booking' => 'diterima']);
        return back()->with('success', 'Booking berhasil diterima!');
    }

    public function tolak(Booking $booking)
    {
        $booking->update(['status_booking' => 'ditolak']);
        return back()->with('success', 'Booking berhasil ditolak!');
    }

    public function selesai(Booking $booking)
    {
        $booking->update(['status_booking' => 'selesai']);
        return back()->with('success', 'Booking ditandai selesai!');
    }
}