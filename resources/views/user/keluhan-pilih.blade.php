@extends('layouts.user-sidebar')

@section('title', 'Pilih Pesanan')

@section('content')

<div class="container py-4">

    <h5 class="fw-bold mb-1">Pesanan Aktif</h5>
    <p class="text-muted" style="font-size: .85rem;">
        Pilih pesanan aktif yang Kamu ingin Keluhkan
    </p>

    <a href="{{ route('keluhan.index') }}" class="btn btn-sm btn-outline-secondary mb-3">
        ← Kembali
    </a>

    <div class="row">
        @forelse($bookings as $b)
            <div class="col-md-4 mb-4">

                <div class="card shadow-sm h-100" style="border-radius:12px;overflow:hidden;">

                    {{-- GAMBAR --}}
                    <img 
                        src="{{ asset('storage/' . $b->room->kost->foto_utama) }}"
                        onerror="this.src='https://via.placeholder.com/300x150?text=No+Image'"
                        style="height:150px;object-fit:cover;width:100%;"
                    >

                    <div class="card-body">

                        <div class="fw-bold" style="font-size:.9rem;">
                            {{ $b->room->kost->nama_kost }}
                        </div>

                        <div style="font-size:.8rem;color:#777;">
                            📍 {{ $b->room->kost->kota }}
                        </div>

                        <div style="font-size:.75rem;color:#aaa;">
                            🚪 Kamar {{ $b->room->nomor_kamar }}
                        </div>

                        <div style="font-size:.75rem;color:#aaa;">
                            {{ \Carbon\Carbon::parse($b->created_at)->translatedFormat('d M Y') }}
                        </div>

                        <a href="{{ route('keluhan.create', $b->id_booking) }}"
                           class="btn btn-sm w-100 mt-3"
                           style="background:#E8401C;color:#fff;">
                           🚨 Keluhkan
                        </a>

                    </div>
                </div>

            </div>
        @empty
            <div class="text-center text-muted mt-5">
                Tidak ada pesanan 😢
            </div>
        @endforelse
    </div>

</div>

@endsection