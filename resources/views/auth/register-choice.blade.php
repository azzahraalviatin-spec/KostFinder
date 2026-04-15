<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pilih Tipe Daftar - KostFinder</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      margin: 0;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background: linear-gradient(180deg, #eef2f8 0%, #e9eef7 100%);
      font-family: 'Segoe UI', sans-serif;
      color: #1f2937;
    }

    .register-choice-shell {
      width: 100%;
      max-width: 560px;
      padding: 1.2rem;
    }

    .register-choice-card {
      background: #fff;
      border-radius: 1.6rem;
      box-shadow: 0 24px 70px rgba(15, 23, 42, .14);
      padding: 2rem 1.6rem 1.4rem;
      border: 1px solid rgba(226, 232, 240, .9);
    }

    .register-choice-header {
      text-align: center;
      margin-bottom: 1.25rem;
    }

    .register-choice-header h1 {
      font-size: 1.15rem;
      font-weight: 800;
      margin-bottom: .3rem;
      color: #1f2937;
    }

    .register-choice-header p {
      margin: 0;
      color: #6b7280;
      font-size: .95rem;
    }

    .register-option {
      display: flex;
      align-items: center;
      gap: .95rem;
      padding: 1rem;
      border: 1px solid #dbe4f0;
      border-radius: 1rem;
      text-decoration: none;
      color: #1f2937;
      background: #fff;
      transition: .18s ease;
    }

    .register-option + .register-option {
      margin-top: .9rem;
    }

    .register-option:hover {
      border-color: #e8401c;
      background: #fff7f3;
      color: #1f2937;
      transform: translateY(-1px);
    }

    .register-option-icon {
      width: 44px;
      height: 44px;
      border-radius: .95rem;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
      font-size: 1.1rem;
    }

    .register-option-icon.user {
      background: #d9f8ec;
      color: #117a5b;
    }

    .register-option-icon.owner {
      background: #fff1c9;
      color: #a16207;
    }

    .register-option-copy {
      flex: 1;
      min-width: 0;
    }

    .register-option-copy strong {
      display: block;
      font-size: 1rem;
      font-weight: 800;
      margin-bottom: .15rem;
    }

    .register-option-copy span {
      display: block;
      color: #6b7280;
      font-size: .88rem;
      line-height: 1.45;
    }

    .register-option-arrow {
      color: #9aa4b2;
      font-size: 1rem;
      flex-shrink: 0;
    }

    .register-choice-footer {
      text-align: center;
      margin-top: 1.2rem;
      color: #6b7280;
      font-size: .92rem;
    }

    .register-choice-footer a {
      color: #e8401c;
      font-weight: 700;
      text-decoration: none;
    }
  </style>
</head>
<body>
  <div class="register-choice-shell">
    <div class="register-choice-card">
      <div class="register-choice-header">
        <h1>Daftar ke KostFinder</h1>
        <p>Saya ingin mendaftar sebagai...</p>
      </div>

      <a href="{{ route('register.user') }}" class="register-option">
        <div class="register-option-icon user">
          <i class="bi bi-search-heart"></i>
        </div>
        <div class="register-option-copy">
          <strong>Pencari Kost</strong>
          <span>Cari, simpan favorit, dan booking kos impian kamu</span>
        </div>
        <div class="register-option-arrow">
          <i class="bi bi-chevron-right"></i>
        </div>
      </a>

      <a href="{{ route('register.owner') }}" class="register-option">
        <div class="register-option-icon owner">
          <i class="bi bi-house-check"></i>
        </div>
        <div class="register-option-copy">
          <strong>Pemilik Kost</strong>
          <span>Kelola properti dan pasang iklan kost kamu</span>
        </div>
        <div class="register-option-arrow">
          <i class="bi bi-chevron-right"></i>
        </div>
      </a>

      <div class="register-choice-footer">
        Sudah punya akun?
        <a href="{{ route('login') }}">Masuk sekarang</a>
      </div>
    </div>
  </div>
</body>
</html>
