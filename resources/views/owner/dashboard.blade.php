@extends('layouts.owner')

@section('title', 'Dashboard Pemilik')

@push('styles')
<style>
    /* STAT CARDS (5 Squares Premium) */
    .stat-grid { display:grid; grid-template-columns:repeat(5, 1fr); gap:.8rem; margin-bottom:1.5rem; }
    .stat-card { border-radius:15px; padding:1.5rem .5rem; display:flex; flex-direction:column; align-items:center; justify-content:center; gap:.8rem; position:relative; overflow:hidden; transition:transform .2s; min-height:130px; text-align:center; cursor: pointer; }
    .stat-card:hover { transform:translateY(-5px); box-shadow:0 10px 25px rgba(0,0,0,.1); }
    .stat-card::after { content:''; position:absolute; right:-10px; top:-10px; width:60px; height:60px; border-radius:50%; background:rgba(255,255,255,.12); }
    
    .stat-card.total { background:linear-gradient(135deg,#1e2d3d,#3a4f63); }
    .stat-card.terisi { background:linear-gradient(135deg,#10b981,#34d399); }
    .stat-card.booking { background:linear-gradient(135deg,#6366f1,#818cf8); }
    .stat-card.pending { background:linear-gradient(135deg,#f59e0b,#fb923c); }
    .stat-card.income { background:linear-gradient(135deg,#e8401c,#ff7043); }

    .stat-icon-wrap { width:40px; height:40px; border-radius:12px; background:rgba(255,255,255,.15); display:flex; align-items:center; justify-content:center; font-size:1.3rem; color:#fff; flex-shrink:0; }
    .stat-num { font-size:1.5rem; font-weight:800; color:#fff; line-height:1.1; }
    .stat-lbl { font-size:.72rem; color:rgba(255,255,255,.9); font-weight:600; margin-top:2px; }
    .stat-sub-text { font-size:.65rem; color:rgba(255,255,255,.7); font-weight:500; }
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
    Selamat datang, {{ auth()->user()->name }}! 
  </h4>
  @if(isset($total_bank_accounts) && $total_bank_accounts == 0)
    <div class="alert alert-warning border-0 shadow-sm mt-3 d-flex align-items-center" style="border-radius:12px; background: #fff7ed; border-left: 4px solid #ea580c !important;">
      <i class="bi bi-exclamation-triangle-fill fs-4 me-3" style="color: #ea580c;"></i>
      <div>
        <div style="font-weight: 800; color: #9a3412; font-size: .88rem;">Pembayaran Belum Diatur!</div>
        <div style="font-size: .78rem; color: #c2410c;">Anda wajib mengisi nomor rekening agar penyewa bisa melakukan pembayaran saat booking. 
          <a href="{{ route('owner.pengaturan') }}?tab=pembayaran" class="fw-bold" style="color: #ea580c; text-decoration: underline;">Atur Sekarang →</a>
        </div>
      </div>
    </div>
  @endif

  @php
    $user = auth()->user();
    $statusVerif = $user->status_verifikasi_identitas ?? 'belum_ada';
  @endphp

  @if($statusVerif !== 'disetujui')
    <div class="alert border-0 shadow-sm mt-3 d-flex align-items-center" 
      style="border-radius:12px; 
      @if($statusVerif == 'pending') background: #eff6ff; border-left: 4px solid #3b82f6 !important;
      @elseif($statusVerif == 'ditolak') background: #fef2f2; border-left: 4px solid #dc2626 !important;
      @else background: #fff1f2; border-left: 4px solid #f43f5e !important; @endif">
      
      @if($statusVerif == 'pending')
        <i class="bi bi-hourglass-split fs-4 me-3" style="color: #3b82f6;"></i>
        <div>
          <div style="font-weight: 800; color: #1e40af; font-size: .88rem;">Identitas Sedang Ditinjau</div>
          <div style="font-size: .78rem; color: #1e40af;">Admin sedang memverifikasi KTP Anda. Mohon tunggu maksimal 1x24 jam.</div>
        </div>
      @elseif($statusVerif == 'ditolak')
        <i class="bi bi-x-circle-fill fs-4 me-3" style="color: #dc2626;"></i>
        <div>
          <div style="font-weight: 800; color: #991b1b; font-size: .88rem;">Verifikasi Identitas Ditolak</div>
          <div style="font-size: .78rem; color: #991b1b;">{{ $user->catatan_verifikasi ?? 'Data KTP tidak valid atau foto kurang jelas.' }} 
            <a href="{{ route('owner.pengaturan') }}?tab=akun" class="fw-bold" style="color: #dc2626; text-decoration: underline;">Upload Ulang →</a>
          </div>
        </div>
      @else
        <i class="bi bi-person-badge-fill fs-4 me-3" style="color: #f43f5e;"></i>
        <div>
          <div style="font-weight: 800; color: #9f1239; font-size: .88rem;">Wajib Verifikasi Identitas!</div>
          <div style="font-size: .78rem; color: #9f1239;">Silakan upload KTP dan Foto Selfie untuk keamanan dan kepercayaan penyewa. 
            <a href="{{ route('owner.pengaturan') }}?tab=akun" class="fw-bold" style="color: #f43f5e; text-decoration: underline;">Verifikasi Sekarang →</a>
          </div>
        </div>
      @endif
    </div>
  @endif
</div>

      {{-- STAT CARDS (5 Squares) --}}
      <div class="stat-grid">
        <div class="stat-card total" onclick="window.location='{{ route('owner.kost.index') }}'">
          <div class="stat-icon-wrap"><i class="bi bi-house-door"></i></div>
          <div class="stat-num">{{ $total_kost }}</div>
          <div class="stat-lbl">Total Kost</div>
          <div class="stat-sub-text">Kost terdaftar</div>
        </div>
        <div class="stat-card terisi" onclick="window.location='{{ route('owner.kamar.index') }}'">
          <div class="stat-icon-wrap"><i class="bi bi-door-open"></i></div>
          <div class="stat-num">{{ $kamar_terisi }}</div>
          <div class="stat-lbl">Kamar Terisi</div>
          <div class="stat-sub-text">{{ $kamar_terisi }} dari {{ $total_kamar }} kamar</div>
        </div>
        <div class="stat-card booking" onclick="window.location='{{ route('owner.booking.index') }}'">
          <div class="stat-icon-wrap"><i class="bi bi-journal-check"></i></div>
          <div class="stat-num">{{ $total_booking }}</div>
          <div class="stat-lbl">Total Booking</div>
          <div class="stat-sub-text">Riwayat booking</div>
        </div>
        <div class="stat-card pending" onclick="window.location='{{ route('owner.booking.index') }}?status=pending'">
          <div class="stat-icon-wrap"><i class="bi bi-hourglass-split"></i></div>
          <div class="stat-num">{{ $booking_pending }}</div>
          <div class="stat-lbl">Booking Pending</div>
          <div class="stat-sub-text">Perlu konfirmasi</div>
        </div>
        <div class="stat-card income" onclick="window.location='{{ route('owner.booking.index') }}?status=selesai'">
          <div class="stat-icon-wrap"><i class="bi bi-wallet2"></i></div>
          <div class="stat-num" style="font-size:1.1rem;">Rp{{ number_format($pendapatan_bulan_ini, 0, ',', '.') }}</div>
          <div class="stat-lbl">Pendapatan</div>
          <div class="stat-sub-text">Bulan ini</div>
        </div>
      </div>

      <div class="row g-3 mb-3">
        <div class="col-12 col-lg-8">
          <div class="section-card">
            <div class="section-head">
              <h6><i class="bi bi-graph-up me-1" style="color:var(--primary)"></i> Statistik Booking  6 Bulan Terakhir</h6>
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

@if(!auth()->user()->ownerReview)
<div class="modal fade" id="modalUlasan" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-0 pb-0">
                <div>
                    <h5 class="fw-800 mb-1" style="font-weight:800;">Bagaimana pengalaman Anda? ?</h5>
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
                            <label class="form-label small fw-600">Kota</label>
                            <input type="text" name="kota" class="form-control form-control-sm rounded-3">
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-600">Lokasi Kos</label>
                            <input type="text" name="lokasi_kos" class="form-control form-control-sm rounded-3">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-600">Rating</label>
                        <div class="star-rating">
                            @for($i = 5; $i >= 1; $i--)
                            <input type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}">
                            <label for="star{{ $i }}">?</label>
                            @endfor
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-600">Ulasan Anda</label>
                        <textarea name="ulasan" rows="4" class="form-control form-control-sm rounded-3"></textarea>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-sm fw-700 rounded-3 flex-fill" style="background:#e8401c;color:#fff;">Kirim Ulasan</button>
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

    @if(!auth()->user()->ownerReview)
    setTimeout(() => {
        const modal = new bootstrap.Modal(document.getElementById('modalUlasan'));
        modal.show();
    }, 2000);
    @endif
  </script>
@endpush
