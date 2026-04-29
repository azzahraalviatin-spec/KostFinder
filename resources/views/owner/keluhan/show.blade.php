<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail Keluhan - KostFinder</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    :root { --sidebar-w:200px; --sidebar-col:60px; --primary:#e8401c; --dark:#1e2d3d; --bg:#f0f4f8; --line:#e4e9f0; --muted:#8fa3b8; }
    * { margin:0; padding:0; box-sizing:border-box; }
    body { font-family:'Plus Jakarta Sans',sans-serif; background:var(--bg); display:flex; min-height:100vh; }
    .sidebar { width:var(--sidebar-w); min-height:100vh; background:var(--dark); position:fixed; top:0; left:0; display:flex; flex-direction:column; z-index:200; transition:width .3s ease; overflow:hidden; }
    .sidebar.collapsed { width:var(--sidebar-col); }
    .sidebar-brand { padding:1.2rem .9rem; border-bottom:1px solid rgba(255,255,255,.08); display:flex; align-items:center; gap:.6rem; min-height:60px; white-space:nowrap; }
    .brand-icon { width:32px; height:32px; flex-shrink:0; background:var(--primary); border-radius:.5rem; display:flex; align-items:center; justify-content:center; font-size:1rem; }
    .brand-text { overflow:hidden; transition:opacity .2s; }
    .brand-text .name { font-size:1rem; font-weight:800; color:#fff; }
    .brand-text .name span { color:var(--primary); }
    .brand-text .sub { font-size:.65rem; color:#7a92aa; }
    .sidebar.collapsed .brand-text { opacity:0; width:0; }
    .sidebar-menu { padding:.7rem .5rem; flex:1; }
    .menu-label { font-size:.6rem; font-weight:700; letter-spacing:.1em; color:#7a92aa; padding:.5rem .5rem .2rem; white-space:nowrap; transition:opacity .2s; }
    .sidebar.collapsed .menu-label { opacity:0; }
    .menu-item { display:flex; align-items:center; gap:.65rem; padding:.58rem .65rem; border-radius:.55rem; color:#a0b4c4; text-decoration:none; font-size:.82rem; font-weight:500; margin-bottom:.1rem; transition:all .2s; white-space:nowrap; cursor:pointer; border:0; background:none; width:100%; text-align:left; }
    .menu-item i { font-size:.95rem; width:20px; flex-shrink:0; }
    .menu-item span { overflow:hidden; transition:opacity .2s; }
    .sidebar.collapsed .menu-item span { opacity:0; width:0; }
    .menu-item:hover { background:rgba(255,255,255,.07); color:#fff; }
    .menu-item.active { background:var(--primary); color:#fff; }
    .menu-item.logout { color:#f87171; }
    .menu-item.logout:hover { background:rgba(248,113,113,.1); }
    .sidebar-user { padding:.85rem .9rem; border-top:1px solid rgba(255,255,255,.08); display:flex; align-items:center; gap:.6rem; white-space:nowrap; }
    .user-avatar { width:32px; height:32px; border-radius:50%; background:var(--primary); color:#fff; font-weight:700; font-size:.8rem; flex-shrink:0; display:flex; align-items:center; justify-content:center; }
    .user-info { overflow:hidden; transition:opacity .2s; }
    .sidebar.collapsed .user-info { opacity:0; width:0; }
    .user-name { color:#fff; font-size:.8rem; font-weight:600; }
    .user-role { color:#7a92aa; font-size:.68rem; }
    .main { margin-left:var(--sidebar-w); flex:1; transition:margin-left .3s ease; display:flex; flex-direction:column; }
    .main.collapsed { margin-left:var(--sidebar-col); }
    .topbar { background:#fff; height:60px; padding:0 1.5rem; display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid #e4e9f0; position:sticky; top:0; z-index:100; }
    .search-box { display:flex; align-items:center; gap:.5rem; background:#f0f4f8; border:1px solid #dde3ed; border-radius:.55rem; padding:.38rem .75rem; width:180px; }
    .search-box input { border:0; background:none; outline:none; font-size:.8rem; color:#333; width:100%; }
    .icon-btn { width:34px; height:34px; border-radius:.5rem; background:#f0f4f8; border:1px solid #dde3ed; display:flex; align-items:center; justify-content:center; color:#555; font-size:.9rem; cursor:pointer; text-decoration:none; position:relative; }
    .notif-dot { position:absolute; top:5px; right:5px; width:6px; height:6px; background:var(--primary); border-radius:50%; border:1px solid #fff; }
    .content { padding:1.4rem; flex:1; }
    .owner-footer { background:#fff; border-top:1px solid #e4e9f0; padding:.8rem 1.5rem; text-align:center; color:#8fa3b8; font-size:.72rem; }

    /* SHOW STYLES */
    .detail-wrap { max-width:800px; margin: 0 auto; }
    .back-btn { 
      display:inline-flex; 
      align-items:center; 
      gap:.6rem; 
      background: linear-gradient(135deg, #ff8c00, #e8401c);
      color:#fff; 
      font-size:.85rem; 
      font-weight:700; 
      text-decoration:none; 
      margin-bottom:1.5rem; 
      padding:.5rem 1.2rem; 
      border-radius:10px; 
      box-shadow: 0 4px 15px rgba(232, 64, 28, 0.25);
      transition:all .3s ease; 
      border: none;
    }
    .back-btn:hover { 
      transform: translateX(-5px);
      box-shadow: 0 6px 20px rgba(232, 64, 28, 0.4);
      color: #fff;
    }
    .detail-card { 
      background:#fff; 
      border-radius:20px; 
      border:1px solid rgba(228, 233, 240, 0.8); 
      overflow:hidden; 
      margin-bottom:1.5rem; 
      box-shadow:0 10px 30px rgba(0,0,0,0.03); 
    }
    .detail-head { 
      padding:1.25rem 1.5rem; 
      border-bottom:1px solid #f0f3f8; 
      display:flex; 
      justify-content:space-between; 
      align-items:center;
      background: #fafbfc;
    }
    .detail-body { padding:1.5rem; }
    .info-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.25rem; margin-bottom: 1.5rem; }
    .info-item { display: flex; flex-direction: column; gap: 0.35rem; }
    .info-label { font-size:.72rem; font-weight:700; color:var(--muted); text-transform: uppercase; letter-spacing: 0.03em; }
    .info-val { font-size:.9rem; font-weight:700; color:#1e293b; display: flex; align-items: center; gap: 0.5rem; }
    .desc-box { 
      background:#f8fafc; 
      border-radius:15px; 
      padding:1.25rem; 
      font-size:.88rem; 
      color:#334155; 
      line-height:1.8; 
      margin-top:.5rem;
      border: 1px solid #f1f5f9;
    }
    .status-pill { font-size:.72rem; font-weight:800; padding:.35rem .9rem; border-radius:99px; display: inline-flex; align-items: center; gap: 0.4rem; }
    .select-status { 
      width:100%; 
      padding:.75rem 1rem; 
      border:2px solid #f1f5f9; 
      border-radius:12px; 
      font-size:.88rem; 
      font-weight:600; 
      color:#1e293b; 
      background:#fff; 
      outline:none; 
      margin-bottom:1.25rem;
      transition: all 0.2s;
    }
    .select-status:focus { border-color:var(--primary); background: #fff; }
    .btn-update { 
      background: linear-gradient(135deg, var(--dark), #2d3748);
      color:#fff; 
      border:0; 
      border-radius:12px; 
      padding:.75rem 1.5rem; 
      font-size:.88rem; 
      font-weight:700; 
      cursor:pointer; 
      display:inline-flex; 
      align-items:center; 
      gap:.6rem; 
      transition:all 0.3s;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .btn-update:hover { 
      transform: translateY(-2px);
      box-shadow: 0 6px 15px rgba(0,0,0,0.15);
    }
    .img-preview {
      width: 100%;
      max-height: 400px;
      object-fit: contain;
      border-radius: 15px;
      background: #f8fafc;
      border: 1px solid #e2e8f0;
      padding: 10px;
    }
  </style>
</head>
<body>

  @include('owner._sidebar')

  <div class="main" id="mainContent">

    @include('owner._navbar')

    <div class="content">
      <div class="detail-wrap">

        <a href="{{ route('owner.keluhan.index') }}" class="back-btn">
          <i class="bi bi-arrow-left-short" style="font-size:1.4rem;"></i> Kembali
        </a>

        @if(session('success'))
          <div class="alert alert-success border-0 shadow-sm mb-4" style="border-radius:15px; font-size:.85rem; background: #dcfce7; color: #166534;">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
          </div>
        @endif

        <div class="detail-card">
          <div class="detail-head">
            <div>
              <div style="font-size:1.1rem;font-weight:800;color:var(--dark);">{{ $keluhan->judul ?? $keluhan->jenis ?? 'Detail Keluhan' }}</div>
              <div style="font-size:.78rem;color:var(--muted);margin-top:.2rem;">
                <i class="bi bi-calendar3 me-1"></i> {{ \Carbon\Carbon::parse($keluhan->created_at)->translatedFormat('d F Y') }}
                <span class="mx-2">•</span>
                <i class="bi bi-clock me-1"></i> {{ \Carbon\Carbon::parse($keluhan->created_at)->format('H:i') }} WIB
              </div>
            </div>
            @php
              $st = $keluhan->status ?? 'pending';
              $stStyles = [
                'pending'  => 'background:#fff7ed;color:#ea580c;border:1px solid #ffedd5;',
                'diproses' => 'background:#eff6ff;color:#3b82f6;border:1px solid #dbeafe;',
                'selesai'  => 'background:#f0fdf4;color:#16a34a;border:1px solid #dcfce7;'
              ];
              $stLabels = ['pending'=>'⏳ Pending','diproses'=>'🔄 Diproses','selesai'=>'✅ Selesai'];
            @endphp
            <span class="status-pill" style="{{ $stStyles[$st] ?? $stStyles['pending'] }}">
              {{ $stLabels[$st] ?? ucfirst($st) }}
            </span>
          </div>
          <div class="detail-body">
            <div class="info-grid">
              <div class="info-item">
                <span class="info-label">🏠 Kost</span>
                <span class="info-val">{{ $keluhan->booking->room->kost->nama_kost ?? '-' }}</span>
              </div>
              <div class="info-item">
                <span class="info-label">🚪 Nomor Kamar</span>
                <span class="info-val">Kamar {{ $keluhan->booking->room->nomor_kamar ?? '-' }}</span>
              </div>
              <div class="info-item">
                <span class="info-label">👤 Nama Penghuni</span>
                <span class="info-val">{{ $keluhan->booking->user->name ?? '-' }}</span>
              </div>
              <div class="info-item">
                <span class="info-label">📋 Jenis Keluhan</span>
                <span class="info-val">{{ $keluhan->jenis ?? '-' }}</span>
              </div>
            </div>

            <div style="margin-top:1.5rem;">
              <span class="info-label">📝 Deskripsi Keluhan</span>
              <div class="desc-box">
                {{ $keluhan->deskripsi ?? $keluhan->isi ?? '-' }}
              </div>
            </div>

            @if($keluhan->foto)
              <div style="margin-top:1.5rem;">
                <span class="info-label">📷 Foto Lampiran</span>
                <div class="mt-2">
                  <img src="{{ asset('storage/'.$keluhan->foto) }}" class="img-preview shadow-sm" alt="foto keluhan">
                </div>
              </div>
            @endif
          </div>
        </div>

        <div class="detail-card">
          <div class="detail-head">
            <div style="font-weight:800;font-size:.95rem;color:var(--dark);">
              <i class="bi bi-pencil-square me-2" style="color:var(--primary);"></i> Tindak Lanjut Pemilik
            </div>
          </div>
          <div class="detail-body">
            <form action="{{ route('owner.keluhan.updateStatus', $keluhan->id) }}" method="POST">
              @csrf
              <div class="row">
                <div class="col-md-6">
                  <div style="font-size:.8rem;font-weight:700;color:#475569;margin-bottom:.5rem;">Update Status</div>
                  <select name="status" class="select-status">
                    <option value="pending"  {{ $keluhan->status == 'pending'  ? 'selected' : '' }}>⏳ Menunggu (Pending)</option>
                    <option value="diproses" {{ $keluhan->status == 'diproses' ? 'selected' : '' }}>🔄 Sedang Diproses</option>
                    <option value="selesai"  {{ $keluhan->status == 'selesai'  ? 'selected' : '' }}>✅ Sudah Selesai</option>
                  </select>
                </div>
              </div>

              <div style="font-size:.8rem;font-weight:700;color:#475569;margin-bottom:.5rem;margin-top:.5rem;">Berikan Tanggapan ke Penghuni</div>
              <textarea name="balasan" class="select-status" rows="4" 
                placeholder="Tulis solusi atau informasi untuk penghuni agar mereka tahu keluhan sedang ditangani..." 
                style="resize:none;">{{ $keluhan->balasan }}</textarea>

              <div class="d-flex justify-content-end">
                <button type="submit" class="btn-update">
                  <i class="bi bi-send-fill"></i> Simpan & Update Penghuni
                </button>
              </div>
            </form>
          </div>
        </div>

      </div>
    </div>

    <footer class="owner-footer">&copy; {{ date('Y') }} KostFinder &mdash; Panel Pemilik Kost</footer>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function toggleSidebar() {
      document.getElementById('sidebar').classList.toggle('collapsed');
      document.getElementById('mainContent').classList.toggle('collapsed');
    }
  </script>
</body>
</html>