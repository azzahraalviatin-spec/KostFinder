@auth
@if(auth()->user()->role === 'user')

<div class="u-bottom-nav" id="uBottomNav">

  <a href="{{ route('home') }}" class="u-bn-item {{ request()->routeIs('home') && !request()->is('user/*') ? 'active' : '' }}">
    <i class="bi bi-search"></i>
    <span>Cari</span>
  </a>

  <a href="{{ route('user.favorit') }}" class="u-bn-item {{ request()->routeIs('user.favorit') ? 'active' : '' }}">
    <i class="bi bi-heart"></i>
    <span>Favorit</span>
  </a>

  <a href="{{ route('user.profil') }}" 
     onclick="toggleProfilMenu(event)"
     class="u-bn-item {{ request()->routeIs('user.profil') ? 'active' : '' }}">

    <div class="u-bn-avatar">
      @if(auth()->user()->foto_profil)
        <img src="{{ asset('storage/'.auth()->user()->foto_profil) }}" alt="foto">
      @else
        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
      @endif
    </div>
    <span>Profil</span>
  </a>

</div>

{{-- PROFIL POPUP --}}
<div class="u-profil-popup" id="uProfilPopup">
  <div class="u-pp-handle"></div>

  <div class="u-pp-user">
    <div class="u-pp-avatar">
      @if(auth()->user()->foto_profil)
        <img src="{{ asset('storage/'.auth()->user()->foto_profil) }}" alt="foto">
      @else
        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
      @endif
    </div>
    <div>
      <div class="u-pp-name">{{ auth()->user()->name }}</div>
      <div class="u-pp-email">{{ auth()->user()->email }}</div>
      <span class="u-pp-role">Penyewa Kost</span>
    </div>
  </div>

  <div class="u-pp-menu">
    <a href="#" class="u-pp-item">
      <i class="bi bi-person-circle"></i> Edit Profil
    </a>
    <a href="#" class="u-pp-item">
      <i class="bi bi-bell"></i> Notifikasi
    </a>
    <a href="#" class="u-pp-item">
      <i class="bi bi-shield-check"></i> Keamanan Akun
    </a>
    <a href="#" class="u-pp-item">
      <i class="bi bi-question-circle"></i> Bantuan
    </a>

    <div class="u-pp-divider"></div>

  {{-- Ganti bagian logout di dropdown user --}}
<li>
    <form method="POST" action="{{ route('logout') }}" id="logout-form-user">
        @csrf
        <button type="submit" class="dropdown-item d-flex align-items-center gap-2 text-danger">
            <i class="bi bi-box-arrow-right" style="width:14px;"></i> Logout
        </button>
    </form>
</li>
  </div>
</div>

{{-- BACKDROP --}}
<div class="u-pp-backdrop" id="uPpBackdrop" onclick="closeProfilMenu()"></div>

<style>

/* ========================= */
/* 🔥 BOTTOM NAV MOBILE */
/* ========================= */
.u-bottom-nav {
  position: fixed;
  bottom: 0; left: 0; right: 0;
  height: 70px;
  background: #fff;
  border-top: 1px solid #e4e9f0;
  display: flex;
  align-items: center;
  justify-content: space-around;
  gap: .5rem;
  z-index: 500;
  padding: 0 .5rem;
  padding-bottom: env(safe-area-inset-bottom);
  box-shadow: 0 -4px 20px rgba(0,0,0,.08);
}

/* Item */
.u-bn-item {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: .2rem;
  text-decoration: none;
  color: #8fa3b8;
  font-size: .72rem;
  font-weight: 600;
  padding: .4rem .6rem;
  border-radius: .6rem;
  transition: all .2s;
  min-width: 52px;
}

/* Icon */
.u-bn-item i {
  font-size: 1.4rem;
  transition: all .2s;
}

/* Hover & Active */
.u-bn-item:hover { color: #e8401c; }

.u-bn-item.active {
  color: #e8401c;
}

.u-bn-item.active i {
  transform: translateY(-3px) scale(1.1);
}

/* Tap effect (mobile feel) */
.u-bn-item:active {
  transform: scale(0.95);
}

/* Avatar */
.u-bn-avatar {
  width: 28px; height: 28px;
  border-radius: 50%;
  background: #e8401c;
  color: #fff;
  font-weight: 700;
  font-size: .75rem;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
  border: 2px solid #e4e9f0;
}

.u-bn-avatar img {
  width: 100%; height: 100%;
  object-fit: cover;
}

/* ========================= */
/* 📱 RESPONSIVE */
/* ========================= */

/* Desktop */
body {
  padding-bottom: 0;
}

/* Mobile */
@media (max-width: 768px) {
  body {
    padding-bottom: 75px;
  }
}

/* ❌ Hide di laptop */
@media (min-width: 768px) {
  .u-bottom-nav {
    display: none !important;
  }
}

/* ========================= */
/* 🔥 PROFIL POPUP */
/* ========================= */

.u-profil-popup {
  position: fixed;
  bottom: -100%;
  left: 0; right: 0;
  background: #fff;
  border-radius: 1.2rem 1.2rem 0 0;
  z-index: 600;
  padding: .75rem 1.2rem 2rem;
  transition: bottom .35s;
  box-shadow: 0 -8px 30px rgba(0,0,0,.15);
}

.u-profil-popup.open {
  bottom: 0;
}

.u-pp-backdrop {
  display: none;
  position: fixed;
  inset: 0;
  background: rgba(0,0,0,.4);
  z-index: 590;
}

.u-pp-backdrop.open {
  display: block;
}

</style>

<script>
function toggleProfilMenu(e) {
  e.preventDefault();
  document.getElementById('uProfilPopup').classList.toggle('open');
  document.getElementById('uPpBackdrop').classList.toggle('open');
}

function closeProfilMenu() {
  document.getElementById('uProfilPopup').classList.remove('open');
  document.getElementById('uPpBackdrop').classList.remove('open');
}
</script>

@endif
@endauth