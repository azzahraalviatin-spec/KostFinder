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
use App\Notifications\OwnerBaruNotification;

class RegisteredOwnerController extends Controller
{
    public function create(): View
    {
        return view('auth.register-owner');
    }

    public function store(Request $request): RedirectResponse
    {
     $request->validate([
    'name'      => ['required', 'string', 'max:100'],
    'no_hp'     => ['required', 'string', 'max:20', Rule::unique('users', 'no_hp')],
    'email'     => ['required', 'string', 'lowercase', 'email', 'max:100', Rule::unique('users', 'email')],
    'password'  => ['required', 'confirmed', Rules\Password::defaults()],
    'alamat'    => ['required', 'string'],
    'kota'      => ['required', 'string'],
    'provinsi'  => ['nullable', 'string'],
    'kode_pos'  => ['nullable', 'string', 'max:10'],
    'kecamatan' => ['nullable', 'string', 'max:100'],
    'kelurahan' => ['nullable', 'string', 'max:100'],
    'area_jalan'=> ['nullable', 'string', 'max:150'],
    'latitude'  => ['nullable', 'numeric'],
    'longitude' => ['nullable', 'numeric'],
]);

$owner = User::create([
    'name'      => $request->name,
    'no_hp'     => $request->no_hp,
    'email'     => $request->email,
    'password'  => Hash::make($request->password),
    'role'      => 'owner',
    'status_verifikasi_identitas' => 'belum',
    'alamat'    => $request->alamat,
    'kota'      => $request->kota,
    'kota_properti' => $request->kota_properti ?? $request->kota,
    'provinsi'  => $request->provinsi ?? 'Jawa Timur',
    'kode_pos'  => $request->kode_pos,
    'kecamatan' => $request->kecamatan,
    'kelurahan' => $request->kelurahan,
    'area_jalan'=> $request->area_jalan,
    'latitude'  => $request->latitude ?? 0,
    'longitude' => $request->longitude ?? 0,
]);

        event(new Registered($owner));

// ✅ Kirim notifikasi ke admin
$admin = User::where('role', 'admin')->first();
if ($admin) {
    $admin->notify(new OwnerBaruNotification($owner));
}

        return redirect()->route('login', ['role' => 'owner'])
            ->with('status', 'Registrasi pemilik kos berhasil. Silakan login dengan email dan password.');
    }
}
