<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Kost - KostFinder</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
  <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css"/>
  
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
    body { background: var(--bg); min-height: 100vh; overflow-x: hidden; }

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
    .sidebar-user { padding: .9rem; border-top: 1px solid rgba(255,255,255,.08); display: flex; align-items: center; gap: .7rem; background: rgba(255,255,255,.03); }
    .user-avatar { width: 40px; height: 40px; border-radius: 50%; background: var(--primary); color: #fff; font-weight: 700; display: flex; align-items: center; justify-content: center; flex-shrink: 0; overflow: hidden; }
    .user-name { color: #fff; font-size: .84rem; font-weight: 700; }
    .user-role { color: #8aa0b7; font-size: .72rem; }

    /* ── MAIN ── */
    .main { margin-left: var(--sidebar-w); min-height: 100vh; display: flex; flex-direction: column; transition: .3s ease; }
    .main.collapsed { margin-left: var(--sidebar-col); }

    /* ── TOPBAR ── */
    .topbar { height: 72px; background: #fff; border-bottom: 1px solid var(--line); display: flex; align-items: center; justify-content: space-between; padding: 0 1.5rem; position: sticky; top: 0; z-index: 100; }
    .topbar-left { display: flex; align-items: center; gap: 1rem; }
    .topbar-left h5 { margin: 0; font-size: 1.05rem; font-weight: 800; color: var(--dark); }
    .topbar-left p { margin: 0; font-size: .78rem; color: var(--muted); }
    .topbar-right { display: flex; align-items: center; gap: .65rem; }
    .search-box { display: flex; align-items: center; gap: .55rem; background: #f7f9fc; border: 1px solid var(--line); border-radius: .8rem; padding: .55rem .85rem; width: 250px; }
    .search-box input { border: none; background: transparent; outline: none; width: 100%; font-size: .85rem; }
    .icon-btn { width: 40px; height: 40px; border-radius: .8rem; border: 1px solid var(--line); background: #fff; display: flex; align-items: center; justify-content: center; color: #667789; text-decoration: none; font-size: 1rem; }
    .icon-btn:hover { background: #f7f9fc; color: #333; }
    .notif-dot { position: absolute; top: 6px; right: 6px; width: 8px; height: 8px; background: #e8401c; border-radius: 50%; border: 2px solid #fff; }

    /* ── CONTENT ── */
    .content { padding: 1.5rem; flex: 1; }

    /* ── FORM CARD ── */
    .form-card { background: #fff; border-radius: 1rem; border: 1px solid var(--line); box-shadow: 0 6px 20px rgba(0,0,0,.04); padding: 1.5rem; margin-bottom: 1rem; }
    .form-card h6 { font-weight: 800; color: var(--dark); font-size: .95rem; margin-bottom: 1rem; padding-bottom: .8rem; border-bottom: 1px solid #f0f3f8; display: flex; align-items: center; gap: .4rem; }
    .form-label { font-size: .82rem; font-weight: 700; color: #344054; margin-bottom: .35rem; }
    .form-control, .form-select { font-size: .85rem; border-color: var(--line); border-radius: .75rem; padding: .65rem .9rem; min-height: 46px; }
    textarea.form-control { min-height: auto; }
    .form-control:focus, .form-select:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(232,64,28,.1); }
    .form-check { background: #f8fafc; border: 1px solid #edf2f7; border-radius: .75rem; padding: .7rem .8rem; height: 100%; transition: .2s; }
    .form-check:hover { border-color: #ffd2c7; background: #fff7f5; }
    .form-check-input:checked { background-color: var(--primary); border-color: var(--primary); }
    .form-check-label { font-size: .82rem; font-weight: 600; color: #344054; cursor: pointer; }
    #map { height: 300px; border-radius: .8rem; border: 1px solid var(--line); overflow: hidden; }

    .btn-submit { background: linear-gradient(135deg,#e8401c,#ff7043); color: #fff; font-weight: 700; border: 0; border-radius: .75rem; padding: .7rem 1.5rem; font-size: .88rem; cursor: pointer; box-shadow: 0 6px 16px rgba(232,64,28,.22); transition: .2s; display: inline-flex; align-items: center; gap: .4rem; }
    .btn-submit:hover { background: linear-gradient(135deg,#cb3518,#e8401c); transform: translateY(-1px); }

    .owner-footer { background: #fff; border-top: 1px solid var(--line); padding: .9rem 1.5rem; text-align: center; color: var(--muted); font-size: .76rem; }

    /* ═══════════════════════════════════
       UPLOAD FOTO SECTION — REDESIGNED
    ═══════════════════════════════════ */

    .upload-section { position: relative; }

    /* Drop Zone */
    .drop-zone {
      border: 2px dashed #d8e2ef;
      border-radius: 1.1rem;
      background: #fafcff;
      padding: 2.2rem 1.5rem;
      text-align: center;
      cursor: pointer;
      transition: all .25s ease;
      position: relative;
      overflow: hidden;
    }

    .drop-zone::before {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, rgba(232,64,28,.03), rgba(255,112,67,.05));
      opacity: 0;
      transition: .25s;
    }

    .drop-zone:hover, .drop-zone.drag-over {
      border-color: var(--primary);
      background: #fff8f6;
      transform: scale(1.005);
    }

    .drop-zone:hover::before, .drop-zone.drag-over::before { opacity: 1; }

    .drop-zone.drag-over { border-style: solid; box-shadow: 0 0 0 4px rgba(232,64,28,.1); }

    .drop-zone-icon {
      width: 68px; height: 68px;
      margin: 0 auto 1rem;
      background: linear-gradient(135deg, #fff5f2, #ffe8e0);
      border-radius: 1rem;
      display: flex; align-items: center; justify-content: center;
      font-size: 1.8rem;
      color: var(--primary);
      box-shadow: 0 8px 20px rgba(232,64,28,.12);
      transition: .25s;
    }

    .drop-zone:hover .drop-zone-icon { transform: translateY(-4px); box-shadow: 0 12px 28px rgba(232,64,28,.2); }

    .drop-zone-title { font-size: 1rem; font-weight: 800; color: var(--dark); margin-bottom: .35rem; }
    .drop-zone-sub { font-size: .8rem; color: var(--muted); margin-bottom: 1.2rem; line-height: 1.6; }

    .btn-pilih-foto {
      display: inline-flex; align-items: center; gap: .5rem;
      background: linear-gradient(135deg,#e8401c,#ff7043);
      color: #fff; font-weight: 700; font-size: .82rem;
      padding: .6rem 1.3rem; border-radius: .75rem; border: none;
      box-shadow: 0 6px 16px rgba(232,64,28,.22);
      cursor: pointer; transition: .2s;
    }
    .btn-pilih-foto:hover { background: linear-gradient(135deg,#cb3518,#e8401c); transform: translateY(-1px); }

    .drop-zone-hint { font-size: .72rem; color: #b0bfcc; margin-top: .85rem; }

    /* File input hidden */
    #fotoInput { display: none; }

    /* Info bar */
    .foto-info-bar {
      display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: .5rem;
      margin-top: 1rem; padding: .65rem .9rem;
      background: var(--primary-light);
      border: 1px solid var(--primary-mid);
      border-radius: .75rem;
    }

    .foto-info-left { display: flex; align-items: center; gap: .5rem; font-size: .78rem; color: #9a3412; font-weight: 600; }
    .foto-info-left i { font-size: .88rem; }

    .foto-counter {
      display: flex; align-items: center; gap: .4rem;
      font-size: .78rem; font-weight: 700; color: #9a3412;
    }

    .counter-dot {
      width: 8px; height: 8px; border-radius: 50%;
      background: #d8cbc8;
      transition: .2s;
    }
    .counter-dot.filled { background: var(--primary); }

    /* Preview grid */
    .preview-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 1rem;
  margin-top: 1.2rem;
}

    .preview-card {
      position: relative;
      border-radius: 1rem;
      overflow: hidden;
      background: #f8fafc;
      border: 1.5px solid var(--line);
      box-shadow: 0 4px 16px rgba(15,23,42,.06);
      transition: .25s ease;
      animation: popIn .3s cubic-bezier(.34,1.56,.64,1) both;
    }

    @keyframes popIn {
      from { opacity: 0; transform: scale(.88); }
      to   { opacity: 1; transform: scale(1); }
    }

    .preview-card:hover { transform: translateY(-3px); box-shadow: 0 12px 28px rgba(15,23,42,.1); border-color: #cdd6e4; }

    /* Cover badge */
    .preview-card.is-cover { border-color: var(--primary); box-shadow: 0 4px 16px rgba(232,64,28,.15); }

    .preview-img-wrap { position: relative; height: 180px; overflow: hidden; background: #edf2f7; }
    .preview-img-wrap img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform .35s ease; }
    .preview-card:hover .preview-img-wrap img { transform: scale(1.06); }

    /* overlay on hover */
    .preview-img-overlay {
      position: absolute; inset: 0;
      background: linear-gradient(to top, rgba(17,24,39,.55) 0%, transparent 55%);
      opacity: 0; transition: .25s;
    }
    .preview-card:hover .preview-img-overlay { opacity: 1; }

    /* Badge cover */
    .badge-cover {
      position: absolute; top: 10px; left: 10px;
      background: linear-gradient(135deg,#e8401c,#ff7043);
      color: #fff; font-size: .65rem; font-weight: 800;
      padding: .3rem .7rem; border-radius: 999px;
      box-shadow: 0 4px 12px rgba(232,64,28,.3);
      display: flex; align-items: center; gap: .3rem;
      letter-spacing: .02em;
    }

    /* Badge nomor */
    .badge-num {
      position: absolute; top: 10px; right: 44px;
      background: rgba(17,24,39,.65);
      color: #fff; font-size: .65rem; font-weight: 700;
      padding: .28rem .55rem; border-radius: 999px;
      backdrop-filter: blur(6px);
    }

    /* Tombol hapus */
    .btn-remove {
      position: absolute; top: 8px; right: 8px;
      width: 32px; height: 32px;
      border: none; border-radius: 50%;
      background: rgba(17,24,39,.65);
      color: #fff;
      display: flex; align-items: center; justify-content: center;
      cursor: pointer; font-size: .85rem;
      backdrop-filter: blur(6px);
      transition: .2s;
    }
    .btn-remove:hover { background: rgba(220,38,38,.9); transform: scale(1.1); }

    /* Tombol set cover */
    .btn-set-cover {
      position: absolute; bottom: 10px; right: 10px;
      background: rgba(255,255,255,.9);
      color: #555; font-size: .68rem; font-weight: 700;
      padding: .28rem .65rem; border-radius: 999px;
      border: none; cursor: pointer;
      display: flex; align-items: center; gap: .3rem;
      backdrop-filter: blur(6px);
      transition: .2s;
      opacity: 0;
    }
    .preview-card:hover .btn-set-cover { opacity: 1; }
    .btn-set-cover:hover { background: #fff; color: var(--primary); }
    .preview-card.is-cover .btn-set-cover { display: none; }

    /* Preview info */
    .preview-info {
      padding: .75rem .9rem;
      display: flex; align-items: center; justify-content: space-between;
      gap: .5rem;
    }

    .preview-name { font-size: .8rem; font-weight: 700; color: var(--dark); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; flex: 1; }
    .preview-size { font-size: .7rem; color: var(--muted); flex-shrink: 0; }

    /* Tips box */
    .tips-box {
      margin-top: 1rem;
      background: #f0f9ff;
      border: 1px solid #bae6fd;
      border-left: 3px solid #0ea5e9;
      border-radius: .75rem;
      padding: .8rem 1rem;
    }

    .tips-box .tips-title { font-size: .78rem; font-weight: 800; color: #0369a1; margin-bottom: .35rem; display: flex; align-items: center; gap: .35rem; }
    .tips-box ul { margin: 0; padding-left: 1.1rem; }
    .tips-box ul li { font-size: .75rem; color: #0c4a6e; line-height: 1.8; }

    /* Empty zone (add more) */
    .add-more-zone {
      border: 2px dashed var(--line);
      border-radius: 1rem;
      height: 180px;
      display: flex; flex-direction: column; align-items: center; justify-content: center;
      gap: .5rem; cursor: pointer;
      color: var(--muted); font-size: .8rem; font-weight: 600;
      transition: .2s;
      display: none;
    }
    .add-more-zone:hover { border-color: var(--primary); color: var(--primary); background: var(--primary-light); }
    .add-more-zone i { font-size: 1.6rem; }

    /* Progress bar (simulasi upload) */
    .upload-progress {
      position: absolute; bottom: 0; left: 0; right: 0;
      height: 3px;
      background: rgba(255,255,255,.3);
      overflow: hidden;
    }
    .upload-progress-bar {
      height: 100%;
      background: linear-gradient(90deg,#e8401c,#ff7043);
      border-radius: 2px;
      width: 0%;
      transition: width .8s ease;
    }

    @media (max-width: 991px) {
  .sidebar { transform: translateX(-100%); }
  .sidebar.show { transform: translateX(0); }
  .main { margin-left: 0 !important; }
  .search-box { width: 160px; }
  .preview-grid { grid-template-columns: repeat(2, 1fr); }
}
  </style>
</head>
<body>

  @include('owner._sidebar')

  <div class="main" id="mainContent">
    @include('owner._navbar')

    <div class="content">

      {{-- BREADCRUMB --}}
      <div class="d-flex align-items-center gap-2 mb-3" style="font-size:.82rem;color:var(--muted);">
        <a href="{{ route('owner.kost.index') }}" style="color:var(--muted);text-decoration:none;">Data Kost Saya</a>
        <i class="bi bi-chevron-right" style="font-size:.7rem;"></i>
        <span style="color:var(--dark);font-weight:700;">Tambah Kost</span>
      </div>

      @if($errors->any())
        <div class="alert alert-danger py-2 mb-3" style="font-size:.83rem;border-radius:.75rem;">
          <i class="bi bi-exclamation-triangle me-1"></i> {{ $errors->first() }}
        </div>
      @endif

      <form action="{{ route('owner.kost.store') }}" method="POST" enctype="multipart/form-data" id="kostForm">
        @csrf

        <div class="row g-3">

          {{-- KIRI --}}
          <div class="col-12 col-lg-8">

            {{-- Informasi Dasar --}}
            <div class="form-card">
              <h6><i class="bi bi-info-circle" style="color:var(--primary)"></i> Informasi Dasar</h6>

              <div class="mb-3">
                <label class="form-label">Nama Kost <span class="text-danger">*</span></label>
                <input type="text" name="nama_kost" class="form-control"
                       placeholder="Contoh: Kost Melati Indah"
                       value="{{ old('nama_kost') }}" required>
              </div>

              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label">Kota/Kabupaten <span class="text-danger">*</span></label>
                  <select name="kota" class="form-select" required>
                    <option value="">-- Pilih Kota --</option>
                    @foreach(['Surabaya','Malang','Sidoarjo','Gresik','Kediri','Jember','Banyuwangi','Mojokerto','Madiun','Pasuruan','Blitar','Probolinggo','Tulungagung','Lumajang','Jombang','Nganjuk','Lamongan','Bojonegoro','Tuban','Magetan','Ngawi','Ponorogo','Pacitan','Trenggalek','Bondowoso','Situbondo','Pamekasan','Sampang','Bangkalan','Sumenep'] as $kota)
                      <option value="{{ $kota }}" {{ old('kota') == $kota ? 'selected' : '' }}>{{ $kota }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Tipe Kost <span class="text-danger">*</span></label>
                  <select name="tipe_kost" class="form-select" required>
                    <option value="">-- Pilih Tipe --</option>
                    <option value="Putra"  {{ old('tipe_kost') == 'Putra'  ? 'selected' : '' }}>Putra</option>
                    <option value="Putri"  {{ old('tipe_kost') == 'Putri'  ? 'selected' : '' }}>Putri</option>
                    <option value="Campur" {{ old('tipe_kost') == 'Campur' ? 'selected' : '' }}>Campur</option>
                  </select>
                </div>
              </div>

              <div class="mt-3">
                <label class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                <textarea name="alamat" class="form-control" rows="2"
                          placeholder="Jl. Contoh No. 123, Kelurahan, Kecamatan" required>{{ old('alamat') }}</textarea>
              </div>

              <div class="mt-3">
                <label class="form-label">Deskripsi Kost</label>
                <textarea name="deskripsi" class="form-control" rows="3"
                          placeholder="Ceritakan tentang kost kamu...">{{ old('deskripsi') }}</textarea>
              </div>
            </div>

            {{-- Fasilitas --}}
            <div class="form-card">
              <h6><i class="bi bi-check2-square" style="color:var(--primary)"></i> Fasilitas Umum Kost</h6>
              <p style="font-size:.76rem;color:var(--muted);margin-top:-.5rem;margin-bottom:.85rem;">Pilih fasilitas yang digunakan bersama seluruh penghuni.</p>
              <div class="row g-2">
                @foreach(['WiFi/Internet','Parkir Motor','Parkir Mobil','Air Minum','Dapur','Laundry','CCTV','Mushola','Ruang Tamu','Jemuran','Ruang Santai','Keamanan 24 Jam'] as $f)
                  <div class="col-6 col-md-4">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="fasilitas[]"
                             value="{{ $f }}" id="f_{{ $loop->index }}"
                             {{ is_array(old('fasilitas')) && in_array($f, old('fasilitas')) ? 'checked' : '' }}>
                      <label class="form-check-label" for="f_{{ $loop->index }}">{{ $f }}</label>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>

            {{-- Aturan --}}
            <div class="form-card">
              <h6><i class="bi bi-clipboard-check" style="color:var(--primary)"></i> Aturan Kost</h6>
              <textarea name="aturan" class="form-control" rows="3"
                        placeholder="Contoh: Tidak boleh membawa tamu menginap, jam malam 22.00...">{{ old('aturan') }}</textarea>
            </div>

            {{-- ═══════════════════════════════════
                 FOTO PROPERTI — SECTION BARU
            ═══════════════════════════════════ --}}
            <div class="form-card">
              <h6><i class="bi bi-images" style="color:var(--primary)"></i> Foto Properti Kost</h6>

              <div class="upload-section">

                {{-- Drop Zone --}}
                <div class="drop-zone" id="dropZone">
                  <div class="drop-zone-icon">
                    <i class="bi bi-cloud-arrow-up-fill"></i>
                  </div>
                  <div class="drop-zone-title">Upload Foto Properti</div>
                  <div class="drop-zone-sub">
                    Seret & lepas foto di sini, atau klik tombol di bawah<br>
                    untuk memilih dari galeri perangkat kamu
                  </div>
                  <button type="button" class="btn-pilih-foto" onclick="document.getElementById('fotoInput').click()">
                    <i class="bi bi-folder2-open"></i> Pilih Foto
                  </button>
                  <div class="drop-zone-hint">
                    <i class="bi bi-info-circle me-1"></i>
                    Maks. <strong>6 foto</strong> &bull; Format: JPG, PNG, WEBP &bull; Ukuran maks. <strong>2 MB</strong> per foto
                  </div>
                </div>{{-- TUTUP drop-zone --}}

                {{-- Input file tersembunyi --}}
                <input type="file" name="foto_kost[]" id="fotoInput"
                       accept="image/jpeg,image/png,image/webp" multiple>

                {{-- Info bar: counter foto --}}
                <div class="foto-info-bar" id="fotoInfoBar" style="display:none;">
  <div class="foto-info-left">
    <i class="bi bi-images"></i>
    <span id="fotoInfoText">0 dari 6 foto dipilih</span>
  </div>
  <div class="foto-counter" id="fotoDots">
    <div class="counter-dot" id="dot1"></div>
    <div class="counter-dot" id="dot2"></div>
    <div class="counter-dot" id="dot3"></div>
    <div class="counter-dot" id="dot4"></div>
    <div class="counter-dot" id="dot5"></div>
    <div class="counter-dot" id="dot6"></div>
  </div>
</div>

                {{-- Preview grid --}}
                <div class="preview-grid" id="previewGrid"></div>

                {{-- Tips --}}
                <div class="tips-box">
                  <div class="tips-title">
                    <i class="bi bi-lightbulb-fill" style="color:#f59e0b"></i>
                    Tips foto profesional ala Mamikos
                  </div>
                  <ul>
                    <li>Foto <strong>tampak depan bangunan</strong> sebagai foto utama/cover</li>
                    <li>Pastikan pencahayaan <strong>terang & natural</strong>, hindari foto blur</li>
                    <li>Ambil dari sudut yang memperlihatkan <strong>luas ruangan</strong></li>
                    <li>Foto kedua bisa area <strong>kamar, dapur, atau fasilitas</strong> unggulan</li>
                  </ul>
                </div>

                </div>{{-- TUTUP upload-section --}}
            </div>{{-- TUTUP form-card --}}

          </div>{{-- TUTUP col-lg-8 --}}

          {{-- KANAN --}}
          <div class="col-12 col-lg-4">

          <div class="form-card">
  <h6><i class="bi bi-cash" style="color:var(--primary)"></i> Harga</h6>

  {{-- Harga Per Bulan --}}
  <label class="form-label">Harga Per Bulan</label>
  <div class="row g-2 mb-1">
    <div class="col-6">
      <div class="input-group">
        <span class="input-group-text" style="font-size:.78rem;background:#f8fafd;border-color:var(--line);">Rp</span>
        <input type="number" name="harga_mulai" class="form-control"
               placeholder="500000" value="{{ old('harga_mulai') }}">
      </div>
      <div class="form-text" style="font-size:.7rem;">Mulai dari</div>
    </div>
    <div class="col-6">
      <div class="input-group">
        <span class="input-group-text" style="font-size:.78rem;background:#f8fafd;border-color:var(--line);">Rp</span>
        <input type="number" name="harga_sampai" class="form-control"
               placeholder="1200000" value="{{ old('harga_sampai') }}">
      </div>
      <div class="form-text" style="font-size:.7rem;">Sampai</div>
    </div>
  </div>
  <div class="form-text mb-3" style="font-size:.72rem;color:var(--muted);">
    <i class="bi bi-info-circle me-1"></i>Harga dapat berbeda tiap kamar
  </div>

  {{-- Divider --}}
  <hr style="border-color:#f0f3f8;margin:.5rem 0 1rem;">

  {{-- Diskon --}}
<div class="mb-3">
  <label class="form-label">
    Diskon <span style="font-size:.7rem;color:var(--muted);font-weight:500;">(opsional)</span>
  </label>

  <div class="input-group">
    <span class="input-group-text" style="font-size:.78rem;background:#f8fafd;border-color:var(--line);">Rp</span>
    <input type="number" name="diskon" class="form-control"
           placeholder="Contoh: 200000"
           value="{{ old('diskon') }}">
  </div>

  <div class="form-text" style="font-size:.72rem;color:var(--muted);">
    <i class="bi bi-lightning-charge me-1"></i>
    Kos kamu akan tampil dengan badge <strong>Diskon</strong> di halaman utama
  </div>
</div>

  {{-- Harga Per Hari --}}
  <div class="d-flex align-items-center justify-content-between mb-2">
    <label class="form-label mb-0">Harga Per Hari <span style="font-size:.7rem;color:var(--muted);font-weight:500;">(opsional)</span></label>
    <div class="form-check form-switch mb-0">
    <input class="form-check-input" type="checkbox" id="toggleHarian"
       name="ada_harian" value="1"
       {{ old('ada_harian') ? 'checked' : '' }}
       onchange="document.getElementById('sectionHarian').style.display = this.checked ? 'block' : 'none'">    </div>
  </div>

  <div id="sectionHarian" style="display:{{ old('ada_harian') ? 'block' : 'none' }};">
    <div class="row g-2 mb-1">
      <div class="col-6">
        <div class="input-group">
          <span class="input-group-text" style="font-size:.78rem;background:#f8fafd;border-color:var(--line);">Rp</span>
          <input type="number" name="harga_harian_mulai" class="form-control"
                 placeholder="75000" value="{{ old('harga_harian_mulai') }}">
        </div>
        <div class="form-text" style="font-size:.7rem;">Mulai dari</div>
      </div>
      <div class="col-6">
        <div class="input-group">
          <span class="input-group-text" style="font-size:.78rem;background:#f8fafd;border-color:var(--line);">Rp</span>
          <input type="number" name="harga_harian_sampai" class="form-control"
                 placeholder="150000" value="{{ old('harga_harian_sampai') }}">
        </div>
        <div class="form-text" style="font-size:.7rem;">Sampai</div>
      </div>
    </div>
    <div class="form-text" style="font-size:.72rem;color:var(--muted);">
      <i class="bi bi-info-circle me-1"></i>Harga harian dapat berbeda tiap kamar
    </div>
  </div>

</div>

            <div class="form-card">
              <h6><i class="bi bi-toggle-on" style="color:var(--primary)"></i> Status</h6>
              <select name="status" class="form-select">
                <option value="aktif"    {{ old('status') == 'aktif'    ? 'selected' : '' }}>Aktif</option>
                <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
              </select>
            </div>
            <div class="form-card">
  <h6><i class="bi bi-geo-alt" style="color:var(--primary)"></i> Lokasi di Peta</h6>
  <p style="font-size:.75rem;color:var(--muted);margin-bottom:.7rem;">
    Masukkan alamat lalu klik <strong>Cari Lokasi</strong>, atau klik langsung di peta.
  </p>

  {{-- TOMBOL CARI LOKASI --}}
  <div class="mb-2">
    <input type="text" id="inputCariLokasi" class="form-control mb-2"
           placeholder="Ketik alamat kost di sini..."
           style="border-radius:.75rem;font-size:.82rem;">
    <div class="d-flex gap-2">
      <button type="button" id="btnCariLokasi"
              onclick="cariLokasi()"
              style="background:linear-gradient(135deg,#e8401c,#ff7043);color:#fff;
                     border:none;border-radius:.75rem;padding:.55rem 1rem;
                     font-size:.82rem;font-weight:700;cursor:pointer;
                     display:flex;align-items:center;gap:.4rem;width:100%;">
        <i class="bi bi-search"></i> Cari Lokasi
      </button>
    </div>
    <div id="lokasiStatus" style="font-size:.75rem;color:var(--muted);margin-top:.4rem;"></div>
  </div>

  <div id="map"></div>
  <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
  <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">
            </div>

          </div>
        </div>

        <div class="d-flex gap-2 mt-2 mb-4">
          <button type="submit" class="btn-submit">
            <i class="bi bi-check-lg"></i> Simpan Kost
          </button>
          <a href="{{ route('owner.kost.index') }}"
             class="btn btn-outline-secondary"
             style="border-radius:.75rem;padding:.7rem 1.2rem;font-size:.85rem;">
            Batal
          </a>
        </div>

      </form>
    </div>

    <footer class="owner-footer">
      © {{ date('Y') }} KostFinder — Panel Pemilik Kost. All rights reserved.
    </footer>
  </div>

  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script><script>
    // ═══════════════════════════════════════════════════════════════
    //  SIDEBAR
    // ═══════════════════════════════════════════════════════════════
    function toggleSidebar() {
        const s = document.getElementById('sidebar');
        const m = document.getElementById('mainContent');
        if (window.innerWidth <= 991) { s?.classList.toggle('show'); }
        else { s?.classList.toggle('collapsed'); m?.classList.toggle('collapsed'); }
    }

    // ═══════════════════════════════════════════════════════════════
    //  MAP SETUP
    // ═══════════════════════════════════════════════════════════════
    const initLat = Number('{{ old('latitude', -7.4478) }}') || -7.4478;
    const initLng = Number('{{ old('longitude', 112.7183) }}') || 112.7183;
    
    const map = L.map('map').setView([initLat, initLng], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap'
    }).addTo(map);

    const latInput = document.getElementById('latitude');
    const lngInput = document.getElementById('longitude');
    let marker = null;

    // ═══════════════════════════════════════════════════════════════
    //  SET MARKER (BISA DIGESER)
    // ═══════════════════════════════════════════════════════════════
    function setMarker(lat, lng) {
        latInput.value = lat.toFixed(7);
        lngInput.value = lng.toFixed(7);

        if (marker) {
            marker.setLatLng([lat, lng]);
        } else {
            marker = L.marker([lat, lng], { draggable: true }).addTo(map);
            
            // Saat digeser → update koordinat
            marker.on('dragend', function() {
                const pos = marker.getLatLng();
                latInput.value = pos.lat.toFixed(7);
                lngInput.value = pos.lng.toFixed(7);
                showStatus('Koordinat diperbarui: ' + pos.lat.toFixed(5) + ', ' + pos.lng.toFixed(5), 'success');
            });
        }
        
        marker.bindPopup('📍 Lokasi kost').openPopup();
    }

    // Init marker kalau ada old value
    if (latInput.value && lngInput.value) {
        setMarker(parseFloat(latInput.value), parseFloat(lngInput.value));
    }

    // Klik peta → set lokasi
    map.on('click', function(e) {
        setMarker(e.latlng.lat, e.latlng.lng);
        map.setView([e.latlng.lat, e.latlng.lng], 17);
        showStatus('Lokasi dipilih dari peta', 'success');
    });

    setTimeout(() => map.invalidateSize(), 300);

    // ═══════════════════════════════════════════════════════════════
    //  CARI LOKASI (PAKAI FETCH API)
    // ═══════════════════════════════════════════════════════════════
    function showStatus(msg, type) {
        const colors = { success: '#16a34a', warning: '#f59e0b', error: '#dc2626' };
        const icons = { success: 'check-circle', warning: 'exclamation-triangle', error: 'x-circle' };
        document.getElementById('lokasiStatus').innerHTML = 
            '<span style="color:' + colors[type] + '"><i class="bi bi-' + icons[type] + ' me-1"></i>' + msg + '</span>';
    }

    async function cariLokasi() {
        const inputCari = document.getElementById('inputCariLokasi').value.trim();
        const alamat = inputCari || document.querySelector('textarea[name="alamat"]').value.trim();
        const kota = document.querySelector('select[name="kota"]').value;
        const btn = document.getElementById('btnCariLokasi');

        if (!alamat) {
            showStatus('Isi alamat dulu!', 'error');
            return;
        }

        btn.disabled = true;
        showStatus('Mencari lokasi...', 'warning');

        // Buat 4 level query (dari spesifik ke umum)
        const queries = [];
        
        // Level 1: Alamat lengkap
        queries.push(alamat + (kota ? ', ' + kota : '') + ', Jawa Timur, Indonesia');
        
        // Level 2: Area/Dusun/Desa saja
        const area = alamat.match(/(Dusun|Desa|Banjar|Krajan)\s+\w+/i);
        if (area) queries.push(area[0] + ', ' + kota + ', Jawa Timur, Indonesia');
        
        // Level 3: Kecamatan
        const kec = alamat.match(/(Kec\.?|Kecamatan)\s+(\w+)/i);
        if (kec) queries.push('Kecamatan ' + kec[2] + ', ' + kota + ', Jawa Timur, Indonesia');
        
        // Level 4: Kota saja
        if (kota) queries.push(kota + ', Jawa Timur, Indonesia');

        // Coba satu per satu
        for (const query of queries) {
            console.log('🔍 Coba:', query);
            
            try {
                const res = await fetch('https://nominatim.openstreetmap.org/search?format=json&q=' + encodeURIComponent(query) + '&limit=1&accept-language=id');
                const data = await res.json();

                if (data.length > 0) {
                    const lat = parseFloat(data[0].lat);
                    const lng = parseFloat(data[0].lon);
                    
                    setMarker(lat, lng);
                    map.setView([lat, lng], 18);
                    showStatus('Ditemukan: ' + data[0].display_name.split(',')[0], 'success');
                    
                    btn.disabled = false;
                    return; // Berhenti kalau ketemu
                }
            } catch (e) {
                console.log('❌ Gagal:', query);
            }
        }

        // Kalau semua gagal
        showStatus('Tidak ditemukan. Coba klik langsung di peta!', 'error');
        btn.disabled = false;
    }

    // Enter key
    document.getElementById('inputCariLokasi').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            cariLokasi();
        }
    });

    // ═══════════════════════════════════════════════════════════════
    //  UPLOAD FOTO (TETAP SAMA)
    // ═══════════════════════════════════════════════════════════════
    const MAX_FILES = 6, MAX_MB = 2;
    const dropZone = document.getElementById('dropZone');
    const fotoInput = document.getElementById('fotoInput');
    const previewGrid = document.getElementById('previewGrid');
    const infoBar = document.getElementById('fotoInfoBar');
    const infoText = document.getElementById('fotoInfoText');
    let selectedFiles = [];

    ['dragenter','dragover','dragleave','drop'].forEach(evt => {
        dropZone.addEventListener(evt, e => { e.preventDefault(); e.stopPropagation(); }, false);
    });

    dropZone.addEventListener('dragover', () => dropZone.classList.add('drag-over'));
    dropZone.addEventListener('dragleave', () => dropZone.classList.remove('drag-over'));
    dropZone.addEventListener('drop', e => {
        dropZone.classList.remove('drag-over');
        handleFiles(Array.from(e.dataTransfer.files));
    });

    fotoInput.addEventListener('change', () => handleFiles(Array.from(fotoInput.files)));
    dropZone.addEventListener('click', e => { if(!e.target.closest('.btn-pilih-foto')) fotoInput.click(); });

    function handleFiles(newFiles) {
        const images = newFiles.filter(f => f.type.startsWith('image/'));
        if (images.length !== newFiles.length) return alert('Hanya gambar!');
        if (images.some(f => f.size > MAX_MB*1024*1024)) return alert('Maks 2MB!');
        
        selectedFiles = [...selectedFiles, ...images].slice(0, MAX_FILES);
        if (selectedFiles.length === MAX_FILES) alert('Maks 6 foto!');
        
        updateInput();
        renderPreviews();
    }

    function updateInput() {
        const dt = new DataTransfer();
        selectedFiles.forEach(f => dt.items.add(f));
        fotoInput.files = dt.files;
    }

    function renderPreviews() {
        previewGrid.innerHTML = '';
        infoBar.style.display = selectedFiles.length ? 'flex' : 'none';
        infoText.textContent = selectedFiles.length + ' dari ' + MAX_FILES + ' foto';
        
        for(let i=1; i<=MAX_FILES; i++) {
            const dot = document.getElementById('dot'+i);
            if(dot) dot.classList.toggle('filled', i <= selectedFiles.length);
        }

        selectedFiles.forEach((file, i) => {
            const reader = new FileReader();
            reader.onload = e => {
                const div = document.createElement('div');
                div.className = 'preview-card' + (i===0?' is-cover':'');
                div.innerHTML = `
                    <div class="preview-img-wrap">
                        <img src="${e.target.result}">
                        <div class="preview-img-overlay"></div>
                        ${i===0?'<div class="badge-cover"><i class="bi bi-star-fill"></i> Cover</div>':''}
                        <span class="badge-num">Foto ${i+1}</span>
                        <button type="button" class="btn-remove" onclick="removeFile(${i})"><i class="bi bi-x-lg"></i></button>
                        ${i!==0?`<button type="button" class="btn-set-cover" onclick="setCover(${i})"><i class="bi bi-star"></i> Cover</button>`:''}
                    </div>
                    <div class="preview-info">
                        <div class="preview-name">${file.name}</div>
                        <div class="preview-size">${(file.size/1024/1024).toFixed(2)}MB</div>
                    </div>`;
                previewGrid.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    }

    window.removeFile = function(idx) {
        selectedFiles.splice(idx, 1);
        updateInput();
        renderPreviews();
    };

    window.setCover = function(idx) {
        const [moved] = selectedFiles.splice(idx, 1);
        selectedFiles.unshift(moved);
        updateInput();
        renderPreviews();
    };
</script>
</body>
</html>