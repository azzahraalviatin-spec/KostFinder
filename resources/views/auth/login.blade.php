<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - KostFinder</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body { background: #f0f2f5; min-height: 100vh; display: flex; align-items: center; justify-content: center; font-family: 'Segoe UI', sans-serif; }
    .login-card { background: #fff; border-radius: 1.2rem; padding: 2.5rem 2rem; width: 100%; max-width: 400px; box-shadow: 0 8px 32px rgba(0,0,0,.1); }
    .logo-wrap { width: 56px; height: 56px; background: #1a2236; border-radius: .85rem; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; font-size: 1.6rem; }
    .form-label { font-size: .82rem; font-weight: 700; letter-spacing: .05em; color: #333; }
    .input-group-text { background: #f5f7fa; border-right: 0; color: #888; }
    .input-group-text.eye { border-left: 0; border-right: 1px solid #dee2e6; cursor: pointer; }
    .form-control { border-left: 0; background: #f5f7fa; }
    .form-control:focus { box-shadow: none; border-color: #dee2e6; background: #f5f7fa; }
    .btn-login { background: #1a2236; color: #fff; font-weight: 700; letter-spacing: .08em; height: 48px; border: 0; border-radius: .6rem; }
    .btn-login:hover { background: #111827; color: #fff; }
    .divider { display: flex; align-items: center; gap: .75rem; margin: .75rem 0; color: #aaa; font-size: .78rem; }
    .divider::before, .divider::after { content:''; flex:1; height:1px; background:#e4e9f0; }
  </style>
</head>
<body>
  @php
    $selectedRole = request('role', 'user');
    $showGoogleLogin = $selectedRole === 'user';
  @endphp
  <div class="login-card">
    <div class="logo-wrap">👑</div>
    <h5 class="text-center fw-bold mb-1">KostFinder</h5>
    <p class="text-center text-muted mb-4" style="font-size:.85rem;">
      {{ $selectedRole === 'owner' ? 'Masuk sebagai Pemilik Kos' : ($selectedRole === 'admin' ? 'Masuk sebagai Admin' : 'Satu halaman login untuk semua role') }}
    </p>

    @if(session('status'))
      <div class="alert alert-success py-2" style="font-size:.85rem;">{{ session('status') }}</div>
    @endif
    @if($errors->any())
      <div class="alert alert-danger py-2" style="font-size:.85rem;">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
      @csrf
      <input type="hidden" name="role" value="{{ $selectedRole }}">

      <div class="mb-3">
        <label class="form-label">EMAIL</label>
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-envelope"></i></span>
          <input type="email" name="email" class="form-control" placeholder="Masukkan email anda" value="{{ old('email') }}" required>
        </div>
      </div>

      <div class="mb-4">
        <label class="form-label">PASSWORD</label>
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-lock"></i></span>
          <input type="password" name="password" id="passwordInput" class="form-control" placeholder="Minimal 8 karakter" required>
          <span class="input-group-text eye" onclick="togglePass('passwordInput', 'eyeIcon')">
            <i class="bi bi-eye" id="eyeIcon"></i>
          </span>
        </div>
      </div>

      <button type="submit" class="btn btn-login w-100 mb-3">LOGIN</button>
    
      <div class="text-end mb-2">
        <a href="{{ route('password.request') }}" style="font-size:.8rem;color:#888;text-decoration:none;">
          Lupa password?
        </a>
      </div>

      @if($showGoogleLogin)
      <a href="{{ route('auth.google.redirect', ['role' => $selectedRole]) }}" class="btn btn-outline-secondary w-100 mb-3 d-flex align-items-center justify-content-center gap-2">
        <i class="bi bi-google"></i> Login dengan Google
      </a>
      @endif

      @if($selectedRole !== 'admin')
        <div class="divider">atau</div>
        <div class="text-center" style="font-size:.83rem;color:#888;">
          Belum punya akun?
          <a href="{{ route('register') }}" style="color:#e8401c;font-weight:700;text-decoration:none;">
            Daftar
          </a>
        </div>
      @endif

    </form>
  </div>

  <script>
    function togglePass(inputId, iconId) {
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
