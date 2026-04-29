@extends('layouts.app')

@section('title', 'Hubungi Kami')

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<style>
/* ══════════════════════════════════════
   HERO HEADER
══════════════════════════════════════ */
/* ══════════════════════════════════════
   HERO HEADER — Image Background Lokal
══════════════════════════════════════ */
.hk-hero-img {
    height: 350px;
    background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), 
                url('{{ asset('images/hubungi.jpg') }}'); /* Ganti jadi ini wee! */
    background-size: cover;
    background-position: center;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    text-align: center;
}
.hk-hero-img h1 { font-size: 3rem; font-weight: 800; text-shadow: 2px 2px 8px rgba(0,0,0,0.5); }

/* ══════════════════════════════════════
   CONTENT
══════════════════════════════════════ */
.hk-body { padding: 4rem 0; background: #f8fafc; }
.hk-panel { background: #fff; border-radius: 1.5rem; padding: 2rem; box-shadow: 0 10px 30px rgba(0,0,0,0.05); height: 100%; }
.hk-panel-title { font-size: 1.1rem; font-weight: 800; text-transform: uppercase; margin-bottom: 1.5rem; color: #1a1919; }

/* Contact Items */
.contact-item { display: flex; gap: 1rem; margin-bottom: 1.5rem; }
.contact-item i { font-size: 1.4rem; color: #E8401C; }
.contact-item p { margin: 0; font-size: 0.9rem; color: #4b5563; }
.contact-item strong { display: block; color: #111827; }

/* Media Sosial Tengah & Besar */
.social-container {
    display: flex;
    justify-content: center;
    gap: 2.5rem; /* Memberi jarak antar icon */
    margin: 2rem 0;
    padding: 1.5rem;
    border-top: 1px solid #f3f4f6;
}
.social-container a { 
    font-size: 2rem; /* Ukuran lebih besar */
    color: #374151; 
    transition: 0.3s transform; 
}
.social-container a:hover { transform: scale(1.2); color: #E8401C; }


/* Leaflet Map */
#map { height: 220px; border-radius: 1rem; margin-top: 1rem; border: 1px solid #e5e7eb; }

/* Gallery Database */
.gallery-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem; }
.gallery-item { border-radius: 0.8rem; overflow: hidden; aspect-ratio: 4/3; position: relative; }
.gallery-item img { width: 100%; height: 100%; object-fit: cover; }
.gallery-price { position: absolute; bottom: 0; width: 100%; background: rgba(0,0,0,0.6); color: #fff; font-size: 0.7rem; padding: 5px; text-align: center; }

.btn-all-kos { background: #E8401C; color: #fff; width: 100%; padding: 0.8rem; border-radius: 0.6rem; font-weight: 700; border: none; }

/* ══════════════════════════════════════
   FOOTER
══════════════════════════════════════ */
.main-footer { background: #111827; color: #9ca3af; padding: 3rem 0 1.5rem; font-size: 0.85rem; }
.footer-logo { font-size: 1.5rem; font-weight: 800; color: #fff; margin-bottom: 1rem; }
.footer-logo span { color: #E8401C; }
</style>
@endsection

@section('content')

<section class="hk-hero-img">
    <h1>Hubungi Kami</h1>
</section>

<section class="hk-body">
    <div class="container">
        <div class="row g-4">
            
            <div class="col-lg-5">
                <div class="hk-panel text-center"> <h2 class="hk-panel-title text-start">Kontak Utama</h2>
                    
                    <div class="text-start">
                        <div class="contact-item">
                            <i class="bi bi-envelope"></i>
                            <div><strong>Email:</strong><p>{{ $siteSettings->email_support ?? 'support@kostfinder.com' }}</p></div>
                        </div>
                        <div class="contact-item">
                            <i class="bi bi-geo-alt"></i>
                            <div><strong>Alamat Kantor:</strong><p>{!! nl2br(e($siteSettings->alamat_kantor ?? "Dusun Banjar, Desa Banjarkemantren RT 01/RW 04, \nKec. Buduran, Sidoarjo, 61252")) !!}</p></div>
                        </div>
                    </div>

                    <div class="social-container">
                        @if($siteSettings->instagram_link)
                            <a href="{{ $siteSettings->instagram_link }}" target="_blank" title="Instagram KostFinder"><i class="bi bi-instagram"></i></a>
                        @endif
                        @if($siteSettings->facebook_link)
                            <a href="{{ $siteSettings->facebook_link }}" target="_blank" title="Facebook KostFinder"><i class="bi bi-facebook"></i></a>
                        @endif
                        @if($siteSettings->tiktok_link)
                            <a href="{{ $siteSettings->tiktok_link }}" target="_blank" title="TikTok KostFinder"><i class="bi bi-tiktok"></i></a>
                        @endif
                        @if($siteSettings->whatsapp_cs)
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siteSettings->whatsapp_cs) }}" target="_blank" title="WhatsApp KostFinder"><i class="bi bi-whatsapp"></i></a>
                        @endif
                    </div>

                    <div id="map"></div>
                </div>
            </div>

            <div class="col-lg-7">
    <div class="hk-panel">
        <h2 class="hk-panel-title">Galeri Properti Terbaik</h2>
        
        <div class="gallery-grid">
            @foreach($kosts as $item)
                <div class="gallery-item">
                    {{-- Menggunakan accessor foto_utama_url dari model Kost --}}
                    <img src="{{ $item->foto_utama_url }}" alt="{{ $item->nama_kost }}">
                    <div class="gallery-price">
                        <strong>{{ $item->nama_kost }}</strong> <br>
                        <small>Rp {{ number_format($item->harga_mulai, 0, ',', '.') }}/bulan</small>
                    </div>
                </div>
            @endforeach
        </div>

        <a href="{{ route('kost.cari') }}" class="btn btn-all-kos">LIHAT SEMUA KOS TERVERIFIKASI</a>    </div>
</div>

        </div>
    </div>
</section>



@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    var map = L.map('map').setView([-7.4215, 112.7212], 15);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    L.marker([-7.4215, 112.7212]).addTo(map)
        .bindPopup('<b>Kantor KostFinder</b><br>Desa Banjarkemantren, Sidoarjo')
        .openPopup();
</script>
@endsection

