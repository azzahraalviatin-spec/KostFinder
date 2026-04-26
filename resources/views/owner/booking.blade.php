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
    .topbar-right { display:flex; align-items:center; gap:.6rem; }
    .icon-btn { width:34px; height:34px; border-radius:.5rem; background:#f0f4f8; border:1px solid #dde3ed; display:flex; align-items:center; justify-content:center; color:#555; font-size:.9rem; cursor:pointer; text-decoration:none; }
    .content { padding:1.5rem; flex:1; }
    .owner-footer { background:#fff; border-top:1px solid #e4e9f0; padding:.8rem 1.5rem; text-align:center; color:#8fa3b8; font-size:.72rem; }

    /* STAT CARDS */
    .stat-grid { display:grid; grid-template-columns:repeat(5,1fr); gap:1rem; margin-bottom:1.5rem; }
    .stat-card { border-radius:16px; padding:1.1rem 1.25rem; display:flex; align-items:center; gap:1rem; position:relative; overflow:hidden; }
    .stat-card::after { content:''; position:absolute; right:-16px; top:-16px; width:80px; height:80px; border-radius:50%; opacity:.12; background:#fff; }
    .stat-card.total  { background:linear-gradient(135deg,#1e2d3d,#2d4a6b); }
    .stat-card.pending { background:linear-gradient(135deg,#f97316,#fb923c); }
    .stat-card.diterima { background:linear-gradient(135deg,#16a34a,#22c55e); }
    .stat-card.ditolak { background:linear-gradient(135deg,#dc2626,#ef4444); }
    .stat-card.selesai { background:linear-gradient(135deg,#64748b,#94a3b8); }
    .stat-icon-wrap { width:44px; height:44px; border-radius:12px; background:rgba(255,255,255,.18); display:flex; align-items:center; justify-content:center; font-size:1.2rem; color:#fff; flex-shrink:0; }
    .stat-num { font-size:1.8rem; font-weight:800; color:#fff; line-height:1; }
    .stat-lbl { font-size:.72rem; color:rgba(255,255,255,.75); margin-top:3px; font-weight:500; }

    /* TABLE */
    .table-section { background:#fff; border-radius:16px; border:1px solid #e4e9f0; overflow:hidden; }
    .table-header { padding:1rem 1.25rem; border-bottom:1px solid #f0f4f8; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:.75rem; }
    .table-title { font-size:.92rem; font-weight:800; color:var(--dark); display:flex; align-items:center; gap:.5rem; }
    .table-title-dot { width:8px; height:8px; border-radius:50%; background:var(--primary); }
    .filter-wrap { display:flex; gap:.4rem; flex-wrap:wrap; }
    .fpill {
  padding: .38rem 1rem;
  border-radius: 999px;
  font-size: .72rem;
  font-weight: 600;
  border: 1px solid #e5eaf1;
  background: #fff;
  color: #64748b;
  cursor: pointer;
  transition: all .22s ease;
}

/* HOVER */
.fpill:hover {
  background: #f8fafc;
  transform: translateY(-1px);
  box-shadow: 0 4px 10px rgba(0,0,0,.05);
}

/* ACTIVE BASE */
.fpill.active {
  color: #fff;
  border: none;
  box-shadow: 0 6px 16px rgba(0,0,0,.12);
  transform: translateY(-1px);
}

/* WARNA PER STATUS */
.fpill.active.f-semua {
  background: linear-gradient(135deg,#1e293b,#334155);
}

.fpill.active.f-pending {
  background: linear-gradient(135deg,#f97316,#fb923c);
}

.fpill.active.f-diterima {
  background: linear-gradient(135deg,#16a34a,#22c55e);
}

.fpill.active.f-ditolak {
  background: linear-gradient(135deg,#dc2626,#ef4444);
}

.fpill.active.f-selesai {
  background: linear-gradient(135deg,#64748b,#94a3b8);
}
.fpill.active.f-dibatalkan {
  background: linear-gradient(135deg,#94a3b8,#cbd5e1);
}
.filter-wrap {
  display: flex;
  gap: .5rem;
  flex-wrap: wrap;
  background: #f1f5f9;
  padding: .35rem;
  border-radius: 999px;
}
table { width:100%; border-collapse:collapse; }
    thead th { font-size:.67rem; font-weight:700; color:#94a3b8; letter-spacing:.06em; padding:.65rem 1rem; background:#f8fafd; border-bottom:1px solid #f0f4f8; text-transform:uppercase; }
    tbody td { font-size:.8rem; color:#334155; padding:.8rem 1rem; border-bottom:1px solid #f8fafd; vertical-align:middle; }
    tbody tr:last-child td { border-bottom:0; }
    tbody tr:hover td { background:#fafbfe; }
    .avatar-circle { width:34px; height:34px; border-radius:50%; color:#fff; font-weight:700; font-size:.78rem; flex-shrink:0; display:flex; align-items:center; justify-content:center; }
    .sbadge { padding:.28rem .85rem; border-radius:99px; font-size:.7rem; font-weight:700; display:inline-flex; align-items:center; gap:.35rem; }
    .sbadge-pending { background:#fff7ed; color:#ea580c; }
    .sbadge-diterima { background:#f0fdf4; color:#16a34a; }
    .sbadge-ditolak { background:#fef2f2; color:#dc2626; }
    .sbadge-selesai { background:#f1f5f9; color:#64748b; }
    .sbadge-dibatalkan { background:#f8fafc; color:#94a3b8; }
    .sbadge-dot { width:6px; height:6px; border-radius:50%; flex-shrink:0; }
    .sbadge-pending .sbadge-dot { background:#ea580c; }
    .sbadge-diterima .sbadge-dot { background:#16a34a; }
    .sbadge-ditolak .sbadge-dot { background:#dc2626; }
    .sbadge-selesai .sbadge-dot { background:#94a3b8; }
    .sbadge-dibatalkan .sbadge-dot { background:#cbd5e1; }
    .aksi-wrap { display:flex; gap:.35rem; }
    .abtn { width:32px; height:32px; border-radius:9px; border:0; display:inline-flex; align-items:center; justify-content:center; font-size:.82rem; cursor:pointer; transition:all .15s; }
    .abtn:hover { transform:translateY(-1px); }
    .abtn-terima { background:#dcfce7; color:#16a34a; }
    .abtn-tolak { background:#fee2e2; color:#dc2626; }
    .abtn-selesai { background:#f1f5f9; color:#475569; }
    .abtn-detail { background:#e0f2fe; color:#0369a1; }
    .empty-wrap { padding:3.5rem 1rem; text-align:center; color:#94a3b8; }
    .empty-wrap i { font-size:3rem; opacity:.2; display:block; margin-bottom:.75rem; }
  </style>
</head>
<body>
  @include('owner._sidebar')
  <div class="main" id="mainContent">
    @include('owner._navbar')
    <div class="content">

      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4 rounded-3">
          <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      @endif

      <div class="mb-4">
        <h5 class="fw-bold mb-0" style="color:var(--dark);">Kelola Booking</h5>
        <p class="text-muted small mb-0">Pantau dan kelola semua permintaan booking kos Anda</p>
      </div>

      {{-- STAT CARDS --}}
      <div class="stat-grid">
        <div class="stat-card total">
          <div class="stat-icon-wrap"><i class="bi bi-journal-check"></i></div>
          <div>
            <div class="stat-num">{{ $allBookings->count() }}</div>
            <div class="stat-lbl">Total Booking</div>
          </div>
        </div>
        <div class="stat-card pending">
          <div class="stat-icon-wrap"><i class="bi bi-clock-history"></i></div>
          <div>
            <div class="stat-num">{{ $allBookings->where('status_booking','pending')->count() }}</div>
            <div class="stat-lbl">Menunggu</div>
          </div>
        </div>
        <div class="stat-card diterima">
          <div class="stat-icon-wrap"><i class="bi bi-check-circle"></i></div>
          <div>
            <div class="stat-num">{{ $allBookings->where('status_booking','diterima')->count() }}</div>
            <div class="stat-lbl">Diterima</div>
          </div>
        </div>
        <div class="stat-card ditolak">
          <div class="stat-icon-wrap"><i class="bi bi-x-circle"></i></div>
          <div>
            <div class="stat-num">{{ $allBookings->whereIn('status_booking',['ditolak','dibatalkan'])->count() }}</div>
            <div class="stat-lbl">Batal/Tolak</div>
          </div>
        </div>
        <div class="stat-card selesai">
          <div class="stat-icon-wrap"><i class="bi bi-flag"></i></div>
          <div>
            <div class="stat-num">{{ $allBookings->where('status_booking','selesai')->count() }}</div>
            <div class="stat-lbl">Selesai</div>
          </div>
        </div>
      </div>

      {{-- TABLE --}}
      <div class="table-section">
        <div class="table-header">
          <div class="table-title">
            <div class="table-title-dot"></div>
            Daftar Booking
          </div>
          <div class="filter-wrap">
          <a href="?status=semua" class="fpill f-semua {{ $activeStatus=='semua'?'active':'' }}">Semua</a>

<a href="?status=pending" class="fpill f-pending {{ $activeStatus=='pending'?'active':'' }}">Pending</a>
<a href="?status=diterima" class="fpill f-diterima {{ $activeStatus=='diterima'?'active':'' }}">Diterima</a>
<a href="?status=ditolak" class="fpill f-ditolak {{ $activeStatus=='ditolak'?'active':'' }}">Ditolak</a>
<a href="?status=dibatalkan" class="fpill f-dibatalkan {{ $activeStatus=='dibatalkan'?'active':'' }}">Dibatalkan</a>
<a href="?status=selesai" class="fpill f-selesai {{ $activeStatus=='selesai'?'active':'' }}">Selesai</a>
 </div>
        </div>
        <div style="overflow-x:auto;">
          <table>
            <thead>
              <tr>
                <th>#</th>
                <th>Penyewa</th>
                <th>Kost &amp; Kamar</th>
                <th>Tgl Masuk</th>
                <th>Durasi</th>
                <th>Total</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($bookings as $i => $booking)
              <tr class="booking-row" data-status="{{ $booking->status_booking }}">
                <td style="color:#94a3b8;font-weight:600;">{{ $i + 1 }}</td>
                <td>
                  <div style="display:flex;align-items:center;gap:.6rem;">
                    @php
                      $colors = ['#e8401c','#3b82f6','#8b5cf6','#10b981','#f59e0b','#ec4899'];
                      $cl = $colors[ord(strtoupper(substr($booking->user->name ?? 'U',0,1))) % count($colors)];
                    @endphp
                    <div class="avatar-circle" style="background:{{ $cl }};">{{ strtoupper(substr($booking->user->name ?? 'U',0,1)) }}</div>
                    <div>
                      <div style="font-weight:600;font-size:.82rem;color:#1e293b;">{{ $booking->user->name ?? '-' }}</div>
                      <div style="font-size:.7rem;color:#94a3b8;">{{ $booking->user->email ?? '-' }}</div>
                    </div>
                  </div>
                </td>
                <td>
                  <div style="font-weight:600;font-size:.82rem;color:#1e293b;">{{ $booking->room->kost->nama_kost ?? '-' }}</div>
                  <div style="font-size:.7rem;color:#94a3b8;">Kamar {{ $booking->room->nomor_kamar ?? '-' }}</div>
                </td>
                <td>{{ \Carbon\Carbon::parse($booking->tanggal_masuk)->format('d M Y') }}</td>
                <td>
                  <span style="font-size:.78rem;background:#f1f5f9;color:#475569;padding:3px 10px;border-radius:99px;font-weight:600;">
                    {{ $booking->durasi_sewa }} {{ isset($booking->tipe_sewa) && $booking->tipe_sewa==='harian' ? 'hari' : 'bln' }}
                  </span>
                </td>
                <td style="font-weight:700;color:var(--primary);font-size:.85rem;">
                  Rp {{ number_format($booking->total_bayar ?? 0,0,',','.') }}
                </td>
                <td>
                  <span class="sbadge sbadge-{{ $booking->status_booking }}">
                    <span class="sbadge-dot"></span>
                    @if($booking->status_booking === 'ditolak')
                      Ditolak Owner
                    @elseif($booking->status_booking === 'dibatalkan')
                      Dibatalkan User
                    @else
                      {{ ucfirst($booking->status_booking) }}
                    @endif
                  </span>
                </td>
                <td>
                  <div class="aksi-wrap">
                    @if($booking->status_booking == 'pending')
                      <form action="{{ route('owner.booking.terima',$booking->id_booking) }}" method="POST">
                        @csrf @method('PATCH')
                        <button type="submit" class="abtn abtn-terima" title="Terima"><i class="bi bi-check-lg"></i></button>
                      </form>
                      <form action="{{ route('owner.booking.tolak',$booking->id_booking) }}" method="POST" class="js-tolak">
                        @csrf @method('PATCH')
                        <button type="submit" class="abtn abtn-tolak" title="Tolak"><i class="bi bi-x-lg"></i></button>
                      </form>
                    @elseif($booking->status_booking == 'diterima')
                      <form action="{{ route('owner.booking.selesai',$booking->id_booking) }}" method="POST" class="js-selesai">
                        @csrf @method('PATCH')
                        <button type="submit" class="abtn abtn-selesai" title="Selesai"><i class="bi bi-check2-all"></i></button>
                      </form>
                    @endif
                    <a href="{{ route('owner.booking.show', $booking->id_booking) }}" 
   class="abtn abtn-detail" 
   title="Detail">
  <i class="bi bi-eye"></i>
</a>
                  </div>


              
                </td>
              </tr>
              @empty
              <tr><td colspan="8">
                <div class="empty-wrap">
                  <i class="bi bi-inbox"></i>
                  <p style="font-size:.85rem;">Belum ada booking masuk</p>
                </div>
              </td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <footer class="owner-footer">&copy; {{ date('Y') }} KostFinder &mdash; Panel Pemilik Kost. All rights reserved.</footer>
  </div>

  {{-- MODAL DETAIL --}}
  <div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content rounded-4 border-0 shadow-lg">
        <div class="modal-header" style="border-bottom:1px solid #f0f4f8;padding:1rem 1.25rem;">
          <div style="display:flex;align-items:center;gap:.5rem;">
            <div style="width:8px;height:8px;border-radius:50%;background:var(--primary);"></div>
            <h6 class="modal-title fw-bold mb-0">Detail Booking</h6>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body p-0" id="modalBody"></div>
      </div>
    </div>
  </div>

  {{-- MODAL TOLAK --}}
  <div class="modal fade" id="tolakModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
      <div class="modal-content rounded-4 border-0 shadow">
        <div class="modal-body text-center p-4">
          <div style="width:56px;height:56px;border-radius:50%;background:#fee2e2;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;">
            <i class="bi bi-x-lg" style="font-size:1.4rem;color:#dc2626;"></i>
          </div>
          <h6 class="fw-bold mb-1">Tolak Booking?</h6>
          <p class="text-muted small mb-3">Permintaan booking ini akan ditolak.</p>
          <div class="d-flex gap-2">
            <button class="btn btn-sm btn-light rounded-3 flex-fill fw-semibold" data-bs-dismiss="modal">Batal</button>
            <button class="btn btn-sm btn-danger rounded-3 flex-fill fw-semibold" id="tolakConfirmBtn">Ya, Tolak</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- MODAL SELESAI --}}
  <div class="modal fade" id="selesaiModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
      <div class="modal-content rounded-4 border-0 shadow">
        <div class="modal-body text-center p-4">
          <div style="width:56px;height:56px;border-radius:50%;background:#dcfce7;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;">
            <i class="bi bi-check2-all" style="font-size:1.4rem;color:#16a34a;"></i>
          </div>
          <h6 class="fw-bold mb-1">Tandai Selesai?</h6>
          <p class="text-muted small mb-3">Booking ini akan ditandai sebagai selesai.</p>
          <div class="d-flex gap-2">
            <button class="btn btn-sm btn-light rounded-3 flex-fill fw-semibold" data-bs-dismiss="modal">Batal</button>
            <button class="btn btn-sm rounded-3 flex-fill fw-semibold" style="background:#16a34a;color:#fff;" id="selesaiConfirmBtn">Ya, Selesai</button>
          </div>
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
  
    let tolakForm = null;
    document.querySelectorAll('.js-tolak').forEach(f => {
      f.addEventListener('submit', function(e) { e.preventDefault(); tolakForm=this; new bootstrap.Modal(document.getElementById('tolakModal')).show(); });
    });
    document.getElementById('tolakConfirmBtn').addEventListener('click', () => { if(tolakForm) tolakForm.submit(); });

    let selesaiForm = null;
    document.querySelectorAll('.js-selesai').forEach(f => {
      f.addEventListener('submit', function(e) { e.preventDefault(); selesaiForm=this; new bootstrap.Modal(document.getElementById('selesaiModal')).show(); });
    });
    document.getElementById('selesaiConfirmBtn').addEventListener('click', () => { if(selesaiForm) selesaiForm.submit(); });

   
  </script>
</body>
</html>