<?php

namespace App\Http\Controllers;

use App\Models\Kost;
use Illuminate\Http\Request;

class KosController extends Controller
{
    public function cari(Request $request)
    {
        $query = Kost::where('status', 'aktif')
            ->withCount(['rooms as kamar_tersedia' => function($q) {
                $q->where('status_kamar', 'tersedia');
            }])
            ->withCount(['rooms as kamar_total'])
            ->withAvg('reviews', 'rating')
            ->withCount('reviews');

        // Filter keyword pencarian
        if ($request->q) {
            $query->where(function($q) use ($request) {
                $q->where('nama_kost', 'like', '%' . $request->q . '%')
                  ->orWhere('kota',    'like', '%' . $request->q . '%')
                  ->orWhere('alamat',  'like', '%' . $request->q . '%');
            });
        }

        // Filter kota (dari klik kota populer di landing page)
        if ($request->kota) {
            $query->where('kota', 'like', '%' . $request->kota . '%');
        }

        // Filter tipe
        if ($request->filled('tipe')) {
            $query->where('tipe_kost', $request->tipe);
        }
        

        // Filter harga
        if ($request->harga_min) {
            $query->where('harga_mulai', '>=', $request->harga_min);
        }
        if ($request->harga_max) {
            $query->where('harga_mulai', '<=', $request->harga_max);
        }

        if ($request->fasilitas) {
            $query->where(function($q) use ($request) {
                foreach ($request->fasilitas as $f) {
                    $q->orWhere('fasilitas', 'like', '%' . $f . '%');
                }
            });
        }
        

// FILTER ATURAN
if ($request->aturan) {
    $query->where(function($q) use ($request) {
        foreach ($request->aturan as $a) {
            $q->orWhere('aturan', 'like', '%' . $a . '%');
        }
    });
}



        // Filter durasi harian
        if ($request->durasi === 'Harian') {
            $query->where('ada_harian', 1);
        }

        // Filter hanya yang ada kamar tersedia
        if ($request->kamar) {
            $query->whereHas('rooms', function($q) {
                $q->where('status_kamar', 'tersedia');
            });
        }

        $kosts = $query->latest()->paginate(12)->withQueryString();

        $kostsMap = $kosts->map(function ($k) {
            return [
                'id'     => $k->id_kost,
                'nama'   => $k->nama_kost,
                'alamat' => $k->alamat,
                'kota'   => $k->kota,
                'harga'  => $k->harga_mulai,
                'lat'    => $k->latitude  ?? null,
                'lng'    => $k->longitude ?? null,
                'url'    => route('kost.show', $k->id_kost),
                'foto'   => $k->foto_utama ? asset('storage/' . $k->foto_utama) : null,
            ];
        });

        return view('cari-kost', compact('kosts', 'kostsMap'));
    }


}
