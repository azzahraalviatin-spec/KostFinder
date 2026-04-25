<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Kamar - KostFinder</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    :root { --sidebar-w:200px; --sidebar-col:60px; --primary:#e8401c; --dark:#1e2d3d; --bg:#f0f4f8; }
    * { margin:0; padding:0; box-sizing:border-box; }
    body { font-family:'Plus Jakarta Sans',sans-serif; background:var(--bg); display:flex; min-height:100vh; }
    .sidebar { width:var(--sidebar-w); min-height:100vh; background:var(--dark); position:fixed; top:0; left:0; display:flex; flex-direction:column; z-index:200; transition:width .3s ease; overflow:hidden; }
    .sidebar.collapsed { width:var(--sidebar-col); }
    .sidebar-brand { padding:1.2rem .9rem; border-bottom:1px solid rgba(255,255,255,.08); display:flex; align-items:center; gap:.6rem; min-height:60px; white-space:nowrap; }
    .brand-icon { width:32px; height:32px; flex-shrink:0; background:var(--primary); border-radius:.5rem; display:flex; align-items:center; justify-content:center; font-size:1rem; }
    .brand-text { overflow:hidden; transition:opacity .2s; }
    .brand-text .name { font-size:1rem; font-weight:800; color:#fff; }
    .brand-text .name span { color:var(--primary); }
    .brand-text .sub { font-size:.65rem; color:#7a92aa; }
    .sidebar.collapsed .brand-text { opacity:0; width:0; }
    .sidebar-menu { padding:.7rem .5rem; flex:1; }
    .menu-label { font-size:.6rem; font-weight:700; letter-spacing:.1em; color:#7a92aa; padding:.5rem .5rem .2rem; white-space:nowrap; transition:opacity .2s; }
    .sidebar.collapsed .menu-label { opacity:0; }
    .menu-item { display:flex; align-items:center; gap:.65rem; padding:.58rem .65rem; border-radius:.55rem; color:#a0b4c4; text-decoration:none; font-size:.82rem; font-weight:500; margin-bottom:.1rem; transition:all .2s; white-space:nowrap; cursor:pointer; border:0; background:none; width:100%; text-align:left; }
    .menu-item i { font-size:.95rem; width:20px; flex-shrink:0; }
    .menu-item span { overflow:hidden; transition:opacity .2s; }
    .sidebar.collapsed .menu-item span { opacity:0; width:0; }
    .menu-item:hover { background:rgba(255,255,255,.07); color:#fff; }
    .menu-item.active { background:var(--primary); color:#fff; }
    .menu-item.logout { color:#f87171; }
    .menu-item.logout:hover { background:rgba(248,113,113,.1); }
    .sidebar-user { padding:.85rem .9rem; border-top:1px solid rgba(255,255,255,.08); display:flex; align-items:center; gap:.6rem; white-space:nowrap; }
    .user-avatar { width:32px; height:32px; border-radius:50%; background:var(--primary); color:#fff; font-weight:700; font-size:.8rem; flex-shrink:0; display:flex; align-items:center; justify-content:center; }
    .user-info { overflow:hidden; transition:opacity .2s; }
    .sidebar.collapsed .user-info { opacity:0; width:0; }
    .user-name { color:#fff; font-size:.8rem; font-weight:600; }
    .user-role { color:#7a92aa; font-size:.68rem; }
    .main { margin-left:var(--sidebar-w); flex:1; transition:margin-left .3s ease; display:flex; flex-direction:column; }
    .main.collapsed { margin-left:var(--sidebar-col); }
    .topbar { background:#fff; height:60px; padding:0 1.5rem; display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid #e4e9f0; position:sticky; top:0; z-index:100; }
    .topbar-left h5 { font-size:.98rem; font-weight:800; color:var(--dark); margin:0; }
    .topbar-left p { font-size:.72rem; color:#8fa3b8; margin:0; }
    .topbar-right { display:flex; align-items:center; gap:.6rem; }
    .search-box { display:flex; align-items:center; gap:.5rem; background:#f0f4f8; border:1px solid #dde3ed; border-radius:.55rem; padding:.38rem .75rem; width:180px; }
    .search-box input { border:0; background:none; outline:none; font-size:.8rem; color:#333; width:100%; }
    .icon-btn { width:34px; height:34px; border-radius:.5rem; background:#f0f4f8; border:1px solid #dde3ed; display:flex; align-items:center; justify-content:center; color:#555; font-size:.9rem; cursor:pointer; text-decoration:none; }
    .icon-btn:hover { background:#e4e9f0; color:#333; }
    .content { padding:1.4rem; flex:1; }
    .form-card { background:#fff; border-radius:.85rem; border:1px solid #e4e9f0; box-shadow:0 2px 6px rgba(0,0,0,.04); padding:1.5rem; max-width:900px; }
    .form-label { font-size:.8rem; font-weight:600; color:#444; margin-bottom:.3rem; }
    .form-control, .form-select { font-size:.85rem; border-color:#e4e9f0; border-radius:.55rem; padding:.5rem .8rem; }
    .form-control:focus, .form-select:focus { border-color:var(--primary); box-shadow:0 0 0 3px rgba(232,64,28,.1); }
    .owner-footer { background:#fff; border-top:1px solid #e4e9f0; padding:.8rem 1.5rem; text-align:center; color:#8fa3b8; font-size:.72rem; }
    .thumb { width:130px; height:90px; border-radius:.5rem; object-fit:cover; border:1px solid #e4e9f0; }
    .thumb-grid { display:flex; flex-wrap:wrap; gap:.5rem; }
  </style>
</head>
<body>
  @include('owner._sidebar')

  <div class="main" id="mainContent">
    @include('owner._navbar')

    <div class="content">
      @if($errors->any())
        <div class="alert alert-danger py-2 mb-3" style="font-size:.83rem;">{{ $errors->first() }}</div>
      @endif

      <div class="form-card">
        <h6 class="mb-3" style="font-weight:700;color:var(--dark);"><i class="bi bi-pencil-square me-1" style="color:var(--primary)"></i> Edit Kamar</h6>

        <form action="{{ route('owner.kamar.update', $kamar->id_room) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Pilih Kost</label>
              <select name="kost_id" class="form-select" required>
                <option value="">-- Pilih Kost --</option>
                @foreach($kosts as $kost)
                  <option value="{{ $kost->id_kost }}" {{ old('kost_id', $kamar->kost_id) == $kost->id_kost ? 'selected' : '' }}>{{ $kost->nama_kost }}</option>
                @endforeach
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label">Tipe / Nama Kamar</label>
              <input type="text" name="nomor_kamar" class="form-control" value="{{ old('nomor_kamar', $kamar->nomor_kamar) }}" placeholder="Contoh: Tipe A, Kamar 101, dll" required>
              <small class="text-muted">Gunakan ini sebagai identitas kamar.</small>
            </div>

            <div class="col-12">
  <label class="form-label fw-bold">Harga & Durasi Sewa</label>
  <div class="row g-2">

    {{-- BULANAN --}}
    <div class="col-12">
      <div class="border rounded-3 p-3" style="background:#f8fafd;">
        <div class="d-flex align-items-center gap-2 mb-2">
          <input type="checkbox" name="aktif_bulanan" id="aktifBulanan" value="1"
            {{ old('aktif_bulanan', $kamar->aktif_bulanan ?? true) ? 'checked' : '' }}
            onchange="toggleHarga('Bulanan')" class="form-check-input mt-0" style="accent-color:#e8401c;">
          <label for="aktifBulanan" style="font-size:.85rem;font-weight:700;cursor:pointer;">🗓️ Sewa Bulanan</label>
        </div>
      <div id="inputBulanan" style="{{ old('aktif_bulanan', $kamar->aktif_bulanan ?? true) ? '' : 'display:none' }}">
          <div class="input-group">
            <span class="input-group-text">Rp</span>
            <input type="number" name="harga_per_bulan" class="form-control"
              value="{{ old('harga_per_bulan', $kamar->harga_per_bulan) }}" placeholder="Contoh: 900000" min="0">
            <span class="input-group-text">/ bulan</span>
          </div>
        </div>
      </div>
    </div>

    {{-- HARIAN --}}
    <div class="col-12">
      <div class="border rounded-3 p-3" style="background:#f8fafd;">
        <div class="d-flex align-items-center gap-2 mb-2">
          <input type="checkbox" name="aktif_harian" id="aktifHarian" value="1"
            {{ old('aktif_harian', $kamar->aktif_harian ?? false) ? 'checked' : '' }}
            onchange="toggleHarga('Harian')" class="form-check-input mt-0" style="accent-color:#e8401c;">
          <label for="aktifHarian" style="font-size:.85rem;font-weight:700;cursor:pointer;">📅 Sewa Harian</label>
        </div>
        <div id="inputHarian" style="{{ old('aktif_harian', $kamar->aktif_harian ?? false) ? '' : 'display:none' }}">
          <div class="input-group">
            <span class="input-group-text">Rp</span>
            <input type="number" name="harga_harian" class="form-control"
              value="{{ old('harga_harian', $kamar->harga_harian) }}" placeholder="Contoh: 75000" min="0">
            <span class="input-group-text">/ hari</span>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

            <div class="col-md-6">
              <label class="form-label">Status Kamar</label>
              <select name="status_kamar" class="form-select" required>
                <option value="tersedia" {{ old('status_kamar', $kamar->status_kamar) === 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                <option value="terisi" {{ old('status_kamar', $kamar->status_kamar) === 'terisi' ? 'selected' : '' }}>Terisi</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Kategori Tipe</label>
              <select name="tipe_kamar" class="form-select">
                <option value="">-- Pilih Kategori --</option>
                <option value="Standard" {{ old('tipe_kamar', $kamar->tipe_kamar) === 'Standard' ? 'selected' : '' }}>Standard</option>
                <option value="Deluxe" {{ old('tipe_kamar', $kamar->tipe_kamar) === 'Deluxe' ? 'selected' : '' }}>Deluxe</option>
                <option value="VIP" {{ old('tipe_kamar', $kamar->tipe_kamar) === 'VIP' ? 'selected' : '' }}>VIP</option>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label">Informasi Listrik</label>
              <select name="listrik" class="form-select">
                <option value="">-- Pilih Info Listrik --</option>
                <option value="Termasuk Listrik" {{ old('listrik', $kamar->listrik) === 'Termasuk Listrik' ? 'selected' : '' }}>Sudah Termasuk Listrik</option>
                <option value="Token Sendiri" {{ old('listrik', $kamar->listrik) === 'Token Sendiri' ? 'selected' : '' }}>Beli Token Sendiri (Meteran di kamar)</option>
                <option value="Bayar Sesuai Pemakaian" {{ old('listrik', $kamar->listrik) === 'Bayar Sesuai Pemakaian' ? 'selected' : '' }}>Bayar di luar sewa (Sesuai pemakaian)</option>
              </select>
            </div>

<div class="col-md-6">
  <label class="form-label">Ukuran Kamar</label>
  <input type="text" name="ukuran" class="form-control" value="{{ old('ukuran', $kamar->ukuran) }}" placeholder="Contoh: 3x4 m²">
</div>

<div class="col-12">
  <label class="form-label">Deskripsi Kamar</label>
  <textarea name="deskripsi" rows="2" class="form-control" placeholder="Contoh: Kamar nyaman dengan ventilasi baik">{{ old('deskripsi', $kamar->deskripsi) }}</textarea>
</div>

<div class="col-12">
  <label class="form-label">Aturan Khusus Kamar</label>
  <textarea name="aturan_kamar" rows="2" class="form-control" placeholder="Contoh: Maksimal 2 orang, Tidak boleh membawa hewan, dll">{{ old('aturan_kamar', $kamar->aturan_kamar) }}</textarea>
  <small class="text-muted">Opsional, isi jika ada aturan spesifik untuk tipe kamar ini.</small>
</div>
<div class="col-12">
  <label class="form-label">Fasilitas Kamar</label>
  @php
  $fasilitasList = [
    'Tempat Tidur (Kasur, Bantal, Guling)',
    'Lemari Pakaian',
    'Meja & Kursi Belajar',
    'AC',
    'Kipas Angin',
    'Stopkontak',
    'Kamar Mandi Dalam',
    'Kamar Mandi Luar',
    'Gantungan Baju (Kapstok)',
    'TV',
    'WiFi',
    'Kulkas',
    'Dapur',

];
  $selectedFasilitas = old('fasilitas', is_array($kamar->fasilitas) ? $kamar->fasilitas : []);
@endphp
  <div class="row g-2">
    @foreach($fasilitasList as $f)
    <div class="col-6 col-md-4 col-lg-3">
      <label class="d-flex align-items-center gap-2 p-2 rounded-3 border" style="cursor:pointer;font-size:.82rem;background:#fff;">
        <input type="checkbox" name="fasilitas[]" value="{{ $f }}"
          {{ in_array($f, $selectedFasilitas) ? 'checked' : '' }}
          style="accent-color:#e8401c;">
        {{ $f }}
      </label>
    </div>
    @endforeach
  </div>
</div>

<div class="col-md-6">
  <label class="form-label">Upload Foto Kamar</label>

  @php $sisaSlot = 6 - $kamar->images->count(); @endphp

  @if($kamar->images->isNotEmpty())
    <div class="mb-2 p-2 rounded-3 border" style="background:#fff5f2;border-color:#ffd0c0!important;">
      <label class="d-flex align-items-center gap-2" style="cursor:pointer;font-size:.82rem;">
        <input type="checkbox" name="hapus_semua_foto" id="hapusSemua" value="1"
          style="accent-color:#e8401c;" onchange="toggleSlot()">
        <span>🗑️ <strong>Ganti Semua Foto</strong> — hapus foto lama dan upload baru</span>
      </label>
    </div>
  @endif

  <input type="file" name="foto_kamar[]" class="form-control" accept="image/*" multiple
    id="fotoKamarInput"
    data-existing="{{ $kamar->images->count() }}"
    data-max-files="{{ $sisaSlot }}"
    {{ $sisaSlot <= 0 ? 'disabled' : '' }}>

  <small class="text-muted" id="slotInfo">
    @if($sisaSlot <= 0)
      Foto sudah penuh (maksimal 6 foto). Centang <strong>Ganti Semua Foto</strong> kalau mau upload baru.
    @else
      Sisa slot: <strong>{{ $sisaSlot }} foto</strong> (sudah ada {{ $kamar->images->count() }}, maksimal 6).
    @endif
  </small>
</div>

            <div class="col-md-6">
              <label class="form-label d-block">Foto Saat Ini</label>
              @if($kamar->images->isNotEmpty())
                <div class="thumb-grid">
                  @foreach($kamar->images as $img)
                    <img src="{{ '/storage/'.ltrim($img->foto_path, '/') }}" class="thumb" alt="Foto kamar">
                  @endforeach
                </div>
              @else
                <span class="text-muted">Belum ada foto kamar.</span>
              @endif
            </div>
          </div>

          <div class="mt-3 d-flex gap-2">
            <a href="{{ route('owner.kamar.index') }}" class="btn btn-outline-secondary">Batal</a>
            <button type="submit" class="btn btn-danger">Update Kamar</button>
          </div>
        </form>
      </div>
    </div>

    <footer class="owner-footer">&copy; {{ date('Y') }} KostFinder - Panel Pemilik Kost.</footer>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function toggleHarga(type) {
  const checkbox = document.getElementById('aktif' + type);
  const inputBox = document.getElementById('input' + type);

  if (checkbox && inputBox) {
    inputBox.style.display = checkbox.checked ? 'block' : 'none';
  }
}

function toggleSlot() {
  const cb = document.getElementById('hapusSemua');
  const input = document.getElementById('fotoKamarInput');
  const info = document.getElementById('slotInfo');

  if (!input || !info) return;

  const existing = Number(input.dataset.existing || 0);

  if (cb && cb.checked) {
    input.dataset.maxFiles = 6;
    input.disabled = false;
    info.innerHTML = 'Sisa slot: <strong>6 foto</strong> (foto lama akan dihapus semua).';
    input.style.borderColor = '#e8401c';
  } else {
    const sisa = 6 - existing;
    input.dataset.maxFiles = sisa;
    input.disabled = sisa <= 0;
    info.innerHTML = sisa <= 0
      ? 'Foto sudah penuh (maksimal 6 foto). Centang <strong>Ganti Semua Foto</strong> kalau mau upload baru.'
      : `Sisa slot: <strong>${sisa} foto</strong> (sudah ada ${existing}, maksimal 6).`;
    input.style.borderColor = '';
  }

  input.value = '';
}

document.addEventListener('DOMContentLoaded', function () {
  toggleHarga('Bulanan');
  toggleHarga('Harian');
  toggleSlot();

  const fotoKamarInput = document.getElementById('fotoKamarInput');

  if (fotoKamarInput) {
    fotoKamarInput.addEventListener('change', function() {
      const cb = document.getElementById('hapusSemua');
      const maxFiles = (cb && cb.checked) ? 6 : Number(this.dataset.maxFiles || 6);

      if (this.files.length > maxFiles) {
        alert(`Maksimal ${maxFiles} foto yang bisa diupload.`);
        this.value = '';
      }
    });
  }
});
</script>
</body>
</html>

