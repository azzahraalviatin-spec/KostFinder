<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kost;
use App\Models\User;
use App\Models\OwnerReview;

class OwnerLandingController extends Controller
{
    public function index()
    {
        $stats = [
            'total_kost'    => Kost::count(),
            'total_owner'   => User::where('role', 'owner')->count(),
            'total_penyewa' => User::where('role', 'penyewa')->count(),
            'avg_rating'    => OwnerReview::avg('rating') ?? 0,
        ];

        $reviews = OwnerReview::with('user')
            ->approved()
            ->latest()
            ->take(6)
            ->get();

        return view('owner-landing', compact('stats', 'reviews'));
    }
}