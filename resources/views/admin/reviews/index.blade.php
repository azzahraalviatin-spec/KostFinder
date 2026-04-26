@extends('admin.layout')

@section('title', 'Kelola Ulasan')
@section('page_title', 'Moderasi Ulasan')
@section('page_subtitle', 'Pantau dan moderasi ulasan pengguna untuk menjaga kualitas platform')

@section('content')
<style>
    .card-panel {
        background: #fff;
        border-radius: 1rem;
        border: none;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        padding: 1.5rem;
    }
    .stat-card-mini {
        background: #fff;
        border-radius: 1rem;
        padding: 1.2rem;
        border: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: all 0.3s ease;
    }
    .stat-card-mini:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
    }
    .stat-icon-wrap {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
    }
    .table thead th {
        background: #f8fafc;
        color: #64748b;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        padding: 1rem;
    }
    .table tbody td {
        padding: 1.2rem 1rem;
        font-size: 0.85rem;
        color: #334155;
    }
    .rating-stars {
        color: #fbbf24;
        font-size: 0.9rem;
    }
    .btn-action {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        border: none;
        transition: all 0.2s;
        text-decoration: none;
    }
    .btn-action:hover { transform: translateY(-2px); }
    .btn-approve { background: #dcfce7; color: #15803d; }
    .btn-reject { background: #fee2e2; color: #b91c1c; }
    .btn-view { background: #f1f5f9; color: #475569; }
</style>

<div class="container-fluid">
    {{-- ── STATS ROW ── --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="stat-card-mini">
                <div class="stat-icon-wrap" style="background: #fff7ed; color: #ea580c;">
                    <i class="bi bi-clock-history"></i>
                </div>
                <div>
                    <div class="fw-bold fs-5">{{ $reviews->where('status','pending')->count() }}</div>
                    <div class="text-muted small">Menunggu</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card-mini">
                <div class="stat-icon-wrap" style="background: #f0fdf4; color: #16a34a;">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div>
                    <div class="fw-bold fs-5">{{ $reviews->where('status','approved')->count() }}</div>
                    <div class="text-muted small">Disetujui</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card-mini">
                <div class="stat-icon-wrap" style="background: #fef2f2; color: #dc2626;">
                    <i class="bi bi-x-octagon"></i>
                </div>
                <div>
                    <div class="fw-bold fs-5">{{ $reviews->where('status','rejected')->count() }}</div>
                    <div class="text-muted small">Ditolak</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card-mini">
                <div class="stat-icon-wrap" style="background: #eff6ff; color: #2563eb;">
                    <i class="bi bi-chat-left-text"></i>
                </div>
                <div>
                    <div class="fw-bold fs-5">{{ $reviews->total() }}</div>
                    <div class="text-muted small">Total Ulasan</div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── MAIN TABLE ── --}}
    <div class="card-panel">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Pengguna</th>
                        <th>Properti</th>
                        <th>Rating</th>
                        <th width="300">Ulasan</th>
                        <th>Status</th>
                        <th class="text-end">Moderasi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reviews as $r)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="bg-primary-subtle text-primary fw-bold rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; background: #e0e7ff;">
                                    {{ substr($r->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="fw-bold">{{ $r->user->name }}</div>
                                    <div class="text-muted small">{{ $r->created_at->format('d M Y') }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="fw-semibold text-dark">{{ $r->kost->nama_kost ?? 'N/A' }}</div>
                            <div class="small text-muted"><i class="bi bi-geo-alt me-1"></i>{{ $r->kost->kota ?? 'N/A' }}</div>
                        </td>
                        <td>
                            <div class="rating-stars mb-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="bi bi-star{{ $i <= $r->rating ? '-fill' : '' }}"></i>
                                @endfor
                            </div>
                            <span class="badge bg-light text-dark border small">{{ $r->rating }}.0</span>
                        </td>
                        <td>
                            <div class="text-truncate-2 small text-muted" style="line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                "{{ $r->komentar }}"
                            </div>
                            <a href="javascript:void(0)" onclick="viewFullReview('{{ addslashes($r->komentar) }}', '{{ $r->user->name }}', '{{ $r->reply ? addslashes($r->reply->balasan) : '' }}')" class="text-primary fw-bold text-decoration-none small">Baca Selengkapnya</a>
                        </td>
                        <td>
                            @if($r->status === 'pending')
                                <span class="badge bg-warning-subtle text-warning px-3 py-2 rounded-pill" style="background: #fef9c3; color: #a16207 !important;">Menunggu</span>
                            @elseif($r->status === 'approved')
                                <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill" style="background: #dcfce7; color: #15803d !important;">Disetujui</span>
                            @else
                                <span class="badge bg-danger-subtle text-danger px-3 py-2 rounded-pill" style="background: #fee2e2; color: #b91c1c !important;">Ditolak</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-2 justify-content-end">
                                @if($r->status !== 'approved')
                                <form action="{{ route('admin.reviews.approve', $r->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn-action btn-approve" title="Setujui">
                                        <i class="bi bi-check-lg"></i>
                                    </button>
                                </form>
                                @endif

                                @if($r->status !== 'rejected')
                                <form action="{{ route('admin.reviews.reject', $r->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn-action btn-reject" title="Tolak">
                                        <i class="bi bi-x-lg"></i>
                                    </button>
                                </form>
                                @endif
                                
                                <button class="btn-action btn-view" onclick="viewFullReview('{{ addslashes($r->komentar) }}', '{{ $r->user->name }}', '{{ $r->reply ? addslashes($r->reply->balasan) : '' }}')" title="Detail">
                                    <i class="bi bi-info-circle-fill"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="bi bi-star fs-1 d-block mb-2 opacity-25"></i>
                            Belum ada ulasan yang perlu dimoderasi.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($reviews->hasPages())
        <div class="mt-4">
            {{ $reviews->links() }}
        </div>
        @endif
    </div>
</div>

{{-- ── MODAL VIEW FULL ── --}}
<div class="modal fade" id="reviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 1.2rem;">
            <div class="modal-header border-0 pb-0">
                <h6 class="fw-bold mb-0">Detail Ulasan Pengguna</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="d-flex align-items-center gap-3 mb-3 pb-3 border-bottom">
                    <div id="modalUserAvatar" class="bg-primary text-white fw-bold rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;"></div>
                    <div>
                        <div id="modalUserName" class="fw-bold"></div>
                        <div class="text-muted small">Pemberi Ulasan</div>
                    </div>
                </div>
                <p id="modalReviewText" class="text-muted fs-6" style="line-height: 1.8; font-style: italic;"></p>
                <div id="modalReplySection" class="mt-4 p-3 bg-light rounded-3" style="display:none; border-left: 4px solid var(--primary);">
                    <div class="fw-bold small mb-1"><i class="bi bi-reply-fill"></i> Balasan Pemilik:</div>
                    <div id="modalReplyText" class="small text-dark"></div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-light fw-bold rounded-3 w-100" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    function viewFullReview(text, name, reply = null) {
        const modal = new bootstrap.Modal(document.getElementById('reviewModal'));
        document.getElementById('modalReviewText').innerText = `"${text}"`;
        document.getElementById('modalUserName').innerText = name;
        document.getElementById('modalUserAvatar').innerText = name.substring(0,1).toUpperCase();
        
        const replySec = document.getElementById('modalReplySection');
        if (reply) {
            replySec.style.display = 'block';
            document.getElementById('modalReplyText').innerText = reply;
        } else {
            replySec.style.display = 'none';
        }
        
        modal.show();
    }
</script>
@endsection