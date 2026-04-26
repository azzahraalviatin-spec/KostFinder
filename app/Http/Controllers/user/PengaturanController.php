<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengaturanController extends Controller
{
public function index()
{
    return view('user.pengaturan');
}
    public function updatePrivasi(Request $request)
    {
        $user = Auth::user();

        $user->update([
            'notif_info_umum'  => $request->has('notif_info_umum'),
            'notif_data_diri'  => $request->has('notif_data_diri'),
            'notif_aktivitas'  => $request->has('notif_aktivitas'),
            'notif_pencarian'  => $request->has('notif_pencarian'),
        ]);

        return redirect()->route('user.pengaturan.index')
            ->with('success', 'Pengaturan privasi berhasil disimpan!');
    }

    public function updateNotifikasi(Request $request)
    {
        $user = Auth::user();

        $user->update([
            'notif_booking'    => $request->has('notif_booking'),
            'notif_pembayaran' => $request->has('notif_pembayaran'),
            'notif_chat'       => $request->has('notif_chat'),
        ]);

        return redirect()->route('user.pengaturan.index')
            ->with('success', 'Pengaturan notifikasi berhasil disimpan!');
    }
}