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
<div class="alert alert-success" style="border-radius:.75rem;font-size:.85rem;">✅ {{ session('success') }}</div>
@endif

{{-- GANTI PASSWORD --}}
<div class="setting-section">
  <div class="setting-title"><i class="bi bi-lock-fill" style="color:var(--primary);"></i> Ganti Password</div>
  <form method="POST" action="{{ route('user.profil.update') }}" class="form-setting">
    @csrf @method('PATCH')
    <input type="hidden" name="section" value="password">
    <div class="mb-2">
      <label>Password Lama</label>
      <input type="password" name="current_password" class="form-control" placeholder="••••••••" required>
      @error('current_password')<div style="color:#dc2626;font-size:.75rem;margin-top:.3rem;">{{ $message }}</div>@enderror
    </div>
    <div class="mb-2">
      <label>Password Baru</label>
      <input type="password" name="password" class="form-control" placeholder="••••••••" required>
      @error('password')<div style="color:#dc2626;font-size:.75rem;margin-top:.3rem;">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
      <label>Konfirmasi Password Baru</label>
      <input type="password" name="password_confirmation" class="form-control" placeholder="••••••••" required>
    </div>
    <button type="submit" class="btn-save">Simpan Password</button>
  </form>
</div>

{{-- NOTIFIKASI --}}
<div class="setting-section">
  <div class="setting-title"><i class="bi bi-bell-fill" style="color:var(--primary);"></i> Notifikasi</div>
  <form method="POST" action="{{ route('user.pengaturan.notifikasi') }}" class="form-setting">
    @csrf @method('PATCH')
    <div class="toggle-row">
      <div class="toggle-info">
        <div class="toggle-label">Notifikasi Booking</div>
        <div class="toggle-sub">Update status pemesanan kost kamu</div>
      </div>
      <div class="form-check form-switch mb-0">
        <input class="form-check-input" type="checkbox" name="notif_booking" value="1" {{ $user->notif_booking ? 'checked' : '' }}>
      </div>
    </div>
    <div class="toggle-row">
      <div class="toggle-info">
        <div class="toggle-label">Notifikasi Pembayaran</div>
        <div class="toggle-sub">Konfirmasi dan reminder pembayaran</div>
      </div>
      <div class="form-check form-switch mb-0">
        <input class="form-check-input" type="checkbox" name="notif_pembayaran" value="1" {{ $user->notif_pembayaran ? 'checked' : '' }}>
      </div>
    </div>
    <div class="toggle-row">
      <div class="toggle-info">
        <div class="toggle-label">Notifikasi Promo</div>
        <div class="toggle-sub">Info promo dan penawaran menarik</div>
      </div>
      <div class="form-check form-switch mb-0">
        <input class="form-check-input" type="checkbox" name="notif_promo" value="1" {{ $user->notif_promo ? 'checked' : '' }}>
      </div>
    </div>
    <div class="toggle-row">
      <div class="toggle-info">
        <div class="toggle-label">Notifikasi Chat</div>
        <div class="toggle-sub">Pesan baru dari pemilik kost</div>
      </div>
      <div class="form-check form-switch mb-0">
        <input class="form-check-input" type="checkbox" name="notif_chat" value="1" {{ $user->notif_chat ? 'checked' : '' }}>
      </div>
    </div>
    <div class="mt-3">
      <button type="submit" class="btn-save">Simpan Notifikasi</button>
    </div>
  </form>
</div>

{{-- PRIVASI --}}
<div class="setting-section">
  <div class="setting-title"><i class="bi bi-shield-fill" style="color:var(--primary);"></i> Privasi</div>
  <form method="POST" action="{{ route('user.pengaturan.privasi') }}" class="form-setting">
    @csrf @method('PATCH')
    <div class="toggle-row">
      <div class="toggle-info">
        <div class="toggle-label">Info Umum</div>
        <div class="toggle-sub">Tampilkan info umum profilmu</div>
      </div>
      <div class="form-check form-switch mb-0">
        <input class="form-check-input" type="checkbox" name="notif_info_umum" value="1" {{ $user->notif_info_umum ? 'checked' : '' }}>
      </div>
    </div>
    <div class="toggle-row">
      <div class="toggle-info">
        <div class="toggle-label">Data Diri</div>
        <div class="toggle-sub">Izinkan akses data diri untuk layanan</div>
      </div>
      <div class="form-check form-switch mb-0">
        <input class="form-check-input" type="checkbox" name="notif_data_diri" value="1" {{ $user->notif_data_diri ? 'checked' : '' }}>
      </div>
    </div>
    <div class="toggle-row">
      <div class="toggle-info">
        <div class="toggle-label">Riwayat Aktivitas</div>
        <div class="toggle-sub">Simpan riwayat pencarian kost</div>
      </div>
      <div class="form-check form-switch mb-0">
        <input class="form-check-input" type="checkbox" name="notif_aktivitas" value="1" {{ $user->notif_aktivitas ? 'checked' : '' }}>
      </div>
    </div>
    <div class="toggle-row">
      <div class="toggle-info">
        <div class="toggle-label">Data Pencarian</div>
        <div class="toggle-sub">Gunakan data pencarian untuk rekomendasi</div>
      </div>
      <div class="form-check form-switch mb-0">
        <input class="form-check-input" type="checkbox" name="notif_pencarian" value="1" {{ $user->notif_pencarian ? 'checked' : '' }}>
      </div>
    </div>
    <div class="mt-3">
      <button type="submit" class="btn-save">Simpan Privasi</button>
    </div>
  </form>
</div>

@endsection