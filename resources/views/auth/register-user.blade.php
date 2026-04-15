<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Pencari Kos - KostFinder</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body { background: #f0f2f5; min-height: 100vh; display: flex; align-items: center; justify-content: center; font-family: 'Segoe UI', sans-serif; }
    .register-card { background: #fff; border-radius: 1.2rem; padding: 2.5rem 2rem; width: 100%; max-width: 440px; box-shadow: 0 8px 32px rgba(0,0,0,.1); }
    .form-label { font-size: .82rem; font-weight: 700; letter-spacing: .05em; color: #333; }
    .input-group-text { background: #f5f7fa; border-right: 0; color: #888; }
    .input-group-text.eye { border-left: 0; border-right: 1px solid #dee2e6; cursor: pointer; }
    .form-control { border-left: 0; background: #f5f7fa; }
    .form-control:focus { box-shadow: none; border-color: #dee2e6; background: #f5f7fa; }
    .btn-daftar { background: #1a2236; color: #fff; font-weight: 700; letter-spacing: .08em; height: 48px; border: 0; border-radius: .6rem; }
    .btn-daftar:hover { background: #111827; color: #fff; }
  </style>
</head>
<body>
  <div class="register-card">
    <h5 class="text-center fw-bold mb-1">DAFTAR PENCARI KOS</h5>
    <p class="text-center text-muted mb-4" style="font-size:.85rem;">Buat akun untuk mencari kos dengan email dan password</p>

    @if($errors->any())
      <div class="alert alert-danger py-2" style="font-size:.85rem;">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('register.user.store') }}">
      @csrf

      <div class="mb-3">
        <label class="form-label">NAMA LENGKAP</label>
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-person"></i></span>
          <input type="text" name="name" class="form-control" placeholder="Nama lengkap" value="{{ old('name') }}" required>
        </div>
      </div>

      <div class="mb-3">
        <label class="form-label">EMAIL</label>
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-envelope"></i></span>
          <input type="email" name="email" class="form-control" placeholder="nama@email.com" value="{{ old('email') }}" required>
        </div>
      </div>

      <div class="mb-3">
        <label class="form-label">NOMOR HANDPHONE</label>
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-telephone"></i></span>
          <input type="text" name="no_hp" class="form-control" placeholder="+62 812-3456-7890" value="{{ old('no_hp') }}" required>
        </div>
      </div>

      <div class="mb-3">
        <label class="form-label">PASSWORD</label>
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-lock"></i></span>
          <input type="password" name="password" id="password1" class="form-control" placeholder="Minimal 8 karakter" required>
          <span class="input-group-text eye" onclick="togglePass('password1', 'eye1')">
            <i class="bi bi-eye" id="eye1"></i>
          </span>
        </div>
      </div>

      <div class="mb-4">
        <label class="form-label">KONFIRMASI PASSWORD</label>
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-lock"></i></span>
          <input type="password" name="password_confirmation" id="password2" class="form-control" placeholder="Ulangi password" required>
          <span class="input-group-text eye" onclick="togglePass('password2', 'eye2')">
            <i class="bi bi-eye" id="eye2"></i>
          </span>
        </div>
      </div>

      <button type="submit" class="btn btn-daftar w-100 mb-3">DAFTAR</button>

      <div class="text-center" style="font-size:.85rem;">
        Ingin daftar sebagai pemilik?
        <a href="{{ route('register.owner') }}" class="fw-bold" style="color:#e8401c;">Masuk ke form owner</a>
      </div>
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
