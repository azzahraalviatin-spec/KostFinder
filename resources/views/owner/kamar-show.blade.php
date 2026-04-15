<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail Kamar - KostFinder</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    /* =====================================================
       CSS VARIABLES
    ===================================================== */
    :root {
      --primary:   #e8401c;
      --primary2:  #ff7043;
      --dark:      #1e2d3d;
      --muted:     #8a97a8;
      --line:      #e8edf3;
      --sidebar-w: 250px;
      --topbar-h:  64px;
    }

    /* =====================================================
       RESET
    ===================================================== */
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      background: #f4f6f9;
      font-family: 'Segoe UI', sans-serif;
      overflow-x: hidden;
    }

    /* =====================================================
       SIDEBAR
    ===================================================== */
    .sidebar {
      position: fixed;
      top: 0;
      left: 0;
      width: var(--sidebar-w);
      height: 100vh;
      background: var(--dark);
      display: flex;
      flex-direction: column;
      z-index: 1040;
      overflow-y: auto;
    }

    .sidebar-brand {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 20px 18px 16px;
      border-bottom: 1px solid rgba(255,255,255,.07);
    }
    .brand-icon {
      width: 38px;
      height: 38px;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.1rem;
      flex-shrink: 0;
    }
    .brand-text .name {
      font-size: .95rem;
      font-weight: 800;
      color: #fff;
    }
    .brand-text .name span { color: var(--primary); }
    .brand-text .sub {
      font-size: .68rem;
      color: rgba(255,255,255,.45);
      margin-top: 1px;
    }

    .sidebar-menu {
      flex: 1;
      padding: 14px 12px;
    }
    .menu-label {
      font-size: .62rem;
      font-weight: 700;
      color: rgba(255,255,255,.3);
      letter-spacing: 1px;
      padding: 10px 8px 6px;
    }
    .menu-item {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 9px 12px;
      border-radius: 9px;
      color: rgba(255,255,255,.65);
      font-size: .84rem;
      font-weight: 500;
      text-decoration: none;
      transition: all .15s;
      border: none;
      background: none;
      width: 100%;
      cursor: pointer;
    }
    .menu-item:hover {
      background: rgba(255,255,255,.07);
      color: #fff;
    }
    .menu-item.active {
      background: linear-gradient(135deg, var(--primary), var(--primary2));
      color: #fff;
      box-shadow: 0 4px 14px rgba(232,64,28,.35);
    }
    .menu-item i { font-size: 1rem; flex-shrink: 0; }
    .menu-item.logout { color: rgba(255,100,80,.75); }
    .menu-item.logout:hover { background: rgba(255,80,50,.1); color: #ff6050; }

    .sidebar-user {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 14px 16px;
      margin-top: auto;
    }
    .user-avatar {
      width: 34px;
      height: 34px;
      border-radius: 50%;
      background: var(--primary);
      color: #fff;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      font-size: .85rem;
      flex-shrink: 0;
    }
    .user-name {
      font-size: .82rem;
      font-weight: 700;
      color: #fff;
    }
    .user-role {
      font-size: .7rem;
      color: rgba(255,255,255,.45);
    }

    /* =====================================================
       TOPBAR
    ===================================================== */
    .topbar {
      position: fixed;
      top: 0;
      left: var(--sidebar-w);
      right: 0;
      height: var(--topbar-h);
      background: #fff;
      border-bottom: 1px solid var(--line);
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 22px;
      z-index: 1030;
      gap: 16px;
    }
    .topbar-left {
      display: flex;
      align-items: center;
      gap: 12px;
    }
    .topbar-left h5 {
      font-size: .92rem;
      font-weight: 700;
      color: var(--dark);
      margin: 0;
    }
    .topbar-left p {
      font-size: .72rem;
      color: var(--muted);
      margin: 0;
    }
    .topbar-right {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-left: auto;
    }
    .sidebar-toggle-btn {
      background: none;
      border: none;
      font-size: 1.2rem;
      color: var(--dark);
      cursor: pointer;
      padding: 4px 8px;
      border-radius: 6px;
    }
    .sidebar-toggle-btn:hover { background: #f4f6f9; }

    .search-box {
      display: flex;
      align-items: center;
      gap: 8px;
      background: #f4f6f9;
      border-radius: 9px;
      padding: 7px 13px;
      width: 220px;
    }
    .search-box input {
      border: none;
      background: none;
      outline: none;
      font-size: .82rem;
      color: var(--dark);
      width: 100%;
    }

    .icon-btn {
      width: 36px;
      height: 36px;
      border-radius: 9px;
      background: #f4f6f9;
      border: none;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1rem;
      color: var(--dark);
      cursor: pointer;
      text-decoration: none;
      transition: background .15s;
    }
    .icon-btn:hover { background: var(--line); }

    .notif-dot {
      width: 8px;
      height: 8px;
      background: var(--primary);
      border-radius: 50%;
      position: absolute;
      top: 4px;
      right: 4px;
      border: 2px solid #fff;
    }

    /* =====================================================
       KONTEN UTAMA
    ===================================================== */
    .content-area {
      margin-left: var(--sidebar-w);
      margin-top: var(--topbar-h);
      padding: 26px 24px;
      min-height: calc(100vh - var(--topbar-h));
    }

    /* =====================================================
       KOMPONEN HALAMAN
    ===================================================== */
    .page-header {
      border-left: 4px solid var(--primary);
      padding-left: 12px;
      margin-bottom: 20px;
    }
    .page-header h4 {
      font-weight: 700;
      font-size: 1.15rem;
      color: var(--dark);
      margin-bottom: 3px;
    }

    .card-box {
      background: #fff;
      border-radius: 14px;
      box-shadow: 0 2px 12px rgba(0,0,0,.06);
      padding: 20px;
      margin-bottom: 16px;
    }
    .card-box h6 {
      font-weight: 700;
      font-size: .86rem;
      color: var(--dark);
      margin-bottom: 14px;
      display: flex;
      align-items: center;
      gap: 6px;
    }
    .card-box h6 i { color: var(--primary); }

    .info-label {
      font-size: .69rem;
      color: #aaa;
      text-transform: uppercase;
      letter-spacing: .5px;
      margin-bottom: 3px;
    }
    .info-value {
      font-weight: 600;
      font-size: .91rem;
      color: var(--dark);
    }

    .foto-main {
      width: 100%;
      height: 260px;
      object-fit: cover;
      border-radius: 10px;
      cursor: pointer;
      transition: opacity .2s;
    }
    .foto-main:hover { opacity: .9; }

    .foto-thumb {
      width: 76px;
      height: 58px;
      object-fit: cover;
      border-radius: 8px;
      cursor: pointer;
      border: 2px solid transparent;
      transition: border-color .2s;
    }
    .foto-thumb:hover,
    .foto-thumb.active { border-color: var(--primary); }

    .badge-fas {
      background: #f4f6f9;
      color: #444;
      border: 1px solid var(--line);
      font-size: .79rem;
      font-weight: 500;
      padding: 5px 12px;
      border-radius: 7px;
      display: inline-block;
    }

    .btn-edit {
      background: #fef3c7;
      color: #92400e;
      border: 1px solid #fde68a;
      border-radius: 9px;
      font-weight: 600;
      padding: 9px 0;
      transition: background .15s;
    }
    .btn-edit:hover { background: #fde68a; color: #78350f; }

    .btn-hapus {
      background: #fee2e2;
      color: #dc2626;
      border: 1px solid #fecaca;
      border-radius: 9px;
      font-weight: 600;
      padding: 9px 0;
      transition: background .15s;
    }
    .btn-hapus:hover { background: #fecaca; color: #b91c1c; }
  </style>
</head>
<body>

  {{-- SIDEBAR --}}
  @include('owner._sidebar')

  {{-- TOPBAR / NAVBAR --}}
  @include('owner._navbar')

  {{-- ===================== KONTEN UTAMA ===================== --}}
  <div class="content-area">

    {{-- BREADCRUMB --}}
    <nav aria-label="breadcrumb" class="mb-2">
      <ol class="breadcrumb small mb-0">
        <li class="breadcrumb-item">
          <a href="{{ route('owner.kamar.index') }}"
             class="text-decoration-none"
             style="color:var(--primary)">Kelola Kamar</a>
        </li>
        <li class="breadcrumb-item active text-muted">Detail Kamar</li>
      </ol>
    </nav>

    {{-- PAGE HEADER --}}
    <div class="page-header">
      <h4>Kamar {{ $kamar->nomor_kamar }} &mdash; {{ $kamar->kost->nama_kost }}</h4>
      <small class="text-muted">
        <i class="bi bi-geo-alt-fill me-1" style="color:var(--primary)"></i>
        {{ $kamar->kost->alamat }}
      </small>
    </div>

    {{-- TOMBOL KEMBALI --}}
    <a href="{{ route('owner.kamar.index') }}"
       class="btn mb-4"
       style="background:linear-gradient(135deg,#e8401c,#ff7043);color:#fff;font-weight:600;border-radius:9px;padding:8px 20px;">
      <i class="bi bi-arrow-left me-1"></i> Kembali ke Kamar
    </a>

    {{-- ROW --}}
    <div class="row g-4">

      {{-- KOLOM FOTO --}}
      <div class="col-xl-5 col-lg-5 col-md-12">
        <div class="card-box h-100">
          <h6><i class="bi bi-images"></i> Foto Kamar</h6>

          @if($kamar->images && $kamar->images->count())
            <img id="fotoUtama"
                 src="{{ asset('storage/' . $kamar->images[0]->foto_path) }}"
                 class="foto-main mb-3"
                 alt="Foto kamar">
            <div class="d-flex flex-wrap gap-2">
              @foreach($kamar->images as $idx => $img)
                <img src="{{ asset('storage/' . $img->foto_path) }}"
                     class="foto-thumb {{ $idx === 0 ? 'active' : '' }}"
                     alt="thumb"
                     onclick="gantiPhoto(this)">
              @endforeach
            </div>
          @else
            <div class="text-center py-5 text-muted">
              <i class="bi bi-image fs-1 d-block mb-2 opacity-25"></i>
              Belum ada foto kamar
            </div>
          @endif
        </div>
      </div>

      {{-- KOLOM DETAIL --}}
      <div class="col-xl-7 col-lg-7 col-md-12">

        {{-- INFO --}}
        <div class="card-box">
          <h6><i class="bi bi-info-circle"></i> Informasi Kamar</h6>
          <div class="row g-3">
            <div class="col-6">
              <div class="info-label">Nomor Kamar</div>
              <div class="info-value">{{ $kamar->nomor_kamar }}</div>
            </div>
            <div class="col-6">
              <div class="info-label">Tipe Kamar</div>
              <div class="info-value">{{ $kamar->tipe_kamar }}</div>
            </div>
            <div class="col-6">
              <div class="info-label">Harga / Bulan</div>
              <div class="info-value" style="color:var(--primary);font-size:1.05rem;">
                Rp {{ number_format($kamar->harga_per_bulan, 0, ',', '.') }}
              </div>
            </div>
            <div class="col-6">
              <div class="info-label">Status</div>
              <div class="mt-1">
                @if($kamar->status_kamar == 'tersedia')
                  <span class="badge px-3 py-2"
                        style="background:#dcfce7;color:#16a34a;font-size:.78rem;">
                    <i class="bi bi-check-circle-fill me-1"></i> Tersedia
                  </span>
                @else
                  <span class="badge px-3 py-2"
                        style="background:#fee2e2;color:#dc2626;font-size:.78rem;">
                    <i class="bi bi-x-circle-fill me-1"></i> {{ ucfirst($kamar->status_kamar) }}
                  </span>
                @endif
              </div>
            </div>
            <div class="col-6">
              <div class="info-label">Ukuran Kamar</div>
              <div class="info-value">{{ $kamar->ukuran ?? '-' }}</div>
            </div>
          </div>
        </div>

        {{-- FASILITAS --}}
        <div class="card-box">
          <h6><i class="bi bi-star"></i> Fasilitas Kamar</h6>
          @php
            $fasilitas = is_array($kamar->fasilitas)
                ? $kamar->fasilitas
                : explode(',', $kamar->fasilitas ?? '');
            $fasilitas = array_values(array_filter(array_map('trim', $fasilitas)));
          @endphp
          @if(!empty($fasilitas))
            <div class="d-flex flex-wrap gap-2">
              @foreach($fasilitas as $f)
                <span class="badge-fas">{{ $f }}</span>
              @endforeach
            </div>
          @else
            <p class="text-muted small mb-0">Tidak ada fasilitas tercatat</p>
          @endif
        </div>

        {{-- AKSI --}}
        <div class="d-flex gap-2">
          <a href="{{ route('owner.kamar.edit', $kamar->id_room) }}"
             class="btn btn-edit flex-fill">
            <i class="bi bi-pencil-square me-1"></i> Edit Kamar
          </a>
          <form action="{{ route('owner.kamar.destroy', $kamar->id_room) }}"
                method="POST"
                class="flex-fill js-confirm-delete"
                data-delete-message="Yakin ingin menghapus Kamar {{ $kamar->nomor_kamar }}?">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-hapus w-100">
              <i class="bi bi-trash me-1"></i> Hapus Kamar
            </button>
          </form>
        </div>

      </div>{{-- end col kanan --}}
    </div>{{-- end row --}}
  </div>{{-- end content-area --}}

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function gantiPhoto(el) {
      document.getElementById('fotoUtama').src = el.src;
      document.querySelectorAll('.foto-thumb').forEach(t => t.classList.remove('active'));
      el.classList.add('active');
    }

    function toggleSidebar() {
      const sb = document.getElementById('sidebar');
      if (!sb) return;
      const isOpen = sb.style.left === '0px' || sb.style.left === '';
      sb.style.left = isOpen ? '-250px' : '0px';
    }
  </script>
</body>
</html>