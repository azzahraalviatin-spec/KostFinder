<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PromoController extends Controller
{
    public function index()
    {
        $promos = Promo::orderBy('urutan')->latest()->get();
        return view('admin.promos', compact('promos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'           => 'required|string|max:150',
            'gambar'          => 'required|image|mimes:jpg,jpeg,png,webp|max:3048',
            'status'          => 'required|in:aktif,nonaktif',
            'tanggal_mulai'   => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'urutan'          => 'nullable|integer|min:0',
        ]);

        $path = $request->file('gambar')->store('promos', 'public');

        Promo::create([
            'judul'           => $request->judul,
            'gambar'          => $path,
            'status'          => $request->status,
            'tanggal_mulai'   => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'urutan'          => $request->urutan ?? 0,
        ]);

        return back()->with('status', '✅ Promo berhasil ditambahkan!');
    }

    public function update(Request $request, Promo $promo)
    {
        $request->validate([
            'judul'           => 'required|string|max:150',
            'gambar'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3048',
            'status'          => 'required|in:aktif,nonaktif',
            'tanggal_mulai'   => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'urutan'          => 'nullable|integer|min:0',
        ]);

        if ($request->hasFile('gambar')) {
            if ($promo->gambar) Storage::disk('public')->delete($promo->gambar);
            $promo->gambar = $request->file('gambar')->store('promos', 'public');
        }

        $promo->judul           = $request->judul;
        $promo->status          = $request->status;
        $promo->tanggal_mulai   = $request->tanggal_mulai;
        $promo->tanggal_selesai = $request->tanggal_selesai;
        $promo->urutan          = $request->urutan ?? 0;
        $promo->save();

        return back()->with('status', '✅ Promo berhasil diupdate!');
    }

    public function destroy(Promo $promo)
    {
        if ($promo->gambar) Storage::disk('public')->delete($promo->gambar);
        $promo->delete();
        return back()->with('status', '🗑️ Promo berhasil dihapus!');
    }

    public function toggleStatus(Promo $promo)
    {
        $promo->status = $promo->status === 'aktif' ? 'nonaktif' : 'aktif';
        $promo->save();
        return back()->with('status', 'Status promo diperbarui!');
    }
}