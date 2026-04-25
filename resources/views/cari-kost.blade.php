<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cari Kos - KosKu</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <style>
        :root { --primary: #e8572a; --primary-dark: #c94820; --primary-light: #fff3ef; }
        body { background: #f8fafc; font-family: 'Segoe UI', sans-serif; }

        .filter-bar { background:#fff; border-bottom:1px solid #e2e8f0; padding:10px 0; position:relative; z-index:150; }
        .filter-pill {
            display:inline-flex; align-items:center; gap:6px;
            padding:7px 16px; border-radius:50px; border:1.5px solid #cbd5e1;
            background:#fff; font-size:.84rem; font-weight:500; color:#475569;
            cursor:pointer; transition:all .2s; white-space:nowrap;
            text-decoration:none; user-select:none;
            .tipe-wrap { position: relative; }
    .tipe-panel {
        position: absolute; 
        top: calc(100% + 10px); 
        left: 0; 
        z-index: 9999; /* Supaya tidak tertutup peta */
        background: #fff; 
        border-radius: 12px; 
        box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        padding: 15px; 
        min-width: 250px; 
        display: none; /* Default sembunyi */
        border: 1px solid #ddd;
    }
    .tipe-panel.show { display: block; }
    .tipe-row { 
        padding: 10px; 
        cursor: pointer; 
        display: flex; 
        align-items: center; 
        gap: 10px;
        border-radius: 8px;
    }
    .tipe-row:hover { background: #f0f0f0; }
    .tipe-row.active { color: #e8572a; font-weight: bold; background: #fff3ef; }
        }
        .filter-pill:hover { border-color:var(--primary); color:var(--primary); background:var(--primary-light); }
        .filter-pill.active { border-color:var(--primary); color:var(--primary); background:var(--primary-light); font-weight:600; }

    /* Bungkus tombol dan panel agar sejajar */

    .tipe-wrap { 
        position: relative; 
        display: inline-block; 
    }

    /* Style tombol saat Aktif (Orange) */
    .filter-pill.active {
        background-color: #e8572a !important; /* Warna Orange */
        color: white !important;
        border-color: #e8572a !important;
    }
    
    /* Ikon ikut jadi putih kalau aktif */
    .filter-pill.active i {
        color: white !important;
    }

    /* Panel Pop-up Melayang */
    .tipe-panel {
        position: absolute;
        top: 100%;
        left: 0;
        z-index: 9999;
        background: white;
        min-width: 250px;
        padding: 15px;
        margin-top: 10px;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        display: none;
    }

    .tipe-panel.show { 
        display: block !important; 
    }


    @keyframes munculDikit {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .tipe-row {
        padding: 12px;
        cursor: pointer;
        border-radius: 8px;
        transition: 0.2s;
    }
    .tipe-row:hover { background: #fff3ef; color: #e8572a; }

        .tipe-row:hover { color:var(--primary); }

        .cb-box {
            width:20px; height:20px; border-radius:5px;
            border:2px solid #cbd5e1; flex-shrink:0;
            display:flex; align-items:center; justify-content:center;
            transition:all .15s; background:#fff;
        }
        .tipe-row.checked .cb-box { background:var(--primary); border-color:var(--primary); }
        .tipe-row.checked .cb-box::after {
            content:''; display:block;
            width:5px; height:9px;
            border:2px solid #fff; border-top:none; border-left:none;
            transform:rotate(45deg) translateY(-1px);
        }
        .tipe-row.checked { color:var(--primary); font-weight:500; }

        .tipe-panel-footer {
            display:flex; justify-content:space-between; align-items:center;
            margin-top:16px; padding-top:14px; border-top:1px solid #f1f5f9;
        }
        .btn-hapus { background:none; border:none; font-size:.875rem; color:#64748b; font-weight:500; cursor:pointer; padding:0; }
        .btn-hapus:hover { color:#ef4444; }
        .btn-simpan { background:none; border:none; font-size:.875rem; color:#16a34a; font-weight:700; cursor:pointer; padding:0; }
        .btn-simpan:hover { color:#15803d; }

        .result-bar {
            display:flex; align-items:center; justify-content:space-between;
            padding:10px 20px; background:#fff; border-bottom:1px solid #e2e8f0;
            font-size:.875rem; color:#475569; flex-wrap:wrap; gap:8px;
        }

        .main-layout { display:flex; height:calc(100vh - 120px); overflow:hidden; }
        .list-panel { width:52%; overflow-y:auto; padding:16px; background:#f1f5f9; flex-shrink:0; }
        .map-panel { flex:1; position:relative; }
        #map { position:absolute; top:0; left:0; width:100%; height:100%; }

        @media(max-width:768px){
            .main-layout{flex-direction:column;height:auto;overflow:visible}
            .list-panel{width:100%}
            .map-panel{width:100%;height:320px;position:relative}
        }

        .kost-card {
            background:#fff; border-radius:16px; overflow:hidden;
            border:1.5px solid #e2e8f0; transition:all .2s;
            text-decoration:none; color:inherit; display:flex;
            margin-bottom:12px; box-shadow:0 1px 4px rgba(0,0,0,.04);
        }
        .kost-card:hover { transform:translateY(-3px); box-shadow:0 10px 28px rgba(0,0,0,.1); border-color:var(--primary); color:inherit; }

        .card-img-wrap { position:relative; flex-shrink:0; width:160px; min-height:140px; overflow:hidden; }
        .card-img { width:160px; height:140px; object-fit:cover; display:block; transition:transform .3s; }
        .kost-card:hover .card-img { transform:scale(1.05); }
        .card-img-placeholder {
            width:160px; height:140px;
            background:linear-gradient(135deg,#e2e8f0,#cbd5e1);
            display:flex; flex-direction:column; align-items:center; justify-content:center;
            color:#94a3b8; font-size:2rem; gap:6px;
        }
        .card-img-placeholder span { font-size:.72rem; color:#b0bec5; }

        .badge-tipe { position:absolute; top:8px; left:8px; padding:3px 10px; border-radius:50px; font-size:.7rem; font-weight:700; z-index:2; }
        .badge-putra  { background:rgba(219,234,254,.95); color:#1d4ed8; }
        .badge-putri  { background:rgba(252,231,243,.95); color:#be185d; }
        .badge-campur { background:rgba(209,250,229,.95); color:#065f46; }

        .card-body-kost { padding:14px 16px; flex:1; display:flex; flex-direction:column; justify-content:space-between; min-width:0; }
        .card-nama { font-weight:700; font-size:.95rem; color:#1e293b; margin-bottom:3px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
        .card-loc  { font-size:.8rem; color:#64748b; margin-bottom:6px; display:flex; align-items:center; gap:3px; }
        .card-fas  { font-size:.75rem; color:#94a3b8; margin-bottom:8px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
        .card-bottom { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:6px; }
        .card-harga { font-size:1.05rem; font-weight:800; color:var(--primary); line-height:1; }
        .card-harga small { font-size:.72rem; font-weight:400; color:#94a3b8; }

        .badge-kamar { font-size:.72rem; padding:4px 10px; border-radius:50px; font-weight:600; display:flex; align-items:center; gap:4px; }
        .badge-tersedia { background:#d1fae5; color:#065f46; }
        .badge-penuh    { background:#fee2e2; color:#991b1b; }
        .badge-sedikit  { background:#fef3c7; color:#92400e; }

        .marker-price {
            background:#fff; border:2px solid var(--primary);
            border-radius:50px; padding:4px 10px;
            font-size:.75rem; font-weight:700; color:var(--primary);
            white-space:nowrap; box-shadow:0 2px 8px rgba(0,0,0,.2);
            cursor:pointer; transition:all .15s;
        }
        .marker-price.active { background:var(--primary); color:#fff; transform:scale(1.1); }

        .leaflet-popup-content-wrapper { border-radius:16px !important; box-shadow:0 8px 24px rgba(0,0,0,.15) !important; border:none !important; padding:0 !important; overflow:hidden; }
        .leaflet-popup-content { margin:0 !important; min-width:200px; }
        .popup-img { width:100%; height:110px; object-fit:cover; display:block; }
        .popup-img-placeholder { width:100%; height:80px; background:linear-gradient(135deg,#e2e8f0,#cbd5e1); display:flex; align-items:center; justify-content:center; color:#94a3b8; font-size:1.5rem; }
        .popup-body { padding:12px 14px; }
        .popup-nama  { font-weight:700; font-size:.9rem; color:#1e293b; margin-bottom:2px; }
        .popup-kota  { font-size:.76rem; color:#64748b; margin-bottom:6px; }
        .popup-harga { color:var(--primary); font-weight:800; font-size:1rem; margin-bottom:10px; }
        .popup-harga small { font-weight:400; color:#94a3b8; font-size:.72rem; }
        .popup-link  { display:block; text-align:center; background:var(--primary); color:#fff; border-radius:10px; padding:7px 0; font-size:.82rem; font-weight:600; text-decoration:none; }
        .popup-link:hover { background:var(--primary-dark); color:#fff; }

        .empty-state { text-align:center; padding:60px 20px; }
        .empty-state i { font-size:3.5rem; color:#cbd5e1; margin-bottom:16px; display:block; }

        .pagination .page-link { border-radius:8px !important; margin:0 2px; color:var(--primary); border-color:#e2e8f0; font-size:.85rem; }
        .pagination .page-item.active .page-link { background:var(--primary); border-color:var(--primary); }
        .list-panel::-webkit-scrollbar { width:4px; }
        .list-panel::-webkit-scrollbar-thumb { background:#cbd5e1; border-radius:4px; }
   .fasilitas-item {
    transition: all .2s;
}

.fasilitas-item:hover {
    border-color: var(--primary) !important;
    background: var(--primary-light);
}

.fasilitas-item input:checked + i {
    color: #fff !important;
    background: var(--primary);
    border-radius: 6px;
    padding: 4px;
}
.fasilitas-item {
    transition: all .2s;
}

.fasilitas-item:hover {
    border-color: var(--primary) !important;
    background: var(--primary-light);
}

.fasilitas-item input:checked {
    accent-color: var(--primary);
}
.marker-price {
    cursor: pointer;
    pointer-events: auto;
}/* Biar foto di Maps tampil full ke pinggir pop-up */
.leaflet-popup-content-wrapper {
    padding: 0 !important;
    overflow: hidden;
    border-radius: 12px;
}
.leaflet-popup-content {
    margin: 0 !important;
    width: 220px !important;
}
/* Card Update: Biar Alamat & Fasilitas lebih rapi */
.card-loc {
    font-size: .78rem;
    color: #475569;
    margin-bottom: 4px;
    display: -webkit-box;
    -webkit-line-clamp: 1; /* Alamat maksimal 1 baris biar gak berantakan */
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.card-fas-list {
    display: flex;
    flex-wrap: wrap;
    gap: 4px;
    margin-bottom: 10px;
}

.fas-badge {
    font-size: .68rem;
    padding: 2px 8px;
    background: #f1f5f9;
    color: #64748b;
    border-radius: 4px;
    border: 1px solid #e2e8f0;
}
   </style>
</head>
<body>

@include('layouts.navigation')

<div class="filter-bar">
    <div class="container-fluid px-3 px-md-4">
        <div class="d-flex gap-2 overflow-auto pb-1" style="scrollbar-width:none">
        <div class="tipe-wrap">
            <button class="filter-pill {{ request('tipe') ? 'active' : '' }}" data-bs-toggle="modal" data-bs-target="#modalTipe">
                <i class="bi bi-people"></i> 
                {{ request('tipe') ?: 'Semua Tipe Kos' }} 
                <i class="bi bi-chevron-down ms-1"></i>
            </button>
        </div>


            <button class="filter-pill {{ request('durasi') ? 'active':'' }}" data-bs-toggle="modal" data-bs-target="#modalDurasi">
                <i class="bi bi-calendar3"></i> Bulanan
                @if(request('durasi'))<span class="badge rounded-pill ms-1" style="background:var(--primary);font-size:.62rem">✓</span>@endif
            </button>

            <button class="filter-pill {{ request('harga_min')||request('harga_max') ? 'active':'' }}" data-bs-toggle="modal" data-bs-target="#modalHarga">
                <i class="bi bi-cash-stack"></i> Harga
                @if(request('harga_min')||request('harga_max'))<span class="badge rounded-pill ms-1" style="background:var(--primary);font-size:.62rem">✓</span>@endif
            </button>

            <button class="filter-pill {{ request('fasilitas') ? 'active':'' }}" data-bs-toggle="modal" data-bs-target="#modalFasilitas">
                <i class="bi bi-wifi"></i> Fasilitas
                @if(request('fasilitas'))<span class="badge rounded-pill ms-1" style="background:var(--primary);font-size:.62rem">{{ count((array)request('fasilitas')) }}</span>@endif
            </button>

            <button class="filter-pill {{ request('aturan') ? 'active':'' }}" data-bs-toggle="modal" data-bs-target="#modalAturan">
                <i class="bi bi-journal-text"></i> Aturan Kos
                @if(request('aturan'))<span class="badge rounded-pill ms-1" style="background:var(--primary);font-size:.62rem">✓</span>@endif
            </button>

            <a href="{{ route('kost.cari', array_merge(request()->all(), ['kamar' => request('kamar') ? null : '1'])) }}"
               class="filter-pill {{ request('kamar') ? 'active':'' }}">
                <i class="bi bi-door-open"></i> Kamar Tersedia
            </a>

            @if(request()->hasAny(['q','tipe','harga_min','harga_max','fasilitas','durasi','aturan','kamar']))
            <a href="{{ route('kost.cari') }}" class="filter-pill" style="color:#ef4444;border-color:#fca5a5">
                <i class="bi bi-x-circle"></i> Reset
            </a>
            @endif
        </div>
    </div>
</div>

<div class="result-bar">
    <span>
        <i class="bi bi-house-check me-1" style="color:var(--primary)"></i>
        <strong>{{ $kosts->total() }}</strong> kos ditemukan
        @if(request('q')) untuk "<strong>{{ request('q') }}</strong>" @endif
    </span>
    <span style="font-size:.8rem;color:#94a3b8"><i class="bi bi-funnel me-1"></i>Terbaru</span>
</div>

<div class="main-layout">
    <div class="list-panel">
        @if($kosts->count() > 0)
            @foreach($kosts as $kost)
            @php
                $tipe          = strtolower($kost->tipe_kost ?? 'campur');
                $fas           = $kost->fasilitas;
                if (is_string($fas)) $fas = json_decode($fas, true);
                if (!is_array($fas)) $fas = [];
                $kamarTersedia = $kost->kamar_tersedia ?? 0;
                $kamarTotal    = $kost->kamar_total ?? 0;
            @endphp
                  <a href="{{ route('kost.show', $kost->id_kost) }}"
               class="kost-card" id="card-{{ $kost->id_kost }}"
               onmouseenter="highlightMarker({{ $kost->id_kost }})"
               onmouseleave="unhighlightMarker({{ $kost->id_kost }})">

                <div class="card-img-wrap">
                    @if($kost->foto_utama)
                        <img src="{{ asset('storage/' . $kost->foto_utama) }}"
                             alt="{{ $kost->nama_kost }}" class="card-img"
                             onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                        <div class="card-img-placeholder" style="display:none;">
                            <i class="bi bi-house-fill"></i><span>Foto tidak tersedia</span>
                        </div>
                    @else
                        <div class="card-img-placeholder">
                            <i class="bi bi-house-fill"></i><span>Belum ada foto</span>
                        </div>
                    @endif
                    <span class="badge-tipe badge-{{ $tipe }}">{{ ucfirst($tipe) }}</span>
                </div>

                <div class="card-body-kost">
                          <div>
                      <div class="card-nama">{{ $kost->nama_kost }}</div>
        
                          <div class="card-loc">
                       <i class="bi bi-geo-alt-fill text-danger me-1"></i>
                            {{ $kost->alamat_lengkap ?? $kost->alamat }}, {{ $kost->kota }}
                            </div>
      
                             @if(count($fas) > 0)
                                        <div class="card-fas-list">
                                  @foreach(array_slice($fas, 0, 4) as $item)
                                   <span class="fas-badge">
                                <i class="bi bi-check2"></i> {{ $item }}
                                   </span>
            @endforeach
            @if(count($fas) > 4)
                <span class="fas-badge text-muted">+{{ count($fas) - 4 }}</span>
            @endif
        </div>
        @endif
    </div>

    <div class="card-bottom">
        <div class="card-harga">
            Rp{{ number_format($kost->harga_mulai, 0, ',', '.') }}
            <small>/bulan</small>
        </div>
        
        {{-- Status Kamar --}}
        @if($kamarTotal == 0)
            <span class="badge-kamar {{ $kost->status==='aktif' ? 'badge-tersedia':'badge-penuh' }}">
                <i class="bi bi-{{ $kost->status==='aktif' ? 'check':'x' }}-circle-fill"></i>
                {{ $kost->status==='aktif' ? 'Tersedia':'Penuh' }}
            </span>
        @elseif($kamarTersedia == 0)
            <span class="badge-kamar badge-penuh"><i class="bi bi-x-circle-fill"></i> Penuh</span>
        @else
            <span class="badge-kamar badge-tersedia"><i class="bi bi-check-circle-fill"></i> {{ $kamarTersedia }} Kamar</span>
        @endif
    </div>
</div>
            </a>
            @endforeach

            <div class="d-flex justify-content-center mt-2 mb-4">
                {{ $kosts->links('pagination::bootstrap-5') }}
            </div>
        @else
            <div class="empty-state">
                <i class="bi bi-house-slash"></i>
                <h5 style="color:#475569">Kos tidak ditemukan</h5>
                <p style="color:#94a3b8;font-size:.9rem">Coba ubah filter atau kata kunci</p>
                <a href="{{ route('kost.cari') }}" class="btn rounded-pill px-4 mt-2 text-white fw-semibold" style="background:var(--primary)">
                    <i class="bi bi-arrow-counterclockwise me-1"></i>Reset
                </a>
            </div>
        @endif
    </div>

    <div class="map-panel"><div id="map"></div></div>
</div>

{{-- MODAL TIPE KOS --}}
<div class="modal fade" id="modalTipe" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title fw-bold">Pilih Kategori Kos</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('kost.cari') }}" method="GET">
                @if(request('q')) <input type="hidden" name="q" value="{{ request('q') }}">@endif
                <div class="modal-body">
                    <p style="font-size:.85rem;color:#64748b">Pilih tipe kos sesuai kebutuhanmu.</p>
                    <div class="d-flex flex-column gap-2">
                        @foreach(['Putra'=>'👦 Putra', 'Putri'=>'👧 Putri', 'Campur'=>'👫 Campur'] as $val=>$label)
                        <label class="d-flex align-items-center gap-3 p-3 rounded-3 border" style="cursor:pointer;border-color:#e2e8f0 !important">
                            <input type="radio" name="tipe" value="{{ $val }}" class="form-check-input m-0" {{ request('tipe')==$val ? 'checked':'' }}>
                            <span style="font-size:.9rem;font-weight:500">{{ $label }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <a href="{{ route('kost.cari', request()->except(['tipe'])) }}" class="btn btn-light rounded-pill px-4">Reset</a>
                    <button type="submit" class="btn rounded-pill px-4 text-white fw-semibold" style="background:var(--primary)">Terapkan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL HARGA --}}
<div class="modal fade" id="modalHarga" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title fw-bold">Filter Harga</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('kost.cari') }}" method="GET">
                @if(request('q'))    <input type="hidden" name="q"    value="{{ request('q') }}">@endif
                @if(request('tipe')) <input type="hidden" name="tipe" value="{{ request('tipe') }}">@endif
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Minimum</label>
                            <input type="number" name="harga_min" id="inp_min" class="form-control rounded-3" placeholder="Rp 0" value="{{ request('harga_min') }}">
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Maksimum</label>
                            <input type="number" name="harga_max" id="inp_max" class="form-control rounded-3" placeholder="Rp 5.000.000" value="{{ request('harga_max') }}">
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-3 flex-wrap">
                        <button type="button" class="filter-pill" style="font-size:.78rem" onclick="setRange(0,500000)">&lt; 500rb</button>
                        <button type="button" class="filter-pill" style="font-size:.78rem" onclick="setRange(500000,1000000)">500rb–1jt</button>
                        <button type="button" class="filter-pill" style="font-size:.78rem" onclick="setRange(1000000,2000000)">1jt–2jt</button>
                        <button type="button" class="filter-pill" style="font-size:.78rem" onclick="setRange(2000000,'')">&gt; 2jt</button>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <a href="{{ route('kost.cari', request()->except(['harga_min','harga_max'])) }}" class="btn btn-light rounded-pill px-4">Reset</a>
                    <button type="submit" class="btn rounded-pill px-4 text-white fw-semibold" style="background:var(--primary)">Terapkan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL FASILITAS --}}
<div class="modal fade" id="modalFasilitas" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title fw-bold">Filter Fasilitas</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('kost.cari') }}" method="GET">
                @if(request('q'))         <input type="hidden" name="q"         value="{{ request('q') }}">@endif
                @if(request('tipe'))      <input type="hidden" name="tipe"      value="{{ request('tipe') }}">@endif
                @if(request('harga_min')) <input type="hidden" name="harga_min" value="{{ request('harga_min') }}">@endif
                @if(request('harga_max')) <input type="hidden" name="harga_max" value="{{ request('harga_max') }}">@endif
                <div class="modal-body">
                    <div class="row g-2">
                    @foreach([
    ['icon'=>'bi-thermometer-half','label'=>'AC'],
    ['icon'=>'bi-wifi','label'=>'WiFi / Internet'],
    ['icon'=>'bi-door-closed','label'=>'Kamar Mandi Dalam'],
    ['icon'=>'bi-moon','label'=>'Kasur'],
    ['icon'=>'bi-archive','label'=>'Lemari'],
    ['icon'=>'bi-table','label'=>'Meja & Kursi'],
    ['icon'=>'bi-snow','label'=>'Kulkas Bersama'],
    ['icon'=>'bi-droplet','label'=>'Laundry'],
    ['icon'=>'bi-cup-hot','label'=>'Dapur'],
    ['icon'=>'bi-cup-straw','label'=>'Air Minum (Dispenser)'],
    ['icon'=>'bi-bicycle','label'=>'Parkir Motor'],
    ['icon'=>'bi-car-front','label'=>'Parkir Mobil'],
    ['icon'=>'bi-tv','label'=>'TV'],
    ['icon'=>'bi-shield-check','label'=>'CCTV'],
] as $f)
                        <div class="col-6">
<label class="d-flex align-items-center gap-2 p-2 rounded-3 border fasilitas-item"
                                   style="cursor:pointer;border-color:#e2e8f0 !important;font-size:.875rem"
                                   for="mf_{{ Str::slug($f['label']) }}">
                                <input type="checkbox" class="form-check-input m-0"
                                       name="fasilitas[]" id="mf_{{ Str::slug($f['label']) }}"
                                       value="{{ $f['label'] }}"
                                       {{ is_array(request('fasilitas')) && in_array($f['label'],request('fasilitas')) ? 'checked':'' }}>
                                <i class="bi {{ $f['icon'] }}" style="font-size:.9rem;color:var(--primary)"></i>
                                <span>{{ $f['label'] }}</span>
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <a href="{{ route('kost.cari', request()->except(['fasilitas'])) }}" class="btn btn-light rounded-pill px-4">Reset</a>
                    <button type="submit" class="btn rounded-pill px-4 text-white fw-semibold" style="background:var(--primary)">Terapkan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL DURASI --}}
<div class="modal fade" id="modalDurasi" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title fw-bold">Durasi Sewa</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('kost.cari') }}" method="GET">
                @if(request('q'))    <input type="hidden" name="q"    value="{{ request('q') }}">@endif
                @if(request('tipe')) <input type="hidden" name="tipe" value="{{ request('tipe') }}">@endif
                <div class="modal-body">
                    <p style="font-size:.85rem;color:#64748b">Pilih durasi sewa yang kamu inginkan.</p>
                    <div class="d-flex flex-column gap-2">
                        @foreach(['Harian'=>'Harian','Bulanan'=>'Bulanan'] as $val=>$label)
                        <label class="d-flex align-items-center gap-3 p-3 rounded-3 border" style="cursor:pointer;border-color:#e2e8f0 !important">
                            <input type="radio" name="durasi" value="{{ $val }}" class="form-check-input m-0" {{ request('durasi')==$val ? 'checked':'' }}>
                            <span style="font-size:.9rem;font-weight:500">{{ $label }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <a href="{{ route('kost.cari', request()->except(['durasi'])) }}" class="btn btn-light rounded-pill px-4">Reset</a>
                    <button type="submit" class="btn rounded-pill px-4 text-white fw-semibold" style="background:var(--primary)">Terapkan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL ATURAN --}}
<div class="modal fade" id="modalAturan" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title fw-bold">Aturan Kos</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('kost.cari') }}" method="GET">
                @if(request('q'))    <input type="hidden" name="q"    value="{{ request('q') }}">@endif
                @if(request('tipe')) <input type="hidden" name="tipe" value="{{ request('tipe') }}">@endif
                <div class="modal-body">
                    <p style="font-size:.85rem;color:#64748b">Pilih aturan kos yang sesuai.</p>
                    <div class="row g-2">
                    @foreach([
    ['icon'=>'bi-person-x','label'=>'Dilarang Bawa Lawan Jenis'],
    ['icon'=>'bi-ban','label'=>'Dilarang Bawa Hewan'],
    ['icon'=>'bi-cash','label'=>'Tamu Menginap Denda'],
    ['icon'=>'bi-people','label'=>'Boleh Bertamu'],
    ['icon'=>'bi-clock','label'=>'Jam Tutup Gerbang'],
    ['icon'=>'bi-volume-mute','label'=>'Dilarang Berisik'],
    ['icon'=>'bi-fire','label'=>'Dilarang Merokok'],
    ['icon'=>'bi-person-check','label'=>'Wajib Lapor Tamu'],
] as $a)
                        <div class="col-6">
                           <label class="aturan-item d-flex align-items-center gap-2 p-2 rounded-3 border"
                                   style="cursor:pointer;border-color:#e2e8f0 !important;font-size:.875rem"
                                   for="aturan_{{ Str::slug($a['label']) }}">
                                <input type="checkbox" class="form-check-input m-0"
                                       name="aturan[]" id="aturan_{{ Str::slug($a['label']) }}"
                                       value="{{ $a['label'] }}"
                                       {{ is_array(request('aturan')) && in_array($a['label'],request('aturan')) ? 'checked':'' }}>
                                <i class="bi {{ $a['icon'] }}" style="font-size:.9rem;color:var(--primary)"></i>
                                <span>{{ $a['label'] }}</span>
                            </label>
                        </div>
                        @endforeach
                    </div>
                    <div class="mt-3">
    <label class="form-label small fw-bold text-muted">Cari/Tulis aturan lainnya:</label>
    <input type="text" name="q_aturan" class="form-control form-control-sm rounded-3" 
           placeholder="Misal: Boleh bawa elektronik..." value="{{ request('q_aturan') }}">
</div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <a href="{{ route('kost.cari', request()->except(['aturan'])) }}" class="btn btn-light rounded-pill px-4">Reset</a>
                    <button type="submit" class="btn rounded-pill px-4 text-white fw-semibold" style="background:var(--primary)">Terapkan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    // 2. INISIALISASI MAP (Hanya satu kali)
    let map, markers = {}, allBounds = [];
    const kostsData = @json($kostsMap->values());

    function formatRp(n) {
        if (!n) return '-';
        if (n >= 1000000) return 'Rp' + (n/1000000).toFixed(1).replace('.0','') + 'jt';
        if (n >= 1000) return 'Rp' + Math.round(n/1000) + 'rb';
        return 'Rp' + n;
    }

    function addMarker(kost, lat, lng) {
        const icon = L.divIcon({
            className: '',
            html: `<div class="marker-price" onclick="markerClick(${kost.id})">${formatRp(kost.harga)}</div>`,
            iconAnchor: [32, 14],
        });

        const fotoUrl = kost.foto ? `/storage/${kost.foto}` : '';
        const imgHtml = kost.foto 
            ? `<img src="${fotoUrl}" class="popup-img" style="width:100%;height:110px;object-fit:cover;display:block" onerror="this.src='https://placehold.co/200x110?text=No+Photo'">`
            : `<div style="background:#eee;height:80px;display:flex;align-items:center;justify-content:center"><i class="bi bi-house-fill"></i></div>`;

        const m = L.marker([lat, lng], { icon }).addTo(map);
        
        m.bindPopup(`
            <div class="leaflet-popup-custom">
                ${imgHtml}
                <div class="popup-body" style="padding:10px">
                    <div style="font-weight:700;font-size:.9rem">${kost.nama}</div>
                    <div style="color:#e8572a;font-weight:800">${formatRp(kost.harga)}/bln</div>
                    <a href="/kost/${kost.id}" style="display:block;text-align:center;background:#e8572a;color:#fff;padding:5px;border-radius:8px;text-decoration:none;font-size:.8rem;margin-top:8px">Lihat Detail</a>
                </div>
            </div>`, { maxWidth: 220 });

        markers[kost.id] = m;
        allBounds.push([lat, lng]);
    }

    // 3. JALANKAN MAP SETELAH DOM SIAP
    document.addEventListener("DOMContentLoaded", function() {
        setTimeout(async function() {
            // Setup Map
            map = L.map('map').setView([-7.548, 112.232], 9); 
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap'
            }).addTo(map);

            // Paksa render ulang agar tidak putih/abu-abu
            map.invalidateSize();

            // Load Markers
            for (let k of kostsData) {
                if (k.lat && k.lng) {
                    addMarker(k, k.lat, k.lng);
                } else if (k.alamat) {
                    // Geocoding jika koordinat kosong (opsional)
                    const r = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(k.alamat)}`);
                    const d = await r.json();
                    if (d.length) addMarker(k, d[0].lat, d[0].lon);
                }
            }

            if (allBounds.length > 0) map.fitBounds(allBounds, { padding:[30,30] });
        }, 500);
    });

    function markerClick(id) {
        if (markers[id]) markers[id].openPopup();
    }
</script>
</body>
</html>