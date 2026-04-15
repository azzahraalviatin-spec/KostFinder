<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Profil - KostFinder</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
  <style>
    * { margin:0; padding:0; box-sizing:border-box; }
    body { font-family:'Plus Jakarta Sans',sans-serif; background:#f2f5fa; padding-bottom:80px; }
    .form-wrap { max-width:680px; margin:2rem auto; padding:0 1rem; }
    .info-banner { background:#e8f4fd; border:1px solid #bee3f8; border-radius:.65rem; padding:.75rem 1rem; display:flex; align-items:center; gap:.6rem; font-size:.82rem; color:#2b6cb0; margin-bottom:1.5rem; }
    .info-banner i { font-size:1rem; flex-shrink:0; }
    .foto-wrap { display:flex; flex-direction:column; align-items:center; margin-bottom:1.8rem; }
    .foto-avatar { width:88px; height:88px; border-radius:50%; background:#e8401c; color:#fff; font-weight:800; font-size:2rem; display:flex; align-items:center; justify-content:center; overflow:hidden; margin-bottom:.5rem; border:3px solid #fff; box-shadow:0 4px 16px rgba(232,64,28,.2); cursor:pointer; position:relative; }
    .foto-avatar img { width:88px; height:88px; object-fit:cover; border-radius:50%; }
    .foto-avatar-overlay { position:absolute; inset:0; background:rgba(0,0,0,.35); border-radius:50%; display:flex; align-items:center; justify-content:center; opacity:0; transition:opacity .2s; }
    .foto-avatar:hover .foto-avatar-overlay { opacity:1; }
    .foto-avatar-overlay i { color:#fff; font-size:1.2rem; }
    .foto-label { font-size:.8rem; color:#e8401c; font-weight:600; cursor:pointer; }
    .form-section { background:#fff; border-radius:.85rem; border:1px solid #e4e9f0; overflow:hidden; margin-bottom:1rem; }
    .form-section-title { font-size:.72rem; font-weight:700; color:#8fa3b8; letter-spacing:.08em; padding:.75rem 1.2rem .4rem; background:#f8fafd; border-bottom:1px solid #f0f3f8; }
    .form-row-item { display:flex; align-items:center; padding:.85rem 1.2rem; border-bottom:1px solid #f8fafd; gap:1rem; }
    .form-row-item:last-child { border-bottom:0; }
    .form-row-label { width:180px; flex-shrink:0; font-size:.84rem; font-weight:600; color:#374151; }
    .form-row-label .wajib { font-size:.68rem; color:#ea580c; font-weight:400; display:block; margin-top:.1rem; }
    .form-row-input { flex:1; }
    .form-row-input input { width:100%; border:1px solid #e4e9f0; border-radius:.5rem; padding:.5rem .75rem; font-size:.84rem; color:#374151; background:#f8fafd; font-family:'Plus Jakarta Sans',sans-serif; outline:none; transition:border .2s; }
    .form-row-input input:focus { border-color:#e8401c; background:#fff; }
    .form-row-input input[type="date"] { color:#374151; }
    .btn-simpan { background:#e8401c; color:#fff; font-weight:700; border:0; border-radius:.6rem; padding:.65rem 2rem; font-size:.9rem; cursor:pointer; transition:background .2s; }
    .btn-simpan:hover { background:#cb3518; }
    .btn-batal { background:#fff; color:#374151; font-weight:600; border:1px solid #e4e9f0; border-radius:.6rem; padding:.65rem 1.5rem; font-size:.9rem; cursor:pointer; text-decoration:none; display:inline-block; }
    .btn-batal:hover { background:#f8fafd; color:#1a2332; }
    .alert-success-custom { background:#f0fdf4; border:1px solid #bbf7d0; color:#16a34a; border-radius:.65rem; padding:.75rem 1rem; font-size:.82rem; margin-bottom:1rem; display:flex; align-items:center; gap:.5rem; }

    /* SELECT2 CUSTOM */
    .select2-container .select2-selection--single { height:38px !important; border:1px solid #e4e9f0 !important; border-radius:.5rem !important; background:#f8fafd !important; }
    .select2-container--default .select2-selection--single .select2-selection__rendered { line-height:38px !important; font-size:.84rem; color:#374151; padding-left:.75rem; }
    .select2-container--default .select2-selection--single .select2-selection__arrow { height:36px !important; }
    .select2-container--default.select2-container--focus .select2-selection--single { border-color:#e8401c !important; background:#fff !important; }
    .select2-dropdown { border:1px solid #e4e9f0 !important; border-radius:.5rem !important; font-size:.84rem; }
    .select2-container--default .select2-results__option--highlighted { background:#e8401c !important; }
    .select2-search--dropdown .select2-search__field { border:1px solid #e4e9f0 !important; border-radius:.4rem !important; padding:.4rem .6rem; font-size:.82rem; }
  </style>
</head>
<body>

@include('layouts.navigation')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const search = document.getElementById('navbarSearch');
    if(search) search.classList.remove('d-none');
  });
</script>

<div style="padding:.6rem 1.5rem;font-size:.78rem;color:#8fa3b8;background:#fff;border-bottom:1px solid #f0f3f8;">
  <a href="{{ route('home') }}" style="color:#8fa3b8;text-decoration:none;">Home</a>
  <i class="bi bi-chevron-right" style="font-size:.6rem;margin:0 .3rem;"></i>
  <a href="{{ route('user.profil') }}" style="color:#8fa3b8;text-decoration:none;">Profil</a>
  <i class="bi bi-chevron-right" style="font-size:.6rem;margin:0 .3rem;"></i>
  <span>Edit Profil</span>
</div>

<div class="form-wrap">

  @if(session('success'))
    <div class="alert-success-custom"><i class="bi bi-check-circle-fill"></i> {{ session('success') }}</div>
  @endif

  <div class="info-banner">
    <i class="bi bi-info-circle-fill"></i>
    Pemilik kos lebih menyukai calon penyewa dengan profil yang jelas dan lengkap.
  </div>

  <form method="POST" action="{{ route('user.profil.update') }}" enctype="multipart/form-data">
    @csrf
    @method('PATCH')

    {{-- FOTO --}}

    <div class="foto-wrap">
  <div class="foto-avatar" onclick="toggleFotoMenu(event)">
    @if(auth()->user()->foto_profil)
      <img src="{{ asset('storage/'.auth()->user()->foto_profil) }}" alt="foto" id="fotoPreview">
    @else
      <span id="fotoInitial">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</span>
      <img src="" alt="" id="fotoPreview" style="display:none;">
    @endif
    <div class="foto-avatar-overlay"><i class="bi bi-camera"></i></div>
  </div>
  <label class="foto-label" onclick="toggleFotoMenu(event)">Ubah Foto</label>
  <input type="file" id="fotoInput" name="foto_profil" accept="image/*" style="display:none;" onchange="previewFoto(this)">

  {{-- POPUP MENU --}}
  <div id="fotoMenu" style="display:none;position:absolute;background:#fff;border:1px solid #e4e9f0;border-radius:.75rem;box-shadow:0 8px 24px rgba(0,0,0,.12);z-index:999;overflow:hidden;min-width:180px;margin-top:.3rem;">
   <button type="button" onclick="bukaPilihFoto()"
      style="width:100%;padding:.7rem 1rem;border:0;background:#fff;text-align:left;font-size:.83rem;font-weight:600;color:#374151;cursor:pointer;display:flex;align-items:center;gap:.6rem;transition:background .15s;"
      onmouseover="this.style.background='#f8fafd'" onmouseout="this.style.background='#fff'">
      <i class="bi bi-camera" style="color:#e8401c;"></i> Ubah Foto
    </button>
    @if(auth()->user()->foto_profil)
    <button type="button" onclick="hapusFotoProfil()"
      style="width:100%;padding:.7rem 1rem;border:0;border-top:1px solid #f0f3f8;background:#fff;text-align:left;font-size:.83rem;font-weight:600;color:#dc2626;cursor:pointer;display:flex;align-items:center;gap:.6rem;transition:background .15s;"
      onmouseover="this.style.background='#fff5f5'" onmouseout="this.style.background='#fff'">
      <i class="bi bi-trash"></i> Hapus Foto
    </button>
    @endif
  </div>
</div>

    {{-- INFORMASI PRIBADI --}}
    <div class="form-section">
      <div class="form-section-title">INFORMASI PRIBADI</div>
      <div class="form-row-item">
        <div class="form-row-label">Nama Lengkap</div>
        <div class="form-row-input"><input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" placeholder="Masukkan nama lengkap"></div>
      </div>
      <div class="form-row-item">
        <div class="form-row-label">Jenis Kelamin<span class="wajib">Wajib diisi</span></div>
        <div class="form-row-input">
          <select name="jenis_kelamin" id="selJK">
            <option value="">Pilih jenis kelamin</option>
            <option value="laki-laki" {{ auth()->user()->jenis_kelamin=='laki-laki'?'selected':'' }}>Laki-laki</option>
            <option value="perempuan" {{ auth()->user()->jenis_kelamin=='perempuan'?'selected':'' }}>Perempuan</option>
          </select>
        </div>
      </div>
      <div class="form-row-item">
        <div class="form-row-label">Tanggal Lahir<span class="wajib">Wajib diisi</span></div>
        <div class="form-row-input"><input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', auth()->user()->tanggal_lahir) }}"></div>
      </div>
      <div class="form-row-item">
        <div class="form-row-label">Nomor HP</div>
        <div class="form-row-input"><input type="text" name="no_hp" value="{{ old('no_hp', auth()->user()->no_hp) }}" placeholder="+62 xxxx xxxx"></div>
      </div>
      <div class="form-row-item">
        <div class="form-row-label">Nomor Kontak Darurat</div>
        <div class="form-row-input"><input type="text" name="kontak_darurat" value="{{ old('kontak_darurat', auth()->user()->kontak_darurat) }}" placeholder="+62 xxxx xxxx"></div>
      </div>
    </div>

    {{-- PEKERJAAN & PENDIDIKAN --}}
    <div class="form-section">
      <div class="form-section-title">PEKERJAAN & PENDIDIKAN</div>
      <div class="form-row-item">
        <div class="form-row-label">Pekerjaan<span class="wajib">Wajib diisi</span></div>
        <div class="form-row-input">
          <select name="pekerjaan" id="selPekerjaan">
            <option value="">Pilih pekerjaan</option>
            <option value="mahasiswa" {{ auth()->user()->pekerjaan=='mahasiswa'?'selected':'' }}>Mahasiswa</option>
            <option value="pelajar" {{ auth()->user()->pekerjaan=='pelajar'?'selected':'' }}>Pelajar</option>
            <option value="karyawan" {{ auth()->user()->pekerjaan=='karyawan'?'selected':'' }}>Karyawan Swasta</option>
            <option value="pns" {{ auth()->user()->pekerjaan=='pns'?'selected':'' }}>PNS</option>
            <option value="wirausaha" {{ auth()->user()->pekerjaan=='wirausaha'?'selected':'' }}>Wirausaha</option>
            <option value="freelancer" {{ auth()->user()->pekerjaan=='freelancer'?'selected':'' }}>Freelancer</option>
            <option value="lainnya" {{ auth()->user()->pekerjaan=='lainnya'?'selected':'' }}>Lainnya</option>
          </select>
          <input type="text" name="pekerjaan_lainnya" id="inputPekerjaanLainnya" placeholder="Tulis pekerjaan kamu..." style="display:none;margin-top:.5rem;">
        </div>
      </div>
      <div class="form-row-item" id="rowInstansi" style="{{ in_array(auth()->user()->pekerjaan, ['mahasiswa','pelajar']) ? '' : 'display:none;' }}">
      <div class="form-row-label">Nama Instansi/Kampus/Sekolah</div>
        <div class="form-row-input">
          <select name="instansi" id="selInstansi">
            <option value="">Pilih nama instansi/kampus/sekolah</option>
            <optgroup label="Jawa Timur">
              <option value="ITS" {{ auth()->user()->instansi=='ITS'?'selected':'' }}>ITS Surabaya</option>
              <option value="UNAIR" {{ auth()->user()->instansi=='UNAIR'?'selected':'' }}>Universitas Airlangga (UNAIR)</option>
              <option value="UNESA" {{ auth()->user()->instansi=='UNESA'?'selected':'' }}>Universitas Negeri Surabaya (UNESA)</option>
              <option value="UPN Surabaya" {{ auth()->user()->instansi=='UPN Surabaya'?'selected':'' }}>UPN Veteran Surabaya</option>
              <option value="UBAYA" {{ auth()->user()->instansi=='UBAYA'?'selected':'' }}>Universitas Surabaya (UBAYA)</option>
              <option value="PETRA" {{ auth()->user()->instansi=='PETRA'?'selected':'' }}>Universitas Kristen Petra</option>
              <option value="UB" {{ auth()->user()->instansi=='UB'?'selected':'' }}>Universitas Brawijaya (UB) Malang</option>
              <option value="UM" {{ auth()->user()->instansi=='UM'?'selected':'' }}>Universitas Negeri Malang (UM)</option>
              <option value="UIN Malang" {{ auth()->user()->instansi=='UIN Malang'?'selected':'' }}>UIN Maulana Malik Ibrahim Malang</option>
              <option value="UMM" {{ auth()->user()->instansi=='UMM'?'selected':'' }}>Universitas Muhammadiyah Malang (UMM)</option>
              <option value="UNEJ" {{ auth()->user()->instansi=='UNEJ'?'selected':'' }}>Universitas Jember (UNEJ)</option>
              <option value="UNIJOYO" {{ auth()->user()->instansi=='UNIJOYO'?'selected':'' }}>Universitas Trunojoyo Madura</option>
              <option value="UNWIDHA" {{ auth()->user()->instansi=='UNWIDHA'?'selected':'' }}>Universitas Widyagama Malang</option>
            </optgroup>
            <optgroup label="Jakarta & Sekitarnya">
              <option value="UI" {{ auth()->user()->instansi=='UI'?'selected':'' }}>Universitas Indonesia (UI)</option>
              <option value="UNJ" {{ auth()->user()->instansi=='UNJ'?'selected':'' }}>Universitas Negeri Jakarta (UNJ)</option>
              <option value="Trisakti" {{ auth()->user()->instansi=='Trisakti'?'selected':'' }}>Universitas Trisakti</option>
              <option value="Binus" {{ auth()->user()->instansi=='Binus'?'selected':'' }}>Bina Nusantara University (BINUS)</option>
              <option value="Atma Jaya" {{ auth()->user()->instansi=='Atma Jaya'?'selected':'' }}>Universitas Atma Jaya Jakarta</option>
              <option value="IPB" {{ auth()->user()->instansi=='IPB'?'selected':'' }}>IPB University Bogor</option>
            </optgroup>
            <optgroup label="Jawa Barat">
              <option value="ITB" {{ auth()->user()->instansi=='ITB'?'selected':'' }}>Institut Teknologi Bandung (ITB)</option>
              <option value="UNPAD" {{ auth()->user()->instansi=='UNPAD'?'selected':'' }}>Universitas Padjadjaran (UNPAD)</option>
              <option value="UPI" {{ auth()->user()->instansi=='UPI'?'selected':'' }}>Universitas Pendidikan Indonesia (UPI)</option>
            </optgroup>
            <optgroup label="Jawa Tengah & DIY">
              <option value="UGM" {{ auth()->user()->instansi=='UGM'?'selected':'' }}>Universitas Gadjah Mada (UGM)</option>
              <option value="UNY" {{ auth()->user()->instansi=='UNY'?'selected':'' }}>Universitas Negeri Yogyakarta (UNY)</option>
              <option value="UNDIP" {{ auth()->user()->instansi=='UNDIP'?'selected':'' }}>Universitas Diponegoro (UNDIP)</option>
              <option value="UNNES" {{ auth()->user()->instansi=='UNNES'?'selected':'' }}>Universitas Negeri Semarang (UNNES)</option>
            </optgroup>
            <optgroup label="Luar Jawa">
              <option value="UNHAS" {{ auth()->user()->instansi=='UNHAS'?'selected':'' }}>Universitas Hasanuddin Makassar</option>
              <option value="USU" {{ auth()->user()->instansi=='USU'?'selected':'' }}>Universitas Sumatera Utara (USU)</option>
              <option value="UNSRI" {{ auth()->user()->instansi=='UNSRI'?'selected':'' }}>Universitas Sriwijaya</option>
              <option value="UDAYANA" {{ auth()->user()->instansi=='UDAYANA'?'selected':'' }}>Universitas Udayana Bali</option>
            </optgroup>
            <option value="lainnya" {{ auth()->user()->instansi=='lainnya'?'selected':'' }}>Lainnya</option>
          </select>
          <input type="text" name="instansi_lainnya" id="inputInstansiLainnya" placeholder="Tulis nama instansi..." style="display:none;margin-top:.5rem;">
        </div>
      </div>
      <div class="form-row-item">
        <div class="form-row-label">Pendidikan Terakhir</div>
        <div class="form-row-input">
          <select name="pendidikan" id="selPendidikan">
            <option value="">Pilih pendidikan terakhir</option>
            <option value="sd" {{ auth()->user()->pendidikan=='sd'?'selected':'' }}>SD</option>
            <option value="smp" {{ auth()->user()->pendidikan=='smp'?'selected':'' }}>SMP</option>
            <option value="sma" {{ auth()->user()->pendidikan=='sma'?'selected':'' }}>SMA/SMK</option>
            <option value="d3" {{ auth()->user()->pendidikan=='d3'?'selected':'' }}>D3</option>
            <option value="s1" {{ auth()->user()->pendidikan=='s1'?'selected':'' }}>S1</option>
            <option value="s2" {{ auth()->user()->pendidikan=='s2'?'selected':'' }}>S2</option>
            <option value="s3" {{ auth()->user()->pendidikan=='s3'?'selected':'' }}>S3</option>
          </select>
        </div>
      </div>
      <div class="form-row-item">
        <div class="form-row-label">Status</div>
        <div class="form-row-input">
          <select name="status_pernikahan" id="selStatus">
            <option value="">Pilih status</option>
            <option value="lajang" {{ auth()->user()->status_pernikahan=='lajang'?'selected':'' }}>Lajang</option>
            <option value="menikah" {{ auth()->user()->status_pernikahan=='menikah'?'selected':'' }}>Menikah</option>
            <option value="cerai" {{ auth()->user()->status_pernikahan=='cerai'?'selected':'' }}>Cerai</option>
          </select>
        </div>
      </div>
    </div>

    {{-- LOKASI --}}
    <div class="form-section">
      <div class="form-section-title">LOKASI</div>
      <div class="form-row-item">
        <div class="form-row-label">Kota Asal</div>
        <div class="form-row-input">
          <select name="kota" id="selKota">
            <option value="">Pilih kota asal</option>
            <optgroup label="Jawa Timur">
              <option value="Surabaya" {{ auth()->user()->kota=='Surabaya'?'selected':'' }}>Surabaya</option>
              <option value="Malang" {{ auth()->user()->kota=='Malang'?'selected':'' }}>Malang</option>
              <option value="Sidoarjo" {{ auth()->user()->kota=='Sidoarjo'?'selected':'' }}>Sidoarjo</option>
              <option value="Gresik" {{ auth()->user()->kota=='Gresik'?'selected':'' }}>Gresik</option>
              <option value="Kediri" {{ auth()->user()->kota=='Kediri'?'selected':'' }}>Kediri</option>
              <option value="Jember" {{ auth()->user()->kota=='Jember'?'selected':'' }}>Jember</option>
              <option value="Banyuwangi" {{ auth()->user()->kota=='Banyuwangi'?'selected':'' }}>Banyuwangi</option>
              <option value="Mojokerto" {{ auth()->user()->kota=='Mojokerto'?'selected':'' }}>Mojokerto</option>
              <option value="Madiun" {{ auth()->user()->kota=='Madiun'?'selected':'' }}>Madiun</option>
              <option value="Pasuruan" {{ auth()->user()->kota=='Pasuruan'?'selected':'' }}>Pasuruan</option>
              <option value="Probolinggo" {{ auth()->user()->kota=='Probolinggo'?'selected':'' }}>Probolinggo</option>
              <option value="Blitar" {{ auth()->user()->kota=='Blitar'?'selected':'' }}>Blitar</option>
              <option value="Lamongan" {{ auth()->user()->kota=='Lamongan'?'selected':'' }}>Lamongan</option>
              <option value="Bojonegoro" {{ auth()->user()->kota=='Bojonegoro'?'selected':'' }}>Bojonegoro</option>
              <option value="Tulungagung" {{ auth()->user()->kota=='Tulungagung'?'selected':'' }}>Tulungagung</option>
              <option value="Lumajang" {{ auth()->user()->kota=='Lumajang'?'selected':'' }}>Lumajang</option>
              <option value="Bangkalan" {{ auth()->user()->kota=='Bangkalan'?'selected':'' }}>Bangkalan</option>
              <option value="Pamekasan" {{ auth()->user()->kota=='Pamekasan'?'selected':'' }}>Pamekasan</option>
              <option value="Sampang" {{ auth()->user()->kota=='Sampang'?'selected':'' }}>Sampang</option>
              <option value="Sumenep" {{ auth()->user()->kota=='Sumenep'?'selected':'' }}>Sumenep</option>
            </optgroup>
            <optgroup label="DKI Jakarta">
              <option value="Jakarta Pusat" {{ auth()->user()->kota=='Jakarta Pusat'?'selected':'' }}>Jakarta Pusat</option>
              <option value="Jakarta Selatan" {{ auth()->user()->kota=='Jakarta Selatan'?'selected':'' }}>Jakarta Selatan</option>
              <option value="Jakarta Barat" {{ auth()->user()->kota=='Jakarta Barat'?'selected':'' }}>Jakarta Barat</option>
              <option value="Jakarta Timur" {{ auth()->user()->kota=='Jakarta Timur'?'selected':'' }}>Jakarta Timur</option>
              <option value="Jakarta Utara" {{ auth()->user()->kota=='Jakarta Utara'?'selected':'' }}>Jakarta Utara</option>
            </optgroup>
            <optgroup label="Jawa Barat">
              <option value="Bandung" {{ auth()->user()->kota=='Bandung'?'selected':'' }}>Bandung</option>
              <option value="Bekasi" {{ auth()->user()->kota=='Bekasi'?'selected':'' }}>Bekasi</option>
              <option value="Depok" {{ auth()->user()->kota=='Depok'?'selected':'' }}>Depok</option>
              <option value="Bogor" {{ auth()->user()->kota=='Bogor'?'selected':'' }}>Bogor</option>
              <option value="Tasikmalaya" {{ auth()->user()->kota=='Tasikmalaya'?'selected':'' }}>Tasikmalaya</option>
              <option value="Cirebon" {{ auth()->user()->kota=='Cirebon'?'selected':'' }}>Cirebon</option>
            </optgroup>
            <optgroup label="Jawa Tengah & DIY">
              <option value="Semarang" {{ auth()->user()->kota=='Semarang'?'selected':'' }}>Semarang</option>
              <option value="Yogyakarta" {{ auth()->user()->kota=='Yogyakarta'?'selected':'' }}>Yogyakarta</option>
              <option value="Solo" {{ auth()->user()->kota=='Solo'?'selected':'' }}>Solo</option>
              <option value="Purwokerto" {{ auth()->user()->kota=='Purwokerto'?'selected':'' }}>Purwokerto</option>
              <option value="Magelang" {{ auth()->user()->kota=='Magelang'?'selected':'' }}>Magelang</option>
            </optgroup>
            <optgroup label="Sumatera">
              <option value="Medan" {{ auth()->user()->kota=='Medan'?'selected':'' }}>Medan</option>
              <option value="Palembang" {{ auth()->user()->kota=='Palembang'?'selected':'' }}>Palembang</option>
              <option value="Pekanbaru" {{ auth()->user()->kota=='Pekanbaru'?'selected':'' }}>Pekanbaru</option>
              <option value="Padang" {{ auth()->user()->kota=='Padang'?'selected':'' }}>Padang</option>
              <option value="Bandar Lampung" {{ auth()->user()->kota=='Bandar Lampung'?'selected':'' }}>Bandar Lampung</option>
              <option value="Batam" {{ auth()->user()->kota=='Batam'?'selected':'' }}>Batam</option>
            </optgroup>
            <optgroup label="Kalimantan">
              <option value="Balikpapan" {{ auth()->user()->kota=='Balikpapan'?'selected':'' }}>Balikpapan</option>
              <option value="Samarinda" {{ auth()->user()->kota=='Samarinda'?'selected':'' }}>Samarinda</option>
              <option value="Banjarmasin" {{ auth()->user()->kota=='Banjarmasin'?'selected':'' }}>Banjarmasin</option>
              <option value="Pontianak" {{ auth()->user()->kota=='Pontianak'?'selected':'' }}>Pontianak</option>
            </optgroup>
            <optgroup label="Sulawesi & Timur Indonesia">
              <option value="Makassar" {{ auth()->user()->kota=='Makassar'?'selected':'' }}>Makassar</option>
              <option value="Manado" {{ auth()->user()->kota=='Manado'?'selected':'' }}>Manado</option>
              <option value="Denpasar" {{ auth()->user()->kota=='Denpasar'?'selected':'' }}>Denpasar</option>
              <option value="Mataram" {{ auth()->user()->kota=='Mataram'?'selected':'' }}>Mataram</option>
              <option value="Kupang" {{ auth()->user()->kota=='Kupang'?'selected':'' }}>Kupang</option>
              <option value="Jayapura" {{ auth()->user()->kota=='Jayapura'?'selected':'' }}>Jayapura</option>
            </optgroup>
            <option value="Lainnya" {{ auth()->user()->kota=='Lainnya'?'selected':'' }}>Lainnya</option>
          </select>
          <input type="text" name="kota_lainnya" id="inputKotaLainnya" placeholder="Tulis kota kamu..." style="display:none;margin-top:.5rem;">
        </div>
      </div>
    </div>

    <div class="d-flex gap-2 justify-content-end mt-3">
      <a href="{{ route('user.profil') }}" class="btn-batal">Batal</a>
      <button type="submit" class="btn-simpan">Simpan</button>
    </div>

  </form>
</div>

@include('layouts._bottom-nav')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
  const tagsOpt = { width: '100%', allowClear: true, tags: true, createTag: function(p){ return { id: p.term, text: p.term }; } };

  $('#selKota').select2({ ...tagsOpt, placeholder: 'Pilih atau ketik kota asal' });
  $('#selInstansi').select2({ ...tagsOpt, placeholder: 'Pilih atau ketik kampus/sekolah' });
  $('#selPekerjaan').select2({ ...tagsOpt, placeholder: 'Pilih atau ketik pekerjaan' });
  $('#selPendidikan').select2({ ...tagsOpt, placeholder: 'Pilih atau ketik pendidikan terakhir' });
  $('#selJK').select2({ ...tagsOpt, placeholder: 'Pilih jenis kelamin' });
  $('#selStatus').select2({ placeholder: 'Pilih status', width: '100%', allowClear: true });
});

  function previewFoto(input) {
    if (input.files && input.files[0]) {
      const reader = new FileReader();
      reader.onload = function(e) {
        const preview = document.getElementById('fotoPreview');
        const initial = document.getElementById('fotoInitial');
        preview.src = e.target.result;
        preview.style.display = 'block';
        if(initial) initial.style.display = 'none';
      };
      reader.readAsDataURL(input.files[0]);
    }
  }
  // Tampilkan input teks kalau pilih Lainnya
function handleLainnya(selectId, inputId) {
  $('#' + selectId).on('change', function() {
    if($(this).val() === 'lainnya' || $(this).val() === 'Lainnya') {
      $('#' + inputId).show().focus();
    } else {
      $('#' + inputId).hide().val('');
    }
  });
}

handleLainnya('selKota', 'inputKotaLainnya');
handleLainnya('selInstansi', 'inputInstansiLainnya');
handleLainnya('selPekerjaan', 'inputPekerjaanLainnya');
// Tampilkan/sembunyikan instansi berdasarkan pekerjaan
function toggleInstansi(val) {
  if (val === 'mahasiswa' || val === 'pelajar') {
    $('#rowInstansi').show();
  } else {
    $('#rowInstansi').hide();
    $('#selInstansi').val(null).trigger('change');
  }
}

// Saat pekerjaan berubah
$('#selPekerjaan').on('change', function() {
  toggleInstansi($(this).val());
});

// Inisialisasi saat halaman load
toggleInstansi('{{ auth()->user()->pekerjaan }}');
function toggleFotoMenu(e) {
  e.stopPropagation();
  e.preventDefault();
  const menu = document.getElementById('fotoMenu');
  menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
}

document.addEventListener('click', function(e) {
  if (!e.target.closest('#fotoMenu') && !e.target.closest('.foto-avatar') && !e.target.closest('.foto-label')) {
    document.getElementById('fotoMenu').style.display = 'none';
  }
});

function bukaPilihFoto() {
  document.getElementById('fotoMenu').style.display = 'none';
  setTimeout(() => {
    document.getElementById('fotoInput').click();
  }, 100);
}

  function hapusFotoProfil() {
  document.getElementById('fotoMenu').style.display = 'none';

  const overlay = document.createElement('div');
  overlay.style.cssText = 'position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:99999;display:flex;align-items:center;justify-content:center;backdrop-filter:blur(4px);';

  overlay.innerHTML = `
    <div style="background:#fff;border-radius:1rem;width:100%;max-width:360px;margin:1rem;box-shadow:0 20px 60px rgba(0,0,0,.2);overflow:hidden;">
      <div style="background:linear-gradient(135deg,#e8401c,#ff7043);padding:1.3rem 1.5rem;display:flex;align-items:center;gap:.85rem;">
        <div style="width:40px;height:40px;background:rgba(255,255,255,.2);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
          <i class="bi bi-trash3-fill" style="color:#fff;font-size:1rem;"></i>
        </div>
        <div>
          <div style="font-weight:800;color:#fff;font-size:.95rem;">Hapus Foto Profil</div>
          <div style="color:rgba(255,255,255,.75);font-size:.73rem;">Tindakan ini tidak dapat dibatalkan</div>
        </div>
      </div>
      <div style="padding:1.3rem 1.5rem;">
        <div style="background:#fff5f2;border:1px solid #ffd0c0;border-radius:.65rem;padding:.9rem 1rem;display:flex;align-items:flex-start;gap:.7rem;">
          <i class="bi bi-exclamation-triangle-fill" style="color:#e8401c;font-size:1rem;flex-shrink:0;margin-top:.1rem;"></i>
          <p style="margin:0;font-size:.83rem;color:#1e2d3d;font-weight:500;line-height:1.5;">
            Yakin ingin menghapus foto profil kamu? Foto akan diganti dengan avatar default.
          </p>
        </div>
      </div>
      <div style="padding:.9rem 1.5rem 1.3rem;display:flex;gap:.7rem;justify-content:flex-end;border-top:1px solid #f0f3f8;">
        <button id="btnBatalHapusFoto"
          style="background:#fff;border:1.5px solid #e4e9f0;color:#555;font-size:.82rem;font-weight:600;padding:.5rem 1.2rem;border-radius:.6rem;cursor:pointer;"
          onmouseover="this.style.borderColor='#aab4be';this.style.color='#333'"
          onmouseout="this.style.borderColor='#e4e9f0';this.style.color='#555'">
          <i class="bi bi-x"></i> Batal
        </button>
        <button id="btnOkHapusFoto"
          style="background:linear-gradient(135deg,#e8401c,#ff7043);border:none;color:#fff;font-size:.82rem;font-weight:700;padding:.5rem 1.3rem;border-radius:.6rem;cursor:pointer;box-shadow:0 4px 14px rgba(232,64,28,.35);"
          onmouseover="this.style.background='linear-gradient(135deg,#cb3518,#e8401c)';this.style.transform='translateY(-1px)'"
          onmouseout="this.style.background='linear-gradient(135deg,#e8401c,#ff7043)';this.style.transform='translateY(0)'">
          <i class="bi bi-trash3"></i> Ya, Hapus
        </button>
      </div>
    </div>
  `;

  document.body.appendChild(overlay);

  document.getElementById('btnBatalHapusFoto').onclick = () => overlay.remove();

  document.getElementById('btnOkHapusFoto').onclick = () => {
    overlay.remove();
    fetch('{{ route("user.profil.update") }}', {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({ _method: 'PATCH', hapus_foto: 1 })
    }).then(() => location.reload());
  };
}
</script>
</body>
</html>