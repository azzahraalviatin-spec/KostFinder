{{-- ══ FOOTER ══ --}}
<style>
  .kf-footer {
    position: relative;
    color: #cbd5e1;
    background: #0f172a;
    overflow: hidden;
  }

  .kf-footer::before {
    content: "";
    position: absolute; inset: 0;
    background: 
      radial-gradient(circle at 10% -10%, rgba(242,116,65,0.1) 0, rgba(242,116,65,0) 40%),
      radial-gradient(circle at 90% 110%, rgba(242,116,65,0.05) 0, rgba(242,116,65,0) 40%);
    pointer-events: none;
  }

  .kf-footer-wrap { position: relative; z-index: 1; padding: 4rem 0 1.5rem; }

  .kf-brand { color: #fff; font-size: 1.7rem; font-weight: 800; letter-spacing: -.02em; margin-bottom: .8rem; }
  .kf-brand span { color: #f27441; }

  .kf-desc { color: #94a3b8; max-width: 360px; font-size: .92rem; margin-bottom: 1.5rem; line-height: 1.6; }

  .kf-social { display: inline-flex; gap: .8rem; }
  .kf-social a {
    width: 40px; height: 40px; border-radius: 50%;
    border: 1px solid rgba(242,116,65,.2);
    color: #cbd5e1;
    display: inline-grid; place-items: center;
    text-decoration: none; transition: all .3s ease;
    background: rgba(255,255,255,.03);
  }
  .kf-social a:hover { 
    color: #fff; 
    border-color: #f27441; 
    background: #f27441;
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(242,116,65,0.2);
  }

  .kf-head { color: #fff; font-size: .85rem; letter-spacing: .1em; text-transform: uppercase; margin-bottom: 1.2rem; font-weight: 700; position: relative; }
  .kf-head::after { content: ''; position: absolute; left: 0; bottom: -6px; width: 30px; height: 2px; background: #f27441; }

  .kf-links { list-style: none; margin: 0; padding: 0; }
  .kf-links li { margin-bottom: .7rem; }
  .kf-links a { color: #94a3b8; text-decoration: none; font-size: .95rem; transition: .2s; }
  .kf-links a:hover { color: #f27441; padding-left: 5px; }

  .kf-contact-item { color: #94a3b8; font-size: .92rem; margin-bottom: .8rem; display: flex; align-items: flex-start; gap: .7rem; line-height: 1.5; }
  .kf-contact-item i { color: #f27441; font-size: 1.1rem; margin-top: 2px; }

  .kf-bottom {
    position: relative; z-index: 1;
    border-top: 1px solid rgba(255,255,255,.05);
    padding: 1.2rem 0;
    color: #64748b; font-size: .85rem;
    background: rgba(0,0,0,0.2);
  }
  .kf-bottom a { color: #64748b; text-decoration: none; margin-left: 15px; transition: .2s; }
  .kf-bottom a:hover { color: #f27441; }
</style>

<footer class="kf-footer">
  <div class="container kf-footer-wrap">
    <div class="row g-5">

      {{-- Kolom Brand --}}
      <div class="col-12 col-lg-4">
        <div class="kf-brand"><span>Kost</span>Finder</div>
        <p class="kf-desc">
          Solusi terbaik mencari kost nyaman di Jawa Timur. Kami menghubungkan pemilik kost dengan penyewa melalui platform yang transparan dan mudah digunakan.
        </p>
        <div class="kf-social">
          @if($siteSettings->instagram_link)
            <a href="{{ $siteSettings->instagram_link }}" target="_blank" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
          @endif
          @if($siteSettings->facebook_link)
            <a href="{{ $siteSettings->facebook_link }}" target="_blank" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
          @endif
          @if($siteSettings->tiktok_link)
            <a href="{{ $siteSettings->tiktok_link }}" target="_blank" aria-label="TikTok"><i class="bi bi-tiktok"></i></a>
          @endif
          @if($siteSettings->whatsapp_cs)
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siteSettings->whatsapp_cs) }}" target="_blank" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
          @endif
        </div>
      </div>

{{-- Kolom Layanan --}}
<div class="col-6 col-md-4 col-lg-2">
  <div class="kf-head">Layanan</div>
  <ul class="kf-links">
    <li><a href="{{ url('/') }}">Beranda</a></li>
    <li><a href="#" class="fitur-nanti">Cari Kost</a></li> {{-- Belum ada link --}}
    <li><a href="{{ route('owner.landing') }}">Pasang Iklan</a></li>
    <li><a href="#" class="fitur-nanti">Kost Premium</a></li> {{-- Belum ada link --}}
    <li><a href="#">Panduan</a></li> {{-- Mengarah ke Panduan --}}
  </ul>
</div>

{{-- Kolom Dukungan --}}
<div class="col-6 col-md-4 col-lg-2">
  <div class="kf-head">Dukungan</div>
  <ul class="kf-links">
    <li><a href="#" class="fitur-nanti">Tentang Kami</a></li>
    <li><a href="#" class="fitur-nanti">Pusat Bantuan</a></li>
    <li><a href="#" class="fitur-nanti">Syarat & Ketentuan</a></li>
    <li><a href="#" class="fitur-nanti">Kebijakan Privasi</a></li>
    <li><a href="#" class="fitur-nanti">Blog & Berita</a></li>
  </ul>
</div>

      {{-- Kolom Kontak --}}
      <div class="col-12 col-md-4 col-lg-4">
        <div class="kf-head">Hubungi Kami</div>
        <div class="kf-contact-item">
          <i class="bi bi-geo-alt"></i> 
          <span>{!! nl2br(e($siteSettings->alamat_kantor ?? "Dusun Banjar, Desa Banjarkemantren, \nKec. Buduran, Kab. Sidoarjo, \nJawa Timur 61252")) !!}</span>
        </div>
        <div class="kf-contact-item">
          <i class="bi bi-envelope"></i> 
          <a href="mailto:{{ $siteSettings->email_support ?? 'admin@kostfinder.com' }}" style="color: inherit; text-decoration: none;">
            {{ $siteSettings->email_support ?? 'admin@kostfinder.com' }}
          </a>
        </div>
        <div class="kf-contact-item">
          <i class="bi bi-telephone"></i> 
          <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siteSettings->whatsapp_cs ?? '62881036163991') }}" target="_blank" style="color: inherit; text-decoration: none;">
            {{ $siteSettings->whatsapp_cs ?? '0881036163991' }}
          </a>
        </div>
        <div class="kf-contact-item">
          <i class="bi bi-clock"></i> 
          <span>Senin - Sabtu, 08.00 - 20.00 WIB</span>
        </div>
      </div>

    </div>
  </div>

  <div class="kf-bottom">
    <div class="container d-flex flex-wrap justify-content-between align-items-center gap-2">
      <span>&copy; {{ date('Y') }} <strong>KostFinder Jawa Timur</strong>. All rights reserved.</span>
      <div class="kf-bottom-links">
        <a href="#">Privasi</a>
        <a href="#">Syarat & Ketentuan</a>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  document.querySelectorAll('.fitur-nanti').forEach(link => {
    link.addEventListener('click', function(e) {
      e.preventDefault(); // Mencegah halaman pindah/refresh
      
      Swal.fire({
        title: 'Sabar ya! 🙏',
        text: 'Fitur ini akan segera tersedia untuk Anda.',
        icon: 'info',
        confirmButtonText: 'Oke, Mengerti',
        confirmButtonColor: '#ff7b4d', // Warna orange sesuai tema KostFinder
        background: '#fff',
        timer: 3000 // Akan tertutup otomatis dalam 3 detik
      });
    });
  });
</script>
</footer>