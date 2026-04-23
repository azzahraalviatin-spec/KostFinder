<?php

namespace App\Http\Controllers;

use App\Models\Kost;
use App\Models\Room;
use App\Models\Review;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // ── Base query: kost aktif & owner terverifikasi ──
        $publishedQuery = Kost::query()
            ->where('status', 'aktif')
            ->whereHas('owner', function ($q) {
                $q->where('status_verifikasi_identitas', 'disetujui');
            });

        // ── Filter dari request ──
        $filters = [
            'q'               => trim((string) $request->string('q')),
            'city'            => trim((string) $request->string('city')),
            'type'            => trim((string) $request->string('type')),
            'max_price'       => $request->integer('max_price'),
            'location_mode'   => trim((string) $request->string('location_mode', 'daerah')),
            'location_detail' => trim((string) $request->string('location_detail')),
            'sewa' => trim((string) $request->string('sewa')),
            'facilities'      => array_filter(array_map('trim', explode(',', (string) $request->string('facilities')))),
        ];

        // ── Query utama kost — hanya kolom yang dibutuhkan ──
        $kostQuery = (clone $publishedQuery)
            ->select([
                'id_kost', 'nama_kost', 'alamat', 'kota',
                'tipe_kost', 'harga_mulai', 'fasilitas',
                'deskripsi', 'foto_utama', 'status', 'owner_id',
            ])
            // Hanya ambil kolom penting dari rooms (BUKAN semua kolom)
            ->with(['rooms' => function ($q) {
                $q->select('id_room', 'kost_id', 'harga_per_bulan', 'harga_harian', 'aktif_bulanan', 'aktif_harian', 'status_kamar', 'fasilitas');
            }])
            ->withCount('rooms')
            ->withAvg('reviews', 'rating')   // rata-rata rating — dihitung di DB, tidak load semua review
            ->withCount('reviews');           // jumlah review — dihitung di DB

        // ── Filter keyword pencarian ──
        if ($filters['q'] !== '') {
            $search = $filters['q'];
            $kostQuery->where(function ($q) use ($search) {
                $q->where('nama_kost', 'like', "%{$search}%")
                  ->orWhere('alamat',    'like', "%{$search}%")
                  ->orWhere('kota',      'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        // ── Filter kota ──
        if ($filters['city'] !== '') {
            $kostQuery->where('kota', $filters['city']);
        }

        // ── Filter tipe kost ──
        if (in_array($filters['type'], ['Putra', 'Putri', 'Campur'], true)) {
            $kostQuery->where('tipe_kost', $filters['type']);
        }

        // ── Filter harga maksimal ──
        if (!empty($filters['max_price'])) {
            $maxPrice = $filters['max_price'];
            $kostQuery->where(function ($q) use ($maxPrice) {
                $q->where('harga_mulai', '<=', $maxPrice)
                  ->orWhereHas('rooms', function ($rq) use ($maxPrice) {
                      $rq->where('harga_per_bulan', '<=', $maxPrice);
                  });
            });
        }

        // ── Filter lokasi detail ──
        if ($filters['location_detail'] !== '') {
            $location = $filters['location_detail'];
            $kostQuery->where(function ($q) use ($location) {
                $q->where('kota',      'like', "%{$location}%")
                  ->orWhere('alamat',  'like', "%{$location}%")
                  ->orWhere('deskripsi','like', "%{$location}%");
            });
        }

        // ── Filter fasilitas ──
        if (!empty($filters['facilities'])) {
            foreach ($filters['facilities'] as $facility) {
                $kostQuery->where(function ($q) use ($facility) {
                    $q->where('fasilitas', 'like', "%{$facility}%")
                      ->orWhere('deskripsi','like', "%{$facility}%");
                });
            }
        }

        // ── Hasil akhir dengan pagination ──
        $kosts = $kostQuery->latest()->paginate(9)->withQueryString();

        // ── Statistik — query ringan langsung ke DB ──
        $stats = [
            'total_kost'  => (clone $publishedQuery)->count(),
            'total_kota'  => (clone $publishedQuery)->distinct('kota')->count('kota'),
            'total_kamar' => DB::table('rooms')->count(),
            'avg_rating'  => round(Review::avg('rating') ?? 0, 1),
        ];

        // ── Opsi kota untuk dropdown filter ──
        $cityOptions = (clone $publishedQuery)
            ->select('kota')
            ->distinct()
            ->orderBy('kota')
            ->pluck('kota');

        // ── Kota unggulan (section kota populer) ──
        $featuredCities = (clone $publishedQuery)
            ->selectRaw('kota, COUNT(*) as total')
            ->groupBy('kota')
            ->orderByDesc('total')
            ->limit(9)
            ->get();

        // ── Jumlah kost per kota — 1 query untuk semua kota sekaligus ──
        // Ini menggantikan query di dalam @foreach di blade (yang tadinya 9x query)
        $jumlahPerKota = Kost::where('status', 'aktif')
            ->selectRaw('LOWER(kota) as kota_lower, COUNT(*) as total')
            ->groupBy('kota_lower')
            ->pluck('total', 'kota_lower');

        // ── Favorit user — 1 query untuk semua kost sekaligus ──
        // Ini menggantikan query di dalam @foreach di blade (yang tadinya N x query)
        $favoritIds = Auth::check()
            ? Favorite::where('user_id', Auth::id())
                ->pluck('kost_id')
                ->toArray()
            : [];

// ── Query kamar untuk section rekomendasi (per kamar) ──
$rooms = Room::query()
    ->whereHas('kost', function ($q) {
        $q->where('status', 'aktif')
          ->whereHas('owner', function ($q2) {
              $q2->where('status_verifikasi_identitas', 'disetujui');
          });
    })

    ->with([
        'mainImage',
        'kost' => function($q) {
            $q->select('id_kost','nama_kost','alamat','kota','tipe_kost','foto_utama')
              ->withAvg('reviews','rating');
        },
    ])

    ->where('status_kamar', 'tersedia')

    // ✅ PINDAH KE SINI (SETELAH STATUS)
    ->when($filters['sewa'] === 'harian', function ($q) {
        $q->where('aktif_harian', 1)
          ->whereNotNull('harga_harian');
    })
    ->when($filters['sewa'] === 'bulanan', function ($q) {
        $q->where('aktif_bulanan', 1)
          ->whereNotNull('harga_per_bulan');
    })

    ->latest()
    ->limit(12)
    ->get();
        // ── Data gambar kota ──
        $kotaList = [
            'surabaya'   => [
                'label'    => 'Kos Surabaya',
                'img'      => asset('images/kota/surabaya.jpg'),
                'fallback' => 'https://images.unsplash.com/photo-1555899434-94d1368aa7af?w=800&q=80&fit=crop',
            ],
            'malang'     => [
                'label'    => 'Kos Malang',
                'img'      => asset('images/kota/malang.jpg'),
                'fallback' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800&q=80&fit=crop',
            ],
            'sidoarjo'   => [
                'label'    => 'Kos Sidoarjo',
                'img'      => asset('images/kota/sidoarjo.jpg'),
                'fallback' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=800&q=80&fit=crop',
            ],
            'jember'     => [
                'label'    => 'Kos Jember',
                'img'      => asset('images/kota/jember.jpg'),
                'fallback' => 'https://images.unsplash.com/photo-1500534314209-a25ddb2bd429?w=800&q=80&fit=crop',
            ],
            'gresik'     => [
                'label'    => 'Kos Gresik',
                'img'      => asset('images/kota/gresik.jpg'),
                'fallback' => 'https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?w=800&q=80&fit=crop',
            ],
            'kediri'     => [
                'label'    => 'Kos Kediri',
                'img'      => asset('images/kota/kediri.jpg'),
                'fallback' => 'https://images.unsplash.com/photo-1448375240586-882707db888b?w=800&q=80&fit=crop',
            ],
            'banyuwangi' => [
                'label'    => 'Kos Banyuwangi',
                'img'      => asset('images/kota/banyuwangi.jpg'),
                'fallback' => 'https://images.unsplash.com/photo-1518509562904-e7ef99cdcc86?w=800&q=80&fit=crop',
            ],
            'mojokerto'  => [
                'label'    => 'Kos Mojokerto',
                'img'      => asset('images/kota/mojokerto.jpg'),
                'fallback' => 'https://images.unsplash.com/photo-1470770903676-69b98201ea1c?w=800&q=80&fit=crop',
            ],
            'pasuruan'   => [
                'label'    => 'Kos Pasuruan',
                'img'      => asset('images/kota/pasuruan.jpg'),
                'fallback' => 'https://images.unsplash.com/photo-1501854140801-50d01698950b?w=800&q=80&fit=crop',
            ],
        ];

        return view('welcome', compact(
            'kosts',
            'filters',
            'stats',
            'rooms',
            'cityOptions',
            'featuredCities',
            'kotaList',
            'jumlahPerKota',  // ✅ fix: query kota 1x saja
            'favoritIds'      // ✅ fix: query favorit 1x saja
        ));
    }
}   