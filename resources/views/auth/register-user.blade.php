<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Pencari Kos - KostFinder</title>
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
      display: flex; align-items: center; justify-content: center;
    }

    /* SHELL */
    .register-shell {
      max-width: 1100px; width: 100%;
      display: grid; grid-template-columns: 1fr 1fr;
      background: rgba(255,255,255,.72); border: 1px solid rgba(255,255,255,.6);
      border-radius: 32px; overflow: hidden; box-shadow: var(--shadow); backdrop-filter: blur(8px);
      min-height: 600px;
    }

    /* SIDE PANEL */
    .register-side {
      position: relative; color: #fff;
      background: linear-gradient(180deg,rgba(8,20,34,.16) 0%,rgba(8,20,34,.58) 48%,rgba(8,20,34,.9) 100%),
        url('{{ asset('images/daftar.png') }}') center center / cover no-repeat;
      display: flex; align-items: flex-start;
    }
    .side-content {
      position: relative; z-index: 1; width: 100%;
      padding: 52px 38px 44px;
      display: flex; justify-content: center;
    }
    .side-copy {
      display: grid; gap: 12px; width: 100%; max-width: 520px;
      margin-top: clamp(8px,5vh,48px); justify-items: start; text-align: left;
    }
    .side-copy h1 {
      margin: 0; font-size: clamp(1.8rem,2.6vw,2.8rem);
      font-weight: 800; line-height: 1.12; max-width: 14ch;
      text-shadow: 0 8px 30px rgba(0,0,0,.32);
    }
    .side-copy p {
      margin: 0; color: rgba(255,255,255,.88);
      line-height: 1.65; font-size: .97rem;
      text-shadow: 0 6px 22px rgba(0,0,0,.26);
    }
    .side-features {
      margin-top: 28px; display: flex; flex-direction: column; gap: 14px;
    }
    .side-feature-item {
      display: flex; align-items: center; gap: 12px;
    }
    .side-feature-icon {
      width: 36px; height: 36px; border-radius: 50%;
      background: rgba(214,90,49,.75); display: flex; align-items: center;
      justify-content: center; font-size: .95rem; flex-shrink: 0;
      box-shadow: 0 0 0 4px rgba(214,90,49,.25);
    }
    .side-feature-label {
      font-size: .88rem; font-weight: 600; color: rgba(255,255,255,.9);
    }

    /* MAIN PANEL */
    .register-main {
      background: var(--panel); padding: 44px 46px; overflow-y: auto;
      display: flex; flex-direction: column; justify-content: center;
    }
    .brand-link {
      display: inline-flex; align-items: center; gap: 10px;
      margin-bottom: 24px; color: var(--navy); text-decoration: none;
      font-weight: 800; letter-spacing: .06em;
    }
 .brand-link i {
  font-size: 1.3rem;
}
    .intro-copy h2 {
      margin: 0 0 8px; font-size: clamp(1.5rem,2vw,2rem);
      font-weight: 800; line-height: 1.15; color: var(--navy);
    }
    .intro-copy p {
      margin: 0 0 28px; color: var(--muted); line-height: 1.7; font-size: .92rem;
    }

    /* DIVIDER */
    .section-divider {
      border: 0; border-top: 1px solid var(--line); margin: 0 0 24px;
    }

    /* FORM */
    .form-label {
      font-size: .75rem; font-weight: 800; letter-spacing: .09em;
      color: #374151; margin-bottom: 8px;
    }
    .input-group-text {
      background: var(--panel-soft); border: 1px solid var(--line);
      border-right: 0; color: #8a776d;
      border-radius: 16px 0 0 16px; padding: 0 16px;
    }
    .input-group-text.eye {
      border-left: 0; border-right: 1px solid var(--line);
      border-radius: 0 16px 16px 0; cursor: pointer;
    }
    .form-control {
      border: 1px solid var(--line); background: var(--panel-soft);
      min-height: 52px; border-radius: 16px; color: var(--ink); padding: 14px 16px;
    }
    .input-group > .form-control {
      border-left: 0; border-radius: 0 16px 16px 0;
    }
    .form-control:focus {
      box-shadow: 0 0 0 .22rem rgba(214,90,49,.12);
      border-color: rgba(214,90,49,.48); background: #fff;
    }

    /* BUTTON DAFTAR */
    .btn-daftar {
      width: 100%; min-height: 54px; margin-top: 8px;
      border: 0; border-radius: 16px;
      background: linear-gradient(135deg, var(--accent) 0%, #e67b4b 100%);
      color: #fff; font-weight: 800; letter-spacing: .08em;
      font-size: .95rem; font-family: inherit;
      box-shadow: 0 16px 30px rgba(214,90,49,.24);
      display: flex; align-items: center; justify-content: center; gap: 10px;
      cursor: pointer; transition: transform .15s, box-shadow .15s;
    }
    .btn-daftar:hover {
      transform: translateY(-1px);
      box-shadow: 0 20px 36px rgba(214,90,49,.3);
      color: #fff;
    }

    /* HELPER LINKS */
    .helper-links {
      text-align: center; color: var(--muted);
      font-size: .88rem; line-height: 1.8; margin-top: 18px;
      padding-top: 18px; border-top: 1px solid var(--line);
    }
    .helper-links a {
      color: var(--accent); font-weight: 700; text-decoration: none;
    }
    .helper-links a:hover { text-decoration: underline; }

    /* ALERT */
    .alert { border-radius: 18px; border: 0; margin-bottom: 20px; }

    /* RESPONSIVE */
    @media(max-width: 991px) {
      .register-shell { grid-template-columns: 1fr; }
      .register-side { min-height: 240px; }
      .side-content { padding: 30px 24px; }
      .side-copy { margin-top: 0; max-width: 100%; }
    }
    @media(max-width: 575px) {
      body { padding: 12px; }
      .register-main { padding: 24px 18px; }
    }
  </style>
</head>
<body>

<div class="register-shell">

  {{-- SIDE PANEL --}}
  <aside class="register-side">
    <div class="side-content">
      <div class="side-copy">
        <h1>Temukan Kos Impianmu dengan Mudah</h1>
        <p>Daftar sekarang dan mulai cari kos terbaik di sekitar lokasimu.</p>
        <div class="side-features">
          <div class="side-feature-item">
            <div class="side-feature-icon"><i class="bi bi-search"></i></div>
            <span class="side-feature-label">Cari kos berdasarkan lokasi & fasilitas</span>
          </div>
          <div class="side-feature-item">
            <div class="side-feature-icon"><i class="bi bi-bookmark-heart"></i></div>
            <span class="side-feature-label">Simpan kos favorit dengan mudah</span>
          </div>
          <div class="side-feature-item">
            <div class="side-feature-icon"><i class="bi bi-chat-dots"></i></div>
            <span class="side-feature-label">Hubungi pemilik kos langsung</span>
          </div>
          <div class="side-feature-item">
            <div class="side-feature-icon"><i class="bi bi-shield-check"></i></div>
            <span class="side-feature-label">Akun aman & terpercaya</span>
          </div>
        </div>
      </div>
    </div>
  </aside>

  {{-- MAIN PANEL --}}
  <main class="register-main">
   <a href="{{ route('home') }}" class="brand-link">
  <span style="
    width: 44px; height: 44px;
    display: inline-flex; align-items: center; justify-content: center;
    border-radius: 14px; color: #fff; font-size: 1.3rem;
    background: linear-gradient(135deg, #10233f 0%, #1f3e68 100%);
    box-shadow: 0 8px 20px rgba(16,35,63,0.22); flex-shrink: 0;">
    <i class="bi bi-house-heart-fill" style="color:#fff;background:none;width:auto;height:auto;border-radius:0;"></i>
  </span>
  <div>
    <div style="font-size: 1.1rem; font-weight: 800; line-height: 1.2;">
      <span style="color: #111b27;">Kost</span><span style="color: #f06432;">Finder</span>
    </div>
    <div style="font-size: 0.78rem; color: #6b7280; font-weight: 500;">Platform pencarian kos yang terasa simpel</div>
  </div>
</a>

    <div class="intro-copy">
      <h2>Buat Akun Pencari Kos</h2>
      <p>Isi data diri kamu di bawah ini untuk mulai mencari kos.</p>
    </div>

    @if($errors->any())
      <div class="alert alert-danger py-3 px-3">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('register.user.store') }}" novalidate>
      @csrf

      <div class="row g-3">
        <div class="col-12">
          <label class="form-label">NAMA LENGKAP</label>
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-person"></i></span>
            <input type="text" name="name" class="form-control"
              placeholder="Nama lengkap kamu"
              value="{{ old('name') }}" required>
          </div>
        </div>

        <div class="col-12">
          <label class="form-label">EMAIL</label>
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
            <input type="email" name="email" class="form-control"
              placeholder="nama@email.com"
              value="{{ old('email') }}" required>
          </div>
        </div>

        <div class="col-12">
          <label class="form-label">NOMOR HANDPHONE</label>
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-telephone"></i></span>
            <input type="text" name="no_hp" class="form-control"
              placeholder="+62 812-3456-7890"
              value="{{ old('no_hp') }}" required>
          </div>
        </div>

        <div class="col-md-6">
          <label class="form-label">PASSWORD</label>
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-lock"></i></span>
            <input type="password" name="password" id="password1"
              class="form-control" placeholder="Minimal 8 karakter" required>
            <span class="input-group-text eye" onclick="togglePass('password1','eye1')">
              <i class="bi bi-eye" id="eye1"></i>
            </span>
          </div>
        </div>

        <div class="col-md-6">
          <label class="form-label">KONFIRMASI PASSWORD</label>
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-lock"></i></span>
            <input type="password" name="password_confirmation" id="password2"
              class="form-control" placeholder="Ulangi password" required>
            <span class="input-group-text eye" onclick="togglePass('password2','eye2')">
              <i class="bi bi-eye" id="eye2"></i>
            </span>
          </div>
        </div>
      </div>

      <button type="submit" class="btn btn-daftar mt-4">
        DAFTAR SEKARANG <i class="bi bi-arrow-right"></i>
      </button>

      <div class="helper-links">
        Sudah punya akun? <a href="{{ route('login', ['role'=>'user']) }}">Masuk di sini</a><br>
            </div>
    </form>
  </main>

</div>

<script>
  function togglePass(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon  = document.getElementById(iconId);
    if (input.type === 'password') {
      input.type = 'text';
      icon.className = 'bi bi-eye-slash';
    } else {
      input.type = 'password';
      icon.className = 'bi bi-eye';
    }
  }
</script>

</body>
</html>