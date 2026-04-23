<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail Booking - KostFinder</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    :root { --sidebar-w:200px; --sidebar-col:60px; --primary:#e8401c; --dark:#1e2d3d; --bg:#f0f4f8; }
    * { margin:0; padding:0; box-sizing:border-box; }
    body { font-family:'Plus Jakarta Sans',sans-serif; background:var(--bg); display:flex; min-height:100vh; }
    .sidebar { width:var(--sidebar-w); min-height:100vh; background:var(--dark); position:fixed; top:0; left:0; display:flex; flex-direction:column; z-index:200; transition:width .3s ease; overflow:hidden; }
    .sidebar.collapsed { width:var(--sidebar-col); }
    .sidebar-brand { padding:1.2rem .9rem; border-bottom:1px solid rgba(255,255,255,.08); display:flex; align-items:center; gap:.6rem; min-height:60px; white-space:nowrap; }
    .brand-icon { width:32px; height:32px; flex-shrink:0; background:var(--primary); border-radius:.5rem; display:flex; align-items:center; justify-content:center; font-size:1rem; }
    .brand-text { overflow:hidden; transition:opacity .2s; }
    .brand-text .name { font-size:1rem; font-weight:800; color:#fff; }
    .brand-text .name span { color:var(--primary); }
    .brand-text .sub { font-size:.65rem; color:#7a92aa; }
    .sidebar.collapsed .brand-text { opacity:0; width:0; }
    .sidebar-menu { padding:.7rem .5rem; flex:1; }
    .menu-label { font-size:.6rem; font-weight:700; letter-spacing:.1em; color:#7a92aa; padding:.5rem .5rem .2rem; white-space:nowrap; transition:opacity .2s; }
    .sidebar.collapsed .menu-label { opacity:0; }
    .menu-item { display:flex; align-items:center; gap:.65rem; padding:.58rem .65rem; border-radius:.55rem; color:#a0b4c4; text-decoration:none; font-size:.82rem; font-weight:500; margin-bottom:.1rem; transition:all .2s; white-space:nowrap; cursor:pointer; border:0; background:none; width:100%; text-align:left; }
    .menu-item i { font-size:.95rem; width:20px; flex-shrink:0; }
    .menu-item span { overflow:hidden; transition:opacity .2s; }
    .sidebar.collapsed .menu-item span { opacity:0; width:0; }
    .menu-item:hover { background:rgba(255,255,255,.07); color:#fff; }
    .menu-item.active { background:var(--primary); color:#fff; }
    .menu-item.logout { color:#f87171; }
    .menu-item.logout:hover { background:rgba(248,113,113,.1); }
    .sidebar-user { padding:.85rem .9rem; border-top:1px solid rgba(255,255,255,.08); display:flex; align-items:center; gap:.6rem; white-space:nowrap; }
    .user-avatar { width:32px; height:32px; border-radius:50%; background:var(--primary); color:#fff; font-weight:700; font-size:.8rem; flex-shrink:0; display:flex; align-items:center; justify-content:center; }
    .user-info { overflow:hidden; transition:opacity .2s; }
    .sidebar.collapsed .user-info { opacity:0; width:0; }
    .user-name { color:#fff; font-size:.8rem; font-weight:600; }
    .user-role { color:#7a92aa; font-size:.68rem; }
    .main { margin-left:var(--sidebar-w); flex:1; transition:margin-left .3s ease; display:flex; flex-direction:column; }
    .main.collapsed { margin-left:var(--sidebar-col); }
    .topbar { background:#fff; height:60px; padding:0 1.5rem; display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid #e4e9f0; position:sticky; top:0; z-index:100; }
    .topbar-right { display:flex; align-items:center; gap:.6rem; }
    .icon-btn { width:34px; height:34px; border-radius:.5rem; background:#f0f4f8; border:1px solid #dde3ed; display:flex; align-items:center; justify-content:center; color:#555; font-size:.9rem; cursor:pointer; text-decoration:none; }
    .content { padding:1.5rem; flex:1; }
    .owner-footer { background:#fff; border-top:1px solid #e4e9f0; padding:.8rem 1.5rem; text-align:center; color:#8fa3b8; font-size:.72rem; }
    .back-link { font-size:.82rem; font-weight:700; color:#fff; text-decoration:none; display:inline-flex; align-items:center; gap:.4rem; margin-bottom:1.25rem; padding:.45rem .9rem; background:linear-gradient(135deg,#e8401c,#fb923c); border:none; border-radius:99px; transition:all .2s; box-shadow:0 3px 10px rgba(232,64,28,.25); }
    .back-link:hover { transform:translateY(-1px); box-shadow:0 6px 16px rgba(232,64,28,.35); color:#fff; }
    .detail-grid { display:grid; grid-template-columns:1fr 320px; gap:1.25rem; align-items:start; }
    .main-card { background:#fff; border-radius:20px; border:1px solid #e4e9f0; overflow:hidden; }
    .hero-banner { background:linear-gradient(135deg,#1e2d3d 0%,#2d4a6b 100%); padding:1.5rem 1.75rem; position:relative; overflow:hidden; }
    .hero-banner::before { content:''; position:absolute; right:-40px; top:-40px; width:180px; height:180px; border-radius:50%; background:rgba(255,255,255,.05); }
    .hero-id { font-size:.72rem; font-weight:700; color:rgba(255,255,255,.5); letter-spacing:.1em; text-transform:uppercase; margin-bottom:.3rem; }
    .hero-title { font-size:1.3rem; font-weight:800; color:#fff; margin-bottom:.3rem; }
    .hero-sub { font-size:.82rem; color:rgba(255,255,255,.6); display:flex; align-items:center; gap:.4rem; flex-wrap:wrap; }
    .hero-status { margin-top:1rem; }
    .sbadge { padding:.38rem 1rem; border-radius:99px; font-size:.75rem; font-weight:700; display:inline-flex; align-items:center; gap:.4rem; }
    .sb-pending  { background:rgba(249,115,22,.2); color:#fb923c; }
    .sb-diterima { background:rgba(34,197,94,.2); color:#4ade80; }
    .sb-ditolak  { background:rgba(239,68,68,.2); color:#f87171; }
    .sb-selesai  { background:rgba(148,163,184,.2); color:#94a3b8; }
    .sbadge-dot { width:7px; height:7px; border-radius:50%; flex-shrink:0; }
    .sb-pending .sbadge-dot { background:#fb923c; }
    .sb-diterima .sbadge-dot { background:#4ade80; }
    .sb-ditolak .sbadge-dot { background:#f87171; }
    .sb-selesai .sbadge-dot { background:#94a3b8; }
    .section { padding:1.25rem 1.75rem; border-bottom:1px solid #f0f4f8; }
    .section:last-child { border-bottom:0; }
    .section-title { font-size:.7rem; font-weight:700; color:#94a3b8; letter-spacing:.08em; text-transform:uppercase; margin-bottom:1rem; display:flex; align-items:center; gap:.5rem; }
    .section-title::after { content:''; flex:1; height:1px; background:#f0f4f8; }
    .info-row { display:grid; grid-template-columns:1fr 1fr; gap:.75rem; }
    .info-item.full { grid-column:1 / -1; }
    .info-label { font-size:.68rem; color:#94a3b8; font-weight:600; margin-bottom:.2rem; }
    .info-value { font-size:.88rem; color:#1e293b; font-weight:600; }
    .info-value.muted { color:#475569; font-weight:500; }
    .penyewa-profile { display:flex; align-items:center; gap:1rem; padding:1rem; background:#f8fafc; border-radius:14px; border:1px solid #edf2f7; }
    .penyewa-avatar { width:52px; height:52px; border-radius:50%; color:#fff; font-weight:800; font-size:1.1rem; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
    .penyewa-name { font-size:.95rem; font-weight:700; color:#1e293b; }
    .penyewa-email { font-size:.75rem; color:#94a3b8; margin-top:2px; }
    .penyewa-hp { font-size:.78rem; color:#475569; margin-top:3px; display:flex; align-items:center; gap:4px; }
    .timeline { display:flex; align-items:center; margin:.5rem 0 0; }
    .tl-dot { width:12px; height:12px; border-radius:50%; background:var(--primary); flex-shrink:0; }
    .tl-line { flex:1; height:2px; background:linear-gradient(90deg,var(--primary),#16a34a); }
    .tl-dot-end { width:12px; height:12px; border-radius:50%; background:#16a34a; flex-shrink:0; }
    .tl-dates { display:grid; grid-template-columns:1fr 1fr; gap:.5rem; margin-top:.5rem; margin-bottom:1rem; }
    .tl-date-lbl { font-size:.65rem; color:#94a3b8; font-weight:600; }
    .tl-date-val { font-size:.88rem; font-weight:700; color:#1e293b; }
    .tl-dates div:last-child { text-align:right; }
    .durasi-badge { display:inline-flex; align-items:center; gap:.4rem; background:#eff6ff; color:#1d4ed8; border-radius:99px; padding:.3rem .9rem; font-size:.78rem; font-weight:700; }
    .price-box { background:linear-gradient(135deg,#fff5f3,#fff); border:1px solid #fcd5c8; border-radius:14px; padding:1rem 1.25rem; display:flex; justify-content:space-between; align-items:center; }
    .price-box-lbl { font-size:.72rem; color:#94a3b8; font-weight:600; }
    .price-box-val { font-size:1.3rem; font-weight:800; color:var(--primary); }
    .proof-img { width:100%; max-height:320px; object-fit:cover; border-radius:12px; border:1px solid #e4e9f0; margin-bottom:.75rem; }
    .side-card { background:#fff; border-radius:20px; border:1px solid #e4e9f0; overflow:hidden; margin-bottom:1rem; }
    .side-card-head { padding:1rem 1.25rem; border-bottom:1px solid #f0f4f8; display:flex; align-items:center; gap:.5rem; }
    .side-card-head-dot { width:8px; height:8px; border-radius:50%; background:var(--primary); }
    .side-card-title { font-size:.85rem; font-weight:700; color:var(--dark); }
    .side-card-body { padding:1rem 1.25rem; }
    .btn-aksi { width:100%; padding:.75rem 1rem; border-radius:12px; font-size:.85rem; font-weight:700; border:0; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:.5rem; transition:all .15s; margin-bottom:.5rem; text-decoration:none; }
    .btn-aksi:last-child { margin-bottom:0; }
    .btn-aksi:hover { transform:translateY(-1px); opacity:.9; }
    .btn-back   { background:#f1f5f9; color:#475569; }
    .btn-terima { background:linear-gradient(135deg,#16a34a,#22c55e); color:#fff; }
    .btn-tolak  { background:linear-gradient(135deg,#dc2626,#ef4444); color:#fff; }
    .btn-selesai{ background:linear-gradient(135deg,#475569,#64748b); color:#fff; }
    .booking-step { display:flex; gap:.75rem; margin-bottom:.85rem; }
    .booking-step:last-child { margin-bottom:0; }
    .step-icon { width:32px; height:32px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:.8rem; flex-shrink:0; }
    .step-done   { background:#dcfce7; color:#16a34a; }
    .step-active { background:linear-gradient(135deg,#e8401c,#fb923c); color:#fff; }
    .step-wait   { background:#f1f5f9; color:#94a3b8; }
    .step-reject { background:#fee2e2; color:#dc2626; }
    .step-title  { font-size:.82rem; font-weight:700; color:#1e293b; }
    .step-sub    { font-size:.72rem; color:#94a3b8; margin-top:1px; }
    @media (max-width:900px) { .detail-grid { grid-template-columns:1fr; } .info-row { grid-template-columns:1fr; } }
  </style>
</head>
<body>
  @php
    $statusClass = ['pending'=>'sb-pending','diterima'=>'sb-diterima','ditolak'=>'sb-ditolak','selesai'=>'sb-selesai'];
    $step = ['pending'=>1,'diterima'=>2,'selesai'=>3,'ditolak'=>99][$booking->status_booking] ?? 0;
    $colors = ['#e8401c','#3b82f6','#8b5cf6','#10b981','#f59e0b','#ec4899'];
    $avatarColor = $colors[ord(strtoupper(substr($booking->user->name ?? 'U',0,1))) % count($colors)];
  @endphp

  @include('owner._sidebar')
  <div class="main" id="mainContent">
    @include('owner._navbar')
    <div class="content">

      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3 rounded-3">
          <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      @endif

      <a href="{{ route('owner.booking.index') }}" class="back-link">
        <i class="bi bi-arrow-left"></i> Kembali ke daftar booking
      </a>

      <div class="detail-grid">
        {{-- KIRI --}}
        <div class="main-card">
          <div class="hero-banner">
            <div class="hero-id">Booking #{{ $booking->id_booking }}</div>
            <div class="hero-title">{{ $booking->room->kost->nama_kost ?? '-' }}</div>
            <div class="hero-sub">
              <i class="bi bi-door-open" style="font-size:.8rem;"></i>
              Kamar {{ $booking->room->nomor_kamar ?? '-' }}
              <span style="opacity:.3;">|</span>
              <i class="bi bi-calendar3" style="font-size:.8rem;"></i>
              {{ \Carbon\Carbon::parse($booking->created_at)->format('d M Y') }}
            </div>
            <div class="hero-status">
              <span class="sbadge {{ $statusClass[$booking->status_booking] ?? 'sb-selesai' }}">
                <span class="sbadge-dot"></span>
                {{ ucfirst($booking->status_booking) }}
              </span>
            </div>
          </div>

          <div class="section">
            <div class="section-title">Informasi Penyewa</div>
            <div class="penyewa-profile">
              <div class="penyewa-avatar" style="background:{{ $avatarColor }};">
                {{ strtoupper(substr($booking->user->name ?? 'U',0,1)) }}
              </div>
              <div>
                <div class="penyewa-name">{{ $booking->user->name ?? '-' }}</div>
                <div class="penyewa-email">{{ $booking->user->email ?? '-' }}</div>
                @if($booking->user->no_hp)
                  <div class="penyewa-hp">
                    <i class="bi bi-telephone" style="font-size:.7rem;color:var(--primary);"></i>
                    {{ $booking->user->no_hp }}
                  </div>
                @endif
              </div>
            </div>
          </div>

          <div class="section">
            <div class="section-title">Detail Sewa</div>
            <div class="timeline">
              <div class="tl-dot"></div>
              <div class="tl-line"></div>
              <div class="tl-dot-end"></div>
            </div>
            <div class="tl-dates">
              <div>
                <div class="tl-date-lbl">Tanggal Masuk</div>
                <div class="tl-date-val">{{ optional($booking->tanggal_masuk)->format('d M Y') ?? '-' }}</div>
              </div>
              <div>
                <div class="tl-date-lbl">Tanggal Selesai</div>
                <div class="tl-date-val">{{ optional($booking->tanggal_selesai)->format('d M Y') ?? '-' }}</div>
              </div>
            </div>
            <div class="info-row">
              <div class="info-item">
                <div class="info-label">Durasi Sewa</div>
                <span class="durasi-badge">
                  <i class="bi bi-clock" style="font-size:.72rem;"></i>
                  {{ $booking->durasi_sewa }} {{ ($booking->tipe_durasi ?? '') === 'harian' ? 'hari' : 'bulan' }}
                </span>
              </div>
              <div class="info-item">
  <div class="info-label">Metode Pembayaran</div>
  @if($booking->metode_pembayaran)
    <div style="display:inline-flex;align-items:center;gap:.4rem;background:#eff6ff;color:#1d4ed8;border-radius:8px;padding:.3rem .75rem;font-size:.8rem;font-weight:700;margin-top:.2rem;">
      <i class="bi bi-{{ strtolower($booking->metode_pembayaran) === 'tunai' || strtolower($booking->metode_pembayaran) === 'cash' ? 'cash-coin' : 'bank' }}" style="font-size:.8rem;"></i>
      {{ strtoupper($booking->metode_pembayaran) }}
    </div>
  @else
    <div class="info-value muted">-</div>
  @endif
</div>
              <div class="info-item">
                <div class="info-label">Status Pembayaran</div>
                <div class="info-value muted">{{ ucfirst($booking->status_pembayaran ?? '-') }}</div>
              </div>
              <div class="info-item">
                <div class="info-label">Pendapatan Owner</div>
                <div class="info-value muted">Rp {{ number_format($booking->pendapatan_owner ?? 0,0,',','.') }}</div>
              </div>
              @if($booking->catatan)
              <div class="info-item full">
                <div class="info-label">Catatan Penyewa</div>
                <div style="background:#f8fafc;border-radius:10px;padding:.75rem 1rem;border-left:3px solid var(--primary);font-size:.83rem;color:#475569;margin-top:.25rem;">
                  {{ $booking->catatan }}
                </div>
              </div>
              @endif
            </div>
          </div>

          @if($booking->status_booking === 'ditolak' && $booking->alasan_batal)
<div class="info-item full">
  <div class="info-label">Alasan Penolakan</div>
  <div style="background:#fef2f2;border-radius:10px;padding:.75rem 1rem;border-left:3px solid #dc2626;font-size:.83rem;color:#dc2626;margin-top:.25rem;display:flex;align-items:flex-start;gap:.5rem;">
    <i class="bi bi-exclamation-circle" style="flex-shrink:0;margin-top:2px;"></i>
    {{ $booking->alasan_batal }}
  </div>
</div>
@endif

          <div class="section">
            <div class="section-title">Pembayaran</div>
            <div class="price-box">
              <div>
                <div class="price-box-lbl">Total yang harus dibayar</div>
                <div class="price-box-val">Rp {{ number_format($booking->total_bayar ?? 0,0,',','.') }}</div>
              </div>
              <div style="width:48px;height:48px;border-radius:14px;background:linear-gradient(135deg,#e8401c,#fb923c);display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.2rem;">
                <i class="bi bi-credit-card"></i>
              </div>
            </div>
          </div>

          @if($booking->bukti_pembayaran)
          <div class="section">
            <div class="section-title">Bukti Pembayaran</div>
            <img src="{{ asset('storage/'.$booking->bukti_pembayaran) }}" alt="Bukti" class="proof-img">
            <a href="{{ asset('storage/'.$booking->bukti_pembayaran) }}" target="_blank"
               style="display:inline-flex;align-items:center;gap:.4rem;font-size:.78rem;color:#0369a1;font-weight:600;background:#e0f2fe;padding:.45rem .9rem;border-radius:8px;text-decoration:none;">
              <i class="bi bi-arrows-fullscreen"></i> Lihat ukuran penuh
            </a>
          </div>
          @endif
        </div>

        {{-- KANAN --}}
        <div>
          <div class="side-card">
            <div class="side-card-head">
              <div class="side-card-head-dot"></div>
              <div class="side-card-title">Tindakan</div>
            </div>
            <div class="side-card-body">
              @if($booking->status_booking === 'pending')
                <form action="{{ route('owner.booking.terima',$booking->id_booking) }}" method="POST">
                  @csrf @method('PATCH')
                  <button type="submit" class="btn-aksi btn-terima"><i class="bi bi-check-lg"></i> Terima Booking</button>
                </form>
                <form action="{{ route('owner.booking.tolak',$booking->id_booking) }}" method="POST" class="js-tolak">
                  @csrf @method('PATCH')
                  <button type="submit" class="btn-aksi btn-tolak"><i class="bi bi-x-lg"></i> Tolak Booking</button>
                </form>
              @elseif($booking->status_booking === 'diterima')
                <form action="{{ route('owner.booking.selesai',$booking->id_booking) }}" method="POST" class="js-selesai">
                  @csrf @method('PATCH')
                  <button type="submit" class="btn-aksi btn-selesai"><i class="bi bi-check2-all"></i> Tandai Selesai</button>
                </form>
              @endif
              <a href="{{ route('owner.booking.index') }}" class="btn-aksi btn-back"><i class="bi bi-list-ul"></i> Kembali ke daftar</a>
            </div>
          </div>

          <div class="side-card">
            <div class="side-card-head">
              <div class="side-card-head-dot"></div>
              <div class="side-card-title">Status Booking</div>
            </div>
            <div class="side-card-body">
              @if($booking->status_booking === 'ditolak')
                <div class="booking-step">
                  <div class="step-icon step-done"><i class="bi bi-check"></i></div>
                  <div><div class="step-title">Booking Masuk</div><div class="step-sub">Permintaan diterima sistem</div></div>
                </div>
                <div class="booking-step">
                  <div class="step-icon step-reject"><i class="bi bi-x"></i></div>
                  <div><div class="step-title" style="color:#dc2626;">Booking Ditolak</div><div class="step-sub">Owner menolak permintaan</div></div>
                </div>
              @else
                <div class="booking-step">
                  <div class="step-icon {{ $step >= 1 ? 'step-done' : 'step-wait' }}"><i class="bi bi-{{ $step >= 1 ? 'check' : 'circle' }}"></i></div>
                  <div><div class="step-title">Booking Masuk</div><div class="step-sub">Permintaan diterima sistem</div></div>
                </div>
                <div class="booking-step">
                  <div class="step-icon {{ $step >= 2 ? 'step-done' : ($step == 1 ? 'step-active' : 'step-wait') }}"><i class="bi bi-{{ $step >= 2 ? 'check' : 'clock' }}"></i></div>
                  <div><div class="step-title">Dikonfirmasi Owner</div><div class="step-sub">{{ $step >= 2 ? 'Owner telah menerima' : 'Menunggu konfirmasi' }}</div></div>
                </div>
                <div class="booking-step">
                  <div class="step-icon {{ $step >= 3 ? 'step-done' : 'step-wait' }}"><i class="bi bi-{{ $step >= 3 ? 'check' : 'house' }}"></i></div>
                  <div><div class="step-title">Masa Sewa Aktif</div><div class="step-sub">{{ $step >= 3 ? 'Penyewa aktif tinggal' : 'Belum dimulai' }}</div></div>
                </div>
                <div class="booking-step">
                  <div class="step-icon {{ $step >= 3 ? 'step-done' : 'step-wait' }}"><i class="bi bi-flag"></i></div>
                  <div><div class="step-title">Selesai</div><div class="step-sub">{{ $step >= 3 ? 'Sewa telah selesai' : 'Belum selesai' }}</div></div>
                </div>
              @endif
            </div>
          </div>

          <div class="side-card">
            <div class="side-card-head">
              <div class="side-card-head-dot"></div>
              <div class="side-card-title">Ringkasan</div>
            </div>
            <div class="side-card-body" style="display:flex;flex-direction:column;gap:.6rem;">
              <div style="display:flex;justify-content:space-between;font-size:.82rem;">
                <span style="color:#94a3b8;">Kost</span>
                <span style="font-weight:600;color:#1e293b;text-align:right;max-width:160px;font-size:.8rem;">{{ $booking->room->kost->nama_kost ?? '-' }}</span>
              </div>
              <div style="height:1px;background:#f0f4f8;"></div>
              <div style="display:flex;justify-content:space-between;font-size:.82rem;">
                <span style="color:#94a3b8;">Kamar</span>
                <span style="font-weight:600;color:#1e293b;">{{ $booking->room->nomor_kamar ?? '-' }}</span>
              </div>
              <div style="height:1px;background:#f0f4f8;"></div>
              <div style="display:flex;justify-content:space-between;font-size:.82rem;">
                <span style="color:#94a3b8;">Durasi</span>
                <span style="font-weight:600;color:#1e293b;">{{ $booking->durasi_sewa }} {{ ($booking->tipe_durasi ?? '') === 'harian' ? 'hari' : 'bulan' }}</span>
              </div>
              <div style="height:1px;background:#f0f4f8;"></div>
              <div style="display:flex;justify-content:space-between;font-size:.82rem;">
                <span style="color:#94a3b8;">Total</span>
                <span style="font-weight:800;color:var(--primary);font-size:.9rem;">Rp {{ number_format($booking->total_bayar ?? 0,0,',','.') }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <footer class="owner-footer">&copy; {{ date('Y') }} KostFinder &mdash; Panel Pemilik Kost. All rights reserved.</footer>
  </div>

  <div class="modal fade" id="tolakModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4 border-0 shadow">
      <div class="modal-body p-4">
        <div style="width:56px;height:56px;border-radius:50%;background:#fee2e2;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;">
          <i class="bi bi-x-lg" style="font-size:1.4rem;color:#dc2626;"></i>
        </div>
        <h6 class="fw-bold mb-1 text-center">Tolak Booking?</h6>
        <p class="text-muted small mb-3 text-center">Berikan alasan penolakan agar penyewa mengetahui.</p>
        <div id="tolakFormContainer">
          <div class="mb-3">
            <label class="form-label fw-semibold small">Alasan Penolakan</label>
            <textarea id="alasanTolakInput" rows="3" class="form-control rounded-3"
              placeholder="Contoh: Kamar sudah terisi, syarat tidak terpenuhi, dll..."
              maxlength="300"></textarea>
            <div class="text-muted text-end mt-1" style="font-size:.7rem;" id="alasanCount">0/300</div>
          </div>
        </div>
        <div class="d-flex gap-2">
          <button class="btn btn-sm btn-light rounded-3 flex-fill fw-semibold" data-bs-dismiss="modal">Batal</button>
          <button class="btn btn-sm btn-danger rounded-3 flex-fill fw-semibold" id="tolakConfirmBtn">Ya, Tolak</button>
        </div>
      </div>
    </div>
  </div>
</div>

  <div class="modal fade" id="selesaiModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
      <div class="modal-content rounded-4 border-0 shadow">
        <div class="modal-body text-center p-4">
          <div style="width:56px;height:56px;border-radius:50%;background:#dcfce7;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;"><i class="bi bi-check2-all" style="font-size:1.4rem;color:#16a34a;"></i></div>
          <h6 class="fw-bold mb-1">Tandai Selesai?</h6>
          <p class="text-muted small mb-3">Booking ini akan ditandai sebagai selesai.</p>
          <div class="d-flex gap-2">
            <button class="btn btn-sm btn-light rounded-3 flex-fill fw-semibold" data-bs-dismiss="modal">Batal</button>
            <button class="btn btn-sm rounded-3 flex-fill fw-semibold" style="background:#16a34a;color:#fff;" id="selesaiConfirmBtn">Ya, Selesai</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function toggleSidebar() {
      document.getElementById('sidebar').classList.toggle('collapsed');
      document.getElementById('mainContent').classList.toggle('collapsed');
    }
    let tolakForm = null;
document.querySelectorAll('.js-tolak').forEach(f => {
  f.addEventListener('submit', function(e) {
    e.preventDefault(); tolakForm=this;
    document.getElementById('alasanTolakInput').value = '';
    document.getElementById('alasanCount').textContent = '0/300';
    new bootstrap.Modal(document.getElementById('tolakModal')).show();
  });
});
document.getElementById('alasanTolakInput').addEventListener('input', function() {
  document.getElementById('alasanCount').textContent = this.value.length + '/300';
});
document.getElementById('tolakConfirmBtn').addEventListener('click', () => {
  if(tolakForm) {
    const alasan = document.getElementById('alasanTolakInput').value;
    let input = tolakForm.querySelector('input[name="alasan_batal"]');
    if(!input) {
      input = document.createElement('input');
      input.type = 'hidden';
      input.name = 'alasan_batal';
      tolakForm.appendChild(input);
    }
    input.value = alasan;
    tolakForm.submit();
  }
});
let selesaiForm = null;
    document.querySelectorAll('.js-selesai').forEach(f => {
      f.addEventListener('submit', function(e) { e.preventDefault(); selesaiForm=this; new bootstrap.Modal(document.getElementById('selesaiModal')).show(); });
    });
    document.getElementById('selesaiConfirmBtn').addEventListener('click', () => { if(selesaiForm) selesaiForm.submit(); });
  </script>
</body>
</html>