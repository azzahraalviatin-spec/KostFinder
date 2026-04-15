{{--
  Partial: _form_verifikasi.blade.php
  Letakkan di: resources/views/owner/_form_verifikasi.blade.php
  Dipanggil dengan @include('owner._form_verifikasi', ['formId' => 'namaForm'])
--}}
<form action="{{ route('owner.pengaturan.update') }}" method="POST" enctype="multipart/form-data" id="{{ $formId ?? 'formVerif' }}">
  @csrf @method('PATCH')

  <div class="row g-3 mb-3">

    {{-- FOTO KTP --}}
    <div class="col-md-6">
      <label class="form-label">
        <i class="bi bi-card-text me-1" style="color:var(--primary);"></i>
        Foto KTP / Identitas <span style="color:#dc2626;">*</span>
      </label>
      <label for="fotoKTP_{{ $formId ?? 'x' }}" class="upload-box" id="box_ktp_{{ $formId ?? 'x' }}">
        <i class="bi bi-card-text"></i>
        <div style="font-size:.78rem;font-weight:600;color:#555;margin-bottom:.2rem;">Klik untuk upload foto KTP</div>
        <div style="font-size:.72rem;color:#94a3b8;">JPG, PNG — maks. 2MB</div>
        <input type="file" name="foto_ktp" id="fotoKTP_{{ $formId ?? 'x' }}" class="d-none" accept="image/*"
          onchange="previewUpload(this, 'box_ktp_{{ $formId ?? 'x' }}')">
      </label>
      <div style="font-size:.72rem;color:#6b7a8d;margin-top:.4rem;">
        <i class="bi bi-info-circle me-1"></i>Pastikan semua tulisan terbaca jelas
      </div>
    </div>

    {{-- FOTO SELFIE --}}
    <div class="col-md-6">
      <label class="form-label">
        <i class="bi bi-camera me-1" style="color:var(--primary);"></i>
        Selfie Pegang KTP <span style="color:#dc2626;">*</span>
      </label>
      <label for="fotoSelfie_{{ $formId ?? 'x' }}" class="upload-box" id="box_selfie_{{ $formId ?? 'x' }}">
        <i class="bi bi-camera"></i>
        <div style="font-size:.78rem;font-weight:600;color:#555;margin-bottom:.2rem;">Klik untuk upload foto selfie</div>
        <div style="font-size:.72rem;color:#94a3b8;">Wajah + KTP terlihat jelas</div>
        <input type="file" name="foto_selfie" id="fotoSelfie_{{ $formId ?? 'x' }}" class="d-none" accept="image/*"
          onchange="previewUpload(this, 'box_selfie_{{ $formId ?? 'x' }}')">
      </label>
      <div style="font-size:.72rem;color:#6b7a8d;margin-top:.4rem;">
        <i class="bi bi-info-circle me-1"></i>Pegang KTP di samping wajah kamu
      </div>
    </div>

    {{-- BUKTI KEPEMILIKAN --}}
    <div class="col-12">
      <label class="form-label">
        <i class="bi bi-house-check me-1" style="color:var(--primary);"></i>
        Bukti Kepemilikan Kost <span style="color:#dc2626;">*</span>
      </label>

      {{-- Info box pilihan dokumen --}}
      <div style="background:#f8fafd;border:1px solid #e4e9f0;border-radius:.65rem;padding:.75rem 1rem;margin-bottom:.6rem;">
        <div style="font-size:.76rem;font-weight:700;color:#444;margin-bottom:.5rem;">Pilih salah satu dokumen:</div>
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(140px,1fr));gap:.4rem;">
          @foreach([
            ['bi-file-text','Sertifikat Tanah / SHM'],
            ['bi-building','IMB / PBG'],
            ['bi-file-earmark-text','Akta Jual Beli'],
            ['bi-file-earmark','Surat Sewa / Kontrak'],
            ['bi-camera','Foto Depan Kost'],
          ] as $item)
          <div style="display:flex;align-items:center;gap:.4rem;font-size:.73rem;color:#555;">
            <i class="bi {{ $item[0] }}" style="color:#8fa3b8;font-size:.8rem;flex-shrink:0;"></i>
            {{ $item[1] }}
          </div>
          @endforeach
        </div>
      </div>

      <label for="fotoKepemilikan_{{ $formId ?? 'x' }}" class="upload-box" id="box_kepemilikan_{{ $formId ?? 'x' }}">
        <i class="bi bi-house-check"></i>
        <div style="font-size:.78rem;font-weight:600;color:#555;margin-bottom:.2rem;">Klik untuk upload bukti kepemilikan</div>
        <div style="font-size:.72rem;color:#94a3b8;">JPG, PNG, atau PDF — maks. 5MB</div>
        <input type="file" name="foto_kepemilikan" id="fotoKepemilikan_{{ $formId ?? 'x' }}" class="d-none"
          accept="image/*,application/pdf"
          onchange="previewUpload(this, 'box_kepemilikan_{{ $formId ?? 'x' }}')">
      </label>
    </div>

  </div>

  {{-- Tips --}}
  <div style="background:#fffbf0;border:1px solid #fde68a;border-radius:.65rem;padding:.8rem 1rem;font-size:.76rem;color:#78532a;line-height:1.6;margin-bottom:1rem;">
    <div style="font-weight:700;margin-bottom:.3rem;"><i class="bi bi-lightbulb-fill me-1"></i> Tips agar dokumen disetujui:</div>
    <ul style="margin:0;padding-left:1.2rem;">
      <li>Foto harus terang, tidak blur, dan semua teks terbaca</li>
      <li>Nama di KTP harus sama dengan nama akun kamu</li>
      <li>Bukti kepemilikan harus sesuai alamat kost yang didaftarkan</li>
    </ul>
  </div>

  <button type="submit" class="btn-save">
    <i class="bi bi-shield-check me-1"></i> Kirim untuk Diverifikasi
  </button>

</form>