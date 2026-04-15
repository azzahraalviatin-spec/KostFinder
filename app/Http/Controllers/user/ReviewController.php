<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Notifications\ReviewBaruNotification;
use App\Models\User;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'booking_id'        => 'required|exists:bookings,id_booking',
            'rating'            => 'required|integer|min:1|max:5',
            'rating_kebersihan' => 'required|integer|min:1|max:5',
            'rating_fasilitas'  => 'required|integer|min:1|max:5',
            'rating_lokasi'     => 'required|integer|min:1|max:5',
            'rating_harga'      => 'required|integer|min:1|max:5',
            'komentar'          => 'nullable|string|max:1000',
            'foto_review.*'     => 'nullable|image|max:2048',
        ]);

        $booking = Booking::where('id_booking', $request->booking_id)
                    ->where('user_id', auth()->id())
                    ->where('status_booking', 'selesai')
                    ->firstOrFail();

        // Cek sudah pernah review
        $sudahReview = Review::where('booking_id', $booking->id_booking)->exists();
        if ($sudahReview) {
            return response()->json(['error' => 'Kamu sudah memberikan review untuk kos ini.'], 422);
        }

        // Upload foto
        $fotos = [];
        if ($request->hasFile('foto_review')) {
            foreach ($request->file('foto_review') as $foto) {
                $fotos[] = $foto->store('reviews', 'public');
            }
        }

        // Hitung rating rata-rata
        $ratingRata = round(($request->rating + $request->rating_kebersihan + $request->rating_fasilitas + $request->rating_lokasi + $request->rating_harga) / 5);
        $review = Review::create([
            'user_id'           => auth()->id(),
            'kost_id'           => $booking->room->kost->id_kost,
            'booking_id'        => $booking->id_booking,
            'rating'            => $ratingRata,
            'rating_kebersihan' => $request->rating_kebersihan,
            'rating_fasilitas'  => $request->rating_fasilitas,
            'rating_lokasi'     => $request->rating_lokasi,
            'rating_harga'      => $request->rating_harga,
            'komentar'          => $request->komentar,
            'foto_review'       => $fotos ?: null,
        ]);
        
        // ✅ Kirim notifikasi ke admin
        $admin = User::where('role', 'admin')->first();
        if ($admin) {
            $admin->notify(new ReviewBaruNotification($review));
        };

        return response()->json(['success' => true]);
    }
}