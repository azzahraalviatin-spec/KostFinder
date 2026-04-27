@extends('layouts.owner')

@section('title', 'Kelola Kamar')

@push('styles')
<style>
    /* ── ROOM CARD ── */
    .room-card { background:#fff; border-radius:1.1rem; border:1px solid var(--line); overflow:hidden; transition:all .3s ease; height:100%; display:flex; flex-direction:column; position:relative; }
    .room-card:hover { transform:translateY(-5px); box-shadow:0 12px 30px rgba(0,0,0,.08); border-color:var(--primary-mid); }
    
    .room-img { height:180px; position:relative; overflow:hidden; background:#edf2f7; }
    .room-img img { width:100%; height:100%; object-fit:cover; transition:.5s; }
    .room-card:hover .room-img img { transform:scale(1.08); }
    .no-img { width:100%; height:100%; display:flex; align-items:center; justify-content:center; color:#cbd5e1; font-size:2.5rem; }

    .status-badge { position:absolute; top:12px; right:12px; padding:.35rem .8rem; border-radius:999px; font-size:.68rem; font-weight:800; text-transform:uppercase; letter-spacing:.04em; color:#fff; box-shadow:0 4px 10px rgba(0,0,0,.1); z-index:10; }
    .status-tersedia { background:#16a34a; }
    .status-terisi { background:#dc2626; }

    .room-body { padding:1.25rem; flex:1; display:flex; flex-direction:column; }
    .kost-tag { font-size:.68rem; font-weight:700; color:var(--primary); text-transform:uppercase; letter-spacing:.05em; margin-bottom:.3rem; display:block; }
    .room-title { font-size:.95rem; font-weight:800; color:var(--dark); margin-bottom:.5rem; line-height:1.4; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
    
    .room-meta { display:flex; flex-wrap:wrap; gap:.75rem; margin-bottom:1rem; }
    .meta-item { display:flex; align-items:center; gap:.35rem; font-size:.75rem; color:var(--muted); font-weight:600; }
    .meta-item i { color:var(--primary); font-size:.85rem; }

    .price-box { background:#f8fafc; border:1px solid #f1f5f9; border-radius:.8rem; padding:.75rem; margin-top:auto; }
    .price-label { font-size:.65rem; color:var(--muted); font-weight:700; text-transform:uppercase; margin-bottom:2px; }
    .price-val { font-size:1.05rem; font-weight:800; color:var(--dark); }
    .price-unit { font-size:.72rem; color:var(--muted); font-weight:500; }

    .room-footer { padding:1rem 1.25rem; border-top:1px dashed var(--line); display:flex; gap:.6rem; }
    .btn-action { flex:1; height:38px; border-radius:.7rem; display:flex; align-items:center; justify-content:center; gap:.4rem; font-size:.78rem; font-weight:700; text-decoration:none; transition:.2s; border:none; }
    .btn-edit { background:#fef3c7; color:#92400e; }
    .btn-edit:hover { background:#fde68a; }
    .btn-detail { background:#eff6ff; color:#1e40af; }
    .btn-detail:hover { background:#dbeafe; }
    .btn-delete { background:#fef2f2; color:#dc2626; cursor:pointer; }
    .btn-delete:hover { background:#fee2e2; }

    /* ── EMPTY STATE ── */
    .empty-state { padding:5rem 2rem; text-align:center; background:#fff; border-radius:1.5rem; border:2px dashed var(--line); margin-top:1rem; }
    .empty-icon { width:80px; height:80px; background:var(--primary-light); color:var(--primary); border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:2.5rem; margin:0 auto 1.5rem; }
</style>
@endpush

@section('content')
      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4 border-0 shadow-sm" style="border-radius:1rem; background:#f0fdf4; color:#166534;" role="alert">
          <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif

      {{-- HEADER --}}
      <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
          <h4 class="fw-800 mb-1" style="color:var(--dark); letter-spacing:-0.02em;">Kelola Kamar Kost</h4>
          <p class="text-muted mb-0" style="font-size:.85rem;">Manajemen stok kamar, harga, dan status ketersediaan.</p>
        </div>
        <a href="{{ route('owner.kamar.create') }}" class="btn btn-primary d-inline-flex align-items-center gap-2 px-4 shadow-sm" 
           style="background:linear-gradient(135deg, #e8401c, #ff7043); border:none; border-radius:.8rem; height:48px; font-weight:700; font-size:.88rem;">
          <i class="bi bi-plus-lg"></i> Tambah Kamar Baru
        </a>
      </div>

      {{-- LIST KAMAR --}}
      <div class="row g-4">
        @forelse($rooms as $room)
          <div class="col-12 col-md-6 col-xl-4">
            <div class="room-card">
              <span class="status-badge {{ $room->status_kamar == 'tersedia' ? 'status-tersedia' : 'status-terisi' }}">
                {{ $room->status_kamar }}
              </span>

              <div class="room-img">
                @php
                  $image = $room->mainImage ?? $room->images->where('tipe_foto', 'kamar')->first();
                @endphp
                @if($image)
                  <img src="{{ asset('storage/' . $image->foto_path) }}" alt="Kamar {{ $room->nomor_kamar }}">
                @else
                  <div class="no-img"><i class="bi bi-door-open"></i></div>
                @endif
              </div>

              <div class="room-body">
                <span class="kost-tag">{{ $room->kost->nama_kost }}</span>
                <div class="room-title">Kamar {{ $room->nomor_kamar }} ({{ $room->tipe_kamar }})</div>
                
                <div class="room-meta">
                  @if($room->ukuran)
                    <div class="meta-item"><i class="bi bi-arrows-fullscreen"></i> {{ $room->ukuran }}</div>
                  @endif
                  <div class="meta-item"><i class="bi bi-lightning-charge"></i> {{ $room->listrik ?? 'Termasuk' }}</div>
                </div>

                <div class="price-box">
                  <div class="price-label">Harga Sewa</div>
                  <div class="price-val">
                    Rp {{ number_format($room->harga_per_bulan, 0, ',', '.') }}
                    <span class="price-unit">/bln</span>
                  </div>
                  @if($room->harga_harian)
                    <div style="font-size:.72rem; font-weight:600; color:#0369a1; margin-top:2px;">
                      Rp {{ number_format($room->harga_harian, 0, ',', '.') }} <span class="price-unit">/hari</span>
                    </div>
                  @endif
                </div>
              </div>

              <div class="room-footer">
                <a href="{{ route('owner.kamar.show', $room->id_room) }}" class="btn-action btn-detail" title="Lihat Detail">
                  <i class="bi bi-eye"></i> Detail
                </a>
                <a href="{{ route('owner.kamar.edit', $room->id_room) }}" class="btn-action btn-edit" title="Edit Kamar">
                  <i class="bi bi-pencil-square"></i> Edit
                </a>
                <form action="{{ route('owner.kamar.destroy', $room->id_room) }}" method="POST" class="flex-1" onsubmit="return confirm('Yakin ingin menghapus kamar ini?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn-action btn-delete w-100" title="Hapus Kamar">
                    <i class="bi bi-trash"></i>
                  </button>
                </form>
              </div>
            </div>
          </div>
        @empty
          <div class="col-12">
            <div class="empty-state">
              <div class="empty-icon"><i class="bi bi-door-closed"></i></div>
              <h5 class="fw-800" style="color:var(--dark);">Belum Ada Kamar</h5>
              <p class="text-muted mx-auto" style="max-width:400px; font-size:.9rem;">
                Kamu belum menambahkan data kamar untuk kost kamu. Calon penyewa butuh melihat info kamar untuk mulai memesan.
              </p>
              <a href="{{ route('owner.kamar.create') }}" class="btn btn-primary mt-3 px-4 rounded-3 fw-700" style="background:var(--primary); border:none;">
                Buat Kamar Pertama
              </a>
            </div>
          </div>
        @endforelse
      </div>
@endsection
