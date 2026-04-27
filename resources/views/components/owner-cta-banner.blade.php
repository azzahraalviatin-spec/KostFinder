{{-- ══ OWNER BANNER COMPONENT ══ --}}
<div class="owner-section">
  <div class="container">
    <div class="owner-banner owner-banner-has-img">
      <div class="owner-content">
        <div class="owner-chip"><i class="bi bi-building"></i> Untuk Pemilik Kost</div>
        <h3 class="owner-title">Daftarkan Kost Anda &amp; Jangkau Lebih Banyak Calon Penghuni</h3>
        <p class="owner-sub">Tampilkan properti Anda secara lebih profesional dan bantu pencari kost menemukan tempat tinggal yang tepat.</p>
        <a href="{{ route('owner.landing') }}" class="btn-owner">
          Pelajari Lebih Lanjut <i class="bi bi-arrow-right-short" style="font-size:1.2rem;"></i>
        </a>
      </div>
    </div>
  </div>
</div>

<style>
  /* ══ OWNER BANNER STYLES ══ */
  .owner-section { 
    background: transparent; 
    padding: 1.5rem 0 3rem;
  }
  
  .owner-banner { 
    border-radius: 1.6rem; 
    overflow: hidden; 
    position: relative; 
    padding: 3.5rem 3rem; 
    background: linear-gradient(125deg, #1c0800 0%, #4a1500 30%, #8b2f00 62%, #e4572e 100%); 
    box-shadow: 0 24px 64px rgba(228,87,46,0.25); 
  }
  
  .owner-banner::before { 
    content: ''; 
    position: absolute; top: -100px; right: -100px; width: 450px; height: 450px; 
    border-radius: 50%; 
    background: radial-gradient(circle, rgba(255,120,50,0.25) 0%, transparent 65%); 
    pointer-events: none; 
  }
  
  .owner-banner::after { 
    content: ''; 
    position: absolute; bottom: -80px; left: 25%; width: 300px; height: 300px; 
    border-radius: 50%; 
    background: radial-gradient(circle, rgba(255,180,70,0.1) 0%, transparent 65%); 
    pointer-events: none; 
  }
  
  .owner-banner-has-img { 
    background-image: linear-gradient(120deg, rgba(20,5,0,0.95) 0%, rgba(55,15,0,0.9) 38%, rgba(110,35,0,0.75) 62%, rgba(200,65,20,0.4) 85%, transparent 100%), 
    url('{{ asset("images/banner/owner-kost-banner.jpg") }}'); 
    background-size: cover; 
    background-position: center right; 
  }
  
  .owner-content { 
    position: relative; z-index: 2; 
    max-width: 540px; 
    text-align: left;
  }
  
  .owner-chip { 
    display: inline-flex; align-items: center; gap: 0.4rem; 
    background: rgba(255,255,255,0.12); 
    border: 1px solid rgba(255,255,255,0.22); 
    color: #ffd4bf; 
    font-size: 0.72rem; font-weight: 700; letter-spacing: 0.07em; 
    text-transform: uppercase; 
    padding: 0.3rem 0.85rem; 
    border-radius: 999px; 
    margin-bottom: 1rem; 
    backdrop-filter: blur(8px); 
  }
  
  .owner-title { 
    font-family: 'Fraunces', serif; 
    font-weight: 700; 
    color: #ffffff; 
    font-size: clamp(1.5rem, 3vw, 2.4rem); 
    line-height: 1.15; 
    letter-spacing: -0.02em; 
    margin-bottom: 0.8rem; 
    text-shadow: 0 2px 16px rgba(0,0,0,0.4); 
  }
  
  .owner-sub { 
    color: rgba(255,220,200,0.85); 
    font-size: 0.92rem; 
    line-height: 1.7; 
    margin-bottom: 1.8rem; 
  }
  
  .btn-owner { 
    display: inline-flex; align-items: center; gap: 0.5rem; 
    background: #ffffff; 
    color: #c03e1c; 
    font-weight: 800; font-size: 0.9rem; 
    padding: 0.85rem 1.75rem; 
    border-radius: 0.9rem; 
    text-decoration: none !important; 
    box-shadow: 0 8px 28px rgba(0,0,0,0.2); 
    transition: all 0.2s; 
  }
  
  .btn-owner:hover { 
    transform: translateY(-2px); 
    color: #e4572e; 
    background: #fff8f4; 
    box-shadow: 0 14px 36px rgba(0,0,0,0.25); 
  }

  @media (max-width: 768px) {
    .owner-banner { padding: 2.5rem 1.5rem; border-radius: 1.2rem; }
    .owner-content { max-width: 100%; }
    .owner-title { font-size: 1.6rem; }
  }
</style>
