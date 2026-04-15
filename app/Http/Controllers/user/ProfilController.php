<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    public function update(Request $request)
    {
        $user = Auth::user();

        // Hapus foto profil — harus dicek PALING AWAL sebelum validasi
        if ($request->input('hapus_foto')) {
            if ($user->foto_profil) {
                Storage::disk('public')->delete($user->foto_profil);
            }
            $user->update(['foto_profil' => null]);
            return response()->json(['success' => true]);
        }

        $request->validate([
            'name'              => 'required|string|max:255',
            'jenis_kelamin'     => 'nullable|in:laki-laki,perempuan',
            'tanggal_lahir'     => 'nullable|date',
            'no_hp'             => 'nullable|string|max:20|unique:users,no_hp,' . $user->id,
            'kontak_darurat'    => 'nullable|string|max:20',
            'pekerjaan'         => 'nullable|string|max:100',
            'instansi'          => 'nullable|string|max:100',
            'pendidikan'        => 'nullable|string|max:50',
            'status_pernikahan' => 'nullable|string|max:50',
            'kota'              => 'nullable|string|max:100',
            'foto_profil'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only([
            'name', 'jenis_kelamin', 'tanggal_lahir', 'no_hp',
            'kontak_darurat', 'pekerjaan', 'instansi', 'pendidikan',
            'status_pernikahan', 'kota',
        ]);

        // Upload foto baru
        if ($request->hasFile('foto_profil')) {
            if ($user->foto_profil) {
                Storage::disk('public')->delete($user->foto_profil);
            }
            $data['foto_profil'] = $request->file('foto_profil')->store('foto-profil', 'public');
        }

        $user->update($data);

        return redirect()->route('user.profil.edit')
            ->with('success', 'Profil berhasil diperbarui!');
    }
}