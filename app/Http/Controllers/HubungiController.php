<?php
// FILE: app/Http/Controllers/HubungiController.php

namespace App\Http\Controllers;
use App\Models\Kost;
use Illuminate\Http\Request;

class HubungiController extends Controller
{
    public function index()
    {
        // Ambil 4 kos terbaru yang statusnya tersedia
        $kosts = \App\Models\Kost::where('status', 'tersedia')->latest()->take(4)->get();
        
        return view('hubungi', compact('kosts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'  => 'required|string|max:100',
            'email' => 'required|email',
            'pesan' => 'required|string',
        ]);

        // Simpan ke DB (buat model Kontak dulu jika perlu):
        // \App\Models\Kontak::create($request->only(['nama','email','no_hp','topik','sumber','pernah_app','pesan']));

        return back()->with('success', 'Pesan kamu sudah terkirim! Tim KostFinder akan menghubungimu segera. 🎉');
    }
}

// ── TAMBAHKAN DI routes/web.php ──
// Route::get('/hubungi-kami', [\App\Http\Controllers\HubungiController::class, 'index'])->name('hubungi.kami');
// Route::post('/hubungi-kami', [\App\Http\Controllers\HubungiController::class, 'store'])->name('hubungi.store');