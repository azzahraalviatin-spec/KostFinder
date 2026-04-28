@extends('admin.layout')

@section('title', 'Monitoring Booking')
@section('page_title', 'Monitoring Booking')

@push('styles')
<style>
    /* ══════════════════════════════════════════
       STAT CARDS — matching KostFinder dashboard
    ══════════════════════════════════════════ */
.stat-row {
    display: grid;
    grid-template-columns: repeat(5, minmax(0, 1fr));
    gap: 1rem;
    margin-bottom: 1.8rem;
}

@media (max-width: 1200px) {
    .stat-row { grid-template-columns: repeat(3, 1fr); }
}
@media (max-width: 768px) {
    .stat-row { grid-template-columns: repeat(2, 1fr); }
}
.stat-card {
    background: #fff;
    border-radius: 16px;
    padding: 1.1rem 1.1rem;
    display: flex;
    align-items: center;
    gap: .9rem;
    border: 1px solid #eef2f7;
    box-shadow: 0 4px 14px rgba(0,0,0,.06);
    transition: all .25s ease;
    position: relative;
    overflow: hidden;
}

.stat-card::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, transparent, rgba(232,64,28,.06));
    opacity: 0;
    transition: .3s;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 28px rgba(232,64,28,.15);
}

.stat-card:hover::after {
    opacity: 1;
}
    .stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 22px rgba(0,0,0,.09); }

    .stat-icon-wrap {
        width: 46px; height: 46px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.15rem; flex-shrink: 0;
    }
    .stat-icon-wrap.c-total    { background: #ede9fe; color: #7c3aed; }
    .stat-icon-wrap.c-pending  { background: #fff3cd; color: #d97706; }
    .stat-icon-wrap.c-diterima { background: #d1fae5; color: #059669; }
    .stat-icon-wrap.c-selesai  { background: #f1f5f9; color: #64748b; }
    .stat-icon-wrap.c-income   { background: #fee2e2; color: #e8401c; }

    .stat-body  { min-width: 0; }
    .stat-num   { font-size: 1.45rem; font-weight: 800; color: #1e2d3d; line-height: 1.1; }
    .stat-lbl   { font-size: .72rem; color: #94a3b8; font-weight: 600; margin-top: .15rem; }
    .stat-sub   { font-size: .67rem; font-weight: 700; margin-top: .1rem; }
    .stat-sub.c-total    { color: #7c3aed; }
    .stat-sub.c-pending  { color: #d97706; }
    .stat-sub.c-diterima { color: #059669; }
    .stat-sub.c-selesai  { color: #64748b; }
    .stat-sub.c-income   { color: #e8401c; }
    .stat-num.income-num { font-size: .88rem; line-height: 1.3; word-break: break-all; }

    /* ══════════════════════════════════════════
       TABLE SECTION
    ══════════════════════════════════════════ */
 .table-section {
    width: 100%;
    background: #fff;
    border-radius: 18px;
    border: 1px solid #eef2f7;
    overflow: hidden;
    box-shadow: 0 6px 18px rgba(0,0,0,.06);
}
.content {
    padding: 1.5rem 1.8rem;
}
.booking-table tbody tr {
    transition: all .15s ease;
}

.booking-table tbody tr:hover {
    background: #f9fbff;
    transform: scale(1.002);
}
.booking-table thead th {
    background: #f9fafc;
    font-size: .65rem;
    letter-spacing: .08em;
}
    .table-header {
        padding: 1rem 1.4rem;
        border-bottom: 1px solid #f0f4f8;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: .75rem;
    }
    .table-title {
        font-size: .9rem; font-weight: 800; color: #1e2d3d;
        display: flex; align-items: center; gap: .5rem;
    }
    .table-title-dot {
        width: 8px; height: 8px; border-radius: 50%; background: #e8401c;
    }

    /* Filter Pills */
    .filter-wrap {
        display: flex; gap: .25rem; flex-wrap: wrap;
        background: #f8fafd; padding: .3rem; border-radius: 99px;
        border: 1px solid #f0f4f8;
    }
    .fpill {
        padding: .3rem .88rem; border-radius: 99px;
        font-size: .7rem; font-weight: 700; color: #64748b;
        text-decoration: none; transition: all .2s; white-space: nowrap;
    }
    .fpill:hover { color: #1e2d3d; background: rgba(0,0,0,.05); text-decoration: none; }
    .fpill.active { color: #fff; box-shadow: 0 2px 8px rgba(0,0,0,.15); }
    .fpill.active.f-semua    { background: #1e2d3d; }
    .fpill.active.f-pending  { background: #f59e0b; }
    .fpill.active.f-diterima { background: #10b981; }
    .fpill.active.f-ditolak  { background: #ef4444; }
    .fpill.active.f-selesai  { background: #64748b; }

    /* Table */
    .booking-table            { width: 100%; border-collapse: collapse; }
    .booking-table thead th   {
        font-size: .65rem; font-weight: 800; color: #94a3b8;
        letter-spacing: .09em; text-transform: uppercase;
        padding: .85rem 1.1rem;
        background: #f8fafd; border-bottom: 1px solid #f0f4f8;
        white-space: nowrap;
    }
    .booking-table tbody td {
        font-size: .8rem; color: #334155;
        padding: .85rem 1.1rem;
        border-bottom: 1px solid #f8fafd;
        vertical-align: middle;
    }
    .booking-table tbody tr:last-child td { border-bottom: 0; }
    .booking-table tbody tr:hover         { background: #fafbff; transition: background .15s; }

    /* Avatar */
    .avatar-circle {
        width: 34px; height: 34px; border-radius: 50%;
        color: #fff; font-weight: 800; font-size: .74rem;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; box-shadow: 0 2px 6px rgba(0,0,0,.12);
    }

    /* Status Badges */
    .sbadge {
        padding: .28rem .78rem; border-radius: 99px;
        font-size: .67rem; font-weight: 700;
        display: inline-flex; align-items: center; gap: .32rem;
        white-space: nowrap;
    }
    .sbadge-pending    { background: #fff7ed; color: #ea580c; }
    .sbadge-diterima   { background: #f0fdf4; color: #16a34a; }
    .sbadge-ditolak    { background: #fef2f2; color: #dc2626; }
    .sbadge-selesai    { background: #f1f5f9; color: #64748b; }
    .sbadge-dibatalkan { background: #f8fafc; color: #94a3b8; }
    .sbadge-dot { width: 6px; height: 6px; border-radius: 50%; background: currentColor; flex-shrink: 0; }

    /* Action Button */
    .abtn {
        width: 30px; height: 30px; border-radius: 8px; border: 0;
        display: inline-flex; align-items: center; justify-content: center;
        font-size: .8rem; cursor: pointer; transition: all .18s; text-decoration: none;
    }
    .abtn:hover { transform: translateY(-2px); filter: brightness(.9); text-decoration: none; }
    .abtn-detail { background: #e0f2fe; color: #0369a1; }

    /* Empty State */
    .empty-state { padding: 3.5rem 1rem; text-align: center; }
    .empty-icon  { font-size: 2.5rem; color: #cbd5e1; display: block; margin-bottom: .75rem; }
    .empty-state p { color: #94a3b8; font-size: .82rem; margin: 0; font-weight: 500; }

    /* Pagination */
    .pagination-wrap { padding: .85rem 1.4rem; border-top: 1px solid #f0f4f8; }
    .pagination .page-link {
        font-size: .73rem; font-weight: 600; color: #64748b;
        border-radius: 8px !important; border: 1px solid #e8edf5;
        margin: 0 2px; padding: .35rem .65rem;
    }
    .pagination .page-item.active .page-link { background: #e8401c; border-color: #e8401c; color: #fff; }
    .pagination .page-link:hover { background: #f1f5f9; color: #1e2d3d; }
    .pagination .page-item.disabled .page-link { opacity: .5; }
</style>
@endpush

@section('content')
<div class="container-fluid px-0">

{{-- Alert --}}
@if(session('status'))
    <div class="alert alert-success alert-dismissible fade show mb-4 border-0 shadow-sm"
         style="border-radius:12px; font-size:.83rem; font-weight:600;">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('status') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
    </div>
@endif

{{-- ══ STAT CARDS ══ --}}
<div class="stat-row">

    <div class="stat-card">
        <div class="stat-icon-wrap c-total"><i class="bi bi-journal-text"></i></div>
        <div>
            <div class="stat-num">{{ $allBookings->count() }}</div>
            <div class="stat-lbl">Total Booking</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon-wrap c-pending"><i class="bi bi-hourglass-split"></i></div>
        <div>
            <div class="stat-num">{{ $allBookings->where('status_booking','pending')->count() }}</div>
            <div class="stat-lbl">Pending</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon-wrap c-diterima"><i class="bi bi-check2-circle"></i></div>
        <div>
            <div class="stat-num">{{ $allBookings->where('status_booking','diterima')->count() }}</div>
            <div class="stat-lbl">Diterima</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon-wrap c-selesai"><i class="bi bi-flag-fill"></i></div>
        <div>
            <div class="stat-num">{{ $allBookings->where('status_booking','selesai')->count() }}</div>
            <div class="stat-lbl">Selesai</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon-wrap c-income"><i class="bi bi-wallet2"></i></div>
        <div>
            <div class="stat-num income-num">
                Rp{{ number_format($allBookings->where('status_booking','selesai')->sum('total_bayar'),0,',','.') }}
            </div>
            <div class="stat-lbl">Total Transaksi</div>
        </div>
    </div>

</div>

{{-- ══ TABLE ══ --}}
<div class="table-section">
    <div class="table-header">
        <div class="table-title">
            <div class="table-title-dot"></div>
            Daftar Booking
        </div>

        <div class="filter-wrap">
            @foreach(['semua' => 'Semua', 'pending' => 'Pending', 'diterima' => 'Diterima', 'ditolak' => 'Ditolak', 'selesai' => 'Selesai'] as $key => $label)
                <a href="?status={{ $key }}"
                   class="fpill f-{{ $key }} {{ $activeStatus === $key ? 'active' : '' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>
    </div>

    <div class="table-responsive">
        <table class="booking-table">
            <thead>
                <tr>
                    <th style="width:46px; text-align:center;">#</th>
                    <th>Penyewa &amp; Kamar</th>
                    <th>Kost</th>
                    <th>Durasi</th>
                    <th>Total Bayar</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th style="text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $i => $booking)
                <tr>
                    <td style="text-align:center; color:#94a3b8; font-weight:800; font-size:.73rem;">
                        {{ $i + 1 }}
                    </td>

                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="avatar-circle"
                                 style="background:hsl({{ ($booking->user_id * 47) % 360 }},55%,48%)">
                                {{ strtoupper(mb_substr($booking->user->name ?? 'U', 0, 1)) }}
                            </div>
                            <div>
                                <div style="font-size:.82rem; font-weight:700; color:#1e2d3d; white-space:nowrap;">
                                    {{ $booking->user->name ?? '-' }}
                                </div>
                                <div style="font-size:.7rem; color:#94a3b8;">
                                    Kamar {{ $booking->room->nomor_kamar ?? '-' }}
                                </div>
                            </div>
                        </div>
                    </td>

                    <td style="font-size:.78rem; color:#475569; font-weight:500; max-width:160px;">
                        {{ $booking->room->kost->nama_kost ?? '-' }}
                    </td>

                    <td style="white-space:nowrap;">
                        <div style="font-size:.8rem; font-weight:700; color:#1e2d3d;">
                            {{ $booking->jumlah_durasi ?? $booking->durasi_sewa ?? '-' }}
                            {{ ucfirst($booking->tipe_durasi ?? 'Bulanan') }}
                        </div>
                        <div style="font-size:.7rem; color:#94a3b8;">
                            Mulai {{ \Carbon\Carbon::parse($booking->tanggal_masuk)->translatedFormat('d M Y') }}
                        </div>
                    </td>

                    <td style="white-space:nowrap;">
                        <div style="font-size:.82rem; font-weight:800; color:#1e2d3d;">
                            Rp{{ number_format($booking->total_bayar, 0, ',', '.') }}
                        </div>
                    </td>

                    <td>
                        <span class="sbadge sbadge-{{ $booking->status_booking }}">
                            <div class="sbadge-dot"></div>
                            {{ ucfirst($booking->status_booking) }}
                        </span>
                    </td>

                    <td style="white-space:nowrap; font-size:.74rem; color:#64748b;">
                        {{ $booking->created_at->translatedFormat('d M Y') }}
                    </td>

                    <td style="text-align:center;">
                        <a href="{{ route('admin.bookings.show', $booking->id_booking) }}"
                           class="abtn abtn-detail" title="Lihat Detail">
                            <i class="bi bi-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8">
                        <div class="empty-state">
                            <i class="bi bi-inbox empty-icon"></i>
                            <p>Belum ada data booking.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($bookings->hasPages())
        <div class="pagination-wrap d-flex justify-content-end">
            {{ $bookings->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>

@endsection