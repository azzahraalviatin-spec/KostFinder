@extends('layouts.app')

@section('title', 'Panduan Penggunaan - KostFinder')

@section('styles')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Fraunces:ital,opsz,wght@0,9..144,700;1,9..144,400&display=swap" rel="stylesheet">
<style>
  :root {
    --kf-primary: #E8401C;
    --kf-primary-dark: #c03414;
    --kf-primary-light: #ff7a52;
    --kf-dark: #0f1923;
    --kf-muted: #6c768a;
    --kf-soft: #f6f8fc;
    --kf-border: #e7ebf3;
  }
  body { font-family: 'Plus Jakarta Sans', sans-serif; background: #fafbff; }

  /* ── HERO ── */
  .panduan-hero {
    background: linear-gradient(135deg, #0f1923 0%, #1e2f42 60%, #162538 100%);
    padding: 5rem 0 8rem;
    position: relative;
    overflow: hidden;
  }
  .panduan-hero::before {
    content: '';
    position: absolute; inset: 0;
    background:
      radial-gradient(ellipse 55% 70% at 85% 40%, rgba(232,64,28,.2), transparent 60%),
      radial-gradient(ellipse 40% 50% at 10% 80%, rgba(255,122,82,.1), transparent 55%);
    pointer-events: none;
  }
  .panduan-hero::after {
    content: '';
    position: absolute;
    bottom: -2px; left: 0; right: 0;
    height: 80px;
    background: #fafbff;
    clip-path: ellipse(55% 100% at 50% 100%);
  }
  .hero-badge {
    display: inline-flex; align-items: center; gap: .45rem;
    background: rgba(232,64,28,.15); border: 1px solid rgba(232,64,28,.35);
    color: #ff9977; font-size: .75rem; font-weight: 700;
    letter-spacing: .08em; text-transform: uppercase;
    padding: .32rem .9rem; border-radius: 999px; margin-bottom: 1.2rem;
  }
  .hero-badge span {
    width: 6px; height: 6px; border-radius: 50%; background: #ff7a52;
    animation: blink 2s infinite;
  }
  @keyframes blink { 0%,100%{opacity:1} 50%{opacity:.3} }
  .panduan-hero-title {
    font-family: 'Fraunces', serif; font-weight: 700;
    font-size: clamp(2.2rem, 4.5vw, 3.4rem); color: #fff;
    letter-spacing: -.025em; line-height: 1.1; margin-bottom: .8rem;
  }
  .panduan-hero-title .accent { color: #ff7a52; font-style: italic; }
  .panduan-hero-sub {
    color: #8a9ab8; font-size: .95rem; line-height: 1.75;
    max-width: 500px; margin-bottom: 2rem;
  }
  .hero-search {
    display: flex; align-items: center; gap: .5rem;
    background: rgba(255,255,255,.08); border: 1.5px solid rgba(255,255,255,.14);
    border-radius: 1rem; padding: .5rem .5rem .5rem 1rem;
    max-width: 460px; transition: border-color .2s, background .2s;
  }
  .hero-search:focus-within { border-color: rgba(232,64,28,.5); background: rgba(255,255,255,.12); }
  .hero-search input {
    flex: 1; background: transparent; border: 0; outline: none;
    color: #fff; font-size: .9rem; font-family: 'Plus Jakarta Sans', sans-serif;
  }
  .hero-search input::placeholder { color: rgba(255,255,255,.35); }
  .hero-search-btn {
    height: 36px; padding: 0 1rem; border-radius: .7rem;
    background: var(--kf-primary); color: #fff; border: 0;
    font-size: .82rem; font-weight: 700; cursor: pointer;
    transition: background .18s;
  }
  .hero-search-btn:hover { background: var(--kf-primary-dark); }
  .hero-stats { display: flex; gap: 2rem; margin-top: 2.5rem; flex-wrap: wrap; }
  .hero-stat-num {
    font-family: 'Fraunces', serif; font-size: 1.6rem;
    font-weight: 700; color: #fff; line-height: 1;
  }
  .hero-stat-num span { color: #ff7a52; }
  .hero-stat-label { font-size: .75rem; color: #8a9ab8; margin-top: .2rem; font-weight: 500; }

  /* floating cards */
  .hero-visual { position: relative; height: 320px; display: flex; align-items: center; justify-content: center; }
  .float-card {
    position: absolute; background: rgba(255,255,255,.08);
    border: 1px solid rgba(255,255,255,.12); border-radius: 1rem;
    padding: .9rem 1.1rem; backdrop-filter: blur(10px);
    display: flex; align-items: center; gap: .7rem;
    color: #fff; font-size: .82rem; font-weight: 600; white-space: nowrap;
    animation: floatY 4s ease-in-out infinite;
  }
  .float-card:nth-child(2){animation-delay:.8s}
  .float-card:nth-child(3){animation-delay:1.6s}
  .float-card:nth-child(4){animation-delay:2.4s}
  @keyframes floatY { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-8px)} }
  .float-card-icon { width:34px;height:34px;border-radius:.6rem;display:flex;align-items:center;justify-content:center;font-size:1rem; }
  .float-card:nth-child(1){top:20px;left:10%}
  .float-card:nth-child(2){top:80px;right:5%}
  .float-card:nth-child(3){bottom:80px;left:5%}
  .float-card:nth-child(4){bottom:20px;right:15%}

  /* ── CATEGORIES ── */
  .categories-section { padding: 3.5rem 0 2rem; }
  .cat-card {
    background: #fff; border: 1.5px solid var(--kf-border);
    border-radius: 1.1rem; padding: 1.5rem 1.3rem;
    cursor: pointer; transition: all .22s ease;
    text-align: center; height: 100%; position: relative; overflow: hidden;
  }
  .cat-card::before {
    content: ''; position: absolute; inset: 0;
    background: linear-gradient(135deg, var(--kf-primary), var(--kf-primary-dark));
    opacity: 0; transition: opacity .22s;
  }
  .cat-card:hover::before,.cat-card.active::before { opacity: 1; }
  .cat-card > * { position: relative; z-index: 1; }
  .cat-icon {
    width:52px;height:52px;border-radius:1rem;
    display:flex;align-items:center;justify-content:center;
    font-size:1.3rem;margin:0 auto .9rem;transition:all .22s;
  }
  .cat-card:nth-child(1) .cat-icon{background:#fff0eb;color:var(--kf-primary)}
  .cat-card:nth-child(2) .cat-icon{background:#eff8ff;color:#2563eb}
  .cat-card:nth-child(3) .cat-icon{background:#f0fdf4;color:#16a34a}
  .cat-card:nth-child(4) .cat-icon{background:#fdfbf0;color:#d97706}
  .cat-card:nth-child(5) .cat-icon{background:#fdf4ff;color:#9333ea}
  .cat-card:hover .cat-icon,.cat-card.active .cat-icon{background:rgba(255,255,255,.2)!important;color:#fff!important}
  .cat-title{font-weight:800;font-size:.88rem;color:var(--kf-dark);margin-bottom:.25rem;transition:color .22s}
  .cat-desc{font-size:.75rem;color:var(--kf-muted);margin:0;transition:color .22s}
  .cat-card:hover .cat-title,.cat-card.active .cat-title{color:#fff}
  .cat-card:hover .cat-desc,.cat-card.active .cat-desc{color:rgba(255,255,255,.75)}
  .cat-count{display:inline-flex;align-items:center;justify-content:center;width:20px;height:20px;border-radius:50%;background:var(--kf-soft);color:var(--kf-muted);font-size:.65rem;font-weight:700;margin-top:.6rem;transition:all .22s}
  .cat-card:hover .cat-count,.cat-card.active .cat-count{background:rgba(255,255,255,.2);color:#fff}

  /* ── CONTENT ── */
  .content-section { padding: 1rem 0 5rem; }
  .panduan-panel { display: none; }
  .panduan-panel.active { display: block; animation: fadeIn .3s ease; }
  @keyframes fadeIn { from{opacity:0;transform:translateY(8px)} to{opacity:1;transform:none} }

  .panel-header { display:flex;align-items:center;gap:1rem;margin-bottom:2rem;padding-bottom:1.2rem;border-bottom:1px solid var(--kf-border); }
  .panel-header-icon { width:48px;height:48px;border-radius:.9rem;display:flex;align-items:center;justify-content:center;font-size:1.2rem;color:#fff;flex-shrink:0;box-shadow:0 6px 16px rgba(232,64,28,.28);background:linear-gradient(135deg,var(--kf-primary),var(--kf-primary-dark)); }
  .panel-header-title { font-family:'Fraunces',serif;font-size:1.4rem;font-weight:700;color:var(--kf-dark);margin:0;letter-spacing:-.02em; }
  .panel-header-sub { font-size:.85rem;color:var(--kf-muted);margin:.2rem 0 0; }

  /* TIMELINE */
  .timeline { position:relative;padding-left:2.2rem; }
  .timeline::before { content:'';position:absolute;left:.85rem;top:1rem;bottom:1rem;width:2px;background:linear-gradient(to bottom,var(--kf-primary),#ffb3a0,transparent); }
  .timeline-item { position:relative;margin-bottom:1.5rem; }
  .timeline-item:last-child{margin-bottom:0}
  .timeline-dot { position:absolute;left:-2.2rem;top:.9rem;width:28px;height:28px;border-radius:50%;background:linear-gradient(135deg,var(--kf-primary),var(--kf-primary-dark));color:#fff;font-size:.7rem;font-weight:800;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 10px rgba(232,64,28,.3);z-index:1; }
  .timeline-card { background:#fff;border:1px solid var(--kf-border);border-radius:.9rem;padding:1.1rem 1.3rem;box-shadow:0 2px 10px rgba(10,20,50,.05);transition:all .2s; }
  .timeline-card:hover { border-color:#ffc4b5;box-shadow:0 6px 20px rgba(232,64,28,.1);transform:translateX(4px); }
  .timeline-card-title { font-weight:700;font-size:.9rem;color:var(--kf-dark);margin-bottom:.3rem; }
  .timeline-card-text { font-size:.85rem;color:var(--kf-muted);line-height:1.65;margin:0; }
  .timeline-card-text strong{color:var(--kf-dark)}

  /* BOXES */
  .tip-box { display:flex;align-items:flex-start;gap:.8rem;background:linear-gradient(135deg,#f0fdf4,#dcfce7);border:1px solid #bbf7d0;border-radius:.85rem;padding:.9rem 1.1rem;margin-top:1.2rem;font-size:.83rem;color:#166534;line-height:1.6; }
  .tip-box i{flex-shrink:0;margin-top:.15rem}
  .warning-box { display:flex;align-items:flex-start;gap:.8rem;background:linear-gradient(135deg,#fffbeb,#fef9c3);border:1px solid #fde68a;border-radius:.85rem;padding:.9rem 1.1rem;margin-top:1.2rem;font-size:.83rem;color:#92400e;line-height:1.6; }
  .warning-box i{flex-shrink:0;margin-top:.15rem}

  /* ACCORDION */
  .kf-accordion{display:flex;flex-direction:column;gap:.65rem}
  .kf-acc-item{background:#fff;border:1.5px solid var(--kf-border);border-radius:.9rem;overflow:hidden;transition:border-color .2s,box-shadow .2s}
  .kf-acc-item:hover{border-color:#ffc4b5;box-shadow:0 4px 16px rgba(232,64,28,.08)}
  .kf-acc-item.open{border-color:#ffb3a0;box-shadow:0 4px 20px rgba(232,64,28,.1)}
  .kf-acc-header{display:flex;align-items:center;gap:.9rem;padding:1rem 1.2rem;cursor:pointer;user-select:none}
  .kf-acc-icon{width:34px;height:34px;border-radius:.6rem;background:#fff0eb;color:var(--kf-primary);display:flex;align-items:center;justify-content:center;font-size:.9rem;flex-shrink:0;transition:all .2s}
  .kf-acc-item.open .kf-acc-icon{background:var(--kf-primary);color:#fff}
  .kf-acc-title{flex:1;font-weight:700;font-size:.9rem;color:var(--kf-dark);margin:0}
  .kf-acc-chevron{color:#c0c8d8;font-size:.75rem;transition:transform .25s;flex-shrink:0}
  .kf-acc-item.open .kf-acc-chevron{transform:rotate(180deg);color:var(--kf-primary)}
  .kf-acc-body{display:none;padding:0 1.2rem 1.2rem 3.5rem}
  .kf-acc-item.open .kf-acc-body{display:block}

  /* GUIDE CARDS */
  .guide-card{background:#fff;border:1.5px solid var(--kf-border);border-radius:1rem;padding:1.4rem;height:100%;transition:all .22s;position:relative;overflow:hidden}
  .guide-card::after{content:'';position:absolute;bottom:0;left:0;right:0;height:3px;background:linear-gradient(90deg,var(--kf-primary),var(--kf-primary-light));transform:scaleX(0);transform-origin:left;transition:transform .25s}
  .guide-card:hover{transform:translateY(-4px);box-shadow:0 14px 32px rgba(10,20,50,.1);border-color:#ffc4b5}
  .guide-card:hover::after{transform:scaleX(1)}
  .guide-card-num{font-family:'Fraunces',serif;font-size:2.5rem;font-weight:700;color:#f0f2f7;line-height:1;margin-bottom:.6rem}
  .guide-card-title{font-weight:800;font-size:.92rem;color:var(--kf-dark);margin-bottom:.4rem}
  .guide-card-text{font-size:.83rem;color:var(--kf-muted);line-height:1.65;margin:0}
  .guide-card-tag{display:inline-block;padding:.18rem .6rem;border-radius:999px;font-size:.68rem;font-weight:700;margin-bottom:.7rem}
  .tag-penghuni{background:#fff0eb;color:var(--kf-primary)}
  .tag-owner{background:#eff8ff;color:#2563eb}
  .tag-tips{background:#f0fdf4;color:#16a34a}

  /* SIDEBAR */
  .guide-sidebar{position:sticky;top:80px}
  .sidebar-box{background:#fff;border:1.5px solid var(--kf-border);border-radius:1rem;overflow:hidden;margin-bottom:1rem;box-shadow:0 4px 16px rgba(10,20,50,.05)}
  .sidebar-box-head{padding:.9rem 1.1rem;background:var(--kf-soft);font-size:.75rem;font-weight:800;color:var(--kf-dark);text-transform:uppercase;letter-spacing:.08em;border-bottom:1px solid var(--kf-border)}
  .sidebar-nav-item{display:flex;align-items:center;gap:.65rem;padding:.72rem 1.1rem;font-size:.84rem;font-weight:600;color:var(--kf-muted);cursor:pointer;transition:all .15s;border-bottom:1px solid #f4f6fb;text-decoration:none}
  .sidebar-nav-item:last-child{border-bottom:0}
  .sidebar-nav-item i{width:16px;text-align:center;font-size:.9rem}
  .sidebar-nav-item:hover{background:#fff8f5;color:var(--kf-primary)}
  .sidebar-nav-item.active{background:#fff3ef;color:var(--kf-primary);font-weight:700}
  .help-box{background:linear-gradient(135deg,#0f1923,#1e2f42);border-radius:1rem;padding:1.3rem;text-align:center}
  .help-box-emoji{font-size:2rem;margin-bottom:.6rem}
  .help-box-title{font-weight:800;font-size:.95rem;color:#fff;margin-bottom:.35rem}
  .help-box-sub{font-size:.78rem;color:#8a9ab8;line-height:1.55;margin-bottom:1rem}
  .btn-help{display:block;background:var(--kf-primary);color:#fff;font-weight:700;font-size:.82rem;padding:.62rem 1rem;border-radius:.65rem;text-decoration:none;box-shadow:0 4px 12px rgba(232,64,28,.35);transition:all .18s}
  .btn-help:hover{background:var(--kf-primary-dark);color:#fff;transform:translateY(-1px)}

  @media(max-width:991px){.guide-sidebar{position:static;margin-bottom:1.5rem}.hero-visual{display:none}.panduan-hero{padding-bottom:6rem}}
</style>
@endsection

@section('content')

{{-- HERO --}}
<section class="panduan-hero">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-6">
        <div class="hero-badge"><span></span> Pusat Bantuan KostFinder</div>
        <h1 class="panduan-hero-title">Ada yang Bisa<br>Kami <span class="accent">Bantu?</span></h1>
        <p class="panduan-hero-sub">Panduan lengkap menggunakan KostFinder — dari daftar akun, cari kost, booking, sampai jadi pemilik kost.</p>
        <div class="hero-search">
          <i class="bi bi-search" style="color:rgba(255,255,255,.35);font-size:.9rem;"></i>
          <input type="text" id="heroSearch" placeholder="Cari panduan, misal: cara booking..." oninput="liveSearch(this.value)">
          <button class="hero-search-btn" onclick="doSearch()">Cari</button>
        </div>
        <div class="hero-stats">
          <div class="hero-stat"><div class="hero-stat-num">5<span>+</span></div><div class="hero-stat-label">Kategori Panduan</div></div>
          <div class="hero-stat"><div class="hero-stat-num">15<span>+</span></div><div class="hero-stat-label">Artikel Bantuan</div></div>
          <div class="hero-stat"><div class="hero-stat-num">24<span>/7</span></div><div class="hero-stat-label">Siap Membantu</div></div>
        </div>
      </div>
      <div class="col-lg-6 d-none d-lg-block">
        <div class="hero-visual">
          <div class="float-card"><div class="float-card-icon" style="background:rgba(232,64,28,.2);color:#ff7a52;"><i class="bi bi-house-fill"></i></div>Kost ditemukan! 🎉</div>
          <div class="float-card"><div class="float-card-icon" style="background:rgba(74,222,128,.2);color:#4ade80;"><i class="bi bi-check-circle-fill"></i></div>Booking dikonfirmasi</div>
          <div class="float-card"><div class="float-card-icon" style="background:rgba(96,165,250,.2);color:#60a5fa;"><i class="bi bi-star-fill"></i></div>Rating 4.8/5 ⭐</div>
          <div class="float-card"><div class="float-card-icon" style="background:rgba(251,191,36,.2);color:#fbbf24;"><i class="bi bi-people-fill"></i></div>1.200+ penghuni aktif</div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- CATEGORIES --}}
<section class="categories-section">
  <div class="container">
    <div class="text-center mb-4">
      <p style="font-size:.8rem;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:var(--kf-primary);margin-bottom:.4rem;">Pilih Topik</p>
      <h2 style="font-family:'Fraunces',serif;font-weight:700;font-size:clamp(1.4rem,2.5vw,1.9rem);color:var(--kf-dark);letter-spacing:-.02em;margin:0;">Mau Belajar Tentang Apa?</h2>
    </div>
    <div class="row g-3 justify-content-center">
      <div class="col-6 col-md-4 col-lg"><div class="cat-card active" onclick="switchPanel('penghuni',this)"><div class="cat-icon"><i class="bi bi-person-fill"></i></div><div class="cat-title">Penghuni</div><div class="cat-desc">Daftar & kelola akun</div><div class="cat-count">3</div></div></div>
      <div class="col-6 col-md-4 col-lg"><div class="cat-card" onclick="switchPanel('cari',this)"><div class="cat-icon"><i class="bi bi-search"></i></div><div class="cat-title">Cari Kost</div><div class="cat-desc">Filter & favorit</div><div class="cat-count">3</div></div></div>
      <div class="col-6 col-md-4 col-lg"><div class="cat-card" onclick="switchPanel('booking',this)"><div class="cat-icon"><i class="bi bi-calendar-check-fill"></i></div><div class="cat-title">Booking</div><div class="cat-desc">Pesan & bayar kost</div><div class="cat-count">3</div></div></div>
      <div class="col-6 col-md-4 col-lg"><div class="cat-card" onclick="switchPanel('owner',this)"><div class="cat-icon"><i class="bi bi-building-fill"></i></div><div class="cat-title">Pemilik Kost</div><div class="cat-desc">Daftar & kelola kost</div><div class="cat-count">3</div></div></div>
      <div class="col-6 col-md-4 col-lg"><div class="cat-card" onclick="switchPanel('akun',this)"><div class="cat-icon"><i class="bi bi-shield-lock-fill"></i></div><div class="cat-title">Keamanan</div><div class="cat-desc">Password & privasi</div><div class="cat-count">2</div></div></div>
    </div>
  </div>
</section>

{{-- MAIN CONTENT --}}
<section class="content-section">
  <div class="container">
    <div class="row g-4">

      {{-- SIDEBAR --}}
      <div class="col-lg-3 order-lg-2">
        <div class="guide-sidebar">
          <div class="sidebar-box">
            <div class="sidebar-box-head">Navigasi Cepat</div>
            <div class="sidebar-nav-item active" onclick="switchPanel('penghuni')" id="snav-penghuni"><i class="bi bi-person"></i> Penghuni</div>
            <div class="sidebar-nav-item" onclick="switchPanel('cari')" id="snav-cari"><i class="bi bi-search"></i> Cari Kost</div>
            <div class="sidebar-nav-item" onclick="switchPanel('booking')" id="snav-booking"><i class="bi bi-calendar-check"></i> Booking Kost</div>
            <div class="sidebar-nav-item" onclick="switchPanel('owner')" id="snav-owner"><i class="bi bi-building"></i> Pemilik Kost</div>
            <div class="sidebar-nav-item" onclick="switchPanel('akun')" id="snav-akun"><i class="bi bi-shield-lock"></i> Keamanan Akun</div>
          </div>
          <div class="help-box">
            <div class="help-box-emoji">🤝</div>
            <div class="help-box-title">Masih Bingung?</div>
            <div class="help-box-sub">Tim kami siap membantu kamu menemukan jawaban yang tepat.</div>
            <a href="mailto:support@kostfinder.com" class="btn-help"><i class="bi bi-envelope me-1"></i> Hubungi Kami</a>
          </div>
        </div>
      </div>

      {{-- PANELS --}}
      <div class="col-lg-9 order-lg-1">

        {{-- PENGHUNI --}}
        <div class="panduan-panel active" id="panel-penghuni">
          <div class="panel-header">
            <div class="panel-header-icon"><i class="bi bi-person-fill"></i></div>
            <div><div class="panel-header-title">Panduan Penghuni</div><div class="panel-header-sub">Cara mendaftar, login, dan mengelola akun pencari kost</div></div>
          </div>
          <div class="row g-3 mb-4">
            <div class="col-md-4"><div class="guide-card"><div class="guide-card-num">01</div><div class="guide-card-tag tag-penghuni">Penghuni</div><div class="guide-card-title">Daftar Akun</div><div class="guide-card-text">Buat akun baru sebagai pencari kost dalam hitungan menit.</div></div></div>
            <div class="col-md-4"><div class="guide-card"><div class="guide-card-num">02</div><div class="guide-card-tag tag-penghuni">Penghuni</div><div class="guide-card-title">Login & Masuk</div><div class="guide-card-text">Masuk ke akun dengan email/password atau Google.</div></div></div>
            <div class="col-md-4"><div class="guide-card"><div class="guide-card-num">03</div><div class="guide-card-tag tag-penghuni">Penghuni</div><div class="guide-card-title">Update Profil</div><div class="guide-card-text">Lengkapi dan perbarui informasi profil kamu.</div></div></div>
          </div>
          <div class="kf-accordion">
            <div class="kf-acc-item open">
              <div class="kf-acc-header" onclick="toggleAcc(this)"><div class="kf-acc-icon"><i class="bi bi-person-plus-fill"></i></div><div class="kf-acc-title">Cara Daftar Akun sebagai Penghuni</div><i class="bi bi-chevron-down kf-acc-chevron"></i></div>
              <div class="kf-acc-body">
                <div class="timeline">
                  <div class="timeline-item"><div class="timeline-dot">1</div><div class="timeline-card"><div class="timeline-card-title">Klik tombol Daftar</div><p class="timeline-card-text">Di pojok kanan atas halaman, klik tombol <strong>"Daftar"</strong> berwarna merah.</p></div></div>
                  <div class="timeline-item"><div class="timeline-dot">2</div><div class="timeline-card"><div class="timeline-card-title">Pilih tipe akun</div><p class="timeline-card-text">Pilih <strong>"Daftar sebagai Pencari Kost"</strong> pada modal yang muncul.</p></div></div>
                  <div class="timeline-item"><div class="timeline-dot">3</div><div class="timeline-card"><div class="timeline-card-title">Isi formulir pendaftaran</div><p class="timeline-card-text">Masukkan <strong>nama lengkap, email aktif</strong>, dan <strong>password</strong> minimal 8 karakter.</p></div></div>
                  <div class="timeline-item"><div class="timeline-dot">4</div><div class="timeline-card"><div class="timeline-card-title">Akun siap digunakan!</div><p class="timeline-card-text">Klik <strong>"Daftar Sekarang"</strong> — kamu langsung bisa mulai mencari kost.</p></div></div>
                </div>
                <div class="tip-box"><i class="bi bi-lightning-charge-fill"></i><span>Cara lebih cepat: klik <strong>"Login dengan Google"</strong> untuk daftar/masuk otomatis tanpa mengisi formulir!</span></div>
              </div>
            </div>
            <div class="kf-acc-item">
              <div class="kf-acc-header" onclick="toggleAcc(this)"><div class="kf-acc-icon"><i class="bi bi-box-arrow-in-right"></i></div><div class="kf-acc-title">Cara Login ke Akun KostFinder</div><i class="bi bi-chevron-down kf-acc-chevron"></i></div>
              <div class="kf-acc-body">
                <div class="timeline">
                  <div class="timeline-item"><div class="timeline-dot">1</div><div class="timeline-card"><div class="timeline-card-title">Klik tombol Masuk</div><p class="timeline-card-text">Di navbar kanan atas, klik tombol <strong>"Masuk"</strong>.</p></div></div>
                  <div class="timeline-item"><div class="timeline-dot">2</div><div class="timeline-card"><div class="timeline-card-title">Masukkan email & password</div><p class="timeline-card-text">Isi <strong>email</strong> dan <strong>password</strong> yang sudah didaftarkan, lalu klik <strong>"Login"</strong>.</p></div></div>
                  <div class="timeline-item"><div class="timeline-dot">3</div><div class="timeline-card"><div class="timeline-card-title">Atau login dengan Google</div><p class="timeline-card-text">Klik <strong>"Login dengan Google"</strong> untuk masuk lebih cepat.</p></div></div>
                </div>
                <div class="tip-box"><i class="bi bi-lightbulb-fill"></i><span>Lupa password? Klik <strong>"Lupa password?"</strong> di halaman login untuk reset via email.</span></div>
              </div>
            </div>
            <div class="kf-acc-item">
              <div class="kf-acc-header" onclick="toggleAcc(this)"><div class="kf-acc-icon"><i class="bi bi-pencil-fill"></i></div><div class="kf-acc-title">Cara Update Profil Penghuni</div><i class="bi bi-chevron-down kf-acc-chevron"></i></div>
              <div class="kf-acc-body">
                <div class="timeline">
                  <div class="timeline-item"><div class="timeline-dot">1</div><div class="timeline-card"><div class="timeline-card-title">Buka Profil Saya</div><p class="timeline-card-text">Klik nama kamu → pilih <strong>"Profil Saya"</strong>.</p></div></div>
                  <div class="timeline-item"><div class="timeline-dot">2</div><div class="timeline-card"><div class="timeline-card-title">Klik Edit Profil</div><p class="timeline-card-text">Ubah nama, foto, atau nomor HP sesuai kebutuhan.</p></div></div>
                  <div class="timeline-item"><div class="timeline-dot">3</div><div class="timeline-card"><div class="timeline-card-title">Simpan perubahan</div><p class="timeline-card-text">Klik <strong>"Simpan Perubahan"</strong> — profil langsung terupdate.</p></div></div>
                </div>
              </div>
            </div>
          </div>
        </div>

        {{-- CARI --}}
        <div class="panduan-panel" id="panel-cari">
          <div class="panel-header">
            <div class="panel-header-icon"><i class="bi bi-search"></i></div>
            <div><div class="panel-header-title">Cara Mencari Kost</div><div class="panel-header-sub">Temukan kost terbaik dengan fitur pencarian dan filter KostFinder</div></div>
          </div>
          <div class="row g-3 mb-4">
            <div class="col-md-4"><div class="guide-card"><div class="guide-card-num">01</div><div class="guide-card-tag tag-tips">Tips</div><div class="guide-card-title">Cari by Kota</div><div class="guide-card-text">Ketik nama kota atau klik kota populer di halaman utama.</div></div></div>
            <div class="col-md-4"><div class="guide-card"><div class="guide-card-num">02</div><div class="guide-card-tag tag-tips">Tips</div><div class="guide-card-title">Gunakan Filter</div><div class="guide-card-text">Filter kost berdasarkan harga, fasilitas, dan tipe penghuni.</div></div></div>
            <div class="col-md-4"><div class="guide-card"><div class="guide-card-num">03</div><div class="guide-card-tag tag-tips">Tips</div><div class="guide-card-title">Simpan Favorit</div><div class="guide-card-text">Klik ikon hati untuk menyimpan kost yang kamu suka.</div></div></div>
          </div>
          <div class="kf-accordion">
            <div class="kf-acc-item open">
              <div class="kf-acc-header" onclick="toggleAcc(this)"><div class="kf-acc-icon"><i class="bi bi-map-fill"></i></div><div class="kf-acc-title">Cara Mencari Kost di KostFinder</div><i class="bi bi-chevron-down kf-acc-chevron"></i></div>
              <div class="kf-acc-body">
                <div class="timeline">
                  <div class="timeline-item"><div class="timeline-dot">1</div><div class="timeline-card"><div class="timeline-card-title">Gunakan kolom pencarian</div><p class="timeline-card-text">Ketik <strong>nama kota, kampus, atau nama jalan</strong> lalu klik <strong>"Cari Kost"</strong>.</p></div></div>
                  <div class="timeline-item"><div class="timeline-dot">2</div><div class="timeline-card"><div class="timeline-card-title">Atau pilih kota populer</div><p class="timeline-card-text">Klik kota seperti <strong>Surabaya, Malang, Sidoarjo</strong> di halaman utama.</p></div></div>
                  <div class="timeline-item"><div class="timeline-dot">3</div><div class="timeline-card"><div class="timeline-card-title">Lihat hasil pencarian</div><p class="timeline-card-text">Daftar kost tampil beserta <strong>harga, fasilitas, dan lokasi</strong>.</p></div></div>
                </div>
                <div class="tip-box"><i class="bi bi-sliders"></i><span>Gunakan tombol <strong>Filter</strong> untuk menyaring kost berdasarkan fasilitas, tipe penghuni, dan harga.</span></div>
              </div>
            </div>
            <div class="kf-acc-item">
              <div class="kf-acc-header" onclick="toggleAcc(this)"><div class="kf-acc-icon"><i class="bi bi-heart-fill"></i></div><div class="kf-acc-title">Cara Menyimpan Kost ke Favorit</div><i class="bi bi-chevron-down kf-acc-chevron"></i></div>
              <div class="kf-acc-body">
                <div class="timeline">
                  <div class="timeline-item"><div class="timeline-dot">1</div><div class="timeline-card"><div class="timeline-card-title">Pastikan sudah login</div><p class="timeline-card-text">Fitur favorit hanya tersedia untuk pengguna yang sudah <strong>login</strong>.</p></div></div>
                  <div class="timeline-item"><div class="timeline-dot">2</div><div class="timeline-card"><div class="timeline-card-title">Klik ikon hati ♡</div><p class="timeline-card-text">Di kartu kost, klik ikon <strong>♡</strong> di pojok kanan atas gambar untuk menyimpan.</p></div></div>
                  <div class="timeline-item"><div class="timeline-dot">3</div><div class="timeline-card"><div class="timeline-card-title">Akses daftar favorit</div><p class="timeline-card-text">Buka menu <strong>Favorit</strong> di profil untuk melihat kost tersimpan.</p></div></div>
                </div>
              </div>
            </div>
            <div class="kf-acc-item">
              <div class="kf-acc-header" onclick="toggleAcc(this)"><div class="kf-acc-icon"><i class="bi bi-eye-fill"></i></div><div class="kf-acc-title">Apa yang Harus Dilakukan Setelah Menemukan Kost?</div><i class="bi bi-chevron-down kf-acc-chevron"></i></div>
              <div class="kf-acc-body">
                <div class="timeline">
                  <div class="timeline-item"><div class="timeline-dot">1</div><div class="timeline-card"><div class="timeline-card-title">Lihat detail kost</div><p class="timeline-card-text">Klik kost yang diminati untuk melihat <strong>foto, fasilitas, harga, dan lokasi</strong>.</p></div></div>
                  <div class="timeline-item"><div class="timeline-dot">2</div><div class="timeline-card"><div class="timeline-card-title">Bandingkan beberapa kost</div><p class="timeline-card-text">Simpan ke <strong>Favorit</strong> untuk membandingkan sebelum memutuskan.</p></div></div>
                  <div class="timeline-item"><div class="timeline-dot">3</div><div class="timeline-card"><div class="timeline-card-title">Lanjut booking</div><p class="timeline-card-text">Sudah yakin? Klik <strong>"Booking Sekarang"</strong> untuk melanjutkan pemesanan.</p></div></div>
                </div>
              </div>
            </div>
          </div>
        </div>

        {{-- BOOKING --}}
        <div class="panduan-panel" id="panel-booking">
          <div class="panel-header">
            <div class="panel-header-icon"><i class="bi bi-calendar-check-fill"></i></div>
            <div><div class="panel-header-title">Cara Booking Kost</div><div class="panel-header-sub">Panduan lengkap pemesanan kost dari pilih kamar hingga pembayaran</div></div>
          </div>
          <div class="row g-3 mb-4">
            <div class="col-md-4"><div class="guide-card"><div class="guide-card-num">01</div><div class="guide-card-tag tag-penghuni">Booking</div><div class="guide-card-title">Pilih Kamar</div><div class="guide-card-text">Pilih tipe kamar yang tersedia dan sesuai budget.</div></div></div>
            <div class="col-md-4"><div class="guide-card"><div class="guide-card-num">02</div><div class="guide-card-tag tag-penghuni">Booking</div><div class="guide-card-title">Tunggu Konfirmasi</div><div class="guide-card-text">Pemilik kost akan membalas dalam waktu singkat.</div></div></div>
            <div class="col-md-4"><div class="guide-card"><div class="guide-card-num">03</div><div class="guide-card-tag tag-penghuni">Booking</div><div class="guide-card-title">Lakukan Pembayaran</div><div class="guide-card-text">Bayar sesuai instruksi setelah booking disetujui.</div></div></div>
          </div>
          <div class="kf-accordion">
            <div class="kf-acc-item open">
              <div class="kf-acc-header" onclick="toggleAcc(this)"><div class="kf-acc-icon"><i class="bi bi-calendar-plus-fill"></i></div><div class="kf-acc-title">Cara Booking Kost di KostFinder</div><i class="bi bi-chevron-down kf-acc-chevron"></i></div>
              <div class="kf-acc-body">
                <div class="timeline">
                  <div class="timeline-item"><div class="timeline-dot">1</div><div class="timeline-card"><div class="timeline-card-title">Buka halaman detail kost</div><p class="timeline-card-text">Pilih kost yang diinginkan lalu pilih <strong>tipe kamar</strong> yang tersedia.</p></div></div>
                  <div class="timeline-item"><div class="timeline-dot">2</div><div class="timeline-card"><div class="timeline-card-title">Klik Booking Sekarang</div><p class="timeline-card-text">Isi <strong>tanggal masuk</strong> dan catatan tambahan, lalu konfirmasi.</p></div></div>
                  <div class="timeline-item"><div class="timeline-dot">3</div><div class="timeline-card"><div class="timeline-card-title">Tunggu konfirmasi pemilik</div><p class="timeline-card-text">Pantau status di menu <strong>"Pesanan"</strong> di profil kamu.</p></div></div>
                  <div class="timeline-item"><div class="timeline-dot">4</div><div class="timeline-card"><div class="timeline-card-title">Lakukan pembayaran</div><p class="timeline-card-text">Setelah disetujui, ikuti instruksi pembayaran yang diberikan.</p></div></div>
                </div>
                <div class="tip-box"><i class="bi bi-bell-fill"></i><span>Status booking bisa dipantau kapan saja di menu <strong>"Pesanan"</strong> di profil kamu.</span></div>
              </div>
            </div>
            <div class="kf-acc-item">
              <div class="kf-acc-header" onclick="toggleAcc(this)"><div class="kf-acc-icon"><i class="bi bi-credit-card-fill"></i></div><div class="kf-acc-title">Cara Melakukan Pembayaran</div><i class="bi bi-chevron-down kf-acc-chevron"></i></div>
              <div class="kf-acc-body">
                <div class="timeline">
                  <div class="timeline-item"><div class="timeline-dot">1</div><div class="timeline-card"><div class="timeline-card-title">Buka menu Pesanan</div><p class="timeline-card-text">Setelah booking disetujui, buka <strong>"Pesanan"</strong> dan klik booking tersebut.</p></div></div>
                  <div class="timeline-item"><div class="timeline-dot">2</div><div class="timeline-card"><div class="timeline-card-title">Klik Bayar Sekarang</div><p class="timeline-card-text">Ikuti instruksi pembayaran yang tersedia.</p></div></div>
                  <div class="timeline-item"><div class="timeline-dot">3</div><div class="timeline-card"><div class="timeline-card-title">Upload bukti transfer</div><p class="timeline-card-text">Upload <strong>bukti pembayaran</strong> dan tunggu konfirmasi dari pemilik.</p></div></div>
                </div>
              </div>
            </div>
            <div class="kf-acc-item">
              <div class="kf-acc-header" onclick="toggleAcc(this)"><div class="kf-acc-icon"><i class="bi bi-x-circle-fill"></i></div><div class="kf-acc-title">Cara Membatalkan Booking</div><i class="bi bi-chevron-down kf-acc-chevron"></i></div>
              <div class="kf-acc-body">
                <div class="timeline">
                  <div class="timeline-item"><div class="timeline-dot">1</div><div class="timeline-card"><div class="timeline-card-title">Buka menu Pesanan</div><p class="timeline-card-text">Masuk ke <strong>"Pesanan"</strong> dan pilih booking yang ingin dibatalkan.</p></div></div>
                  <div class="timeline-item"><div class="timeline-dot">2</div><div class="timeline-card"><div class="timeline-card-title">Klik Batalkan & konfirmasi</div><p class="timeline-card-text">Klik <strong>"Batalkan"</strong> dan konfirmasi pembatalan.</p></div></div>
                </div>
                <div class="warning-box"><i class="bi bi-exclamation-triangle-fill"></i><span>Pembatalan hanya bisa dilakukan saat status masih <strong>"Menunggu"</strong> atau <strong>"Disetujui"</strong> sebelum pembayaran.</span></div>
              </div>
            </div>
          </div>
        </div>

        {{-- OWNER --}}
        <div class="panduan-panel" id="panel-owner">
          <div class="panel-header">
            <div class="panel-header-icon"><i class="bi bi-building-fill"></i></div>
            <div><div class="panel-header-title">Panduan Pemilik Kost</div><div class="panel-header-sub">Daftarkan properti dan mulai terima penghuni via KostFinder</div></div>
          </div>
          <div class="row g-3 mb-4">
            <div class="col-md-4"><div class="guide-card"><div class="guide-card-num">01</div><div class="guide-card-tag tag-owner">Owner</div><div class="guide-card-title">Daftar Owner</div><div class="guide-card-text">Buat akun pemilik kost dan verifikasi identitas.</div></div></div>
            <div class="col-md-4"><div class="guide-card"><div class="guide-card-num">02</div><div class="guide-card-tag tag-owner">Owner</div><div class="guide-card-title">Pasang Iklan Kost</div><div class="guide-card-text">Upload foto dan isi detail kost agar tampil di pencarian.</div></div></div>
            <div class="col-md-4"><div class="guide-card"><div class="guide-card-num">03</div><div class="guide-card-tag tag-owner">Owner</div><div class="guide-card-title">Kelola Booking</div><div class="guide-card-text">Terima, tolak, dan pantau semua pesanan masuk.</div></div></div>
          </div>
          <div class="kf-accordion">
            <div class="kf-acc-item open">
              <div class="kf-acc-header" onclick="toggleAcc(this)"><div class="kf-acc-icon"><i class="bi bi-person-badge-fill"></i></div><div class="kf-acc-title">Cara Daftar sebagai Pemilik Kost</div><i class="bi bi-chevron-down kf-acc-chevron"></i></div>
              <div class="kf-acc-body">
                <div class="timeline">
                  <div class="timeline-item"><div class="timeline-dot">1</div><div class="timeline-card"><div class="timeline-card-title">Klik Daftar → Pemilik Kost</div><p class="timeline-card-text">Di navbar, klik <strong>"Daftar"</strong> lalu pilih <strong>"Daftar sebagai Pemilik Kost"</strong>.</p></div></div>
                  <div class="timeline-item"><div class="timeline-dot">2</div><div class="timeline-card"><div class="timeline-card-title">Isi formulir pendaftaran</div><p class="timeline-card-text">Masukkan nama, email, nomor HP, dan password akun owner.</p></div></div>
                  <div class="timeline-item"><div class="timeline-dot">3</div><div class="timeline-card"><div class="timeline-card-title">Lengkapi verifikasi identitas</div><p class="timeline-card-text">Upload dokumen identitas agar kost bisa tampil di platform.</p></div></div>
                  <div class="timeline-item"><div class="timeline-dot">4</div><div class="timeline-card"><div class="timeline-card-title">Tunggu persetujuan admin</div><p class="timeline-card-text">Tim KostFinder memverifikasi akun dalam <strong>1x24 jam</strong>.</p></div></div>
                </div>
                <div class="tip-box"><i class="bi bi-shield-check-fill"></i><span>Kost hanya tampil di pencarian setelah identitas pemilik <strong>diverifikasi</strong> oleh admin KostFinder.</span></div>
              </div>
            </div>
            <div class="kf-acc-item">
              <div class="kf-acc-header" onclick="toggleAcc(this)"><div class="kf-acc-icon"><i class="bi bi-house-add-fill"></i></div><div class="kf-acc-title">Cara Mendaftarkan dan Memasang Iklan Kost</div><i class="bi bi-chevron-down kf-acc-chevron"></i></div>
              <div class="kf-acc-body">
                <div class="timeline">
                  <div class="timeline-item"><div class="timeline-dot">1</div><div class="timeline-card"><div class="timeline-card-title">Masuk ke Dashboard Owner</div><p class="timeline-card-text">Login ke akun pemilik lalu buka <strong>Dashboard Owner</strong>.</p></div></div>
                  <div class="timeline-item"><div class="timeline-dot">2</div><div class="timeline-card"><div class="timeline-card-title">Klik Tambah Kost</div><p class="timeline-card-text">Isi nama, alamat, kota, tipe kost, dan deskripsi properti.</p></div></div>
                  <div class="timeline-item"><div class="timeline-dot">3</div><div class="timeline-card"><div class="timeline-card-title">Upload foto kost</div><p class="timeline-card-text">Tambahkan <strong>foto kost yang menarik</strong> untuk meningkatkan minat calon penghuni.</p></div></div>
                  <div class="timeline-item"><div class="timeline-dot">4</div><div class="timeline-card"><div class="timeline-card-title">Tambahkan detail kamar</div><p class="timeline-card-text">Isi <strong>tipe kamar, harga per bulan, fasilitas</strong>, dan ketersediaannya.</p></div></div>
                </div>
              </div>
            </div>
            <div class="kf-acc-item">
              <div class="kf-acc-header" onclick="toggleAcc(this)"><div class="kf-acc-icon"><i class="bi bi-check2-all"></i></div><div class="kf-acc-title">Cara Konfirmasi dan Kelola Booking Masuk</div><i class="bi bi-chevron-down kf-acc-chevron"></i></div>
              <div class="kf-acc-body">
                <div class="timeline">
                  <div class="timeline-item"><div class="timeline-dot">1</div><div class="timeline-card"><div class="timeline-card-title">Cek notifikasi booking</div><p class="timeline-card-text">Buka <strong>Dashboard Owner → Booking</strong> saat ada pemesanan masuk.</p></div></div>
                  <div class="timeline-item"><div class="timeline-dot">2</div><div class="timeline-card"><div class="timeline-card-title">Terima atau Tolak</div><p class="timeline-card-text">Lihat detail calon penghuni, klik <strong>"Terima"</strong> atau <strong>"Tolak"</strong>.</p></div></div>
                  <div class="timeline-item"><div class="timeline-dot">3</div><div class="timeline-card"><div class="timeline-card-title">Konfirmasi selesai</div><p class="timeline-card-text">Setelah penghuni membayar, klik <strong>"Selesai"</strong> untuk menandai lunas.</p></div></div>
                </div>
              </div>
            </div>
          </div>
        </div>

        {{-- AKUN --}}
        <div class="panduan-panel" id="panel-akun">
          <div class="panel-header">
            <div class="panel-header-icon"><i class="bi bi-shield-lock-fill"></i></div>
            <div><div class="panel-header-title">Keamanan Akun</div><div class="panel-header-sub">Panduan mengelola password dan keamanan akun KostFinder kamu</div></div>
          </div>
          <div class="kf-accordion">
            <div class="kf-acc-item open">
              <div class="kf-acc-header" onclick="toggleAcc(this)"><div class="kf-acc-icon"><i class="bi bi-key-fill"></i></div><div class="kf-acc-title">Cara Ganti Password</div><i class="bi bi-chevron-down kf-acc-chevron"></i></div>
              <div class="kf-acc-body">
                <div class="timeline">
                  <div class="timeline-item"><div class="timeline-dot">1</div><div class="timeline-card"><div class="timeline-card-title">Buka Profil → Keamanan</div><p class="timeline-card-text">Login lalu buka halaman <strong>Profil</strong> dan klik tab <strong>"Keamanan"</strong>.</p></div></div>
                  <div class="timeline-item"><div class="timeline-dot">2</div><div class="timeline-card"><div class="timeline-card-title">Isi form ganti password</div><p class="timeline-card-text">Masukkan <strong>password lama</strong> dan <strong>password baru</strong> minimal 8 karakter.</p></div></div>
                  <div class="timeline-item"><div class="timeline-dot">3</div><div class="timeline-card"><div class="timeline-card-title">Simpan perubahan</div><p class="timeline-card-text">Klik <strong>"Simpan"</strong> — password baru langsung aktif.</p></div></div>
                </div>
              </div>
            </div>
            <div class="kf-acc-item">
              <div class="kf-acc-header" onclick="toggleAcc(this)"><div class="kf-acc-icon"><i class="bi bi-envelope-fill"></i></div><div class="kf-acc-title">Cara Reset Password (Lupa Password)</div><i class="bi bi-chevron-down kf-acc-chevron"></i></div>
              <div class="kf-acc-body">
                <div class="timeline">
                  <div class="timeline-item"><div class="timeline-dot">1</div><div class="timeline-card"><div class="timeline-card-title">Klik "Lupa password?"</div><p class="timeline-card-text">Di halaman login, klik link <strong>"Lupa password?"</strong>.</p></div></div>
                  <div class="timeline-item"><div class="timeline-dot">2</div><div class="timeline-card"><div class="timeline-card-title">Masukkan email terdaftar</div><p class="timeline-card-text">Isi <strong>email</strong> terdaftar lalu klik <strong>"Kirim Link Reset"</strong>.</p></div></div>
                  <div class="timeline-item"><div class="timeline-dot">3</div><div class="timeline-card"><div class="timeline-card-title">Cek email & reset password</div><p class="timeline-card-text">Klik link di email, lalu masukkan <strong>password baru</strong>.</p></div></div>
                </div>
                <div class="tip-box"><i class="bi bi-clock-fill"></i><span>Link reset password berlaku selama <strong>60 menit</strong>. Jika expired, ulangi dari awal.</span></div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>

@endsection

@section('scripts')
<script>
const panels = ['penghuni','cari','booking','owner','akun'];

function switchPanel(id, catEl = null) {
  panels.forEach(p => {
    document.getElementById('panel-'+p)?.classList.toggle('active', p===id);
    document.getElementById('snav-'+p)?.classList.toggle('active', p===id);
  });
  if (!catEl) {
    document.querySelectorAll('.cat-card').forEach((el,i) => el.classList.toggle('active', panels[i]===id));
  } else {
    document.querySelectorAll('.cat-card').forEach(el => el.classList.remove('active'));
    catEl.classList.add('active');
  }
  document.querySelector('.content-section')?.scrollIntoView({ behavior:'smooth', block:'start' });
}

function toggleAcc(header) {
  header.closest('.kf-acc-item').classList.toggle('open');
}

function liveSearch(val) {
  if (!val.trim()) return;
  const q = val.toLowerCase();
  const map = {
    'daftar':'penghuni','registrasi':'penghuni','login':'penghuni','masuk':'penghuni','profil':'penghuni',
    'cari':'cari','filter':'cari','favorit':'cari','kota':'cari',
    'booking':'booking','pesan':'booking','bayar':'booking','pembayaran':'booking','batal':'booking',
    'owner':'owner','pemilik':'owner','properti':'owner','pasang':'owner','iklan':'owner',
    'password':'akun','sandi':'akun','reset':'akun','keamanan':'akun',
  };
  for (const [key, panel] of Object.entries(map)) {
    if (q.includes(key)) { switchPanel(panel); break; }
  }
}
function doSearch() { liveSearch(document.getElementById('heroSearch').value); }
</script>
@endsection