<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Kost;
use App\Models\Room;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $owner_id = auth()->id();

        $total_kost = Kost::where('owner_id', $owner_id)->count();

        $total_booking = Booking::whereHas('room.kost', fn($q) => $q->where('owner_id', $owner_id))->count();

        $booking_pending = Booking::whereHas('room.kost', fn($q) => $q->where('owner_id', $owner_id))
            ->where('status_booking', 'pending')->count();

        $pendapatan_bulan_ini = Booking::whereHas('room.kost', fn($q) => $q->where('owner_id', $owner_id))
            ->where('status_pembayaran', 'lunas')
            ->whereMonth('updated_at', now()->month)
            ->whereYear('updated_at', now()->year)
            ->sum('pendapatan_owner');
            $cekBooking = Booking::whereHas('room.kost', fn($q) => $q->where('owner_id', $owner_id))
            ->get(['id_booking', 'status_pembayaran', 'status_booking', 'pendapatan_owner', 'total_harga', 'updated_at']);
        

        $pendapatan_bulan_lalu = Booking::whereHas('room.kost', fn($q) => $q->where('owner_id', $owner_id))
            ->where('status_pembayaran', 'lunas')
            ->whereMonth('updated_at', now()->subMonth()->month)
            ->whereYear('updated_at', now()->subMonth()->year)
            ->sum('pendapatan_owner');

        $selisih_pendapatan = $pendapatan_bulan_ini - $pendapatan_bulan_lalu;

        $kosts = Kost::where('owner_id', $owner_id)->latest()->get();

        $bookings = Booking::whereHas('room.kost', fn($q) => $q->where('owner_id', $owner_id))
            ->with(['user', 'room.kost'])
            ->latest()->limit(5)->get();

        return view('owner.dashboard', compact(
            'total_kost', 'total_booking', 'booking_pending', 'kosts', 'bookings',
            'pendapatan_bulan_ini', 'pendapatan_bulan_lalu', 'selisih_pendapatan'
        ));
    }

    public function search(Request $request)
    {
        $q = $request->get('q', '');
        if (strlen($q) < 2) return response()->json([]);

        $owner_id = auth()->id();

        $kosts = Kost::where('owner_id', $owner_id)
        ->where('nama_kost', 'like', "%$q%")
        ->limit(4)->get()
        ->map(fn($k) => [
            'title'    => $k->nama_kost,
            'subtitle' => $k->kota,
            'icon'     => '🏠',
            'url'      => route('owner.kost.show', $k->id_kost),
        ]);
    
    $kamar = Room::whereHas('kost', fn($q2) => $q2->where('owner_id', $owner_id))
        ->with('kost')
        ->where('nomor_kamar', 'like', "%$q%")
        ->limit(4)->get()
        ->map(fn($r) => [
            'title'    => 'Kamar ' . $r->nomor_kamar,
            'subtitle' => $r->kost->nama_kost ?? '—',
            'icon'     => '🚪',
            'url'      => route('owner.kamar.show', $r->id_room),
        ]);

        return response()->json($kosts->merge($kamar)->values());
    }
}