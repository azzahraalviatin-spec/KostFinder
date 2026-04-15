@extends('layouts.app')

@section('title', $kost->nama_kost . ' - KostFinder')

@section('styles')
<style>
  :root { --primary: #e8401c; --dark: #1e2d3d; --bg: #f8fafd; }

  .breadcrumb-item a { color:var(--primary); text-decoration:none; font-size:.8rem; }
  .breadcrumb-item.active { font-size:.8rem; color:#8fa3b8; }

  .foto-grid { display:grid; grid-template-columns:2fr 1fr; gap:.5rem; border-radius:1rem; overflow:hidden; height:400px; }
  .foto-side { display:grid; grid-template-rows:1fr 1fr; gap:.5rem; height:100%; }  .foto-main { width:100%; height:100%; object-fit:cover; }
  .foto-main-placeholder { width:100%; height:100%; background:#e9edf2; display:flex; align-items:center; justify-content:center; font-size:5rem; color:#c0ccd8; }
  .foto-side { display:grid; grid-template-rows:1fr 1fr; gap:.5rem; height:100%; }
  .foto-side img { width:100%; height:100%; object-fit:cover; }
  .foto-side-placeholder { width:100%; height:100%; background:#edf0f4; display:flex; align-items:center; justify-content:center; font-size:2.5rem; color:#c0ccd8; }
  .foto-more-btn { position:absolute; bottom:12px; right:12px; background:rgba(255,255,255,.92); color:#333; border:1px solid #ddd; border-radius:.6rem; padding:.35rem .9rem; font-size:.78rem; font-weight:700; cursor:pointer; box-shadow:0 2px 8px rgba(0,0,0,.12); }

  .tab-nav { background:#fff; border-bottom:2px solid #e4e9f0; position:sticky; top:57px; z-index:99; }
  .tab-nav .nav-link { color:#555; font-size:.85rem; font-weight:600; padding:.8rem 1.1rem; border:0; border-bottom:3px solid transparent; border-radius:0; margin-bottom:-2px; text-decoration:none; white-space:nowrap; }
  .tab-nav .nav-link.active { color:var(--primary); border-bottom-color:var(--primary); }
  .tab-nav .nav-link:hover { color:var(--primary); }
  .tab-nav-scroll { overflow-x:auto; display:flex; scrollbar-width:none; }
  .tab-nav-scroll::-webkit-scrollbar { display:none; }

  .sidebar-sticky { position:sticky; top:110px; }
  .price-card { background:#fff; border:1px solid #e4e9f0; border-radius:1rem; padding:1.4rem; box-shadow:0 4px 20px rgba(0,0,0,.08); }
  .price-main { font-size:1.6rem; font-weight:800; color:var(--primary); }
  .price-period { font-size:.8rem; color:#888; font-weight:400; }
  .btn-sewa { background:var(--primary); color:#fff; border:0; border-radius:.75rem; padding:.85rem; font-weight:700; font-size:.95rem; width:100%; display:block; text-align:center; text-decoration:none; transition:background .2s; cursor:pointer; }
  .btn-sewa:hover { background:#cb3518; color:#fff; }
  .btn-sewa:disabled { background:#ccc; cursor:not-allowed; opacity:.6; }
  .btn-tanya { background:#fff; color:var(--primary); border:2px solid var(--primary); border-radius:.75rem; padding:.7rem; font-weight:700; font-size:.9rem; width:100%; margin-top:.6rem; transition:all .2s; cursor:pointer; }
  .btn-tanya:hover { background:#fff5f2; }

  .section-block { padding:1.8rem 0; border-bottom:1px solid #f0f3f8; }
  .section-block:last-child { border-bottom:none; }
  .sec-heading { font-size:1.05rem; font-weight:800; color:var(--dark); margin-bottom:1.2rem; display:flex; align-items:center; gap:.5rem; }

  .fasilitas-item { display:flex; align-items:center; gap:.7rem; font-size:.85rem; color:#444; margin-bottom:.7rem; }
  .fasilitas-item i { font-size:1rem; color:var(--primary); width:20px; flex-shrink:0; }
  .fasilitas-grid { display:grid; grid-template-columns:1fr 1fr; gap:.2rem 1.5rem; }
  .aturan-item { display:flex; align-items:flex-start; gap:.7rem; font-size:.83rem; color:#444; margin-bottom:.65rem; }
  .aturan-item i { font-size:.9rem; color:#e8401c; margin-top:.15rem; flex-shrink:0; }

  .badge-tipe { background:#fff5f2; color:#be3f1d; border:1px solid #ffd7ca; border-radius:999px; padding:.3rem .85rem; font-size:.78rem; font-weight:700; }
  .badge-verified { background:#f0fdf4; color:#16a34a; border:1px solid #bbf7d0; border-radius:999px; padding:.3rem .85rem; font-size:.78rem; font-weight:700; }

  .kamar-card { border:1px solid #e4e9f0; border-radius:1rem; overflow:hidden; background:#fff; transition:box-shadow .2s, transform .2s; }
  .kamar-card:hover { box-shadow:0 8px 24px rgba(0,0,0,.1); transform:translateY(-2px); }
  .kamar-thumb { width:100%; height:160px; object-fit:cover; }
  .kamar-thumb-ph { width:100%; height:160px; background:#f0f4f8; display:flex; align-items:center; justify-content:center; font-size:2.5rem; color:#c0ccd8; }
  .status-tersedia { background:#f0fdf4; color:#16a34a; border:1px solid #bbf7d0; border-radius:999px; padding:.2rem .65rem; font-size:.73rem; font-weight:700; }
  .status-terisi { background:#fef2f2; color:#dc2626; border:1px solid #fecaca; border-radius:999px; padding:.2rem .65rem; font-size:.73rem; font-weight:700; }
  .fas-tag { background:#f0f4f8; color:#555; border-radius:.4rem; padding:.2rem .55rem; font-size:.74rem; display:inline-block; margin:.1rem; }

  .owner-banner { background:linear-gradient(135deg,#fff5f2,#ffe8e0); border:1px solid #ffd0c0; border-radius:1rem; padding:1.2rem; display:flex; align-items:center; gap:1rem; }
  .owner-ava { width:52px; height:52px; border-radius:50%; background:var(--primary); color:#fff; font-size:1.2rem; font-weight:800; display:flex; align-items:center; justify-content:center; flex-shrink:0; overflow:hidden; border:3px solid #fff; box-shadow:0 2px 8px rgba(232,64,28,.3); }
  .online-dot { width:8px; height:8px; background:#22c55e; border-radius:50%; display:inline-block; margin-right:.3rem; }

  .review-card { background:#fff; border:1px solid #f0f3f8; border-radius:.9rem; padding:1rem 1.2rem; margin-bottom:.85rem; box-shadow:0 2px 8px rgba(0,0,0,.04); }
  .review-ava { width:40px; height:40px; border-radius:50%; background:var(--primary); color:#fff; font-weight:700; font-size:.85rem; display:flex; align-items:center; justify-content:center; flex-shrink:0; overflow:hidden; }
  .rating-bar-bg { background:#f0f3f8; border-radius:999px; height:7px; flex:1; overflow:hidden; }
  .rating-bar-fill { background:linear-gradient(90deg,#f59e0b,#fbbf24); border-radius:999px; height:7px; }

  .lokasi-map { width:100%; height:280px; background:linear-gradient(135deg,#dff0f7,#c5e3f0); border-radius:1rem; border:1px solid #b8d9e8; position:relative; overflow:hidden; }
  .lokasi-grid { position:absolute; inset:0; background-image:linear-gradient(rgba(100,160,190,.2) 1px,transparent 1px),linear-gradient(90deg,rgba(100,160,190,.2) 1px,transparent 1px); background-size:45px 45px; }
  .lokasi-road-h { position:absolute; left:0; right:0; height:14px; background:rgba(200,220,230,.8); top:52%; transform:translateY(-50%); }
  .lokasi-road-v { position:absolute; top:0; bottom:0; width:14px; background:rgba(200,220,230,.8); left:42%; }
  .lokasi-road-h2 { position:absolute; left:0; right:0; height:8px; background:rgba(200,220,230,.6); top:28%; }
  .lokasi-road-v2 { position:absolute; top:0; bottom:0; width:8px; background:rgba(200,220,230,.6); left:70%; }
  .lokasi-marker { position:absolute; top:52%; left:42%; transform:translate(-50%,-100%); z-index:2; text-align:center; }
  .lokasi-pin-shadow { width:12px; height:6px; background:rgba(0,0,0,.2); border-radius:50%; margin:0 auto; }
  .lokasi-block { position:absolute; background:rgba(180,210,225,.5); border-radius:.3rem; }

  .rekom-track { display:flex; gap:1rem; overflow-x:auto; padding-bottom:.5rem; scroll-behavior:smooth; scrollbar-width:none; }
  .rekom-track::-webkit-scrollbar { display:none; }
  .rekom-card { flex:0 0 240px; border:1px solid #e4e9f0; border-radius:1rem; overflow:hidden; background:#fff; transition:box-shadow .2s,transform .2s; text-decoration:none; color:inherit; }
  .rekom-card:hover { box-shadow:0 8px 24px rgba(0,0,0,.1); transform:translateY(-2px); }
  .rekom-thumb { width:100%; height:140px; object-fit:cover; }
  .rekom-thumb-ph { width:100%; height:140px; background:#f0f4f8; display:flex; align-items:center; justify-content:center; font-size:2rem; color:#c0ccd8; }
  .rekom-nav { width:38px; height:38px; border:1px solid #e4e9f0; background:#fff; border-radius:50%; font-size:.95rem; color:#444; cursor:pointer; display:flex; align-items:center; justify-content:center; transition:background .2s; }
  .rekom-nav:hover { background:#f4f7fc; }

  /* FORM BOOKING SIDEBAR */
  .booking-input { border:1px solid #e4e9f0; border-radius:.5rem; padding:.5rem .75rem; font-size:.82rem; color:#333; width:100%; outline:none; transition:border .2s; }
  .booking-input:focus { border-color:var(--primary); box-shadow:0 0 0 3px rgba(232,64,28,.1); }
  .kamar-select-item { border:1.5px solid #e4e9f0; border-radius:.65rem; padding:.6rem .8rem; cursor:pointer; transition:all .2s; margin-bottom:.5rem; }
  .kamar-select-item:hover { border-color:var(--primary); background:#fff5f2; }
  .kamar-select-item.selected { border-color:var(--primary); background:#fff5f2; }
  .kamar-select-item.terisi { opacity:.5; cursor:not-allowed; pointer-events:none; }

  /* TIPE DURASI */
  .tipe-durasi-btn { flex:1; border:2px solid #e4e9f0; border-radius:.65rem; padding:.5rem .7rem; cursor:pointer; text-align:center; background:#fff; transition:all .2s; }
  .tipe-durasi-btn.active { border-color:var(--primary); background:#fff5f2; }
  .tipe-durasi-btn.disabled { opacity:.4; pointer-events:none; }
  .tipe-durasi-btn .tipe-label { font-size:.75rem; font-weight:700; color:#555; }
  .tipe-durasi-btn.active .tipe-label { color:var(--primary); }
  .tipe-durasi-btn .tipe-harga { font-size:.7rem; color:#888; margin-top:.15rem; }

  /* JUMLAH DURASI */
  .jumlah-btn { width:32px; height:32px; border:1px solid #e4e9f0; border-radius:.45rem; background:#f8fafd; font-size:1.1rem; font-weight:700; cursor:pointer; display:flex; align-items:center; justify-content:center; transition:all .2s; flex-shrink:0; }
  .jumlah-btn:hover { background:#e4e9f0; }
  .fasilitas-popup {
  position: fixed;
  inset: 0;
  background: rgba(0,0,0,.45);
  z-index: 99999;
  display: none;
  align-items: center;
  justify-content: center;
  padding: 1rem;
}

.fasilitas-box {
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
}
#lightboxOverlay { display:none; }
#lightboxOverlay.aktif { display:flex !important; }
#lbThumbs::-webkit-scrollbar { display:none; }
#lbAllSection { overflow-y:auto; }
</style>

@endsection

@section('content')
{{-- ALERT ERROR/SUCCESS --}}
@if(session('error'))
<div style="position:fixed;top:80px;right:20px;z-index:99999;max-width:380px;background:#fef2f2;border:1px solid #fecaca;border-radius:.8rem;padding:1rem 1.2rem;box-shadow:0 8px 24px rgba(0,0,0,.12);display:flex;align-items:flex-start;gap:.8rem;animation:slideIn .3s ease;">
  <span style="font-size:1.2rem;flex-shrink:0;">❌</span>
  <div>
    <div style="font-weight:700;font-size:.85rem;color:#b91c1c;margin-bottom:.2rem;">Tidak Bisa Booking</div>
    <div style="font-size:.82rem;color:#dc2626;line-height:1.5;">{{ session('error') }}</div>
    <a href="{{ route('user.profil') }}" style="display:inline-block;margin-top:.6rem;background:#dc2626;color:#fff;font-size:.75rem;font-weight:700;padding:.3rem .8rem;border-radius:.4rem;text-decoration:none;">Lengkapi Profil →</a>
  </div>
  <button onclick="this.parentElement.remove()" style="background:none;border:none;color:#aaa;font-size:1rem;cursor:pointer;flex-shrink:0;margin-left:auto;">✕</button>
</div>
<style>@keyframes slideIn { from{opacity:0;transform:translateX(20px)} to{opacity:1;transform:none} }</style>
@endif

@if(session('success'))
<div style="position:fixed;top:80px;right:20px;z-index:99999;max-width:380px;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:.8rem;padding:1rem 1.2rem;box-shadow:0 8px 24px rgba(0,0,0,.12);display:flex;align-items:flex-start;gap:.8rem;">
  <span style="font-size:1.2rem;">✅</span>
  <div style="font-size:.82rem;color:#16a34a;font-weight:600;">{{ session('success') }}</div>
</div>
@endif

<div style="background:#f8fafd;min-height:100vh;padding-bottom:4rem;">

{{-- BREADCRUMB --}}
<div class="container py-2">
    <nav><ol class="breadcrumb mb-0">
      <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ $kost->kota }}</a></li>
      <li class="breadcrumb-item active">{{ Str::limit($kost->nama_kost, 40) }}</li>
    </ol></nav>
</div>

{{-- FOTO GALERI --}}
<div class="container mb-3">
@php
    $fotoUtama = $kost->foto_utama ? ltrim($kost->foto_utama, '/') : null;
    $semuaFoto = collect();
    if($fotoUtama) $semuaFoto->push(['path' => $fotoUtama, 'label' => 'Foto Utama']);
    foreach($kost->rooms as $room) {
        foreach($room->images as $img) {
            $semuaFoto->push(['path' => ltrim($img->foto_path,'/'), 'label' => 'Kamar '.$room->nomor_kamar]);
        }
    }
@endphp

<div style="display:grid;grid-template-columns:2fr 1fr;gap:.5rem;height:420px;border-radius:1.2rem;overflow:hidden;">

    {{-- FOTO KIRI BESAR --}}
    @if($fotoUtama)
        <img src="{{ asset('storage/'.$fotoUtama) }}"
            style="width:100%;height:100%;object-fit:cover;cursor:zoom-in;"
            onclick="bukaLightbox(0)" alt="{{ $kost->nama_kost }}">
    @else
        <div style="width:100%;height:100%;background:#e9edf2;display:flex;align-items:center;justify-content:center;font-size:5rem;color:#c0ccd8;">🏠</div>
    @endif

    {{-- FOTO KANAN 2 SLOT --}}
    <div style="display:grid;grid-template-rows:1fr 1fr;gap:.5rem;">

        {{-- SLOT ATAS KANAN --}}
        @if($semuaFoto->count() > 1)
            <img src="{{ asset('storage/'.$semuaFoto[1]['path']) }}"
                style="width:100%;height:100%;object-fit:cover;cursor:zoom-in;"
                onclick="bukaLightbox(1)" alt="foto">
        @elseif($fotoUtama)
            <img src="{{ asset('storage/'.$fotoUtama) }}"
                style="width:100%;height:100%;object-fit:cover;filter:brightness(.75);"
                alt="foto">
        @else
            <div style="width:100%;height:100%;background:#edf0f4;display:flex;align-items:center;justify-content:center;font-size:2.5rem;color:#c0ccd8;">🛏️</div>
        @endif

        {{-- SLOT BAWAH KANAN + TOMBOL LIHAT SEMUA --}}
        <div style="position:relative;overflow:hidden;">
            @if($semuaFoto->count() > 2)
                <img src="{{ asset('storage/'.$semuaFoto[2]['path']) }}"
                    style="width:100%;height:100%;object-fit:cover;cursor:zoom-in;"
                    onclick="bukaLightbox(2)" alt="foto">
            @elseif($fotoUtama)
                <img src="{{ asset('storage/'.$fotoUtama) }}"
                    style="width:100%;height:100%;object-fit:cover;filter:brightness(.6);"
                    alt="foto">
            @else
                <div style="width:100%;height:100%;background:#edf0f4;display:flex;align-items:center;justify-content:center;font-size:2.5rem;color:#c0ccd8;">🏡</div>
            @endif

            {{-- TOMBOL LIHAT SEMUA --}}
            <button onclick="bukaLightbox(0)"
                style="position:absolute;bottom:12px;right:12px;background:rgba(255,255,255,.96);color:#222;border:none;border-radius:.55rem;padding:.4rem .95rem;font-size:.78rem;font-weight:700;cursor:pointer;box-shadow:0 4px 16px rgba(0,0,0,.18);display:flex;align-items:center;gap:.4rem;z-index:2;">
                <i class="bi bi-grid-3x3-gap" style="font-size:.85rem;"></i> Lihat semua foto
            </button>
        </div>

    </div>
</div>

{{-- LIGHTBOX --}}
<div id="lightboxOverlay" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.96);z-index:99999;flex-direction:column;">

    {{-- Header --}}
    <div style="display:flex;align-items:center;justify-content:space-between;padding:.8rem 1.2rem;flex-shrink:0;">
        <div style="color:#fff;font-size:.85rem;font-weight:700;" id="lbTitle">Foto 1 dari {{ $semuaFoto->count() }}</div>
        <button onclick="tutupLightbox()" style="background:rgba(255,255,255,.15);border:none;color:#fff;width:36px;height:36px;border-radius:50%;font-size:1.1rem;cursor:pointer;display:flex;align-items:center;justify-content:center;">✕</button>
    </div>

    {{-- Foto aktif --}}
    <div style="flex:1;display:flex;align-items:center;justify-content:center;position:relative;">
        <button onclick="lbNav(-1)" style="position:absolute;left:16px;background:rgba(255,255,255,.15);border:none;color:#fff;width:48px;height:48px;border-radius:50%;font-size:1.5rem;cursor:pointer;display:flex;align-items:center;justify-content:center;">‹</button>
        <img id="lbImg" src="" alt="" style="max-width:88%;max-height:72vh;object-fit:contain;border-radius:.75rem;transition:opacity .2s;">
        <button onclick="lbNav(1)" style="position:absolute;right:16px;background:rgba(255,255,255,.15);border:none;color:#fff;width:48px;height:48px;border-radius:50%;font-size:1.5rem;cursor:pointer;display:flex;align-items:center;justify-content:center;">›</button>
    </div>

    {{-- Label --}}
    <div style="text-align:center;padding:.4rem;flex-shrink:0;">
        <span id="lbLabel" style="background:rgba(255,255,255,.15);color:#fff;font-size:.78rem;font-weight:700;padding:.3rem .9rem;border-radius:999px;"></span>
    </div>

    {{-- Thumbnail strip --}}
    <div style="padding:.7rem 1rem;flex-shrink:0;">
        <div id="lbThumbs" style="display:flex;gap:.5rem;overflow-x:auto;scrollbar-width:none;justify-content:center;">
            @foreach($semuaFoto as $i => $foto)
            <img src="{{ asset('storage/'.$foto['path']) }}"
                onclick="lbGoto({{ $i }})"
                id="lbThumb{{ $i }}"
                style="width:60px;height:45px;object-fit:cover;border-radius:.4rem;cursor:pointer;opacity:.5;border:2px solid transparent;flex-shrink:0;transition:all .2s;"
                alt="">
            @endforeach
        </div>
    </div>

    {{-- Semua foto per kategori --}}
    <div id="lbAllSection" style="background:#111;padding:0 1.2rem;flex-shrink:0;max-height:0;overflow:hidden;transition:max-height .4s ease;">
        <div style="padding:1rem 0;">
            <div style="color:#fff;font-weight:700;font-size:.88rem;margin-bottom:.8rem;">Semua Foto</div>

            @if($fotoUtama)
            <div style="margin-bottom:1rem;">
                <div style="color:#aaa;font-size:.72rem;font-weight:700;margin-bottom:.5rem;text-transform:uppercase;letter-spacing:.05em;">🏠 Foto Utama</div>
                <div style="display:flex;gap:.4rem;overflow-x:auto;scrollbar-width:none;">
                    <img src="{{ asset('storage/'.$fotoUtama) }}"
                        onclick="lbGoto(0)"
                        style="height:85px;width:auto;object-fit:cover;border-radius:.5rem;cursor:pointer;flex-shrink:0;">
                </div>
            </div>
            @endif

            @foreach($kost->rooms as $room)
            @if($room->images->isNotEmpty())
            <div style="margin-bottom:1rem;">
                <div style="color:#aaa;font-size:.72rem;font-weight:700;margin-bottom:.5rem;text-transform:uppercase;letter-spacing:.05em;">🛏️ Kamar {{ $room->nomor_kamar }}</div>
                <div style="display:flex;gap:.4rem;overflow-x:auto;scrollbar-width:none;">
                    @foreach($room->images as $img)
                    @php $fotoIdx = $semuaFoto->search(fn($f) => $f['path'] === ltrim($img->foto_path,'/')); @endphp
                    <img src="{{ asset('storage/'.ltrim($img->foto_path,'/')) }}"
                        onclick="lbGoto({{ $fotoIdx !== false ? $fotoIdx : 0 }})"
                        style="height:85px;width:auto;object-fit:cover;border-radius:.5rem;cursor:pointer;flex-shrink:0;">
                    @endforeach
                </div>
            </div>
            @endif
            @endforeach
        </div>
    </div>

    {{-- Tombol toggle semua foto --}}
    <div style="text-align:center;padding:.6rem;flex-shrink:0;background:#111;">
        <button onclick="toggleLbAll()" id="btnLbAll"
            style="background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.2);color:#fff;padding:.4rem 1.2rem;border-radius:999px;font-size:.78rem;font-weight:700;cursor:pointer;">
            Lihat Semua Foto ↓
        </button>
    </div>

</div>

</div>
  {{-- JUDUL --}}
  <div class="container mb-2">
    <div class="d-flex flex-wrap gap-2 align-items-center mb-2">
      <span class="badge-tipe">🏠 {{ $kost->tipe_kost }}</span>
      <span class="badge-verified">✅ Terverifikasi</span>
    </div>
    <h1 style="font-size:1.5rem;font-weight:800;color:var(--dark);margin-bottom:.5rem;">{{ $kost->nama_kost }}</h1>
    <div class="d-flex flex-wrap align-items-center gap-3 mb-2" style="font-size:.83rem;color:#555;">
      <span>🏘️ {{ $kost->tipe_kost }}</span>
      <span>📍 {{ $kost->kota }}</span>
      @if($kost->reviews->count() > 0)
        @php $avg = round($kost->reviews->avg('rating'), 1); @endphp
        <span style="color:#f59e0b;font-weight:700;">⭐ {{ $avg }} <span style="color:#888;font-weight:400;">({{ $kost->reviews->count() }} review)</span></span>
      @endif
      @php $tersedia = $kost->rooms->where('status_kamar','tersedia')->count(); @endphp
      @if($tersedia > 0)
        <span style="color:#e8401c;font-weight:700;">🔑 Tersisa {{ $tersedia }} kamar</span>
      @else
        <span style="color:#dc2626;font-weight:700;">❌ Penuh</span>
      @endif
    </div>
    <div style="font-size:.83rem;color:#666;margin-bottom:.8rem;">
      <i class="bi bi-geo-alt-fill text-danger"></i> {{ $kost->alamat }}
    </div>
  </div>

  {{-- OWNER BANNER --}}
  @php $owner = $kost->owner ?? null; @endphp
  <div class="container mb-2">
    <div class="owner-banner">
      <div class="owner-ava">
        @if($owner && $owner->foto_profil)
          <img src="{{ asset('storage/'.$owner->foto_profil) }}" style="width:100%;height:100%;object-fit:cover;" alt="">
        @else
          {{ strtoupper(substr($owner->name ?? 'P', 0, 1)) }}
        @endif
      </div>
      <div>
        <div style="font-size:.8rem;color:#888;">Kos dikelola oleh</div>
        <div style="font-weight:800;font-size:.95rem;color:var(--dark);">{{ $owner->name ?? 'Pemilik Kost' }}</div>
        <div style="font-size:.75rem;color:#888;"><span class="online-dot"></span>Online baru-baru ini</div>
      </div>
      <div class="ms-auto"><i class="bi bi-shield-check-fill text-success fs-4"></i></div>
    </div>
  </div>

  {{-- TAB NAV --}}
  <div class="tab-nav">
    <div class="container">
      <div class="tab-nav-scroll">
        <a class="nav-link active" href="#sec-kamar">📸 Foto Properti</a>
        <a class="nav-link" href="#sec-fasilitas-kamar">🛏️ Fasilitas Kamar</a>
        <a class="nav-link" href="#sec-fasilitas-umum">🏢 Fasilitas Umum</a>
        <a class="nav-link" href="#sec-lokasi">📍 Lokasi</a>
        <a class="nav-link" href="#sec-review">⭐ Review</a>
        <a class="nav-link" href="#sec-pemilik">👤 Pemilik Kos</a>
      </div>
    </div>
  </div>

  {{-- MAIN CONTENT --}}
  <div class="container mt-3">
    <div class="row g-4">

      {{-- KIRI --}}
      <div class="col-12 col-lg-8">

        {{-- KAMAR --}}
        <div id="sec-kamar" class="section-block" style="scroll-margin-top:120px;">
          <div class="sec-heading">📸 Foto Properti & Kamar</div>
          @if($kost->rooms->isEmpty())
            <div class="text-center py-5 text-muted">
              <div style="font-size:3rem;">🚪</div>
              <div>Belum ada kamar tersedia</div>
            </div>
          @else
            <div class="row g-3">
              @foreach($kost->rooms as $room)
              <div class="col-12 col-md-6">
                <div class="kamar-card">
                  @if($room->images->isNotEmpty())
                    <img src="{{ asset('storage/'.ltrim($room->images->first()->foto_path,'/')) }}" class="kamar-thumb" alt="Kamar {{ $room->nomor_kamar }}">
                  @else
                    <div class="kamar-thumb-ph">🛏️</div>
                  @endif
                  <div class="p-3">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                      <div>
                        <div class="fw-bold" style="font-size:.92rem;">Kamar {{ $room->nomor_kamar }}</div>
                        @if($room->tipe_kamar)<small class="text-muted" style="font-size:.78rem;">{{ $room->tipe_kamar }}</small>@endif
                      </div>
                      <span class="{{ $room->status_kamar==='tersedia'?'status-tersedia':'status-terisi' }}">
                        {{ $room->status_kamar==='tersedia' ? '✅ Tersedia' : '❌ Terisi' }}
                      </span>
                    </div>
                    @if($room->ukuran)<div style="font-size:.78rem;color:#666;margin-bottom:.3rem;">📐 {{ $room->ukuran }}</div>@endif
                    @if($room->deskripsi)<div style="font-size:.78rem;color:#777;margin-bottom:.5rem;">{{ Str::limit($room->deskripsi,70) }}</div>@endif
                    @if($room->fasilitas && count($room->fasilitas) > 0)
                      <div class="mb-2">
                        @foreach(array_slice($room->fasilitas, 0, 3) as $f)<span class="fas-tag">{{ $f }}</span>@endforeach
                        @if(count($room->fasilitas) > 3)<span class="fas-tag">+{{ count($room->fasilitas)-3 }} lainnya</span>@endif
                      </div>
                    @endif
                    {{-- HARGA --}}
                    <div class="mb-2">
                      @if($room->aktif_bulanan && $room->harga_per_bulan)
                        <span style="font-size:.8rem;color:#555;">🗓️ <strong style="color:var(--primary);">Rp {{ number_format($room->harga_per_bulan,0,',','.') }}</strong>/bln</span>
                      @endif
                      @if($room->aktif_harian && $room->harga_harian)
                        <span style="font-size:.8rem;color:#555;margin-left:.5rem;">📅 <strong style="color:#d97706;">Rp {{ number_format($room->harga_harian,0,',','.') }}</strong>/hari</span>
                      @endif
                    </div>
                    <div class="d-flex justify-content-between align-items-center pt-2" style="border-top:1px solid #f0f3f8;margin-top:.5rem;">
                      @if($room->status_kamar === 'tersedia')
                        @auth
                          @if(auth()->user()->role === 'user')
                            <button onclick="pilihKamarDanScroll({{ $room->id_room }}, document.getElementById('kamarItem{{ $room->id_room }}'), {{ $room->harga_per_bulan ?? 0 }}, {{ $room->harga_harian ?? 0 }}, {{ $room->aktif_harian ? 1 : 0 }}, {{ $room->aktif_bulanan ? 1 : 0 }})"
                              class="btn btn-sm btn-danger" style="font-size:.78rem;border-radius:.5rem;padding:.3rem .8rem;width:100%;">
                              Pilih Kamar
                            </button>
                          @endif
                        @else
                          <a href="{{ route('login') }}" class="btn btn-sm btn-outline-danger" style="font-size:.78rem;border-radius:.5rem;">Login dulu</a>
                        @endauth
                      @else
                        <span style="font-size:.75rem;color:#aaa;">Tidak tersedia</span>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
              @endforeach
            </div>
          @endif
        </div>
<!-- POPUP FASILITAS -->
<div class="fasilitas-popup" id="fasilitasPopup" style="display:none;">
  <div class="fasilitas-box" id="fasilitasContent"></div>
</div>
{{-- FASILITAS KAMAR --}}
<div id="sec-fasilitas-kamar" class="section-block" style="scroll-margin-top:120px;">
  <div class="sec-heading">🛏️ Fasilitas Kamar</div>

  @php
    $ikonFasilitas = [
      '🛏️ Kasur' => 'bi-moon-stars',
      '❄️ AC' => 'bi-thermometer-snow',
      '🌀 Kipas Angin' => 'bi-wind',
      '📺 TV' => 'bi-tv',
      '🚿 Kamar Mandi Dalam' => 'bi-droplet',
      '🚽 Kamar Mandi Luar' => 'bi-droplet-half',
      '🔥 Air Panas' => 'bi-fire',
      '🪑 Meja & Kursi' => 'bi-easel',
      '🗄️ Lemari' => 'bi-archive',
      '🌐 WiFi' => 'bi-wifi',
      '🅿️ Parkir Motor' => 'bi-scooter',
      '🅿️ Parkir Mobil' => 'bi-car-front',
      '🍳 Dapur' => 'bi-cup-hot',
      '👕 Laundry' => 'bi-bag',
      '🕌 Mushola' => 'bi-building',
      '📹 CCTV' => 'bi-camera-video',
      '🧊 Kulkas' => 'bi-snow',
    ];
  @endphp

  @foreach($kost->rooms as $room)
    <div class="mb-4 p-3 rounded-3" style="background:#fff;border:1px solid #f0f3f8;">
      
      <div class="d-flex align-items-center gap-2 mb-3">
        <span style="font-size:.88rem;font-weight:800;color:var(--dark);">
          🚪 Kamar {{ $room->nomor_kamar }}
        </span>

        @if($room->tipe_kamar)
          <span class="fas-tag">{{ $room->tipe_kamar }}</span>
        @endif

        @if($room->ukuran)
          <span class="fas-tag">📐 {{ $room->ukuran }}</span>
        @endif
      </div>

      @php
        $fasilitasKamar = is_array($room->fasilitas)
          ? $room->fasilitas
          : (json_decode($room->fasilitas, true) ?: []);
      @endphp

      @if(count($fasilitasKamar) > 0)

        {{-- Preview fasilitas --}}
        <div class="mb-2">
          @foreach(array_slice($fasilitasKamar, 0, 3) as $f)
            <span class="fas-tag">{{ $f }}</span>
          @endforeach

          @if(count($fasilitasKamar) > 3)
            <button 
              type="button"
              onclick="openFasilitas(this)" 
              data-fasilitas='@json($fasilitasKamar)'
              class="btn btn-sm btn-light">
              +{{ count($fasilitasKamar)-3 }} lainnya
            </button>
          @endif
        </div>

        {{-- Semua fasilitas --}}
        <div class="fasilitas-grid">
          @foreach($fasilitasKamar as $f)
            <div class="fasilitas-item">
              <i class="bi {{ $ikonFasilitas[$f] ?? 'bi-check-circle-fill' }}"></i> {{ $f }}
            </div>
          @endforeach
        </div>

      @else
        <div class="text-muted" style="font-size:.82rem;">Belum ada fasilitas kamar</div>
      @endif

      @if($room->deskripsi)
        <div class="mt-2 pt-2" style="border-top:1px solid #f5f7fa;font-size:.82rem;color:#666;">
          💬 {{ $room->deskripsi }}
        </div>
      @endif

    </div>
  @endforeach
</div>

        {{-- FASILITAS UMUM --}}
        <div id="sec-fasilitas-umum" class="section-block" style="scroll-margin-top:120px;">
          <div class="sec-heading">🏢 Fasilitas Umum</div>
          @if($kost->fasilitas)
          <div class="fasilitas-grid mb-4">
            @foreach(explode(',', $kost->fasilitas) as $f)
              <div class="fasilitas-item"><i class="bi bi-check-circle-fill" style="color:#22c55e;"></i> {{ trim($f) }}</div>
            @endforeach
          </div>
          @endif
          @if($kost->deskripsi)
          <div class="mt-3 p-3 rounded-3" style="background:#f8fafd;border:1px solid #e4e9f0;">
            <div style="font-size:.82rem;font-weight:700;color:#888;margin-bottom:.5rem;">📝 Deskripsi Kost</div>
            <p style="font-size:.85rem;color:#555;margin:0;">{{ $kost->deskripsi }}</p>
          </div>
          @endif
          @if($kost->aturan)
          <div class="sec-heading mt-4" style="font-size:.95rem;">📋 Peraturan Kost</div>
          @foreach(explode("\n", $kost->aturan) as $aturan)
            @if(trim($aturan))
              <div class="aturan-item">
                <i class="bi bi-exclamation-circle-fill" style="color:#f59e0b;"></i>
                <span>{{ trim($aturan) }}</span>
              </div>
            @endif
          @endforeach
          @endif
        </div>

        {{-- LOKASI --}}
        <div id="sec-lokasi" class="section-block" style="scroll-margin-top:120px;">
          <div class="sec-heading">📍 Lokasi & Lingkungan</div>
          <div class="mb-3 p-3 rounded-3 d-flex align-items-start gap-2" style="background:#fff5f2;border:1px solid #ffd0c0;">
            <i class="bi bi-geo-alt-fill text-danger mt-1"></i>
            <div>
              <div style="font-weight:700;font-size:.85rem;color:#be3f1d;">{{ $kost->kota }}</div>
              <div style="font-size:.82rem;color:#666;margin-top:.2rem;">{{ $kost->alamat }}</div>
            </div>
          </div>
          <div class="lokasi-map">
            <div class="lokasi-grid"></div>
            <div class="lokasi-block" style="width:60px;height:40px;top:15%;left:15%;"></div>
            <div class="lokasi-block" style="width:45px;height:55px;top:20%;left:55%;"></div>
            <div class="lokasi-block" style="width:70px;height:35px;top:65%;left:20%;"></div>
            <div class="lokasi-block" style="width:50px;height:45px;top:60%;left:72%;"></div>
            <div class="lokasi-block" style="width:40px;height:30px;top:35%;left:78%;"></div>
            <div class="lokasi-road-h"></div>
            <div class="lokasi-road-v"></div>
            <div class="lokasi-road-h2"></div>
            <div class="lokasi-road-v2"></div>
            <div class="lokasi-marker">
              <div style="font-size:2.2rem;filter:drop-shadow(0 2px 4px rgba(0,0,0,.3));">📍</div>
              <div style="background:#fff;border:2px solid var(--primary);border-radius:.6rem;padding:.25rem .7rem;font-size:.75rem;font-weight:700;color:var(--primary);margin-top:.2rem;white-space:nowrap;box-shadow:0 2px 8px rgba(232,64,28,.2);">
                {{ Str::limit($kost->nama_kost, 20) }}
              </div>
              <div class="lokasi-pin-shadow mt-1"></div>
            </div>
          </div>
        </div>

        {{-- REVIEW --}}
        <div id="sec-review" class="section-block" style="scroll-margin-top:120px;">
          <div class="sec-heading">⭐ Review & Rating</div>
          @if($kost->reviews->count() > 0)
            @php $avg = round($kost->reviews->avg('rating'),1); $total = $kost->reviews->count(); @endphp
            <div class="p-4 rounded-3 mb-4 d-flex gap-4 align-items-center" style="background:linear-gradient(135deg,#fffbf0,#fff8e0);border:1px solid #fde68a;">
              <div class="text-center" style="min-width:90px;">
                <div style="font-size:3rem;font-weight:900;color:#f59e0b;line-height:1;">{{ $avg }}</div>
                <div style="font-size:.75rem;color:#888;margin:.2rem 0;">dari 5</div>
                <div style="font-size:.9rem;color:#f59e0b;">
                  @for($i=1;$i<=5;$i++)<i class="bi bi-star{{ $i<=$avg?'-fill':'' }}"></i>@endfor
                </div>
                <div style="font-size:.73rem;color:#888;margin-top:.3rem;">{{ $total }} ulasan</div>
              </div>
              <div style="flex:1;">
                @for($star=5;$star>=1;$star--)
                  @php $cnt = $kost->reviews->where('rating',$star)->count(); $pct = $total>0?($cnt/$total)*100:0; @endphp
                  <div class="d-flex align-items-center gap-2 mb-2">
                    <span style="font-size:.75rem;color:#555;width:12px;">{{ $star }}</span>
                    <i class="bi bi-star-fill" style="color:#f59e0b;font-size:.7rem;flex-shrink:0;"></i>
                    <div class="rating-bar-bg"><div class="rating-bar-fill" style="width:{{ $pct }}%;"></div></div>
                    <span style="font-size:.72rem;color:#888;width:18px;">{{ $cnt }}</span>
                  </div>
                @endfor
              </div>
            </div>
            @foreach($kost->reviews->sortByDesc('created_at')->take(5) as $review)
            <div class="review-card">
              <div class="d-flex gap-3 align-items-start">
                <div class="review-ava">
                  @if($review->user && $review->user->foto_profil)
                    <img src="{{ asset('storage/'.$review->user->foto_profil) }}" style="width:100%;height:100%;object-fit:cover;" alt="">
                  @else
                    {{ strtoupper(substr($review->user->name ?? 'A', 0, 1)) }}
                  @endif
                </div>
                <div style="flex:1;">
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="fw-bold" style="font-size:.87rem;">{{ $review->user->name ?? 'Anonim' }}</div>
                    <div style="font-size:.73rem;color:#bbb;">{{ $review->created_at->diffForHumans() }}</div>
                  </div>
                  <div style="font-size:.82rem;color:#f59e0b;margin:.25rem 0;">
                    @for($i=1;$i<=5;$i++)<i class="bi bi-star{{ $i<=$review->rating?'-fill':'' }}"></i>@endfor
                  </div>
                  @if($review->komentar)
                    <p style="font-size:.84rem;color:#555;margin:0;line-height:1.55;">{{ $review->komentar }}</p>
                  @endif
                </div>
              </div>
            </div>
            @endforeach
          @else
            <div class="text-center py-5 text-muted">
              <div style="font-size:3rem;margin-bottom:.5rem;">⭐</div>
              <div style="font-size:.9rem;font-weight:600;">Belum ada review</div>
            </div>
          @endif
        </div>

        {{-- PEMILIK --}}
        <div id="sec-pemilik" class="section-block" style="scroll-margin-top:120px;">
          <div class="sec-heading">👤 Pemilik Kos</div>
          <div class="owner-banner">
            <div class="owner-ava" style="width:64px;height:64px;font-size:1.5rem;">
              @if($owner && $owner->foto_profil)
                <img src="{{ asset('storage/'.$owner->foto_profil) }}" style="width:100%;height:100%;object-fit:cover;" alt="">
              @else
                {{ strtoupper(substr($owner->name ?? 'P', 0, 1)) }}
              @endif
            </div>
            <div>
              <div style="font-weight:800;font-size:1rem;color:var(--dark);">{{ $owner->name ?? 'Pemilik Kost' }}</div>
              <div style="font-size:.8rem;color:#888;">Pemilik Kost · KostFinder</div>
              <div style="font-size:.78rem;color:#22c55e;margin-top:.2rem;font-weight:600;"><i class="bi bi-shield-check-fill me-1"></i>Terverifikasi</div>
            </div>
          </div>
        </div>

        {{-- REKOMENDASI --}}
        @if($rekomendasi->count() > 0)
        <div class="section-block" style="border-bottom:none;">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="sec-heading mb-0">🏘️ Kamu Mungkin Menyukainya</div>
            <div class="d-flex gap-2">
              <button class="rekom-nav" id="rekoPrev"><i class="bi bi-chevron-left"></i></button>
              <button class="rekom-nav" id="rekoNext"><i class="bi bi-chevron-right"></i></button>
            </div>
          </div>
          <div class="rekom-track" id="rekoTrack">
            @foreach($rekomendasi as $r)
            <a href="{{ route('kost.show', $r->id_kost) }}" class="rekom-card">
              @if($r->foto_utama)
                <img src="{{ asset('storage/'.$r->foto_utama) }}" class="rekom-thumb" alt="{{ $r->nama_kost }}">
              @else
                <div class="rekom-thumb-ph">🏠</div>
              @endif
              <div class="p-3">
                <div style="font-size:.78rem;color:#888;margin-bottom:.2rem;">🏘️ {{ $r->tipe_kost }}</div>
                <div class="fw-bold" style="font-size:.88rem;color:var(--dark);margin-bottom:.2rem;">{{ Str::limit($r->nama_kost,30) }}</div>
                <div style="font-size:.75rem;color:#888;margin-bottom:.5rem;"><i class="bi bi-geo-alt"></i> {{ $r->kota }}</div>
                <div class="fw-bold" style="color:var(--primary);font-size:.9rem;">
                  Rp {{ number_format($r->harga_mulai,0,',','.') }}
                  <span class="fw-normal text-muted" style="font-size:.73rem;">/bln</span>
                </div>
              </div>
            </a>
            @endforeach
          </div>
        </div>
        @endif

      </div>
      {{-- END KIRI --}}

      {{-- SIDEBAR KANAN --}}
      <div class="col-12 col-lg-4">
        <div class="sidebar-sticky">
          <div class="price-card">
            <div class="mb-3">
              <div class="price-main">Rp {{ number_format($kost->harga_mulai,0,',','.') }}<span class="price-period">/bulan</span></div>
              <small class="text-muted" style="font-size:.75rem;">💰 Harga mulai dari</small>
            </div>

            @auth
            @if(auth()->user()->role === 'user')

{{-- NOTIFIKASI TAGIHAN BELUM BAYAR --}}
@php
  $tagihanBelumBayar = \App\Models\Booking::where('user_id', auth()->id())
    ->where('status_booking', 'pending')
    ->where('status_pembayaran', 'belum')
    ->with('room.kost')
    ->latest()
    ->first();
@endphp

@if($tagihanBelumBayar)
<div style="background:#fff5f2;border:1.5px solid #ffd0c0;border-radius:.75rem;padding:.85rem 1rem;margin-bottom:1rem;">
  <div style="display:flex;align-items:flex-start;gap:.6rem;">
    <span style="font-size:1.1rem;flex-shrink:0;">⚠️</span>
    <div>
      <div style="font-weight:700;font-size:.82rem;color:#be3f1d;">Tagihan Belum Dibayar!</div>
      <div style="font-size:.75rem;color:#8fa3b8;margin:.2rem 0;">
        Kamu masih punya booking <strong style="color:#e8401c;">{{ $tagihanBelumBayar->room->kost->nama_kost ?? '-' }}</strong> yang belum dibayar.
      </div>
      <a href="{{ route('user.booking.pembayaran', $tagihanBelumBayar->id_booking) }}"
        style="display:inline-block;margin-top:.5rem;background:linear-gradient(135deg,#e8401c,#ff7043);color:#fff;font-size:.75rem;font-weight:700;padding:.35rem .85rem;border-radius:.45rem;text-decoration:none;">
        💳 Segera Bayar →
      </a>
    </div>
  </div>
</div>
@endif



                <form id="formBookingSidebar" action="{{ route('user.booking.store') }}" method="POST">
                  @csrf

                  <input type="hidden" name="room_id" id="sidebarRoomId">
                  <input type="hidden" name="tipe_durasi" id="tipeDurasi" value="bulanan">
                  <input type="hidden" name="jumlah_durasi" id="jumlahDurasi" value="1">

                  {{-- PILIH KAMAR --}}
                  <div class="mb-3">
                    <div style="font-size:.72rem;color:#888;margin-bottom:.4rem;font-weight:600;">🚪 Pilih Kamar</div>
                    @foreach($kost->rooms as $room)
                      <div class="kamar-select-item {{ $room->status_kamar !== 'tersedia' ? 'terisi' : '' }}"
                        id="kamarItem{{ $room->id_room }}"
                        data-harga-bulanan="{{ $room->harga_per_bulan ?? 0 }}"
                        data-harga-harian="{{ $room->harga_harian ?? 0 }}"
                        data-aktif-harian="{{ $room->aktif_harian ? '1' : '0' }}"
                        data-aktif-bulanan="{{ $room->aktif_bulanan ? '1' : '0' }}"
                        onclick="{{ $room->status_kamar === 'tersedia' ? 'pilihKamar('.$room->id_room.', this)' : '' }}">
                        <div class="d-flex justify-content-between align-items-center">
                          <div>
                            <div style="font-size:.82rem;font-weight:700;">Kamar {{ $room->nomor_kamar }}</div>
                            @if($room->tipe_kamar)<div style="font-size:.72rem;color:#888;">{{ $room->tipe_kamar }}</div>@endif
                          </div>
                          <div class="text-end">
                            @if($room->aktif_bulanan && $room->harga_per_bulan)
                              <div style="font-size:.78rem;font-weight:700;color:var(--primary);">Rp {{ number_format($room->harga_per_bulan,0,',','.') }}/bln</div>
                            @endif
                            @if($room->aktif_harian && $room->harga_harian)
                              <div style="font-size:.72rem;color:#d97706;">Rp {{ number_format($room->harga_harian,0,',','.') }}/hari</div>
                            @endif
                            <span class="{{ $room->status_kamar === 'tersedia' ? 'status-tersedia' : 'status-terisi' }}" style="font-size:.68rem;">
                              {{ $room->status_kamar === 'tersedia' ? '✅ Tersedia' : '❌ Terisi' }}
                            </span>
                          </div>
                        </div>
                      </div>
                    @endforeach
                  </div>

                  {{-- TIPE DURASI --}}
                  <div class="mb-2" id="wrapTipeDurasi" style="display:none;">
                    <div style="font-size:.72rem;color:#888;margin-bottom:.4rem;font-weight:600;">⏱️ Tipe Sewa</div>
                    <div style="display:flex;gap:.5rem;">
                      <div id="btnBulanan" class="tipe-durasi-btn active" onclick="pilihTipeDurasi('bulanan')">
                        <div class="tipe-label">🗓️ Bulanan</div>
                        <div class="tipe-harga" id="hargaBulananLabel">-</div>
                      </div>
                      <div id="btnHarian" class="tipe-durasi-btn disabled" onclick="pilihTipeDurasi('harian')">
                        <div class="tipe-label">📅 Harian</div>
                        <div class="tipe-harga" id="hargaHarianLabel">-</div>
                      </div>
                    </div>
                  </div>

                  {{-- JUMLAH DURASI --}}
                  <div class="mb-2" id="wrapJumlah" style="display:none;">
                    <div style="font-size:.72rem;color:#888;margin-bottom:.3rem;font-weight:600;" id="labelJumlah">📆 Jumlah Bulan</div>
                    <div style="display:flex;align-items:center;gap:.4rem;">
                      <button type="button" class="jumlah-btn" onclick="ubahJumlah(-1)">−</button>
                      <input type="text" id="jumlahDisplay" value="1" readonly
                        style="flex:1;text-align:center;border:1px solid #e4e9f0;border-radius:.45rem;padding:.4rem;font-size:.88rem;font-weight:700;background:#f8fafd;">
                      <button type="button" class="jumlah-btn" onclick="ubahJumlah(1)">+</button>
                    </div>
                  </div>

                  {{-- TANGGAL CHECK-IN --}}
<div class="mb-2" id="wrapTanggal" style="display:none;">
<div style="font-size:.7rem;color:#8fa3b8;margin-top:.3rem;">⏰ Waktu Indonesia Barat (WIB)</div>
  <div style="font-size:.72rem;color:#888;margin-bottom:.3rem;font-weight:600;">📅 Tanggal Check-in</div>
  <div style="display:flex;gap:.5rem;">
    <input type="date" name="tanggal_masuk" id="tanggalMasuk" class="booking-input"
      min="{{ date('Y-m-d') }}" required onchange="hitungCheckout()" style="flex:1;">
    <input type="time" name="jam_masuk" id="jamMasuk" class="booking-input"
      style="width:110px;" onchange="hitungCheckout()">
  </div>
</div>

                  {{-- CHECK-OUT OTOMATIS --}}
                  <div class="mb-3 pb-3" id="wrapCheckout" style="display:none;border-bottom:1px solid #f0f3f8;">
                    <div style="font-size:.72rem;color:#888;margin-bottom:.3rem;font-weight:600;">🏁 Tanggal Check-out</div>
                    <div id="checkoutDisplay" class="booking-input" style="background:#f8fafd;color:#aaa;">
                      Otomatis dihitung
                    </div>
                  </div>

                  {{-- RINGKASAN HARGA --}}
                  <div id="ringkasanWrap" style="display:none;margin-bottom:.8rem;">
                    <div style="font-size:.78rem;font-weight:700;color:#444;margin-bottom:.5rem;">📋 Ringkasan Harga</div>
                    <div style="background:#f8fafd;border-radius:.65rem;padding:.8rem;">
                      <div class="d-flex justify-content-between mb-2" style="font-size:.78rem;">
                        <span style="color:#666;" id="ringkasanLabel">-</span>
                        <span style="font-weight:600;" id="ringkasanHarga">-</span>
                      </div>
                      <div class="d-flex justify-content-between mb-2" style="font-size:.78rem;">
                        <span style="color:#666;">Biaya layanan (5%)</span>
                        <span style="font-weight:600;" id="ringkasanLayanan">-</span>
                      </div>
                      <div style="border-top:1px solid #e4e9f0;margin:.5rem 0;"></div>
                      <div class="d-flex justify-content-between" style="font-size:.85rem;">
                        <span style="font-weight:700;color:#1e2d3d;">Total</span>
                        <span style="font-weight:800;color:var(--primary);" id="ringkasanTotal">-</span>
                      </div>
                    </div>
                  </div>

                  {{-- TOMBOL SUBMIT --}}
                  <button type="submit" class="btn-sewa mb-2" id="btnAjukanSewa" disabled>
                    💳 Bayar Sekarang
                  </button>

                </form>

                <button class="btn-tanya" onclick="alert('Fitur chat segera hadir!')">💬 Tanya Pemilik</button>

                <div class="mt-2" style="font-size:.72rem;color:#8fa3b8;line-height:1.5;">
                  <div>✅ Pembatalan gratis hingga 24 jam sebelum check-in</div>
                  <div>✅ Konfirmasi booking menunggu owner</div>
                  <div>✅ Customer support 24/7</div>
                </div>

              @endif
            @else
              <a href="{{ route('login') }}" class="btn-sewa text-decoration-none mb-2">🔑 Login untuk Sewa</a>
            @endauth

            <div class="text-center mt-3" style="font-size:.73rem;color:#8fa3b8;">
              <i class="bi bi-shield-check text-success me-1"></i> Kost telah diverifikasi admin KostFinder
            </div>
          </div>

          {{-- RATING MINI --}}
          @if($kost->reviews->count() > 0)
          <div class="mt-3 p-3 bg-white rounded-3 border" style="border-color:#e4e9f0!important;">
            <div class="d-flex align-items-center gap-2">
              <span style="font-size:1.3rem;font-weight:800;color:#f59e0b;">{{ round($kost->reviews->avg('rating'),1) }}</span>
              <div>
                <div style="font-size:.78rem;color:#f59e0b;">
                  @for($i=1;$i<=5;$i++)<i class="bi bi-star{{ $i<=round($kost->reviews->avg('rating'))?'-fill':'' }}"></i>@endfor
                </div>
                <div style="font-size:.72rem;color:#888;">{{ $kost->reviews->count() }} ulasan penghuni</div>
              </div>
            </div>
          </div>
          @endif

          {{-- STATISTIK KAMAR --}}
          <div class="mt-3 p-3 bg-white rounded-3 border" style="border-color:#e4e9f0!important;">
            <div class="row g-0 text-center">
              <div class="col-6 py-2" style="border-right:1px solid #f0f3f8;">
                <div style="font-size:1.4rem;font-weight:800;color:var(--primary);">{{ $kost->rooms->where('status_kamar','tersedia')->count() }}</div>
                <div style="font-size:.73rem;color:#888;">🔑 Kamar Tersedia</div>
              </div>
              <div class="col-6 py-2">
                <div style="font-size:1.4rem;font-weight:800;color:var(--dark);">{{ $kost->rooms->count() }}</div>
                <div style="font-size:.73rem;color:#888;">🏠 Total Kamar</div>
              </div>
            </div>
          </div>

        </div>
      </div>
      {{-- END SIDEBAR --}}

    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

  // ==============================
  // TAB SMOOTH SCROLL
  // ==============================
  document.querySelectorAll('.tab-nav-scroll a[href^="#"]').forEach(link => {
    link.addEventListener('click', function(e) {
      e.preventDefault();
      const target = document.querySelector(this.getAttribute('href'));
      if (target) {
        window.scrollTo({
          top: target.getBoundingClientRect().top + window.scrollY - 125,
          behavior: 'smooth'
        });
      }
    });
  });

  // ==============================
  // HIGHLIGHT TAB AKTIF SAAT SCROLL
  // ==============================
  const sections = document.querySelectorAll('[id^="sec-"]');
  const navLinks = document.querySelectorAll('.tab-nav-scroll a');

  window.addEventListener('scroll', () => {
    let current = '';
    sections.forEach(sec => {
      if (window.scrollY >= sec.offsetTop - 140) {
        current = sec.id;
      }
    });
    navLinks.forEach(link => {
      link.classList.toggle('active', link.getAttribute('href') === '#' + current);
    });
  });

  // ==============================
  // REKOMENDASI SLIDER
  // ==============================
  const rekoTrack = document.getElementById('rekoTrack');
  const rekoPrev = document.getElementById('rekoPrev');
  const rekoNext = document.getElementById('rekoNext');

  if (rekoPrev && rekoTrack) {
    rekoPrev.addEventListener('click', () => {
      rekoTrack.scrollBy({ left: -260, behavior: 'smooth' });
    });
  }

  if (rekoNext && rekoTrack) {
    rekoNext.addEventListener('click', () => {
      rekoTrack.scrollBy({ left: 260, behavior: 'smooth' });
    });
  }

  // ==============================
  // STATE BOOKING
  // ==============================
  let selectedRoomId = '';
  let selectedHargaBulanan = 0;
  let selectedHargaHarian = 0;
  let selectedAktifHarian = false;
  let selectedAktifBulanan = false;
  let currentTipe = 'bulanan';
  let currentJumlah = 1;
  let selectedHarga = 0;

  // ==============================
  // HELPER ELEMENT
  // ==============================
  function el(id) {
    return document.getElementById(id);
  }

  // ==============================
  // PILIH KAMAR + SCROLL
  // ==============================
  window.pilihKamarDanScroll = function(roomId) {
    const targetEl = el('kamarItem' + roomId);
    if (targetEl) {
      pilihKamar(roomId, targetEl);
    }
    const formBooking = el('formBookingSidebar');
    if (formBooking) {
      formBooking.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
  };

  // ==============================
  // PILIH KAMAR
  // ==============================
  window.pilihKamar = function(roomId, clickedEl) {
    document.querySelectorAll('.kamar-select-item').forEach(item => {
      item.classList.remove('selected');
    });

    if (!clickedEl) return;

    clickedEl.classList.add('selected');

    selectedRoomId = roomId;
    selectedHargaBulanan = parseInt(clickedEl.dataset.hargaBulanan || 0);
    selectedHargaHarian = parseInt(clickedEl.dataset.hargaHarian || 0);
    selectedAktifHarian = clickedEl.dataset.aktifHarian === '1';
    selectedAktifBulanan = clickedEl.dataset.aktifBulanan === '1';

    if (el('sidebarRoomId')) {
      el('sidebarRoomId').value = roomId;
    }

    if (el('hargaBulananLabel')) {
      el('hargaBulananLabel').textContent =
        (selectedAktifBulanan && selectedHargaBulanan > 0)
          ? 'Rp ' + selectedHargaBulanan.toLocaleString('id-ID') + '/bln'
          : 'Tidak tersedia';
    }

    if (el('hargaHarianLabel')) {
      el('hargaHarianLabel').textContent =
        (selectedAktifHarian && selectedHargaHarian > 0)
          ? 'Rp ' + selectedHargaHarian.toLocaleString('id-ID') + '/hari'
          : 'Tidak tersedia';
    }

    const btnBulanan = el('btnBulanan');
    const btnHarian = el('btnHarian');

    if (btnBulanan) {
      if (selectedAktifBulanan && selectedHargaBulanan > 0) {
        btnBulanan.classList.remove('disabled');
      } else {
        btnBulanan.classList.add('disabled');
      }
    }

    if (btnHarian) {
      if (selectedAktifHarian && selectedHargaHarian > 0) {
        btnHarian.classList.remove('disabled');
      } else {
        btnHarian.classList.add('disabled');
      }
    }

    if (selectedAktifBulanan && selectedHargaBulanan > 0) {
      currentTipe = 'bulanan';
    } else if (selectedAktifHarian && selectedHargaHarian > 0) {
      currentTipe = 'harian';
    }

    if (el('wrapTipeDurasi')) el('wrapTipeDurasi').style.display = 'block';
    if (el('wrapJumlah')) el('wrapJumlah').style.display = 'block';
    if (el('wrapTanggal')) el('wrapTanggal').style.display = 'block';
    if (el('wrapCheckout')) el('wrapCheckout').style.display = 'block';

    pilihTipeDurasi(currentTipe);
  };

  // ==============================
  // PILIH TIPE DURASI
  // ==============================
  window.pilihTipeDurasi = function(tipe) {
    const btnBulanan = el('btnBulanan');
    const btnHarian = el('btnHarian');

    if (tipe === 'bulanan' && (!selectedAktifBulanan || selectedHargaBulanan <= 0)) return;
    if (tipe === 'harian' && (!selectedAktifHarian || selectedHargaHarian <= 0)) return;

    currentTipe = tipe;

    if (el('tipeDurasi')) el('tipeDurasi').value = tipe;

    if (btnBulanan) btnBulanan.classList.remove('active');
    if (btnHarian) btnHarian.classList.remove('active');

    if (tipe === 'bulanan') {
      if (btnBulanan) btnBulanan.classList.add('active');
      selectedHarga = selectedHargaBulanan;
      if (el('labelJumlah')) el('labelJumlah').textContent = '📆 Jumlah Bulan';
    } else {
      if (btnHarian) btnHarian.classList.add('active');
      selectedHarga = selectedHargaHarian;
      if (el('labelJumlah')) el('labelJumlah').textContent = '📅 Jumlah Hari';
    }

    currentJumlah = 1;
    if (el('jumlahDisplay')) el('jumlahDisplay').value = 1;
    if (el('jumlahDurasi')) el('jumlahDurasi').value = 1;

    hitungCheckout();
  };

  // ==============================
  // UBAH JUMLAH
  // ==============================
  window.ubahJumlah = function(delta) {
    const max = currentTipe === 'bulanan' ? 24 : 30;
    currentJumlah = Math.min(max, Math.max(1, currentJumlah + delta));
    if (el('jumlahDisplay')) el('jumlahDisplay').value = currentJumlah;
    if (el('jumlahDurasi')) el('jumlahDurasi').value = currentJumlah;
    hitungCheckout();
  };

  // ==============================
  // HITUNG CHECKOUT
  // ==============================
  window.hitungCheckout = function() {
  const tanggalMasuk = el('tanggalMasuk') ? el('tanggalMasuk').value : '';
  const jamMasuk = el('jamMasuk') ? el('jamMasuk').value : '12:00';
  const jumlah = currentJumlah;

  if (el('checkoutDisplay')) {
    el('checkoutDisplay').textContent = 'Otomatis dihitung';
    el('checkoutDisplay').style.color = '#aaa';
  }

  if (tanggalMasuk) {
    const checkin = new Date(tanggalMasuk + 'T' + (jamMasuk || '12:00') + ':00');
    const checkout = new Date(checkin);

    if (currentTipe === 'bulanan') {
      checkout.setMonth(checkout.getMonth() + jumlah);
    } else {
      checkout.setDate(checkout.getDate() + jumlah);
    }

    const opts = { day: 'numeric', month: 'long', year: 'numeric' };
    const tglCheckout = checkout.toLocaleDateString('id-ID', opts);
    const jamCheckout = String(checkout.getHours()).padStart(2, '0') + ':' + String(checkout.getMinutes()).padStart(2, '0');

    if (el('checkoutDisplay')) {
      el('checkoutDisplay').textContent = `${tglCheckout}, pukul ${jamCheckout} WIB`;
      el('checkoutDisplay').style.color = '#333';
    }
  }

  if (selectedHarga > 0) {
    const subtotal = selectedHarga * jumlah;
    const biayaLayanan = Math.round(subtotal * 0.05);
    const total = subtotal + biayaLayanan;
    const satuanLabel = currentTipe === 'bulanan' ? 'bulan' : 'hari';

    if (el('ringkasanWrap')) el('ringkasanWrap').style.display = 'block';
    if (el('ringkasanLabel')) el('ringkasanLabel').textContent = `Harga kamar × ${jumlah} ${satuanLabel}`;
    if (el('ringkasanHarga')) el('ringkasanHarga').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
    if (el('ringkasanLayanan')) el('ringkasanLayanan').textContent = 'Rp ' + biayaLayanan.toLocaleString('id-ID');
    if (el('ringkasanTotal')) el('ringkasanTotal').textContent = 'Rp ' + total.toLocaleString('id-ID');
  } else {
    if (el('ringkasanWrap')) el('ringkasanWrap').style.display = 'none';
  }

  cekFormReady();
};
  // ==============================
  // CEK FORM SIAP
  // ==============================
  function cekFormReady() {
    const tgl = el('tanggalMasuk') ? el('tanggalMasuk').value : '';
    const kamar = el('sidebarRoomId') ? el('sidebarRoomId').value : '';
    const ready = !!(tgl && kamar && selectedHarga > 0);

    const btn = el('btnAjukanSewa');
    if (btn) {
      btn.disabled = !ready;
      btn.style.opacity = ready ? '1' : '.6';
      btn.style.cursor = ready ? 'pointer' : 'not-allowed';
    }
  }

// ==============================
// SET TANGGAL DEFAULT HARI INI (WIB)
// ==============================
(function setTanggalDefault() {
  const inputTgl = el('tanggalMasuk');
  const inputJam = el('jamMasuk');
  if (!inputTgl) return;

  const now = new Date();
  const jakartaOffset = 7 * 60;
  const utc = now.getTime() + (now.getTimezoneOffset() * 60000);
  const jakartaTime = new Date(utc + (jakartaOffset * 60000));

  const yyyy = jakartaTime.getFullYear();
  const mm = String(jakartaTime.getMonth() + 1).padStart(2, '0');
  const dd = String(jakartaTime.getDate()).padStart(2, '0');
  const hh = String(jakartaTime.getHours()).padStart(2, '0');
  const min = String(jakartaTime.getMinutes()).padStart(2, '0');

  const hariIni = `${yyyy}-${mm}-${dd}`;
  const jamSekarang = `${hh}:${min}`;

  inputTgl.value = hariIni;
  inputTgl.min = hariIni;

  if (inputJam) {
    inputJam.value = jamSekarang;
  }
})();

  // ==============================
  // EVENT TANGGAL
  // ==============================
  if (el('tanggalMasuk')) {
    el('tanggalMasuk').addEventListener('change', hitungCheckout);
  }

});
window.openFasilitas = function(button) {
  const popup = document.getElementById('fasilitasPopup');
  const content = document.getElementById('fasilitasContent');

  let fasilitas = [];

  try {
    fasilitas = JSON.parse(button.dataset.fasilitas || '[]');
  } catch (e) {
    fasilitas = [];
  }

  let html = `
    <div style="background:#fff;padding:1.2rem 1.4rem;border-radius:1rem;max-width:420px;width:90%;box-shadow:0 10px 30px rgba(0,0,0,.15);">
      <h5 style="margin-bottom:1rem;font-weight:800;">Fasilitas Kamar</h5>
      <ul style="padding-left:1.2rem;margin-bottom:1rem;">
  `;

  if (fasilitas.length > 0) {
    fasilitas.forEach(item => {
      html += `<li style="margin-bottom:.4rem;">${item}</li>`;
    });
  } else {
    html += `<li>Tidak ada fasilitas</li>`;
  }

  html += `
      </ul>
      <button type="button" onclick="closeFasilitas()" 
        style="background:#e8401c;color:#fff;border:none;padding:.55rem 1rem;border-radius:.6rem;font-weight:700;cursor:pointer;">
        Tutup
      </button>
    </div>
  `;

  content.innerHTML = html;
  popup.style.display = 'flex';
};

window.closeFasilitas = function() {
  document.getElementById('fasilitasPopup').style.display = 'none';
  document.getElementById('fasilitasContent').innerHTML = '';
};
window.closeFasilitas = function() {
  document.getElementById('fasilitasPopup').style.display = 'none';
}
// ══ LIGHTBOX ══
const lbFotos = @json($semuaFoto->values());
let lbIdx = 0;
let lbAllOpen = false;

function bukaLightbox(idx) {
    lbIdx = idx;
    document.getElementById('lightboxOverlay').classList.add('aktif');
    document.body.style.overflow = 'hidden';
    lbRender();
}

function tutupLightbox() {
    document.getElementById('lightboxOverlay').classList.remove('aktif');
    document.body.style.overflow = '';
}

function lbNav(dir) {
    lbIdx = (lbIdx + dir + lbFotos.length) % lbFotos.length;
    lbRender();
}

function lbGoto(idx) {
    lbIdx = idx;
    lbRender();
}

function lbRender() {
    const foto = lbFotos[lbIdx];
    const img = document.getElementById('lbImg');
    img.style.opacity = '0';
    setTimeout(() => {
        img.src = '{{ asset("storage/") }}/' + foto.path;
        img.style.opacity = '1';
    }, 150);
    document.getElementById('lbTitle').textContent = 'Foto ' + (lbIdx+1) + ' dari ' + lbFotos.length;
    document.getElementById('lbLabel').textContent = foto.label;

    document.querySelectorAll('[id^="lbThumb"]').forEach((el,i) => {
        el.style.opacity = i === lbIdx ? '1' : '.5';
        el.style.borderColor = i === lbIdx ? '#e8401c' : 'transparent';
    });

    const thumb = document.getElementById('lbThumb' + lbIdx);
    if(thumb) thumb.scrollIntoView({ behavior:'smooth', inline:'center', block:'nearest' });
}

function toggleLbAll() {
    lbAllOpen = !lbAllOpen;
    const sec = document.getElementById('lbAllSection');
    const btn = document.getElementById('btnLbAll');
    sec.style.maxHeight = lbAllOpen ? '300px' : '0';
    btn.textContent = lbAllOpen ? 'Sembunyikan ↑' : 'Lihat Semua Foto ↓';
}

function scrollToLbTop() {
    document.getElementById('lbImg').scrollIntoView({ behavior:'smooth', block:'center' });
}

document.addEventListener('keydown', e => {
    if(!document.getElementById('lightboxOverlay').classList.contains('aktif')) return;
    if(e.key === 'ArrowLeft') lbNav(-1);
    if(e.key === 'ArrowRight') lbNav(1);
    if(e.key === 'Escape') tutupLightbox();
});
</script>
@endsection