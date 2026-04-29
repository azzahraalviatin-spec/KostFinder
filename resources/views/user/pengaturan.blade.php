@extends('layouts.user-sidebar')

@section('title', 'Pengaturan')

@section('styles')
<style>
  :root { --primary: #D0783B; --dark: #1e2d3d; }

  .setting-section { background:#fff; border-radius:1rem; border:1px solid #edf0f7; padding:1.4rem; margin-bottom:1.2rem; }
  .setting-title { font-size:.9rem; font-weight:800; color:var(--dark); margin-bottom:1rem; display:flex; align-items:center; gap:.5rem; }

  .form-setting label { font-size:.8rem; font-weight:700; color:#374151; margin-bottom:.3rem; }
  .form-setting .form-control { font-size:.85rem; border:1.5px solid #e4e9f0; border-radius:.65rem; padding:.55rem .85rem; }
  .form-setting .form-control:focus { border-color:var(--primary); box-shadow:0 0 0 3px rgba(208,120,59,.1); }
  .btn-save { background:var(--primary); color:#fff; border:0; border-radius:.65rem; padding:.55rem 1.3rem; font-size:.83rem; font-weight:700; cursor:pointer; transition:background .18s; }
  .btn-save:hover { background:#b5622e; }

  /* TOGGLE SWITCH */
  .toggle-row { display:flex; align-items:center; justify-content:space-between; padding:.75rem 0; border-bottom:1px solid #f5f5f5; gap:1rem; }
  .toggle-row:last-child { border-bottom:0; padding-bottom:0; }
  .toggle-info { flex:1; }
  .toggle-label { font-size:.83rem; font-weight:700; color:var(--dark); }
  .toggle-sub   { font-size:.75rem; color:#8fa3b8; margin-top:.1rem; }
  .form-switch .form-check-input { width:2.4em; height:1.3em; cursor:pointer; }
  .form-switch .form-check-input:checked { background-color:var(--primary); border-color:var(--primary); }
  .form-switch .form-check-input:focus { box-shadow:0 0 0 3px rgba(208,120,59,.15); border-color:var(--primary); }
</style>
@endsection

@section('content')
@php $user = auth()->user(); @endphp

@if(session('success'))
<div class="alert alert-success d-flex align-items-center" style="border-radius:1rem; font-size:.85rem; border:none; background:#ecfdf5; color:#065f46; box-shadow:0 4px 12px rgba(0,0,0,.03); margin-bottom:1.5rem;">
  <i class="bi bi-check-circle-fill me-2"></i>
  <div>{{ session('success') }}</div>
</div>
@endif

<div class="row g-4">
  
  {{-- KIRI: GANTI PASSWORD --}}
  <div class="col-12 col-lg-6">
    <div class="setting-section h-100">
      <div class="setting-title"><i class="bi bi-shield-lock-fill" style="color:var(--primary);"></i> Keamanan Akun</div>
      <div style="font-size:.78rem; color:#8fa3b8; margin-bottom:1.5rem;">Perbarui password Anda secara berkala untuk menjaga keamanan akun.</div>
      
      <form method="POST" action="{{ route('user.profil.update') }}" class="form-setting">
        @csrf @method('PATCH')
        <input type="hidden" name="section" value="password">
        <div class="mb-3">
          <label>Password Lama</label>
          <input type="password" name="current_password" class="form-control" placeholder="Masukkan password saat ini" required>
          @error('current_password')<div style="color:#dc2626;font-size:.75rem;margin-top:.3rem;">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
          <label>Password Baru</label>
          <input type="password" name="password" class="form-control" placeholder="Minimal 8 karakter" required>
          @error('password')<div style="color:#dc2626;font-size:.75rem;margin-top:.3rem;">{{ $message }}</div>@enderror
        </div>
        <div class="mb-4">
          <label>Konfirmasi Password Baru</label>
          <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password baru" required>
        </div>
        <button type="submit" class="btn-save w-100">Update Password</button>
      </form>
    </div>
  </div>

  {{-- KANAN: NOTIFIKASI --}}
  <div class="col-12 col-lg-6">
    <div class="setting-section h-100">
      <div class="setting-title"><i class="bi bi-bell-fill" style="color:var(--primary);"></i> Notifikasi</div>
      <div style="font-size:.78rem; color:#8fa3b8; margin-bottom:1.5rem;">Atur bagaimana Anda ingin menerima pembaruan dari KostFinder.</div>
      
      <form method="POST" action="{{ route('user.pengaturan.notifikasi') }}" class="form-setting">
        @csrf @method('PATCH')
        <div class="toggle-row">
          <div class="toggle-info">
            <div class="toggle-label">Pemesanan Kost</div>
            <div class="toggle-sub">Status booking dan konfirmasi owner</div>
          </div>
          <div class="form-check form-switch mb-0">
            <input class="form-check-input" type="checkbox" name="notif_booking" value="1" {{ $user->notif_booking ? 'checked' : '' }}>
          </div>
        </div>
        <div class="toggle-row">
          <div class="toggle-info">
            <div class="toggle-label">Pembayaran</div>
            <div class="toggle-sub">Reminder dan status transaksi</div>
          </div>
          <div class="form-check form-switch mb-0">
            <input class="form-check-input" type="checkbox" name="notif_pembayaran" value="1" {{ $user->notif_pembayaran ? 'checked' : '' }}>
          </div>
        </div>
        <div class="toggle-row">
          <div class="toggle-info">
            <div class="toggle-label">Pesan Chat</div>
            <div class="toggle-sub">Pesan baru dari pemilik kost</div>
          </div>
          <div class="form-check form-switch mb-0">
            <input class="form-check-input" type="checkbox" name="notif_chat" value="1" {{ $user->notif_chat ? 'checked' : '' }}>
          </div>
        </div>
        <div class="mt-4">
          <button type="submit" class="btn-save w-100">Simpan Notifikasi</button>
        </div>
      </form>
    </div>
  </div>

  {{-- BAWAH: PRIVASI --}}
  <div class="col-12">
    <div class="setting-section">
      <div class="setting-title"><i class="bi bi-eye-slash-fill" style="color:var(--primary);"></i> Preferensi & Privasi</div>
      <div style="font-size:.78rem; color:#8fa3b8; margin-bottom:1.2rem;">Kelola privasi data dan riwayat aktivitas pencarian Anda.</div>
      
      <form method="POST" action="{{ route('user.pengaturan.privasi') }}" class="form-setting">
        @csrf @method('PATCH')
        <div class="row">
          <div class="col-md-6">
            <div class="toggle-row">
              <div class="toggle-info">
                <div class="toggle-label">Info Umum Profil</div>
                <div class="toggle-sub">Tampilkan nama dan foto profil secara publik</div>
              </div>
              <div class="form-check form-switch mb-0">
                <input class="form-check-input" type="checkbox" name="notif_info_umum" value="1" {{ $user->notif_info_umum ? 'checked' : '' }}>
              </div>
            </div>
            <div class="toggle-row">
              <div class="toggle-info">
                <div class="toggle-label">Akses Data Diri</div>
                <div class="toggle-sub">Izinkan layanan pihak ketiga (opsional)</div>
              </div>
              <div class="form-check form-switch mb-0">
                <input class="form-check-input" type="checkbox" name="notif_data_diri" value="1" {{ $user->notif_data_diri ? 'checked' : '' }}>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="toggle-row">
              <div class="toggle-info">
                <div class="toggle-label">Simpan Riwayat Aktivitas</div>
                <div class="toggle-sub">Membantu mempercepat pencarian sebelumnya</div>
              </div>
              <div class="form-check form-switch mb-0">
                <input class="form-check-input" type="checkbox" name="notif_aktivitas" value="1" {{ $user->notif_aktivitas ? 'checked' : '' }}>
              </div>
            </div>
            <div class="toggle-row">
              <div class="toggle-info">
                <div class="toggle-label">Rekomendasi Berbasis Data</div>
                <div class="toggle-sub">Personalisasi kost sesuai minat Anda</div>
              </div>
              <div class="form-check form-switch mb-0">
                <input class="form-check-input" type="checkbox" name="notif_pencarian" value="1" {{ $user->notif_pencarian ? 'checked' : '' }}>
              </div>
            </div>
          </div>
        </div>
        <div class="mt-4 d-flex justify-content-end">
          <button type="submit" class="btn-save px-5">Simpan Preferensi</button>
        </div>
      </form>
    </div>
  </div>

</div>
@endsection