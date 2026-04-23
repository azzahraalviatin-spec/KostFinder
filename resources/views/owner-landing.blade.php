<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftarkan Kost Anda - KostFinder</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cabinet+Grotesk:wght@400;500;700;800;900&family=Fraunces:ital,opsz,wght@0,9..144,600;0,9..144,700;1,9..144,500&display=swap" rel="stylesheet">

    <style>
    /* ═══════════════════════════════════════
       ROOT & RESET
    ═══════════════════════════════════════ */
    :root {
        --g:   #d4621a;
        --g2:  #b8521a;
        --g3:  #f0874a;
        --or:  #f06432;
        --ink: #111b27;
        --ink2: #2d3f52;
        --mu:  #6b7d92;
        --soft:#f4f7fa;
        --line:#e2e9f0;
        --white:#ffffff;
        --r: .75rem;
        --r2: 1.25rem;
        --r3: 1.75rem;
    }
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html { scroll-behavior: smooth; font-size: 16px; }
    body {
        font-family: 'Cabinet Grotesk', sans-serif;
        color: var(--ink);
        background: #fff;
        overflow-x: hidden;
        -webkit-font-smoothing: antialiased;
    }
    .serif { font-family: 'Fraunces', serif; }
    .wrap { width: min(1140px, calc(100% - 40px)); margin: 0 auto; }
    .sec { padding: 96px 0; }
    img { display: block; max-width: 100%; }
    a { text-decoration: none; }

    /* ═══════════════════════════════════════
       TOPBAR
    ═══════════════════════════════════════ */
    .topbar {
        position: sticky; top: 0; z-index: 200;
        background: rgba(255,255,255,.9);
        backdrop-filter: blur(18px);
        border-bottom: 1px solid rgba(226,233,240,.8);
    }
    .topbar-in {
        height: 72px;
        display: flex; align-items: center; justify-content: space-between; gap: 16px;
    }
    .brand {
        display: flex; align-items: center; gap: 10px;
        color: var(--ink);
    }
    .brand-mark {
        width: 38px; height: 38px; border-radius: 11px;
        background: linear-gradient(135deg, var(--g3), var(--g2));
        display: flex; align-items: center; justify-content: center;
        color: #fff; font-size: 1rem;
        box-shadow: 0 8px 20px rgba(212,98,26,.25);
    }
    .brand-name {
        font-family: 'Fraunces', serif;
        font-size: 1.6rem; font-weight: 700;
        color: var(--g); letter-spacing: -.03em;
    }
    .topbar-btn {
        display: inline-flex; align-items: center; gap: 7px;
        height: 42px; padding: 0 18px; border-radius: 10px;
        background: linear-gradient(135deg, var(--g3), var(--g));
        color: #fff; font-weight: 800; font-size: .9rem;
        box-shadow: 0 6px 18px rgba(212,98,26,.28);
        transition: transform .2s, box-shadow .2s;
    }
    .topbar-btn:hover { transform: translateY(-1px); box-shadow: 0 10px 24px rgba(212,98,26,.35); color: #fff; }

    /* ═══════════════════════════════════════
       HERO
    ═══════════════════════════════════════ */
    .hero {
        position: relative; overflow: hidden;
        padding: 25px 0 55px;
        background: #fff;
    }
    /* decorative blobs */
    .hero::before {
        content: '';
        position: absolute; inset: 0; pointer-events: none;
        background:
            radial-gradient(ellipse 55% 50% at 5% 10%,  rgba(212,98,26,.09), transparent 55%),
            radial-gradient(ellipse 45% 40% at 95% 5%,  rgba(240,100,50,.07), transparent 50%),
            radial-gradient(ellipse 35% 60% at 80% 95%, rgba(212,98,26,.06), transparent 55%);
    }
    /* noise texture */
    .hero::after {
        content: '';
        position: absolute; inset: 0; pointer-events: none; opacity: .025;
        background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 512 512' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.8' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
    }
    .hero-grid {
        position: relative; z-index: 2;
        display: grid; grid-template-columns: 1fr 1fr; gap: 56px; align-items: center;
    }
    .hero-kicker {
        display: inline-flex; align-items: center; gap: .5rem;
        padding: .35rem .9rem; border-radius: 999px;
        background: rgba(212,98,26,.1); border: 1px solid rgba(212,98,26,.2);
        color: var(--g); font-size: .78rem; font-weight: 800;
        letter-spacing: .07em; text-transform: uppercase; margin-bottom: 1.2rem;
    }
    .hero-kicker i { font-size: .85rem; }
    .hero-h1 {
        font-size: clamp(2.4rem, 4.5vw, 4rem);
        line-height: 1.1; letter-spacing: -.04em;
        color: var(--ink); margin-bottom: 1.1rem;
    }
    .hero-h1 em { color: var(--g); font-style: italic; }
    .hero-sub {
        font-size: 1.05rem; line-height: 1.8; color: var(--mu);
        max-width: 480px; margin-bottom: 2rem;
    }
    .hero-actions { display: flex; flex-wrap: wrap; gap: 12px; }
    .btn-primary {
        display: inline-flex; align-items: center; gap: 8px;
        height: 50px; padding: 0 22px; border-radius: 12px;
        background: linear-gradient(135deg, var(--g3), var(--g2));
        color: #fff; font-weight: 800; font-size: .95rem;
        box-shadow: 0 10px 28px rgba(212,98,26,.28);
        transition: transform .2s, box-shadow .2s;
    }
    .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 16px 36px rgba(212,98,26,.35); color: #fff; }
    .btn-ghost {
        display: inline-flex; align-items: center; gap: 8px;
        height: 50px; padding: 0 22px; border-radius: 12px;
        border: 1.5px solid var(--line); background: #fff;
        color: var(--ink2); font-weight: 700; font-size: .95rem;
        transition: border-color .2s, background .2s;
    }
    .btn-ghost:hover { border-color: #b0c4d4; background: var(--soft); color: var(--ink); }

    /* visual side */
    .hero-visual { position: relative; height: 500px; }
    .hero-img {
        position: absolute; right: auto; left: 0; top: 0;
        width: 100%; height: 100%; border-radius: 24px; overflow: hidden;
        box-shadow: 0 40px 80px rgba(17,27,39,.16);
    }
    .hero-img img { width: 100%; height: 100%; object-fit: cover; }
    .hero-img-empty {
        width: 100%; height: 100%;
        background: linear-gradient(135deg, #fde8d8, #fff3ed);
        display: flex; align-items: center; justify-content: center;
        font-size: 5rem;
    }

    /* floating cards */
    .flt {
        position: absolute; z-index: 5;
        background: rgba(255,255,255,.96);
        border: 1px solid rgba(255,255,255,.85);
        border-radius: 18px;
        box-shadow: 0 20px 44px rgba(17,27,39,.14);
        backdrop-filter: blur(12px);
    }
    .flt.stat {
        left: -24px; bottom: 60px;
        padding: 16px 20px; min-width: 175px;
    }
    .flt-label { font-size: .72rem; font-weight: 700; color: var(--mu); margin-bottom: 4px; }
    .flt-val { font-size: 2rem; font-weight: 900; color: var(--ink); line-height: 1; }
    .flt-badge {
        display: inline-flex; align-items: center; gap: 4px;
        margin-top: 6px; font-size: .72rem; font-weight: 800;
        color: var(--g); background: rgba(212,98,26,.1);
        padding: 3px 8px; border-radius: 999px;
    }
    .mini-bars {
        display: flex; align-items: flex-end; gap: 5px; height: 44px; margin-top: 10px;
    }
    .mini-bars span {
        flex: 1; border-radius: 4px 4px 0 0;
        background: linear-gradient(180deg, var(--g3), var(--g));
        transition: height .3s;
    }
    .flt.penyewa {
        right: -10px; top: 40px;
        padding: 14px 18px; min-width: 185px;
    }
    .flt-row { display: flex; align-items: center; gap: 8px; margin-bottom: 8px; }
    .flt-dot { width: 9px; height: 9px; border-radius: 50%; background: var(--g3); flex-shrink: 0; }
    .flt-penyewa-text { font-size: .85rem; font-weight: 700; color: var(--ink2); line-height: 1.45; }
    .flt-prog { height: 7px; border-radius: 999px; background: #e6eff6; overflow: hidden; margin-top: 4px; }
    .flt-prog span { display: block; width: 74%; height: 100%; background: linear-gradient(90deg, var(--g), var(--g3)); }

    /* ═══════════════════════════════════════
       STATS STRIP
    ═══════════════════════════════════════ */
    .stats-strip {
        background: linear-gradient(135deg, var(--g2), var(--g));
        padding: 36px 0;
    }
    .stats-inner {
        display: flex; justify-content: space-around; align-items: center;
        flex-wrap: wrap; gap: 28px;
    }
    .stat-it { text-align: center; }
    .stat-num {
        font-family: 'Fraunces', serif;
        font-size: 2.4rem; font-weight: 700; color: #fff; line-height: 1;
    }
    .stat-lbl { font-size: .82rem; color: rgba(255,255,255,.78); font-weight: 600; margin-top: 5px; }
    .stat-div { width: 1px; height: 40px; background: rgba(255,255,255,.2); }

    /* ═══════════════════════════════════════
       KEUNGGULAN
    ═══════════════════════════════════════ */
    .adv-sec { background: var(--soft); }
    .kicker {
        font-size: .76rem; font-weight: 800; letter-spacing: .09em;
        text-transform: uppercase; color: var(--g); margin-bottom: 12px;
        text-align: center;
    }
    .sec-h {
        font-size: clamp(1.9rem, 3.2vw, 3rem);
        line-height: 1.12; letter-spacing: -.04em; margin-bottom: 12px;
        text-align: center;
    }
    .sec-sub { color: var(--mu); font-size: 1rem; line-height: 1.85; text-align: center; }
    .sec-sub.capped { max-width: 740px; margin-inline: auto; }

    .adv-grid {
        display: grid; grid-template-columns: repeat(4, 1fr);
        gap: 18px; margin-top: 48px;
    }
    .adv-card {
        background: #fff; border-radius: 22px;
        border: 1px solid var(--line);
        padding: 22px;
        box-shadow: 0 8px 28px rgba(17,27,39,.05);
        transition: transform .25s, box-shadow .25s;
        overflow: hidden;
    }
    .adv-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 24px 52px rgba(17,27,39,.12);
    }

    .adv-num { display: none; }

    .adv-title {
        font-size: 1rem; font-weight: 800;
        line-height: 1.45; margin-bottom: 8px;
        display: flex; align-items: center; gap: 6px;
    }

    .adv-title span {
        font-size: .82rem; font-weight: 900;
    }
    .adv-illus {
        height: 180px; border-radius: 16px; margin-bottom: 20px;
        overflow: hidden; position: relative;
        background: linear-gradient(135deg, #fff3ed, #fde8d8);
    }

    .adv-illus img {
        width: 100%; height: 100%;
        object-fit: cover;
        border-radius: 16px;
        display: block;
        transition: transform .3s ease;
    }

    .adv-card:hover .adv-illus img {
        transform: scale(1.05);
    }
    .adv-num {
        font-size: .74rem; font-weight: 900; letter-spacing: .1em;
        color: var(--g); margin-bottom: 10px;
    }
    .adv-title { font-size: 1rem; font-weight: 800; line-height: 1.45; margin-bottom: 8px; }
    .adv-desc { color: var(--mu); font-size: .88rem; line-height: 1.75; }

    /* ═══════════════════════════════════════
       SPLIT SECTION - NEW STYLE
    ═══════════════════════════════════════ */
    .split-sec { background: var(--soft); }

    .split-header { margin-bottom: 40px; text-align: center; }

    .split-tabs {
        display: flex; gap: 10px;
        margin-top: 24px; flex-wrap: wrap;
        justify-content: center;
    }

    .split-tab {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 10px 22px; border-radius: 999px;
        border: 1.5px solid var(--line);
        background: #fff;
        color: var(--ink2); font-size: .9rem; font-weight: 700;
        cursor: pointer; transition: all .2s;
        font-family: 'Cabinet Grotesk', sans-serif;
    }

    .split-tab:hover { border-color: var(--g); color: var(--g); }

    .split-tab.active {
        background: var(--g); border-color: var(--g); color: #fff;
        box-shadow: 0 6px 18px rgba(212,98,26,.28);
    }

    .split-tab-body {
        background: #fff; border-radius: 24px;
        border: 1px solid var(--line); padding: 36px;
        box-shadow: 0 8px 32px rgba(17,27,39,.06);
    }

    .split-new-grid {
        display: grid; grid-template-columns: 1fr 1fr;
        gap: 32px; align-items: start;
    }

    @media (max-width: 768px) {
        .split-new-grid { grid-template-columns: 1fr; }
        .split-tab-body { padding: 20px; }
    }

    .feat-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
    .feat-card {
        border-radius: 16px; border: 1px solid var(--line);
        padding: 18px; background: var(--soft);
        transition: border-color .2s, background .2s;
    }
    .feat-card:hover { border-color: #f0c4a0; background: #fff7f2; }
    .feat-icon {
        width: 38px; height: 38px; border-radius: 10px;
        background: rgba(212,98,26,.12); color: var(--g);
        display: flex; align-items: center; justify-content: center;
        font-size: .95rem; margin-bottom: 10px;
    }
    .feat-title { font-size: .9rem; font-weight: 800; line-height: 1.4; margin-bottom: 5px; }
    .feat-desc { color: var(--mu); font-size: .82rem; line-height: 1.65; }

    /* ═══════════════════════════════════════
       TESTIMONIALS
    ═══════════════════════════════════════ */
    .quote-sec { background: linear-gradient(180deg, #f4f8fb 0%, #fff 100%); }
    .quote-grid {
        display: grid; grid-template-columns: repeat(3, 1fr);
        gap: 20px; margin-top: 48px;
    }
    .quote-card {
        background: #fff; border-radius: 22px;
        border: 1px solid var(--line); padding: 28px;
        box-shadow: 0 8px 28px rgba(17,27,39,.05);
        display: flex; flex-direction: column; justify-content: space-between;
        transition: transform .25s, box-shadow .25s;
    }
    .quote-card:hover { transform: translateY(-4px); box-shadow: 0 18px 44px rgba(17,27,39,.1); }
    .quote-stars { color: #f59e0b; font-size: 1rem; margin-bottom: 14px; letter-spacing: 2px; }
    .quote-text { color: #334155; font-size: .93rem; line-height: 1.85; margin-bottom: 20px; flex: 1; }
    .quote-author { display: flex; align-items: center; gap: 12px; }
    .quote-avatar {
        width: 44px; height: 44px; border-radius: 50%; flex-shrink: 0;
        background: linear-gradient(135deg, #fde8d8, #f0c4a0);
        display: flex; align-items: center; justify-content: center;
        font-weight: 800; font-size: 1rem; color: var(--g2);
    }
    .quote-name { font-size: .93rem; font-weight: 800; color: var(--ink); }
    .quote-role { font-size: .78rem; color: var(--mu); margin-top: 2px; }
    .hex-inner.hex-logo {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 1px;
    color: #fff;
    font-size: .72rem;
    font-weight: 900;
    text-align: center;
}
    /* ═══════════════════════════════════════
       FAQ
    ═══════════════════════════════════════ */
    .faq-sec { background: #fff; }
    .faq-layout { display: grid; grid-template-columns: .85fr 1.15fr; gap: 56px; align-items: start; }
    .faq-sticky { position: sticky; top: 88px; }

    .faq-list { display: flex; flex-direction: column; gap: 12px; }
    .faq-item {
        border-radius: 18px; border: 1px solid var(--line);
        background: #fff; overflow: hidden;
        box-shadow: 0 4px 16px rgba(17,27,39,.04);
        transition: box-shadow .2s;
    }
    .faq-item:hover { box-shadow: 0 8px 28px rgba(17,27,39,.08); }
    .faq-item.open { border-color: #f0c4a0; }
    .faq-trigger {
        width: 100%; display: flex; align-items: center; justify-content: space-between;
        gap: 12px; padding: 20px 22px; background: none; border: none;
        cursor: pointer; text-align: left;
    }
    .faq-q { font-size: .97rem; font-weight: 800; color: var(--ink); }
    .faq-chevron {
        width: 30px; height: 30px; border-radius: 50%; flex-shrink: 0;
        border: 1.5px solid var(--line); background: var(--soft);
        display: flex; align-items: center; justify-content: center;
        font-size: .75rem; color: var(--mu);
        transition: transform .3s, background .2s, border-color .2s;
    }
    .faq-item.open .faq-chevron {
        transform: rotate(180deg);
        background: var(--g); border-color: var(--g); color: #fff;
    }
    .faq-body {
        max-height: 0; overflow: hidden;
        transition: max-height .38s cubic-bezier(.4,0,.2,1);
    }
    .faq-item.open .faq-body { max-height: 300px; }
    .faq-a { padding: 0 22px 20px; color: var(--mu); font-size: .91rem; line-height: 1.85; }

    /* ═══════════════════════════════════════
       CTA FINAL
    ═══════════════════════════════════════ */
    .cta-sec { background: var(--soft); padding: 96px 0; }
    .cta-box {
        border-radius: 32px; padding: 64px 40px;
        text-align: center; color: #fff;
        position: relative; overflow: hidden;
        background:
            radial-gradient(circle at 15% 20%, rgba(240,135,74,.22), transparent 28%),
            radial-gradient(circle at 85% 80%, rgba(240,100,50,.18), transparent 28%),
            linear-gradient(145deg, #1e0e05, #3d1a08);
        box-shadow: 0 40px 80px rgba(17,27,39,.2);
    }
    .cta-box::before {
        content: '';
        position: absolute; inset: 0; pointer-events: none; opacity: .04;
        background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 512 512' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
    }
    .cta-inner { position: relative; z-index: 2; }
    .cta-kicker {
        display: inline-flex; align-items: center; gap: .4rem;
        padding: .3rem .85rem; border-radius: 999px;
        background: rgba(255,255,255,.1); border: 1px solid rgba(255,255,255,.18);
        color: rgba(255,255,255,.9); font-size: .75rem; font-weight: 800;
        letter-spacing: .07em; text-transform: uppercase; margin-bottom: 1.2rem;
    }
    .cta-h { font-size: clamp(2rem, 3.8vw, 3.4rem); line-height: 1.1; letter-spacing: -.04em; margin-bottom: .9rem; }
    .cta-p { max-width: 600px; margin: 0 auto 1.8rem; color: rgba(255,255,255,.75); font-size: 1rem; line-height: 1.85; }
    .cta-help { margin-top: 18px; color: rgba(255,255,255,.65); font-size: .88rem; }
    .cta-help a { color: rgba(255,255,255,.9); font-weight: 700; }

    /* ═══════════════════════════════════════
       FOOTER
    ═══════════════════════════════════════ */
    .footer { padding: 48px 0 36px; background: #fff; border-top: 1px solid var(--line); }
    .footer-grid {
        display: grid; grid-template-columns: 1.4fr .8fr .8fr 1fr;
        gap: 32px; padding-bottom: 32px; margin-bottom: 24px;
        border-bottom: 1px solid var(--line);
    }
    .foot-brand-name {
        font-family: 'Fraunces', serif;
        font-size: 1.5rem; font-weight: 700; color: var(--g);
        letter-spacing: -.03em; margin-bottom: 10px;
    }
    .foot-desc { color: var(--mu); font-size: .88rem; line-height: 1.85; }
    .foot-head {
        font-size: .74rem; font-weight: 900; letter-spacing: .09em;
        text-transform: uppercase; color: var(--ink2); margin-bottom: 14px;
    }
    .foot-links { display: flex; flex-direction: column; gap: 9px; }
    .foot-link { color: var(--mu); font-size: .9rem; transition: color .18s; }
    .foot-link:hover { color: var(--g); }
    .foot-contact { color: var(--mu); font-size: .9rem; line-height: 2; }
    .foot-copy {
        display: flex; justify-content: space-between; flex-wrap: wrap; gap: 8px;
        font-size: .82rem; color: #9baab8;
    }

    /* ═══════════════════════════════════════
       REVEAL ANIMATION
    ═══════════════════════════════════════ */
    .reveal { opacity: 0; transform: translateY(22px); transition: opacity .6s ease, transform .6s ease; }
    .reveal.vis { opacity: 1; transform: none; }
    .reveal-d1 { transition-delay: .1s; }
    .reveal-d2 { transition-delay: .2s; }
    .reveal-d3 { transition-delay: .3s; }

    /* ═══════════════════════════════════════
       RESPONSIVE
    ═══════════════════════════════════════ */
    @media (max-width: 1023px) {
        .hero-grid, .split-box, .faq-layout { grid-template-columns: 1fr; }
        .adv-grid { grid-template-columns: repeat(2, 1fr); }
        .quote-grid { grid-template-columns: repeat(2, 1fr); }
        .footer-grid { grid-template-columns: 1fr 1fr; }
        .hero-visual { height: 380px; margin-top: 12px; }
        .hero-img { right: auto; width: 100%; }
        .flt.stat { left: 8px; bottom: 8px; }
        .flt.penyewa { right: 8px; top: 8px; }
        .split-l { padding: 32px; }
        .split-r { padding: 32px; }
        .faq-sticky { position: static; }
    }
    @media (max-width: 640px) {
        .sec { padding: 64px 0; }
        .adv-grid { grid-template-columns: 1fr; }
        .quote-grid { grid-template-columns: 1fr; }
        .feat-grid { grid-template-columns: 1fr; }
        .footer-grid { grid-template-columns: 1fr; }
        .hero { padding: 56px 0 72px; }
        .cta-box { padding: 44px 20px; border-radius: 24px; }
        .stats-inner { gap: 18px; }
        .stat-div { display: none; }
    }
    .split-content {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        align-items: center;
    }

    .split-features {
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .feat-item {
        display: flex;
        gap: 12px;
        padding: 14px;
        border-radius: 14px;
        background: #f8fafc;
        border: 1px solid var(--line);
        transition: all .2s;
    }

    .feat-item:hover {
        background: #fff7f2;
        border-color: #f0c4a0;
    }

    .feat-item i {
        font-size: 1.2rem;
        color: var(--g);
    }

    .split-visual {
        position: relative;
        height: 320px;
    }

    .circle-bg {
        position: absolute;
        width: 260px;
        height: 260px;
        background: radial-gradient(circle, #fde8d8, transparent);
        border-radius: 50%;
        top: 30px;
        left: 50%;
        transform: translateX(-50%);
    }

    .phone-img {
        position: absolute;
        height: 300px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 2;
    }

    .card-float {
        position: absolute;
        bottom: 10px;
        left: 50%;
        transform: translateX(-50%);
        background: white;
        border-radius: 14px;
        padding: 10px 14px;
        box-shadow: 0 10px 25px rgba(0,0,0,.1);
        z-index: 3;
    }

    .small-text {
        font-size: 0.8rem;
        margin-bottom: 6px;
    }

    .btn-row {
        display: flex;
        gap: 6px;
    }

    .btn-red {
        background: #fee2e2;
        color: #dc2626;
        padding: 4px 10px;
        border-radius: 8px;
        font-size: 0.75rem;
    }

    .btn-green {
        background: #fff3ed;
        color: var(--g);
        padding: 4px 10px;
        border-radius: 8px;
        font-size: 0.75rem;
    }
    /* ═══════════════════════════════════════
       TAB LAYOUT (Split Section)
    ═══════════════════════════════════════ */
    .tab-content { animation: fadeIn .3s ease; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: none; } }

    .tab-layout {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        align-items: start;
        margin-top: 8px;
    }

    .tab-visual { }
    .tab-img-wrap {
        border-radius: 18px;
        overflow: hidden;
        border: 1px solid var(--line);
        background: linear-gradient(135deg, #fde8d8, #fff3ed);
        height: 260px;
    }
    .tab-img-wrap img {
        width: 100%; height: 100%; object-fit: cover;
        display: block;
    }
    .tab-img-empty {
        width: 100%; height: 100%;
        display: flex; flex-direction: column;
        align-items: center; justify-content: center;
        font-size: 3rem; color: var(--mu);
        gap: 8px;
    }
    .tab-img-empty span { font-size: .85rem; font-weight: 700; }

    @media (max-width: 768px) {
        .tab-layout { grid-template-columns: 1fr; }
    }

    /* ═══════════════════════════════════════
       TESTIMONI - HEXAGON STYLE
    ═══════════════════════════════════════ */
    .quote-sec {
        background: linear-gradient(160deg, #fff7f2 0%, #fff 60%);
    }

    .testi-wrap {
        display: grid;
        grid-template-columns: 1fr 1.1fr;
        gap: 48px;
        align-items: center;
    }

    /* Hexagon wrap */
    .testi-hex-wrap {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 380px;
    }

    .testi-hex-grid {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 12px;
    }

    .hex-row {
        display: flex;
        gap: 12px;
        justify-content: center;
    }

    .hex-item { display: flex; align-items: center; justify-content: center; }

    .hex-shape {
        width: 110px; height: 110px;
        clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
        display: flex; align-items: center; justify-content: center;
        transition: transform .3s;
    }
    .hex-shape:hover { transform: scale(1.06); }

    .hex-shape.gold {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        width: 130px; height: 130px;
    }
    .hex-shape.green {
        background: linear-gradient(135deg, var(--g3), var(--g));
    }
    .hex-shape.green-dark {
        background: linear-gradient(135deg, var(--g), var(--g2));
    }
    .hex-shape.gray {
        background: linear-gradient(135deg, #e2e9f0, #cbd5e1);
    }

    .hex-inner {
        color: #fff;
        font-weight: 900;
        font-size: 1.2rem;
        text-align: center;
        line-height: 1;
    }

    .hex-shape.gold .hex-inner { font-size: 1.4rem; }
    .hex-shape.gray .hex-inner { font-size: 1.4rem; }

    /* Kartu ulasan kanan */
    .testi-card-wrap {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .testi-card {
        background: #fff;
        border-radius: 24px;
        padding: 32px 36px;
        border: 1px solid var(--line);
        box-shadow: 0 20px 56px rgba(17,27,39,.09);
    }

    .testi-card-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 16px;
    }

    .testi-big-quote {
        font-size: 4rem;
        line-height: .8;
        color: var(--g);
        opacity: .3;
        font-weight: 900;
    }

    .testi-card-stars {
        color: #f59e0b;
        font-size: 1.3rem;
        letter-spacing: 2px;
    }

    .testi-card-text {
        font-size: 1.05rem;
        line-height: 1.9;
        color: var(--ink2);
        margin-bottom: 24px;
        min-height: 90px;
        transition: opacity .35s ease, transform .35s ease;
    }

    .testi-card-text.fade {
        opacity: 0;
        transform: translateY(8px);
    }

    .testi-card-author {
        display: flex;
        align-items: center;
        gap: 14px;
        padding-top: 20px;
        border-top: 1px solid var(--line);
    }

    .testi-card-avatar {
        width: 48px; height: 48px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--g3), var(--g2));
        color: #fff;
        font-weight: 900; font-size: .9rem;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        border: 3px solid #fff;
        box-shadow: 0 4px 12px rgba(212,98,26,.25);
        transition: opacity .3s;
    }

    .testi-card-name {
        font-size: 1rem;
        font-weight: 800;
        color: var(--ink);
    }

    .testi-card-loc {
        display: flex;
        align-items: center;
        gap: 4px;
        font-size: .8rem;
        color: var(--mu);
        margin-top: 2px;
    }

    /* Progress bar */
    .testi-progress-wrap {
        height: 3px;
        background: var(--line);
        border-radius: 999px;
        overflow: hidden;
    }
    .testi-progress-bar {
        height: 100%;
        border-radius: 999px;
        background: linear-gradient(90deg, var(--g3), var(--g));
        width: 0%;
        transition: width linear;
    }
    .hex-shape img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
    display: block;
}
    /* Dots navigasi */
    .testi-dots-nav {
        display: flex;
        gap: 8px;
        justify-content: center;
    }

    .testi-dot-nav {
        width: 10px; height: 10px;
        border-radius: 50%;
        background: var(--line);
        cursor: pointer;
        transition: all .25s;
    }

    .testi-dot-nav.active {
        background: var(--g);
        width: 28px;
        border-radius: 999px;
    }

    @media (max-width: 900px) {
        .testi-wrap { grid-template-columns: 1fr; }
        .testi-hex-wrap { min-height: 280px; }
        .hex-shape { width: 80px; height: 80px; }
        .hex-shape.gold { width: 100px; height: 100px; }
    }
    /* ═══ FEAT ITEM CLICKABLE ═══ */
    .feat-item-click {
        cursor: pointer;
        position: relative;
    }

    .feat-item-click.active-feat {
        background: #fff7f2;
        border-color: var(--g);
        box-shadow: 0 4px 16px rgba(212,98,26,.12);
    }

    .feat-item-click.active-feat i:first-child {
        color: var(--g);
    }

    .feat-arrow {
        margin-left: auto;
        flex-shrink: 0;
        color: var(--mu);
        font-size: .8rem;
        opacity: 0;
        transform: translateX(-4px);
        transition: all .2s;
    }

    .feat-item-click.active-feat .feat-arrow {
        opacity: 1;
        color: var(--g);
        transform: none;
    }

    /* Visual kanan */
    .feat-visual-wrap {
        border-radius: 18px;
        overflow: hidden;
        border: 1px solid var(--line);
        background: linear-gradient(135deg, #fff7f2, #fff3ed);
        height: 480px;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .feat-visual {
        position: absolute;
        inset: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 28px;
        text-align: center;
        opacity: 0;
        transform: translateY(10px);
        transition: opacity .35s ease, transform .35s ease;
        pointer-events: none;
    }

    .feat-visual.active {
        opacity: 1;
        transform: none;
        pointer-events: auto;
    }

    .feat-visual-icon {
        font-size: 3rem;
        margin-bottom: 14px;
        filter: drop-shadow(0 4px 8px rgba(0,0,0,.1));
    }

    .feat-visual-title {
        font-size: 1rem;
        font-weight: 800;
        color: var(--ink);
        margin-bottom: 8px;
    }

    .feat-visual-desc {
        font-size: .85rem;
        color: var(--mu);
        line-height: 1.75;
        max-width: 220px;
    }
    .feat-visual img {
        width: auto;
        height: 95%;
        max-width: 95%;
        object-fit: contain;
        border-radius: 12px;
        display: block;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        filter: drop-shadow(0 8px 24px rgba(0,0,0,.13));
    }

    .feat-visual-fallback {
        flex-direction: column;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        text-align: center;
    }
    </style>
</head>
<body>

@php
    $ownerCtaUrl = auth()->check()
        ? (auth()->user()->role === 'owner' 
            ? route('owner.dashboard') 
            : route('register.owner'))
        : route('register.owner');
@endphp

{{-- ══ TOPBAR ══ --}}
<header class="topbar">
    <div class="wrap topbar-in">
        <a href="{{ route('home') }}" class="brand">
            <div class="brand-mark"><i class="bi bi-house-door-fill"></i></div>
            <div class="brand-name serif">KostFinder</div>
        </a>
        <a href="{{ $ownerCtaUrl }}" class="topbar-btn">
            <i class="bi bi-plus-circle"></i> Daftarkan Kos
        </a>
    </div>
</header>

{{-- ══ HERO ══ --}}
<section class="hero">
    <div class="wrap">
        <div class="hero-grid">
            {{-- kiri --}}
            <div class="reveal">
                <div class="hero-kicker"><i class="bi bi-building"></i> Untuk Pemilik Kost</div>
                <h1 class="hero-h1 serif">
                    Daftarkan Kost Anda &amp;<br>
                    <em>Jangkau Lebih Banyak</em><br>
                    Calon Penghuni
                </h1>
                <p class="hero-sub">
                    Tampilkan properti Anda secara lebih profesional dan bantu pencari kost menemukan tempat tinggal yang tepat — lebih cepat, lebih mudah.
                </p>
                <div class="hero-actions">
                    <a href="{{ $ownerCtaUrl }}" class="btn-primary">
                        Daftarkan Kos Sekarang <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>

            {{-- kanan: visual --}}
            <div class="hero-visual reveal reveal-d2">
                <div class="hero-img">
                    <img src="{{ asset('images/banner/owner-kost-banner2.png') }}" alt="Pemilik kost"
                         onerror="this.style.display='none';">
                    <div class="hero-img-empty" id="heroImgEmpty" style="display:none;">🏠</div>
                </div>

                {{-- float: laporan --}}
                <div class="flt stat">
                    <div class="flt-label">Laporan performa</div>
                    <div class="flt-val">80%</div>
                    <div class="flt-badge"><i class="bi bi-arrow-up-short"></i> Meningkat</div>
                    <div class="mini-bars">
                        <span style="height:20px;opacity:.5;"></span>
                        <span style="height:28px;opacity:.65;"></span>
                        <span style="height:24px;opacity:.75;"></span>
                        <span style="height:38px;opacity:.85;"></span>
                        <span style="height:44px;"></span>
                    </div>
                </div>

                {{-- float: penyewa --}}
                <div class="flt penyewa">
                    <div class="flt-row">
                        <div class="flt-dot"></div>
                        <div class="flt-label" style="margin:0;">Calon penyewa aktif</div>
                    </div>
                    <div class="flt-penyewa-text">Mudah & cepat temukan penyewa yang sesuai.</div>
                    <div class="flt-prog"><span></span></div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══ STATS STRIP ══ --}}
<div class="stats-strip">
    <div class="wrap">
        <div class="stats-inner">
            <div class="stat-it">
                <div class="stat-num serif">{{ $stats['total_kost'] }}+</div>
                <div class="stat-lbl">Listing Kost Aktif</div>
            </div>
            <div class="stat-div"></div>
            <div class="stat-it">
                <div class="stat-num serif">{{ $stats['total_owner'] }}</div>
                <div class="stat-lbl">Pemilik Kos Terdaftar</div>
            </div>
            <div class="stat-div"></div>
            <div class="stat-it">
                <div class="stat-num serif">{{ $stats['total_penyewa'] }}+</div>
                <div class="stat-lbl">Pencari Kost Aktif</div>
            </div>
            <div class="stat-div"></div>
            <div class="stat-it">
                <div class="stat-num serif">
                    {{ number_format($stats['avg_rating'], 1) }}
                    <span style="font-size:1.4rem;">/5</span>
                </div>
                <div class="stat-lbl">Rating Pemilik Kost</div>
            </div>
        </div>
    </div>
</div>

{{-- ══ KEUNGGULAN ══ --}}
<section class="sec adv-sec" id="keunggulan">
    <div class="wrap">
        <div class="text-center reveal">
            <div class="kicker">Mudahnya kelola kos di KostFinder</div>
            <h2 class="sec-h serif">Berbagai keunggulan kelola properti<br>untuk kemajuan bisnis kos Anda.</h2>
            <p class="sec-sub capped">
                Kami rangkum manfaat yang paling dibutuhkan pemilik kos agar pemasaran, pemantauan, dan pengelolaan properti terasa lebih praktis.
            </p>
        </div>

        <div class="adv-grid">
            @foreach([
                ['no'=>'01','color'=>'#d4621a','img'=>'1.jpg','title'=>'Jangkau Lebih Banyak','desc'=>'Promosikan kos Anda dan capai lebih banyak calon penyewa yang aktif mencari hunian.'],
                ['no'=>'02','color'=>'#d4621a','img'=>'2.jpg','title'=>'Pantau Real-time','desc'=>'Pantau okupansi, keuangan, dan aktivitas kos dari satu dashboard yang lengkap.'],
                ['no'=>'03','color'=>'#c27b14','img'=>'3.jpg','title'=>'Tips & Wawasan','desc'=>'Dapatkan tips dan wawasan untuk mengoptimalkan pengelolaan kos Anda.'],
                ['no'=>'04','color'=>'#b85a1a','img'=>'4.jpg','title'=>'Pembayaran Otomatis','desc'=>'Otomatiskan pembayaran kos Anda sehingga lebih praktis dan terorganisir.'],
            ] as $i => $adv)
            <article class="adv-card reveal reveal-d{{ $i+1 }}">
                <div class="adv-illus">
                    <img src="{{ asset('images/keunggulan/' . $adv['img']) }}" alt="{{ $adv['title'] }}"
                        onerror="this.style.display='none';">
                </div>
                <div class="adv-num" style="color:{{ $adv['color'] }};">{{ $adv['no'] }}</div>
                <div class="adv-title">
                    <span style="color:{{ $adv['color'] }};">{{ $adv['no'] }}</span>
                    {{ $adv['title'] }}
                </div>
                <p class="adv-desc">{{ $adv['desc'] }}</p>
            </article>
            @endforeach
        </div>
    </div>
</section>

{{-- ══ SPLIT: LAYANAN ══ --}}
<section class="sec split-sec">
    <div class="wrap">

        {{-- Header atas --}}
        <div class="split-header reveal">
            <div class="kicker">Maju Bersama KostFinder</div>
            <h2 class="sec-h serif">Kelola kos secara mandiri atau<br>serahkan ke sistem yang lebih rapi.</h2>
            <p class="sec-sub" style="max-width:580px;">
                Dengan berbagai produk dan layanan, Anda bisa pilih cara pengelolaan yang paling sesuai dengan kebutuhan bisnis properti Anda.
            </p>

            {{-- Tab pill --}}
            <div class="split-tabs">
                <button class="split-tab active" onclick="switchTab('mandiri', this)">
                    <i class="bi bi-person-check"></i> Kelola Kos Mandiri
                </button>
                <button class="split-tab" onclick="switchTab('managed', this)">
                    <i class="bi bi-stars"></i> Dikelola KostFinder
                </button>
            </div>
        </div>

        {{-- Konten Tab --}}
        <div class="split-tab-body reveal reveal-d1">

            {{-- TAB: Mandiri --}}
            <div id="tab-mandiri" class="tab-content active">
                <div class="split-new-grid">
                    <div class="split-features">
                        <div class="feat-item feat-item-click active-feat" onclick="selectFeat(this, 'feat1')">
                            <i class="bi bi-megaphone"></i>
                            <div>
                                <div class="feat-title">Promosi Properti Lebih Tepat Sasaran</div>
                                <div class="feat-desc">Jangkau calon penyewa yang relevan melalui sistem pencarian yang terarah.</div>
                            </div>
                            <i class="bi bi-chevron-right feat-arrow"></i>
                        </div>
                        <div class="feat-item feat-item-click" onclick="selectFeat(this, 'feat2')">
                            <i class="bi bi-house-gear"></i>
                            <div>
                                <div class="feat-title">Manajemen Properti Digital Terintegrasi</div>
                                <div class="feat-desc">Kelola seluruh data dan aktivitas kos dalam satu dashboard yang rapi.</div>
                            </div>
                            <i class="bi bi-chevron-right feat-arrow"></i>
                        </div>
                        <div class="feat-item feat-item-click" onclick="selectFeat(this, 'feat3')">
                            <i class="bi bi-credit-card"></i>
                            <div>
                                <div class="feat-title">Sistem Pengajuan & Penagihan Sewa Otomatis</div>
                                <div class="feat-desc">Permudah proses administrasi mulai dari pengajuan hingga pembayaran.</div>
                            </div>
                            <i class="bi bi-chevron-right feat-arrow"></i>
                        </div>
                        <div class="feat-item feat-item-click" onclick="selectFeat(this, 'feat4')">
                            <i class="bi bi-stars"></i>
                            <div>
                                <div class="feat-title">Tampilan Properti Lebih Profesional</div>
                                <div class="feat-desc">Tingkatkan daya tarik kos dengan tampilan listing yang lebih terpercaya.</div>
                            </div>
                            <i class="bi bi-chevron-right feat-arrow"></i>
                        </div>
                    </div>

                    <div class="tab-visual">
                        <div class="feat-visual-wrap">
                            <div class="feat-visual active" id="feat1">
                                <img src="{{ asset('images/fitur/promosi.jpg') }}" alt="Promosi"
                                    onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                                <div class="feat-visual-fallback" style="display:none;">
                                    <div class="feat-visual-icon">📣</div>
                                    <div class="feat-visual-title">Promosi Tepat Sasaran</div>
                                </div>
                            </div>
                            <div class="feat-visual" id="feat2">
                                <img src="{{ asset('images/fitur/manajemen.jpg') }}" alt="Manajemen"
                                    onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                                <div class="feat-visual-fallback" style="display:none;">
                                    <div class="feat-visual-icon">🏠</div>
                                    <div class="feat-visual-title">Dashboard Manajemen</div>
                                </div>
                            </div>
                            <div class="feat-visual" id="feat3">
                                <img src="{{ asset('images/fitur/tagihan.jpg') }}" alt="Tagihan"
                                    onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                                <div class="feat-visual-fallback" style="display:none;">
                                    <div class="feat-visual-icon">💳</div>
                                    <div class="feat-visual-title">Tagihan Otomatis</div>
                                </div>
                            </div>
                            <div class="feat-visual" id="feat4">
                                <img src="{{ asset('images/fitur/profesional.jpg') }}" alt="Profesional"
                                    onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                                <div class="feat-visual-fallback" style="display:none;">
                                    <div class="feat-visual-icon">✨</div>
                                    <div class="feat-visual-title">Tampilan Profesional</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TAB: Managed --}}
            <div id="tab-managed" class="tab-content" style="display:none;">
                <div class="split-new-grid">
                    <div class="split-features">
                        <div class="feat-item">
                            <i class="bi bi-robot"></i>
                            <div>
                                <div class="feat-title">Otomatisasi Proses Pengelolaan</div>
                                <div class="feat-desc">Sistem kami menangani alur booking, konfirmasi, dan tagihan secara otomatis.</div>
                            </div>
                        </div>
                        <div class="feat-item">
                            <i class="bi bi-headset"></i>
                            <div>
                                <div class="feat-title">Dukungan Tim KostFinder</div>
                                <div class="feat-desc">Tim kami siap membantu menangani pertanyaan dan kebutuhan penyewa Anda.</div>
                            </div>
                        </div>
                        <div class="feat-item">
                            <i class="bi bi-bar-chart-line"></i>
                            <div>
                                <div class="feat-title">Laporan Performa Bulanan</div>
                                <div class="feat-desc">Terima laporan lengkap setiap bulan langsung ke email Anda.</div>
                            </div>
                        </div>
                        <div class="feat-item">
                            <i class="bi bi-shield-check"></i>
                            <div>
                                <div class="feat-title">Jaminan Transparansi Penuh</div>
                                <div class="feat-desc">Pantau semua aktivitas properti secara real-time kapan saja.</div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-visual">
                        <div class="feat-visual-wrap">
                            <div class="feat-visual active">
                                <img src="{{ asset('images/tab-managed.jpg') }}" alt="Managed"
                                    onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                                <div class="feat-visual-fallback" style="display:none;">
                                    <div class="feat-visual-icon">📊</div>
                                    <div class="feat-visual-title">Managed Dashboard</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ══ TESTIMONI ══ --}}
<section class="sec quote-sec">
    <div class="wrap">

        {{-- Header --}}
        <div class="text-center reveal" style="margin-bottom:52px;">
            <h2 class="sec-h serif">
                <span style="color:var(--g);font-size:clamp(2.2rem,4vw,3.5rem);">{{ $reviews->count() > 0 ? number_format($reviews->count()) : '1,247' }}+</span>
                Pemilik Kos Sudah Merasakan Manfaatnya
            </h2>
            <p class="sec-sub capped">Temukan kemudahan dalam mengelola kos Anda bersama KostFinder.</p>
        </div>

        @if($reviews->count() > 0)
        <div class="testi-wrap reveal reveal-d1">

        {{-- Kiri: Hexagon Grid --}}
<div class="testi-hex-wrap">
    @php
        $hexReviews = $reviews->take(7)->values();
        $centerUser = $hexReviews->get(0);
        $surrounding = $hexReviews->skip(1)->values();
        
        function avatarUrl($name) {
            return 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&background=d4621a&color=fff&size=128&bold=true&rounded=false';
        }
        
        // posisi: [baris, kolom] — susunan seperti gambar
        $positions = [
            ['row'=>0,'col'=>0,'shape'=>'green'],
            ['row'=>0,'col'=>1,'shape'=>'gray'],
            ['row'=>1,'col'=>0,'shape'=>'gray'],
            // tengah = center (gold)
            ['row'=>1,'col'=>2,'shape'=>'green-dark'],
            ['row'=>2,'col'=>0,'shape'=>'green'],
            ['row'=>2,'col'=>1,'shape'=>'gray'],
            ['row'=>2,'col'=>2,'shape'=>'green'],
        ];
    @endphp

    <div class="testi-hex-grid">

        {{-- Baris 1: 2 hex --}}
        <div class="hex-row">
            @foreach([0,1] as $idx)
            <div class="hex-item">
                <div class="hex-shape {{ $surrounding->get($idx) ? 'green' : 'gray' }}">
                    @if($surrounding->get($idx))
                        <img src="{{ avatarUrl($surrounding->get($idx)->user->name) }}"
                             alt="{{ $surrounding->get($idx)->user->name }}"
                             style="width:100%;height:100%;object-fit:cover;">
                    @else
                        <div class="hex-inner">👤</div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        {{-- Baris 2: kiri + GOLD tengah + kanan --}}
        <div class="hex-row" style="margin-top:-14px;">
            <div class="hex-item">
                <div class="hex-shape gray">
                    @if($surrounding->get(2))
                        <img src="{{ avatarUrl($surrounding->get(2)->user->name) }}"
                             alt="{{ $surrounding->get(2)->user->name }}"
                             style="width:100%;height:100%;object-fit:cover;">
                    @else
                        <div class="hex-inner">👤</div>
                    @endif
                </div>
            </div>

            {{-- CENTER GOLD --}}
            <div class="hex-item">
                <div class="hex-shape gold">
                    @if($centerUser)
                        <img src="{{ avatarUrl($centerUser->user->name) }}"
                             alt="{{ $centerUser->user->name }}"
                             style="width:100%;height:100%;object-fit:cover;">
                    @else
                        <div class="hex-inner" style="font-size:2rem;">🏠</div>
                    @endif
                </div>
            </div>

            <div class="hex-item">
                <div class="hex-shape green-dark">
                    @if($surrounding->get(3))
                        <img src="{{ avatarUrl($surrounding->get(3)->user->name) }}"
                             alt="{{ $surrounding->get(3)->user->name }}"
                             style="width:100%;height:100%;object-fit:cover;">
                    @else
                        <div class="hex-inner">👤</div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Baris 3: 2 hex --}}
        <div class="hex-row" style="margin-top:-14px;">
            @foreach([4,5] as $idx)
            <div class="hex-item">
                <div class="hex-shape {{ $idx === 4 ? 'green' : 'gray' }}">
                    @if($surrounding->get($idx))
                        <img src="{{ avatarUrl($surrounding->get($idx)->user->name) }}"
                             alt="{{ $surrounding->get($idx)->user->name }}"
                             style="width:100%;height:100%;object-fit:cover;">
                    @else
                        <div class="hex-inner">👤</div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

    </div>

    {{-- Dekorasi dot --}}
    <div style="position:absolute;top:8%;left:4%;width:12px;height:12px;border-radius:50%;background:var(--g);opacity:.55;"></div>
    <div style="position:absolute;top:28%;left:1%;width:8px;height:8px;border-radius:50%;background:#f59e0b;opacity:.65;"></div>
    <div style="position:absolute;bottom:22%;left:6%;width:10px;height:10px;border-radius:50%;background:var(--g);opacity:.45;"></div>
    <div style="position:absolute;bottom:8%;right:8%;width:8px;height:8px;border-radius:50%;background:#f59e0b;opacity:.55;"></div>
    <div style="position:absolute;top:12%;right:5%;width:7px;height:7px;border-radius:50%;background:var(--g3);opacity:.5;"></div>
</div>

            {{-- Kanan: Kartu Ulasan --}}
            <div class="testi-card-wrap">
                <div class="testi-card">
                    <div class="testi-card-top">
                        <div class="testi-big-quote serif">"</div>
                        <div class="testi-card-stars" id="testiStars">★★★★★</div>
                    </div>
                    <p class="testi-card-text" id="testiMainText">{{ $reviews->first()->ulasan }}</p>
                    <div class="testi-card-author">
                        <div class="testi-card-avatar" id="testiInitials">
                            {{ strtoupper(substr($reviews->first()->user->name, 0, 2)) }}
                        </div>
                        <div>
                            <div class="testi-card-name" id="testiName">{{ $reviews->first()->user->name }}</div>
                            <div class="testi-card-loc">
                                <i class="bi bi-house-door-fill" style="font-size:.7rem;"></i>
                                <span id="testiKos">{{ $reviews->first()->lokasi_kos }}</span>
                            </div>
                            <div class="testi-card-loc">
                                <i class="bi bi-geo-alt-fill" style="font-size:.7rem;"></i>
                                <span id="testiCity">{{ $reviews->first()->kota }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="testi-progress-wrap" style="margin-top:20px;">
                        <div class="testi-progress-bar" id="testiProgress"></div>
                    </div>
                </div>

                <div class="testi-dots-nav">
                    @foreach($reviews as $i => $r)
                    <span class="testi-dot-nav {{ $i === 0 ? 'active' : '' }}"
                        onclick="selectTesti({{ $i }})"></span>
                    @endforeach
                </div>
            </div>

        </div>

        @else
        {{-- Fallback kalau belum ada review --}}
        <div class="testi-wrap reveal reveal-d1">
            <div class="testi-hex-wrap">
                <div class="testi-hex-grid">
                    <div class="hex-row">
                        <div class="hex-item"><div class="hex-shape green"><div class="hex-inner hex-logo"><svg viewBox="0 0 38 38" fill="none" width="36" height="36"><path d="M19 7L8 13.5V24.5L19 31L30 24.5V13.5L19 7Z" fill="white" fill-opacity="0.85"/><path d="M19 12L13 15.5V22.5L19 26L25 22.5V15.5L19 12Z" fill="rgba(212,98,26,0.45)"/></svg></div></div></div>
                        <div class="hex-item"><div class="hex-shape gray"><div class="hex-inner hex-logo"><svg viewBox="0 0 38 38" fill="none" width="36" height="36"><path d="M19 7L8 13.5V24.5L19 31L30 24.5V13.5L19 7Z" fill="white" fill-opacity="0.5"/></svg></div></div></div>
                    </div>
                    <div class="hex-row" style="margin-top:-14px;">
                        <div class="hex-item"><div class="hex-shape gray"><div class="hex-inner hex-logo"><svg viewBox="0 0 38 38" fill="none" width="36" height="36"><path d="M19 7L8 13.5V24.5L19 31L30 24.5V13.5L19 7Z" fill="white" fill-opacity="0.5"/></svg></div></div></div>
                        <div class="hex-item">
                            <div class="hex-shape gold">
                                <div class="hex-inner hex-logo">
                                    <svg viewBox="0 0 38 38" fill="none" width="52" height="52"><path d="M19 5L6 12.5V25.5L19 33L32 25.5V12.5L19 5Z" fill="white" fill-opacity="0.95"/><path d="M19 11L12 15.5V23.5L19 28L26 23.5V15.5L19 11Z" fill="rgba(212,98,26,0.55)"/></svg>
                                    <div style="font-size:.7rem;font-weight:900;margin-top:3px;color:rgba(255,255,255,.9);letter-spacing:.04em;">KostFinder</div>
                                </div>
                            </div>
                        </div>
                        <div class="hex-item"><div class="hex-shape green-dark"><div class="hex-inner hex-logo"><svg viewBox="0 0 38 38" fill="none" width="36" height="36"><path d="M19 7L8 13.5V24.5L19 31L30 24.5V13.5L19 7Z" fill="white" fill-opacity="0.8"/><path d="M19 12L13 15.5V22.5L19 26L25 22.5V15.5L19 12Z" fill="rgba(212,98,26,0.4)"/></svg></div></div></div>
                    </div>
                    <div class="hex-row" style="margin-top:-14px;">
                        <div class="hex-item"><div class="hex-shape green"><div class="hex-inner hex-logo"><svg viewBox="0 0 38 38" fill="none" width="36" height="36"><path d="M19 7L8 13.5V24.5L19 31L30 24.5V13.5L19 7Z" fill="white" fill-opacity="0.85"/><path d="M19 12L13 15.5V22.5L19 26L25 22.5V15.5L19 12Z" fill="rgba(212,98,26,0.45)"/></svg></div></div></div>
                        <div class="hex-item"><div class="hex-shape gray"><div class="hex-inner hex-logo"><svg viewBox="0 0 38 38" fill="none" width="36" height="36"><path d="M19 7L8 13.5V24.5L19 31L30 24.5V13.5L19 7Z" fill="white" fill-opacity="0.5"/></svg></div></div></div>
                    </div>
                </div>
                <div style="position:absolute;top:8%;left:4%;width:12px;height:12px;border-radius:50%;background:var(--g);opacity:.55;"></div>
                <div style="position:absolute;top:28%;left:1%;width:8px;height:8px;border-radius:50%;background:#f59e0b;opacity:.65;"></div>
                <div style="position:absolute;bottom:22%;left:6%;width:10px;height:10px;border-radius:50%;background:var(--g);opacity:.45;"></div>
                <div style="position:absolute;bottom:8%;right:8%;width:8px;height:8px;border-radius:50%;background:#f59e0b;opacity:.55;"></div>
            </div>

            <div class="testi-card-wrap">
                <div class="testi-card">
                    <div class="testi-card-top">
                        <div class="testi-big-quote serif">"</div>
                        <div class="testi-card-stars">★★★★★</div>
                    </div>
                    <p class="testi-card-text">Sejak bergabung dengan KostFinder, pengelolaan kos saya jadi jauh lebih mudah dan praktis. Semua teratur dan penyewa pun semakin mudah mencari kamar.</p>
                    <div class="testi-card-author">
                        <div class="testi-card-avatar">BS</div>
                        <div>
                            <div class="testi-card-name">Budi Setiawan</div>
                            <div class="testi-card-loc"><i class="bi bi-house-door-fill" style="font-size:.7rem;"></i> Kos Putra Jaya</div>
                            <div class="testi-card-loc"><i class="bi bi-geo-alt-fill" style="font-size:.7rem;"></i> Malang</div>
                        </div>
                    </div>
                    <div class="testi-progress-wrap" style="margin-top:20px;"><div class="testi-progress-bar" style="width:100%;"></div></div>
                </div>
                <div class="testi-dots-nav">
                    <span class="testi-dot-nav active"></span>
                    <span class="testi-dot-nav"></span>
                    <span class="testi-dot-nav"></span>
                    <span class="testi-dot-nav"></span>
                </div>
            </div>
        </div>
        @endif

    </div>
</section>

{{-- ══ FAQ ══ --}}
<section class="sec faq-sec">
    <div class="wrap">
        <div class="faq-layout">
            {{-- kiri: intro --}}
            <div class="faq-sticky reveal">
                <div class="kicker">Tanya &amp; Jawab</div>
                <h2 class="sec-h serif">Makin yakin bergabung dengan KostFinder</h2>
                <p class="sec-sub" style="margin-bottom:1.8rem;">
                    Beberapa pertanyaan yang paling sering muncul sebelum pemilik kos mulai mendaftarkan properti mereka.
                </p>
            </div>

            {{-- kanan: FAQ accordion --}}
            <div class="faq-list reveal reveal-d2">
            @foreach([
                ['q'=>'Bagaimana cara daftarkan kos?','a'=>'Untuk dapat mendaftarkan kos, Anda perlu memiliki akun pemilik kos terlebih dahulu. Klik tombol Daftarkan Kos di halaman ini, selesaikan proses verifikasi, lalu mulai tambahkan kos di akun Anda.'],
                ['q'=>'Apakah mendaftarkan kos di KostFinder gratis?','a'=>'Ya, Anda bisa mulai mendaftarkan properti dan mengelolanya secara gratis. Jika nanti ada pengembangan fitur promosi tambahan, itu bisa disesuaikan dengan kebutuhan bisnis Anda.'],
                ['q'=>'Apakah bisa diakses lebih dari 1 perangkat?','a'=>'Ya. KostFinder dapat diakses di mana saja, kapan saja, dan dengan perangkat apa saja, baik melalui laptop maupun ponsel. Cukup login dengan akun pemilik dan data Anda tersinkron secara real-time.'],
                ['q'=>'Apa bedanya kelola sendiri dengan dikelola KostFinder?','a'=>'Jika Anda kelola sendiri, Anda punya kendali penuh mulai dari listing, harga, hingga komunikasi dengan penyewa. Cocok untuk pemilik yang aktif. Sedangkan jika dikelola KostFinder, tim kami yang mengurus promosi, konfirmasi booking, penagihan, hingga laporan bulanan. Keduanya bisa dipantau real-time dari dashboard Anda.'],
            ] as $i => $faq)
                <div class="faq-item {{ $i===0 ? 'open' : '' }}" onclick="toggleFaq(this)">
                    <button type="button" class="faq-trigger">
                        <span class="faq-q">{{ $faq['q'] }}</span>
                        <div class="faq-chevron"><i class="bi bi-chevron-down"></i></div>
                    </button>
                    <div class="faq-body">
                        <p class="faq-a">{{ $faq['a'] }}</p>
                    </div>
                </div>
            @endforeach
            </div>
        </div>
    </div>
</section>


@php
$testiJson = $reviews->map(function($r) {
    return [
        'initial' => strtoupper(substr($r->user->name, 0, 2)),
        'name'    => $r->user->name,
        'role'    => 'Pemilik Kos • ' . $r->lokasi_kos,
        'city'    => $r->kota,
        'kos'     => $r->lokasi_kos,
        'text'    => $r->ulasan,
        'rating'  => $r->rating,
    ];
});
@endphp

<script>
/* Reveal on scroll */
(function(){
    const els = document.querySelectorAll('.reveal');
    const obs = new IntersectionObserver(entries => {
        entries.forEach(e => { if(e.isIntersecting){ e.target.classList.add('vis'); obs.unobserve(e.target); }});
    }, { threshold: 0.1 });
    els.forEach(el => obs.observe(el));

    /* Hero image fallback */
    const img = document.querySelector('.hero-img img');
    const empty = document.getElementById('heroImgEmpty');
    if(img && empty){
        img.onerror = () => { img.style.display='none'; empty.style.display='flex'; };
    }
})();

/* FAQ accordion */
function toggleFaq(item){
    const isOpen = item.classList.contains('open');
    document.querySelectorAll('.faq-item.open').forEach(el => el.classList.remove('open'));
    if(!isOpen) item.classList.add('open');
}

function changeImage(type){
    let img = document.getElementById("phoneImage");
    if(type === 'img1'){ img.src = "{{ asset('images/img1.png') }}"; }
    else if(type === 'img2'){ img.src = "{{ asset('images/img2.png') }}"; }
    else if(type === 'img3'){ img.src = "{{ asset('images/img3.png') }}"; }
    else if(type === 'img4'){ img.src = "{{ asset('images/img4.png') }}"; }
}

/* Switch Tab */
function switchTab(tab, el) {
    document.querySelectorAll('.tab-content').forEach(t => t.style.display = 'none');
    document.querySelectorAll('.split-tab').forEach(p => p.classList.remove('active'));
    document.getElementById('tab-' + tab).style.display = 'block';
    el.classList.add('active');
}

/* ══ Testimoni ══ */
const testiData = {!! json_encode($testiJson) !!};

let testiIdx = 0;
let testiTimer = null;
const TESTI_DURATION = 5000;

function selectTesti(idx) {
    clearInterval(testiTimer);

    const txt      = document.getElementById('testiMainText');
    const initials = document.getElementById('testiInitials');
    const name     = document.getElementById('testiName');
    const city     = document.getElementById('testiCity');
    const stars    = document.getElementById('testiStars');
    const progress = document.getElementById('testiProgress');
    const dots     = document.querySelectorAll('.testi-dot-nav');

    txt.style.opacity   = '0';
    txt.style.transform = 'translateY(8px)';

    setTimeout(() => {
        testiIdx = idx;
        const d = testiData[idx];

        txt.textContent      = d.text;
        initials.textContent = d.initial;
        name.textContent     = d.name;
        city.textContent     = d.city;
        document.getElementById('testiKos').textContent = d.kos;
        stars.textContent    = '★'.repeat(d.rating) + '☆'.repeat(5 - d.rating);

        txt.style.transition = 'opacity .35s ease, transform .35s ease';
        txt.style.opacity    = '1';
        txt.style.transform  = 'none';

        dots.forEach((d, i) => d.classList.toggle('active', i === idx));

        progress.style.transition = 'none';
        progress.style.width      = '0%';
        requestAnimationFrame(() => {
            requestAnimationFrame(() => {
                progress.style.transition = `width ${TESTI_DURATION}ms linear`;
                progress.style.width      = '100%';
            });
        });
    }, 200);

    startTestiAuto();
}

function startTestiAuto() {
    clearInterval(testiTimer);
    testiTimer = setInterval(() => {
        selectTesti((testiIdx + 1) % testiData.length);
    }, TESTI_DURATION);
}

document.addEventListener('DOMContentLoaded', () => {
    const progress = document.getElementById('testiProgress');
    if (progress) {
        progress.style.transition = `width ${TESTI_DURATION}ms linear`;
        progress.style.width = '100%';
        startTestiAuto();
    }
});

/* ══ Feat Item Click ══ */
function selectFeat(el, featId) {
    document.querySelectorAll('.feat-item-click').forEach(f => f.classList.remove('active-feat'));
    document.querySelectorAll('.feat-visual').forEach(v => v.classList.remove('active'));
    el.classList.add('active-feat');
    document.getElementById(featId).classList.add('active');
}
</script>
</body>
</html>