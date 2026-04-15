<?php

namespace App\Http\Requests\Auth;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'role' => ['nullable', 'in:user,owner,admin'],
        ];
    }

    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $credentials = [
            'email' => $this->string('email')->toString(),
            'password' => $this->password,
        ];

        if (Schema::hasColumn('users', 'status_akun')) {
            $credentials['status_akun'] = 'aktif';
        }

        if (! Auth::attempt($credentials, $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            $targetUser = User::where('email', $this->input('email'))->first();

            if (Schema::hasTable('activity_logs')) {
                ActivityLog::create([
                    'actor_id' => null,
                    'target_user_id' => $targetUser?->id,
                    'action' => 'login_failed',
                    'target_type' => 'auth',
                    'target_id' => null,
                    'ip_address' => $this->ip(),
                    'user_agent' => (string) $this->userAgent(),
                    'meta' => [
                        'role_hint' => (string) $this->input('role', 'user'),
                        'identity' => (string) $this->input('email'),
                    ],
                ]);
            }

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        if (Schema::hasTable('activity_logs')) {
            ActivityLog::create([
                'actor_id' => Auth::id(),
                'target_user_id' => Auth::id(),
                'action' => 'login_success',
                'target_type' => 'auth',
                'target_id' => null,
                'ip_address' => $this->ip(),
                'user_agent' => (string) $this->userAgent(),
                'meta' => [
                    'role' => (string) Auth::user()?->role,
                    'role_hint' => (string) $this->input('role', 'user'),
                ],
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')->toString()).'|'.$this->ip());
    }
}
