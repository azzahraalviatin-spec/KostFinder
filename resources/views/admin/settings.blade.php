@php use Illuminate\Support\Facades\Storage; @endphp
@extends('admin.layout')

@section('content')
<div class="container py-4">

    <h3 class="mb-4 fw-bold">⚙️ Pengaturan Admin</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row g-4">

            {{-- 🔹 AKUN --}}
            <div class="col-md-6">
                <div class="card shadow-sm border-0 rounded-4 p-4">
                    <h5 class="fw-bold mb-3">👤 Pengaturan Akun</h5>
                    {{-- FOTO PROFIL --}}
<div class="d-flex align-items-center gap-3 mb-4">

    <div class="position-relative" style="width:75px; height:75px;">
        <img id="preview-foto"
             src="{{ auth()->user()->photo
                 ? Storage::url(auth()->user()->photo)
                 : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=DC3545&color=fff&size=75&bold=true' }}"
             class="rounded-circle object-fit-cover w-100 h-100"
             style="cursor:pointer;"
             onclick="document.getElementById('input-foto').click()"
             title="Klik untuk ganti foto">

        <label for="input-foto"
               class="position-absolute bottom-0 end-0 bg-white rounded-circle border d-flex align-items-center justify-content-center shadow-sm"
               style="width:24px; height:24px; cursor:pointer;">
            <i class="bi bi-camera-fill" style="font-size:11px; color:#555;"></i>
        </label>

        <input type="file" id="input-foto" name="photo" accept="image/*" class="d-none">
    </div>

    <div>
        <div class="fw-bold">{{ auth()->user()->name }}</div>
        <div class="text-muted small">{{ auth()->user()->email }}</div>
        <div class="small text-danger mt-1" style="cursor:pointer;"
             onclick="document.getElementById('input-foto').click()">
            <i class="bi bi-pencil-fill"></i> Ganti Foto
        </div>
    </div>
</div>

@error('photo')
    <div class="text-danger small mb-2">{{ $message }}</div>
@enderror
                    {{-- Email --}}
                    <div class="mb-3">
                        <label class="form-label text-muted small">Email</label>
                        <input type="email" class="form-control bg-light"
                               value="{{ auth()->user()->email }}" readonly>
                    </div>

                

                   

                </div>
            </div>

            {{-- 🔹 NOTIFIKASI --}}
            <div class="col-md-6">
                <div class="card shadow-sm border-0 rounded-4 p-4">
                    <h5 class="fw-bold mb-3">🔔 Notifikasi</h5>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox"
                               name="notif_booking" id="notif_booking"
                               {{ $settings?->notif_booking ? 'checked' : '' }}>
                        <label class="form-check-label" for="notif_booking">
                            Notifikasi Booking
                        </label>
                    </div>

                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox"
                               name="notif_user" id="notif_user"
                               {{ $settings?->notif_user ? 'checked' : '' }}>
                        <label class="form-check-label" for="notif_user">
                            Notifikasi User
                        </label>
                    </div>

                </div>
            </div>

        </div>
        {{-- 🔹 GANTI PASSWORD --}}
<div class="col-md-6">
    <div class="card shadow-sm border-0 rounded-4 p-4">
        <h5 class="fw-bold mb-3">
            <i class="bi bi-lock-fill text-danger"></i> Ganti Password
        </h5>

        {{-- Password Lama --}}
        <div class="mb-3">
            <label class="form-label text-muted small">Password Lama</label>
            <div class="input-group">
                <input type="password" name="old_password" id="old_password"
                       placeholder="Masukkan password lama"
                       class="form-control @error('old_password') is-invalid @enderror">
                <button type="button" class="btn btn-outline-secondary"
                        onclick="togglePassword('old_password', 'icon-old')">
                    <i id="icon-old" class="bi bi-eye"></i>
                </button>
                @error('old_password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Password Baru & Konfirmasi --}}
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label text-muted small">Password Baru</label>
                <div class="input-group">
                    <input type="password" name="password" id="new_password"
                           placeholder="Min. 8 karakter"
                           class="form-control @error('password') is-invalid @enderror">
                    <button type="button" class="btn btn-outline-secondary"
                            onclick="togglePassword('new_password', 'icon-new')">
                        <i id="icon-new" class="bi bi-eye"></i>
                    </button>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <label class="form-label text-muted small">Konfirmasi Password Baru</label>
                <div class="input-group">
                    <input type="password" name="password_confirmation" id="confirm_password"
                           placeholder="Ulangi password baru"
                           class="form-control">
                    <button type="button" class="btn btn-outline-secondary"
                            onclick="togglePassword('confirm_password', 'icon-confirm')">
                        <i id="icon-confirm" class="bi bi-eye"></i>
                    </button>
                </div>
            </div>
        </div>

        {{-- Tombol --}}
        <div class="mt-4">
            <button type="submit" class="btn btn-danger px-4">
                <i class="bi bi-lock-fill"></i> Update Password
            </button>
        </div>

    </div>
</div>
    

    </form>
</div>

{{-- Preview foto sebelum upload --}}
<script>
document.getElementById('input-foto').addEventListener('change', function () {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('preview-foto').src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
});
// Toggle show/hide password
function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon  = document.getElementById(iconId);

    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('bi-eye', 'bi-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('bi-eye-slash', 'bi-eye');
    }
}

// Preview foto
document.getElementById('input-foto').addEventListener('change', function () {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('preview-foto').src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
});
</script>

@endsection