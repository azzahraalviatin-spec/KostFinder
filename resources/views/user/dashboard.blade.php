@extends('layouts.user-sidebar')

@section('title', 'Dashboard')

@section('styles')
<style>
  :root { --primary: #D0783B; --dark: #1e2d3d; }

  .dash-greeting {
    background: linear-gradient(135deg, #D0783B 0%, #e8975a 100%);
    border-radius: 1rem; padding: 1.4rem 1.75rem; color: #fff;
    margin-bottom: 1.25rem; position: relative; overflow: hidden;
  }
  .dash-greeting::after { content:''; position:absolute; right:-20px; top:-20px; width:160px; height:160px; border-radius:50%; background:rgba(255,255,255,.08); }
  .dash-greeting::before { content:''; position:absolute; right:60px; bottom:-30px; width:100px; height:100px; border-radius:50%; background:rgba(255,255,255,.06); }
  .dash-greeting-title { font-size:1.2rem; font-weight:800; margin-bottom:.2rem; position:relative; z-index:1; }
  .dash-greeting-sub   { font-size:.83rem; opacity:.85; position:relative; z-index:1; }
  .dash-greeting-date  { font-size:.76rem; opacity:.7; margin-top:.4rem; display:flex; align-items:center; gap:.3rem; position:relative; z-index:1; }

  /* PENGINGAT BAYAR */
  .alert-bayar {
    background: linear-gradient(135deg, #fff7ed, #fff3e0);
    border: 1.5px solid #fed7aa; border-left: 4px solid #ea580c;
    border-radius: .85rem; padding: 1rem 1.2rem;
    margin-bottom: 1.25rem; display: flex; align-items: center;
    gap: 1rem; flex-wrap: wrap;
  }
  .alert-bayar-icon {
    width:40px; height:40px; background:#ea580c; border-radius:50%;
    display:flex; align-items:center; justify-content:center;
    color:#fff; font-size:1.1rem; flex-shrink:0;
    animation: pulse 2s infinite;
  }
  @keyframes pulse {
    0%,100% { box-shadow: 0 0 0 0 rgba(234,88,12,.4); }
    50%      { box-shadow: 0 0 0 8px rgba(234,88,12,0); }
  }
  .alert-bayar-info { flex:1; min-width:0; }
  .alert-bayar-title { font-weight:800; font-size:.88rem; color:#c2410c; }
  .alert-bayar-sub   { font-size:.78rem; color:#9a3412; margin-top:.15rem; }
  .alert-bayar-countdown { background:#ea580c; color:#fff; font-weight:800; font-size:.73rem; padding:.18rem .65rem; border-radius:99px; margin-top:.3rem; display:inline-block; }
  .btn-bayar-now {
    background:#ea580c; color:#fff; border:0; border-radius:.6rem;
    padding:.45rem 1.1rem; font-size:.78rem; font-weight:700;
    cursor:pointer; text-decoration:none; transition:background .18s;
    white-space:nowrap; display:inline-flex; align-items:center; gap:.3rem;
  }
  .btn-bayar-now:hover { background:#c2410c; color:#fff; }

  /* STAT CARDS */
  .dash-stats { display:grid; grid-template-columns:repeat(3,1fr); gap:.85rem; margin-bottom:1.25rem; }
  @media(max-width:576px){ .dash-stats{ grid-template-columns:1fr; } }
  .stat-card { background:#fff; border-radius:.85rem; padding:1rem 1.1rem; border:1px solid #edf0f7; display:flex; align-items:center; gap:.8rem; transition:box-shadow .2s; }
  .stat-card:hover { box-shadow:0 6px 20px rgba(0,0,0,.07); }
  .stat-icon { width:42px; height:42px; border-radius:.7rem; display:flex; align-items:center; justify-content:center; font-size:1.1rem; flex-shrink:0; }
  .stat-icon.orange { background:#fff7ed; color:#ea580c; }
  .stat-icon.yellow { background:#fffbeb; color:#d97706; }
  .stat-icon.blue   { background:#eff6ff; color:#3b82f6; }
  .stat-num   { font-size:1.4rem; font-weight:800; color:var(--dark); line-height:1; }
  .stat-label { font-size:.74rem; color:#8fa3b8; font-weight:600; margin-top:.12rem; }

  /* SECTION TITLE */
  .dash-sec { font-size:.9rem; font-weight:800; color:var(--dark); margin-bottom:.85rem; display:flex; align-items:center; gap:.45rem; }
  .dash-sec a { margin-left:auto; font-size:.76rem; font-weight:600; color:var(--primary); text-decoration:none; }
  .dash-sec a:hover { text-decoration:underline; }

  /* QUICK LINKS */
  .quick-links { display:grid; grid-template-columns:repeat(4,1fr); gap:.65rem; margin-bottom:1.25rem; }
  @media(max-width:576px){ .quick-links{ grid-template-columns:repeat(2,1fr); } }
  .quick-item { background:#fff; border-radius:.8rem; border:1px solid #edf0f7; padding:.85rem; text-align:center; text-decoration:none; color:#374151; font-size:.76rem; font-weight:600; transition:all .2s; display:flex; flex-direction:column; align-items:center; gap:.4rem; }
  .quick-item i { font-size:1.3rem; color:var(--primary); }
  .quick-item:hover { border-color:var(--primary); color:var(--primary); box-shadow:0 4px 14px rgba(208,120,59,.15); }

  /* BOOKING GRID 4 KOLOM */
  .booking-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:.75rem; margin-bottom:1.25rem; }
  @media(max-width:900px){ .booking-grid{ grid-template-columns:repeat(2,1fr); } }
  @media(max-width:480px){ .booking-grid{ grid-template-columns:1fr; } }

  .bk-card { background:#fff; border-radius:.85rem; border:1px solid #edf0f7; overflow:hidden; transition:all .2s; display:flex; flex-direction:column; }
  .bk-card:hover { box-shadow:0 6px 20px rgba(0,0,0,.09); transform:translateY(-2px); }

  .bk-img { height:95px; background:#f7f3f0; display:flex; align-items:center; justify-content:center; font-size:2rem; overflow:hidden; position:relative; flex-shrink:0; }
  .bk-img img { width:100%; height:100%; object-fit:cover; }
  .bk-img-badge { position:absolute; top:6px; right:6px; font-size:.62rem; font-weight:700; padding:.18rem .55rem; border-radius:99px; }

  .bk-body { flex:1; padding:.7rem .75rem; }
  .bk-name { font-weight:800; font-size:.78rem; color:var(--dark); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
  .bk-loc  { font-size:.68rem; color:#8fa3b8; margin-top:.08rem; display:flex; align-items:center; gap:.2rem; }
  .bk-kamar{ font-size:.68rem; color:#6b7280; margin-top:.15rem; }
  .bk-price{ font-weight:800; font-size:.76rem; color:var(--primary); margin-top:.25rem; }

  .bk-status { display:inline-flex; align-items:center; gap:.2rem; font-size:.63rem; font-weight:700; padding:.15rem .55rem; border-radius:99px; margin-top:.25rem; }
  .bk-status.pending  { background:#fff7ed; color:#ea580c; }
  .bk-status.diterima { background:#f0fdf4; color:#16a34a; }
  .bk-status.selesai  { background:#f0f9ff; color:#0369a1; }
  .bk-status.ditolak  { background:#fef2f2; color:#dc2626; }
  .bk-status.batal    { background:#f8fafd; color:#94a3b8; }

  .bk-actions { padding:.55rem .75rem; border-top:1px solid #f0f3f8; display:flex; gap:.35rem; }
  .bk-btn { flex:1; font-size:.68rem; font-weight:700; padding:.28rem .4rem; border-radius:.4rem; cursor:pointer; text-align:center; text-decoration:none; transition:all .18s; border:0; display:inline-flex; align-items:center; justify-content:center; gap:.2rem; white-space:nowrap; }
  .bk-btn.pay  { background:var(--primary); color:#fff; }
  .bk-btn.pay:hover  { background:#b5622e; color:#fff; }
  .bk-btn.view { background:#f0f4f8; color:#555; border:1.5px solid #e4e9f0; }
  .bk-btn.view:hover { border-color:var(--primary); color:var(--primary); background:#fff; }

  /* REKOMENDASI */
  .rek-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(185px,1fr)); gap:.85rem; margin-bottom:1.25rem; }
  .rek-card { background:#fff; border-radius:.85rem; border:1px solid #edf0f7; overflow:hidden; text-decoration:none; color:inherit; transition:all .2s; display:block; }
  .rek-card:hover { box-shadow:0 8px 24px rgba(0,0,0,.1); transform:translateY(-2px); color:inherit; }
  .rek-img { height:120px; background:#f7f3f0; overflow:hidden; position:relative; }
  .rek-img img { width:100%; height:100%; object-fit:cover; }
  .rek-badge { position:absolute; top:7px; left:7px; background:var(--primary); color:#fff; font-size:.65rem; font-weight:700; padding:2px 7px; border-radius:99px; }
  .rek-body { padding:.7rem; }
  .rek-name  { font-weight:700; font-size:.82rem; color:var(--dark); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
  .rek-loc   { font-size:.72rem; color:#8fa3b8; margin-top:.15rem; display:flex; align-items:center; gap:.25rem; }
  .rek-price { font-weight:800; font-size:.82rem; color:var(--primary); margin-top:.35rem; }

  /* EMPTY */
  .empty-box { background:#fff; border-radius:.85rem; border:1px solid #edf0f7; padding:2rem; text-align:center; color:#8fa3b8; margin-bottom:1.25rem; }
  .empty-box i { font-size:2rem; margin-bottom:.5rem; display:block; color:#fde8e3; }
  .empty-box p { font-size:.82rem; margin:0; }
</style>
@endsection

@section('content')
@php
  $user    = auth()->user();
  $hariIni = \Carbon\Carbon::now('Asia/Jakarta')->translatedFormat('l, d F Y');

  $bookingBelumBayar = $bookings->filter(fn($b) =>
    $b->status_booking === 'pending' && ($b->status_pembayaran ?? 'belum') === 'belum'
  )->first();

  $bookingMenunggu = $bookings->filter(fn($b) =>
    $b->status_booking === 'pending' && ($b->status_pembayaran ?? '') === 'menunggu'
  )->first();

  $statusLabel = ['pending'=>'Menunggu','diterima'=>'Diterima','selesai'=>'Selesai','ditolak'=>'Ditolak','batal'=>'Dibatal'];
  $statusIcon  = ['pending'=>'⏳','diterima'=>'✅','selesai'=>'🏁','ditolak'=>'❌','batal'=>'🚫'];
@endphp

{{-- GREETING --}}
<div class="dash-greeting">
  <div class="dash-greeting-title">Halo, {{ explode(' ', $user->name)[0] }}! 👋</div>
  <div class="dash-greeting-sub">Selamat datang di KostFinder. Temukan kos impianmu hari ini!</div>
  <div class="dash-greeting-date"><i class="bi bi-calendar3"></i> {{ $hariIni }}</div>
</div>

{{-- PENGINGAT BAYAR --}}
@if($bookingBelumBayar)
@php
  $kostName = $bookingBelumBayar->room->kost->nama_kost ?? 'Kos';
  $sisaHari = \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($bookingBelumBayar->tanggal_masuk), false);
@endphp
<div class="alert-bayar">
  <div class="alert-bayar-icon"><i class="bi bi-exclamation-lg"></i></div>
  <div class="alert-bayar-info">
    <div class="alert-bayar-title">⚠️ Segera Selesaikan Pembayaran!</div>
    <div class="alert-bayar-sub">Booking <strong>{{ $kostName }}</strong> menunggu bukti pembayaran.</div>
    @if($sisaHari > 0)
      <span class="alert-bayar-countdown">⏰ {{ $sisaHari }} hari lagi hingga tanggal masuk</span>
    @else
      <span class="alert-bayar-countdown" style="background:#dc2626;">⏰ Tanggal masuk sudah lewat!</span>
    @endif
  </div>
  <a href="{{ route('user.booking.pembayaran', $bookingBelumBayar->id_booking) }}" class="btn-bayar-now">
    <i class="bi bi-credit-card"></i> Bayar Sekarang
  </a>
</div>
@elseif($bookingMenunggu)
<div class="alert-bayar" style="border-left-color:#d97706;background:linear-gradient(135deg,#fffbeb,#fef9c3);">
  <div class="alert-bayar-icon" style="background:#d97706;animation:none;"><i class="bi bi-clock"></i></div>
  <div class="alert-bayar-info">
    <div class="alert-bayar-title" style="color:#92400e;">⏳ Menunggu Konfirmasi Owner</div>
    <div class="alert-bayar-sub" style="color:#78350f;">Bukti pembayaran <strong>{{ $bookingMenunggu->room->kost->nama_kost ?? 'Kos' }}</strong> sedang diverifikasi.</div>
    <span class="alert-bayar-countdown" style="background:#d97706;">Biasanya 1x24 jam</span>
  </div>
</div>
@endif

{{-- STAT CARDS --}}
<div class="dash-stats">
  <div class="stat-card">
    <div class="stat-icon orange"><i class="bi bi-calendar-check-fill"></i></div>
    <div><div class="stat-num">{{ $totalBooking }}</div><div class="stat-label">Total Pesanan</div></div>
  </div>
  <div class="stat-card">
    <div class="stat-icon yellow"><i class="bi bi-hourglass-split"></i></div>
    <div><div class="stat-num">{{ $bookingPending }}</div><div class="stat-label">Menunggu</div></div>
  </div>
  <div class="stat-card">
    <div class="stat-icon blue"><i class="bi bi-heart-fill"></i></div>
    <div><div class="stat-num">{{ $totalFavorit }}</div><div class="stat-label">Kos Favorit</div></div>
  </div>
</div>

{{-- QUICK LINKS --}}
<div class="dash-sec"><i class="bi bi-lightning-charge-fill" style="color:#d97706;"></i> Akses Cepat</div>
<div class="quick-links">
  <a href="{{ route('kost.cari') }}" class="quick-item"><i class="bi bi-search"></i> Cari Kos</a>
  <a href="{{ route('user.booking.index') }}" class="quick-item"><i class="bi bi-calendar-check-fill"></i> Pesananku</a>
  <a href="{{ route('user.favorit') }}" class="quick-item"><i class="bi bi-heart-fill"></i> Favoritku</a>
  <a href="{{ route('user.profil') }}" class="quick-item"><i class="bi bi-person-circle"></i> Profilku</a>
</div>

{{-- PESANAN TERBARU - GRID 4 KOLOM --}}
<div class="dash-sec">
  <i class="bi bi-calendar-check-fill" style="color:var(--primary);"></i> Pesanan Terbaru
  <a href="{{ route('user.booking.index') }}">Lihat Semua <i class="bi bi-arrow-right"></i></a>
</div>

@if($bookings->count())
<div class="booking-grid">
  @foreach($bookings->take(4) as $booking)
  @php
    $kost = $booking->room->kost ?? null;
    $st   = $booking->status_booking ?? 'pending';
    $belumBayar = $st === 'pending' && ($booking->status_pembayaran ?? 'belum') === 'belum';
    $menungguVerif = ($booking->status_pembayaran ?? '') === 'menunggu';
  @endphp
  <div class="bk-card">
    <div class="bk-img">
      @if($kost && $kost->foto_utama)
        <img src="{{ asset('storage/'.$kost->foto_utama) }}">
      @else
        🏠
      @endif
      @if($belumBayar)
        <span class="bk-img-badge" style="background:#ea580c;color:#fff;">Belum Bayar</span>
      @elseif($menungguVerif)
        <span class="bk-img-badge" style="background:#d97706;color:#fff;">Verifikasi</span>
      @endif
    </div>
    <div class="bk-body">
      <div class="bk-name">{{ $kost->nama_kost ?? '-' }}</div>
      <div class="bk-loc"><i class="bi bi-geo-alt"></i> {{ $kost->kota ?? '-' }}</div>
      <div class="bk-kamar">🚪 Kamar {{ $booking->room->nomor_kamar ?? '-' }}</div>
      <div class="bk-price">Rp {{ number_format($booking->total_harga ?? 0, 0, ',', '.') }}/bln</div>
      <div><span class="bk-status {{ $st }}">{{ ($statusIcon[$st] ?? '') }} {{ $statusLabel[$st] ?? ucfirst($st) }}</span></div>
    </div>
    <div class="bk-actions">
      @if($belumBayar)
        <a href="{{ route('user.booking.pembayaran', $booking->id_booking) }}" class="bk-btn pay">💳 Bayar</a>
      @elseif($kost)
        <a href="{{ route('kost.show', $kost->id_kost) }}" class="bk-btn view">🏠 Lihat</a>
      @endif
      <a href="{{ route('user.booking.index') }}" class="bk-btn view">📋 Detail</a>
    </div>
  </div>
  @endforeach
</div>
@else
<div class="empty-box">
  <i class="bi bi-calendar-x"></i>
  <p>Belum ada pesanan. <a href="{{ route('kost.cari') }}" style="color:var(--primary);font-weight:700;">Cari kos sekarang!</a></p>
</div>
@endif



@endsection