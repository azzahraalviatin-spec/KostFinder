<style>
  .kf-footer {
    position: relative;
    margin-top: 3rem;
    color: #d6e0f2;
    background:
      radial-gradient(circle at 8% -10%, rgba(232, 64, 28, .22) 0, rgba(232, 64, 28, 0) 38%),
      linear-gradient(180deg, #15223a 0%, #101a2d 100%);
  }

  .kf-footer::before {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(120deg, rgba(255, 255, 255, .03), rgba(255, 255, 255, 0));
    pointer-events: none;
  }

  .kf-footer-wrap {
    position: relative;
    z-index: 1;
    padding: 3rem 0 1.25rem;
  }

  .kf-brand {
    color: #fff;
    font-size: 1.55rem;
    font-weight: 800;
    letter-spacing: -.02em;
    margin-bottom: .65rem;
  }

  .kf-brand span {
    color: #ff7b4d;
  }

  .kf-desc {
    color: #adbbd4;
    max-width: 360px;
    font-size: .92rem;
    margin-bottom: 1rem;
  }

  .kf-social {
    display: inline-flex;
    gap: .5rem;
  }

  .kf-social a {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    border: 1px solid rgba(190, 206, 230, .25);
    color: #edf3ff;
    display: inline-grid;
    place-items: center;
    text-decoration: none;
    transition: .2s ease;
  }

  .kf-social a:hover {
    color: #fff;
    border-color: rgba(255, 255, 255, .7);
    background: rgba(255, 255, 255, .1);
  }

  .kf-head {
    color: #fff;
    font-size: .82rem;
    letter-spacing: .12em;
    text-transform: uppercase;
    margin-bottom: .9rem;
    font-weight: 700;
  }

  .kf-links {
    list-style: none;
    margin: 0;
    padding: 0;
  }

  .kf-links li {
    margin-bottom: .45rem;
  }

  .kf-links a {
    color: #b8c6df;
    text-decoration: none;
    font-size: .9rem;
  }

  .kf-links a:hover {
    color: #fff;
  }

  .kf-contact-item {
    color: #b8c6df;
    font-size: .9rem;
    margin-bottom: .42rem;
    display: flex;
    align-items: center;
    gap: .45rem;
  }

  .kf-bottom {
    position: relative;
    z-index: 1;
    border-top: 1px solid rgba(186, 203, 228, .2);
    padding: .95rem 0;
    color: #93a7c8;
    font-size: .85rem;
  }
</style>

<footer class="kf-footer">
  <div class="container kf-footer-wrap">
    <div class="row g-4">
      <div class="col-12 col-lg-4">
        <div class="kf-brand"><span>Kost</span>Finder</div>
        <p class="kf-desc">
          Platform pencarian kost terpercaya di Jawa Timur. Membantu penyewa menemukan hunian nyaman dan membantu pemilik kost mendapatkan penyewa lebih cepat.
        </p>
        <div class="kf-social">
          <a href="#" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
          <a href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
          <a href="#" aria-label="TikTok"><i class="bi bi-tiktok"></i></a>
          <a href="#" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
        </div>
      </div>

      <div class="col-6 col-md-4 col-lg-2">
        <div class="kf-head">Layanan</div>
        <ul class="kf-links">
          <li><a href="#">Cari Kost</a></li>
          <li><a href="#">Pasang Iklan Kost</a></li>
          <li><a href="#">Kost Premium</a></li>
          <li><a href="#">Promo Mingguan</a></li>
        </ul>
      </div>

      <div class="col-6 col-md-4 col-lg-2">
        <div class="kf-head">Perusahaan</div>
        <ul class="kf-links">
          <li><a href="#">Tentang Kami</a></li>
          <li><a href="#">Blog</a></li>
          <li><a href="#">Karir</a></li>
          <li><a href="#">Hubungi Kami</a></li>
        </ul>
      </div>

      <div class="col-12 col-md-4 col-lg-4">
        <div class="kf-head">Kontak</div>
        <div class="kf-contact-item"><i class="bi bi-geo-alt"></i> Surabaya, Jawa Timur</div>
        <div class="kf-contact-item"><i class="bi bi-envelope"></i> halo@kostfinder.id</div>
        <div class="kf-contact-item"><i class="bi bi-telephone"></i> +62 812-3456-7890</div>
        <div class="kf-contact-item"><i class="bi bi-clock"></i> Senin - Sabtu, 08.00 - 20.00</div>
      </div>
    </div>
  </div>

  <div class="kf-bottom">
    <div class="container d-flex flex-wrap justify-content-between gap-2">
      <span>&copy; {{ date('Y') }} KostFinder Jawa Timur. All rights reserved.</span>
      <span>Privasi | Syarat & Ketentuan</span>
    </div>
  </div>
</footer>
