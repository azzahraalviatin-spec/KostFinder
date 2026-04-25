@extends('layouts.user-sidebar')

@section('title', 'Kos Favoritku')

@section('styles')
<style>
  .fav-tabs {
    display: flex;
    border-bottom: 2px solid #e4e9f0;
    margin-bottom: 1.25rem;
    background: #fff;
    border-radius: .85rem .85rem 0 0;
    padding: 0 1.2rem;
  }
  .fav-tab {
    padding: .8rem 1.1rem;
    font-weight: 600; font-size: .85rem;
    color: #8fa3b8; text-decoration: none;
    border-bottom: 2px solid transparent;
    margin-bottom: -2px;
    transition: all .2s;
  }
  .fav-tab.active { color: #E8401C; border-bottom-color: #E8401C; }

  .fav-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: 1rem;
  }

  .kost-card {
    background: #fff; border-radius: .85rem;
    border: 1px solid #e4e9f0; overflow: hidden;
    transition: all .2s; cursor: pointer;
  }
  .kost-card:hover { box-shadow: 0 8px 24px rgba(0,0,0,.1); transform: translateY(-2px); }

  .kost-card-img { position: relative; height: 155px; overflow: hidden; }
  .kost-card-img img { width: 100%; height: 100%; object-fit: cover; }
  .kost-badge {
    position: absolute; top: 8px; left: 8px;
    background: #E8401C; color: #fff;
    font-size: .7rem; font-weight: 700;
    padding: 3px 9px; border-radius: 99px;
  }
  .fav-btn {
    position: absolute; top: 8px; right: 8px;
    background: #fff; border-radius: 50%;
    width: 32px; height: 32px; border: none;
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 2px 8px rgba(0,0,0,.2); cursor: pointer;
    transition: transform .2s;
  }
  .fav-btn:hover { transform: scale(1.1); }
  .fav-btn i { color: #E8401C; font-size: .95rem; }

  .kost-card-body { padding: .85rem; }
  .kost-name { font-weight: 700; font-size: .88rem; color: #0f1923; }
  .kost-loc { font-size: .76rem; color: #8fa3b8; margin-top: .2rem; display: flex; align-items: center; gap: .3rem; }
  .kost-type {
    font-size: .7rem; font-weight: 600;
    background: #fff5f3; color: #E8401C;
    padding: 2px 8px; border-radius: 99px;
    display: inline-block; margin-top: .4rem;
  }
  .kost-price { font-weight: 800; color: #E8401C; font-size: .88rem; margin-top: .4rem; }

  .btn-lihat {
    display: block; text-align: center;
    background: #E8401C; color: #fff;
    font-size: .78rem; font-weight: 700;
    padding: .45rem; border-radius: .5rem;
    text-decoration: none; margin-top: .6rem;
    transition: background .18s;
  }
  .btn-lihat:hover { background: #c73015; color: #fff; }

  .empty-box {
    background: #fff; border-radius: 0 0 .85rem .85rem;
    border: 1px solid #e4e9f0; border-top: 0;
    padding: 3rem; text-align: center; color: #8fa3b8;
  }
  .empty-box i { font-size: 2.5rem; display: block; margin-bottom: .75rem; color: #fde8e3; }
  .empty-box p { font-size: .85rem; margin: 0; }
</style>
@endsection

@section('content')

@php
  $user = auth()->user();
  $tab  = request('tab', 'favorit');
  $favorit = \App\Models\Favorite::where('user_id', $user->id)
              ->with('kost')->latest()->get();
  $dilihat = \App\Models\RecentlyViewedKost::where('user_id', $user->id)
              ->with('kost')->orderBy('updated_at', 'desc')->get();
@endphp

{{-- TABS --}}
<div class="fav-tabs">
  <a href="?tab=favorit" class="fav-tab {{ $tab == 'favorit' ? 'active' : '' }}">
    <i class="bi bi-heart-fill me-1" style="font-size:.75rem;"></i> Difavoritkan
  </a>
  <a href="?tab=dilihat" class="fav-tab {{ $tab == 'dilihat' ? 'active' : '' }}">
    <i class="bi bi-eye me-1" style="font-size:.75rem;"></i> Pernah Dilihat
  </a>
</div>

@if($tab == 'favorit')
  @if($favorit->count())
    <div class="fav-grid">
      @foreach($favorit as $fav)
        @if($fav->kost)
        <div class="kost-card">
          <div class="kost-card-img">
            @if($fav->kost->foto_utama)
              <img src="{{ asset('storage/'.$fav->kost->foto_utama) }}">
            @else
              <div style="height:155px;display:flex;align-items:center;justify-content:center;background:#f7f3f0;font-size:2.5rem;">🏠</div>
            @endif
            <span class="kost-badge">{{ $fav->kost->tipe_kost ?? 'Kos' }}</span>
            <form method="POST" action="{{ route('user.favorit.destroy', $fav->id) }}">
              @csrf @method('DELETE')
              <button class="fav-btn" onclick="event.stopPropagation()" title="Hapus favorit">
                <i class="bi bi-heart-fill"></i>
              </button>
            </form>
          </div>
          <div class="kost-card-body">
            <div class="kost-name">{{ $fav->kost->nama_kost }}</div>
            <div class="kost-loc"><i class="bi bi-geo-alt"></i> {{ $fav->kost->kota }}</div>
            <span class="kost-type">Kos {{ $fav->kost->tipe_kost }}</span>
            <div class="kost-price">Rp {{ number_format($fav->kost->harga_mulai ?? 0, 0, ',', '.') }}/bulan</div>
            <a href="{{ route('kost.show', $fav->kost->id_kost) }}" class="btn-lihat">Lihat Detail</a>
          </div>
        </div>
        @endif
      @endforeach
    </div>
  @else
    <div class="empty-box">
      <i class="bi bi-heart"></i>
      <p>Belum ada kos favorit. <a href="{{ route('kost.cari') }}" style="color:#E8401C;font-weight:700;">Cari kos sekarang!</a></p>
    </div>
  @endif
@endif

@if($tab == 'dilihat')
  @if($dilihat->count())
    <div style="display:flex; justify-content:flex-end; margin-bottom: 1rem;">
      <form id="formClearHistory" action="{{ route('user.favorit.clearHistory') }}" method="POST">
        @csrf @method('DELETE')
        <button type="button" onclick="confirmClearHistory()" style="background:#fff; border:1px solid #fecaca; color:#dc2626; padding:.4rem .85rem; border-radius:.5rem; font-size:.8rem; font-weight:600; cursor:pointer; transition:all .2s;">
          <i class="bi bi-trash3"></i> Hapus Riwayat
        </button>
      </form>
    </div>
    
    <div class="fav-grid">
      @foreach($dilihat as $view)
        @if($view->kost)
        <div class="kost-card">
          <div class="kost-card-img">
            @if($view->kost->foto_utama)
              <img src="{{ asset('storage/'.$view->kost->foto_utama) }}">
            @else
              <div style="height:155px;display:flex;align-items:center;justify-content:center;background:#f7f3f0;font-size:2.5rem;">🏠</div>
            @endif
            <span class="kost-badge">{{ $view->kost->tipe_kost ?? 'Kos' }}</span>
          </div>
          <div class="kost-card-body">
            <div class="kost-name">{{ $view->kost->nama_kost }}</div>
            <div class="kost-loc"><i class="bi bi-geo-alt"></i> {{ $view->kost->kota }}</div>
            <span class="kost-type">Kos {{ $view->kost->tipe_kost }}</span>
            <div class="kost-price">Rp {{ number_format($view->kost->harga_mulai ?? 0, 0, ',', '.') }}/bulan</div>
            <div style="font-size:0.7rem; color:#8fa3b8; margin-top:0.4rem;"><i class="bi bi-clock-history"></i> Dilihat {{ $view->updated_at->diffForHumans() }}</div>
            <a href="{{ route('kost.show', $view->kost->id_kost) }}" class="btn-lihat" style="background:#f0f4f8; color:#475569;">Lihat Kembali</a>
          </div>
        </div>
        @endif
      @endforeach
    </div>
  @else
    <div class="empty-box">
      <i class="bi bi-eye"></i>
      <p>Belum ada riwayat kos yang dilihat.</p>
    </div>
  @endif
@endif

@endsection

@section('scripts')
<script>
  function confirmClearHistory() {
    Swal.fire({
      title: 'Hapus Riwayat?',
      text: "Semua riwayat kos yang pernah Anda lihat akan dihapus.",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#dc2626',
      cancelButtonColor: '#8fa3b8',
      confirmButtonText: 'Ya, Hapus!',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        document.getElementById('formClearHistory').submit();
      }
    })
  }
</script>
@endsection