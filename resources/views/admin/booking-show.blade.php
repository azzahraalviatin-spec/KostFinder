@extends('admin.layout')

@section('title', 'Detail Booking')
@section('page_title', 'Detail Booking')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <a href="{{ route('admin.bookings') }}" class="btn-kembali-gradasi">
            <i class="bi bi-arrow-left"></i> Kembali ke Monitoring
        </a>
    </div>

    <div class="row">
        <!-- 📄 INFO BOOKING -->
        <div class="col-md-8">
            <div class="card border-0 shadow-sm p-4 mb-4" style="border-radius: 1.2rem;">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0">Informasi Pesanan</h5>
                    <span class="badge rounded-pill px-3 py-2 
                        @if($booking->status_booking == 'pending') bg-warning text-dark 
                        @elseif($booking->status_booking == 'diterima') bg-success 
                        @elseif($booking->status_booking == 'ditolak') bg-danger 
                        @else bg-primary @endif">
                        {{ strtoupper($booking->status_booking) }}
                    </span>
                </div>

                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="text-muted small text-uppercase fw-bold">ID Booking</label>
                        <p class="fw-bold fs-5 text-primary">#BK-{{ $booking->id_booking }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small text-uppercase fw-bold">Tanggal Transaksi</label>
                        <p class="fw-semibold">{{ $booking->created_at->format('d F Y, H:i') }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small text-uppercase fw-bold">Properti</label>
                        <p class="fw-semibold">{{ $booking->room->kost->nama_kost ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small text-uppercase fw-bold">Nomor Kamar</label>
                        <p class="fw-semibold">Kamar {{ $booking->room->nomor_kamar ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small text-uppercase fw-bold">Rencana Check-in</label>
                        <p class="fw-bold text-success"><i class="bi bi-calendar-check me-2"></i>{{ \Carbon\Carbon::parse($booking->tanggal_masuk)->format('d F Y') }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small text-uppercase fw-bold">Durasi Sewa</label>
                        <p class="fw-semibold">{{ $booking->durasi_sewa }} Bulan</p>
                    </div>
                </div>

                <hr class="my-4">

                <h6 class="fw-bold mb-3">Rincian Pembayaran</h6>
                <div class="bg-light p-3 rounded-3">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Harga Sewa ({{ $booking->durasi_sewa }} bln)</span>
                        <span>Rp {{ number_format($booking->total_bayar - $booking->komisi_admin) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Biaya Layanan Admin</span>
                        <span>Rp {{ number_format($booking->komisi_admin) }}</span>
                    </div>
                    <div class="d-flex justify-content-between pt-2 border-top fw-bold fs-5">
                        <span>Total Bayar</span>
                        <span class="text-primary">Rp {{ number_format($booking->total_bayar) }}</span>
                    </div>
                </div>
                <div class="mt-3">
                    <label class="text-muted small fw-bold">Status Pembayaran:</label>
                    <span class="ms-2 fw-bold {{ $booking->status_pembayaran == 'lunas' ? 'text-success' : 'text-danger' }}">
                        {{ strtoupper($booking->status_pembayaran) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- 👤 INFO USER & OWNER -->
        <div class="col-md-4">
            <!-- PENYEWA -->
            <div class="card border-0 shadow-sm p-4 mb-4" style="border-radius: 1.2rem;">
                <h6 class="fw-bold mb-3"><i class="bi bi-person-circle me-2"></i>Penyewa</h6>
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px;">
                        {{ substr($booking->user->name, 0, 1) }}
                    </div>
                    <div>
                        <div class="fw-bold">{{ $booking->user->name }}</div>
                        <div class="text-muted small">{{ $booking->user->email }}</div>
                    </div>
                </div>
                <a href="https://wa.me/{{ $booking->user->no_hp }}" target="_blank" class="btn btn-outline-success btn-sm w-100 rounded-3">
                    <i class="bi bi-whatsapp me-2"></i>Hubungi Penyewa
                </a>
            </div>

            <!-- PEMILIK -->
            <div class="card border-0 shadow-sm p-4 mb-4" style="border-radius: 1.2rem;">
                <h6 class="fw-bold mb-3"><i class="bi bi-house-door me-2"></i>Pemilik Kos</h6>
                <div class="fw-bold text-dark">{{ $booking->room->kost->owner->name ?? '-' }}</div>
                <div class="text-muted small mb-3">{{ $booking->room->kost->owner->email ?? '-' }}</div>
                <a href="https://wa.me/{{ $booking->room->kost->owner->no_hp ?? '' }}" target="_blank" class="btn btn-outline-dark btn-sm w-100 rounded-3">
                    <i class="bi bi-whatsapp me-2"></i>Hubungi Pemilik
                </a>
            </div>

            <!-- AKSI ADMIN -->
            @if($booking->status_booking == 'pending')
            <div class="card border-0 shadow-sm p-4 border-primary" style="border-radius: 1.2rem; background: #f0f7ff;">
                <h6 class="fw-bold mb-3 text-primary">Tindakan Admin</h6>
                <p class="small text-muted">Admin dapat membantu menyetujui atau menolak pesanan ini.</p>
                <div class="d-grid gap-2">
                    <button class="btn btn-success fw-bold rounded-3" onclick="confirmAction('{{ route('admin.bookings.update-status', [$booking, 'diterima']) }}', 'Terima Booking?', 'Setujui pesanan ini sekarang?', 'PATCH', 'success')">
                        Setujui Pesanan
                    </button>
                    <button class="btn btn-danger fw-bold rounded-3" onclick="confirmAction('{{ route('admin.bookings.update-status', [$booking, 'ditolak']) }}', 'Tolak Booking?', 'Batalkan pesanan ini?', 'PATCH', 'danger')">
                        Tolak Pesanan
                    </button>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
    .btn-kembali-gradasi {
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
        background: linear-gradient(135deg, #1e293b, #334155);
        color: #fff;
        padding: 0.6rem 1.4rem;
        border-radius: 0.8rem;
        font-weight: 700;
        font-size: 0.85rem;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    .btn-kembali-gradasi:hover {
        transform: translateY(-2px);
        color: #fff;
        filter: brightness(1.2);
    }
</style>

{{-- Integrasi Modal Konfirmasi --}}
<div class="modal fade" id="confirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 1.2rem;">
            <div class="modal-body p-4 text-center">
                <div id="confirmIconWrap" class="mb-3 mx-auto d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; border-radius: 50%;">
                    <i id="confirmIcon" class="bi fs-2"></i>
                </div>
                <h5 id="confirmTitle" class="fw-bold mb-2"></h5>
                <p id="confirmMessage" class="text-muted small mb-4"></p>
                <form id="confirmForm" method="POST">
                    @csrf
                    <input type="hidden" name="_method" id="confirmMethod" value="POST">
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-light w-100 fw-bold" data-bs-dismiss="modal" style="border-radius: 10px;">Batal</button>
                        <button type="submit" id="confirmSubmitBtn" class="btn w-100 fw-bold" style="border-radius: 10px;">Ya</button>
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

        submitBtn.className = 'btn w-100 fw-bold';
        if(type === 'danger') {
            submitBtn.classList.add('btn-danger');
            iconWrap.style.backgroundColor = '#fee2e2';
            icon.className = 'bi bi-x-circle text-danger fs-2';
        } else {
            submitBtn.classList.add('btn-success');
            iconWrap.style.backgroundColor = '#dcfce7';
            icon.className = 'bi bi-check-circle text-success fs-2';
        }
        modal.show();
    }
</script>
@endsection
