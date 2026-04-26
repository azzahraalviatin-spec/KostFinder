<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Kamar - KostFinder</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    :root { --sidebar-w:200px; --sidebar-col:60px; --primary:#e8401c; --dark:#1e2d3d; --bg:#f0f4f8; }
    * { margin:0; padding:0; box-sizing:border-box; }
    body { font-family:'Plus Jakarta Sans',sans-serif; background:var(--bg); display:flex; min-height:100vh; }

    /* ── SIDEBAR ── */
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

    /* ── MAIN ── */
    .main { margin-left:var(--sidebar-w); flex:1; transition:margin-left .3s ease; display:flex; flex-direction:column; }
    .main.collapsed { margin-left:var(--sidebar-col); }
    .topbar { background:#fff; height:60px; padding:0 1.5rem; display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid #e4e9f0; position:sticky; top:0; z-index:100; }
    .topbar-left h5 { font-size:.98rem; font-weight:800; color:var(--dark); margin:0; }
    .topbar-left p { font-size:.72rem; color:#8fa3b8; margin:0; }
    .topbar-right { display:flex; align-items:center; gap:.6rem; }
    .search-box { display:flex; align-items:center; gap:.5rem; background:#f0f4f8; border:1px solid #dde3ed; border-radius:.55rem; padding:.38rem .75rem; width:180px; }
    .search-box input { border:0; background:none; outline:none; font-size:.8rem; color:#333; width:100%; }
    .icon-btn { width:34px; height:34px; border-radius:.5rem; background:#f0f4f8; border:1px solid #dde3ed; display:flex; align-items:center; justify-content:center; color:#555; font-size:.9rem; cursor:pointer; text-decoration:none; }
    .icon-btn:hover { background:#e4e9f0; color:#333; }
    .content { padding:1.4rem; flex:1; }
    .owner-footer { background:#fff; border-top:1px solid #e4e9f0; padding:.8rem 1.5rem; text-align:center; color:#8fa3b8; font-size:.72rem; }

    /* ── FORM ── */
    .form-card { background:#fff; border-radius:.85rem; border:1px solid #e4e9f0; box-shadow:0 2px 6px rgba(0,0,0,.04); padding:1.5rem; margin-bottom:1rem; }
    .form-card-title { font-weight:800; color:var(--dark); font-size:.9rem; margin-bottom:1rem; padding-bottom:.7rem; border-bottom:1px solid #f0f4f8; display:flex; align-items:center; gap:.4rem; }
    .form-label { font-size:.8rem; font-weight:600; color:#444; margin-bottom:.3rem; }
    .form-control, .form-select { font-size:.85rem; border-color:#e4e9f0; border-radius:.55rem; padding:.5rem .8rem; }
    .form-control:focus, .form-select:focus { border-color:var(--primary); box-shadow:0 0 0 3px rgba(232,64,28,.1); }

    /* ── MODE TOGGLE ── */
    .mode-toggle { display:flex; gap:.5rem; margin-bottom:1.2rem; background:#f0f4f8; border-radius:.65rem; padding:.3rem; }
    .mode-btn { flex:1; padding:.55rem 1rem; border-radius:.5rem; border:none; font-size:.82rem; font-weight:700; cursor:pointer; transition:all .2s; background:transparent; color:#64748b; }
    .mode-btn.active { background:#fff; color:var(--primary); box-shadow:0 2px 8px rgba(0,0,0,.08); }

    /* ── MASSAL SECTION ── */
    .massal-box { background:linear-gradient(135deg,#fff5f2,#fff); border:1.5px solid #ffd0c0; border-radius:.85rem; padding:1.2rem; margin-bottom:1rem; }
    .massal-box-title { font-size:.85rem; font-weight:800; color:#9a3412; margin-bottom:.85rem; display:flex; align-items:center; gap:.4rem; }

    /* Jumlah kamar stepper */
    .jumlah-stepper { display:flex; align-items:center; gap:.5rem; }
    .stepper-btn { width:36px; height:36px; border-radius:.5rem; border:1.5px solid #e4e9f0; background:#fff; color:var(--dark); font-size:1.1rem; font-weight:700; cursor:pointer; display:flex; align-items:center; justify-content:center; transition:.15s; }
    .stepper-btn:hover { border-color:var(--primary); color:var(--primary); }
    .stepper-input { width:60px; text-align:center; font-weight:800; font-size:1rem; border:1.5px solid #e4e9f0; border-radius:.5rem; padding:.4rem; }
    .stepper-input:focus { outline:none; border-color:var(--primary); }

    /* Preview kamar generated */
    .preview-kamar-wrap { margin-top:1rem; }
    .preview-kamar-title { font-size:.75rem; font-weight:700; color:#64748b; margin-bottom:.5rem; text-transform:uppercase; letter-spacing:.04em; }
    .preview-kamar-list { display:flex; flex-wrap:wrap; gap:.4rem; }
    .preview-kamar-chip { background:#fff; border:1.5px solid #e4e9f0; border-radius:.5rem; padding:.3rem .65rem; font-size:.78rem; font-weight:700; color:var(--dark); display:flex; align-items:center; gap:.3rem; transition:.15s; }
    .preview-kamar-chip:hover { border-color:var(--primary); color:var(--primary); }
    .preview-kamar-chip i { font-size:.65rem; color:#8fa3b8; }

    /* Prefix & nomor awal */
    .nomor-preview { background:#f8fafc; border:1px solid #e4e9f0; border-radius:.55rem; padding:.55rem .85rem; font-size:.85rem; font-weight:700; color:var(--dark); min-width:80px; text-align:center; }

    /* Fasilitas checkbox */
    .fasilitas-label { display:flex; align-items:center; gap:.5rem; padding:.45rem .65rem; border-radius:.55rem; border:1px solid #e4e9f0; cursor:pointer; font-size:.8rem; background:#fff; transition:.15s; }
    .fasilitas-label:hover { border-color:#ffd0c0; background:#fff7f5; }
    .fasilitas-label input:checked ~ span { color:var(--primary); font-weight:700; }
    .fasilitas-label:has(input:checked) { border-color:#ffd0c0; background:#fff7f5; }

    /* Harga section */
    .harga-box { background:#f8fafd; border:1px solid #e4e9f0; border-radius:.65rem; padding:.9rem 1rem; }
    .harga-box-header { display:flex; align-items:center; gap:.5rem; margin-bottom:.65rem; }

    /* Submit btn */
    .btn-simpan { background:linear-gradient(135deg,#e8401c,#ff7043); color:#fff; font-weight:800; border:0; border-radius:.65rem; padding:.7rem 1.8rem; font-size:.88rem; cursor:pointer; box-shadow:0 6px 16px rgba(232,64,28,.22); transition:.2s; display:inline-flex; align-items:center; gap:.5rem; }
    .btn-simpan:hover { transform:translateY(-1px); box-shadow:0 8px 20px rgba(232,64,28,.3); }

    /* Info box */
    .info-box { background:#eff6ff; border:1px solid #bfdbfe; border-left:3px solid #3b82f6; border-radius:.65rem; padding:.75rem 1rem; font-size:.78rem; color:#1e40af; }
    .info-box i { color:#3b82f6; }
    .warning-box { background:#fffbeb; border:1px solid #fde68a; border-left:3px solid #f59e0b; border-radius:.65rem; padding:.75rem 1rem; font-size:.78rem; color:#92400e; margin-top:.75rem; }

    @media(max-width:991px) {
      .sidebar { transform:translateX(-100%); }
      .sidebar.show { transform:translateX(0); }
      .main { margin-left:0 !important; }
    }
  </style>
</head>
<body>

  @include('owner._sidebar')

  <div class="main" id="mainContent">
    @include('owner._navbar')

    <div class="content">

      {{-- BREADCRUMB --}}
      <div class="d-flex align-items-center gap-2 mb-3" style="font-size:.82rem;color:#8fa3b8;">
        <a href="{{ route('owner.kamar.index') }}" style="color:#8fa3b8;text-decoration:none;">Kelola Kamar</a>
        <i class="bi bi-chevron-right" style="font-size:.7rem;"></i>
        <span style="color:var(--dark);font-weight:700;">Tambah Kamar</span>
      </div>

      @if($errors->any())
        <div class="alert alert-danger py-2 mb-3" style="font-size:.83rem;border-radius:.65rem;">
          <i class="bi bi-exclamation-triangle me-1"></i> {{ $errors->first() }}
        </div>
      @endif

      {{-- ══════════════════════════════════════
           MODE TOGGLE: SATU KAMAR vs MASSAL
      ══════════════════════════════════════ --}}
      <div class="mode-toggle">
        <button type="button" class="mode-btn active" id="btnModeSatu" onclick="setMode('satu')">
          <i class="bi bi-door-closed me-1"></i> Tambah 1 Kamar
        </button>
        <button type="button" class="mode-btn" id="btnModeMassal" onclick="setMode('massal')">
          <i class="bi bi-grid-3x3-gap me-1"></i> Tambah Banyak Kamar Sekaligus
        </button>
      </div>

      <form action="{{ route('owner.kamar.store') }}" method="POST" enctype="multipart/form-data" id="kamarForm">
        @csrf

        {{-- Hidden: mode --}}
        <input type="hidden" name="mode" id="inputMode" value="satu">

        {{-- ══════════════════════════════════════
             SECTION MASSAL (tampil kalau mode massal)
        ══════════════════════════════════════ --}}
        <div id="sectionMassal" style="display:none;">
          <div class="massal-box">
            <div class="massal-box-title">
              <i class="bi bi-grid-3x3-gap-fill" style="color:var(--primary);"></i>
              Pengaturan Tambah Banyak Kamar
            </div>

            <div class="row g-3">
              {{-- Jumlah kamar --}}
              <div class="col-md-4">
                <label class="form-label">Jumlah Kamar yang Mau Ditambahkan</label>
                <div class="jumlah-stepper">
                  <button type="button" class="stepper-btn" onclick="stepJumlah(-1)">−</button>
                  <input type="number" id="jumlahKamar" name="jumlah_kamar" value="5" min="1" max="50"
                         class="stepper-input" oninput="updatePreview()">
                  <button type="button" class="stepper-btn" onclick="stepJumlah(1)">+</button>
                </div>
                <small class="text-muted" style="font-size:.72rem;">Maks. 50 kamar sekaligus</small>
              </div>

              {{-- Prefix / awalan nomor --}}
              <div class="col-md-4">
                <label class="form-label">Awalan Nomor Kamar <span style="font-size:.7rem;color:#8fa3b8;">(opsional)</span></label>
                <input type="text" id="prefixKamar" name="prefix_kamar" class="form-control"
                       placeholder="Contoh: A, B, Kamar, dll"
                       oninput="updatePreview()" maxlength="10">
                <small class="text-muted" style="font-size:.72rem;">Kosongkan kalau pakai angka saja</small>
              </div>

              {{-- Nomor mulai --}}
              <div class="col-md-4">
                <label class="form-label">Nomor Mulai Dari</label>
                <input type="number" id="nomorMulai" name="nomor_mulai" class="form-control"
                       value="1" min="1" oninput="updatePreview()">
                <small class="text-muted" style="font-size:.72rem;">Contoh: mulai dari 101</small>
              </div>
            </div>

            {{-- Preview nama kamar yang akan dibuat --}}
            <div class="preview-kamar-wrap" id="previewWrap">
              <div class="preview-kamar-title"><i class="bi bi-eye me-1"></i>Preview nama kamar yang akan dibuat:</div>
              <div class="preview-kamar-list" id="previewList"></div>
            </div>

            <div class="info-box mt-3">
              <i class="bi bi-info-circle me-1"></i>
              Semua kamar di bawah akan dibuat dengan <strong>data yang sama persis</strong> — harga, fasilitas, tipe, listrik, ukuran, dan deskripsi. Kamu bisa edit individual kamar setelah disimpan kalau ada yang perlu dibedakan.
            </div>
          </div>
        </div>

        {{-- ══════════════════════════════════════
             SECTION SATU KAMAR (tampil kalau mode satu)
        ══════════════════════════════════════ --}}
        <div id="sectionSatu">
          <div class="form-card">
            <div class="form-card-title">
              <i class="bi bi-door-closed" style="color:var(--primary);"></i> Identitas Kamar
            </div>
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Tipe / Nama Kamar <span class="text-danger">*</span></label>
                <input type="text" name="nomor_kamar" class="form-control"
                       value="{{ old('nomor_kamar') }}"
                       placeholder="Contoh: Tipe A, Kamar 101, dll">
                <small class="text-muted" style="font-size:.72rem;">Identitas unik tiap kamar</small>
              </div>
              <div class="col-md-6">
                <label class="form-label">Status Kamar</label>
                <select name="status_kamar" class="form-select">
                  <option value="tersedia" {{ old('status_kamar','tersedia') === 'tersedia' ? 'selected':'' }}>Tersedia</option>
                  <option value="terisi"   {{ old('status_kamar') === 'terisi' ? 'selected':'' }}>Terisi</option>
                </select>
              </div>
            </div>
          </div>
        </div>

        {{-- ══════════════════════════════════════
             PILIH KOST (selalu tampil)
        ══════════════════════════════════════ --}}
        <div class="form-card">
          <div class="form-card-title">
            <i class="bi bi-house" style="color:var(--primary);"></i> Pilih Kost
          </div>
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Kost <span class="text-danger">*</span></label>
              <select name="kost_id" class="form-select" required>
                <option value="">-- Pilih Kost --</option>
                @foreach($kosts as $kost)
                  <option value="{{ $kost->id_kost }}"
                    {{ old('kost_id') == $kost->id_kost ? 'selected' : '' }}>
                    {{ $kost->nama_kost }}
                  </option>
                @endforeach
              </select>
            </div>
            <div class="col-md-3">
              <label class="form-label">Kategori Tipe</label>
              <select name="tipe_kamar" class="form-select">
                <option value="">-- Pilih --</option>
                <option value="Standard" {{ old('tipe_kamar') === 'Standard' ? 'selected':'' }}>Standard</option>
                <option value="Deluxe"   {{ old('tipe_kamar') === 'Deluxe'   ? 'selected':'' }}>Deluxe</option>
                <option value="VIP"      {{ old('tipe_kamar') === 'VIP'      ? 'selected':'' }}>VIP</option>
              </select>
            </div>
            <div class="col-md-3">
              <label class="form-label">Ukuran Kamar</label>
              <div class="input-group">
                <input type="text" name="ukuran" class="form-control"
                       value="{{ old('ukuran') }}" placeholder="3x4">
                <span class="input-group-text" style="font-size:.78rem;background:#f8fafd;border-color:#e4e9f0;">m²</span>
              </div>
            </div>
          </div>
        </div>

        {{-- ══════════════════════════════════════
             HARGA
        ══════════════════════════════════════ --}}
        <div class="form-card">
          <div class="form-card-title">
            <i class="bi bi-cash-coin" style="color:var(--primary);"></i> Harga & Durasi Sewa
          </div>
          <div class="row g-3">

            {{-- BULANAN --}}
            <div class="col-12">
              <div class="harga-box">
                <div class="harga-box-header">
                  <input type="checkbox" name="aktif_bulanan" id="aktifBulanan" value="1"
                    {{ old('aktif_bulanan', true) ? 'checked' : '' }}
                    onchange="toggleHarga('Bulanan')"
                    class="form-check-input mt-0" style="accent-color:#e8401c;width:18px;height:18px;">
                  <label for="aktifBulanan" style="font-size:.88rem;font-weight:700;cursor:pointer;">🗓️ Sewa Bulanan</label>
                </div>
                <div id="inputBulanan">
                  <div class="input-group" style="max-width:280px;">
                    <span class="input-group-text" style="font-size:.8rem;background:#f8fafd;border-color:#e4e9f0;">Rp</span>
                    <input type="number" name="harga_per_bulan" class="form-control"
                           value="{{ old('harga_per_bulan') }}" placeholder="Contoh: 900000" min="0">
                    <span class="input-group-text" style="font-size:.78rem;background:#f8fafd;border-color:#e4e9f0;">/bln</span>
                  </div>
                </div>
              </div>
            </div>

            {{-- HARIAN --}}
            <div class="col-12">
              <div class="harga-box">
                <div class="harga-box-header">
                  <input type="checkbox" name="aktif_harian" id="aktifHarian" value="1"
                    {{ old('aktif_harian') ? 'checked' : '' }}
                    onchange="toggleHarga('Harian')"
                    class="form-check-input mt-0" style="accent-color:#e8401c;width:18px;height:18px;">
                  <label for="aktifHarian" style="font-size:.88rem;font-weight:700;cursor:pointer;">📅 Sewa Harian <span style="font-size:.72rem;color:#8fa3b8;font-weight:500;">(opsional)</span></label>
                </div>
                <div id="inputHarian" style="{{ old('aktif_harian') ? '' : 'display:none' }}">
                  <div class="input-group" style="max-width:280px;">
                    <span class="input-group-text" style="font-size:.8rem;background:#f8fafd;border-color:#e4e9f0;">Rp</span>
                    <input type="number" name="harga_harian" class="form-control"
                           value="{{ old('harga_harian') }}" placeholder="Contoh: 75000" min="0">
                    <span class="input-group-text" style="font-size:.78rem;background:#f8fafd;border-color:#e4e9f0;">/hari</span>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>

        {{-- ══════════════════════════════════════
             FASILITAS
        ══════════════════════════════════════ --}}
        <div class="form-card">
          <div class="form-card-title">
            <i class="bi bi-star" style="color:var(--primary);"></i> Fasilitas Kamar
          </div>
          @php
            $fasilitasList = [
              'Tempat Tidur (Kasur, Bantal, Guling)',
              'Lemari Pakaian','Meja & Kursi Belajar',
              'AC','Kipas Angin','Stopkontak',
              'Kamar Mandi Dalam','Kamar Mandi Luar',
              'Gantungan Baju (Kapstok)','TV','WiFi','Kulkas',
            ];
            $selected = old('fasilitas', []);
          @endphp
          <div class="row g-2">
            @foreach($fasilitasList as $f)
              <div class="col-6 col-md-4 col-lg-3">
                <label class="fasilitas-label">
                  <input type="checkbox" name="fasilitas[]" value="{{ $f }}"
                    {{ in_array($f, $selected) ? 'checked' : '' }}
                    style="accent-color:#e8401c;width:15px;height:15px;flex-shrink:0;">
                  <span style="font-size:.8rem;">{{ $f }}</span>
                </label>
              </div>
            @endforeach
          </div>
        </div>

        {{-- ══════════════════════════════════════
             DETAIL TAMBAHAN
        ══════════════════════════════════════ --}}
        <div class="form-card">
          <div class="form-card-title">
            <i class="bi bi-card-text" style="color:var(--primary);"></i> Detail Tambahan
          </div>
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Informasi Listrik</label>
              <select name="listrik" class="form-select">
                <option value="">-- Pilih Info Listrik --</option>
                <option value="Termasuk Listrik"        {{ old('listrik') === 'Termasuk Listrik'        ? 'selected':'' }}>Sudah Termasuk Listrik</option>
                <option value="Token Sendiri"           {{ old('listrik') === 'Token Sendiri'           ? 'selected':'' }}>Beli Token Sendiri (Meteran di kamar)</option>
                <option value="Bayar Sesuai Pemakaian"  {{ old('listrik') === 'Bayar Sesuai Pemakaian'  ? 'selected':'' }}>Bayar di luar sewa (Sesuai pemakaian)</option>
              </select>
            </div>
            <div class="col-md-6">
              {{-- Hanya tampil di mode satu kamar --}}
              <div id="statusMassalInfo" style="display:none;">
                <label class="form-label">Status Kamar</label>
                <select name="status_kamar_massal" class="form-select">
                  <option value="tersedia">Tersedia</option>
                  <option value="terisi">Terisi</option>
                </select>
                <small class="text-muted" style="font-size:.72rem;">Semua kamar yang dibuat akan punya status ini</small>
              </div>
            </div>
            <div class="col-12">
              <label class="form-label">Deskripsi Kamar</label>
              <textarea name="deskripsi" rows="2" class="form-control"
                        placeholder="Contoh: Kamar nyaman dengan ventilasi baik, cocok untuk mahasiswa...">{{ old('deskripsi') }}</textarea>
            </div>
            <div class="col-12">
              <label class="form-label">Aturan Khusus Kamar <span style="font-size:.7rem;color:#8fa3b8;">(opsional)</span></label>
              <textarea name="aturan_kamar" rows="2" class="form-control"
                        placeholder="Contoh: Maksimal 2 orang, tidak boleh membawa hewan...">{{ old('aturan_kamar') }}</textarea>
            </div>
          </div>
        </div>

        {{-- ══════════════════════════════════════
             FOTO (hanya mode satu kamar)
        ══════════════════════════════════════ --}}
        <div class="form-card" id="sectionFoto">
          <div class="form-card-title">
            <i class="bi bi-images" style="color:var(--primary);"></i> Upload Foto Kamar
          </div>
          <input type="file" name="foto_kamar[]" class="form-control" accept="image/*" multiple id="fotoKamarInput">
          <small class="text-muted" style="font-size:.72rem;">Maksimal 5 foto (JPG/PNG/WEBP, 5MB per foto)</small>
          <div class="warning-box" id="fotoMassalWarning" style="display:none;">
            <i class="bi bi-exclamation-triangle me-1"></i>
            Mode tambah banyak kamar: foto tidak bisa diupload sekaligus. Upload foto per kamar setelah kamar dibuat, lewat menu <strong>Edit Kamar</strong>.
          </div>
        </div>

        {{-- ══════════════════════════════════════
             TOMBOL SUBMIT
        ══════════════════════════════════════ --}}
        <div class="d-flex gap-2 mt-1 mb-4 align-items-center flex-wrap">
          <button type="submit" class="btn-simpan" id="btnSimpan">
            <i class="bi bi-check-lg"></i>
            <span id="btnSimpanText">Simpan Kamar</span>
          </button>
          <a href="{{ route('owner.kamar.index') }}" class="btn btn-outline-secondary" style="border-radius:.65rem;padding:.65rem 1.2rem;font-size:.85rem;">
            Batal
          </a>
          {{-- Badge info jumlah di mode massal --}}
          <div id="massalBadge" style="display:none;background:#fff5f2;border:1px solid #ffd0c0;border-radius:.5rem;padding:.45rem .85rem;font-size:.8rem;font-weight:700;color:#9a3412;">
            <i class="bi bi-grid-3x3-gap me-1"></i>
            <span id="massalBadgeText">Akan membuat 5 kamar</span>
          </div>
        </div>

      </form>
    </div>

    <footer class="owner-footer">&copy; {{ date('Y') }} KostFinder - Panel Pemilik Kost.</footer>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // ══════════════════════════════════════════════════
    //  SIDEBAR
    // ══════════════════════════════════════════════════
    function toggleSidebar() {
      const s = document.getElementById('sidebar');
      const m = document.getElementById('mainContent');
      if (window.innerWidth <= 991) s?.classList.toggle('show');
      else { s?.classList.toggle('collapsed'); m?.classList.toggle('collapsed'); }
    }

    // ══════════════════════════════════════════════════
    //  MODE TOGGLE: SATU vs MASSAL
    // ══════════════════════════════════════════════════
    function setMode(mode) {
      const isMassal = mode === 'massal';

      // Tombol toggle
      document.getElementById('btnModeSatu').classList.toggle('active', !isMassal);
      document.getElementById('btnModeMassal').classList.toggle('active', isMassal);

      // Hidden input
      document.getElementById('inputMode').value = mode;

      // Section massal
      document.getElementById('sectionMassal').style.display = isMassal ? 'block' : 'none';

      // Section identitas 1 kamar
      document.getElementById('sectionSatu').style.display = isMassal ? 'none' : 'block';

      // Status kamar (di massal ada field sendiri di detail)
      document.getElementById('statusMassalInfo').style.display = isMassal ? 'block' : 'none';

      // Foto
      const fotoInput = document.getElementById('fotoKamarInput');
      const fotoWarn  = document.getElementById('fotoMassalWarning');
      fotoInput.style.display   = isMassal ? 'none' : 'block';
      fotoWarn.style.display    = isMassal ? 'block' : 'none';
      if (isMassal) fotoInput.value = '';

      // Tombol & badge
      document.getElementById('btnSimpanText').textContent = isMassal ? 'Buat Semua Kamar' : 'Simpan Kamar';
      document.getElementById('massalBadge').style.display = isMassal ? 'inline-flex' : 'none';

      // Update preview
      if (isMassal) updatePreview();
    }

    // ══════════════════════════════════════════════════
    //  STEPPER JUMLAH KAMAR
    // ══════════════════════════════════════════════════
    function stepJumlah(delta) {
      const input = document.getElementById('jumlahKamar');
      let val = parseInt(input.value || 1) + delta;
      val = Math.max(1, Math.min(50, val));
      input.value = val;
      updatePreview();
    }

    // ══════════════════════════════════════════════════
    //  UPDATE PREVIEW NAMA KAMAR
    // ══════════════════════════════════════════════════
    function updatePreview() {
      const jumlah  = parseInt(document.getElementById('jumlahKamar').value) || 1;
      const prefix  = document.getElementById('prefixKamar').value.trim();
      const mulai   = parseInt(document.getElementById('nomorMulai').value) || 1;
      const list    = document.getElementById('previewList');
      const badge   = document.getElementById('massalBadgeText');

      list.innerHTML = '';
      const tampil = Math.min(jumlah, 12); // tampilkan maks 12 chip

      for (let i = 0; i < tampil; i++) {
        const nomor = prefix ? (prefix + (mulai + i)) : String(mulai + i);
        const chip  = document.createElement('div');
        chip.className = 'preview-kamar-chip';
        chip.innerHTML = `<i class="bi bi-door-closed"></i> ${nomor}`;
        list.appendChild(chip);
      }

      if (jumlah > 12) {
        const more = document.createElement('div');
        more.className = 'preview-kamar-chip';
        more.style.background = '#f0f4f8';
        more.style.color = '#64748b';
        more.innerHTML = `<i class="bi bi-three-dots"></i> +${jumlah - 12} lagi`;
        list.appendChild(more);
      }

      badge.textContent = `Akan membuat ${jumlah} kamar`;
    }

    // ══════════════════════════════════════════════════
    //  TOGGLE HARGA BULANAN / HARIAN
    // ══════════════════════════════════════════════════
    function toggleHarga(tipe) {
      const cb = document.getElementById('aktif' + tipe);
      const el = document.getElementById('input'  + tipe);
      if (cb && el) el.style.display = cb.checked ? '' : 'none';
    }

    // ══════════════════════════════════════════════════
    //  VALIDASI FOTO
    // ══════════════════════════════════════════════════
    document.getElementById('fotoKamarInput').addEventListener('change', function () {
      if (this.files.length > 5) {
        alert('Maksimal 5 foto kamar.');
        this.value = '';
      }
    });

    // ══════════════════════════════════════════════════
    //  INIT
    // ══════════════════════════════════════════════════
    document.addEventListener('DOMContentLoaded', function () {
      toggleHarga('Bulanan');
      toggleHarga('Harian');
      updatePreview();
    });
  </script>
</body>
</html>