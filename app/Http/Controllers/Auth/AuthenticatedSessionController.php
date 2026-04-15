<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Laravel\Socialite\Facades\Socialite;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        return $this->redirectByRole(auth()->user());
    }

    public function redirectToGoogle(Request $request): RedirectResponse
    {
        if (! class_exists(\Laravel\Socialite\Facades\Socialite::class)) {
            return redirect()
                ->route('login', ['role' => 'user'])
                ->withErrors(['login' => 'Paket Google login belum terpasang. Jalankan: composer require laravel/socialite']);
        }

        $role = $request->query('role');

        if ($role !== null && $role !== 'user') {
            return redirect()
                ->route('login', ['role' => $role])
                ->withErrors(['login' => 'Login Google hanya tersedia untuk pencari kos.']);
        }

        session(['google_login_role' => 'user']);

        return Socialite::driver('google')
            ->redirectUrl(route('auth.google.callback'))
            ->redirect();
    }

    public function handleGoogleCallback(Request $request): RedirectResponse
    {
        if (! class_exists(\Laravel\Socialite\Facades\Socialite::class)) {
            return redirect()
                ->route('login', ['role' => 'user'])
                ->withErrors(['login' => 'Paket Google login belum terpasang. Jalankan: composer require laravel/socialite']);
        }

        try {
            $googleUser = Socialite::driver('google')
                ->redirectUrl(route('auth.google.callback'))
                ->user();
        } catch (\Throwable $e) {
            return redirect()
                ->route('login', ['role' => 'user'])
                ->withErrors(['login' => 'Login Google gagal. Silakan coba lagi.']);
        }

        $email = $googleUser->getEmail();

        if (! $email) {
            return redirect()
                ->route('login', ['role' => 'user'])
                ->withErrors(['login' => 'Akun Google tidak memiliki email yang valid.']);
        }

        $user = User::where('google_id', $googleUser->getId())->first();

        if (! $user) {
            $user = User::where('email', $email)->first();
        }

        if ($user && $user->role !== 'user') {
            return redirect()
                ->route('login', ['role' => $user->role])
                ->withErrors(['login' => 'Akun owner dan admin tidak boleh login dengan Google.']);
        }

        if ($user && Schema::hasColumn('users', 'status_akun') && $user->status_akun === 'nonaktif') {
            return redirect()
                ->route('login', ['role' => 'user'])
                ->withErrors(['login' => 'Akun dinonaktifkan oleh admin.']);
        }

        if (! $user) {
            $user = User::create([
                'name' => $googleUser->getName() ?: 'Pengguna KostFinder',
                'email' => $email,
                'email_verified_at' => now(),
                'password' => Hash::make(Str::random(32)),
                'role' => 'user',
                'google_id' => $googleUser->getId(),
            ]);
        } elseif (! $user->google_id) {
            $user->google_id = $googleUser->getId();
            $user->save();
        }

        Auth::login($user, true);
        $request->session()->regenerate();
        $request->session()->forget('google_login_role');

        if (Schema::hasTable('activity_logs')) {
            ActivityLog::create([
                'actor_id' => $user->id,
                'target_user_id' => $user->id,
                'action' => 'login_google_success',
                'target_type' => 'auth',
                'ip_address' => $request->ip(),
                'user_agent' => (string) $request->userAgent(),
                'meta' => ['role' => 'user'],
            ]);
        }

        return $this->redirectByRole($user);
    }

    public function destroy(Request $request): RedirectResponse
    {
        if ($request->user() && Schema::hasTable('activity_logs')) {
            ActivityLog::create([
                'actor_id' => $request->user()->id,
                'target_user_id' => $request->user()->id,
                'action' => 'logout',
                'target_type' => 'auth',
                'ip_address' => $request->ip(),
                'user_agent' => (string) $request->userAgent(),
                'meta' => ['role' => $request->user()->role],
            ]);
        }

        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    protected function redirectByRole(User $user): RedirectResponse
    {
        return match ($user->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'owner' => redirect()->route('owner.dashboard'),
            default => redirect()->route('home'),
        };
    }
}
