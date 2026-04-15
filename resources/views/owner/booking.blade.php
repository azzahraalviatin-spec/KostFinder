<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kelola Booking - KostFinder</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
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
    .content { padding:1.4rem; flex:1; }
    .section-card { background:#fff; border-radius:.85rem; border:1px solid #e4e9f0; box-shadow:0 2px 6px rgba(0,0,0,.04); overflow:hidden; }
    .section-head { padding:.9rem 1.2rem; border-bottom:1px solid #f0f3f8; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:.5rem; }
    .section-head h6 { font-weight:700; color:var(--dark); margin:0; font-size:.87rem; }
    table thead th { font-size:.68rem; font-weight:700; color:#8fa3b8; letter-spacing:.05em; border:0; padding:.6rem 1rem; background:#f8fafd; }
    table tbody td { font-size:.8rem; color:#333; padding:.65rem 1rem; border-color:#f0f3f8; vertical-align:middle; }
    .s-pill { padding:.22rem .7rem; border-radius:999px; font-size:.7rem; font-weight:600; display:inline-flex; align-items:center; gap:.25rem; }
    .s-pending { background:#fff7ed; color:#ea580c; }
    .s-diterima { background:#f0fdf4; color:#16a34a; }
    .s-ditolak { background:#fef2f2; color:#dc2626; }
    .s-selesai { background:#f0f4f8; color:#64748b; }
    .filter-btn { padding:.3rem .8rem; border-radius:.45rem; font-size:.75rem; font-weight:600; border:1px solid #e4e9f0; background:#f8fafd; color:#555; cursor:pointer; transition:all .2s; }
    .filter-btn.active, .filter-btn:hover { background:var(--primary); color:#fff; border-color:var(--primary); }
    .owner-footer { background:#fff; border-top:1px solid #e4e9f0; padding:.8rem 1.5rem; text-align:center; color:#8fa3b8; font-size:.72rem; }
    .empty-s { padding:2.5rem; text-align:center; color:#8fa3b8; font-size:.82rem; }
    .empty-s i { font-size:2rem; display:block; margin-bottom:.5rem; opacity:.3; }
    .penyewa-info { display:flex; align-items:center; gap:.6rem; }
    .penyewa-avatar { width:30px; height:30px; border-radius:50%; background:var(--primary); color:#fff; font-weight:700; font-size:.75rem; flex-shrink:0; display:flex; align-items:center; justify-content:center; }
    .stat-mini { background:#fff; border-radius:.75rem; border:1px solid #e4e9f0; padding:.8rem 1rem; display:flex; align-items:center; gap:.7rem; }
    .stat-mini-icon { width:38px; height:38px; border-radius:.6rem; display:flex; align-items:center; justify-content:center; font-size:1.1rem; flex-shrink:0; }
    .stat-mini-num { font-size:1.3rem; font-weight:800; color:var(--dark); line-height:1; }
    .stat-mini-lbl { font-size:.7rem; color:#8fa3b8; }
  </style>
</head>
<body>

  @include('owner._sidebar')

  <div class="main" id="mainContent">
    @include('owner._navbar')

    <div class="content">

      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3" style="font-size:.83rem;">
          {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      @endif

      {{-- STAT MINI --}}
      <div class="row g-3 mb-3">
        <div class="col-6 col-md-3">
          <div class="stat-mini">
            <div class="stat-mini-icon" style="background:#fff7ed;">📋</div>
            <div>
              <div class="stat-mini-num">{{ $bookings->count() }}</div>
              <div class="stat-mini-lbl">Total Booking</div>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="stat-mini">
            <div class="stat-mini-icon" style="background:#fff7ed;">⏳</div>
            <div>
              <div class="stat-mini-num">{{ $bookings->where('status_booking','pending')->count() }}</div>
              <div class="stat-mini-lbl">Pending</div>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="stat-mini">
            <div class="stat-mini-icon" style="background:#f0fdf4;">✅</div>
            <div>
              <div class="stat-mini-num">{{ $bookings->where('status_booking','diterima')->count() }}</div>
              <div class="stat-mini-lbl">Diterima</div>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="stat-mini">
            <div class="stat-mini-icon" style="background:#fef2f2;">❌</div>
            <div>
              <div class="stat-mini-num">{{ $bookings->where('status_booking','ditolak')->count() }}</div>
              <div class="stat-mini-lbl">Ditolak</div>
            </div>
          </div>
        </div>
      </div>

      {{-- TABEL BOOKING --}}
      <div class="section-card">
        <div class="section-head">
          <h6><i class="bi bi-journal-check me-1" style="color:var(--primary)"></i> Kelola Booking</h6>
          <div class="d-flex gap-1 flex-wrap">
            <button class="filter-btn active" onclick="filterBooking('semua', this)">Semua</button>
            <button class="filter-btn" onclick="filterBooking('pending', this)">Pending</button>
            <button class="filter-btn" onclick="filterBooking('diterima', this)">Diterima</button>
            <button class="filter-btn" onclick="filterBooking('ditolak', this)">Ditolak</button>
            <button class="filter-btn" onclick="filterBooking('selesai', this)">Selesai</button>
          </div>
        </div>

        <div class="table-responsive">
          <table class="table mb-0" id="bookingTable">
            <thead>
              <tr>
                <th>No</th>
                <th>PENYEWA</th>
                <th>KOST & KAMAR</th>
                <th>TANGGAL MASUK</th>
                <th>DURASI</th>
                <th>TOTAL HARGA</th>
                <th>STATUS</th>
                <th>AKSI</th>
              </tr>
            </thead>
            <tbody>
              @forelse($bookings as $i => $booking)
              <tr class="booking-row" data-status="{{ $booking->status_booking }}">
                <td>{{ $i + 1 }}</td>
                <td>
                  <div class="penyewa-info">
                    <div class="penyewa-avatar">{{ strtoupper(substr($booking->user->name ?? 'U', 0, 1)) }}</div>
                    <div>
                      <div style="font-weight:600;font-size:.82rem;">{{ $booking->user->name ?? '—' }}</div>
                      <div style="font-size:.72rem;color:#8fa3b8;">{{ $booking->user->email ?? '—' }}</div>
                    </div>
                  </div>
                </td>
                <td>
                  <div style="font-weight:600;font-size:.82rem;">{{ $booking->room->kost->nama_kost ?? '—' }}</div>
                  <div style="font-size:.72rem;color:#8fa3b8;">Kamar No. {{ $booking->room->nomor_kamar ?? '—' }}</div>
                </td>
                <td>{{ \Carbon\Carbon::parse($booking->tanggal_masuk)->format('d M Y') }}</td>
                <td>{{ $booking->durasi_sewa }} bulan</td>
                <td style="font-weight:700;color:var(--primary);">
                  Rp {{ number_format($booking->total_bayar ?? 0, 0, ',', '.') }}
                </td>
                <td>
                  <span class="s-pill s-{{ $booking->status_booking }}">
                    <i class="bi bi-circle-fill" style="font-size:.35rem;"></i>
                    {{ ucfirst($booking->status_booking) }}
                  </span>
                </td>
                <td>
                  <div class="d-flex gap-1">
                    @if($booking->status_booking == 'pending')
                      <form action="{{ route('owner.booking.terima', $booking->id_booking) }}" method="POST">
                        @csrf @method('PATCH')
                        <button class="btn btn-sm btn-success" title="Terima">
                          <i class="bi bi-check-lg"></i>
                        </button>
                      </form>
                      <form action="{{ route('owner.booking.tolak', $booking->id_booking) }}" method="POST">
                        @csrf @method('PATCH')
                        <button class="btn btn-sm btn-danger" title="Tolak" onclick="return confirm('Tolak booking ini?')">
                          <i class="bi bi-x-lg"></i>
                        </button>
                      </form>
                    @elseif($booking->status_booking == 'diterima')
                      <form action="{{ route('owner.booking.selesai', $booking->id_booking) }}" method="POST">
                        @csrf @method('PATCH')
                        <button class="btn btn-sm btn-secondary" title="Tandai Selesai" onclick="return confirm('Tandai booking ini selesai?')">
                          <i class="bi bi-check2-all"></i>
                        </button>
                      </form>
                    @else
                      <span style="font-size:.75rem;color:#8fa3b8;">—</span>
                    @endif
                    <button class="btn btn-sm btn-outline-secondary" onclick="showDetail({{ $booking->id_booking }})" title="Detail">
                      <i class="bi bi-eye"></i>
                    </button>
                  </div>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="8">
                  <div class="empty-s">
                    <i class="bi bi-inbox"></i>
                    Belum ada booking masuk
                  </div>
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

    </div>

    <footer class="owner-footer">
      © {{ date('Y') }} KostFinder — Panel Pemilik Kost. All rights reserved.
    </footer>
  </div>

  {{-- MODAL DETAIL --}}
  <div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content" style="border-radius:.85rem;border:0;">
        <div class="modal-header" style="border-bottom:1px solid #f0f3f8;">
          <h6 class="modal-title fw-bold" style="color:var(--dark);">
            <i class="bi bi-info-circle me-1" style="color:var(--primary)"></i> Detail Booking
          </h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body" id="modalBody" style="font-size:.85rem;">
          {{-- diisi via JS --}}
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function toggleSidebar() {
      document.getElementById('sidebar').classList.toggle('collapsed');
      document.getElementById('mainContent').classList.toggle('collapsed');
    }

    function filterBooking(status, btn) {
      document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      document.querySelectorAll('.booking-row').forEach(row => {
        if (status === 'semua' || row.dataset.status === status) {
          row.style.display = '';
        } else {
          row.style.display = 'none';
        }
      });
    }

    const bookingData = @json($bookingsJson);

    function showDetail(id) {
      const d = bookingData[id];
      if (!d) return;
      document.getElementById('modalBody').innerHTML = `
        <div class="row g-3">
          <div class="col-6"><div style="font-size:.7rem;color:#8fa3b8;font-weight:700;">PENYEWA</div><div class="fw-semibold">${d.penyewa}</div></div>
          <div class="col-6"><div style="font-size:.7rem;color:#8fa3b8;font-weight:700;">EMAIL</div><div>${d.email}</div></div>
          <div class="col-6"><div style="font-size:.7rem;color:#8fa3b8;font-weight:700;">TELEPON</div><div>${d.telepon}</div></div>
          <div class="col-6"><div style="font-size:.7rem;color:#8fa3b8;font-weight:700;">STATUS</div><div><span class="s-pill s-${d.status}">${d.status}</span></div></div>
          <div class="col-6"><div style="font-size:.7rem;color:#8fa3b8;font-weight:700;">KOST</div><div class="fw-semibold">${d.kost}</div></div>
          <div class="col-6"><div style="font-size:.7rem;color:#8fa3b8;font-weight:700;">KAMAR</div><div>No. ${d.kamar}</div></div>
          <div class="col-6"><div style="font-size:.7rem;color:#8fa3b8;font-weight:700;">TANGGAL MASUK</div><div>${d.masuk}</div></div>
          <div class="col-6"><div style="font-size:.7rem;color:#8fa3b8;font-weight:700;">DURASI</div><div>${d.durasi}</div></div>
          <div class="col-12"><div style="font-size:.7rem;color:#8fa3b8;font-weight:700;">CATATAN</div><div>${d.catatan}</div></div>
        </div>
      `;
      new bootstrap.Modal(document.getElementById('detailModal')).show();
    }
  </script>
</body>
</html>