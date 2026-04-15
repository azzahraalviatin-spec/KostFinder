<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Favorite;
use App\Models\Kost;
use App\Models\Review;

class DashboardController extends Controller
{
    public function index()
    {
        $user_id = auth()->id();

        $totalBooking    = Booking::where('user_id', $user_id)->count();
        $bookingPending  = Booking::where('user_id', $user_id)->where('status_booking', 'pending')->count();
        $bookingDiterima = Booking::where('user_id', $user_id)->where('status_booking', 'diterima')->count();
        $totalFavorit    = Favorite::where('user_id', $user_id)->count();
        $totalReview     = Review::where('user_id', $user_id)->count();

        $bookings = Booking::where('user_id', $user_id)
            ->with(['room.kost'])
            ->latest()->limit(5)->get();

        $favorit = Favorite::where('user_id', $user_id)
            ->with('kost')->latest()->limit(3)->get();

        $rekomendasiKost = Kost::where('status', 'aktif')
            ->latest()->limit(8)->get();

        return view('user.dashboard', compact(
            'totalBooking', 'bookingPending', 'bookingDiterima',
            'totalFavorit', 'totalReview',
            'bookings', 'favorit', 'rekomendasiKost'
        ));
    }
}