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

    /* ===== FOTO FASILITAS KAMAR ===== */
    .section-divider {
      border-top: 2px dashed #e4e9f0;
      margin: 1.5rem 0 1rem;
    }
    .fas-item-card {
      background: #f8fafd;
      border: 1px solid #e4e9f0;
      border-radius: .65rem;
      padding: .85rem;
      position: relative;
    }
    .fas-preview {
      width: 100%;
      height: 110px;
      object-fit: cover;
      border-radius: .4rem;
      display: none;
      margin-bottom: .5rem;
    }
    .fas-preview.show { display: block; }
    .fas-placeholder {
      width: 100%;
      height: 110px;
      border-radius: .4rem;
      background: #eef1f6;
      border: 2px dashed #cdd5df;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      color: #b0bec5;
      font-size: .75rem;
      cursor: pointer;
      margin-bottom: .5rem;
    }
    .fas-placeholder i { font-size: 1.4rem; margin-bottom: 3px; }
    .fas-placeholder.has-file { display: none; }
    .btn-remove-fas {
      position: absolute;
      top: 6px;
      right: 6px;
      width: 26px;
      height: 26px;
      border-radius: 50%;
      background: #fee2e2;
      color: #dc2626;
      border: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: .8rem;
      cursor: pointer;
      z-index: 2;
    }
    .btn-remove-fas:hover { background: #fecaca; }
    .btn-add-fasilitas {
      border: 2px dashed #d1dce9;
      background: #fff;
      border-radius: .65rem;
      height: 170px;
      width: 100%;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      color: var(--primary);
      font-size: .8rem;
      font-weight: 700;
      cursor: pointer;
      transition: all .2s;
    }
    .btn-add-fasilitas:hover { border-color: var(--primary); background: #fff5f3; }
    .btn-add-fasilitas i { font-size: 1.5rem; margin-bottom: 4px; }

    /* foto fasilitas existing */
    .fas-exist-card {
      position: relative;
      border-radius: .55rem;
      overflow: hidden;
      border: 1px solid #e4e9f0;
    }
    .fas-exist-card img {
      width: 100%;
      height: 100px;
      object-fit: cover;
      display: block;
    }
    .fas-exist-label {
      background: rgba(30,45,61,.75);
      color: #fff;
      font-size: .7rem;
      font-weight: 600;
      padding: 3px 8px;
      text-align: center;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }
    .fas-exist-del {
      position: absolute;
      top: 5px;
      right: 5px;
      width: 22px;
      height: 22px;
      border-radius: 50%;
      background: rgba(220,38,38,.85);
      color: #fff;
      border: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: .7rem;
      cursor: pointer;
    }
    .fas-exist-del:hover { background: #b91c1c; }
    .fas-exist-card.marked-delete { opacity: .45; }
    .fas-exist-card.marked-delete .fas-exist-del { background: #666; }
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
        <h6 class="mb-3" style="font-weight:700;color:var(--dark);">
          <i class="bi bi-pencil-square me-1" style="color:var(--primary)"></i> Edit Kamar
        </h6>

        <form action="{{ route('owner.kamar.update', $kamar->id_room) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="row g-3">

            {{-- PILIH KOST --}}
            <div class="col-md-6">
              <label class="form-label">Pilih Kost</label>
              <select name="kost_id" class="form-select" required>
                <option value="">-- Pilih Kost --</option>
                @foreach($kosts as $kost)
                  <option value="{{ $kost->id_kost }}" {{ old('kost_id', $kamar->kost_id) == $kost->id_kost ? 'selected' : '' }}>
                    {{ $kost->nama_kost }}
                  </option>
                @endforeach
              </select>
            </div>

            {{-- NAMA KAMAR --}}
            <div class="col-md-6">
              <label class="form-label">Tipe / Nama Kamar</label>
              <input type="text" name="nomor_kamar" class="form-control"
                value="{{ old('nomor_kamar', $kamar->nomor_kamar) }}"
                placeholder="Contoh: Tipe A, Kamar 101, dll" required>
              <small class="text-muted">Gunakan ini sebagai identitas kamar.</small>
            </div>

            {{-- HARGA --}}
            <div class="col-12">
              <label class="form-label fw-bold">Harga & Durasi Sewa</label>
              <div class="row g-2">
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

            {{-- STATUS --}}
            <div class="col-md-6">
              <label class="form-label">Status Kamar</label>
              <select name="status_kamar" class="form-select" required>
                <option value="tersedia" {{ old('status_kamar', $kamar->status_kamar) === 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                <option value="terisi"   {{ old('status_kamar', $kamar->status_kamar) === 'terisi'   ? 'selected' : '' }}>Terisi</option>
              </select>
            </div>

            {{-- TIPE --}}
            <div class="col-md-6">
              <label class="form-label">Kategori Tipe</label>
              <select name="tipe_kamar" class="form-select">
                <option value="">-- Pilih Kategori --</option>
                <option value="Standard" {{ old('tipe_kamar', $kamar->tipe_kamar) === 'Standard' ? 'selected' : '' }}>Standard</option>
                <option value="Deluxe"   {{ old('tipe_kamar', $kamar->tipe_kamar) === 'Deluxe'   ? 'selected' : '' }}>Deluxe</option>
                <option value="VIP"      {{ old('tipe_kamar', $kamar->tipe_kamar) === 'VIP'      ? 'selected' : '' }}>VIP</option>
              </select>
            </div>

            {{-- LISTRIK --}}
            <div class="col-md-6">
              <label class="form-label">Informasi Listrik</label>
              <select name="listrik" class="form-select">
                <option value="">-- Pilih Info Listrik --</option>
                <option value="Termasuk Listrik"        {{ old('listrik', $kamar->listrik) === 'Termasuk Listrik'        ? 'selected' : '' }}>Sudah Termasuk Listrik</option>
                <option value="Token Sendiri"           {{ old('listrik', $kamar->listrik) === 'Token Sendiri'           ? 'selected' : '' }}>Beli Token Sendiri</option>
                <option value="Bayar Sesuai Pemakaian"  {{ old('listrik', $kamar->listrik) === 'Bayar Sesuai Pemakaian'  ? 'selected' : '' }}>Bayar Sesuai Pemakaian</option>
              </select>
            </div>

            {{-- UKURAN --}}
            <div class="col-md-6">
              <label class="form-label">Ukuran Kamar</label>
              <input type="text" name="ukuran" class="form-control" value="{{ old('ukuran', $kamar->ukuran) }}" placeholder="Contoh: 3x4 m²">
            </div>

            {{-- DESKRIPSI --}}
            <div class="col-12">
              <label class="form-label">Deskripsi Kamar</label>
              <textarea name="deskripsi" rows="2" class="form-control" placeholder="Contoh: Kamar nyaman dengan ventilasi baik">{{ old('deskripsi', $kamar->deskripsi) }}</textarea>
            </div>

            {{-- ATURAN --}}
            <div class="col-12">
              <label class="form-label">Aturan Khusus Kamar</label>
              <textarea name="aturan_kamar" rows="2" class="form-control" placeholder="Contoh: Maksimal 2 orang, Tidak boleh membawa hewan, dll">{{ old('aturan_kamar', $kamar->aturan_kamar) }}</textarea>
              <small class="text-muted">Opsional, isi jika ada aturan spesifik untuk tipe kamar ini.</small>
            </div>

            {{-- FASILITAS --}}
            <div class="col-12">
              <label class="form-label">Fasilitas Kamar</label>
              @php
                $fasilitasList = [
                  'Tempat Tidur (Kasur, Bantal, Guling)', 'Lemari Pakaian', 'Meja & Kursi Belajar',
                  'AC', 'Kipas Angin', 'Stopkontak', 'Kamar Mandi Dalam', 'Kamar Mandi Luar',
                  'Gantungan Baju (Kapstok)', 'TV', 'WiFi', 'Kulkas', 'Dapur',
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

            {{-- ======================================================
                 FOTO KAMAR UTAMA
            ====================================================== --}}
            <div class="col-12">
              <div class="section-divider"></div>
              <label class="form-label fw-bold" style="color:var(--dark);font-size:.9rem;">
                <i class="bi bi-camera me-1" style="color:var(--primary)"></i> Foto Kamar
              </label>

              @php $sisaSlot = 6 - $fotoKamar->count(); @endphp

              @if($fotoKamar->isNotEmpty())
                <div class="mb-2 p-2 rounded-3 border" style="background:#fff5f2;border-color:#ffd0c0!important;">
                  <label class="d-flex align-items-center gap-2" style="cursor:pointer;font-size:.82rem;">
                    <input type="checkbox" name="hapus_semua_foto" id="hapusSemua" value="1"
                      style="accent-color:#e8401c;" onchange="toggleSlot()">
                    <span>🗑️ <strong>Ganti Semua Foto Kamar</strong> — hapus foto lama dan upload baru</span>
                  </label>
                </div>
              @endif

              <input type="file" name="foto_kamar[]" class="form-control mb-1" accept="image/*" multiple
                id="fotoKamarInput"
                data-existing="{{ $fotoKamar->count() }}"
                data-max-files="{{ $sisaSlot }}"
                {{ $sisaSlot <= 0 ? 'disabled' : '' }}>

              <small class="text-muted" id="slotInfo">
                @if($sisaSlot <= 0)
                  Foto sudah penuh (maks. 6). Centang <strong>Ganti Semua Foto Kamar</strong> kalau mau upload baru.
                @else
                  Sisa slot: <strong>{{ $sisaSlot }} foto</strong> (sudah ada {{ $fotoKamar->count() }}, maks. 6).
                @endif
              </small>

              @if($fotoKamar->isNotEmpty())
                <div class="thumb-grid mt-2">
                  @foreach($fotoKamar as $img)
                    <img src="{{ '/storage/'.ltrim($img->foto_path, '/') }}" class="thumb" alt="Foto kamar">
                  @endforeach
                </div>
              @endif
            </div>

            {{-- ======================================================
                 FOTO FASILITAS KAMAR  ← BAGIAN BARU
            ====================================================== --}}
            <div class="col-12">
              <div class="section-divider"></div>
              <div class="d-flex justify-content-between align-items-center mb-2">
                <label class="form-label fw-bold mb-0" style="color:var(--dark);font-size:.9rem;">
                  <i class="bi bi-images me-1" style="color:var(--primary)"></i> Foto Fasilitas Kamar
                  <span class="text-muted fw-normal" style="font-size:.75rem;">(Kamar Mandi, Lemari, AC, dll)</span>
                </label>
                <small class="text-muted">Maks. 10 foto fasilitas</small>
              </div>
              <p class="text-muted mb-3" style="font-size:.78rem;">
                Upload foto fasilitas beserta namanya. Contoh: Foto Kamar Mandi, Judul: "Kamar Mandi".
              </p>

              {{-- Foto fasilitas yang sudah ada --}}
              @if($fotoFasilitas->isNotEmpty())
                <div class="row g-2 mb-3" id="fasExistGrid">
                  @foreach($fotoFasilitas as $img)
                  <div class="col-6 col-md-3 col-lg-2" id="fas-exist-{{ $img->id }}">
                    <div class="fas-exist-card">
                      <img src="{{ '/storage/'.ltrim($img->foto_path, '/') }}" alt="{{ $img->judul }}">
                      <div class="fas-exist-label">{{ $img->judul ?: 'Tanpa Judul' }}</div>
                      <button type="button" class="fas-exist-del"
                        onclick="toggleHapusFasilitas({{ $img->id }}, this)"
                        title="Hapus foto ini">
                        <i class="bi bi-trash3"></i>
                      </button>
                    </div>
                    {{-- Input hidden akan ditambah JS --}}
                  </div>
                  @endforeach
                </div>
              @endif

              {{-- Grid upload foto fasilitas baru --}}
              <div class="row g-2" id="fasGrid">
                {{-- Item pertama sudah langsung muncul --}}
                <div class="col-6 col-md-3 col-lg-2" id="fas-new-0">
                  <div class="fas-item-card">
                    <button type="button" class="btn-remove-fas" onclick="removeFasItem(0)" title="Hapus">
                      <i class="bi bi-x"></i>
                    </button>
                    <div class="fas-placeholder" id="fas-ph-0" onclick="document.getElementById('fas-file-0').click()">
                      <i class="bi bi-camera-fill"></i>
                      <span>Klik upload foto</span>
                    </div>
                    <img class="fas-preview" id="fas-prev-0" src="" alt="">
                    <input type="file" name="foto_fasilitas[0][file]" id="fas-file-0"
                      accept="image/*" style="display:none"
                      onchange="previewFas(0, this)">
                    <input type="text" name="foto_fasilitas[0][judul]" class="form-control mt-1"
                      placeholder="Judul (cth: Kamar Mandi)" style="font-size:.78rem;padding:.3rem .55rem;">
                  </div>
                </div>

                {{-- Tombol tambah --}}
                <div class="col-6 col-md-3 col-lg-2" id="fas-add-btn-col">
                  <button type="button" class="btn-add-fasilitas" onclick="tambahFasItem()" id="btnTambahFas">
                    <i class="bi bi-plus-circle-fill"></i>
                    Tambah Foto
                  </button>
                </div>
              </div>
            </div>

          </div>{{-- end row --}}

          <div class="mt-4 d-flex gap-2">
            <a href="{{ route('owner.kamar.index') }}" class="btn btn-outline-secondary">Batal</a>
            <button type="submit" class="btn btn-danger px-4">Update Kamar</button>
          </div>
        </form>
      </div>
    </div>

    <footer class="owner-footer">&copy; {{ date('Y') }} KostFinder - Panel Pemilik Kost.</footer>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    /* ========== HARGA TOGGLE ========== */
    function toggleHarga(type) {
      const cb  = document.getElementById('aktif' + type);
      const box = document.getElementById('input' + type);
      if (cb && box) box.style.display = cb.checked ? 'block' : 'none';
    }

    /* ========== SLOT FOTO KAMAR ========== */
    function toggleSlot() {
      const cb    = document.getElementById('hapusSemua');
      const input = document.getElementById('fotoKamarInput');
      const info  = document.getElementById('slotInfo');
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
          ? 'Foto sudah penuh (maks. 6). Centang <strong>Ganti Semua Foto Kamar</strong>.'
          : `Sisa slot: <strong>${sisa} foto</strong> (sudah ada ${existing}, maks. 6).`;
        input.style.borderColor = '';
      }
      input.value = '';
    }

    /* ========== HAPUS FOTO FASILITAS EXISTING ========== */
    const hapusFasilitasIds = new Set();

    function toggleHapusFasilitas(id, btn) {
      const card = document.querySelector(`#fas-exist-${id} .fas-exist-card`);
      if (hapusFasilitasIds.has(id)) {
        hapusFasilitasIds.delete(id);
        card.classList.remove('marked-delete');
        btn.innerHTML = '<i class="bi bi-trash3"></i>';
        // Remove hidden input
        const hidden = document.getElementById('del-fas-' + id);
        if (hidden) hidden.remove();
      } else {
        hapusFasilitasIds.add(id);
        card.classList.add('marked-delete');
        btn.innerHTML = '<i class="bi bi-arrow-counterclockwise"></i>';
        // Add hidden input
        const hidden = document.createElement('input');
        hidden.type  = 'hidden';
        hidden.name  = 'hapus_fasilitas_ids[]';
        hidden.value = id;
        hidden.id    = 'del-fas-' + id;
        document.querySelector('form').appendChild(hidden);
      }
    }

    /* ========== FOTO FASILITAS BARU ========== */
    let fasIndex = 1; // index ke-0 sudah ada

    function previewFas(idx, input) {
      const file = input.files[0];
      if (!file) return;
      const prev = document.getElementById('fas-prev-' + idx);
      const ph   = document.getElementById('fas-ph-' + idx);
      const reader = new FileReader();
      reader.onload = e => {
        prev.src = e.target.result;
        prev.classList.add('show');
        ph.classList.add('has-file');
      };
      reader.readAsDataURL(file);
    }

    function tambahFasItem() {
      const MAX_FAS = 10;
      const existing = {{ $fotoFasilitas->count() }};
      const newItems = document.querySelectorAll('[id^="fas-new-"]').length;
      if (existing + newItems >= MAX_FAS) {
        alert('Maksimal ' + MAX_FAS + ' foto fasilitas.');
        return;
      }

      const idx  = fasIndex++;
      const col  = document.createElement('div');
      col.className = 'col-6 col-md-3 col-lg-2';
      col.id = 'fas-new-' + idx;
      col.innerHTML = `
        <div class="fas-item-card">
          <button type="button" class="btn-remove-fas" onclick="removeFasItem(${idx})" title="Hapus">
            <i class="bi bi-x"></i>
          </button>
          <div class="fas-placeholder" id="fas-ph-${idx}" onclick="document.getElementById('fas-file-${idx}').click()">
            <i class="bi bi-camera-fill"></i>
            <span>Klik upload foto</span>
          </div>
          <img class="fas-preview" id="fas-prev-${idx}" src="" alt="">
          <input type="file" name="foto_fasilitas[${idx}][file]" id="fas-file-${idx}"
            accept="image/*" style="display:none"
            onchange="previewFas(${idx}, this)">
          <input type="text" name="foto_fasilitas[${idx}][judul]" class="form-control mt-1"
            placeholder="Judul (cth: AC)" style="font-size:.78rem;padding:.3rem .55rem;">
        </div>
      `;

      // Masukkan sebelum tombol "Tambah"
      const addBtn = document.getElementById('fas-add-btn-col');
      document.getElementById('fasGrid').insertBefore(col, addBtn);
    }

    function removeFasItem(idx) {
      const el = document.getElementById('fas-new-' + idx);
      if (el) el.remove();
    }

    /* ========== INIT ========== */
    document.addEventListener('DOMContentLoaded', function () {
      toggleHarga('Bulanan');
      toggleHarga('Harian');
      toggleSlot();

      const fotoInput = document.getElementById('fotoKamarInput');
      if (fotoInput) {
        fotoInput.addEventListener('change', function () {
          const cb  = document.getElementById('hapusSemua');
          const max = (cb && cb.checked) ? 6 : Number(this.dataset.maxFiles || 6);
          if (this.files.length > max) {
            alert(`Maksimal ${max} foto yang bisa diupload.`);
            this.value = '';
          }
        });
      }
    });
  </script>
</body>
</html>