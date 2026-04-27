@extends('layouts.owner')

@section('title', 'Kelola Booking')

@push('styles')
<style>
    /* STAT CARDS (Square Style) */
    .stat-grid { display:grid; grid-template-columns:repeat(5, 1fr); gap:.75rem; margin-bottom:1.5rem; }
    .stat-card { border-radius:12px; padding:1.2rem .5rem; display:flex; flex-direction:column; align-items:center; justify-content:center; gap:.6rem; position:relative; overflow:hidden; transition: transform .2s; min-height: 110px; text-align: center; }
    .stat-card:hover { transform: translateY(-3px); box-shadow: 0 4px 15px rgba(0,0,0,.1); }
    .stat-card::after { content:''; position:absolute; right:-5px; top:-5px; width:45px; height:45px; border-radius:50%; opacity:.1; background:#fff; }
    
    .stat-card.total  { background:linear-gradient(135deg,#1e2d3d,#2d4a6b); }
    .stat-card.pending { background:linear-gradient(135deg,#f59e0b,#fb923c); }
    .stat-card.diterima { background:linear-gradient(135deg,#10b981,#34d399); }
    .stat-card.selesai { background:linear-gradient(135deg,#64748b,#94a3b8); }
    .stat-card.income { background:linear-gradient(135deg,#e8401c,#ff7043); }

    .stat-icon-wrap { width:36px; height:36px; border-radius:10px; background:rgba(255,255,255,.15); display:flex; align-items:center; justify-content:center; font-size:1.1rem; color:#fff; flex-shrink:0; }
    .stat-num { font-size:1.3rem; font-weight:800; color:#fff; line-height:1.1; word-break: break-all; }
    .stat-lbl { font-size:.68rem; color:rgba(255,255,255,.85); font-weight:600; margin-top:2px; }

    /* TABLE STYLES */
    .table-section { background:#fff; border-radius:16px; border:1px solid #e4e9f0; overflow:hidden; }
    .table-header { padding:1.2rem 1.5rem; border-bottom:1px solid #f0f4f8; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:1rem; }
    .table-title { font-size:.95rem; font-weight:800; color:var(--dark); display:flex; align-items:center; gap:.6rem; }
    .table-title-dot { width:8px; height:8px; border-radius:50%; background:var(--primary); }
    
    .filter-wrap { display:flex; gap:.4rem; flex-wrap:wrap; background:#f1f5f9; padding:.4rem; border-radius:99px; }
    .fpill { padding:.4rem 1.1rem; border-radius:99px; font-size:.75rem; font-weight:700; color:#64748b; text-decoration:none; transition:.2s; }
    .fpill:hover { color:var(--dark); background:rgba(0,0,0,.03); }
    .fpill.active { color:#fff; box-shadow:0 4px 12px rgba(0,0,0,.12); }
    .fpill.active.f-semua { background:#1e2d3d; }
    .fpill.active.f-pending { background:#f59e0b; }
    .fpill.active.f-diterima { background:#10b981; }
    .fpill.active.f-ditolak { background:#ef4444; }
    .fpill.active.f-selesai { background:#64748b; }
    .fpill.active.f-dibatalkan { background:#94a3b8; }

    table { width:100%; border-collapse:collapse; }
    thead th { font-size:.68rem; font-weight:800; color:#94a3b8; letter-spacing:.08em; padding:1rem; background:#f8fafd; border-bottom:1px solid #f0f4f8; text-transform:uppercase; }
    tbody td { font-size:.82rem; color:#334155; padding:1rem; border-bottom:1px solid #f8fafd; vertical-align:middle; }
    
    .avatar-circle { width:34px; height:34px; border-radius:50%; color:#fff; font-weight:700; font-size:.78rem; display:flex; align-items:center; justify-content:center; }
    .sbadge { padding:.3rem .9rem; border-radius:99px; font-size:.7rem; font-weight:700; display:inline-flex; align-items:center; gap:.4rem; }
    .sbadge-pending { background:#fff7ed; color:#ea580c; }
    .sbadge-diterima { background:#f0fdf4; color:#16a34a; }
    .sbadge-ditolak { background:#fef2f2; color:#dc2626; }
    .sbadge-selesai { background:#f1f5f9; color:#64748b; }
    .sbadge-dibatalkan { background:#f8fafc; color:#94a3b8; }
    .sbadge-dot { width:6px; height:6px; border-radius:50%; background:currentColor; }

    .aksi-wrap { display:flex; gap:.4rem; }
    .abtn { width:32px; height:32px; border-radius:10px; border:0; display:flex; align-items:center; justify-content:center; font-size:.85rem; cursor:pointer; transition:.15s; }
    .abtn:hover { transform:translateY(-2px); filter:brightness(.95); }
    .abtn-terima { background:#dcfce7; color:#16a34a; }
    .abtn-tolak { background:#fee2e2; color:#dc2626; }
    .abtn-selesai { background:#f1f5f9; color:#475569; }
    .abtn-detail { background:#e0f2fe; color:#0369a1; }
</style>
@endpush

@section('content')
      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4 border-0 shadow-sm" style="border-radius:12px;">
          <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      @endif

      <div class="mb-4">
        <h4 class="fw-800 mb-1" style="color:var(--dark);">Kelola Booking</h4>
        <p class="text-muted small mb-0">Monitor status dan pendapatan dari penyewaan kamar Anda</p>
      </div>

      {{-- STAT CARDS (5 Squares) --}}
      <div class="stat-grid">
        <div class="stat-card total">
          <div class="stat-icon-wrap"><i class="bi bi-journal-text"></i></div>
          <div class="stat-num">{{ $allBookings->count() }}</div>
          <div class="stat-lbl">Total</div>
        </div>
        <div class="stat-card pending">
          <div class="stat-icon-wrap"><i class="bi bi-hourglass-split"></i></div>
          <div class="stat-num">{{ $allBookings->where('status_booking','pending')->count() }}</div>
          <div class="stat-lbl">Pending</div>
        </div>
        <div class="stat-card diterima">
          <div class="stat-icon-wrap"><i class="bi bi-check2-circle"></i></div>
          <div class="stat-num">{{ $allBookings->where('status_booking','diterima')->count() }}</div>
          <div class="stat-lbl">Diterima</div>
        </div>
        <div class="stat-card selesai">
          <div class="stat-icon-wrap"><i class="bi bi-flag-fill"></i></div>
          <div class="stat-num">{{ $allBookings->where('status_booking','selesai')->count() }}</div>
          <div class="stat-lbl">Selesai</div>
        </div>
        <div class="stat-card income">
          <div class="stat-icon-wrap"><i class="bi bi-wallet2"></i></div>
          <div class="stat-num" style="font-size:1.05rem;">Rp{{ number_format($allBookings->where('status_booking','selesai')->sum('pendapatan_owner'),0,',','.') }}</div>
          <div class="stat-lbl">Pendapatan</div>
        </div>
      </div>

      {{-- TABLE SECTION --}}
      <div class="table-section shadow-sm">
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
            <a href="?status=selesai" class="fpill f-selesai {{ $activeStatus=='selesai'?'active':'' }}">Selesai</a>
          </div>
        </div>

        <div style="overflow-x:auto;">
          <table>
            <thead>
              <tr>
                <th style="width:50px; text-align:center;">#</th>
                <th>Penyewa & Kamar</th>
                <th>Durasi</th>
                <th>Total Bayar</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($bookings as $i => $booking)
                <tr>
                  <td style="text-align:center; color:var(--muted); font-weight:700;">{{ $i + 1 }}</td>
                  <td>
                    <div class="d-flex align-items-center gap-3">
                      <div class="avatar-circle" style="background:hsl({{ ($booking->user_id * 40) % 360 }}, 60%, 50%)">
                        {{ strtoupper(substr($booking->user->name ?? 'U', 0, 1)) }}
                      </div>
                      <div>
                        <div class="fw-bold text-dark">{{ $booking->user->name ?? 'User' }}</div>
                        <div class="text-muted small">Kamar {{ $booking->room->nomor_kamar ?? '-' }}</div>
                      </div>
                    </div>
                  </td>
                  <td>
                    <div class="fw-600">{{ $booking->jumlah_durasi }} {{ ucfirst($booking->tipe_durasi) }}</div>
                    <div class="text-muted small">{{ $booking->tanggal_masuk->format('d M') }} - {{ $booking->tanggal_selesai->format('d M Y') }}</div>
                  </td>
                  <td>
                    <div class="fw-bold text-dark">Rp{{ number_format($booking->total_bayar, 0, ',', '.') }}</div>
                    <div class="text-muted small">Via {{ $booking->metode_pembayaran ?: '-' }}</div>
                  </td>
                  <td>
                    <span class="sbadge sbadge-{{ $booking->status_booking }}">
                      <div class="sbadge-dot"></div>
                      {{ ucfirst($booking->status_booking) }}
                    </span>
                  </td>
                  <td>
                    <div class="aksi-wrap">
                      @if($booking->status_booking === 'pending')
                        <form action="{{ route('owner.booking.terima', $booking->id_booking) }}" method="POST">
                          @csrf @method('PATCH')
                          <button type="submit" class="abtn abtn-terima" title="Terima"><i class="bi bi-check-lg"></i></button>
                        </form>
                        <button type="button" class="abtn abtn-tolak js-btn-tolak" data-id="{{ $booking->id_booking }}" title="Tolak"><i class="bi bi-x-lg"></i></button>
                      @endif

                      @if($booking->status_booking === 'diterima')
                        <button type="button" class="abtn abtn-selesai js-btn-selesai" data-id="{{ $booking->id_booking }}" title="Selesai"><i class="bi bi-flag"></i></button>
                      @endif

                      <a href="{{ route('owner.booking.show', $booking->id_booking) }}" class="abtn abtn-detail" title="Detail"><i class="bi bi-eye"></i></a>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="6">
                    <div class="text-center py-5">
                      <i class="bi bi-inbox text-muted" style="font-size:3rem; opacity:.3;"></i>
                      <p class="text-muted mt-2">Belum ada data booking dengan status ini.</p>
                    </div>
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

  {{-- MODALS --}}
  <div class="modal fade" id="tolakModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <form id="tolakForm" method="POST" class="modal-content border-0 rounded-4 shadow">
        @csrf @method('PATCH')
        <div class="modal-body p-4 text-center">
          <div class="mb-3 text-danger"><i class="bi bi-exclamation-octagon" style="font-size:3.5rem;"></i></div>
          <h5 class="fw-bold">Tolak Pesanan?</h5>
          <p class="text-muted small">Berikan alasan mengapa Anda menolak pesanan ini.</p>
          <textarea name="alasan_batal" class="form-control rounded-3" rows="3" placeholder="Contoh: Kamar sedang dalam perbaikan..." required></textarea>
          <div class="d-flex gap-2 mt-4">
            <button type="button" class="btn btn-light w-100 fw-bold py-2" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-danger w-100 fw-bold py-2">Ya, Tolak</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <div class="modal fade" id="selesaiModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <form id="selesaiForm" method="POST" class="modal-content border-0 rounded-4 shadow">
        @csrf @method('PATCH')
        <div class="modal-body p-4 text-center">
          <div class="mb-3 text-success"><i class="bi bi-check2-circle" style="font-size:3.5rem;"></i></div>
          <h5 class="fw-bold">Tandai Selesai?</h5>
          <p class="text-muted small">Pesanan akan dianggap selesai dan pendapatan akan dicatat ke dalam sistem.</p>
          <div class="d-flex gap-2 mt-4">
            <button type="button" class="btn btn-light w-100 fw-bold py-2" data-bs-dismiss="modal">Belum</button>
            <button type="submit" class="btn btn-success w-100 fw-bold py-2">Ya, Selesai</button>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.js-btn-tolak').forEach(btn => {
      btn.addEventListener('click', function() {
        const id = this.dataset.id;
        document.getElementById('tolakForm').action = `/owner/booking/${id}/tolak`;
        new bootstrap.Modal(document.getElementById('tolakModal')).show();
      });
    });

    document.querySelectorAll('.js-btn-selesai').forEach(btn => {
      btn.addEventListener('click', function() {
        const id = this.dataset.id;
        document.getElementById('selesaiForm').action = `/owner/booking/${id}/selesai`;
        new bootstrap.Modal(document.getElementById('selesaiModal')).show();
      });
    });
</script>
@endpush