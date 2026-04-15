@extends('admin.layout')

@section('title', 'Laporan Admin')
@section('page_title', 'Laporan & Statistik Platform')
@section('page_subtitle', 'Ringkasan performa platform kost, booking, dan pemasukan admin')

@section('content')
<div class="container-fluid px-0">

    {{-- ===================== STYLE ===================== --}}
    <style>
        .report-card {
            border: none;
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.06);
            background: #fff;
        }

        .stat-card {
            border: none;
            border-radius: 18px;
            padding: 20px;
            color: #fff;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
            transition: .2s ease-in-out;
            height: 100%;
        }

        .stat-card:hover {
            transform: translateY(-4px);
        }

        .stat-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: rgba(255,255,255,0.18);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
        }

        .stat-label {
            font-size: 14px;
            opacity: .92;
        }

        .stat-value {
            font-size: 28px;
            font-weight: 700;
            line-height: 1.2;
        }

        .gradient-blue { background: linear-gradient(135deg, #4f46e5, #6366f1); }
        .gradient-green { background: linear-gradient(135deg, #10b981, #34d399); }
        .gradient-orange { background: linear-gradient(135deg, #f59e0b, #fbbf24); }
        .gradient-red { background: linear-gradient(135deg, #ef4444, #f87171); }
        .gradient-purple { background: linear-gradient(135deg, #7c3aed, #a78bfa); }
        .gradient-dark { background: linear-gradient(135deg, #1f2937, #374151); }

        .section-title {
            font-weight: 700;
            font-size: 18px;
            margin-bottom: 18px;
        }

        .mini-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-pending {
            background: #fff7ed;
            color: #c2410c;
        }

        .badge-diterima {
            background: #ecfdf5;
            color: #047857;
        }

        .badge-ditolak {
            background: #fef2f2;
            color: #b91c1c;
        }

        .badge-selesai {
            background: #eff6ff;
            color: #1d4ed8;
        }

        .badge-bayar-belum {
            background: #f3f4f6;
            color: #4b5563;
        }

        .badge-bayar-menunggu {
            background: #fff7ed;
            color: #c2410c;
        }

        .badge-bayar-lunas {
            background: #ecfdf5;
            color: #047857;
        }

        .table thead th {
            background: #f8fafc;
            border-bottom: 1px solid #e5e7eb;
            font-size: 13px;
            font-weight: 700;
            color: #374151;
        }

        .table td {
            vertical-align: middle;
            font-size: 14px;
        }

        .soft-box {
            background: #f8fafc;
            border-radius: 16px;
            padding: 16px;
        }

        .top-rank {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            background: #eef2ff;
            color: #4338ca;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }

        .empty-box {
            padding: 28px;
            text-align: center;
            color: #6b7280;
            background: #f9fafb;
            border-radius: 16px;
        }
    </style>

    {{-- ===================== HEADER ACTION ===================== --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
        <div>
            <h4 class="mb-1 fw-bold">Dashboard Laporan Platform</h4>
            <p class="text-muted mb-0">Pantau statistik pengguna, booking, pemasukan, dan performa kos.</p>
        </div>

        <div class="d-flex gap-2">
    <a href="{{ route('admin.reports.export.pdf') }}" class="btn btn-danger rounded-pill px-4">
        <i class="bi bi-file-earmark-pdf me-2"></i> PDF
    </a>
    <a href="{{ route('admin.reports.export.word') }}" class="btn btn-primary rounded-pill px-4">
        <i class="bi bi-file-earmark-word me-2"></i> Word
    </a>
</div>
    </div>

    {{-- ===================== KPI CARDS ===================== --}}
    <div class="row g-4 mb-4">
        <div class="col-md-6 col-xl-2">
            <div class="stat-card gradient-blue">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-label">Total User</div>
                        <div class="stat-value">{{ $totalUsers }}</div>
                    </div>
                    <div class="stat-icon"><i class="bi bi-people-fill"></i></div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-2">
            <div class="stat-card gradient-green">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-label">Total Owner</div>
                        <div class="stat-value">{{ $totalOwners }}</div>
                    </div>
                    <div class="stat-icon"><i class="bi bi-person-badge-fill"></i></div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-2">
            <div class="stat-card gradient-orange">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-label">Total Kos</div>
                        <div class="stat-value">{{ $totalKosts }}</div>
                    </div>
                    <div class="stat-icon"><i class="bi bi-house-door-fill"></i></div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-2">
            <div class="stat-card gradient-red">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-label">Total Booking</div>
                        <div class="stat-value">{{ $totalBookings }}</div>
                    </div>
                    <div class="stat-icon"><i class="bi bi-journal-check"></i></div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-2">
            <div class="stat-card gradient-purple">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-label">Booking Bulan Ini</div>
                        <div class="stat-value">{{ $bookingThisMonth }}</div>
                    </div>
                    <div class="stat-icon"><i class="bi bi-calendar2-check-fill"></i></div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-2">
            <div class="stat-card gradient-dark">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-label">Pendapatan Admin</div>
                        <div class="stat-value" style="font-size: 22px;">
                            Rp {{ number_format($totalPendapatanAdmin ?? 0, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="stat-icon"><i class="bi bi-cash-coin"></i></div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===================== CHART + STATUS ===================== --}}
    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="card report-card h-100">
                <div class="card-body p-4">
                    <div class="section-title">Grafik Booking 6 Bulan Terakhir</div>
                    <canvas id="bookingChart" height="110"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card report-card h-100">
                <div class="card-body p-4">
                    <div class="section-title">Statistik Status Booking</div>

                    <div class="soft-box mb-3 d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small">Pending</div>
                            <div class="fw-bold fs-4">{{ $bookingByStatus['pending'] ?? 0 }}</div>
                        </div>
                        <span class="mini-badge badge-pending">Menunggu</span>
                    </div>

                    <div class="soft-box mb-3 d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small">Diterima</div>
                            <div class="fw-bold fs-4">{{ $bookingByStatus['diterima'] ?? 0 }}</div>
                        </div>
                        <span class="mini-badge badge-diterima">Approved</span>
                    </div>

                    <div class="soft-box mb-3 d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small">Ditolak</div>
                            <div class="fw-bold fs-4">{{ $bookingByStatus['ditolak'] ?? 0 }}</div>
                        </div>
                        <span class="mini-badge badge-ditolak">Rejected</span>
                    </div>

                    <div class="soft-box d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small">Selesai</div>
                            <div class="fw-bold fs-4">{{ $bookingByStatus['selesai'] ?? 0 }}</div>
                        </div>
                        <span class="mini-badge badge-selesai">Done</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===================== BOOKING TERBARU ===================== --}}
    <div class="card report-card mb-4">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="section-title mb-0">Booking Terbaru</div>
                <span class="text-muted small">10 transaksi terbaru</span>
            </div>

            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Penyewa</th>
                            <th>Owner</th>
                            <th>Nama Kos</th>
                            <th>Daerah</th>
                            <th>Kamar</th>
                            <th>Status Booking</th>
                            <th>Pembayaran</th>
                            <th>Total</th>
                            <th>Komisi Admin</th>
                            <th>Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentBookings as $item)
                            <tr>
                                <td class="fw-semibold">{{ $item->nama_penyewa }}</td>
                                <td>{{ $item->nama_owner }}</td>
                                <td>{{ $item->nama_kost }}</td>
                                <td>{{ $item->daerah_kos }}</td>
                                <td>Kamar #{{ $item->nama_kamar }}</td>
                                <td>
                                    @if($item->status_booking === 'pending')
                                        <span class="mini-badge badge-pending">Pending</span>
                                    @elseif($item->status_booking === 'diterima')
                                        <span class="mini-badge badge-diterima">Diterima</span>
                                    @elseif($item->status_booking === 'ditolak')
                                        <span class="mini-badge badge-ditolak">Ditolak</span>
                                    @else
                                        <span class="mini-badge badge-selesai">Selesai</span>
                                    @endif
                                </td>
                                <td>
                                    @if($item->status_pembayaran === 'belum')
                                        <span class="mini-badge badge-bayar-belum">Belum</span>
                                    @elseif($item->status_pembayaran === 'menunggu')
                                        <span class="mini-badge badge-bayar-menunggu">Menunggu</span>
                                    @else
                                        <span class="mini-badge badge-bayar-lunas">Lunas</span>
                                    @endif
                                </td>
                                <td>Rp {{ number_format($item->total_bayar ?? 0, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($item->komisi_admin ?? 0, 0, ',', '.') }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10">
                                    <div class="empty-box">Belum ada data booking terbaru.</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ===================== TOP KOS ===================== --}}
    <div class="card report-card">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="section-title mb-0">Kos Paling Laris Bulan Ini</div>
                <span class="text-muted small">Berdasarkan booking & pemasukan</span>
            </div>

            <div class="row g-3">
                @forelse($topKostsThisMonth as $index => $kost)
                    <div class="col-md-6 col-xl-4">
                        <div class="soft-box h-100">
                            <div class="d-flex align-items-start gap-3">
                                <div class="top-rank">#{{ $index + 1 }}</div>
                                <div class="flex-grow-1">
                                    <h6 class="fw-bold mb-1">{{ $kost->nama_kost }}</h6>
                                    <div class="text-muted small mb-1">{{ $kost->daerah_kos }}</div>
                                    <div class="small mb-2">Owner: <span class="fw-semibold">{{ $kost->nama_owner }}</span></div>

                                    <div class="d-flex flex-wrap gap-2 mt-2">
                                        <span class="mini-badge badge-selesai">
                                            {{ $kost->total_booking }} Booking
                                        </span>
                                        <span class="mini-badge badge-diterima">
                                            Rp {{ number_format($kost->total_pemasukan ?? 0, 0, ',', '.') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="empty-box">
                            Belum ada kos terlaris bulan ini.
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const bookingLabels = @json($monthlyLabels);
    const bookingTotals = @json($monthlyTotals);

    const ctx = document.getElementById('bookingChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: bookingLabels,
            datasets: [{
                label: 'Jumlah Booking',
                data: bookingTotals,
                tension: 0.35,
                fill: true,
                borderWidth: 3,
                pointRadius: 4,
                pointHoverRadius: 6,
                backgroundColor: 'rgba(99, 102, 241, 0.12)',
                borderColor: '#6366f1',
                pointBackgroundColor: '#6366f1',
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });
</script>
@endsection