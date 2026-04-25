<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;

class KeluhanController extends Controller
{
    public function index()
    {
        $keluhans = \App\Models\Keluhan::whereHas('booking', function($query) {
            $query->where('user_id', auth()->id());
        })->with('booking.room.kost')->latest()->get();

        return view('user.keluhan', compact('keluhans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id_booking',
            'jenis'      => 'required|string|max:255',
            'deskripsi'  => 'required|string'
        ]);

        \App\Models\Keluhan::create([
            'booking_id' => $request->booking_id,
            'jenis'      => $request->jenis,
            'deskripsi'  => $request->deskripsi,
            'status'     => 'pending'
        ]);

        return redirect()->route('keluhan.index')->with('success', 'Keluhan berhasil diajukan!');
    }

    public function pilih()
    {
        // Hanya bisa komplain saat booking berstatus "diterima" (Check In / Aktif)
        $bookings = Booking::where('user_id', auth()->id())
            ->where('status_booking', 'diterima')
            ->with(['room.kost'])
            ->latest()
            ->get();

        return view('user.keluhan-pilih', compact('bookings'));
    }

    public function create($id)
    {
        $booking = Booking::with('room.kost')->findOrFail($id);

        return view('user.keluhan-create', compact('booking'));
    }
}