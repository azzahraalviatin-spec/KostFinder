@extends('layouts.app')

@section('title', 'Temukan Kost Impian di Jawa Timur')

@section('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Fraunces:ital,opsz,wght@0,9..144,700;1,9..144,400&display=swap" rel="stylesheet">

<style>
  :root {
    --kf-primary: #e4572e;
    --kf-primary-dark: #c03e1c;
    --kf-primary-light: #ff7a52;
    --kf-dark: #0f1923;
    --kf-muted: #6c768a;
    --kf-soft: #f6f8fc;
    --kf-border: #e7ebf3;
    --kf-accent: #ffb347;
  }

  *, *::before, *::after { box-sizing: border-box; }
  html { scroll-behavior: smooth; }
  body { font-family: 'Plus Jakarta Sans', sans-serif; }
  .welcome-page { background: #fafbff; overflow-x: hidden; }

  /* ── HERO ── */
  .hero { position: relative; min-height: 100vh; display: flex; align-items: center; overflow: hidden; }
  .hero-bg {
    position: absolute; inset: 0;
    background-image: linear-gradient(135deg, rgba(10,18,32,.92) 0%, rgba(15,25,40,.75) 45%, rgba(10,18,32,.55) 100%),
      url('{{ asset("images/hero-kost1.jpg") }}');
    background-size: cover;
    background-position: center;
    transform: scale(1.04);
    transition: transform 8s ease-out;
  }
  .hero-bg.loaded { transform: scale(1); }
  .hero-mesh { position: absolute; inset: 0; background: radial-gradient(ellipse 60% 55% at 80% 30%, rgba(228,87,46,.22) 0%, transparent 65%), radial-gradient(ellipse 40% 60% at 10% 80%, rgba(255,179,71,.12) 0%, transparent 55%); pointer-events: none; }
  .hero-grain { position: absolute; inset: 0; opacity: .04; background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)'/%3E%3C/svg%3E"); pointer-events: none; }
  .hero-content { position: relative; z-index: 2; padding: 1rem 0 1rem; animation: heroIn .9s cubic-bezier(.22,1,.36,1) both; }
  @keyframes heroIn { from { opacity: 0; transform: translateY(28px); } to { opacity: 1; transform: translateY(0); } }
  .hero-badge { display: inline-flex; align-items: center; gap: .4rem; padding: .38rem .9rem; border-radius: 999px; border: 1px solid rgba(255,255,255,.22); background: rgba(255,255,255,.08); backdrop-filter: blur(8px); color: #e8d5c8; font-size: .8rem; font-weight: 600; letter-spacing: .03em; margin-bottom: 1.4rem; animation: heroIn .9s .1s cubic-bezier(.22,1,.36,1) both; }
  .hero-badge span.dot { width: 7px; height: 7px; border-radius: 50%; background: #4ade80; box-shadow: 0 0 0 3px rgba(74,222,128,.3); animation: pulse 2s infinite; }
  @keyframes pulse { 0%,100% { box-shadow:0 0 0 3px rgba(74,222,128,.3) } 50% { box-shadow:0 0 0 6px rgba(74,222,128,.15) } }
  .hero-title { font-family: 'Fraunces', serif; font-weight: 700; font-size: clamp(2.4rem, 5.5vw, 4.8rem); line-height: 1.06; letter-spacing: -.025em; color: #fff; margin-bottom: 1rem; animation: heroIn .9s .18s cubic-bezier(.22,1,.36,1) both; }
  .hero-title .accent { color: var(--kf-primary-light); font-style: italic; position: relative; }
  .hero-title .accent::after { content: ''; position: absolute; bottom: -4px; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, var(--kf-primary-light), transparent); border-radius: 99px; }
  .hero-sub { color: #bdc9e0; font-size: 1rem; max-width: 580px; line-height: 1.75; margin-bottom: 2rem; animation: heroIn .9s .26s cubic-bezier(.22,1,.36,1) both; }

  /* ── SEARCH CARD ── */
  .search-wrapper { position: relative; max-width: 760px; animation: heroIn .9s .34s cubic-bezier(.22,1,.36,1) both; }
  .search-card { background: rgba(255,255,255,.99); backdrop-filter: blur(16px); border-radius: 1.5rem; padding: .95rem 1rem; box-shadow: 0 24px 48px rgba(5,10,20,.22), 0 0 0 1px rgba(255,255,255,.2); }
  .search-card .form-control { border: 0; height: 50px; font-size: .95rem; padding-left: 0; color: var(--kf-dark); background: transparent; }
  .search-card .form-control:focus { box-shadow: none; }
  .search-card .form-control::placeholder { color: #a0a9bc; }
  .search-divider { width: 1px; height: 28px; background: #e0e5ef; margin: 0 .4rem; }
  .btn-filter { display: flex; align-items: center; gap: .38rem; padding: .58rem .95rem; border-radius: .95rem; border: 1px solid #f1d7cb; background: linear-gradient(135deg, #fff8f4 0%, #ffece3 100%); color: #f06432; font-size: .84rem; font-weight: 700; white-space: nowrap; cursor: pointer; transition: all .18s; }
  .btn-filter:hover { background: linear-gradient(135deg, #fff2eb 0%, #ffe1d4 100%); border-color: #efb7a2; }
  .btn-cari { height: 50px; padding: 0 1.6rem; border-radius: 1rem; border: 0; background: linear-gradient(135deg, #ffd7c7 0%, #ff9b75 100%); color: #31170d; font-weight: 800; font-size: .95rem; letter-spacing: .01em; white-space: nowrap; box-shadow: 0 10px 24px rgba(228,87,46,.22); transition: all .2s; cursor: pointer; }
  .btn-cari:hover { transform: translateY(-1px); box-shadow: 0 14px 28px rgba(228,87,46,.28); color: #20100a; }

  /* ── HERO DROPDOWN ── */
  .hero-dropdown {
    position: absolute; top: calc(100% + 8px); left: 0; right: 0;
    z-index: 99999; background: #fff; border-radius: 1.35rem;
    border: 1px solid #eef2f7; box-shadow: 0 22px 54px rgba(10,20,50,.18);
    padding: 1rem 1rem .95rem; animation: dropIn .2s ease;
  }
  @keyframes dropIn { from { opacity: 0; transform: translateY(-8px); } to { opacity: 1; transform: none; } }
  .hero-drop-head { display: flex; align-items: flex-start; gap: .75rem; margin-bottom: 1rem; }
  .hero-drop-icon { width: 34px; height: 34px; border-radius: 50%; border: 1px solid #eef2f7; background: #fff8f4; display: flex; align-items: center; justify-content: center; color: #f06432; flex-shrink: 0; }
  .hero-chip { display: inline-flex; align-items: center; justify-content: center; padding: .48rem .95rem; border-radius: 999px; border: 1px solid #dde5ef; background: #fff; color: #25313d; cursor: pointer; font-size: .76rem; font-weight: 600; transition: all .18s ease; }
  .hero-chip:hover { border-color: #ffbeaa; color: #f06432; background: #fff8f4; }
  .hero-kota-thumb { width: 88px; height: 56px; border-radius: .75rem; overflow: hidden; background: #f0f3f8; margin-bottom: .38rem; border: 1.5px solid #eaeff8; }
  .hero-kota-thumb img { width: 100%; height: 100%; object-fit: cover; }

  .quick-tags { display: flex; flex-wrap: wrap; gap: .45rem; margin-top: .9rem; animation: heroIn .9s .42s cubic-bezier(.22,1,.36,1) both; }
  .qtag { display: inline-flex; align-items: center; gap: .3rem; padding: .3rem .75rem; border-radius: 999px; background: rgba(255,255,255,.12); border: 1px solid rgba(255,255,255,.2); color: #e0e8f5; font-size: .78rem; font-weight: 600; cursor: pointer; backdrop-filter: blur(6px); transition: all .2s; }
  .qtag:hover { background: rgba(255,255,255,.2); color: #fff; }

  /* ── STATS ── */
  .stats-row { position: relative; z-index: 4; margin-top: -3rem; }
  .stats-card { background: #fff; border-radius: 1.2rem; border: 1px solid #eaeff9; box-shadow: 0 20px 50px rgba(10,20,50,.1); padding: 1.5rem 2rem; }
  .stat-item { text-align: center; }
  .stat-number { font-family: 'Fraunces', serif; font-size: clamp(1.6rem, 2.8vw, 2.2rem); font-weight: 700; color: var(--kf-dark); line-height: 1; }
  .stat-number .stat-accent { color: var(--kf-primary); }
  .stat-label { margin-top: .3rem; color: var(--kf-muted); font-size: .82rem; font-weight: 500; }
  .stat-divider { width: 1px; background: #eaeff9; align-self: stretch; }

  /* ── SECTION UMUM ── */
  .section-space { padding: 5rem 0; }
  .section-title { font-family: 'Fraunces', serif; font-weight: 700; color: var(--kf-dark); letter-spacing: -.02em; line-height: 1.15; margin-bottom: .4rem; }
  .section-sub { color: var(--kf-muted); font-size: .95rem; margin: 0; }

  /* ── PROMO ── */
  .promo-track { display: flex; gap: 1rem; overflow-x: auto; scroll-behavior: smooth; padding-bottom: .5rem; scrollbar-width: none; }
  .promo-track::-webkit-scrollbar { display: none; }
  .promo-card { flex: 0 0 clamp(300px, 72vw, 820px); height: 240px; border-radius: 1rem; overflow: hidden; background: linear-gradient(135deg, #f0e8e0, #e8d8ce); border: 1px solid #ddd5ce; position: relative; }
  .promo-card img { width: 100%; height: 100%; object-fit: cover; }
  .promo-empty { width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: .9rem; color: #a09080; font-weight: 600; }
  .promo-controls { display: flex; align-items: center; gap: .8rem; margin-top: 1rem; }
  .promo-nav-btn { width: 40px; height: 40px; border-radius: 50%; border: 1.5px solid #dde3ef; background: #fff; color: var(--kf-dark); display: flex; align-items: center; justify-content: center; font-size: 1rem; box-shadow: 0 4px 12px rgba(0,0,0,.07); transition: all .2s; cursor: pointer; }
  .promo-nav-btn:hover { background: var(--kf-primary); border-color: var(--kf-primary); color: #fff; }
  .promo-see-all { color: var(--kf-dark); font-weight: 700; font-size: .9rem; text-decoration: none; }
  .promo-see-all:hover { color: var(--kf-primary); }

  /* ── KOTA POPULER ── */
  .kota-section { background: linear-gradient(180deg, #f4f7ff 0%, #fff 100%); }
  .city-card { position: relative; border-radius: 1.1rem; overflow: hidden; display: block; height: 210px; box-shadow: 0 8px 24px rgba(10,20,50,.1); border: 1px solid #dae2f0; transition: transform .28s ease, box-shadow .28s ease; text-decoration: none; }
  .city-card:hover { transform: translateY(-5px); box-shadow: 0 18px 40px rgba(10,20,50,.18); }
  .city-card img { width: 100%; height: 100%; object-fit: cover; transition: transform .5s ease; }
  .city-card:hover img { transform: scale(1.06); }
  .city-overlay { position: absolute; inset: 0; background: linear-gradient(to top, rgba(8,14,26,.78) 0%, rgba(8,14,26,.42) 55%, rgba(8,14,26,.18) 100%); display: flex; align-items: center; justify-content: center; flex-direction: column; text-align: center; padding: 1rem; color: #fff; }
  .city-overlay h6 { margin: 0; font-weight: 800; font-size: 1.05rem; text-shadow: 0 2px 8px rgba(0,0,0,.5); }
  .city-overlay p { margin: .3rem 0 0; font-size: .75rem; color: #c8d8ee; background: rgba(255,255,255,.12); backdrop-filter: blur(4px); padding: .18rem .6rem; border-radius: 999px; }

  /* ── REKOMENDASI ── */
  .reco-track { display: flex; gap: 1.1rem; overflow-x: auto; scroll-behavior: smooth; padding-bottom: .5rem; scrollbar-width: none; }
  .reco-track::-webkit-scrollbar { display: none; }
  .reco-item { flex: 0 0 clamp(270px, 33vw, 310px); display: flex; }
  .reco-item > a { width: 100%; }
  .kost-card { border-radius: 1rem; overflow: hidden; background: #fff; border: 1px solid #eaeff9; box-shadow: 0 4px 16px rgba(10,20,50,.07); transition: transform .25s, box-shadow .25s; }
  .kost-card:hover { transform: translateY(-5px); box-shadow: 0 16px 40px rgba(10,20,50,.14); }
  .kost-img-wrap { position: relative; height: 195px; overflow: hidden; }
  .kost-img-wrap img { width: 100%; height: 100%; object-fit: cover; transition: transform .45s; }
  .kost-card:hover .kost-img-wrap img { transform: scale(1.05); }

  /* ── TOMBOL FAVORIT ── */
  .btn-fav { position: absolute; top: .7rem; right: .7rem; width: 34px; height: 34px; border-radius: 50%; background: rgba(255,255,255,.95); backdrop-filter: blur(6px); border: 0; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 2px 10px rgba(0,0,0,.18); transition: transform .2s, box-shadow .2s; z-index: 5; }
  .btn-fav:hover { transform: scale(1.18); box-shadow: 0 4px 16px rgba(232,64,28,.3); }
  .btn-fav.liked { background: #fff0ee; }
  .btn-fav i { font-size: .95rem; transition: transform .25s cubic-bezier(.34,1.56,.64,1), color .15s; }
  .btn-fav.pop i { transform: scale(1.5); }

  .kost-body { padding: .9rem 1rem 1rem; }
  .kost-name { font-weight: 800; font-size: .92rem; color: var(--kf-dark); line-height: 1.35; margin-bottom: .22rem; }
  .kost-loc { font-size: .75rem; color: var(--kf-muted); margin-bottom: .3rem; display: flex; align-items: center; gap: .22rem; }
  .kost-fas { font-size: .7rem; color: #9ca3af; margin-bottom: .55rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
  .kost-price-label { font-size: .72rem; color: var(--kf-muted); }
  .kost-price { font-size: 1.05rem; font-weight: 900; color: var(--kf-primary); letter-spacing: -.01em; }
  .kost-price span { font-size: .75rem; font-weight: 400; color: #9ca3af; }
  .reco-nav-btn { width: 40px; height: 40px; border-radius: 50%; border: 1.5px solid #dde3ef; background: #fff; color: var(--kf-dark); display: flex; align-items: center; justify-content: center; font-size: 1rem; box-shadow: 0 4px 12px rgba(0,0,0,.07); transition: all .2s; cursor: pointer; }
  .reco-nav-btn:hover { background: var(--kf-primary); border-color: var(--kf-primary); color: #fff; }

  /* ── OWNER BANNER ── */
  .owner-section { background: var(--kf-dark); }
  .owner-banner { border-radius: 1.4rem; overflow: hidden; background-image: linear-gradient(100deg, rgba(10,18,32,.96) 0%, rgba(10,18,32,.85) 40%, rgba(10,18,32,.5) 70%, rgba(10,18,32,.15) 100%), url('{{ asset("images/banner/owner-kost-banner.jpg") }}'); background-size: cover; background-position: center right; padding: 3.5rem 3rem; position: relative; }
  .owner-banner::before { content: ''; position: absolute; inset: 0; background: radial-gradient(ellipse 50% 80% at 90% 50%, rgba(228,87,46,.18), transparent); pointer-events: none; }
  .owner-content { position: relative; z-index: 2; max-width: 580px; }
  .owner-chip { display: inline-flex; align-items: center; gap: .4rem; background: rgba(228,87,46,.18); border: 1px solid rgba(228,87,46,.4); color: #ff9977; font-size: .75rem; font-weight: 700; letter-spacing: .07em; text-transform: uppercase; padding: .3rem .8rem; border-radius: 999px; margin-bottom: 1rem; }
  .owner-title { font-family: 'Fraunces', serif; font-weight: 700; color: #fff; font-size: clamp(1.7rem, 3.5vw, 2.9rem); line-height: 1.12; letter-spacing: -.02em; margin-bottom: .7rem; }
  .owner-sub { color: #8a9ab8; font-size: .95rem; line-height: 1.6; margin-bottom: 1.6rem; }
  .btn-owner { display: inline-flex; align-items: center; gap: .5rem; background: linear-gradient(135deg, var(--kf-primary), var(--kf-primary-dark)); color: #fff; font-weight: 800; font-size: .95rem; padding: .85rem 1.6rem; border-radius: .85rem; text-decoration: none; box-shadow: 0 8px 24px rgba(228,87,46,.45); transition: all .2s; }
  .btn-owner:hover { transform: translateY(-2px); color: #fff; }

  /* ── FITUR SECTION ── */
  .fitur-section { background: linear-gradient(160deg, #0f1923 0%, #1a2a3a 50%, #0f1923 100%); position: relative; overflow: hidden; }
  .fitur-section::before { content: ''; position: absolute; inset: 0; background: radial-gradient(ellipse 55% 45% at 15% 20%, rgba(228,87,46,.14) 0%, transparent 60%), radial-gradient(ellipse 40% 50% at 85% 80%, rgba(255,179,71,.08) 0%, transparent 55%); pointer-events: none; }
  .fitur-inner { position: relative; z-index: 2; }
  .fitur-desc-box { padding-right: 2.5rem; }
  .fitur-platform-badge { display: inline-flex; align-items: center; gap: .4rem; padding: .32rem .85rem; border-radius: 999px; background: rgba(228,87,46,.18); border: 1px solid rgba(228,87,46,.35); color: #ff9f80; font-size: .75rem; font-weight: 700; letter-spacing: .06em; text-transform: uppercase; margin-bottom: 1.1rem; }
  .fitur-main-title { font-family: 'Fraunces', serif; font-weight: 700; color: #fff; font-size: clamp(1.7rem, 3vw, 2.5rem); line-height: 1.15; letter-spacing: -.02em; margin-bottom: .9rem; }
  .fitur-main-title span { color: var(--kf-primary-light); font-style: italic; }
  .fitur-main-desc { color: #8a9ab8; font-size: .92rem; line-height: 1.85; margin-bottom: 1.8rem; }
  .fitur-toggle-btn { display: inline-flex; align-items: center; gap: .6rem; padding: .72rem 1.4rem; border-radius: .85rem; border: 1.5px solid rgba(255,255,255,.15); background: rgba(255,255,255,.07); backdrop-filter: blur(8px); color: #d0ddf0; font-size: .88rem; font-weight: 700; cursor: pointer; transition: all .22s; white-space: nowrap; }
  .fitur-toggle-btn:hover { background: rgba(228,87,46,.2); border-color: rgba(228,87,46,.5); color: #ffceba; }
  .fitur-toggle-btn .ft-icon { transition: transform .35s cubic-bezier(.34,1.56,.64,1); }
  .fitur-toggle-btn.open .ft-icon { transform: rotate(180deg); }
  .fitur-cards-wrap { max-height: 0; overflow: hidden; transition: max-height .5s cubic-bezier(.4,0,.2,1), opacity .4s ease; opacity: 0; }
  .fitur-cards-wrap.open { max-height: 1600px; opacity: 1; }
  .fitur-cards-grid { display: grid; grid-template-columns: 1fr 1fr; gap: .9rem; padding-top: 1.4rem; }
  @media (max-width: 600px) { .fitur-cards-grid { grid-template-columns: 1fr; } }
  .fitur-card { background: rgba(255,255,255,.05); border: 1px solid rgba(255,255,255,.1); border-radius: 1rem; padding: 1.1rem 1.2rem; display: flex; gap: .9rem; align-items: flex-start; transition: background .22s, border-color .22s, transform .22s; }
  .fitur-card:hover { background: rgba(255,255,255,.09); border-color: rgba(228,87,46,.3); transform: translateY(-2px); }
  .fitur-card-icon { width: 40px; height: 40px; border-radius: .8rem; flex-shrink: 0; display: flex; align-items: center; justify-content: center; font-size: 1.05rem; color: #fff; }
  .fci1 { background: linear-gradient(135deg,#ff7a52,#e4572e); }
  .fci2 { background: linear-gradient(135deg,#34d399,#059669); }
  .fci3 { background: linear-gradient(135deg,#60a5fa,#2563eb); }
  .fci4 { background: linear-gradient(135deg,#c084fc,#7c3aed); }
  .fci5 { background: linear-gradient(135deg,#fbbf24,#d97706); }
  .fci6 { background: linear-gradient(135deg,#2dd4bf,#0d9488); }
  .fitur-card-title { font-size: .88rem; font-weight: 800; color: #e8edf6; margin-bottom: .25rem; }
  .fitur-card-desc { font-size: .8rem; color: #7a90ac; line-height: 1.7; margin: 0; }
  .fitur-layout { display: grid; grid-template-columns: 1fr 1.6fr; gap: 3rem; align-items: start; }
  @media (max-width: 991px) { .fitur-layout { grid-template-columns: 1fr; gap: 2rem; } .fitur-desc-box { padding-right: 0; } }

  /* ── TESTIMONIAL ── */
  .testimonial-section { background: linear-gradient(180deg, #fff 0%, #f8fbff 100%); }
  .testimonial-card { background: #fff; border: 1px solid #e8edf6; border-radius: 1.2rem; padding: 1.5rem; height: 100%; box-shadow: 0 10px 30px rgba(15,25,35,.06); transition: all .25s ease; }
  .testimonial-card:hover { transform: translateY(-5px); box-shadow: 0 18px 40px rgba(15,25,35,.12); }
  .testimonial-stars { color: #f59e0b; font-size: .95rem; margin-bottom: .8rem; }
  .testimonial-quote { color: #334155; font-size: .92rem; line-height: 1.8; margin-bottom: 1.2rem; }
  .testimonial-user { display: flex; align-items: center; gap: .85rem; }
  .testimonial-avatar { width: 46px; height: 46px; border-radius: 50%; background: linear-gradient(135deg, #ffe3d8, #ffd1bf); color: var(--kf-primary-dark); font-weight: 800; display: flex; align-items: center; justify-content: center; }
  .testimonial-name { font-weight: 800; font-size: .9rem; color: var(--kf-dark); margin: 0; }
  .testimonial-role { font-size: .78rem; color: var(--kf-muted); margin: 0; }

  /* ── FINAL CTA ── */
  .final-cta-section { background: linear-gradient(135deg, #0f1923 0%, #162232 100%); }
  .final-cta-box { position: relative; overflow: hidden; border-radius: 1.5rem; padding: 3.2rem 2rem; background: radial-gradient(circle at top right, rgba(228,87,46,.22), transparent 28%), radial-gradient(circle at bottom left, rgba(255,179,71,.14), transparent 30%); border: 1px solid rgba(255,255,255,.08); text-align: center; }
  .final-cta-title { font-family: 'Fraunces', serif; font-size: clamp(1.8rem, 3.8vw, 3rem); color: #fff; font-weight: 700; letter-spacing: -.02em; margin-bottom: .8rem; }
  .final-cta-sub { max-width: 650px; margin: 0 auto 1.6rem; color: #aebcd2; font-size: .95rem; line-height: 1.8; }
  .btn-final-cta { display: inline-flex; align-items: center; gap: .5rem; background: linear-gradient(135deg, var(--kf-primary), var(--kf-primary-dark)); color: #fff; font-weight: 800; font-size: .95rem; padding: .9rem 1.5rem; border-radius: .85rem; text-decoration: none; box-shadow: 0 10px 28px rgba(228,87,46,.38); transition: all .2s ease; }
  .btn-final-cta:hover { transform: translateY(-2px); color: #fff; }

  /* ── FILTER CHIP ── */
  .f-chip { display:inline-flex; align-items:center; gap:.3rem; padding:.4rem .9rem; border-radius:999px; border:1.5px solid #e4e9f0; background:#fff; font-size:.8rem; font-weight:600; color:#555; cursor:pointer; transition:all .18s; user-select:none; }
  .f-chip:hover { border-color:#ffbeaa; color:#e4572e; background:#fff8f4; }
  .f-chip.aktif { background:#fff5f2; border-color:#e4572e; color:#e4572e; }

  /* ── MODAL FILTER ── */
  .modal-filter .modal-content { border: 0; border-radius: 1.4rem; box-shadow: 0 32px 80px rgba(10,20,50,.22); overflow: hidden; }
  .modal-filter-header { padding: 1.3rem 1.5rem 1rem; border-bottom: 1px solid #f0f4f9; display: flex; align-items: center; justify-content: space-between; }
  .modal-filter-title { font-family: 'Fraunces', serif; font-weight: 700; font-size: 1.1rem; color: var(--kf-dark); margin: 0; }
  .modal-filter-sub { font-size: .76rem; color: var(--kf-muted); margin: .1rem 0 0; }
  .modal-filter-body { padding: 1.3rem 1.5rem; max-height: 68vh; overflow-y: auto; }
  .modal-filter-body::-webkit-scrollbar { width: 5px; }
  .modal-filter-body::-webkit-scrollbar-track { background: #f6f8fc; }
  .modal-filter-body::-webkit-scrollbar-thumb { background: #dde3ef; border-radius: 99px; }
  .filter-group { margin-bottom: 1.4rem; }
  .filter-group-label { font-size: .7rem; font-weight: 800; color: var(--kf-dark); letter-spacing: .08em; text-transform: uppercase; margin-bottom: .7rem; display: flex; align-items: center; gap: .4rem; }
  .filter-group-label::after { content: ''; flex: 1; height: 1px; background: #eef2f8; }
  .modal-filter-footer { padding: 1rem 1.5rem; border-top: 1px solid #f0f4f9; display: flex; gap: .75rem; }
  .btn-reset-filter { flex: 1; padding: .7rem; border-radius: .9rem; border: 1.5px solid #e0e6f0; background: #fff; font-size: .85rem; font-weight: 700; color: #555; cursor: pointer; transition: all .18s; }
  .btn-reset-filter:hover { border-color: #c5cfe0; color: #333; }
  .btn-apply-filter { flex: 2.2; padding: .7rem; border-radius: .9rem; border: 0; background: linear-gradient(135deg, var(--kf-primary), var(--kf-primary-dark)); color: #fff; font-size: .88rem; font-weight: 800; cursor: pointer; box-shadow: 0 8px 22px rgba(228,87,46,.28); transition: all .2s; }
  .btn-apply-filter:hover { transform: translateY(-1px); box-shadow: 0 12px 28px rgba(228,87,46,.36); }

  /* ── REVEAL ── */
  .reveal { opacity: 0; transform: translateY(24px); transition: opacity .65s ease, transform .65s ease; }
  .reveal.visible { opacity: 1; transform: none; }
  .reveal-delay-1 { transition-delay: .1s; }
  .reveal-delay-2 { transition-delay: .2s; }
  .reveal-delay-3 { transition-delay: .3s; }

  @media (max-width: 991px) { .hero-content { padding-top: 5rem; padding-bottom: 5rem; } .owner-banner { padding: 2.5rem 2rem; } }
  @media (max-width: 767px) { .stats-row { margin-top: -1.5rem; } .stats-card { padding: 1.1rem 1rem; } .search-card { padding: .75rem; } .btn-cari { width: 100%; margin-top: .5rem; border-radius: .75rem !important; height: 46px; } .owner-banner { padding: 2rem 1.4rem; } .final-cta-box { padding: 2.4rem 1.2rem; } }
</style>
@endsection

@section('content')
<div class="welcome-page">

  {{-- ══════════════ HERO ══════════════ --}}
  <section class="hero">
    <div class="hero-bg" id="heroBg"></div>
    <div class="hero-mesh"></div>
    <div class="hero-grain"></div>
    <div class="container hero-content">
      <div class="row">
        <div class="col-lg-9 col-xl-8">
          <div class="hero-badge"><span class="dot"></span> Platform Kost Fokus Jawa Timur</div>
          <h1 class="hero-title">Temukan Kost yang<br><span class="accent">Nyaman &amp; Cocok</span> untukmu</h1>
          <p class="hero-sub">Cari kost putra, putri, atau campur dengan lokasi strategis, harga transparan, dan informasi yang lebih jelas — biar kamu nggak bingung sebelum memilih.</p>

          <div class="search-wrapper" id="searchWrapper">
            <div class="search-card">
              <div class="d-flex align-items-center gap-2 flex-wrap flex-md-nowrap">
                <i class="bi bi-search" style="color:#a0a9bc;font-size:1.1rem;flex-shrink:0;margin-left:.3rem;"></i>
                <input
                  type="text"
                  id="heroSearchInput"
                  class="form-control flex-grow-1"
                  placeholder="Cari kota, kampus, atau nama jalan..."
                  autocomplete="off"
                  onfocus="showHeroDropdown()"
                >
                <div class="search-divider d-none d-md-block"></div>
                <button onclick="showFilterModal()" class="btn-filter d-none d-md-flex">
                  <i class="bi bi-sliders"></i> Fasilitas
                </button>
                <button class="btn-cari" onclick="doSearch()">
                  <i class="bi bi-search me-1"></i> Cari Kost
                </button>
              </div>
            </div>

            <div id="heroDropdown" class="hero-dropdown d-none">
              <div class="hero-drop-head">
                <div class="hero-drop-icon"><i class="bi bi-house-door"></i></div>
                <div>
                  <div style="font-size:.82rem;font-weight:800;color:#111827;">Lokasi</div>
                  <div style="font-size:.8rem;color:#6b7280;line-height:1.5;">Cari nama properti / alamat / daerah / kota</div>
                </div>
              </div>

              <div class="d-flex gap-2 overflow-auto pb-2 mb-3" style="scrollbar-width:none;">
                @foreach([
                  'Surabaya' => 'photo-1555899434-94d1368aa7af',
                  'Malang'   => 'photo-1558618666-fcd25c85cd64',
                  'Sidoarjo' => 'photo-1486406146926-c627a92ad1ab',
                  'Gresik'   => 'photo-1504280390367-361c6d9f38f4',
                  'Jember'   => 'photo-1500534314209-a25ddb2bd429',
                ] as $c => $photo)
                <div class="text-center flex-shrink-0" style="cursor:pointer;" onclick="setHeroSearch('{{ $c }}')">
                  <div class="hero-kota-thumb">
                    <img src="{{ asset('images/kota/'.strtolower($c).'.jpg') }}"
                         onerror="this.src='https://images.unsplash.com/{{ $photo }}?w=88&h=56&fit=crop'"
                         alt="{{ $c }}" loading="lazy">
                  </div>
                  <div style="font-size:.74rem;font-weight:700;color:#374151;">{{ $c }}</div>
                </div>
                @endforeach
              </div>

              <div class="d-flex gap-3 border-bottom mb-2">
                <button id="tabBtnDaerah" class="btn btn-link p-0 pb-2 fw-bold text-decoration-none" style="color:var(--kf-primary);border-bottom:2px solid var(--kf-primary);font-size:.84rem;" onclick="switchHeroTab('daerah', this)">Daerah</button>
                <button id="tabBtnKampus" class="btn btn-link p-0 pb-2 fw-medium text-decoration-none" style="color:#888;font-size:.84rem;" onclick="switchHeroTab('kampus', this)">Kampus</button>
              </div>
              <div id="heroTabDaerah" class="d-flex flex-wrap gap-2">
                @foreach(['Surabaya','Malang','Sidoarjo','Gresik','Kediri','Jember','Banyuwangi','Mojokerto','Pasuruan'] as $d)
                <span class="hero-chip" onclick="setHeroSearch('{{ $d }}')">{{ $d }}</span>
                @endforeach
              </div>
              <div id="heroTabKampus" class="d-none flex-wrap gap-2">
                @foreach(['ITS Surabaya','UNAIR','UB Malang','UIN Malang','UNEJ Jember','UNESA','UNITOMO','UPN Veteran'] as $k)
                <span class="hero-chip" onclick="setHeroSearch('{{ $k }}')">{{ $k }}</span>
                @endforeach
              </div>
            </div>
          </div>

          <div class="quick-tags">
            <span style="color:#8090a8;font-size:.78rem;font-weight:600;align-self:center;">Populer:</span>
            @foreach(['Kos Malang','Kos ITS','Kos Surabaya','Kos Jember'] as $qt)
            <div class="qtag" onclick="setHeroSearch('{{ $qt }}')">{{ $qt }}</div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- ══════════════ STATS ══════════════ --}}
  <div class="container stats-row reveal">
    <div class="stats-card">
      <div class="d-flex justify-content-around align-items-center flex-wrap gap-3">
        <div class="stat-item">
          <div class="stat-number">{{ number_format($stats['total_kost']) }}<span class="stat-accent">+</span></div>
          <div class="stat-label">Unit Kost Aktif</div>
        </div>
        <div class="stat-divider d-none d-md-block"></div>
        <div class="stat-item">
          <div class="stat-number">{{ number_format($stats['total_kamar']) }}<span class="stat-accent">+</span></div>
          <div class="stat-label">Total Kamar Tersedia</div>
        </div>
        <div class="stat-divider d-none d-md-block"></div>
        <div class="stat-item">
          <div class="stat-number">{{ $stats['total_kota'] }}</div>
          <div class="stat-label">Kota Besar Jatim</div>
        </div>
        <div class="stat-divider d-none d-md-block"></div>
        <div class="stat-item">
          <div class="stat-number">{{ number_format($stats['avg_rating'], 1) }}<span class="stat-accent">/5</span></div>
          <div class="stat-label">Rating Pengguna</div>
        </div>
      </div>
    </div>
  </div>

  {{-- ══════════════ PROMO ══════════════ --}}
  <section class="section-space pb-3">
    <div class="container reveal">
      <div class="d-flex justify-content-between align-items-end flex-wrap gap-2 mb-3">
        <div>
          <h3 class="section-title" style="font-size:clamp(1.5rem,2.8vw,2rem);">Promo &amp; Info Menarik</h3>
          <p class="section-sub">Penawaran eksklusif dan info kost yang lagi banyak dicari.</p>
        </div>
        <div class="promo-controls">
          <button type="button" id="promoPrev" class="promo-nav-btn"><i class="bi bi-chevron-left"></i></button>
          <a href="#" class="promo-see-all">Lihat semua</a>
          <button type="button" id="promoNext" class="promo-nav-btn"><i class="bi bi-chevron-right"></i></button>
        </div>
      </div>
      <div class="promo-track" id="promoTrack" style="cursor:grab;">
        <article class="promo-card"><img src="{{ asset('images/promo/promo-1.jpg') }}" alt="Promo 1" onerror="this.parentElement.innerHTML='<div class=\'promo-empty\'>🎉 Promo Segera Hadir</div>'"></article>
        <article class="promo-card"><img src="{{ asset('images/promo/promo-2.jpg') }}" alt="Promo 2" onerror="this.parentElement.innerHTML='<div class=\'promo-empty\'>🎁 Iklan Kost Tersedia</div>'"></article>
        <article class="promo-card"><img src="{{ asset('images/promo/promo-3.jpg') }}" alt="Promo 3" onerror="this.parentElement.innerHTML='<div class=\'promo-empty\'>✨ Promo Menarik</div>'"></article>
      </div>
    </div>
  </section>

  {{-- ══════════════ KOTA POPULER ══════════════ --}}
  <section class="section-space kota-section" id="kota-populer">
    <div class="container">
      <div class="section-head reveal mb-4">
        <h3 class="section-title" style="font-size:clamp(1.5rem,2.8vw,2rem);">Kota Populer di Jawa Timur</h3>
        <p class="section-sub">Area kost favorit dekat kampus, kantor, dan pusat aktivitas.</p>
      </div>
      <div class="row g-3">
        @foreach($kotaList as $kota => $info)
          {{-- ✅ FIX: Tidak ada query di sini, pakai $jumlahPerKota dari controller --}}
          @php $jumlah = $jumlahPerKota[$kota] ?? 0; @endphp
          <div class="col-12 col-sm-6 col-md-4 reveal reveal-delay-{{ ($loop->index % 3) + 1 }}">
            <a href="{{ route('home', ['city' => $kota]) }}" class="city-card">
              <img src="{{ $info['img'] }}" loading="lazy"
                   onerror="this.onerror=null;this.src='{{ $info['fallback'] }}';"
                   alt="{{ $info['label'] }}">
              <div class="city-overlay">
                <div>
                  <h6>{{ $info['label'] }}</h6>
                  <p>{{ $jumlah > 0 ? $jumlah.' kost tersedia' : 'Segera hadir' }}</p>
                </div>
              </div>
            </a>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- ══════════════ REKOMENDASI ══════════════ --}}
  <section class="section-space" style="background:#f8faff;">
    <div class="container">
      <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-3 reveal">
        <div>
          <h3 class="section-title" style="font-size:clamp(1.5rem,2.8vw,2rem);">Rekomendasi Kost Unggulan</h3>
          <p class="section-sub">Properti dengan fasilitas lengkap dan tampilan yang paling menarik.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
          <a href="{{ route('home') }}" style="color:var(--kf-dark);font-weight:700;font-size:.88rem;text-decoration:none;">Lihat semua</a>
          <button type="button" id="recoPrev" class="reco-nav-btn"><i class="bi bi-chevron-left"></i></button>
          <button type="button" id="recoNext" class="reco-nav-btn"><i class="bi bi-chevron-right"></i></button>
        </div>
      </div>

      <div class="reco-track" id="recoTrack">
        @forelse($kosts as $kost)
        @php
          // ✅ FIX: Tidak ada query di sini — pakai hasil withAvg & withCount dari controller
          $sisaKamar    = $kost->rooms->where('status_kamar', 'tersedia')->count();
          $rating       = $kost->reviews_avg_rating ?? 0;   // ✅ pakai withAvg, bukan reviews->avg()
          $jumlahReview = $kost->reviews_count ?? 0;        // ✅ pakai withCount
          $fasilitas    = $kost->rooms->flatMap(fn($r) => is_array($r->fasilitas) ? $r->fasilitas : [])->unique()->take(4)->values();
          $hargaBulanan = $kost->rooms->where('aktif_bulanan', 1)->where('harga_per_bulan', '>', 0)->min('harga_per_bulan');
          $hargaHarian  = $kost->rooms->where('aktif_harian', 1)->where('harga_harian', '>', 0)->min('harga_harian');
          // ✅ FIX: Tidak ada query Favorite di sini — pakai $favoritIds dari controller
          $isFav = in_array($kost->id_kost, $favoritIds);
        @endphp
        <div class="reco-item">
          <a href="{{ route('kost.show', $kost->id_kost) }}" style="text-decoration:none;color:inherit;display:block;width:100%;">
            <div class="kost-card" style="height:100%;display:flex;flex-direction:column;">

              {{-- Gambar --}}
              <div class="kost-img-wrap" style="flex-shrink:0;">
                @if($kost->foto_utama)
                  <img src="{{ asset('storage/'.$kost->foto_utama) }}" alt="{{ $kost->nama_kost }}" loading="lazy">
                @else
                  <div style="width:100%;height:100%;background:linear-gradient(135deg,#fff0eb,#ffddd0);display:flex;align-items:center;justify-content:center;font-size:3.5rem;">🏠</div>
                @endif

                {{-- Tombol Favorit — ✅ FIX: pakai $isFav dari $favoritIds, tanpa query --}}
                <button
                  class="btn-fav {{ $isFav ? 'liked' : '' }}"
                  data-kost="{{ $kost->id_kost }}"
                  onclick="event.preventDefault(); toggleFav(this)"
                  title="{{ $isFav ? 'Hapus dari favorit' : 'Tambah ke favorit' }}"
                >
                  <i class="bi bi-heart{{ $isFav ? '-fill' : '' }}" style="color:{{ $isFav ? '#e8401c' : '#bbb' }};"></i>
                </button>
              </div>

              {{-- Body --}}
              <div class="kost-body" style="flex:1;display:flex;flex-direction:column;">
                <div style="display:flex;align-items:center;gap:.5rem;flex-wrap:wrap;margin-bottom:.4rem;">
                  <span style="background:rgba(15,25,40,.08);color:#374151;font-size:.72rem;font-weight:700;padding:.18rem .55rem;border-radius:.4rem;">
                    {{ $kost->tipe_kost ?? 'Campur' }}
                  </span>
                  @if($rating > 0)
                  <span style="font-size:.72rem;font-weight:700;color:var(--kf-dark);">
                    ⭐ {{ number_format($rating, 1) }}
                    <span style="color:var(--kf-muted);font-weight:400;">({{ $jumlahReview }})</span>
                  </span>
                  @endif
                  @if($sisaKamar > 0)
                  <span style="color:#e4572e;font-size:.72rem;font-weight:700;">Sisa {{ $sisaKamar }} kamar</span>
                  @else
                  <span style="color:#991b1b;font-size:.72rem;font-weight:700;">Penuh</span>
                  @endif
                </div>

                <div class="kost-name">{{ $kost->nama_kost }}</div>
                <div class="kost-loc">
                  <i class="bi bi-geo-alt" style="font-size:.7rem;color:var(--kf-primary);"></i>
                  {{ $kost->alamat ?? $kost->kota }}
                </div>
                @if($fasilitas->count() > 0)
                <div class="kost-fas">{{ $fasilitas->implode(' · ') }}</div>
                @endif

                <div style="margin-top:auto;padding-top:.5rem;">
                  <div class="kost-price-label">Mulai dari</div>
                  @if($hargaBulanan)
                  <div class="kost-price">Rp {{ number_format($hargaBulanan, 0, ',', '.') }} <span>/bulan</span></div>
                  @endif
                  @if($hargaHarian)
                  <div class="kost-price" style="font-size:.92rem;color:#f59e0b;">Rp {{ number_format($hargaHarian, 0, ',', '.') }} <span style="color:#9ca3af;">/hari</span></div>
                  @endif
                  @if(!$hargaBulanan && !$hargaHarian)
                  <div class="kost-price">Rp {{ number_format($kost->harga_mulai ?? 0, 0, ',', '.') }} <span>/bulan</span></div>
                  @endif
                </div>
              </div>

            </div>
          </a>
        </div>
        @empty
        <div class="p-4 text-muted" style="font-size:.88rem;">Belum ada kost tersedia saat ini.</div>
        @endforelse
      </div>
    </div>
  </section>

  {{-- ══════════════ OWNER BANNER ══════════════ --}}
  <section class="owner-section section-space">
    <div class="container reveal">
      <div class="owner-banner">
        <div class="owner-content">
          <div class="owner-chip"><i class="bi bi-building"></i> Untuk Pemilik Kost</div>
          <h3 class="owner-title">Daftarkan Kost Anda &amp; Jangkau Lebih Banyak Calon Penghuni</h3>
          <p class="owner-sub">Tampilkan properti Anda secara lebih profesional dan bantu pencari kost menemukan tempat tinggal yang tepat.</p>
          <a href="{{ route('owner.landing') }}" class="btn-owner">Pelajari Lebih Lanjut <i class="bi bi-arrow-right-short" style="font-size:1.2rem;"></i></a>
        </div>
      </div>
    </div>
  </section>

  {{-- ══════════════ FITUR SECTION ══════════════ --}}
  <section class="fitur-section section-space">
    <div class="container fitur-inner">
      <div class="fitur-layout reveal">
        <div class="fitur-desc-box">
          <div class="fitur-platform-badge"><i class="bi bi-stars"></i> Platform KostFinder</div>
          <h3 class="fitur-main-title">Kenapa Cari Kost <span>Lebih Gampang</span> di Sini?</h3>
          <p class="fitur-main-desc">KostFinder dirancang khusus untuk pencari kost di Jawa Timur. Semua informasi tersaji lengkap — harga, fasilitas, foto, dan lokasi — di satu tempat, tanpa perlu tanya sana-sini.</p>
          <button type="button" class="fitur-toggle-btn" id="fiturToggleBtn" onclick="toggleSemuaFitur()">
            <i class="bi bi-grid-3x3-gap ft-icon"></i>
            Lihat Semua Fitur
            <i class="bi bi-chevron-down ft-icon"></i>
          </button>
        </div>
        <div>
          <div class="fitur-cards-wrap" id="fiturList">
            <div class="fitur-cards-grid">
              @foreach([
                ['icon'=>'bi bi-search',      'cls'=>'fci1','title'=>'Pencarian Kost',          'desc'=>'Cari kost berdasarkan nama daerah, kampus, atau nama jalan di seluruh Jawa Timur dengan cepat.'],
                ['icon'=>'bi bi-sliders',     'cls'=>'fci2','title'=>'Filter Canggih',           'desc'=>'Filter berdasarkan fasilitas, tipe kost (putra/putri/campur), harga, dan durasi sewa harian atau bulanan.'],
                ['icon'=>'bi bi-card-list',   'cls'=>'fci3','title'=>'Info Lengkap & Transparan','desc'=>'Setiap listing tampil lengkap — harga, foto, fasilitas, lokasi, dan ketersediaan kamar secara real-time.'],
                ['icon'=>'bi bi-heart',       'cls'=>'fci4','title'=>'Simpan Favorit',           'desc'=>'Simpan kost yang menarik ke daftar favorit dan bandingkan kapan saja sebelum kamu memutuskan.'],
                ['icon'=>'bi bi-telephone',   'cls'=>'fci5','title'=>'Hubungi Pemilik Langsung', 'desc'=>'Lihat kontak pemilik kost langsung di halaman detail dan jadwalkan survey tanpa perantara.'],
                ['icon'=>'bi bi-building-add','cls'=>'fci6','title'=>'Daftarkan Kost Milikmu',  'desc'=>'Pemilik kost bisa daftar gratis dan tampilkan listing secara profesional agar lebih mudah ditemukan.'],
              ] as $item)
              <div class="fitur-card">
                <div class="fitur-card-icon {{ $item['cls'] }}"><i class="{{ $item['icon'] }}"></i></div>
                <div>
                  <div class="fitur-card-title">{{ $item['title'] }}</div>
                  <p class="fitur-card-desc">{{ $item['desc'] }}</p>
                </div>
              </div>
              @endforeach
            </div>
          </div>
          <div id="fiturPlaceholder" style="padding:1.4rem 0;color:#4a5f76;font-size:.88rem;line-height:1.8;">
            Klik tombol <strong style="color:#7a9ab8;">Lihat Semua Fitur</strong> untuk melihat apa saja yang bisa kamu manfaatkan di KostFinder. 🚀
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- ══════════════ TESTIMONI ══════════════ --}}
  <section class="testimonial-section section-space">
    <div class="container">
      <div class="text-center mb-5 reveal">
        <h3 class="section-title" style="font-size:clamp(1.7rem,3vw,2.4rem);">Apa Kata Mereka Tentang <span style="color:var(--kf-primary)">KostFinder</span></h3>
        <p class="section-sub mx-auto" style="max-width:600px;">Pengalaman pencari kost yang ingin proses cari tempat tinggal jadi lebih cepat, nyaman, dan nggak bikin pusing.</p>
      </div>
      <div class="row g-3">
        @foreach([
          ['name'=>'Nabila','role'=>'Mahasiswi','quote'=>'Aku jadi lebih gampang cari kost dekat kampus tanpa harus scroll grup terus. Tampilannya enak dan informasinya lebih jelas.'],
          ['name'=>'Fajar', 'role'=>'Karyawan', 'quote'=>'Enaknya bisa lihat beberapa pilihan kost sekaligus. Jadi lebih gampang bandingin harga dan fasilitas sebelum survey.'],
          ['name'=>'Rina',  'role'=>'Perantau', 'quote'=>'Biasanya nyari kost tuh capek dan bingung. Di sini lebih praktis, jadi nggak buang banyak waktu buat cari satu-satu.'],
        ] as $i => $t)
        <div class="col-12 col-md-6 col-lg-4 reveal reveal-delay-{{ ($i % 3) + 1 }}">
          <div class="testimonial-card">
            <div class="testimonial-stars">★★★★★</div>
            <p class="testimonial-quote">"{{ $t['quote'] }}"</p>
            <div class="testimonial-user">
              <div class="testimonial-avatar">{{ strtoupper(substr($t['name'], 0, 1)) }}</div>
              <div>
                <p class="testimonial-name">{{ $t['name'] }}</p>
                <p class="testimonial-role">{{ $t['role'] }}</p>
              </div>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- ══════════════ CTA ══════════════ --}}
  <section class="final-cta-section section-space">
    <div class="container reveal">
      <div class="final-cta-box">
        <h3 class="final-cta-title">Siap Menemukan Kost yang Cocok?</h3>
        <p class="final-cta-sub">Jelajahi berbagai pilihan kost dengan informasi yang lebih jelas, tampilan yang nyaman, dan proses pencarian yang lebih praktis.</p>
        <a href="{{ route('home') }}" class="btn-final-cta">Cari Kost Sekarang <i class="bi bi-arrow-right-short" style="font-size:1.2rem;"></i></a>
      </div>
    </div>
  </section>

  {{-- ══════════════ MODAL FILTER ══════════════ --}}
  <div class="modal fade modal-filter" id="modalFilter" tabindex="-1" aria-labelledby="modalFilterLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:520px;">
      <div class="modal-content">
        <div class="modal-filter-header">
          <div>
            <p class="modal-filter-title" id="modalFilterLabel">🔍 Filter Pencarian Kost</p>
            <p class="modal-filter-sub">Sesuaikan kost dengan kebutuhanmu</p>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-filter-body">
          <div class="filter-group">
            <div class="filter-group-label">🏠 Tipe Kost</div>
            <div class="d-flex gap-2 flex-wrap">
              @foreach(['Semua'=>'','Putra'=>'Putra','Putri'=>'Putri','Campur'=>'Campur'] as $label => $val)
              <div class="f-chip {{ $label==='Semua' ? 'aktif' : '' }}" data-group="tipe" data-val="{{ $val }}" onclick="pilihChip(this,'tipe')">
                @if($label==='Putra') 👨 @elseif($label==='Putri') 👩 @elseif($label==='Campur') 👥 @endif {{ $label }}
              </div>
              @endforeach
            </div>
          </div>
          <div class="filter-group">
            <div class="filter-group-label">💰 Harga per Bulan</div>
            <div class="d-flex gap-2 flex-wrap">
              @foreach(['Semua'=>'_','< 500rb'=>'0_500000','500rb – 1jt'=>'500000_1000000','1jt – 2jt'=>'1000000_2000000','> 2jt'=>'2000000_'] as $label => $val)
              <div class="f-chip {{ $label==='Semua' ? 'aktif' : '' }}" data-group="harga" data-val="{{ $val }}" onclick="pilihChip(this,'harga')">{{ $label }}</div>
              @endforeach
            </div>
          </div>
          <div class="filter-group">
            <div class="filter-group-label">⏱️ Durasi Sewa</div>
            <div class="d-flex gap-2 flex-wrap">
              @foreach(['Semua'=>'','Harian'=>'harian','Bulanan'=>'bulanan'] as $label => $val)
              <div class="f-chip {{ $label==='Semua' ? 'aktif' : '' }}" data-group="durasi" data-val="{{ $val }}" onclick="pilihChip(this,'durasi')">{{ $label }}</div>
              @endforeach
            </div>
          </div>
          <div class="filter-group" style="margin-bottom:0;">
            <div class="filter-group-label">✅ Fasilitas</div>
            <div class="d-flex gap-2 flex-wrap">
              @foreach([
                ['emoji'=>'📶','label'=>'WiFi'],['emoji'=>'❄️','label'=>'AC'],
                ['emoji'=>'🚿','label'=>'Kamar Mandi Dalam'],['emoji'=>'🍳','label'=>'Dapur'],
                ['emoji'=>'👕','label'=>'Laundry'],['emoji'=>'🏍️','label'=>'Parkir Motor'],
                ['emoji'=>'🚗','label'=>'Parkir Mobil'],['emoji'=>'📷','label'=>'CCTV'],
                ['emoji'=>'💂','label'=>'Security 24 Jam'],['emoji'=>'🛏️','label'=>'Kasur'],
                ['emoji'=>'🗄️','label'=>'Lemari'],['emoji'=>'📚','label'=>'Meja Belajar'],
              ] as $fas)
              <div class="f-chip" data-group="fasilitas" data-val="{{ $fas['label'] }}" onclick="pilihChipFas(this)">
                {{ $fas['emoji'] }} {{ $fas['label'] }}
              </div>
              @endforeach
            </div>
          </div>
        </div>
        <div class="modal-filter-footer">
          <button type="button" class="btn-reset-filter" onclick="resetFilter()">↺ Reset</button>
          <button type="button" class="btn-apply-filter" onclick="terapkanFilter()">🔍 Terapkan Filter</button>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection

@section('scripts')
<script>
(function () {
  // ── Hero background ──
  setTimeout(() => document.getElementById('heroBg')?.classList.add('loaded'), 200);

  // ── Reveal on scroll ──
  const observer = new IntersectionObserver(entries => {
    entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); observer.unobserve(e.target); } });
  }, { threshold: 0.1 });
  document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

  // ── Promo slider ──
  const promoTrack = document.getElementById('promoTrack');
  if (promoTrack) {
    const slide = () => Math.max(300, promoTrack.clientWidth * 0.72);
    document.getElementById('promoPrev')?.addEventListener('click', () => promoTrack.scrollBy({ left: -slide(), behavior: 'smooth' }));
    document.getElementById('promoNext')?.addEventListener('click', () => promoTrack.scrollBy({ left: slide(), behavior: 'smooth' }));
    let down = false, sx, sl;
    promoTrack.addEventListener('mousedown', e => { down=true; sx=e.pageX-promoTrack.offsetLeft; sl=promoTrack.scrollLeft; promoTrack.style.cursor='grabbing'; });
    promoTrack.addEventListener('mouseleave', () => { down=false; promoTrack.style.cursor='grab'; });
    promoTrack.addEventListener('mouseup',    () => { down=false; promoTrack.style.cursor='grab'; });
    promoTrack.addEventListener('mousemove',  e  => { if(!down) return; e.preventDefault(); promoTrack.scrollLeft = sl-(e.pageX-promoTrack.offsetLeft-sx); });
  }

  // ── Reco slider ──
  const recoTrack = document.getElementById('recoTrack');
  if (recoTrack) {
    const slide = () => Math.max(270, recoTrack.clientWidth * 0.8);
    document.getElementById('recoPrev')?.addEventListener('click', () => recoTrack.scrollBy({ left: -slide(), behavior: 'smooth' }));
    document.getElementById('recoNext')?.addEventListener('click', () => recoTrack.scrollBy({ left: slide(), behavior: 'smooth' }));
  }

  // ── Navbar search toggle ──
  const hero = document.querySelector('.hero');
  const navbarSearch = document.getElementById('navbarSearch');
  if (hero && navbarSearch) {
    window.addEventListener('scroll', () => {
      navbarSearch.classList.toggle('d-none', hero.getBoundingClientRect().bottom >= 70);
    });
  }
})();

/* ══ HERO DROPDOWN ══ */
function showHeroDropdown() {
  document.getElementById('heroDropdown').classList.remove('d-none');
}
function setHeroSearch(val) {
  document.getElementById('heroSearchInput').value = val;
  document.getElementById('heroDropdown').classList.add('d-none');
  document.getElementById('heroSearchInput').focus();
}
function switchHeroTab(tab, el) {
  const daerah = document.getElementById('heroTabDaerah');
  const kampus = document.getElementById('heroTabKampus');
  if (tab === 'daerah') {
    daerah.classList.remove('d-none'); daerah.classList.add('d-flex');
    kampus.classList.add('d-none');   kampus.classList.remove('d-flex');
  } else {
    kampus.classList.remove('d-none'); kampus.classList.add('d-flex');
    daerah.classList.add('d-none');    daerah.classList.remove('d-flex');
  }
  document.querySelectorAll('#heroDropdown .btn-link').forEach(btn => {
    btn.style.color = '#888'; btn.style.borderBottom = 'none';
    btn.classList.remove('fw-bold'); btn.classList.add('fw-medium');
  });
  el.style.color = 'var(--kf-primary)'; el.style.borderBottom = '2px solid var(--kf-primary)';
  el.classList.remove('fw-medium'); el.classList.add('fw-bold');
}
document.addEventListener('click', e => {
  const wrapper = document.getElementById('searchWrapper');
  if (wrapper && !wrapper.contains(e.target)) {
    document.getElementById('heroDropdown')?.classList.add('d-none');
  }
});
function doSearch() {
  const q = document.getElementById('heroSearchInput').value.trim();
  window.location.href = '{{ route("home") }}' + (q ? '?q=' + encodeURIComponent(q) : '');
}
document.getElementById('heroSearchInput')?.addEventListener('keydown', e => {
  if (e.key === 'Enter') doSearch();
});

/* ══ FILTER MODAL ══ */
function showFilterModal() { new bootstrap.Modal(document.getElementById('modalFilter')).show(); }
function pilihChip(el, grup) {
  document.querySelectorAll(`.f-chip[data-group="${grup}"]`).forEach(c => c.classList.remove('aktif'));
  el.classList.add('aktif');
}
function pilihChipFas(el) { el.classList.toggle('aktif'); }
function resetFilter() {
  ['tipe','harga','durasi'].forEach(grup => {
    document.querySelectorAll(`.f-chip[data-group="${grup}"]`).forEach((c, i) => c.classList.toggle('aktif', i === 0));
  });
  document.querySelectorAll('.f-chip[data-group="fasilitas"]').forEach(c => c.classList.remove('aktif'));
}
function terapkanFilter() {
  const params = new URLSearchParams();
  const q = document.getElementById('heroSearchInput')?.value.trim();
  if (q) params.set('q', q);
  const tipe = document.querySelector('.f-chip[data-group="tipe"].aktif')?.dataset.val;
  if (tipe) params.set('type', tipe);
  const harga = document.querySelector('.f-chip[data-group="harga"].aktif')?.dataset.val;
  if (harga && harga !== '_') {
    const [min, max] = harga.split('_');
    if (min) params.set('harga_min', min);
    if (max) params.set('max_price', max);
  }
  const durasi = document.querySelector('.f-chip[data-group="durasi"].aktif')?.dataset.val;
  if (durasi) params.set('durasi', durasi);
  document.querySelectorAll('.f-chip[data-group="fasilitas"].aktif').forEach(c => {
    params.append('facilities', c.dataset.val);
  });
  bootstrap.Modal.getInstance(document.getElementById('modalFilter'))?.hide();
  window.location.href = '{{ route("home") }}?' + params.toString();
}

/* ══ FITUR TOGGLE ══ */
function toggleSemuaFitur() {
  const btn         = document.getElementById('fiturToggleBtn');
  const list        = document.getElementById('fiturList');
  const placeholder = document.getElementById('fiturPlaceholder');
  const isOpen      = list.classList.contains('open');
  list.classList.toggle('open', !isOpen);
  btn.classList.toggle('open', !isOpen);
  if (placeholder) placeholder.style.display = isOpen ? '' : 'none';
}

/* ══ FAVORIT ══ */
function toggleFav(btn) {
  const kostId = btn.dataset.kost;
  const icon   = btn.querySelector('i');
  btn.classList.add('pop');
  setTimeout(() => btn.classList.remove('pop'), 300);

  @auth
  fetch('{{ route("user.favorit.toggle") }}', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
    body: JSON.stringify({ kost_id: kostId })
  })
  .then(r => r.json())
  .then(data => {
    if (data.status === 'added') {
      icon.className = 'bi bi-heart-fill'; icon.style.color = '#e8401c';
      btn.classList.add('liked'); btn.title = 'Hapus dari favorit';
    } else if (data.status === 'removed') {
      icon.className = 'bi bi-heart'; icon.style.color = '#bbb';
      btn.classList.remove('liked'); btn.title = 'Tambah ke favorit';
    }
  })
  .catch(err => console.error('Favorit error:', err));
  @else
  window.location.href = '{{ route("login") }}';
  @endauth
}
</script>
@endsection