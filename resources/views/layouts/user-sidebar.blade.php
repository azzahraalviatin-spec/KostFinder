<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Dashboard') - KostFinder</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Fraunces:opsz,wght@9..144,800&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f7f3f0; }

    /* ══ LAYOUT UTAMA ══
       uf-body  = flex column, full height
       uf-wrap  = area tengah (sidebar + konten), flex: 1
       uf-footer-area = footer yang full width, di luar uf-wrap
    */
    .uf-body {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    /* Wrapper sidebar + konten — flex: 1 agar menekan footer ke bawah */
    .uf-wrap {
      display: flex;
      flex: 1;
      align-items: flex-start;
      padding: 1rem;
      gap: 1rem;
    }

    /* ══ SIDEBAR WRAPPER ══ */
    .uf-sidebar-wrap {
      flex-shrink: 0;
      display: flex;
      flex-direction: column;
      gap: .5rem;
      transition: all .3s ease;
    }

    /* Tombol MENU */
    .uf-menu-btn {
      background: #D0783B;
      color: #fff;
      border: 0;
      padding: .45rem 1rem;
      border-radius: .6rem;
      font-weight: 700;
      font-size: .82rem;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: .4rem;
      transition: background .18s;
      width: fit-content;
    }
    .uf-menu-btn:hover { background: #b5622e; }
    .uf-menu-btn i { font-size: .85rem; transition: transform .3s; }
    .uf-menu-btn.collapsed-btn i.chevron { transform: rotate(-90deg); }

    /* ══ SIDEBAR ══ */
    .uf-sidebar {
      width: 235px;
      background: linear-gradient(160deg, #e08a4a 0%, #D0783B 45%, #b5622e 100%);
      border-radius: 1.2rem;
      display: flex;
      flex-direction: column;
      position: relative;
      overflow: hidden;
      transition: all .3s ease;
      box-shadow: 0 8px 24px rgba(176,90,30,.25);
    }

    .uf-sidebar.collapsed {
      width: 0;
      opacity: 0;
      pointer-events: none;
      overflow: hidden;
    }

    .uf-sidebar::before {
      content: '';
      position: absolute; top: -40px; right: -40px;
      width: 160px; height: 160px; border-radius: 50%;
      background: rgba(255,255,255,.07); pointer-events: none;
    }

    .uf-sidebar-inner {
      width: 235px;
      display: flex;
      flex-direction: column;
      overflow: hidden;
    }

    /* User card */
    .uf-sb-user {
      margin: 1rem .85rem .6rem;
      background: rgba(255,255,255,.18);
      border-radius: .75rem; padding: .75rem .85rem;
      display: flex; align-items: center; gap: .65rem;
    }
    .uf-sb-avatar {
      width: 36px; height: 36px; border-radius: 50%;
      background: rgba(255,255,255,.3);
      border: 2px solid rgba(255,255,255,.5);
      display: flex; align-items: center; justify-content: center;
      color: #fff; font-weight: 800; font-size: .82rem;
      flex-shrink: 0; overflow: hidden;
    }
    .uf-sb-avatar img { width: 100%; height: 100%; object-fit: cover; }
    .uf-sb-name { font-weight: 700; font-size: .82rem; color: #fff; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .uf-sb-role { font-size: .66rem; font-weight: 600; color: rgba(255,255,255,.75); margin-top: 1px; }

    /* Divider */
    .uf-sb-div { height: 1px; background: rgba(255,255,255,.18); margin: .35rem .85rem; }

    /* Section label */
    .uf-sb-section {
      font-size: .61rem; font-weight: 800;
      text-transform: uppercase; letter-spacing: .12em;
      color: rgba(255,255,255,.5);
      padding: .45rem 1.1rem .2rem;
      white-space: nowrap;
    }

    /* Nav item */
    .uf-sb-item {
      display: flex; align-items: center; gap: .6rem;
      padding: .52rem .9rem; margin: .04rem .6rem;
      border-radius: .58rem; text-decoration: none;
      color: rgba(255,255,255,.88); font-size: .82rem; font-weight: 600;
      transition: all .18s; white-space: nowrap;
    }
    .uf-sb-item i { font-size: .88rem; width: 16px; text-align: center; flex-shrink: 0; }
    .uf-sb-item:hover { background: rgba(255,255,255,.18); color: #fff; }
    .uf-sb-item.active {
      background: #fff; color: #D0783B; font-weight: 700;
      box-shadow: 0 3px 10px rgba(0,0,0,.12);
    }
    .uf-sb-item.active i { color: #D0783B; }

    /* Logout */
    .uf-sb-logout {
      display: flex; align-items: center; gap: .6rem;
      padding: .52rem .9rem; margin: .04rem .6rem;
      border-radius: .58rem; color: rgba(255,255,255,.75);
      font-size: .82rem; font-weight: 600;
      cursor: pointer; border: none; background: transparent;
      width: calc(100% - 1.2rem); text-align: left;
      transition: all .18s; white-space: nowrap;
      margin-bottom: .85rem;
    }
    .uf-sb-logout:hover { background: rgba(255,255,255,.14); color: #fff; }
    .uf-sb-logout i { font-size: .88rem; width: 16px; text-align: center; }

    /* ══ MAIN AREA ══ */
    .uf-main-area {
      flex: 1;
      display: flex;
      flex-direction: column;
      min-width: 0;
    }

    /* Subbar */
    .uf-subbar {
      background: #fff; border-radius: .85rem;
      border: 1px solid #edf0f7;
      padding: .55rem 1.1rem;
      display: flex; align-items: center; gap: .75rem;
      margin-bottom: 1rem;
      box-shadow: 0 2px 8px rgba(0,0,0,.04);
    }
    .uf-subbar-title { font-weight: 700; font-size: .88rem; color: #0f1923; }
    .uf-subbar-breadcrumb { font-size: .76rem; color: #8fa3b8; margin-left: auto; }
    .uf-subbar-breadcrumb a { color: #8fa3b8; text-decoration: none; }
    .uf-subbar-breadcrumb a:hover { color: #D0783B; }

    /* Content */
    .uf-content { flex: 1; }

    /* ══ FOOTER AREA — full width, di luar sidebar ══ */
    .uf-footer-area {
      width: 100%;
      margin-top: auto; /* dorong ke bawah jika konten pendek */
    }

    @media (max-width: 768px) {
      .uf-wrap { padding: .75rem; gap: .75rem; }
    }

    /* Mobile */
    @media (max-width: 991px) {
      .uf-sidebar-wrap { position: fixed; top: 70px; left: 1rem; z-index: 500; }
      .uf-sidebar { box-shadow: 0 12px 40px rgba(0,0,0,.2); }
      .uf-wrap { padding-top: 3.5rem; }
    }

    .uf-backdrop {
      display: none; position: fixed; inset: 0;
      background: rgba(0,0,0,.35); z-index: 490;
    }
    .uf-backdrop.open { display: block; }
  </style>

  @yield('styles')
</head>
<body>

<div class="uf-body">

  {{-- ══ NAVBAR ══ --}}
  @include('layouts.navigation')

  <div class="uf-backdrop" id="ufBackdrop" onclick="closeSidebar()"></div>

  {{-- ══ TENGAH: Sidebar + Konten ══ --}}
  <div class="uf-wrap">

    {{-- SIDEBAR WRAP --}}
    <div class="uf-sidebar-wrap" id="ufSidebarWrap">

      {{-- Tombol MENU --}}
      <button class="uf-menu-btn" id="menuBtn" onclick="toggleSidebar()">
        <i class="bi bi-list"></i>
        MENU
        <i class="bi bi-chevron-down chevron" id="menuChevron"></i>
      </button>

      {{-- Sidebar --}}
      <aside class="uf-sidebar" id="ufSidebar">
        <div class="uf-sidebar-inner">

          <div class="uf-sb-user">
            <div class="uf-sb-avatar">
              @if(auth()->user()->foto_profil)
                <img src="{{ asset('storage/'.auth()->user()->foto_profil) }}">
              @else
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
              @endif
            </div>
            <div style="min-width:0;">
              <div class="uf-sb-name">{{ auth()->user()->name }}</div>
              <div class="uf-sb-role">Pencari Kos</div>
            </div>
          </div>

          <div class="uf-sb-div"></div>
          <div class="uf-sb-section">Menu Utama</div>

          <a href="{{ route('user.dashboard') }}" class="uf-sb-item {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2-fill"></i> Dashboard
          </a>
          <a href="{{ route('user.booking.index') }}" class="uf-sb-item {{ request()->routeIs('user.booking*') ? 'active' : '' }}">
            <i class="bi bi-calendar-check-fill"></i> Pesananku
          </a>
          <a href="{{ route('user.favorit') }}" class="uf-sb-item {{ request()->routeIs('user.favorit') ? 'active' : '' }}">
            <i class="bi bi-heart-fill"></i> Kos Favoritku
          </a>

          <div class="uf-sb-div"></div>
          <div class="uf-sb-section">Aktivitas</div>

          <a href="{{ route('user.ulasan.index') }}" class="uf-sb-item {{ request()->routeIs('user.ulasan*') ? 'active' : '' }}">
            <i class="bi bi-star-fill"></i> Ulasanku
          </a>
          <a href="{{ route('keluhan.index') }}" class="uf-sb-item {{ request()->routeIs('keluhan*') ? 'active' : '' }}">
            <i class="bi bi-chat-left-text-fill"></i> Keluhanku
          </a>

          <div class="uf-sb-div"></div>
          <div class="uf-sb-section">Lainnya</div>

          <a href="{{ route('kost.cari') }}" class="uf-sb-item">
            <i class="bi bi-search"></i> Cari Kos
          </a>
          <div class="uf-sb-item-wrap">
            <a href="#" onclick="toggleProfilSubmenu(event)" class="uf-sb-item {{ request()->routeIs('user.profil*', 'user.verifikasi*', 'user.pengaturan*') ? 'active' : '' }}">
              <i class="bi bi-person-circle"></i> Profil Saya
              <i class="bi bi-chevron-down ms-auto" id="profilChevron" style="font-size:.7rem; transition:transform .3s; {{ request()->routeIs('user.profil*', 'user.verifikasi*', 'user.pengaturan*') ? 'transform:rotate(-180deg);' : '' }}"></i>
            </a>
            <div class="uf-sb-submenu" id="profilSubmenu" style="display: {{ request()->routeIs('user.profil*', 'user.verifikasi*', 'user.pengaturan*') ? 'block' : 'none' }}; padding-left: 1.5rem; margin-top: 0.2rem;">
              <a href="{{ route('user.profil') }}" class="uf-sb-item {{ request()->routeIs('user.profil*') ? 'active' : '' }}" style="font-size: .8rem; padding: .4rem .9rem; margin-bottom: .2rem; min-height: auto;">
                Data Diri
              </a>
           <a href="{{ route('user.verifikasi.index') }}" class="uf-sb-item {{ request()->routeIs('user.verifikasi*') ? 'active' : '' }}" style="font-size: .8rem; padding: .4rem .9rem; margin-bottom: .2rem; min-height: auto;">
  Verifikasi Akun
</a>
<a href="{{ route('user.pengaturan.index') }}" class="uf-sb-item {{ request()->routeIs('user.pengaturan*') ? 'active' : '' }}" style="font-size: .8rem; padding: .4rem .9rem; margin-bottom: .2rem; min-height: auto;">
  Pengaturan
</a>
            </div>
          </div>

          <div class="uf-sb-div" style="margin-top:.5rem;"></div>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="uf-sb-logout">
              <i class="bi bi-box-arrow-left"></i> Keluar dari Akun
            </button>
          </form>

        </div>
      </aside>
    </div>

    {{-- MAIN AREA (konten halaman) --}}
    <div class="uf-main-area">

      <div class="uf-subbar">
        <span class="uf-subbar-title">@yield('title', 'Dashboard')</span>
        <span class="uf-subbar-breadcrumb">
          <a href="{{ route('home') }}">Beranda</a> / @yield('title', 'Dashboard')
        </span>
      </div>

      <div class="uf-content">
        @yield('content')
      </div>

    </div>
    {{-- akhir .uf-main-area --}}

  </div>
  {{-- akhir .uf-wrap —— FOOTER HARUS DI LUAR SINI --}}

  {{-- ══ FOOTER: full width dari kiri ke kanan ══ --}}
  <div class="uf-footer-area">
    @include('layouts.footer')
  </div>

</div>
{{-- akhir .uf-body --}}

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  const sidebar  = document.getElementById('ufSidebar');
  const backdrop = document.getElementById('ufBackdrop');
  const menuBtn  = document.getElementById('menuBtn');
  const chevron  = document.getElementById('menuChevron');
  let isOpen = true;

  function toggleSidebar() {
    isOpen = !isOpen;
    sidebar.classList.toggle('collapsed', !isOpen);
    chevron.style.transform = isOpen ? 'rotate(0deg)' : 'rotate(-90deg)';
    if (window.innerWidth < 992) {
      backdrop.classList.toggle('open', isOpen);
    }
  }

  function closeSidebar() {
    isOpen = false;
    sidebar.classList.add('collapsed');
    chevron.style.transform = 'rotate(-90deg)';
    backdrop.classList.remove('open');
  }

  function toggleProfilSubmenu(e) {
    e.preventDefault();
    const sub = document.getElementById('profilSubmenu');
    const chev = document.getElementById('profilChevron');
    if (sub.style.display === 'none') {
      sub.style.display = 'block';
      chev.style.transform = 'rotate(-180deg)';
    } else {
      sub.style.display = 'none';
      chev.style.transform = 'rotate(0deg)';
    }
  }

  window.addEventListener('resize', () => {
    if (window.innerWidth >= 992) {
      backdrop.classList.remove('open');
    }
  });
</script>

@if(session('success'))
<script>
  Swal.fire({
    icon: 'success',
    title: 'Berhasil!',
    text: '{{ session('success') }}',
    showConfirmButton: false,
    timer: 2000
  });
</script>
@endif

@if(session('error'))
<script>
  Swal.fire({
    icon: 'error',
    title: 'Oops...',
    text: '{{ session('error') }}',
    confirmButtonColor: '#E8401C'
  });
</script>
@endif

@yield('scripts')
</body>
</html>