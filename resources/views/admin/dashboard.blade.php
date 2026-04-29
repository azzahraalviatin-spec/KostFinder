@extends('admin.layout')

@section('title', 'Dashboard Admin')
@section('page_title', 'Dashboard Admin')

@push('styles')
<style>
    .stat-card {
        background: #fff;
        border-radius: .85rem;
        padding: 1.1rem 1.2rem;
        border: 1px solid #e4e9f0;
        box-shadow: 0 2px 6px rgba(0,0,0,.04);
        display: flex;
        align-items: center;
        gap: 1rem;
        height: 100%;
        transition: all .25s ease;
        cursor: pointer;
    }
    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 25px rgba(232,64,28,.12);
    }
    .stat-icon { width:46px; height:46px; border-radius:.75rem; display:flex; align-items:center; justify-content:center; font-size:1.2rem; flex-shrink:0; }
    .stat-num  { font-size:1.6rem; font-weight:800; color:var(--dark); line-height:1; }
    .stat-lbl  { font-size:.75rem; color:#8fa3b8; margin-top:.2rem; }
    .stat-sub  { font-size:.7rem; font-weight:600; margin-top:.3rem; }

    .s-pill { padding:.18rem .6rem; border-radius:999px; font-size:.7rem; font-weight:600; display:inline-flex; align-items:center; gap:.25rem; }
    .s-pending   { background:#fff7ed; color:#ea580c; }
    .s-diterima  { background:#f0fdf4; color:#16a34a; }
    .s-ditolak   { background:#fef2f2; color:#dc2626; }
    .s-selesai   { background:#f1f5f9; color:#64748b; }

   /* ===== ALERT FIX (ANTI KETIMPA CSS GLOBAL) ===== */
.alert-custom {
    display: flex !important;
    align-items: center !important;
    gap: 12px !important;
    padding: 14px 16px !important;
    border-radius: 12px !important;
    margin-top: 12px !important;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05) !important;
}

/* ORANGE */
.alert-warning-custom {
    background: #fff7ed !important;
    border-left: 4px solid #ea580c !important;
}
.alert-warning-custom .icon {
    color: #ea580c;
}

/* RED */
.alert-danger-custom {
    background: #fef2f2 !important;
    border-left: 4px solid #dc2626 !important;
}
.alert-danger-custom .icon {
    color: #dc2626;
}

/* TEXT */
.alert-title {
    font-weight: 800;
    font-size: 0.9rem;
    margin-bottom: 2px;
}

.alert-desc {
    font-size: 0.8rem;
    color: #555;
}

.alert-link {
    font-weight: 700;
    text-decoration: underline;
    margin-left: 6px;
}
/* RESET ALERT BOOTSTRAP */
.alert {
    all: unset;
}
</style>
@endpush

@section('content')

<div style="margin-bottom: 1.5rem;">

{{-- KOST BELUM VERIF --}}
@if($notifications['unverified_kosts'] > 0)
<div style="display:flex; align-items:center; gap:12px; padding:14px 16px; border-radius:12px; margin-top:12px; background:#fff7ed; border-left:4px solid #ea580c;">
    
    <i class="bi bi-exclamation-triangle-fill fs-4" style="color:#ea580c;"></i>
    
    <div>
        <div style="font-weight:800; color:#9a3412; font-size:.9rem;">
            Kost Menunggu Verifikasi!
        </div>
        <div style="font-size:.8rem; color:#c2410c;">
            Terdapat <strong>{{ $notifications['unverified_kosts'] }} kost</strong> yang belum diverifikasi.
            <a href="{{ route('admin.kosts') }}?verified=tidak" style="font-weight:700; text-decoration:underline; color:#ea580c;">
                Atur Sekarang →
            </a>
        </div>
    </div>

</div>
@endif


{{-- USER NONAKTIF --}}
@if($notifications['inactive_users'] > 0)
<div style="display:flex; align-items:center; gap:12px; padding:14px 16px; border-radius:12px; margin-top:12px; background:#fef2f2; border-left:4px solid #dc2626;">
    
    <i class="bi bi-person-x-fill fs-4" style="color:#dc2626;"></i>
    
    <div>
        <div style="font-weight:800; color:#991b1b; font-size:.9rem;">
            Akun Dinonaktifkan!
        </div>
        <div style="font-size:.8rem; color:#991b1b;">
            Terdapat <strong>{{ $notifications['inactive_users'] }} akun</strong> nonaktif.
            <a href="{{ route('admin.users') }}?status=nonaktif" style="font-weight:700; text-decoration:underline; color:#dc2626;">
                Lihat Akun →
            </a>
        </div>
    </div>

</div>
@endif

</div>
{{-- ── STAT CARDS ── --}}
<div class="row g-3 mb-4">

    {{-- Total User --}}
    <div class="col-6 col-xl-3">
        <div class="stat-card" onclick="window.location='{{ route('admin.users') }}'">
            <div class="stat-icon" style="background:rgba(99,102,241,.12); color:#6366f1;">
                <i class="bi bi-people-fill"></i>
            </div>
            <div>
                <div class="stat-num">{{ $summary['total_users'] }}</div>
                <div class="stat-lbl">Total Pengguna</div>
                <div class="stat-sub" style="color:#6366f1;">User terdaftar</div>
            </div>
        </div>
    </div>

    {{-- Total Owner --}}
    <div class="col-6 col-xl-3">
        <div class="stat-card" onclick="window.location='{{ route('admin.owners') }}'">
            <div class="stat-icon" style="background:rgba(16,185,129,.12); color:#10b981;">
                <i class="bi bi-person-badge-fill"></i>
            </div>
            <div>
                <div class="stat-num">{{ $summary['total_owners'] }}</div>
                <div class="stat-lbl">Total Owner</div>
                <div class="stat-sub" style="color:#10b981;">Pemilik kost</div>
            </div>
        </div>
    </div>

    {{-- Total Kost --}}
    <div class="col-6 col-xl-3">
        <div class="stat-card" onclick="window.location='{{ route('admin.kosts') }}'">
            <div class="stat-icon" style="background:rgba(232,64,28,.12); color:#e8401c;">
                <i class="bi bi-house-door-fill"></i>
            </div>
            <div>
                <div class="stat-num">{{ $summary['total_kosts'] }}</div>
                <div class="stat-lbl">Total Kost</div>
                <div class="stat-sub" style="color:#e8401c;">Kost terdaftar</div>
            </div>
        </div>
    </div>

    {{-- Total Booking --}}
    <div class="col-6 col-xl-3">
        <div class="stat-card" onclick="window.location='{{ route('admin.bookings') }}'">
            <div class="stat-icon" style="background:rgba(245,158,11,.12); color:#f59e0b;">
                <i class="bi bi-journal-check"></i>
            </div>
            <div>
                <div class="stat-num">{{ $summary['total_bookings'] }}</div>
                <div class="stat-lbl">Total Booking</div>
                <div class="stat-sub" style="color:#f59e0b;">{{ $booking_pending }} pending</div>
            </div>
        </div>
    </div>

</div>

{{-- ── CHART + KOST TERPOPULER ── --}}
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

    {{-- Kost Terpopuler --}}
    <div class="col-12 col-lg-4">
        <div class="section-card h-100">
            <div class="section-head">
                <h6><i class="bi bi-trophy me-1" style="color:var(--primary)"></i> Kost Terpopuler</h6>
                <a href="{{ route('admin.kosts') }}" class="link-p">Lihat Semua</a>
            </div>
            @if($topKosts->isEmpty())
                <div class="p-4 text-center text-muted" style="font-size:.82rem;">
                    <i class="bi bi-house-door d-block fs-3 mb-2 opacity-25"></i>
                    Belum ada data booking
                </div>
            @else
                @foreach($topKosts as $idx => $k)
                    <div style="display:flex; align-items:center; gap:.75rem; padding:.7rem 1.2rem; border-bottom:1px solid #f0f3f8;">
                        <div style="width:26px; height:26px; border-radius:50%; background:#fff5f2; color:var(--primary); font-weight:800; font-size:.8rem; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                            {{ $idx + 1 }}
                        </div>
                        <div style="flex:1; min-width:0;">
                            <div style="font-weight:700; font-size:.83rem; color:var(--dark); white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                {{ $k->nama_kost }}
                            </div>
                        </div>
                        <div style="font-size:.75rem; font-weight:700; color:var(--primary); flex-shrink:0;">
                            {{ $k->total_booking }} booking
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

</div>

{{-- ── BOOKING TERBARU (full width karena aktivitas dihapus) ── --}}
<div class="row g-3">
    <div class="col-12">
        <div class="section-card">
            <div class="section-head">
                <h6><i class="bi bi-journal-check me-1" style="color:var(--primary)"></i> Booking Terbaru</h6>
                <a href="{{ route('admin.bookings') }}" class="link-p">Lihat Semua</a>
            </div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>PENYEWA</th>
                            <th>KOST</th>
                            <th>KAMAR</th>
                            <th>STATUS</th>
                            <th>TANGGAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentBookings as $b)
                            <tr>
                                <td class="fw-semibold">{{ $b->user->name ?? '-' }}</td>
                                <td>{{ $b->room->kost->nama_kost ?? '-' }}</td>
                                <td>No. {{ $b->room->nomor_kamar ?? '-' }}</td>
                                <td>
                                    <span class="s-pill s-{{ $b->status_booking }}">
                                        <i class="bi bi-circle-fill" style="font-size:.35rem;"></i>
                                        {{ ucfirst($b->status_booking) }}
                                    </span>
                                </td>
                                <td style="white-space:nowrap;">{{ $b->created_at->format('d M Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <div class="py-3 text-center text-muted" style="font-size:.82rem;">
                                        <i class="bi bi-inbox d-block fs-3 mb-1 opacity-25"></i>
                                        Belum ada booking
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
new Chart(document.getElementById('bookingChart').getContext('2d'), {
    type: 'bar',
    data: {
        labels: @json($monthlyLabels),
        datasets: [{
            label: 'Booking',
            data: @json($monthlyTotals),
            backgroundColor: @json($monthlyTotals).map(v => v > 0
                ? 'rgba(232,64,28,.85)'
                : 'rgba(228,233,240,.8)'
            ),
            borderRadius: 6,
            borderSkipped: false,
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false },
            tooltip: {
                callbacks: { label: ctx => ` ${ctx.parsed.y} booking` }
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
</script>
@endpush