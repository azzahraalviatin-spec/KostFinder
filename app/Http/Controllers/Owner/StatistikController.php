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

        // Tahun filter (default tahun ini)
        $tahun       = $request->get('tahun', Carbon::now()->year);
        $daftarTahun = range(Carbon::now()->year, 2023); // dari tahun ini sampai 2023

        // Total pendapatan (berdasarkan tahun filter)
        $totalPendapatan = Booking::whereHas('room.kost', function($q) use ($owner_id) {
            $q->where('owner_id', $owner_id);
        })->whereIn('status_booking', ['diterima', 'selesai'])
          ->whereYear('created_at', $tahun)
          ->with('room')
          ->get()
          ->sum(fn($b) => ($b->room->harga ?? 0) * $b->durasi_sewa);

        // Total booking (berdasarkan tahun filter)
        $totalBooking = Booking::whereHas('room.kost', function($q) use ($owner_id) {
            $q->where('owner_id', $owner_id);
        })->whereYear('created_at', $tahun)->count();

        // Kamar terisi vs tersedia (realtime, tidak filter tahun)
        $kamarTerisi   = Room::whereHas('kost', fn($q) => $q->where('owner_id', $owner_id))->where('status_kamar', 'terisi')->count();
        $kamarTersedia = Room::whereHas('kost', fn($q) => $q->where('owner_id', $owner_id))->where('status_kamar', 'tersedia')->count();

        // Grafik 12 bulan dalam tahun filter
        $chartLabels = [];
        $chartData   = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartLabels[] = Carbon::create($tahun, $i, 1)->translatedFormat('M');
            $chartData[]   = Booking::whereHas('room.kost', function($q) use ($owner_id) {
                $q->where('owner_id', $owner_id);
            })->whereYear('created_at', $tahun)
              ->whereMonth('created_at', $i)
              ->count();
        }

        // Kost paling banyak dipesan
        $kostPopuler = Kost::where('owner_id', $owner_id)
            ->withCount(['rooms as total_booking' => fn($q) => $q->whereHas('bookings', function($b) use ($tahun) {
                $b->whereYear('created_at', $tahun);
            })])
            ->orderByDesc('total_booking')
            ->get();

        return view('owner.Statistik', compact(
            'totalPendapatan', 'totalBooking', 'kamarTerisi',
            'kamarTersedia', 'chartLabels', 'chartData', 'kostPopuler',
            'tahun', 'daftarTahun'
        ));
    }
    public function exportExcel(Request $request)
{
    $tahun = $request->tahun;

    // sementara dummy dulu biar gak error
    return response()->download(storage_path('app/public/contoh.xlsx'));
}

}