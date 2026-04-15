<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Kost;
use App\Models\Room;
use App\Models\RoomImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KamarController extends Controller
{
    public function index()
    {
        $rooms = Room::with(['kost', 'mainImage'])
            ->whereHas('kost', fn ($q) => $q->where('owner_id', auth()->id()))
            ->latest()
            ->get();

        return view('owner.kamar', compact('rooms'));
    }

    public function create()
    {
        $kosts = Kost::where('owner_id', auth()->id())
            ->orderBy('nama_kost')
            ->get();

        return view('owner.kamar-create', compact('kosts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kost_id'         => 'required|exists:kosts,id_kost',
            'nomor_kamar'     => 'required|string|max:50',
            'harga_per_bulan' => 'nullable|integer|min:0',
            'harga_harian'    => 'nullable|integer|min:0',
            'status_kamar'    => 'required|in:tersedia,terisi',
            'tipe_kamar'      => 'nullable|string',
            'ukuran'          => 'nullable|string|max:50',
            'deskripsi'       => 'nullable|string',
            'fasilitas'       => 'nullable|array',
            'fasilitas.*'     => 'string',
           'foto_kamar'      => 'nullable|array',
           'foto_kamar.*'    => 'image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $kost = Kost::where('id_kost', $validated['kost_id'])
            ->where('owner_id', auth()->id())
            ->firstOrFail();

        $room = Room::create([
            'kost_id'         => $kost->id_kost,
            'nomor_kamar'     => $validated['nomor_kamar'],
            'harga_per_bulan' => $validated['harga_per_bulan'] ?? 0,
            'harga_harian'    => $validated['harga_harian'] ?? null,
            'aktif_bulanan'   => $request->has('aktif_bulanan') ? 1 : 0,
            'aktif_harian'    => $request->has('aktif_harian') ? 1 : 0,
            'status_kamar'    => $validated['status_kamar'],
            'tipe_kamar'      => $validated['tipe_kamar'] ?? null,
            'ukuran'          => $validated['ukuran'] ?? null,
            'deskripsi'       => $validated['deskripsi'] ?? null,
            'fasilitas'       => $validated['fasilitas'] ?? null,
        ]);

        $this->syncRoomImages($room, $request, false);

        return redirect()->route('owner.kamar.index')->with('success', 'Kamar berhasil ditambahkan.');
    }

    public function show(Room $kamar)
    {
        $kamar->load(['images', 'bookings.user', 'kost']);
        $kost = $kamar->kost;
    
        // 🔥 FIX fasilitas biar selalu array
        if (is_string($kost->fasilitas)) {
            $decoded = json_decode($kost->fasilitas, true);
    
            if (json_last_error() === JSON_ERROR_NONE) {
                $kost->fasilitas = $decoded;
            } else {
                $kost->fasilitas = explode(',', $kost->fasilitas);
            }
        }
    
        return view('owner.kamar-show', compact('kamar', 'kost'));
    }

    public function edit(Room $kamar)
    {
        $kamar->load(['kost', 'mainImage', 'images']);
        $this->authorizeOwner($kamar);

        $kosts = Kost::where('owner_id', auth()->id())
            ->orderBy('nama_kost')
            ->get();

        return view('owner.kamar-edit', compact('kamar', 'kosts'));
    }

    public function update(Request $request, Room $kamar)
    {

        $kamar->load(['kost', 'mainImage', 'images']);
        $this->authorizeOwner($kamar);

        $validated = $request->validate([
            'kost_id'         => 'required|exists:kosts,id_kost',
            'nomor_kamar'     => 'required|string|max:50',
            'harga_per_bulan' => 'nullable|integer|min:0',
            'harga_harian'    => 'nullable|integer|min:0',
            'status_kamar'    => 'required|in:tersedia,terisi',
            'tipe_kamar'      => 'nullable|string',
            'ukuran'          => 'nullable|string|max:50',
            'deskripsi'       => 'nullable|string',
            'fasilitas'       => 'nullable|array',
            'fasilitas.*'     => 'string',
'foto_kamar'      => 'nullable|array',
'foto_kamar.*'    => 'image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $kost = Kost::where('id_kost', $validated['kost_id'])
            ->where('owner_id', auth()->id())
            ->firstOrFail();

        $kamar->update([
            'kost_id'         => $kost->id_kost,
            'nomor_kamar'     => $validated['nomor_kamar'],
            'harga_per_bulan' => $validated['harga_per_bulan'] ?? 0,
            'harga_harian'    => $validated['harga_harian'] ?? null,
            'aktif_bulanan'   => $request->has('aktif_bulanan') ? 1 : 0,
            'aktif_harian'    => $request->has('aktif_harian') ? 1 : 0,
            'status_kamar'    => $validated['status_kamar'],
            'tipe_kamar'      => $validated['tipe_kamar'] ?? null,
            'ukuran'          => $validated['ukuran'] ?? null,
            'deskripsi'       => $validated['deskripsi'] ?? null,
            'fasilitas'       => $validated['fasilitas'] ?? null,
        ]);

        $this->syncRoomImages($kamar, $request, true);

        return redirect()->route('owner.kamar.index')->with('success', 'Kamar berhasil diupdate.');
    }

    public function destroy(Room $kamar)
    {
        $kamar->load(['kost', 'images']);
        $this->authorizeOwner($kamar);

        foreach ($kamar->images as $image) {
            Storage::disk('public')->delete($image->foto_path);
        }

        $kamar->delete();

        return redirect()->route('owner.kamar.index')->with('success', 'Kamar berhasil dihapus.');
    }

    private function syncRoomImages(Room $room, Request $request, bool $replaceExisting): void
    {
        if (!$request->hasFile('foto_kamar')) {
            return;
        }
    
        if ($request->boolean('hapus_semua_foto')) {
            foreach ($room->images as $image) {
                Storage::disk('public')->delete($image->foto_path);
            }
            $room->images()->delete();
        }
    
        $existingCount = $room->images()->count();
        $sisaSlot = 6 - $existingCount;
    
        if ($sisaSlot <= 0) {
            return;
        }
    
        $files = array_slice($request->file('foto_kamar'), 0, $sisaSlot);
        $isFirstExisting = $existingCount === 0;
    
        foreach ($files as $index => $file) {
            $path = $file->store('kamar', 'public');
            RoomImage::create([
                'room_id'   => $room->id_room,
                'foto_path' => $path,
                'is_utama'  => $isFirstExisting && $index === 0,
            ]);
        }
    }
    private function authorizeOwner(Room $room): void
    {
        abort_if($room->kost->owner_id !== auth()->id(), 403);
    }
}