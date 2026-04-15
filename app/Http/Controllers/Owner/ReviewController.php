<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\OwnerReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // Tampilkan form review di dashboard owner
    public function index()
    {
        $review = OwnerReview::where('user_id', Auth::id())->latest()->first();
        return view('owner.review', compact('review'));
    }

    // Simpan review baru
    public function store(Request $request)
    {
        $request->validate([
            'kota'       => 'required|string|max:100',
            'lokasi_kos' => 'required|string|max:150',
            'rating'     => 'required|integer|min:1|max:5',
            'ulasan'     => 'required|string|min:20|max:500',
        ]);

        // Cek apakah sudah pernah review
        $existing = OwnerReview::where('user_id', Auth::id())->first();
        if ($existing) {
            return back()->with('error', 'Anda sudah pernah mengirim ulasan.');
        }

        OwnerReview::create([
            'user_id'    => Auth::id(),
            'kota'       => $request->kota,
            'lokasi_kos' => $request->lokasi_kos,
            'rating'     => $request->rating,
            'ulasan'     => $request->ulasan,
            'status'     => 'pending',
        ]);

        return back()->with('success', 'Ulasan berhasil dikirim! Menunggu persetujuan admin.');
    }
}