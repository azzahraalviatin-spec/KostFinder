<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

// TAMBAHAN
use App\Models\RentalRequest;
use App\Models\Transaction;
use App\Models\ViewHistory;

class ProfileController extends Controller
{
    /**
     * HALAMAN PROFIL USER
     */
    public function index(): View
    {
        $user = Auth::user();
    
        $rentalRequests = collect();
        $bookings = collect();
        $viewHistories = collect();
        $transactions = collect();
    
        $totalBookings = 0;
        $totalTransactions = 0;
        $totalViewed = 0;
        $activeRequests = 0;
    
        return view('user.profil', compact(
            'user',
            'rentalRequests',
            'bookings',
            'viewHistories',
            'transactions',
            'totalBookings',
            'totalTransactions',
            'totalViewed',
            'activeRequests'
        ));
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}