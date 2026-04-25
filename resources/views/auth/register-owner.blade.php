<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Owner - KostFinder</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
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
    .register-side {
      position: relative; color: #fff;
      background: linear-gradient(180deg,rgba(8,20,34,.16) 0%,rgba(8,20,34,.58) 48%,rgba(8,20,34,.9) 100%),
        url('{{ asset("images/daftar.png") }}') center center / cover no-repeat;
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
    .register-main { background: var(--panel); padding: 40px 42px; overflow-y: auto; }
    .brand-link { display: inline-flex; align-items: center; gap: 10px; margin-bottom: 22px; color: var(--navy); text-decoration: none; font-weight: 800; letter-spacing: .06em; }
    .brand-link i { width: 40px; height: 40px; display: inline-flex; align-items: center; justify-content: center; border-radius: 14px; background: var(--accent-soft); color: var(--accent); font-size: 1.1rem; }
    .intro-copy h2 { margin: 0 0 8px; font-size: clamp(1.8rem,2.4vw,2.4rem); font-weight: 800; line-height: 1.12; }
    .intro-copy p  { margin: 0; color: var(--muted); max-width: 60ch; line-height: 1.7; }
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
    .step-panel { display: none; }
    .step-panel.active { display: block; animation: slideUp .3s ease; }
    @keyframes slideUp { from{opacity:0;transform:translateY(14px);}to{opacity:1;transform:translateY(0);} }
    .section-head { display: flex; justify-content: space-between; align-items: flex-start; gap: 16px; margin-bottom: 20px; padding-bottom: 14px; border-bottom: 1px solid var(--line); }
    .section-title    { margin: 0; font-size: 1rem; font-weight: 800; color: var(--navy); }
    .section-subtitle { margin: 4px 0 0; color: var(--muted); font-size: .88rem; line-height: 1.6; }
    .form-label { font-size: .78rem; font-weight: 800; letter-spacing: .09em; color: #374151; margin-bottom: 8px; }
    .input-group-text { background: var(--panel-soft); border: 1px solid var(--line); border-right: 0; color: #8a776d; border-radius: 16px 0 0 16px; padding: 0 16px; }
    .input-group-text.eye { border-left: 0; border-right: 1px solid var(--line); border-radius: 0 16px 16px 0; cursor: pointer; }
    .form-control { border: 1px solid var(--line); background: var(--panel-soft); min-height: 52px; border-radius: 16px; color: var(--ink); padding: 14px 16px; }
    .input-group > .form-control { border-left: 0; border-radius: 0 16px 16px 0; }
    .form-control:focus { box-shadow: 0 0 0 .22rem rgba(214,90,49,.12); border-color: rgba(214,90,49,.48); background: #fff; }
    .btn-lanjut { width: 100%; min-height: 54px; margin-top: 28px; border: 0; border-radius: 16px; background: linear-gradient(135deg,var(--accent) 0%,#e67b4b 100%); color: #fff; font-weight: 800; letter-spacing: .08em; font-size: .95rem; font-family: inherit; box-shadow: 0 16px 30px rgba(214,90,49,.24); display: flex; align-items: center; justify-content: center; gap: 10px; cursor: pointer; transition: transform .15s,box-shadow .15s; }
    .btn-lanjut:hover { transform: translateY(-1px); box-shadow: 0 20px 36px rgba(214,90,49,.3); }
    .btn-back-step { display: inline-flex; align-items: center; gap: 8px; background: none; border: 1px solid var(--line); border-radius: 12px; padding: 8px 16px; font-size: .84rem; font-weight: 700; color: var(--muted); cursor: pointer; margin-bottom: 20px; transition: background .15s,color .15s; font-family: inherit; }
    .btn-back-step:hover { background: var(--panel-soft); color: var(--ink); }
    .form-actions { display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap; padding-top: 6px; margin-top: 24px; }
    .helper-links { color: var(--muted); font-size: .88rem; line-height: 1.65; }
    .helper-links a { color: var(--accent); font-weight: 700; text-decoration: none; }
    .btn-daftar { min-width: 220px; min-height: 54px; border: 0; border-radius: 16px; background: linear-gradient(135deg,var(--accent) 0%,#e67b4b 100%); color: #fff; font-weight: 800; letter-spacing: .08em; box-shadow: 0 16px 30px rgba(214,90,49,.24); }
    .btn-daftar:hover { background: linear-gradient(135deg,var(--accent-dark) 0%,#d96838 100%); color: #fff; }
    .alert { border-radius: 18px; border: 0; margin-bottom: 18px; }
    .inline-error { display: none; margin-top: 14px; padding: 12px 16px; background: #fff2f2; border: 1px solid #fecaca; border-radius: 14px; font-size: .84rem; color: #b91c1c; }
    .tulis-sendiri-hint { font-size: .75rem; color: var(--muted); margin-top: 5px; display: none; }
    @media(max-width:1099px){.register-shell{grid-template-columns:1fr;}.register-side{min-height:260px;}}
    @media(max-width:767px){body{padding:14px;}.register-main{padding:22px 18px;}.side-content{padding:30px 22px 22px;}.side-copy{margin-top:0;max-width:100%;}.form-actions{display:flex;flex-direction:column;align-items:stretch;}.form-actions .btn-daftar{width:100%;margin-top:12px;}.btn-daftar{margin-top:12px;}}
    @media(max-width:575px){body{padding:0;}.register-side{order:1;min-height:130px;max-height:130px;flex-shrink:0;overflow:hidden;}.side-content{padding:16px 18px;}.side-copy h1,.side-copy p,.side-steps{display:none;}.register-main{order:2;flex:1;padding:20px 16px 32px;border-radius:24px 24px 0 0;margin-top:-20px;position:relative;z-index:2;background:#fff;}.btn-daftar{width:100%;}.btn-lanjut{font-size:.88rem;}}
  </style>
</head>
<body>
<div class="register-shell">

  <aside class="register-side">
    <div class="side-content">
      <div class="side-copy">
        <h1>Daftarkan Kost Anda dan Kelola Properti dengan Lebih Mudah</h1>
        <p>Bergabung dengan ribuan pemilik kost terpercaya.</p>
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
      </div>

      {{-- STEP 2 --}}
      <div class="step-panel" id="step-2">
        <button type="button" class="btn-back-step" onclick="goStep1()">
          <i class="bi bi-arrow-left"></i> Kembali ke Data Owner
        </button>
        <div class="section-head">
          <div>
            <h3 class="section-title">Alamat Properti</h3>
            <p class="section-subtitle">Isi alamat lengkap properti kost kamu.</p>
          </div>
        </div>
        <div class="row g-3">
          <div class="col-12">
            <label class="form-label">ALAMAT LENGKAP</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
              <input type="text" name="alamat" id="alamat" class="form-control" placeholder="Nama jalan, nomor, RT/RW..." value="{{ old('alamat') }}">
            </div>
          </div>

          <div class="col-md-6">
            <label class="form-label">KOTA / KABUPATEN</label>
            <select name="kota" id="kota" class="form-control" onchange="updateKecamatan()">
              <option value="">-- Pilih Kota --</option>
              <option value="Surabaya"   {{ old('kota')==='Surabaya'   ? 'selected':'' }}>Surabaya</option>
              <option value="Malang"     {{ old('kota')==='Malang'     ? 'selected':'' }}>Malang</option>
              <option value="Sidoarjo"   {{ old('kota')==='Sidoarjo'   ? 'selected':'' }}>Sidoarjo</option>
              <option value="Jember"     {{ old('kota')==='Jember'     ? 'selected':'' }}>Jember</option>
              <option value="Gresik"     {{ old('kota')==='Gresik'     ? 'selected':'' }}>Gresik</option>
              <option value="Kediri"     {{ old('kota')==='Kediri'     ? 'selected':'' }}>Kediri</option>
              <option value="Banyuwangi" {{ old('kota')==='Banyuwangi' ? 'selected':'' }}>Banyuwangi</option>
              <option value="Mojokerto"  {{ old('kota')==='Mojokerto'  ? 'selected':'' }}>Mojokerto</option>
              <option value="Pasuruan"   {{ old('kota')==='Pasuruan'   ? 'selected':'' }}>Pasuruan</option>
            </select>
          </div>

          <div class="col-md-6">
            <label class="form-label">PROVINSI</label>
            <input type="text" name="provinsi" id="provinsi" class="form-control" placeholder="Jawa Timur" value="{{ old('provinsi', 'Jawa Timur') }}" readonly>
          </div>

          {{-- KECAMATAN --}}
          <div class="col-md-4">
            <label class="form-label">KECAMATAN</label>
            <select id="kecamatan-select" class="form-control" onchange="updateKelurahan()">
              <option value="">-- Pilih Kota dulu --</option>
            </select>
            <input type="text" name="kecamatan" id="kecamatan-input" class="form-control mt-2"
              placeholder="Tulis kecamatan kamu..." style="display:none;" value="{{ old('kecamatan') }}">
            <div class="tulis-sendiri-hint" id="kec-hint">✏️ Ketik kecamatan kamu di atas</div>
          </div>

          {{-- KELURAHAN --}}
          <div class="col-md-4">
            <label class="form-label">KELURAHAN / DESA</label>
            <select id="kelurahan-select" class="form-control" onchange="autoKodePos()">
              <option value="">-- Pilih Kecamatan dulu --</option>
            </select>
            <input type="text" name="kelurahan" id="kelurahan-input" class="form-control mt-2"
              placeholder="Tulis kelurahan/desa kamu..." style="display:none;" value="{{ old('kelurahan') }}">
            <div class="tulis-sendiri-hint" id="kel-hint">✏️ Ketik kelurahan kamu di atas</div>
          </div>

          {{-- KODE POS --}}
          <div class="col-md-4">
            <label class="form-label">KODE POS</label>
            <input type="text" name="kode_pos" id="kode_pos" class="form-control"
              placeholder="Otomatis / isi manual" value="{{ old('kode_pos') }}">
          </div>

          <input type="hidden" name="latitude" value="0">
          <input type="hidden" name="longitude" value="0">
        </div>

        <div class="inline-error" id="step2-error"></div>
        <div class="form-actions mt-3">
          <button type="button" class="btn btn-daftar w-100" onclick="submitForm()">DAFTAR SEKARANG</button>
          <div class="helper-links mt-2">
            Sudah punya akun owner? <a href="{{ route('login', ['role'=>'owner']) }}">Masuk di sini</a>
          </div>
        </div>
      </div>
    </form>
  </main>
</div>

<script>
// =============================================
// DATA WILAYAH LENGKAP — 9 KOTA
// =============================================
const WILAYAH = {
  "Surabaya": {
    "Benowo":        {"Benowo":"60198","Kandangan":"60192","Karang Kliwang":"60191","Lontar":"60196","Pakal":"60197","Sememi":"60194","Tambak Dono":"60195","Babat Jerawat":"60193"},
    "Bubutan":       {"Alun-alun Contong":"60174","Bubutan":"60175","Gundih":"60172","Jepara":"60173","Tembok Dukuh":"60176"},
    "Bulak":         {"Bulak":"60124","Kenjeran":"60122","Kedung Cowek":"60123","Sukolilo Baru":"60125"},
    "Dukuh Pakis":   {"Dukuh Kupang":"60225","Dukuh Pakis":"60224","Gunung Sari":"60226","pradah Kali Kendal":"60227"},
    "Gayungan":      {"Dukuh Menanggal":"60234","Gayungan":"60235","Ketintang":"60231","Menanggal":"60232"},
    "Gebang Putih":  {"Gebang Putih":"60117","Keputih":"60111","Klampis Ngasem":"60117","Medokan Semampir":"60119","Menur Pumpungan":"60118","Semolowaru":"60119"},
    "Genteng":       {"Embong Kaliasin":"60271","Genteng":"60275","Kapasari":"60274","Ketabang":"60272","Peneleh":"60273"},
    "Gubeng":        {"Airlangga":"60286","Baratajaya":"60284","Gubeng":"60281","Kertajaya":"60282","Mojo":"60285","Pucangsewu":"60282"},
    "Gununganyar":   {"Gununganyar":"60294","Gununganyar Tambak":"60295","Rungkut Menanggal":"60293","Rungkut Tengah":"60293"},
    "Jambangan":     {"Jambangan":"60242","Karah":"60244","Kebonsari":"60233","Pagesangan":"60233"},
    "Karangpilang":  {"Gedangasin":"60222","Karangpilang":"60221","Kedurus":"60221","Wiyung":"60228"},
    "Kenjeran":      {"Bulak Banteng":"60127","Sidotopo Wetan":"60129","Tambak Wedi":"60125","Tanah Kali Kedinding":"60128"},
    "Krembangan":    {"Dupak":"60181","Kemayoran":"60182","Krembangan Selatan":"60177","Morokrembangan":"60178","Perak Barat":"60177"},
    "Lakarsantri":   {"Bangkingan":"60213","Jeruk":"60213","Lakarsantri":"60212","Lidah Kulon":"60213","Lidah Wetan":"60213","Sumur Welut":"60216"},
    "Mulyorejo":     {"Dukuh Sutorejo":"60113","Kalijudan":"60114","Kalisari":"60112","Kejawan Putih Tambak":"60112","Mulyorejo":"60115","Sutorejo":"60113"},
    "Pabean Cantian":{"Bongkaran":"60161","Kroman":"60111","Nyamplungan":"60162","Perak Timur":"60165","Perak Utara":"60164"},
    "Pakal":         {"Babat Jerawat":"60193","Benowo":"60198","Pakal":"60197","Sumber Rejo":"60198"},
    "Rungkut":       {"Kali Rungkut":"60292","Kedung Baruk":"60298","Medokan Ayu":"60295","Penjaringan Sari":"60291","Rungkut Kidul":"60293","Wonorejo":"60296"},
    "Sambikerep":    {"Bringin":"60217","Made":"60215","Sambikerep":"60216","Lontar":"60196"},
    "Sawahan":       {"Banyu Urip":"60251","Dukuh Kupang":"60225","Kupang Krajan":"60252","Pakis":"60256","Putat Gede":"60253","Sawahan":"60254"},
    "Semampir":      {"Ampel":"60151","Pegirian":"60152","Sidotopo":"60153","Ujung":"60155","Wonokusumo":"60154"},
    "Simokerto":     {"Kapasan":"60141","Sidodadi":"60141","Simokerto":"60141","Simolawang":"60144","Tambakrejo":"60142"},
    "Sukolilo":      {"Gebang Putih":"60117","Keputih":"60111","Klampis Ngasem":"60117","Medokan Semampir":"60119","Menur Pumpungan":"60118","Semolowaru":"60119"},
    "Sukomanunggal": {"Putat Gede":"60253","Simomulyo":"60281","Simomulyo Baru":"60281","Sukomanunggal":"60281","Tanjungsari":"60187"},
    "Tambaksari":    {"Gading":"60134","Kapas Madya Baru":"60136","Pacarkeling":"60131","Pacarkembang":"60131","Rangkah":"60133","Tambaksari":"60132"},
    "Tandes":        {"Balongsari":"60186","Karangpoh":"60186","Manukan Kulon":"60185","Manukan Wetan":"60184","Tandes":"60186"},
    "Tegalsari":     {"Keputran":"60265","Kedungdoro":"60253","Dr. Soetomo":"60264","Tegalsari":"60262","Wonorejo":"60243"},
    "Tenggilis Mejoyo":{"Kendangsari":"60292","Kutisari":"60291","Panjang Jiwo":"60299","Tenggilis Mejoyo":"60292"},
    "Wiyung":        {"Babatan":"60227","Balas Klumprik":"60222","Jajar Tunggal":"60228","Wiyung":"60228"},
    "Wonocolo":      {"Bendul Merisi":"60244","Jemurwonosari":"60237","Margorejo":"60238","Sidosermo":"60239","Siwalankerto":"60236"},
    "Wonokromo":     {"Darmo":"60241","Jagir":"60244","Ngagel":"60246","Ngagelrejo":"60245","Sawunggaling":"60242","Wonokromo":"60243"}
  },
  "Malang": {
    "Blimbing":      {"Arjosari":"60272","Balearjosari":"60274","Blimbing":"60471","Jodipan":"60271","Kesatrian":"60272","Pandanwangi":"60474","Polehan":"60272","Purwodadi":"60471","Wonokoyo":"60473"},
    "Kedungkandang": {"Arjowinangun":"60632","Bumiayu":"60633","Buring":"60634","Cemorokandang":"60635","Kedungkandang":"60636","Lesanpuro":"60637","Madyopuro":"60638","Mergosono":"60639","Sawojajar":"60471","Wonokoyo":"60473"},
    "Klojen":        {"Bareng":"60116","Gadingkasri":"60113","Kasin":"60119","Kauman":"60119","Kiduldalem":"60219","Klojen":"60219","Oro Oro Dowo":"60212","Penanggungan":"60217","Rampalcelaket":"60212","Samaan":"60212","Sukoharjo":"60117"},
    "Lowokwaru":     {"Dinoyo":"60144","Jatimulyo":"60141","Ketawanggede":"60145","Lowokwaru":"60141","Merjosari":"60144","Mojolangu":"60142","Sumbersari":"60145","Tlogomas":"60144","Tunggulwulung":"60143","Tunjungsekar":"60142"},
    "Sukun":         {"Bandungrejosari":"60148","Bandulan":"60146","Bakalankrajan":"60148","Ciptomulyo":"60148","Gadang":"60148","Karangbesuki":"60149","Kebonsari":"60148","Mulyorejo":"60147","Pisangcandi":"60146","Sukun":"60148","Tanjungrejo":"60146"}
  },
  "Sidoarjo": {
    "Balong Bendo":  {"Balong Bendo":"61274","Bakung Temenggungan":"61274","Bakung Pringgodani":"61274","Bogem Pinggir":"61274","Gabung":"61274","Jiyu":"61274","Kedung Cangkring":"61274","Masangan Kulon":"61274","Masangan Wetan":"61274","Pulosari":"61274","Wonokasian":"61274"},
    "Buduran":       {"Banjarkemantren":"61252","Buduran":"61252","Dukuhtengah":"61252","Entalsewu":"61252","Pagerwojo":"61252","Prasung":"61252","Sawohan":"61252","Sidokerto":"61252","Sidomulyo":"61252","Sukorejo":"61252","Wadungasih":"61252"},
    "Candi":         {"Balongdowo":"61271","Bligo":"61271","Bulu Sidokare":"61213","Candi":"61271","Gelam":"61271","Jambangan":"61271","Kalipecabean":"61271","Klurak":"61271","Larangan":"61271","Sugihwaras":"61271","Sepande":"61271","Sidodadi":"61271","Sumokali":"61271","Tenggulunan":"61271","Wedoroklurak":"61271"},
    "Gedangan":      {"Ganting":"61254","Gedangan":"61254","Gemurung":"61254","Karangbong":"61254","Ketajen":"61254","Kragan":"61254","Keboansikep":"61254","Sruni":"61254","Sawotratap":"61254","Tebel":"61254","Wedi":"61254"},
    "Jabon":         {"Dukuhsari":"61276","Garongan":"61276","Jabon":"61276","Keboguyang":"61276","Kedungrejo":"61276","Kupang":"61276","Lajuk":"61276","Mliriprowo":"61276","Permisan":"61276","Semambung":"61276","Tambak Kalisogo":"61276"},
    "Krembung":      {"Cangkring":"61275","Jenggot":"61275","Kandangan":"61275","Keper":"61275","Krembung":"61275","Lemujut":"61275","Mojoruntut":"61275","Ploso":"61275","Tambakrejo":"61275","Tanjeg Wagir":"61275","Waung":"61275"},
    "Krian":         {"Barengkrajan":"61262","Katerungan":"61262","Keboharan":"61262","Kemiri":"61262","Kraton":"61262","Krian":"61262","Nidomulyo":"61262","Ponokawan":"61262","Tempel":"61262","Terung Kulon":"61262","Terung Wetan":"61262","Tropodo":"61257","Watugolong":"61262"},
    "Porong":        {"Gedang":"61274","Juwetkenongo":"61274","Kebonagung":"61274","Kesambi":"61274","Lajuk":"61274","Mindi":"61274","Pamotan":"61274","Plumbon":"61274","Porong":"61274","Renokenongo":"61274","Siring":"61274","Wunut":"61274"},
    "Prambon":       {"Bulang":"61264","Candi Negoro":"61264","Gedangrowo":"61264","Gampang":"61264","Jedongcangkring":"61264","Jiworukem":"61264","Kajartengguli":"61264","Kedungwonokerto":"61264","Kemantren":"61264","Ngampelsari":"61264","Prambon":"61264","Simogirang":"61264","Temu":"61264","Watugolong":"61264"},
    "Sedati":        {"Betro":"61253","Buncitan":"61253","Cemandi":"61253","Gisik Cemandi":"61253","Kalanganyar":"61253","Pabean":"61253","Pepe":"61253","Pranti":"61253","Pulungan":"61253","Sedati Agung":"61253","Sedati Gede":"61253"},
    "Sidoarjo":      {"Bulusidokare":"61213","Celep":"61214","Gebang":"61215","Lemahputro":"61214","Magersari":"61213","Pekauman":"61215","Pucang":"61213","Sekardangan":"61214","Sidoarjo":"61213","Urangagung":"61215"},
    "Sukodono":      {"Anggaswangi":"61258","Bangsri":"61258","Kepatihan":"61258","Masangankulon":"61258","Pekarungan":"61258","Plumbungan":"61258","Sambungrejo":"61258","Suko":"61258","Sukodono":"61258","Suruh":"61258","Wilayut":"61258"},
    "Tarik":         {"Balongmacekan":"61265","Banjarwungu":"61265","Brand":"61265","Gampingrowo":"61265","Kemuning":"61265","Kendal":"61265","Klantingsari":"61265","Kramat Temenggung":"61265","Mergobener":"61265","Mindugading":"61265","Sebani":"61265","Segodobancang":"61265","Tarik":"61265","Tanjekwagir":"61265","Tramang Kliwon":"61265"},
    "Tanggulangin":  {"Ganggangpanjang":"61272","Kalitengah":"61272","Kalisampurno":"61272","Kedungbanteng":"61272","Kedungsolo":"61272","Ketapang":"61272","Ngaban":"61272","Putat":"61272","Randegan":"61272","Tanggulangin":"61272","Ketegan":"61272"},
    "Taman":         {"Bohar":"61257","Geluran":"61257","Jemundo":"61257","Kalijaten":"61257","Kedungturi":"61257","Kramat jegu":"61257","Ngelom":"61257","Pertapanmaduretno":"61257","Sepanjang":"61257","Taman":"61257","Trosobo":"61257","Wage":"61257"},
    "Tulangan":      {"Baharan":"61273","Bangunsupt":"61273","Grabagan":"61273","Janti":"61273","Kepadangan":"61273","Kepuharum":"61273","Medalem":"61273","Modong":"61273","Pangkemiri":"61273","Ploso":"61275","Sudimoro":"61273","Tulangan":"61273","Urangagung":"61273","Wonokarang":"61273"},
    "Waru":          {"Berbek":"61254","Bungurasih":"61257","Kepuh Kiriman":"61256","Kureksari":"61256","Medaeng":"61257","Ngingas":"61257","Pepelegi":"61257","Tambak Sawah":"61256","Tambak Sumur":"61256","Tropodo":"61257","Waru":"61256","Wedoro":"61255"},
    "Wonoayu":       {"Candinegoro":"61261","Cerme":"61261","Durak":"61261","Karangpuri":"61261","Ketimang":"61261","Lambangan Kulon":"61261","Lambangan Wetan":"61261","Mojorangagung":"61261","Mulyodadi":"61261","Pagerngumbuk":"61261","Plaosan":"61261","Semambung":"61261","Simoketawang":"61261","Tanggul":"61261","Wonoayu":"61261"}
  },
  "Jember": {
    "Ajung":         {"Ajung":"68175","Arjasa":"68175","Biting":"68175","Gambiran":"68175","Klungkung":"68175","Mangaran":"68175","Pancakarya":"68175","Sukamakmur":"68175"},
    "Ambulu":        {"Ambulu":"68172","Andongsari":"68172","Pontang":"68172","Sabrang":"68172","Sumberrejo":"68172","Tegalsari":"68172","Wirowongso":"68172"},
    "Arjasa":        {"Arjasa":"68191","Candijati":"68191","Kamal":"68191","Kemuning Lor":"68191","Kotakan":"68191","Langkap":"68191","Darsono":"68191"},
    "Balung":        {"Balung Kidul":"68161","Balung Lor":"68161","Gumelar":"68161","Karangsemanding":"68161","Taman Sari":"68161","Curah Kalong":"68161"},
    "Bangsalsari":   {"Bangsalsari":"68154","Banjarsari":"68154","Gambirono":"68154","Gunungsari":"68154","Karangbayat":"68154","Langkap":"68191","Sukorejo":"68154","Tisnogambar":"68154"},
    "Gumukmas":      {"Bagorejo":"68163","Gumukmas":"68163","Kepanjen":"68163","Kraton":"68163","Menampu":"68163","Purwoasri":"68163","Tembokrejo":"68163"},
    "Jenggawah":     {"Cangkring":"68171","Jenggawah":"68171","Kertonegoro":"68171","Mangaran":"68175","Sruni":"68171","Wonojati":"68171"},
    "Jombang":       {"Candimulyo":"68168","Dukuhdempok":"68168","Jombang":"68168","Kesilir":"68168","Mulyorejo":"68168","Sumberpakem":"68168"},
    "Kalisat":       {"Ajung":"68175","Glagahwero":"68192","Kalisat":"68192","Kranjingan":"68192","Semboro":"68192","Sukorejo":"68154","Sumberketempa":"68192","Gambiran":"68175"},
    "Kaliwates":     {"Gebang":"68137","Jember Kidul":"68131","Kaliwates":"68133","Kebon Agung":"68136","Mangli":"68136","Sempusari":"68135","Tegalbesar":"68134"},
    "Ledokombo":     {"Lembengan":"68195","Slateng":"68195","Sumberlesung":"68195","Sumbersalak":"68195","Sumberbulus":"68195"},
    "Mayang":        {"Mayang":"68184","Seputih":"68184","Sidomukti":"68184","Tegalrejo":"68184"},
    "Mumbulsari":    {"Lampeji":"68183","Mumbulsari":"68183","Suco":"68183","Tamansari":"68183","Wirowongso":"68183"},
    "Pakusari":      {"Bedadung":"68181","Kertosari":"68181","Pakusari":"68181","Subo":"68181","Sumberpandan":"68181"},
    "Panti":         {"Kemiri":"68153","Panti":"68153","Serut":"68153","Suci":"68153"},
    "Patrang":       {"Baratan":"68111","Bintoro":"68111","Gebang":"68117","Jember":"68111","Jumerto":"68117","Patrang":"68111","Slawu":"68116"},
    "Puger":         {"Mojomulyo":"68164","Puger Kulon":"68164","Puger Wetan":"68164","Grenden":"68164","Mojosari":"68164","Wonoasri":"68164"},
    "Rambipuji":     {"Curahmalang":"68152","Gugut":"68152","Pecoro":"68152","Rambipuji":"68152","Rowotamtu":"68152"},
    "Semboro":       {"Pondokrejo":"68157","Semboro":"68157","Sidomulyo":"68157","Sidomekar":"68157"},
    "Silo":          {"Harjomulyo":"68196","Karangharjo":"68196","Pace":"68196","Sempolan":"68196","Sidomulyo":"68196","Silo":"68196"},
    "Sukorambi":     {"Klungkung":"68175","Sukorambi":"68176","Karang Pring":"68176","Jubung":"68176"},
    "Sukowono":      {"Arjasa":"68191","Pocangan":"68194","Sukowono":"68194","Sumberwringin":"68194"},
    "Sumberbaru":    {"Jatiroto":"68156","Karang Bayat":"68156","Sumberbaru":"68156","Sumberagung":"68156"},
    "Sumberjambe":   {"Pringgondani":"68193","Slateng":"68195","Sumberjambe":"68193","Rowosari":"68193"},
    "Sumbersari":    {"Antirogo":"68123","Kebonsari":"68122","Kranjingan":"68124","Sumbersari":"68121","Tegal Gede":"68121","Wirolegi":"68125"},
    "Tanggul":       {"Klatakan":"68155","Patemon":"68155","Tanggul Kulon":"68155","Tanggul Wetan":"68155","Wonoasri":"68155"},
    "Tempurejo":     {"Andongrejo":"68173","Curahnongko":"68173","Pondokrejo":"68157","Sidodadi":"68173","Tempurejo":"68173"},
    "Umbulsari":     {"Bedadung":"68181","Gunungsari":"68154","Umbulsari":"68165","Gadingrejo":"68165","Paleran":"68165"},
    "Wuluhan":       {"Dukuhdempok":"68168","Glundengan":"68162","Kesilir":"68168","Lojejer":"68162","Tanjungrejo":"68162","Wuluhan":"68162"}
  },
  "Gresik": {
    "Bungah":        {"Bedanten":"61152","Bungah":"61152","Indrodelik":"61152","Kemangi":"61152","Kisik":"61152","Kramat":"61152","Masangan":"61152","Mojopuro Gede":"61152","Mojopuro Wetan":"61152","Sidokumpul":"61119","Sukorejo":"61152","Sungonlegowo":"61152","Tanjungwidoro":"61152"},
    "Cerme":         {"Banjarsari":"61171","Cerme Kidul":"61171","Cerme Lor":"61171","Dadap Kuning":"61171","Dampaan":"61171","Dooro":"61171","Dungus":"61171","Gedangkulut":"61171","Guranganyar":"61171","Iker-iker Geger":"61171","Jono":"61171","Kandangan":"61171","Ngabetan":"61171","Pandu":"61171","Tambakberas":"61171","Wedani":"61171"},
    "Driyorejo":     {"Cangkir":"61177","Driyorejo":"61177","Karangandong":"61177","Kesamben Kulon":"61177","Kesamben Wetan":"61177","Krikilan":"61177","Mojosarirejo":"61177","Mulung":"61177","Petiken":"61177","Randegansari":"61177","Sumput":"61177","Tanjung":"61177","Terate":"61177","Tenaru":"61177"},
    "Duduksampeyan": {"Ambeng-ambeng Watangrejo":"61162","Bendungan":"61162","Brayublandong":"61162","Glindah":"61162","Gunungan":"61162","Kandangan":"61171","Kemudi":"61162","Kertosono":"61162","Palebon":"61162","Panjangbaru":"61162","Sembung":"61151","Sumari":"61162","Tirem":"61162"},
    "Gresik":        {"Bedilan":"61116","Gresik":"61118","Kebungson":"61117","Kemuteran":"61114","Kroman":"61111","Lumpur":"61115","Ngipik":"61116","Pekauman":"61116","Pekelingan":"61116","Sidokumpul":"61119","Sukodono":"61258","Tlogopojok":"61112"},
    "Kebomas":       {"Gending":"61124","Gulomantung":"61122","Industri":"61123","Indro":"61122","Kembangan":"61121","Kebomas":"61123","Ngargosari":"61123","Prambangan":"61124","Sidomoro":"61123","Singosari":"61123","Tenggulunan":"61121","Randuagung":"61124"},
    "Kedamean":      {"Beton":"61175","Cermen":"61175","Glindah":"61162","Karangsemanding":"61175","Kedamean":"61175","Lampah":"61175","Mojodadi":"61175","Ngepung":"61175","Slempit":"61175","Turirejo":"61175"},
    "Manyar":        {"Banyuwangi":"61151","Betoyoguci":"61151","Betoyokauman":"61151","Gumeno":"61151","Leran":"61151","Manyar Sidomukti":"61151","Manyar Sidorukun":"61151","Roomo":"61151","Sembung":"61151","Suci":"61151","Sukomulyo":"61152","Sukorejo":"61151","Tanggulrejo":"61151"},
    "Menganti":      {"Beton":"61175","Boboh":"61174","Boteng":"61174","Bringkang":"61174","Domas":"61174","Drancang":"61174","Gadingkulon":"61174","Kepatihan":"61258","Laban":"61174","Menganti":"61174","Mojotengah":"61174","Putatlor":"61174","Randupadangan":"61174","Sidojangkung":"61174","Sidorukun":"61174","Simongagrok":"61174","Slempit":"61175","Setro":"61174"},
    "Panceng":       {"Banyutengah":"61156","Campurejo":"61156","Dalegan":"61156","Doudo":"61156","Gedangan":"61254","Ketanen":"61156","Kramat":"61152","Ngemboh":"61156","Panceng":"61156","Petung":"61156","Serah":"61156","Siwalan":"61156"},
    "Sangkapura":    {"Dekatagung":"61181","Grejeg":"61181","Kepuh Teluk":"61181","Kotakusuma":"61181","Kumalasa":"61181","Lebak":"61181","Sawahmulya":"61181","Sangkapura":"61181","Sidogedungbatu":"61181","Tajung":"61181","Tanjungoriik":"61181"},
    "Sidayu":        {"Asempapak":"61153","Bunderan":"61153","Gedangan":"61254","Golokan":"61153","Kauman":"61153","Lasem":"61153","Mojoasem":"61153","Pengulu":"61153","Purwodadi":"61153","Raci Kulon":"61153","Raci Wetan":"61153","Randuboto":"61153","Sambipondok":"61153","Sedagaran":"61153","Sidayu":"61153","Srowo":"61153","Sukorejo":"61153","Tiremenggal":"61153"},
    "Tambak":        {"Diponggo":"61182","Gunungteguh":"61182","Kepuhlegundi":"61182","Kepuhtinggal":"61182","Paromaan":"61182","Sukaoneng":"61182","Sukalela":"61182","Tambak":"61182","Tanjungan":"61182"},
    "Ujungpangkah":  {"Banyuurip":"61154","Glatik":"61154","Gosari":"61154","Karangrejo":"61154","Kebonagung":"61154","Pangkahkulon":"61154","Pangkahwetan":"61154","Sekapuk":"61154","Sidokumpul":"61154","Tanjangawan":"61154","Ujungpangkah":"61154"},
    "Wringinanom":   {"Bambe":"61176","Dunggede":"61176","Kesamben Kulon":"61177","Lebaniwaras":"61176","Mondoluku":"61176","Pasinan Lemahputih":"61176","Sembung":"61151","Soko":"61176","Sumengko":"61176","Watesari":"61176","Wringinanom":"61176"}
  },
  "Kediri": {
    "Badas":         {"Badas":"64215","Blaru":"64215","Cengkok":"64215","Gampeng":"64215","Kawedusan":"64215","Krecek":"64215","Nanggungan":"64215","Pelas":"64215","Purwodadi":"64215","Semen":"64215","Sumberejo":"64215","Sumber Rejo":"64215","Sumbersono":"64215"},
    "Banyakan":      {"Banyakan":"64182","Blungkang":"64182","Jabon":"64182","Kayen Kidul":"64182","Lembu":"64182","Maron":"64182","Mlancu":"64182","Ngadi":"64182","Semen":"64182"},
    "Gampengrejo":   {"Gampengrejo":"64182","Pondok":"64182","Sukorame":"64182","Turus":"64182"},
    "Grogol":        {"Cerme":"64183","Gambyok":"64183","Gogorante":"64183","Grogol":"64183","Janti":"64183","Kalipang":"64183","Kambingan":"64183","Kandat":"64183","Manggis":"64183","Parang":"64183","Sumberduren":"64183","Sumberejo":"64183","Wonocatur":"64183"},
    "Gurah":         {"Bogem":"64181","Brumbung":"64181","Bulupasar":"64181","Gayam":"64181","Gedangsewu":"64181","Gurah":"64181","Kerkep":"64181","Nambaan":"64181","Papar":"64181","Puhkidul":"64181","Semen":"64181","Tiron":"64181","Tiru Lor":"64181"},
    "Kandat":        {"Blimbing":"64184","Kandat":"64184","Kencong":"64184","Kranggahan":"64184","Nanggungan":"64215","Ngletih":"64184","Sumberasri":"64184","Tiru Kidul":"64184"},
    "Kayen Kidul":   {"Banyuanyar":"64185","Canggu":"64185","Kayen Kidul":"64185","Ngebrak":"64185","Puhsarang":"64185","Seketi":"64185","Sidomulyo":"64185","Sukoharjo":"64185"},
    "Kepung":        {"Besowo":"64292","Damarwulan":"64292","Gadungan":"64292","Kencong":"64292","Kepung":"64292","Krenceng":"64292","Keling":"64292","Puncu":"64292","Sumberagung":"64292"},
    "Kota Kediri - Klojen":{"Balowerti":"64121","Dandangan":"64125","Kemasan":"64126","Ngadirejo":"64127","Pocanan":"64121","Ringinanom":"64124","Setonopande":"64128","Setono Gedong":"64129","Tinalan":"64129"},
    "Kota Kediri - Mojoroto":{"Banaran":"64115","Banjaran":"64117","Betet":"64118","Campurejo":"64118","Dermo":"64119","Gayam":"64112","Lirboyo":"64114","Mojoroto":"64114","Ngampel":"64115","Pojok":"64112","Semampir":"64116","Sukorame":"64182"},
    "Kota Kediri - Pesantren":{"Bangsal":"64134","Bawang":"64136","Blabak":"64135","Burengan":"64133","Ketami":"64138","Pesantren":"64133","Singonegaran":"64139","Tosaren":"64139"},
    "Mojo":          {"Brenggolo":"64292","Duwet":"64292","Jugo":"64292","Kraton":"64292","Miri":"64292","Mojo":"64292","Petok":"64292","Ploso":"64275","Semen":"64292","Sumberagung":"64292"},
    "Ngasem":        {"Bedug":"64182","Joho":"64182","Kunjang":"64291","Kwaron":"64291","Nanggungan":"64215","Ngasem":"64182","Plosokidul":"64291","Semen":"64182"},
    "Papar":         {"Bangle":"64291","Catur":"64291","Gedongombo":"64291","Janti":"64291","Papar":"64291","Plosokidul":"64291","Srikaton":"64291","Sumberejo":"64291","Tanon":"64291"},
    "Pare":          {"Gedangsewu":"64211","Bendo":"64211","Damarwulan":"64292","Kunjang":"64291","Pare":"64211","Pelem":"64211","Sidorejo":"64211","Sumberbendo":"64211","Tulungrejo":"64211"},
    "Plemahan":      {"Bogokidul":"64213","Mejono":"64213","Ngreco":"64213","Pagu":"64213","Pikatan":"64213","Plemahan":"64213","Srikaton":"64291","Sukorejo":"64213"},
    "Plosoklaten":   {"Jagul":"64214","Plosoklaten":"64214","Ploso":"64275","Sepawon":"64214","Sugihwaras":"64214"},
    "Puncu":         {"Asmorobangun":"64292","Besowo":"64292","Gadungan":"64292","Kepung":"64292","Puncu":"64292","Sumberagung":"64292"},
    "Purwoasri":     {"Cerme":"64183","Purwoasri":"64216","Sumberejo":"64216","Wonorejo":"64216"},
    "Ringinrejo":    {"Bogo":"64217","Karangtengah":"64217","Purwodadi":"64217","Ringinrejo":"64217","Wonodadi":"64217"},
    "Semen":         {"Joho":"64182","Nambaan":"64181","Ngadi":"64182","Semen":"64182","Tiron":"64181"},
    "Tarokan":       {"Cengkok":"64215","Keling":"64292","Sendang":"64218","Tarokan":"64218"}
  },
  "Banyuwangi": {
    "Bangorejo":     {"Bangorejo":"68487","Kebondalem":"68487","Ringintelu":"68487","Sambirejo":"68487","Sukorejo":"68487","Temurejo":"68487"},
    "Banyuwangi":    {"Kampung Melayu":"68411","Kepatihan":"68411","Kertosari":"68416","Pakis":"68414","Penganjuran":"68416","Singonegaran":"68414","Sobo":"68416","Tamanbaru":"68416","Temenggungan":"68416","Tukangkayu":"68417"},
    "Blimbingsari":  {"Blimbingsari":"68466","Karangrejo":"68466","Kaotan":"68466","Sukojati":"68466","Watukebo":"68466"},
    "Bungatan":      {"Bungatan":"68452","Ketapang":"68452","Sumberbaru":"68452","Sumberanyar":"68452"},
    "Cluring":       {"Benculuk":"68482","Cluring":"68482","Gambor":"68482","Sembulung":"68482","Sraten":"68482","Tegalsari":"68482","Tulungrejo":"68482"},
    "Glagah":        {"Bakungan":"68421","Glagah":"68421","Kemiren kemiren":"68421","Olehsari":"68421","Paspan":"68421","Rejosari":"68421","Taman Suruh":"68421","Tamansuruh":"68421","Benelan Lor":"68421"},
    "Gambiran":      {"Gambiran":"68486","Jajag":"68486","Purwoharjo":"68486","Purwodadi":"68486","Wringinagung":"68486"},
    "Genteng":       {"Genteng Kulon":"68465","Genteng Wetan":"68465","Karangbendo":"68465","Kembiritan":"68465","Setail":"68465"},
    "Giri":          {"Boyolangu":"68422","Giri":"68422","Jambesari":"68422","Penataban":"68422"},
    "Glagah":        {"Bakungan":"68421","Glagah":"68421","Kemiren":"68421","Olehsari":"68421","Paspan":"68421","Rejosari":"68421","Taman Suruh":"68421"},
    "Kabat":         {"Badean":"68461","Benelan Kidul":"68461","Bunder":"68461","Gombolirang":"68461","Kabat":"68461","Kalirejo":"68461","Labanasem":"68461","Macan Putih":"68461","Pakistaji":"68461","Pendarungan":"68461","Sukojati":"68466","Tambong":"68461","Pondoknongko":"68461"},
    "Kalibaru":      {"Banyuanyar":"68468","Kalibaru Kulon":"68468","Kalibaru Manis":"68468","Kalibarukulon":"68468","Kebonrejo":"68468","SelowongAgung":"68468"},
    "Kalipuro":      {"Bulusan":"68413","Gombengsari":"68413","Kelir":"68413","Ketapang":"68452","Liprak Kulon":"68413","Liprak Wetan":"68413","Pesucen":"68413","Telemung":"68413"},
    "Licin":         {"Gumuk":"68418","Jelun":"68418","Kampunganyar":"68418","Kedayunan":"68418","Licin":"68418","Pakel":"68418","Segobang":"68418"},
    "Muncar":        {"Blambangan":"68472","Kedungrejo":"68472","Kumendung":"68472","Muncar":"68472","Sumberberas":"68472","Tambakrejo":"68472","Tembokrejo":"68472"},
    "Pesanggaran":   {"Bulurejo":"68488","Pesanggaran":"68488","Sarongan":"68488","Sumberagung":"68488"},
    "Purwoharjo":    {"Glagahagung":"68483","Karetan":"68483","Kradenan":"68483","Purwoharjo":"68483","Sidorejo":"68483","Sumberasri":"68483","Wringinpitu":"68483"},
    "Rogojampi":     {"Karangbendo":"68462","Lemahbang Kulon":"68462","Patoman":"68462","Pendarungan":"68462","Rogojampi":"68462","RogoJampi":"68462"},
    "Sempu":         {"Jambewangi":"68467","Sempu":"68467","Tegalharjo":"68467","Temuasri":"68467"},
    "Singojuruh":    {"Benelan Lor":"68421","Gambiran":"68486","Lemah Bang":"68463","Singojuruh":"68463","Singolatren":"68463","Sumber Bulu":"68463","Wongsorejo":"68463"},
    "Siliragung":    {"Barurejo":"68489","Bulusari":"68489","Seneporejo":"68489","Siliragung":"68489"},
    "Songgon":       {"Bedewang":"68464","Cantuk":"68464","Kenjo":"68464","Krikilan":"68464","Parang Harjo":"68464","Sumberberas":"68472","Singolatren":"68463","Songgon":"68464"},
    "Srono":         {"Bagorejo":"68471","Kebaman":"68471","Parijatah Kulon":"68471","Parijatah Wetan":"68471","Rejoagung":"68471","Sambimulyo":"68471","Sumbersewu":"68471","Srono":"68471"},
    "Tegaldlimo":    {"Kendalrejo":"68484","Kedunggebang":"68484","Kedungrejo":"68484","Purwoagung":"68484","Tegaldlimo":"68484","Wringinputih":"68484"},
    "Tegalsari":     {"Kedungasri":"68485","Kedungsari":"68485","Tamansari":"68485","Tegalsari":"68485","Yosomulyo":"68485"},
    "Wongsorejo":    {"Alasmalang":"68453","Bajulmati":"68453","Bimorejo":"68453","Bondowoso":"68453","Sidodadi":"68453","Sidowangi":"68453","Sumberanyar":"68453","Umpel Mantung":"68453","Wongsorejo":"68453"}
  },
  "Mojokerto": {
    "Bangsal":       {"Bangsal":"61382","Brangkal":"61382","Gedangan":"61382","Jatidukuh":"61382","Japanan":"61382","Karangdiyeng":"61382","Kedungmaling":"61382","Puloniti":"61382","Sumbertebu":"61382"},
    "Dawar Blandong":{"Bandung":"61383","Canggu":"61385","Dawar Blandong":"61383","Gebang":"61383","Grujugan":"61383","Karangjeruk":"61383","Kebonagung":"61383","Randegan":"61383","Simongagrok":"61383","Suru":"61383"},
    "Gedeg":         {"Domas":"61351","Gedeg":"61351","Gembongan":"61351","Gewang":"61351","Gunungan":"61351","Karangpoh":"61351","Kemantren":"61351","Mojoroto":"61351","Nguwok":"61351","Pagerluyung":"61351","Perning":"61351","Sidorejo":"61351","Sumberwono":"61351"},
    "Gondang":       {"Centong":"61372","Dilem":"61372","Gondang":"61372","Jrambe":"61372","Kalikatir":"61372","Ketapanrame":"61372","Klitih":"61372","Kwadengan":"61372","Pohjejer":"61372","Pulorejo":"61321","Segunung":"61372","Srowo":"61153"},
    "Jetis":         {"Banjar Asri":"61352","Banjar Kemantren":"61352","Canggu":"61385","Jatipasar":"61352","Jetis":"61352","Karang Kuten":"61352","Lakardowo":"61352","Mojogebang":"61352","Ngabar":"61352","Penanggungan":"61352","Plososari":"61352","Sukodono":"61352","Sumberwono":"61351"},
    "Jatirejo":      {"Bleberan":"61371","Duyung":"61371","Jatirejo":"61371","Karangkuten":"61352","Kesemek":"61371","Lebak Jabung":"61371","Ngareski":"61371","Nogosari":"61371","Pataan":"61371","Petak":"61371","Sumengko":"61371","Terusan":"61371"},
    "Kemlagi":       {"Balongsari":"61186","Kemlagi":"61353","Kemlagilor":"61353","Kedungsumur":"61353","Leminggir":"61353","Mojodadi":"61353","Mojokumpul":"61353","Mojorejo":"61353","Pekukuhan":"61353","Puri":"61354","Sumbersekar":"61353","Warugunung":"61353"},
    "Kutorejo":      {"Baureno":"61384","Gedeg":"61351","Kalipang":"61384","Kutorejo":"61384","Lebakjabung":"61384","Ngingasrembyong":"61384","Pohjejer":"61372","Sawo Tratap":"61254","Simongagrok":"61383","Tempuran":"61384"},
    "Magersari":     {"Balongsari":"61313","Gedongan":"61314","Gunung Gedangan":"61315","Jagalan":"61315","Kauman":"61312","Magersari":"61314","Miji":"61312","Sentanan":"61314"},
    "Mojoanyar":     {"Banjaragung":"61385","Canggu":"61385","Kedungmaling":"61382","Mojoanyar":"61385","Mojokumpul":"61353","Ngingasrembyong":"61384","Ngaresrejo":"61385","Penanggungan":"61352","Randegan":"61383","Sumber Agung":"61385"},
    "Mojosari":      {"Awang Awang":"61382","Beloh":"61382","Menanggal":"61382","Modopuro":"61381","Mojosari":"61381","Ngimbangan":"61381","Randegan":"61383","Sumber Taman":"61381","Sumbertanggul":"61381"},
    "Pacet":         {"Candiwatu":"61374","Claket":"61374","Kemiri":"61374","Mojokembang":"61374","Pacet":"61374","Padusan":"61374","Petak":"61371","Sajen":"61374","Seloliman":"61374","Tanjungkenongo":"61374"},
    "Puri":          {"Balongmojo":"61354","Brangkal":"61354","Jrambe":"61372","Kauman":"61354","Kemasantani":"61354","Kembangsri":"61354","Kenanten":"61354","Puri":"61354","Sekargadung":"61354","Sumbertanggul":"61381","Tambakagung":"61354","Tambakrejo":"61354"},
    "Prajurit Kulon":{"Blooto":"61321","Jagalan":"61315","Kedundung":"61323","Kranggan":"61322","Mentikan":"61321","Meri":"61322","Prajurit Kulon":"61321","Pulorejo":"61321","Surodinawan":"61322"},
    "Pungging":      {"Balongmasin":"61384","Jabontegal":"61384","Mojorejo":"61365","Mulyoagung":"61384","Ngrame":"61384","Pungging":"61384","Randuharjo":"61384","Sekargadung":"61354","Tunggalpager":"61384","Watukenongo":"61384"},
    "Sooko":         {"Gemekan":"61361","Jambuwok":"61361","Karangkedawang":"61361","Sambiroto":"61361","Sooko":"61361","Sumbertanggul":"61381","Tempuran":"61384","Wringinanom":"61176"},
    "Trawas":        {"Belik":"61375","Duyung":"61375","Duyung-Trawas":"61375","Gumeng":"61375","Ketapanrame":"61375","Ngembat":"61375","Penanggungan":"61375","Seloliman":"61374","Sugeng":"61375","Tamiajeng":"61375","Trawas":"61375"},
    "Trowulan":      {"Bejijong":"61362","Beloh":"61382","Bicak":"61362","Brangkal":"61382","Domas":"61351","Gunungan":"61351","Jambuwok":"61361","Kejagan":"61362","Klinterejo":"61362","Kumitir":"61362","Ngarjo":"61362","Panggih":"61362","Sentonorejo":"61362","Trowulan":"61362","Watesumpak":"61362"},
    "Wonodadi":      {"Canggu":"61385","Mojoanyar":"61385","Ngabar":"61352","Pulorejo":"61321","Terusan":"61371","Wonodadi":"61217"}
  },
  "Pasuruan": {
    "Bangil":        {"Masangan":"67153","Dermo":"67153","Kauman":"67153","Kalianyar":"67153","Kolursari":"67153","Manaruwi":"67153","Pogar":"67153","Raci":"67153","Latek":"67153","Bendomungal":"67153","Tambaan":"67153","Gempeng":"67153"},
    "Beji":          {"Beji":"67154","Carat":"67154","Cangkringmalang":"67154","Glagahsari":"67154","Kedungringin":"67154","Ngempit":"67154","Pagak":"67154","Pleret":"67154","Tambakrejo":"67154"},
    "Bugul Kidul":   {"Blandongan":"67122","Bugul Kidul":"67121","Kepel":"67122","Krampyangan":"67121","Tembokrejo":"67122"},
    "Gading Rejo":   {"Gading Rejo":"67154","Karanganyar":"67154","Kenduruan":"67154","Ngerong":"67154","Semut":"67154","Suwayuwo":"67154","Wonorejo":"67154"},
    "Gadingrejo":    {"Gadingrejo":"67115","Gentong":"67115","Kebonsari":"67116","Petahunan":"67115","Randusari":"67115"},
    "Gondang Wetan": {"Duren":"67162","Gondangwetan":"67162","Kalianyar":"67162","Kepulungan":"67162","Kluwut":"67162","Lemahbang":"67162","Pandean":"67162","Pateguhan":"67162","Sumberrejo":"67162","Wonoasri":"67162"},
    "Grati":         {"Grati Tunon":"67184","Gratitunon":"67184","Kalipang":"67184","Kedawung Kulon":"67184","Kedawung Wetan":"67184","Klaseman":"67184","Kramat Jegu":"67257","Raci":"67184","Rebalas":"67184","Segoropuro":"67184","Sumberdawesari":"67184"},
    "Kejayan":       {"Gerongan":"67171","Kalianyar":"67171","Kejayan":"67171","Klepu":"67171","Pulokerto":"67171","Sumberrejo":"67171","Umbrean":"67171","Wonorejo":"67171"},
    "Kraton":        {"Kraton":"67151","Ngempit":"67154","Ranggeh":"67151","Rejoso":"67151","Semare":"67151","Tambaagung":"67151"},
    "Lekok":         {"Jatirejo":"67181","Jatirejo Wetan":"67181","Kepulungan":"67181","Lekok":"67181","Wates":"67181","Wonomerto":"67181"},
    "Lumbang":       {"Bodang":"67163","Karangjati":"67163","Karangsono":"67163","Kemiri":"67163","Lumbang":"67163","Pakel":"67163","Sumberkembar":"67163","Watugede":"67163"},
    "Nguling":       {"Kapasan":"67182","Kedawung Kulon":"67182","Kedawung Wetan":"67182","Nguling":"67182","Penunggul":"67182","Randuati":"67182","Semedusari":"67182","Sumberanyar":"67182"},
    "Pandaan":       {"Durensewu":"67156","Jogosari":"67156","Karangjati":"67156","Petungasri":"67156","Pandaan":"67156","Pecalukan":"67156","Tawangrejo":"67156","Wedoro":"67156"},
    "Pasrepan":      {"Dawuhan":"67173","Karangsono":"67173","Kedawung":"67173","Pasrepan":"67173","Ploso":"67173","Sidogiri":"67173"},
    "Pohjentrek":    {"Karangketug":"67116","Pohjentrek":"67118","Sekargadung":"67117","Tambaan":"67153"},
    "Prigen":        {"Gambiran":"67157","Jatiarjo":"67157","Ledug":"67157","Lumbangrejo":"67157","Nogosari":"67157","Prigen":"67157","Sukorejo":"67157","Wonodadi":"67157"},
    "Purwodadi":     {"Gerbo":"67172","Pohgading":"67172","Purwodadi":"67172","Sengonagung":"67172","Tambaksari":"67172"},
    "Purworejo":     {"Bangilan":"67119","Bugul Lor":"67117","Karangketug":"67116","Pohjentrek":"67118","Purworejo":"67118","Sekargadung":"67117"},
    "Rejoso":        {"Arjosari":"67174","Kalipang":"67174","Kemiri":"67174","Rejoso":"67174","Sebalong":"67174","Sumber Suko":"67174"},
    "Rembang":       {"Curahdami":"67175","Kedawung":"67175","Klakah Rejo":"67175","Rembang":"67175","Sumber Bendo":"67175","Tunggul Wulung":"67175"},
    "Sukorejo":      {"Gunung Gangsir":"67155","Lemah ireng":"67155","Petungasri":"67155","Sukorejo":"67155","Wonorejo":"67155"},
    "Tosari":        {"Baledono":"67177","Kandangan":"67177","Keduwung":"67177","Mororejo":"67177","Podokoyo":"67177","Tosari":"67177","Wonokitri":"67177"},
    "Tutur":         {"Andonosari":"67176","Kalipang":"67176","Nongkojajar":"67176","Pungging":"67176","Tutur":"67176","Wonosari":"67176"},
    "Umbulan":       {"Gading Rejo":"67154","Umbulan":"67153","Winongan Kidul":"67153","Winongan Lor":"67153"},
    "Winongan":      {"Bandaran":"67161","Banyubang":"67161","Dawarblandong":"67161","Kedawung Wetan":"67161","Nguling":"67182","Winongan Kidul":"67161","Winongan Lor":"67161"}
  }
};

// =============================================
// FUNGSI DROPDOWN DINAMIS
// =============================================
function updateKecamatan() {
  const kota   = document.getElementById('kota').value;
  const kecSel = document.getElementById('kecamatan-select');
  const kecInp = document.getElementById('kecamatan-input');
  const kelSel = document.getElementById('kelurahan-select');
  const kelInp = document.getElementById('kelurahan-input');
  const kecHint= document.getElementById('kec-hint');
  const kelHint= document.getElementById('kel-hint');

  kecSel.innerHTML = '<option value="">-- Pilih Kecamatan --</option>';
  kelSel.innerHTML = '<option value="">-- Pilih Kelurahan --</option>';
  kecInp.style.display = 'none'; kecInp.value = '';
  kelInp.style.display = 'none'; kelInp.value = '';
  kecHint.style.display = 'none';
  kelHint.style.display = 'none';
  document.getElementById('kode_pos').value = '';

  if (!kota || !WILAYAH[kota]) return;

  Object.keys(WILAYAH[kota]).sort().forEach(kec => {
    const o = document.createElement('option');
    o.value = kec; o.textContent = kec;
    kecSel.appendChild(o);
  });
  const oLain = document.createElement('option');
  oLain.value = '__lainnya__';
  oLain.textContent = '✏️ Tidak ada? Tulis sendiri...';
  kecSel.appendChild(oLain);
}

function updateKelurahan() {
  const kota   = document.getElementById('kota').value;
  const kecSel = document.getElementById('kecamatan-select');
  const kecInp = document.getElementById('kecamatan-input');
  const kelSel = document.getElementById('kelurahan-select');
  const kelInp = document.getElementById('kelurahan-input');
  const kecHint= document.getElementById('kec-hint');
  const kelHint= document.getElementById('kel-hint');

  kelSel.innerHTML = '<option value="">-- Pilih Kelurahan --</option>';
  kelInp.style.display = 'none'; kelInp.value = '';
  kelHint.style.display = 'none';
  document.getElementById('kode_pos').value = '';

  if (kecSel.value === '__lainnya__') {
    kecInp.style.display = 'block';
    kecHint.style.display = 'block';
    kelInp.style.display = 'block';
    kelHint.style.display = 'block';
    kelSel.style.display = 'none';
    return;
  }

  kecInp.style.display = 'none';
  kecHint.style.display = 'none';
  kelSel.style.display = 'block';

  const kec = kecSel.value;
  if (!kota || !kec || !WILAYAH[kota][kec]) return;

  Object.entries(WILAYAH[kota][kec]).sort().forEach(([kel, kp]) => {
    const o = document.createElement('option');
    o.value = kel; o.dataset.kp = kp; o.textContent = kel;
    kelSel.appendChild(o);
  });
  const oLain = document.createElement('option');
  oLain.value = '__lainnya__';
  oLain.textContent = '✏️ Tidak ada? Tulis sendiri...';
  kelSel.appendChild(oLain);
}

function autoKodePos() {
  const kelSel = document.getElementById('kelurahan-select');
  const kelInp = document.getElementById('kelurahan-input');
  const kelHint= document.getElementById('kel-hint');

  if (kelSel.value === '__lainnya__') {
    kelInp.style.display = 'block';
    kelHint.style.display = 'block';
    document.getElementById('kode_pos').value = '';
    return;
  }
  kelInp.style.display = 'none';
  kelHint.style.display = 'none';
  const sel = kelSel.options[kelSel.selectedIndex];
  document.getElementById('kode_pos').value = (sel && sel.dataset.kp) ? sel.dataset.kp : '';
}

// =============================================
// FUNGSI FORM NAVIGATION
// =============================================
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
  const kota   = document.getElementById('kota').value;
  const kecSel = document.getElementById('kecamatan-select');
  const kecInp = document.getElementById('kecamatan-input');
  const kelSel = document.getElementById('kelurahan-select');
  const kelInp = document.getElementById('kelurahan-input');
  const errEl  = document.getElementById('step2-error');

  const kecVal = kecSel.value === '__lainnya__' ? kecInp.value.trim() : kecSel.value;
  const kelVal = kelSel.value === '__lainnya__' ? kelInp.value.trim() : (kelSel.style.display === 'none' ? kelInp.value.trim() : kelSel.value);

  if (!alamat)  { showErr(errEl,'Alamat lengkap harus diisi.'); return; }
  if (!kota)    { showErr(errEl,'Kota harus dipilih.'); return; }
  if (!kecVal)  { showErr(errEl,'Kecamatan harus diisi.'); return; }
  if (!kelVal)  { showErr(errEl,'Kelurahan/Desa harus diisi.'); return; }

  // Pastikan hidden input kecamatan & kelurahan terisi sebelum submit
  if (kecSel.value !== '__lainnya__') {
    document.getElementById('kecamatan-input').value = kecSel.value;
    document.getElementById('kecamatan-input').style.display = 'block';
  }
  if (kelSel.value !== '__lainnya__' && kelSel.style.display !== 'none') {
    document.getElementById('kelurahan-input').value = kelSel.value;
    document.getElementById('kelurahan-input').style.display = 'block';
  }

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
    n2.className='prog-num idle';n2.textContent='2';l2.className='prog-label idle';
    fill.style.width='0%';
    sd1.className='side-step-dot active';sd1.textContent='1';sl1.className='side-step-label';
    sd2.className='side-step-dot idle';sd2.textContent='2';sl2.className='side-step-label idle';
  } else {
    n1.className='prog-num done';n1.innerHTML='<i class="bi bi-check" style="font-size:.8rem"></i>';l1.className='prog-label done';
    n2.className='prog-num active';n2.textContent='2';l2.className='prog-label active';
    fill.style.width='100%';
    sd1.className='side-step-dot done';sd1.innerHTML='<i class="bi bi-check" style="font-size:.8rem"></i>';sl1.className='side-step-label';
    sd2.className='side-step-dot active';sd2.textContent='2';sl2.className='side-step-label';
  }
}

function togglePass(id, iconId) {
  const el = document.getElementById(id);
  const icon = document.getElementById(iconId);
  if (el.type === 'password') { el.type = 'text'; icon.className = 'bi bi-eye-slash'; }
  else { el.type = 'password'; icon.className = 'bi bi-eye'; }
}
</script>
</body>
</html>