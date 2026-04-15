@extends('admin.layout')

@section('title', 'Detail Kos')
@section('page_title', 'Detail Kos')

@section('content')

<div class="container-fluid">

    <!-- 🔙 TOMBOL KEMBALI -->
    <div class="mb-3">
        <a href="{{ route('admin.kosts') }}" class="btn btn-light border rounded-3">
            <i class="bi bi-arrow-left"></i> Kembali ke Monitoring Kos
        </a>
    </div>

    <!-- 🔥 FOTO KOS -->
    <div class="card mb-4 overflow-hidden">
        <img src="{{ asset('storage/' . ($kost->foto_utama ?? 'default.jpg')) }}" 
             class="w-100" style="height:250px;object-fit:cover;">
    </div>

    <div class="row">

        <!-- 🔥 INFO UTAMA -->
        <div class="col-md-8">
            <div class="card p-4 mb-3">

                <h4 class="fw-bold mb-3">{{ $kost->nama_kost }}</h4>

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <small class="text-muted">Kota</small>
                        <div class="fw-semibold">{{ $kost->kota }}</div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <small class="text-muted">Tipe</small>
                        <div class="fw-semibold">{{ $kost->tipe }}</div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <small class="text-muted">Harga Mulai</small>
                        <div class="fw-semibold text-primary">Rp {{ number_format($kost->harga_mulai) }}</div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <small class="text-muted">Status</small>
                        <span class="badge bg-success">{{ $kost->status }}</span>
                    </div>

                </div>

                <hr>

                <small class="text-muted">Alamat</small>
                <p class="mb-3">{{ $kost->alamat }}</p>

                <small class="text-muted">Deskripsi</small>
                <p>{{ $kost->deskripsi }}</p>

            </div>
        </div>

        <!-- 🔥 SIDEBAR -->
        <div class="col-md-4">

            <div class="card p-3 mb-3">
                <small class="text-muted">Owner</small>
                <h6 class="fw-bold mb-0">{{ $kost->owner->name ?? '-' }}</h6>
            </div>

            <div class="card p-3 mb-3">
                <small class="text-muted">Verifikasi</small>
                <span class="badge bg-warning">{{ $kost->is_verified ? 'Terverifikasi' : 'Belum' }}</span>
            </div>

            <div class="card p-3">
                <small class="text-muted">Total Booking</small>
                <h4 class="fw-bold">{{ $bookingCount }}</h4>
            </div>

        </div>

    </div>

    <!-- 🔥 KAMAR -->
    <div class="card mt-3">

        <div class="p-3 border-bottom fw-bold">
            Daftar Kamar
        </div>

        <div class="p-3">

            @if($kost->rooms->isEmpty())
                <div class="text-center text-muted py-4">
                    🚫 Belum ada kamar
                </div>
            @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>No Kamar</th>
                            <th>Harga</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($kost->rooms as $room)
                        <tr>
                            <td>{{ $room->nomor_kamar }}</td>
                            <td>Rp {{ number_format($room->harga) }}</td>
                            <td>
                                <span class="badge bg-success">{{ $room->status }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>
            @endif

        </div>

    </div>

</div>

@endsection