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
        :root { --primary: #2563eb; --primary-dark: #1d4ed8; }
        body { background: #f8fafc; font-family: 'Segoe UI', sans-serif; }

        /* FILTER BAR */
        .filter-bar { background: #fff; border-bottom: 1px solid #e2e8f0; padding: 10px 0; position: relative; z-index: 150; }
        .filter-pill {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 6px 16px; border-radius: 50px; border: 1.5px solid #cbd5e1;
            background: #fff; font-size: .85rem; font-weight: 500; color: #475569;
            cursor: pointer; transition: all .15s; white-space: nowrap; text-decoration: none;
        }
        .filter-pill:hover, .filter-pill.active {
            border-color: var(--primary); color: var(--primary); background: #eff6ff;
        }

        /* TIPE PANEL (mirip Mamikos) */
        .tipe-wrap { position: relative; }
        .tipe-panel {
            position: absolute; top: calc(100% + 8px); left: 0; z-index: 400;
            background: #fff; border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0,0,0,.15);
            padding: 20px; min-width: 240px;
            display: none;
        }
        .tipe-panel.show { display: block; }
        .tipe-desc { font-size: .8rem; color: #94a3b8; margin-bottom: 14px; line-height: 1.5; }
        .tipe-checkbox {
            display: flex; align-items: center; gap: 12px;
            padding: 10px 4px; cursor: pointer;
            border-bottom: 1px solid #f1f5f9; font-size: .9rem; color: #1e293b;
        }
        .tipe-checkbox:last-of-type { border-bottom: none; }
        .tipe-checkbox input[type=checkbox] {
            width: 18px; height: 18px; border-radius: 4px;
            accent-color: var(--primary); cursor: pointer; flex-shrink: 0;
        }
        .tipe-panel-footer {
            display: flex; justify-content: space-between; align-items: center;
            margin-top: 14px; padding-top: 12px; border-top: 1px solid #f1f5f9;
        }
        .btn-hapus { background: none; border: none; font-size: .875rem; color: #475569; font-weight: 500; cursor: pointer; padding: 0; }
        .btn-simpan { background: none; border: none; font-size: .875rem; color: #16a34a; font-weight: 700; cursor: pointer; padding: 0; }

        /* RESULT BAR */
        .result-bar {
            display: flex; align-items: center; justify-content: space-between;
            padding: 10px 16px; background: #fff; border-bottom: 1px solid #e2e8f0;
            font-size: .875rem; color: #475569; flex-wrap: wrap; gap: 8px;
        }
        .sort-select {
            border: 1.5px solid #cbd5e1; border-radius: 8px;
            padding: 5px 12px; font-size: .85rem; color: #475569; background: #fff;
        }

        /* LAYOUT MIRIP MAMIKOS */
        .main-layout { display: flex; height: calc(100vh - 115px); overflow: hidden; }
        .list-panel { width: 52%; overflow-y: auto; padding: 16px; background: #f8fafc; flex-shrink: 0; }
        .map-panel  { flex: 1; position: relative; }
        #map { width: 100%; height: 100%; }

        @media (max-width: 768px) {
            .main-layout { flex-direction: column; height: auto; }
            .list-panel  { width: 100%; }
            .map-panel   { width: 100%; height: 300px; }
        }

        /* KOST CARD */
        .kost-card {
            background: #fff; border-radius: 14px; overflow: hidden;
            border: 1px solid #e2e8f0; transition: all .2s;
            text-decoration: none; color: inherit; display: flex;
            margin-bottom: 12px;
        }
        .kost-card:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,.1); color: inherit; }
        .kost-card.highlighted { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(37,99,235,.15); }

        .card-img-wrap { position: relative; flex-shrink: 0; }
        .card-img { width: 155px; height: 130px; object-fit: cover; }
        .card-img-placeholder {
            width: 155px; height: 130px;
            background: linear-gradient(135deg, #e2e8f0, #cbd5e1);
            display: flex; align-items: center; justify-content: center;
            color: #94a3b8; font-size: 2rem;
        }
        .badge-tipe {
            position: absolute; top: 8px; left: 8px;
            padding: 2px 10px; border-radius: 50px; font-size: .72rem; font-weight: 600;
        }
        .badge-putra  { background: #dbeafe; color: #1d4ed8; }
        .badge-putri  { background: #fce7f3; color: #be185d; }
        .badge-campur { background: #d1fae5; color: #065f46; }

        .card-body-kost { padding: 12px 14px; flex: 1; display: flex; flex-direction: column; justify-content: space-between; }
        .card-nama  { font-weight: 600; font-size: .95rem; color: #1e293b; margin-bottom: 2px; }
        .card-loc   { font-size: .8rem; color: #64748b; margin-bottom: 5px; }
        .card-fas   { font-size: .76rem; color: #94a3b8; margin-bottom: 6px; }
        .card-harga { font-size: 1rem; font-weight: 700; color: var(--primary); }
        .card-harga small { font-size: .72rem; font-weight: 400; color: #94a3b8; }

        .badge-kamar { font-size: .7rem; padding: 2px 8px; border-radius: 50px; font-weight: 600; }
        .badge-tersedia { background: #d1fae5; color: #065f46; }
        .badge-penuh    { background: #fee2e2; color: #991b1b; }

        /* MAP MARKER */
        .marker-price {
            background: #fff; border: 2px solid var(--primary);
            border-radius: 50px; padding: 3px 10px;
            font-size: .75rem; font-weight: 700; color: var(--primary);
            white-space: nowrap; box-shadow: 0 2px 8px rgba(0,0,0,.18);
            cursor: pointer; transition: all .15s;
        }
        .marker-price.active { background: var(--primary); color: #fff; }

        .leaflet-popup-content { margin: 10px 14px; min-width: 175px; }
        .popup-nama  { font-weight: 600; font-size: .9rem; color: #1e293b; }
        .popup-harga { color: var(--primary); font-weight: 700; font-size: .95rem; margin: 4px 0; }
        .popup-link  {
            display: block; text-align: center; background: var(--primary);
            color: #fff; border-radius: 8px; padding: 5px 0;
            font-size: .82rem; text-decoration: none; margin-top: 8px;
        }
        .popup-link:hover { background: var(--primary-dark); color: #fff; }

        /* EMPTY STATE */
        .empty-state { text-align: center; padding: 60px 20px; }
        .empty-state i { font-size: 3rem; color: #cbd5e1; margin-bottom: 12px; display: block; }

        /* PAGINATION */
        .pagination .page-link { border-radius: 8px !important; margin: 0 2px; color: var(--primary); border-color: #e2e8f0; font-size: .85rem; }
        .pagination .page-item.active .page-link { background: var(--primary); border-color: var(--primary); }
    </style>
</head>
<body>

@include('layouts.navigation')

{{-- FILTER PILLS --}}
<div class="filter-bar">
    <div class="container-fluid px-3 px-md-4">
        <div class="d-flex gap-2 overflow-auto pb-1" style="scrollbar-width:none">

            {{-- TIPE KOS (panel checkbox mirip Mamikos) --}}
            <div class="tipe-wrap">
                <button class="filter-pill {{ request('tipe') ? 'active' : '' }}"
                        id="btnTipe" onclick="toggleTipePanel(event)">
                    <i class="bi bi-people"></i>
                    {{ request('tipe') ? request('tipe') : 'Semua Tipe Kos' }}
                    <i class="bi bi-chevron-down" style="font-size:.7rem"></i>
                </button>

                <div class="tipe-panel" id="tipePanel">
                    <p class="tipe-desc">Tipe kos yang kamu cari berdasarkan gender.</p>

                    <label class="tipe-checkbox">
                        <input type="checkbox" class="tipe-cb" value="Putra"
                               {{ request('tipe') == 'Putra' ? 'checked' : '' }}>
                        Putra
                    </label>
                    <label class="tipe-checkbox">
                        <input type="checkbox" class="tipe-cb" value="Putri"
                               {{ request('tipe') == 'Putri' ? 'checked' : '' }}>
                        Putri
                    </label>
                    <label class="tipe-checkbox">
                        <input type="checkbox" class="tipe-cb" value="Campur"
                               {{ request('tipe') == 'Campur' ? 'checked' : '' }}>
                        Campur
                    </label>

                    <div class="tipe-panel-footer">
                        <button class="btn-hapus" onclick="hapusTipe()">Hapus</button>
                        <button class="btn-simpan" onclick="simpanTipe()">Simpan</button>
                    </div>
                </div>
            </div>
            </button>
            {{-- DURASI --}}
<button class="filter-pill {{ request('durasi') ? 'active' : '' }}"
        data-bs-toggle="modal" data-bs-target="#modalDurasi">
    <i class="bi bi-calendar3"></i> Bulanan
    @if(request('durasi'))
        <span class="badge bg-primary rounded-pill ms-1" style="font-size:.62rem">✓</span>
    @endif
</button>
            {{-- HARGA --}}
            <button class="filter-pill {{ request('harga_min') || request('harga_max') ? 'active' : '' }}"
                    data-bs-toggle="modal" data-bs-target="#modalHarga">
                <i class="bi bi-cash-stack"></i> Harga
                @if(request('harga_min') || request('harga_max'))
                    <span class="badge bg-primary rounded-pill ms-1" style="font-size:.62rem">✓</span>
                @endif
            </button>

            {{-- FASILITAS --}}
            <button class="filter-pill {{ request('fasilitas') ? 'active' : '' }}"
                    data-bs-toggle="modal" data-bs-target="#modalFasilitas">
                <i class="bi bi-wifi"></i> Fasilitas
                @if(request('fasilitas'))
                    <span class="badge bg-primary rounded-pill ms-1" style="font-size:.62rem">{{ count((array) request('fasilitas')) }}</span>
                @endif
    

{{-- ATURAN KOS --}}
<button class="filter-pill {{ request('aturan') ? 'active' : '' }}"
        data-bs-toggle="modal" data-bs-target="#modalAturan">
    <i class="bi bi-journal-text"></i> Aturan Kos
    @if(request('aturan'))
        <span class="badge bg-primary rounded-pill ms-1" style="font-size:.62rem">✓</span>
    @endif
</button>

{{-- KAMAR TERSEDIA --}}
<a href="{{ route('kost.cari', array_merge(request()->all(), ['kamar' => request('kamar') ? null : '1'])) }}"
   class="filter-pill {{ request('kamar') ? 'active' : '' }}">
    <i class="bi bi-door-open"></i> Kamar Tersedia
</a>

            {{-- RESET --}}
            {{-- RESET --}}
            @if(request()->hasAny(['q', 'tipe', 'harga_min', 'harga_max', 'fasilitas', 'durasi', 'aturan', 'kamar']))
            <a href="{{ route('kost.cari') }}" class="filter-pill" style="color:#ef4444; border-color:#fca5a5">
                <i class="bi bi-x-circle"></i> Reset
            </a>
            @endif

        </div>
    </div>
</div>

{{-- RESULT BAR --}}
<div class="result-bar">
    <span>
        <i class="bi bi-house-check text-primary me-1"></i>
        <strong>{{ $kosts->total() }}</strong> kos ditemukan
        @if(request('q')) untuk "<strong>{{ request('q') }}</strong>" @endif
    </span>
    <div class="d-flex align-items-center gap-2">
        <span style="font-size:.82rem">Urutkan:</span>
        <select class="sort-select" onchange="applySort(this.value)">
            <option value="terbaru"  {{ request('sort', 'terbaru') == 'terbaru'  ? 'selected' : '' }}>Terbaru</option>
            <option value="termurah" {{ request('sort') == 'termurah' ? 'selected' : '' }}>Termurah</option>
            <option value="termahal" {{ request('sort') == 'termahal' ? 'selected' : '' }}>Termahal</option>
        </select>
    </div>
</div>

{{-- MAIN LAYOUT --}}
<div class="main-layout">

    {{-- KIRI: LIST KOS --}}
    <div class="list-panel">
        @if($kosts->count() > 0)

            @foreach($kosts as $kost)
            @php
                $tipe          = strtolower($kost->tipe_kost ?? 'campur');
                $img           = $kost->images->first();
                $fas           = is_array($kost->fasilitas) ? $kost->fasilitas : [];
                $kamarTersedia = $kost->rooms->where('status', 'tersedia')->count();
            @endphp

            <a href="{{ route('kost.show', $kost->id_kost) }}"
               class="kost-card"
               id="card-{{ $kost->id_kost }}"
               onmouseenter="highlightMarker({{ $kost->id_kost }})"
               onmouseleave="unhighlightMarker({{ $kost->id_kost }})">

                <div class="card-img-wrap">
                    @if($img)
                        <img src="{{ asset('storage/' . $img->path) }}" alt="{{ $kost->nama_kost }}" class="card-img">
                    @elseif($kost->foto_utama)
                        <img src="{{ asset('storage/' . $kost->foto_utama) }}" alt="{{ $kost->nama_kost }}" class="card-img">
                    @else
                        <div class="card-img-placeholder"><i class="bi bi-house-fill"></i></div>
                    @endif
                    <span class="badge-tipe badge-{{ $tipe }}">{{ ucfirst($tipe) }}</span>
                </div>

                <div class="card-body-kost">
                    <div>
                        <div class="card-nama">{{ $kost->nama_kost }}</div>
                        <div class="card-loc">
                            <i class="bi bi-geo-alt" style="font-size:.72rem"></i> {{ $kost->kota }}
                        </div>
                        @if(count($fas))
                        <div class="card-fas">{{ implode(' · ', array_slice($fas, 0, 3)) }}</div>
                        @endif
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="card-harga">
                            Rp{{ number_format($kost->harga_mulai, 0, ',', '.') }}
                            <small>/bulan</small>
                        </div>
                        <span class="badge-kamar {{ $kamarTersedia > 0 ? 'badge-tersedia' : 'badge-penuh' }}">
                            {{ $kamarTersedia > 0 ? $kamarTersedia . ' kamar' : 'Penuh' }}
                        </span>
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
                <p style="color:#94a3b8; font-size:.9rem">Coba ubah filter atau kata kunci</p>
                <a href="{{ route('kost.cari') }}" class="btn btn-primary rounded-pill px-4 mt-2">
                    <i class="bi bi-arrow-counterclockwise me-1"></i>Reset
                </a>
            </div>
        @endif
    </div>

    {{-- KANAN: MAP --}}
    <div class="map-panel">
        <div id="map"></div>
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
                @if(request('q'))    <input type="hidden" name="q"    value="{{ request('q') }}"> @endif
                @if(request('tipe')) <input type="hidden" name="tipe" value="{{ request('tipe') }}"> @endif
                @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Minimum</label>
                            <input type="number" name="harga_min" id="inp_min" class="form-control rounded-3"
                                   placeholder="Rp 0" value="{{ request('harga_min') }}">
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Maksimum</label>
                            <input type="number" name="harga_max" id="inp_max" class="form-control rounded-3"
                                   placeholder="Rp 5.000.000" value="{{ request('harga_max') }}">
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-3 flex-wrap">
                        <button type="button" class="filter-pill" style="font-size:.78rem" onclick="setRange(0, 500000)">&lt; 500rb</button>
                        <button type="button" class="filter-pill" style="font-size:.78rem" onclick="setRange(500000, 1000000)">500rb–1jt</button>
                        <button type="button" class="filter-pill" style="font-size:.78rem" onclick="setRange(1000000, 2000000)">1jt–2jt</button>
                        <button type="button" class="filter-pill" style="font-size:.78rem" onclick="setRange(2000000, '')">&gt; 2jt</button>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <a href="{{ route('kost.cari', request()->except(['harga_min', 'harga_max'])) }}"
                       class="btn btn-light rounded-pill px-4">Reset</a>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Terapkan</button>
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
                @if(request('q'))       <input type="hidden" name="q"        value="{{ request('q') }}"> @endif
                @if(request('tipe'))    <input type="hidden" name="tipe"     value="{{ request('tipe') }}"> @endif
                @if(request('sort'))    <input type="hidden" name="sort"     value="{{ request('sort') }}"> @endif
                @if(request('harga_min')) <input type="hidden" name="harga_min" value="{{ request('harga_min') }}"> @endif
                @if(request('harga_max')) <input type="hidden" name="harga_max" value="{{ request('harga_max') }}"> @endif
                <div class="modal-body">
                    <div class="row g-2">
                        @foreach([
                            ['icon' => 'bi-wifi',             'label' => 'WiFi'],
                            ['icon' => 'bi-thermometer-half', 'label' => 'AC'],
                            ['icon' => 'bi-door-closed',      'label' => 'Kamar Mandi Dalam'],
                            ['icon' => 'bi-cup-hot',          'label' => 'Dapur'],
                            ['icon' => 'bi-bicycle',          'label' => 'Parkir Motor'],
                            ['icon' => 'bi-car-front',        'label' => 'Parkir Mobil'],
                            ['icon' => 'bi-droplet',          'label' => 'Laundry'],
                            ['icon' => 'bi-moon',             'label' => 'Kasur'],
                            ['icon' => 'bi-shield-check',     'label' => 'CCTV'],
                            ['icon' => 'bi-plug',             'label' => 'Listrik Token'],
                        ] as $f)
                        <div class="col-6">
                            <label class="d-flex align-items-center gap-2 p-2 rounded-3 border"
                                   style="cursor:pointer; border-color:#e2e8f0 !important; font-size:.875rem"
                                   for="mf_{{ Str::slug($f['label']) }}">
                                <input type="checkbox" class="form-check-input m-0"
                                       name="fasilitas[]"
                                       id="mf_{{ Str::slug($f['label']) }}"
                                       value="{{ $f['label'] }}"
                                       {{ is_array(request('fasilitas')) && in_array($f['label'], request('fasilitas')) ? 'checked' : '' }}>
                                <i class="bi {{ $f['icon'] }} text-primary" style="font-size:.9rem"></i>
                                <span>{{ $f['label'] }}</span>
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <a href="{{ route('kost.cari', request()->except(['fasilitas'])) }}"
                       class="btn btn-light rounded-pill px-4">Reset</a>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Terapkan</button>
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
                @if(request('q'))    <input type="hidden" name="q"    value="{{ request('q') }}"> @endif
                @if(request('tipe')) <input type="hidden" name="tipe" value="{{ request('tipe') }}"> @endif
                @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif
                <div class="modal-body">
                    <p style="font-size:.85rem;color:#64748b">Pilih durasi sewa yang kamu inginkan.</p>
                    <div class="d-flex flex-column gap-2">
                        @foreach(['Harian'=>'Harian','Bulanan'=>'Bulanan','Tahunan'=>'Tahunan'] as $val=>$label)
                        <label class="d-flex align-items-center gap-3 p-3 rounded-3 border"
                               style="cursor:pointer;border-color:#e2e8f0 !important">
                            <input type="radio" name="durasi" value="{{ $val }}"
                                   class="form-check-input m-0"
                                   {{ request('durasi') == $val ? 'checked' : '' }}>
                            <span style="font-size:.9rem;font-weight:500">{{ $label }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <a href="{{ route('kost.cari', request()->except(['durasi'])) }}"
                       class="btn btn-light rounded-pill px-4">Reset</a>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Terapkan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL ATURAN KOS --}}
<div class="modal fade" id="modalAturan" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title fw-bold">Aturan Kos</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('kost.cari') }}" method="GET">
                @if(request('q'))    <input type="hidden" name="q"    value="{{ request('q') }}"> @endif
                @if(request('tipe')) <input type="hidden" name="tipe" value="{{ request('tipe') }}"> @endif
                @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif
                <div class="modal-body">
                    <p style="font-size:.85rem;color:#64748b">Pilih aturan kos yang sesuai.</p>
                    <div class="row g-2">
                        @foreach([
                            ['icon'=>'bi-cup-straw',    'label'=>'Boleh Masak'],
                            ['icon'=>'bi-person-heart', 'label'=>'Boleh Pasangan'],
                            ['icon'=>'bi-clock',        'label'=>'Bebas Jam Malam'],
                            ['icon'=>'bi-house-heart',  'label'=>'Boleh Hewan Peliharaan'],
                            ['icon'=>'bi-people',       'label'=>'Boleh Tamu'],
                            ['icon'=>'bi-music-note',   'label'=>'Bebas Berisik'],
                        ] as $a)
                        <div class="col-6">
                            <label class="d-flex align-items-center gap-2 p-2 rounded-3 border"
                                   style="cursor:pointer;border-color:#e2e8f0 !important;font-size:.875rem"
                                   for="aturan_{{ Str::slug($a['label']) }}">
                                <input type="checkbox" class="form-check-input m-0"
                                       name="aturan[]"
                                       id="aturan_{{ Str::slug($a['label']) }}"
                                       value="{{ $a['label'] }}"
                                       {{ is_array(request('aturan')) && in_array($a['label'], request('aturan')) ? 'checked' : '' }}>
                                <i class="bi {{ $a['icon'] }} text-primary" style="font-size:.9rem"></i>
                                <span>{{ $a['label'] }}</span>
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <a href="{{ route('kost.cari', request()->except(['aturan'])) }}"
                       class="btn btn-light rounded-pill px-4">Reset</a>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Terapkan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>

// ── TIPE PANEL ──
function toggleTipePanel(e) {
    e.stopPropagation();
    document.getElementById('tipePanel').classList.toggle('show');
}
document.addEventListener('click', function(e) {
    const panel = document.getElementById('tipePanel');
    const btn   = document.getElementById('btnTipe');
    if (panel && !panel.contains(e.target) && e.target !== btn) {
        panel.classList.remove('show');
    }
});
function hapusTipe() {
    document.querySelectorAll('.tipe-cb').forEach(cb => cb.checked = false);
}
function simpanTipe() {
    const checked = [...document.querySelectorAll('.tipe-cb:checked')].map(cb => cb.value);
    const url = new URL(window.location.href);
    url.searchParams.delete('tipe');
    url.searchParams.delete('tipe');

if (checked.length > 0) {
    url.searchParams.set('tipe', checked[0]); // ambil 1 aja biar aman dulu
}
    window.location.href = url.toString();
}

// ── MAP ──
const kostsData = @json($kostsMap->values());

const map = L.map('map').setView([-2.5, 117.8], 5);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap', maxZoom: 19
}).addTo(map);

const markers   = {};
const allBounds = [];

function formatRp(n) {
    if (!n) return '-';
    if (n >= 1000000) return 'Rp' + (n / 1000000).toFixed(1).replace('.0', '') + 'jt';
    if (n >= 1000)    return 'Rp' + Math.round(n / 1000) + 'rb';
    return 'Rp' + n;
}

function addMarker(kost, lat, lng) {
    const icon = L.divIcon({
        className: '',
        html: '<div class="marker-price" id="marker-' + kost.id + '">' + formatRp(kost.harga) + '</div>',
        iconAnchor: [30, 12],
    });
    const m = L.marker([lat, lng], { icon }).addTo(map);
    m.bindPopup(
        '<div class="popup-nama">' + kost.nama + '</div>' +
        '<div style="font-size:.78rem;color:#64748b;margin:2px 0">' + kost.kota + '</div>' +
        '<div class="popup-harga">' + formatRp(kost.harga) + '<small style="font-weight:400;color:#94a3b8;font-size:.72rem">/bulan</small></div>' +
        '<a href="' + kost.url + '" class="popup-link">Lihat Detail &rarr;</a>'
    );
    markers[kost.id] = m;
    allBounds.push([lat, lng]);
}

async function geocodeAlamat(alamat) {
    try {
        const r = await fetch(
            'https://nominatim.openstreetmap.org/search?format=json&limit=1&q=' + encodeURIComponent(alamat),
            { headers: { 'Accept-Language': 'id' } }
        );
        const d = await r.json();
        if (d.length) return { lat: parseFloat(d[0].lat), lng: parseFloat(d[0].lon) };
    } catch(e) {}
    return null;
}

async function loadAllMarkers() {
    for (let i = 0; i < kostsData.length; i++) {
        const k = kostsData[i];
        if (k.lat && k.lng) {
            addMarker(k, k.lat, k.lng);
        } else {
            if (i > 0) await new Promise(r => setTimeout(r, 1200));
            const coord = await geocodeAlamat(k.alamat);
            if (coord) addMarker(k, coord.lat, coord.lng);
        }
    }
    if (allBounds.length > 0) {
        map.fitBounds(allBounds, { padding: [30, 30], maxZoom: 14 });
    }
}

loadAllMarkers();

function highlightMarker(id) {
    const el = document.getElementById('marker-' + id);
    if (el) el.classList.add('active');
    if (markers[id]) { markers[id].openPopup(); map.panTo(markers[id].getLatLng()); }
}
function unhighlightMarker(id) {
    const el = document.getElementById('marker-' + id);
    if (el) el.classList.remove('active');
}

function applySort(val) {
    const u = new URL(window.location.href);
    u.searchParams.set('sort', val);
    window.location.href = u.toString();
}

function setRange(min, max) {
    document.getElementById('inp_min').value = min;
    document.getElementById('inp_max').value = max;
}

</script>
</body>
</html>