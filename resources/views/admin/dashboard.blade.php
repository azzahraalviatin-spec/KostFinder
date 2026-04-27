@extends('layouts.owner')

@section('title', 'Dashboard Pemilik')

@push('styles')
<style>
    .stat-card {
      background:#fff;
      border-radius:.85rem;
      padding:1.1rem 1.2rem;
      border:1px solid #e4e9f0;
      box-shadow:0 2px 6px rgba(0,0,0,.04);
      display:flex;
      align-items:center;
      gap:1rem;
      transition: all .25s ease;
      cursor: pointer;
      height: 100%;
    }
    .stat-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 12px 25px rgba(232,64,28,0.15);
    }
    .stat-icon { width:46px; height:46px; border-radius:.75rem; display:flex; align-items:center; justify-content:center; font-size:1.2rem; flex-shrink:0; }
    .stat-num { font-size:1.6rem; font-weight:800; color:var(--dark); line-height:1; }
    .stat-lbl { font-size:.75rem; color:#8fa3b8; margin-top:.2rem; }
    .stat-sub { font-size:.7rem; font-weight:600; margin-top:.3rem; }

    /* Pendapatan bulan ini - badge live */
    .income-live-badge {
        display: inline-flex;
        align-items: center;
        gap: .3rem;
        background: #dcfce7;
        color: #15803d;
        font-size: .62rem;
        font-weight: 700;
        padding: .15rem .5rem;
        border-radius: 99px;
        margin-top: .3rem;
    }
    .income-live-dot {
        width: 6px; height: 6px;
        border-radius: 50%;
        background: #16a34a;
        animation: pulse-dot 1.5s infinite;
    }
    @keyframes pulse-dot {
        0%,100% { opacity:1; transform:scale(1); }
        50%      { opacity:.4; transform:scale(.7); }
    }

    .section-card { background:#fff; border-radius:.85rem; border:1px solid #e4e9f0; box-shadow:0 2px 6px rgba(0,0,0,.04); overflow:hidden; }
    .section-head { padding:.9rem 1.2rem; border-bottom:1px solid #f0f3f8; display:flex; justify-content:space-between; align-items:center; }
    .section-head h6 { font-weight:700; color:var(--dark); margin:0; font-size:.87rem; }
    .link-p { color:var(--primary); font-size:.78rem; font-weight:600; text-decoration:none; }
    .link-p:hover { color:#cb3518; }
    table thead th { font-size:.68rem; font-weight:700; color:#8fa3b8; letter-spacing:.05em; border:0; padding:.6rem 1rem; background:#f8fafd; }
    table tbody td { font-size:.8rem; color:#333; padding:.65rem 1rem; border-color:#f0f3f8; vertical-align:middle; }
    .s-pill { padding:.18rem .6rem; border-radius:999px; font-size:.7rem; font-weight:600; display:inline-flex; align-items:center; gap:.25rem; }
    .s-pending   { background:#fff7ed; color:#ea580c; }
    .s-diterima  { background:#f0fdf4; color:#16a34a; }
    .s-ditolak   { background:#fef2f2; color:#dc2626; }
    .s-selesai   { background:#f1f5f9; color:#64748b; }
    .kost-item { display:flex; align-items:center; gap:.8rem; padding:.75rem 1.2rem; border-bottom:1px solid #f0f3f8; }
    .kost-item:last-child { border:0; }
    .kost-thumb { width:46px; height:38px; border-radius:.5rem; background:#fff5f2; border:1px solid #ffd0c0; display:flex; align-items:center; justify-content:center; font-size:1.1rem; flex-shrink:0; }
    .kost-name { font-weight:700; font-size:.82rem; color:var(--dark); }
    .kost-loc  { font-size:.72rem; color:#8fa3b8; }
    .act-btn { width:28px; height:28px; border-radius:.4rem; border:1px solid #e4e9f0; background:#f8fafd; display:flex; align-items:center; justify-content:center; color:#666; font-size:.75rem; cursor:pointer; text-decoration:none; transition:all .15s; }
    .act-btn:hover { background:#eef1f8; }
    .act-btn.del:hover { background:#fff5f2; color:var(--primary); border-color:#ffd0c0; }
    .empty-s { padding:2rem; text-align:center; color:#8fa3b8; font-size:.82rem; }
    .empty-s i { font-size:1.8rem; display:block; margin-bottom:.4rem; opacity:.35; }
    .star-rating { display:flex; flex-direction:row-reverse; gap:4px; }
    .star-rating input { display:none; }
    .star-rating label { font-size:1.8rem; color:#d1d5db; cursor:pointer; transition:color .15s; }
    .star-rating input:checked ~ label,
    .star-rating label:hover,
    .star-rating label:hover ~ label { color:#f59e0b; }
</style>
@endpush

@section('content')

<div style="margin-bottom:1.75rem;">
  <h4 style="font-size:1.3rem;font-weight:700;color:var(--dark);margin:0;">
    Selamat datang, {{ auth()->user()->name }}! 👋
  </h4>

  {{-- Alert: Rekening belum diatur --}}
  @if(isset($total_bank_accounts) && $total_bank_accounts == 0)
    <div class="alert alert-warning border-0 shadow-sm mt-3 d-flex align-items-center"
         style="border-radius:12px; background:#fff7ed; border-left:4px solid #ea580c !important;">
      <i class="bi bi-exclamation-triangle-fill fs-4 me-3" style="color:#ea580c;"></i>
      <div>
        <div style="font-weight:800;color:#9a3412;font-size:.88rem;">Pembayaran Belum Diatur!</div>
        <div style="font-size:.78rem;color:#c2410c;">
          Anda wajib mengisi nomor rekening agar penyewa bisa melakukan pembayaran saat booking.
          <a href="{{ route('owner.pengaturan') }}?tab=pembayaran" class="fw-bold" style="color:#ea580c;text-decoration:underline;">Atur Sekarang →</a>
        </div>
      </div>
    </div>
  @endif

  {{-- Alert: Verifikasi Identitas --}}
  @php
    $user        = auth()->user();
    $statusVerif = $user->status_verifikasi_identitas ?? 'belum_ada';
  @endphp

  @if($statusVerif !== 'disetujui')
    <div class="alert border-0 shadow-sm mt-3 d-flex align-items-center"
         style="border-radius:12px;
           @if($statusVerif == 'pending') background:#eff6ff; border-left:4px solid #3b82f6 !important;
           @elseif($statusVerif == 'ditolak') background:#fef2f2; border-left:4px solid #dc2626 !important;
           @else background:#fff1f2; border-left:4px solid #f43f5e !important;
           @endif">
      @if($statusVerif == 'pending')
        <i class="bi bi-hourglass-split fs-4 me-3" style="color:#3b82f6;"></i>
        <div>
          <div style="font-weight:800;color:#1e40af;font-size:.88rem;">Identitas Sedang Ditinjau</div>
          <div style="font-size:.78rem;color:#1e40af;">Admin sedang memverifikasi KTP Anda. Mohon tunggu maksimal 1×24 jam.</div>
        </div>
      @elseif($statusVerif == 'ditolak')
        <i class="bi bi-x-circle-fill fs-4 me-3" style="color:#dc2626;"></i>
        <div>
          <div style="font-weight:800;color:#991b1b;font-size:.88rem;">Verifikasi Identitas Ditolak</div>
          <div style="font-size:.78rem;color:#991b1b;">
            {{ $user->catatan_verifikasi ?? 'Data KTP tidak valid atau foto kurang jelas.' }}
            <a href="{{ route('owner.pengaturan') }}?tab=akun" class="fw-bold" style="color:#dc2626;text-decoration:underline;">Upload Ulang →</a>
          </div>
        </div>
      @else
        <i class="bi bi-person-badge-fill fs-4 me-3" style="color:#f43f5e;"></i>
        <div>
          <div style="font-weight:800;color:#9f1239;font-size:.88rem;">Wajib Verifikasi Identitas!</div>
          <div style="font-size:.78rem;color:#9f1239;">
            Silakan upload KTP dan Foto Selfie untuk keamanan dan kepercayaan penyewa.
            <a href="{{ route('owner.pengaturan') }}?tab=akun" class="fw-bold" style="color:#f43f5e;text-decoration:underline;">Verifikasi Sekarang →</a>
          </div>
        </div>
      @endif
    </div>
  @endif
</div>

{{-- ===== STAT CARDS ===== --}}
<div class="row g-3 mb-3">

  {{-- Total Kost --}}
  <div class="col-6 col-xl-3">
    <div class="stat-card">
      <div class="stat-icon" style="background:rgba(232,64,28,.1);color:#e8401c;">
        <i class="bi bi-house-door"></i>
      </div>
      <div>
        <div class="stat-num">{{ $total_kost }}</div>
        <div class="stat-lbl">Total Kost</div>
        <div class="stat-sub" style="color:#e8401c;">Kost terdaftar</div>
      </div>
    </div>
  </div>

  {{-- Total Booking --}}
  <div class="col-6 col-xl-3">
    <div class="stat-card">
      <div class="stat-icon" style="background:rgba(232,64,28,.1);color:#e8401c;">
        <i class="bi bi-journal-check"></i>
      </div>
      <div>
        <div class="stat-num">{{ $total_booking }}</div>
        <div class="stat-lbl">Total Booking</div>
        <div class="stat-sub" style="color:#f59e0b;">{{ $booking_pending }} pending</div>
      </div>
    </div>
  </div>

  {{-- Booking Selesai --}}
  <div class="col-6 col-xl-3">
    <div class="stat-card">
      <div class="stat-icon" style="background:rgba(100,116,139,.1);color:#64748b;">
        <i class="bi bi-flag-fill"></i>
      </div>
      <div>
        {{-- 
          $booking_selesai = total booking dengan status selesai.
          Pastikan variabel ini dikirim dari DashboardController.
          Contoh: $booking_selesai = Booking::where('owner_id', $ownerId)->where('status_booking','selesai')->count();
        --}}
        <div class="stat-num">{{ $booking_selesai ?? 0 }}</div>
        <div class="stat-lbl">Booking Selesai</div>
        <div class="stat-sub" style="color:#64748b;">Sudah terbayar</div>
      </div>
    </div>
  </div>

  {{-- 
    ===== PENDAPATAN BULAN INI =====
    Nilai ini akan otomatis berubah setiap kali ada booking yang di-set "Selesai",
    karena diambil real-time dari database melalui controller.

    Di DashboardController, hitung seperti ini:
    -------------------------------------------------------
    $pendapatan_bulan_ini = Booking::whereHas('room.kost', fn($q) => $q->where('user_id', auth()->id()))
        ->where('status_booking', 'selesai')
        ->whereMonth('updated_at', now()->month)
        ->whereYear('updated_at', now()->year)
        ->sum('pendapatan_owner');

    $pendapatan_bulan_lalu = Booking::whereHas('room.kost', fn($q) => $q->where('user_id', auth()->id()))
        ->where('status_booking', 'selesai')
        ->whereMonth('updated_at', now()->subMonth()->month)
        ->whereYear('updated_at', now()->subMonth()->year)
        ->sum('pendapatan_owner');

    $selisih_pendapatan = $pendapatan_bulan_ini - $pendapatan_bulan_lalu;
    -------------------------------------------------------
    Saat booking di-set selesai (BookingController@selesai), pastikan:
    $booking->status_booking  = 'selesai';
    $booking->pendapatan_owner = $booking->total_bayar * 0.9; // atau sesuai komisi
    $booking->save();
  --}}
  <div class="col-6 col-xl-3">
    <div class="stat-card">
      <div class="stat-icon" style="background:rgba(16,185,129,.1);color:#10b981;">
        <i class="bi bi-cash-stack"></i>
      </div>
      <div style="min-width:0;">
        <div class="stat-num" style="font-size:{{ strlen(number_format($pendapatan_bulan_ini ?? 0)) > 9 ? '1rem' : '1.15rem' }};">
          Rp {{ number_format($pendapatan_bulan_ini ?? 0, 0, ',', '.') }}
        </div>
        <div class="stat-lbl">Pendapatan Bulan Ini</div>

        {{-- Badge perbandingan dengan bulan lalu --}}
        @php $selisih = $selisih_pendapatan ?? 0; @endphp
        @if($selisih > 0)
          <div class="stat-sub" style="color:#10b981;">
            ↑ Rp {{ number_format($selisih, 0, ',', '.') }} vs bln lalu
          </div>
        @elseif($selisih < 0)
          <div class="stat-sub" style="color:#ef4444;">
            ↓ Rp {{ number_format(abs($selisih), 0, ',', '.') }} vs bln lalu
          </div>
        @else
          <div class="stat-sub" style="color:#94a3b8;">Sama seperti bulan lalu</div>
        @endif

        {{-- Live indicator --}}
        <div class="income-live-badge">
          <span class="income-live-dot"></span> Live
        </div>
      </div>
    </div>
  </div>

</div>

{{-- ===== CHART + KOST SAYA ===== --}}
<div class="row g-3 mb-3">
  <div class="col-12 col-lg-8">
    <div class="section-card">
      <div class="section-head">
        <h6><i class="bi bi-graph-up me-1" style="color:var(--primary)"></i> Statistik Booking 6 Bulan Terakhir</h6>
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
            <div class="kost-thumb" style="color:#e8401c;">
              <i class="bi bi-building"></i>
            </div>
            <div style="flex:1; min-width:0;">
              <div class="kost-name text-truncate">{{ $kost->nama_kost }}</div>
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

{{-- ===== BOOKING TERBARU ===== --}}
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
              <td>{{ $b->jumlah_durasi ?? $b->durasi_sewa }} {{ $b->tipe_durasi ?? 'bulan' }}</td>
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

{{-- ===== MODAL ULASAN (hanya tampil jika belum pernah review) ===== --}}
@if(!auth()->user()->ownerReview)
  <div class="modal fade" id="modalUlasan" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content border-0 rounded-4 shadow">
        <div class="modal-header border-0 pb-0">
          <div>
            <h5 class="fw-bold mb-1">Bagaimana pengalaman Anda? ⭐</h5>
            <p class="text-muted small mb-0">Ulasan Anda membantu pemilik kos lain bergabung.</p>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body pt-3">
          @if(session('success'))
            <div class="alert alert-success rounded-3 small">
              <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            </div>
          @endif
          <form action="{{ route('owner.review.store') }}" method="POST">
            @csrf
            <div class="row g-2 mb-3">
              <div class="col-6">
                <label class="form-label small fw-semibold">Kota</label>
                <input type="text" name="kota" class="form-control form-control-sm rounded-3">
              </div>
              <div class="col-6">
                <label class="form-label small fw-semibold">Lokasi Kos</label>
                <input type="text" name="lokasi_kos" class="form-control form-control-sm rounded-3">
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label small fw-semibold">Rating</label>
              <div class="star-rating">
                @for($i = 5; $i >= 1; $i--)
                  <input type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}">
                  <label for="star{{ $i }}">★</label>
                @endfor
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label small fw-semibold">Ulasan Anda</label>
              <textarea name="ulasan" rows="4" class="form-control form-control-sm rounded-3"></textarea>
            </div>
            <div class="d-flex gap-2">
              <button type="submit" class="btn btn-sm fw-bold rounded-3 flex-fill"
                      style="background:#e8401c;color:#fff;">Kirim Ulasan</button>
              <button type="button" class="btn btn-sm btn-light rounded-3" data-bs-dismiss="modal">Nanti Saja</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endif

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // ===== BOOKING CHART =====
  const ctx = document.getElementById('bookingChart').getContext('2d');

  // Data 6 bulan terakhir dari controller
  // Pastikan DashboardController mengirim: $chartLabels dan $chartData
  // Contoh di controller:
  // $chartData   = [];
  // $chartLabels = [];
  // for ($i = 5; $i >= 0; $i--) {
  //     $bulan = now()->subMonths($i);
  //     $chartLabels[] = $bulan->translatedFormat('M');
  //     $chartData[]   = Booking::whereHas('room.kost', fn($q) => $q->where('user_id', auth()->id()))
  //                        ->whereMonth('created_at', $bulan->month)
  //                        ->whereYear('created_at', $bulan->year)
  //                        ->count();
  // }

  new Chart(ctx, {
    type: 'line',
    data: {
      labels: {!! json_encode($chartLabels ?? ['Bln-5','Bln-4','Bln-3','Bln-2','Bln-1','Ini']) !!},
      datasets: [{
        label: 'Booking',
        data: {!! json_encode($chartData ?? [0,0,0,0,0,0]) !!},
        borderColor: '#e8401c',
        backgroundColor: 'rgba(232,64,28,.08)',
        borderWidth: 2.5,
        pointBackgroundColor: '#e8401c',
        pointRadius: 5,
        pointHoverRadius: 7,
        tension: 0.4,
        fill: true,
      }]
    },
    options: {
      responsive: true,
      plugins: { legend: { display: false } },
      scales: {
        y: { beginAtZero: true, grid: { color: '#f0f3f8' }, ticks: { font: { size: 11 }, stepSize: 1 } },
        x: { grid: { display: false }, ticks: { font: { size: 11 } } }
      }
    }
  });

  // ===== MODAL ULASAN (delay 2 detik) =====
  @if(!auth()->user()->ownerReview)
    setTimeout(() => {
      new bootstrap.Modal(document.getElementById('modalUlasan')).show();
    }, 2000);
  @endif
</script>
@endpush