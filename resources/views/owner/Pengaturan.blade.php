<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pengaturan - KostFinder</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    :root { --sidebar-w:200px; --sidebar-col:60px; --primary:#e8401c; --dark:#1e2d3d; --bg:#f0f4f8; }
    * { margin:0; padding:0; box-sizing:border-box; }
    body { font-family:'Plus Jakarta Sans',sans-serif; background:var(--bg); display:flex; min-height:100vh; align-items:stretch; }
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
    .main { margin-left:var(--sidebar-w); flex:1; transition:margin-left .3s ease; display:flex; flex-direction:column; min-height:100vh; }
    .main.collapsed { margin-left:var(--sidebar-col); }
    .topbar { background:#fff; height:60px; padding:0 1.5rem; display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid #e4e9f0; position:sticky; top:0; z-index:100; }
    .topbar-left { display:flex; align-items:center; gap:.8rem; }
    .topbar-left h5 { font-size:.98rem; font-weight:800; color:var(--dark); margin:0; }
    .topbar-left p { font-size:.72rem; color:#8fa3b8; margin:0; }
    .topbar-right { display:flex; align-items:center; gap:.6rem; }
    .icon-btn { width:34px; height:34px; border-radius:.5rem; background:#f0f4f8; border:1px solid #dde3ed; display:flex; align-items:center; justify-content:center; color:#555; font-size:.9rem; cursor:pointer; text-decoration:none; position:relative; }
    .icon-btn:hover { background:#e4e9f0; color:#333; }
    .content { padding:1.4rem; flex:1; }
    .layout-2col { display:flex; gap:1rem; align-items:flex-start; }
    .col-kiri { flex:0 0 65%; min-width:0; }
    .col-kanan { flex:1; min-width:0; position:sticky; top:70px; }
    @media(max-width:991px){
      .layout-2col { flex-direction:column; }
      .col-kiri, .col-kanan { flex:0 0 100%; position:static; }
    }
    .form-card { background:#fff; border-radius:.85rem; border:1px solid #e4e9f0; box-shadow:0 2px 6px rgba(0,0,0,.04); padding:1.5rem; margin-bottom:1rem; }
    .form-card h6 { font-weight:700; color:var(--dark); font-size:.9rem; margin-bottom:1rem; padding-bottom:.6rem; border-bottom:1px solid #f0f3f8; display:flex; align-items:center; gap:.4rem; }
    .form-label { font-size:.8rem; font-weight:600; color:#444; margin-bottom:.3rem; }
    .form-control { font-size:.85rem; border-color:#e4e9f0; border-radius:.55rem; padding:.5rem .8rem; }
    .form-control:focus { border-color:var(--primary); box-shadow:0 0 0 3px rgba(232,64,28,.1); }
    .btn-save { background:var(--primary); color:#fff; font-weight:700; border:0; border-radius:.55rem; padding:.5rem 1.4rem; font-size:.85rem; cursor:pointer; }
    .btn-save:hover { background:#cb3518; }
    .avatar-wrap { position:relative; display:inline-block; }
    .avatar-big { width:90px; height:90px; border-radius:50%; background:var(--primary); color:#fff; font-size:2rem; font-weight:800; display:flex; align-items:center; justify-content:center; border:3px solid #fff; box-shadow:0 2px 10px rgba(0,0,0,.1); }
    .avatar-big img { width:90px; height:90px; border-radius:50%; object-fit:cover; }
    .avatar-edit { position:absolute; bottom:0; right:0; width:26px; height:26px; background:var(--primary); border-radius:50%; display:flex; align-items:center; justify-content:center; cursor:pointer; border:2px solid #fff; }
    .avatar-edit i { color:#fff; font-size:.7rem; }
    .notif-item { display:flex; justify-content:space-between; align-items:center; padding:.75rem 0; border-bottom:1px solid #f0f3f8; }
    .notif-item:last-child { border:0; padding-bottom:0; }
    .notif-label { font-size:.83rem; font-weight:600; color:var(--dark); }
    .notif-sub { font-size:.73rem; color:#8fa3b8; }
    .form-switch .form-check-input { width:2.5em; height:1.3em; cursor:pointer; }
    .form-switch .form-check-input:checked { background-color:var(--primary); border-color:var(--primary); }
    .owner-footer { background:#fff; border-top:1px solid #e4e9f0; padding:.8rem 1.5rem; text-align:center; color:#8fa3b8; font-size:.72rem; margin-top:auto; }
    .danger-zone { border:1px solid #fee2e2; border-radius:.85rem; padding:1.2rem 1.5rem; background:#fff; margin-top:1rem; }
    .upload-box { border:2px dashed #e4e9f0; border-radius:.75rem; padding:1.5rem; text-align:center; cursor:pointer; transition:all .2s; background:#f8fafd; display:block; }
    .upload-box:hover { border-color:var(--primary); background:#fff5f2; }
    .upload-box i { font-size:1.8rem; color:#c0ccd8; margin-bottom:.4rem; display:block; }
    .preview-img { width:100%; height:140px; object-fit:cover; border-radius:.55rem; margin-top:.5rem; }

    /* ===== VERIFIKASI STYLES BARU ===== */
    .verif-banner { border-radius:.85rem; padding:1rem 1.2rem; margin-bottom:1.2rem; display:flex; align-items:flex-start; gap:.9rem; }
    .verif-banner .icon-wrap { width:40px; height:40px; border-radius:50%; display:flex; align-items:center; justify-content:center; flex-shrink:0; font-size:1.1rem; }
    .verif-banner .vb-title { font-weight:700; font-size:.87rem; margin-bottom:.2rem; }
    .verif-banner .vb-sub { font-size:.76rem; line-height:1.55; }
    .verif-banner.done  { background:#f0fdf4; border:1.5px solid #86efac; }
    .verif-banner.done .icon-wrap { background:#dcfce7; }
    .verif-banner.done .vb-title { color:#15803d; }
    .verif-banner.done .vb-sub { color:#4b7a5a; }
    .verif-banner.pending { background:#fffbeb; border:1.5px solid #fde68a; }
    .verif-banner.pending .icon-wrap { background:#fef9c3; }
    .verif-banner.pending .vb-title { color:#b45309; }
    .verif-banner.pending .vb-sub { color:#78532a; }
    .verif-banner.ditolak { background:#fef2f2; border:1.5px solid #fca5a5; }
    .verif-banner.ditolak .icon-wrap { background:#fee2e2; }
    .verif-banner.ditolak .vb-title { color:#b91c1c; }
    .verif-banner.ditolak .vb-sub { color:#7f1d1d; }
    .verif-banner.belum { background:#fff5f2; border:1.5px solid #ffd0c0; }
    .verif-banner.belum .icon-wrap { background:#ffe4dc; }
    .verif-banner.belum .vb-title { color:#c2410c; }
    .verif-banner.belum .vb-sub { color:#7c2d12; }

    /* catatan admin */
    .catatan-admin { background:#fef2f2; border:1.5px solid #fca5a5; border-radius:.75rem; padding:1rem 1.1rem; margin-bottom:1.2rem; }
    .catatan-admin .ca-header { display:flex; align-items:center; gap:.5rem; margin-bottom:.4rem; }
    .catatan-admin .ca-header i { color:#dc2626; font-size:.95rem; }
    .catatan-admin .ca-header span { font-size:.82rem; font-weight:700; color:#b91c1c; }
    .catatan-admin .ca-body { font-size:.81rem; color:#7f1d1d; line-height:1.6; padding-left:1.5rem; }

    /* doc preview card */
    .doc-grid { display:grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap:.75rem; margin-bottom:1rem; }
    .doc-card { border:1px solid #e4e9f0; border-radius:.7rem; overflow:hidden; background:#f8fafd; }
    .doc-card .doc-thumb { width:100%; height:110px; object-fit:cover; display:block; cursor:pointer; transition:opacity .2s; }
    .doc-card .doc-thumb:hover { opacity:.85; }
    .doc-card .doc-label { font-size:.72rem; font-weight:600; color:#555; padding:.45rem .7rem; border-top:1px solid #f0f3f8; display:flex; align-items:center; gap:.35rem; }
    .doc-card .doc-label i { color:#8fa3b8; font-size:.8rem; }
    .doc-card.doc-file { display:flex; align-items:center; justify-content:center; flex-direction:column; gap:.4rem; padding:1rem; cursor:pointer; text-decoration:none; }
    .doc-card.doc-file i { font-size:2rem; color:#e8401c; }
    .doc-card.doc-file span { font-size:.73rem; font-weight:600; color:#555; text-align:center; }

    /* step indicator */
    .verif-steps { display:flex; gap:0; margin-bottom:1.3rem; }
    .step { flex:1; text-align:center; position:relative; }
    .step::after { content:''; position:absolute; top:14px; left:50%; width:100%; height:2px; background:#e4e9f0; z-index:0; }
    .step:last-child::after { display:none; }
    .step-dot { width:28px; height:28px; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto .35rem; position:relative; z-index:1; font-size:.72rem; font-weight:700; border:2px solid #e4e9f0; background:#fff; color:#94a3b8; }
    .step.active .step-dot { background:var(--primary); border-color:var(--primary); color:#fff; }
    .step.done .step-dot { background:#16a34a; border-color:#16a34a; color:#fff; }
    .step.done::after { background:#16a34a; }
    .step-label { font-size:.68rem; font-weight:600; color:#94a3b8; }
    .step.active .step-label { color:var(--primary); }
    .step.done .step-label { color:#16a34a; }

    /* lightbox */
    #lightbox { display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,.85); z-index:99999; align-items:center; justify-content:center; }
    #lightbox.show { display:flex; }
    #lightbox img { max-width:90vw; max-height:85vh; border-radius:.75rem; box-shadow:0 20px 60px rgba(0,0,0,.5); }
    #lightbox .lb-close { position:absolute; top:1rem; right:1.2rem; color:#fff; font-size:1.8rem; cursor:pointer; line-height:1; }
  </style>
</head>
<body>

  @include('owner._sidebar')

  <div class="main" id="mainContent">
    @include('owner._navbar')

    <div class="content">

      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3" style="font-size:.83rem;border-radius:.7rem;">
          <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      @endif
      @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-3" style="font-size:.83rem;border-radius:.7rem;">
          <i class="bi bi-exclamation-circle me-1"></i> {{ session('error') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      @endif

      <div class="layout-2col">

        {{-- ==================== KOLOM KIRI ==================== --}}
        <div class="col-kiri">

          {{-- PROFIL --}}
          <div class="form-card">
            <h6><i class="bi bi-person-circle" style="color:var(--primary)"></i> Profil Saya</h6>
            <div class="d-flex align-items-center gap-3 mb-4">
              <div class="avatar-wrap">
                @if(auth()->user()->foto_profil)
                  <div class="avatar-big"><img src="{{ asset('storage/'.auth()->user()->foto_profil) }}" alt="Foto Profil"></div>
                @else
                  <div class="avatar-big">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                @endif
                <label for="fotoInput" class="avatar-edit" title="Ganti foto"><i class="bi bi-camera"></i></label>
              </div>
              <div>
                <div style="font-weight:700;font-size:1rem;color:var(--dark);">{{ auth()->user()->name }}</div>
                <div style="font-size:.8rem;color:#8fa3b8;">{{ auth()->user()->email }}</div>
                <div style="font-size:.75rem;font-weight:600;margin-top:.3rem;">
                  @php $sv = auth()->user()->status_verifikasi_identitas; @endphp
                  @if($sv === 'disetujui')
                    <span style="color:#16a34a;display:inline-flex;align-items:center;gap:.3rem;">
                      <i class="bi bi-patch-check-fill"></i> Identitas Terverifikasi
                    </span>
                  @elseif($sv === 'pending')
                    <span style="color:#b45309;display:inline-flex;align-items:center;gap:.3rem;">
                      <i class="bi bi-hourglass-split"></i> Menunggu Verifikasi Admin
                    </span>
                  @elseif($sv === 'ditolak')
                    <span style="color:#dc2626;display:inline-flex;align-items:center;gap:.3rem;">
                      <i class="bi bi-x-circle-fill"></i> Verifikasi Ditolak — Upload Ulang
                    </span>
                  @else
                    <span style="color:#e8401c;display:inline-flex;align-items:center;gap:.3rem;">
                      <i class="bi bi-exclamation-triangle-fill"></i> Identitas Belum Diverifikasi
                    </span>
                  @endif
                </div>
              </div>
            </div>
            <form action="{{ route('owner.pengaturan.update') }}" method="POST" enctype="multipart/form-data">
              @csrf @method('PATCH')
              <input type="file" name="foto_profil" id="fotoInput" class="d-none" accept="image/*" onchange="this.form.submit()">
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label">Nama Lengkap</label>
                  <input type="text" name="name" class="form-control" value="{{ old('name', auth()->user()->name) }}" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Email</label>
                  <input type="email" name="email" class="form-control" value="{{ old('email', auth()->user()->email) }}" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label">No. Telepon</label>
                  <input type="text" name="no_hp" class="form-control" placeholder="08xxxxxxxxxx" value="{{ old('no_hp', auth()->user()->no_hp ?? '') }}">
                </div>
                <div class="col-md-6">
                  <label class="form-label">Kota Domisili</label>
                  <input type="text" name="kota" class="form-control" placeholder="Surabaya" value="{{ old('kota', auth()->user()->kota ?? '') }}">
                </div>
              </div>
              <div class="mt-3">
                <button type="submit" class="btn-save"><i class="bi bi-check-lg me-1"></i> Simpan Profil</button>
              </div>
            </form>
          </div>

          {{-- ===== VERIFIKASI IDENTITAS ===== --}}
          <div class="form-card">
            <h6><i class="bi bi-shield-check" style="color:var(--primary)"></i> Verifikasi Pemilik Kost</h6>

            {{-- Info box --}}
            <div class="p-3 rounded-3 mb-3" style="background:#f0f9ff;border:1px solid #bae6fd;">
              <div style="font-size:.8rem;font-weight:700;color:#0369a1;margin-bottom:.4rem;display:flex;align-items:center;gap:.4rem;">
                <i class="bi bi-info-circle-fill"></i> Mengapa Verifikasi Diperlukan?
              </div>
              <div style="font-size:.76rem;color:#0c4a6e;line-height:1.6;">
                Verifikasi memastikan kamu adalah pemilik kost yang sah. Kost hanya akan tampil ke pencari setelah identitas & kepemilikan disetujui admin.
              </div>
            </div>

            @php $sv = auth()->user()->status_verifikasi_identitas; @endphp

            {{-- ======= STATUS: DISETUJUI ======= --}}
            @if($sv === 'disetujui')

              {{-- Banner sukses --}}
              <div class="verif-banner done">
                <div class="icon-wrap"><i class="bi bi-patch-check-fill" style="color:#16a34a;font-size:1.2rem;"></i></div>
                <div>
                  <div class="vb-title">Verifikasi Selesai!</div>
                  <div class="vb-sub">Semua dokumen kamu sudah disetujui oleh Admin KostFinder. Kost kamu sudah bisa tampil ke calon penyewa.</div>
                </div>
              </div>

              {{-- Step indicator --}}
              <div class="verif-steps">
                <div class="step done">
                  <div class="step-dot"><i class="bi bi-check"></i></div>
                  <div class="step-label">Upload Dokumen</div>
                </div>
                <div class="step done">
                  <div class="step-dot"><i class="bi bi-check"></i></div>
                  <div class="step-label">Review Admin</div>
                </div>
                <div class="step done">
                  <div class="step-dot"><i class="bi bi-check"></i></div>
                  <div class="step-label">Disetujui</div>
                </div>
              </div>

              {{-- Dokumen yang sudah diupload --}}
              <div style="font-size:.8rem;font-weight:700;color:#555;margin-bottom:.6rem;">📁 Dokumen Tersimpan</div>
              <div class="doc-grid">
                @if(auth()->user()->foto_ktp)
                <div class="doc-card">
                  <img src="{{ asset('storage/'.auth()->user()->foto_ktp) }}" class="doc-thumb" alt="KTP" onclick="bukaLightbox(this.src)">
                  <div class="doc-label"><i class="bi bi-card-text"></i> Foto KTP</div>
                </div>
                @endif
                @if(auth()->user()->foto_selfie)
                <div class="doc-card">
                  <img src="{{ asset('storage/'.auth()->user()->foto_selfie) }}" class="doc-thumb" alt="Selfie" onclick="bukaLightbox(this.src)">
                  <div class="doc-label"><i class="bi bi-camera"></i> Selfie + KTP</div>
                </div>
                @endif
                @if(auth()->user()->foto_kepemilikan)
                  @php
                    $ext = pathinfo(auth()->user()->foto_kepemilikan, PATHINFO_EXTENSION);
                    $isPdf = strtolower($ext) === 'pdf';
                  @endphp
                  @if($isPdf)
                    <a href="{{ asset('storage/'.auth()->user()->foto_kepemilikan) }}" target="_blank" class="doc-card doc-file">
                      <i class="bi bi-file-earmark-pdf-fill"></i>
                      <span>Bukti Kepemilikan<br>(PDF)</span>
                    </a>
                  @else
                    <div class="doc-card">
                      <img src="{{ asset('storage/'.auth()->user()->foto_kepemilikan) }}" class="doc-thumb" alt="Kepemilikan" onclick="bukaLightbox(this.src)">
                      <div class="doc-label"><i class="bi bi-house-check"></i> Bukti Kepemilikan</div>
                    </div>
                  @endif
                @endif
              </div>

              {{-- Link update dokumen --}}
              <div style="font-size:.75rem;color:#888;margin-top:.5rem;">
                Ingin update dokumen?
                <a href="#" onclick="document.getElementById('formVerifUpdate').classList.toggle('d-none');return false;"
                  style="color:var(--primary);font-weight:600;">Klik di sini</a>
              </div>
              <div id="formVerifUpdate" class="d-none mt-3">
                <div style="background:#fffbeb;border:1px solid #fde68a;border-radius:.65rem;padding:.8rem 1rem;font-size:.76rem;color:#78532a;margin-bottom:1rem;">
                  <i class="bi bi-exclamation-triangle me-1"></i>
                  Update dokumen akan mereset status verifikasi ke <strong>Pending</strong> dan perlu disetujui ulang oleh admin.
                </div>
                @include('owner._form_verifikasi', ['formId' => 'formUpdateDokumen'])
              </div>

            {{-- ======= STATUS: PENDING ======= --}}
            @elseif($sv === 'pending')

              <div class="verif-banner pending">
                <div class="icon-wrap"><i class="bi bi-hourglass-split" style="color:#d97706;font-size:1.1rem;"></i></div>
                <div>
                  <div class="vb-title">Sedang Direview Admin</div>
                  <div class="vb-sub">Dokumen kamu sudah kami terima dan sedang dalam proses review. Estimasi waktu: <strong>1×24 jam</strong>. Kamu akan mendapat notifikasi setelah selesai.</div>
                </div>
              </div>

              {{-- Step indicator --}}
              <div class="verif-steps">
                <div class="step done">
                  <div class="step-dot"><i class="bi bi-check"></i></div>
                  <div class="step-label">Upload Dokumen</div>
                </div>
                <div class="step active">
                  <div class="step-dot">2</div>
                  <div class="step-label">Review Admin</div>
                </div>
                <div class="step">
                  <div class="step-dot">3</div>
                  <div class="step-label">Disetujui</div>
                </div>
              </div>

              {{-- Preview dokumen yang sudah diupload --}}
              @if(auth()->user()->foto_ktp || auth()->user()->foto_selfie || auth()->user()->foto_kepemilikan)
              <div style="font-size:.8rem;font-weight:700;color:#555;margin-bottom:.6rem;">📁 Dokumen yang Dikirim</div>
              <div class="doc-grid">
                @if(auth()->user()->foto_ktp)
                <div class="doc-card">
                  <img src="{{ asset('storage/'.auth()->user()->foto_ktp) }}" class="doc-thumb" alt="KTP" onclick="bukaLightbox(this.src)">
                  <div class="doc-label"><i class="bi bi-card-text"></i> Foto KTP</div>
                </div>
                @endif
                @if(auth()->user()->foto_selfie)
                <div class="doc-card">
                  <img src="{{ asset('storage/'.auth()->user()->foto_selfie) }}" class="doc-thumb" alt="Selfie" onclick="bukaLightbox(this.src)">
                  <div class="doc-label"><i class="bi bi-camera"></i> Selfie + KTP</div>
                </div>
                @endif
                @if(auth()->user()->foto_kepemilikan)
                  @php $ext2 = pathinfo(auth()->user()->foto_kepemilikan, PATHINFO_EXTENSION); @endphp
                  @if(strtolower($ext2) === 'pdf')
                    <a href="{{ asset('storage/'.auth()->user()->foto_kepemilikan) }}" target="_blank" class="doc-card doc-file">
                      <i class="bi bi-file-earmark-pdf-fill"></i>
                      <span>Bukti Kepemilikan<br>(PDF)</span>
                    </a>
                  @else
                    <div class="doc-card">
                      <img src="{{ asset('storage/'.auth()->user()->foto_kepemilikan) }}" class="doc-thumb" alt="Kepemilikan" onclick="bukaLightbox(this.src)">
                      <div class="doc-label"><i class="bi bi-house-check"></i> Bukti Kepemilikan</div>
                    </div>
                  @endif
                @endif
              </div>
              @endif

            {{-- ======= STATUS: DITOLAK ======= --}}
            @elseif($sv === 'ditolak')

              <div class="verif-banner ditolak">
                <div class="icon-wrap"><i class="bi bi-x-circle-fill" style="color:#dc2626;font-size:1.2rem;"></i></div>
                <div>
                  <div class="vb-title">Verifikasi Ditolak</div>
                  <div class="vb-sub">Maaf, dokumen kamu tidak memenuhi syarat. Silakan baca catatan admin di bawah dan upload ulang dokumen yang benar.</div>
                </div>
              </div>

              {{-- Catatan Admin --}}
              @if(auth()->user()->catatan_verifikasi)
              <div class="catatan-admin">
                <div class="ca-header">
                  <i class="bi bi-chat-square-text-fill"></i>
                  <span>Catatan dari Admin KostFinder</span>
                </div>
                <div class="ca-body">{{ auth()->user()->catatan_verifikasi }}</div>
              </div>
              @endif

              {{-- Step indicator --}}
              <div class="verif-steps">
                <div class="step done">
                  <div class="step-dot"><i class="bi bi-check"></i></div>
                  <div class="step-label">Upload Dokumen</div>
                </div>
                <div class="step" style="--dot-bg:#dc2626;">
                  <div class="step-dot" style="background:#fee2e2;border-color:#fca5a5;color:#dc2626;"><i class="bi bi-x"></i></div>
                  <div class="step-label" style="color:#dc2626;">Ditolak</div>
                </div>
                <div class="step">
                  <div class="step-dot">3</div>
                  <div class="step-label">Disetujui</div>
                </div>
              </div>

              <div style="font-size:.82rem;font-weight:700;color:#444;margin-bottom:.8rem;">
                <i class="bi bi-arrow-repeat me-1" style="color:var(--primary);"></i> Upload Ulang Dokumen
              </div>
              @include('owner._form_verifikasi', ['formId' => 'formVerifDitolak'])

            {{-- ======= STATUS: BELUM ======= --}}
            @else

              <div class="verif-banner belum">
                <div class="icon-wrap"><i class="bi bi-exclamation-triangle-fill" style="color:#c2410c;font-size:1.1rem;"></i></div>
                <div>
                  <div class="vb-title">Identitas Belum Diverifikasi</div>
                  <div class="vb-sub">Upload identitas kamu sekarang agar kost dapat ditampilkan kepada calon penyewa.</div>
                </div>
              </div>

              {{-- Step indicator --}}
              <div class="verif-steps">
                <div class="step active">
                  <div class="step-dot">1</div>
                  <div class="step-label">Upload Dokumen</div>
                </div>
                <div class="step">
                  <div class="step-dot">2</div>
                  <div class="step-label">Review Admin</div>
                </div>
                <div class="step">
                  <div class="step-dot">3</div>
                  <div class="step-label">Disetujui</div>
                </div>
              </div>

              @include('owner._form_verifikasi', ['formId' => 'formVerifBaru'])

            @endif
          </div>

{{-- ALAMAT PROPERTI --}}
<div class="form-card">
  <h6><i class="bi bi-geo-alt-fill" style="color:var(--primary)"></i> Alamat Properti</h6>
  <form action="{{ route('owner.pengaturan.update') }}" method="POST">
    @csrf @method('PATCH')
    <div class="row g-3">
      <div class="col-12">
        <label class="form-label">Alamat Lengkap</label>
        <input type="text" name="alamat" class="form-control" placeholder="Nama jalan, nomor, RT/RW..." value="{{ old('alamat', auth()->user()->alamat ?? '') }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">Kota / Kabupaten</label>
        <select name="kota_properti" class="form-select form-control" style="background-image: url('data:image/svg+xml,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 16 16%27%3e%3cpath fill=%27none%27 stroke=%27%23343a40%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27 stroke-width=%272%27 d=%27m2 5 6 6 6-6%27/%3e%3c/svg%3e');">
          <option value="">-- Pilih Kota --</option>
          @php
            $currentKota = old('kota_properti', auth()->user()->kota_properti ?? auth()->user()->kota ?? '');
          @endphp
          @foreach(['Surabaya','Malang','Sidoarjo','Gresik','Mojokerto','Kediri','Blitar','Madiun','Pasuruan','Probolinggo','Batu','Jember','Banyuwangi','Lumajang','Jombang','Nganjuk','Tuban','Lamongan','Bojonegoro','Pamekasan','Sampang','Sumenep','Bangkalan','Ponorogo','Magetan','Ngawi','Trenggalek','Tulungagung','Pacitan','Situbondo','Bondowoso'] as $k)
          <option value="{{ $k }}" {{ $currentKota === $k ? 'selected' : '' }}>{{ $k }}</option>
          @endforeach
        </select>
        <div style="font-size:.68rem;color:#8fa3b8;margin-top:.2rem;">*Otomatis terisi sesuai data pendaftaran / profil.</div>
      </div>
      <div class="col-md-6">
        <label class="form-label">Provinsi</label>
        <input type="text" name="provinsi" class="form-control" value="{{ old('provinsi', auth()->user()->provinsi ?? 'Jawa Timur') }}">
      </div>
      <div class="col-md-4">
        <label class="form-label">Kecamatan</label>
        <input type="text" name="kecamatan" class="form-control" placeholder="Nama kecamatan" value="{{ old('kecamatan', auth()->user()->kecamatan ?? '') }}">
      </div>
      <div class="col-md-4">
        <label class="form-label">Kelurahan / Desa</label>
        <input type="text" name="kelurahan" class="form-control" placeholder="Nama kelurahan" value="{{ old('kelurahan', auth()->user()->kelurahan ?? '') }}">
      </div>
      <div class="col-md-4">
        <label class="form-label">Kode Pos</label>
        <input type="text" name="kode_pos" class="form-control" placeholder="Contoh: 61234" value="{{ old('kode_pos', auth()->user()->kode_pos ?? '') }}">
      </div>

    </div>
    <div class="mt-3">
      <button type="submit" class="btn-save"><i class="bi bi-check-lg me-1"></i> Simpan Alamat</button>
    </div>
  </form>
</div>

{{-- REKENING BANK --}}
<div class="form-card">
  <h6><i class="bi bi-bank" style="color:var(--primary)"></i> Daftar Rekening Bank (Maks. 5)</h6>
  
  <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:.7rem;padding:.9rem;margin-bottom:1.2rem;">
    <div style="font-size:.8rem;font-weight:700;color:#15803d;margin-bottom:.3rem;display:flex;align-items:center;gap:.4rem;">
      <i class="bi bi-info-circle-fill"></i> Info Pencairan Dana
    </div>
    <div style="font-size:.76rem;color:#166534;line-height:1.55;">
      Kamu bisa mendaftarkan hingga 5 rekening berbeda. Admin akan mengirimkan hasil sewa ke salah satu rekening yang kamu pilih saat mengajukan penarikan dana.
    </div>
  </div>

  @if($banks->count() > 0)
  <div class="table-responsive mb-4">
    <table class="table table-sm" style="font-size:.85rem;">
      <thead class="table-light">
        <tr>
          <th>Bank</th>
          <th>Nomor Rekening</th>
          <th>Atas Nama</th>
          <th class="text-center">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($banks as $b)
        <tr>
          <td class="align-middle">
            <span class="fw-bold">{{ $b->nama_bank }}</span>
            @if($b->is_primary) <span class="badge bg-success" style="font-size:.65rem;">Utama</span> @endif
          </td>
          <td class="align-middle">{{ $b->nomor_rekening }}</td>
          <td class="align-middle">{{ $b->nama_pemilik }}</td>
          <td class="text-center">
            <form action="{{ route('owner.pengaturan.bank.delete', $b->id) }}" method="POST" onsubmit="return confirm('Hapus rekening ini?')">
              @csrf @method('DELETE')
              <button type="submit" class="btn btn-sm btn-outline-danger" style="border:none;">
                <i class="bi bi-trash"></i>
              </button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  @else
  <div class="text-center py-4" style="background:#f8fafc; border-radius:.8rem; border:1px dashed #cbd5e1; margin-bottom:1.5rem;">
    <i class="bi bi-credit-card-2-front" style="font-size:2rem; color:#94a3b8;"></i>
    <p class="mt-2 mb-0" style="font-size:.8rem; color:#64748b;">Belum ada rekening yang didaftarkan.</p>
  </div>
  @endif

  @if($banks->count() < 5)
  <div style="background:#f8fafc; padding:1.2rem; border-radius:.8rem; border:1px solid #e2e8f0;">
    <h7 class="fw-bold d-block mb-3" style="font-size:.85rem;">+ Tambah Rekening Baru</h7>
    <form action="{{ route('owner.pengaturan.bank.store') }}" method="POST">
      @csrf
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Nama Bank / E-Wallet</label>
          <select name="nama_bank" class="form-select form-control" required>
            <option value="">-- Pilih Bank --</option>
            @foreach([
              'Bank BCA', 'Bank Mandiri', 'Bank BRI', 'Bank BNI', 'Bank Syariah Indonesia (BSI)',
              'Bank BTN', 'Bank CIMB Niaga', 'Bank Permata', 'Bank Danamon', 'Bank Maybank',
              'Bank Mega', 'Bank OCBC NISP', 'Bank Panin', 'Bank Bukopin', 'Bank Jatim',
              'Bank Jateng', 'Bank Jabar Banten (BJB)', 'Bank DKI', 'Bank Sumut', 'Bank Nagari',
              'Bank Riau Kepri', 'Bank Sumsel Babel', 'Bank Lampung', 'Bank Kalsel', 'Bank Kalbar',
              'Bank Kaltimtara', 'Bank Kalteng', 'Bank Sulselbar', 'Bank SulutGo', 'Bank NTB Syariah',
              'Bank NTT', 'Bank Maluku Malut', 'Bank Papua', 'Bank Bengkulu', 'Bank Sulteng',
              'Bank Sultra', 'Bank BTPN', 'Bank Jenius', 'Bank Neo Commerce', 'Bank Seabank',
              'Bank Aladin', 'Bank Jago', 'DANA', 'OVO', 'GoPay', 'LinkAja', 'ShopeePay'
            ] as $b)
            <option value="{{ $b }}">{{ $b }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label">Nomor Rekening / HP</label>
          <input type="text" name="nomor_rekening" class="form-control" placeholder="Contoh: 1234567890" required>
        </div>
        <div class="col-12">
          <label class="form-label">Nama Pemilik Rekening</label>
          <input type="text" name="nama_pemilik" class="form-control" placeholder="Sesuai buku tabungan" required>
        </div>
      </div>
      <div class="mt-3">
        <button type="submit" class="btn-save" style="background:var(--dark);"><i class="bi bi-plus-lg me-1"></i> Tambahkan Rekening</button>
      </div>
    </form>
  </div>
  @else
  <div class="alert alert-warning" style="font-size:.8rem; border-radius:.7rem;">
    <i class="bi bi-exclamation-triangle-fill me-1"></i> Kamu sudah mencapai batas maksimal 5 rekening. Hapus salah satu jika ingin menambah yang baru.
  </div>
  @endif
</div>

          {{-- GANTI PASSWORD --}}
          <div class="form-card">
            <h6><i class="bi bi-lock" style="color:var(--primary)"></i> Ganti Password</h6>
            <form action="{{ route('owner.pengaturan.password') }}" method="POST">
              @csrf @method('PATCH')
              <div class="row g-3">
                <div class="col-12">
                  <label class="form-label">Password Lama</label>
                  <div class="input-group">
                    <input type="password" name="current_password" class="form-control" placeholder="Masukkan password lama" id="pwLama">
                    <button type="button" class="btn btn-outline-secondary" onclick="togglePw('pwLama')"><i class="bi bi-eye"></i></button>
                  </div>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Password Baru</label>
                  <div class="input-group">
                    <input type="password" name="password" class="form-control" placeholder="Min. 8 karakter" id="pwBaru">
                    <button type="button" class="btn btn-outline-secondary" onclick="togglePw('pwBaru')"><i class="bi bi-eye"></i></button>
                  </div>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Konfirmasi Password Baru</label>
                  <div class="input-group">
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password baru" id="pwKonfirm">
                    <button type="button" class="btn btn-outline-secondary" onclick="togglePw('pwKonfirm')"><i class="bi bi-eye"></i></button>
                  </div>
                </div>
              </div>
              <div class="mt-3">
                <button type="submit" class="btn-save"><i class="bi bi-lock me-1"></i> Update Password</button>
              </div>
            </form>
          </div>

        </div>
        {{-- END KOLOM KIRI --}}

        {{-- ==================== KOLOM KANAN ==================== --}}
        <div class="col-kanan">

          <div class="form-card">
            <h6><i class="bi bi-patch-check" style="color:var(--primary)"></i> Status Akun</h6>
            <div class="d-flex flex-column gap-2">
              <div class="d-flex justify-content-between align-items-center p-2 rounded-2" style="background:#f8fafd;">
                <span style="font-size:.8rem;color:#555;display:flex;align-items:center;gap:.4rem;"><i class="bi bi-envelope-fill" style="color:#8fa3b8;"></i> Email</span>
                <span style="font-size:.75rem;font-weight:700;color:#16a34a;">✅ Terdaftar</span>
              </div>
              <div class="d-flex justify-content-between align-items-center p-2 rounded-2" style="background:#f8fafd;">
                <span style="font-size:.8rem;color:#555;display:flex;align-items:center;gap:.4rem;"><i class="bi bi-card-text" style="color:#8fa3b8;"></i> Identitas</span>
                @php $sv = auth()->user()->status_verifikasi_identitas; @endphp
                @if($sv === 'disetujui')
                  <span style="font-size:.75rem;font-weight:700;color:#16a34a;">✅ Terverifikasi</span>
                @elseif($sv === 'pending')
                  <span style="font-size:.75rem;font-weight:700;color:#b45309;">⏳ Menunggu</span>
                @elseif($sv === 'ditolak')
                  <span style="font-size:.75rem;font-weight:700;color:#dc2626;">❌ Ditolak</span>
                @else
                  <span style="font-size:.75rem;font-weight:700;color:#dc2626;">❌ Belum</span>
                @endif
              </div>
              <div class="d-flex justify-content-between align-items-center p-2 rounded-2" style="background:#f8fafd;">
                <span style="font-size:.8rem;color:#555;display:flex;align-items:center;gap:.4rem;"><i class="bi bi-house-check" style="color:#8fa3b8;"></i> Kepemilikan</span>
                @if(auth()->user()->foto_kepemilikan && $sv === 'disetujui')
                  <span style="font-size:.75rem;font-weight:700;color:#16a34a;">✅ Terverifikasi</span>
                @elseif(auth()->user()->foto_kepemilikan && $sv === 'pending')
                  <span style="font-size:.75rem;font-weight:700;color:#b45309;">⏳ Menunggu</span>
                @elseif(!auth()->user()->foto_kepemilikan)
                  <span style="font-size:.75rem;font-weight:700;color:#dc2626;">❌ Belum Upload</span>
                @else
                  <span style="font-size:.75rem;font-weight:700;color:#dc2626;">❌ Ditolak</span>
                @endif
              </div>
              <div class="d-flex justify-content-between align-items-center p-2 rounded-2" style="background:#f8fafd;">
                <span style="font-size:.8rem;color:#555;display:flex;align-items:center;gap:.4rem;"><i class="bi bi-house-fill" style="color:#8fa3b8;"></i> Kost Aktif</span>
                <span style="font-size:.75rem;font-weight:700;color:#1d4ed8;">
                  {{ \App\Models\Kost::where('owner_id', auth()->id())->where('status','aktif')->count() }} kost
                </span>
              </div>
            </div>
          </div>

          <div class="form-card">
            <h6><i class="bi bi-bell" style="color:var(--primary)"></i> Notifikasi</h6>
            <form action="{{ route('owner.pengaturan.notifikasi') }}" method="POST">
              @csrf @method('PATCH')
              <div class="notif-item">
                <div>
                  <div class="notif-label">Booking Masuk</div>
                  <div class="notif-sub">Notifikasi saat ada penyewa baru booking</div>
                </div>
                <div class="form-check form-switch mb-0">
                  <input class="form-check-input" type="checkbox" name="notif_booking" value="1" {{ auth()->user()->notif_booking ? 'checked' : '' }} onchange="this.form.submit()">
                </div>
              </div>
              <div class="notif-item">
                <div>
                  <div class="notif-label">Booking Dibatalkan</div>
                  <div class="notif-sub">Notifikasi saat penyewa membatalkan booking</div>
                </div>
                <div class="form-check form-switch mb-0">
                  <input class="form-check-input" type="checkbox" name="notif_cancel" value="1" {{ auth()->user()->notif_cancel ? 'checked' : '' }} onchange="this.form.submit()">
                </div>
              </div>
              <div class="notif-item">
                <div>
                  <div class="notif-label">Pengingat Pembayaran</div>
                  <div class="notif-sub">Notifikasi tagihan yang akan jatuh tempo</div>
                </div>
                <div class="form-check form-switch mb-0">
                  <input class="form-check-input" type="checkbox" name="notif_pembayaran" value="1" {{ auth()->user()->notif_pembayaran ? 'checked' : '' }} onchange="this.form.submit()">
                </div>
              </div>
              <div class="notif-item">
                <div>
                  <div class="notif-label">Promo & Informasi</div>
                  <div class="notif-sub">Update fitur dan promo dari KostFinder</div>
                </div>
                <div class="form-check form-switch mb-0">
                  <input class="form-check-input" type="checkbox" name="notif_promo" value="1" {{ auth()->user()->notif_promo ? 'checked' : '' }} onchange="this.form.submit()">
                </div>
              </div>
            </form>
          </div>

          <div class="danger-zone">
            <h6 style="font-weight:700;color:#dc2626;font-size:.87rem;margin-bottom:.5rem;">
              <i class="bi bi-exclamation-triangle me-1"></i> Zona Berbahaya
            </h6>
            <p style="font-size:.78rem;color:#8fa3b8;margin-bottom:.8rem;">
              Hapus akun akan menghapus semua data kost, kamar, dan booking secara permanen.
            </p>
            <button class="btn btn-sm btn-outline-danger w-100" onclick="showModalHapus()" style="border-radius:.5rem;font-size:.8rem;font-weight:600;">
              <i class="bi bi-trash me-1"></i> Hapus Akun Saya
            </button>
          </div>

        </div>
        {{-- END KOLOM KANAN --}}

      </div>
    </div>

    <footer class="owner-footer">
      © {{ date('Y') }} KostFinder — Panel Pemilik Kost. All rights reserved.
    </footer>
  </div>

  {{-- MODAL HAPUS AKUN --}}
  <div id="modalHapusAkun" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,.6);z-index:99999;align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:1.2rem;padding:2rem;width:100%;max-width:380px;margin:1rem;box-shadow:0 20px 60px rgba(0,0,0,.25);">
      <div style="text-align:center;margin-bottom:1.2rem;">
        <div style="width:60px;height:60px;background:#fee2e2;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto .9rem;">
          <i class="bi bi-trash" style="font-size:1.5rem;color:#dc2626;"></i>
        </div>
        <div style="font-weight:800;font-size:1rem;color:#1e2d3d;margin-bottom:.4rem;">Hapus Akun?</div>
        <div style="font-size:.82rem;color:#8fa3b8;line-height:1.6;">Yakin hapus akun? <strong style="color:#dc2626;">Tindakan ini tidak bisa dibatalkan!</strong> Semua data kost, kamar, dan booking akan terhapus permanen.</div>
      </div>
      <div style="display:flex;gap:.6rem;">
        <button onclick="hideModalHapus()" style="flex:1;padding:.65rem;border-radius:.6rem;border:1.5px solid #e4e9f0;background:#fff;font-size:.85rem;font-weight:600;color:#555;cursor:pointer;">
          Batal
        </button>
        <form action="{{ route('owner.akun.hapus') }}" method="POST" style="flex:1;">
          @csrf @method('DELETE')
          <button type="submit" style="width:100%;padding:.65rem;border-radius:.6rem;border:0;background:#dc2626;color:#fff;font-size:.85rem;font-weight:700;cursor:pointer;">
            <i class="bi bi-trash me-1"></i> Ya, Hapus!
          </button>
        </form>
      </div>
    </div>
  </div>

  {{-- LIGHTBOX --}}
  <div id="lightbox" onclick="tutupLightbox()">
    <span class="lb-close" onclick="tutupLightbox()">&times;</span>
    <img id="lbImg" src="" alt="">
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function showModalHapus() { document.getElementById('modalHapusAkun').style.display = 'flex'; }
    function hideModalHapus() { document.getElementById('modalHapusAkun').style.display = 'none'; }
    document.getElementById('modalHapusAkun').addEventListener('click', function(e) {
      if (e.target === this) hideModalHapus();
    });
    function togglePw(id) {
      const el = document.getElementById(id);
      el.type = el.type === 'password' ? 'text' : 'password';
    }
    function previewUpload(input, boxId) {
      const box = document.getElementById(boxId);
      if (input.files && input.files[0]) {
        const file = input.files[0];
        const isPdf = file.type === 'application/pdf';
        if (isPdf) {
          box.style.borderColor = '#22c55e';
          box.style.background = '#f0fdf4';
          box.querySelectorAll('i').forEach(el => { el.className = 'bi bi-file-earmark-pdf-fill'; el.style.color = '#22c55e'; });
          box.querySelectorAll('div').forEach(el => el.textContent = file.name);
          return;
        }
        const reader = new FileReader();
        reader.onload = e => {
          box.style.padding = '0';
          box.style.border = '2px solid #22c55e';
          box.style.background = '#f0fdf4';
          box.style.overflow = 'hidden';
          box.style.height = '160px';
          box.querySelectorAll('i, div').forEach(el => el.style.display = 'none');
          let img = box.querySelector('img.inner-preview');
          if (!img) {
            img = document.createElement('img');
            img.className = 'inner-preview';
            img.style.cssText = 'width:100%;height:100%;object-fit:cover;border-radius:.65rem;display:block;';
            box.appendChild(img);
          }
          img.src = e.target.result;
        };
        reader.readAsDataURL(file);
      }
    }
    function bukaLightbox(src) {
      document.getElementById('lbImg').src = src;
      document.getElementById('lightbox').classList.add('show');
    }
    function tutupLightbox() {
      document.getElementById('lightbox').classList.remove('show');
    }
    document.addEventListener('keydown', e => { if(e.key === 'Escape') tutupLightbox(); });
    function toggleSidebar() {
      document.getElementById('sidebar').classList.toggle('collapsed');
      document.getElementById('mainContent').classList.toggle('collapsed');
    }
  </script>
</body>
</html>