<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;

class KeluhanController extends Controller
{
    public function pilih()
    {
        $bookings = Booking::where('user_id', auth()->id())
            ->whereIn('status_booking', ['aktif','selesai'])
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