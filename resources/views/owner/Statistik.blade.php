@extends('layouts.owner')

@section('title', 'Statistik - KostFinder')

@push('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
    .stat-card.income  { background: linear-gradient(135deg, #e8401c, #ff6b47); }
    .stat-card.booking { background: linear-gradient(135deg, #4f46e5, #818cf8); }
    .stat-card.pending { background: linear-gradient(135deg, #d97706, #fb923c); }
    .stat-card.terisi  { background: linear-gradient(135deg, #059669, #34d399); }

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
        flex-wrap: wrap;
        gap: .5rem;
    }
    .section-head h6 {
        font-weight: 700;
        color: var(--dark);
        margin: 0;
        font-size: .87rem;
    }

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

    .progress { height: 8px; border-radius: 999px; }
    .progress-bar { background: var(--primary); border-radius: 999px; }

    .filter-tahun { display: flex; align-items: center; gap: .5rem; }
    .filter-tahun select {
        font-size: .8rem;
        font-weight: 600;
        border: 1.5px solid #e4e9f0;
        border-radius: .5rem;
        padding: .3rem .7rem;
        color: var(--dark);
        background: #f8fafd;
        cursor: pointer;
        outline: none;
    }
    .filter-tahun select:focus { border-color: var(--primary); }

    .donut-wrap {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .donut-center {
        position: absolute;
        text-align: center;
        pointer-events: none;
    }
    .donut-center .num {
        font-size: 1.4rem;
        font-weight: 800;
        color: var(--dark);
        line-height: 1;
    }
    .donut-center .lbl {
        font-size: .65rem;
        color: #8fa3b8;
        margin-top: .15rem;
    }
    .kamar-legend { display: flex; flex-direction: column; gap: .5rem; margin-top: 1rem; }
    .kamar-legend-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: .8rem;
    }
    .kamar-legend-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        flex-shrink: 0;
    }
    .owner-footer {
        background: #fff;
        border-top: 1px solid #e4e9f0;
        padding: .8rem 1.5rem;
        text-align: center;
        color: #8fa3b8;
        font-size: .72rem;
        margin-top: auto;
    }

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

{{-- ── HEADER + FILTER TAHUN ── --}}
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <div>
        <div style="font-size:.95rem; font-weight:800; color:var(--dark);">
            <i class="bi bi-bar-chart-line me-1" style="color:var(--primary);"></i> Statistik Kost
        </div>
        <div style="font-size:.75rem; color:#8fa3b8;">Data tahun {{ $tahun }}</div>
    </div>
    <div class="d-flex align-items-center gap-2">
        <form method="GET" action="{{ route('owner.statistik') }}" class="filter-tahun">
            <i class="bi bi-calendar3" style="color:#8fa3b8; font-size:.85rem;"></i>
            <select name="tahun" onchange="this.form.submit()">
                @foreach($daftarTahun as $t)
                    <option value="{{ $t }}" {{ $t == $tahun ? 'selected' : '' }}>{{ $t }}</option>
                @endforeach
            </select>
        </form>
        <a href="{{ route('owner.export.excel', ['tahun' => $tahun]) }}"
            class="btn btn-sm fw-bold"
            style="background:var(--primary); color:#fff; border-radius:.5rem;">
            <i class="bi bi-download me-1"></i> Export Excel
        </a>
    </div>
</div>

{{-- ── STAT CARDS (5 COMPACT HORIZONTAL) ── --}}
<div class="stat-grid">

    {{-- Pendapatan Tahun Ini --}}
    <div class="stat-card total">
        <div class="stat-icon-wrap"><i class="bi bi-graph-up-arrow"></i></div>
        <div class="stat-body">
            <div class="stat-num" style="font-size:.92rem;">
                Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
            </div>
            <div class="stat-lbl">Pendapatan {{ $tahun }}</div>
            <div class="stat-sub-text">Total tahunan</div>
        </div>
    </div>

    {{-- Pendapatan Bulan Ini --}}
    <div class="stat-card income">
        <div class="stat-icon-wrap"><i class="bi bi-cash-stack"></i></div>
        <div class="stat-body">
            <div class="stat-num" style="font-size:.92rem;">
                Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}
            </div>
            <div class="stat-lbl">Bulan Ini</div>
            <div class="stat-sub-text">vs Rp {{ number_format($pendapatanBulanLalu, 0, ',', '.') }}</div>
        </div>
    </div>

    {{-- Total Booking --}}
    <div class="stat-card booking">
        <div class="stat-icon-wrap"><i class="bi bi-clipboard-check"></i></div>
        <div class="stat-body">
            <div class="stat-num">{{ $totalBooking }}</div>
            <div class="stat-lbl">Total Booking</div>
            <div class="stat-sub-text">{{ $rataBooking }}/bulan</div>
        </div>
    </div>

    {{-- Performa --}}
    <div class="stat-card pending">
        <div class="stat-icon-wrap"><i class="bi bi-award"></i></div>
        <div class="stat-body">
            <div class="stat-num" style="font-size:.95rem;">{{ $performa }}</div>
            <div class="stat-lbl">Performa</div>
            <div class="stat-sub-text">Tahun {{ $tahun }}</div>
        </div>
    </div>

    {{-- Kamar Terisi --}}
    <div class="stat-card terisi">
        <div class="stat-icon-wrap"><i class="bi bi-door-closed"></i></div>
        <div class="stat-body">
            @php $totalKamarStat = $kamarTerisi + $kamarTersedia; @endphp
            <div class="stat-num">{{ $kamarTerisi }} / {{ $totalKamarStat }}</div>
            <div class="stat-lbl">Kamar Terisi</div>
            <div class="stat-sub-text">
                {{ $totalKamarStat > 0 ? round($kamarTerisi / $totalKamarStat * 100) : 0 }}% Hunian
            </div>
        </div>
    </div>

</div>

{{-- ── GRAFIK + DONUT ── --}}
<div class="row g-3 mb-3">

    {{-- Grafik Booking --}}
    <div class="col-12 col-lg-8">
        <div class="section-card">
            <div class="section-head">
                <h6><i class="bi bi-graph-up me-1" style="color:var(--primary)"></i> Grafik Booking {{ $tahun }}</h6>
            </div>
            <div class="p-3">
                <canvas id="bookingChart" height="100"></canvas>
            </div>
        </div>

        {{-- Insight Cepat --}}
        <div class="section-card p-3 mt-3">
            <div class="d-flex justify-content-between flex-wrap gap-3">
                <div>
                    <div style="font-size:.68rem; color:#8fa3b8; font-weight:600;">BULAN TERLARIS</div>
                    <div style="font-weight:700; color:var(--dark); font-size:.9rem; margin-top:.15rem;">
                        {{ $bulanTerlaris ?? '-' }}
                    </div>
                </div>
                <div>
                    <div style="font-size:.68rem; color:#8fa3b8; font-weight:600;">RATA-RATA BOOKING</div>
                    <div style="font-weight:700; color:var(--dark); font-size:.9rem; margin-top:.15rem;">
                        {{ $rataBooking }}/bulan
                    </div>
                </div>
                <div>
                    <div style="font-size:.68rem; color:#8fa3b8; font-weight:600;">PERFORMA</div>
                    <div style="font-weight:700; color:var(--primary); font-size:.9rem; margin-top:.15rem;">
                        {{ $performa }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Donut Kamar --}}
    <div class="col-12 col-lg-4">
        <div class="section-card h-100">
            <div class="section-head">
                <h6><i class="bi bi-door-open me-1" style="color:var(--primary)"></i> Status Kamar</h6>
            </div>
            <div class="p-3">
                @php $totalKamar = $kamarTerisi + $kamarTersedia; @endphp
                @if($totalKamar > 0)
                    <div class="donut-wrap">
                        <canvas id="kamarChart" height="200"></canvas>
                        <div class="donut-center">
                            <div class="num">{{ round($kamarTerisi / $totalKamar * 100) }}%</div>
                            <div class="lbl">Terisi</div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-4 text-muted" style="font-size:.82rem;">
                        <i class="bi bi-door-closed fs-3 d-block mb-2 opacity-25"></i>
                        Belum ada kamar
                    </div>
                @endif

                <div class="kamar-legend">
                    <div class="kamar-legend-item">
                        <div class="d-flex align-items-center gap-2">
                            <div class="kamar-legend-dot" style="background:#e8401c;"></div>
                            <span style="color:#555; font-size:.82rem;">Terisi</span>
                        </div>
                        <span style="font-weight:700; color:#e8401c; font-size:.82rem;">{{ $kamarTerisi }} kamar</span>
                    </div>
                    <div class="kamar-legend-item">
                        <div class="d-flex align-items-center gap-2">
                            <div class="kamar-legend-dot" style="background:#22c55e;"></div>
                            <span style="color:#555; font-size:.82rem;">Tersedia</span>
                        </div>
                        <span style="font-weight:700; color:#22c55e; font-size:.82rem;">{{ $kamarTersedia }} kamar</span>
                    </div>
                    @if($totalKamar > 0)
                        <div class="mt-2 p-2 rounded-2 text-center"
                            style="background:#f8fafd; font-size:.75rem; color:#555;">
                            Tingkat hunian:
                            <strong style="color:var(--primary);">
                                {{ round($kamarTerisi / $totalKamar * 100) }}%
                            </strong>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>

{{-- ── KOST TERPOPULER ── --}}
<div class="section-card mb-3">
    <div class="section-head">
        <h6><i class="bi bi-trophy me-1" style="color:var(--primary)"></i> Kost Paling Banyak Dipesan — {{ $tahun }}</h6>
    </div>

    @if($kostPopuler->isEmpty() || $kostPopuler->sum('total_booking') == 0)
        <div class="text-center py-4 text-muted" style="font-size:.82rem;">
            <i class="bi bi-bar-chart fs-3 d-block mb-2 opacity-25"></i>
            Belum ada data booking di tahun {{ $tahun }}
        </div>
    @else
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>NAMA KOST</th>
                        <th>KOTA</th>
                        <th>TOTAL BOOKING</th>
                        <th>POPULARITAS</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kostPopuler as $i => $kost)
                        @if($kost->total_booking > 0)
                        <tr>
                            <td>
                                @if($i == 0)
                                    🥇 <span style="color:var(--primary); font-weight:700;">Terlaris</span>
                                @elseif($i == 1) 🥈
                                @elseif($i == 2) 🥉
                                @else {{ $i + 1 }}
                                @endif
                            </td>
                            <td class="fw-semibold">{{ $kost->nama_kost }}</td>
                            <td>{{ $kost->kota }}</td>
                            <td>
                                <span class="fw-bold" style="color:var(--primary);">
                                    {{ $kost->total_booking }}
                                </span> booking
                            </td>
                            <td style="width:200px;">
                                <div class="progress">
                                    <div class="progress-bar"
                                        style="width:{{ $kostPopuler->max('total_booking') > 0 ? ($kost->total_booking / $kostPopuler->max('total_booking') * 100) : 0 }}%">
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

@endsection

@push('scripts')
<script>
    // ── Booking Bar Chart ──
    new Chart(document.getElementById('bookingChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: @json($chartLabels),
            datasets: [{
                label: 'Booking',
                data: @json($chartData),
                backgroundColor: @json($chartData).map(v => v > 0
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

    // ── Donut Kamar ──
    @if(($kamarTerisi + $kamarTersedia) > 0)
    new Chart(document.getElementById('kamarChart').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: ['Terisi', 'Tersedia'],
            datasets: [{
                data: [{{ $kamarTerisi }}, {{ $kamarTersedia }}],
                backgroundColor: ['#e8401c', '#22c55e'],
                hoverBackgroundColor: ['#cb3518', '#16a34a'],
                borderWidth: 3,
                borderColor: '#fff',
            }]
        },
        options: {
            responsive: true,
            cutout: '72%',
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => ` ${ctx.label}: ${ctx.parsed} kamar`
                    }
                }
            }
        }
    });
    @endif
</script>
@endpush