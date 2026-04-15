@extends('layouts.app')

@section('title', 'Konfirmasi Booking - KostFinder')

@section('styles')
<style>
  :root {
    --primary:#e8401c; --primary-soft:#fff5f2; --dark:#1e2d3d;
    --bg:#f0f4f8; --muted:#6b7280; --line:#e5e7eb;
    --success:#16a34a; --info:#0284c7;
  }
  body { background:var(--bg); }

  .booking-wrap { max-width:780px; margin:2rem auto; padding:0 1rem 5rem; }

  /* ── STEP BAR ── */
  .step-bar { display:flex; align-items:center; margin-bottom:2rem; }
  .step { display:flex; align-items:center; gap:.55rem; white-space:nowrap; }
  .step-num { width:34px; height:34px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:.8rem; font-weight:800; flex-shrink:0; }
  .step-lbl { font-size:.82rem; font-weight:700; }
  .step.done .step-num, .step.active .step-num { background:var(--primary); color:#fff; }
  .step.inactive .step-num { background:#e5e7eb; color:#9ca3af; }
  .step.done .step-lbl { color:var(--primary); }
  .step.active .step-lbl { color:var(--dark); }
  .step.inactive .step-lbl { color:#9ca3af; }
  .step-line { flex:1; height:2px; background:#e5e7eb; margin:0 .75rem; }
  .step-line.done { background:var(--primary); }

  /* ── CARD ── */
  .card-section { background:#fff; border-radius:1.1rem; border:1px solid #edf0f5; padding:1.5rem; margin-bottom:1rem; box-shadow:0 4px 20px rgba(15,23,42,.05); }
  .card-section .cs-title { font-weight:800; color:var(--dark); font-size:.92rem; margin-bottom:1.1rem; padding-bottom:.75rem; border-bottom:1.5px solid #f1f5f9; display:flex; align-items:center; gap:.5rem; }

  /* ── KOST HEADER ── */
  .kost-header { display:flex; align-items:center; gap:1rem; padding:.75rem 0 1.1rem; border-bottom:1px solid #f1f5f9; margin-bottom:1rem; }
  .kost-thumb { width:62px; height:62px; border-radius:.75rem; object-fit:cover; background:#f0f3f8; flex-shrink:0; display:flex; align-items:center; justify-content:center; font-size:1.6rem; }
  .kost-thumb img { width:62px; height:62px; border-radius:.75rem; object-fit:cover; }
  .kost-nama { font-weight:800; font-size:1rem; color:var(--dark); margin-bottom:.2rem; }
  .kost-sub { font-size:.78rem; color:var(--muted); display:flex; align-items:center; gap:.35rem; }

  /* ── INFO ROW ── */
  .info-row { display:flex; justify-content:space-between; align-items:center; gap:1rem; padding:.65rem 0; border-bottom:1px solid #f8fafc; font-size:.86rem; }
  .info-row:last-child { border-bottom:0; }
  .info-row .lbl { color:var(--muted); display:flex; align-items:center; gap:.4rem; }
  .info-row .lbl svg { flex-shrink:0; }
  .info-row .val { font-weight:700; color:var(--dark); text-align:right; }

  /* ── TANGGAL CARD ── */
  .tanggal-grid { display:grid; grid-template-columns:1fr auto 1fr; gap:.75rem; align-items:center; margin-bottom:1rem; }
  .tgl-card { background:#f8fafd; border:1.5px solid #e4e9f0; border-radius:.9rem; padding:.9rem 1rem; text-align:center; }
  .tgl-card.checkin { border-color:#bbf7d0; background:#f0fdf4; }
  .tgl-card.checkout { border-color:#fecaca; background:#fef2f2; }
  .tgl-badge { font-size:.68rem; font-weight:800; letter-spacing:.06em; text-transform:uppercase; margin-bottom:.35rem; }
  .tgl-card.checkin .tgl-badge { color:#16a34a; }
  .tgl-card.checkout .tgl-badge { color:#dc2626; }
  .tgl-tanggal { font-size:.95rem; font-weight:800; color:var(--dark); line-height:1.2; }
  .tgl-jam { font-size:1.1rem; font-weight:900; color:var(--dark); margin-top:.3rem; font-variant-numeric:tabular-nums; }
  .tgl-hari { font-size:.73rem; color:var(--muted); margin-top:.1rem; }
  .tgl-arrow { text-align:center; color:#94a3b8; font-size:.8rem; }
  .durasi-chip { display:inline-flex; align-items:center; gap:.35rem; background:#fff5f2; color:var(--primary); border:1.5px solid #ffd0c0; font-size:.75rem; font-weight:800; padding:.3rem .75rem; border-radius:999px; margin-bottom:1rem; }

  /* ── HARGA ── */
  .harga-section { background:#f8fafd; border-radius:.85rem; padding:1rem 1.1rem; }
  .harga-row { display:flex; justify-content:space-between; font-size:.84rem; padding:.4rem 0; }
  .harga-row .hk { color:var(--muted); }
  .harga-row .hv { font-weight:600; color:var(--dark); }
  .harga-divider { border:0; border-top:1.5px dashed #e4e9f0; margin:.55rem 0; }
  .harga-total { display:flex; justify-content:space-between; align-items:center; padding-top:.55rem; }
  .harga-total .ht-label { font-weight:800; font-size:.9rem; color:var(--dark); }
  .harga-total .ht-value { font-size:1.2rem; font-weight:900; color:var(--primary); }
  .fee-badge { display:inline-flex; align-items:center; gap:.3rem; background:#fff7ed; color:#c2410c; border:1px solid #fdba74; font-size:.68rem; font-weight:700; padding:.2rem .5rem; border-radius:999px; margin-left:.4rem; }

  /* ── METODE ── */
  .metode-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:.65rem; }
  .metode-item { border:2px solid #e5e7eb; border-radius:.85rem; padding:.85rem .7rem; cursor:pointer; transition:all .18s; text-align:center; position:relative; }
  .metode-item:hover { border-color:var(--primary); background:var(--primary-soft); }
  .metode-item.selected { border-color:var(--primary); background:var(--primary-soft); box-shadow:0 0 0 4px rgba(232,64,28,.1); }
  .metode-logo { width:100%; height:32px; border-radius:.4rem; display:flex; align-items:center; justify-content:center; color:#fff; font-weight:900; font-size:.78rem; margin:0 auto .5rem; }
  .metode-name { font-weight:700; font-size:.78rem; color:var(--dark); }
  .metode-check { position:absolute; top:.45rem; right:.45rem; width:18px; height:18px; border-radius:50%; background:var(--primary); color:#fff; font-size:.65rem; display:none; align-items:center; justify-content:center; }
  .metode-item.selected .metode-check { display:flex; }

  /* ── REKENING BOX ── */
  .rekening-box { background:#f0f9ff; border:1.5px solid #bae6fd; border-radius:.9rem; padding:1.1rem; margin-top:1rem; display:none; animation:fadeIn .25s ease; }
  .rekening-box.show { display:block; }
  @keyframes fadeIn { from{opacity:0;transform:translateY(6px)} to{opacity:1;transform:translateY(0)} }
  .rek-label { font-size:.75rem; font-weight:700; color:#0369a1; margin-bottom:.5rem; }
  .rek-an { font-size:.8rem; color:#475569; margin-bottom:.3rem; }
  .rek-num { font-size:1.3rem; font-weight:900; color:var(--dark); letter-spacing:.04em; }
  .copy-btn { background:var(--primary); color:#fff; border:0; border-radius:.5rem; padding:.38rem .8rem; font-size:.75rem; font-weight:700; cursor:pointer; margin-left:.6rem; transition:background .15s; }
  .copy-btn:hover { background:#cb3518; }
  .nominal-box { background:#dbeafe; border-radius:.65rem; padding:.65rem .9rem; margin-top:.75rem; font-size:.8rem; color:#1e40af; font-weight:600; }

  /* ── UPLOAD ── */
  .upload-area { border:2px dashed #dbe2ea; border-radius:.95rem; padding:2rem; text-align:center; cursor:pointer; transition:all .2s; background:#f8fafc; }
  .upload-area:hover { border-color:var(--primary); background:var(--primary-soft); }
  .upload-area.has-file { border-color:var(--success); background:#f0fdf4; }
  .upload-icon { width:52px; height:52px; background:#f1f5f9; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto .75rem; }
  .upload-icon svg { color:#94a3b8; }
  .upload-area.has-file .upload-icon { background:#dcfce7; }
  .upload-area.has-file .upload-icon svg { color:#16a34a; }

  /* ── BTN BAYAR ── */
  .btn-bayar { background:linear-gradient(135deg,#e8401c,#ff6b3d); color:#fff; border:0; border-radius:.9rem; padding:1rem; font-weight:800; font-size:1rem; width:100%; cursor:pointer; transition:all .2s; box-shadow:0 8px 20px rgba(232,64,28,.25); display:flex; align-items:center; justify-content:center; gap:.6rem; }
  .btn-bayar:hover { transform:translateY(-2px); box-shadow:0 12px 28px rgba(232,64,28,.3); }
  .btn-bayar:disabled { background:#cbd5e1; box-shadow:none; cursor:not-allowed; transform:none; }
  .back-link { display:block; text-align:center; margin-top:.85rem; font-size:.82rem; color:#6b7280; text-decoration:none; }
  .back-link:hover { color:var(--primary); }

  /* ── COUNTDOWN ── */
  .countdown-bar { background:linear-gradient(135deg,#fff5f2,#ffe4dc); border:1.5px solid #ffd0c0; border-radius:.85rem; padding:.85rem 1.1rem; margin-bottom:1rem; display:flex; align-items:center; gap:.75rem; }
  .cd-icon { width:38px; height:38px; background:#e8401c; border-radius:50%; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
  .cd-text { font-size:.8rem; color:#7c2d12; }
  .cd-time { font-size:1rem; font-weight:900; color:#e8401c; font-variant-numeric:tabular-nums; }

  @media(max-width:576px) {
    .tanggal-grid { grid-template-columns:1fr; }
    .tgl-arrow { display:none; }
    .metode-grid { grid-template-columns:repeat(3,1fr); }
    .step-lbl { display:none; }
    .step-line { margin:0 .4rem; }
  }
</style>
@endsection

@section('content')
<div class="booking-wrap">

  {{-- STEP BAR --}}
  <div class="step-bar">
    <div class="step done">
      <div class="step-num">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
      </div>
      <div class="step-lbl">Pilih Kamar</div>
    </div>
    <div class="step-line done"></div>
    <div class="step active">
      <div class="step-num">2</div>
      <div class="step-lbl">Pembayaran</div>
    </div>
    <div class="step-line"></div>
    <div class="step inactive">
      <div class="step-num">3</div>
      <div class="step-lbl">Selesai</div>
    </div>
  </div>

  {{-- ALERT --}}
  @if(session('error'))
    <div class="alert alert-danger" style="border-radius:.85rem;font-size:.85rem;margin-bottom:1rem;">
      {{ session('error') }}
    </div>
  @endif
  @if($errors->any())
    <div class="alert alert-danger" style="border-radius:.85rem;font-size:.85rem;margin-bottom:1rem;">
      <strong>Ada data yang belum benar:</strong>
      <ul class="mb-0 mt-1 ps-3">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
  @endif

  {{-- COUNTDOWN BATAS BAYAR --}}
  <div class="countdown-bar">
    <div class="cd-icon">
      <svg width="18" height="18" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24">
        <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
      </svg>
    </div>
    <div>
      <div class="cd-text">Selesaikan pembayaran dalam</div>
      <div class="cd-time" id="countdown">23:59:59</div>
    </div>
  </div>

  {{-- RINGKASAN BOOKING --}}
  <div class="card-section">
    <div class="cs-title">
      <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="1"/></svg>
      Ringkasan Booking
    </div>

    {{-- Header kost --}}
    <div class="kost-header">
      <div class="kost-thumb">🏠</div>
      <div>
        <div class="kost-nama">{{ $booking->room->kost->nama_kost ?? '-' }}</div>
        <div class="kost-sub">
          <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
          {{ $booking->room->kost->kota ?? '-' }}
          &nbsp;·&nbsp;
          <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18"/></svg>
          Kamar {{ $booking->room->nomor_kamar ?? '-' }}
          {{ !empty($booking->room->tipe_kamar) ? '('.$booking->room->tipe_kamar.')' : '' }}
        </div>
      </div>
      <div class="ms-auto">
        <span style="background:#f0fdf4;color:#16a34a;border:1px solid #bbf7d0;font-size:.72rem;font-weight:700;padding:.3rem .75rem;border-radius:999px;white-space:nowrap;">
          ✅ Booking Aktif
        </span>
      </div>
    </div>

    {{-- Tanggal check-in / check-out --}}
    @php
      $masuk   = \Carbon\Carbon::parse($booking->tanggal_masuk);
      $selesai = \Carbon\Carbon::parse($booking->tanggal_selesai);
      $hariMasuk   = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'][$masuk->dayOfWeek];
      $hariSelesai = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'][$selesai->dayOfWeek];
      $bulanID = ['','Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agt','Sep','Okt','Nov','Des'];
    @endphp

    <div class="tanggal-grid">
      {{-- Check In --}}
      <div class="tgl-card checkin">
        <div class="tgl-badge">Check-In</div>
        <div class="tgl-tanggal">
          {{ $masuk->format('d') }} {{ $bulanID[$masuk->format('n')] }} {{ $masuk->format('Y') }}
        </div>
        <div class="tgl-jam" id="jamCheckin">--:--</div>
        <div class="tgl-hari">{{ $hariMasuk }}</div>
      </div>

      {{-- Arrow --}}
      <div class="tgl-arrow">
        <div class="durasi-chip" style="flex-direction:column;gap:.1rem;padding:.5rem .65rem;">
          <span style="font-size:.65rem;font-weight:700;color:#94a3b8;">DURASI</span>
          <span>{{ $booking->durasi_sewa }} {{ $booking->tipe_durasi === 'harian' ? 'Hari' : 'Bulan' }}</span>
        </div>
      </div>

      {{-- Check Out --}}
      <div class="tgl-card checkout">
        <div class="tgl-badge">Check-Out</div>
        <div class="tgl-tanggal">
          {{ $selesai->format('d') }} {{ $bulanID[$selesai->format('n')] }} {{ $selesai->format('Y') }}
        </div>
        <div class="tgl-jam" id="jamCheckout">--:--</div>
        <div class="tgl-hari">{{ $hariSelesai }}</div>
      </div>
    </div>

    {{-- Rincian Harga --}}
    <div class="harga-section">
      <div class="harga-row">
        <span class="hk">Harga Sewa</span>
        <span class="hv">Rp {{ number_format($booking->total_harga ?? 0, 0, ',', '.') }}</span>
      </div>
      <div class="harga-row">
        <span class="hk">
          Biaya Layanan
          <span class="fee-badge">Platform Fee 10%</span>
        </span>
        <span class="hv">Rp {{ number_format($booking->komisi_admin ?? 0, 0, ',', '.') }}</span>
      </div>
      <hr class="harga-divider">
      <div class="harga-total">
        <span class="ht-label">💰 Total Transfer</span>
        <span class="ht-value">Rp {{ number_format($booking->total_bayar ?? 0, 0, ',', '.') }}</span>
      </div>
    </div>

  </div>

  {{-- FORM PEMBAYARAN --}}
  <form action="{{ route('user.booking.bayar', $booking->id_booking) }}" method="POST" enctype="multipart/form-data" id="formBayar">
    @csrf

    {{-- PILIH METODE --}}
    <div class="card-section">
      <div class="cs-title">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
        Metode Pembayaran
      </div>

      <div class="metode-grid">
        <div class="metode-item" onclick="pilihMetode('BCA', this)">
          <div class="metode-check">✓</div>
          <div class="metode-logo" style="background:#006cb4;">BCA</div>
          <div class="metode-name">Bank BCA</div>
        </div>
        <div class="metode-item" onclick="pilihMetode('BRI', this)">
          <div class="metode-check">✓</div>
          <div class="metode-logo" style="background:#003f87;">BRI</div>
          <div class="metode-name">Bank BRI</div>
        </div>
        <div class="metode-item" onclick="pilihMetode('Mandiri', this)">
          <div class="metode-check">✓</div>
          <div class="metode-logo" style="background:#003087;">Mandiri</div>
          <div class="metode-name">Mandiri</div>
        </div>
      </div>

      <input type="hidden" name="metode_pembayaran" id="metode_pembayaran" value="{{ old('metode_pembayaran') }}">

      {{-- INFO REKENING --}}
      <div class="rekening-box" id="rekeningBox">
        <div class="rek-label">📌 Transfer ke rekening berikut:</div>
        <div class="rek-an">A.n <strong id="rekeningNama"></strong></div>
        <div style="display:flex;align-items:center;flex-wrap:wrap;gap:.3rem;margin-top:.2rem;">
          <span class="rek-num" id="rekeningNomor"></span>
          <button type="button" class="copy-btn" onclick="salinRekening()">
            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="margin-right:3px;vertical-align:-1px;"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
            Salin
          </button>
        </div>
        <div class="nominal-box">
          💡 Transfer <strong>tepat</strong> sesuai nominal:
          <strong>Rp {{ number_format($booking->total_bayar ?? 0, 0, ',', '.') }}</strong>
          — nomor unik mempercepat konfirmasi.
        </div>
      </div>
    </div>

    {{-- UPLOAD BUKTI --}}
    <div class="card-section">
      <div class="cs-title">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
        Upload Bukti Pembayaran
      </div>

      <p style="font-size:.82rem;color:#6b7280;margin-bottom:1rem;">
        Upload foto / screenshot bukti transfer. Pastikan <strong>nominal</strong> dan <strong>tanggal</strong> transfer terlihat jelas.
      </p>

      <label for="buktiUpload" class="upload-area" id="uploadArea">
        <div class="upload-icon">
          <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <polyline points="16 16 12 12 8 16"/><line x1="12" y1="12" x2="12" y2="21"/>
            <path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"/>
          </svg>
        </div>
        <div style="font-size:.88rem;color:#374151;font-weight:700;" id="uploadText">
          Klik untuk upload bukti transfer
        </div>
        <div style="font-size:.74rem;color:#94a3b8;margin-top:.3rem;">
          Format JPG, JPEG, PNG · Maksimal 2MB
        </div>
        <input type="file" name="bukti_pembayaran" id="buktiUpload" class="d-none" accept="image/*" onchange="previewBukti(this)" required>
      </label>

      <img id="previewImg"
        style="display:none;width:100%;max-height:260px;object-fit:contain;margin-top:1rem;border-radius:.85rem;border:1.5px solid #e4e9f0;"
        alt="Preview Bukti Pembayaran">
    </div>

    {{-- TOMBOL BAYAR --}}
    <button type="submit" class="btn-bayar" id="btnBayar" disabled>
      <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
      Kirim Bukti Pembayaran
    </button>

    <a href="{{ route('kost.show', $booking->room->kost->id_kost) }}" class="back-link">
      ← Kembali ke detail kost
    </a>
  </form>
</div>
@endsection

@section('scripts')
<script>
  const rekening = {
    BCA:    { nama:'KostFinder Indonesia', nomor:'1234567890' },
    BRI:    { nama:'KostFinder Indonesia', nomor:'0987654321' },
    Mandiri:{ nama:'KostFinder Indonesia', nomor:'1122334455' }
  };

  let metodeTerpilih = false;
  let buktiTerpilih  = false;

  /* ── JAM REALTIME ── */
  function updateJam() {
    const now    = new Date();
    const jam    = String(now.getHours()).padStart(2,'0');
    const menit  = String(now.getMinutes()).padStart(2,'0');
    const tampil = jam + ':' + menit;

    // Check-in: jam sekarang
    const elIn = document.getElementById('jamCheckin');
    if (elIn) elIn.textContent = tampil + ' WIB';

    // Check-out: jam 12:00 (standar checkout kos)
    const elOut = document.getElementById('jamCheckout');
    if (elOut) elOut.textContent = '12:00 WIB';
  }
  updateJam();
  setInterval(updateJam, 30000); // update tiap 30 detik

  /* ── COUNTDOWN 24 JAM ── */
  function mulaiCountdown() {
    const KEY = 'booking_deadline_{{ $booking->id_booking }}';
    let deadline = localStorage.getItem(KEY);
    if (!deadline) {
      deadline = Date.now() + 24 * 60 * 60 * 1000;
      localStorage.setItem(KEY, deadline);
    }
    deadline = parseInt(deadline);

    function tick() {
      const sisa = deadline - Date.now();
      if (sisa <= 0) {
        document.getElementById('countdown').textContent = 'Waktu habis!';
        return;
      }
      const j = Math.floor(sisa / 3600000);
      const m = Math.floor((sisa % 3600000) / 60000);
      const s = Math.floor((sisa % 60000) / 1000);
      document.getElementById('countdown').textContent =
        String(j).padStart(2,'0') + ':' + String(m).padStart(2,'0') + ':' + String(s).padStart(2,'0');
    }
    tick();
    setInterval(tick, 1000);
  }
  mulaiCountdown();

  /* ── PILIH METODE ── */
  function pilihMetode(metode, el) {
    document.querySelectorAll('.metode-item').forEach(i => i.classList.remove('selected'));
    el.classList.add('selected');
    document.getElementById('metode_pembayaran').value = metode;

    const box = document.getElementById('rekeningBox');
    box.classList.add('show');
    document.getElementById('rekeningNama').textContent   = rekening[metode].nama;
    document.getElementById('rekeningNomor').textContent  = rekening[metode].nomor;

    metodeTerpilih = true;
    cekFormReady();
  }

  /* ── SALIN REKENING ── */
  function salinRekening() {
    const nomor = document.getElementById('rekeningNomor').textContent;
    navigator.clipboard.writeText(nomor).then(() => {
      const btn = event.target.closest('button');
      const ori = btn.innerHTML;
      btn.innerHTML = '✓ Tersalin!';
      btn.style.background = '#16a34a';
      setTimeout(() => { btn.innerHTML = ori; btn.style.background = ''; }, 2000);
    });
  }

  /* ── PREVIEW BUKTI ── */
  function previewBukti(input) {
    if (input.files && input.files[0]) {
      const file = input.files[0];
      const reader = new FileReader();
      reader.onload = e => {
        document.getElementById('previewImg').src = e.target.result;
        document.getElementById('previewImg').style.display = 'block';
        document.getElementById('uploadArea').classList.add('has-file');
        document.getElementById('uploadText').textContent = '✅ ' + file.name;
      };
      reader.readAsDataURL(file);
      buktiTerpilih = true;
      cekFormReady();
    }
  }

  /* ── CEK FORM READY ── */
  function cekFormReady() {
    document.getElementById('btnBayar').disabled = !(metodeTerpilih && buktiTerpilih);
  }

  /* ── RESTORE OLD VALUE ── */
  document.addEventListener('DOMContentLoaded', () => {
    const old = document.getElementById('metode_pembayaran').value;
    if (old && rekening[old]) {
      const el = [...document.querySelectorAll('.metode-item')]
        .find(i => i.getAttribute('onclick')?.includes("'"+old+"'"));
      if (el) pilihMetode(old, el);
    }
  });
</script>
@endsection