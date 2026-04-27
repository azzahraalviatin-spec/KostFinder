<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Kost;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class StatistikController extends Controller
{
    public function index(Request $request)
    {
        $owner_id = auth()->id();

        $tahun       = $request->get('tahun', Carbon::now()->year);
        $daftarTahun = range(Carbon::now()->year, 2023);

        // ── TOTAL PENDAPATAN ──
        // ✅ FIX: ganti 'diterima' → 'selesai' karena pendapatan_owner
        //         baru diisi saat booking di-set selesai
        $totalPendapatan = Booking::whereHas('room.kost', fn($q) => $q->where('owner_id', $owner_id))
            ->where('status_booking', 'selesai')
            ->whereYear('updated_at', $tahun)
            ->sum('pendapatan_owner');

        // ── TOTAL BOOKING (semua status) ──
        $totalBooking = Booking::whereHas('room.kost', fn($q) => $q->where('owner_id', $owner_id))
            ->whereYear('created_at', $tahun)
            ->count();

        // ── KAMAR ──
        $kamarTerisi   = Room::whereHas('kost', fn($q) => $q->where('owner_id', $owner_id))
            ->where('status_kamar', 'terisi')->count();
        $kamarTersedia = Room::whereHas('kost', fn($q) => $q->where('owner_id', $owner_id))
            ->where('status_kamar', 'tersedia')->count();

        // ── GRAFIK 12 BULAN ──
        $chartLabels = [];
        $chartData   = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartLabels[] = Carbon::create($tahun, $i, 1)->translatedFormat('M');
            $chartData[]   = Booking::whereHas('room.kost', fn($q) => $q->where('owner_id', $owner_id))
                ->whereYear('created_at', $tahun)
                ->whereMonth('created_at', $i)
                ->count();
        }

        // ── INSIGHT CEPAT ──
        $maxIdx        = array_search(max($chartData), $chartData);
        $bulanTerlaris = max($chartData) > 0 ? $chartLabels[$maxIdx] : null;
        $rataBooking   = $totalBooking > 0 ? round($totalBooking / 12, 1) : 0;
        $performa      = $totalBooking >= 10 ? '🔥 Ramai' : ($totalBooking >= 5 ? '📈 Berkembang' : 'Stabil');

        // ── KOST TERPOPULER ──
        $kostPopuler = Kost::where('owner_id', $owner_id)
            ->withCount(['rooms as total_booking' => fn($q) =>
                $q->whereHas('bookings', fn($b) =>
                    $b->whereYear('created_at', $tahun)
                )
            ])
            ->orderByDesc('total_booking')
            ->get();

        // ── PENDAPATAN BULAN INI ──
        // ✅ FIX: ganti 'diterima' → 'selesai'
        $bulanIni = Carbon::now()->month;

        $pendapatanBulanIni = Booking::whereHas('room.kost', fn($q) => $q->where('owner_id', $owner_id))
            ->where('status_booking', 'selesai')
            ->whereYear('updated_at', Carbon::now()->year)
            ->whereMonth('updated_at', $bulanIni)
            ->sum('pendapatan_owner');

        // ── PENDAPATAN BULAN LALU ──
        // ✅ FIX: ganti 'diterima' → 'selesai'
        $bulanLalu = $bulanIni == 1 ? 12 : $bulanIni - 1;
        $tahunLalu = $bulanIni == 1 ? Carbon::now()->year - 1 : Carbon::now()->year;

        $pendapatanBulanLalu = Booking::whereHas('room.kost', fn($q) => $q->where('owner_id', $owner_id))
            ->where('status_booking', 'selesai')
            ->whereYear('updated_at', $tahunLalu)
            ->whereMonth('updated_at', $bulanLalu)
            ->sum('pendapatan_owner');

        return view('owner.Statistik', compact(
            'totalPendapatan',
            'totalBooking',
            'kamarTerisi',
            'kamarTersedia',
            'chartLabels',
            'chartData',
            'kostPopuler',
            'tahun',
            'daftarTahun',
            'bulanTerlaris',
            'rataBooking',
            'performa',
            'pendapatanBulanIni',
            'pendapatanBulanLalu'
        ));
    }

    public function exportExcel(Request $request)
    {
        $tahun = $request->tahun;
        return response()->download(storage_path('app/public/contoh.xlsx'));
    }
}