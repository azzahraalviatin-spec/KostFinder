<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Kost - KostFinder</title>
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
    .section-card { background:#fff; border-radius:.85rem; border:1px solid #e4e9f0; box-shadow:0 2px 6px rgba(0,0,0,.04); overflow:hidden; }
    .section-head { padding:.9rem 1.2rem; border-bottom:1px solid #f0f3f8; display:flex; justify-content:space-between; align-items:center; }
    .section-head h6 { font-weight:700; color:var(--dark); margin:0; font-size:.87rem; }
    table thead th { font-size:.68rem; font-weight:700; color:#8fa3b8; letter-spacing:.05em; border:0; padding:.6rem 1rem; background:#f8fafd; }
    table tbody td { font-size:.8rem; color:#333; padding:.65rem 1rem; border-color:#f0f3f8; vertical-align:middle; }
    .btn-tambah { background:var(--primary); color:#fff; font-weight:700; border:0; border-radius:.55rem; padding:.42rem .9rem; font-size:.8rem; text-decoration:none; display:inline-flex; align-items:center; gap:.35rem; }
    .btn-tambah:hover { background:#cb3518; color:#fff; }
    .owner-footer { background:#fff; border-top:1px solid #e4e9f0; padding:.8rem 1.5rem; text-align:center; color:#8fa3b8; font-size:.72rem; }
  </style>
</head>
<body>

  @include('owner._sidebar')

  <div class="main" id="mainContent">

    @include('owner._navbar')

    <div class="content">

      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
          {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      @endif

      <div class="section-card">
        <div class="section-head">
          <h6><i class="bi bi-house me-1" style="color:var(--primary)"></i> Data Kost Saya</h6>
          <a href="{{ route('owner.kost.create') }}" class="btn-tambah">
            <i class="bi bi-plus-lg"></i> Tambah Kost
          </a>
        </div>

        <div class="table-responsive">
          <table class="table mb-0">
            <thead>
              <tr>
                <th>No</th>
                <th>FOTO</th>
                <th>NAMA KOST</th>
                <th>KOTA</th>
                <th>TIPE</th>
                <th>HARGA</th>
                <th>STATUS</th>
                <th>AKSI</th>
              </tr>
            </thead>
            <tbody>
              @forelse($kosts as $i => $kost)
              <tr>
                <td>{{ $i + 1 }}</td>
                <td>
                  @if($kost->foto_utama_url)
                    <img src="{{ $kost->foto_utama_url }}" width="70" class="rounded">
                  @else
                    <span class="text-muted">—</span>
                  @endif
                </td>
                <td class="fw-semibold">{{ $kost->nama_kost }}</td>
                <td>{{ $kost->kota }}</td>
                <td>{{ $kost->tipe_kost }}</td>
                <td>
  <div style="font-size:.78rem;">
    <div style="font-weight:700;color:#e8401c;">
      Rp {{ number_format($kost->harga_mulai, 0, ',', '.') }}
      @if($kost->harga_sampai)
        – Rp {{ number_format($kost->harga_sampai, 0, ',', '.') }}
      @endif
    </div>
    <div style="color:#8fa3b8;font-size:.7rem;">/bulan</div>
    @if($kost->ada_harian && $kost->harga_harian_mulai)
      <div style="margin-top:.25rem;color:#0369a1;font-weight:600;">
        Rp {{ number_format($kost->harga_harian_mulai, 0, ',', '.') }}
        @if($kost->harga_harian_sampai)
          – Rp {{ number_format($kost->harga_harian_sampai, 0, ',', '.') }}
        @endif
      </div>
      <div style="color:#8fa3b8;font-size:.7rem;">/hari</div>
    @endif
  </div>
</td>
                <td>
                  <span class="badge bg-{{ $kost->status == 'aktif' ? 'success' : 'secondary' }}">
                    {{ $kost->status }}
                  </span>
                </td>
                
                <td>
                <a href="{{ route('owner.kost.show', $kost->id_kost) }}" class="btn btn-sm btn-info text-white">
    <i class="bi bi-eye"></i>
  </a>
                  <a href="{{ route('owner.kost.edit', $kost->id_kost) }}" class="btn btn-sm btn-warning">
                    <i class="bi bi-pencil"></i> Edit
                  </a>
                  <form action="{{ route('owner.kost.destroy', $kost->id_kost) }}" method="POST" class="d-inline js-confirm-delete" data-delete-message="Anda yakin ingin menghapus kost ini?">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger" type="submit">
                      <i class="bi bi-trash"></i> Hapus
                    </button>
                  </form>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="8" class="text-center py-4 text-muted">
                  <i class="bi bi-house-add fs-3 d-block mb-2 opacity-25"></i>
                  Belum ada kost. <a href="{{ route('owner.kost.create') }}" style="color:var(--primary)">Tambah sekarang</a>
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

    </div>

    <footer class="owner-footer">
      © {{ date('Y') }} KostFinder — Panel Pemilik Kost. All rights reserved.
    </footer>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
  // Override search untuk filter tabel di halaman ini
  document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('globalSearch');
    if (!searchInput) return;

    // Clone input untuk hapus event listener lama dari navbar
    const newInput = searchInput.cloneNode(true);
    searchInput.parentNode.replaceChild(newInput, searchInput);

    newInput.addEventListener('input', function () {
      const keyword = this.value.toLowerCase().trim();
      const rows = document.querySelectorAll('tbody tr');

      // Sembunyikan dropdown popup
      document.getElementById('searchDropdown').style.display = 'none';

      rows.forEach(row => {
        const namaKost = row.querySelector('td:nth-child(3)')?.textContent.toLowerCase() || '';
        const kota     = row.querySelector('td:nth-child(4)')?.textContent.toLowerCase() || '';
        const tipe     = row.querySelector('td:nth-child(5)')?.textContent.toLowerCase() || '';

        row.style.display = (
          !keyword ||
          namaKost.includes(keyword) ||
          kota.includes(keyword) ||
          tipe.includes(keyword)
        ) ? '' : 'none';
      });
    });
  });
</script>
</body>
</html>
