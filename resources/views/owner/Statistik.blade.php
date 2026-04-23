<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Statistik - KostFinder</title>
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
    .main { margin-left:var(--sidebar-w); flex:1; transition:margin-left .3s ease; display:flex; flex-direction:column; min-height:100vh; }
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
    .content { padding:1.4rem; flex:1; }
    .stat-card { background:#fff; border-radius:.85rem; padding:1.1rem 1.2rem; border:1px solid #e4e9f0; box-shadow:0 2px 6px rgba(0,0,0,.04); display:flex; align-items:center; gap:1rem; }
    .stat-icon { width:46px; height:46px; border-radius:.75rem; display:flex; align-items:center; justify-content:center; font-size:1.2rem; flex-shrink:0; }
    .stat-num { font-size:1.5rem; font-weight:800; color:var(--dark); line-height:1; }
    .stat-lbl { font-size:.75rem; color:#8fa3b8; margin-top:.2rem; }
    .section-card { background:#fff; border-radius:.85rem; border:1px solid #e4e9f0; box-shadow:0 2px 6px rgba(0,0,0,.04); overflow:hidden; }
    .section-head { padding:.9rem 1.2rem; border-bottom:1px solid #f0f3f8; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:.5rem; }
    .section-head h6 { font-weight:700; color:var(--dark); margin:0; font-size:.87rem; }
    table thead th { font-size:.68rem; font-weight:700; color:#8fa3b8; letter-spacing:.05em; border:0; padding:.6rem 1rem; background:#f8fafd; }
    table tbody td { font-size:.8rem; color:#333; padding:.65rem 1rem; border-color:#f0f3f8; vertical-align:middle; }
    .owner-footer { background:#fff; border-top:1px solid #e4e9f0; padding:.8rem 1.5rem; text-align:center; color:#8fa3b8; font-size:.72rem; margin-top:auto; }
    .progress { height:8px; border-radius:999px; }
    .progress-bar { background:var(--primary); border-radius:999px; }

    /* Filter tahun */
    .filter-tahun { display:flex; align-items:center; gap:.5rem; }
    .filter-tahun select { font-size:.8rem; font-weight:600; border:1.5px solid #e4e9f0; border-radius:.5rem; padding:.3rem .7rem; color:var(--dark); background:#f8fafd; cursor:pointer; outline:none; }
    .filter-tahun select:focus { border-color:var(--primary); }

    /* Donut center text */
    .donut-wrap { position:relative; display:flex; justify-content:center; align-items:center; }
    .donut-center { position:absolute; text-align:center; pointer-events:none; }
    .donut-center .num { font-size:1.4rem; font-weight:800; color:var(--dark); line-height:1; }
    .donut-center .lbl { font-size:.65rem; color:#8fa3b8; margin-top:.15rem; }

    /* Legend kamar */
    .kamar-legend { display:flex; flex-direction:column; gap:.5rem; margin-top:1rem; }
    .kamar-legend-item { display:flex; justify-content:space-between; align-items:center; font-size:.8rem; }
    .kamar-legend-dot { width:10px; height:10px; border-radius:50%; flex-shrink:0; }
    .stat-card {
  transition: all .25s ease;
  cursor: pointer;
}

.stat-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 12px 24px rgba(0,0,0,.08);
}

 </style>
</head>
<body>

  @include('owner._sidebar')

  <div class="main" id="mainContent">
    @include('owner._navbar')

    <div class="content">

      {{-- FILTER TAHUN --}}
      <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <div>
          <div style="font-size:.95rem;font-weight:800;color:var(--dark);">📊 Statistik Kost</div>
          <div style="font-size:.75rem;color:#8fa3b8;">Data tahun {{ $tahun }}</div>
        </div>
        <div class="d-flex align-items-center gap-2">
  <form method="GET" action="{{ route('owner.statistik') }}" class="filter-tahun">
    <i class="bi bi-calendar3" style="color:#8fa3b8;font-size:.85rem;"></i>
    <select name="tahun" onchange="this.form.submit()">
      @foreach($daftarTahun as $t)
        <option value="{{ $t }}" {{ $t == $tahun ? 'selected' : '' }}>{{ $t }}</option>
      @endforeach
    </select>
  </form>

  <a href="{{ route('owner.export.excel', ['tahun' => $tahun]) }}" 
     class="btn btn-sm"
     style="background:var(--primary);color:#fff;font-weight:600;">
     <i class="bi bi-download me-1"></i> Export Excel
  </a>
</div>


      {{-- STAT CARDS --}}
      <div class="row g-3 mb-3">
        <div class="col-6 col-xl-3">
          <div class="stat-card">
          <div class="stat-icon" style="background:#ecfdf5;color:#22c55e;"></div>

            <div>
              <div class="stat-num" style="font-size:1rem;">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
              <div class="stat-lbl">Pendapatan {{ $tahun }}</div>
            </div>
          </div>
        </div>
        <div class="col-6 col-xl-3">
          <div class="stat-card">
          <div class="stat-icon" style="background:#eff6ff;color:#3b82f6;">📋</div>

            <div>
              <div class="stat-num">{{ $totalBooking }}</div>
              <div class="stat-lbl">Booking {{ $tahun }}</div>
            </div>
          </div>
        </div>
        <div class="col-6 col-xl-3">
          <div class="stat-card">
          <div class="stat-icon" style="background:#fff7ed;color:#f97316;">🛏️</div>

            <div>
              <div class="stat-num">{{ $kamarTerisi }}</div>
              <div class="stat-lbl">Kamar Terisi</div>
            </div>
          </div>
        </div>
        <div class="col-6 col-xl-3">
          <div class="stat-card">
          <div class="stat-icon" style="background:#fefce8;color:#eab308;">🏠</div>
          <form method="GET" action="{{ route('owner.statistik') }}" class="filter-tahun">

            <div>
              <div class="stat-num">{{ $kamarTersedia }}</div>
              <div class="stat-lbl">Kamar Tersedia</div>
            </div>
          </div>
        </div>
      </div>

      <div class="row g-3 mb-3">
        {{-- GRAFIK BOOKING --}}
        <div class="col-12 col-lg-8">
          <div class="section-card">
            <div class="section-head">
              <h6><i class="bi bi-graph-up me-1" style="color:var(--primary)"></i> Grafik Booking {{ $tahun }}</h6>
            </div>
            <div class="p-3">
              <canvas id="bookingChart" height="100"></canvas>
            </div>
          </div>
        </div>
        {{-- INSIGHT CEPAT --}}
<div class="row g-3 mb-3">
  <div class="col-12">
    <div class="section-card p-3 d-flex justify-content-between flex-wrap gap-3">

      <div>
        <div style="font-size:.7rem;color:#8fa3b8;">📈 Bulan Terlaris</div>
        <div style="font-weight:700;color:var(--dark);">
          {{ $bulanTerlaris ?? '-' }}
        </div>
      </div>

      <div>
        <div style="font-size:.7rem;color:#8fa3b8;">📊 Rata-rata Booking</div>
        <div style="font-weight:700;color:var(--dark);">
          {{ $rataBooking ?? 0 }}/bulan
        </div>
      </div>

      <div>
        <div style="font-size:.7rem;color:#8fa3b8;">🔥 Performa</div>
        <div style="font-weight:700;color:var(--primary);">
          {{ $performa ?? 'Stabil' }}
        </div>
      </div>

    </div>
  </div>
</div>


        {{-- DONUT KAMAR --}}
        <div class="col-12 col-lg-4">
          <div class="section-card h-100">
            <div class="section-head">
              <h6><i class="bi bi-door-open me-1" style="color:var(--primary)"></i> Status Kamar</h6>
            </div>
            <div class="p-3">
              @php $totalKamar = $kamarTerisi + $kamarTersedia; @endphp

              @if($totalKamar > 0)
                <div class="donut-wrap">
                  <canvas id="kamarChart" height="200"></canvas>
                  <div class="donut-center">
  <div class="num">
    {{ $totalKamar > 0 ? round($kamarTerisi / $totalKamar * 100) : 0 }}%
  </div>
  <div class="lbl">Terisi</div>
</div>

                </div>
              @else
                <div class="text-center py-4 text-muted" style="font-size:.82rem;">
                  <i class="bi bi-door-closed fs-3 d-block mb-2 opacity-25"></i>
                  Belum ada kamar
                </div>
              @endif

              <div class="kamar-legend">
                <div class="kamar-legend-item">
                  <div class="d-flex align-items-center gap-2">
                    <div class="kamar-legend-dot" style="background:#e8401c;"></div>
                    <span style="color:#555;">Terisi</span>
                  </div>
                  <span style="font-weight:700;color:#e8401c;">{{ $kamarTerisi }} kamar</span>
                </div>
                <div class="kamar-legend-item">
                  <div class="d-flex align-items-center gap-2">
                    <div class="kamar-legend-dot" style="background:#22c55e;"></div>
                    <span style="color:#555;">Tersedia</span>
                  </div>
                  <span style="font-weight:700;color:#22c55e;">{{ $kamarTersedia }} kamar</span>
                </div>
                @if($totalKamar > 0)
                  <div class="mt-1 p-2 rounded-2" style="background:#f8fafd;font-size:.75rem;color:#555;text-align:center;">
                    Tingkat hunian: <strong style="color:var(--primary);">{{ $totalKamar > 0 ? round($kamarTerisi / $totalKamar * 100) : 0 }}%</strong>
                  </div>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- KOST TERPOPULER --}}
      <div class="section-card mb-3">
        <div class="section-head">
          <h6><i class="bi bi-trophy me-1" style="color:var(--primary)"></i> Kost Paling Banyak Dipesan — {{ $tahun }}</h6>
        </div>
        @if($kostPopuler->isEmpty() || $kostPopuler->sum('total_booking') == 0)
          <div class="text-center py-4 text-muted" style="font-size:.82rem;">
            <i class="bi bi-bar-chart fs-3 d-block mb-2 opacity-25"></i>
            Belum ada data booking di tahun {{ $tahun }}
          </div>
        @else
          <div class="table-responsive">
            <table class="table mb-0">
              <thead>
                <tr>
                  <th>#</th>
                  <th>NAMA KOST</th>
                  <th>KOTA</th>
                  <th>TOTAL BOOKING</th>
                  <th>POPULARITAS</th>
                </tr>
              </thead>
              <tbody>
                @foreach($kostPopuler as $i => $kost)
                  @if($kost->total_booking > 0)
                  <tr>
                    <td>
                    @if($i == 0) 🥇 <span style="color:var(--primary);font-weight:700;">Terlaris</span>

                      @elseif($i == 1) 🥈
                      @elseif($i == 2) 🥉
                      @else {{ $i + 1 }}
                      @endif
                    </td>
                    <td class="fw-semibold">{{ $kost->nama_kost }}</td>
                    <td>{{ $kost->kota }}</td>
                    <td><span class="fw-bold" style="color:var(--primary);">{{ $kost->total_booking }}</span> booking</td>
                    <td style="width:200px;">
                      <div class="progress">
                        <div class="progress-bar" style="width:{{ $kostPopuler->max('total_booking') > 0 ? ($kost->total_booking / $kostPopuler->max('total_booking') * 100) : 0 }}%"></div>
                      </div>
                    </td>
                  </tr>
                  @endif
                @endforeach
              </tbody>
            </table>
          </div>
        @endif
      </div>

    </div>

    <footer class="owner-footer">
      © {{ date('Y') }} KostFinder — Panel Pemilik Kost. All rights reserved.
    </footer>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function toggleSidebar() {
      document.getElementById('sidebar').classList.toggle('collapsed');
      document.getElementById('mainContent').classList.toggle('collapsed');
    }

    // Grafik Booking 12 Bulan
    new Chart(document.getElementById('bookingChart').getContext('2d'), {
      type: 'bar',
      data: {
        labels: @json($chartLabels),
        datasets: [{
          label: 'Booking',
          data: @json($chartData),
          backgroundColor: @json($chartData).map(v => v > 0 ? 'rgba(232,64,28,.85)' : 'rgba(228,233,240,.8)'),
          borderRadius: 6,
          borderSkipped: false,
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: { display: false },
          tooltip: {
            callbacks: {
              label: ctx => ` ${ctx.parsed.y} booking`
            }
          }
        },
        scales: {
          y: { beginAtZero: true, grid: { color: '#f0f3f8' }, ticks: { font: { size: 11 }, stepSize: 1 } },
          x: { grid: { display: false }, ticks: { font: { size: 11 } } }
        }
      }
    });

    // Donut Kamar
    @if(($kamarTerisi + $kamarTersedia) > 0)
    new Chart(document.getElementById('kamarChart').getContext('2d'), {
      type: 'doughnut',
      data: {
        labels: ['Terisi', 'Tersedia'],
        datasets: [{
          data: [{{ $kamarTerisi }}, {{ $kamarTersedia }}],
          backgroundColor: ['#e8401c', '#22c55e'],
          hoverBackgroundColor: ['#cb3518', '#16a34a'],
          borderWidth: 3,
          borderColor: '#fff',
        }]
      },
      options: {
        responsive: true,
        cutout: '72%',
        plugins: {
          legend: { display: false },
          tooltip: {
            callbacks: {
              label: ctx => ` ${ctx.label}: ${ctx.parsed} kamar`
            }
          }
        }
      }
    });
    @endif
  </script>
</body>
</html>