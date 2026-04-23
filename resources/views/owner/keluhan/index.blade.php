<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Keluhan Penghuni - KostFinder</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    :root { --sidebar-w:200px; --sidebar-col:60px; --primary:#e8401c; --dark:#1e2d3d; --bg:#f0f4f8; --line:#e4e9f0; --muted:#8fa3b8; }
    * { margin:0; padding:0; box-sizing:border-box; }
    body { font-family:'Plus Jakarta Sans',sans-serif; background:var(--bg); display:flex; min-height:100vh; }

    /* copy dari dashboard */
    .sidebar { width:var(--sidebar-w); min-height:100vh; background:var(--dark); position:fixed; top:0; left:0; display:flex; flex-direction:column; z-index:200; transition:width .3s ease; overflow:hidden; }
    .sidebar.collapsed { width:var(--sidebar-col); }
    .sidebar-brand { padding:1.2rem .9rem; border-bottom:1px solid rgba(255,255,255,.08); display:flex; align-items:center; gap:.6rem; min-height:60px; white-space:nowrap; }
    .brand-icon { width:32px; height:32px; flex-shrink:0; background:var(--primary); border-radius:.5rem; display:flex; align-items:center; justify-content:center; font-size:1rem; }
    .brand-text { overflow:hidden; transition:opacity .2s; }
    .brand-text .name { font-size:1rem; font-weight:800; color:#fff; }
    .brand-text .name span { color:var(--primary); }
    .brand-text .sub { font-size:.65rem; color:#7a92aa; }
    .sidebar.collapsed .brand-text { opacity:0; width:0; }
    .sidebar-menu { padding:.7rem .5rem; flex:1; }
    .menu-label { font-size:.6rem; font-weight:700; letter-spacing:.1em; color:#7a92aa; padding:.5rem .5rem .2rem; white-space:nowrap; transition:opacity .2s; }
    .sidebar.collapsed .menu-label { opacity:0; }
    .menu-item { display:flex; align-items:center; gap:.65rem; padding:.58rem .65rem; border-radius:.55rem; color:#a0b4c4; text-decoration:none; font-size:.82rem; font-weight:500; margin-bottom:.1rem; transition:all .2s; white-space:nowrap; cursor:pointer; border:0; background:none; width:100%; text-align:left; }
    .menu-item i { font-size:.95rem; width:20px; flex-shrink:0; }
    .menu-item span { overflow:hidden; transition:opacity .2s; }
    .sidebar.collapsed .menu-item span { opacity:0; width:0; }
    .menu-item:hover { background:rgba(255,255,255,.07); color:#fff; }
    .menu-item.active { background:var(--primary); color:#fff; }
    .menu-item.logout { color:#f87171; }
    .menu-item.logout:hover { background:rgba(248,113,113,.1); }
    .sidebar-user { padding:.85rem .9rem; border-top:1px solid rgba(255,255,255,.08); display:flex; align-items:center; gap:.6rem; white-space:nowrap; }
    .user-avatar { width:32px; height:32px; border-radius:50%; background:var(--primary); color:#fff; font-weight:700; font-size:.8rem; flex-shrink:0; display:flex; align-items:center; justify-content:center; }
    .user-info { overflow:hidden; transition:opacity .2s; }
    .sidebar.collapsed .user-info { opacity:0; width:0; }
    .user-name { color:#fff; font-size:.8rem; font-weight:600; }
    .user-role { color:#7a92aa; font-size:.68rem; }
    .main { margin-left:var(--sidebar-w); flex:1; transition:margin-left .3s ease; display:flex; flex-direction:column; }
    .main.collapsed { margin-left:var(--sidebar-col); }
    .topbar { background:#fff; height:60px; padding:0 1.5rem; display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid #e4e9f0; position:sticky; top:0; z-index:100; }
    .search-box { display:flex; align-items:center; gap:.5rem; background:#f0f4f8; border:1px solid #dde3ed; border-radius:.55rem; padding:.38rem .75rem; width:180px; }
    .search-box input { border:0; background:none; outline:none; font-size:.8rem; color:#333; width:100%; }
    .icon-btn { width:34px; height:34px; border-radius:.5rem; background:#f0f4f8; border:1px solid #dde3ed; display:flex; align-items:center; justify-content:center; color:#555; font-size:.9rem; cursor:pointer; text-decoration:none; position:relative; }
    .notif-dot { position:absolute; top:5px; right:5px; width:6px; height:6px; background:var(--primary); border-radius:50%; border:1px solid #fff; }
    .content { padding:1.4rem; flex:1; }
    .owner-footer { background:#fff; border-top:1px solid #e4e9f0; padding:.8rem 1.5rem; text-align:center; color:#8fa3b8; font-size:.72rem; }

    /* KELUHAN STYLES */
    .kel-stats { display:grid; grid-template-columns:repeat(3,1fr); gap:.85rem; margin-bottom:1.5rem; }
    .kel-stat { background:#fff; border-radius:.85rem; padding:1rem 1.2rem; border:1px solid #e4e9f0; display:flex; align-items:center; gap:.8rem; box-shadow:0 2px 6px rgba(0,0,0,.04); }
    .kel-stat-icon { width:42px; height:42px; border-radius:.7rem; display:flex; align-items:center; justify-content:center; font-size:1.1rem; flex-shrink:0; }

    .kel-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(280px,1fr)); gap:1rem; }
    .kel-card { background:#fff; border-radius:.85rem; border:1px solid #e4e9f0; overflow:hidden; transition:all .2s; display:flex; flex-direction:column; box-shadow:0 2px 6px rgba(0,0,0,.04); }
    .kel-card:hover { box-shadow:0 6px 20px rgba(0,0,0,.09); transform:translateY(-2px); }
    .kel-card-head { padding:.85rem 1rem; border-bottom:1px solid #f0f3f8; display:flex; justify-content:space-between; align-items:flex-start; gap:.5rem; }
    .kel-card-body { padding:.85rem 1rem; flex:1; }
    .kel-card-foot { padding:.65rem 1rem; border-top:1px solid #f0f3f8; display:flex; justify-content:flex-end; }
    .kel-kost { font-weight:700; font-size:.85rem; color:var(--dark); }
    .kel-user { font-size:.73rem; color:var(--muted); margin-top:.15rem; }
    .kel-judul { font-weight:700; font-size:.82rem; color:#374151; margin-bottom:.3rem; }
    .kel-desc { font-size:.78rem; color:#6b7280; line-height:1.6; display:-webkit-box; -webkit-line-clamp:3; -webkit-box-orient:vertical; overflow:hidden; }
    .kel-date { font-size:.7rem; color:#aaa; margin-top:.5rem; }
    .status-pill { font-size:.68rem; font-weight:700; padding:.2rem .65rem; border-radius:99px; white-space:nowrap; }
    .btn-detail { background:var(--primary); color:#fff; border:0; border-radius:.5rem; padding:.35rem .85rem; font-size:.75rem; font-weight:700; text-decoration:none; transition:background .18s; display:inline-flex; align-items:center; gap:.3rem; }
    .btn-detail:hover { background:#c73015; color:#fff; }
    .empty-box { background:#fff; border-radius:.85rem; border:1px solid #e4e9f0; padding:3rem; text-align:center; color:#aaa; }
    .empty-box i { font-size:2.5rem; display:block; margin-bottom:.75rem; opacity:.3; }
  </style>
</head>
<body>

  @include('owner._sidebar')

  <div class="main" id="mainContent">

    @include('owner._navbar')

    <div class="content">

      <div style="margin-bottom:1.5rem;">
        <h4 style="font-size:1.1rem;font-weight:800;color:var(--dark);margin:0;">
          <i class="bi bi-exclamation-circle-fill me-2" style="color:var(--primary);"></i>Keluhan Penghuni
        </h4>
        <p style="font-size:.78rem;color:var(--muted);margin-top:.25rem;">Daftar keluhan dari penghuni kost Anda</p>
      </div>

      {{-- STATISTIK --}}
      @php
        $totalKeluhan = $keluhans->count();
        $pending      = $keluhans->where('status','pending')->count();
        $selesai      = $keluhans->where('status','selesai')->count();
      @endphp
      <div class="kel-stats">
        <div class="kel-stat">
          <div class="kel-stat-icon" style="background:#fff5f2;color:var(--primary);"><i class="bi bi-chat-left-text-fill"></i></div>
          <div>
            <div style="font-size:1.4rem;font-weight:800;color:var(--dark);">{{ $totalKeluhan }}</div>
            <div style="font-size:.74rem;color:var(--muted);font-weight:600;">Total Keluhan</div>
          </div>
        </div>
        <div class="kel-stat">
          <div class="kel-stat-icon" style="background:#fff7ed;color:#ea580c;"><i class="bi bi-hourglass-split"></i></div>
          <div>
            <div style="font-size:1.4rem;font-weight:800;color:var(--dark);">{{ $pending }}</div>
            <div style="font-size:.74rem;color:var(--muted);font-weight:600;">Menunggu</div>
          </div>
        </div>
        <div class="kel-stat">
          <div class="kel-stat-icon" style="background:#f0fdf4;color:#16a34a;"><i class="bi bi-check-circle-fill"></i></div>
          <div>
            <div style="font-size:1.4rem;font-weight:800;color:var(--dark);">{{ $selesai }}</div>
            <div style="font-size:.74rem;color:var(--muted);font-weight:600;">Selesai</div>
          </div>
        </div>
      </div>

      {{-- LIST --}}
      @if($keluhans->count())
        <div class="kel-grid">
          @foreach($keluhans as $keluhan)
          @php
            $st = $keluhan->status ?? 'pending';
            $stStyles = [
              'pending'  => 'background:#fff7ed;color:#ea580c;',
              'diproses' => 'background:#eff6ff;color:#3b82f6;',
              'selesai'  => 'background:#f0fdf4;color:#16a34a;',
            ];
            $stLabels = ['pending'=>'⏳ Pending','diproses'=>'🔄 Diproses','selesai'=>'✅ Selesai'];
          @endphp
          <div class="kel-card">
            <div class="kel-card-head">
              <div>
                <div class="kel-kost">{{ $keluhan->booking->room->kost->nama_kost ?? '-' }}</div>
                <div class="kel-user"><i class="bi bi-person me-1"></i>{{ $keluhan->booking->user->name ?? '-' }}</div>
              </div>
              <span class="status-pill" style="{{ $stStyles[$st] ?? $stStyles['pending'] }}">{{ $stLabels[$st] ?? ucfirst($st) }}</span>
            </div>
            <div class="kel-card-body">
              <div class="kel-judul">{{ $keluhan->judul ?? $keluhan->jenis ?? 'Keluhan' }}</div>
              <div class="kel-desc">{{ $keluhan->deskripsi ?? $keluhan->isi ?? '-' }}</div>
              <div class="kel-date"><i class="bi bi-clock me-1"></i>{{ \Carbon\Carbon::parse($keluhan->created_at)->translatedFormat('d M Y, H:i') }}</div>
            </div>
            <div class="kel-card-foot">
              <a href="{{ route('owner.keluhan.show', $keluhan->id_keluhan) }}" class="btn-detail">
                <i class="bi bi-eye"></i> Lihat Detail
              </a>
            </div>
          </div>
          @endforeach
        </div>
      @else
        <div class="empty-box">
          <i class="bi bi-chat-left-text"></i>
          <p style="font-size:.85rem;">Belum ada keluhan dari penghuni.</p>
        </div>
      @endif

    </div>

    <footer class="owner-footer">
      &copy; {{ date('Y') }} KostFinder &mdash; Panel Pemilik Kost
    </footer>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function toggleSidebar() {
      document.getElementById('sidebar').classList.toggle('collapsed');
      document.getElementById('mainContent').classList.toggle('collapsed');
    }
  </script>
</body>
</html>