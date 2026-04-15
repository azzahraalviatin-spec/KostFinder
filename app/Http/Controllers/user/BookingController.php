<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Notifications\BookingBaruNotification;
use App\Notifications\BookingDibatalkanNotification;
use App\Models\User;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::where('user_id', auth()->id())
            ->with(['room.kost'])
            ->latest()
            ->get();

        return view('user.booking', compact('bookings'));
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'room_id'           => 'required|exists:rooms,id_room',
            'tanggal_masuk'     => 'required|date|after_or_equal:today',
            'tipe_durasi'       => 'required|in:harian,bulanan',
            'jumlah_durasi'     => 'required|integer|min:1',
            'catatan'           => 'nullable|string|max:500',
            'metode_pembayaran' => 'nullable|string|max:100',
        ]);

        // ── CEK PROFIL USER ──
        $user = auth()->user();

        if (empty($user->no_hp)) {
            return back()->with('error', '⚠️ Lengkapi nomor HP kamu di profil sebelum booking.');
        }

        if (empty($user->foto_ktp)) {
            return back()->with('error', '⚠️ Upload foto KTP kamu di profil sebelum booking.');
        }

        if ($user->status_verifikasi_identitas !== 'disetujui') {
            $pesan = match($user->status_verifikasi_identitas) {
                'pending' => '⏳ Identitas kamu sedang diverifikasi admin.',
                'ditolak' => '❌ Identitas kamu ditolak admin.',
                default   => '⚠️ Lengkapi verifikasi identitas.',
            };
            return back()->with('error', $pesan);
        }

        $room = Room::findOrFail($request->room_id);

        // CEK KAMAR
        if ($room->status_kamar !== 'tersedia') {
            return back()->with('error', '❌ Kamar tidak tersedia.');
        }

        // CEK DURASI TERSEDIA
        $tipeDurasi   = $request->tipe_durasi;
        $jumlahDurasi = (int) $request->jumlah_durasi;

        if ($tipeDurasi === 'harian' && !$room->aktif_harian) {
            return back()->with('error', '❌ Kamar ini tidak tersedia untuk sewa harian.');
        }

        if ($tipeDurasi === 'bulanan' && !$room->aktif_bulanan) {
            return back()->with('error', '❌ Kamar ini tidak tersedia untuk sewa bulanan.');
        }

// CEK BOOKING AKTIF USER INI
$existing = Booking::where('user_id', auth()->id())
    ->where('room_id', $request->room_id)
    ->whereIn('status_booking', ['pending', 'diterima'])
    ->exists();

if ($existing) {
    return back()->with('error', '❌ Kamu sudah booking kamar ini. Selesaikan pembayaran terlebih dahulu.');
}

// CEK KAMAR SUDAH DIPESAN USER LAIN
$kamarDipesan = Booking::where('room_id', $request->room_id)
    ->whereIn('status_booking', ['pending', 'diterima'])
    ->exists();

if ($kamarDipesan) {
    return back()->with('error', '❌ Kamar ini sudah dipesan oleh pengguna lain.');
}

        // ── HITUNG TANGGAL & HARGA ──
        $tanggalMasuk = Carbon::parse($request->tanggal_masuk);

// BARU
if ($tipeDurasi === 'harian') {
    $tanggalSelesai = $tanggalMasuk->copy()->addDays($jumlahDurasi)->toDateString();
    $hargaSatuan    = (int) $room->harga_harian;
    $durasiLabel    = $jumlahDurasi;
} else {
    $tanggalSelesai = $tanggalMasuk->copy()->addMonths($jumlahDurasi)->toDateString();
    $hargaSatuan    = (int) $room->harga_per_bulan;
    $durasiLabel    = $jumlahDurasi;
}

        $totalHarga     = $hargaSatuan * $jumlahDurasi;
        $komisiAdmin    = round($totalHarga * 0.10);
        $totalBayar     = $totalHarga + $komisiAdmin;
        $pendapatanOwner = $totalHarga;

        $booking = Booking::create([
            'user_id'           => auth()->id(),
            'room_id'           => $request->room_id,
           'tanggal_masuk' => $tanggalMasuk->toDateString(),
            'tanggal_selesai'   => $tanggalSelesai,
            'durasi_sewa'       => $durasiLabel,
            'tipe_durasi'       => $tipeDurasi,
            'jumlah_durasi'     => $jumlahDurasi,
            'catatan'           => $request->catatan,
            'total_harga'       => $totalHarga,
            'total_bayar'       => $totalBayar,
            'komisi_admin'      => $komisiAdmin,
            'pendapatan_owner'  => $pendapatanOwner,
            'metode_pembayaran' => $request->metode_pembayaran,
            'status_booking'    => 'pending',
            'status_pembayaran' => 'belum',
        ]);

        $room->update(['status_kamar' => 'terisi']);


        // ✅ Kirim notifikasi ke admin
        $admin = User::where('role', 'admin')->first();
        if ($admin) {
            $admin->notify(new BookingBaruNotification($booking));
        }
        return redirect()->route('user.booking.pembayaran', $booking->id_booking)
            ->with('success', '✅ Booking berhasil! Lanjut pembayaran.');
    }

    public function pembayaran($id)
    {
        $booking = Booking::where('id_booking', $id)
            ->where('user_id', auth()->id())
            ->with(['room.kost'])
            ->firstOrFail();

        if ($booking->status_pembayaran !== 'belum') {
            return redirect()->route('user.booking.index')
                ->with('success', 'Booking sudah diproses!');
        }

        return view('user.booking-bayar', compact('booking'));
    }

    public function bayar(Request $request, $id)
    {
        $request->validate([
            'metode_pembayaran' => 'required|string|max:100',
            'bukti_pembayaran'  => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $booking = Booking::where('id_booking', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        if (in_array($booking->status_booking, ['ditolak', 'selesai'])) {
            return back()->with('error', 'Booking tidak bisa dibayar.');
        }

        if ($booking->status_pembayaran !== 'belum') {
            return back()->with('error', 'Sudah bayar.');
        }

        $path = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');

        $booking->update([
            'metode_pembayaran' => $request->metode_pembayaran,
            'bukti_pembayaran'  => $path,
            'status_pembayaran' => 'menunggu',
        ]);

        return redirect()->route('user.booking.index')
            ->with('success', '✅ Bukti pembayaran dikirim!');
    }

    public function cancel(Request $request, $id)
    {
        $booking = Booking::where('id_booking', $id)
            ->where('user_id', auth()->id())
            ->with('room')
            ->firstOrFail();

        if ($booking->status_booking !== 'pending') {
            return back()->with('error', 'Tidak bisa dibatalkan.');
        }

        $booking->update([
            'status_booking'    => 'ditolak',
            'status_pembayaran' => 'ditolak',
            'alasan_batal'      => $request->alasan_batal ?? 'Dibatalkan',
        ]);

        $booking->room->update(['status_kamar' => 'tersedia']);
    

        // ✅ Kirim notifikasi ke admin
        $admin = User::where('role', 'admin')->first();
        if ($admin) {
            $admin->notify(new BookingDibatalkanNotification($booking));
        }
        return back()->with('success', '✅ Booking dibatalkan.');
    }
}