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
    :root { --sidebar-w:200px; --sidebar-col:60px; --primary:#e8401c; --dark:#1e2d3d; --bg:#f0f4f8; }
    * { margin:0; padding:0; box-sizing:border-box; }
    body { font-family:'Plus Jakarta Sans',sans-serif; background:var(--bg); display:flex; min-height:100vh; }
    .main { margin-left:var(--sidebar-w); flex:1; transition:margin-left .3s ease; display:flex; flex-direction:column; }
    .main.collapsed { margin-left:var(--sidebar-col); }
    .topbar { background:#fff; height:60px; padding:0 1.5rem; display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid #e4e9f0; position:sticky; top:0; z-index:100; }
    .topbar-left h5 { font-size:.98rem; font-weight:800; color:var(--dark); margin:0; }
    .topbar-left p { font-size:.72rem; color:#8fa3b8; margin:0; }
    .content { padding:1.4rem; flex:1; }
    .owner-footer { background:#fff; border-top:1px solid #e4e9f0; padding:.8rem 1.5rem; text-align:center; color:#8fa3b8; font-size:.72rem; }

    /* Sidebar */
    .sidebar { width:var(--sidebar-w); min-height:100vh; background:var(--dark); position:fixed; top:0; left:0; display:flex; flex-direction:column; z-index:200; transition:width .3s ease; overflow:hidden; }
    .sidebar.collapsed { width:var(--sidebar-col); }
    .sidebar-brand { padding:1.2rem .9rem; border-bottom:1px solid rgba(255,255,255,.08); display:flex; align-items:center; gap:.6rem; min-height:60px; white-space:nowrap; }
    .brand-icon { width:32px; height:32px; flex-shrink:0; background:var(--primary); border-radius:.5rem; display:flex; align-items:center; justify-content:center; font-size:1rem; }
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

    /* Star rating */
    .star-picker { display:flex; gap:6px; }
    .star-pick { font-size:2rem; cursor:pointer; color:#d1d5db; transition:color .15s, transform .15s; user-select:none; }
    .star-pick.active { color:#f59e0b; }
    .star-pick:hover { transform:scale(1.2); }
    .star-label { font-size:.85rem; font-weight:700; color:#f59e0b; min-width:100px; }

    /* Review cards */
    .review-card { background:#fff; border:1px solid #e4e9f0; border-radius:12px; padding:1rem 1.2rem; margin-bottom:.75rem; }
    .review-card.pending-card { border-color:#fbbf24; background:#fffbeb; }
    .star-display { color:#f59e0b; font-size:.95rem; }
    .reply-box { background:#f0f4f8; border-left:3px solid #3b82f6; border-radius:0 8px 8px 0; padding:.65rem 1rem; margin-top:.75rem; }
    .reply-box .reply-label { font-size:.72rem; font-weight:700; color:#3b82f6; margin-bottom:3px; }
    .reply-box .reply-text { font-size:.83rem; color:#475569; }
    .pending-blur { filter:blur(4px); user-select:none; pointer-events:none; }
    .star-filter-btn { border:1px solid #e4e9f0; background:#fff; border-radius:99px; padding:4px 14px; font-size:.78rem; cursor:pointer; color:#64748b; transition:all .15s; }
    .star-filter-btn.active { background:#fef3c7; border-color:#f59e0b; color:#92400e; font-weight:600; }
    .stat-pill { background:#f0f4f8; border-radius:10px; padding:.6rem 1rem; text-align:center; }
    .stat-pill .val { font-size:1.4rem; font-weight:800; }
    .stat-pill .lbl { font-size:.68rem; color:#8fa3b8; margin-top:1px; }
  </style>
</head>
<body>

  @include('owner._sidebar')

  <div class="main" id="mainContent">

    @include('owner._navbar')

    <div class="content">

      {{-- HEADER --}}
      <div class="mb-4">
        <h4 class="fw-bold mb-1">Ulasan</h4>
        <p class="text-muted small">Kelola ulasan penyewa dan bagikan pengalaman Anda menggunakan KostFinder.</p>
      </div>

      {{-- ALERT --}}
      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
          <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      @endif
      @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-3" role="alert">
          <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      @endif

      {{-- STATISTIK --}}
      <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
          <div class="stat-pill">
            <div class="val text-warning">{{ number_format($rata_rating, 1) }} <i class="bi bi-star-fill" style="font-size:1rem;"></i></div>
            <div class="lbl">Rating rata-rata</div>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="stat-pill">
            <div class="val text-danger">{{ $belum_dibalas }}</div>
            <div class="lbl">Belum dibalas</div>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="stat-pill">
            <div class="val text-warning">{{ $pending_reviews->count() }}</div>
            <div class="lbl">Menunggu verifikasi</div>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="stat-pill">
            <div class="val">{{ $reviews->count() }}</div>
            <div class="lbl">Total ulasan</div>
          </div>
        </div>
      </div>

      <div class="row g-4">

        {{-- KIRI: ULASAN PENYEWA --}}
        <div class="col-lg-7">
          <div class="bg-white rounded-4 p-4 shadow-sm border">
            <h6 class="fw-bold mb-3">Ulasan Penyewa ke Kos</h6>

            {{-- TABS --}}
            <ul class="nav nav-tabs mb-3" id="reviewTabs">
              <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-belum">
                  Belum Dibalas
                  @if($belum_dibalas > 0)
                    <span class="badge bg-danger ms-1">{{ $belum_dibalas }}</span>
                  @endif
                </button>
              </li>
              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-semua">Semua</button>
              </li>
              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-pending">
                  Pending
                  @if($pending_reviews->count() > 0)
                    <span class="badge bg-warning text-dark ms-1">{{ $pending_reviews->count() }}</span>
                  @endif
                </button>
              </li>
            </ul>

            <div class="tab-content">

              {{-- TAB BELUM DIBALAS --}}
              <div class="tab-pane fade show active" id="tab-belum">
                {{-- Filter Bintang --}}
                <div class="d-flex gap-2 flex-wrap mb-3">
                  <button class="star-filter-btn active" onclick="filterStar(this, 'belum', 0)">Semua</button>
                  @for($s = 5; $s >= 1; $s--)
                    <button class="star-filter-btn" onclick="filterStar(this, 'belum', {{ $s }})">★ {{ $s }}</button>
                  @endfor
                </div>

                @php $belumList = $reviews->whereNull('reply'); @endphp

                @forelse($belumList as $rev)
                  <div class="review-card" data-star-belum="{{ $rev->rating }}">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                      <div class="d-flex align-items-center gap-2">
                        <div style="width:36px;height:36px;border-radius:50%;background:#dbeafe;color:#1d4ed8;font-weight:700;font-size:.8rem;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                          {{ strtoupper(substr($rev->user->name ?? 'U', 0, 2)) }}
                        </div>
                        <div>
                          <div class="fw-semibold" style="font-size:.85rem;">{{ $rev->user->name ?? 'Pengguna' }}</div>
                          <div class="text-muted" style="font-size:.72rem;">{{ $rev->kost->nama_kost ?? '' }} • {{ $rev->created_at->diffForHumans() }}</div>
                        </div>
                      </div>
                      <div class="text-end">
                        <div class="star-display">{{ str_repeat('★', $rev->rating) }}{{ str_repeat('☆', 5 - $rev->rating) }}</div>
                        <span class="badge bg-danger" style="font-size:.68rem;">Belum dibalas</span>
                      </div>
                    </div>
                    <p class="text-muted mb-2" style="font-size:.83rem;line-height:1.6;">"{{ $rev->komentar }}"</p>

                    {{-- Form Balas --}}
                    <form action="{{ route('owner.review.reply', $rev->id) }}" method="POST" class="mt-2">
                      @csrf
                      <div class="d-flex gap-2 align-items-end">
                        <textarea name="balasan" rows="2" class="form-control form-control-sm rounded-3"
                          placeholder="Tulis balasan Anda..." style="resize:none;" required minlength="5" maxlength="500"></textarea>
                        <div class="d-flex flex-column gap-1">
                          <button type="submit" class="btn btn-sm rounded-3 fw-semibold" style="background:#e8401c;color:#fff;white-space:nowrap;">
                            <i class="bi bi-send me-1"></i>Balas
                          </button>
                          <button type="button" class="btn btn-sm btn-outline-danger rounded-3"
                            onclick="openLaporModal({{ $rev->id }})">
                            Laporkan
                          </button>
                        </div>
                      </div>
                    </form>
                  </div>
                @empty
                  <div class="text-center text-muted py-4" id="empty-belum">
                    <i class="bi bi-check-circle" style="font-size:2rem;"></i>
                    <p class="mt-2 small">Semua ulasan sudah dibalas!</p>
                  </div>
                @endforelse
                <div id="empty-belum-filter" class="text-center text-muted py-3 small" style="display:none;">Tidak ada ulasan dengan bintang ini</div>
              </div>

              {{-- TAB SEMUA --}}
              <div class="tab-pane fade" id="tab-semua">
                <div class="d-flex gap-2 flex-wrap mb-3">
                  <button class="star-filter-btn active" onclick="filterStar(this, 'semua', 0)">Semua</button>
                  @for($s = 5; $s >= 1; $s--)
                    <button class="star-btn-semua star-filter-btn" onclick="filterStar(this, 'semua', {{ $s }})">★ {{ $s }}</button>
                  @endfor
                </div>

                @forelse($reviews as $rev)
                  <div class="review-card" data-star-semua="{{ $rev->rating }}">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                      <div class="d-flex align-items-center gap-2">
                        <div style="width:36px;height:36px;border-radius:50%;background:#dbeafe;color:#1d4ed8;font-weight:700;font-size:.8rem;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                          {{ strtoupper(substr($rev->user->name ?? 'U', 0, 2)) }}
                        </div>
                        <div>
                          <div class="fw-semibold" style="font-size:.85rem;">{{ $rev->user->name ?? 'Pengguna' }}</div>
                          <div class="text-muted" style="font-size:.72rem;">{{ $rev->kost->nama_kost ?? '' }} • {{ $rev->created_at->diffForHumans() }}</div>
                        </div>
                      </div>
                      <div class="text-end">
                        <div class="star-display">{{ str_repeat('★', $rev->rating) }}{{ str_repeat('☆', 5 - $rev->rating) }}</div>
                        @if($rev->reply)
                          <span class="badge bg-success" style="font-size:.68rem;">Sudah dibalas</span>
                        @else
                          <span class="badge bg-danger" style="font-size:.68rem;">Belum dibalas</span>
                        @endif
                      </div>
                    </div>
                    <p class="text-muted mb-2" style="font-size:.83rem;line-height:1.6;">"{{ $rev->komentar }}"</p>

                    @if($rev->reply)
                      <div class="reply-box">
                        <div class="reply-label"><i class="bi bi-reply me-1"></i>Balasan Anda</div>
                        <div class="reply-text">{{ $rev->reply->balasan }}</div>
                      </div>
                    @else
                      <form action="{{ route('owner.review.reply', $rev->id) }}" method="POST" class="mt-2">
                        @csrf
                        <div class="d-flex gap-2 align-items-end">
                          <textarea name="balasan" rows="2" class="form-control form-control-sm rounded-3"
                            placeholder="Tulis balasan Anda..." style="resize:none;" required minlength="5" maxlength="500"></textarea>
                          <button type="submit" class="btn btn-sm rounded-3 fw-semibold" style="background:#e8401c;color:#fff;white-space:nowrap;">
                            <i class="bi bi-send me-1"></i>Balas
                          </button>
                        </div>
                      </form>
                    @endif
                  </div>
                @empty
                  <div class="text-center text-muted py-4">
                    <i class="bi bi-chat-square-text" style="font-size:2rem;"></i>
                    <p class="mt-2 small">Belum ada ulasan yang masuk.</p>
                  </div>
                @endforelse
                <div id="empty-semua-filter" class="text-center text-muted py-3 small" style="display:none;">Tidak ada ulasan dengan bintang ini</div>
              </div>

              {{-- TAB PENDING --}}
              <div class="tab-pane fade" id="tab-pending">
                <div class="alert alert-warning rounded-3 small py-2 mb-3">
                  <i class="bi bi-info-circle me-1"></i>
                  Ulasan ini sedang ditinjau admin sebelum ditampilkan ke publik. Anda belum bisa membalas.
                </div>

                @forelse($pending_reviews as $rev)
                  <div class="review-card pending-card">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                      <div class="d-flex align-items-center gap-2">
                        <div style="width:36px;height:36px;border-radius:50%;background:#e5e7eb;color:#6b7280;font-weight:700;font-size:.8rem;display:flex;align-items:center;justify-content:center;flex-shrink:0;">??</div>
                        <div>
                          <div class="fw-semibold" style="font-size:.85rem;">Nama disembunyikan</div>
                          <div class="text-muted" style="font-size:.72rem;">{{ $rev->created_at->diffForHumans() }}</div>
                        </div>
                      </div>
                      <div class="text-end">
                        <div class="star-display">{{ str_repeat('★', $rev->rating) }}{{ str_repeat('☆', 5 - $rev->rating) }}</div>
                        <span class="badge bg-warning text-dark" style="font-size:.68rem;">Pending verifikasi</span>
                      </div>
                    </div>
                    <p class="pending-blur mb-1" style="font-size:.83rem;line-height:1.6;">"{{ $rev->komentar }}"</p>
                    <div class="text-warning small mt-2">
                      <i class="bi bi-eye-slash me-1"></i>Konten disamarkan sampai admin selesai memverifikasi
                    </div>
                  </div>
                @empty
                  <div class="text-center text-muted py-4">
                    <i class="bi bi-clock" style="font-size:2rem;"></i>
                    <p class="mt-2 small">Tidak ada ulasan yang sedang pending.</p>
                  </div>
                @endforelse
              </div>

            </div>
          </div>
        </div>

        {{-- KANAN: DISTRIBUSI RATING + FEEDBACK KE PLATFORM --}}
        <div class="col-lg-5">

          {{-- Distribusi Rating --}}
          <div class="bg-white rounded-4 p-4 shadow-sm border mb-4">
            <h6 class="fw-bold mb-3">Distribusi Rating</h6>
            <div class="d-flex gap-3 align-items-center">
              <div class="text-center">
                <div style="font-size:2.5rem;font-weight:800;">{{ number_format($rata_rating, 1) }}</div>
                <div class="star-display" style="font-size:1.1rem;">
                  @for($i = 1; $i <= 5; $i++)
                    {{ $i <= round($rata_rating) ? '★' : '☆' }}
                  @endfor
                </div>
                <div class="text-muted" style="font-size:.72rem;">{{ $reviews->count() }} terverifikasi</div>
              </div>
              <div class="flex-fill">
                @for($s = 5; $s >= 1; $s--)
                  @php $cnt = $reviews->where('rating', $s)->count(); $pct = $reviews->count() > 0 ? ($cnt / $reviews->count()) * 100 : 0; @endphp
                  <div class="d-flex align-items-center gap-2 mb-1" style="cursor:pointer;" onclick="filterByBar({{ $s }})">
                    <div class="text-muted" style="font-size:.75rem;width:10px;">{{ $s }}</div>
                    <div style="flex:1;height:6px;background:#f0f4f8;border-radius:3px;overflow:hidden;">
                      <div style="width:{{ $pct }}%;height:100%;background:#f59e0b;border-radius:3px;"></div>
                    </div>
                    <div class="text-muted" style="font-size:.72rem;width:20px;">{{ $cnt }}</div>
                  </div>
                @endfor
                <div class="text-muted mt-1" style="font-size:.68rem;">Klik bar untuk filter ulasan</div>
              </div>
            </div>
          </div>

          {{-- Feedback ke Platform --}}
          <div class="bg-white rounded-4 p-4 shadow-sm border">
            <h6 class="fw-bold mb-1">Feedback ke Platform</h6>
            <p class="text-muted small mb-3">Bagaimana pengalaman Anda menggunakan KostFinder?</p>

            @if($owner_review)
              <div class="d-flex align-items-center gap-2 mb-3">
                <div style="font-size:1.1rem;color:#f59e0b;">
                  @for($i = 1; $i <= 5; $i++){{ $i <= $owner_review->rating ? '★' : '☆' }}@endfor
                </div>
                @if($owner_review->status === 'pending')
                  <span class="badge bg-warning text-dark">Menunggu persetujuan</span>
                @elseif($owner_review->status === 'approved')
                  <span class="badge bg-success">Ditampilkan</span>
                @else
                  <span class="badge bg-danger">Ditolak</span>
                @endif
              </div>
              <p style="font-size:.85rem;line-height:1.7;color:#334155;">"{{ $owner_review->ulasan }}"</p>
              <div class="text-muted small mt-2">
                <i class="bi bi-geo-alt me-1"></i>{{ $owner_review->kota }} •
                <i class="bi bi-calendar ms-2 me-1"></i>{{ $owner_review->created_at->format('d M Y') }}
              </div>
              @if($owner_review->status === 'rejected')
                <div class="alert alert-warning mt-3 mb-0 rounded-3 small">
                  <i class="bi bi-info-circle me-1"></i>Ulasan tidak disetujui. Hubungi admin untuk info lebih lanjut.
                </div>
              @endif
            @else
              <form action="{{ route('owner.review.store') }}" method="POST">
                @csrf
                @php $kosts = \App\Models\Kost::where('owner_id', auth()->id())->get(); @endphp
                <div class="mb-3">
                  <label class="form-label fw-semibold small">Nama Kos <span class="text-danger">*</span></label>
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
                <div class="mb-3">
                  <label class="form-label fw-semibold small">Lokasi <span class="text-danger">*</span></label>
                  <input type="text" name="kota" id="inputKota" class="form-control form-control-sm rounded-3 @error('kota') is-invalid @enderror" placeholder="contoh: Lowokwaru, Malang" value="{{ old('kota') }}">
                  @error('kota')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                  <label class="form-label fw-semibold small">Rating <span class="text-danger">*</span></label>
                  <div class="d-flex align-items-center gap-2">
                    <div class="star-picker" id="starPicker">
                      @for($i = 1; $i <= 5; $i++)
                        <span class="star-pick {{ $i <= old('rating', 5) ? 'active' : '' }}" data-val="{{ $i }}" onclick="pickStar({{ $i }})">★</span>
                      @endfor
                    </div>
                    <span class="star-label" id="starLabel">Sangat Bagus</span>
                  </div>
                  <input type="hidden" name="rating" id="ratingInput" value="{{ old('rating', 5) }}">
                  @error('rating')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                  <label class="form-label fw-semibold small">Ulasan <span class="text-danger">*</span></label>
                  <textarea name="ulasan" rows="3" id="ulasanText"
                    class="form-control form-control-sm rounded-3 @error('ulasan') is-invalid @enderror"
                    placeholder="Ceritakan pengalaman Anda menggunakan KostFinder... (min 20 karakter)"
                    maxlength="500">{{ old('ulasan') }}</textarea>
                  <div class="d-flex justify-content-between mt-1">
                    @error('ulasan')
                      <div class="text-danger" style="font-size:.75rem;">{{ $message }}</div>
                    @else
                      <small class="text-muted">Minimal 20 karakter</small>
                    @enderror
                    <small class="text-muted" id="charCount">0/500</small>
                  </div>
                </div>
                <div class="alert rounded-3 small mb-3 py-2" style="background:#f0fdf4;border:1px solid #bbf7d0;color:#166534;">
                  <i class="bi bi-info-circle me-1"></i>Ditampilkan setelah disetujui admin (1x24 jam).
                </div>
                <button type="submit" class="btn w-100 rounded-3 fw-bold" style="background:#e8401c;color:#fff;">
                  <i class="bi bi-send me-2"></i>Kirim Feedback
                </button>
              </form>
            @endif
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
          <h6 class="modal-title fw-bold">Laporkan Ulasan</h6>
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
            <button type="submit" class="btn btn-sm btn-danger rounded-3">Kirim Laporan</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Sidebar toggle
    function toggleSidebar() {
      document.getElementById('sidebar').classList.toggle('collapsed');
      document.getElementById('mainContent').classList.toggle('collapsed');
    }

    // Kos select
    function updateLokasi(sel) {
      const opt = sel.options[sel.selectedIndex];
      const el = document.getElementById('inputKota');
      if (el) el.value = opt.dataset.kota || '';
    }
    const sel0 = document.querySelector('select[name=lokasi_kos]');
    if (sel0 && sel0.value) updateLokasi(sel0);

    // Star picker (feedback)
    const starLabels = {1:'Kurang',2:'Cukup',3:'Lumayan',4:'Bagus',5:'Sangat Bagus'};
    function pickStar(val) {
      document.getElementById('ratingInput').value = val;
      document.getElementById('starLabel').textContent = starLabels[val];
      document.querySelectorAll('.star-pick').forEach((s, i) => s.classList.toggle('active', i < val));
    }
    const ri = document.getElementById('ratingInput');
    if (ri) pickStar(parseInt(ri.value) || 5);

    // Char count
    const ta = document.getElementById('ulasanText');
    const cc = document.getElementById('charCount');
    if (ta && cc) ta.addEventListener('input', () => cc.textContent = ta.value.length + '/500');

    // Modal laporkan
    function openLaporModal(reviewId) {
      document.getElementById('laporForm').action = '/owner/ulasan/' + reviewId + '/report';
      new bootstrap.Modal(document.getElementById('laporModal')).show();
    }

    // Filter bintang
    function filterStar(btn, tab, star) {
      const scope = tab === 'belum' ? '#tab-belum' : '#tab-semua';
      const attr = tab === 'belum' ? 'data-star-belum' : 'data-star-semua';
      const emptyId = tab === 'belum' ? 'empty-belum-filter' : 'empty-semua-filter';

      document.querySelectorAll(scope + ' .star-filter-btn').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');

      let visible = 0;
      document.querySelectorAll(scope + ' .review-card').forEach(card => {
        const s = parseInt(card.getAttribute(attr));
        const show = star === 0 || s === star;
        card.style.display = show ? 'block' : 'none';
        if (show) visible++;
      });
      document.getElementById(emptyId).style.display = visible === 0 ? 'block' : 'none';
    }

    // Klik bar distribusi → pindah ke tab semua + filter
    function filterByBar(star) {
      const tab = document.querySelector('[data-bs-target="#tab-semua"]');
      if (tab) tab.click();
      setTimeout(() => {
        const btns = document.querySelectorAll('#tab-semua .star-filter-btn');
        const starMap = {5:1, 4:2, 3:3, 2:4, 1:5};
        if (btns[starMap[star]]) filterStar(btns[starMap[star]], 'semua', star);
      }, 150);
    }
  </script>
</body>
</html>