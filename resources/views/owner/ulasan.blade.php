<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ulasan - KostFinder</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    :root {
      --sidebar-w: 220px;
      --sidebar-col: 64px;
      --primary: #e8401c;
      --primary-light: #fff3f0;
      --dark: #1e2d3d;
      --bg: #f0f4f8;
    }
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg); display: flex; min-height: 100vh; }

    /* ── MAIN LAYOUT ── */
    .main { margin-left: var(--sidebar-w); flex: 1; transition: margin-left .3s ease; display: flex; flex-direction: column; min-height: 100vh; }
    .main.collapsed { margin-left: var(--sidebar-col); }

    /* ── TOPBAR ── */
    .topbar { background: #fff; height: 60px; padding: 0 1.5rem; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e4e9f0; position: sticky; top: 0; z-index: 100; }
    .topbar-left h5 { font-size: .98rem; font-weight: 800; color: var(--dark); margin: 0; }
    .topbar-left p { font-size: .72rem; color: #8fa3b8; margin: 0; }

    /* ── CONTENT ── */
    .content { padding: 1.6rem; flex: 1; }
    .owner-footer { background: #fff; border-top: 1px solid #e4e9f0; padding: .8rem 1.5rem; text-align: center; color: #8fa3b8; font-size: .72rem; }

    /* ── SIDEBAR ── */
    .sidebar { width: var(--sidebar-w); min-height: 100vh; background: var(--dark); position: fixed; top: 0; left: 0; display: flex; flex-direction: column; z-index: 200; transition: width .3s ease; overflow: hidden; }
    .sidebar.collapsed { width: var(--sidebar-col); }
    .sidebar-brand { padding: 1.2rem .9rem; border-bottom: 1px solid rgba(255,255,255,.08); display: flex; align-items: center; gap: .6rem; min-height: 60px; white-space: nowrap; }
    .brand-icon { width: 34px; height: 34px; flex-shrink: 0; background: var(--primary); border-radius: .5rem; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; }
    .brand-text .name { font-size: 1rem; font-weight: 800; color: #fff; }
    .brand-text .name span { color: var(--primary); }
    .brand-text .sub { font-size: .65rem; color: #7a92aa; }
    .sidebar.collapsed .brand-text { opacity: 0; width: 0; }
    .sidebar-menu { padding: .7rem .5rem; flex: 1; }
    .menu-label { font-size: .6rem; font-weight: 700; letter-spacing: .1em; color: #7a92aa; padding: .5rem .5rem .2rem; white-space: nowrap; transition: opacity .2s; }
    .sidebar.collapsed .menu-label { opacity: 0; }
    .menu-item { display: flex; align-items: center; gap: .65rem; padding: .58rem .65rem; border-radius: .55rem; color: #a0b4c4; text-decoration: none; font-size: .82rem; font-weight: 500; margin-bottom: .1rem; transition: all .2s; white-space: nowrap; cursor: pointer; border: 0; background: none; width: 100%; text-align: left; }
    .menu-item i { font-size: .95rem; width: 20px; flex-shrink: 0; }
    .menu-item span { overflow: hidden; transition: opacity .2s; }
    .sidebar.collapsed .menu-item span { opacity: 0; width: 0; }
    .menu-item:hover { background: rgba(255,255,255,.07); color: #fff; }
    .menu-item.active { background: var(--primary); color: #fff; }
    .menu-item.logout { color: #f87171; }
    .menu-item.logout:hover { background: rgba(248,113,113,.1); }
    .sidebar-user { padding: .85rem .9rem; border-top: 1px solid rgba(255,255,255,.08); display: flex; align-items: center; gap: .6rem; white-space: nowrap; }
    .user-avatar { width: 32px; height: 32px; border-radius: 50%; background: var(--primary); color: #fff; font-weight: 700; font-size: .8rem; flex-shrink: 0; display: flex; align-items: center; justify-content: center; }
    .user-info { overflow: hidden; transition: opacity .2s; }
    .sidebar.collapsed .user-info { opacity: 0; width: 0; }
    .user-name { color: #fff; font-size: .8rem; font-weight: 600; }
    .user-role { color: #7a92aa; font-size: .68rem; }

    /* ── PAGE HEADER ── */
    .page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.4rem; }
    .page-header-left h4 { font-size: 1.2rem; font-weight: 800; color: var(--dark); margin: 0; }
    .page-header-left p { font-size: .78rem; color: #8fa3b8; margin: .2rem 0 0; }

    /* ── STAT CARDS ── */
    .stat-cards { display: grid; grid-template-columns: repeat(4, 1fr); gap: .85rem; margin-bottom: 1.4rem; }
    .stat-card { background: #fff; border-radius: 14px; padding: 1rem 1.1rem; border: 1px solid #e4e9f0; display: flex; align-items: center; gap: .85rem; transition: box-shadow .2s; }
    .stat-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,.07); }
    .stat-card-icon { width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.15rem; flex-shrink: 0; }
    .stat-card-icon.rating { background: #fff8e6; color: #f59e0b; }
    .stat-card-icon.unreplied { background: #fef2f2; color: #ef4444; }
    .stat-card-icon.pending { background: #fffbeb; color: #f59e0b; }
    .stat-card-icon.total { background: #f0f9ff; color: #0ea5e9; }
    .stat-card-val { font-size: 1.5rem; font-weight: 800; color: var(--dark); line-height: 1; }
    .stat-card-val.text-warn { color: #f59e0b; }
    .stat-card-val.text-red { color: #ef4444; }
    .stat-card-val.text-sky { color: #0ea5e9; }
    .stat-card-lbl { font-size: .7rem; color: #8fa3b8; margin-top: 3px; }

    /* ── PANEL CARDS ── */
    .panel-card { background: #fff; border-radius: 16px; border: 1px solid #e4e9f0; overflow: hidden; }
    .panel-card-head { padding: 1rem 1.3rem; border-bottom: 1px solid #f0f4f8; display: flex; align-items: center; justify-content: space-between; }
    .panel-card-head h6 { font-size: .92rem; font-weight: 800; color: var(--dark); margin: 0; }
    .panel-card-body { padding: 1.1rem 1.3rem; }

    /* ── TABS ── */
    .custom-tabs { display: flex; gap: .3rem; border-bottom: 2px solid #f0f4f8; margin-bottom: 1rem; }
    .custom-tab { padding: .5rem .9rem; font-size: .8rem; font-weight: 600; color: #8fa3b8; border: none; background: none; cursor: pointer; border-bottom: 2px solid transparent; margin-bottom: -2px; border-radius: 6px 6px 0 0; transition: all .2s; }
    .custom-tab:hover { color: var(--dark); background: #f8fafc; }
    .custom-tab.active { color: var(--primary); border-bottom-color: var(--primary); background: var(--primary-light); }

    /* ── STAR FILTER ── */
    .star-filters { display: flex; flex-wrap: wrap; gap: .4rem; margin-bottom: 1rem; }
    .star-filter-btn { border: 1.5px solid #e4e9f0; background: #fff; border-radius: 99px; padding: 4px 13px; font-size: .76rem; cursor: pointer; color: #64748b; font-weight: 500; transition: all .15s; }
    .star-filter-btn.active { background: #fef3c7; border-color: #f59e0b; color: #92400e; font-weight: 700; }
    .star-filter-btn:hover:not(.active) { border-color: #cbd5e1; background: #f8fafc; }

    /* ── REVIEW CARDS ── */
    .review-card { background: #fff; border: 1.5px solid #e4e9f0; border-radius: 12px; padding: 1rem 1.1rem; margin-bottom: .7rem; transition: box-shadow .2s; }
    .review-card:hover { box-shadow: 0 3px 12px rgba(0,0,0,.06); }
    .review-card.pending-card { border-color: #fbbf24; background: #fffbeb; }
    .review-avatar { width: 36px; height: 36px; border-radius: 50%; background: #dbeafe; color: #1d4ed8; font-weight: 700; font-size: .8rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .review-name { font-size: .85rem; font-weight: 700; color: var(--dark); }
    .review-meta { font-size: .71rem; color: #94a3b8; margin-top: 1px; }
    .star-display { color: #f59e0b; font-size: .9rem; letter-spacing: 1px; }
    .review-comment { font-size: .83rem; color: #475569; line-height: 1.65; margin: .5rem 0 0; }
    .review-comment::before { content: '"'; }
    .review-comment::after { content: '"'; }
    .reply-box { background: #f0f9ff; border-left: 3px solid #3b82f6; border-radius: 0 8px 8px 0; padding: .6rem .9rem; margin-top: .75rem; }
    .reply-label { font-size: .7rem; font-weight: 700; color: #3b82f6; margin-bottom: 3px; }
    .reply-text { font-size: .82rem; color: #334155; }
    .pending-blur { filter: blur(4px); user-select: none; pointer-events: none; }
    .reply-form-wrap { margin-top: .8rem; }
    .reply-form-wrap .form-control { font-size: .82rem; border-color: #e4e9f0; resize: none; }
    .reply-form-wrap .form-control:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(232,64,28,.1); }
    .btn-reply { background: var(--primary); color: #fff; border: none; border-radius: 8px; padding: 6px 14px; font-size: .78rem; font-weight: 700; cursor: pointer; transition: opacity .15s; white-space: nowrap; }
    .btn-reply:hover { opacity: .88; }
    .btn-report { background: transparent; border: 1.5px solid #fca5a5; color: #ef4444; border-radius: 8px; padding: 5px 12px; font-size: .76rem; font-weight: 600; cursor: pointer; transition: all .15s; white-space: nowrap; }
    .btn-report:hover { background: #fef2f2; }
    .empty-state { text-align: center; padding: 2.5rem 1rem; color: #94a3b8; }
    .empty-state i { font-size: 2.2rem; display: block; margin-bottom: .6rem; }
    .empty-state p { font-size: .83rem; margin: 0; }

    /* ── RATING DISTRIBUTION ── */
    .rating-big { font-size: 2.8rem; font-weight: 800; color: var(--dark); line-height: 1; }
    .rating-stars { color: #f59e0b; font-size: 1rem; letter-spacing: 2px; }
    .rating-count { font-size: .72rem; color: #94a3b8; margin-top: 3px; }
    .dist-row { display: flex; align-items: center; gap: .6rem; margin-bottom: .45rem; cursor: pointer; }
    .dist-row:hover .dist-bar-fill { filter: brightness(.9); }
    .dist-num { font-size: .75rem; color: #64748b; width: 10px; text-align: right; flex-shrink: 0; }
    .dist-bar { flex: 1; height: 7px; background: #f0f4f8; border-radius: 4px; overflow: hidden; }
    .dist-bar-fill { height: 100%; background: linear-gradient(90deg, #f59e0b, #fbbf24); border-radius: 4px; transition: width .4s ease; }
    .dist-cnt { font-size: .72rem; color: #94a3b8; width: 18px; flex-shrink: 0; }
    .dist-hint { font-size: .68rem; color: #b0bec5; margin-top: .4rem; }

    /* ── STAR PICKER (feedback form) ── */
    .star-picker { display: flex; gap: 6px; }
    .star-pick { font-size: 1.9rem; cursor: pointer; color: #d1d5db; transition: color .15s, transform .15s; user-select: none; }
    .star-pick.active { color: #f59e0b; }
    .star-pick:hover { transform: scale(1.2); }
    .star-label { font-size: .82rem; font-weight: 700; color: #f59e0b; }

    /* ── FEEDBACK EXISTING ── */
    .feedback-existing { background: #f8fafc; border-radius: 12px; padding: 1rem 1.1rem; border: 1px solid #e4e9f0; }
    .feedback-rating-row { display: flex; align-items: center; gap: .7rem; margin-bottom: .6rem; }

    /* ── RESPONSIVE ── */
    @media (max-width: 991px) {
      .stat-cards { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 575px) {
      .stat-cards { grid-template-columns: 1fr 1fr; }
      .content { padding: 1rem; }
    }
  </style>
</head>
<body>

  @include('owner._sidebar')

  <div class="main" id="mainContent">

    @include('owner._navbar')

    <div class="content">

      {{-- PAGE HEADER --}}
      <div class="page-header">
        <div class="page-header-left">
          <h4><i class="bi bi-star-half me-2" style="color:var(--primary);"></i>Ulasan</h4>
          <p>Kelola ulasan penyewa dan bagikan pengalaman Anda menggunakan KostFinder.</p>
        </div>
      </div>

      {{-- ALERTS --}}
      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 small mb-3" role="alert">
          <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      @endif
      @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-3 small mb-3" role="alert">
          <i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('error') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      @endif

      {{-- STAT CARDS --}}
      <div class="stat-cards">
        <div class="stat-card">
          <div class="stat-card-icon rating"><i class="bi bi-star-fill"></i></div>
          <div>
            <div class="stat-card-val text-warn">{{ number_format($rata_rating, 1) }}</div>
            <div class="stat-card-lbl">Rating rata-rata</div>
          </div>
        </div>
        <div class="stat-card">
          <div class="stat-card-icon unreplied"><i class="bi bi-chat-left-dots"></i></div>
          <div>
            <div class="stat-card-val text-red">{{ $belum_dibalas }}</div>
            <div class="stat-card-lbl">Belum dibalas</div>
          </div>
        </div>
        <div class="stat-card">
          <div class="stat-card-icon pending"><i class="bi bi-hourglass-split"></i></div>
          <div>
            <div class="stat-card-val text-warn">{{ $pending_reviews->count() }}</div>
            <div class="stat-card-lbl">Menunggu verifikasi</div>
          </div>
        </div>
        <div class="stat-card">
          <div class="stat-card-icon total"><i class="bi bi-chat-square-text"></i></div>
          <div>
            <div class="stat-card-val text-sky">{{ $reviews->count() }}</div>
            <div class="stat-card-lbl">Total ulasan</div>
          </div>
        </div>
      </div>

      {{-- MAIN 2-COLUMN LAYOUT --}}
      <div class="row g-4">

        {{-- ── KOLOM KIRI: ULASAN PENYEWA ── --}}
        <div class="col-lg-7">
          <div class="panel-card">
            <div class="panel-card-head">
              <h6><i class="bi bi-people me-2" style="color:var(--primary);"></i>Ulasan Penyewa ke Kos</h6>
              @if($belum_dibalas > 0)
                <span class="badge" style="background:#fef2f2;color:#ef4444;font-size:.7rem;font-weight:700;padding:4px 10px;border-radius:99px;">
                  {{ $belum_dibalas }} belum dibalas
                </span>
              @endif
            </div>
            <div class="panel-card-body">

              {{-- CUSTOM TABS --}}
              <div class="custom-tabs">
                <button class="custom-tab active" onclick="switchTab(this, 'tab-belum')">
                  <i class="bi bi-clock me-1"></i>Belum Dibalas
                  @if($belum_dibalas > 0)
                    <span class="badge bg-danger ms-1" style="font-size:.65rem;">{{ $belum_dibalas }}</span>
                  @endif
                </button>
                <button class="custom-tab" onclick="switchTab(this, 'tab-semua')">
                  <i class="bi bi-list-ul me-1"></i>Semua
                </button>
                <button class="custom-tab" onclick="switchTab(this, 'tab-pending')">
                  <i class="bi bi-hourglass me-1"></i>Pending
                  @if($pending_reviews->count() > 0)
                    <span class="badge ms-1" style="background:#fef3c7;color:#92400e;font-size:.65rem;">{{ $pending_reviews->count() }}</span>
                  @endif
                </button>
              </div>

              {{-- ── TAB: BELUM DIBALAS ── --}}
              <div id="tab-belum" class="tab-content-pane">
                <div class="star-filters">
                  <button class="star-filter-btn active" onclick="filterStar(this,'belum',0)">Semua</button>
                  @for($s = 5; $s >= 1; $s--)
                    <button class="star-filter-btn" onclick="filterStar(this,'belum',{{ $s }})">★ {{ $s }}</button>
                  @endfor
                </div>

                @php $belumList = $reviews->whereNull('reply'); @endphp
                @forelse($belumList as $rev)
                  <div class="review-card" data-star-belum="{{ $rev->rating }}">
                    <div class="d-flex justify-content-between align-items-start">
                      <div class="d-flex align-items-center gap-2">
                        <div class="review-avatar">{{ strtoupper(substr($rev->user->name ?? 'U', 0, 2)) }}</div>
                        <div>
                          <div class="review-name">{{ $rev->user->name ?? 'Pengguna' }}</div>
                          <div class="review-meta">
                            <i class="bi bi-house-door me-1"></i>{{ $rev->kost->nama_kost ?? '' }}
                            <span class="mx-1">·</span>
                            <i class="bi bi-clock me-1"></i>{{ $rev->created_at->diffForHumans() }}
                          </div>
                        </div>
                      </div>
                      <div class="text-end flex-shrink-0 ms-2">
                        <div class="star-display">{{ str_repeat('★', $rev->rating) }}{{ str_repeat('☆', 5 - $rev->rating) }}</div>
                        <span class="badge" style="background:#fef2f2;color:#ef4444;font-size:.66rem;margin-top:3px;">Belum dibalas</span>
                      </div>
                    </div>
                    <p class="review-comment">{{ $rev->komentar }}</p>
                    <div class="reply-form-wrap">
                      <form action="{{ route('owner.review.reply', $rev->id) }}" method="POST">
                        @csrf
                        <div class="d-flex gap-2 align-items-start">
                          <textarea name="balasan" rows="2" class="form-control form-control-sm rounded-3"
                            placeholder="Tulis balasan Anda..." required minlength="5" maxlength="500"></textarea>
                          <div class="d-flex flex-column gap-1 flex-shrink-0">
                            <button type="submit" class="btn-reply"><i class="bi bi-send me-1"></i>Balas</button>
                            <button type="button" class="btn-report" onclick="openLaporModal({{ $rev->id }})">Laporkan</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                @empty
                  <div class="empty-state">
                    <i class="bi bi-check-circle text-success"></i>
                    <p>Semua ulasan sudah dibalas!</p>
                  </div>
                @endforelse
                <div id="empty-belum-filter" class="empty-state" style="display:none;">
                  <i class="bi bi-search"></i>
                  <p>Tidak ada ulasan dengan rating ini</p>
                </div>
              </div>

              {{-- ── TAB: SEMUA ── --}}
              <div id="tab-semua" class="tab-content-pane" style="display:none;">
                <div class="star-filters">
                  <button class="star-filter-btn active" onclick="filterStar(this,'semua',0)">Semua</button>
                  @for($s = 5; $s >= 1; $s--)
                    <button class="star-filter-btn" onclick="filterStar(this,'semua',{{ $s }})">★ {{ $s }}</button>
                  @endfor
                </div>

                @forelse($reviews as $rev)
                  <div class="review-card" data-star-semua="{{ $rev->rating }}">
                    <div class="d-flex justify-content-between align-items-start">
                      <div class="d-flex align-items-center gap-2">
                        <div class="review-avatar">{{ strtoupper(substr($rev->user->name ?? 'U', 0, 2)) }}</div>
                        <div>
                          <div class="review-name">{{ $rev->user->name ?? 'Pengguna' }}</div>
                          <div class="review-meta">
                            <i class="bi bi-house-door me-1"></i>{{ $rev->kost->nama_kost ?? '' }}
                            <span class="mx-1">·</span>
                            <i class="bi bi-clock me-1"></i>{{ $rev->created_at->diffForHumans() }}
                          </div>
                        </div>
                      </div>
                      <div class="text-end flex-shrink-0 ms-2">
                        <div class="star-display">{{ str_repeat('★', $rev->rating) }}{{ str_repeat('☆', 5 - $rev->rating) }}</div>
                        @if($rev->reply)
                          <span class="badge" style="background:#f0fdf4;color:#16a34a;font-size:.66rem;margin-top:3px;">Sudah dibalas</span>
                        @else
                          <span class="badge" style="background:#fef2f2;color:#ef4444;font-size:.66rem;margin-top:3px;">Belum dibalas</span>
                        @endif
                      </div>
                    </div>
                    <p class="review-comment">{{ $rev->komentar }}</p>
                    @if($rev->reply)
                      <div class="reply-box">
                        <div class="reply-label"><i class="bi bi-reply-fill me-1"></i>Balasan Anda</div>
                        <div class="reply-text">{{ $rev->reply->balasan }}</div>
                      </div>
                    @else
                      <div class="reply-form-wrap">
                        <form action="{{ route('owner.review.reply', $rev->id) }}" method="POST">
                          @csrf
                          <div class="d-flex gap-2 align-items-start">
                            <textarea name="balasan" rows="2" class="form-control form-control-sm rounded-3"
                              placeholder="Tulis balasan Anda..." required minlength="5" maxlength="500"></textarea>
                            <button type="submit" class="btn-reply flex-shrink-0"><i class="bi bi-send me-1"></i>Balas</button>
                          </div>
                        </form>
                      </div>
                    @endif
                  </div>
                @empty
                  <div class="empty-state">
                    <i class="bi bi-chat-square-text"></i>
                    <p>Belum ada ulasan yang masuk.</p>
                  </div>
                @endforelse
                <div id="empty-semua-filter" class="empty-state" style="display:none;">
                  <i class="bi bi-search"></i>
                  <p>Tidak ada ulasan dengan rating ini</p>
                </div>
              </div>

              {{-- ── TAB: PENDING ── --}}
              <div id="tab-pending" class="tab-content-pane" style="display:none;">
                <div class="alert rounded-3 small py-2 mb-3 d-flex align-items-center gap-2"
                  style="background:#fffbeb;border:1px solid #fde68a;color:#92400e;">
                  <i class="bi bi-info-circle-fill" style="color:#f59e0b;font-size:.95rem;"></i>
                  Ulasan ini sedang ditinjau admin sebelum ditampilkan ke publik.
                </div>

                @forelse($pending_reviews as $rev)
                  <div class="review-card pending-card">
                    <div class="d-flex justify-content-between align-items-start">
                      <div class="d-flex align-items-center gap-2">
                        <div class="review-avatar" style="background:#e5e7eb;color:#6b7280;">??</div>
                        <div>
                          <div class="review-name">Nama disembunyikan</div>
                          <div class="review-meta"><i class="bi bi-clock me-1"></i>{{ $rev->created_at->diffForHumans() }}</div>
                        </div>
                      </div>
                      <div class="text-end flex-shrink-0 ms-2">
                        <div class="star-display">{{ str_repeat('★', $rev->rating) }}{{ str_repeat('☆', 5 - $rev->rating) }}</div>
                        <span class="badge" style="background:#fef3c7;color:#92400e;font-size:.66rem;margin-top:3px;">Pending verifikasi</span>
                      </div>
                    </div>
                    <p class="review-comment pending-blur">{{ $rev->komentar }}</p>
                    <div class="small mt-2" style="color:#d97706;">
                      <i class="bi bi-eye-slash me-1"></i>Konten disamarkan sampai admin selesai memverifikasi
                    </div>
                  </div>
                @empty
                  <div class="empty-state">
                    <i class="bi bi-clock"></i>
                    <p>Tidak ada ulasan yang sedang pending.</p>
                  </div>
                @endforelse
              </div>

            </div>
          </div>
        </div>

        {{-- ── KOLOM KANAN ── --}}
        <div class="col-lg-5 d-flex flex-column gap-4">

          {{-- DISTRIBUSI RATING --}}
          <div class="panel-card">
            <div class="panel-card-head">
              <h6><i class="bi bi-bar-chart me-2" style="color:var(--primary);"></i>Distribusi Rating</h6>
            </div>
            <div class="panel-card-body">
              <div class="d-flex gap-4 align-items-center">
                <div class="text-center flex-shrink-0">
                  <div class="rating-big">{{ number_format($rata_rating, 1) }}</div>
                  <div class="rating-stars">
                    @for($i = 1; $i <= 5; $i++){{ $i <= round($rata_rating) ? '★' : '☆' }}@endfor
                  </div>
                  <div class="rating-count">{{ $reviews->count() }} terverifikasi</div>
                </div>
                <div class="flex-fill">
                  @for($s = 5; $s >= 1; $s--)
                    @php $cnt = $reviews->where('rating', $s)->count(); $pct = $reviews->count() > 0 ? ($cnt / $reviews->count()) * 100 : 0; @endphp
                    <div class="dist-row" onclick="filterByBar({{ $s }})">
                      <div class="dist-num">{{ $s }}</div>
                      <div class="dist-bar">
                        <div class="dist-bar-fill" style="width:{{ $pct }}%;"></div>
                      </div>
                      <div class="dist-cnt">{{ $cnt }}</div>
                    </div>
                  @endfor
                  <div class="dist-hint"><i class="bi bi-cursor me-1"></i>Klik bar untuk filter ulasan</div>
                </div>
              </div>
            </div>
          </div>

          {{-- FEEDBACK KE PLATFORM --}}
          <div class="panel-card">
            <div class="panel-card-head">
              <h6><i class="bi bi-megaphone me-2" style="color:var(--primary);"></i>Feedback ke Platform</h6>
            </div>
            <div class="panel-card-body">
              <p class="text-muted small mb-3" style="font-size:.78rem;">Bagaimana pengalaman Anda menggunakan KostFinder?</p>

              @if($owner_review)
                <div class="feedback-existing">
                  <div class="feedback-rating-row">
                    <div style="font-size:1rem;color:#f59e0b;">
                      @for($i = 1; $i <= 5; $i++){{ $i <= $owner_review->rating ? '★' : '☆' }}@endfor
                    </div>
                    @if($owner_review->status === 'pending')
                      <span class="badge" style="background:#fef3c7;color:#92400e;font-size:.7rem;">Menunggu persetujuan</span>
                    @elseif($owner_review->status === 'approved')
                      <span class="badge" style="background:#f0fdf4;color:#16a34a;font-size:.7rem;">Ditampilkan</span>
                    @else
                      <span class="badge" style="background:#fef2f2;color:#ef4444;font-size:.7rem;">Ditolak</span>
                    @endif
                  </div>
                  <p style="font-size:.84rem;line-height:1.7;color:#334155;">"{{ $owner_review->ulasan }}"</p>
                  <div class="text-muted small mt-2" style="font-size:.72rem;">
                    <i class="bi bi-geo-alt me-1"></i>{{ $owner_review->kota }}
                    <span class="mx-2">·</span>
                    <i class="bi bi-calendar me-1"></i>{{ $owner_review->created_at->format('d M Y') }}
                  </div>
                  @if($owner_review->status === 'rejected')
                    <div class="alert alert-warning mt-3 mb-0 rounded-3 small py-2">
                      <i class="bi bi-info-circle me-1"></i>Ulasan tidak disetujui. Hubungi admin untuk info lebih lanjut.
                    </div>
                  @endif
                </div>
              @else
                <form action="{{ route('owner.review.store') }}" method="POST">
                  @csrf
                  @php $kosts = \App\Models\Kost::where('owner_id', auth()->id())->get(); @endphp

                  {{-- Pilih Kos --}}
                  <div class="mb-3">
                    <label class="form-label fw-semibold" style="font-size:.8rem;">Nama Kos <span class="text-danger">*</span></label>
                    <select name="lokasi_kos" class="form-select form-select-sm rounded-3 @error('lokasi_kos') is-invalid @enderror" onchange="updateLokasi(this)">
                      <option value="">-- Pilih Kos Anda --</option>
                      @foreach($kosts as $kost)
                        <option value="{{ $kost->nama_kost }}" data-kota="{{ $kost->kota }}" {{ old('lokasi_kos') == $kost->nama_kost ? 'selected' : '' }}>
                          {{ $kost->nama_kost }}
                        </option>
                      @endforeach
                    </select>
                    @error('lokasi_kos')<div class="invalid-feedback">{{ $message }}</div>@enderror
                  </div>

                  {{-- Lokasi --}}
                  <div class="mb-3">
                    <label class="form-label fw-semibold" style="font-size:.8rem;">Lokasi <span class="text-danger">*</span></label>
                    <input type="text" name="kota" id="inputKota"
                      class="form-control form-control-sm rounded-3 @error('kota') is-invalid @enderror"
                      placeholder="contoh: Lowokwaru, Malang" value="{{ old('kota') }}">
                    @error('kota')<div class="invalid-feedback">{{ $message }}</div>@enderror
                  </div>

                  {{-- Rating --}}
                  <div class="mb-3">
                    <label class="form-label fw-semibold" style="font-size:.8rem;">Rating <span class="text-danger">*</span></label>
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                      <div class="star-picker" id="starPicker">
                        @for($i = 1; $i <= 5; $i++)
                          <span class="star-pick {{ $i <= old('rating', 5) ? 'active' : '' }}" data-val="{{ $i }}" onclick="pickStar({{ $i }})">★</span>
                        @endfor
                      </div>
                      <span class="star-label" id="starLabel">Sangat Bagus</span>
                    </div>
                    <input type="hidden" name="rating" id="ratingInput" value="{{ old('rating', 5) }}">
                    @error('rating')<div class="text-danger small mt-1" style="font-size:.75rem;">{{ $message }}</div>@enderror
                  </div>

                  {{-- Ulasan --}}
                  <div class="mb-3">
                    <label class="form-label fw-semibold" style="font-size:.8rem;">Ulasan <span class="text-danger">*</span></label>
                    <textarea name="ulasan" rows="3" id="ulasanText"
                      class="form-control form-control-sm rounded-3 @error('ulasan') is-invalid @enderror"
                      placeholder="Ceritakan pengalaman Anda menggunakan KostFinder... (min 20 karakter)"
                      maxlength="500">{{ old('ulasan') }}</textarea>
                    <div class="d-flex justify-content-between mt-1">
                      @error('ulasan')
                        <div class="text-danger" style="font-size:.73rem;">{{ $message }}</div>
                      @else
                        <small class="text-muted" style="font-size:.72rem;">Minimal 20 karakter</small>
                      @enderror
                      <small class="text-muted" id="charCount" style="font-size:.72rem;">0/500</small>
                    </div>
                  </div>

                  {{-- Info --}}
                  <div class="rounded-3 small mb-3 py-2 px-3 d-flex align-items-center gap-2"
                    style="background:#f0fdf4;border:1px solid #bbf7d0;color:#166534;font-size:.77rem;">
                    <i class="bi bi-info-circle-fill" style="color:#16a34a;"></i>
                    Ditampilkan setelah disetujui admin (1×24 jam).
                  </div>

                  <button type="submit" class="btn w-100 rounded-3 fw-bold" style="background:var(--primary);color:#fff;font-size:.85rem;">
                    <i class="bi bi-send me-2"></i>Kirim Feedback
                  </button>
                </form>
              @endif
            </div>
          </div>

        </div>
      </div>
    </div>

    <footer class="owner-footer">
      © {{ date('Y') }} KostFinder — Panel Pemilik Kost. All rights reserved.
    </footer>
  </div>

  {{-- MODAL LAPORKAN --}}
  <div class="modal fade" id="laporModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content rounded-4 border-0 shadow">
        <div class="modal-header border-0 pb-0">
          <h6 class="modal-title fw-bold"><i class="bi bi-flag me-2 text-danger"></i>Laporkan Ulasan</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <form id="laporForm" method="POST">
          @csrf
          <div class="modal-body">
            <p class="text-muted small mb-3">Jelaskan mengapa ulasan ini tidak pantas ditampilkan.</p>
            <textarea name="report_reason" rows="4" class="form-control rounded-3"
              placeholder="Contoh: ulasan mengandung informasi palsu atau fitnah..." required minlength="10" maxlength="300"></textarea>
          </div>
          <div class="modal-footer border-0 pt-0">
            <button type="button" class="btn btn-sm btn-secondary rounded-3" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-sm btn-danger rounded-3 fw-semibold">Kirim Laporan</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // ── SIDEBAR TOGGLE ──
    function toggleSidebar() {
      document.getElementById('sidebar').classList.toggle('collapsed');
      document.getElementById('mainContent').classList.toggle('collapsed');
    }

    // ── CUSTOM TABS ──
    function switchTab(btn, tabId) {
      document.querySelectorAll('.custom-tab').forEach(t => t.classList.remove('active'));
      document.querySelectorAll('.tab-content-pane').forEach(p => p.style.display = 'none');
      btn.classList.add('active');
      document.getElementById(tabId).style.display = 'block';
    }

    // ── KOS SELECT ──
    function updateLokasi(sel) {
      const opt = sel.options[sel.selectedIndex];
      const el = document.getElementById('inputKota');
      if (el) el.value = opt.dataset.kota || '';
    }
    const sel0 = document.querySelector('select[name=lokasi_kos]');
    if (sel0 && sel0.value) updateLokasi(sel0);

    // ── STAR PICKER ──
    const starLabels = {1:'Kurang',2:'Cukup',3:'Lumayan',4:'Bagus',5:'Sangat Bagus'};
    function pickStar(val) {
      document.getElementById('ratingInput').value = val;
      document.getElementById('starLabel').textContent = starLabels[val];
      document.querySelectorAll('.star-pick').forEach((s, i) => s.classList.toggle('active', i < val));
    }
    const ri = document.getElementById('ratingInput');
    if (ri) pickStar(parseInt(ri.value) || 5);

    // ── CHAR COUNT ──
    const ta = document.getElementById('ulasanText');
    const cc = document.getElementById('charCount');
    if (ta && cc) {
      ta.addEventListener('input', () => cc.textContent = ta.value.length + '/500');
    }

    // ── MODAL LAPORKAN ──
    function openLaporModal(reviewId) {
      document.getElementById('laporForm').action = '/owner/ulasan/' + reviewId + '/report';
      new bootstrap.Modal(document.getElementById('laporModal')).show();
    }

    // ── FILTER BINTANG ──
    function filterStar(btn, tab, star) {
      const scope = '#tab-' + tab;
      const attr = 'data-star-' + tab;
      const emptyId = 'empty-' + tab + '-filter';

      document.querySelectorAll(scope + ' .star-filter-btn').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');

      let visible = 0;
      document.querySelectorAll(scope + ' .review-card').forEach(card => {
        const s = parseInt(card.getAttribute(attr));
        const show = star === 0 || s === star;
        card.style.display = show ? 'block' : 'none';
        if (show) visible++;
      });
      const emptyEl = document.getElementById(emptyId);
      if (emptyEl) emptyEl.style.display = visible === 0 ? 'flex' : 'none';
    }

    // ── KLIK BAR DISTRIBUSI → filter tab semua ──
    function filterByBar(star) {
      switchTab(document.querySelectorAll('.custom-tab')[1], 'tab-semua');
      setTimeout(() => {
        const btns = document.querySelectorAll('#tab-semua .star-filter-btn');
        const starMap = {5:1, 4:2, 3:3, 2:4, 1:5};
        if (btns[starMap[star]]) filterStar(btns[starMap[star]], 'semua', star);
      }, 100);
    }
  </script>
</body>
</html>