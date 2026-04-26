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
  .kost-sub { font-size:.78rem; color:var(--muted); display:flex; align-items:center; gap:.35rem; flex-wrap:wrap; }

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

  /* ── BTN CANCEL ── */
  .btn-cancel { background:#fff; color:#dc2626; border:2px solid #fecaca; border-radius:.9rem; padding:.85rem; font-weight:700; font-size:.9rem; width:100%; cursor:pointer; transition:all .2s; display:flex; align-items:center; justify-content:center; gap:.5rem; margin-top:.65rem; }
  .btn-cancel:hover { background:#fef2f2; border-color:#dc2626; }

  /* ── COUNTDOWN ── */
  .countdown-bar { background:linear-gradient(135deg,#fff5f2,#ffe4dc); border:1.5px solid #ffd0c0; border-radius:.85rem; padding:.85rem 1.1rem; margin-bottom:1rem; display:flex; align-items:center; gap:.75rem; }
  .cd-icon { width:38px; height:38px; background:#e8401c; border-radius:50%; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
  .cd-text { font-size:.8rem; color:#7c2d12; }
  .cd-time { font-size:1rem; font-weight:900; color:#e8401c; font-variant-numeric:tabular-nums; }

  /* ── MODAL CANCEL ── */
  .modal-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,.55); z-index:9999; align-items:center; justify-content:center; padding:1rem; backdrop-filter:blur(4px); }
  .modal-overlay.show { display:flex; }
  .modal-box { background:#fff; border-radius:1.2rem; width:100%; max-width:420px; overflow:hidden; box-shadow:0 20px 60px rgba(0,0,0,.2); animation:fadeIn .2s ease; }
  .modal-head { padding:1.2rem 1.5rem; border-bottom:1px solid #f0f3f8; display:flex; justify-content:space-between; align-items:center; }
  .modal-body { padding:1.5rem; }
  .modal-foot { padding:1rem 1.5rem; border-top:1px solid #f0f3f8; display:flex; gap:.65rem; }
  .alasan-item { border:1.5px solid #e4e9f0; border-radius:.65rem; padding:.65rem .9rem; cursor:pointer; margin-bottom:.45rem; font-size:.83rem; color:#444; transition:all .2s; }
  .alasan-item:hover, .alasan-item.selected { border-color:var(--primary); background:#fff5f2; color:var(--primary); font-weight:700; }

  @media(max-width:576px) {
    .tanggal-grid { grid-template-columns:1fr; }
    .tgl-arrow { display:none; }
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

  {{-- COUNTDOWN --}}
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

    {{-- Tanggal --}}
    @php
      $masuk   = \Carbon\Carbon::parse($booking->tanggal_masuk);
      $selesai = \Carbon\Carbon::parse($booking->tanggal_selesai);
      $hariMasuk   = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'][$masuk->dayOfWeek];
      $hariSelesai = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'][$selesai->dayOfWeek];
      $bulanID = ['','Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agt','Sep','Okt','Nov','Des'];
      $labelDurasi = $booking->tipe_durasi === 'harian' ? 'Hari' : 'Bulan';
    @endphp

    <div class="tanggal-grid">
      <div class="tgl-card checkin">
        <div class="tgl-badge">Check-In</div>
        <div class="tgl-tanggal">{{ $masuk->format('d') }} {{ $bulanID[$masuk->format('n')] }} {{ $masuk->format('Y') }}</div>
        <div class="tgl-jam" id="jamCheckin">--:--</div>
        <div class="tgl-hari">{{ $hariMasuk }}</div>
      </div>
      <div class="tgl-arrow">
        <div class="durasi-chip" style="flex-direction:column;gap:.1rem;padding:.5rem .65rem;">
          <span style="font-size:.65rem;font-weight:700;color:#94a3b8;">DURASI</span>
          <span>{{ $booking->durasi_sewa }} {{ $labelDurasi }}</span>
        </div>
      </div>
      <div class="tgl-card checkout">
        <div class="tgl-badge">Check-Out</div>
        <div class="tgl-tanggal">{{ $selesai->format('d') }} {{ $bulanID[$selesai->format('n')] }} {{ $selesai->format('Y') }}</div>
        <div class="tgl-jam" id="jamCheckout">--:--</div>
        <div class="tgl-hari">{{ $hariSelesai }}</div>
      </div>
    </div>

    {{-- ── RINCIAN HARGA ── --}}
    <div class="harga-section">
      {{-- Baris harga sewa --}}
      <div class="harga-row">
        <span class="hk">
          Harga Sewa
          <span style="font-size:.72rem;color:#94a3b8;">
            ({{ $booking->durasi_sewa }} {{ $labelDurasi }})
          </span>
        </span>
        <span class="hv">Rp {{ number_format($booking->total_harga ?? 0, 0, ',', '.') }}</span>
      </div>

      {{-- Biaya layanan --}}
      <div class="harga-row">
        <span class="hk">
          Biaya Layanan
        <span class="fee-badge">Platform Fee {{ $persenKomisi }}%</span>
        </span>
        <span class="hv">Rp {{ number_format($booking->komisi_admin ?? 0, 0, ',', '.') }}</span>
      </div>

      <hr class="harga-divider">

      {{-- Total --}}
      <div class="harga-total">
        <span class="ht-label">💰 Total Transfer</span>
        <span class="ht-value">Rp {{ number_format($booking->total_bayar ?? 0, 0, ',', '.') }}</span>
      </div>
    </div>

  </div>{{-- end card ringkasan --}}

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
        @forelse($bankAccounts as $acc)
          <div class="metode-item" onclick="pilihMetode('{{ $acc->id }}', this)">
            <div class="metode-check">✓</div>
            <div class="metode-logo" style="background:{{ in_array(strtoupper($acc->nama_bank), ['BCA','BRI','MANDIRI','BNI']) ? 'var(--dark)' : '#64748b' }};">
              {{ strtoupper($acc->nama_bank) }}
            </div>
            <div class="metode-name">{{ $acc->nama_bank }}</div>
          </div>
        @empty
          <div class="col-12 text-center py-3">
            <div class="alert alert-warning border-0" style="background:#fff7ed;color:#9a3412;font-size:.82rem;border-radius:12px;">
              <i class="bi bi-exclamation-triangle-fill me-2"></i>
              Pemilik kost belum mengatur metode pembayaran. Silakan hubungi pemilik kost atau tunggu beberapa saat.
            </div>
          </div>
        @endforelse
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

    {{-- TOMBOL KIRIM BUKTI --}}
    <button type="submit" class="btn-bayar" id="btnBayar" disabled>
      <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
      Kirim Bukti Pembayaran
    </button>

  </form>

  {{-- TOMBOL CANCEL BOOKING --}}
  <button type="button" class="btn-cancel" onclick="bukaModalCancel()">
    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
    Batalkan Booking
  </button>

</div>{{-- end booking-wrap --}}

{{-- ══════════════ MODAL CANCEL BOOKING ══════════════ --}}
<div class="modal-overlay" id="modalCancel" onclick="if(event.target===this)tutupModalCancel()">
  <div class="modal-box">

    <div class="modal-head">
      <div>
        <div style="font-weight:800;font-size:.98rem;color:#dc2626;">🚫 Batalkan Booking</div>
        <div style="font-size:.75rem;color:#888;margin-top:2px;">
          {{ $booking->room->kost->nama_kost ?? '-' }} · Kamar {{ $booking->room->nomor_kamar ?? '-' }}
        </div>
      </div>
      <button onclick="tutupModalCancel()" style="background:none;border:none;font-size:1.2rem;color:#aaa;cursor:pointer;">✕</button>
    </div>

    <div class="modal-body">
      <p style="font-size:.82rem;color:#6b7280;margin-bottom:1rem;">
        Setelah dibatalkan, kamar akan kembali tersedia dan kamu perlu booking ulang jika berubah pikiran.
      </p>

      <div style="font-size:.8rem;font-weight:700;color:#444;margin-bottom:.55rem;">Pilih alasan pembatalan:</div>

      <div class="alasan-item" onclick="pilihAlasan('Berubah pikiran', this)">😅 Berubah pikiran</div>
      <div class="alasan-item" onclick="pilihAlasan('Salah pilih kamar', this)">🚪 Salah pilih kamar</div>
      <div class="alasan-item" onclick="pilihAlasan('Ada keperluan mendadak', this)">⚡ Ada keperluan mendadak</div>
      <div class="alasan-item" onclick="pilihAlasan('Menemukan kost yang lebih cocok', this)">🏠 Lebih cocok di tempat lain</div>
      <div class="alasan-item" onclick="pilihAlasan('Lainnya', this)">✏️ Alasan lain</div>

      <div id="alasanLainWrap" style="display:none;margin-top:.5rem;">
        <textarea id="alasanLainText" class="form-control" rows="2"
          placeholder="Tulis alasanmu..."
          style="font-size:.8rem;border-radius:.6rem;"
          oninput="updateAlasanLain(this.value)"></textarea>
      </div>
    </div>

    <div class="modal-foot">
      <button type="button" onclick="tutupModalCancel()"
        style="flex:1;padding:.6rem;border-radius:.6rem;border:1.5px solid #e4e9f0;background:#fff;font-size:.83rem;font-weight:600;color:#555;cursor:pointer;">
        Kembali
      </button>

      {{-- Form cancel --}}
      <form id="formCancel" action="{{ route('user.booking.cancel', $booking->id_booking) }}" method="POST" style="flex:1;">
        @csrf
        @method('PATCH')
        <input type="hidden" name="alasan_batal" id="alasanBatalInput">
        <button type="submit" id="btnKonfirmasiBatal" disabled
          style="width:100%;padding:.6rem;border-radius:.6rem;border:0;background:#dc2626;color:#fff;font-size:.83rem;font-weight:700;cursor:pointer;opacity:.5;transition:opacity .2s;">
          🚫 Ya, Batalkan
        </button>
      </form>
    </div>

  </div>
</div>

@endsection

@section('scripts')
<script>
  const rekening = {
    @foreach($bankAccounts as $acc)
      '{{ $acc->id }}': { nama: '{{ $acc->nama_pemilik }}', nomor: '{{ $acc->nomor_rekening }}', bank: '{{ $acc->nama_bank }}' },
    @endforeach
  };

  let metodeTerpilih = false;
  let buktiTerpilih  = false;

  /* ── JAM REALTIME ── */
  function updateJam() {
    const now   = new Date();
    const jam   = String(now.getHours()).padStart(2,'0');
    const menit = String(now.getMinutes()).padStart(2,'0');
    const elIn  = document.getElementById('jamCheckin');
    const elOut = document.getElementById('jamCheckout');
    if (elIn)  elIn.textContent  = jam + ':' + menit + ' WIB';
    if (elOut) elOut.textContent = '12:00 WIB';
  }
  updateJam();
  setInterval(updateJam, 30000);

  /* ── COUNTDOWN 24 JAM ── */
  (function () {
    const KEY      = 'booking_deadline_{{ $booking->id_booking }}';
    let   deadline = localStorage.getItem(KEY);
    if (!deadline) {
      deadline = Date.now() + 24 * 60 * 60 * 1000;
      localStorage.setItem(KEY, deadline);
    }
    deadline = parseInt(deadline);

    function tick() {
      const sisa = deadline - Date.now();
      const el   = document.getElementById('countdown');
      if (!el) return;
      if (sisa <= 0) { el.textContent = 'Waktu habis!'; return; }
      const j = Math.floor(sisa / 3600000);
      const m = Math.floor((sisa % 3600000) / 60000);
      const s = Math.floor((sisa % 60000) / 1000);
      el.textContent = String(j).padStart(2,'0') + ':' + String(m).padStart(2,'0') + ':' + String(s).padStart(2,'0');
    }
    tick();
    setInterval(tick, 1000);
  })();

  /* ── PILIH METODE ── */
  function pilihMetode(metode, el) {
    document.querySelectorAll('.metode-item').forEach(i => i.classList.remove('selected'));
    el.classList.add('selected');
    document.getElementById('metode_pembayaran').value = metode;

    const box = document.getElementById('rekeningBox');
    box.classList.add('show');
    document.getElementById('rekeningNama').textContent  = rekening[metode].nama;
    document.getElementById('rekeningNomor').textContent = rekening[metode].nomor;

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
      const reader = new FileReader();
      reader.onload = e => {
        document.getElementById('previewImg').src = e.target.result;
        document.getElementById('previewImg').style.display = 'block';
        document.getElementById('uploadArea').classList.add('has-file');
        document.getElementById('uploadText').textContent = '✅ ' + input.files[0].name;
      };
      reader.readAsDataURL(input.files[0]);
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

  /* ════════════════════════════════
     MODAL CANCEL BOOKING
  ════════════════════════════════ */
  function bukaModalCancel() {
    document.getElementById('modalCancel').classList.add('show');
    // Reset
    document.querySelectorAll('.alasan-item').forEach(i => i.classList.remove('selected'));
    document.getElementById('alasanBatalInput').value = '';
    document.getElementById('alasanLainWrap').style.display = 'none';
    setBtnCancel(false);
  }

  function tutupModalCancel() {
    document.getElementById('modalCancel').classList.remove('show');
  }

  function pilihAlasan(alasan, el) {
    document.querySelectorAll('.alasan-item').forEach(i => i.classList.remove('selected'));
    el.classList.add('selected');

    if (alasan === 'Lainnya') {
      document.getElementById('alasanLainWrap').style.display = 'block';
      document.getElementById('alasanBatalInput').value = '';
      setBtnCancel(false);
    } else {
      document.getElementById('alasanLainWrap').style.display = 'none';
      document.getElementById('alasanBatalInput').value = alasan;
      setBtnCancel(true);
    }
  }

  function updateAlasanLain(val) {
    document.getElementById('alasanBatalInput').value = val;
    setBtnCancel(val.trim().length > 0);
  }

  function setBtnCancel(aktif) {
    const btn = document.getElementById('btnKonfirmasiBatal');
    btn.disabled  = !aktif;
    btn.style.opacity = aktif ? '1' : '.5';
    btn.style.cursor  = aktif ? 'pointer' : 'not-allowed';
  }
</script>
@endsection