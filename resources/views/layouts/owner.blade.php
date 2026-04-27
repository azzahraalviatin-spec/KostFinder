<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Owner Panel') - KostFinder</title>
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  
  <style>
    :root { 
      --sidebar-w: 250px; 
      --sidebar-col: 78px; 
      --primary: #e8401c; 
      --primary-light: #fff5f2; 
      --primary-mid: #ffd0c0; 
      --dark: #1e2d3d; 
      --bg: #f4f7fb; 
      --line: #e8edf4; 
      --muted: #8fa3b8; 
    }
    
    * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
    body { background: var(--bg); min-height: 100vh; display: flex; overflow-x: hidden; }
    
    /* ── SIDEBAR ── */
    .sidebar { width: var(--sidebar-w); min-height: 100vh; background: var(--dark); position: fixed; top: 0; left: 0; display: flex; flex-direction: column; z-index: 200; transition: all .3s ease; overflow: hidden; }
    .sidebar.collapsed { width: var(--sidebar-col); }
    .sidebar-brand { padding: 1.2rem .9rem; border-bottom: 1px solid rgba(255,255,255,.08); display: flex; align-items: center; gap: .6rem; min-height: 70px; white-space: nowrap; }
    .brand-icon { width: 38px; height: 38px; flex-shrink: 0; background: linear-gradient(135deg,#e8401c,#ff7043); border-radius: .7rem; display: flex; align-items: center; justify-content: center; font-size: 1rem; color: #fff; box-shadow: 0 4px 12px rgba(232,64,28,.4); }
    .brand-text { overflow: hidden; transition: .2s; }
    .brand-text .name { font-size: 1.2rem; font-weight: 800; color: #fff; line-height: 1; }
    .brand-text .name span { color: #ff7a45; }
    .brand-text .sub { font-size: .72rem; color: #8aa0b7; margin-top: .25rem; }
    .sidebar.collapsed .brand-text, .sidebar.collapsed .menu-label, .sidebar.collapsed .menu-item span, .sidebar.collapsed .user-info { opacity: 0; width: 0; overflow: hidden; }
    .sidebar-menu { padding: .8rem .6rem; flex: 1; }
    .menu-label { font-size: .68rem; font-weight: 700; color: #7f96ad; padding: .45rem .55rem; letter-spacing: .08em; }
    .menu-item { display: flex; align-items: center; gap: .7rem; padding: .72rem .8rem; border-radius: .75rem; color: #adc0cf; text-decoration: none; font-size: .88rem; font-weight: 600; margin-bottom: .2rem; transition: .2s; white-space: nowrap; border: none; background: transparent; width: 100%; text-align: left; cursor: pointer; }
    .menu-item i { font-size: 1rem; width: 20px; flex-shrink: 0; }
    .menu-item:hover { background: rgba(255,255,255,.08); color: #fff; }
    .menu-item.active { background: linear-gradient(135deg,#e8401c,#ff7043); color: #fff; box-shadow: 0 8px 18px rgba(232,64,28,.25); }
    .menu-item.logout { color: #ff8d8d; }
    .menu-item.logout:hover { background: rgba(255,95,95,.12); color: #fff; }
    
    /* ── MAIN ── */
    .main { margin-left: var(--sidebar-w); min-height: 100vh; display: flex; flex-direction: column; transition: .3s ease; flex: 1; }
    .main.collapsed { margin-left: var(--sidebar-col); }
    
    /* ── TOPBAR ── */
    .topbar { height: 72px; background: #fff; border-bottom: 1px solid var(--line); display: flex; align-items: center; justify-content: space-between; padding: 0 1.5rem; position: sticky; top: 0; z-index: 100; }
    
    /* ── CONTENT ── */
    .content { padding: 1.5rem; flex: 1; }
    
    .owner-footer { background: #fff; border-top: 1px solid var(--line); padding: 1rem 1.5rem; text-align: center; color: var(--muted); font-size: .8rem; font-weight: 600; }
    
    /* ── GALLERY & PREVIEWS ── */
    .preview-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 1rem; margin-top: 1rem; }
    .preview-card { background: #fff; border: 1px solid var(--line); border-radius: .85rem; overflow: hidden; transition: .25s; position: relative; }
    .preview-card:hover { border-color: var(--primary); box-shadow: 0 10px 25px rgba(0,0,0,.08); transform: translateY(-3px); }
    .preview-img-wrap { position: relative; height: 130px; overflow: hidden; }
    .preview-img-wrap img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform .35s ease; }
    .preview-card:hover .preview-img-wrap img { transform: scale(1.06); }
    .badge-cover { position: absolute; top: 10px; left: 10px; background: linear-gradient(135deg,#e8401c,#ff7043); color: #fff; font-size: .65rem; font-weight: 800; padding: .3rem .7rem; border-radius: 999px; box-shadow: 0 4px 12px rgba(232,64,28,.3); display: flex; align-items: center; gap: .3rem; z-index: 5; }
    .btn-remove { position: absolute; top: 8px; right: 8px; width: 32px; height: 32px; border: none; border-radius: 50%; background: rgba(17,24,39,.65); color: #fff; display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: .85rem; backdrop-filter: blur(6px); transition: .2; z-index: 5; }
    .btn-remove:hover { background: rgba(220,38,38,.9); transform: scale(1.1); }
    .preview-info { padding: .75rem .9rem; }
    .preview-label-input { font-size: .78rem; font-weight: 600; border: 1px solid var(--line); border-radius: .55rem; padding: .4rem .65rem; width: 100%; outline: none; transition: .2s; }
    .preview-label-input:focus { border-color: var(--primary); background: #fff; }

    @media (max-width: 991px) {
      .sidebar { transform: translateX(-100%); }
      .sidebar.show { transform: translateX(0); }
      .main { margin-left: 0 !important; }
      .preview-grid { grid-template-columns: repeat(2, 1fr); }
    }
  </style>

  {{-- ✅ DIPINDAH KE SINI (di luar tag style) supaya CSS dari tiap halaman bisa masuk --}}
  @stack('styles')

</head>
<body>

  @include('owner._sidebar')

  <div class="main" id="mainContent">
    @include('owner._navbar')

    <div class="content">
      @yield('content')
    </div>

    <footer class="owner-footer">
      © {{ date('Y') }} <span style="color:var(--primary)">KostFinder</span> — Panel Pemilik Kost. All rights reserved.
    </footer>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function toggleSidebar() {
      const s = document.getElementById('sidebar');
      const m = document.getElementById('mainContent');
      if (window.innerWidth <= 991) { s.classList.toggle('show'); }
      else { s.classList.toggle('collapsed'); m.classList.toggle('collapsed'); }
    }
  </script>
  @stack('scripts')
</body>
</html>