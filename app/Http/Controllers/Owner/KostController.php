<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Kost;
use App\Models\KostImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KostController extends Controller
{
    public function index()
    {
        $kosts = Kost::where('owner_id', auth()->id())
            ->with(['rooms', 'images'])
            ->latest()
            ->get();
            

        return view('owner.kost', compact('kosts'));
    }

    public function create()
    {
        return view('owner.kost-create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kost'   => 'required|string|max:255',
            'kota'        => 'required|string|max:100',
            'tipe_kost'   => 'required|string|max:50',
            'alamat'      => 'required|string',
            'deskripsi'   => 'nullable|string',
            'harga_mulai'         => 'nullable|numeric|min:0',
'harga_sampai'        => 'nullable|numeric|min:0',
'ada_harian'          => 'nullable|boolean',
'harga_harian_mulai'  => 'nullable|numeric|min:0',
'harga_harian_sampai' => 'nullable|numeric|min:0',
            'status'      => 'required|string',
            'latitude'    => 'nullable|string',
            'longitude'   => 'nullable|string',
            'foto_kost'   => 'nullable|array|max:6',
'foto_kost.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048', 
        ]);

        $foto_utama = null;

        $kost = Kost::create([
            'owner_id'    => auth()->id(),
            'nama_kost'   => $request->nama_kost,
            'alamat'      => $request->alamat,
            'kota'        => $request->kota,
            'tipe_kost'   => $request->tipe_kost,
            'deskripsi'   => $request->deskripsi,
            'fasilitas'   => $request->fasilitas ? json_encode($request->fasilitas) : null,
            'aturan'      => $request->aturan,
           'harga_mulai'         => $request->harga_mulai,
'harga_sampai'        => $request->harga_sampai,
'ada_harian'          => $request->boolean('ada_harian'),
'harga_harian_mulai'  => $request->ada_harian ? $request->harga_harian_mulai : null,
'harga_harian_sampai' => $request->ada_harian ? $request->harga_harian_sampai : null,
            'latitude'    => $request->latitude,
            'longitude'   => $request->longitude,
            'status'      => $request->status,
        ]);

        if ($request->hasFile('foto_kost')) {
            foreach ($request->file('foto_kost') as $index => $file) {
                $path = $file->store('kost', 'public');

                if ($index === 0) {
                    $foto_utama = $path;
                }

                KostImage::create([
                    'kost_id'    => $kost->id_kost,
                    'image_path' => $path,
                    'sort_order' => $index,
                ]);
            }

            $kost->update([
                'foto_utama' => $foto_utama
            ]);
        }

        return redirect()->route('owner.kost.index')
            ->with('success', 'Data kost berhasil ditambahkan!');
    }

    public function show(Kost $kost)
    {
        abort_if($kost->owner_id !== auth()->id(), 403);

        $kost->load(['rooms', 'images']);

        return view('owner.kost-show', compact('kost'));
    }

    public function edit(Kost $kost)
    {
        abort_if($kost->owner_id !== auth()->id(), 403);

        $kost->load('images');

        return view('owner.kost-edit', compact('kost'));
    }

    public function update(Request $request, Kost $kost)
    {
        abort_if($kost->owner_id !== auth()->id(), 403);

        $request->validate([
            'nama_kost'   => 'required|string|max:150',
            'alamat'      => 'required|string',
            'kota'        => 'required|string|max:100',
            'tipe_kost'   => 'required|in:Putra,Putri,Campur',
            'deskripsi'   => 'nullable|string',
            'fasilitas'   => 'nullable|array',
            'aturan'      => 'nullable|string',
            'harga_mulai'         => 'nullable|numeric|min:0',
'harga_sampai'        => 'nullable|numeric|min:0',
'ada_harian'          => 'nullable|boolean',
'harga_harian_mulai'  => 'nullable|numeric|min:0',
'harga_harian_sampai' => 'nullable|numeric|min:0',
            'latitude'    => 'nullable|numeric',
            'longitude'   => 'nullable|numeric',
            'status'      => 'nullable|in:aktif,nonaktif',
'foto_kost'   => 'nullable|array|max:6',
'foto_kost.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $kost->update([
            'nama_kost'   => $request->nama_kost,
            'alamat'      => $request->alamat,
            'kota'        => $request->kota,
            'tipe_kost'   => $request->tipe_kost,
            'deskripsi'   => $request->deskripsi,
            'fasilitas'   => $request->fasilitas ? json_encode($request->fasilitas) : null,
            'aturan'      => $request->aturan,
           'harga_mulai'         => $request->harga_mulai,
'harga_sampai'        => $request->harga_sampai,
'ada_harian'          => $request->boolean('ada_harian'),
'harga_harian_mulai'  => $request->ada_harian ? $request->harga_harian_mulai : null,
'harga_harian_sampai' => $request->ada_harian ? $request->harga_harian_sampai : null,
            'latitude'    => $request->latitude,
            'longitude'   => $request->longitude,
            'status'      => $request->status ?? $kost->status,
        ]);

        if ($request->hasFile('foto_kost')) {
            foreach ($kost->images as $img) {
                if ($img->image_path && Storage::disk('public')->exists($img->image_path)) {
                    Storage::disk('public')->delete($img->image_path);
                }
            }

            $kost->images()->delete();

            $fotoUtamaBaru = null;

            foreach ($request->file('foto_kost') as $index => $file) {
                $path = $file->store('kost', 'public');

                if ($index === 0) {
                    $fotoUtamaBaru = $path;
                }

                KostImage::create([
                    'kost_id'    => $kost->id_kost,
                    'image_path' => $path,
                    'sort_order' => $index,
                ]);
            }

            $kost->update([
                'foto_utama' => $fotoUtamaBaru
            ]);
        }

        return redirect()->route('owner.kost.index')
            ->with('success', 'Kost berhasil diupdate!');
    }

    public function destroy(Kost $kost)
    {
        abort_if($kost->owner_id !== auth()->id(), 403);

        foreach ($kost->images as $img) {
            if ($img->image_path && Storage::disk('public')->exists($img->image_path)) {
                Storage::disk('public')->delete($img->image_path);
            }
        }

        if ($kost->foto_utama && Storage::disk('public')->exists($kost->foto_utama)) {
            Storage::disk('public')->delete($kost->foto_utama);
        }

        $kost->delete();

        return redirect()->route('owner.kost.index')
            ->with('success', 'Kost berhasil dihapus!');
    }
}