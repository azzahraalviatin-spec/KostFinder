@extends('admin.layout')

@section('title', 'Monitoring Booking')
@section('page_title', 'Monitoring Booking')
@section('page_subtitle', 'Filter booking berdasarkan status dan rentang tanggal')

@section('content')
<style>
    .card-panel {
        background: #fff;
        border-radius: 1rem;
        border: none;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        padding: 1.5rem;
    }
    .table thead th {
        background: #f8fafc;
        color: #64748b;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        border-top: none;
        padding: 1rem;
    }
    .table tbody td {
        padding: 1.2rem 1rem;
        color: #334155;
        font-size: 0.85rem;
        border-bottom: 1px solid #f1f5f9;
    }
    .badge-pill {
        padding: 0.45rem 0.8rem;
        border-radius: 999px;
        font-weight: 700;
        font-size: 0.68rem;
    }
    .btn-action {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        transition: all 0.2s;
        border: none;
        text-decoration: none;
    }
    .btn-action:hover { transform: translateY(-2px); }
    .btn-approve { background: #dcfce7; color: #15803d; }
    .btn-reject { background: #fee2e2; color: #b91c1c; }
    .btn-delete { background: #f1f5f9; color: #64748b; }
    
    .filter-box {
        background: #f8fafc;
        padding: 1.2rem;
        border-radius: 12px;
        margin-bottom: 1.5rem;
        border: 1px solid #e2e8f0;
    }
</style>

<div class="card-panel">
    <!-- 🔍 FILTER -->
    <div class="filter-box">
        <form method="GET" action="{{ route('admin.bookings') }}" class="row g-3">
            <div class="col-md-3">
                <label class="form-label small fw-bold text-muted">Status Booking</label>
                <select name="status" class="form-select" style="border-radius: 10px;">
                    <option value="">Semua Status</option>
                    <option value="pending" @selected(request('status') === 'pending')>⏳ Pending</option>
                    <option value="diterima" @selected(request('status') === 'diterima')>✅ Diterima</option>
                    <option value="ditolak" @selected(request('status') === 'ditolak')>❌ Ditolak</option>
                    <option value="selesai" @selected(request('status') === 'selesai')>🏁 Selesai</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-bold text-muted">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control" style="border-radius: 10px;">
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-bold text-muted">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control" style="border-radius: 10px;">
            </div>
            <div class="col-md-3 d-flex align-items-end gap-2">
                <button type="submit" class="btn btn-primary w-100 fw-bold" style="border-radius: 10px; padding: 0.6rem;">Filter</button>
                <a href="{{ route('admin.bookings') }}" class="btn btn-outline-secondary w-100 fw-bold" style="border-radius: 10px; padding: 0.6rem;">Reset</a>
            </div>
        </form>
    </div>

    <!-- 📊 TABLE -->
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th width="50">No</th>
                    <th>Penyewa</th>
                    <th>Properti & Kamar</th>
                    <th>Check-in</th>
                    <th class="text-center">Durasi</th>
                    <th>Pembayaran</th>
                    <th>Status</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($bookings as $booking)
                <tr>
                    <td class="text-muted">{{ $loop->iteration }}</td>
                    <td>
                        <div class="fw-bold text-dark">{{ $booking->user->name ?? '-' }}</div>
                        <div class="text-muted small">{{ $booking->user->email ?? '-' }}</div>
                    </td>
                    <td>
                        <div class="fw-semibold text-primary">{{ $booking->room->kost->nama_kost ?? '-' }}</div>
                        <div class="small text-muted"><i class="bi bi-door-open me-1"></i>Kamar {{ $booking->room->nomor_kamar ?? '-' }}</div>
                    </td>
                    <td>
                        <div class="fw-medium"><i class="bi bi-calendar3 me-2 text-muted"></i>{{ \Carbon\Carbon::parse($booking->tanggal_masuk)->format('d M Y') }}</div>
                    </td>
                    <td class="text-center">
                        <span class="badge bg-light text-dark border">{{ (int) $booking->durasi_sewa }} bulan</span>
                    </td>
                    <td>
                        @if($booking->status_pembayaran == 'belum')
                            <span class="badge badge-pill bg-danger-subtle text-danger" style="background:#fee2e2; color:#b91c1c;">Belum Bayar</span>
                        @elseif($booking->status_pembayaran == 'pending')
                            <span class="badge badge-pill bg-warning-subtle text-warning text-dark" style="background:#fef9c3; color:#a16207;">Menunggu</span>
                        @else
                            <span class="badge badge-pill bg-success-subtle text-success" style="background:#dcfce7; color:#15803d;">Lunas</span>
                        @endif
                    </td>
                    <td>
                        @if($booking->status_booking == 'pending')
                            <span class="badge badge-pill bg-warning text-dark" style="background:#fbbf24;">Pending</span>
                        @elseif($booking->status_booking == 'diterima')
                            <span class="badge badge-pill bg-success" style="background:#10b981;">Diterima</span>
                        @elseif($booking->status_booking == 'ditolak')
                            <span class="badge badge-pill bg-danger" style="background:#ef4444;">Ditolak</span>
                        @elseif($booking->status_booking == 'selesai')
                            <span class="badge badge-pill bg-primary" style="background:#3b82f6;">Selesai</span>
                        @else
                            <span class="badge badge-pill bg-secondary">{{ $booking->status_booking }}</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('admin.bookings.show', $booking) }}" class="btn-action btn-detail" title="Lihat Detail">
                                <i class="bi bi-eye-fill"></i>
                            </a>
                            
                            @if($booking->status_booking == 'pending')
                                <button type="button" class="btn-action btn-approve" 
                                        onclick="confirmAction('{{ route('admin.bookings.update-status', [$booking, 'diterima']) }}', 'Terima Booking?', 'Apakah Anda yakin ingin menyetujui pesanan kost ini?', 'PATCH', 'success')"
                                        title="Terima">
                                    <i class="bi bi-check-lg"></i>
                                </button>
                                <button type="button" class="btn-action btn-reject" 
                                        onclick="confirmAction('{{ route('admin.bookings.update-status', [$booking, 'ditolak']) }}', 'Tolak Booking?', 'Apakah Anda yakin ingin menolak pesanan kost ini?', 'PATCH', 'danger')"
                                        title="Tolak">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-1 d-block mb-2 opacity-25"></i>
                        Belum ada data booking yang ditemukan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- 🔢 PAGINATION -->
    <div class="mt-4">
        {{ $bookings->links() }}
    </div>
</div>

{{-- ── MODAL KONFIRMASI GLOBAL ── --}}
@if(!View::hasSection('has_confirm_modal'))
@section('has_confirm_modal', true)
<div class="modal fade" id="confirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 1.2rem;">
            <div class="modal-body p-4 text-center">
                <div id="confirmIconWrap" class="mb-3 mx-auto d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; border-radius: 50%;">
                    <i id="confirmIcon" class="fs-2"></i>
                </div>
                <h5 id="confirmTitle" class="fw-bold mb-2"></h5>
                <p id="confirmMessage" class="text-muted small mb-4"></p>
                
                <form id="confirmForm" method="POST">
                    @csrf
                    <input type="hidden" name="_method" id="confirmMethod" value="POST">
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-light w-100 fw-bold" data-bs-dismiss="modal" style="border-radius: 10px; padding: 0.6rem;">Batal</button>
                        <button type="submit" id="confirmSubmitBtn" class="btn w-100 fw-bold" style="border-radius: 10px; padding: 0.6rem;">Ya, Lanjutkan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmAction(url, title, message, method, type) {
        const modal = new bootstrap.Modal(document.getElementById('confirmModal'));
        const form = document.getElementById('confirmForm');
        const titleEl = document.getElementById('confirmTitle');
        const msgEl = document.getElementById('confirmMessage');
        const methodInput = document.getElementById('confirmMethod');
        const submitBtn = document.getElementById('confirmSubmitBtn');
        const iconWrap = document.getElementById('confirmIconWrap');
        const icon = document.getElementById('confirmIcon');

        form.action = url;
        titleEl.innerText = title;
        msgEl.innerText = message;
        methodInput.value = method;

        // Reset classes
        submitBtn.className = 'btn w-100 fw-bold';
        iconWrap.className = 'mb-3 mx-auto d-flex align-items-center justify-content-center';
        icon.className = 'bi fs-2';

        if (type === 'danger') {
            submitBtn.classList.add('btn-danger');
            iconWrap.style.backgroundColor = '#fee2e2';
            icon.classList.add('bi-exclamation-triangle', 'text-danger');
        } else if (type === 'success') {
            submitBtn.classList.add('btn-success');
            iconWrap.style.backgroundColor = '#dcfce7';
            icon.classList.add('bi-patch-check', 'text-success');
        } else if (type === 'warning') {
            submitBtn.classList.add('btn-warning');
            iconWrap.style.backgroundColor = '#fef9c3';
            icon.classList.add('bi-hourglass-split', 'text-warning');
        }

        modal.show();
    }
</script>
@endif
@endsection