<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lupa Password - KostFinder</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

    :root {
      --navy: #10233f;
      --navy-deep: #091529;
      --cream: #fffaf2;
      --peach: #ffb26b;
      --gold: #ffd166;
      --ink: #24324a;
      --muted: #6c7a92;
      --line: rgba(16, 35, 63, 0.1);
      --card-shadow: 0 24px 60px rgba(16, 35, 63, 0.14);
    }

    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      min-height: 100vh;
      font-family: 'Plus Jakarta Sans', sans-serif;
      color: var(--ink);
      background:
        radial-gradient(circle at top left, rgba(255, 178, 107, 0.22), transparent 28%),
        radial-gradient(circle at bottom right, rgba(16, 35, 63, 0.10), transparent 32%),
        linear-gradient(135deg, #fffdf8 0%, #f7f8fb 45%, #eef3f8 100%);
    }

    .auth-shell {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 32px;
    }

    .auth-card {
      width: min(1120px, 100%);
      min-height: calc(100vh - 64px);
      display: grid;
      grid-template-columns: minmax(0, 1fr) minmax(0, 460px);
      background: rgba(255, 255, 255, 0.82);
      border: 1px solid rgba(255, 255, 255, 0.7);
      border-radius: 32px;
      overflow: hidden;
      box-shadow: var(--card-shadow);
      backdrop-filter: blur(16px);
    }

    .visual-panel {
      position: relative;
      overflow: hidden;
      background: linear-gradient(145deg, var(--navy-deep) 0%, #17355e 55%, #27527f 100%);
    }

    .visual-media {
      position: absolute;
      inset: 0;
      background:
        linear-gradient(180deg, rgba(4, 10, 20, 0.26) 0%, rgba(4, 10, 20, 0.7) 100%),
        url('{{ asset('images/daftar.png') }}') center/cover no-repeat;
      transform: scale(1.05);
    }

    .visual-content {
      position: relative;
      z-index: 1;
      height: 100%;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 42px;
      text-align: center;
      color: #fff;
    }

    .visual-badge {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      padding: 8px 13px;
      border-radius: 999px;
      background: rgba(255, 255, 255, 0.14);
      border: 1px solid rgba(255, 255, 255, 0.18);
      backdrop-filter: blur(10px);
      font-size: 0.74rem;
      font-weight: 700;
    }

    .visual-copy {
      max-width: 340px;
      margin-top: 14px;
    }

    .visual-title {
      margin: 0 0 12px;
      font-size: clamp(1.35rem, 2.4vw, 2rem);
      line-height: 1.2;
      font-weight: 800;
    }

    .visual-text {
      margin: 0;
      font-size: 0.82rem;
      line-height: 1.6;
      color: rgba(255, 255, 255, 0.84);
    }

    .visual-caption {
      margin: 16px auto 0;
      max-width: 270px;
      padding: 9px 12px;
      border-radius: 14px;
      background: rgba(255, 255, 255, 0.12);
      border: 1px solid rgba(255, 255, 255, 0.15);
      backdrop-filter: blur(10px);
      font-size: 0.74rem;
      line-height: 1.45;
      color: rgba(255, 255, 255, 0.84);
    }

    .form-panel {
      display: flex;
      align-items: center;
      padding: 52px;
      background: linear-gradient(180deg, rgba(255, 255, 255, 0.96) 0%, rgba(255, 248, 240, 0.94) 100%);
    }

    .form-wrap {
      width: 100%;
      max-width: 380px;
    }

    .brand-link {
      display: inline-flex;
      align-items: center;
      gap: 14px;
      text-decoration: none;
      margin-bottom: 26px;
    }

    .brand-icon {
      width: 52px;
      height: 52px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      border-radius: 16px;
      color: #fff;
      font-size: 1.2rem;
      background: linear-gradient(135deg, var(--navy) 0%, #1f3e68 100%);
      box-shadow: 0 16px 36px rgba(16, 35, 63, 0.22);
    }

    .brand-title {
      margin: 0;
      font-size: 1.2rem;
      font-weight: 800;
      color: var(--navy);
    }

    .brand-subtitle {
      display: block;
      margin-top: 2px;
      font-size: 0.88rem;
      color: var(--muted);
      font-weight: 500;
    }

    .form-title {
      margin: 0;
      font-size: clamp(1.9rem, 4vw, 2.5rem);
      line-height: 1.08;
      font-weight: 800;
      color: var(--navy-deep);
    }

    .form-lead {
      margin: 14px 0 26px;
      color: var(--muted);
      font-size: 0.95rem;
      line-height: 1.75;
    }

    .form-label {
      display: block;
      margin-bottom: 8px;
      font-size: 0.77rem;
      font-weight: 800;
      color: var(--ink);
      letter-spacing: 0.08em;
      text-transform: uppercase;
    }

    .input-wrap {
      position: relative;
    }

    .input-icon {
      position: absolute;
      left: 18px;
      top: 50%;
      transform: translateY(-50%);
      color: #90a0b6;
    }

    .form-control {
      width: 100%;
      min-height: 58px;
      padding: 16px 18px 16px 50px;
      border-radius: 18px;
      border: 1px solid rgba(16, 35, 63, 0.12);
      background: rgba(255, 255, 255, 0.84);
      color: var(--ink);
      font-size: 0.96rem;
      font-weight: 600;
      box-shadow: none;
      transition: 0.25s ease;
    }

    .form-control::placeholder {
      color: #a2aec0;
      font-weight: 500;
    }

    .form-control:focus {
      border-color: rgba(16, 35, 63, 0.32);
      background: #fff;
      box-shadow: 0 0 0 5px rgba(16, 35, 63, 0.08);
    }

    .btn-submit {
      width: 100%;
      min-height: 58px;
      border: 0;
      border-radius: 18px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      color: #fff;
      font-size: 0.96rem;
      font-weight: 800;
      text-decoration: none;
      background: linear-gradient(135deg, var(--navy-deep) 0%, var(--navy) 100%);
      box-shadow: 0 18px 32px rgba(16, 35, 63, 0.22);
      transition: 0.25s ease;
    }

    .btn-submit:hover {
      transform: translateY(-2px);
      box-shadow: 0 24px 40px rgba(16, 35, 63, 0.28);
    }

    .alert {
      border: 0;
      border-radius: 18px;
      padding: 15px 16px;
      margin-bottom: 18px;
      font-size: 0.9rem;
      line-height: 1.6;
    }

    .alert-success {
      background: rgba(34, 197, 94, 0.14);
      color: #166534;
    }

    .alert-danger {
      background: rgba(239, 68, 68, 0.14);
      color: #991b1b;
    }

    .reset-link-box {
      display: block;
      margin-top: 10px;
      padding: 12px 14px;
      border-radius: 16px;
      background: rgba(16, 35, 63, 0.06);
      color: var(--navy);
      font-size: 0.84rem;
      font-weight: 700;
      line-height: 1.6;
      word-break: break-word;
      text-decoration: none;
    }

    .reset-link-box:hover {
      background: rgba(16, 35, 63, 0.1);
      color: var(--navy-deep);
    }

    .helper-text {
      margin: 18px 0 0;
      text-align: center;
      color: var(--muted);
      font-size: 0.92rem;
    }

    .helper-text a {
      color: var(--navy);
      font-weight: 800;
      text-decoration: none;
    }

    @media (max-width: 991px) {
      .auth-shell {
        padding: 18px;
      }

      .auth-card {
        min-height: auto;
        grid-template-columns: 1fr;
      }

      .visual-panel {
        min-height: 420px;
        order: 1;
      }

      .form-panel {
        order: 2;
        padding: 32px 24px 36px;
      }
    }

    @media (max-width: 575px) {
      .auth-shell {
        padding: 0;
      }

      .auth-card {
        min-height: 100vh;
        border-radius: 0;
      }

      .visual-panel {
        min-height: 360px;
      }

      .visual-content,
      .form-panel {
        padding: 24px 18px 28px;
      }
    }
  </style>
</head>
<body>
  <div class="auth-shell">
    <div class="auth-card">
      <section class="visual-panel">
        <div class="visual-media"></div>
        <div class="visual-content">
          <div class="visual-badge">
            <i class="bi bi-shield-lock-fill"></i>
            Reset akses akunmu
          </div>

          <div class="visual-copy">
            <h2 class="visual-title">Masuk lagi dengan langkah reset yang lebih jelas.</h2>
            <p class="visual-text">
              Kami bantu kirim link reset password supaya kamu bisa kembali mengakses akun dengan aman.
            </p>
            <div class="visual-caption">
              Untuk percobaan local, link reset juga akan ditampilkan langsung setelah form dikirim.
            </div>
          </div>
        </div>
      </section>

      <section class="form-panel">
        <div class="form-wrap">
          <a href="{{ url('/') }}" class="brand-link">
            <span class="brand-icon">
              <i class="bi bi-house-heart-fill"></i>
            </span>
            <div>
              <h1 class="brand-title">KostFinder</h1>
              <span class="brand-subtitle">Bantu kamu kembali ke akun dengan cepat</span>
            </div>
          </a>

          <h3 class="form-title">Lupa password?</h3>
          <p class="form-lead">
            Masukkan email akunmu. Kami akan kirimkan link reset password dan, saat kamu sedang di local, link itu juga muncul langsung di halaman ini.
          </p>

          @if(session('status'))
            <div class="alert alert-success">
              <i class="bi bi-check-circle-fill me-2"></i>{{ session('status') }}

              @if(session('reset_link'))
                <a href="{{ session('reset_link') }}" class="reset-link-box">
                  <i class="bi bi-link-45deg me-1"></i>Buka link reset password
                </a>
              @endif
            </div>
          @endif

          @if($errors->any())
            <div class="alert alert-danger">
              <i class="bi bi-exclamation-circle-fill me-2"></i>{{ $errors->first() }}
            </div>
          @endif

          <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="mb-4">
              <label class="form-label" for="email">Email</label>
              <div class="input-wrap">
                <i class="bi bi-envelope input-icon"></i>
                <input
                  type="email"
                  name="email"
                  id="email"
                  class="form-control"
                  placeholder="nama@email.com"
                  value="{{ old('email') }}"
                  required
                  autofocus
                >
              </div>
            </div>

            <button type="submit" class="btn-submit">
              <i class="bi bi-send-fill"></i>
              Kirim link reset
            </button>
          </form>

          <p class="helper-text">
            Sudah ingat password?
            <a href="{{ route('login') }}">Kembali login</a>
          </p>
        </div>
      </section>
    </div>
  </div>
</body>
</html>
