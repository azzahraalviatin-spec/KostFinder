@extends('layouts.user-sidebar')

@section('title', 'Ulasanku')

@section('styles')
<style>
  :root { --primary:#e8401c; --dark:#1e2d3d; }
  .page-wrap { max-width:780px; margin:0 auto; }

  /* Tabs */
  .review-tabs {
    display: flex;
    border-bottom: 2px solid #e4e9f0;
    margin-bottom: 1.25rem;
    background: #fff;
    border-radius: .85rem .85rem 0 0;
    padding: 0 1.2rem;
  }
  .review-tab {
    padding: .75rem 1.1rem; font-weight: 600; font-size: .83rem;
    color: #8fa3b8; text-decoration: none;
    border-bottom: 2px solid transparent; margin-bottom: -2px;
    transition: all .2s;
  }
  .review-tab.active { color: var(--primary); border-bottom-color: var(--primary); }

  /* Card ulasan */
  .review-card {
    background: #fff; border-radius: .85rem;
    border: 1px solid #e4e9f0;
    padding: 1rem 1.2rem; margin-bottom: .85rem;
    transition: box-shadow .2s;
  }
  .review-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,.07); }

  .review-kost { font-weight: 700; font-size: .88rem; color: var(--dark); }
  .review-kamar { font-size: .74rem; color: #888; margin-top: .1rem; }

  .star-row { display: flex; gap: 2px; margin: .5rem 0 .4rem; }
  .star-row i { font-size: .9rem; color: #fbbf24; }
  .star-row i.empty { color: #e4e9f0; }

  .review-text { font-size: .82rem; color: #374151; line-height: 1.6; }
  .review-date { font-size: .72rem; color: #aaa; margin-top: .5rem; }

  .badge-status {
    font-size: .68rem; font-weight: 700;
    padding: 2px 8px; border-radius: 99px;
    display: inline-block; margin-top: .4rem;
  }
  .badge-approved { background: #f0fdf4; color: #16a34a; }
  .badge-pending   { background: #fffbeb; color: #d97706; }
  .badge-rejected  { background: #fef2f2; color: #dc2626; }

  /* Empty */
  .empty-box {
    background: #fff; border-radius: 0 0 .85rem .85rem;
    border: 1px solid #e4e9f0; border-top: 0;
    padding: 3rem; text-align: center; color: #aaa;
  }
  .empty-box i { font-size: 2.5rem; display: block; margin-bottom: .75rem; color: #fde8e3; }
  .empty-box p { font-size: .83rem; margin: 0; }

  /* Pending review card */
  .pending-card {
    background: #fff; border-radius: .85rem;
    border: 1.5px dashed #ffd0c0;
    padding: 1rem 1.2rem; margin-bottom: .85rem;
    display: flex; align-items: center; justify-content: space-between; gap: 1rem;
  }
  .btn-beri-ulasan {
    background: var(--primary); color: #fff;
    border: 0; border-radius: .55rem;
    padding: .38rem .9rem; font-size: .76rem; font-weight: 700;
    cursor: pointer; white-space: nowrap;
    text-decoration: none; transition: background .18s;
  }
  .btn-beri-ulasan:hover { background: #cb3518; color: #fff; }

  /* Modal ulasan */
  #modalUlasan { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,.6); z-index: 999999; align-items: center; justify-content: center; backdrop-filter: blur(4px); }
  .star-input { display: flex; gap: .3rem; margin: .75rem 0; }
  .star-input i { font-size: 1.6rem; color: #e4e9f0; cursor: pointer; transition: color .15s; }
  
  .card:hover {
  transform: translateY(-3px);
  transition: .2s;
}.star-input i.active, .star-input i:hover { color: #fbbf24; }
.star-input i {
  font-size: 1.8rem;
  color: #e4e9f0;
  cursor: pointer;
  transition: all .2s ease;
}

.star-input i:hover {
  transform: scale(1.2);
}

#ratingText {
  transition: all .2s ease;
}   
.star-input i {
  font-size: 2rem;
  color: #e4e9f0;
  cursor: pointer;
  transition: all .2s ease;
}

/* Hover effect */
.star-input i:hover {
  transform: scale(1.25);
}

/* Efek saat dipilih */
.star-input i.active {
  transform: scale(1.2);
  color: #fbbf24;
}

/* Animasi teks rating */
#ratingText {
  transition: all .25s ease;
  display: inline-block;
}
</style>
@endsection

@section('content')

@php
  $user = auth()->user();
  $tab  = request('tab', 'ulasanku');

  // Ulasan yang sudah dibuat
  $ulasan = \App\Models\Review::where('user_id', $user->id)
            ->with(['kost'])
            ->latest()
            ->get();

  // Booking selesai yang belum diulas
  $belumDiulas = \App\Models\Booking::where('user_id', $user->id)
      ->where('status_booking', 'selesai')
      ->with(['room.kost'])
      ->get()
      ->filter(function ($b) use ($user) {
          return !\App\Models\Review::where('user_id', $user->id)
              ->where('kost_id', $b->room->kost->id)
              ->exists();
      });
@endphp

<div class="page-wrap">
  
  {{-- TABS --}}
  <div class="review-tabs">
    <a href="?tab=menunggu" class="review-tab {{ $tab === 'menunggu' ? 'active' : '' }}">
      Menunggu Diulas
      @if($belumDiulas->count())
        <span style="background:#E8401C;color:#fff;font-size:.62rem;font-weight:700;padding:1px 6px;border-radius:99px;margin-left:4px;">{{ $belumDiulas->count() }}</span>
      @endif
    </a>
    <a href="?tab=ulasanku" class="review-tab {{ $tab === 'ulasanku' ? 'active' : '' }}">Ulasan Saya</a>
  </div>

  <div class="row">
@{{-- TAB: MENUNGGU DIULAS --}}
@if($tab === 'menunggu')

  @if($belumDiulas->count())

  <div class="row">
    @foreach($belumDiulas as $b)
      <div class="col-md-3 mb-4">

        <div class="card h-100 shadow-sm" style="border-radius:12px;overflow:hidden;">
          
        <img 
  src="{{ asset('storage/' . $b->room->kost->foto_utama) }}"
  onerror="this.src='https://via.placeholder.com/300x150?text=No+Image'"
  style="height:140px;object-fit:cover;width:100%;">

          <div class="card-body p-2">
            
            <div style="font-weight:700;font-size:.8rem;">
              {{ $b->room->kost->nama_kost ?? '-' }}
            </div>

            <div style="font-size:.7rem;color:#888;">
              🚪 {{ $b->room->nomor_kamar ?? '-' }}
            </div>

            <div style="font-size:.68rem;color:#aaa;">
              {{ \Carbon\Carbon::parse($b->tanggal_selesai)->translatedFormat('d M Y') }}
            </div>

            <button class="btn btn-sm w-100 mt-2"
              style="background:#E8401C;color:#fff;font-size:.7rem;"
              onclick="bukaModalUlasan({{ $b->id_booking }}, '{{ addslashes($b->room->kost->nama_kost ?? '') }}')">
              ⭐ Beri Ulasan
            </button>

          </div>
        </div>

      </div>
    @endforeach
  </div>

  @else
    <div class="empty-box" style="border-radius:.85rem;border:1px solid #e4e9f0;">
      <i class="bi bi-check-circle"></i>
      <p>Semua booking sudah diulas. Terima kasih! 😊</p>
    </div>
  @endif


@endif
  {{-- TAB: ULASAN SAYA --}}
  @if($tab === 'ulasanku')
    @if($ulasan->count())
      @foreach($ulasan as $u)
      <div class="review-card">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:.5rem;">
          <div>
            <div class="review-kost">{{ $u->kost->nama_kost ?? '-' }}</div>
            <div class="review-kamar">📍 {{ $u->kost->kota ?? '-' }}</div>
          </div>
          @php
            $st = $u->status ?? 'pending';
            $stClass = match($st) { 'approved' => 'badge-approved', 'rejected' => 'badge-rejected', default => 'badge-pending' };
            $stLabel = match($st) { 'approved' => '✅ Ditampilkan', 'rejected' => '❌ Ditolak', default => '⏳ Menunggu Review' };
          @endphp
          <span class="badge-status {{ $stClass }}">{{ $stLabel }}</span>
        </div>

        <div class="star-row">
          @for($i = 1; $i <= 5; $i++)
            <i class="bi bi-star-fill {{ $i <= ($u->rating ?? 0) ? '' : 'empty' }}"></i>
          @endfor
          <span style="font-size:.75rem;color:#6b7280;margin-left:.3rem;font-weight:600;">{{ $u->rating }}/5</span>
        </div>

        <div class="review-text">{{ $u->komentar ?? $u->isi ?? '-' }}</div>
        <div class="review-date">{{ \Carbon\Carbon::parse($u->created_at)->translatedFormat('d F Y') }}</div>
      </div>
      @endforeach
    @else
      <div class="empty-box" style="border-radius:.85rem;border:1px solid #e4e9f0;">
        <i class="bi bi-star"></i>
        <p>Belum ada ulasan. Selesaikan booking untuk bisa memberikan ulasan!</p>
      </div>
    @endif
  @endif

</div>

{{-- MODAL BERI ULASAN --}}
<div id="modalUlasan" onclick="if(event.target===this)tutupModalUlasan()">
  <div style="background:#fff;border-radius:1rem;padding:1.6rem;width:100%;max-width:440px;margin:1rem;box-shadow:0 20px 60px rgba(0,0,0,.2);">
    <div style="font-weight:800;font-size:.98rem;color:var(--dark);margin-bottom:.2rem;">⭐ Beri Ulasan</div>
    <div style="font-size:.78rem;color:#888;margin-bottom:1rem;" id="modalUlasanKost"></div>

    <form id="formUlasan" method="POST" action="{{ route('user.review.store') }}">
      @csrf
      <input type="hidden" name="booking_id" id="ulasanBookingId">
      <input type="hidden" name="rating" id="ratingInput" value="0">

      <div style="font-size:.8rem;font-weight:700;color:#444;margin-bottom:.3rem;">Rating:</div>
      <div class="star-input" id="starInput">
  @for($i = 1; $i <= 5; $i++)
    <i class="bi bi-star-fill" data-val="{{ $i }}"></i>
  @endfor
</div>

<div id="ratingText" style="
  font-size:.8rem;
  font-weight:600;
  margin-top:.3rem;
  color:#888;
">
  Belum ada rating
</div>

      <div style="font-size:.8rem;font-weight:700;color:#444;margin-bottom:.4rem;margin-top:.6rem;">Komentar:</div>
      <textarea name="komentar" class="form-control" rows="3" placeholder="Ceritakan pengalamanmu di kos ini..." style="font-size:.82rem;border-radius:.6rem;resize:none;" required></textarea>

      <div class="d-flex gap-2 mt-3">
        <button type="button" onclick="tutupModalUlasan()" style="flex:1;padding:.55rem;border-radius:.55rem;border:1.5px solid #e4e9f0;background:#fff;font-size:.83rem;font-weight:600;color:#555;cursor:pointer;">Batal</button>
        <button type="submit" style="flex:1;padding:.55rem;border-radius:.55rem;border:0;background:var(--primary);color:#fff;font-size:.83rem;font-weight:700;cursor:pointer;">⭐ Kirim Ulasan</button>
      </div>
    </form>
  </div>
</div>

<section class="mt-5">
  <div class="container">
    <div style="
      background: linear-gradient(135deg,#0d1b2a,#1b263b);
      border-radius:16px;
      padding:30px;
      color:white;
    ">

      <span style="
        background:#ff7849;
        padding:4px 10px;
        border-radius:20px;
        font-size:.7rem;
        font-weight:700;
      ">
        UNTUK PEMILIK KOST
      </span>

      <h4 style="margin-top:10px;font-weight:800;">
        Daftarkan Kost Anda & <br>
        Jangkau Lebih Banyak Calon Penghuni
      </h4>

      <p style="font-size:.85rem;color:#ddd;">
        Tampilkan properti Anda secara profesional dan dapatkan penyewa lebih cepat.
      </p>

      <a href="#" class="btn btn-warning btn-sm">
        Pelajari Lebih Lanjut →
      </a>

    </div>
  </div>
</section>
@endsection


@section('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {

let currentRating = 0;

const ratingLabels = {
  1: "😡 Buruk banget",
  2: "😕 Kurang",
  3: "😐 Cukup",
  4: "😊 Bagus",
  5: "🔥 Mantap banget!"
};

const stars = document.querySelectorAll('#starInput i');
const ratingText = document.getElementById('ratingText');
const ratingInput = document.getElementById('ratingInput');

function updateStars(val) {
  stars.forEach((star, index) => {
    if (index < val) {
      star.style.color = "#fbbf24";
      star.style.transform = "scale(1.2)";
    } else {
      star.style.color = "#e4e9f0";
      star.style.transform = "scale(1)";
    }
  });
}

function updateText(val) {
  if (val === 0) {
    ratingText.innerHTML = "Belum ada rating";
    ratingText.style.color = "#888";
    return;
  }

  ratingText.innerHTML = ratingLabels[val];

  const colors = {
    1: "#dc2626",
    2: "#f97316",
    3: "#eab308",
    4: "#22c55e",
    5: "#16a34a"
  };

  ratingText.style.color = colors[val];

  ratingText.style.transform = "scale(1.1)";
  setTimeout(() => {
    ratingText.style.transform = "scale(1)";
  }, 150);
}

stars.forEach((star, index) => {

  star.addEventListener("click", () => {
    currentRating = index + 1;
    ratingInput.value = currentRating;

    updateStars(currentRating);
    updateText(currentRating);
  });

  star.addEventListener("mouseover", () => {
    updateStars(index + 1);
    updateText(index + 1);
  });

  star.addEventListener("mouseout", () => {
    updateStars(currentRating);
    updateText(currentRating);
  });

});

});
</script>
@endsection