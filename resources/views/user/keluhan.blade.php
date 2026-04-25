@extends('layouts.user-sidebar')

@section('title', 'Keluhanku')

@section('styles')
<style>
  :root { --primary:#e8401c; --dark:#1e2d3d; }
  .page-wrap { max-width:780px; margin:0 auto; }

  /* Header action */
  .page-header {
    display: flex; align-items: center;
    justify-content: space-between; margin-bottom: 1.25rem;
  }
  .page-header h6 { font-weight: 800; font-size: .92rem; color: var(--dark); margin: 0; }
  .btn-tambah {
    background: var(--primary); color: #fff;
    border: 0; border-radius: .6rem;
    padding: .45rem 1rem; font-size: .78rem; font-weight: 700;
    cursor: pointer; display: flex; align-items: center; gap: .4rem;
    transition: background .18s; text-decoration: none;
  }
  .btn-tambah:hover { background: #cb3518; color: #fff; }

  /* Keluhan card */
  .keluhan-card {
    background: #fff; border-radius: .85rem;
    border: 1px solid #e4e9f0;
    padding: 1rem 1.2rem; margin-bottom: .85rem;
    transition: box-shadow .2s;
  }
  .keluhan-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,.07); }

  .keluhan-head { display: flex; justify-content: space-between; align-items: flex-start; gap: .5rem; margin-bottom: .6rem; }
  .keluhan-kost { font-weight: 700; font-size: .88rem; color: var(--dark); }
  .keluhan-kamar { font-size: .74rem; color: #888; margin-top: .1rem; }

  .badge-status {
    font-size: .68rem; font-weight: 700;
    padding: 3px 9px; border-radius: 99px;
    white-space: nowrap;
  }
  .badge-open     { background: #fff7ed; color: #ea580c; }
  .badge-proses   { background: #eff6ff; color: #3b82f6; }
  .badge-selesai  { background: #f0fdf4; color: #16a34a; }
  .badge-ditolak  { background: #fef2f2; color: #dc2626; }

  .keluhan-judul { font-weight: 700; font-size: .83rem; color: #374151; margin-bottom: .3rem; }
  .keluhan-isi   { font-size: .8rem; color: #6b7280; line-height: 1.6; }
  .keluhan-date  { font-size: .7rem; color: #aaa; margin-top: .5rem; }

  /* Balasan */
  .balasan-wrap {
    margin-top: .75rem; padding: .7rem .9rem;
    background: #f7f3f0; border-radius: .6rem;
    border-left: 3px solid var(--primary);
  }
  .balasan-label { font-size: .7rem; font-weight: 700; color: var(--primary); margin-bottom: .3rem; }
  .balasan-text  { font-size: .8rem; color: #374151; line-height: 1.5; }

  /* Empty */
  .empty-box {
    background: #fff; border-radius: .85rem;
    border: 1px solid #e4e9f0;
    padding: 3rem; text-align: center; color: #aaa;
  }
  .empty-box i { font-size: 2.5rem; display: block; margin-bottom: .75rem; color: #fde8e3; }
  .empty-box p { font-size: .83rem; margin: 0; }

  /* Modal */
  #modalKeluhan { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,.6); z-index: 999999; align-items: center; justify-content: center; backdrop-filter: blur(4px); }
</style>
@endsection

@section('content')

@php
  $user = auth()->user();

  // Booking aktif/selesai untuk pilihan keluhan
  $bookingAktif = \App\Models\Booking::where('user_id', $user->id)
                   ->whereIn('status_booking', ['diterima', 'selesai'])
                   ->with(['room.kost'])
                   ->latest()->get();
@endphp

<div class="page-wrap">

  {{-- HEADER --}}
  <div class="page-header">
    <h6><i class="bi bi-chat-left-text-fill me-2" style="color:var(--primary);"></i> Daftar Keluhan</h6>
    @if($bookingAktif->count())
    <a href="{{ route('keluhan.pilih') }}" class="btn btn-danger btn-sm">
  + Tambah Keluhan
</a>
    @endif
  </div>

  @if(session('success'))
    <div class="alert alert-success mb-3" style="font-size:.82rem;border-radius:.75rem;">{{ session('success') }}</div>
  @endif

  {{-- LIST KELUHAN --}}
  @if($keluhans->count())
    @foreach($keluhans as $keluhan)
    @php
      $st = $keluhan->status ?? 'pending';
      $stClass = match($st) {
        'diproses' => 'badge-proses',
        'proses'  => 'badge-proses',
        'selesai' => 'badge-selesai',
        'ditolak' => 'badge-ditolak',
        default   => 'badge-open',
      };
      $stLabel = match($st) {
        'diproses' => '🔄 Diproses',
        'proses'  => '🔄 Diproses',
        'selesai' => '✅ Selesai',
        'ditolak' => '❌ Ditolak',
        default   => '📬 Menunggu',
      };
    @endphp
    <div class="keluhan-card">
      <div class="keluhan-head">
        <div>
          <div class="keluhan-kost">{{ $keluhan->booking->room->kost->nama_kost ?? '-' }}</div>
          <div class="keluhan-kamar">🚪 Kamar {{ $keluhan->booking->room->nomor_kamar ?? '-' }}</div>
        </div>
        <span class="badge-status {{ $stClass }}">{{ $stLabel }}</span>
      </div>

      <div class="keluhan-judul">{{ $keluhan->jenis ?? 'Keluhan' }}</div>
      <div class="keluhan-isi">{{ $keluhan->deskripsi ?? '-' }}</div>
      <div class="keluhan-date">
        <i class="bi bi-clock"></i>
        {{ \Carbon\Carbon::parse($keluhan->created_at)->translatedFormat('d F Y, H:i') }}
      </div>

      @if($keluhan->balasan ?? null)
        <div class="balasan-wrap">
          <div class="balasan-label"><i class="bi bi-reply-fill me-1"></i> Balasan Owner</div>
          <div class="balasan-text">{{ $keluhan->balasan }}</div>
        </div>
      @endif
    </div>
    @endforeach
  @else
    <div class="empty-box">
      <i class="bi bi-chat-left-text"></i>
      <p>Belum ada keluhan yang diajukan.</p>
      @if($bookingAktif->count())
        <button class="btn-tambah mt-3 mx-auto" onclick="document.getElementById('modalKeluhan').style.display='flex'">
          <i class="bi bi-plus-lg"></i> Buat Keluhan
        </button>
      @else
        <p style="margin-top:.5rem;font-size:.76rem;color:#ccc;">Kamu belum memiliki booking aktif untuk diajukan keluhan.</p>
      @endif
    </div>
  @endif

</div>

{{-- MODAL TAMBAH KELUHAN --}}
<div id="modalKeluhan" onclick="if(event.target===this)this.style.display='none'">
  <div style="background:#fff;border-radius:1rem;padding:1.6rem;width:100%;max-width:460px;margin:1rem;box-shadow:0 20px 60px rgba(0,0,0,.2);max-height:90vh;overflow-y:auto;">
    <div style="font-weight:800;font-size:.98rem;color:var(--dark);margin-bottom:1rem;">📢 Buat Keluhan</div>

    <form method="POST" action="{{ route('keluhan.store') }}">
      @csrf

      <div class="mb-3">
        <label style="font-size:.8rem;font-weight:700;color:#444;margin-bottom:.4rem;display:block;">Pilih Booking:</label>
        <select name="booking_id" class="form-select form-select-sm" style="border-radius:.6rem;font-size:.82rem;" required>
          <option value="">-- Pilih Booking --</option>
          @foreach($bookingAktif as $b)
            <option value="{{ $b->id_booking }}">
              {{ $b->room->kost->nama_kost ?? '-' }} — Kamar {{ $b->room->nomor_kamar ?? '-' }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="mb-3">
        <label style="font-size:.8rem;font-weight:700;color:#444;margin-bottom:.4rem;display:block;">Jenis Keluhan:</label>
        <input type="text" name="jenis" class="form-control form-control-sm" placeholder="Contoh: AC rusak, kamar bocor, dll" style="border-radius:.6rem;font-size:.82rem;" required>
      </div>

      <div class="mb-3">
        <label style="font-size:.8rem;font-weight:700;color:#444;margin-bottom:.4rem;display:block;">Deskripsi:</label>
        <textarea name="deskripsi" class="form-control" rows="4" placeholder="Ceritakan keluhanmu secara detail..." style="font-size:.82rem;border-radius:.6rem;resize:none;" required></textarea>
      </div>

      <div class="d-flex gap-2">
        <button type="button" onclick="document.getElementById('modalKeluhan').style.display='none'" style="flex:1;padding:.55rem;border-radius:.55rem;border:1.5px solid #e4e9f0;background:#fff;font-size:.83rem;font-weight:600;color:#555;cursor:pointer;">Batal</button>
        <button type="submit" style="flex:1;padding:.55rem;border-radius:.55rem;border:0;background:var(--primary);color:#fff;font-size:.83rem;font-weight:700;cursor:pointer;">📢 Kirim Keluhan</button>
      </div>
    </form>
  </div>
</div>

@endsection