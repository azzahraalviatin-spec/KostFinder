{{-- ══ FOOTER ══ --}}
<style>
  .kf-footer {
    position: relative;
    color: #d6e0f2;
    background: 
      radial-gradient(circle at 8% -10%, rgba(232,64,28,.22) 0, rgba(232,64,28,0) 38%),
      linear-gradient(180deg, #15223a 0%, #101a2d 100%);
  }

  .kf-footer::before {
    content: "";
    position: absolute; inset: 0;
    background: linear-gradient(120deg, rgba(255,255,255,.03), rgba(255,255,255,0));
    pointer-events: none;
  }

  .kf-footer-wrap { position: relative; z-index: 1; padding: 4rem 0 1.5rem; }

  .kf-brand { color: #fff; font-size: 1.7rem; font-weight: 800; letter-spacing: -.02em; margin-bottom: .8rem; }
  .kf-brand span { color: #ff7b4d; }

  .kf-desc { color: #adbbd4; max-width: 360px; font-size: .92rem; margin-bottom: 1.5rem; line-height: 1.6; }

  .kf-social { display: inline-flex; gap: .8rem; }
  .kf-social a {
    width: 40px; height: 40px; border-radius: 50%;
    border: 1px solid rgba(190,206,230,.2);
    color: #edf3ff;
    display: inline-grid; place-items: center;
    text-decoration: none; transition: all .3s ease;
    background: rgba(255,255,255,.03);
  }
  .kf-social a:hover { 
    color: #fff; 
    border-color: #ff7b4d; 
    background: #ff7b4d;
    transform: translateY(-3px);
  }

  .kf-head { color: #fff; font-size: .85rem; letter-spacing: .1em; text-transform: uppercase; margin-bottom: 1.2rem; font-weight: 700; position: relative; }
  .kf-head::after { content: ''; position: absolute; left: 0; bottom: -6px; width: 30px; height: 2px; background: #ff7b4d; }

  .kf-links { list-style: none; margin: 0; padding: 0; }
  .kf-links li { margin-bottom: .7rem; }
  .kf-links a { color: #b8c6df; text-decoration: none; font-size: .95rem; transition: .2s; }
  .kf-links a:hover { color: #ff7b4d; padding-left: 5px; }

  .kf-contact-item { color: #b8c6df; font-size: .92rem; margin-bottom: .8rem; display: flex; align-items: flex-start; gap: .7rem; line-height: 1.5; }
  .kf-contact-item i { color: #ff7b4d; font-size: 1.1rem; margin-top: 2px; }

  .kf-bottom {
    position: relative; z-index: 1;
    border-top: 1px solid rgba(186,203,228,.1);
    padding: 1.2rem 0;
    color: #93a7c8; font-size: .85rem;
    background: rgba(0,0,0,0.1);
  }
  .kf-bottom a { color: #93a7c8; text-decoration: none; margin-left: 15px; transition: .2s; }
  .kf-bottom a:hover { color: #fff; }
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
          <a href="{{ $siteSettings->instagram_link ?? 'https://www.instagram.com/kostfinder.id' }}" target="_blank" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
          <a href="#" target="_blank" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
          <a href="{{ $siteSettings->tiktok_link ?? 'https://www.tiktok.com/@kostfinder' }}" target="_blank" aria-label="TikTok"><i class="bi bi-tiktok"></i></a>
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
          <span>Dusun Banjar, Desa Banjarkemantren, <br>Kec. Buduran, Kab. Sidoarjo, <br>Jawa Timur 61252</span>
        </div>
        <div class="kf-contact-item">
          <i class="bi bi-envelope"></i> 
          <span>{{ $siteSettings->email_support ?? 'kostfinder@gmail.com' }}</span>
        </div>
        <div class="kf-contact-item">
          <i class="bi bi-telephone"></i> 
          <span>{{ $siteSettings->whatsapp_cs ?? '0881036163991' }}</span>
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