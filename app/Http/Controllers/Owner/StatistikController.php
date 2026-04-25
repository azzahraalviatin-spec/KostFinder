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
        // Pakai field pendapatan_owner yang sudah ada di tabel,
        // filter status 'diterima' (status selesai di migration hanya diterima/ditolak)
        $totalPendapatan = Booking::whereHas('room.kost', function ($q) use ($owner_id) {
                $q->where('owner_id', $owner_id);
            })
            ->where('status_booking', 'diterima')
            ->whereYear('created_at', $tahun)
            ->sum('pendapatan_owner'); // pakai kolom langsung, lebih akurat

        // Fallback: kalau pendapatan_owner kosong semua, hitung dari harga kamar × durasi
        if ($totalPendapatan == 0) {
            $totalPendapatan = Booking::whereHas('room.kost', function ($q) use ($owner_id) {
                    $q->where('owner_id', $owner_id);
                })
                ->where('status_booking', 'diterima')
                ->whereYear('created_at', $tahun)
                ->with('room')
                ->get()
                ->sum(fn($b) => ($b->total_harga ?? ($b->room->harga ?? 0) * $b->durasi_sewa));
        }

        // ── TOTAL BOOKING ──
        $totalBooking = Booking::whereHas('room.kost', function ($q) use ($owner_id) {
                $q->where('owner_id', $owner_id);
            })
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
            $chartData[]   = Booking::whereHas('room.kost', function ($q) use ($owner_id) {
                    $q->where('owner_id', $owner_id);
                })
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

        // ── STAT BULAN INI (untuk dashboard card) ──
        $bulanIni            = Carbon::now()->month;
        $pendapatanBulanIni  = Booking::whereHas('room.kost', function ($q) use ($owner_id) {
                $q->where('owner_id', $owner_id);
            })
            ->where('status_booking', 'diterima')
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', $bulanIni)
            ->sum('pendapatan_owner');

        if ($pendapatanBulanIni == 0) {
            $pendapatanBulanIni = Booking::whereHas('room.kost', function ($q) use ($owner_id) {
                    $q->where('owner_id', $owner_id);
                })
                ->where('status_booking', 'diterima')
                ->whereYear('created_at', Carbon::now()->year)
                ->whereMonth('created_at', $bulanIni)
                ->with('room')
                ->get()
                ->sum(fn($b) => $b->total_harga ?? ($b->room->harga ?? 0) * $b->durasi_sewa);
        }

        $pendapatanBulanLalu = Booking::whereHas('room.kost', function ($q) use ($owner_id) {
                $q->where('owner_id', $owner_id);
            })
            ->where('status_booking', 'diterima')
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', $bulanIni - 1 < 1 ? 12 : $bulanIni - 1)
            ->with('room')
            ->get()
            ->sum(fn($b) => $b->total_harga ?? ($b->room->harga ?? 0) * $b->durasi_sewa);

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