@extends('layouts.app')

@section('title', 'Booking Saya - KostFinder')

@section('styles')
<style>
  :root { --primary:#e8401c; --dark:#1e2d3d; --bg:#f0f4f8; }
  body { background:var(--bg); }

  .page-wrap { max-width:720px; margin:0 auto; padding:1.5rem 1rem 5rem; }
  .page-title { font-size:1.1rem; font-weight:800; color:var(--dark); margin-bottom:1.2rem; }

  .booking-card { background:#fff; border-radius:1rem; border:1px solid #e4e9f0; box-shadow:0 2px 8px rgba(0,0,0,.04); margin-bottom:1rem; overflow:hidden; }
  .booking-card-head { padding:1rem 1.2rem; border-bottom:1px solid #f0f3f8; display:flex; justify-content:space-between; align-items:center; }
  .booking-card-body { padding:1rem 1.2rem; }
  .booking-card-foot { padding:.75rem 1.2rem; border-top:1px solid #f0f3f8; display:flex; gap:.5rem; justify-content:flex-end; }

  .kost-name { font-weight:800; font-size:.92rem; color:var(--dark); }
  .kamar-name { font-size:.78rem; color:#888; margin-top:.1rem; }

  .info-grid { display:grid; grid-template-columns:1fr 1fr; gap:.5rem 1rem; margin-top:.8rem; }
  .info-item .lbl { font-size:.72rem; color:#aaa; }
  .info-item .val { font-size:.82rem; font-weight:600; color:var(--dark); margin-top:.1rem; }

  /* STATUS PILLS */
  .pill { padding:.25rem .75rem; border-radius:999px; font-size:.72rem; font-weight:700; display:inline-flex; align-items:center; gap:.3rem; }
  .pill-pending { background:#fff7ed; color:#ea580c; }
  .pill-diterima { background:#f0fdf4; color:#16a34a; }
  .pill-ditolak { background:#fef2f2; color:#dc2626; }
  .pill-selesai { background:#f0f9ff; color:#0369a1; }
  .pill-dibatalkan { background:#f8fafd; color:#aaa; }
  .pill-menunggu { background:#fffbf0; color:#b45309; }

  /* TOMBOL */
  .btn-batal { background:#fff; color:#dc2626; border:1.5px solid #fecaca; border-radius:.5rem; padding:.4rem .9rem; font-size:.78rem; font-weight:700; cursor:pointer; transition:all .2s; }
  .btn-batal:hover { background:#fef2f2; }
  .btn-detail { background:#f0f4f8; color:#555; border:1.5px solid #e4e9f0; border-radius:.5rem; padding:.4rem .9rem; font-size:.78rem; font-weight:600; cursor:pointer; text-decoration:none; transition:all .2s; }
  .btn-detail:hover { background:#e4e9f0; }
  .btn-bayar { background:var(--primary); color:#fff; border:0; border-radius:.5rem; padding:.4rem .9rem; font-size:.78rem; font-weight:700; cursor:pointer; text-decoration:none; transition:all .2s; }
  .btn-bayar:hover { background:#cb3518; color:#fff; }

  /* BUKTI PEMBAYARAN */
  .bukti-wrap { margin-top:.8rem; padding:.6rem .8rem; background:#f0fdf4; border:1px solid #bbf7d0; border-radius:.6rem; font-size:.78rem; color:#16a34a; }

  /* EMPTY */
  .empty-wrap { text-align:center; padding:3rem 1rem; color:#aaa; }
  .empty-wrap .icon { font-size:3rem; display:block; margin-bottom:.5rem; opacity:.4; }

  /* MODAL BATAL */
  #modalBatal { display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,.6); z-index:999999; align-items:center; justify-content:center; backdrop-filter:blur(4px); }
  .alasan-item { border:1.5px solid #e4e9f0; border-radius:.65rem; padding:.7rem 1rem; cursor:pointer; margin-bottom:.5rem; font-size:.85rem; color:#444; transition:all .2s; }
  .alasan-item:hover { border-color:var(--primary); background:#fff5f2; color:var(--primary); }
  .alasan-item.selected { border-color:var(--primary); background:#fff5f2; color:var(--primary); font-weight:700; }
</style>
@endsection

@section('content')
<div class="page-wrap">

  <div class="page-title">📋 Booking Saya</div>

  @if(session('success'))
    <div class="alert alert-success mb-3" style="font-size:.83rem;">{{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div class="alert alert-danger mb-3" style="font-size:.83rem;">{{ session('error') }}</div>
  @endif

  @if($bookings->isEmpty())
    <div class="empty-wrap">
      <span class="icon">📋</span>
      <div style="font-weight:700;font-size:.95rem;color:#555;">Belum ada booking</div>
      <div style="font-size:.82rem;margin-top:.3rem;">Yuk cari kost impianmu!</div>
      <a href="{{ route('home') }}" style="display:inline-block;margin-top:1rem;background:var(--primary);color:#fff;border-radius:.6rem;padding:.5rem 1.2rem;font-size:.82rem;font-weight:700;text-decoration:none;">🔍 Cari Kost</a>
    </div>
  @else
    @foreach($bookings as $booking)
    <div class="booking-card">
      <div class="booking-card-head">
        <div>
          <div class="kost-name">{{ $booking->room->kost->nama_kost ?? '-' }}</div>
          <div class="kamar-name">🚪 Kamar {{ $booking->room->nomor_kamar ?? '-' }} {{ $booking->room->tipe_kamar ? '· '.$booking->room->tipe_kamar : '' }}</div>
        </div>
        {{-- STATUS PILL --}}
        @php
          $status = $booking->status_booking;
          $pillClass = match($status) {
            'pending'    => 'pill-pending',
            'diterima'   => 'pill-diterima',
            'ditolak'    => 'pill-ditolak',
            'selesai'    => 'pill-selesai',
            default      => 'pill-dibatalkan',
          };
          $statusLabel = match($status) {
            'pending'    => '⏳ Menunggu',
            'diterima'   => '✅ Diterima',
            'ditolak'    => '❌ Ditolak',
            'selesai'    => '🏁 Selesai',
            default      => '🚫 Dibatalkan',
          };
        @endphp
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

        {{-- STATUS PEMBAYARAN --}}
        @if($booking->status_pembayaran === 'menunggu')
          <div class="bukti-wrap" style="background:#fffbf0;border-color:#fde68a;color:#b45309;">
            ⏳ Bukti pembayaran dikirim — menunggu konfirmasi owner
          </div>
        @elseif($booking->status_pembayaran === 'lunas')
          <div class="bukti-wrap">
            ✅ Pembayaran sudah dikonfirmasi owner
          </div>
        @elseif($booking->status_pembayaran === 'ditolak')
          <div class="bukti-wrap" style="background:#fef2f2;border-color:#fecaca;color:#dc2626;">
            ❌ Pembayaran ditolak — silakan hubungi owner
          </div>
        @elseif($booking->status_booking === 'pending' && $booking->status_pembayaran === 'belum')
          <div class="bukti-wrap" style="background:#fff5f2;border-color:#ffd0c0;color:#be3f1d;">
            ⚠️ Belum upload bukti pembayaran
          </div>
        @endif

        {{-- CATATAN --}}
        @if($booking->catatan)
          <div style="margin-top:.6rem;font-size:.78rem;color:#888;">💬 {{ $booking->catatan }}</div>
        @endif
      </div>

      <div class="booking-card-foot">
        <a href="{{ route('kost.show', $booking->room->kost->id_kost) }}" class="btn-detail">🏠 Lihat Kost</a>

        {{-- TOMBOL BAYAR jika belum upload bukti --}}
        @if($booking->status_booking === 'pending' && $booking->status_pembayaran === 'belum')
          <a href="{{ route('user.booking.pembayaran', $booking->id_booking) }}" class="btn-bayar">💳 Upload Bukti</a>
        @endif

        {{-- TOMBOL BATALKAN --}}
        @if($booking->status_booking === 'pending')
          <button class="btn-batal" onclick="bukaModalBatal({{ $booking->id_booking }}, '{{ $booking->room->kost->nama_kost ?? '' }}')">
            🚫 Batalkan
          </button>
        @endif
      </div>
    </div>
    @endforeach
  @endif

</div>

{{-- MODAL BATALKAN BOOKING --}}
<div id="modalBatal" onclick="if(event.target===this)tutupModalBatal()">
  <div style="background:#fff;border-radius:1rem;padding:1.8rem;width:100%;max-width:420px;margin:1rem;box-shadow:0 20px 60px rgba(0,0,0,.2);">
    <div style="font-weight:800;font-size:1rem;color:var(--dark);margin-bottom:.3rem;">🚫 Batalkan Booking</div>
    <div style="font-size:.8rem;color:#888;margin-bottom:1.2rem;" id="modalBatalKost"></div>

    <form id="formBatal" method="POST">
      @csrf @method('PATCH')
      <input type="hidden" name="alasan_batal" id="alasanBatalInput">

      <div style="font-size:.82rem;font-weight:700;color:#444;margin-bottom:.6rem;">Pilih alasan pembatalan:</div>

      <div class="alasan-item" onclick="pilihAlasan('Berubah pikiran', this)">😅 Berubah pikiran</div>
      <div class="alasan-item" onclick="pilihAlasan('Salah pilih kamar', this)">🚪 Salah pilih kamar</div>
      <div class="alasan-item" onclick="pilihAlasan('Ada keperluan mendadak', this)">⚡ Ada keperluan mendadak</div>
      <div class="alasan-item" onclick="pilihAlasan('Menemukan kost yang lebih cocok', this)">🏠 Menemukan kost yang lebih cocok</div>
      <div class="alasan-item" onclick="pilihAlasan('Lainnya', this)">✏️ Alasan lain</div>

      {{-- INPUT ALASAN LAIN --}}
      <div id="alasanLainWrap" style="display:none;margin-top:.5rem;">
        <textarea id="alasanLainText" class="form-control" rows="2" placeholder="Tulis alasanmu..." style="font-size:.82rem;border-radius:.6rem;" oninput="document.getElementById('alasanBatalInput').value=this.value"></textarea>
      </div>

      <div class="d-flex gap-2 mt-3">
        <button type="button" onclick="tutupModalBatal()" style="flex:1;padding:.6rem;border-radius:.55rem;border:1.5px solid #e4e9f0;background:#fff;font-size:.85rem;font-weight:600;color:#555;cursor:pointer;">
          Kembali
        </button>
        <button type="submit" id="btnKonfirmasiBatal" disabled style="flex:1;padding:.6rem;border-radius:.55rem;border:0;background:#dc2626;color:#fff;font-size:.85rem;font-weight:700;cursor:pointer;opacity:.5;">
          🚫 Konfirmasi Batal
        </button>
      </div>
    </form>
  </div>
</div>
@endsection

@section('scripts')
<script>
  function bukaModalBatal(bookingId, namaKost) {
    document.getElementById('formBatal').action = `/user/booking/${bookingId}/cancel`;
    document.getElementById('modalBatalKost').textContent = '🏠 ' + namaKost;
    document.getElementById('modalBatal').style.display = 'flex';
    // Reset
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

  // Kalau alasan lain diisi
  document.getElementById('alasanLainText')?.addEventListener('input', function() {
    const ada = this.value.trim().length > 0;
    document.getElementById('btnKonfirmasiBatal').disabled = !ada;
    document.getElementById('btnKonfirmasiBatal').style.opacity = ada ? '1' : '.5';
  });
</script>
@endsection