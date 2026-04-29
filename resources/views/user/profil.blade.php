@extends('layouts.user-sidebar')

@section('title', 'Profil Saya')

@section('content')
@php
  $user = auth()->user();
  $fields = ['name','email','no_hp','jenis_kelamin','tanggal_lahir','pekerjaan','kota','foto_ktp'];
  $filled = collect($fields)->filter(fn($f) => !empty($user->$f))->count();
  $pct = round(($filled / count($fields)) * 100);
@endphp

<div style="max-width: 600px;">
  
  {{-- Card Identitas --}}
  <a href="{{ route('user.profil.edit') }}" style="display:block; text-decoration:none; margin-bottom:1.5rem;">
    <div style="background:#fff; border-radius:1rem; border:1px solid #e4e9f0; padding:1.2rem; display:flex; align-items:center; justify-content:space-between; box-shadow:0 2px 10px rgba(0,0,0,.02); transition:all .2s;" onmouseover="this.style.boxShadow='0 6px 20px rgba(0,0,0,.06)';this.style.transform='translateY(-2px)'" onmouseout="this.style.boxShadow='0 2px 10px rgba(0,0,0,.02)';this.style.transform='translateY(0)'">
      <div style="display:flex; align-items:center; gap:1.2rem;">
        <div style="width:70px; height:70px; border-radius:50%; background:#e8401c; color:#fff; font-weight:800; font-size:1.8rem; display:flex; align-items:center; justify-content:center; overflow:hidden;">
          @if($user->foto_profil)
            <img src="{{ asset('storage/'.$user->foto_profil) }}" style="width:100%;height:100%;object-fit:cover;">
          @else
            {{ strtoupper(substr($user->name,0,1)) }}
          @endif
        </div>
        <div>
          <div style="font-weight:800; font-size:1.2rem; color:#1a2332; margin-bottom:.2rem;">{{ $user->name }}</div>
          <div style="font-size:.9rem; color:#8fa3b8;">{{ $user->email }}</div>
        </div>
      </div>
      <i class="bi bi-chevron-right" style="color:#c0ccd8; font-size:1.4rem;"></i>
    </div>
  </a>

  {{-- Card Progress --}}
  <div style="background:#fff; border-radius:1rem; border:1px solid #e4e9f0; padding:1.2rem 1.5rem; box-shadow:0 2px 10px rgba(0,0,0,.02);">
    <div class="d-flex justify-content-between align-items-end" style="margin-bottom:.8rem;">
      <span style="font-weight:800; color:#e8401c; font-size:1.1rem;">{{ $pct }}%</span>
      <span style="color:#8fa3b8; font-size:.9rem;">{{ $filled }}/{{ count($fields) }} data profil terisi</span>
    </div>
    <div style="height:6px; background:#f0f3f8; border-radius:999px; margin-bottom:.8rem; overflow:hidden;">
      <div style="height:100%; background:linear-gradient(90deg,#e8401c,#ff6b3d); border-radius:999px; width:{{ $pct }}%;"></div>
    </div>
    <div style="font-size:.85rem; color:#8fa3b8; line-height:1.6;">Profil yang lengkap membantu kami memberikan rekomendasi yang lebih akurat.</div>
  </div>

</div>
@endsection