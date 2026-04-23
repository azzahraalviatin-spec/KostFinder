<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Owner - KostFinder</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.css"/>
  <style>
    :root {
      --bg: #f6efe8; --panel: #ffffff; --panel-soft: #fbf6f2;
      --ink: #1f2937; --muted: #6b7280; --line: #e8ddd5;
      --accent: #d65a31; --accent-dark: #b4441e; --accent-soft: #fff2eb;
      --navy: #17324d; --shadow: 0 24px 70px rgba(27,36,52,.14);
    }
    * { box-sizing: border-box; }
    body {
      margin: 0; min-height: 100vh; font-family: 'Segoe UI', sans-serif; color: var(--ink);
      background: radial-gradient(circle at top left,rgba(214,90,49,.16),transparent 24%),
        radial-gradient(circle at bottom right,rgba(23,50,77,.12),transparent 26%),
        linear-gradient(135deg,#fffaf7 0%,#f7efe7 46%,#f2e6dd 100%);
      padding: 24px;
    }
    .register-shell {
      max-width: 1240px; margin: 0 auto; min-height: calc(100vh - 48px);
      display: grid; grid-template-columns: 1fr 1fr;
      background: rgba(255,255,255,.72); border: 1px solid rgba(255,255,255,.6);
      border-radius: 32px; overflow: hidden; box-shadow: var(--shadow); backdrop-filter: blur(8px);
    }
    /* SIDE */
    .register-side {
      position: relative; color: #fff;
      background: linear-gradient(180deg,rgba(8,20,34,.16) 0%,rgba(8,20,34,.58) 48%,rgba(8,20,34,.9) 100%),
        url('{{ asset('images/daftar.png') }}') center center / cover no-repeat;
      min-height: 100%; display: flex; align-items: flex-start;
    }
    .side-content { position: relative; z-index: 1; width: 100%; padding: 52px 38px 44px; display: flex; justify-content: center; }
    .side-copy { display: grid; gap: 12px; width: 100%; max-width: 520px; margin-top: clamp(8px,5vh,48px); justify-items: start; text-align: left; }
    .side-copy h1 { margin: 0; font-size: clamp(2rem,3vw,3.1rem); font-weight: 800; line-height: 1.12; max-width: 11ch; text-shadow: 0 8px 30px rgba(0,0,0,.32); }
    .side-copy p  { margin: 0; color: rgba(255,255,255,.88); line-height: 1.65; font-size: 1rem; text-shadow: 0 6px 22px rgba(0,0,0,.26); }
    .side-steps   { margin-top: 28px; display: flex; flex-direction: column; align-items: flex-start; gap: 0; }
    .side-step-item { display: flex; align-items: center; gap: 12px; padding: 10px 0; position: relative; }
    .side-step-item:not(:last-child)::after { content:''; position: absolute; left: 13px; top: 100%; width: 2px; height: 100%; background: rgba(255,255,255,.2); }
    .side-step-dot { width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: .78rem; font-weight: 800; flex-shrink: 0; transition: all .3s; }
    .side-step-dot.active { background: var(--accent); color: #fff; box-shadow: 0 0 0 4px rgba(214,90,49,.3); }
    .side-step-dot.done   { background: #22c55e; color: #fff; }
    .side-step-dot.idle   { background: rgba(255,255,255,.15); color: rgba(255,255,255,.5); border: 1.5px solid rgba(255,255,255,.2); }
    .side-step-label      { font-size: .84rem; font-weight: 600; color: rgba(255,255,255,.85); }
    .side-step-label.idle { color: rgba(255,255,255,.4); }
    /* MAIN */
    .register-main { background: var(--panel); padding: 40px 42px; overflow-y: auto; }
    .brand-link { display: inline-flex; align-items: center; gap: 10px; margin-bottom: 22px; color: var(--navy); text-decoration: none; font-weight: 800; letter-spacing: .06em; }
    .brand-link i { width: 40px; height: 40px; display: inline-flex; align-items: center; justify-content: center; border-radius: 14px; background: var(--accent-soft); color: var(--accent); font-size: 1.1rem; }
    .intro-copy h2 { margin: 0 0 8px; font-size: clamp(1.8rem,2.4vw,2.4rem); font-weight: 800; line-height: 1.12; }
    .intro-copy p  { margin: 0; color: var(--muted); max-width: 60ch; line-height: 1.7; }
    /* PROGRESS */
    .progress-wrap { display: flex; align-items: center; gap: 12px; margin: 24px 0 32px; }
    .prog-step { display: flex; align-items: center; gap: 8px; font-size: .82rem; font-weight: 700; }
    .prog-num { width: 26px; height: 26px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: .74rem; font-weight: 800; transition: all .3s; }
    .prog-num.active { background: var(--accent); color: #fff; }
    .prog-num.done   { background: #22c55e; color: #fff; }
    .prog-num.idle   { background: var(--line); color: var(--muted); }
    .prog-label.active { color: var(--ink); }
    .prog-label.done   { color: #22c55e; }
    .prog-label.idle   { color: var(--muted); }
    .prog-line { flex: 1; height: 2px; border-radius: 2px; background: var(--line); position: relative; overflow: hidden; }
    .prog-line-fill { position: absolute; left: 0; top: 0; bottom: 0; background: #22c55e; border-radius: 2px; transition: width .4s ease; width: 0%; }
    /* PANELS */
    .step-panel { display: none; }
    .step-panel.active { display: block; animation: slideUp .3s ease; }
    @keyframes slideUp { from{opacity:0;transform:translateY(14px);}to{opacity:1;transform:translateY(0);} }
    .section-head { display: flex; justify-content: space-between; align-items: flex-start; gap: 16px; margin-bottom: 20px; padding-bottom: 14px; border-bottom: 1px solid var(--line); }
    .section-title    { margin: 0; font-size: 1rem; font-weight: 800; color: var(--navy); }
    .section-subtitle { margin: 4px 0 0; color: var(--muted); font-size: .88rem; line-height: 1.6; }
    /* FORM */
    .form-label { font-size: .78rem; font-weight: 800; letter-spacing: .09em; color: #374151; margin-bottom: 8px; }
    .input-group-text { background: var(--panel-soft); border: 1px solid var(--line); border-right: 0; color: #8a776d; border-radius: 16px 0 0 16px; padding: 0 16px; }
    .input-group-text.eye { border-left: 0; border-right: 1px solid var(--line); border-radius: 0 16px 16px 0; cursor: pointer; }
    .form-control { border: 1px solid var(--line); background: var(--panel-soft); min-height: 52px; border-radius: 16px; color: var(--ink); padding: 14px 16px; }
    .input-group > .form-control { border-left: 0; border-radius: 0 16px 16px 0; }
    .form-control:focus { box-shadow: 0 0 0 .22rem rgba(214,90,49,.12); border-color: rgba(214,90,49,.48); background: #fff; }
    .field-hint { margin-top: 8px; color: var(--muted); font-size: .8rem; line-height: 1.5; }
    /* ALAMAT DROPDOWN */
    .alamat-wrap { position: relative; }
    .alamat-suggestions { display: none; position: absolute; top: calc(100% + 6px); left: 0; right: 0; background: #fff; border: 1px solid var(--line); border-radius: 18px; box-shadow: 0 16px 40px rgba(31,41,55,.13); z-index: 1200; max-height: 240px; overflow-y: auto; }
    .sug-item { width: 100%; text-align: left; background: transparent; border: 0; padding: 12px 16px; cursor: pointer; transition: background .15s; display: flex; align-items: flex-start; gap: 10px; }
    .sug-item:hover { background: #fff4ed; }
    .sug-item i { color: var(--accent); margin-top: 3px; flex-shrink: 0; }
    .sug-main { display: block; font-size: .88rem; font-weight: 700; color: var(--ink); }
    .sug-sub  { display: block; font-size: .76rem; color: var(--muted); margin-top: 2px; line-height: 1.4; }
    .alamat-spin { position: absolute; right: 14px; top: 50%; transform: translateY(-50%); display: none; z-index: 2; }
    .alamat-spin .spinner-border { width: 18px; height: 18px; border-width: 2px; color: var(--accent); }
    .alamat-status { margin-top: 7px; font-size: .78rem; min-height: 1.1rem; display: flex; align-items: center; gap: 5px; color: var(--muted); }
    .alamat-status.ok  { color: #16a34a; }
    .alamat-status.err { color: #dc2626; }
    /* BUTTONS */
    .btn-lanjut { width: 100%; min-height: 54px; margin-top: 28px; border: 0; border-radius: 16px; background: linear-gradient(135deg,var(--accent) 0%,#e67b4b 100%); color: #fff; font-weight: 800; letter-spacing: .08em; font-size: .95rem; font-family: inherit; box-shadow: 0 16px 30px rgba(214,90,49,.24); display: flex; align-items: center; justify-content: center; gap: 10px; cursor: pointer; transition: transform .15s,box-shadow .15s; }
    .btn-lanjut:hover { transform: translateY(-1px); box-shadow: 0 20px 36px rgba(214,90,49,.3); }
    .btn-back-step { display: inline-flex; align-items: center; gap: 8px; background: none; border: 1px solid var(--line); border-radius: 12px; padding: 8px 16px; font-size: .84rem; font-weight: 700; color: var(--muted); cursor: pointer; margin-bottom: 20px; transition: background .15s,color .15s; font-family: inherit; }
    .btn-back-step:hover { background: var(--panel-soft); color: var(--ink); }
    /* AUTO FILL GRID */
    .auto-fill-grid { display: grid; grid-template-columns: repeat(4,minmax(0,1fr)); gap: 14px; }
    .auto-fill-card { border: 1px solid var(--line); border-radius: 18px; background: #fff; padding: 14px 15px; }
    .auto-fill-card span { display: block; font-size: .72rem; font-weight: 800; letter-spacing: .08em; color: #9a8477; margin-bottom: 8px; }
    .auto-fill-card .form-control { min-height: 46px; padding: 12px 14px; border-radius: 14px; background: var(--panel-soft); }
    .coord-grid { display: grid; grid-template-columns: repeat(2,minmax(0,1fr)); gap: 8px; }
    /* MAP */
    .map-card { border: 1px solid var(--line); border-radius: 24px; background: #fff; overflow: hidden; margin-top: 4px; }
    .map-topbar { padding: 14px 18px; display: flex; align-items: center; justify-content: space-between; gap: 12px; background: linear-gradient(180deg,#fff8f3 0%,#fff 100%); border-bottom: 1px solid var(--line); }
    .map-topbar p { margin: 3px 0 0; color: var(--muted); font-size: .8rem; }
    .map-badge { flex-shrink: 0; padding: 8px 12px; border-radius: 999px; background: #17324d; color: #fff; font-size: .74rem; font-weight: 700; white-space: nowrap; }
    .map-badge.ok { background: #16a34a; }
    #map { height: 300px; z-index: 0; }
    .map-status { padding: 8px 18px 10px; font-size: .78rem; color: var(--muted); background: #fff; min-height: 30px; }
    /* FORM ACTIONS */
    .form-actions { display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap; padding-top: 6px; margin-top: 24px; }
    .helper-links { color: var(--muted); font-size: .88rem; line-height: 1.65; }
    .helper-links a { color: var(--accent); font-weight: 700; text-decoration: none; }
    .btn-daftar { min-width: 220px; min-height: 54px; border: 0; border-radius: 16px; background: linear-gradient(135deg,var(--accent) 0%,#e67b4b 100%); color: #fff; font-weight: 800; letter-spacing: .08em; box-shadow: 0 16px 30px rgba(214,90,49,.24); }
    .btn-daftar:hover { background: linear-gradient(135deg,var(--accent-dark) 0%,#d96838 100%); color: #fff; }
    .alert { border-radius: 18px; border: 0; margin-bottom: 18px; }
    .inline-error { display: none; margin-top: 14px; padding: 12px 16px; background: #fff2f2; border: 1px solid #fecaca; border-radius: 14px; font-size: .84rem; color: #b91c1c; }
    @media(max-width:1099px){.register-shell{grid-template-columns:1fr;}.register-side{min-height:260px;}}
    @media(max-width:767px){body{padding:14px;}.register-main{padding:22px 18px;}.side-content{padding:30px 22px 22px;}.side-copy{margin-top:0;max-width:100%;}.form-actions,.map-topbar{display:block;}.map-badge,.btn-daftar{margin-top:12px;}.auto-fill-grid{grid-template-columns:1fr 1fr;}#map{height:260px;}}
    @media(max-width:575px){.auto-fill-grid{grid-template-columns:1fr;}.coord-grid{grid-template-columns:1fr;}.btn-daftar{width:100%;}.btn-lanjut{font-size:.88rem;}}
  </style>
</head>
<body>
<div class="register-shell">

  <aside class="register-side">
    <div class="side-content">
      <div class="side-copy">
        <h1>Daftarkan Kost Anda dan Kelola Properti dengan Lebih Mudah</h1>
        <p>Bergabung dengan ribuan pemilik kost terpercaya.</p>
        <p>Ketik alamat — semua field &amp; peta otomatis terisi!</p>
        <div class="side-steps">
          <div class="side-step-item">
            <div class="side-step-dot active" id="side-dot-1">1</div>
            <span class="side-step-label" id="side-lbl-1">Data Owner</span>
          </div>
          <div class="side-step-item">
            <div class="side-step-dot idle" id="side-dot-2">2</div>
            <span class="side-step-label idle" id="side-lbl-2">Alamat &amp; Peta</span>
          </div>
        </div>
      </div>
    </div>
  </aside>

  <main class="register-main">
    <a href="{{ route('register') }}" class="brand-link">
      <i class="bi bi-house-heart"></i>
      <span>KOSTFINDER OWNER</span>
    </a>

    <div class="intro-copy">
      <h2>Buat akun owner dan atur alamat properti dengan lebih cepat.</h2>
      <p>Isi data diri dulu, lalu lanjutkan ke alamat properti kamu.</p>
    </div>

    @if($errors->any())
      <div class="alert alert-danger py-3 px-3">{{ $errors->first() }}</div>
    @endif

    <div class="progress-wrap">
      <div class="prog-step">
        <div class="prog-num active" id="prog-num-1">1</div>
        <span class="prog-label active" id="prog-lbl-1">Data Diri</span>
      </div>
      <div class="prog-line"><div class="prog-line-fill" id="prog-fill"></div></div>
      <div class="prog-step">
        <div class="prog-num idle" id="prog-num-2">2</div>
        <span class="prog-label idle" id="prog-lbl-2">Alamat &amp; Peta</span>
      </div>
    </div>

    <form method="POST" action="{{ route('register.owner.store') }}" id="register-form" novalidate>
      @csrf

      {{-- STEP 1 --}}
      <div class="step-panel active" id="step-1">
        <div class="section-head">
          <div>
            <h3 class="section-title">Data Owner</h3>
            <p class="section-subtitle">Isi identitas utama untuk akun pemilik kost.</p>
          </div>
        </div>
        <div class="row g-3">
          <div class="col-12">
            <label class="form-label">NAMA LENGKAP</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-person"></i></span>
              <input type="text" name="name" id="f-name" class="form-control" placeholder="Nama lengkap pemilik kost" value="{{ old('name') }}">
            </div>
          </div>
          <div class="col-md-6">
            <label class="form-label">NOMOR HANDPHONE</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-telephone"></i></span>
              <input type="text" name="no_hp" id="f-hp" class="form-control" placeholder="+62 812-3456-7890" value="{{ old('no_hp') }}">
            </div>
          </div>
          <div class="col-md-6">
            <label class="form-label">EMAIL</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-envelope"></i></span>
              <input type="email" name="email" id="f-email" class="form-control" placeholder="email@kost.com" value="{{ old('email') }}">
            </div>
          </div>
          <div class="col-md-6">
            <label class="form-label">PASSWORD</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-lock"></i></span>
              <input type="password" name="password" id="password1" class="form-control" placeholder="Minimal 8 karakter">
              <span class="input-group-text eye" onclick="togglePass('password1','eye1')"><i class="bi bi-eye" id="eye1"></i></span>
            </div>
          </div>
          <div class="col-md-6">
            <label class="form-label">KONFIRMASI PASSWORD</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-lock"></i></span>
              <input type="password" name="password_confirmation" id="password2" class="form-control" placeholder="Ulangi password">
              <span class="input-group-text eye" onclick="togglePass('password2','eye2')"><i class="bi bi-eye" id="eye2"></i></span>
            </div>
          </div>
        </div>
        <div class="inline-error" id="step1-error"></div>
        <button type="button" class="btn-lanjut" onclick="goStep2()">
          Lanjut ke Alamat &amp; Peta <i class="bi bi-arrow-right"></i>
        </button>
        <div class="form-actions" style="margin-top:20px;padding-top:20px;border-top:1px solid var(--line);">
          <div class="helper-links">
            Sudah punya akun owner? <a href="{{ route('login', ['role'=>'owner']) }}">Masuk di sini</a><br>
            Ingin daftar sebagai pencari kos? <a href="{{ route('register.user') }}">Pilih form user</a>
          </div>
        </div>
      </div>

      {{-- STEP 2 --}}
      <div class="step-panel" id="step-2">
        <button type="button" class="btn-back-step" onclick="goStep1()">
          <i class="bi bi-arrow-left"></i> Kembali ke Data Owner
        </button>
        <div class="section-head">
          <div>
            <h3 class="section-title">Alamat dan Peta</h3>
            <p class="section-subtitle">Ketik alamat → sistem otomatis isi semua field. Atau klik langsung di peta.</p>
          </div>
        </div>

        <div class="row g-3 mb-2">
          <div class="col-12">
            <label class="form-label">ALAMAT LENGKAP</label>
            <div class="alamat-wrap">
              <div class="input-group" style="position:relative;">
                <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                <input type="text" name="alamat" id="alamat" class="form-control"
                  placeholder="Ketik nama jalan / kelurahan / kota kamu..."
                  value="{{ old('alamat') }}" autocomplete="off">
                <div class="alamat-spin" id="alamat-spin">
                  <div class="spinner-border" role="status"></div>
                </div>
              </div>
              <div class="alamat-suggestions" id="alamat-suggestions"></div>
            </div>
            <div class="alamat-status" id="alamat-status">
              <i class="bi bi-lightbulb"></i>&nbsp;Ketik minimal 4 huruf — saran & isi otomatis aktif.
            </div>
          </div>
          <div class="col-md-4">
            <label class="form-label">KOTA / KABUPATEN</label>
            <input type="text" name="kota" id="kota" class="form-control" placeholder="Otomatis terisi" value="{{ old('kota') }}">
          </div>
          <div class="col-md-4">
            <label class="form-label">PROVINSI</label>
            <input type="text" name="provinsi" id="provinsi" class="form-control" placeholder="Otomatis terisi" value="{{ old('provinsi') }}">
          </div>
          <div class="col-md-4">
            <label class="form-label">KODE POS</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-mailbox"></i></span>
              <input type="text" name="kode_pos" id="kode_pos" class="form-control" placeholder="Otomatis terisi" value="{{ old('kode_pos') }}">
            </div>
          </div>
        </div>

        <div class="auto-fill-grid mb-3">
          <div class="auto-fill-card">
            <span>KECAMATAN</span>
            <input type="text" name="kecamatan" id="kecamatan" class="form-control" placeholder="Otomatis terisi" value="{{ old('kecamatan') }}">
          </div>
          <div class="auto-fill-card">
            <span>KELURAHAN / DESA</span>
            <input type="text" name="kelurahan" id="kelurahan" class="form-control" placeholder="Otomatis terisi" value="{{ old('kelurahan') }}">
          </div>
          <div class="auto-fill-card">
            <span>AREA / JALAN</span>
            <input type="text" name="area_jalan" id="area_jalan" class="form-control" placeholder="Otomatis terisi" value="{{ old('area_jalan') }}">
          </div>
          <div class="auto-fill-card">
            <span>TITIK KOORDINAT</span>
            <div class="coord-grid">
              <input type="text" name="latitude"  id="latitude"  class="form-control" placeholder="Lat" value="{{ old('latitude') }}">
              <input type="text" name="longitude" id="longitude" class="form-control" placeholder="Lng" value="{{ old('longitude') }}">
            </div>
          </div>
        </div>

        <div class="map-card">
          <div class="map-topbar">
            <div>
              <strong>Konfirmasi lokasi di peta</strong>
              <p>Pilih saran alamat di atas, atau klik / geser pin di peta.</p>
            </div>
            <div class="map-badge" id="map-badge">Siap dipilih</div>
          </div>
          <div id="map"></div>
          <div class="map-status" id="map-status">Belum ada titik dipilih. Ketik alamat atau klik peta.</div>
        </div>

        <div class="inline-error" id="step2-error"></div>
        <div class="form-actions">
          <div class="helper-links">
            Sudah punya akun owner? <a href="{{ route('login', ['role'=>'owner']) }}">Masuk di sini</a>
          </div>
          <button type="button" class="btn btn-daftar" onclick="submitForm()">DAFTAR SEKARANG</button>
        </div>
      </div>
    </form>
  </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
// ═══════════════════════════════════════════
// STATE
// ═══════════════════════════════════════════
let mapInitialized = false, map, marker;
let searchTimer    = null;
let isProg         = false; // true saat kode sedang isi field → skip event input

// ═══════════════════════════════════════════
// STEP NAVIGATION
// ═══════════════════════════════════════════
function goStep2() {
  const name  = document.getElementById('f-name').value.trim();
  const hp    = document.getElementById('f-hp').value.trim();
  const email = document.getElementById('f-email').value.trim();
  const pw1   = document.getElementById('password1').value;
  const pw2   = document.getElementById('password2').value;
  const errEl = document.getElementById('step1-error');

  if (!name)          { showErr(errEl,'Nama lengkap harus diisi.'); return; }
  if (!hp)            { showErr(errEl,'Nomor HP harus diisi.'); return; }
  if (!email)         { showErr(errEl,'Email harus diisi.'); return; }
  if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) { showErr(errEl,'Format email tidak valid.'); return; }
  if (!pw1)           { showErr(errEl,'Password harus diisi.'); return; }
  if (pw1.length < 8) { showErr(errEl,'Password minimal 8 karakter.'); return; }
  if (pw1 !== pw2)    { showErr(errEl,'Password dan konfirmasi tidak cocok.'); return; }

  errEl.style.display = 'none';
  document.getElementById('step-1').classList.remove('active');
  document.getElementById('step-2').classList.add('active');
  setProgress(2);
  if (!mapInitialized) { initMap(); mapInitialized = true; }
  window.scrollTo({ top:0, behavior:'smooth' });
}

function goStep1() {
  document.getElementById('step-2').classList.remove('active');
  document.getElementById('step-1').classList.add('active');
  setProgress(1);
  window.scrollTo({ top:0, behavior:'smooth' });
}

function showErr(el, msg) { el.textContent = msg; el.style.display = 'block'; }

function submitForm() {
  const alamat = document.getElementById('alamat').value.trim();
  const errEl  = document.getElementById('step2-error');
  if (!alamat) { showErr(errEl,'Alamat lengkap harus diisi atau dipilih dari saran.'); return; }
  errEl.style.display = 'none';
  document.getElementById('register-form').submit();
}

function setProgress(step) {
  const n1=document.getElementById('prog-num-1'),l1=document.getElementById('prog-lbl-1');
  const n2=document.getElementById('prog-num-2'),l2=document.getElementById('prog-lbl-2');
  const fill=document.getElementById('prog-fill');
  const sd1=document.getElementById('side-dot-1'),sl1=document.getElementById('side-lbl-1');
  const sd2=document.getElementById('side-dot-2'),sl2=document.getElementById('side-lbl-2');
  if (step===1) {
    n1.className='prog-num active';n1.textContent='1';l1.className='prog-label active';
    n2.className='prog-num idle';  n2.textContent='2';l2.className='prog-label idle';
    fill.style.width='0%';
    sd1.className='side-step-dot active';sd1.textContent='1';sl1.className='side-step-label';
    sd2.className='side-step-dot idle';  sd2.textContent='2';sl2.className='side-step-label idle';
  } else {
    n1.className='prog-num done';n1.innerHTML='<i class="bi bi-check" style="font-size:.8rem"></i>';l1.className='prog-label done';
    n2.className='prog-num active';n2.textContent='2';l2.className='prog-label active';
    fill.style.width='100%';
    sd1.className='side-step-dot done';sd1.innerHTML='<i class="bi bi-check" style="font-size:.8rem"></i>';sl1.className='side-step-label';
    sd2.className='side-step-dot active';sd2.textContent='2';sl2.className='side-step-label';
  }
}

// ═══════════════════════════════════════════
// MAP
// ═══════════════════════════════════════════
function initMap() {
  map = L.map('map').setView([-2.5489,118.0149],5);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{attribution:'&copy; OpenStreetMap'}).addTo(map);
  marker = L.marker([-2.5489,118.0149],{draggable:true}).addTo(map);
  marker.on('dragend', function() {
    const {lat,lng}=marker.getLatLng();
    setMapStatus('Membaca alamat dari titik baru...');
    reverseGeocode(lat,lng);
  });
  map.on('click', function(e) {
    const {lat,lng}=e.latlng;
    marker.setLatLng([lat,lng]);
    map.setView([lat,lng],Math.max(map.getZoom(),16));
    setMapStatus('Membaca alamat...');
    reverseGeocode(lat,lng);
  });
  setTimeout(()=>map.invalidateSize(),280);
}

function moveMap(lat,lng,zoom=17) {
  if (!mapInitialized) return;
  marker.setLatLng([lat,lng]);
  map.setView([lat,lng],zoom);
}

function setMapStatus(msg) { document.getElementById('map-status').textContent=msg; }

// ═══════════════════════════════════════════
// ISI SEMUA FIELD
// ═══════════════════════════════════════════
function fillAllFields(displayName, addr, lat, lng) {
  isProg = true;
  const street = [addr.road, addr.house_number].filter(Boolean).join(' ');
  const builtAlamat = [street, addr.neighbourhood, addr.suburb||addr.village, addr.city||addr.town||addr.county].filter(Boolean).join(', ');

  setVal('alamat',     displayName || builtAlamat || '');
  setVal('kota',       addr.city||addr.town||addr.regency||addr.county||addr.municipality||addr.state_district||'');
  setVal('provinsi',   addr.state||addr.region||addr.province||'');
  setVal('kode_pos',   addr.postcode||'');
  setVal('kecamatan',  addr.city_district||addr.subdistrict||addr.district||addr.county||'');
  setVal('kelurahan',  addr.suburb||addr.village||addr.city_village||addr.neighbourhood||'');
  setVal('area_jalan', addr.road||addr.pedestrian||addr.residential||'');
  setVal('latitude',   Number(lat).toFixed(8));
  setVal('longitude',  Number(lng).toFixed(8));

  const badge=document.getElementById('map-badge');
  badge.textContent='Lokasi terpilih ✓';
  badge.className='map-badge ok';
  hideSuggestions();

  setTimeout(()=>{ isProg=false; },500);
}

function setVal(id,val) { const el=document.getElementById(id); if(el&&val!==undefined) el.value=val; }

// ═══════════════════════════════════════════
// REVERSE GEOCODING
// ═══════════════════════════════════════════
async function reverseGeocode(lat,lng) {
  try {
    const res  = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&addressdetails=1`,{headers:{'Accept-Language':'id'}});
    const data = await res.json();
    if (!data||!data.address) {
      setVal('latitude',Number(lat).toFixed(8)); setVal('longitude',Number(lng).toFixed(8));
      setMapStatus('Titik dipilih. Lengkapi alamat manual bila perlu.');
      return;
    }
    fillAllFields(data.display_name||'',data.address,lat,lng);
    setMapStatus('Alamat berhasil diisi dari titik peta. Periksa & perbaiki bila perlu.');
    setAlamatStatus('Alamat diisi dari klik peta!','ok');
  } catch {
    setVal('latitude',Number(lat).toFixed(8)); setVal('longitude',Number(lng).toFixed(8));
    setMapStatus('Gagal baca alamat otomatis. Isi manual ya.');
  }
}

// ═══════════════════════════════════════════
// FORWARD GEOCODING — coba beberapa variasi
// ═══════════════════════════════════════════
async function searchAlamat(query) {
  const clean = query
    .replace(/\bKec\.\s*/gi,'').replace(/\bKel\.\s*/gi,'')
    .replace(/\bKab\.\s*/gi,'Kabupaten ').replace(/\bJl\.\s*/gi,'Jalan ')
    .replace(/\bNo\.\s*/gi,'').replace(/\bRt\.?\s*/gi,'').replace(/\bRw\.?\s*/gi,'')
    .replace(/\s+/g,' ').trim();

  const parts  = clean.split(',').map(p=>p.trim()).filter(Boolean);
  const full   = clean;
  const medium = parts.slice(-4).join(', ');
  const short  = parts.slice(-3).join(', ');
  const vshort = parts.slice(-2).join(', ');
  const variants = [...new Set([full,medium,short,vshort])].filter(q=>q&&q.length>=3);

  let collected = [];
  for (const v of variants) {
    try {
      const res  = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(v)}&countrycodes=id&limit=5&addressdetails=1`,{headers:{'Accept-Language':'id'}});
      const data = await res.json();
      if (Array.isArray(data)) collected.push(...data);
    } catch { /* lanjut */ }
    if (collected.length >= 5) break;
  }

  // Deduplikasi
  const seen = new Set();
  return collected.filter(item=>seen.has(item.display_name)?false:seen.add(item.display_name)).slice(0,6);
}

// ═══════════════════════════════════════════
// AUTO-FILL LANGSUNG (tanpa pilih saran)
// — dipanggil saat: tidak ada saran, atau user berhenti ketik lama
// ═══════════════════════════════════════════
async function autoFillFromQuery(query) {
  setAlamatStatus('Mengisi field secara otomatis...','');
  setSpinner(true);

  // Bersihkan singkatan
  const clean = query
    .replace(/\bJl\.\s*/gi,'Jalan ').replace(/\bNo\.\s*/gi,'')
    .replace(/\bRt\.?\s*\d*/gi,'').replace(/\bRw\.?\s*\d*/gi,'')
    .replace(/\bKec\.\s*/gi,'').replace(/\bKel\.\s*/gi,'')
    .replace(/\bKab\.\s*/gi,'Kabupaten ').replace(/\bBlok\s+\w+/gi,'')
    .replace(/\s+/g,' ').trim();

  // Pecah jadi bagian-bagian berdasarkan koma
  const parts = clean.split(',').map(p=>p.trim()).filter(p=>p.length>=2);

  // Buat beberapa variasi dari pendek ke panjang (Nominatim lebih berhasil dengan query pendek)
  const variants = [];

  // Variasi 1: 2 bagian terakhir (paling sering berhasil: kelurahan, kota)
  if (parts.length >= 2) variants.push(parts.slice(-2).join(', '));
  // Variasi 2: 3 bagian terakhir
  if (parts.length >= 3) variants.push(parts.slice(-3).join(', '));
  // Variasi 3: 1 bagian terakhir saja (kota/kabupaten)
  if (parts.length >= 1) variants.push(parts[parts.length-1]);
  // Variasi 4: query penuh yang sudah dibersihkan
  if (clean.length >= 4) variants.push(clean);
  // Variasi 5: bagian pertama + 2 bagian terakhir
  if (parts.length >= 4) variants.push([parts[0], ...parts.slice(-2)].join(', '));

  const uniqueVariants = [...new Set(variants)].filter(v=>v&&v.length>=3);

  let found = null;
  for (const v of uniqueVariants) {
    try {
      const res  = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(v)}&countrycodes=id&limit=1&addressdetails=1`,{headers:{'Accept-Language':'id'}});
      const data = await res.json();
      if (data && data.length > 0) { found = data[0]; break; }
    } catch { /* coba variasi berikutnya */ }
  }

  setSpinner(false);

  if (found) {
    const lat = parseFloat(found.lat), lng = parseFloat(found.lon);
    // Untuk display_name tetap pakai query asli user, bukan hasil Nominatim
    // tapi isi field dari data Nominatim
    fillAllFields('', found.address||{}, lat, lng);
    // Kembalikan isian alamat ke teks asli user (lebih detail)
    setVal('alamat', query);
    moveMap(lat,lng,16);
    setMapStatus('Semua field diisi otomatis. Geser pin untuk presisi lebih tinggi.');
    setAlamatStatus('Semua field berhasil diisi otomatis!','ok');
  } else {
    setAlamatStatus('Tidak ditemukan. Coba ketik nama kota/kecamatan saja, atau klik peta.','err');
  }
}

// ═══════════════════════════════════════════
// RENDER SARAN
// ═══════════════════════════════════════════
function renderSuggestions(items, query) {
  const box = document.getElementById('alamat-suggestions');
  box.innerHTML = '';

  if (!items.length) {
    // Tidak ada saran → langsung auto-fill dari query
    box.style.display = 'none';
    autoFillFromQuery(query);
    return;
  }

  items.forEach(item => {
    const btn = document.createElement('button');
    btn.type  = 'button';
    btn.className = 'sug-item';
    const main = item.address.road||item.address.neighbourhood||item.address.suburb||item.address.village||item.name||'Pilih lokasi ini';
    btn.innerHTML = `<i class="bi bi-geo-alt-fill"></i><span><span class="sug-main">${main}</span><span class="sug-sub">${item.display_name}</span></span>`;
    btn.addEventListener('click', ()=>pilihSaran(item));
    box.appendChild(btn);
  });

  box.style.display = 'block';
  setAlamatStatus(`${items.length} lokasi ditemukan — pilih yang paling sesuai, atau tunggu isi otomatis.`,'');

  // Kalau user tidak memilih saran dalam 4 detik → auto-fill dari hasil pertama
  clearTimeout(window._autoPickTimer);
  window._autoPickTimer = setTimeout(()=>{
    if (box.style.display !== 'none') {
      pilihSaran(items[0]);
    }
  }, 4000);
}

function hideSuggestions() {
  document.getElementById('alamat-suggestions').style.display = 'none';
  clearTimeout(window._autoPickTimer);
}

function setAlamatStatus(msg,type) {
  const el=document.getElementById('alamat-status');
  el.className='alamat-status'+(type?' '+type:'');
  const icon=type==='ok'?'check-circle-fill':type==='err'?'exclamation-circle':'lightbulb';
  el.innerHTML=`<i class="bi bi-${icon}"></i>&nbsp;${msg}`;
}

function setSpinner(show) { document.getElementById('alamat-spin').style.display=show?'block':'none'; }

function pilihSaran(item) {
  const lat=parseFloat(item.lat), lng=parseFloat(item.lon);
  fillAllFields(item.display_name, item.address||{}, lat, lng);
  moveMap(lat,lng,17);
  setMapStatus('Alamat dipilih dari saran. Geser pin bila perlu.');
  setAlamatStatus('Semua field berhasil terisi otomatis!','ok');
}

// ═══════════════════════════════════════════
// EVENT: ketik di ALAMAT LENGKAP
// ═══════════════════════════════════════════
document.getElementById('alamat').addEventListener('input', function() {
  if (isProg) return; // sedang diisi kode, abaikan

  const q = this.value.trim();
  clearTimeout(searchTimer);
  clearTimeout(window._autoPickTimer);
  hideSuggestions();

  if (q.length < 4) {
    setSpinner(false);
    setAlamatStatus('Ketik minimal 4 huruf — saran & isi otomatis aktif.','');
    return;
  }

  setSpinner(true);
  setAlamatStatus('Mencari lokasi...','');

  // Setelah 800ms berhenti ketik → cari saran
  // Setelah 2500ms berhenti ketik → langsung auto-fill kalau saran belum dipilih
  searchTimer = setTimeout(async ()=>{
    const results = await searchAlamat(q);
    setSpinner(false);
    renderSuggestions(results, q);

    // Fallback: kalau ada saran tapi user tidak pilih dalam 4 detik, sudah dihandle di renderSuggestions
    // Kalau tidak ada saran, autoFillFromQuery sudah dipanggil di renderSuggestions
  }, 800);
});

// Enter → langsung auto-fill
document.getElementById('alamat').addEventListener('keydown', function(e) {
  if (e.key === 'Enter') {
    e.preventDefault();
    clearTimeout(searchTimer);
    clearTimeout(window._autoPickTimer);
    hideSuggestions();
    const q = this.value.trim();
    if (q.length >= 4) autoFillFromQuery(q);
  }
});

// Tutup dropdown saat klik di luar
document.addEventListener('click', function(e) {
  const box=document.getElementById('alamat-suggestions'),input=document.getElementById('alamat');
  if (!box.contains(e.target)&&e.target!==input) hideSuggestions();
});

function togglePass(inputId,iconId) {
  const input=document.getElementById(inputId),icon=document.getElementById(iconId);
  if(input.type==='password'){input.type='text';icon.className='bi bi-eye-slash';}
  else{input.type='password';icon.className='bi bi-eye';}
}

@if($errors->any() && old('alamat'))
  document.addEventListener('DOMContentLoaded',()=>goStep2());
@endif
</script>
</body>
</html>