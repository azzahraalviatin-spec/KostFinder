@extends('admin.layout')

@section('title', 'Detail Kos')
@section('page_title', 'Detail Kos')

@section('content')

<div class="container-fluid">

    <!-- 🔙 TOMBOL KEMBALI -->
    <div class="mb-4">
        <a href="{{ route('admin.kosts') }}" class="btn-kembali-gradasi">
            <i class="bi bi-arrow-left"></i> Kembali ke Monitoring Kos
        </a>
    </div>

    <!-- 🔥 FOTO KOS -->
    <div class="card mb-4 overflow-hidden border-0 shadow-sm" style="border-radius: 1.2rem;">
        <img src="{{ asset('storage/' . ($kost->foto_utama ?? 'default.jpg')) }}" 
             class="w-100" style="height: 450px; object-fit: cover; border-radius: 1.2rem;">
    </div>

    <style>
        .btn-kembali-gradasi {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            background: linear-gradient(135deg, #e8401c, #ff7043);
            color: #fff;
            padding: 0.6rem 1.4rem;
            border-radius: 0.8rem;
            font-weight: 700;
            font-size: 0.85rem;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            box-shadow: 0 4px 15px rgba(232, 64, 28, 0.25);
        }
        .btn-kembali-gradasi:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(232, 64, 28, 0.35);
            color: #fff;
            filter: brightness(1.1);
        }
        .btn-kembali-gradasi i {
            font-size: 1.1rem;
        }
    </style>

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