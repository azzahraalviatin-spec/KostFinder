<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function selectRole(): View
    {
        return view('auth.register-choice');
    }

    public function create(): View
    {
        return view('auth.register-user');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'no_hp' => ['required', 'string', 'max:20', Rule::unique('users', 'no_hp')],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'no_hp' => $request->no_hp,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        event(new Registered($user));

        return redirect()->route('login')
            ->with('status', 'Registrasi pencari kos berhasil. Silakan login dengan email dan password.');
    }

    public function storeLegacy(Request $request): RedirectResponse
    {
        if ($request->input('role') === 'owner') {
            return app(RegisteredOwnerController::class)->store($request);
        }

        return $this->store($request);
    }
}
