<?php
namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\OwnerReview;
use App\Models\Review;
use App\Models\ReviewReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index()
    {
        $owner_review = OwnerReview::where('user_id', Auth::id())->latest()->first();

        $reviews = Review::whereHas('kost', function ($q) {
                $q->where('owner_id', Auth::id());
            })
            ->with(['user', 'reply', 'kost'])
            ->where('status', 'approved')
            ->latest()
            ->get();

        $pending_reviews = Review::whereHas('kost', function ($q) {
                $q->where('owner_id', Auth::id());
            })
            ->with(['user', 'kost'])
            ->where('status', 'pending')
            ->latest()
            ->get();

        $belum_dibalas = $reviews->filter(fn($r) => is_null($r->reply))->count();
        $rata_rating   = $reviews->avg('rating') ?? 0;

        return view('owner.ulasan', compact(
            'owner_review',
            'reviews',
            'pending_reviews',
            'belum_dibalas',
            'rata_rating'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kota'       => 'required|string|max:100',
            'lokasi_kos' => 'required|string|max:150',
            'rating'     => 'required|integer|min:1|max:5',
            'ulasan'     => 'required|string|min:20|max:500',
        ]);

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

    public function reply(Request $request, Review $review)
    {
        $request->validate([
            'balasan' => 'required|string|min:5|max:500',
        ]);

        if ($review->kost->owner_id !== Auth::id()) {
            abort(403);
        }

        if ($review->reply) {
            return back()->with('error', 'Ulasan ini sudah dibalas.');
        }

        ReviewReply::create([
            'review_id' => $review->id,
            'owner_id'  => Auth::id(),
            'balasan'   => $request->balasan,
        ]);

        // Auto approve jika masih pending
        if ($review->status === 'pending') {
            $review->update(['status' => 'approved']);
            return back()->with('success', 'Balasan dikirim dan ulasan telah disetujui untuk tampil di publik!');
        }

        return back()->with('success', 'Balasan berhasil dikirim!');
    }

    public function approve(Review $review)
    {
        if ($review->kost->owner_id !== Auth::id()) {
            abort(403);
        }

        $review->update(['status' => 'approved']);

        return back()->with('success', 'Ulasan telah disetujui dan sekarang tampil di halaman publik!');
    }

    public function report(Request $request, Review $review)
    {
        $request->validate([
            'report_reason' => 'required|string|min:10|max:300',
        ]);

        if ($review->kost->owner_id !== Auth::id()) {
            abort(403);
        }

        $review->update([
            'is_reported'   => true,
            'report_reason' => $request->report_reason,
        ]);

        return back()->with('success', 'Ulasan berhasil dilaporkan ke admin.');
    }
}