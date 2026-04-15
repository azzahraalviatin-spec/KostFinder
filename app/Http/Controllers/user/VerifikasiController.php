<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifikasiController extends Controller
{
    public function updateEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email,' . Auth::id(),
        ]);

        Auth::user()->update([
            'email' => $request->email,
            'email_verified_at' => null, // reset verifikasi kalau email berubah
        ]);

        return redirect()->route('user.profil', ['tab' => 'verifikasi'])
            ->with('success', 'Email berhasil diperbarui!');
    }

    public function updateHp(Request $request)
    {
        $request->validate(['no_hp' => 'required|string|max:20']);
        
        auth()->user()->update([
            'no_hp' => '+62'.$request->no_hp
        ]);
    
        return back()->with('success', 'Nomor HP berhasil diperbarui!');
    }
    public function updateIdentitas(Request $request)
    {
     
        $request->validate([
            'jenis_identitas' => 'required|string|max:100',
            'foto_ktp'        => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
            'setuju'          => 'required',
        ]);
    
// Hapus foto lama kalau ada
if (Auth::user()->foto_ktp) {
    \Illuminate\Support\Facades\Storage::disk('public')->delete(Auth::user()->foto_ktp);
}


$ktpPath    = $request->file('foto_ktp')->store('verifikasi', 'public');

    
        Auth::user()->update([
            'jenis_identitas'            => $request->jenis_identitas,
            'foto_ktp'                   => $ktpPath,
            'status_verifikasi_identitas' => 'pending',
        ]);
    
        return redirect()->route('user.profil', ['tab' => 'verifikasi'])
            ->with('success', 'Identitas berhasil diunggah! Menunggu verifikasi admin.');
    }
}