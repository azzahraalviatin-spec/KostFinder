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
            <button class="btn btn-success rounded-pill px-4 shadow-sm fw-bold">
                <i class="bi bi-file-earmark-excel me-2"></i> Export Excel
            </button>
            <a href="{{ route('admin.reports.export.pdf') }}" class="btn btn-danger rounded-pill px-4 shadow-sm fw-bold">
                <i class="bi bi-file-earmark-pdf me-2"></i> Export PDF
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
                    <div style="height: 300px;">
                        <canvas id="bookingChart"></canvas>
                    </div>
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
    <div class="card report-card mb-4 border-0 shadow-sm">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="section-title mb-0">Booking Terbaru</div>
                <span class="badge bg-primary-subtle text-primary rounded-pill px-3">5 transaksi terbaru</span>
            </div>

            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Penyewa</th>
                            <th>Owner</th>
                            <th>Nama Kos</th>
                            <th>Status</th>
                            <th>Pembayaran</th>
                            <th>Total</th>
                            <th>Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentBookings as $item)
                            <tr>
                                <td class="fw-bold text-dark">{{ $item->nama_penyewa }}</td>
                                <td>{{ $item->nama_owner }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $item->nama_kost }}</div>
                                    <div class="small text-muted">Kamar #{{ $item->nama_kamar }}</div>
                                </td>
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
                                <td class="fw-bold text-primary">Rp {{ number_format($item->total_bayar ?? 0, 0, ',', '.') }}</td>
                                <td class="small text-muted">{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">
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
    <div class="card report-card border-0 shadow-sm">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h5 class="fw-bold mb-0">Kos Paling Laris Bulan Ini</h5>
                    <p class="text-muted small mb-0">Berdasarkan jumlah booking dan total pemasukan</p>
                </div>
            </div>

            <div class="row g-4">
                @forelse($topKostsThisMonth as $index => $kost)
                    <div class="col-md-6 col-xl-4">
                        <div class="p-3 rounded-4 border h-100 transition-all hover-shadow" style="background: #fdfdfd;">
                            <div class="d-flex align-items-start gap-3">
                                <div class="top-rank shadow-sm" style="background: linear-gradient(135deg, #4f46e5, #6366f1); color: #fff;">
                                    {{ $index + 1 }}
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="fw-bold mb-1 text-dark">{{ $kost->nama_kost }}</h6>
                                    <div class="text-muted small mb-3"><i class="bi bi-geo-alt me-1"></i>{{ $kost->daerah_kos }}</div>
                                    
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <div class="p-2 rounded-3 text-center" style="background: #f0fdf4;">
                                                <div class="text-success fw-bold fs-5">{{ $kost->total_booking }}</div>
                                                <div class="text-muted small" style="font-size: 10px; text-transform: uppercase;">Booking</div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="p-2 rounded-3 text-center" style="background: #eff6ff;">
                                                <div class="text-primary fw-bold" style="font-size: 13px;">Rp{{ number_format($kost->total_pemasukan/1000, 0) }}k</div>
                                                <div class="text-muted small" style="font-size: 10px; text-transform: uppercase;">Omzet</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3 pt-2 border-top">
                                        <span class="small text-muted">Owner: </span>
                                        <span class="small fw-bold">{{ $kost->nama_owner }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="empty-box py-5">
                            <i class="bi bi-house-x fs-1 opacity-25 d-block mb-2"></i>
                            Belum ada kos terlaris bulan ini.
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
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
                    tension: 0.4,
                    fill: true,
                    borderWidth: 3,
                    pointRadius: 5,
                    pointHoverRadius: 8,
                    backgroundColor: 'rgba(79, 70, 229, 0.1)',
                    borderColor: '#4f46e5',
                    pointBackgroundColor: '#4f46e5',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f1f5f9' },
                        ticks: { precision: 0, font: { size: 11 } }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 11 } }
                    }
                }
            }
        });
    });
</script>
@endpush