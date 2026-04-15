<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Pemilik - KostFinder</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    :root { --sidebar-w:200px; --sidebar-col:60px; --primary:#e8401c; --dark:#1e2d3d; --bg:#f0f4f8; }
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
    .topbar-left { display:flex; align-items:center; gap:.8rem; }
    .topbar-left h5 { font-size:.98rem; font-weight:800; color:var(--dark); margin:0; }
    .topbar-left p { font-size:.72rem; color:#8fa3b8; margin:0; }
    .topbar-right { display:flex; align-items:center; gap:.6rem; }
    .search-box { display:flex; align-items:center; gap:.5rem; background:#f0f4f8; border:1px solid #dde3ed; border-radius:.55rem; padding:.38rem .75rem; width:180px; }
    .search-box input { border:0; background:none; outline:none; font-size:.8rem; color:#333; width:100%; }
    .icon-btn { width:34px; height:34px; border-radius:.5rem; background:#f0f4f8; border:1px solid #dde3ed; display:flex; align-items:center; justify-content:center; color:#555; font-size:.9rem; cursor:pointer; text-decoration:none; position:relative; }
    .icon-btn:hover { background:#e4e9f0; color:#333; }
    .notif-dot { position:absolute; top:5px; right:5px; width:6px; height:6px; background:var(--primary); border-radius:50%; border:1px solid #fff; }
    .btn-tambah { background:var(--primary); color:#fff; font-weight:700; border:0; border-radius:.55rem; padding:.42rem .9rem; font-size:.8rem; text-decoration:none; display:flex; align-items:center; gap:.35rem; }
    .btn-tambah:hover { background:#cb3518; color:#fff; }
    .content { padding:1.4rem; flex:1; }
    .stat-card { background:#fff; border-radius:.85rem; padding:1.1rem 1.2rem; border:1px solid #e4e9f0; box-shadow:0 2px 6px rgba(0,0,0,.04); display:flex; align-items:center; gap:1rem; }
    .stat-icon { width:46px; height:46px; border-radius:.75rem; display:flex; align-items:center; justify-content:center; font-size:1.2rem; flex-shrink:0; }
    .stat-num { font-size:1.6rem; font-weight:800; color:var(--dark); line-height:1; }
    .stat-lbl { font-size:.75rem; color:#8fa3b8; margin-top:.2rem; }
    .stat-sub { font-size:.7rem; font-weight:600; margin-top:.3rem; }
    .section-card { background:#fff; border-radius:.85rem; border:1px solid #e4e9f0; box-shadow:0 2px 6px rgba(0,0,0,.04); overflow:hidden; }
    .section-head { padding:.9rem 1.2rem; border-bottom:1px solid #f0f3f8; display:flex; justify-content:space-between; align-items:center; }
    .section-head h6 { font-weight:700; color:var(--dark); margin:0; font-size:.87rem; }
    .link-p { color:var(--primary); font-size:.78rem; font-weight:600; text-decoration:none; }
    .link-p:hover { color:#cb3518; }
    table thead th { font-size:.68rem; font-weight:700; color:#8fa3b8; letter-spacing:.05em; border:0; padding:.6rem 1rem; background:#f8fafd; }
    table tbody td { font-size:.8rem; color:#333; padding:.65rem 1rem; border-color:#f0f3f8; vertical-align:middle; }
    .s-pill { padding:.18rem .6rem; border-radius:999px; font-size:.7rem; font-weight:600; display:inline-flex; align-items:center; gap:.25rem; }
    .s-pending { background:#fff7ed; color:#ea580c; }
    .s-diterima { background:#f0fdf4; color:#16a34a; }
    .s-ditolak { background:#fef2f2; color:#dc2626; }
    .kost-item { display:flex; align-items:center; gap:.8rem; padding:.75rem 1.2rem; border-bottom:1px solid #f0f3f8; }
    .kost-item:last-child { border:0; }
    .kost-thumb { width:46px; height:38px; border-radius:.5rem; background:#fff5f2; border:1px solid #ffd0c0; display:flex; align-items:center; justify-content:center; font-size:1.1rem; flex-shrink:0; }
    .kost-name { font-weight:700; font-size:.82rem; color:var(--dark); }
    .kost-loc { font-size:.72rem; color:#8fa3b8; }
    .act-btn { width:28px; height:28px; border-radius:.4rem; border:1px solid #e4e9f0; background:#f8fafd; display:flex; align-items:center; justify-content:center; color:#666; font-size:.75rem; cursor:pointer; text-decoration:none; transition:all .15s; }
    .act-btn:hover { background:#eef1f8; }
    .act-btn.del:hover { background:#fff5f2; color:var(--primary); border-color:#ffd0c0; }
    .empty-s { padding:2rem; text-align:center; color:#8fa3b8; font-size:.82rem; }
    .empty-s i { font-size:1.8rem; display:block; margin-bottom:.4rem; opacity:.35; }
    .owner-footer { background:#fff; border-top:1px solid #e4e9f0; padding:.8rem 1.5rem; text-align:center; color:#8fa3b8; font-size:.72rem; }
  </style>
</head>
<body>

  @include('owner._sidebar')

  <div class="main" id="mainContent">
    @include('owner._navbar')

    <div class="content">

      <div class="row g-3 mb-3">
        <div class="col-6 col-xl-3">
          <div class="stat-card">
            <div class="stat-icon" style="background:#fff5f2;">🏠</div>
            <div>
              <div class="stat-num">{{ $total_kost }}</div>
              <div class="stat-lbl">Total Kost</div>
              <div class="stat-sub" style="color:#e8401c;">Kost terdaftar</div>
            </div>
          </div>
        </div>
        <div class="col-6 col-xl-3">
          <div class="stat-card">
            <div class="stat-icon" style="background:#f0f9ff;">🛏️</div>
            <div>
              <div class="stat-num">0</div>
              <div class="stat-lbl">Kamar Terisi</div>
              <div class="stat-sub" style="color:#0ea5e9;">0 dari 0 kamar</div>
            </div>
          </div>
        </div>
        <div class="col-6 col-xl-3">
          <div class="stat-card">
            <div class="stat-icon" style="background:#fffbeb;">📋</div>
            <div>
              <div class="stat-num">{{ $total_booking }}</div>
              <div class="stat-lbl">Total Booking</div>
              <div class="stat-sub" style="color:#f59e0b;">{{ $booking_pending }} pending</div>
            </div>
          </div>
        </div>
        <div class="col-6 col-xl-3">
          <div class="stat-card">
            <div class="stat-icon" style="background:#f0fdf4;">💰</div>
            <div>
              <div class="stat-num" style="font-size:1.2rem;">Rp 0</div>
              <div class="stat-lbl">Pendapatan Bulan Ini</div>
              <div class="stat-sub" style="color:#10b981;">— vs bulan lalu</div>
            </div>
          </div>
        </div>
      </div>

      <div class="row g-3 mb-3">
        <div class="col-12 col-lg-8">
          <div class="section-card">
            <div class="section-head">
              <h6><i class="bi bi-graph-up me-1" style="color:var(--primary)"></i> Statistik Booking — 6 Bulan Terakhir</h6>
            </div>
            <div class="p-3">
              <canvas id="bookingChart" height="100"></canvas>
            </div>
          </div>
        </div>
        <div class="col-12 col-lg-4">
          <div class="section-card h-100">
            <div class="section-head">
              <h6><i class="bi bi-house me-1" style="color:var(--primary)"></i> Kost Saya</h6>
              <a href="{{ route('owner.kost.index') }}" class="link-p">Kelola</a>
            </div>
            @if($kosts->isEmpty())
              <div class="empty-s">
                <i class="bi bi-house-add"></i>
                Belum ada kost.<br>
                <a href="{{ route('owner.kost.create') }}" style="color:var(--primary);font-weight:600;">+ Tambah sekarang</a>
              </div>
            @else
              @foreach($kosts->take(4) as $kost)
              <div class="kost-item">
                <div class="kost-thumb">
                  @if($kost->foto_utama)
                    <img src="{{ asset('storage/'.$kost->foto_utama) }}" style="width:100%;height:100%;object-fit:cover;border-radius:.5rem;">
                  @else
                    🏠
                  @endif
                </div>
                <div style="flex:1;">
                  <div class="kost-name">{{ $kost->nama_kost }}</div>
                  <div class="kost-loc"><i class="bi bi-geo-alt" style="font-size:.65rem;"></i> {{ $kost->kota }}</div>
                </div>
                <div class="d-flex gap-1">
                  <a href="{{ route('owner.kost.edit', $kost->id_kost) }}" class="act-btn"><i class="bi bi-pencil"></i></a>
                  <form action="{{ route('owner.kost.destroy', $kost->id_kost) }}" method="POST" class="js-confirm-delete" data-delete-message="Anda yakin ingin menghapus kost ini?">
                    @csrf @method('DELETE')
                    <button class="act-btn del" type="submit"><i class="bi bi-trash"></i></button>
                  </form>
                </div>
              </div>
              @endforeach
            @endif
          </div>
        </div>
      </div>

      <div class="section-card">
        <div class="section-head">
          <h6><i class="bi bi-journal-check me-1" style="color:var(--primary)"></i> Booking Terbaru</h6>
          <a href="{{ route('owner.booking.index') }}" class="link-p">Lihat Semua</a>
        </div>
        <div class="table-responsive">
          <table class="table mb-0">
            <thead>
              <tr>
                <th>PENYEWA</th><th>KOST</th><th>KAMAR</th>
                <th>TANGGAL MASUK</th><th>DURASI</th><th>STATUS</th>
              </tr>
            </thead>
            <tbody>
              @if(isset($bookings) && $bookings->count() > 0)
                @foreach($bookings as $b)
                <tr>
                  <td class="fw-semibold">{{ $b->user->name }}</td>
                  <td>{{ $b->room->kost->nama_kost }}</td>
                  <td>No. {{ $b->room->nomor_kamar }}</td>
                  <td>{{ \Carbon\Carbon::parse($b->tanggal_masuk)->format('d M Y') }}</td>
                  <td>{{ $b->durasi_sewa }} bulan</td>
                  <td>
                    <span class="s-pill s-{{ $b->status_booking }}">
                      <i class="bi bi-circle-fill" style="font-size:.35rem;"></i>
                      {{ ucfirst($b->status_booking) }}
                    </span>
                  </td>
                </tr>
                @endforeach
              @else
                <tr><td colspan="6"><div class="empty-s"><i class="bi bi-inbox"></i>Belum ada booking</div></td></tr>
              @endif
            </tbody>
          </table>
        </div>
      </div>

    </div>

    <footer class="owner-footer">
      © {{ date('Y') }} KostFinder — Panel Pemilik Kost. All rights reserved.
    </footer>
  </div>

  <script>
    function toggleSidebar() {
      const s = document.getElementById('sidebar');
      const m = document.getElementById('mainContent');
      s.classList.toggle('collapsed');
      m.classList.toggle('collapsed');
    }
    const ctx = document.getElementById('bookingChart').getContext('2d');
    new Chart(ctx, {
      type: 'line',
      data: {
        labels: ['Sep','Okt','Nov','Des','Jan','Feb'],
        datasets: [{
          label: 'Booking',
          data: [0,0,0,0,0,0],
          borderColor: '#e8401c',
          backgroundColor: 'rgba(232,64,28,.08)',
          borderWidth: 2,
          pointBackgroundColor: '#e8401c',
          pointRadius: 4,
          tension: 0.4,
          fill: true,
        }]
      },
      options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
          y: { beginAtZero: true, grid: { color: '#f0f3f8' }, ticks: { font: { size: 11 } } },
          x: { grid: { display: false }, ticks: { font: { size: 11 } } }
        }
      }
    });
  </script>
</body>
</html>
