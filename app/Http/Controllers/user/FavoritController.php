<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Kost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoritController extends Controller
{
    public function index()
    {
        $favorites = Favorite::with('kost.rooms')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('user.favorit', compact('favorites'));
    }

    public function toggle(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'login_required'], 401);
        }

        $kostId = $request->kost_id;
        $existing = Favorite::where('user_id', Auth::id())
            ->where('kost_id', $kostId)
            ->first();

        if ($existing) {
            $existing->delete();
            return response()->json(['status' => 'removed']);
        } else {
            Favorite::create([
                'user_id' => Auth::id(),
                'kost_id' => $kostId,
            ]);
            return response()->json(['status' => 'added']);
        }
    }

    public function remove(Favorite $favorite)
    {
        if ($favorite->user_id !== Auth::id()) {
            abort(403);
        }

        $favorite->delete();

        return redirect()->route('user.favorit')
            ->with('success', 'Kos berhasil dihapus dari favorit!');
    }
    public function destroy(\Illuminate\Http\Request $request, $id)
    {
        $fav = \App\Models\Favorite::where('id', $id)
                    ->where('user_id', auth()->id())  // ← keamanan
                    ->firstOrFail();
        $fav->delete();
    
        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }
        return back()->with('success', 'Kos dihapus dari favorit.');
    }

    public function clearHistory()
    {
        \App\Models\RecentlyViewedKost::where('user_id', auth()->id())->delete();
        return back()->with('success', 'Riwayat berhasil dihapus!');
    }
}