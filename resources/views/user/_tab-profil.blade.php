<div class="content-card">
  <div class="content-card-head">Profil Saya</div>
  
  <div class="content-card-body" style="padding-top:1rem;">
    @if(session('status') === 'profile-updated')
      <div class="alert-success-custom"><i class="bi bi-check-circle-fill"></i> Profil berhasil diperbarui.</div>
    @endif
    
    <div class="info-banner" style="background:#e8f4fd; border:1px solid #bee3f8; border-radius:.65rem; padding:.75rem 1rem; display:flex; align-items:center; gap:.6rem; font-size:.82rem; color:#2b6cb0; margin-bottom:1.5rem;">
      <i class="bi bi-info-circle-fill"></i>
      Pemilik kos lebih menyukai calon penyewa dengan profil yang jelas dan lengkap.
    </div>

    <form method="POST" action="{{ route('user.profil.update') }}" enctype="multipart/form-data">
      @csrf
      @method('PATCH')

      {{-- FOTO --}}
      <div class="foto-wrap" style="display:flex; flex-direction:column; align-items:center; margin-bottom:1.8rem;">
        <div class="foto-avatar" onclick="toggleFotoMenu(event)" style="width:88px; height:88px; border-radius:50%; background:#e8401c; color:#fff; font-weight:800; font-size:2rem; display:flex; align-items:center; justify-content:center; overflow:hidden; margin-bottom:.5rem; border:3px solid #fff; box-shadow:0 4px 16px rgba(232,64,28,.2); cursor:pointer; position:relative;">
          @if(auth()->user()->foto_profil)
            <img src="{{ asset('storage/'.auth()->user()->foto_profil) }}" alt="foto" id="fotoPreview" style="width:88px; height:88px; object-fit:cover; border-radius:50%;">
          @else
            <span id="fotoInitial">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</span>
            <img src="" alt="" id="fotoPreview" style="display:none; width:88px; height:88px; object-fit:cover; border-radius:50%;">
          @endif
          <div class="foto-avatar-overlay" style="position:absolute; inset:0; background:rgba(0,0,0,.35); border-radius:50%; display:flex; align-items:center; justify-content:center; opacity:0; transition:opacity .2s;">
            <i class="bi bi-camera" style="color:#fff; font-size:1.2rem;"></i>
          </div>
        </div>
        <label class="foto-label" onclick="toggleFotoMenu(event)" style="font-size:.8rem; color:#e8401c; font-weight:600; cursor:pointer;">Ubah Foto</label>
        <input type="file" id="fotoInput" name="foto_profil" accept="image/*" style="display:none;" onchange="previewFoto(this)">

        {{-- POPUP MENU --}}
        <div id="fotoMenu" style="display:none;position:absolute;background:#fff;border:1px solid #e4e9f0;border-radius:.75rem;box-shadow:0 8px 24px rgba(0,0,0,.12);z-index:999;overflow:hidden;min-width:180px;margin-top:7rem;">
          <button type="button" onclick="bukaPilihFoto()" style="width:100%;padding:.7rem 1rem;border:0;background:#fff;text-align:left;font-size:.83rem;font-weight:600;color:#374151;cursor:pointer;display:flex;align-items:center;gap:.6rem;transition:background .15s;" onmouseover="this.style.background='#f8fafd'" onmouseout="this.style.background='#fff'">
            <i class="bi bi-camera" style="color:#e8401c;"></i> Ubah Foto
          </button>
          @if(auth()->user()->foto_profil)
          <button type="button" onclick="hapusFotoProfil()" style="width:100%;padding:.7rem 1rem;border:0;border-top:1px solid #f0f3f8;background:#fff;text-align:left;font-size:.83rem;font-weight:600;color:#dc2626;cursor:pointer;display:flex;align-items:center;gap:.6rem;transition:background .15s;" onmouseover="this.style.background='#fff5f5'" onmouseout="this.style.background='#fff'">
            <i class="bi bi-trash"></i> Hapus Foto
          </button>
          @endif
        </div>
      </div>

      {{-- INFORMASI PRIBADI --}}
      <div class="form-section" style="background:#fff; border-radius:.85rem; border:1px solid #e4e9f0; overflow:hidden; margin-bottom:1rem;">
        <div class="form-section-title" style="font-size:.72rem; font-weight:700; color:#8fa3b8; letter-spacing:.08em; padding:.75rem 1.2rem .4rem; background:#f8fafd; border-bottom:1px solid #f0f3f8;">INFORMASI PRIBADI</div>
        <div class="form-row-item" style="display:flex; align-items:center; padding:.85rem 1.2rem; border-bottom:1px solid #f8fafd; gap:1rem;">
          <div class="form-row-label" style="width:180px; flex-shrink:0; font-size:.84rem; font-weight:600; color:#374151;">Nama Lengkap</div>
          <div class="form-row-input" style="flex:1;"><input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" placeholder="Masukkan nama lengkap" style="width:100%; border:1px solid #e4e9f0; border-radius:.5rem; padding:.5rem .75rem; font-size:.84rem; color:#374151; background:#f8fafd; font-family:'Plus Jakarta Sans',sans-serif; outline:none; transition:border .2s;"></div>
        </div>
        <div class="form-row-item" style="display:flex; align-items:center; padding:.85rem 1.2rem; border-bottom:1px solid #f8fafd; gap:1rem;">
          <div class="form-row-label" style="width:180px; flex-shrink:0; font-size:.84rem; font-weight:600; color:#374151;">Jenis Kelamin<span class="wajib" style="font-size:.68rem; color:#ea580c; font-weight:400; display:block; margin-top:.1rem;">Wajib diisi</span></div>
          <div class="form-row-input" style="flex:1;">
            <select name="jenis_kelamin" id="selJK">
              <option value="">Pilih jenis kelamin</option>
              <option value="laki-laki" {{ auth()->user()->jenis_kelamin=='laki-laki'?'selected':'' }}>Laki-laki</option>
              <option value="perempuan" {{ auth()->user()->jenis_kelamin=='perempuan'?'selected':'' }}>Perempuan</option>
            </select>
          </div>
        </div>
        <div class="form-row-item" style="display:flex; align-items:center; padding:.85rem 1.2rem; border-bottom:1px solid #f8fafd; gap:1rem;">
          <div class="form-row-label" style="width:180px; flex-shrink:0; font-size:.84rem; font-weight:600; color:#374151;">Tanggal Lahir<span class="wajib" style="font-size:.68rem; color:#ea580c; font-weight:400; display:block; margin-top:.1rem;">Wajib diisi</span></div>
          <div class="form-row-input" style="flex:1;"><input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', auth()->user()->tanggal_lahir) }}" style="width:100%; border:1px solid #e4e9f0; border-radius:.5rem; padding:.5rem .75rem; font-size:.84rem; color:#374151; background:#f8fafd; font-family:'Plus Jakarta Sans',sans-serif; outline:none;"></div>
        </div>
        <div class="form-row-item" style="display:flex; align-items:center; padding:.85rem 1.2rem; border-bottom:1px solid #f8fafd; gap:1rem;">
          <div class="form-row-label" style="width:180px; flex-shrink:0; font-size:.84rem; font-weight:600; color:#374151;">Nomor HP</div>
          <div class="form-row-input" style="flex:1;"><input type="text" name="no_hp" value="{{ old('no_hp', auth()->user()->no_hp) }}" placeholder="+62 xxxx xxxx" style="width:100%; border:1px solid #e4e9f0; border-radius:.5rem; padding:.5rem .75rem; font-size:.84rem; color:#374151; background:#f8fafd; font-family:'Plus Jakarta Sans',sans-serif; outline:none;"></div>
        </div>
        <div class="form-row-item" style="display:flex; align-items:center; padding:.85rem 1.2rem; border-bottom:1px solid #f8fafd; gap:1rem;">
          <div class="form-row-label" style="width:180px; flex-shrink:0; font-size:.84rem; font-weight:600; color:#374151;">Nomor Kontak Darurat</div>
          <div class="form-row-input" style="flex:1;"><input type="text" name="kontak_darurat" value="{{ old('kontak_darurat', auth()->user()->kontak_darurat) }}" placeholder="+62 xxxx xxxx" style="width:100%; border:1px solid #e4e9f0; border-radius:.5rem; padding:.5rem .75rem; font-size:.84rem; color:#374151; background:#f8fafd; font-family:'Plus Jakarta Sans',sans-serif; outline:none;"></div>
        </div>
      </div>

      {{-- PEKERJAAN & PENDIDIKAN --}}
      <div class="form-section" style="background:#fff; border-radius:.85rem; border:1px solid #e4e9f0; overflow:hidden; margin-bottom:1rem;">
        <div class="form-section-title" style="font-size:.72rem; font-weight:700; color:#8fa3b8; letter-spacing:.08em; padding:.75rem 1.2rem .4rem; background:#f8fafd; border-bottom:1px solid #f0f3f8;">PEKERJAAN & PENDIDIKAN</div>
        <div class="form-row-item" style="display:flex; align-items:center; padding:.85rem 1.2rem; border-bottom:1px solid #f8fafd; gap:1rem;">
          <div class="form-row-label" style="width:180px; flex-shrink:0; font-size:.84rem; font-weight:600; color:#374151;">Pekerjaan<span class="wajib" style="font-size:.68rem; color:#ea580c; font-weight:400; display:block; margin-top:.1rem;">Wajib diisi</span></div>
          <div class="form-row-input" style="flex:1;">
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
            <input type="text" name="pekerjaan_lainnya" id="inputPekerjaanLainnya" placeholder="Tulis pekerjaan kamu..." style="display:none;margin-top:.5rem; width:100%; border:1px solid #e4e9f0; border-radius:.5rem; padding:.5rem .75rem; font-size:.84rem; color:#374151; background:#f8fafd; outline:none;">
          </div>
        </div>
        <div class="form-row-item" id="rowInstansi" style="display:flex; align-items:center; padding:.85rem 1.2rem; border-bottom:1px solid #f8fafd; gap:1rem; {{ in_array(auth()->user()->pekerjaan, ['mahasiswa','pelajar']) ? '' : 'display:none;' }}">
          <div class="form-row-label" style="width:180px; flex-shrink:0; font-size:.84rem; font-weight:600; color:#374151;">Nama Instansi/Kampus/Sekolah</div>
          <div class="form-row-input" style="flex:1;">
            <select name="instansi" id="selInstansi">
              <option value="">Pilih nama instansi</option>
              <option value="ITS" {{ auth()->user()->instansi=='ITS'?'selected':'' }}>ITS Surabaya</option>
              <option value="UNAIR" {{ auth()->user()->instansi=='UNAIR'?'selected':'' }}>Universitas Airlangga (UNAIR)</option>
              <option value="UNESA" {{ auth()->user()->instansi=='UNESA'?'selected':'' }}>Universitas Negeri Surabaya (UNESA)</option>
              <option value="UB" {{ auth()->user()->instansi=='UB'?'selected':'' }}>Universitas Brawijaya (UB) Malang</option>
              <option value="UGM" {{ auth()->user()->instansi=='UGM'?'selected':'' }}>Universitas Gadjah Mada (UGM)</option>
              <option value="ITB" {{ auth()->user()->instansi=='ITB'?'selected':'' }}>Institut Teknologi Bandung (ITB)</option>
              <option value="UI" {{ auth()->user()->instansi=='UI'?'selected':'' }}>Universitas Indonesia (UI)</option>
              <option value="lainnya" {{ auth()->user()->instansi=='lainnya'?'selected':'' }}>Lainnya</option>
            </select>
            <input type="text" name="instansi_lainnya" id="inputInstansiLainnya" placeholder="Tulis nama instansi..." style="display:none;margin-top:.5rem; width:100%; border:1px solid #e4e9f0; border-radius:.5rem; padding:.5rem .75rem; font-size:.84rem; color:#374151; background:#f8fafd; outline:none;">
          </div>
        </div>
        <div class="form-row-item" style="display:flex; align-items:center; padding:.85rem 1.2rem; border-bottom:1px solid #f8fafd; gap:1rem;">
          <div class="form-row-label" style="width:180px; flex-shrink:0; font-size:.84rem; font-weight:600; color:#374151;">Pendidikan Terakhir</div>
          <div class="form-row-input" style="flex:1;">
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
        <div class="form-row-item" style="display:flex; align-items:center; padding:.85rem 1.2rem; border-bottom:1px solid #f8fafd; gap:1rem;">
          <div class="form-row-label" style="width:180px; flex-shrink:0; font-size:.84rem; font-weight:600; color:#374151;">Status</div>
          <div class="form-row-input" style="flex:1;">
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
      <div class="form-section" style="background:#fff; border-radius:.85rem; border:1px solid #e4e9f0; overflow:hidden; margin-bottom:1rem;">
        <div class="form-section-title" style="font-size:.72rem; font-weight:700; color:#8fa3b8; letter-spacing:.08em; padding:.75rem 1.2rem .4rem; background:#f8fafd; border-bottom:1px solid #f0f3f8;">LOKASI</div>
        <div class="form-row-item" style="display:flex; align-items:center; padding:.85rem 1.2rem; border-bottom:1px solid #f8fafd; gap:1rem;">
          <div class="form-row-label" style="width:180px; flex-shrink:0; font-size:.84rem; font-weight:600; color:#374151;">Kota Asal</div>
          <div class="form-row-input" style="flex:1;">
            <select name="kota" id="selKota">
              <option value="">Pilih kota asal</option>
              <option value="Surabaya" {{ auth()->user()->kota=='Surabaya'?'selected':'' }}>Surabaya</option>
              <option value="Malang" {{ auth()->user()->kota=='Malang'?'selected':'' }}>Malang</option>
              <option value="Sidoarjo" {{ auth()->user()->kota=='Sidoarjo'?'selected':'' }}>Sidoarjo</option>
              <option value="Gresik" {{ auth()->user()->kota=='Gresik'?'selected':'' }}>Gresik</option>
              <option value="Kediri" {{ auth()->user()->kota=='Kediri'?'selected':'' }}>Kediri</option>
              <option value="Jakarta Pusat" {{ auth()->user()->kota=='Jakarta Pusat'?'selected':'' }}>Jakarta Pusat</option>
              <option value="Jakarta Selatan" {{ auth()->user()->kota=='Jakarta Selatan'?'selected':'' }}>Jakarta Selatan</option>
              <option value="Bandung" {{ auth()->user()->kota=='Bandung'?'selected':'' }}>Bandung</option>
              <option value="Semarang" {{ auth()->user()->kota=='Semarang'?'selected':'' }}>Semarang</option>
              <option value="Yogyakarta" {{ auth()->user()->kota=='Yogyakarta'?'selected':'' }}>Yogyakarta</option>
              <option value="Lainnya" {{ auth()->user()->kota=='Lainnya'?'selected':'' }}>Lainnya</option>
            </select>
            <input type="text" name="kota_lainnya" id="inputKotaLainnya" placeholder="Tulis kota kamu..." style="display:none;margin-top:.5rem; width:100%; border:1px solid #e4e9f0; border-radius:.5rem; padding:.5rem .75rem; font-size:.84rem; color:#374151; background:#f8fafd; outline:none;">
          </div>
        </div>
      </div>

      <div class="d-flex gap-2 justify-content-end mt-4">
        <button type="submit" style="background:#e8401c; color:#fff; font-weight:700; border:0; border-radius:.6rem; padding:.65rem 2rem; font-size:.9rem; cursor:pointer; transition:background .2s;">Simpan Perubahan</button>
      </div>

    </form>
  </div>
</div>
