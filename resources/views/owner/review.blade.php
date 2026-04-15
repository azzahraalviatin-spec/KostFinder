<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ulasan Saya - KostFinder</title>
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

    /* Sidebar styles sama dengan dashboard */
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
  </style>
</head>
<body>

  @include('owner._sidebar')

  <div class="main" id="mainContent">

    @include('owner._navbar')

    <div class="content">
      <div class="mb-4">
        <h4 class="fw-bold mb-1">Ulasan Saya</h4>
        <p class="text-muted small">Bagikan pengalaman Anda menggunakan KostFinder.</p>
      </div>

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

      @if($review)
        {{-- Sudah pernah submit --}}
        <div class="bg-white rounded-4 p-4 shadow-sm border">
          <div class="d-flex align-items-center gap-3 mb-4">
            <div style="width:52px;height:52px;border-radius:14px;background:linear-gradient(135deg,#1dd47a,#0e8a4b);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:900;font-size:1.1rem;">
              {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
            </div>
            <div>
              <div class="fw-bold">{{ auth()->user()->name }}</div>
              <div class="text-muted small">{{ $review->lokasi_kos }}</div>
            </div>
            <div class="ms-auto">
              @if($review->status === 'pending')
                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">
                  <i class="bi bi-clock me-1"></i> Menunggu Persetujuan
                </span>
              @elseif($review->status === 'approved')
                <span class="badge bg-success px-3 py-2 rounded-pill">
                  <i class="bi bi-check-circle me-1"></i> Ditampilkan
                </span>
              @else
                <span class="badge bg-danger px-3 py-2 rounded-pill">
                  <i class="bi bi-x-circle me-1"></i> Ditolak
                </span>
              @endif
            </div>
          </div>
          <div class="mb-3">
            <div class="text-warning mb-2" style="font-size:1.1rem;">
              @for($i = 1; $i <= 5; $i++)
                {{ $i <= $review->rating ? '★' : '☆' }}
              @endfor
            </div>
            <p class="mb-0" style="font-size:.97rem;line-height:1.85;color:#334155;">
              "{{ $review->ulasan }}"
            </p>
          </div>
          <div class="d-flex gap-3 text-muted small pt-3 border-top">
            <span><i class="bi bi-geo-alt me-1"></i>{{ $review->kota }}</span>
            <span><i class="bi bi-calendar me-1"></i>{{ $review->created_at->format('d M Y') }}</span>
          </div>
          @if($review->status === 'rejected')
          <div class="alert alert-warning mt-3 mb-0 rounded-3">
            <i class="bi bi-info-circle me-2"></i>
            Ulasan Anda tidak disetujui. Silakan hubungi admin untuk informasi lebih lanjut.
          </div>
          @endif
        </div>

        @else
      {{-- Form tulis ulasan --}}
      <div class="bg-white rounded-4 p-4 shadow-sm border">
        <h6 class="fw-bold mb-4">Tulis Ulasan Anda</h6>
        <form action="{{ route('owner.review.store') }}" method="POST">
          @csrf

          {{-- Info Pemilik Kos (otomatis) --}}
          <div class="bg-light rounded-3 p-3 mb-4 d-flex align-items-center gap-3">
            <div style="width:48px;height:48px;border-radius:14px;background:linear-gradient(135deg,#1dd47a,#0e8a4b);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:900;font-size:1rem;flex-shrink:0;">
              {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
            </div>
            <div>
              <div class="fw-bold" style="font-size:.95rem;">{{ auth()->user()->name }}</div>
              <div class="text-muted small">Pemilik Kos • Terdaftar sejak {{ auth()->user()->created_at->format('Y') }}</div>
            </div>
            <span class="ms-auto badge bg-success rounded-pill px-3">Terverifikasi</span>
          </div>

          {{-- Pilih Kos --}}
          @php
            $kosts = \App\Models\Kost::where('owner_id', auth()->id())->get();
          @endphp

          <div class="mb-3">
            <label class="form-label fw-semibold small">Nama Kos <span class="text-danger">*</span></label>
            <select name="lokasi_kos" id="selectKos"
              class="form-select rounded-3 @error('lokasi_kos') is-invalid @enderror"
              onchange="updateLokasi(this)">
              <option value="">-- Pilih Kos Anda --</option>
              @foreach($kosts as $kost)
              <option value="{{ $kost->nama_kost }}"
                data-kota="{{ $kost->kota }}"
                {{ old('lokasi_kos') == $kost->nama_kost ? 'selected' : '' }}>
                {{ $kost->nama_kost }}
              </option>
              @endforeach
            </select>
            @error('lokasi_kos')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          {{-- Lokasi ditulis sendiri --}}
          <div class="mb-3">
            <label class="form-label fw-semibold small">Lokasi <span class="text-danger">*</span></label>
            <input type="text" name="kota" id="inputKota"
              class="form-control rounded-3 @error('kota') is-invalid @enderror"
              placeholder="contoh: Lowokwaru, Malang"
              value="{{ old('kota') }}">
            @error('kota')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          {{-- Rating Bintang --}}
          <div class="mb-3">
            <label class="form-label fw-semibold small">Rating <span class="text-danger">*</span></label>
            <div class="d-flex align-items-center gap-3">
              <div class="star-picker" id="starPicker">
                @for($i = 1; $i <= 5; $i++)
                <span class="star-pick {{ $i <= old('rating', 5) ? 'active' : '' }}"
                  data-val="{{ $i }}" onclick="pickStar({{ $i }})">★</span>
                @endfor
              </div>
              <span class="star-label" id="starLabel">Sangat Bagus</span>
            </div>
            <input type="hidden" name="rating" id="ratingInput" value="{{ old('rating', 5) }}">
            @error('rating')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
          </div>

          {{-- Ulasan --}}
          <div class="mb-4">
            <label class="form-label fw-semibold small">Ulasan <span class="text-danger">*</span></label>
            <textarea name="ulasan" rows="5" id="ulasanText"
              class="form-control rounded-3 @error('ulasan') is-invalid @enderror"
              placeholder="Ceritakan pengalaman Anda menggunakan KostFinder. Misalnya: kemudahan mendapatkan penyewa, fitur yang membantu, dll... (minimal 20 karakter)"
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

          <div class="alert rounded-3 small mb-4"
            style="background:#f0fdf4;border:1px solid #bbf7d0;color:#166534;">
            <i class="bi bi-info-circle me-1"></i>
            Ulasan ditampilkan setelah disetujui admin (1x24 jam).
          </div>

          <button type="submit" class="btn rounded-3 fw-bold px-4"
            style="background:#e8401c;color:#fff;">
            <i class="bi bi-send me-2"></i>Kirim Ulasan
          </button>
        </form>
      </div>
      @endif
    </div>

    <footer class="owner-footer">
      © {{ date('Y') }} KostFinder — Panel Pemilik Kost. All rights reserved.
    </footer>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function toggleSidebar() {
      const s = document.getElementById('sidebar');
      const m = document.getElementById('mainContent');
      s.classList.toggle('collapsed');
      m.classList.toggle('collapsed');
    }
    function updateLokasi(sel) {
      const opt = sel.options[sel.selectedIndex];
      document.getElementById('inputKota').value = opt.dataset.kota || '';
    }

    const starLabels = {1:'Kurang',2:'Cukup',3:'Lumayan',4:'Bagus',5:'Sangat Bagus'};
    function pickStar(val) {
      document.getElementById('ratingInput').value = val;
      document.getElementById('starLabel').textContent = starLabels[val];
      document.querySelectorAll('.star-pick').forEach((s, i) => {
        s.classList.toggle('active', i < val);
      });
    }
    pickStar(parseInt(document.getElementById('ratingInput').value) || 5);

    const textarea = document.getElementById('ulasanText');
    const counter  = document.getElementById('charCount');
    if (textarea && counter) {
      textarea.addEventListener('input', () => {
        counter.textContent = textarea.value.length + '/500';
      });
    }

    const selectKos = document.getElementById('selectKos');
    if (selectKos && selectKos.value) updateLokasi(selectKos);
  </script>
</body>
</html>