<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kelola Kamar - KostFinder</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    :root { --sidebar-w:200px; --sidebar-col:60px; --primary:#e8401c; --dark:#1e2d3d; --bg:#f0f4f8; }
    * { margin:0; padding:0; box-sizing:border-box; }
    body { font-family:'Plus Jakarta Sans',sans-serif; background:var(--bg); display:flex; min-height:100vh; }
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
    .main { margin-left:var(--sidebar-w); flex:1; transition:margin-left .3s ease; display:flex; flex-direction:column; }
    .main.collapsed { margin-left:var(--sidebar-col); }
    .topbar { background:#fff; height:60px; padding:0 1.5rem; display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid #e4e9f0; position:sticky; top:0; z-index:100; }
    .topbar-left h5 { font-size:.98rem; font-weight:800; color:var(--dark); margin:0; }
    .topbar-left p { font-size:.72rem; color:#8fa3b8; margin:0; }
    .topbar-right { display:flex; align-items:center; gap:.6rem; }
    .search-box { display:flex; align-items:center; gap:.5rem; background:#f0f4f8; border:1px solid #dde3ed; border-radius:.55rem; padding:.38rem .75rem; width:180px; }
    .search-box input { border:0; background:none; outline:none; font-size:.8rem; color:#333; width:100%; }
    .icon-btn { width:34px; height:34px; border-radius:.5rem; background:#f0f4f8; border:1px solid #dde3ed; display:flex; align-items:center; justify-content:center; color:#555; font-size:.9rem; cursor:pointer; text-decoration:none; }
    .icon-btn:hover { background:#e4e9f0; color:#333; }
    .content { padding:1.4rem; flex:1; }
    .owner-footer { background:#fff; border-top:1px solid #e4e9f0; padding:.8rem 1.5rem; text-align:center; color:#8fa3b8; font-size:.72rem; }

    /* KAMAR CARD */
    .kamar-card { background:#fff; border-radius:14px; border:1px solid #e4e9f0; overflow:hidden; transition:transform .2s, box-shadow .2s; height:100%; display:flex; flex-direction:column; }
    .kamar-card:hover { transform:translateY(-3px); box-shadow:0 8px 24px rgba(0,0,0,.09); }
    .kamar-card-img { position:relative; height:155px; overflow:hidden; background:#f0f4f8; }
    .kamar-card-img img { width:100%; height:100%; object-fit:cover; }
    .kamar-card-img .no-img { width:100%; height:100%; display:flex; align-items:center; justify-content:center; color:#c0cfe0; font-size:2.5rem; }
    .kamar-card-img .status-badge { position:absolute; top:10px; right:10px; font-size:.68rem; font-weight:700; padding:3px 10px; border-radius:99px; }
    .kamar-card-img .nomor-badge { position:absolute; top:10px; left:10px; font-size:.75rem; font-weight:700; padding:3px 12px; border-radius:99px; background:rgba(30,45,61,.8); color:#fff; }
    .kamar-card-body { padding:.9rem 1rem; flex:1; display:flex; flex-direction:column; gap:4px; }
    .kamar-kost-name { font-size:.72rem; color:#8fa3b8; display:flex; align-items:center; gap:4px; margin-bottom:2px; }
    .kamar-nomor { font-size:1rem; font-weight:800; color:var(--dark); }
    .kamar-price { font-size:.88rem; font-weight:700; color:var(--primary); margin-top:4px; }
    .kamar-price-sub { font-size:.68rem; color:#8fa3b8; }
    .kamar-price-daily { font-size:.8rem; font-weight:600; color:#0369a1; margin-top:2px; }
    .kamar-info { display:flex; gap:.5rem; margin-top:.6rem; flex-wrap:wrap; }
    .kamar-tag { font-size:.68rem; background:#f0f4f8; color:#64748b; border-radius:6px; padding:3px 8px; display:flex; align-items:center; gap:3px; }
    .kamar-card-footer { padding:.75rem 1rem; border-top:1px solid #f0f4f8; display:flex; gap:.4rem; }
    .btn-aksi { flex:1; font-size:.75rem; font-weight:600; border-radius:8px; padding:.38rem .5rem; border:0; text-align:center; text-decoration:none; display:inline-flex; align-items:center; justify-content:center; gap:4px; transition:opacity .15s; }
    .btn-aksi:hover { opacity:.85; }
    .btn-lihat { background:#e0f2fe; color:#0369a1; }
    .btn-edit { background:#fef3c7; color:#92400e; }
    .btn-hapus { background:#fee2e2; color:#991b1b; cursor:pointer; }

    /* Tambah card */
    .kamar-card-add { background:#fff; border-radius:14px; border:2px dashed #d1dce9; height:100%; min-height:260px; display:flex; flex-direction:column; align-items:center; justify-content:center; gap:.75rem; text-decoration:none; transition:all .2s; }
    .kamar-card-add:hover { border-color:var(--primary); background:#fff5f3; }
    .kamar-card-add .add-icon { width:52px; height:52px; border-radius:50%; background:#fee2d5; display:flex; align-items:center; justify-content:center; font-size:1.4rem; color:var(--primary); }
    .kamar-card-add span { font-size:.85rem; font-weight:700; color:var(--primary); }

    /* Filter */
    .filter-btn { border:1px solid #e4e9f0; background:#fff; border-radius:99px; padding:5px 14px; font-size:.78rem; cursor:pointer; color:#64748b; transition:all .15s; }
    .filter-btn.active { background:var(--primary); border-color:var(--primary); color:#fff; font-weight:600; }

    /* Group header */
    .group-header { font-size:.8rem; font-weight:700; color:var(--dark); padding:.4rem .2rem; margin-bottom:.25rem; display:flex; align-items:center; gap:.5rem; }
    .group-header::after { content:''; flex:1; height:1px; background:#e4e9f0; }
  </style>
</head>
<body>

  @include('owner._sidebar')

  <div class="main" id="mainContent">
    @include('owner._navbar')

    <div class="content">

      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3 rounded-3" role="alert">
          <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      @endif

      {{-- HEADER --}}
      <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
          <h5 class="fw-bold mb-0" style="color:var(--dark);">Kelola Kamar</h5>
          <p class="text-muted small mb-0">{{ $rooms->count() }} kamar terdaftar</p>
        </div>
        <div class="d-flex gap-2 align-items-center flex-wrap">
          {{-- Filter status --}}
          <div class="d-none d-md-flex gap-2">
            <button class="filter-btn active" onclick="filterKamar(this,'semua')">Semua</button>
            <button class="filter-btn" onclick="filterKamar(this,'tersedia')">Tersedia</button>
            <button class="filter-btn" onclick="filterKamar(this,'terisi')">Terisi</button>
          </div>
          <a href="{{ route('owner.kamar.create') }}" class="btn fw-bold rounded-3 px-3" style="background:var(--primary);color:#fff;font-size:.82rem;">
            <i class="bi bi-plus-lg me-1"></i> Tambah Kamar
          </a>
        </div>
      </div>

      {{-- GROUP BY KOST --}}
      @php $grouped = $rooms->groupBy(fn($r) => $r->kost->nama_kost ?? 'Lainnya'); @endphp

      @foreach($grouped as $namaKost => $kamarList)
        <div class="group-header mb-2 mt-3">
          <i class="bi bi-house-fill" style="color:var(--primary);font-size:.85rem;"></i>
          {{ $namaKost }}
          <span class="badge rounded-pill" style="background:#f0f4f8;color:#64748b;font-size:.68rem;font-weight:600;">{{ $kamarList->count() }} kamar</span>
        </div>

        <div class="row g-3 mb-2" id="kamarGrid">
          @foreach($kamarList as $room)
          <div class="col-12 col-sm-6 col-lg-3 kamar-item" data-status="{{ $room->status_kamar }}" data-nama="{{ strtolower($room->kost->nama_kost ?? '') }} {{ strtolower($room->nomor_kamar) }}">
            <div class="kamar-card">

              {{-- Foto --}}
              <div class="kamar-card-img">
                @if($room->mainImage?->foto_path)
                  <img src="{{ '/storage/'.ltrim($room->mainImage->foto_path, '/') }}" alt="Foto kamar">
                @else
                  <div class="no-img"><i class="bi bi-door-open"></i></div>
                @endif
                <span class="nomor-badge">{{ $room->nomor_kamar }}</span>
                <span class="status-badge {{ $room->status_kamar === 'tersedia' ? 'bg-success' : 'bg-danger' }} text-white">
                  {{ ucfirst($room->status_kamar) }}
                </span>
              </div>

              {{-- Body --}}
              <div class="kamar-card-body">
                <div class="kamar-kost-name">
                  <i class="bi bi-house" style="font-size:.7rem;color:var(--primary);"></i>
                  {{ $room->kost->nama_kost ?? '—' }}
                </div>
                <div class="kamar-nomor">{{ $room->nomor_kamar }}</div>

                {{-- Harga --}}
                <div class="mt-1">
                  @if($room->aktif_bulanan && $room->harga_per_bulan)
                    <div class="kamar-price">Rp {{ number_format($room->harga_per_bulan, 0, ',', '.') }}</div>
                    <div class="kamar-price-sub">/bulan</div>
                  @endif
                  @if($room->aktif_harian && $room->harga_harian)
                    <div class="kamar-price-daily">Rp {{ number_format($room->harga_harian, 0, ',', '.') }} <span style="font-weight:400;color:#8fa3b8;font-size:.68rem;">/hari</span></div>
                  @endif
                  @if(!$room->harga_per_bulan && !$room->harga_harian)
                    <div class="kamar-price-sub">Harga belum diatur</div>
                  @endif
                </div>

                {{-- Info tambahan --}}
                <div class="kamar-info">
                  @if($room->tipe_kamar)
                    <span class="kamar-tag"><i class="bi bi-tag" style="font-size:.65rem;"></i>{{ $room->tipe_kamar }}</span>
                  @endif
                  @if($room->listrik)
                    <span class="kamar-tag"><i class="bi bi-lightning-charge" style="font-size:.65rem;"></i>{{ $room->listrik }}</span>
                  @endif
                  @if($room->luas_kamar)
                    <span class="kamar-tag"><i class="bi bi-arrows-angle-expand" style="font-size:.65rem;"></i>{{ $room->luas_kamar }} m²</span>
                  @endif
                  @if($room->kapasitas)
                    <span class="kamar-tag"><i class="bi bi-people" style="font-size:.65rem;"></i>{{ $room->kapasitas }} org</span>
                  @endif
                </div>
              </div>

              {{-- Footer Aksi --}}
              <div class="kamar-card-footer">
                <a href="{{ route('owner.kamar.show', $room->id_room) }}" class="btn-aksi btn-lihat">
                  <i class="bi bi-eye"></i> Lihat
                </a>
                <a href="{{ route('owner.kamar.edit', $room->id_room) }}" class="btn-aksi btn-edit">
                  <i class="bi bi-pencil"></i> Edit
                </a>
                <form action="{{ route('owner.kamar.destroy', $room->id_room) }}" method="POST" class="js-confirm-delete" style="flex:1;" data-delete-message="Yakin ingin menghapus kamar {{ $room->nomor_kamar }}?">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn-aksi btn-hapus w-100">
                    <i class="bi bi-trash"></i> Hapus
                  </button>
                </form>
              </div>

            </div>
          </div>
          @endforeach

          {{-- Card tambah kamar --}}
          <div class="col-12 col-sm-6 col-lg-3">
            <a href="{{ route('owner.kamar.create') }}" class="kamar-card-add">
              <div class="add-icon"><i class="bi bi-plus-lg"></i></div>
              <span>Tambah Kamar</span>
              <p class="text-muted small mb-0">di {{ $namaKost }}</p>
            </a>
          </div>

        </div>
      @endforeach

      @if($rooms->isEmpty())
        <div class="text-center py-5 text-muted">
          <i class="bi bi-door-open" style="font-size:3rem;opacity:.2;"></i>
          <p class="mt-2">Belum ada kamar. <a href="{{ route('owner.kamar.create') }}" style="color:var(--primary)">Tambah sekarang</a></p>
        </div>
      @endif

      <div id="empty-filter" class="text-center py-4 text-muted small" style="display:none;">
        <i class="bi bi-search" style="font-size:2rem;opacity:.3;"></i>
        <p class="mt-2">Tidak ada kamar dengan filter ini</p>
      </div>

    </div>

    <footer class="owner-footer">
      &copy; {{ date('Y') }} KostFinder - Panel Pemilik Kost. All rights reserved.
    </footer>
  </div>

  {{-- Modal konfirmasi hapus --}}
  <div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
      <div class="modal-content rounded-4 border-0 shadow">
        <div class="modal-body text-center p-4">
          <div style="width:52px;height:52px;border-radius:50%;background:#fee2e2;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;">
            <i class="bi bi-trash" style="font-size:1.3rem;color:#991b1b;"></i>
          </div>
          <h6 class="fw-bold mb-1">Hapus Kamar?</h6>
          <p class="text-muted small mb-3" id="deleteMsg">Tindakan ini tidak bisa dibatalkan.</p>
          <div class="d-flex gap-2">
            <button class="btn btn-sm btn-secondary rounded-3 flex-fill" data-bs-dismiss="modal">Batal</button>
            <button class="btn btn-sm btn-danger rounded-3 flex-fill" id="deleteConfirmBtn">Hapus</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function toggleSidebar() {
      document.getElementById('sidebar').classList.toggle('collapsed');
      document.getElementById('mainContent').classList.toggle('collapsed');
    }

    // Filter status
    function filterKamar(btn, status) {
      document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      let visible = 0;
      document.querySelectorAll('.kamar-item').forEach(item => {
        const s = item.dataset.status;
        const show = status === 'semua' || s === status;
        item.style.display = show ? '' : 'none';
        if (show) visible++;
      });
      document.getElementById('empty-filter').style.display = visible === 0 ? 'block' : 'none';
    }

    // Modal hapus
    let deleteForm = null;
    document.querySelectorAll('.js-confirm-delete').forEach(form => {
      form.addEventListener('submit', function (e) {
        e.preventDefault();
        deleteForm = this;
        document.getElementById('deleteMsg').textContent = this.dataset.deleteMessage || 'Tindakan ini tidak bisa dibatalkan.';
        new bootstrap.Modal(document.getElementById('deleteModal')).show();
      });
    });
    document.getElementById('deleteConfirmBtn').addEventListener('click', function () {
      if (deleteForm) deleteForm.submit();
    });

    // Search dari navbar
    document.addEventListener('DOMContentLoaded', function () {
      const searchInput = document.getElementById('globalSearch');
      if (!searchInput) return;
      const newInput = searchInput.cloneNode(true);
      searchInput.parentNode.replaceChild(newInput, searchInput);
      newInput.addEventListener('input', function () {
        const keyword = this.value.toLowerCase().trim();
        document.getElementById('searchDropdown').style.display = 'none';
        let visible = 0;
        document.querySelectorAll('.kamar-item').forEach(item => {
          const nama = item.dataset.nama || '';
          const show = !keyword || nama.includes(keyword);
          item.style.display = show ? '' : 'none';
          if (show) visible++;
        });
        document.getElementById('empty-filter').style.display = visible === 0 ? 'block' : 'none';
      });
    });
  </script>
</body>
</html>