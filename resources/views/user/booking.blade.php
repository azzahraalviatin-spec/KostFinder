@extends('layouts.user-sidebar')

@section('title', 'Pesananku')

@section('styles')
<style>
  :root { --primary:#e8401c; --dark:#1e2d3d; }

  .page-wrap { max-width:780px; margin:0 auto; }

  /* Filter tabs */
  .filter-tabs {
    display: flex; gap: .5rem; flex-wrap: wrap;
    margin-bottom: 1.25rem;
  }
  .filter-tab {
    padding: .38rem .95rem; border-radius: 99px;
    border: 1.5px solid #e4e9f0; background: #fff;
    font-size: .78rem; font-weight: 600; color: #6b7280;
    cursor: pointer; text-decoration: none; transition: all .2s;
  }
  .filter-tab:hover { border-color: var(--primary); color: var(--primary); }
  .filter-tab.active { background: var(--primary); border-color: var(--primary); color: #fff; }

  /* Search */
  .search-wrap {
    display: flex; align-items: center; gap: .5rem;
    background: #fff; border: 1.5px solid #e4e9f0;
    border-radius: .75rem; padding: .5rem .9rem;
    margin-bottom: 1.25rem;
  }
  .search-wrap input {
    border: 0; outline: 0; flex: 1;
    font-size: .83rem; background: transparent;
    font-family: 'Plus Jakarta Sans', sans-serif;
  }
  .search-wrap i { color: #aaa; }

  /* Booking card */
  .booking-card {
    background: #fff; border-radius: 1rem;
    border: 1px solid #e4e9f0;
    box-shadow: 0 2px 8px rgba(0,0,0,.04);
    margin-bottom: 1rem; overflow: hidden;
    transition: box-shadow .2s;
  }
  .booking-card:hover { box-shadow: 0 6px 20px rgba(0,0,0,.08); }

  .booking-card-head {
    padding: .9rem 1.2rem; border-bottom: 1px solid #f0f3f8;
    display: flex; justify-content: space-between; align-items: center; gap: .5rem;
  }
  .booking-card-body { padding: .9rem 1.2rem; }
  .booking-card-foot {
    padding: .7rem 1.2rem; border-top: 1px solid #f0f3f8;
    display: flex; gap: .5rem; justify-content: flex-end; flex-wrap: wrap;
  }

  .kost-name { font-weight: 800; font-size: .9rem; color: var(--dark); }
  .kamar-name { font-size: .76rem; color: #888; margin-top: .1rem; }

  .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: .45rem .9rem; margin-top: .75rem; }
  .info-item .lbl { font-size: .7rem; color: #aaa; }
  .info-item .val { font-size: .81rem; font-weight: 600; color: var(--dark); margin-top: .08rem; }

  /* Status pills */
  .pill { padding: .22rem .7rem; border-radius: 999px; font-size: .7rem; font-weight: 700; display: inline-flex; align-items: center; gap: .3rem; white-space: nowrap; }
  .pill-pending   { background: #fff7ed; color: #ea580c; }
  .pill-diterima  { background: #f0fdf4; color: #16a34a; }
  .pill-ditolak   { background: #fef2f2; color: #dc2626; }
  .pill-selesai   { background: #f0f9ff; color: #0369a1; }
  .pill-dibatalkan{ background: #f8fafd; color: #aaa; }

  /* Notif pembayaran */
  .notif-box {
    margin-top: .7rem; padding: .55rem .8rem;
    border-radius: .6rem; font-size: .76rem; font-weight: 600;
    display: flex; align-items: center; gap: .4rem;
  }
  .notif-box.warning { background: #fffbf0; border: 1px solid #fde68a; color: #b45309; }
  .notif-box.success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #16a34a; }
  .notif-box.danger  { background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; }
  .notif-box.info    { background: #fff5f2; border: 1px solid #ffd0c0; color: #be3f1d; }

  /* Buttons */
  .btn-batal  { background: #fff; color: #dc2626; border: 1.5px solid #fecaca; border-radius: .5rem; padding: .38rem .85rem; font-size: .76rem; font-weight: 700; cursor: pointer; transition: all .2s; }
  .btn-batal:hover { background: #fef2f2; }
  .btn-detail { background: #f0f4f8; color: #555; border: 1.5px solid #e4e9f0; border-radius: .5rem; padding: .38rem .85rem; font-size: .76rem; font-weight: 600; cursor: pointer; text-decoration: none; transition: all .2s; }
  .btn-detail:hover { background: #e4e9f0; color: #333; }
  .btn-bayar  { background: var(--primary); color: #fff; border: 0; border-radius: .5rem; padding: .38rem .85rem; font-size: .76rem; font-weight: 700; cursor: pointer; text-decoration: none; transition: all .2s; }
  .btn-bayar:hover { background: #cb3518; color: #fff; }

  /* Empty */
  .empty-wrap { text-align: center; padding: 3rem 1rem; background: #fff; border-radius: 1rem; border: 1px solid #e4e9f0; color: #aaa; }
  .empty-wrap i { font-size: 2.5rem; display: block; margin-bottom: .75rem; color: #fde8e3; }

  /* Modal */
  #modalBatal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,.6); z-index: 999999; align-items: center; justify-content: center; backdrop-filter: blur(4px); }
  .alasan-item { border: 1.5px solid #e4e9f0; border-radius: .65rem; padding: .65rem .9rem; cursor: pointer; margin-bottom: .45rem; font-size: .83rem; color: #444; transition: all .2s; }
  .alasan-item:hover, .alasan-item.selected { border-color: var(--primary); background: #fff5f2; color: var(--primary); font-weight: 700; }
</style>
@endsection

@section('content')

@php
  $tab = request('tab', 'semua');
  $tabs = [
    'semua'    => 'Semua',
    'pending'  => 'Menunggu Konfirmasi',
    'diterima' => 'Check In',
    'selesai'  => 'Selesai',
    'batal'    => 'Dibatalkan',
  ];
@endphp

<div class="page-wrap">

  @if(session('success'))
    <div class="alert alert-success mb-3" style="font-size:.82rem;border-radius:.75rem;">{{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div class="alert alert-danger mb-3" style="font-size:.82rem;border-radius:.75rem;">{{ session('error') }}</div>
  @endif

  {{-- FILTER TABS --}}
  <div class="filter-tabs">
    @foreach($tabs as $key => $label)
      <a href="?tab={{ $key }}" class="filter-tab {{ $tab === $key ? 'active' : '' }}">{{ $label }}</a>
    @endforeach
  </div>

  {{-- SEARCH --}}
  <div class="search-wrap">
    <i class="bi bi-search"></i>
    <input type="text" id="searchInput" placeholder="Cari berdasarkan nama kos..." onkeyup="filterBooking()">
  </div>

  {{-- LIST --}}
  @php
    $filtered = $bookings->filter(function($b) use ($tab) {
      if ($tab === 'semua') return true;
      return $b->status_booking === $tab;
    });
  @endphp

  @if($filtered->isEmpty())
    <div class="empty-wrap">
      <i class="bi bi-calendar-x"></i>
      <div style="font-weight:700;font-size:.92rem;color:#555;">Belum ada pesanan</div>
      <div style="font-size:.8rem;margin-top:.3rem;">Yuk cari kos impianmu!</div>
      <a href="{{ route('kost.cari') }}" style="display:inline-block;margin-top:1rem;background:var(--primary);color:#fff;border-radius:.6rem;padding:.5rem 1.2rem;font-size:.8rem;font-weight:700;text-decoration:none;">
        <i class="bi bi-search me-1"></i> Cari Kos
      </a>
    </div>
  @else
    <div id="bookingList">
      @foreach($filtered as $booking)
      @php
        $status = $booking->status_booking;
        $pillClass = match($status) {
          'pending'  => 'pill-pending',
          'diterima' => 'pill-diterima',
          'ditolak'  => 'pill-ditolak',
          'selesai'  => 'pill-selesai',
          default    => 'pill-dibatalkan',
        };
        $statusLabel = match($status) {
          'pending'  => '⏳ Menunggu',
          'diterima' => '✅ Diterima',
          'ditolak'  => '❌ Ditolak',
          'selesai'  => '🏁 Selesai',
          default    => '🚫 Dibatalkan',
        };
        $namaKost = $booking->room->kost->nama_kost ?? '-';
      @endphp

      <div class="booking-card" data-nama="{{ strtolower($namaKost) }}">
        <div class="booking-card-head">
          <div>
            <div class="kost-name">{{ $namaKost }}</div>
            <div class="kamar-name">
              🚪 Kamar {{ $booking->room->nomor_kamar ?? '-' }}
              {{ $booking->room->tipe_kamar ? '· '.$booking->room->tipe_kamar : '' }}
            </div>
          </div>
          <span class="pill {{ $pillClass }}">{{ $statusLabel }}</span>
        </div>

        <div class="booking-card-body">
          <div class="info-grid">
            <div class="info-item">
              <div class="lbl">📍 Lokasi</div>
              <div class="val">{{ $booking->room->kost->kota ?? '-' }}</div>
            </div>
            <div class="info-item">
              <div class="lbl">💰 Total Biaya</div>
              <div class="val" style="color:var(--primary);">Rp {{ number_format($booking->total_harga ?? 0, 0, ',', '.') }}</div>
            </div>
            <div class="info-item">
              <div class="lbl">📅 Tanggal Masuk</div>
              <div class="val">{{ \Carbon\Carbon::parse($booking->tanggal_masuk)->translatedFormat('d M Y') }}</div>
            </div>
            <div class="info-item">
              <div class="lbl">🏁 Tanggal Selesai</div>
              <div class="val">{{ $booking->tanggal_selesai ? \Carbon\Carbon::parse($booking->tanggal_selesai)->translatedFormat('d M Y') : '-' }}</div>
            </div>
            <div class="info-item">
              <div class="lbl">⏱️ Durasi</div>
              <div class="val">{{ $booking->durasi_sewa }} Bulan</div>
            </div>
            <div class="info-item">
              <div class="lbl">💳 Metode Bayar</div>
              <div class="val">{{ $booking->metode_pembayaran ?? '-' }}</div>
            </div>
          </div>

          @if($booking->status_pembayaran === 'menunggu')
            <div class="notif-box warning"><i class="bi bi-clock"></i> Bukti pembayaran dikirim — menunggu konfirmasi owner</div>
          @elseif($booking->status_pembayaran === 'lunas')
            <div class="notif-box success"><i class="bi bi-check-circle"></i> Pembayaran sudah dikonfirmasi owner</div>
          @elseif($booking->status_pembayaran === 'ditolak')
            <div class="notif-box danger"><i class="bi bi-x-circle"></i> Pembayaran ditolak — silakan hubungi owner</div>
          @elseif($booking->status_booking === 'pending' && ($booking->status_pembayaran ?? 'belum') === 'belum')
            <div class="notif-box info"><i class="bi bi-exclamation-triangle"></i> Belum upload bukti pembayaran</div>
          @endif

          @if($booking->catatan)
            <div style="margin-top:.55rem;font-size:.76rem;color:#888;">💬 {{ $booking->catatan }}</div>
          @endif
        </div>

        <div class="booking-card-foot">
          @if($booking->room->kost ?? null)
            <a href="{{ route('kost.show', $booking->room->kost->id_kost) }}" class="btn-detail">🏠 Lihat Kos</a>
          @endif
          @if($booking->status_booking === 'pending' && ($booking->status_pembayaran ?? 'belum') === 'belum')
            <a href="{{ route('user.booking.pembayaran', $booking->id_booking) }}" class="btn-bayar">💳 Upload Bukti</a>
          @endif
          @if($booking->status_booking === 'pending')
            <button class="btn-batal" onclick="bukaModalBatal({{ $booking->id_booking }}, '{{ addslashes($namaKost) }}')">
              🚫 Batalkan
            </button>
          @endif
        </div>
      </div>
      @endforeach
    </div>
  @endif

</div>

{{-- MODAL BATAL --}}
<div id="modalBatal" onclick="if(event.target===this)tutupModalBatal()">
  <div style="background:#fff;border-radius:1rem;padding:1.6rem;width:100%;max-width:420px;margin:1rem;box-shadow:0 20px 60px rgba(0,0,0,.2);">
    <div style="font-weight:800;font-size:.98rem;color:var(--dark);margin-bottom:.25rem;">🚫 Batalkan Booking</div>
    <div style="font-size:.78rem;color:#888;margin-bottom:1.1rem;" id="modalBatalKost"></div>

    <form id="formBatal" method="POST">
      @csrf @method('PATCH')
      <input type="hidden" name="alasan_batal" id="alasanBatalInput">

      <div style="font-size:.8rem;font-weight:700;color:#444;margin-bottom:.55rem;">Pilih alasan pembatalan:</div>
      <div class="alasan-item" onclick="pilihAlasan('Berubah pikiran', this)">😅 Berubah pikiran</div>
      <div class="alasan-item" onclick="pilihAlasan('Salah pilih kamar', this)">🚪 Salah pilih kamar</div>
      <div class="alasan-item" onclick="pilihAlasan('Ada keperluan mendadak', this)">⚡ Ada keperluan mendadak</div>
      <div class="alasan-item" onclick="pilihAlasan('Menemukan kost yang lebih cocok', this)">🏠 Lebih cocok di tempat lain</div>
      <div class="alasan-item" onclick="pilihAlasan('Lainnya', this)">✏️ Alasan lain</div>

      <div id="alasanLainWrap" style="display:none;margin-top:.5rem;">
        <textarea id="alasanLainText" class="form-control" rows="2" placeholder="Tulis alasanmu..." style="font-size:.8rem;border-radius:.6rem;" oninput="document.getElementById('alasanBatalInput').value=this.value"></textarea>
      </div>

      <div class="d-flex gap-2 mt-3">
        <button type="button" onclick="tutupModalBatal()" style="flex:1;padding:.55rem;border-radius:.55rem;border:1.5px solid #e4e9f0;background:#fff;font-size:.83rem;font-weight:600;color:#555;cursor:pointer;">Kembali</button>
        <button type="submit" id="btnKonfirmasiBatal" disabled style="flex:1;padding:.55rem;border-radius:.55rem;border:0;background:#dc2626;color:#fff;font-size:.83rem;font-weight:700;cursor:pointer;opacity:.5;">🚫 Konfirmasi</button>
      </div>
    </form>
  </div>
</div>

@endsection

@section('scripts')
<script>
  function filterBooking() {
    const q = document.getElementById('searchInput').value.toLowerCase();
    document.querySelectorAll('.booking-card').forEach(card => {
      card.style.display = card.dataset.nama.includes(q) ? '' : 'none';
    });
  }

  function bukaModalBatal(id, nama) {
    document.getElementById('formBatal').action = `/user/booking/${id}/cancel`;
    document.getElementById('modalBatalKost').textContent = '🏠 ' + nama;
    document.getElementById('modalBatal').style.display = 'flex';
    document.querySelectorAll('.alasan-item').forEach(i => i.classList.remove('selected'));
    document.getElementById('alasanBatalInput').value = '';
    document.getElementById('alasanLainWrap').style.display = 'none';
    document.getElementById('btnKonfirmasiBatal').disabled = true;
    document.getElementById('btnKonfirmasiBatal').style.opacity = '.5';
  }

  function tutupModalBatal() {
    document.getElementById('modalBatal').style.display = 'none';
  }

  function pilihAlasan(alasan, el) {
    document.querySelectorAll('.alasan-item').forEach(i => i.classList.remove('selected'));
    el.classList.add('selected');
    if (alasan === 'Lainnya') {
      document.getElementById('alasanLainWrap').style.display = 'block';
      document.getElementById('alasanBatalInput').value = '';
      document.getElementById('btnKonfirmasiBatal').disabled = true;
      document.getElementById('btnKonfirmasiBatal').style.opacity = '.5';
    } else {
      document.getElementById('alasanLainWrap').style.display = 'none';
      document.getElementById('alasanBatalInput').value = alasan;
      document.getElementById('btnKonfirmasiBatal').disabled = false;
      document.getElementById('btnKonfirmasiBatal').style.opacity = '1';
    }
  }

  document.getElementById('alasanLainText')?.addEventListener('input', function() {
    const ada = this.value.trim().length > 0;
    document.getElementById('btnKonfirmasiBatal').disabled = !ada;
    document.getElementById('btnKonfirmasiBatal').style.opacity = ada ? '1' : '.5';
  });
</script>
@endsection