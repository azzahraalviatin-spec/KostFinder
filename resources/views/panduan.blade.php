@extends('layouts.app')

@section('title', 'Panduan Penggunaan - KostFinder')

@section('styles')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&family=Playfair+Display:ital,wght@0,700;0,800;1,600&display=swap" rel="stylesheet">
<style>
:root {
  --or-50:  #fff8f3;
  --or-100: #ffeedd;
  --or-200: #ffd8b8;
  --or-300: #ffbb87;
  --or-400: #ff9a52;
  --or-500: #f4793a;
  --or-600: #e05a20;
  --or-dark: #2c1a0e;
  --or-text: #4a3728;
  --or-muted:#9b7f6e;
  --or-border:#f0ddd0;
  --or-card: #fff;
  --or-bg:   #fdf8f4;
  --shadow-sm: 0 2px 8px rgba(240,120,50,.08);
  --shadow-md: 0 6px 24px rgba(240,120,50,.12);
  --shadow-lg: 0 16px 48px rgba(240,120,50,.16);
}

*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
body{font-family:'Plus Jakarta Sans',sans-serif;background:var(--or-bg);color:var(--or-text);line-height:1.6}

/* ─── HERO ─── */
.hero{
  position:relative;
  overflow:hidden;
  padding:80px 0 120px;

  background:
    linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.5)),
    url("{{ asset('images/panduan.jpg') }}");

  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
}

.hero::before{
  content:'';position:absolute;inset:0;pointer-events:none;
  background:
    radial-gradient(ellipse 70% 80% at 90% -10%,rgba(255,255,255,.12) 0%,transparent 60%),
    radial-gradient(ellipse 50% 60% at -10% 80%,rgba(255,255,255,.08) 0%,transparent 55%);
}
.hero-wave{
  position:absolute;bottom:-2px;left:0;width:100%;height:80px;
  background:var(--or-bg);
  clip-path:ellipse(56% 100% at 50% 100%);
}
.hero-pill{
  display:inline-flex;align-items:center;gap:6px;
  background:rgba(255,255,255,.2);border:1.5px solid rgba(255,255,255,.4);
  color:#fff;font-size:.72rem;font-weight:800;
  letter-spacing:.1em;text-transform:uppercase;
  padding:5px 14px;border-radius:999px;margin-bottom:20px;
}
.hero-pill span{
  width:6px;height:6px;border-radius:50%;
  background:#fff;
  animation:pulse 2s ease-in-out infinite;
}
@keyframes pulse{0%,100%{opacity:1;transform:scale(1)}50%{opacity:.4;transform:scale(.7)}}

.hero-title{
  font-family:'Playfair Display',serif;
  font-size:clamp(2.4rem,5vw,3.8rem);
  font-weight:800;line-height:1.08;
  color:#fff;letter-spacing:-.03em;
  margin-bottom:16px;
}
.hero-title em{
  font-style:italic;font-weight:600;
  color:rgba(255,255,255,.85);
}
.hero-sub{
  font-size:.95rem;color:rgba(255,255,255,.85);
  line-height:1.8;max-width:480px;margin-bottom:32px;font-weight:400;
}

/* search bar */
.search-wrap{
  display:flex;align-items:center;gap:8px;
  background:#fff;border:2px solid rgba(255,255,255,.6);
  border-radius:16px;padding:6px 6px 6px 18px;
  max-width:480px;
  box-shadow:0 8px 32px rgba(0,0,0,.15);
  transition:border-color .2s,box-shadow .2s;
}
.search-wrap:focus-within{border-color:var(--or-400);box-shadow:0 0 0 4px rgba(244,121,58,.1),var(--shadow-md)}
/* ─── SEARCH BAR IMPROVEMENT ─── */
.search-wrap i {
    color: #333333;      /* Ganti jadi hitam pekat agar terlihat jelas */
    font-size: 1.1rem;   /* Sedikit diperbesar ukurannya */
}

.search-wrap input::placeholder {
    color: #757575;      /* Ganti jadi abu-abu tua agar terbaca */
    opacity: 1;          /* Pastikan opacity penuh agar tidak pudar */
    font-weight: 500;
}

.search-wrap input {
    flex: 1;
    background: transparent;
    border: 0;
    outline: none;
    font-family: inherit;
    font-size: .95rem;
    color:rgb(224, 101, 19);      /* Warna teks saat mengetik */
    padding-left: 10px;  /* Kasih jarak sedikit dari ikon */
    
}
.search-btn:hover{transform:translateY(-2px);box-shadow:0 6px 20px rgba(244,121,58,.45)}

/* ─── STATS HERO — Agar Teks Putih & Jelas ─── */
.hero-stats {
    display: flex;
    gap: 32px;
    margin-top: 36px;
    flex-wrap: wrap;
}

.stat-num {
    font-family: 'Playfair Display', serif;
    font-size: 2.2rem; /* Sedikit diperbesar agar gagah */
    font-weight: 800;
    color: #ffffff;    /* GANTI KE PUTIH */
    line-height: 1;
}

.stat-num sup {
    font-size: 1.2rem;
    color: rgba(255, 255, 255, 0.8); /* Putih agak transparan */
    margin-left: 2px;
}

.stat-label {
    font-size: .75rem;
    font-weight: 700;
    color: rgba(255, 255, 255, 0.9); /* Putih agar kontras */
    text-transform: uppercase;
    letter-spacing: .1em;
    margin-top: 6px;
}

.stat-divider {
    width: 1px;
    background: rgba(255, 255, 255, 0.3); /* Garis pemisah putih tipis */
    align-self: stretch;
}

/* floating cards */
.hero-visual{position:relative;height:340px}
.fc{
  position:absolute;
  background:#fff;border:1.5px solid var(--or-border);
  border-radius:16px;padding:12px 16px;
  display:flex;align-items:center;gap:10px;
  font-size:.82rem;font-weight:600;color:var(--or-text);
  white-space:nowrap;box-shadow:var(--shadow-md);
  animation:floatY 5s ease-in-out infinite;
}
.fc:nth-child(1){top:30px;left:0;animation-delay:0s}
.fc:nth-child(2){top:100px;right:0;animation-delay:1s}
.fc:nth-child(3){bottom:100px;left:5%;animation-delay:2s}
.fc:nth-child(4){bottom:25px;right:10%;animation-delay:3s}
@keyframes floatY{0%,100%{transform:translateY(0)}50%{transform:translateY(-10px)}}
.fc-icon{
  width:36px;height:36px;border-radius:10px;
  display:flex;align-items:center;justify-content:center;font-size:1rem;flex-shrink:0;
}
.fc:nth-child(1) .fc-icon{background:#fff3e8;color:var(--or-500)}
.fc:nth-child(2) .fc-icon{background:#e8f8ee;color:#27ae60}
.fc:nth-child(3) .fc-icon{background:#e8f0fe;color:#3a6df0}
.fc:nth-child(4) .fc-icon{background:#fff8e1;color:#f39c12}
.fc-sub{font-size:.7rem;color:var(--or-muted);font-weight:400;margin-top:1px}

/* big decoration circle */
.hero-deco{
  position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);
  width:260px;height:260px;border-radius:50%;
  background:radial-gradient(circle,rgba(255,255,255,.08) 0%,rgba(255,255,255,.02) 60%,transparent 100%);
  border:2px dashed rgba(255,255,255,.2);
}

/* ─── CATEGORIES ─── */
.section-kecil{padding:48px 0 16px}
.label-tag{
  display:inline-block;
  background:var(--or-100);border:1.5px solid var(--or-200);
  color:var(--or-600);font-size:.7rem;font-weight:800;
  text-transform:uppercase;letter-spacing:.1em;
  padding:4px 12px;border-radius:999px;margin-bottom:10px;
}
.section-title{
  font-family:'Playfair Display',serif;
  font-size:clamp(1.5rem,3vw,2.1rem);
  font-weight:800;color:var(--or-dark);letter-spacing:-.025em;
}

.cat-grid{display:grid;grid-template-columns:repeat(5,1fr);gap:12px}
@media(max-width:991px){.cat-grid{grid-template-columns:repeat(3,1fr)}}
@media(max-width:575px){.cat-grid{grid-template-columns:repeat(2,1fr)}}

.cat-card{
  background:#fff;border:2px solid var(--or-border);
  border-radius:16px;padding:20px 14px;
  text-align:center;cursor:pointer;
  transition:all .22s cubic-bezier(.4,0,.2,1);
  position:relative;overflow:hidden;
}
.cat-card::before{
  content:'';position:absolute;inset:0;
  background:linear-gradient(135deg,var(--or-500),var(--or-400));
  opacity:0;transition:opacity .22s;
}
.cat-card>*{position:relative;z-index:1}
.cat-card:hover,.cat-card.active{
  border-color:var(--or-400);
  transform:translateY(-4px);
  box-shadow:var(--shadow-lg);
}
.cat-card:hover::before,.cat-card.active::before{opacity:1}

.cat-ico{
  width:50px;height:50px;border-radius:14px;
  display:flex;align-items:center;justify-content:center;
  font-size:1.2rem;margin:0 auto 10px;
  transition:all .22s;
}
.cat-card:nth-child(1) .cat-ico{background:#fff3e8;color:var(--or-500)}
.cat-card:nth-child(2) .cat-ico{background:#e3f2fd;color:#1565c0}
.cat-card:nth-child(3) .cat-ico{background:#e8f5e9;color:#2e7d32}
.cat-card:nth-child(4) .cat-ico{background:#fce4ec;color:#c62828}
.cat-card:nth-child(5) .cat-ico{background:#f3e5f5;color:#6a1b9a}
.cat-card:hover .cat-ico,.cat-card.active .cat-ico{
  background:rgba(255,255,255,.22)!important;
  color:#fff!important;
}
.cat-name{font-size:.85rem;font-weight:800;color:var(--or-dark);transition:color .22s;margin-bottom:3px}
.cat-desc{font-size:.72rem;color:var(--or-muted);transition:color .22s;margin:0}
.cat-badge{
  display:inline-flex;align-items:center;justify-content:center;
  width:22px;height:22px;border-radius:50%;
  background:var(--or-100);color:var(--or-600);
  font-size:.65rem;font-weight:800;margin-top:8px;
  transition:all .22s;
}
.cat-card:hover .cat-name,.cat-card.active .cat-name,
.cat-card:hover .cat-desc,.cat-card.active .cat-desc{color:rgba(255,255,255,.95)}
.cat-card:hover .cat-badge,.cat-card.active .cat-badge{background:rgba(255,255,255,.25);color:#fff}

/* ─── MAIN ─── */
.main-section{padding:8px 0 80px}

/* sidebar */
.sidebar{position:sticky;top:80px}
.coming-soon-msg{
  display:none;margin-top:10px;padding:9px 12px;
  background:rgba(244,121,58,.1);border:1.5px solid rgba(244,121,58,.3);
  border-radius:10px;font-size:.8rem;font-weight:700;
  color:var(--or-600);text-align:center;
  animation:fadeUp .3s ease;
}
.coming-soon-msg i{margin-right:5px}
.help-card{
  background:linear-gradient(160deg,#fff9f5,#ffeedd);
  border:2px solid var(--or-200);border-radius:18px;
  padding:24px 20px;text-align:center;overflow:hidden;position:relative;
}
.help-card::before{
  content:'';position:absolute;top:-30px;right:-30px;
  width:100px;height:100px;border-radius:50%;
  background:rgba(244,121,58,.1);
}
.help-emoji{font-size:2.2rem;margin-bottom:10px;display:block}
.help-title{font-family:'Playfair Display',serif;font-size:1.05rem;font-weight:800;color:var(--or-dark);margin-bottom:6px}
.help-sub{font-size:.78rem;color:var(--or-muted);line-height:1.6;margin-bottom:16px}
.btn-contact{
  display:flex;align-items:center;justify-content:center;gap:7px;
  background:linear-gradient(135deg,var(--or-500),var(--or-600));
  color:#fff;font-family:inherit;font-size:.82rem;font-weight:700;
  padding:11px 18px;border-radius:12px;
  text-decoration:none;border:0;cursor:pointer;
  box-shadow:0 4px 14px rgba(244,121,58,.35);
  transition:all .18s;
}
.btn-contact:hover{transform:translateY(-2px);box-shadow:0 6px 20px rgba(244,121,58,.45);color:#fff}



/* ─── PANEL ─── */
.panel{display:none;animation:fadeUp .3s ease}
.panel.active{display:block}
@keyframes fadeUp{from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:none}}

.panel-head{
  display:flex;align-items:center;gap:14px;
  padding:20px 24px;
  background:linear-gradient(to right,#fff,var(--or-50));
  border:2px solid var(--or-border);border-radius:18px;
  margin-bottom:24px;
}
.panel-ico{
  width:50px;height:50px;flex-shrink:0;border-radius:14px;
  display:flex;align-items:center;justify-content:center;
  font-size:1.2rem;color:#fff;
  background:linear-gradient(135deg,var(--or-500),var(--or-600));
  box-shadow:0 4px 12px rgba(244,121,58,.3);
}
.panel-title{font-family:'Playfair Display',serif;font-size:1.3rem;font-weight:800;color:var(--or-dark);margin:0;letter-spacing:-.02em}
.panel-subtitle{font-size:.82rem;color:var(--or-muted);margin:3px 0 0}

/* mini guide cards */
.mini-cards{display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:24px}
@media(max-width:575px){.mini-cards{grid-template-columns:1fr}}
.mini-card{
  background:#fff;border:2px solid var(--or-border);
  border-radius:14px;padding:18px;
  transition:all .22s;position:relative;overflow:hidden;
}
.mini-card::after{
  content:'';position:absolute;bottom:0;left:0;right:0;height:3px;
  background:linear-gradient(to right,var(--or-400),var(--or-500));
  transform:scaleX(0);transform-origin:left;transition:transform .25s;
}
.mini-card:hover{transform:translateY(-4px);box-shadow:var(--shadow-md);border-color:var(--or-300)}
.mini-card:hover::after{transform:scaleX(1)}
.mini-num{
  font-family:'Playfair Display',serif;font-size:2.2rem;font-weight:800;
  color:var(--or-100);line-height:1;margin-bottom:6px;
}
.mini-tag{
  display:inline-block;padding:2px 8px;border-radius:999px;
  font-size:.65rem;font-weight:800;letter-spacing:.04em;margin-bottom:6px;
}
.tag-orange{background:var(--or-100);color:var(--or-600)}
.tag-blue{background:#e3f2fd;color:#1565c0}
.tag-green{background:#e8f5e9;color:#2e7d32}
.mini-title{font-size:.85rem;font-weight:800;color:var(--or-dark);margin-bottom:4px}
.mini-desc{font-size:.78rem;color:var(--or-muted);line-height:1.6;margin:0}

/* ─── ACCORDION ─── */
.acc-list{display:flex;flex-direction:column;gap:10px}
.acc-item{
  background:#fff;border:2px solid var(--or-border);
  border-radius:14px;overflow:hidden;
  transition:border-color .2s,box-shadow .2s;
}
.acc-item:hover{border-color:var(--or-300)}
.acc-item.open{border-color:var(--or-400);box-shadow:var(--shadow-md)}
.acc-header{
  display:flex;align-items:center;gap:12px;
  padding:14px 18px;cursor:pointer;user-select:none;
  background:linear-gradient(to right,#fff,var(--or-50));
}
.acc-ico{
  width:36px;height:36px;border-radius:10px;flex-shrink:0;
  background:var(--or-100);color:var(--or-500);
  display:flex;align-items:center;justify-content:center;
  font-size:.9rem;transition:all .2s;
}
.acc-item.open .acc-ico{background:linear-gradient(135deg,var(--or-500),var(--or-600));color:#fff;box-shadow:0 3px 10px rgba(244,121,58,.3)}
.acc-title{flex:1;font-size:.88rem;font-weight:700;color:var(--or-dark);margin:0}
.acc-arrow{
  width:28px;height:28px;border-radius:50%;
  background:var(--or-100);color:var(--or-400);
  display:flex;align-items:center;justify-content:center;
  font-size:.7rem;flex-shrink:0;
  transition:all .25s;
}
.acc-item.open .acc-arrow{background:var(--or-500);color:#fff;transform:rotate(180deg)}
.acc-body{display:none;padding:0 18px 20px}
.acc-item.open .acc-body{display:block}

/* ─── TIMELINE ─── */
.timeline{position:relative;padding-left:30px;margin-top:4px}
.timeline::before{
  content:'';position:absolute;left:11px;top:14px;bottom:8px;width:2px;
  background:linear-gradient(to bottom,var(--or-400),var(--or-100));
  border-radius:2px;
}
.tl-item{position:relative;margin-bottom:12px}
.tl-item:last-child{margin-bottom:0}
.tl-dot{
  position:absolute;left:-30px;top:10px;
  width:24px;height:24px;border-radius:50%;
  background:linear-gradient(135deg,var(--or-500),var(--or-400));
  color:#fff;font-size:.65rem;font-weight:800;
  display:flex;align-items:center;justify-content:center;
  box-shadow:0 2px 8px rgba(244,121,58,.3);z-index:1;
}
.tl-card{
  background:var(--or-50);border:1.5px solid var(--or-border);
  border-radius:12px;padding:12px 14px;
  transition:all .18s;
}
.tl-card:hover{border-color:var(--or-300);transform:translateX(4px);background:#fff}
.tl-title{font-size:.84rem;font-weight:700;color:var(--or-dark);margin-bottom:3px}
.tl-text{font-size:.8rem;color:var(--or-muted);line-height:1.65;margin:0}
.tl-text strong{color:var(--or-600);font-weight:700}

/* tip / warning */
.tip-box{
  display:flex;align-items:flex-start;gap:10px;
  background:linear-gradient(to right,var(--or-50),#fff);
  border:1.5px solid var(--or-200);border-radius:12px;
  padding:12px 14px;margin-top:14px;
  font-size:.8rem;color:var(--or-600);line-height:1.65;
}
.tip-box>i{flex-shrink:0;margin-top:1px;color:var(--or-500);font-size:.95rem}
.warn-box{
  display:flex;align-items:flex-start;gap:10px;
  background:linear-gradient(to right,#fff8e1,#fff);
  border:1.5px solid #ffe082;border-radius:12px;
  padding:12px 14px;margin-top:14px;
  font-size:.8rem;color:#e65100;line-height:1.65;
}
.warn-box>i{flex-shrink:0;margin-top:1px;color:#fb8c00;font-size:.95rem}

/* ─── RESPONSIVE ─── */
@media(max-width:991px){
  .sidebar{position:static;margin-bottom:24px}
  .hero-visual{display:none}
  .hero{padding-bottom:100px}
  .cat-grid{grid-template-columns:repeat(3,1fr)}
}
@media(max-width:575px){
  .cat-grid{grid-template-columns:repeat(2,1fr)}
  .mini-cards{grid-template-columns:1fr}
  .hero{padding:60px 0 90px}
}
</style>
@endsection

@section('content')

{{-- ───────── HERO ───────── --}}
<section class="hero">
  <div class="container">
    <div class="row align-items-center">

      <div class="col-lg-6 mb-5 mb-lg-0">
        <div class="hero-pill"><span></span>Pusat Bantuan KostFinder</div>
        <h1 class="hero-title">Ada yang Bisa<br>Kami <em>Bantu?</em></h1>
        <p class="hero-sub">Panduan lengkap KostFinder — daftar akun, cari kost, booking, sampai jadi pemilik kost yang sukses.</p>

        <div class="search-wrap">
          <i class="bi bi-search"></i>
          <input type="text" id="heroSearch" placeholder="Cari panduan, misal: cara booking…" oninput="liveSearch(this.value)">
          <button class="search-btn" onclick="doSearch()"><i class="bi bi-arrow-right me-1"></i>Cari</button>
        </div>

        <div class="hero-stats">
          <div>
            <div class="stat-num">5<sup>+</sup></div>
            <div class="stat-label">Topik Panduan</div>
          </div>
          <div class="stat-divider"></div>
          <div>
            <div class="stat-num">15<sup>+</sup></div>
            <div class="stat-label">Artikel Bantuan</div>
          </div>
          <div class="stat-divider"></div>
          <div>
            <div class="stat-num">24<sup>/7</sup></div>
            <div class="stat-label">Siap Membantu</div>
          </div>
        </div>
      </div>

      <div class="col-lg-6 d-none d-lg-flex justify-content-center">
        <div class="hero-visual w-100">
          <div class="hero-deco"></div>
          <div class="fc">
            <div class="fc-icon"><i class="bi bi-house-fill"></i></div>
            <div><div>Kost ditemukan! 🎉</div><div class="fc-sub">Surabaya Timur</div></div>
          </div>
          <div class="fc">
            <div class="fc-icon"><i class="bi bi-check-circle-fill"></i></div>
            <div><div>Booking dikonfirmasi</div><div class="fc-sub">Masuk 1 Jan 2025</div></div>
          </div>
          <div class="fc">
            <div class="fc-icon"><i class="bi bi-star-fill"></i></div>
            <div><div>Rating 4.8 / 5 ⭐</div><div class="fc-sub">dari 120 ulasan</div></div>
          </div>
          <div class="fc">
            <div class="fc-icon"><i class="bi bi-people-fill"></i></div>
            <div><div>1.200+ penghuni aktif</div><div class="fc-sub">Bergabung sekarang</div></div>
          </div>
        </div>
      </div>

    </div>
  </div>
  <div class="hero-wave"></div>
</section>

{{-- ───────── KATEGORI ───────── --}}
<section class="section-kecil">
  <div class="container">
    <div class="text-center mb-4">
      <span class="label-tag">Pilih Topik</span>
      <h2 class="section-title">Mau Belajar Tentang Apa?</h2>
    </div>
    <div class="cat-grid">
      <div class="cat-card active" onclick="switchPanel('penghuni',this)">
        <div class="cat-ico"><i class="bi bi-person-fill"></i></div>
        <div class="cat-name">Penghuni</div>
        <div class="cat-desc">Daftar & kelola akun</div>
        <div class="cat-badge">3</div>
      </div>
      <div class="cat-card" onclick="switchPanel('cari',this)">
        <div class="cat-ico"><i class="bi bi-search"></i></div>
        <div class="cat-name">Cari Kost</div>
        <div class="cat-desc">Filter & favorit</div>
        <div class="cat-badge">3</div>
      </div>
      <div class="cat-card" onclick="switchPanel('booking',this)">
        <div class="cat-ico"><i class="bi bi-calendar-check-fill"></i></div>
        <div class="cat-name">Booking</div>
        <div class="cat-desc">Pesan & bayar kost</div>
        <div class="cat-badge">3</div>
      </div>
      <div class="cat-card" onclick="switchPanel('owner',this)">
        <div class="cat-ico"><i class="bi bi-building-fill"></i></div>
        <div class="cat-name">Pemilik Kost</div>
        <div class="cat-desc">Daftar & kelola kost</div>
        <div class="cat-badge">3</div>
      </div>
      <div class="cat-card" onclick="switchPanel('akun',this)">
        <div class="cat-ico"><i class="bi bi-shield-lock-fill"></i></div>
        <div class="cat-name">Keamanan</div>
        <div class="cat-desc">Password & privasi</div>
        <div class="cat-badge">2</div>
      </div>
    </div>
  </div>
</section>

{{-- ───────── MAIN CONTENT ───────── --}}
<section class="main-section">
  <div class="container">
    <div class="row g-4">

      {{-- SIDEBAR --}}
      <div class="col-lg-3 order-lg-2">
        <div class="sidebar">
          <div class="help-card">
            <span class="help-emoji">🤝</span>
            <div class="help-title">Masih Bingung?</div>
            <p class="help-sub">Tim kami siap membantu kamu menemukan jawaban yang tepat kapan saja.</p>
            <button class="btn-contact" onclick="showComingSoon()">
              <i class="bi bi-envelope-fill"></i> Hubungi Kami
            </button>
            <div class="coming-soon-msg" id="comingSoonMsg">
              <i class="bi bi-clock-history"></i> Fitur ini akan segera hadir! 🚀
            </div>
          </div>

        </div>
      </div>

      {{-- PANELS --}}
      <div class="col-lg-9 order-lg-1">

        {{-- ── PANEL: PENGHUNI ── --}}
        <div class="panel active" id="panel-penghuni">
          <div class="panel-head">
            <div class="panel-ico"><i class="bi bi-person-fill"></i></div>
            <div>
              <div class="panel-title">Panduan Penghuni</div>
              <div class="panel-subtitle">Cara mendaftar, login, dan mengelola akun pencari kost</div>
            </div>
          </div>

          <div class="mini-cards">
            <div class="mini-card"><div class="mini-num">01</div><div class="mini-tag tag-orange">Penghuni</div><div class="mini-title">Daftar Akun</div><div class="mini-desc">Buat akun baru sebagai pencari kost dalam hitungan menit.</div></div>
            <div class="mini-card"><div class="mini-num">02</div><div class="mini-tag tag-orange">Penghuni</div><div class="mini-title">Login & Masuk</div><div class="mini-desc">Masuk ke akun dengan email/password atau Google.</div></div>
            <div class="mini-card"><div class="mini-num">03</div><div class="mini-tag tag-orange">Penghuni</div><div class="mini-title">Update Profil</div><div class="mini-desc">Lengkapi dan perbarui informasi profil kamu.</div></div>
          </div>

          <div class="acc-list">
            <div class="acc-item open">
              <div class="acc-header" onclick="toggleAcc(this)">
                <div class="acc-ico"><i class="bi bi-person-plus-fill"></i></div>
                <div class="acc-title">Cara Daftar Akun sebagai Penghuni</div>
                <div class="acc-arrow"><i class="bi bi-chevron-down"></i></div>
              </div>
              <div class="acc-body">
                <div class="timeline">
                  <div class="tl-item"><div class="tl-dot">1</div><div class="tl-card"><div class="tl-title">Klik tombol Daftar</div><p class="tl-text">Di pojok kanan atas halaman, klik tombol <strong>"Daftar"</strong> berwarna oranye.</p></div></div>
                  <div class="tl-item"><div class="tl-dot">2</div><div class="tl-card"><div class="tl-title">Pilih tipe akun</div><p class="tl-text">Pilih <strong>"Daftar sebagai Pencari Kost"</strong> pada modal yang muncul.</p></div></div>
                  <div class="tl-item"><div class="tl-dot">3</div><div class="tl-card"><div class="tl-title">Isi formulir pendaftaran</div><p class="tl-text">Masukkan <strong>nama lengkap, email aktif</strong>, dan <strong>password</strong> minimal 8 karakter.</p></div></div>
                  <div class="tl-item"><div class="tl-dot">4</div><div class="tl-card"><div class="tl-title">Akun siap digunakan!</div><p class="tl-text">Klik <strong>"Daftar Sekarang"</strong> — kamu langsung bisa mulai mencari kost.</p></div></div>
                </div>
                <div class="tip-box"><i class="bi bi-lightning-charge-fill"></i><span>Cara lebih cepat: klik <strong>"Login dengan Google"</strong> untuk daftar/masuk otomatis tanpa mengisi formulir!</span></div>
              </div>
            </div>

            <div class="acc-item">
              <div class="acc-header" onclick="toggleAcc(this)">
                <div class="acc-ico"><i class="bi bi-box-arrow-in-right"></i></div>
                <div class="acc-title">Cara Login ke Akun KostFinder</div>
                <div class="acc-arrow"><i class="bi bi-chevron-down"></i></div>
              </div>
              <div class="acc-body">
                <div class="timeline">
                  <div class="tl-item"><div class="tl-dot">1</div><div class="tl-card"><div class="tl-title">Klik tombol Masuk</div><p class="tl-text">Di navbar kanan atas, klik tombol <strong>"Masuk"</strong>.</p></div></div>
                  <div class="tl-item"><div class="tl-dot">2</div><div class="tl-card"><div class="tl-title">Masukkan email & password</div><p class="tl-text">Isi <strong>email</strong> dan <strong>password</strong> yang sudah didaftarkan, lalu klik <strong>"Login"</strong>.</p></div></div>
                  <div class="tl-item"><div class="tl-dot">3</div><div class="tl-card"><div class="tl-title">Atau login dengan Google</div><p class="tl-text">Klik <strong>"Login dengan Google"</strong> untuk masuk lebih cepat.</p></div></div>
                </div>
                <div class="tip-box"><i class="bi bi-lightbulb-fill"></i><span>Lupa password? Klik <strong>"Lupa password?"</strong> di halaman login untuk reset via email.</span></div>
              </div>
            </div>

            <div class="acc-item">
              <div class="acc-header" onclick="toggleAcc(this)">
                <div class="acc-ico"><i class="bi bi-pencil-fill"></i></div>
                <div class="acc-title">Cara Update Profil Penghuni</div>
                <div class="acc-arrow"><i class="bi bi-chevron-down"></i></div>
              </div>
              <div class="acc-body">
                <div class="timeline">
                  <div class="tl-item"><div class="tl-dot">1</div><div class="tl-card"><div class="tl-title">Buka Profil Saya</div><p class="tl-text">Klik nama kamu → pilih <strong>"Profil Saya"</strong>.</p></div></div>
                  <div class="tl-item"><div class="tl-dot">2</div><div class="tl-card"><div class="tl-title">Klik Edit Profil</div><p class="tl-text">Ubah nama, foto, atau nomor HP sesuai kebutuhan.</p></div></div>
                  <div class="tl-item"><div class="tl-dot">3</div><div class="tl-card"><div class="tl-title">Simpan perubahan</div><p class="tl-text">Klik <strong>"Simpan Perubahan"</strong> — profil langsung terupdate.</p></div></div>
                </div>
              </div>
            </div>
          </div>
        </div>

        {{-- ── PANEL: CARI ── --}}
        <div class="panel" id="panel-cari">
          <div class="panel-head">
            <div class="panel-ico"><i class="bi bi-search"></i></div>
            <div>
              <div class="panel-title">Cara Mencari Kost</div>
              <div class="panel-subtitle">Temukan kost terbaik dengan fitur pencarian dan filter KostFinder</div>
            </div>
          </div>

          <div class="mini-cards">
            <div class="mini-card"><div class="mini-num">01</div><div class="mini-tag tag-green">Tips</div><div class="mini-title">Cari by Kota</div><div class="mini-desc">Ketik nama kota atau klik kota populer di halaman utama.</div></div>
            <div class="mini-card"><div class="mini-num">02</div><div class="mini-tag tag-green">Tips</div><div class="mini-title">Gunakan Filter</div><div class="mini-desc">Filter berdasarkan harga, fasilitas, dan tipe penghuni.</div></div>
            <div class="mini-card"><div class="mini-num">03</div><div class="mini-tag tag-green">Tips</div><div class="mini-title">Simpan Favorit</div><div class="mini-desc">Klik ikon hati untuk menyimpan kost yang kamu suka.</div></div>
          </div>

          <div class="acc-list">
            <div class="acc-item open">
              <div class="acc-header" onclick="toggleAcc(this)">
                <div class="acc-ico"><i class="bi bi-map-fill"></i></div>
                <div class="acc-title">Cara Mencari Kost di KostFinder</div>
                <div class="acc-arrow"><i class="bi bi-chevron-down"></i></div>
              </div>
              <div class="acc-body">
                <div class="timeline">
                  <div class="tl-item"><div class="tl-dot">1</div><div class="tl-card"><div class="tl-title">Gunakan kolom pencarian</div><p class="tl-text">Ketik <strong>nama kota, kampus, atau nama jalan</strong> lalu klik <strong>"Cari Kost"</strong>.</p></div></div>
                  <div class="tl-item"><div class="tl-dot">2</div><div class="tl-card"><div class="tl-title">Atau pilih kota populer</div><p class="tl-text">Klik kota seperti <strong>Surabaya, Malang, Sidoarjo</strong> di halaman utama.</p></div></div>
                  <div class="tl-item"><div class="tl-dot">3</div><div class="tl-card"><div class="tl-title">Lihat hasil pencarian</div><p class="tl-text">Daftar kost tampil beserta <strong>harga, fasilitas, dan lokasi</strong>.</p></div></div>
                </div>
                <div class="tip-box"><i class="bi bi-sliders"></i><span>Gunakan tombol <strong>Filter</strong> untuk menyaring kost berdasarkan fasilitas, tipe penghuni, dan harga.</span></div>
              </div>
            </div>

            <div class="acc-item">
              <div class="acc-header" onclick="toggleAcc(this)">
                <div class="acc-ico"><i class="bi bi-heart-fill"></i></div>
                <div class="acc-title">Cara Menyimpan Kost ke Favorit</div>
                <div class="acc-arrow"><i class="bi bi-chevron-down"></i></div>
              </div>
              <div class="acc-body">
                <div class="timeline">
                  <div class="tl-item"><div class="tl-dot">1</div><div class="tl-card"><div class="tl-title">Pastikan sudah login</div><p class="tl-text">Fitur favorit hanya tersedia untuk pengguna yang sudah <strong>login</strong>.</p></div></div>
                  <div class="tl-item"><div class="tl-dot">2</div><div class="tl-card"><div class="tl-title">Klik ikon hati ♡</div><p class="tl-text">Di kartu kost, klik ikon <strong>♡</strong> di pojok kanan atas gambar untuk menyimpan.</p></div></div>
                  <div class="tl-item"><div class="tl-dot">3</div><div class="tl-card"><div class="tl-title">Akses daftar favorit</div><p class="tl-text">Buka menu <strong>Favorit</strong> di profil untuk melihat kost tersimpan.</p></div></div>
                </div>
              </div>
            </div>

            <div class="acc-item">
              <div class="acc-header" onclick="toggleAcc(this)">
                <div class="acc-ico"><i class="bi bi-eye-fill"></i></div>
                <div class="acc-title">Apa yang Harus Dilakukan Setelah Menemukan Kost?</div>
                <div class="acc-arrow"><i class="bi bi-chevron-down"></i></div>
              </div>
              <div class="acc-body">
                <div class="timeline">
                  <div class="tl-item"><div class="tl-dot">1</div><div class="tl-card"><div class="tl-title">Lihat detail kost</div><p class="tl-text">Klik kost yang diminati untuk melihat <strong>foto, fasilitas, harga, dan lokasi</strong>.</p></div></div>
                  <div class="tl-item"><div class="tl-dot">2</div><div class="tl-card"><div class="tl-title">Bandingkan beberapa kost</div><p class="tl-text">Simpan ke <strong>Favorit</strong> untuk membandingkan sebelum memutuskan.</p></div></div>
                  <div class="tl-item"><div class="tl-dot">3</div><div class="tl-card"><div class="tl-title">Lanjut booking</div><p class="tl-text">Sudah yakin? Klik <strong>"Booking Sekarang"</strong> untuk melanjutkan pemesanan.</p></div></div>
                </div>
              </div>
            </div>
          </div>
        </div>

        {{-- ── PANEL: BOOKING ── --}}
        <div class="panel" id="panel-booking">
          <div class="panel-head">
            <div class="panel-ico"><i class="bi bi-calendar-check-fill"></i></div>
            <div>
              <div class="panel-title">Cara Booking Kost</div>
              <div class="panel-subtitle">Panduan lengkap pemesanan dari pilih kamar hingga pembayaran</div>
            </div>
          </div>

          <div class="mini-cards">
            <div class="mini-card"><div class="mini-num">01</div><div class="mini-tag tag-orange">Booking</div><div class="mini-title">Pilih Kamar</div><div class="mini-desc">Pilih tipe kamar yang tersedia dan sesuai budget.</div></div>
            <div class="mini-card"><div class="mini-num">02</div><div class="mini-tag tag-orange">Booking</div><div class="mini-title">Tunggu Konfirmasi</div><div class="mini-desc">Pemilik kost akan membalas dalam waktu singkat.</div></div>
            <div class="mini-card"><div class="mini-num">03</div><div class="mini-tag tag-orange">Booking</div><div class="mini-title">Lakukan Pembayaran</div><div class="mini-desc">Bayar sesuai instruksi setelah booking disetujui.</div></div>
          </div>

          <div class="acc-list">
            <div class="acc-item open">
              <div class="acc-header" onclick="toggleAcc(this)">
                <div class="acc-ico"><i class="bi bi-calendar-plus-fill"></i></div>
                <div class="acc-title">Cara Booking Kost di KostFinder</div>
                <div class="acc-arrow"><i class="bi bi-chevron-down"></i></div>
              </div>
              <div class="acc-body">
                <div class="timeline">
                  <div class="tl-item"><div class="tl-dot">1</div><div class="tl-card"><div class="tl-title">Buka halaman detail kost</div><p class="tl-text">Pilih kost yang diinginkan lalu pilih <strong>tipe kamar</strong> yang tersedia.</p></div></div>
                  <div class="tl-item"><div class="tl-dot">2</div><div class="tl-card"><div class="tl-title">Klik Booking Sekarang</div><p class="tl-text">Isi <strong>tanggal masuk</strong> dan catatan tambahan, lalu konfirmasi.</p></div></div>
                  <div class="tl-item"><div class="tl-dot">3</div><div class="tl-card"><div class="tl-title">Tunggu konfirmasi pemilik</div><p class="tl-text">Pantau status di menu <strong>"Pesanan"</strong> di profil kamu.</p></div></div>
                  <div class="tl-item"><div class="tl-dot">4</div><div class="tl-card"><div class="tl-title">Lakukan pembayaran</div><p class="tl-text">Setelah disetujui, ikuti instruksi pembayaran yang diberikan.</p></div></div>
                </div>
                <div class="tip-box"><i class="bi bi-bell-fill"></i><span>Status booking bisa dipantau kapan saja di menu <strong>"Pesanan"</strong> di profil kamu.</span></div>
              </div>
            </div>

            <div class="acc-item">
              <div class="acc-header" onclick="toggleAcc(this)">
                <div class="acc-ico"><i class="bi bi-credit-card-fill"></i></div>
                <div class="acc-title">Cara Melakukan Pembayaran</div>
                <div class="acc-arrow"><i class="bi bi-chevron-down"></i></div>
              </div>
              <div class="acc-body">
                <div class="timeline">
                  <div class="tl-item"><div class="tl-dot">1</div><div class="tl-card"><div class="tl-title">Buka menu Pesanan</div><p class="tl-text">Setelah booking disetujui, buka <strong>"Pesanan"</strong> dan klik booking tersebut.</p></div></div>
                  <div class="tl-item"><div class="tl-dot">2</div><div class="tl-card"><div class="tl-title">Klik Bayar Sekarang</div><p class="tl-text">Ikuti instruksi pembayaran yang tersedia.</p></div></div>
                  <div class="tl-item"><div class="tl-dot">3</div><div class="tl-card"><div class="tl-title">Upload bukti transfer</div><p class="tl-text">Upload <strong>bukti pembayaran</strong> dan tunggu konfirmasi dari pemilik.</p></div></div>
                </div>
              </div>
            </div>

            <div class="acc-item">
              <div class="acc-header" onclick="toggleAcc(this)">
                <div class="acc-ico"><i class="bi bi-x-circle-fill"></i></div>
                <div class="acc-title">Cara Membatalkan Booking</div>
                <div class="acc-arrow"><i class="bi bi-chevron-down"></i></div>
              </div>
              <div class="acc-body">
                <div class="timeline">
                  <div class="tl-item"><div class="tl-dot">1</div><div class="tl-card"><div class="tl-title">Buka menu Pesanan</div><p class="tl-text">Masuk ke <strong>"Pesanan"</strong> dan pilih booking yang ingin dibatalkan.</p></div></div>
                  <div class="tl-item"><div class="tl-dot">2</div><div class="tl-card"><div class="tl-title">Klik Batalkan & konfirmasi</div><p class="tl-text">Klik <strong>"Batalkan"</strong> dan konfirmasi pembatalan.</p></div></div>
                </div>
                <div class="warn-box"><i class="bi bi-exclamation-triangle-fill"></i><span>Pembatalan hanya bisa dilakukan saat status masih <strong>"Menunggu"</strong> atau <strong>"Disetujui"</strong> sebelum pembayaran.</span></div>
              </div>
            </div>
          </div>
        </div>

        {{-- ── PANEL: OWNER ── --}}
        <div class="panel" id="panel-owner">
          <div class="panel-head">
            <div class="panel-ico"><i class="bi bi-building-fill"></i></div>
            <div>
              <div class="panel-title">Panduan Pemilik Kost</div>
              <div class="panel-subtitle">Daftarkan properti dan mulai terima penghuni via KostFinder</div>
            </div>
          </div>

          <div class="mini-cards">
            <div class="mini-card"><div class="mini-num">01</div><div class="mini-tag tag-blue">Owner</div><div class="mini-title">Daftar Owner</div><div class="mini-desc">Buat akun pemilik kost dan verifikasi identitas.</div></div>
            <div class="mini-card"><div class="mini-num">02</div><div class="mini-tag tag-blue">Owner</div><div class="mini-title">Pasang Iklan Kost</div><div class="mini-desc">Upload foto dan isi detail kost agar tampil di pencarian.</div></div>
            <div class="mini-card"><div class="mini-num">03</div><div class="mini-tag tag-blue">Owner</div><div class="mini-title">Kelola Booking</div><div class="mini-desc">Terima, tolak, dan pantau semua pesanan masuk.</div></div>
          </div>

          <div class="acc-list">
            <div class="acc-item open">
              <div class="acc-header" onclick="toggleAcc(this)">
                <div class="acc-ico"><i class="bi bi-person-badge-fill"></i></div>
                <div class="acc-title">Cara Daftar sebagai Pemilik Kost</div>
                <div class="acc-arrow"><i class="bi bi-chevron-down"></i></div>
              </div>
              <div class="acc-body">
                <div class="timeline">
                  <div class="tl-item"><div class="tl-dot">1</div><div class="tl-card"><div class="tl-title">Klik Daftar → Pemilik Kost</div><p class="tl-text">Di navbar, klik <strong>"Daftar"</strong> lalu pilih <strong>"Daftar sebagai Pemilik Kost"</strong>.</p></div></div>
                  <div class="tl-item"><div class="tl-dot">2</div><div class="tl-card"><div class="tl-title">Isi formulir pendaftaran</div><p class="tl-text">Masukkan nama, email, nomor HP, dan password akun owner.</p></div></div>
                  <div class="tl-item"><div class="tl-dot">3</div><div class="tl-card"><div class="tl-title">Lengkapi verifikasi identitas</div><p class="tl-text">Upload dokumen identitas agar kost bisa tampil di platform.</p></div></div>
                  <div class="tl-item"><div class="tl-dot">4</div><div class="tl-card"><div class="tl-title">Tunggu persetujuan admin</div><p class="tl-text">Tim KostFinder memverifikasi akun dalam <strong>1×24 jam</strong>.</p></div></div>
                </div>
                <div class="tip-box"><i class="bi bi-shield-check-fill"></i><span>Kost hanya tampil di pencarian setelah identitas pemilik <strong>diverifikasi</strong> oleh admin KostFinder.</span></div>
              </div>
            </div>

            <div class="acc-item">
              <div class="acc-header" onclick="toggleAcc(this)">
                <div class="acc-ico"><i class="bi bi-house-add-fill"></i></div>
                <div class="acc-title">Cara Mendaftarkan dan Memasang Iklan Kost</div>
                <div class="acc-arrow"><i class="bi bi-chevron-down"></i></div>
              </div>
              <div class="acc-body">
                <div class="timeline">
                  <div class="tl-item"><div class="tl-dot">1</div><div class="tl-card"><div class="tl-title">Masuk ke Dashboard Owner</div><p class="tl-text">Login ke akun pemilik lalu buka <strong>Dashboard Owner</strong>.</p></div></div>
                  <div class="tl-item"><div class="tl-dot">2</div><div class="tl-card"><div class="tl-title">Klik Tambah Kost</div><p class="tl-text">Isi nama, alamat, kota, tipe kost, dan deskripsi properti.</p></div></div>
                  <div class="tl-item"><div class="tl-dot">3</div><div class="tl-card"><div class="tl-title">Upload foto kost</div><p class="tl-text">Tambahkan <strong>foto kost yang menarik</strong> untuk meningkatkan minat calon penghuni.</p></div></div>
                  <div class="tl-item"><div class="tl-dot">4</div><div class="tl-card"><div class="tl-title">Tambahkan detail kamar</div><p class="tl-text">Isi <strong>tipe kamar, harga per bulan, fasilitas</strong>, dan ketersediaannya.</p></div></div>
                </div>
              </div>
            </div>

            <div class="acc-item">
              <div class="acc-header" onclick="toggleAcc(this)">
                <div class="acc-ico"><i class="bi bi-check2-all"></i></div>
                <div class="acc-title">Cara Konfirmasi dan Kelola Booking Masuk</div>
                <div class="acc-arrow"><i class="bi bi-chevron-down"></i></div>
              </div>
              <div class="acc-body">
                <div class="timeline">
                  <div class="tl-item"><div class="tl-dot">1</div><div class="tl-card"><div class="tl-title">Cek notifikasi booking</div><p class="tl-text">Buka <strong>Dashboard Owner → Booking</strong> saat ada pemesanan masuk.</p></div></div>
                  <div class="tl-item"><div class="tl-dot">2</div><div class="tl-card"><div class="tl-title">Terima atau Tolak</div><p class="tl-text">Lihat detail calon penghuni, klik <strong>"Terima"</strong> atau <strong>"Tolak"</strong>.</p></div></div>
                  <div class="tl-item"><div class="tl-dot">3</div><div class="tl-card"><div class="tl-title">Konfirmasi selesai</div><p class="tl-text">Setelah penghuni membayar, klik <strong>"Selesai"</strong> untuk menandai lunas.</p></div></div>
                </div>
              </div>
            </div>
          </div>
        </div>

        {{-- ── PANEL: AKUN ── --}}
        <div class="panel" id="panel-akun">
          <div class="panel-head">
            <div class="panel-ico"><i class="bi bi-shield-lock-fill"></i></div>
            <div>
              <div class="panel-title">Keamanan Akun</div>
              <div class="panel-subtitle">Panduan mengelola password dan keamanan akun KostFinder kamu</div>
            </div>
          </div>

          <div class="acc-list">
            <div class="acc-item open">
              <div class="acc-header" onclick="toggleAcc(this)">
                <div class="acc-ico"><i class="bi bi-key-fill"></i></div>
                <div class="acc-title">Cara Ganti Password</div>
                <div class="acc-arrow"><i class="bi bi-chevron-down"></i></div>
              </div>
              <div class="acc-body">
                <div class="timeline">
                  <div class="tl-item"><div class="tl-dot">1</div><div class="tl-card"><div class="tl-title">Buka Profil → Keamanan</div><p class="tl-text">Login lalu buka halaman <strong>Profil</strong> dan klik tab <strong>"Keamanan"</strong>.</p></div></div>
                  <div class="tl-item"><div class="tl-dot">2</div><div class="tl-card"><div class="tl-title">Isi form ganti password</div><p class="tl-text">Masukkan <strong>password lama</strong> dan <strong>password baru</strong> minimal 8 karakter.</p></div></div>
                  <div class="tl-item"><div class="tl-dot">3</div><div class="tl-card"><div class="tl-title">Simpan perubahan</div><p class="tl-text">Klik <strong>"Simpan"</strong> — password baru langsung aktif.</p></div></div>
                </div>
              </div>
            </div>

            <div class="acc-item">
              <div class="acc-header" onclick="toggleAcc(this)">
                <div class="acc-ico"><i class="bi bi-envelope-fill"></i></div>
                <div class="acc-title">Cara Reset Password (Lupa Password)</div>
                <div class="acc-arrow"><i class="bi bi-chevron-down"></i></div>
              </div>
              <div class="acc-body">
                <div class="timeline">
                  <div class="tl-item"><div class="tl-dot">1</div><div class="tl-card"><div class="tl-title">Klik "Lupa password?"</div><p class="tl-text">Di halaman login, klik link <strong>"Lupa password?"</strong>.</p></div></div>
                  <div class="tl-item"><div class="tl-dot">2</div><div class="tl-card"><div class="tl-title">Masukkan email terdaftar</div><p class="tl-text">Isi <strong>email</strong> terdaftar lalu klik <strong>"Kirim Link Reset"</strong>.</p></div></div>
                  <div class="tl-item"><div class="tl-dot">3</div><div class="tl-card"><div class="tl-title">Cek email & reset password</div><p class="tl-text">Klik link di email, lalu masukkan <strong>password baru</strong>.</p></div></div>
                </div>
                <div class="tip-box"><i class="bi bi-clock-fill"></i><span>Link reset password berlaku selama <strong>60 menit</strong>. Jika expired, ulangi dari awal.</span></div>
              </div>
            </div>
          </div>
        </div>

      </div>{{-- end panels --}}
    </div>
  </div>
</section>

@endsection

@section('scripts')
<script>
const PANELS = ['penghuni','cari','booking','owner','akun'];

function switchPanel(id, catEl) {
  PANELS.forEach(p => {
    document.getElementById('panel-' + p)?.classList.toggle('active', p === id);
  });

  document.querySelectorAll('.cat-card').forEach((el, i) => {
    el.classList.toggle('active', catEl ? el === catEl : PANELS[i] === id);
  });

  document.querySelector('.main-section')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
}

function toggleAcc(header) {
  header.closest('.acc-item').classList.toggle('open');
}

function liveSearch(val) {
  if (!val.trim()) return;
  const q = val.toLowerCase();
  const map = {
    daftar:'penghuni', registrasi:'penghuni', login:'penghuni',
    masuk:'penghuni', profil:'penghuni',
    cari:'cari', filter:'cari', favorit:'cari', kota:'cari',
    booking:'booking', pesan:'booking', bayar:'booking',
    pembayaran:'booking', batal:'booking',
    owner:'owner', pemilik:'owner', properti:'owner',
    pasang:'owner', iklan:'owner',
    password:'akun', sandi:'akun', reset:'akun', keamanan:'akun'
  };
  for (const [key, panel] of Object.entries(map)) {
    if (q.includes(key)) { switchPanel(panel); break; }
  }
}


function showComingSoon() {
  const msg = document.getElementById('comingSoonMsg');
  msg.style.display = 'block';
  setTimeout(() => { msg.style.display = 'none'; }, 3500);
}
function doSearch() { liveSearch(document.getElementById('heroSearch').value); }
</script>
@endsection