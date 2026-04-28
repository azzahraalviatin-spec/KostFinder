@extends('layouts.owner')

@section('title', 'Kelola Kamar')

@push('styles')
<style>
    /* ── SUMMARY BAR ── */
    .kamar-summary { display:flex; gap:.75rem; margin-bottom:1.5rem; flex-wrap:wrap; }
    .sum-card { flex:1; min-width:130px; border-radius:1rem; padding:1rem 1.25rem; display:flex; align-items:center; gap:.85rem; border:1px solid transparent; }
    .sum-card.all    { background:#f8fafc; border-color:#e2e8f0; }
    .sum-card.avail  { background:#f0fdf4; border-color:#bbf7d0; }
    .sum-card.filled { background:#fef2f2; border-color:#fecaca; }
    .sum-icon { width:40px; height:40px; border-radius:.75rem; display:flex; align-items:center; justify-content:center; font-size:1.1rem; flex-shrink:0; }
    .sum-card.all    .sum-icon { background:#e2e8f0; color:#475569; }
    .sum-card.avail  .sum-icon { background:#bbf7d0; color:#16a34a; }
    .sum-card.filled .sum-icon { background:#fecaca; color:#dc2626; }
    .sum-num { font-size:1.4rem; font-weight:800; line-height:1; color:var(--dark); }
    .sum-lbl { font-size:.72rem; font-weight:600; color:#64748b; margin-top:2px; }

    /* ── KOST GROUP HEADER ── */
    .kost-group-header { display:flex; align-items:center; gap:.75rem; margin-bottom:1rem; margin-top:.5rem; }
    .kost-group-header .kost-label { font-size:1rem; font-weight:800; color:var(--dark); }
    .kost-group-header .kost-divider { flex:1; height:1px; background:#e4e9f0; }
    .kost-group-header .kost-count { font-size:.75rem; color:#8fa3b8; font-weight:600; }

    /* ── TIPE CARD ── */
    .tipe-card { background:#fff; border-radius:1.1rem; border:1px solid var(--line); overflow:hidden; transition:all .3s ease; height:100%; display:flex; flex-direction:column; position:relative; }
    .tipe-card:hover { transform:translateY(-5px); box-shadow:0 12px 30px rgba(0,0,0,.08); border-color:#e8401c44; }

    .tipe-img { height:180px; position:relative; overflow:hidden; background:#edf2f7; flex-shrink:0; }
    .tipe-img img { width:100%; height:100%; object-fit:cover; transition:.5s; }
    .tipe-card:hover .tipe-img img { transform:scale(1.06); }
    .no-img { width:100%; height:100%; display:flex; align-items:center; justify-content:center; color:#cbd5e1; font-size:2.5rem; }

    .status-badge { position:absolute; top:12px; right:12px; padding:.3rem .75rem; border-radius:999px; font-size:.65rem; font-weight:800; text-transform:uppercase; color:#fff; z-index:10; }
    .status-tersedia { background:#16a34a; }
    .status-habis    { background:#dc2626; }

    .tipe-body { padding:1.1rem 1.2rem; flex:1; display:flex; flex-direction:column; gap:.75rem; }
    .kost-tag  { font-size:.65rem; font-weight:700; color:var(--primary); text-transform:uppercase; letter-spacing:.06em; }
    .tipe-name { font-size:.95rem; font-weight:800; color:var(--dark); line-height:1.3; }
    .tipe-meta { display:flex; flex-wrap:wrap; gap:.6rem; }
    .meta-item { display:flex; align-items:center; gap:.3rem; font-size:.73rem; color:#64748b; font-weight:600; }
    .meta-item i { color:var(--primary); font-size:.8rem; }

    /* stok */
    .stok-wrap { background:#f8fafc; border:1px solid #f1f5f9; border-radius:.75rem; padding:.75rem; }
    .stok-top  { display:flex; justify-content:space-between; align-items:baseline; margin-bottom:.5rem; }
    .stok-angka { font-size:1.3rem; font-weight:800; color:var(--dark); line-height:1; }
    .stok-sub   { font-size:.7rem; color:#64748b; font-weight:500; }
    .stok-detail { font-size:.72rem; color:#64748b; font-weight:600; }
    .bar-track  { height:6px; background:#e2e8f0; border-radius:999px; overflow:hidden; }
    .bar-fill   { height:100%; border-radius:999px; transition:width .4s; }
    .bar-green  { background:#16a34a; }
    .bar-yellow { background:#d97706; }
    .bar-red    { background:#dc2626; }

    /* harga */
    .harga-box   { margin-top:auto; }
    .harga-label { font-size:.62rem; color:#8fa3b8; font-weight:700; text-transform:uppercase; margin-bottom:2px; }
    .harga-val   { font-size:1.05rem; font-weight:800; color:var(--dark); }
    .harga-unit  { font-size:.7rem; color:#8fa3b8; font-weight:500; }

    /* footer */
    .tipe-footer { padding:.9rem 1.2rem; border-top:1px dashed var(--line); display:flex; gap:.5rem; }
    .btn-action  { flex:1; height:36px; border-radius:.65rem; display:flex; align-items:center; justify-content:center; gap:.35rem; font-size:.76rem; font-weight:700; text-decoration:none; transition:.2s; border:none; cursor:pointer; }
    .btn-manage  { background:#fef3c7; color:#92400e; }
    .btn-manage:hover { background:#fde68a; }
    .btn-add     { background:#eff6ff; color:#1e40af; flex:0 0 auto; padding:0 .9rem; }
    .btn-add:hover { background:#dbeafe; }

    /* empty */
    .empty-state { padding:5rem 2rem; text-align:center; background:#fff; border-radius:1.5rem; border:2px dashed var(--line); }
    .empty-icon  { width:80px; height:80px; background:#fff5f2; color:var(--primary); border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:2.5rem; margin:0 auto 1.5rem; }
</style>
@endpush

@section('content')

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4 border-0 shadow-sm"
             style="border-radius:1rem;background:#f0fdf4;color:#166534;" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- HEADER --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h4 class="fw-800 mb-1" style="color:var(--dark);letter-spacing:-0.02em;">Kelola Kamar Kost</h4>
            <p class="text-muted mb-0" style="font-size:.85rem;">Manajemen stok kamar, harga, dan status ketersediaan.</p>
        </div>
        <a href="{{ route('owner.kamar.create') }}"
           class="btn btn-primary d-inline-flex align-items-center gap-2 px-4 shadow-sm"
           style="background:linear-gradient(135deg,#e8401c,#ff7043);border:none;border-radius:.8rem;height:48px;font-weight:700;font-size:.88rem;">
            <i class="bi bi-plus-lg"></i> Tambah Kamar Baru
        </a>
    </div>

    {{-- SUMMARY BAR --}}
    @php
        $totalKamar    = $rooms->count();
        $totalTersedia = $rooms->where('status_kamar','tersedia')->count();
        $totalTerisi   = $rooms->where('status_kamar','terisi')->count();
    @endphp

    @if($totalKamar > 0)
    <div class="kamar-summary">
        <div class="sum-card all">
            <div class="sum-icon"><i class="bi bi-door-open"></i></div>
            <div><div class="sum-num">{{ $totalKamar }}</div><div class="sum-lbl">Total Kamar</div></div>
        </div>
        <div class="sum-card avail">
            <div class="sum-icon"><i class="bi bi-check-circle"></i></div>
            <div><div class="sum-num">{{ $totalTersedia }}</div><div class="sum-lbl">Kamar Tersedia</div></div>
        </div>
        <div class="sum-card filled">
            <div class="sum-icon"><i class="bi bi-person-fill"></i></div>
            <div><div class="sum-num">{{ $totalTerisi }}</div><div class="sum-lbl">Kamar Terisi</div></div>
        </div>
    </div>
    @endif

    {{-- GROUP PER KOST → PER TIPE --}}
    @forelse($rooms->groupBy('kost_id') as $kostId => $roomsPerKost)
        @php $namaKost = $roomsPerKost->first()->kost->nama_kost ?? 'Kost'; @endphp

        <div class="kost-group-header">
            <i class="bi bi-building" style="color:var(--primary);font-size:1rem;"></i>
            <span class="kost-label">{{ $namaKost }}</span>
            <span class="kost-count">{{ $roomsPerKost->count() }} kamar</span>
            <div class="kost-divider"></div>
        </div>

        <div class="row g-4 mb-4">
        @foreach($roomsPerKost->groupBy('tipe_kamar') as $tipe => $roomsPerTipe)
            @php
                $jmlTersedia = $roomsPerTipe->where('status_kamar','tersedia')->count();
                $jmlTerisi   = $roomsPerTipe->where('status_kamar','terisi')->count();
                $jmlTotal    = $roomsPerTipe->count();
                $persen      = $jmlTotal > 0 ? ($jmlTersedia / $jmlTotal) * 100 : 0;
                $barClass    = $persen >= 60 ? 'bar-green' : ($persen >= 30 ? 'bar-yellow' : 'bar-red');
                $rep         = $roomsPerTipe->first();
                $image       = $rep->mainImage ?? $rep->images->where('tipe_foto','kamar')->first();
                $fasilitas   = is_array($rep->fasilitas) ? $rep->fasilitas : [];
                $modalId     = 'modal_'.$kostId.'_'.Str::slug($tipe ?: 'standard');
            @endphp

            <div class="col-12 col-md-6 col-xl-4">
                <div class="tipe-card">

                    {{-- FOTO --}}
                    <div class="tipe-img">
                        @if($image)
                            <img src="{{ asset('storage/'.$image->foto_path) }}" alt="Tipe {{ $tipe }}">
                        @else
                            <div class="no-img"><i class="bi bi-door-open"></i></div>
                        @endif
                        <span class="status-badge {{ $jmlTersedia > 0 ? 'status-tersedia' : 'status-habis' }}">
                            {{ $jmlTersedia > 0 ? 'Tersedia' : 'Penuh' }}
                        </span>
                    </div>

                    {{-- BODY --}}
                    <div class="tipe-body">
                        <div>
                            <div class="kost-tag">{{ $namaKost }}</div>
                            <div class="tipe-name">Tipe {{ $tipe ?: 'Standard' }}</div>
                        </div>

                        <div class="tipe-meta">
                            @if($rep->ukuran)
                                <div class="meta-item"><i class="bi bi-arrows-fullscreen"></i> {{ $rep->ukuran }}</div>
                            @endif
                            <div class="meta-item"><i class="bi bi-lightning-charge"></i> {{ $rep->listrik ?? 'Termasuk' }}</div>
                            @if(count($fasilitas))
                                <div class="meta-item"><i class="bi bi-grid"></i> {{ count($fasilitas) }} fasilitas</div>
                            @endif
                        </div>

                        {{-- STOK BAR --}}
                        <div class="stok-wrap">
                            <div class="stok-top">
                                <div>
                                    <span class="stok-angka">{{ $jmlTersedia }}</span>
                                    <span class="stok-sub"> / {{ $jmlTotal }} kamar tersedia</span>
                                </div>
                                <span class="stok-detail">{{ $jmlTerisi }} terisi</span>
                            </div>
                            <div class="bar-track">
                                <div class="bar-fill {{ $barClass }}" style="width:{{ $persen }}%;"></div>
                            </div>
                        </div>

                        {{-- HARGA --}}
                        <div class="harga-box">
                            <div class="harga-label">Harga Sewa</div>
                            <div class="harga-val">
                                Rp {{ number_format($rep->harga_per_bulan, 0, ',', '.') }}
                                <span class="harga-unit">/bln</span>
                            </div>
                            @if($rep->harga_harian)
                                <div style="font-size:.72rem;font-weight:600;color:#0369a1;margin-top:2px;">
                                    Rp {{ number_format($rep->harga_harian, 0, ',', '.') }}
                                    <span class="harga-unit">/hari</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- FOOTER --}}
                    <div class="tipe-footer">
                        <button type="button" class="btn-action btn-manage"
                                data-bs-toggle="modal" data-bs-target="#{{ $modalId }}">
                            <i class="bi bi-list-ul"></i> Kelola {{ $jmlTotal }} Kamar
                        </button>
                        <a href="{{ route('owner.kamar.create') }}"
                           class="btn-action btn-add" title="Tambah kamar tipe ini">
                            <i class="bi bi-plus-lg"></i>
                        </a>
                    </div>
                </div>
            </div>

            {{-- MODAL LIST KAMAR --}}
            <div class="modal fade" id="{{ $modalId }}" tabindex="-1">
                <div class="modal-dialog modal-dialog-scrollable modal-lg">
                    <div class="modal-content border-0 rounded-4 shadow">
                        <div class="modal-header border-0 pb-0">
                            <div>
                                <h5 class="fw-800 mb-0" style="font-size:1rem;">
                                    Kamar Tipe {{ $tipe ?: 'Standard' }}
                                </h5>
                                <p class="text-muted mb-0" style="font-size:.78rem;">
                                    {{ $namaKost }} &bull; {{ $jmlTotal }} kamar &bull;
                                    <span style="color:#16a34a;font-weight:700;">{{ $jmlTersedia }} tersedia</span> &bull;
                                    <span style="color:#dc2626;font-weight:700;">{{ $jmlTerisi }} terisi</span>
                                </p>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body pt-2">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0" style="font-size:.82rem;">
                                    <thead style="background:#f8fafd;">
                                        <tr>
                                            <th style="font-size:.68rem;color:#8fa3b8;font-weight:700;border:0;padding:.6rem 1rem;">NO. KAMAR</th>
                                            <th style="font-size:.68rem;color:#8fa3b8;font-weight:700;border:0;padding:.6rem 1rem;">STATUS</th>
                                            <th style="font-size:.68rem;color:#8fa3b8;font-weight:700;border:0;padding:.6rem 1rem;">HARGA</th>
                                            <th style="font-size:.68rem;color:#8fa3b8;font-weight:700;border:0;padding:.6rem 1rem;text-align:right;">AKSI</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($roomsPerTipe as $room)
                                        <tr>
                                            <td class="fw-700" style="color:var(--dark);padding:.65rem 1rem;">
                                                <i class="bi bi-door-closed me-1" style="color:var(--primary);"></i>
                                                Kamar {{ $room->nomor_kamar }}
                                            </td>
                                            <td style="padding:.65rem 1rem;">
                                                @if($room->status_kamar === 'tersedia')
                                                    <span style="background:#f0fdf4;color:#16a34a;padding:.2rem .7rem;border-radius:999px;font-size:.68rem;font-weight:700;">
                                                        Tersedia
                                                    </span>
                                                @else
                                                    <span style="background:#fef2f2;color:#dc2626;padding:.2rem .7rem;border-radius:999px;font-size:.68rem;font-weight:700;">
                                                        Terisi
                                                    </span>
                                                @endif
                                            </td>
                                            <td style="font-weight:700;padding:.65rem 1rem;">
                                                Rp {{ number_format($room->harga_per_bulan,0,',','.') }}/bln
                                            </td>
                                            <td style="padding:.65rem 1rem;">
                                                <div class="d-flex gap-1 justify-content-end">
                                                    <a href="{{ route('owner.kamar.show', $room->id_room) }}"
                                                       class="btn btn-sm" style="background:#eff6ff;color:#1e40af;border:0;border-radius:.5rem;font-size:.72rem;font-weight:700;">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <a href="{{ route('owner.kamar.edit', $room->id_room) }}"
                                                       class="btn btn-sm" style="background:#fef3c7;color:#92400e;border:0;border-radius:.5rem;font-size:.72rem;font-weight:700;">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <form action="{{ route('owner.kamar.destroy', $room->id_room) }}"
                                                          method="POST"
                                                          onsubmit="return confirm('Hapus kamar {{ $room->nomor_kamar }}?')">
                                                        @csrf @method('DELETE')
                                                        <button class="btn btn-sm" style="background:#fef2f2;color:#dc2626;border:0;border-radius:.5rem;font-size:.72rem;font-weight:700;">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- END MODAL --}}

        @endforeach
        </div>{{-- /row --}}

    @empty
        <div class="empty-state">
            <div class="empty-icon"><i class="bi bi-door-closed"></i></div>
            <h5 class="fw-800" style="color:var(--dark);">Belum Ada Kamar</h5>
            <p class="text-muted mx-auto" style="max-width:400px;font-size:.9rem;">
                Kamu belum menambahkan data kamar. Calon penyewa butuh melihat info kamar untuk mulai memesan.
            </p>
            <a href="{{ route('owner.kamar.create') }}"
               class="btn btn-primary mt-3 px-4 rounded-3 fw-700"
               style="background:var(--primary);border:none;">
                Buat Kamar Pertama
            </a>
        </div>
    @endforelse

@endsection