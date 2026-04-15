@extends('admin.layout')

@section('title', 'Dashboard Admin')
@section('page_title', 'Selamat datang, '.(auth()->user()->name ?? 'Admin').'!')

@section('content')
<div class="row g-3 mb-3">
    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fff5f2;">👥</div>
            <div>
                <div class="stat-num">{{ number_format($summary['total_users']) }}</div>
                <div class="stat-lbl">Total User</div>
                <div class="stat-sub" style="color:#e8401c;">Akun pencari kos</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#f0f9ff;">🧑‍💼</div>
            <div>
                <div class="stat-num">{{ number_format($summary['total_owners']) }}</div>
                <div class="stat-lbl">Total Owner</div>
                <div class="stat-sub" style="color:#0ea5e9;">Pemilik kos aktif</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fffbeb;">🏠</div>
            <div>
                <div class="stat-num">{{ number_format($summary['total_kosts']) }}</div>
                <div class="stat-lbl">Total Kos</div>
                <div class="stat-sub" style="color:#f59e0b;">Data kos terdaftar</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#f0fdf4;">📋</div>
            <div>
                <div class="stat-num">{{ number_format($summary['total_bookings']) }}</div>
                <div class="stat-lbl">Total Booking</div>
                <div class="stat-sub" style="color:#10b981;">Histori transaksi</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-12 col-lg-8">
        <div class="section-card">
            <div class="section-head">
                <h6><i class="bi bi-graph-up me-1" style="color:var(--primary)"></i> Statistik Booking - 6 Bulan Terakhir</h6>
            </div>
            <div class="p-3">
                <canvas id="bookingChart" height="100"></canvas>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-4">
        <div class="section-card h-100">
            <div class="section-head">
                <h6><i class="bi bi-house-check me-1" style="color:var(--primary)"></i> Notifikasi Admin</h6>
                <a href="{{ route('admin.kosts') }}" class="link-p">Kelola</a>
            </div>
            <div class="p-3" style="font-size:.84rem;">
                <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                    <span>Kos belum diverifikasi</span>
                    <span class="fw-bold text-danger">{{ $notifications['unverified_kosts'] }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                    <span>Akun nonaktif</span>
                    <span class="fw-bold">{{ $notifications['inactive_users'] }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center py-2">
                    <span>Total log aktivitas</span>
                    <span class="fw-bold">{{ $recentActivities->count() }}</span>
                </div>
            </div>

            <div class="section-head" style="border-top:1px solid #f0f3f8;border-bottom:0;">
                <h6><i class="bi bi-fire me-1" style="color:var(--primary)"></i> Kos Terpopuler</h6>
            </div>
            <div>
                @forelse($topKosts->take(4) as $kost)
                    <div class="d-flex justify-content-between align-items-center px-3 py-2 border-top" style="font-size:.8rem;">
                        <div class="text-truncate" style="max-width:170px;">{{ $kost->nama_kost }}</div>
                        <span class="badge text-bg-light">{{ $kost->total_booking }}x</span>
                    </div>
                @empty
                    <div class="px-3 py-3 text-muted" style="font-size:.8rem;">Belum ada data kos terpopuler.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div class="section-card">
    <div class="section-head">
        <h6><i class="bi bi-journal-check me-1" style="color:var(--primary)"></i> Booking Terbaru</h6>
        <a href="{{ route('admin.bookings') }}" class="link-p">Lihat Semua</a>
    </div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>USER</th>
                    <th>KOS</th>
                    <th>TANGGAL MASUK</th>
                    <th>STATUS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentBookings as $booking)
                    <tr>
                        <td class="fw-semibold">{{ $booking->user->name ?? '-' }}</td>
                        <td>{{ $booking->room->kost->nama_kost ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($booking->tanggal_masuk)->format('d M Y') }}</td>
                        <td>
                            <span class="badge {{ $booking->status_booking === 'diterima' ? 'text-bg-success' : ($booking->status_booking === 'pending' ? 'text-bg-warning' : 'text-bg-secondary') }}">
                                {{ ucfirst($booking->status_booking) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted py-4">Belum ada data booking.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const bookingCtx = document.getElementById('bookingChart').getContext('2d');
    new Chart(bookingCtx, {
        type: 'line',
        data: {
            labels: @json($monthlyLabels),
            datasets: [{
                label: 'Booking',
                data: @json($monthlyTotals),
                borderColor: '#e8401c',
                backgroundColor: 'rgba(232,64,28,.08)',
                borderWidth: 2,
                pointBackgroundColor: '#e8401c',
                pointRadius: 4,
                tension: 0.35,
                fill: true
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
@endsection
