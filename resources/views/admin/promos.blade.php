@extends('admin.layout')

@section('title', 'Kelola Promo')
@section('page_title', 'Kelola Promo & Banner')

@section('content')

<div class="row g-3">

  {{-- FORM TAMBAH PROMO --}}
  <div class="col-12 col-lg-4">
    <div class="card-panel">
      <h6 class="fw-bold mb-3" style="color:var(--dark);font-size:.9rem;">
        <i class="bi bi-plus-circle me-1" style="color:var(--primary)"></i> Tambah Promo Baru
      </h6>
      <form action="{{ route('admin.promos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
          <label class="form-label" style="font-size:.8rem;font-weight:600;">Judul Promo</label>
          <input type="text" name="judul" class="form-control form-control-sm" placeholder="Contoh: Promo Tahun Baru" required>
        </div>
        <div class="mb-3">
          <label class="form-label" style="font-size:.8rem;font-weight:600;">Upload Banner</label>
          <input type="file" name="gambar" class="form-control form-control-sm" accept="image/*" required id="promoFileInput">
          <small class="text-muted">JPG/PNG/WebP, maks 3MB. Ukuran ideal: 1200x400px</small>
          <div id="promoPreview" class="mt-2 d-none">
            <img id="promoPreviewImg" src="" alt="Preview" style="width:100%;height:120px;object-fit:cover;border-radius:.55rem;border:1px solid #e4e9f0;">
          </div>
        </div>
        <div class="row g-2 mb-3">
          <div class="col-6">
            <label class="form-label" style="font-size:.8rem;font-weight:600;">Tanggal Mulai</label>
            <input type="date" name="tanggal_mulai" class="form-control form-control-sm">
          </div>
          <div class="col-6">
            <label class="form-label" style="font-size:.8rem;font-weight:600;">Tanggal Selesai</label>
            <input type="date" name="tanggal_selesai" class="form-control form-control-sm">
          </div>
        </div>
        <div class="row g-2 mb-3">
          <div class="col-6">
            <label class="form-label" style="font-size:.8rem;font-weight:600;">Status</label>
            <select name="status" class="form-select form-select-sm">
              <option value="aktif">Aktif</option>
              <option value="nonaktif">Nonaktif</option>
            </select>
          </div>
          <div class="col-6">
            <label class="form-label" style="font-size:.8rem;font-weight:600;">Urutan</label>
            <input type="number" name="urutan" class="form-control form-control-sm" value="0" min="0">
          </div>
        </div>
        <button type="submit" class="btn btn-sm w-100 fw-bold" style="background:var(--primary);color:#fff;border-radius:.55rem;">
          <i class="bi bi-upload me-1"></i> Upload Promo
        </button>
      </form>
    </div>
  </div>

  {{-- DAFTAR PROMO --}}
  <div class="col-12 col-lg-8">
    <div class="section-card">
      <div class="section-head">
        <h6><i class="bi bi-megaphone me-1" style="color:var(--primary)"></i> Daftar Promo ({{ $promos->count() }})</h6>
      </div>

      @if($promos->isEmpty())
        <div class="text-center py-5 text-muted">
          <i class="bi bi-image" style="font-size:2rem;display:block;margin-bottom:.5rem;opacity:.3;"></i>
          Belum ada promo. Upload banner pertama kamu!
        </div>
      @else
        <div class="table-responsive">
          <table class="table mb-0">
            <thead>
              <tr>
                <th>BANNER</th>
                <th>JUDUL</th>
                <th>PERIODE</th>
                <th>STATUS</th>
                <th>URUTAN</th>
                <th>AKSI</th>
              </tr>
            </thead>
            <tbody>
              @foreach($promos as $promo)
              <tr>
                <td>
                  <img src="{{ asset('storage/'.$promo->gambar) }}" alt="{{ $promo->judul }}"
                    style="width:90px;height:50px;object-fit:cover;border-radius:.4rem;border:1px solid #e4e9f0;">
                </td>
                <td class="fw-semibold">{{ $promo->judul }}</td>
                <td style="font-size:.75rem;">
                  @if($promo->tanggal_mulai)
                    {{ $promo->tanggal_mulai->format('d M Y') }} —
                    {{ $promo->tanggal_selesai?->format('d M Y') ?? 'Selamanya' }}
                  @else
                    <span class="text-muted">Tidak terbatas</span>
                  @endif
                </td>
                <td>
                  <form action="{{ route('admin.promos.toggle', $promo) }}" method="POST" class="d-inline">
                    @csrf @method('PATCH')
                    <button type="submit" class="badge border-0 {{ $promo->status === 'aktif' ? 'bg-success' : 'bg-secondary' }}" style="cursor:pointer;">
                      {{ $promo->status === 'aktif' ? '✅ Aktif' : '⏸️ Nonaktif' }}
                    </button>
                  </form>
                </td>
                <td>{{ $promo->urutan }}</td>
                <td>
                  <button class="btn btn-sm btn-outline-warning btn-sm me-1"
                    onclick="editPromo({{ $promo->id }}, '{{ $promo->judul }}', '{{ $promo->status }}', '{{ $promo->tanggal_mulai?->format('Y-m-d') }}', '{{ $promo->tanggal_selesai?->format('Y-m-d') }}', {{ $promo->urutan }})">
                    <i class="bi bi-pencil"></i>
                  </button>
                  <form action="{{ route('admin.promos.destroy', $promo) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('Yakin hapus promo ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger">
                      <i class="bi bi-trash"></i>
                    </button>
                  </form>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @endif
    </div>
  </div>
</div>

{{-- MODAL EDIT --}}
<div class="modal fade" id="modalEdit" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header border-0">
        <h6 class="modal-title fw-bold">✏️ Edit Promo</h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form id="formEdit" method="POST" enctype="multipart/form-data">
        @csrf @method('PATCH')
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label" style="font-size:.8rem;font-weight:600;">Judul Promo</label>
            <input type="text" name="judul" id="editJudul" class="form-control form-control-sm" required>
          </div>
          <div class="mb-3">
            <label class="form-label" style="font-size:.8rem;font-weight:600;">Ganti Banner (opsional)</label>
            <input type="file" name="gambar" class="form-control form-control-sm" accept="image/*">
            <small class="text-muted">Kosongkan jika tidak ingin ganti banner</small>
          </div>
          <div class="row g-2 mb-3">
            <div class="col-6">
              <label class="form-label" style="font-size:.8rem;font-weight:600;">Tanggal Mulai</label>
              <input type="date" name="tanggal_mulai" id="editMulai" class="form-control form-control-sm">
            </div>
            <div class="col-6">
              <label class="form-label" style="font-size:.8rem;font-weight:600;">Tanggal Selesai</label>
              <input type="date" name="tanggal_selesai" id="editSelesai" class="form-control form-control-sm">
            </div>
          </div>
          <div class="row g-2">
            <div class="col-6">
              <label class="form-label" style="font-size:.8rem;font-weight:600;">Status</label>
              <select name="status" id="editStatus" class="form-select form-select-sm">
                <option value="aktif">Aktif</option>
                <option value="nonaktif">Nonaktif</option>
              </select>
            </div>
            <div class="col-6">
              <label class="form-label" style="font-size:.8rem;font-weight:600;">Urutan</label>
              <input type="number" name="urutan" id="editUrutan" class="form-control form-control-sm" min="0">
            </div>
          </div>
        </div>
        <div class="modal-footer border-0">
          <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-sm fw-bold px-3" style="background:var(--primary);color:#fff;">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
  // Preview upload
  document.getElementById('promoFileInput').addEventListener('change', function() {
    if (this.files && this.files[0]) {
      const reader = new FileReader();
      reader.onload = e => {
        document.getElementById('promoPreviewImg').src = e.target.result;
        document.getElementById('promoPreview').classList.remove('d-none');
      };
      reader.readAsDataURL(this.files[0]);
    }
  });

  // Edit promo
  function editPromo(id, judul, status, mulai, selesai, urutan) {
    document.getElementById('formEdit').action = `/admin/promos/${id}`;
    document.getElementById('editJudul').value = judul;
    document.getElementById('editStatus').value = status;
    document.getElementById('editMulai').value = mulai || '';
    document.getElementById('editSelesai').value = selesai || '';
    document.getElementById('editUrutan').value = urutan;
    new bootstrap.Modal(document.getElementById('modalEdit')).show();
  }
</script>
@endpush