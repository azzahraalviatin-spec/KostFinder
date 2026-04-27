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

        $booking_selesai = Booking::whereHas('room.kost', fn($q) => $q->where('owner_id', $owner_id))
            ->where('status_booking', 'selesai')->count();

        $total_kamar = Room::whereHas('kost', fn($q) => $q->where('owner_id', $owner_id))->count();
        $kamar_terisi = Room::whereHas('kost', fn($q) => $q->where('owner_id', $owner_id))
            ->where('status_kamar', 'terisi')->count();

        // ✅ FIX: filter pakai status_booking = 'selesai', bukan status_pembayaran
        $pendapatan_bulan_ini = Booking::whereHas('room.kost', fn($q) => $q->where('owner_id', $owner_id))
            ->where('status_booking', 'selesai')
            ->whereMonth('updated_at', now()->month)
            ->whereYear('updated_at', now()->year)
            ->sum('pendapatan_owner');

        $pendapatan_bulan_lalu = Booking::whereHas('room.kost', fn($q) => $q->where('owner_id', $owner_id))
            ->where('status_booking', 'selesai')
            ->whereMonth('updated_at', now()->subMonth()->month)
            ->whereYear('updated_at', now()->subMonth()->year)
            ->sum('pendapatan_owner');

        $selisih_pendapatan = $pendapatan_bulan_ini - $pendapatan_bulan_lalu;

        // ✅ Data chart 6 bulan terakhir (dinamis)
        $chartLabels = [];
        $chartData   = [];
        for ($i = 5; $i >= 0; $i--) {
            $bulan = now()->subMonths($i);
            $chartLabels[] = $bulan->format('M');
            $chartData[]   = Booking::whereHas('room.kost', fn($q) => $q->where('owner_id', $owner_id))
                ->whereMonth('created_at', $bulan->month)
                ->whereYear('created_at', $bulan->year)
                ->count();
        }

        $kosts = Kost::where('owner_id', $owner_id)->latest()->get();

        $bookings = Booking::whereHas('room.kost', fn($q) => $q->where('owner_id', $owner_id))
            ->with(['user', 'room.kost'])
            ->latest()->limit(5)->get();

        $total_bank_accounts = \App\Models\OwnerBankAccount::where('user_id', $owner_id)->count();

        return view('owner.dashboard', compact(
            'total_kost',
            'total_booking',
            'booking_pending',
            'booking_selesai',
            'kosts',
            'bookings',
            'pendapatan_bulan_ini',
            'pendapatan_bulan_lalu',
            'selisih_pendapatan',
            'total_bank_accounts',
            'total_kamar',
            'kamar_terisi',
            'chartLabels',
            'chartData',
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