<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Kost;
use App\Models\KostImage;
use App\Models\KostFacility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KostController extends Controller
{
    // =========================
    // LIST DATA KOST
    // =========================
    public function index()
    {
        $kosts = Kost::where('owner_id', auth()->id())
            ->with(['rooms', 'images', 'reviews'])
            ->latest()
            ->get();

        return view('owner.kost', compact('kosts'));
    }

    // =========================
    // FORM TAMBAH
    // =========================
    public function create()
    {
        return view('owner.kost-create');
    }

    // =========================
    // SIMPAN DATA
    // =========================
    public function store(Request $request)
    {
        $request->validate([
            'nama_kost'   => 'required|string|max:255',
            'kota'        => 'required|string|max:100',
            'tipe_kost'   => 'required|string|max:50',
            'alamat'      => 'required|string',
            'deskripsi'   => 'nullable|string',

            'harga_mulai'         => 'required|numeric|min:0',
            'harga_sampai'        => 'nullable|numeric|min:0',
            'ada_harian'          => 'nullable|boolean',
            'harga_harian_mulai'  => 'nullable|numeric|min:0',
            'harga_harian_sampai' => 'nullable|numeric|min:0',

            'status'      => 'required|string',
            'latitude'    => 'nullable|string',
            'longitude'   => 'nullable|string',

            'foto_kost'           => 'nullable|array|max:6',
            'foto_kost.*'         => 'image|mimes:jpg,jpeg,png,webp|max:2048',
            'foto_kost_nama'      => 'nullable|array',
            'foto_kost_nama.*'    => 'nullable|string|max:100',
            'facility_photo'      => 'nullable|array',
            'facility_photo.*'    => 'image|mimes:jpg,jpeg,png,webp|max:2048',
            'facility_name'       => 'nullable|array',
            'facility_name.*'     => 'nullable|string|max:100',
        ]);

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
            'harga_sampai'        => $request->harga_sampai ?: null,
            'ada_harian'          => $request->boolean('ada_harian'),
            'harga_harian_mulai'  => $request->ada_harian ? $request->harga_harian_mulai  : null,
            'harga_harian_sampai' => $request->ada_harian ? $request->harga_harian_sampai : null,

            'latitude'    => $request->latitude,
            'longitude'   => $request->longitude,
            'status'      => $request->status,
        ]);

        if ($request->hasFile('foto_kost')) {
            $foto_utama   = null;
            $namaFoto     = $request->input('foto_kost_nama', []);
            foreach ($request->file('foto_kost') as $index => $file) {
                $path = $file->store('kost', 'public');
                if ($index === 0) $foto_utama = $path;
                KostImage::create([
                    'kost_id'    => $kost->id_kost,
                    'image_path' => $path,
                    'sort_order' => $index,
                    'kategori'   => $namaFoto[$index] ?? null,
                ]);
            }
            $kost->update(['foto_utama' => $foto_utama]);
        }

        // ✅ Simpan foto fasilitas umum
        if ($request->hasFile('facility_photo')) {
            $facilityNames  = $request->input('facility_name', []);
            foreach ($request->file('facility_photo') as $index => $file) {
                $path = $file->store('kost/fasilitas', 'public');
                KostFacility::create([
                    'kost_id' => $kost->id_kost,
                    'nama'    => $facilityNames[$index] ?? 'Fasilitas ' . ($index + 1),
                    'foto'    => $path,
                ]);
            }
        }

        return redirect()->route('owner.kost.index')
            ->with('success', 'Data kost berhasil ditambahkan!');
    }

    // =========================
    // DETAIL
    // =========================
    public function show(Kost $kost)
    {
        abort_if($kost->owner_id !== auth()->id(), 403);

        // ✅ Load rooms + images sekaligus
        $kost->load(['rooms.images', 'images', 'generalFacilities']);

        // ✅ Parse fasilitas supaya selalu array
        if (!empty($kost->fasilitas)) {
            if (is_string($kost->fasilitas)) {
                $decoded = json_decode($kost->fasilitas, true);
                $kost->fasilitas = is_array($decoded)
                    ? $decoded
                    : array_values(array_filter(array_map('trim', explode(',', $kost->fasilitas))));
            }
        } else {
            $kost->fasilitas = [];
        }

        // ✅ Foto utama URL helper
        if ($kost->images->isNotEmpty()) {
            $kost->foto_utama_url = asset('storage/' . $kost->images->first()->image_path);
        } else {
            $kost->foto_utama_url = null;
        }

        return view('owner.kost-show', compact('kost'));
    }

    // =========================
    // FORM EDIT
    // =========================
    public function edit(Kost $kost)
    {
        abort_if($kost->owner_id !== auth()->id(), 403);

        $kost->load(['images', 'generalFacilities']);

        // Parse fasilitas
        if (!empty($kost->fasilitas) && is_string($kost->fasilitas)) {
            $decoded = json_decode($kost->fasilitas, true);
            $kost->fasilitas = is_array($decoded)
                ? $decoded
                : array_values(array_filter(array_map('trim', explode(',', $kost->fasilitas))));
        } else {
            $kost->fasilitas = $kost->fasilitas ?? [];
        }

        return view('owner.kost-edit', compact('kost'));
    }

    // =========================
    // UPDATE
    // =========================
    public function update(Request $request, Kost $kost)
    {
        abort_if($kost->owner_id !== auth()->id(), 403);

        $request->validate([
            'nama_kost'   => 'required|string|max:255',
            'alamat'      => 'required|string',
            'kota'        => 'required|string|max:100',
            'tipe_kost'   => 'required|in:Putra,Putri,Campur',
            'deskripsi'   => 'nullable|string',
            'fasilitas'   => 'nullable|array',
            'aturan'      => 'nullable|string',

            'harga_mulai'         => 'required|numeric|min:0',
            'harga_sampai'        => 'nullable|numeric|min:0',
            'ada_harian'          => 'nullable|boolean',
            'harga_harian_mulai'  => 'nullable|numeric|min:0',
            'harga_harian_sampai' => 'nullable|numeric|min:0',

            'latitude'    => 'nullable|string',
            'longitude'   => 'nullable|string',
            'status'      => 'nullable|in:aktif,nonaktif',

            'foto_kost'           => 'nullable|array|max:6',
            'foto_kost.*'         => 'image|mimes:jpg,jpeg,png,webp|max:2048',
            'foto_kost_nama'      => 'nullable|array',
            'foto_kost_nama.*'    => 'nullable|string|max:100',
            'new_facility_photo'  => 'nullable|array',
            'new_facility_photo.*'=> 'image|mimes:jpg,jpeg,png,webp|max:2048',
            'new_facility_name'   => 'nullable|array',
            'new_facility_name.*' => 'nullable|string|max:100',
            'hapus_fasilitas'     => 'nullable|array',
            'hapus_fasilitas.*'   => 'integer',
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
            'harga_sampai'        => $request->harga_sampai ?: null,
            'ada_harian'          => $request->boolean('ada_harian'),
            'harga_harian_mulai'  => $request->ada_harian ? $request->harga_harian_mulai  : null,
            'harga_harian_sampai' => $request->ada_harian ? $request->harga_harian_sampai : null,

            'latitude'    => $request->latitude,
            'longitude'   => $request->longitude,
            'status'      => $request->status ?? $kost->status,
        ]);

        // ✅ Update label untuk foto yang sudah ada
        if ($request->filled('existing_foto_nama')) {
            foreach ($request->existing_foto_nama as $id => $nama) {
                KostImage::where('id', $id)->update(['kategori' => $nama]);
            }
        }

        // ✅ Upload foto baru (Jika ada file baru diupload, ini akan mengganti semua foto lama sesuai logic aslimu)
        // Note: Sebaiknya ke depan ini diubah ke sistem append, tapi kita ikuti flow aslimu dulu.
        if ($request->hasFile('foto_kost')) {
            foreach ($kost->images as $img) {
                if ($img->image_path && Storage::disk('public')->exists($img->image_path)) {
                    Storage::disk('public')->delete($img->image_path);
                }
            }
            $kost->images()->delete();

            $foto_utama = null;
            $namaFoto   = $request->input('foto_kost_nama', []);
            foreach ($request->file('foto_kost') as $index => $file) {
                $path = $file->store('kost', 'public');
                if ($index === 0) $foto_utama = $path;
                KostImage::create([
                    'kost_id'    => $kost->id_kost,
                    'image_path' => $path,
                    'sort_order' => $index,
                    'kategori'   => $namaFoto[$index] ?? null,
                ]);
            }
            $kost->update(['foto_utama' => $foto_utama]);
        }

        // ✅ Hapus fasilitas yang ditandai dihapus
        if ($request->filled('hapus_fasilitas')) {
            $toDelete = KostFacility::where('kost_id', $kost->id_kost)
                ->whereIn('id', $request->hapus_fasilitas)
                ->get();
            foreach ($toDelete as $fac) {
                if ($fac->foto && Storage::disk('public')->exists($fac->foto)) {
                    Storage::disk('public')->delete($fac->foto);
                }
                $fac->delete();
            }
        }

        // ✅ Tambah foto fasilitas baru
        if ($request->hasFile('new_facility_photo')) {
            $newFacilityNames = $request->input('new_facility_name', []);
            foreach ($request->file('new_facility_photo') as $index => $file) {
                $path = $file->store('kost/fasilitas', 'public');
                KostFacility::create([
                    'kost_id' => $kost->id_kost,
                    'nama'    => $newFacilityNames[$index] ?? 'Fasilitas ' . ($index + 1),
                    'foto'    => $path,
                ]);
            }
        }

        return redirect()->route('owner.kost.show', $kost->id_kost)
            ->with('success', 'Kost berhasil diupdate!');
    }

    // =========================
    // ✅ HAPUS FOTO INDIVIDUAL
    // Route: DELETE /owner/kost/{kost}/image/{image}
    // =========================
    public function destroyImage(Kost $kost, KostImage $image)
    {
        abort_if($kost->owner_id !== auth()->id(), 403);

        // Pastikan foto ini milik kost ini
        abort_if($image->kost_id !== $kost->id_kost, 403);

        // Hapus file dari storage
        if ($image->image_path && Storage::disk('public')->exists($image->image_path)) {
            Storage::disk('public')->delete($image->image_path);
        }

        $image->delete();

        // Kalau foto yang dihapus adalah cover → set cover ke foto pertama yang tersisa
        $kost->load('images');
        if ($kost->images->isNotEmpty()) {
            $kost->update([
                'foto_utama' => $kost->images->first()->image_path
            ]);
        } else {
            $kost->update(['foto_utama' => null]);
        }

        // Kembalikan JSON (dipanggil via AJAX) atau redirect biasa
        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Foto berhasil dihapus.',
                'remaining' => $kost->images->count(),
            ]);
        }

        return back()->with('success', 'Foto berhasil dihapus.');
    }

    // =========================
    // DELETE KOST
    // =========================
    public function destroy(Kost $kost)
    {
        abort_if($kost->owner_id !== auth()->id(), 403);

        foreach ($kost->images as $img) {
            if ($img->image_path && Storage::disk('public')->exists($img->image_path)) {
                Storage::disk('public')->delete($img->image_path);
            }
        }

        // Hapus foto fasilitas
        foreach ($kost->generalFacilities as $fac) {
            if ($fac->foto && Storage::disk('public')->exists($fac->foto)) {
                Storage::disk('public')->delete($fac->foto);
            }
        }

        if ($kost->foto_utama && Storage::disk('public')->exists($kost->foto_utama)) {
            Storage::disk('public')->delete($kost->foto_utama);
        }

        $kost->delete();

        return redirect()->route('owner.kost.index')
            ->with('success', 'Kost berhasil dihapus!');
    }

    // =========================
    // HAPUS FOTO FASILITAS
    // Route: DELETE /owner/kost/{kost}/facility/{facility}
    // =========================
    public function destroyFacility(Kost $kost, KostFacility $facility)
    {
        abort_if($kost->owner_id !== auth()->id(), 403);
        abort_if($facility->kost_id !== $kost->id_kost, 403);

        if ($facility->foto && Storage::disk('public')->exists($facility->foto)) {
            Storage::disk('public')->delete($facility->foto);
        }

        $facility->delete();

        return response()->json([
            'success' => true,
            'message' => 'Foto fasilitas berhasil dihapus.',
        ]);
    }
}