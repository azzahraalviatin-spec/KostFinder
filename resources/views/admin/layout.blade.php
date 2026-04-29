<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - KostFinder</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root { --sidebar-w:220px; --sidebar-col:64px; --primary:#e8401c; --dark:#1e2d3d; --bg:#f0f4f8; }
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Plus Jakarta Sans',sans-serif; background:var(--bg); display:flex; min-height:100vh; }
        .sidebar { width:var(--sidebar-w); min-height:100vh; background:var(--dark); position:fixed; top:0; left:0; display:flex; flex-direction:column; z-index:200; transition:width .25s ease; overflow:hidden; }
        .sidebar.collapsed { width:var(--sidebar-col); }
        .sidebar-brand { padding:1.2rem .9rem; border-bottom:1px solid rgba(255,255,255,.08); display:flex; align-items:center; gap:.6rem; min-height:64px; white-space:nowrap; }
        .brand-icon { width:34px; height:34px; background:var(--primary); border-radius:.5rem; display:flex; align-items:center; justify-content:center; color:#fff; font-size:1rem; flex-shrink:0; }
        .brand-text { overflow:hidden; transition:opacity .2s; }
        .sidebar.collapsed .brand-text { opacity:0; width:0; }
        .brand-text .name { font-size:1rem; font-weight:800; color:#fff; }
        .brand-text .name span { color:var(--primary); }
        .brand-text .sub { font-size:.66rem; color:#7a92aa; }
        .sidebar-menu { padding:.7rem .5rem; flex:1; }
        .menu-label { font-size:.62rem; font-weight:700; letter-spacing:.1em; color:#7a92aa; padding:.45rem .5rem .2rem; white-space:nowrap; transition:opacity .2s; }
        .sidebar.collapsed .menu-label { opacity:0; }
        .menu-item { display:flex; align-items:center; gap:.65rem; padding:.6rem .65rem; border-radius:.55rem; color:#a0b4c4; text-decoration:none; font-size:.83rem; font-weight:500; margin-bottom:.12rem; white-space:nowrap; border:0; background:none; width:100%; text-align:left; }
        .menu-item i { font-size:.95rem; width:20px; flex-shrink:0; }
        .menu-item span { overflow:hidden; transition:opacity .2s; }
        .sidebar.collapsed .menu-item span { opacity:0; width:0; }
        .menu-item:hover { background:rgba(255,255,255,.07); color:#fff; }
        .menu-item.active { background:var(--primary); color:#fff; }
        .menu-item.logout { color:#f87171; }
        .menu-item.logout:hover { background:rgba(248,113,113,.12); }
        .sidebar-user { padding:.85rem .9rem; border-top:1px solid rgba(255,255,255,.08); display:flex; align-items:center; gap:.6rem; white-space:nowrap; }
        .user-avatar { width:32px; height:32px; border-radius:50%; background:var(--primary); color:#fff; font-weight:700; font-size:.8rem; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
        .user-info { overflow:hidden; transition:opacity .2s; }
        .sidebar.collapsed .user-info { opacity:0; width:0; }
        .user-name { color:#fff; font-size:.8rem; font-weight:600; }
        .user-role { color:#7a92aa; font-size:.68rem; }
        .main { margin-left:var(--sidebar-w); flex:1; transition:margin-left .25s ease; display:flex; flex-direction:column; min-width:0; }
        .main.collapsed { margin-left:var(--sidebar-col); }
        .topbar { background:#fff; height:62px; padding:0 1.4rem; display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid #e4e9f0; position:sticky; top:0; z-index:100; }
        .topbar-left { display:flex; align-items:center; gap:.8rem; }
        .menu-btn { background:none; border:0; color:#556; font-size:1.25rem; cursor:pointer; display:flex; align-items:center; }
        .topbar-left h5 { font-size:.98rem; font-weight:800; color:var(--dark); margin:0; }
        .topbar-left p { font-size:.72rem; color:#8fa3b8; margin:0; }
        .topbar-right { display:flex; align-items:center; gap:.6rem; }
        .search-box { display:flex; align-items:center; gap:.5rem; background:#f0f4f8; border:1px solid #dde3ed; border-radius:.55rem; padding:.38rem .75rem; width:220px; }
        .search-box input { border:0; background:none; outline:none; font-size:.8rem; color:#333; width:100%; }
        .icon-btn { width:34px; height:34px; border-radius:.5rem; background:#f0f4f8; border:1px solid #dde3ed; display:flex; align-items:center; justify-content:center; color:#555; font-size:.9rem; text-decoration:none; }
        .icon-btn:hover { background:#e4e9f0; color:#333; }
        .content { padding:1.35rem; flex:1; }
        .stat-card { background:#fff; border-radius:.85rem; padding:1.1rem 1.2rem; border:1px solid #e4e9f0; box-shadow:0 2px 6px rgba(0,0,0,.04); display:flex; align-items:center; gap:1rem; height:100%; }
        .stat-icon { width:46px; height:46px; border-radius:.75rem; display:flex; align-items:center; justify-content:center; font-size:1.2rem; flex-shrink:0; }
        .stat-num { font-size:1.6rem; font-weight:800; color:var(--dark); line-height:1; }
        .stat-lbl { font-size:.75rem; color:#8fa3b8; margin-top:.2rem; }
        .stat-sub { font-size:.7rem; font-weight:600; margin-top:.3rem; }
        .metric-card { background:#fff; border-radius:.85rem; padding:1rem 1.1rem; border:1px solid #e4e9f0; box-shadow:0 2px 6px rgba(0,0,0,.04); }
        .metric-label { font-size:.72rem; color:#8fa3b8; text-transform:uppercase; letter-spacing:.06em; font-weight:700; }
        .metric-value { font-size:1.45rem; font-weight:800; color:var(--dark); margin-top:.2rem; }
        .section-card { background:#fff; border-radius:.85rem; border:1px solid #e4e9f0; box-shadow:0 2px 6px rgba(0,0,0,.04); overflow:hidden; }
        .section-head { padding:.9rem 1.2rem; border-bottom:1px solid #f0f3f8; display:flex; justify-content:space-between; align-items:center; }
        .section-head h6 { margin:0; font-weight:700; color:var(--dark); font-size:.87rem; }
        .link-p { color:var(--primary); font-size:.78rem; font-weight:600; text-decoration:none; }
        .link-p:hover { color:#cb3518; }
        .card-panel { background:#fff; border-radius:.85rem; border:1px solid #e4e9f0; box-shadow:0 2px 6px rgba(0,0,0,.04); padding:1rem; }
        table thead th { font-size:.68rem; font-weight:700; color:#8fa3b8; letter-spacing:.05em; border:0; padding:.6rem 1rem; background:#f8fafd; }
        table tbody td { font-size:.8rem; color:#333; padding:.65rem 1rem; border-color:#f0f3f8; vertical-align:middle; }
        .owner-footer { background:#fff; border-top:1px solid #e4e9f0; padding:.8rem 1.5rem; text-align:center; color:#8fa3b8; font-size:.72rem; }
        @media (max-width: 992px) {
            .sidebar { width:var(--sidebar-col); }
            .sidebar .brand-text, .sidebar .menu-label, .sidebar .menu-item span, .sidebar .user-info { opacity:0; width:0; }
            .main { margin-left:var(--sidebar-col); }
        }
    </style>
</head>
<body>
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="brand-icon"><i class="bi bi-shield-check"></i></div>
            <div class="brand-text">
                <div class="name">Kost<span>Finder</span></div>
                <div class="sub">Admin Panel</div>
            </div>
        </div>

        <div class="sidebar-menu">
            <div class="menu-label">MENU UTAMA</div>
            <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i><span>Dashboard</span>
            </a>
            <a href="{{ route('admin.users') }}" class="menu-item {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                <i class="bi bi-people"></i><span>Monitoring User</span>
            </a>
            <a href="{{ route('admin.owners') }}" class="menu-item {{ request()->routeIs('admin.owners*') ? 'active' : '' }}">
                <i class="bi bi-person-badge"></i><span>Monitoring Owner</span>
            </a>
            <a href="{{ route('admin.kosts') }}" class="menu-item {{ request()->routeIs('admin.kosts*') ? 'active' : '' }}">
                <i class="bi bi-house-door"></i><span>Monitoring Kos</span>
            </a>
            <a href="{{ route('admin.bookings') }}" class="menu-item {{ request()->routeIs('admin.bookings*') ? 'active' : '' }}">
                <i class="bi bi-journal-check"></i><span>Monitoring Booking</span>
            </a>

            {{-- ✅ MENU KELOLA ULASAN --}}
            <a href="{{ route('admin.reviews.index') }}" class="menu-item {{ request()->routeIs('admin.reviews*') ? 'active' : '' }}">
                <i class="bi bi-star"></i><span>Kelola Ulasan</span>
                @php
                    $pendingUlasan = \App\Models\Review::where('status','pending')->count();
                @endphp
                @if($pendingUlasan > 0)
                    <span style="margin-left:auto;background:linear-gradient(135deg,#e8401c,#ff7043);color:#fff;font-size:.6rem;font-weight:700;padding:.1rem .45rem;border-radius:999px;">
                        {{ $pendingUlasan }}
                    </span>
                @endif
            </a>
            <a href="{{ route('admin.reports') }}" class="menu-item {{ request()->routeIs('admin.reports*') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-bar-graph"></i><span>Laporan Sistem</span>
            </a>
            <a href="{{ route('admin.settings') }}" 
   class="menu-item {{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
    <i class="bi bi-gear"></i><span>Pengaturan</span>
</a> 

            <div class="menu-label">AKUN</div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="menu-item logout">
                    <i class="bi bi-box-arrow-left"></i><span>Logout</span>
                </button>
            </form>
        </div>

        <div class="sidebar-user">
            <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}</div>
            <div class="user-info">
                <div class="user-name">{{ auth()->user()->name ?? 'Admin' }}</div>
                <div class="user-role">Admin</div>
            </div>
        </div>
    </aside>

    <div class="main" id="mainContent">
        <div class="topbar">
            <div class="topbar-left">
                <button class="menu-btn" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>
                <div>
                    <h5>@yield('page_title', 'Dashboard Admin')</h5>
                    <p>{{ now()->translatedFormat('l, d F Y') }}</p>
                </div>
            </div>
            <div class="topbar-right">
                <div class="search-box">
                    <i class="bi bi-search" style="color:#8fa3b8;font-size:.85rem;"></i>
                    <input type="text" placeholder="Cari user, owner, kos..." autocomplete="off">
                </div>
                {{-- Bell Notifikasi --}}
<div class="position-relative">
    <button class="icon-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-bell"></i>
        @php $unreadCount = auth()->user()->unreadNotifications->count(); @endphp
        @if($unreadCount > 0)
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size:.55rem;">
                {{ $unreadCount > 9 ? '9+' : $unreadCount }}
            </span>
        @endif
    </button>

    <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 p-0" style="width:320px; max-height:400px; overflow-y:auto;">
        <li class="px-3 py-2 border-bottom d-flex justify-content-between align-items-center">
            <span class="fw-bold text-dark" style="font-size:.85rem;">🔔 Notifikasi</span>
            @if($unreadCount > 0)
                <a href="{{ route('admin.notifications.readAll') }}" class="text-danger" style="font-size:.75rem;">Tandai semua dibaca</a>
            @endif
        </li>

        @forelse(auth()->user()->notifications->take(10) as $notif)
            <li>
                <a href="{{ route('admin.notifications.read', $notif->id) }}"
                   class="dropdown-item px-3 py-2 {{ $notif->read_at ? '' : 'bg-light' }}">
                    <div class="d-flex gap-2 align-items-start">
                        <span style="font-size:1.2rem;">{{ $notif->data['icon'] }}</span>
                        <div>
                            <div class="fw-semibold" style="font-size:.8rem;">{{ $notif->data['judul'] }}</div>
                            <div class="text-muted" style="font-size:.75rem;">{{ $notif->data['pesan'] }}</div>
                            <div class="text-muted" style="font-size:.7rem;">{{ $notif->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                </a>
            </li>
        @empty
            <li class="text-center text-muted py-4" style="font-size:.8rem;">
                Tidak ada notifikasi
            </li>
        @endforelse
    </ul>
</div>
                <a href="{{ route('admin.reports') }}" class="icon-btn"><i class="bi bi-gear"></i></a>
            </div>
        </div>

        <div class="content">
            @if(session('status'))
                <div class="alert alert-success py-2">{{ session('status') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger py-2">{{ $errors->first() }}</div>
            @endif
            @yield('content')
        </div>

        <footer class="owner-footer">
            © {{ date('Y') }} KostFinder - Admin Panel
        </footer>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const main = document.getElementById('mainContent');
            sidebar.classList.toggle('collapsed');
            main.classList.toggle('collapsed');
        }
    </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        @stack('scripts')
</body>
</html>
