<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Password - KostFinder</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

    :root {
      --navy: #10233f;
      --navy-deep: #091529;
      --ink: #24324a;
      --muted: #6c7a92;
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
      width: min(560px, 100%);
      padding: 38px 32px;
      border-radius: 30px;
      background: rgba(255, 255, 255, 0.9);
      border: 1px solid rgba(255, 255, 255, 0.7);
      box-shadow: var(--card-shadow);
      backdrop-filter: blur(16px);
    }

    .brand-link {
      display: inline-flex;
      align-items: center;
      gap: 14px;
      text-decoration: none;
      margin-bottom: 24px;
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
      font-size: clamp(1.8rem, 4vw, 2.35rem);
      line-height: 1.08;
      font-weight: 800;
      color: var(--navy-deep);
    }

    .form-lead {
      margin: 14px 0 26px;
      color: var(--muted);
      font-size: 0.94rem;
      line-height: 1.75;
    }

    .form-group {
      margin-bottom: 18px;
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

    .form-control:focus {
      border-color: rgba(16, 35, 63, 0.32);
      background: #fff;
      box-shadow: 0 0 0 5px rgba(16, 35, 63, 0.08);
    }

    .password-toggle {
      position: absolute;
      right: 16px;
      top: 50%;
      transform: translateY(-50%);
      width: 38px;
      height: 38px;
      border: 0;
      border-radius: 50%;
      background: transparent;
      color: #94a3b8;
      transition: 0.2s ease;
    }

    .password-toggle:hover {
      color: var(--navy);
      background: rgba(16, 35, 63, 0.06);
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

    .alert-danger {
      background: rgba(239, 68, 68, 0.14);
      color: #991b1b;
    }

    .error-text {
      display: block;
      margin-top: 8px;
      font-size: 0.82rem;
      color: #b91c1c;
      font-weight: 600;
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

    @media (max-width: 575px) {
      .auth-shell {
        padding: 16px;
      }

      .auth-card {
        padding: 28px 18px;
        border-radius: 24px;
      }
    }
  </style>
</head>
<body>
  <div class="auth-shell">
    <div class="auth-card">
      <a href="{{ url('/') }}" class="brand-link">
        <span class="brand-icon">
          <i class="bi bi-house-heart-fill"></i>
        </span>
        <div>
          <h1 class="brand-title">KostFinder</h1>
          <span class="brand-subtitle">Atur password baru untuk akunmu</span>
        </div>
      </a>

      <h2 class="form-title">Buat password baru</h2>
      <p class="form-lead">
        Masukkan email akunmu lalu isi password baru yang ingin dipakai untuk login berikutnya.
      </p>

      @if($errors->any())
        <div class="alert alert-danger">
          <i class="bi bi-exclamation-circle-fill me-2"></i>{{ $errors->first() }}
        </div>
      @endif

      <form method="POST" action="{{ route('password.store') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="form-group">
          <label class="form-label" for="email">Email</label>
          <div class="input-wrap">
            <i class="bi bi-envelope input-icon"></i>
            <input
              id="email"
              class="form-control"
              type="email"
              name="email"
              value="{{ old('email', $request->email) }}"
              required
              autofocus
              autocomplete="username"
            />
          </div>
          @if($errors->has('email'))
            <span class="error-text">{{ $errors->first('email') }}</span>
          @endif
        </div>

        <div class="form-group">
          <label class="form-label" for="password">Password baru</label>
          <div class="input-wrap">
            <i class="bi bi-lock input-icon"></i>
            <input id="password" class="form-control" type="password" name="password" required autocomplete="new-password" />
            <button type="button" class="password-toggle" onclick="togglePassword('password', 'togglePasswordIcon')" aria-label="Tampilkan password baru">
              <i class="bi bi-eye" id="togglePasswordIcon"></i>
            </button>
          </div>
          @if($errors->has('password'))
            <span class="error-text">{{ $errors->first('password') }}</span>
          @endif
        </div>

        <div class="form-group">
          <label class="form-label" for="password_confirmation">Konfirmasi password</label>
          <div class="input-wrap">
            <i class="bi bi-shield-lock input-icon"></i>
            <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password" />
            <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation', 'toggleConfirmIcon')" aria-label="Tampilkan konfirmasi password">
              <i class="bi bi-eye" id="toggleConfirmIcon"></i>
            </button>
          </div>
          @if($errors->has('password_confirmation'))
            <span class="error-text">{{ $errors->first('password_confirmation') }}</span>
          @endif
        </div>

        <button type="submit" class="btn-submit">
          <i class="bi bi-check2-circle"></i>
          Simpan password baru
        </button>
      </form>

      <p class="helper-text">
        Kembali ke halaman
        <a href="{{ route('login') }}">login</a>
      </p>
    </div>
  </div>

  <script>
    function togglePassword(inputId, iconId) {
      const input = document.getElementById(inputId);
      const icon = document.getElementById(iconId);

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
