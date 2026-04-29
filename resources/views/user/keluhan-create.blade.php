@extends('layouts.user-sidebar')

@section('title', 'Buat Keluhan')

@section('content')

<div class="container py-4" style="max-width:600px;">

    {{-- INFO KOST --}}
    <div class="card mb-3 shadow-sm" style="border-radius:12px;">
        <div class="card-body">

            <div class="fw-bold">
                {{ $booking->room->kost->nama_kost }}
            </div>

            <div style="font-size:.85rem;color:#777;">
                📍 {{ $booking->room->kost->kota }}
            </div>

            <div style="font-size:.8rem;color:#aaa;">
                🚪 Kamar {{ $booking->room->nomor_kamar }}
            </div>

        </div>
    </div>

    {{-- FORM --}}
    <div class="card shadow-sm" style="border-radius:12px;">
        <div class="card-body">

            <h6 class="fw-bold mb-3">Buat Keluhan</h6>

            <form action="{{ route('keluhan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="booking_id" value="{{ $booking->id_booking }}">

                {{-- JENIS KELUHAN --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Jenis Keluhan</label>
                    <select name="jenis" class="form-control" required>
                        <option value="">-- Pilih --</option>
                        <option>Kamar kotor</option>
                        <option>Fasilitas rusak</option>
                        <option>Air / listrik bermasalah</option>
                        <option>Kebisingan</option>
                        <option>Keamanan</option>
                        <option>Lainnya</option>
                    </select>
                </div>

                {{-- DESKRIPSI --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Detail Keluhan</label>
                    <textarea name="isi" class="form-control" rows="4"
                        placeholder="Contoh: AC tidak dingin sejak kemarin..." required></textarea>
                </div>

                {{-- UPLOAD FOTO --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Upload Bukti (opsional)</label>
                    <input type="file" name="foto" class="form-control">
                </div>

                {{-- BUTTON --}}
                <div class="d-flex gap-2">
                    <a href="{{ route('keluhan.pilih') }}" class="btn btn-outline-secondary w-50">
                        Batal
                    </a>
                    <button class="btn w-50" style="background:#E8401C;color:white;">
                        🚨 Kirim Keluhan
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

@endsection