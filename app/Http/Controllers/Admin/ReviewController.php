<?php
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use App\Models\Review;
 
class ReviewController extends Controller
{
    // Tampilkan semua review
    public function index()
    {
        $reviews = Review::with(['user', 'kost'])
            ->latest()
            ->paginate(15);
        return view('admin.reviews.index', compact('reviews'));
    }
 
    // Approve review
    public function approve($id)
    {
        Review::findOrFail($id)->update(['status' => 'approved']);
        return back()->with('success', 'Ulasan berhasil disetujui.');
    }
 
    // Reject review
    public function reject($id)
    {
        Review::findOrFail($id)->update(['status' => 'rejected']);
        return back()->with('success', 'Ulasan berhasil ditolak.');
    }
}