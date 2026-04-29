@extends('admin.layout')

@section('title', 'Monitoring Kos')
@section('page_title', 'Monitoring Data Kos')
@section('page_subtitle', 'Kelola data kos: detail, verifikasi, nonaktifkan, hapus')

@section('content')
<style>
    .card-panel {
        background: #fff;
        border-radius: 1rem;
        border: none;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        padding: 1.5rem;
    }
    .table thead th {
        background: #f8fafc;
        color: #64748b;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        border-top: none;
        padding: 1rem;
    }
    .table tbody td {
        padding: 1rem;
        color: #334155;
        font-size: 0.85rem;
        border-bottom: 1px solid #f1f5f9;
    }
    .table tbody tr:hover {
        background-color: #fcfdfe;
    }
    .badge-pill {
        padding: 0.4rem 0.8rem;
        border-radius: 999px;
        font-weight: 700;
        font-size: 0.7rem;
    }
    .btn-action {
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        transition: all 0.2s;
        border: none;
        text-decoration: none;
    }
    .btn-action:hover {
        transform: translateY(-2px);
    }
    .btn-detail { background: #e0e7ff; color: #4338ca; }
    .btn-verify { background: #dcfce7; color: #15803d; }
    .btn-status { background: #fef9c3; color: #a16207; }
    .btn-delete { background: #fee2e2; color: #b91c1c; }
    
    .filter-box {
        background: #f8fafc;
        padding: 1.2rem;
        border-radius: 12px;
        margin-bottom: 1.5rem;
        border: 1px solid #e2e8f0;
    }
    .form-control, .form-select {
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        padding: 0.6rem 1rem;
        font-size: 0.85rem;
    }
</style>

<div class="card-panel">
    <div class="filter-box">
        <form method="GET" action="{{ route('admin.kosts') }}" class="row g-3">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0" style="border-radius: 10px 0 0 10px;">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="text" name="q" value="{{ request('q') }}" class="form-control border-start-0" placeholder="Cari nama kos, kota, atau alamat..." style="border-radius: 0 10px 10px 0;">
                </div>
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="aktif" @selected(request('status') === 'aktif')>Aktif</option>
                    <option value="nonaktif" @selected(request('status') === 'nonaktif')>Nonaktif</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="verified" class="form-select">
                    <option value="">Semua Verifikasi</option>
                    <option value="ya" @selected(request('verified') === 'ya')>Terverifikasi</option>
                    <option value="tidak" @selected(request('verified') === 'tidak')>Belum</option>
                </select>
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100" style="border-radius: 10px; font-weight: 700;">
                    <i class="bi bi-filter me-1"></i> Filter
                </button>
                <a href="{{ route('admin.kosts') }}" class="btn btn-outline-secondary w-100" style="border-radius: 10px; font-weight: 700;">
                    <i class="bi bi-arrow-clockwise me-1"></i> Reset
                </a>
            </div>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th>Nama Properti</th>
                    <th>Pemilik</th>
                    <th>Lokasi</th>
                    <th>Tipe</th>
                    <th class="text-center">Kamar</th>
                    <th>Harga Mulai</th>
                    <th>Verifikasi</th>
                    <th>Status</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kosts as $kost)
                <tr>
                    <td>
                        <div class="fw-bold text-dark">{{ $kost->nama_kost }}</div>
                        <div class="text-muted" style="font-size: 0.75rem;">ID: #KST-{{ $kost->id }}</div>
                    </td>
                    <td>
                        <div class="fw-semibold">{{ $kost->owner->name ?? '-' }}</div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-1">
                            <i class="bi bi-geo-alt text-danger"></i> {{ $kost->kota }}
                        </div>
                    </td>
                    <td>
                        <span class="text-capitalize">{{ $kost->tipe_kost }}</span>
                    </td>
                    <td class="text-center">
                        <span class="badge bg-light text-dark border">{{ $kost->rooms_count }}</span>
                    </td>
                    <td>
                        <div class="fw-bold text-primary">Rp {{ number_format((int) $kost->harga_mulai, 0, ',', '.') }}</div>
                    </td>
                    <td>
                        @if($kost->is_verified)
                            <span class="badge badge-pill bg-success-subtle text-success" style="background:#dcfce7; color:#15803d;">
                                <i class="bi bi-patch-check-fill me-1"></i> Terverifikasi
                            </span>
                        @else
                            <span class="badge badge-pill bg-warning-subtle text-warning text-dark" style="background:#fef9c3; color:#a16207;">
                                <i class="bi bi-exclamation-circle-fill me-1"></i> Belum
                            </span>
                        @endif
                    </td>
                    <td>
                        @if($kost->status === 'aktif')
                            <span class="badge badge-pill bg-success" style="background-color: #10b981 !important;">Aktif</span>
                        @else
                            <span class="badge badge-pill bg-secondary">Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('admin.kosts.show', $kost) }}" class="btn-action btn-detail" title="Detail">
                                <i class="bi bi-eye-fill"></i>
                            </a>
                            
                            @if(! $kost->is_verified)
                                <button type="button" class="btn-action btn-verify" 
                                        onclick="confirmAction('{{ route('admin.kosts.verify', $kost) }}', 'Verifikasi Kos?', 'Pastikan Anda sudah mengecek detail dan dokumen kos ini sebelum memberikan verifikasi.', 'PATCH', 'success')"
                                        title="Verifikasi">
                                    <i class="bi bi-check-lg"></i>
                                </button>
                            @endif
                            
                            <button type="button" class="btn-action btn-status" 
                                    onclick="confirmAction('{{ route('admin.kosts.toggle-status', $kost) }}', '{{ $kost->status === 'aktif' ? 'Nonaktifkan Kos?' : 'Aktifkan Kos?' }}', 'Apakah Anda yakin ingin mengubah status aktif kos ini?', 'PATCH', 'warning')"
                                    title="{{ $kost->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}">
                                <i class="bi bi-power"></i>
                            </button>
                            
                            <button type="button" class="btn-action btn-delete" 
                                    onclick="confirmAction('{{ route('admin.kosts.destroy', $kost) }}', 'Hapus Kos?', 'Data kos yang dihapus tidak dapat dikembalikan lagi.', 'DELETE', 'danger')"
                                    title="Hapus">
                                <i class="bi bi-trash3-fill"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-1 d-block mb-2 opacity-25"></i>
                        Belum ada data properti kos yang terdaftar.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $kosts->links() }}
    </div>
</div>

{{-- ── MODAL KONFIRMASI GLOBAL ── --}}
<div class="modal fade" id="confirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 1.2rem;">
            <div class="modal-body p-4 text-center">
                <div id="confirmIconWrap" class="mb-3 mx-auto d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; border-radius: 50%;">
                    <i id="confirmIcon" class="fs-2"></i>
                </div>
                <h5 id="confirmTitle" class="fw-bold mb-2"></h5>
                <p id="confirmMessage" class="text-muted small mb-4"></p>
                
                <form id="confirmForm" method="POST">
                    @csrf
                    <input type="hidden" name="_method" id="confirmMethod" value="POST">
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-light w-100 fw-bold" data-bs-dismiss="modal" style="border-radius: 10px; padding: 0.6rem;">Batal</button>
                        <button type="submit" id="confirmSubmitBtn" class="btn w-100 fw-bold" style="border-radius: 10px; padding: 0.6rem;">Ya, Lanjutkan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmAction(url, title, message, method, type) {
        const modal = new bootstrap.Modal(document.getElementById('confirmModal'));
        const form = document.getElementById('confirmForm');
        const titleEl = document.getElementById('confirmTitle');
        const msgEl = document.getElementById('confirmMessage');
        const methodInput = document.getElementById('confirmMethod');
        const submitBtn = document.getElementById('confirmSubmitBtn');
        const iconWrap = document.getElementById('confirmIconWrap');
        const icon = document.getElementById('confirmIcon');

        form.action = url;
        titleEl.innerText = title;
        msgEl.innerText = message;
        methodInput.value = method;

        // Reset classes
        submitBtn.className = 'btn w-100 fw-bold';
        iconWrap.className = 'mb-3 mx-auto d-flex align-items-center justify-content-center';
        icon.className = 'bi fs-2';

        if (type === 'danger') {
            submitBtn.classList.add('btn-danger');
            iconWrap.style.backgroundColor = '#fee2e2';
            icon.classList.add('bi-trash3', 'text-danger');
            submitBtn.innerText = 'Ya, Hapus';
        } else if (type === 'warning') {
            submitBtn.classList.add('btn-warning');
            iconWrap.style.backgroundColor = '#fef9c3';
            icon.classList.add('bi-exclamation-triangle', 'text-warning');
            submitBtn.innerText = 'Ya, Ubah Status';
        } else if (type === 'success') {
            submitBtn.classList.add('btn-success');
            iconWrap.style.backgroundColor = '#dcfce7';
            icon.classList.add('bi-patch-check', 'text-success');
            submitBtn.innerText = 'Ya, Verifikasi';
        }

        modal.show();
    }
</script>
@endsection
