@extends('layouts.user-sidebar')

@section('title', 'Pesananku')

@section('styles')
<style>
  :root { --primary:#e8401c; --dark:#1e2d3d; }

  .page-wrap { max-width:1200px; margin:0 auto; }

  #bookingList {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.25rem;
  }
  @media (max-width: 1100px) {
    #bookingList { grid-template-columns: repeat(2, 1fr); }
  }
  @media (max-width: 640px) {
    #bookingList { grid-template-columns: 1fr; }
  }

  /* Pagination */
  .pagination-wrap {
    display: flex; justify-content: center; align-items: center;
    gap: .4rem; margin-top: 2rem; flex-wrap: wrap;
  }
  .pagination-wrap .page-link {
    display: inline-flex; align-items: center; justify-content: center;
    width: 36px; height: 36px; border-radius: .5rem;
    border: 1.5px solid #e4e9f0; background: #fff;
    font-size: .82rem; font-weight: 700; color: #555;
    text-decoration: none; transition: all .2s;
  }
  .pagination-wrap .page-link:hover {
    border-color: var(--primary); color: var(--primary); background: #fff5f2;
  }
  .pagination-wrap .page-link.active {
    background: var(--primary); border-color: var(--primary); color: #fff;
  }
  .pagination-wrap .page-link.disabled {
    opacity: .4; pointer-events: none;
  }

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
    box-shadow: 0 4px 15px rgba(0,0,0,.03);
    overflow: hidden;
    transition: all .3s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    flex-direction: column;
    height: 100%;
  }
  .booking-card:hover { 
    box-shadow: 0 12px 30px rgba(0,0,0,.08); 
    transform: translateY(-5px);
    border-color: #d1d9e6;
  }

  .booking-card-head {
    padding: 1rem 1.2rem; border-bottom: 1px solid #f0f3f8;
    display: flex; justify-content: space-between; align-items: flex-start; gap: .5rem;
    background: #fafbfc;
  }
  .booking-card-body { padding: 1.2rem; flex: 1; display: flex; flex-direction: column; }
  .booking-card-foot {
    padding: .7rem 1.2rem; border-top: 1px solid #f0f3f8;
    display: flex; gap: .5rem; justify-content: flex-end; flex-wrap: wrap;
  }

  .kost-name { font-weight: 800; font-size: .9rem; color: var(--dark); }
  .kamar-name { font-size: .76rem; color: #888; margin-top: .1rem; }

  .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: .6rem 1rem; margin-top: .5rem; flex: 1; }
  .info-item .lbl { font-size: .72rem; color: #888; margin-bottom: .2rem; }
  .info-item .val { font-size: .85rem; font-weight: 700; color: var(--dark); }

  /* Status pills */
  .pill { padding: .22rem .7rem; border-radius: 999px; font-size: .7rem; font-weight: 700; display: inline-flex; align-items: center; gap: .3rem; white-space: nowrap; }
  .pill-pending   { background: #fff7ed; color: #ea580c; }
  .pill-diterima  { background: #f0fdf4; color: #16a34a; }
  .pill-ditolak   { background: #fef2f2; color: #dc2626; }
  .pill-selesai   { background: #f0f9ff; color: #0369a1; }
  .pill-dibatalkan{ background: #f8fafd; color: #aaa; }

  /* Notif pembayaran */
  .notif-box {
    margin-top: 1rem; padding: .65rem .85rem;
    border-radius: .6rem; font-size: .76rem; font-weight: 600;
    display: flex; align-items: center; gap: .5rem;
  }
  .notif-box.warning { background: #fffbf0; border: 1px solid #fde68a; color: #b45309; }
  .notif-box.success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #16a34a; }
  .notif-box.danger  { background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; }
  .notif-box.info    { background: #fff5f2; border: 1px solid #ffd0c0; color: #be3f1d; }

  /* Buttons */
  .btn-batal  { background: #fff; color: #dc2626; border: 1.5px solid #fecaca; border-radius: .5rem; padding: .38rem .85rem; font-size: .76rem; font-weight: 700; cursor: pointer; transition: all .2s; }
  .btn-batal:hover { background: #fef2f2; }
  .btn-detail { background: #f0f4f8; color: #555; border: 1.5px solid #e4e9f0; border-radius: .5rem; padding: .45rem .85rem; font-size: .8rem; font-weight: 700; cursor: pointer; text-decoration: none; transition: all .2s; width: 100%; text-align: center; }
  .btn-detail:hover { background: #e4e9f0; color: #333; }
  .btn-bayar  { background: var(--primary); color: #fff; border: 0; border-radius: .5rem; padding: .45rem .85rem; font-size: .8rem; font-weight: 700; cursor: pointer; text-decoration: none; transition: all .2s; text-align: center; }
  .btn-bayar:hover { background: #cb3518; color: #fff; }

  /* Empty */
  .empty-wrap { text-align: center; padding: 3rem 1rem; background: #fff; border-radius: 1rem; border: 1px solid #e4e9f0; color: #aaa; }
  .empty-wrap i { font-size: 2.5rem; display: block; margin-bottom: .75rem; color: #fde8e3; }

  /* Modal */
  .custom-modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,.6); z-index: 999999; align-items: center; justify-content: center; backdrop-filter: blur(4px); padding: 1rem; }
  .alasan-item { border: 1.5px solid #e4e9f0; border-radius: .65rem; padding: .65rem .9rem; cursor: pointer; margin-bottom: .45rem; font-size: .83rem; color: #444; transition: all .2s; }
  .alasan-item:hover, .alasan-item.selected { border-color: var(--primary); background: #fff5f2; color: var(--primary); font-weight: 700; }
  
  .mdl-content { background: #fff; border-radius: 1.2rem; width: 100%; max-width: 480px; overflow: hidden; display: flex; flex-direction: column; max-height: 90vh; box-shadow: 0 20px 60px rgba(0,0,0,.2); }
  .mdl-head { padding: 1.2rem 1.5rem; border-bottom: 1px solid #f0f3f8; display: flex; justify-content: space-between; align-items: center; background: #fafbfc; }
  .mdl-title { font-weight: 800; font-size: 1.05rem; color: var(--dark); }
  .mdl-close { background: none; border: none; font-size: 1.2rem; color: #aaa; cursor: pointer; transition: color .2s; }
  .mdl-close:hover { color: #dc2626; }
  .mdl-body { padding: 1.5rem; overflow-y: auto; flex: 1; }
  .mdl-foot { padding: 1.2rem 1.5rem; border-top: 1px solid #f0f3f8; display: flex; gap: .7rem; justify-content: flex-end; background: #fafbfc; flex-wrap: wrap; }
</style>
@endsection

@section('content')

@php
  $tabs = [
    'semua'    => 'Semua',
    'pending'  => 'Menunggu Konfirmasi',
    'diterima' => 'Check In',
    'selesai'    => 'Selesai',
    'dibatalkan' => 'Dibatalkan',
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
  @if($bookings->isEmpty())
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
      @foreach($bookings as $booking)
      @php
        $status = $booking->status_booking;
        $pillClass = match($status) {
          'pending'    => 'pill-pending',
          'diterima'   => 'pill-diterima',
          'ditolak'    => 'pill-ditolak',
          'selesai'    => 'pill-selesai',
          'dibatalkan' => 'pill-dibatalkan',
          default      => 'pill-dibatalkan',
        };
        $statusLabel = match($status) {
          'pending'    => '⏳ Menunggu',
          'diterima'   => '✅ Diterima',
          'ditolak'    => '❌ Ditolak Owner',
          'selesai'    => '🏁 Selesai',
          'dibatalkan' => '🚫 Dibatalkan',
          default      => '🚫 Dibatalkan',
        };
        $namaKost = $booking->room->kost->nama_kost ?? '-';
        $imgUrl = $booking->room->kost->foto_utama_url ?? asset('images/default-kost.jpg');
        $kostId = $booking->room->kost->id_kost ?? 0;
        
        $buktiPembayaran = $booking->bukti_pembayaran ? asset('storage/' . $booking->bukti_pembayaran) : null;

        $bookingData = [
          'id' => $booking->id_booking,
          'kost' => $namaKost,
          'kost_id' => $kostId,
          'kamar' => $booking->room->nomor_kamar ?? '-',
          'tipe_kamar' => $booking->room->tipe_kamar ?? '',
          'statusLabel' => $statusLabel,
          'pillClass' => $pillClass,
          'kota' => $booking->room->kost->kota ?? '-',
          'harga' => 'Rp ' . number_format($booking->total_harga ?? 0, 0, ',', '.'),
          'tgl_masuk' => \Carbon\Carbon::parse($booking->tanggal_masuk)->translatedFormat('d M Y'),
          'tgl_selesai' => $booking->tanggal_selesai ? \Carbon\Carbon::parse($booking->tanggal_selesai)->translatedFormat('d M Y') : '-',
          'durasi' => $booking->durasi_sewa . ' Bulan',
          'metode' => $booking->metode_pembayaran ?? '-',
          'status_bayar' => $booking->status_pembayaran ?? 'belum',
          'bukti_pembayaran' => $buktiPembayaran,
          'catatan' => $booking->catatan,
          'url_bayar' => route('user.booking.pembayaran', $booking->id_booking),
          'url_kost' => route('kost.show', $kostId),
          'is_pending' => $booking->status_booking === 'pending',
          'status_booking' => $booking->status_booking
        ];
      @endphp

      <div class="booking-card" data-nama="{{ strtolower($namaKost) }}" data-booking="{{ json_encode($bookingData) }}">
        
        <div style="width:100%; height:160px; position:relative; overflow:hidden;">
          <img src="{{ $imgUrl }}" style="width:100%; height:100%; object-fit:cover;" onerror="this.src='https://placehold.co/600x400/eeeeee/aaaaaa?text=No+Image';">
          <span class="pill {{ $pillClass }}" style="position:absolute; top:12px; right:12px; box-shadow:0 4px 12px rgba(0,0,0,0.15); backdrop-filter:blur(4px);">{{ $statusLabel }}</span>
        </div>

        <div class="booking-card-head" style="border-bottom:none; padding-bottom:0;">
          <div>
            <div class="kost-name">{{ $namaKost }}</div>
            <div class="kamar-name">
              🚪 Kamar {{ $booking->room->nomor_kamar ?? '-' }}
              {{ $booking->room->tipe_kamar ? '· '.$booking->room->tipe_kamar : '' }}
            </div>
          </div>
        </div>

        <div class="booking-card-body" style="padding-top:0.8rem; padding-bottom:1rem;">
          <div style="font-size:0.82rem; color:#6b7280; display:flex; align-items:center; gap:6px; margin-bottom:6px;">
            <i class="bi bi-geo-alt-fill" style="color:var(--primary); opacity:0.8;"></i> {{ $booking->room->kost->kota ?? '-' }}
          </div>
          <div style="font-size:0.82rem; color:#6b7280; display:flex; align-items:center; gap:6px;">
            <i class="bi bi-calendar-check-fill" style="color:var(--primary); opacity:0.8;"></i> {{ \Carbon\Carbon::parse($booking->tanggal_masuk)->translatedFormat('d M Y') }}
          </div>
          <div style="font-size:1.05rem; font-weight:800; color:var(--dark); margin-top:12px; border-top:1px dashed #e4e9f0; padding-top:12px;">
            Rp {{ number_format($booking->total_harga ?? 0, 0, ',', '.') }}
          </div>
        </div>

        <div class="booking-card-foot" style="background:#fff;">
          <button type="button" class="btn-detail" onclick="bukaModalDetail(this)">Lihat Detail Booking</button>
        </div>
      </div>
      @endforeach
    </div>

    {{-- PAGINATION --}}
    @if($bookings->hasPages())
    <div class="pagination-wrap">
      {{-- Prev --}}
      @if($bookings->onFirstPage())
        <span class="page-link disabled"><i class="bi bi-chevron-left"></i></span>
      @else
        <a class="page-link" href="{{ $bookings->previousPageUrl() }}"><i class="bi bi-chevron-left"></i></a>
      @endif

      {{-- Page Numbers --}}
      @foreach($bookings->getUrlRange(1, $bookings->lastPage()) as $page => $url)
        <a class="page-link {{ $page == $bookings->currentPage() ? 'active' : '' }}" href="{{ $url }}">{{ $page }}</a>
      @endforeach

      {{-- Next --}}
      @if($bookings->hasMorePages())
        <a class="page-link" href="{{ $bookings->nextPageUrl() }}"><i class="bi bi-chevron-right"></i></a>
      @else
        <span class="page-link disabled"><i class="bi bi-chevron-right"></i></span>
      @endif
    </div>
    @endif

  @endif

</div>

{{-- MODAL BATAL --}}
{{-- MODAL DETAIL BOOKING --}}
<div id="modalDetail" class="custom-modal" onclick="if(event.target===this)tutupModalDetail()">
  <div class="mdl-content">
    <div class="mdl-head">
      <div class="mdl-title">Detail Booking</div>
      <button class="mdl-close" onclick="tutupModalDetail()"><i class="bi bi-x-lg"></i></button>
    </div>
    <div class="mdl-body" id="mdlBodyDetail">
      {{-- Akan diisi via JS --}}
    </div>
    <div class="mdl-foot" id="mdlFootDetail">
      {{-- Akan diisi via JS --}}
    </div>
  </div>
</div>

{{-- MODAL BATAL --}}
<div id="modalBatal" class="custom-modal" onclick="if(event.target===this)tutupModalBatal()">
  <div class="mdl-content" style="max-width:420px; padding: 1.5rem;">
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
  function bukaModalDetail(btn) {
    try {
      const card = btn.closest('.booking-card');
      const data = JSON.parse(card.dataset.booking);

    // Build Body
    let bodyHtml = `
      <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem;">
        <div>
          <div class="kost-name" style="font-size:1.1rem;">${data.kost}</div>
          <div class="kamar-name" style="font-size:0.85rem;">🚪 Kamar ${data.kamar} ${data.tipe_kamar ? '· '+data.tipe_kamar : ''}</div>
        </div>
        <span class="pill ${data.pillClass}">${data.statusLabel}</span>
      </div>

      <div class="info-grid">
        <div class="info-item">
          <div class="lbl">📍 Lokasi</div>
          <div class="val">${data.kota}</div>
        </div>
        <div class="info-item">
          <div class="lbl">💰 Total Biaya</div>
          <div class="val" style="color:var(--primary); font-size:1rem;">${data.harga}</div>
        </div>
        <div class="info-item">
          <div class="lbl">📅 Tanggal Masuk</div>
          <div class="val">${data.tgl_masuk}</div>
        </div>
        <div class="info-item">
          <div class="lbl">🏁 Tanggal Selesai</div>
          <div class="val">${data.tgl_selesai}</div>
        </div>
        <div class="info-item">
          <div class="lbl">⏱️ Durasi</div>
          <div class="val">${data.durasi}</div>
        </div>
        <div class="info-item">
          <div class="lbl">💳 Metode Bayar</div>
          <div class="val">${data.metode}</div>
        </div>
      </div>
    `;

    if(data.status_booking !== 'selesai' && data.status_bayar === 'menunggu') {
      bodyHtml += `<div class="notif-box warning"><i class="bi bi-clock"></i> Bukti pembayaran dikirim — menunggu konfirmasi owner</div>`;
    } else if(data.status_booking === 'selesai' || data.status_bayar === 'lunas') {
      bodyHtml += `<div class="notif-box success"><i class="bi bi-check-circle"></i> Pembayaran sudah dikonfirmasi owner</div>`;
    } else if(data.status_bayar === 'ditolak') {
      bodyHtml += `<div class="notif-box danger"><i class="bi bi-x-circle"></i> Pembayaran ditolak — silakan hubungi owner</div>`;
    } else if(data.is_pending && data.status_bayar === 'belum') {
      bodyHtml += `<div class="notif-box info"><i class="bi bi-exclamation-triangle"></i> Belum upload bukti pembayaran</div>`;
    }

    if(data.bukti_pembayaran) {
      bodyHtml += `
      <div style="margin-top:1.2rem;">
        <div style="font-size:0.8rem; font-weight:700; color:#444; margin-bottom:0.5rem;">📸 Bukti Pembayaran:</div>
        <a href="${data.bukti_pembayaran}" target="_blank" style="display:block; border-radius:0.5rem; overflow:hidden; border:1px solid #e4e9f0; text-align:center; padding:0.5rem; background:#fafbfc; text-decoration:none;">
          <img src="${data.bukti_pembayaran}" style="max-height:180px; max-width:100%; border-radius:0.3rem; object-fit:contain;">
          <div style="font-size:0.75rem; color:var(--primary); margin-top:0.4rem; font-weight:600;"><i class="bi bi-box-arrow-up-right"></i> Lihat Penuh</div>
        </a>
      </div>
      `;
    }

    if(data.catatan) {
      bodyHtml += `<div style="margin-top:1rem;padding:.85rem;background:#f9fafb;border-radius:.5rem;border:1px dashed #e4e9f0;font-size:.8rem;color:#6b7280;font-weight:500;">
        💬 <i>"${data.catatan}"</i>
      </div>`;
    }

    document.getElementById('mdlBodyDetail').innerHTML = bodyHtml;

    // Build Foot
    let footHtml = '';
    if(data.kost_id > 0) {
      footHtml += `<a href="${data.url_kost}" class="btn-detail" style="width:auto; display:inline-block; padding:.45rem 1rem;">🏠 Lihat Kos</a>`;
    }
    if(data.is_pending && data.status_bayar === 'belum') {
      footHtml += `<a href="${data.url_bayar}" class="btn-bayar" style="width:auto; display:inline-block; padding:.45rem 1rem;">💳 Upload Bukti</a>`;
    }
    if(data.is_pending) {
      // Escape single quotes for JS handler
      const safeKost = data.kost ? data.kost.replace(/'/g, "\\'") : '';
      footHtml += `<button type="button" class="btn-batal" onclick="tutupModalDetail(); bukaModalBatal(${data.id}, '${safeKost}')" style="margin-left:auto;">🚫 Batalkan</button>`;
    } else {
      // Just a close button if no actions needed on the right
      footHtml += `<button type="button" class="btn-detail" onclick="tutupModalDetail()" style="width:auto; margin-left:auto; display:inline-block; padding:.45rem 1rem;">Tutup</button>`;
    }

    document.getElementById('mdlFootDetail').innerHTML = footHtml;
    document.getElementById('modalDetail').style.display = 'flex';
    } catch(err) {
      console.error("Error opening detail modal: ", err);
      alert("Terjadi kesalahan saat memuat detail. " + err.message);
    }
  }

  function tutupModalDetail() {
    document.getElementById('modalDetail').style.display = 'none';
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