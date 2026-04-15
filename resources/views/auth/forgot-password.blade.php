<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lupa Password - KostFinder</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body { background: #f0f2f5; min-height: 100vh; display: flex; align-items: center; justify-content: center; font-family: 'Segoe UI', sans-serif; }
    .card { border-radius: 1.2rem; padding: 2.5rem 2rem; width: 100%; max-width: 400px; box-shadow: 0 8px 32px rgba(0,0,0,.1); border: 0; }
    .logo-wrap { width: 56px; height: 56px; background: #1a2236; border-radius: .85rem; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; font-size: 1.6rem; }
    .form-label { font-size: .82rem; font-weight: 700; letter-spacing: .05em; color: #333; }
    .input-group-text { background: #f5f7fa; border-right: 0; color: #888; }
    .form-control { border-left: 0; background: #f5f7fa; }
    .form-control:focus { box-shadow: none; border-color: #dee2e6; background: #f5f7fa; }
    .btn-primary { background: #1a2236; border: 0; font-weight: 700; letter-spacing: .08em; height: 48px; border-radius: .6rem; }
    .btn-primary:hover { background: #111827; }
  </style>
</head>
<body>
  <div class="card">
    <div class="logo-wrap">👑</div>
    <h5 class="text-center fw-bold mb-1">Lupa Password?</h5>
    <p class="text-center text-muted mb-4" style="font-size:.83rem;">
      Masukkan email kamu dan kami akan kirimkan link reset password.
    </p>

    @if(session('status'))
      <div class="alert alert-success py-2 mb-3" style="font-size:.83rem;">
        <i class="bi bi-check-circle me-1"></i> {{ session('status') }}
      </div>
    @endif

    @if($errors->any())
      <div class="alert alert-danger py-2 mb-3" style="font-size:.83rem;">
        {{ $errors->first() }}
      </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
      @csrf
      <div class="mb-4">
        <label class="form-label">EMAIL</label>
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-envelope"></i></span>
          <input type="email" name="email" class="form-control" placeholder="email@kamu.com" value="{{ old('email') }}" required autofocus>
        </div>
      </div>

      <button type="submit" class="btn btn-primary w-100 mb-3">
        <i class="bi bi-send me-1"></i> KIRIM LINK RESET
      </button>

      <div class="text-center" style="font-size:.83rem;color:#888;">
        Ingat password?
        <a href="{{ route('login', ['role' => 'owner']) }}" style="color:#e8401c;font-weight:700;text-decoration:none;">
          Kembali Login
        </a>
      </div>
    </form>
  </div>
</body>
</html>