@extends('admin.layout')

@section('title', 'Detail Owner')
@section('page_title', 'Detail Owner')
@section('page_subtitle', 'Profil owner dan daftar kos yang dikelola')

@section('content')

<div class="owner-detail-page">

<style>
  .owner-detail-page {
    --od-bg: #f8fafc;
    --od-card: #ffffff;
    --od-line: #e9edf5;
    --od-text: #0f172a;
    --od-muted: #64748b;
    --od-primary: #2563eb;
    --od-success: #16a34a;
    --od-warning: #f59e0b;
    --od-danger: #dc2626;
    --od-shadow: 0 10px 30px rgba(15, 23, 42, 0.05);
    --od-radius: 20px;
  }

  .owner-detail-page .od-hero {
    background: linear-gradient(135deg, #ffffff, #f8fbff);
    border: 1px solid #e8eef8;
    border-radius: 24px;
    padding: 28px;
    box-shadow: 0 16px 40px rgba(37, 99, 235, 0.05);
  }

  .owner-detail-page .od-avatar {
    width: 70px;
    height: 70px;
    border-radius: 20px;
    background: linear-gradient(135deg, #2563eb, #60a5fa);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    font-weight: 800;
  }

  .owner-detail-page .od-owner-name {
    font-size: 1.35rem;
    font-weight: 800;
    color: var(--od-text);
    margin-bottom: .15rem;
  }

  .owner-detail-page .od-owner-email {
    color: var(--od-muted);
    font-size: .92rem;
  }

  .owner-detail-page .od-card {
    background: var(--od-card);
    border: 1px solid var(--od-line);
    border-radius: var(--od-radius);
    box-shadow: var(--od-shadow);
    padding: 24px;
  }

  .owner-detail-page .od-title {
    font-size: .95rem;
    font-weight: 800;
    color: var(--od-text);
    margin-bottom: 1rem;
  }

  .owner-detail-page .od-info-box {
    background: #fafcff;
    border: 1px solid #eef2f8;
    border-radius: 18px;
    padding: 16px 18px;
    height: 100%;
  }

  .owner-detail-page .od-info-label {
    font-size: .72rem;
    color: var(--od-muted);
    text-transform: uppercase;
    letter-spacing: .5px;
    margin-bottom: .35rem;
  }

  .owner-detail-page .od-info-value {
    font-size: .96rem;
    font-weight: 800;
    color: var(--od-text);
  }

  .owner-detail-page .od-badge {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    padding: .45rem .85rem;
    border-radius: 999px;
    font-size: .78rem;
    font-weight: 700;
  }

  .owner-detail-page .od-success {
    background: #ecfdf3;
    color: #15803d;
    border: 1px solid #bbf7d0;
  }

  .owner-detail-page .od-warning {
    background: #fff8e7;
    color: #b45309;
    border: 1px solid #fde68a;
  }

  .owner-detail-page .od-danger {
    background: #fef2f2;
    color: #b91c1c;
    border: 1px solid #fecaca;
  }

  .owner-detail-page .od-muted {
    background: #f3f4f6;
    color: #6b7280;
    border: 1px solid #e5e7eb;
  }

  .owner-detail-page .od-primary {
    background: #eff6ff;
    color: #1d4ed8;
    border: 1px solid #bfdbfe;
  }

  .owner-detail-page .od-doc {
    border: 1px solid var(--od-line);
    border-radius: 20px;
    overflow: hidden;
    background: #fff;
    transition: all .25s ease;
    box-shadow: 0 8px 20px rgba(15, 23, 42, 0.04);
    height: 100%;
  }

  .owner-detail-page .od-doc:hover {
    transform: translateY(-4px);
    box-shadow: 0 18px 35px rgba(15, 23, 42, 0.08);
  }

  .owner-detail-page .od-doc img {
    width: 100%;
    height: 210px;
    object-fit: cover;
    background: #f8fafc;
  }

  .owner-detail-page .od-doc-body {
    padding: 14px 16px 16px;
  }

  .owner-detail-page .od-doc-title {
    font-size: .86rem;
    font-weight: 800;
    color: #1f2937;
  }

  .owner-detail-page .od-doc-sub {
    font-size: .76rem;
    color: var(--od-muted);
    margin-top: .3rem;
  }

  .owner-detail-page .od-summary {
    padding: 18px;
    border-radius: 20px;
    border: 1px solid #edf2f8;
    background: linear-gradient(180deg, #ffffff, #fafcff);
  }

  .owner-detail-page .od-summary-label {
    font-size: .76rem;
    color: var(--od-muted);
    margin-bottom: .2rem;
  }

  .owner-detail-page .od-summary-value {
    font-size: 1.35rem;
    font-weight: 900;
    color: var(--od-text);
    line-height: 1.1;
  }

  .owner-detail-page .od-summary-icon {
    width: 48px;
    height: 48px;
    border-radius: 16px;
    background: #f3f7ff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
  }

  .owner-detail-page .od-table thead th {
    background: transparent;
    color: #6b7280;
    font-size: .75rem;
    text-transform: uppercase;
    letter-spacing: .5px;
    border-bottom: 1px solid #edf2f7;
    padding: 1rem .8rem;
  }

  .owner-detail-page .od-table tbody td {
    padding: 1rem .8rem;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
    font-size: .89rem;
  }

  .owner-detail-page .od-table tbody tr:hover {
    background: #fafcff;
  }

  .owner-detail-page .od-btn-light {
    border-radius: 999px;
    padding: .72rem 1rem;
    font-weight: 700;
    border: 1px solid var(--od-line);
    background: #fff;
    color: #111827;
  }

  .owner-detail-page .od-btn-success {
    border-radius: 999px;
    padding: .72rem 1rem;
    font-weight: 700;
    border: none;
    background: linear-gradient(135deg, #16a34a, #22c55e);
    color: #fff;
  }

  .owner-detail-page .od-btn-danger {
    border-radius: 999px;
    padding: .72rem 1rem;
    font-weight: 700;
    border: none;
    background: linear-gradient(135deg, #dc2626, #ef4444);
    color: #fff;
  }

  .owner-detail-page .od-reject-box {
    background: #fffaf5;
    border: 1px solid #fed7aa;
    border-radius: 18px;
    padding: 16px;
  }

  .owner-detail-page .od-sticky {
    position: sticky;
    top: 18px;
  }

  .owner-detail-page .od-empty {
    border: 1px dashed #d9e1ee;
    border-radius: 20px;
    background: #fbfcfe;
    padding: 42px 20px;
    text-align: center;
  }
</style>

@if(session('status'))
  <div class="alert alert-success alert-dismissible fade show mb-4 rounded-4 border-0 shadow-sm">
    {{ session('status') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
@endif

<div class="od-hero mb-4">
  <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-4">
    <div class="d-flex align-items-center gap-3">
      <div class="od-avatar">
        {{ strtoupper(substr($owner->name, 0, 1)) }}
      </div>
      <div>
        <div class="od-owner-name">{{ $owner->name }}</div>
        <div class="od-owner-email">{{ $owner->email }}</div>

        <div class="d-flex flex-wrap gap-2 mt-3">
          @if($owner->status_akun === 'aktif')
            <span class="od-badge od-success">● Akun Aktif</span>
          @else
            <span class="od-badge od-danger">● Akun Nonaktif</span>
          @endif

          @if($owner->status_verifikasi_identitas === 'disetujui')
            <span class="od-badge od-primary">🛡️ Owner Terverifikasi</span>
          @elseif($owner->status_verifikasi_identitas === 'pending')
            <span class="od-badge od-warning">⏳ Menunggu Review</span>
          @elseif($owner->status_verifikasi_identitas === 'ditolak')
            <span class="od-badge od-danger">❌ Verifikasi Ditolak</span>
          @else
            <span class="od-badge od-muted">⚪ Belum Upload Dokumen</span>
          @endif
        </div>
      </div>
    </div>

    <div class="text-lg-end">
      <div class="text-muted small mb-1">Terdaftar Sejak</div>
      <div class="fw-bold fs-6 text-dark">{{ $owner->created_at?->format('d M Y • H:i') }}</div>
    </div>
  </div>
</div>

<div class="row g-4">
  <div class="col-lg-8">

    {{-- INFORMASI OWNER --}}
    <div class="od-card mb-4">
      <div class="od-title">Informasi Owner</div>
      <div class="row g-3">
        <div class="col-md-6">
          <div class="od-info-box">
            <div class="od-info-label">Nama Lengkap</div>
            <div class="od-info-value">{{ $owner->name }}</div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="od-info-box">
            <div class="od-info-label">Email</div>
            <div class="od-info-value">{{ $owner->email }}</div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="od-info-box">
            <div class="od-info-label">Nomor HP</div>
            <div class="od-info-value">{{ $owner->no_hp ?? '-' }}</div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="od-info-box">
            <div class="od-info-label">Jumlah Properti</div>
            <div class="od-info-value">{{ $ownerKosts->count() }} Kos</div>
          </div>
        </div>
      </div>
    </div>

    {{-- VERIFIKASI --}}
    <div class="od-card mb-4">
      <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <div class="od-title mb-0">Verifikasi Identitas</div>

        @if($owner->status_verifikasi_identitas === 'disetujui')
          <span class="od-badge od-success">✅ Sudah Diverifikasi</span>
        @elseif($owner->status_verifikasi_identitas === 'pending')
          <span class="od-badge od-warning">⏳ Menunggu Review</span>
        @elseif($owner->status_verifikasi_identitas === 'ditolak')
          <span class="od-badge od-danger">❌ Ditolak</span>
        @else
          <span class="od-badge od-muted">⚪ Belum Upload Dokumen</span>
        @endif
      </div>

      @if($owner->status_verifikasi_identitas === 'ditolak' && $owner->catatan_verifikasi)
        <div class="od-reject-box mb-4">
          <div class="fw-bold mb-1 text-danger">Catatan Penolakan</div>
          <div style="font-size:.88rem;">{{ $owner->catatan_verifikasi }}</div>
        </div>
      @endif

      @if($owner->foto_ktp || $owner->foto_selfie || $owner->foto_kepemilikan)
        <div class="row g-3 mb-4">

          @if($owner->foto_ktp)
          <div class="col-md-4">
            <a href="{{ asset('storage/'.$owner->foto_ktp) }}" target="_blank" class="text-decoration-none">
              <div class="od-doc">
                <img src="{{ asset('storage/'.$owner->foto_ktp) }}" alt="Dokumen KTP">
                <div class="od-doc-body">
                  <div class="od-doc-title">🪪 {{ $owner->jenis_identitas ?? 'KTP' }}</div>
                  <div class="od-doc-sub">Klik untuk melihat dokumen</div>
                </div>
              </div>
            </a>
          </div>
          @endif

          @if($owner->foto_selfie)
          <div class="col-md-4">
            <a href="{{ asset('storage/'.$owner->foto_selfie) }}" target="_blank" class="text-decoration-none">
              <div class="od-doc">
                <img src="{{ asset('storage/'.$owner->foto_selfie) }}" alt="Selfie Identitas">
                <div class="od-doc-body">
                  <div class="od-doc-title">🤳 Selfie Identitas</div>
                  <div class="od-doc-sub">Klik untuk melihat dokumen</div>
                </div>
              </div>
            </a>
          </div>
          @endif

          @if($owner->foto_kepemilikan)
          <div class="col-md-4">
            <a href="{{ asset('storage/'.$owner->foto_kepemilikan) }}" target="_blank" class="text-decoration-none">
              <div class="od-doc">
                <img src="{{ asset('storage/'.$owner->foto_kepemilikan) }}" alt="Bukti Kepemilikan">
                <div class="od-doc-body">
                  <div class="od-doc-title">🏠 Bukti Kepemilikan</div>
                  <div class="od-doc-sub">Klik untuk melihat dokumen</div>
                </div>
              </div>
            </a>
          </div>
          @endif

        </div>

        @if($owner->status_verifikasi_identitas !== 'disetujui')
        <div class="d-flex gap-2 flex-wrap">
          <button type="button" class="od-btn-success" data-bs-toggle="modal" data-bs-target="#modalVerif">
            <i class="bi bi-check-circle me-1"></i> Verifikasi / Setujui
          </button>

          <button type="button" class="od-btn-light text-danger"
            onclick="document.getElementById('formTolak').classList.toggle('d-none')">
            <i class="bi bi-x-circle me-1"></i> Tolak
          </button>
        </div>

        <div id="formTolak" class="d-none mt-4">
          <div class="od-card p-3">
            <form action="{{ route('admin.owners.reject-identity', $owner) }}" method="POST">
              @csrf @method('PATCH')
              <div class="mb-3">
                <label class="form-label fw-bold" style="font-size:.85rem;">Alasan Penolakan</label>
                <input type="text" name="catatan" class="form-control rounded-4 py-2"
                  placeholder="Contoh: Foto identitas buram / bukti kepemilikan tidak valid" required>
              </div>
              <button type="submit" class="od-btn-danger">
                Kirim Penolakan
              </button>
            </form>
          </div>
        </div>
        @endif

      @else
        <div class="od-empty">
          <div style="font-size:2rem;">📂</div>
          <div class="fw-bold mt-2">Belum Ada Dokumen Identitas</div>
          <div class="text-muted small mt-1">Owner belum mengupload dokumen verifikasi.</div>
        </div>
      @endif
    </div>

    {{-- DAFTAR KOS --}}
    <div class="od-card">
      <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
        <div class="od-title mb-0">Daftar Kos Owner</div>
        <span class="od-badge od-primary">{{ $ownerKosts->count() }} Properti</span>
      </div>

      <div class="table-responsive">
        <table class="table od-table mb-0">
          <thead>
            <tr>
              <th>Nama Kos</th>
              <th>Kota</th>
              <th>Status</th>
              <th>Verifikasi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($ownerKosts as $kost)
            <tr>
              <td class="fw-bold text-dark">{{ $kost->nama_kost }}</td>
              <td>{{ $kost->kota }}</td>
              <td>
                @if($kost->status === 'aktif')
                  <span class="od-badge od-success">Aktif</span>
                @else
                  <span class="od-badge od-muted">{{ ucfirst($kost->status) }}</span>
                @endif
              </td>
              <td>
                @if($kost->is_verified)
                  <span class="od-badge od-success">Terverifikasi</span>
                @else
                  <span class="od-badge od-warning">Belum</span>
                @endif
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="4" class="text-center text-muted py-4">Owner belum punya kos.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

  </div>

  {{-- SIDEBAR CONTENT SAJA, BUKAN SIDEBAR LAYOUT --}}
  <div class="col-lg-4">
    <div class="od-sticky">

      <div class="od-card mb-4">
        <div class="od-title">Ringkasan Monitoring</div>

        <div class="d-flex flex-column gap-3">
          <div class="od-summary d-flex justify-content-between align-items-center">
            <div>
              <div class="od-summary-label">Total Kos</div>
              <div class="od-summary-value">{{ $ownerKosts->count() }}</div>
            </div>
            <div class="od-summary-icon">🏠</div>
          </div>

          <div class="od-summary d-flex justify-content-between align-items-center">
            <div>
              <div class="od-summary-label">Kos Aktif</div>
              <div class="od-summary-value">{{ $ownerKosts->where('status','aktif')->count() }}</div>
            </div>
            <div class="od-summary-icon">🟢</div>
          </div>

          <div class="od-summary d-flex justify-content-between align-items-center">
            <div>
              <div class="od-summary-label">Kos Terverifikasi</div>
              <div class="od-summary-value">{{ $ownerKosts->where('is_verified',1)->count() }}</div>
            </div>
            <div class="od-summary-icon">✅</div>
          </div>

          <div class="od-summary d-flex justify-content-between align-items-center">
            <div>
              <div class="od-summary-label">Status Identitas</div>
              <div class="od-summary-value" style="font-size:1rem;">
                @if($owner->status_verifikasi_identitas === 'disetujui')
                  <span class="text-success">Verified</span>
                @elseif($owner->status_verifikasi_identitas === 'pending')
                  <span class="text-warning">Pending</span>
                @elseif($owner->status_verifikasi_identitas === 'ditolak')
                  <span class="text-danger">Ditolak</span>
                @else
                  <span class="text-secondary">Belum Upload</span>
                @endif
              </div>
            </div>
            <div class="od-summary-icon">🪪</div>
          </div>
        </div>
      </div>

      <div class="od-card">
        <div class="od-title">Aksi Admin</div>

        <div class="d-grid gap-2">
          <a href="{{ route('admin.owners') }}" class="od-btn-light text-decoration-none text-center">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Owners
          </a>

          <button type="button"
            class="{{ $owner->status_akun === 'aktif' ? 'od-btn-danger' : 'od-btn-success' }}"
            data-bs-toggle="modal" data-bs-target="#modalToggleStatus">
            {{ $owner->status_akun === 'aktif' ? '🚫 Nonaktifkan Akun' : '✅ Aktifkan Akun' }}
          </button>
        </div>
      </div>

    </div>
  </div>
</div>

{{-- MODAL VERIFIKASI --}}
<div class="modal fade" id="modalVerif" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 rounded-5 shadow">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title fw-bold">Setujui Verifikasi Owner</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body pt-2">
        <p class="mb-2">Yakin ingin memverifikasi owner <strong>{{ $owner->name }}</strong>?</p>
        <p class="text-muted small mb-0">Setelah disetujui, data owner dianggap valid untuk tampil di sistem publik.</p>
      </div>
      <div class="modal-footer border-0">
        <button type="button" class="od-btn-light" data-bs-dismiss="modal">Batal</button>
        <form action="{{ route('admin.owners.verify-identity', $owner) }}" method="POST">
          @csrf @method('PATCH')
          <button type="submit" class="od-btn-success">Ya, Verifikasi</button>
        </form>
      </div>
    </div>
  </div>
</div>

{{-- MODAL TOGGLE STATUS --}}
<div class="modal fade" id="modalToggleStatus" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 rounded-5 shadow">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title fw-bold">
          {{ $owner->status_akun === 'aktif' ? 'Nonaktifkan Akun Owner' : 'Aktifkan Akun Owner' }}
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body pt-2">
        <p class="mb-2">
          Anda yakin ingin
          <strong>{{ $owner->status_akun === 'aktif' ? 'menonaktifkan' : 'mengaktifkan' }}</strong>
          akun <strong>{{ $owner->name }}</strong>?
        </p>
        <p class="text-muted small mb-0">
          @if($owner->status_akun === 'aktif')
            Owner tidak akan bisa login dan kos tidak tampil di publik.
          @else
            Owner akan bisa login kembali dan kos bisa tampil di publik.
          @endif
        </p>
      </div>
      <div class="modal-footer border-0">
        <button type="button" class="od-btn-light" data-bs-dismiss="modal">Batal</button>
        <form action="{{ route('admin.owners.toggle-status', $owner) }}" method="POST">
          @csrf @method('PATCH')
          <button type="submit" class="{{ $owner->status_akun === 'aktif' ? 'od-btn-danger' : 'od-btn-success' }}">
            {{ $owner->status_akun === 'aktif' ? 'Ya, Nonaktifkan' : 'Ya, Aktifkan' }}
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

</div>
@endsection