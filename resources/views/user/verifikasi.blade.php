@extends('layouts.user-sidebar')

@section('title', 'Verifikasi Akun')

@section('styles')
<style>
  :root { --primary: #D0783B; --dark: #1e2d3d; }

  .verif-section { background:#fff; border-radius:1rem; border:1px solid #edf0f7; padding:1.4rem; margin-bottom:1.2rem; }
  .verif-section-title { font-size:.9rem; font-weight:800; color:var(--dark); margin-bottom:1rem; display:flex; align-items:center; gap:.5rem; }
  .verif-badge { display:inline-flex; align-items:center; gap:.3rem; font-size:.72rem; font-weight:700; padding:.22rem .7rem; border-radius:99px; }
  .verif-badge.verified   { background:#f0fdf4; color:#16a34a; }
  .verif-badge.pending    { background:#fff7ed; color:#ea580c; }
  .verif-badge.unverified { background:#f8fafd; color:#94a3b8; }

  .verif-row { display:flex; align-items:center; gap:1rem; padding:.85rem 0; border-bottom:1px solid #f5f5f5; flex-wrap:wrap; }
  .verif-row:last-child { border-bottom:0; padding-bottom:0; }
  .verif-icon { width:40px; height:40px; border-radius:.7rem; display:flex; align-items:center; justify-content:center; font-size:1.1rem; flex-shrink:0; background:#fff7ed; color:#ea580c; }
  .verif-info { flex:1; min-width:0; }
  .verif-label { font-size:.82rem; font-weight:700; color:var(--dark); }
  .verif-value { font-size:.78rem; color:#8fa3b8; margin-top:.12rem; }

  .form-verif label { font-size:.8rem; font-weight:700; color:#374151; margin-bottom:.3rem; }
  .form-verif .form-control { font-size:.85rem; border:1.5px solid #e4e9f0; border-radius:.65rem; padding:.55rem .85rem; }
  .form-verif .form-control:focus { border-color:var(--primary); box-shadow:0 0 0 3px rgba(208,120,59,.1); }
  .btn-verif { background:var(--primary); color:#fff; border:0; border-radius:.65rem; padding:.55rem 1.3rem; font-size:.83rem; font-weight:700; cursor:pointer; transition:background .18s; }
  .btn-verif:hover { background:#b5622e; }

  .ktp-preview { width:100%; max-width:320px; border-radius:.75rem; border:2px dashed #e4e9f0; overflow:hidden; margin-top:.5rem; }
  .ktp-preview img { width:100%; display:block; }

  .status-bar { border-radius:.85rem; padding:1rem 1.2rem; margin-bottom:1.2rem; display:flex; align-items:center; gap:.85rem; }
  .status-bar.success { background:linear-gradient(135deg,#f0fdf4,#dcfce7); border:1.5px solid #bbf7d0; }
  .status-bar.warning { background:linear-gradient(135deg,#fff7ed,#ffedd5); border:1.5px solid #fed7aa; }
  .status-bar.info    { background:linear-gradient(135deg,#eff6ff,#dbeafe); border:1.5px solid #bfdbfe; }
</style>
@endsection

@section('content')
@php $user = auth()->user(); @endphp

@if(session('success'))
<div class="alert alert-success" style="border-radius:.75rem;font-size:.85rem;">✅ {{ session('success') }}</div>
@endif

{{-- STATUS IDENTITAS --}}
@if($user->status_verifikasi_identitas === 'disetujui')
<div class="status-bar success">
  <span style="font-size:1.4rem;">✅</span>
  <div><div style="font-weight:800;font-size:.88rem;color:#15803d;">Akun Terverifikasi</div><div style="font-size:.78rem;color:#166534;">Identitas kamu sudah diverifikasi oleh admin.</div></div>
</div>
@elseif($user->status_verifikasi_identitas === 'pending')
<div class="status-bar warning">
  <span style="font-size:1.4rem;">⏳</span>
  <div><div style="font-weight:800;font-size:.88rem;color:#c2410c;">Menunggu Verifikasi</div><div style="font-size:.78rem;color:#9a3412;">Identitasmu sedang diproses admin. Biasanya 1x24 jam.</div></div>
</div>
@elseif($user->status_verifikasi_identitas === 'ditolak')
<div class="status-bar" style="background:linear-gradient(135deg,#fef2f2,#fee2e2);border:1.5px solid #fecaca;">
  <span style="font-size:1.4rem;">❌</span>
  <div><div style="font-weight:800;font-size:.88rem;color:#dc2626;">Verifikasi Ditolak</div><div style="font-size:.78rem;color:#991b1b;">Silakan unggah ulang identitas yang valid.</div></div>
</div>
@endif

{{-- EMAIL --}}
<div class="verif-section">
  <div class="verif-section-title"><i class="bi bi-envelope-fill" style="color:var(--primary);"></i> Verifikasi Email</div>
  <div class="verif-row">
    <div class="verif-icon"><i class="bi bi-envelope"></i></div>
    <div class="verif-info">
      <div class="verif-label">Email Saat Ini</div>
      <div class="verif-value">{{ $user->email }}</div>
    </div>
    @if($user->email_verified_at)
      <span class="verif-badge verified"><i class="bi bi-check-circle-fill"></i> Terverifikasi</span>
    @else
      <span class="verif-badge unverified"><i class="bi bi-x-circle"></i> Belum</span>
    @endif
  </div>
  <form method="POST" action="{{ route('user.verifikasi.email') }}" class="form-verif mt-3">
    @csrf @method('PATCH')
    <div class="mb-2">
      <label>Ganti Email</label>
      <input type="email" name="email" class="form-control" placeholder="email@baru.com" value="{{ old('email', $user->email) }}" required>
      @error('email')<div style="color:#dc2626;font-size:.75rem;margin-top:.3rem;">{{ $message }}</div>@enderror
    </div>
    <button type="submit" class="btn-verif">Simpan Email</button>
  </form>
</div>

{{-- NO HP --}}
<div class="verif-section">
  <div class="verif-section-title"><i class="bi bi-phone-fill" style="color:var(--primary);"></i> Verifikasi Nomor HP</div>
  <div class="verif-row">
    <div class="verif-icon"><i class="bi bi-phone"></i></div>
    <div class="verif-info">
      <div class="verif-label">Nomor HP Saat Ini</div>
      <div class="verif-value">{{ $user->no_hp ?? 'Belum diisi' }}</div>
    </div>
    @if($user->no_hp)
      <span class="verif-badge verified"><i class="bi bi-check-circle-fill"></i> Tersimpan</span>
    @else
      <span class="verif-badge unverified"><i class="bi bi-x-circle"></i> Belum</span>
    @endif
  </div>
  <form method="POST" action="{{ route('user.verifikasi.hp') }}" class="form-verif mt-3">
    @csrf @method('PATCH')
    <div class="mb-2">
      <label>Nomor HP (tanpa angka 0 di depan)</label>
      <div class="input-group">
        <span class="input-group-text" style="font-size:.83rem;background:#f9f9f9;">+62</span>
        <input type="text" name="no_hp" class="form-control" placeholder="812xxxxxxxx"
          value="{{ old('no_hp', ltrim(str_replace('+62','',$user->no_hp ?? ''), '0')) }}" required>
      </div>
      @error('no_hp')<div style="color:#dc2626;font-size:.75rem;margin-top:.3rem;">{{ $message }}</div>@enderror
    </div>
    <button type="submit" class="btn-verif">Simpan Nomor HP</button>
  </form>
</div>

{{-- IDENTITAS --}}
<div class="verif-section">
  <div class="verif-section-title"><i class="bi bi-card-text" style="color:var(--primary);"></i> Verifikasi Identitas (KTP/SIM)</div>

  @if($user->foto_ktp)
  <div class="verif-row">
    <div class="verif-info">
      <div class="verif-label">Foto Identitas Terakhir</div>
      <div class="ktp-preview mt-2">
        <img src="{{ asset('storage/'.$user->foto_ktp) }}" alt="Foto KTP">
      </div>
    </div>
  </div>
  @endif

  @if($user->status_verifikasi_identitas !== 'disetujui')
  <form method="POST" action="{{ route('user.verifikasi.identitas') }}" enctype="multipart/form-data" class="form-verif mt-3">
    @csrf @method('PATCH')
    <div class="mb-2">
      <label>Jenis Identitas</label>
      <select name="jenis_identitas" class="form-control" required>
        <option value="">-- Pilih --</option>
        <option value="KTP" {{ old('jenis_identitas', $user->jenis_identitas) === 'KTP' ? 'selected' : '' }}>KTP</option>
        <option value="SIM" {{ old('jenis_identitas', $user->jenis_identitas) === 'SIM' ? 'selected' : '' }}>SIM</option>
        <option value="Paspor" {{ old('jenis_identitas', $user->jenis_identitas) === 'Paspor' ? 'selected' : '' }}>Paspor</option>
      </select>
      @error('jenis_identitas')<div style="color:#dc2626;font-size:.75rem;margin-top:.3rem;">{{ $message }}</div>@enderror
    </div>
    <div class="mb-2">
      <label>Foto Identitas</label>
      <input type="file" name="foto_ktp" class="form-control" accept="image/*" required>
      <div style="font-size:.73rem;color:#8fa3b8;margin-top:.3rem;">Format JPG/PNG, maks 5MB</div>
      @error('foto_ktp')<div style="color:#dc2626;font-size:.75rem;margin-top:.3rem;">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
      <label class="d-flex align-items-center gap-2" style="font-weight:500;cursor:pointer;">
        <input type="checkbox" name="setuju" value="1" required> Saya menyetujui data ini digunakan untuk verifikasi akun
      </label>
      @error('setuju')<div style="color:#dc2626;font-size:.75rem;">{{ $message }}</div>@enderror
    </div>
    <button type="submit" class="btn-verif">Upload Identitas</button>
  </form>
  @else
  <div style="font-size:.82rem;color:#16a34a;font-weight:600;margin-top:.5rem;">✅ Identitas sudah diverifikasi, tidak perlu upload ulang.</div>
  @endif
</div>

@endsection