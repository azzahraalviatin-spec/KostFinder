<div class="sidebar" id="sidebar">

  {{-- BRAND --}}
  <div class="sidebar-brand">
    <div class="brand-icon" style="background:linear-gradient(135deg,#e8401c,#ff7043);box-shadow:0 4px 12px rgba(232,64,28,.4);">
      🏠
    </div>
    <div class="brand-text">
      <div class="name">Kost<span>Finder</span></div>
      <div class="sub">Panel Pemilik Kost</div>
    </div>
  </div>

  {{-- MENU --}}
  <div class="sidebar-menu">

    <div class="menu-label">MENU UTAMA</div>

    <a href="{{ route('owner.dashboard') }}"
       class="menu-item {{ request()->routeIs('owner.dashboard') ? 'active' : '' }}">
      <i class="bi bi-speedometer2"></i><span>Dashboard</span>
    </a>

    <a href="{{ route('owner.kost.index') }}"
       class="menu-item {{ request()->routeIs('owner.kost.*') ? 'active' : '' }}">
      <i class="bi bi-house-door"></i><span>Data Kost Saya</span>
    </a>

    <a href="{{ route('owner.kamar.index') }}"
       class="menu-item {{ request()->routeIs('owner.kamar.*') ? 'active' : '' }}">
      <i class="bi bi-door-open"></i><span>Kelola Kamar</span>
    </a>

    <a href="{{ route('owner.booking.index') }}"
       class="menu-item {{ request()->routeIs('owner.booking.*') ? 'active' : '' }}">
      <i class="bi bi-journal-check"></i>
      <span>Kelola Booking</span>
      @php
        $pendingCount = \App\Models\Booking::whereHas('room.kost', fn($q) => $q->where('owner_id', auth()->id()))
          ->where('status_booking','pending')->count();
      @endphp
      @if($pendingCount > 0)
        <span style="margin-left:auto;background:linear-gradient(135deg,#e8401c,#ff7043);color:#fff;font-size:.6rem;font-weight:700;padding:.1rem .45rem;border-radius:999px;">
          {{ $pendingCount }}
        </span>
      @endif
    </a>

    <a href="{{ route('owner.statistik') }}"
       class="menu-item {{ request()->routeIs('owner.statistik') ? 'active' : '' }}">
      <i class="bi bi-graph-up"></i><span>Statistik</span>
    </a>

    <a href="{{ route('owner.review.index') }}"
       class="menu-item {{ request()->routeIs('owner.review.*') ? 'active' : '' }}">
      <i class="bi bi-star"></i>
      <span>Ulasan Kost</span>
      @php
        $pendingReviewsCount = \App\Models\Review::whereHas('kost', fn($q) => $q->where('owner_id', auth()->id()))
          ->where('status', 'pending')->count();
      @endphp
      @if($pendingReviewsCount > 0)
        <span style="margin-left:auto;background:linear-gradient(135deg,#f59e0b,#fbbf24);color:#fff;font-size:.6rem;font-weight:700;padding:.1rem .45rem;border-radius:999px;">
          {{ $pendingReviewsCount }}
        </span>
      @endif
    </a>

    {{-- KELUHAN -- fix pakai menu-item bukan nav-link --}}
    <a href="{{ route('owner.keluhan.index') }}"
       class="menu-item {{ request()->routeIs('owner.keluhan.*') || request()->is('owner/keluhan*') ? 'active' : '' }}">
      <i class="bi bi-exclamation-circle"></i><span>Keluhan</span>
    </a>

    <div class="menu-label" style="margin-top:.5rem;">AKUN</div>

    <a href="{{ route('owner.pengaturan') }}"
       class="menu-item {{ request()->routeIs('owner.pengaturan') ? 'active' : '' }}">
      <i class="bi bi-gear"></i><span>Pengaturan</span>
    </a>

    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" class="menu-item logout">
        <i class="bi bi-box-arrow-left"></i><span>Logout</span>
      </button>
    </form>

  </div>

  {{-- USER --}}
  <div class="sidebar-user" style="background:rgba(255,255,255,.04);border-top:1px solid rgba(255,255,255,.08);">
    <div class="user-avatar" style="overflow:hidden;padding:0;box-shadow:0 2px 8px rgba(0,0,0,.25);border:2px solid rgba(255,255,255,.15);">
      @if(auth()->user()->foto_profil)
        <img src="{{ asset('storage/'.auth()->user()->foto_profil) }}"
             style="width:32px;height:32px;object-fit:cover;border-radius:50%;" alt="foto">
      @else
        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
      @endif
    </div>
    <div class="user-info">
      <div class="user-name" style="font-size:.82rem;font-weight:700;color:#fff;">{{ auth()->user()->name }}</div>
      <div class="user-role" style="display:flex;align-items:center;gap:.3rem;color:rgba(255,255,255,.7);">
        <span style="width:6px;height:6px;background:#22c55e;border-radius:50%;display:inline-block;"></span>
        Pemilik Kost
      </div>
    </div>
  </div>

</div>