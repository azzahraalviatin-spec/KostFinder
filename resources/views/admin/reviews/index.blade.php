@extends('admin.layout')

@section('title', 'Kelola Ulasan')
@section('page_title', 'Kelola Ulasan Owner')

@section('content')

@if(session('success'))
    <div class="alert alert-success rounded-3 py-2 mb-3 d-flex align-items-center gap-2">
        <i class="bi bi-check-circle-fill"></i>{{ session('success') }}
    </div>
@endif

{{-- STAT CARDS --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fff7ed;">⏳</div>
            <div>
                <div class="stat-num">{{ $reviews->where('status','pending')->count() }}</div>
                <div class="stat-lbl">Menunggu</div>
                <div class="stat-sub" style="color:#f59e0b;">Perlu ditinjau</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#f0fdf4;">✅</div>
            <div>
                <div class="stat-num">{{ $reviews->where('status','approved')->count() }}</div>
                <div class="stat-lbl">Disetujui</div>
                <div class="stat-sub" style="color:#16a34a;">Tampil di landing</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fef2f2;">❌</div>
            <div>
                <div class="stat-num">{{ $reviews->where('status','rejected')->count() }}</div>
                <div class="stat-lbl">Ditolak</div>
                <div class="stat-sub" style="color:#dc2626;">Tidak ditampilkan</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#eff6ff;">📝</div>
            <div>
                <div class="stat-num">{{ $reviews->total() }}</div>
                <div class="stat-lbl">Total Ulasan</div>
                <div class="stat-sub" style="color:#3b82f6;">Semua ulasan</div>
            </div>
        </div>
    </div>
</div>

{{-- TABLE --}}
<div class="section-card">
    <div class="section-head">
        <h6><i class="bi bi-star-fill me-2" style="color:#f59e0b;"></i>Daftar Ulasan Pemilik Kos</h6>
    </div>

    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>PEMILIK KOS</th>
                    <th>LOKASI KOS</th>
                    <th>RATING</th>
                    <th>ULASAN</th>
                    <th>STATUS</th>
                    <th>TANGGAL</th>
                    <th>AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reviews as $r)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div style="width:38px;height:38px;border-radius:11px;background:linear-gradient(135deg,#1dd47a,#0e8a4b);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:800;font-size:.78rem;flex-shrink:0;">
                                {{ strtoupper(substr($r->user->name, 0, 2)) }}
                            </div>
                            <div>
                                <div style="font-weight:700;font-size:.83rem;color:#1e2d3d;">{{ $r->user->name }}</div>
                                <div style="font-size:.72rem;color:#8fa3b8;">{{ $r->user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div style="font-weight:700;font-size:.82rem;">{{ $r->lokasi_kos }}</div>
                        <div style="font-size:.72rem;color:#8fa3b8;"><i class="bi bi-geo-alt" style="font-size:.65rem;"></i> {{ $r->kota }}</div>
                    </td>
                    <td>
                        <div style="color:#f59e0b;font-size:.95rem;letter-spacing:1px;">
                            @for($i = 1; $i <= 5; $i++)
                                {{ $i <= $r->rating ? '★' : '☆' }}
                            @endfor
                        </div>
                        <div style="font-size:.7rem;color:#8fa3b8;">{{ $r->rating }}/5</div>
                    </td>
                    <td style="max-width:240px;">
                        <p style="font-size:.8rem;color:#334155;margin:0;line-height:1.65;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                            {{ $r->ulasan }}
                        </p>
                        <button type="button"
                            style="background:none;border:none;color:#e8401c;font-size:.72rem;font-weight:700;padding:0;margin-top:3px;cursor:pointer;"
                            onclick="lihatUlasan('{{ addslashes($r->ulasan) }}', '{{ $r->user->name }}')">
                            Lihat selengkapnya
                        </button>
                    </td>
                    <td>
                        @if($r->status === 'pending')
                            <span class="badge rounded-pill px-3 py-2" style="background:#fff7ed;color:#ea580c;border:1px solid #fed7aa;">
                                <i class="bi bi-clock me-1"></i>Pending
                            </span>
                        @elseif($r->status === 'approved')
                            <span class="badge rounded-pill px-3 py-2" style="background:#f0fdf4;color:#16a34a;border:1px solid #bbf7d0;">
                                <i class="bi bi-check-circle me-1"></i>Approved
                            </span>
                        @else
                            <span class="badge rounded-pill px-3 py-2" style="background:#fef2f2;color:#dc2626;border:1px solid #fecaca;">
                                <i class="bi bi-x-circle me-1"></i>Rejected
                            </span>
                        @endif
                    </td>
                    <td style="font-size:.78rem;color:#8fa3b8;white-space:nowrap;">
                        {{ $r->created_at->format('d M Y') }}
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            @if($r->status !== 'approved')
                            <form action="{{ route('admin.reviews.approve', $r->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit"
                                    style="width:32px;height:32px;border-radius:8px;border:1px solid #bbf7d0;background:#f0fdf4;color:#16a34a;display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:.85rem;"
                                    title="Setujui ulasan ini">
                                    <i class="bi bi-check-lg"></i>
                                </button>
                            </form>
                            @endif
                            @if($r->status !== 'rejected')
                            <button type="button"
                                style="width:32px;height:32px;border-radius:8px;border:1px solid #fecaca;background:#fef2f2;color:#dc2626;display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:.85rem;"
                                title="Tolak ulasan ini"
                                onclick="konfirmasiTolak({{ $r->id }}, '{{ addslashes($r->user->name) }}')">
                                <i class="bi bi-x-lg"></i>
                            </button>
                            {{-- Form reject tersembunyi --}}
                            <form id="reject-form-{{ $r->id }}"
                                action="{{ route('admin.reviews.reject', $r->id) }}"
                                method="POST" style="display:none;">
                                @csrf @method('PATCH')
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">
                        <div class="text-center py-5 text-muted">
                            <i class="bi bi-star" style="font-size:2.5rem;display:block;margin-bottom:10px;opacity:.25;"></i>
                            Belum ada ulasan masuk
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($reviews->hasPages())
    <div class="p-3 d-flex justify-content-end">
        {{ $reviews->links() }}
    </div>
    @endif
</div>

{{-- MODAL: Lihat Ulasan Lengkap --}}
<div class="modal fade" id="modalUlasan" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-0 pb-0">
                <h6 class="fw-bold mb-0" id="modalUlasanNama"></h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body pt-2">
                <p id="modalUlasanText" style="font-size:.93rem;line-height:1.85;color:#334155;"></p>
            </div>
        </div>
    </div>
</div>

{{-- MODAL: Konfirmasi Tolak --}}
<div class="modal fade" id="modalTolak" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-body text-center p-4">
                <div style="width:56px;height:56px;border-radius:50%;background:#fef2f2;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;font-size:1.5rem;">
                    ❌
                </div>
                <h6 class="fw-bold mb-2">Tolak Ulasan?</h6>
                <p class="text-muted small mb-4" id="modalTolakNama">
                    Ulasan dari <strong></strong> tidak akan ditampilkan di halaman landing.
                </p>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-light rounded-3 flex-fill fw-600"
                        data-bs-dismiss="modal" style="font-weight:600;">
                        Batal
                    </button>
                    <button type="button" class="btn rounded-3 flex-fill fw-bold"
                        style="background:#dc2626;color:#fff;font-weight:700;"
                        id="btnTolakKonfirm">
                        Ya, Tolak
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Lihat ulasan lengkap
function lihatUlasan(text, nama) {
    document.getElementById('modalUlasanNama').textContent = 'Ulasan dari ' + nama;
    document.getElementById('modalUlasanText').textContent = text;
    new bootstrap.Modal(document.getElementById('modalUlasan')).show();
}

// Konfirmasi tolak
let rejectId = null;
function konfirmasiTolak(id, nama) {
    rejectId = id;
    document.querySelector('#modalTolakNama strong').textContent = nama;
    new bootstrap.Modal(document.getElementById('modalTolak')).show();
}

document.getElementById('btnTolakKonfirm').addEventListener('click', function() {
    if (rejectId) {
        document.getElementById('reject-form-' + rejectId).submit();
    }
});
</script>
@endpush