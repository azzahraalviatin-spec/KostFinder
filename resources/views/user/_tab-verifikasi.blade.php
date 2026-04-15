{{-- TAB VERIFIKASI AKUN --}}
<div class="content-card">
  <div class="content-card-head">Verifikasi Akun</div>
  <div class="content-card-body" style="padding:0;">

    {{-- SUCCESS MSG --}}
    @if(session('success'))
    <div style="margin:1rem 1.2rem 0;background:#f0fdf4;border:1px solid #bbf7d0;color:#16a34a;border-radius:.65rem;padding:.65rem 1rem;font-size:.82rem;display:flex;align-items:center;gap:.5rem;">
      <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
    </div>
    @endif

    {{-- EMAIL & PHONE --}}
    <div style="padding:1.2rem;border-bottom:1px solid #f0f3f8;">
      <div style="font-weight:700;font-size:.95rem;color:#1a2332;margin-bottom:.75rem;">Email and Phone</div>

      <div style="background:#fff8f0;border:1px solid #fed7aa;border-radius:.65rem;padding:.65rem 1rem;margin-bottom:1rem;">
        <div style="font-size:.78rem;font-weight:700;color:#c2410c;margin-bottom:.2rem;">Mengapa Verifikasi Penting?</div>
        <div style="font-size:.75rem;color:#6b7280;">Verifikasi bisa mencegah akun kamu diretas oleh orang lain. Karena untuk mengakses akun tetap membutuhkan kode verifikasi yang hanya diketahui oleh Anda.</div>
      </div>

      {{-- EMAIL ROW --}}
      <div style="padding:.85rem 0;border-bottom:1px solid #f8fafd;">
        <div style="display:flex;align-items:center;justify-content:space-between;">
          <div style="display:flex;align-items:center;gap:.75rem;">
            <div style="width:38px;height:38px;background:#f0fdf4;border-radius:.6rem;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
              <i class="bi bi-envelope" style="color:#16a34a;font-size:1rem;"></i>
            </div>
            <div>
              <div style="font-size:.85rem;font-weight:600;color:#1a2332;">Email</div>
              <div style="font-size:.75rem;color:#8fa3b8;" id="emailDisplay">{{ auth()->user()->email }}</div>
            </div>
          </div>
          @if(auth()->user()->email_verified_at)
            <div style="display:flex;gap:.4rem;align-items:center;">
              <span style="background:#f0fdf4;color:#16a34a;font-size:.72rem;font-weight:600;padding:.25rem .65rem;border-radius:999px;border:1px solid #bbf7d0;"><i class="bi bi-check-circle-fill"></i> Terverifikasi</span>
              <button onclick="toggleForm('formEmail')" style="background:#e8401c;color:#fff;border:0;border-radius:.5rem;padding:.3rem .75rem;font-size:.75rem;font-weight:600;cursor:pointer;">Ubah</button>
            </div>
          @else
            <button onclick="toggleForm('formEmail')" style="background:#e8401c;color:#fff;border:0;border-radius:.5rem;padding:.3rem .75rem;font-size:.75rem;font-weight:600;cursor:pointer;">Ubah</button>
          @endif
        </div>

        {{-- FORM UBAH EMAIL --}}
        <div id="formEmail" style="display:none;margin-top:.75rem;">
          <form method="POST" action="{{ route('user.verifikasi.email') }}">
            @csrf @method('PATCH')
            <div style="display:flex;gap:.5rem;align-items:center;">
              <input type="email" name="email" value="{{ auth()->user()->email }}"
                style="flex:1;border:1px solid #e4e9f0;border-radius:.5rem;padding:.45rem .75rem;font-size:.84rem;outline:none;font-family:'Plus Jakarta Sans',sans-serif;"
                onfocus="this.style.borderColor='#e8401c'" onblur="this.style.borderColor='#e4e9f0'">
              <button type="submit" style="background:#e8401c;color:#fff;border:0;border-radius:.5rem;padding:.45rem 1rem;font-size:.8rem;font-weight:600;cursor:pointer;white-space:nowrap;">Simpan</button>
              <button type="button" onclick="toggleForm('formEmail')" style="background:#f8fafd;color:#374151;border:1px solid #e4e9f0;border-radius:.5rem;padding:.45rem .85rem;font-size:.8rem;font-weight:600;cursor:pointer;">Batal</button>
            </div>
          </form>
        </div>
      </div>

      {{-- NOMOR HP ROW --}}
      <div style="padding:.85rem 0;">
        <div style="display:flex;align-items:center;justify-content:space-between;">
          <div style="display:flex;align-items:center;gap:.75rem;">
            <div style="width:38px;height:38px;background:#eff6ff;border-radius:.6rem;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
              <i class="bi bi-phone" style="color:#3b82f6;font-size:1rem;"></i>
            </div>
            <div>
              <div style="font-size:.85rem;font-weight:600;color:#1a2332;">Nomor Handphone</div>
              <div style="font-size:.75rem;color:#8fa3b8;" id="hpDisplay">{{ auth()->user()->no_hp ?? 'Belum diisi' }}</div>
            </div>
          </div>
          @if(auth()->user()->no_hp)
            <div style="display:flex;gap:.4rem;align-items:center;">
              <span style="background:#f0fdf4;color:#16a34a;font-size:.72rem;font-weight:600;padding:.25rem .65rem;border-radius:999px;border:1px solid #bbf7d0;"><i class="bi bi-check-circle-fill"></i> Terverifikasi</span>
              <button onclick="toggleForm('formHP')" style="background:#e8401c;color:#fff;border:0;border-radius:.5rem;padding:.3rem .75rem;font-size:.75rem;font-weight:600;cursor:pointer;">Ubah</button>
            </div>
          @else
            <button onclick="toggleForm('formHP')" style="background:#e8401c;color:#fff;border:0;border-radius:.5rem;padding:.3rem .75rem;font-size:.75rem;font-weight:600;cursor:pointer;">Verifikasi</button>
          @endif
        </div>

        {{-- FORM VERIFIKASI HP --}}
        <div id="formHP" style="display:none;margin-top:.75rem;">
          <form method="POST" action="{{ route('user.verifikasi.hp') }}">
            @csrf @method('PATCH')
            <div style="display:flex;gap:.5rem;align-items:center;">
              <div style="display:flex;border:1px solid #e4e9f0;border-radius:.5rem;overflow:hidden;flex:1;">
                <span style="background:#f8fafd;padding:.45rem .65rem;font-size:.84rem;color:#6b7280;border-right:1px solid #e4e9f0;">+62</span>
               <input type="text" name="no_hp" value="{{ ltrim(auth()->user()->no_hp ?? '', '+62') }}"
                  placeholder="8xxxxxxxxxx"
                  style="flex:1;border:0;padding:.45rem .65rem;font-size:.84rem;outline:none;font-family:'Plus Jakarta Sans',sans-serif;">
              </div>
              <button type="submit" style="background:#e8401c;color:#fff;border:0;border-radius:.5rem;padding:.45rem 1rem;font-size:.8rem;font-weight:600;cursor:pointer;white-space:nowrap;">Simpan</button>
              <button type="button" onclick="toggleForm('formHP')" style="background:#f8fafd;color:#374151;border:1px solid #e4e9f0;border-radius:.5rem;padding:.45rem .85rem;font-size:.8rem;font-weight:600;cursor:pointer;">Batal</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    {{-- VERIFIKASI IDENTITAS --}}
    <div style="padding:1.2rem;">
      <div style="font-weight:700;font-size:.95rem;color:#1a2332;margin-bottom:.75rem;">Verifikasi Identitas</div>

      <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:.65rem;padding:.75rem 1rem;margin-bottom:1.2rem;">
        <div style="font-size:.8rem;color:#166534;font-weight:600;">Lengkapi datamu agar proses pengajuan sewa lebih cepat.</div>
        <div style="font-size:.75rem;color:#16a34a;margin-top:.2rem;">Kami melindungi informasi dan penggunaan data diri para pengguna kami.</div>
      </div>

      <form method="POST" action="{{ route('user.verifikasi.identitas') }}" enctype="multipart/form-data">
        @csrf @method('PATCH')

        <div style="margin-bottom:1rem;">
  <div style="font-size:.84rem;font-weight:600;color:#374151;margin-bottom:.5rem;">Jenis Identitas</div>
  <input 
    type="text" 
    name="jenis_identitas" 
    placeholder="Contoh: KTP, Tanda Pelajar, SIM, Passport..."
    value="{{ auth()->user()->jenis_identitas ?? '' }}"
    style="width:100%;border:1px solid #e4e9f0;border-radius:.5rem;padding:.45rem .75rem;font-size:.84rem;outline:none;font-family:'Plus Jakarta Sans',sans-serif;"
    onfocus="this.style.borderColor='#e8401c'"
    onblur="this.style.borderColor='#e4e9f0'"
  >
</div>

        <div style="margin-bottom:1rem;">
          <div style="font-size:.84rem;font-weight:600;color:#374151;margin-bottom:.5rem;">Upload Foto Identitas</div>
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:.75rem;">
  {{-- KTP --}}
  <div class="vf-upload-box" onclick="document.getElementById('uploadKTP').click()">
    <div id="previewKTP" style="display:{{ auth()->user()->foto_ktp ? 'block' : 'none' }};width:100%;height:100%;position:absolute;inset:0;">
      <img id="imgKTP" src="{{ auth()->user()->foto_ktp ? asset('storage/'.auth()->user()->foto_ktp) : '' }}" style="width:100%;height:100%;object-fit:cover;border-radius:.6rem;">
      <button type="button" onclick="clearVfUpload('uploadKTP','previewKTP','iconKTP');event.stopPropagation();" class="vf-clear-btn"><i class="bi bi-x"></i></button>
    </div>
    <div id="iconKTP" class="vf-icon-wrap" style="display:{{ auth()->user()->foto_ktp ? 'none' : 'flex' }}">
      <i class="bi bi-person-vcard" style="font-size:1.8rem;color:#e8401c;"></i>
      <span>Kartu Identitas</span>
    </div>
    <input type="file" id="uploadKTP" name="foto_ktp" accept="image/*" style="display:none;" onchange="previewVfUpload(this,'previewKTP','imgKTP','iconKTP')">
  </div>

 
</div>

<div id="warningUpload" style="margin-top:.6rem;font-size:.75rem;color:#dc2626;display:{{ auth()->user()->foto_ktp ? 'none' : 'flex' }};align-items:center;gap:.3rem;">
  <i class="bi bi-exclamation-circle-fill"></i> Kamu belum mengunggah foto kartu identitas
</div>

        <div style="margin-bottom:1rem;">
          <label style="display:flex;align-items:flex-start;gap:.5rem;font-size:.78rem;color:#374151;cursor:pointer;">
            <input type="checkbox" id="checkSetuju" name="setuju" style="margin-top:2px;accent-color:#e8401c;" onchange="checkVfForm()">
            Dengan melanjutkan, saya menjamin data yang diberikan adalah benar dan menyetujui <a href="#" style="color:#e8401c;">privacy policy</a>
          </label>
        </div>

        <button type="submit" id="btnSimpanVerif" disabled
          style="background:#d1d5db;color:#fff;border:0;border-radius:.6rem;padding:.6rem 2rem;font-size:.85rem;font-weight:700;cursor:not-allowed;transition:all .2s;">
          Simpan
        </button>
      </form>
    </div>

  </div>
</div>

<style>
  .vf-upload-box { border:2px dashed #e4e9f0; border-radius:.65rem; height:120px; display:flex; align-items:center; justify-content:center; cursor:pointer; transition:border-color .2s,background .2s; overflow:hidden; position:relative; }
  .vf-upload-box:hover { border-color:#e8401c; background:#fff5f2; }
  .vf-icon-wrap { display:flex; flex-direction:column; align-items:center; gap:.4rem; font-size:.75rem; color:#374151; font-weight:500; }
  .vf-clear-btn { position:absolute; top:4px; right:4px; background:rgba(0,0,0,.5); border:0; color:#fff; border-radius:50%; width:22px; height:22px; font-size:.7rem; cursor:pointer; display:flex; align-items:center; justify-content:center; }
</style>

<script>
  function toggleForm(id) {
    const el = document.getElementById(id);
    el.style.display = el.style.display === 'none' ? 'block' : 'none';
  }

  function previewVfUpload(input, previewId, imgId, iconId) {
    if (input.files && input.files[0]) {
      const reader = new FileReader();
      reader.onload = function(e) {
        document.getElementById(imgId).src = e.target.result;
        document.getElementById(previewId).style.display = 'block';
        document.getElementById(iconId).style.display = 'none';
        document.getElementById('warningUpload').style.display = 'none';
        checkVfForm();
      };
      reader.readAsDataURL(input.files[0]);
    }
  }

  function clearVfUpload(inputId, previewId, iconId) {
    document.getElementById(inputId).value = '';
    document.getElementById(previewId).style.display = 'none';
    document.getElementById(iconId).style.display = 'flex';
    document.getElementById('warningUpload').style.display = 'flex';
    checkVfForm();
  }

  function checkVfForm() {
    const ktpOk = document.getElementById('uploadKTP').files.length > 0;
    const setuju = document.getElementById('checkSetuju').checked;
    const btn = document.getElementById('btnSimpanVerif');
    if (ktpOk && setuju) {
      btn.disabled = false; btn.style.background = '#e8401c'; btn.style.cursor = 'pointer';
    } else {
      btn.disabled = true; btn.style.background = '#d1d5db'; btn.style.cursor = 'not-allowed';
    }
  }
  // Konfirmasi ganti foto kalau sudah ada
function konfirmasiGantiFoto(inputId, previewId, imgId, iconId, sudahAda) {
  if (sudahAda) {
    const overlay = document.createElement('div');
    overlay.style.cssText = 'position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:99999;display:flex;align-items:center;justify-content:center;backdrop-filter:blur(4px);';
    overlay.innerHTML = `
      <div style="background:#fff;border-radius:1rem;width:100%;max-width:360px;margin:1rem;box-shadow:0 20px 60px rgba(0,0,0,.2);overflow:hidden;">
        <div style="background:linear-gradient(135deg,#e8401c,#ff7043);padding:1.3rem 1.5rem;display:flex;align-items:center;gap:.85rem;">
          <div style="width:40px;height:40px;background:rgba(255,255,255,.2);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <i class="bi bi-arrow-repeat" style="color:#fff;font-size:1rem;"></i>
          </div>
          <div>
            <div style="font-weight:800;color:#fff;font-size:.95rem;">Ganti Foto</div>
            <div style="color:rgba(255,255,255,.75);font-size:.73rem;">Foto lama akan digantikan</div>
          </div>
        </div>
        <div style="padding:1.3rem 1.5rem;">
          <div style="background:#fff5f2;border:1px solid #ffd0c0;border-radius:.65rem;padding:.9rem 1rem;display:flex;align-items:flex-start;gap:.7rem;">
            <i class="bi bi-exclamation-triangle-fill" style="color:#e8401c;font-size:1rem;flex-shrink:0;margin-top:.1rem;"></i>
            <p style="margin:0;font-size:.83rem;color:#1e2d3d;font-weight:500;line-height:1.5;">
              Yakin ingin mengganti foto ini? Foto lama akan digantikan dengan yang baru.
            </p>
          </div>
        </div>
        <div style="padding:.9rem 1.5rem 1.3rem;display:flex;gap:.7rem;justify-content:flex-end;border-top:1px solid #f0f3f8;">
          <button id="btnBatalGantiFoto"
            style="background:#fff;border:1.5px solid #e4e9f0;color:#555;font-size:.82rem;font-weight:600;padding:.5rem 1.2rem;border-radius:.6rem;cursor:pointer;">
            <i class="bi bi-x"></i> Batal
          </button>
          <button id="btnOkGantiFoto"
            style="background:linear-gradient(135deg,#e8401c,#ff7043);border:none;color:#fff;font-size:.82rem;font-weight:700;padding:.5rem 1.3rem;border-radius:.6rem;cursor:pointer;box-shadow:0 4px 14px rgba(232,64,28,.35);">
            <i class="bi bi-check2"></i> Ya, Ganti
          </button>
        </div>
      </div>
    `;
    document.body.appendChild(overlay);

    document.getElementById('btnBatalGantiFoto').onclick = () => {
      overlay.remove();
      document.getElementById(inputId).value = '';
    };

    document.getElementById('btnOkGantiFoto').onclick = () => {
      overlay.remove();
      document.getElementById(inputId).click();
    };
  } else {
    document.getElementById(inputId).click();
  }
}
</script>