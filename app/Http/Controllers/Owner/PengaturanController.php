<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PengaturanController extends Controller
{
    public function index()
    {
        return view('owner.Pengaturan');
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name'             => 'sometimes|required|string|max:100',
            'email'            => 'sometimes|required|email|unique:users,email,' . $user->id,
            'no_hp'            => 'nullable|string|max:20',
            'kota'             => 'nullable|string|max:100',
            'foto_profil'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'jenis_identitas'  => 'nullable|string',
            'foto_ktp'         => 'nullable|image|mimes:jpg,jpeg,png|max:3048',
            'foto_selfie'      => 'nullable|image|mimes:jpg,jpeg,png|max:3048',
            'foto_kepemilikan' => 'nullable|image|mimes:jpg,jpeg,png,pdf|max:5048',
            'alamat'        => 'nullable|string|max:255',
'kota_properti' => 'nullable|string|max:100',
'provinsi'      => 'nullable|string|max:100',
'kecamatan'     => 'nullable|string|max:100',
'kelurahan'     => 'nullable|string|max:100',
'kode_pos'      => 'nullable|string|max:10',
'maps_url'      => 'nullable|url|max:500',
        ]);

        // Upload foto profil
        if ($request->hasFile('foto_profil')) {
            if ($user->foto_profil) Storage::disk('public')->delete($user->foto_profil);
            $user->foto_profil = $request->file('foto_profil')->store('profil', 'public');
        }

        // Upload dokumen verifikasi
        $adaDokumenBaru = false;

        if ($request->hasFile('foto_ktp')) {
            if ($user->foto_ktp) Storage::disk('public')->delete($user->foto_ktp);
            $user->foto_ktp = $request->file('foto_ktp')->store('verifikasi', 'public');
            $adaDokumenBaru = true;
        }

        if ($request->hasFile('foto_selfie')) {
            if ($user->foto_selfie) Storage::disk('public')->delete($user->foto_selfie);
            $user->foto_selfie = $request->file('foto_selfie')->store('verifikasi', 'public');
            $adaDokumenBaru = true;
        }

        if ($request->hasFile('foto_kepemilikan')) {
            if ($user->foto_kepemilikan) Storage::disk('public')->delete($user->foto_kepemilikan);
            $user->foto_kepemilikan = $request->file('foto_kepemilikan')->store('verifikasi', 'public');
            $adaDokumenBaru = true;
        }

        if ($request->jenis_identitas) {
            $user->jenis_identitas = $request->jenis_identitas;
        }

        // Kalau ada dokumen baru → set status jadi pending
        if ($adaDokumenBaru) {
            $user->status_verifikasi_identitas = 'pending';
            $user->catatan_verifikasi = null;
        }

        // Update data profil
        if ($request->name)  $user->name  = $request->name;
        if ($request->email) $user->email = $request->email;
        $user->no_hp         = $request->no_hp;
$user->kota          = $request->kota;
$user->alamat        = $request->alamat;
$user->kota_properti = $request->kota_properti;
$user->provinsi      = $request->provinsi;
$user->kecamatan     = $request->kecamatan;
$user->kelurahan     = $request->kelurahan;
$user->kode_pos      = $request->kode_pos;
$user->maps_url      = $request->maps_url;
$user->save();

        if ($adaDokumenBaru) {
            return back()->with('success', '📋 Dokumen berhasil dikirim! Admin akan memverifikasi dalam 1×24 jam.');
        }

        return back()->with('success', '✅ Profil berhasil diupdate!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Password lama tidak sesuai!');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Password berhasil diubah!');
    }

    public function updateNotifikasi(Request $request)
    {
        $user = auth()->user();
        $user->notif_booking    = $request->has('notif_booking');
        $user->notif_cancel     = $request->has('notif_cancel');
        $user->notif_pembayaran = $request->has('notif_pembayaran');
        $user->notif_promo      = $request->has('notif_promo');
        $user->save();

        return back()->with('success', 'Pengaturan notifikasi disimpan!');
    }

    public function hapusAkun()
    {
        $user = auth()->user();

        // Hapus foto profil
        if ($user->foto_profil) {
            Storage::disk('public')->delete($user->foto_profil);
        }

        // Hapus dokumen verifikasi
        if ($user->foto_ktp)         Storage::disk('public')->delete($user->foto_ktp);
        if ($user->foto_selfie)      Storage::disk('public')->delete($user->foto_selfie);
        if ($user->foto_kepemilikan) Storage::disk('public')->delete($user->foto_kepemilikan);

        // Logout dulu, baru hapus
        auth()->logout();
        $user->delete();

        return redirect('/')->with('success', 'Akun berhasil dihapus.');
    }
}