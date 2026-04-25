{{-- TAB VERIFIKASI AKUN --}}
<div class="card shadow-sm border-0">
  <div class="card-header bg-white fw-bold">
    Verifikasi Akun
  </div>

  <div class="card-body p-0">

    {{-- SUCCESS --}}
    @if(session('success'))
      <div class="alert alert-success m-3 small">
        <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
      </div>
    @endif


    {{-- ================= EMAIL & PHONE ================= --}}
    <div class="p-4 border-bottom">

      <h6 class="fw-bold mb-3">Email & Phone</h6>

      <div class="alert alert-warning small">
        <strong>Mengapa Verifikasi Penting?</strong><br>
        Verifikasi melindungi akun kamu dari akses tidak sah.
      </div>


      {{-- EMAIL --}}
      <div class="d-flex justify-content-between align-items-center py-3 border-bottom">

        <div class="d-flex align-items-center gap-3">
          <div class="bg-success-subtle text-success p-2 rounded">
            <i class="bi bi-envelope"></i>
          </div>
          <div>
            <div class="fw-semibold">Email</div>
            <small class="text-muted">{{ auth()->user()->email }}</small>
          </div>
        </div>

        <div class="d-flex align-items-center gap-2">
          @if(auth()->user()->email_verified_at)
            <span class="badge bg-success">Terverifikasi</span>
          @endif
          <button class="btn btn-sm btn-danger" onclick="toggleForm('formEmail')">Ubah</button>
        </div>

      </div>

      {{-- FORM EMAIL --}}
      <div id="formEmail" class="mt-3 d-none">
        <form method="POST" action="{{ route('user.verifikasi.email') }}">
          @csrf @method('PATCH')

          <div class="input-group">
            <input type="email" name="email" class="form-control" value="{{ auth()->user()->email }}">
            <button class="btn btn-danger">Simpan</button>
            <button type="button" class="btn btn-outline-secondary" onclick="toggleForm('formEmail')">Batal</button>
          </div>

        </form>
      </div>


      {{-- HP --}}
      <div class="d-flex justify-content-between align-items-center py-3">

        <div class="d-flex align-items-center gap-3">
          <div class="bg-primary-subtle text-primary p-2 rounded">
            <i class="bi bi-phone"></i>
          </div>
          <div>
            <div class="fw-semibold">Nomor Handphone</div>
            <small class="text-muted">{{ auth()->user()->no_hp ?? 'Belum diisi' }}</small>
          </div>
        </div>

        <div class="d-flex align-items-center gap-2">
          @if(auth()->user()->no_hp)
            <span class="badge bg-success">Terverifikasi</span>
          @endif
          <button class="btn btn-sm btn-danger" onclick="toggleForm('formHP')">
            {{ auth()->user()->no_hp ? 'Ubah' : 'Verifikasi' }}
          </button>
        </div>

      </div>


      {{-- FORM HP --}}
      <div id="formHP" class="mt-3 d-none">
        <form method="POST" action="{{ route('user.verifikasi.hp') }}">
          @csrf @method('PATCH')

          <div class="input-group">
            <span class="input-group-text">+62</span>
            <input type="text" name="no_hp" class="form-control"
              value="{{ ltrim(auth()->user()->no_hp ?? '', '+62') }}"
              placeholder="8xxxxxxxxxx">
            <button class="btn btn-danger">Simpan</button>
            <button type="button" class="btn btn-outline-secondary" onclick="toggleForm('formHP')">Batal</button>
          </div>

        </form>
      </div>

    </div>



    {{-- ================= VERIFIKASI IDENTITAS ================= --}}
    <div class="p-4">

      <h6 class="fw-bold mb-3">Verifikasi Identitas</h6>

      <div class="alert alert-success small">
        Lengkapi data agar pengajuan sewa lebih cepat.
      </div>

      <form method="POST" action="{{ route('user.verifikasi.identitas') }}" enctype="multipart/form-data">
        @csrf @method('PATCH')

        {{-- JENIS IDENTITAS --}}
        <div class="mb-3">
          <label class="form-label fw-semibold">Jenis Identitas</label>
          <input type="text" name="jenis_identitas" class="form-control"
            placeholder="Contoh: KTP, SIM, Passport"
            value="{{ auth()->user()->jenis_identitas ?? '' }}">
        </div>


        {{-- UPLOAD --}}
        <div class="mb-3">
          <label class="form-label fw-semibold">Upload Foto Identitas</label>

          <div class="row g-3">
            <div class="col-md-6">

              <div class="vf-upload-box" onclick="document.getElementById('uploadKTP').click()">

                <div id="previewKTP" class="{{ auth()->user()->foto_ktp ? '' : 'd-none' }}">
                  <img id="imgKTP"
                    src="{{ auth()->user()->foto_ktp ? asset('storage/'.auth()->user()->foto_ktp) : '' }}"
                    class="img-fluid rounded">

                  <button type="button"
                    onclick="clearVfUpload('uploadKTP','previewKTP','iconKTP');event.stopPropagation();"
                    class="vf-clear-btn">
                    <i class="bi bi-x"></i>
                  </button>
                </div>

                <div id="iconKTP" class="vf-icon-wrap {{ auth()->user()->foto_ktp ? 'd-none' : '' }}">
                  <i class="bi bi-person-vcard fs-3 text-danger"></i>
                  <span>Kartu Identitas</span>
                </div>

                <input type="file" id="uploadKTP" name="foto_ktp"
                  accept="image/*" class="d-none"
                  onchange="previewVfUpload(this,'previewKTP','imgKTP','iconKTP')">

              </div>

            </div>
          </div>

          <div id="warningUpload"
            class="text-danger small mt-2 {{ auth()->user()->foto_ktp ? 'd-none' : '' }}">
            <i class="bi bi-exclamation-circle-fill"></i>
            Kamu belum upload identitas
          </div>
        </div>


        {{-- CHECKBOX --}}
        <div class="form-check mb-3">
          <input class="form-check-input" type="checkbox" id="checkSetuju" onchange="checkVfForm()">
          <label class="form-check-label small">
            Saya setuju dengan <a href="#" class="text-danger">privacy policy</a>
          </label>
        </div>


        {{-- BUTTON --}}
        <button type="submit" id="btnSimpanVerif"
          class="btn btn-secondary fw-bold px-4" disabled>
          Simpan
        </button>

      </form>

    </div>

  </div>
</div>