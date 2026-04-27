@extends('layouts.owner')

@section('title', 'Edit Kamar')

@push('styles')
<style>
    .form-card { background:#fff; border-radius:1rem; border:1px solid var(--line); box-shadow:0 6px 20px rgba(0,0,0,.04); padding:1.5rem; margin-bottom:1.5rem; }
    .form-card h6 { font-weight:800; color:var(--dark); font-size:.95rem; margin-bottom:1.2rem; padding-bottom:.8rem; border-bottom:1px solid #f0f3f8; display:flex; align-items:center; gap:.5rem; }
    .form-label { font-size:.82rem; font-weight:700; color:#344054; margin-bottom:.4rem; }
    .form-control, .form-select { font-size:.85rem; border-color:var(--line); border-radius:.75rem; padding:.65rem .9rem; min-height:46px; }
    .form-control:focus, .form-select:focus { border-color:var(--primary); box-shadow:0 0 0 3px rgba(232,64,28,.1); }
    
    .preview-grid { display:grid; grid-template-columns:repeat(3, 1fr); gap:1rem; margin-top:1.2rem; }
    .preview-card { border-radius:.8rem; overflow:hidden; border:1px solid var(--line); background:#fff; position:relative; }
    .preview-img { height:120px; width:100%; object-fit:cover; }
    .btn-remove { position:absolute; top:5px; right:5px; background:rgba(220,38,38,.9); color:#fff; border:none; border-radius:50%; width:24px; height:24px; display:flex; align-items:center; justify-content:center; font-size:.7rem; cursor:pointer; }

    .btn-submit { background:linear-gradient(135deg,#e8401c,#ff7043); color:#fff; font-weight:700; border:0; border-radius:.75rem; padding:.8rem 2rem; font-size:.9rem; cursor:pointer; box-shadow:0 6px 16px rgba(232,64,28,.2); transition:.2s; display:inline-flex; align-items:center; gap:.5rem; }
    .btn-submit:hover { transform:translateY(-2px); box-shadow:0 8px 20px rgba(232,64,28,.3); }
</style>
@endpush

@section('content')
      <div class="d-flex align-items-center gap-2 mb-3" style="font-size:.82rem; color:var(--muted);">
        <a href="{{ route('owner.kamar.index') }}" style="color:var(--muted); text-decoration:none;">Kelola Kamar</a>
        <i class="bi bi-chevron-right" style="font-size:.7rem;"></i>
        <span style="color:var(--dark); font-weight:700;">Edit Kamar #{{ $kamar->nomor_kamar }}</span>
      </div>

      <form action="{{ route('owner.kamar.update', $kamar->id_room) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <div class="row">
          <div class="col-lg-8">
            {{-- PILIH KOST --}}
            <div class="form-card">
              <h6><i class="bi bi-house" style="color:var(--primary)"></i> Properti Kost</h6>
              <div class="mb-3">
                <label class="form-label">Kost <span class="text-danger">*</span></label>
                <select name="kost_id" class="form-select @error('kost_id') is-invalid @enderror" required>
                  @foreach($kosts as $k)
                    <option value="{{ $k->id_kost }}" {{ $kamar->kost_id == $k->id_kost ? 'selected' : '' }}>{{ $k->nama_kost }}</option>
                  @endforeach
                </select>
                @error('kost_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
            </div>

            {{-- INFORMASI DASAR --}}
            <div class="form-card">
              <h6><i class="bi bi-info-circle" style="color:var(--primary)"></i> Informasi Kamar</h6>
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label">Nomor/Nama Kamar <span class="text-danger">*</span></label>
                  <input type="text" name="nomor_kamar" class="form-control" value="{{ old('nomor_kamar', $kamar->nomor_kamar) }}" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Tipe Kamar</label>
                  <input type="text" name="tipe_kamar" class="form-control" value="{{ old('tipe_kamar', $kamar->tipe_kamar) }}">
                </div>
                <div class="col-md-6">
                  <label class="form-label">Ukuran Kamar (PxL)</label>
                  <input type="text" name="ukuran" class="form-control" value="{{ old('ukuran', $kamar->ukuran) }}">
                </div>
                <div class="col-md-6">
                  <label class="form-label">Info Listrik</label>
                  <select name="listrik" class="form-select">
                    <option value="Termasuk" {{ $kamar->listrik == 'Termasuk' ? 'selected' : '' }}>Termasuk Biaya Sewa</option>
                    <option value="Token Sendiri" {{ $kamar->listrik == 'Token Sendiri' ? 'selected' : '' }}>Token Sendiri (Bayar Terpisah)</option>
                    <option value="Tagihan Bulanan" {{ $kamar->listrik == 'Tagihan Bulanan' ? 'selected' : '' }}>Tagihan Bulanan Terpisah</option>
                  </select>
                </div>
              </div>
              <div class="mt-3">
                <label class="form-label">Deskripsi Kamar</label>
                <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi', $kamar->deskripsi) }}</textarea>
              </div>
            </div>

            {{-- FASILITAS KAMAR --}}
            <div class="form-card">
              <h6><i class="bi bi-check2-square" style="color:var(--primary)"></i> Fasilitas Kamar</h6>
              @php $fasilitasList = is_array($kamar->fasilitas) ? $kamar->fasilitas : []; @endphp
              <div class="row g-2">
                @foreach(['AC', 'Kamar Mandi Dalam', 'Kasur/Springbed', 'Lemari Baju', 'Meja & Kursi', 'TV', 'Water Heater', 'WiFi Kamar', 'Bantal', 'Jendela'] as $f)
                  <div class="col-6 col-md-4">
                    <div class="form-check p-2 border rounded-3" style="font-size:.8rem; background:#f8fafc;">
                      <input class="form-check-input ms-0 me-2" type="checkbox" name="fasilitas[]" value="{{ $f }}" id="f_{{ $loop->index }}" {{ in_array($f, $fasilitasList) ? 'checked' : '' }}>
                      <label class="form-check-label" for="f_{{ $loop->index }}">{{ $f }}</label>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>

            {{-- FOTO KAMAR --}}
            <div class="form-card">
              <h6><i class="bi bi-camera" style="color:var(--primary)"></i> Foto Kamar</h6>
              
              {{-- Foto Saat Ini --}}
              <div class="mb-3">
                <label class="form-label d-block small text-muted">Foto Saat Ini (Klik sampah untuk menghapus)</label>
                <div class="preview-grid">
                  @foreach($fotoKamar as $img)
                    <div class="preview-card">
                      <div class="preview-img-wrap">
                        <img src="{{ asset('storage/' . $img->foto_path) }}">
                        @if($img->is_utama)
                          <div class="badge-cover"><i class="bi bi-star-fill"></i> Utama</div>
                        @endif
                        <div class="form-check p-0 m-0 position-absolute" style="top:5px; right:5px; z-index:10;">
                          <input type="checkbox" name="hapus_foto_ids[]" value="{{ $img->id }}" class="btn-check" id="del_img_{{ $img->id }}">
                          <label class="btn-remove" for="del_img_{{ $img->id }}"><i class="bi bi-trash"></i></label>
                        </div>
                      </div>
                      <div class="preview-info">
                        <input type="text" name="existing_foto_judul[{{ $img->id }}]" 
                               class="preview-label-input" 
                               placeholder="Label (contoh: Kasur, Meja...)"
                               value="{{ $img->judul }}">
                      </div>
                    </div>
                  @endforeach
                </div>
              </div>

              <div class="mb-3">
                <label class="form-label d-block small text-muted">Upload Foto Baru</label>
                <input type="file" name="foto_kamar[]" id="foto_kamar" class="form-control" multiple accept="image/*" onchange="previewImages(this, 'previewGridNew')">
                <div id="judulFotoInputs"></div>
                <div id="previewGridNew" class="preview-grid"></div>
              </div>
            </div>
          </div>

          <div class="col-lg-4">
            {{-- STATUS etc --}}
            <div class="form-card">
              <h6><i class="bi bi-cash-stack" style="color:var(--primary)"></i> Harga Sewa</h6>
              <div class="mb-3">
                <div class="form-check form-switch mb-2">
                  <input class="form-check-input" type="checkbox" name="aktif_bulanan" id="aktif_bulanan" {{ $kamar->aktif_bulanan ? 'checked' : '' }}>
                  <label class="form-check-label fw-bold" for="aktif_bulanan">Bisa Sewa Bulanan</label>
                </div>
                <div class="input-group">
                  <span class="input-group-text">Rp</span>
                  <input type="number" name="harga_per_bulan" class="form-control" value="{{ $kamar->harga_per_bulan }}">
                </div>
              </div>
              <div class="mb-3">
                <div class="form-check form-switch mb-2">
                  <input class="form-check-input" type="checkbox" name="aktif_harian" id="aktif_harian" {{ $kamar->aktif_harian ? 'checked' : '' }}>
                  <label class="form-check-label fw-bold" for="aktif_harian">Bisa Sewa Harian</label>
                </div>
                <div class="input-group">
                  <span class="input-group-text">Rp</span>
                  <input type="number" name="harga_harian" class="form-control" value="{{ $kamar->harga_harian }}">
                </div>
              </div>
            </div>

            <div class="form-card">
              <h6><i class="bi bi-toggle-on" style="color:var(--primary)"></i> Status Kamar</h6>
              <select name="status_kamar" class="form-select">
                <option value="tersedia" {{ $kamar->status_kamar == 'tersedia' ? 'selected' : '' }}>Tersedia (Kosong)</option>
                <option value="terisi" {{ $kamar->status_kamar == 'terisi' ? 'selected' : '' }}>Terisi (Penuh)</option>
              </select>
            </div>

            <button type="submit" class="btn-submit w-100 mb-4">
              <i class="bi bi-check-lg"></i> Simpan Perubahan
            </button>
            <a href="{{ route('owner.kamar.index') }}" class="btn btn-outline-secondary w-100 rounded-3 py-2 fw-bold">Batal</a>
          </div>
        </div>
      </form>
@endsection

@push('scripts')
<script>
    window._judulFotoValues = {};

    function previewImages(input, gridId) {
      const grid = document.getElementById(gridId);
      const judulContainer = document.getElementById('judulFotoInputs');
      grid.innerHTML = '';
      judulContainer.innerHTML = '';
      
      if (input.files) {
        Array.from(input.files).forEach((file, i) => {
          const reader = new FileReader();
          reader.onload = function(e) {
            const card = document.createElement('div');
            card.className = 'preview-card';
            card.innerHTML = `
              <div class="preview-img-wrap">
                <img src="${e.target.result}">
              </div>
              <div class="preview-info">
                <input type="text" 
                       placeholder="Label (contoh: Kasur, Meja...)" 
                       class="preview-label-input" 
                       value="${window._judulFotoValues[i] || ''}"
                       oninput="syncJudulFoto(${i}, this.value)">
              </div>
            `;
            grid.appendChild(card);

            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'foto_kamar_judul[]';
            hiddenInput.id = `hidden_judul_${i}`;
            hiddenInput.value = window._judulFotoValues[i] || '';
            judulContainer.appendChild(hiddenInput);
          }
          reader.readAsDataURL(file);
        });
      }
    }

    function syncJudulFoto(index, value) {
      window._judulFotoValues[index] = value;
      const hidden = document.getElementById(`hidden_judul_${index}`);
      if (hidden) hidden.value = value;
    }
</script>
@endpush
