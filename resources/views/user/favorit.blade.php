<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kos Favorit - KostFinder</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <style>
    body { font-family:'Plus Jakarta Sans',sans-serif; background:#f2f5fa; }

    .fav-wrap { max-width:900px; margin:auto; padding:1.5rem 1rem; }

    .fav-tabs {
      display:flex;
      border-bottom:2px solid #e4e9f0;
      margin-bottom:1.5rem;
      background:#fff;
      border-radius:.85rem .85rem 0 0;
      padding:0 1.2rem;
    }

    .fav-tab {
      padding:.85rem 1.2rem;
      font-weight:600;
      color:#8fa3b8;
      text-decoration:none;
      border-bottom:2px solid transparent;
    }

    .fav-tab.active {
      color:#e8401c;
      border-bottom-color:#e8401c;
    }

    .fav-grid {
      display:grid;
      grid-template-columns:repeat(auto-fill,minmax(260px,1fr));
      gap:1rem;
    }

    .kost-card {
      background:#fff;
      border-radius:.85rem;
      border:1px solid #e4e9f0;
      overflow:hidden;
      transition:.2s;
      cursor:pointer;
    }

    .kost-card:hover {
      box-shadow:0 8px 24px rgba(0,0,0,.1);
      transform:translateY(-2px);
    }

    .kost-card-img {
      position:relative;
      height:160px;
      overflow:hidden;
    }

    .kost-card-img img {
      width:100%;
      height:100%;
      object-fit:cover;
    }

    .kost-badge {
      position:absolute;
      top:8px;
      left:8px;
      background:#e8401c;
      color:#fff;
      font-size:12px;
      padding:3px 8px;
      border-radius:20px;
    }

    .fav-btn {
      position:absolute;
      top:8px;
      right:8px;
      background:#fff;
      border-radius:50%;
      width:32px;
      height:32px;
      border:none;
      display:flex;
      align-items:center;
      justify-content:center;
      box-shadow:0 2px 8px rgba(0,0,0,.2);
    }

    .fav-btn i { color:#e8401c; }

    .kost-card-body { padding:10px; }

    .kost-name {
      font-weight:700;
      font-size:14px;
    }

    .kost-loc {
      font-size:12px;
      color:#888;
    }

    .kost-type {
      font-size:11px;
      background:#eee;
      padding:2px 6px;
      border-radius:10px;
      display:inline-block;
      margin-top:5px;
    }

    .kost-price {
      font-weight:800;
      color:#e8401c;
      margin-top:5px;
    }

    .empty-state {
      text-align:center;
      padding:3rem;
      background:#fff;
      border-radius:0 0 .85rem .85rem;
    }
  </style>
</head>
<body>

@php
  $user = auth()->user();
  $tab = request('tab','favorit');

  $favorit = \App\Models\Favorite::where('user_id',$user->id)
              ->with('kost')->latest()->get();
@endphp

@include('layouts.navigation')

{{-- BREADCRUMB --}}
<div class="p-2 bg-white small text-secondary">
  Home > User > {{ $tab == 'favorit' ? 'Difavoritkan' : 'Pernah Dilihat' }}
</div>

<div class="fav-wrap">

  {{-- TABS --}}
  <div class="fav-tabs">
    <a href="?tab=favorit" class="fav-tab {{ $tab=='favorit'?'active':'' }}">Difavoritkan</a>
    <a href="?tab=dilihat" class="fav-tab {{ $tab=='dilihat'?'active':'' }}">Pernah Dilihat</a>
  </div>

  {{-- TAB FAVORIT --}}
  @if($tab=='favorit')

    @if($favorit->count())
      <div class="fav-grid">

        @foreach($favorit as $fav)
        @if($fav->kost)

        <div class="kost-card">

          <div class="kost-card-img">

            @if($fav->kost->foto_utama)
              <img src="{{ asset('storage/'.$fav->kost->foto_utama) }}">
            @else
              <div style="height:160px;display:flex;align-items:center;justify-content:center;">🏠</div>
            @endif

            {{-- badge --}}
            <span class="kost-badge">{{ $fav->kost->tipe_kost }}</span>

            {{-- tombol love --}}
            <form method="POST" action="{{ route('user.favorit.remove',$fav->id) }}">
              @csrf
              @method('DELETE')
              <button class="fav-btn" onclick="event.stopPropagation()">
                <i class="bi bi-heart-fill"></i>
              </button>
            </form>

          </div>

          {{-- klik card --}}
          <a href="#" style="text-decoration:none;color:inherit;">
            <div class="kost-card-body">
              <div class="kost-name">{{ $fav->kost->nama_kost }}</div>
              <div class="kost-loc">{{ $fav->kost->kota }}</div>
              <div class="kost-type">Kos {{ $fav->kost->tipe_kost }}</div>
              <div class="kost-price">
                Rp {{ number_format($fav->kost->harga_mulai,0,',','.') }}/bulan
              </div>
            </div>
          </a>

        </div>

        @endif
        @endforeach

      </div>

    @else
      <div class="empty-state">
        Belum ada kos favorit
      </div>
    @endif

  @endif

  {{-- TAB DILIHAT --}}
  @if($tab=='dilihat')
    <div class="empty-state">
      Belum ada kos dilihat
    </div>
  @endif

</div>

@include('layouts._bottom-nav')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>