@extends('admin.layout')

@section('title', 'Monitoring Booking')
@section('page_title', 'Monitoring Booking')
@section('page_subtitle', 'Filter booking berdasarkan status dan rentang tanggal')

@section('content')
<div class="card-panel">

    <!-- 🔍 FILTER -->
    <form method="GET" action="{{ route('admin.bookings') }}" class="row g-2 mb-4">
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">Semua status</option>
                <option value="pending" @selected(request('status') === 'pending')>Pending</option>
                <option value="diterima" @selected(request('status') === 'diterima')>Diterima</option>
                <option value="ditolak" @selected(request('status') === 'ditolak')>Ditolak</option>
                <option value="selesai" @selected(request('status') === 'selesai')>Selesai</option>
            </select>
        </div>

        <div class="col-md-3">
            <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control">
        </div>

        <div class="col-md-3">
            <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control">
        </div>

        <div class="col-md-3 d-flex gap-2">
            <button type="submit" class="btn btn-primary w-100">Filter</button>
            <a href="{{ route('admin.bookings') }}" class="btn btn-outline-secondary w-100">Reset</a>
        </div>
    </form>

    <!-- 📊 TABLE -->
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>User</th>
                    <th>Kos</th>
                    <th>Kamar</th>
                    <th>Tanggal Masuk</th>
                    <th>Durasi</th>
                    <th>Pembayaran</th>
                    <th>Status</th>
                  
                </tr>
            </thead>

            <tbody>
                @forelse($bookings as $booking)
                <tr>

                    <!-- 🔥 NOMOR URUT -->
                    <td>{{ $loop->iteration }}</td>

                    <!-- 👤 USER -->
                    <td>
                        <div class="fw-semibold">{{ $booking->user->name ?? '-' }}</div>
                        <small class="text-muted">{{ $booking->user->email ?? '-' }}</small>
                    </td>

                    <!-- 🏠 KOS -->
                    <td>
                        {{ $booking->room->kost->nama_kost ?? '-' }}
                    </td>

                    <!-- 🚪 KAMAR -->
                    <td>
                        Kamar {{ $booking->room->nomor_kamar ?? '-' }}
                    </td>

                    <!-- 📅 TANGGAL -->
                    <td>
                        {{ \Carbon\Carbon::parse($booking->tanggal_masuk)->format('d M Y') }}
                    </td>

                    <!-- ⏳ DURASI -->
                    <td>
                        {{ (int) $booking->durasi_sewa }} bulan
                    </td>

                   
                    <!-- 💰 STATUS PEMBAYARAN -->
                    <td>
                        @if($booking->status_pembayaran == 'belum')
                            <span class="badge bg-danger">Belum Bayar</span>
                        @elseif($booking->status_pembayaran == 'pending')
                            <span class="badge bg-warning text-dark">Menunggu</span>
                        @else
                            <span class="badge bg-success">Lunas</span>
                        @endif
                    </td>

                    <!-- 🔥 STATUS BOOKING -->
                    <td>
                        @if($booking->status_booking == 'pending')
                            <span class="badge bg-warning text-dark">Menunggu</span>
                        @elseif($booking->status_booking == 'diterima')
                            <span class="badge bg-success">Diterima</span>
                        @elseif($booking->status_booking == 'ditolak')
                            <span class="badge bg-danger">Ditolak</span>
                        @elseif($booking->status_booking == 'selesai')
                            <span class="badge bg-primary">Selesai</span>
                        @else
                            <span class="badge bg-secondary">{{ $booking->status_booking }}</span>
                        @endif
                    </td>


                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-5">
                        <i class="bi bi-inbox" style="font-size:40px;color:#cbd5e1;"></i>
                        <p class="text-muted mt-2 mb-0">Belum ada booking</p>
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>
    </div>

    <!-- 🔢 PAGINATION -->
    <div class="mt-3">
        {{ $bookings->links() }}
    </div>

</div>
@endsection