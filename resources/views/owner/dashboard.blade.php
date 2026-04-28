@extends('layouts.owner')

@section('title', 'Dashboard Pemilik')

@push('styles')
<style>
    /* ── STAT CARDS COMPACT HORIZONTAL ── */
    .stat-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: .65rem;
        margin-bottom: 1.5rem;
    }
    .stat-card {
        border-radius: 12px;
        padding: .85rem 1rem;
        display: flex;
        flex-direction: row;
        align-items: center;
        gap: .75rem;
        position: relative;
        overflow: hidden;
        transition: transform .2s, box-shadow .2s;
        cursor: pointer;
        border: none;
        text-decoration: none;
    }
    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,.15);
    }
    .stat-card::before {
        content: '';
        position: absolute;
        right: -12px;
        bottom: -12px;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: rgba(255,255,255,.1);
        pointer-events: none;
    }
    .stat-card.total   { background: linear-gradient(135deg, #1e2d3d, #3a4f63); }
    .stat-card.terisi  { background: linear-gradient(135deg, #059669, #34d399); }
    .stat-card.booking { background: linear-gradient(135deg, #4f46e5, #818cf8); }
    .stat-card.pending { background: linear-gradient(135deg, #d97706, #fb923c); }
    .stat-card.income  { background: linear-gradient(135deg, #e8401c, #ff6b47); }

    .stat-icon-wrap {
        width: 40px;
        height: 40px;
        min-width: 40px;
        border-radius: 10px;
        background: rgba(255,255,255,.18);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        color: #fff;
        flex-shrink: 0;
    }
    .stat-body {
        display: flex;
        flex-direction: column;
        gap: .05rem;
        min-width: 0;
        flex: 1;
    }
    .stat-num {
        font-size: 1.2rem;
        font-weight: 800;
        color: #fff;
        line-height: 1.2;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .stat-lbl {
        font-size: .7rem;
        color: rgba(255,255,255,.9);
        font-weight: 600;
        white-space: nowrap;
    }
    .stat-sub-text {
        font-size: .62rem;
        color: rgba(255,255,255,.65);
        font-weight: 500;
        white-space: nowrap;
    }

    /* ── SECTION CARDS ── */
    .section-card {
        background: #fff;
        border-radius: .85rem;
        border: 1px solid #e4e9f0;
        box-shadow: 0 2px 6px rgba(0,0,0,.04);
        overflow: hidden;
    }
    .section-head {
        padding: .9rem 1.2rem;
        border-bottom: 1px solid #f0f3f8;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .section-head h6 {
        font-weight: 700;
        color: var(--dark);
        margin: 0;
        font-size: .87rem;
    }
    .link-p { color: var(--primary); font-size: .78rem; font-weight: 600; text-decoration: none; }
    .link-p:hover { color: #cb3518; }

    table thead th {
        font-size: .68rem;
        font-weight: 700;
        color: #8fa3b8;
        letter-spacing: .05em;
        border: 0;
        padding: .6rem 1rem;
        background: #f8fafd;
    }
    table tbody td {
        font-size: .8rem;
        color: #333;
        padding: .65rem 1rem;
        border-color: #f0f3f8;
        vertical-align: middle;
    }

    .s-pill {
        padding: .18rem .6rem;
        border-radius: 999px;
        font-size: .7rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: .25rem;
    }
    .s-pending  { background: #fff7ed; color: #ea580c; }
    .s-diterima { background: #f0fdf4; color: #16a34a; }
    .s-ditolak  { background: #fef2f2; color: #dc2626; }
    .s-selesai  { background: #f0fdf4; color: #15803d; }

    .kost-item {
        display: flex;
        align-items: center;
        gap: .8rem;
        padding: .75rem 1.2rem;
        border-bottom: 1px solid #f0f3f8;
    }
    .kost-item:last-child { border: 0; }
    .kost-thumb {
        width: 46px;
        height: 38px;
        border-radius: .5rem;
        background: #fff5f2;
        border: 1px solid #ffd0c0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        flex-shrink: 0;
        color: #e8401c;
    }
    .kost-name { font-weight: 700; font-size: .82rem; color: var(--dark); }
    .kost-loc  { font-size: .72rem; color: #8fa3b8; }

    .act-btn {
        width: 28px;
        height: 28px;
        border-radius: .4rem;
        border: 1px solid #e4e9f0;
        background: #f8fafd;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #666;
        font-size: .75rem;
        cursor: pointer;
        text-decoration: none;
        transition: all .15s;
    }
    .act-btn:hover { background: #eef1f8; }
    .act-btn.del:hover { background: #fff5f2; color: var(--primary); border-color: #ffd0c0; }

    .empty-s {
        padding: 2rem;
        text-align: center;
        color: #8fa3b8;
        font-size: .82rem;
    }
    .empty-s i {
        font-size: 1.8rem;
        display: block;
        margin-bottom: .4rem;
        opacity: .35;
    }

    .star-rating { display: flex; flex-direction: row-reverse; gap: 4px; }
    .star-rating input { display: none; }
    .star-rating label { font-size: 1.8rem; color: #d1d5db; cursor: pointer; transition: color .15s; }
    .star-rating input:checked ~ label,
    .star-rating label:hover,
    .star-rating label:hover ~ label { color: #f59e0b; }

    /* Responsive */
    @media (max-width: 1100px) {
        .stat-grid { grid-template-columns: repeat(3, 1fr); }
    }
    @media (max-width: 700px) {
        .stat-grid { grid-template-columns: repeat(2, 1fr); }
    }
</style>
@endpush

@section('content')

{{-- WELCOME HEADER --}}
<div style="margin-bottom: 1.75rem;">
    <h4 style="font-size:1.3rem; font-weight:700; color:var(--dark); margin:0;">
        Selamat datang, {{ auth()->user()->name }}!
    </h4>

    {{-- Alert: Rekening belum diatur --}}
    @if(isset($total_bank_accounts) && $total_bank_accounts == 0)
        <div class="alert alert-warning border-0 shadow-sm mt-3 d-flex align-items-center"
            style="border-radius:12px; background:#fff7ed; border-left:4px solid #ea580c !important;">
            <i class="bi bi-exclamation-triangle-fill fs-4 me-3" style="color:#ea580c;"></i>
            <div>
                <div style="font-weight:800; color:#9a3412; font-size:.88rem;">Pembayaran Belum Diatur!</div>
                <div style="font-size:.78rem; color:#c2410c;">
                    Anda wajib mengisi nomor rekening agar penyewa bisa melakukan pembayaran saat booking.
                    <a href="{{ route('owner.pengaturan') }}?tab=pembayaran" class="fw-bold"
                        style="color:#ea580c; text-decoration:underline;">Atur Sekarang →</a>
                </div>
            </div>
        </div>
    @endif

    {{-- Alert: Verifikasi identitas --}}
    @php
        $user = auth()->user();
        $statusVerif = $user->status_verifikasi_identitas ?? 'belum_ada';
    @endphp

    @if($statusVerif !== 'disetujui')
        <div class="alert border-0 shadow-sm mt-3 d-flex align-items-center"
            style="border-radius:12px;
            @if($statusVerif == 'pending')      background:#eff6ff; border-left:4px solid #3b82f6 !important;
            @elseif($statusVerif == 'ditolak')  background:#fef2f2; border-left:4px solid #dc2626 !important;
            @else                               background:#fff1f2; border-left:4px solid #f43f5e !important;
            @endif">

            @if($statusVerif == 'pending')
                <i class="bi bi-hourglass-split fs-4 me-3" style="color:#3b82f6;"></i>
                <div>
                    <div style="font-weight:800; color:#1e40af; font-size:.88rem;">Identitas Sedang Ditinjau</div>
                    <div style="font-size:.78rem; color:#1e40af;">Admin sedang memverifikasi KTP Anda. Mohon tunggu maksimal 1x24 jam.</div>
                </div>
            @elseif($statusVerif == 'ditolak')
                <i class="bi bi-x-circle-fill fs-4 me-3" style="color:#dc2626;"></i>
                <div>
                    <div style="font-weight:800; color:#991b1b; font-size:.88rem;">Verifikasi Identitas Ditolak</div>
                    <div style="font-size:.78rem; color:#991b1b;">
                        {{ $user->catatan_verifikasi ?? 'Data KTP tidak valid atau foto kurang jelas.' }}
                        <a href="{{ route('owner.pengaturan') }}?tab=akun" class="fw-bold"
                            style="color:#dc2626; text-decoration:underline;">Upload Ulang →</a>
                    </div>
                </div>
            @else
                <i class="bi bi-person-badge-fill fs-4 me-3" style="color:#f43f5e;"></i>
                <div>
                    <div style="font-weight:800; color:#9f1239; font-size:.88rem;">Wajib Verifikasi Identitas!</div>
                    <div style="font-size:.78rem; color:#9f1239;">
                        Silakan upload KTP dan Foto Selfie untuk keamanan dan kepercayaan penyewa.
                        <a href="{{ route('owner.pengaturan') }}?tab=akun" class="fw-bold"
                            style="color:#f43f5e; text-decoration:underline;">Verifikasi Sekarang →</a>
                    </div>
                </div>
            @endif
        </div>
    @endif
</div>

{{-- ── STAT CARDS (5 COMPACT HORIZONTAL) ── --}}
<div class="stat-grid">

    {{-- Total Kost --}}
    <div class="stat-card total" onclick="window.location='{{ route('owner.kost.index') }}'">
        <div class="stat-icon-wrap"><i class="bi bi-house-door"></i></div>
        <div class="stat-body">
            <div class="stat-num">{{ $total_kost }}</div>
            <div class="stat-lbl">Total Kost</div>
            <div class="stat-sub-text">Kost terdaftar</div>
        </div>
    </div>

    {{-- Kamar Terisi --}}
    <div class="stat-card terisi" onclick="window.location='{{ route('owner.kamar.index') }}'">
        <div class="stat-icon-wrap"><i class="bi bi-door-open"></i></div>
        <div class="stat-body">
            <div class="stat-num">{{ $kamar_terisi }}</div>
            <div class="stat-lbl">Kamar Terisi</div>
            <div class="stat-sub-text">dari {{ $total_kamar }} kamar</div>
        </div>
    </div>

    {{-- Total Booking --}}
    <div class="stat-card booking" onclick="window.location='{{ route('owner.booking.index') }}'">
        <div class="stat-icon-wrap"><i class="bi bi-journal-check"></i></div>
        <div class="stat-body">
            <div class="stat-num">{{ $total_booking }}</div>
            <div class="stat-lbl">Total Booking</div>
            <div class="stat-sub-text">Riwayat booking</div>
        </div>
    </div>

    {{-- Booking Pending --}}
    <div class="stat-card pending" onclick="window.location='{{ route('owner.booking.index') }}?status=pending'">
        <div class="stat-icon-wrap"><i class="bi bi-hourglass-split"></i></div>
        <div class="stat-body">
            <div class="stat-num">{{ $booking_pending }}</div>
            <div class="stat-lbl">Booking Pending</div>
            <div class="stat-sub-text">Perlu konfirmasi</div>
        </div>
    </div>

    {{-- Pendapatan Bulan Ini --}}
    <div class="stat-card income" onclick="window.location='{{ route('owner.booking.index') }}?status=selesai'">
        <div class="stat-icon-wrap"><i class="bi bi-wallet2"></i></div>
        <div class="stat-body">
            <div class="stat-num" style="font-size:.95rem;">
                Rp{{ number_format($pendapatan_bulan_ini, 0, ',', '.') }}
            </div>
            <div class="stat-lbl">Pendapatan</div>
            <div class="stat-sub-text">Bulan ini</div>
        </div>
    </div>

</div>

{{-- ── CHART + KOST SAYA ── --}}
<div class="row g-3 mb-3">

    {{-- Grafik Booking --}}
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

    {{-- Kost Saya --}}
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
                    <a href="{{ route('owner.kost.create') }}" style="color:var(--primary); font-weight:600;">+ Tambah sekarang</a>
                </div>
            @else
                @foreach($kosts->take(4) as $kost)
                    <div class="kost-item">
                        <div class="kost-thumb">
                            <i class="bi bi-building"></i>
                        </div>
                        <div style="flex:1; min-width:0;">
                            <div class="kost-name text-truncate">{{ $kost->nama_kost }}</div>
                            <div class="kost-loc">
                                <i class="bi bi-geo-alt" style="font-size:.65rem;"></i>
                                {{ $kost->kota }}
                            </div>
                        </div>
                        <div class="d-flex gap-1 flex-shrink-0">
                            <a href="{{ route('owner.kost.edit', $kost->id_kost) }}" class="act-btn">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('owner.kost.destroy', $kost->id_kost) }}" method="POST"
                                class="js-confirm-delete"
                                data-delete-message="Anda yakin ingin menghapus kost ini?">
                                @csrf
                                @method('DELETE')
                                <button class="act-btn del" type="submit">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

</div>

{{-- ── BOOKING TERBARU ── --}}
<div class="section-card">
    <div class="section-head">
        <h6><i class="bi bi-journal-check me-1" style="color:var(--primary)"></i> Booking Terbaru</h6>
        <a href="{{ route('owner.booking.index') }}" class="link-p">Lihat Semua</a>
    </div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>PENYEWA</th>
                    <th>KOST</th>
                    <th>KAMAR</th>
                    <th>TANGGAL MASUK</th>
                    <th>DURASI</th>
                    <th>STATUS</th>
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
                    <tr>
                        <td colspan="6">
                            <div class="empty-s">
                                <i class="bi bi-inbox"></i>
                                Belum ada booking
                            </div>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

{{-- ── MODAL ULASAN OWNER ── --}}
@if(!auth()->user()->ownerReview)
<div class="modal fade" id="modalUlasan" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-0 pb-0">
                <div>
                    <h5 style="font-weight:800; margin-bottom:.25rem;">Bagaimana pengalaman Anda?</h5>
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
                            <input type="text" name="kota" class="form-control form-control-sm rounded-3"
                                placeholder="Contoh: Surabaya">
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Lokasi Kos</label>
                            <input type="text" name="lokasi_kos" class="form-control form-control-sm rounded-3"
                                placeholder="Contoh: Gubeng">
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
                        <textarea name="ulasan" rows="4" class="form-control form-control-sm rounded-3"
                            placeholder="Ceritakan pengalaman Anda menggunakan KostFinder..."></textarea>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-sm fw-bold rounded-3 flex-fill"
                            style="background:#e8401c; color:#fff;">
                            Kirim Ulasan
                        </button>
                        <button type="button" class="btn btn-sm btn-light rounded-3" data-bs-dismiss="modal">
                            Nanti Saja
                        </button>
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
    // ── Booking Chart ──
    @php
        $lblChart  = $chartLabels ?? ['Okt','Nov','Des','Jan','Feb','Mar'];
        $dataChart = $chartData   ?? [0,0,0,0,0,0];
    @endphp
    const ctx = document.getElementById('bookingChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($lblChart),
            datasets: [{
                label: 'Booking',
                data: @json($dataChart),
                borderColor: '#e8401c',
                backgroundColor: 'rgba(232,64,28,.08)',
                borderWidth: 2.5,
                pointBackgroundColor: '#e8401c',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                tension: 0.4,
                fill: true,
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
                y: {
                    beginAtZero: true,
                    grid: { color: '#f0f3f8' },
                    ticks: { font: { size: 11 }, stepSize: 1 }
                },
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 11 } }
                }
            }
        }
    });

    // ── Modal Ulasan (tampil setelah 2 detik) ──
    @if(!auth()->user()->ownerReview)
    setTimeout(() => {
        const el = document.getElementById('modalUlasan');
        if (el) {
            const modal = new bootstrap.Modal(el);
            modal.show();
        }
    }, 2000);
    @endif

    // ── Konfirmasi Delete ──
    document.querySelectorAll('.js-confirm-delete').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const msg = this.dataset.deleteMessage || 'Yakin ingin menghapus?';
            if (confirm(msg)) this.submit();
        });
    });
</script>
@endpush