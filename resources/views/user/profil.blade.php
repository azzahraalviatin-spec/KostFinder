<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profil Saya - KostFinder</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    * { margin:0; padding:0; box-sizing:border-box; }
    body { font-family:'Plus Jakarta Sans',sans-serif; background:#f2f5fa; padding-bottom:80px; }
    .profil-layout { max-width:1100px; margin:1.5rem auto; padding:0 1rem; display:flex; gap:1.2rem; align-items:flex-start; }
    .profil-left { width:300px; flex-shrink:0; display:flex; flex-direction:column; gap:.75rem; }
    .profil-user-card { background:#fff; border-radius:.85rem; border:1px solid #e4e9f0; padding:1rem 1.1rem; display:flex; align-items:center; justify-content:space-between; cursor:pointer; text-decoration:none; transition:box-shadow .2s; }
    .profil-user-card:hover { box-shadow:0 4px 16px rgba(0,0,0,.08); }
    .profil-user-left { display:flex; align-items:center; gap:.75rem; }
    .profil-avatar { width:48px; height:48px; border-radius:50%; background:#e8401c; color:#fff; font-weight:800; font-size:1.1rem; display:flex; align-items:center; justify-content:center; overflow:hidden; flex-shrink:0; }
    .profil-avatar img { width:48px; height:48px; object-fit:cover; border-radius:50%; }
    .profil-uname { font-weight:700; font-size:.9rem; color:#1a2332; }
    .profil-uemail { font-size:.72rem; color:#8fa3b8; }
    .profil-progress-card { background:#fff; border-radius:.85rem; border:1px solid #e4e9f0; padding:1rem 1.1rem; }
    .progress-wrap { height:5px; background:#f0f3f8; border-radius:999px; margin:.5rem 0 .35rem; overflow:hidden; }
    .progress-fill { height:100%; background:linear-gradient(90deg,#e8401c,#ff6b3d); border-radius:999px; }
    .profil-menu-card { background:#fff; border-radius:.85rem; border:1px solid #e4e9f0; overflow:hidden; }
    .menu-item { display:flex; align-items:center; gap:.75rem; padding:.78rem 1.1rem; border-bottom:1px solid #f8fafd; text-decoration:none; color:#374151; font-size:.84rem; font-weight:500; cursor:pointer; transition:background .15s; border-left:0; border-right:0; border-top:0; background:none; width:100%; text-align:left; }
    .menu-item:last-child { border-bottom:0; }
    .menu-item:hover { background:#fafbfd; }
    .menu-item.active { color:#e8401c; font-weight:700; background:#fff5f2; }
    .menu-item i { font-size:.95rem; color:#8fa3b8; width:18px; flex-shrink:0; }
    .menu-item.active i { color:#e8401c; }
    .menu-item-label { flex:1; }
    .menu-badge { background:#e8401c; color:#fff; font-size:.62rem; font-weight:800; padding:.1rem .4rem; border-radius:999px; }
    .menu-notif-dot { width:8px; height:8px; background:#e8401c; border-radius:50%; }
    .menu-logout { color:#dc2626 !important; }
    .menu-logout i { color:#dc2626 !important; }
    .menu-logout:hover { background:#fff5f5 !important; }
    .profil-right { flex:1; min-width:0; }
    .content-card { background:#fff; border-radius:.85rem; border:1px solid #e4e9f0; overflow:hidden; }
    .content-card-head { padding:1rem 1.2rem; border-bottom:1px solid #f0f3f8; font-weight:700; font-size:.95rem; color:#1a2332; }
    .content-card-body { padding:1.5rem 1.2rem; }
    .kos-empty { text-align:center; padding:1.5rem 1rem; }
    .kos-empty-icon { width:60px; height:60px; background:#f8fafd; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto .85rem; font-size:1.6rem; color:#c0ccd8; }
    .kos-empty h6 { font-weight:700; color:#1a2332; margin-bottom:.35rem; }
    .kos-empty p { font-size:.82rem; color:#8fa3b8; max-width:320px; margin:0 auto .9rem; }
    .btn-cari-kos { display:inline-flex; align-items:center; gap:.4rem; background:#e8401c; color:#fff; font-weight:700; border:0; border-radius:.6rem; padding:.6rem 1.4rem; font-size:.85rem; text-decoration:none; }
    .btn-cari-kos:hover { background:#cb3518; color:#fff; }
    table thead th { font-size:.68rem; font-weight:700; color:#8fa3b8; letter-spacing:.05em; border:0; padding:.6rem 1rem; background:#f8fafd; }
    table tbody td { font-size:.8rem; color:#333; padding:.65rem 1rem; border-color:#f0f3f8; vertical-align:middle; }
    .s-pill { padding:.18rem .6rem; border-radius:999px; font-size:.7rem; font-weight:600; display:inline-flex; align-items:center; gap:.25rem; }
    .s-pending { background:#fff7ed; color:#ea580c; }
    .s-diterima { background:#f0fdf4; color:#16a34a; }
    .s-ditolak { background:#fef2f2; color:#dc2626; }
    .s-selesai { background:#f0f9ff; color:#0284c7; }
    .review-card { border:1px solid #f0f3f8; border-radius:.65rem; padding:.85rem 1rem; margin-bottom:.65rem; }
    .review-stars { color:#f59e0b; font-size:.85rem; }
    .kos-card-riwayat { border:1px solid #f0f3f8; border-radius:.75rem; overflow:hidden; transition:box-shadow .2s; margin-bottom:.75rem; }
    .kos-card-riwayat:hover { box-shadow:0 4px 16px rgba(0,0,0,.07); }
    .riwayat-tab-btn { background:none; border:none; padding:.75rem 1.1rem .65rem; font-size:.85rem; font-weight:600; color:#8fa3b8; border-bottom:2px solid transparent; margin-bottom:-2px; cursor:pointer; transition:all .2s; }
    .riwayat-tab-btn.active { color:#e8401c; font-weight:700; border-bottom-color:#e8401c; }
    .modal-overlay { display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,.6); z-index:999999; align-items:center; justify-content:center; backdrop-filter:blur(4px); }
    .alasan-item { border:1.5px solid #e4e9f0; border-radius:.65rem; padding:.7rem 1rem; cursor:pointer; margin-bottom:.5rem; font-size:.85rem; color:#444; transition:all .2s; }
    .alasan-item:hover { border-color:#e8401c; background:#fff5f2; color:#e8401c; }

    /* ── MODAL DETAIL BARU ── */
    .md-wrap { background:#fff; border-radius:1.2rem; width:100%; max-width:500px; margin:1rem; box-shadow:0 24px 64px rgba(0,0,0,.22); max-height:92vh; overflow-y:auto; display:flex; flex-direction:column; }
    .md-header { padding:1.1rem 1.3rem; border-bottom:1px solid #f0f3f8; display:flex; align-items:center; justify-content:space-between; position:sticky; top:0; background:#fff; z-index:10; border-radius:1.2rem 1.2rem 0 0; }
    .md-header-title { font-weight:800; font-size:.95rem; color:#1a2332; display:flex; align-items:center; gap:.5rem; }
    .md-close { width:30px; height:30px; border-radius:50%; background:#f0f3f8; border:0; display:flex; align-items:center; justify-content:center; cursor:pointer; color:#555; font-size:.9rem; transition:background .15s; }
    .md-close:hover { background:#e4e9f0; }
    .md-body { padding:1.2rem 1.3rem; }
    .tgl-grid { display:grid; grid-template-columns:1fr 1fr; gap:.6rem; margin-bottom:.85rem; }
    .tgl-card { border-radius:.85rem; padding:.85rem .9rem; text-align:center; }
    .tgl-card.ci { background:#f0fdf4; border:1.5px solid #bbf7d0; }
    .tgl-card.co { background:#fef2f2; border:1.5px solid #fecaca; }
    .tgl-badge { font-size:.6rem; font-weight:800; letter-spacing:.07em; text-transform:uppercase; margin-bottom:.3rem; }
    .tgl-card.ci .tgl-badge { color:#16a34a; }
    .tgl-card.co .tgl-badge { color:#dc2626; }
    .tgl-tgl { font-size:.82rem; font-weight:800; color:#1a2332; line-height:1.3; }
    .tgl-jam { font-size:1.05rem; font-weight:900; color:#1a2332; margin-top:.3rem; font-variant-numeric:tabular-nums; }
    .tgl-sub { font-size:.67rem; color:#8fa3b8; margin-top:.15rem; }
    .info-grid { display:grid; grid-template-columns:1fr 1fr; gap:.5rem; margin-bottom:.85rem; }
    .ig-item { background:#f8fafd; border-radius:.65rem; padding:.6rem .8rem; }
    .ig-item.accent { background:#fff5f2; }
    .ig-label { font-size:.63rem; color:#aaa; margin-bottom:.15rem; }
    .ig-val { font-size:.82rem; font-weight:700; color:#1a2332; }
    .ig-item.accent .ig-val { color:#e8401c; font-size:.9rem; }
    .status-bar { display:flex; justify-content:space-between; align-items:center; padding:.7rem 1rem; border-radius:.75rem; margin-bottom:.75rem; }
    .bukti-box { border-radius:.85rem; overflow:hidden; margin-bottom:.75rem; }
    .bukti-head { padding:.6rem 1rem; display:flex; align-items:center; justify-content:space-between; border-bottom-width:1px; border-bottom-style:solid; }
    .bukti-img-wrap { position:relative; cursor:pointer; }
    .bukti-img-wrap img { width:100%; max-height:190px; object-fit:cover; display:block; }
    .bukti-overlay { position:absolute; bottom:0; left:0; right:0; background:linear-gradient(transparent,rgba(0,0,0,.55)); padding:.75rem .85rem .5rem; }
    .bukti-overlay span { color:#fff; font-size:.73rem; font-weight:700; }

    @media(max-width:768px) { .profil-layout { flex-direction:column; } .profil-left { width:100%; } }
  </style>
</head>
<body>

@php
  $user = auth()->user();
  $fields = ['name','email','no_hp','jenis_kelamin','tanggal_lahir','pekerjaan','kota'];
  $filled = collect($fields)->filter(fn($f) => !empty($user->$f))->count();
  $pct = round(($filled / count($fields)) * 100);
  $totalFavorit = \App\Models\Favorite::where('user_id',$user->id)->count();
  $totalReview  = \App\Models\Review::where('user_id',$user->id)->count();
  $bookings = \App\Models\Booking::where('user_id',$user->id)->with(['room.kost'])->latest()->get();
  $pendingCount = $bookings->where('status_booking','pending')->count();
  $tab = request('tab','riwayat-pengajuan');
@endphp

@include('layouts.navigation')

<div style="padding:.6rem 1.5rem;font-size:.78rem;color:#8fa3b8;background:#fff;border-bottom:1px solid #f0f3f8;">
  <a href="{{ route('home') }}" style="color:#8fa3b8;text-decoration:none;">Home</a>
  <i class="bi bi-chevron-right" style="font-size:.6rem;margin:0 .3rem;"></i>
  <span>Profil</span>
</div>

<div class="profil-layout">

  {{-- KIRI --}}
  <div class="profil-left">
    <a href="{{ route('user.profil.edit') }}" class="profil-user-card">
      <div class="profil-user-left">
        <div class="profil-avatar">
          @if($user->foto_profil)
            <img src="{{ asset('storage/'.$user->foto_profil) }}" alt="foto">
          @else
            {{ strtoupper(substr($user->name,0,1)) }}
          @endif
        </div>
        <div>
          <div class="profil-uname">{{ $user->name }}</div>
          <div class="profil-uemail">{{ $user->email }}</div>
        </div>
      </div>
      <i class="bi bi-chevron-right" style="color:#c0ccd8;"></i>
    </a>

    <div class="profil-progress-card">
      <div class="d-flex justify-content-between" style="font-size:.78rem;">
        <span style="font-weight:700;color:#e8401c;">{{ $pct }}%</span>
        <span style="color:#8fa3b8;">{{ $filled }}/{{ count($fields) }} data profil terisi</span>
      </div>
      <div class="progress-wrap"><div class="progress-fill" style="width:{{ $pct }}%"></div></div>
      <div style="font-size:.72rem;color:#8fa3b8;">Profil yang lengkap membantu kami memberikan rekomendasi yang lebih akurat.</div>
    </div>

    <div class="profil-menu-card">
      <a href="?tab=riwayat-pengajuan" class="menu-item {{ $tab=='riwayat-pengajuan'?'active':'' }}">
        <i class="bi bi-file-earmark-text"></i><span class="menu-item-label">Riwayat Pengajuan Sewa</span>
        @if($pendingCount>0)<span class="menu-badge">{{ $pendingCount }}</span>@endif
      </a>
      <a href="?tab=riwayat-kos" class="menu-item {{ $tab=='riwayat-kos'?'active':'' }}">
        <i class="bi bi-house-door"></i><span class="menu-item-label">Riwayat Kos</span>
      </a>
      <a href="?tab=riwayat-transaksi" class="menu-item {{ $tab=='riwayat-transaksi'?'active':'' }}">
        <i class="bi bi-receipt"></i><span class="menu-item-label">Riwayat Transaksi</span>
      </a>
      <a href="?tab=favorit" class="menu-item {{ $tab=='favorit'?'active':'' }}">
        <i class="bi bi-heart"></i><span class="menu-item-label">Kos Favorit</span>
      </a>
      <a href="?tab=voucher" class="menu-item {{ $tab=='voucher'?'active':'' }}">
        <i class="bi bi-ticket-perforated"></i><span class="menu-item-label">Voucher Saya</span>
      </a>
      <a href="?tab=verifikasi" class="menu-item {{ $tab=='verifikasi'?'active':'' }}">
        <i class="bi bi-patch-check"></i><span class="menu-item-label">Verifikasi Akun</span>
        @if(!$user->email_verified_at)<span class="menu-notif-dot"></span>@endif
      </a>
      <a href="?tab=review" class="menu-item {{ $tab=='review'?'active':'' }}">
        <i class="bi bi-star"></i><span class="menu-item-label">Review Saya</span>
      </a>
      <a href="?tab=pengaturan" class="menu-item {{ $tab=='pengaturan'?'active':'' }}">
        <i class="bi bi-gear"></i><span class="menu-item-label">Pengaturan</span>
      </a>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="menu-item menu-logout">
          <i class="bi bi-box-arrow-left"></i><span class="menu-item-label">Keluar</span>
        </button>
      </form>
    </div>
  </div>

  {{-- KANAN --}}
  <div class="profil-right">

    @if($tab=='riwayat-pengajuan')
    <div class="content-card">
      <div class="content-card-head">Riwayat Pengajuan Sewa</div>
      @if(session('success'))
        <div class="alert alert-success mx-3 mt-3 mb-0" style="font-size:.82rem;">{{ session('success') }}</div>
      @endif
      @if(session('error'))
        <div class="alert alert-danger mx-3 mt-3 mb-0" style="font-size:.82rem;">{{ session('error') }}</div>
      @endif
      @if($bookings->count() > 0)
        <div class="table-responsive">
          <table class="table mb-0">
            <thead>
              <tr><th>KOST</th><th>KAMAR</th><th>TGL PENGAJUAN</th><th>STATUS</th><th>AKSI</th></tr>
            </thead>
            <tbody>
              @foreach($bookings as $b)
              <tr>
                <td class="fw-semibold">{{ $b->room->kost->nama_kost ?? '—' }}</td>
                <td>No. {{ $b->room->nomor_kamar ?? '—' }}</td>
                <td>{{ \Carbon\Carbon::parse($b->created_at)->format('d M Y') }}</td>
                <td><span class="s-pill s-{{ $b->status_booking }}"><i class="bi bi-circle-fill" style="font-size:.35rem;"></i> {{ ucfirst($b->status_booking) }}</span></td>
                <td>
                  <div style="display:flex;gap:.35rem;flex-wrap:wrap;">
                    <button onclick="lihatDetail({{ $b->id_booking }})"
                      style="border:1px solid #e4e9f0;border-radius:.4rem;padding:.22rem .55rem;font-size:.72rem;font-weight:600;cursor:pointer;background:#f8fafd;color:#555;">
                      <i class="bi bi-eye"></i> Detail
                    </button>
                    @if($b->status_booking==='pending')
                      <button onclick="bukaModalBatal({{ $b->id_booking }}, '{{ addslashes($b->room->kost->nama_kost ?? '') }}')"
                        style="border:1px solid #fecaca;border-radius:.4rem;padding:.22rem .55rem;font-size:.72rem;font-weight:600;cursor:pointer;background:#fff;color:#dc2626;">
                        <i class="bi bi-x-circle"></i> Batal
                      </button>
                    @endif
                    @if($b->status_booking==='selesai')
                      @php $sudahReview = \App\Models\Review::where('booking_id', $b->id_booking)->exists(); @endphp
                      @if($sudahReview)
                        <span style="background:#f0fdf4;color:#16a34a;border:1px solid #bbf7d0;border-radius:.5rem;padding:.22rem .55rem;font-size:.72rem;font-weight:600;display:inline-flex;align-items:center;gap:.3rem;">
                          <i class="bi bi-check-circle-fill"></i> Sudah Direview
                        </span>
                      @else
                        <button onclick="bukaModalReview({{ $b->id_booking }}, '{{ addslashes($b->room->kost->nama_kost ?? '') }}')"
                          style="border:1px solid #f59e0b;border-radius:.4rem;padding:.22rem .55rem;font-size:.72rem;font-weight:600;cursor:pointer;background:#fffbeb;color:#d97706;display:inline-flex;align-items:center;gap:.3rem;">
                          <i class="bi bi-star-fill"></i> Beri Review
                        </button>
                      @endif
                    @endif
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @else
        <div class="content-card-body">
          <div class="kos-empty">
            <div class="kos-empty-icon"><i class="bi bi-file-earmark-text"></i></div>
            <h6>Belum ada pengajuan sewa</h6>
            <p>Pengajuan sewa akan muncul setelah kamu melakukan booking.</p>
            <a href="{{ route('home') }}" class="btn-cari-kos"><i class="bi bi-search"></i> Cari Kos Sekarang</a>
          </div>
        </div>
      @endif
    </div>
    @endif

    @if($tab=='riwayat-kos')
    @php
      $recentlyViewed = session('recently_viewed', []);
      $recentKosts = collect();
      if(!empty($recentlyViewed)) {
        $recentKosts = \App\Models\Kost::whereIn('id_kost', $recentlyViewed)
          ->orderByRaw('FIELD(id_kost, '.implode(',', $recentlyViewed).')')
          ->take(10)->get();
      }
      $semuaKos = $bookings->whereIn('status_booking',['diterima','selesai'])->sortByDesc('created_at');
    @endphp
    <div class="content-card">
      <div class="content-card-head">Riwayat Kos</div>
      <div style="display:flex;border-bottom:2px solid #f0f3f8;padding:0 1.2rem;">
        <button onclick="switchRiwayat('disewa')" id="tab-disewa" class="riwayat-tab-btn active">Pernah Disewa</button>
        <button onclick="switchRiwayat('dilihat')" id="tab-dilihat" class="riwayat-tab-btn">Pernah Dilihat</button>
      </div>
      <div id="konten-disewa" style="padding:.85rem 1.2rem 1rem;">
        @if($semuaKos->count() > 0)
          @foreach($semuaKos as $b)
          <div class="kos-card-riwayat">
            <div style="display:flex;gap:.85rem;padding:.85rem 1rem;align-items:center;">
              <div style="width:72px;height:64px;border-radius:.6rem;overflow:hidden;flex-shrink:0;background:#fff5f2;display:flex;align-items:center;justify-content:center;">
                @if($b->room->kost->foto_utama ?? null)
                  <img src="{{ asset('storage/'.$b->room->kost->foto_utama) }}" style="width:100%;height:100%;object-fit:cover;">
                @else
                  <span style="font-size:1.6rem;">🏠</span>
                @endif
              </div>
              <div style="flex:1;min-width:0;">
                <div style="font-weight:700;font-size:.88rem;color:#1a2332;">{{ $b->room->kost->nama_kost ?? '—' }}</div>
                <div style="font-size:.75rem;color:#8fa3b8;margin:.15rem 0;"><i class="bi bi-geo-alt"></i> {{ $b->room->kost->kota ?? '—' }} · Kamar No. {{ $b->room->nomor_kamar ?? '—' }}</div>
                <div style="font-size:.75rem;color:#8fa3b8;">
                  <i class="bi bi-calendar3"></i>
                  {{ \Carbon\Carbon::parse($b->tanggal_masuk)->format('d M Y') }}
                  @if($b->tanggal_selesai) → {{ \Carbon\Carbon::parse($b->tanggal_selesai)->format('d M Y') }} @endif
                </div>
              </div>
              <div style="text-align:right;flex-shrink:0;">
                <span class="s-pill s-{{ $b->status_booking }}"><i class="bi bi-circle-fill" style="font-size:.35rem;"></i> {{ $b->status_booking == 'diterima' ? 'Aktif' : 'Selesai' }}</span>
                <div style="font-size:.82rem;font-weight:800;color:#e8401c;margin-top:.3rem;">Rp {{ number_format($b->total_harga ?? 0, 0, ',', '.') }}</div>
              </div>
            </div>
          </div>
          @endforeach
        @else
          <div style="text-align:center;padding:1.5rem;">
            <div style="font-size:1.8rem;">🏠</div>
            <div style="font-size:.85rem;font-weight:700;color:#1a2332;margin:.4rem 0 .3rem;">Belum ada riwayat kos</div>
            <a href="{{ route('home') }}" class="btn-cari-kos mt-2"><i class="bi bi-search"></i> Cari Kos</a>
          </div>
        @endif
      </div>
      <div id="konten-dilihat" style="display:none;padding:.85rem 1.2rem 1rem;">
        @if($recentKosts->count() > 0)
          <div class="row g-2">
            @foreach($recentKosts as $k)
            <div class="col-6 col-md-4">
              <a href="{{ route('kost.show', $k->id_kost) }}" style="text-decoration:none;">
                <div style="border:1px solid #f0f3f8;border-radius:.65rem;overflow:hidden;">
                  @if($k->foto_utama)
                    <img src="{{ asset('storage/'.$k->foto_utama) }}" style="width:100%;height:90px;object-fit:cover;">
                  @else
                    <div style="width:100%;height:90px;background:#fff5f2;display:flex;align-items:center;justify-content:center;font-size:1.5rem;">🏠</div>
                  @endif
                  <div style="padding:.55rem .7rem;">
                    <div style="font-weight:700;font-size:.78rem;color:#1a2332;">{{ $k->nama_kost }}</div>
                    <div style="font-size:.68rem;color:#8fa3b8;"><i class="bi bi-geo-alt"></i> {{ $k->kota }}</div>
                    <div style="font-size:.78rem;font-weight:800;color:#e8401c;">Rp {{ number_format($k->harga_mulai,0,',','.') }}<span style="font-size:.62rem;font-weight:400;color:#8fa3b8;">/bln</span></div>
                  </div>
                </div>
              </a>
            </div>
            @endforeach
          </div>
        @else
          <div style="text-align:center;padding:1.5rem;">
            <div style="font-size:1.8rem;">👀</div>
            <div style="font-size:.85rem;font-weight:700;color:#1a2332;margin:.4rem 0;">Belum ada kos yang dilihat</div>
          </div>
        @endif
      </div>
    </div>
    @endif

    @if($tab=='riwayat-transaksi')
    <div class="content-card">
      <div class="content-card-head">Riwayat Transaksi</div>
      <div class="content-card-body">
        <div class="kos-empty">
          <div class="kos-empty-icon"><i class="bi bi-receipt"></i></div>
          <h6>Belum ada transaksi</h6>
          <p>Riwayat transaksi akan muncul setelah kamu melakukan pembayaran sewa kos.</p>
        </div>
      </div>
    </div>
    @endif

    @if($tab=='favorit')
    <div class="content-card">
      <div class="content-card-head">Kos Favorit</div>
      <div style="display:flex;border-bottom:2px solid #f0f3f8;padding:0 1.2rem;">
        <button onclick="switchFavorit('favorit')" id="tab-favorit" class="riwayat-tab-btn active">Kos Favorit</button>
        <button onclick="switchFavorit('dilihat')" id="tab-dilihat-fav" class="riwayat-tab-btn">Pernah Dilihat</button>
      </div>
      <div id="konten-favorit" class="content-card-body">
        @php $favorit = \App\Models\Favorite::where('user_id',$user->id)->with('kost')->get(); @endphp
        @if($favorit->count() > 0)
          <div class="row g-3">
            @foreach($favorit as $fav)
            <div class="col-12 col-md-6">
              <div style="border:1px solid #f0f3f8;border-radius:.75rem;overflow:hidden;position:relative;">
                <div onclick="hapusFavorit({{ $fav->id }}, this)" style="position:absolute;top:8px;right:8px;background:#fff;width:34px;height:34px;border-radius:50%;display:flex;align-items:center;justify-content:center;box-shadow:0 2px 8px rgba(0,0,0,.2);cursor:pointer;z-index:10;">
                  <i class="bi bi-heart-fill" style="color:#e8401c;"></i>
                </div>
                @if($fav->kost->foto_utama)
                  <img src="{{ asset('storage/'.$fav->kost->foto_utama) }}" style="width:100%;height:120px;object-fit:cover;">
                @endif
                <div style="padding:.75rem;">
                  <div style="font-weight:700;font-size:.85rem;color:#1a2332;">{{ $fav->kost->nama_kost }}</div>
                  <div style="font-size:.72rem;color:#8fa3b8;"><i class="bi bi-geo-alt"></i> {{ $fav->kost->kota }}</div>
                  <div style="font-size:.85rem;font-weight:800;color:#e8401c;margin-top:.3rem;">Rp {{ number_format($fav->kost->harga_mulai,0,',','.') }}<span style="font-size:.7rem;font-weight:400;color:#8fa3b8;">/bln</span></div>
                </div>
              </div>
            </div>
            @endforeach
          </div>
        @else
          <div class="kos-empty">
            <div class="kos-empty-icon"><i class="bi bi-heart"></i></div>
            <h6>Belum ada kos favorit</h6>
            <p>Simpan kos yang kamu suka dengan tombol ❤️</p>
          </div>
        @endif
      </div>
      <div id="konten-dilihat-fav" class="content-card-body" style="display:none;">
        <div class="kos-empty">
          <div class="kos-empty-icon"><i class="bi bi-eye"></i></div>
          <h6>Belum ada riwayat dilihat</h6>
        </div>
      </div>
    </div>
    @endif

    @if($tab=='voucher')
    <div class="content-card">
      <div class="content-card-head">Voucher Saya</div>
      <div class="content-card-body">
        <div class="kos-empty">
          <div class="kos-empty-icon"><i class="bi bi-ticket-perforated"></i></div>
          <h6>Belum ada voucher</h6>
          <p>Voucher diskon akan muncul di sini jika kamu memilikinya.</p>
        </div>
      </div>
    </div>
    @endif

    @if($tab=='verifikasi')
      @include('user._tab-verifikasi')
    @endif

    @if($tab=='review')
    <div class="content-card">
      <div class="content-card-head">Review Saya</div>
      <div class="content-card-body">
        @php $reviews = \App\Models\Review::where('user_id',$user->id)->with('kost')->latest()->get(); @endphp
        @if($reviews->count() > 0)
          @foreach($reviews as $rv)
          <div class="review-card">
            <div style="font-weight:700;font-size:.85rem;color:#1a2332;">{{ $rv->kost->nama_kost ?? '—' }}</div>
            <div class="review-stars">
              @for($i=1;$i<=5;$i++)<i class="bi bi-star{{ $i<=$rv->rating?'-fill':'' }}"></i>@endfor
              <span style="font-size:.75rem;color:#8fa3b8;">{{ $rv->rating }}/5</span>
            </div>
            <div style="font-size:.82rem;color:#374151;margin-top:.35rem;">{{ $rv->komentar }}</div>
            <div style="font-size:.7rem;color:#c0ccd8;margin-top:.3rem;">{{ \Carbon\Carbon::parse($rv->created_at)->format('d M Y') }}</div>
          </div>
          @endforeach
        @else
          <div class="kos-empty">
            <div class="kos-empty-icon"><i class="bi bi-star"></i></div>
            <h6>Belum ada review</h6>
            <p>Review muncul setelah booking kamu selesai.</p>
          </div>
        @endif
      </div>
    </div>
    @endif

    @if($tab=='pengaturan')
      @include('user._tab-pengaturan')
    @endif

  </div>
</div>

{{-- ═══════════════════════════════════════
     MODAL DETAIL BOOKING (BARU & CANTIK)
═══════════════════════════════════════ --}}
<div id="modalDetail" class="modal-overlay" onclick="if(event.target===this)tutupModalDetail()">
  <div class="md-wrap">
    <div class="md-header">
      <div class="md-header-title">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="1"/></svg>
        Detail Booking
      </div>
      <button class="md-close" onclick="tutupModalDetail()">✕</button>
    </div>
    <div class="md-body" id="modalDetailContent"></div>
  </div>
</div>

{{-- MODAL BATALKAN --}}
<div id="modalBatal" class="modal-overlay" onclick="if(event.target===this)document.getElementById('modalBatal').style.display='none'">
  <div style="background:#fff;border-radius:1rem;padding:1.8rem;width:100%;max-width:420px;margin:1rem;box-shadow:0 20px 60px rgba(0,0,0,.2);">
    <div style="font-weight:800;font-size:1rem;color:#1a2332;margin-bottom:.3rem;">🚫 Batalkan Booking</div>
    <div style="font-size:.8rem;color:#8fa3b8;margin-bottom:1.2rem;" id="modalBatalKost"></div>
    <form id="formBatal" method="POST">
      @csrf @method('PATCH')
      <input type="hidden" name="alasan_batal" id="alasanBatalInput">
      <div style="font-size:.82rem;font-weight:700;color:#444;margin-bottom:.6rem;">Pilih alasan pembatalan:</div>
      <div class="alasan-item" onclick="pilihAlasan('Berubah pikiran',this)">😅 Berubah pikiran</div>
      <div class="alasan-item" onclick="pilihAlasan('Salah pilih kamar',this)">🚪 Salah pilih kamar</div>
      <div class="alasan-item" onclick="pilihAlasan('Ada keperluan mendadak',this)">⚡ Ada keperluan mendadak</div>
      <div class="alasan-item" onclick="pilihAlasan('Menemukan kost yang lebih cocok',this)">🏠 Menemukan kost yang lebih cocok</div>
      <div class="alasan-item" onclick="pilihAlasan('lainnya',this)">✏️ Alasan lain</div>
      <div id="alasanLainWrap" style="display:none;margin-top:.5rem;">
        <textarea id="alasanLainText" class="form-control" rows="2" placeholder="Tulis alasanmu..." style="font-size:.82rem;border-radius:.6rem;"></textarea>
      </div>
      <div class="d-flex gap-2 mt-3">
        <button type="button" onclick="document.getElementById('modalBatal').style.display='none'" style="flex:1;padding:.6rem;border-radius:.55rem;border:1.5px solid #e4e9f0;background:#fff;font-size:.85rem;font-weight:600;color:#555;cursor:pointer;">Kembali</button>
        <button type="submit" id="btnKonfirmasiBatal" disabled style="flex:1;padding:.6rem;border-radius:.55rem;border:0;background:#dc2626;color:#fff;font-size:.85rem;font-weight:700;cursor:pointer;opacity:.5;">🚫 Konfirmasi Batal</button>
      </div>
    </form>
  </div>
</div>

{{-- MODAL REVIEW --}}
<div id="modalReview" class="modal-overlay" onclick="if(event.target===this)tutupModalReview()">
  <div style="background:#fff;border-radius:1rem;padding:1.8rem;width:100%;max-width:500px;margin:1rem;box-shadow:0 20px 60px rgba(0,0,0,.2);max-height:90vh;overflow-y:auto;">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.2rem;">
      <div>
        <div style="font-weight:800;font-size:1rem;color:#1a2332;">⭐ Beri Review</div>
        <div id="reviewNamaKost" style="font-size:.78rem;color:#8fa3b8;margin-top:.15rem;"></div>
      </div>
      <button onclick="tutupModalReview()" style="background:none;border:0;font-size:1.2rem;color:#aaa;cursor:pointer;">✕</button>
    </div>
    <form id="formReview" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="booking_id" id="reviewBookingId">
      <div style="text-align:center;margin-bottom:1.2rem;background:#fffbeb;border-radius:.75rem;padding:1rem;">
        <div style="font-size:.82rem;font-weight:700;color:#374151;margin-bottom:.5rem;">Rating Keseluruhan</div>
        <div class="star-group" data-name="rating" style="font-size:2rem;display:flex;justify-content:center;gap:.3rem;">
          @for($i=1;$i<=5;$i++)<span class="star" data-val="{{ $i }}" style="cursor:pointer;color:#d1d5db;transition:color .15s;">★</span>@endfor
        </div>
        <div class="star-label" style="font-size:.78rem;color:#8fa3b8;margin-top:.3rem;min-height:1.1rem;"></div>
        <input type="hidden" name="rating" class="star-input" value="">
      </div>
      <div style="margin-bottom:1rem;">
        <div style="font-size:.84rem;font-weight:700;color:#374151;margin-bottom:.65rem;">Penilaian Per Aspek</div>
        <div style="display:flex;flex-direction:column;gap:.5rem;">
          @foreach(['kebersihan'=>'🧹 Kebersihan','fasilitas'=>'🛋️ Fasilitas','lokasi'=>'📍 Lokasi','harga'=>'💰 Harga'] as $key=>$label)
          <div style="display:flex;align-items:center;justify-content:space-between;background:#f8fafd;border-radius:.6rem;padding:.55rem .85rem;">
            <span style="font-size:.82rem;color:#374151;font-weight:600;">{{ $label }}</span>
            <div class="star-group" data-name="rating_{{ $key }}" style="font-size:1.25rem;display:flex;gap:.15rem;">
              @for($i=1;$i<=5;$i++)<span class="star" data-val="{{ $i }}" style="cursor:pointer;color:#d1d5db;transition:color .15s;">★</span>@endfor
            </div>
            <input type="hidden" name="rating_{{ $key }}" class="star-input" value="">
          </div>
          @endforeach
        </div>
      </div>
      <div style="margin-bottom:1rem;">
        <div style="font-size:.84rem;font-weight:700;color:#374151;margin-bottom:.4rem;">Komentar <span style="font-weight:400;color:#8fa3b8;">(opsional)</span></div>
        <textarea name="komentar" rows="3" placeholder="Ceritakan pengalamanmu..." style="width:100%;border:1px solid #e4e9f0;border-radius:.6rem;padding:.6rem .85rem;font-size:.84rem;font-family:'Plus Jakarta Sans',sans-serif;outline:none;resize:none;" onfocus="this.style.borderColor='#e8401c'" onblur="this.style.borderColor='#e4e9f0'"></textarea>
      </div>
      <div style="display:flex;gap:.5rem;">
        <button type="button" onclick="tutupModalReview()" style="flex:1;padding:.65rem;border-radius:.55rem;border:1.5px solid #e4e9f0;background:#fff;font-size:.85rem;font-weight:600;color:#555;cursor:pointer;">Batal</button>
        <button type="submit" id="btnKirimReview" style="flex:2;padding:.65rem;border-radius:.55rem;border:0;background:#e8401c;color:#fff;font-size:.85rem;font-weight:700;cursor:pointer;">
          <i class="bi bi-send"></i> Kirim Review
        </button>
      </div>
    </form>
  </div>
</div>

@php
$bookingJson = $bookings->map(function($b) {
    return [
      'id'          => $b->id_booking,
      'kost'        => $b->room->kost->nama_kost ?? '—',
      'kamar'       => 'Kamar '.($b->room->nomor_kamar ?? '—').($b->room->tipe_kamar ? ' · '.$b->room->tipe_kamar : ''),
      'lokasi'      => $b->room->kost->kota ?? '—',
      'alamat'      => $b->room->kost->alamat ?? '',
      'checkin'     => \Carbon\Carbon::parse($b->tanggal_masuk)->translatedFormat('d M Y'),
      'checkout'    => $b->tanggal_selesai ? \Carbon\Carbon::parse($b->tanggal_selesai)->translatedFormat('d M Y') : '—',
      'durasi'      => ($b->durasi_sewa ?? '—').' '.($b->tipe_durasi === 'harian' ? 'Hari' : 'Bulan'),
      'total'       => 'Rp '.number_format($b->total_harga ?? 0, 0, ',', '.'),
      'metode'      => $b->metode_pembayaran ?? '—',
      'status'      => $b->status_booking,
      'statusBayar' => $b->status_pembayaran ?? 'belum',
      'alasan'      => $b->alasan_batal ?? '',
      'tglPengajuan'=> \Carbon\Carbon::parse($b->created_at)->translatedFormat('d M Y'),
      'bukti'       => $b->bukti_pembayaran ? asset('storage/'.$b->bukti_pembayaran) : null,
    ];
  })->keyBy('id');
@endphp

@include('layouts._bottom-nav')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
const bookingData = @json($bookingJson);
const starLabels  = ['','Sangat Buruk','Buruk','Cukup','Bagus','Sangat Bagus'];

// ── SWITCH TAB ──
function switchRiwayat(tab) {
  document.getElementById('konten-disewa').style.display  = tab==='disewa'?'block':'none';
  document.getElementById('konten-dilihat').style.display = tab==='dilihat'?'block':'none';
  document.getElementById('tab-disewa').classList.toggle('active', tab==='disewa');
  document.getElementById('tab-dilihat').classList.toggle('active', tab==='dilihat');
}
function switchFavorit(tab) {
  document.getElementById('konten-favorit').style.display     = tab==='favorit'?'block':'none';
  document.getElementById('konten-dilihat-fav').style.display = tab==='dilihat'?'block':'none';
  document.getElementById('tab-favorit').classList.toggle('active', tab==='favorit');
  document.getElementById('tab-dilihat-fav').classList.toggle('active', tab==='dilihat');
}

// ── MODAL DETAIL ──
function tutupModalDetail() {
  document.getElementById('modalDetail').style.display = 'none';
  clearInterval(window._jamInterval);
}

function jamSekarang() {
  const n = new Date();
  return String(n.getHours()).padStart(2,'0')+':'+String(n.getMinutes()).padStart(2,'0')+' WIB';
}

function lihatDetail(id) {
  const d = bookingData[id];
  if (!d) return;

  const scMap = {pending:'#ea580c',diterima:'#16a34a',ditolak:'#dc2626',selesai:'#0284c7'};
  const sbMap = {pending:'#fff7ed',diterima:'#f0fdf4',ditolak:'#fef2f2',selesai:'#f0f9ff'};
  const slMap = {pending:'⏳ Menunggu',diterima:'✅ Diterima',ditolak:'❌ Ditolak',selesai:'🏁 Selesai'};
  const sc = scMap[d.status]||'#aaa';
  const sb = sbMap[d.status]||'#f8fafd';
  const sl = slMap[d.status]||d.status;

  // Bukti transfer HTML
  let buktiHtml = '';
  if (d.statusBayar === 'menunggu' || d.statusBayar === 'lunas') {
    const isLunas   = d.statusBayar === 'lunas';
    const bBorder   = isLunas ? '#bbf7d0' : '#fde68a';
    const bBg       = isLunas ? '#f0fdf4'  : '#fffbf0';
    const bColor    = isLunas ? '#16a34a'  : '#b45309';
    const bLabel    = isLunas ? '✅ Pembayaran Dikonfirmasi' : '⏳ Menunggu Konfirmasi';
    const bSub      = isLunas ? 'Pemilik kos telah mengkonfirmasi pembayaranmu' : 'Menunggu konfirmasi dari pemilik kos';

    buktiHtml = `
      <div style="border:1.5px solid ${bBorder};border-radius:.85rem;overflow:hidden;margin-bottom:.75rem;">
        <div style="background:${bBg};padding:.65rem 1rem;display:flex;align-items:center;justify-content:space-between;border-bottom:1px solid ${bBorder};">
          <span style="font-size:.78rem;font-weight:700;color:${bColor};">💳 Status Pembayaran</span>
          <span style="font-size:.72rem;font-weight:700;color:${bColor};">${bLabel}</span>
        </div>
        ${d.bukti ? `
        <div style="padding:.85rem 1rem;">
          <div style="font-size:.75rem;font-weight:700;color:#555;margin-bottom:.55rem;">📸 Bukti Transfer</div>
          <div style="border-radius:.75rem;overflow:hidden;border:1px solid #e4e9f0;cursor:pointer;position:relative;" onclick="bukaLightbox('${d.bukti}')">
            <img src="${d.bukti}" style="width:100%;max-height:200px;object-fit:cover;display:block;">
            <div style="position:absolute;bottom:0;left:0;right:0;background:linear-gradient(transparent,rgba(0,0,0,.55));padding:.75rem .85rem .5rem;">
              <span style="color:#fff;font-size:.73rem;font-weight:700;">
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="margin-right:4px;"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/><line x1="11" y1="8" x2="11" y2="14"/><line x1="8" y1="11" x2="14" y2="11"/></svg>
                Klik untuk perbesar
              </span>
            </div>
          </div>
          <div style="font-size:.72rem;color:#8fa3b8;margin-top:.45rem;">${bSub}</div>
        </div>` : `<div style="padding:.75rem 1rem;font-size:.8rem;color:#8fa3b8;">${bSub}</div>`}
      </div>`;
  } else if (d.statusBayar === 'belum' && d.status === 'pending') {
    buktiHtml = `
      <div style="border:1.5px solid #ffd0c0;border-radius:.85rem;overflow:hidden;margin-bottom:.75rem;">
        <div style="background:#fff5f2;padding:.65rem 1rem;border-bottom:1px solid #ffd0c0;">
          <span style="font-size:.78rem;font-weight:700;color:#be3f1d;">⚠️ Belum Upload Bukti Pembayaran</span>
        </div>
        <div style="padding:.75rem 1rem;font-size:.8rem;color:#8fa3b8;">Segera upload bukti transfer untuk memproses booking kamu.</div>
      </div>`;
  }

  document.getElementById('modalDetailContent').innerHTML = `
    <!-- HEADER KOST -->
    <div style="background:linear-gradient(135deg,#fff5f2,#fff);border:1.5px solid #ffd0c0;border-radius:.9rem;padding:1rem 1.1rem;margin-bottom:1rem;">
      <div style="font-weight:800;font-size:1rem;color:#1a2332;margin-bottom:.35rem;">${d.kost}</div>
      <div style="display:flex;flex-wrap:wrap;gap:.3rem .85rem;font-size:.75rem;color:#8fa3b8;">
        <span>🚪 ${d.kamar}</span>
        <span>📍 ${d.lokasi}</span>
        ${d.alamat ? `<span>🗺️ ${d.alamat}</span>` : ''}
      </div>
    </div>

    <!-- CHECK-IN / CHECK-OUT -->
    <div class="tgl-grid">
      <div class="tgl-card ci">
        <div class="tgl-badge">Check-In</div>
        <div class="tgl-tgl">${d.checkin}</div>
        <div class="tgl-jam" id="jamCheckinModal">${jamSekarang()}</div>
        <div class="tgl-sub">Jam check-in sekarang</div>
      </div>
      <div class="tgl-card co">
        <div class="tgl-badge">Check-Out</div>
        <div class="tgl-tgl">${d.checkout}</div>
        <div class="tgl-jam">12:00 WIB</div>
        <div class="tgl-sub">Batas check-out</div>
      </div>
    </div>

    <!-- INFO GRID -->
    <div class="info-grid">
      <div class="ig-item"><div class="ig-label">⏱️ Durasi</div><div class="ig-val">${d.durasi}</div></div>
      <div class="ig-item accent"><div class="ig-label">💰 Total Biaya</div><div class="ig-val">${d.total}</div></div>
      <div class="ig-item"><div class="ig-label">💳 Metode Bayar</div><div class="ig-val">${d.metode}</div></div>
      <div class="ig-item"><div class="ig-label">📋 Tgl Pengajuan</div><div class="ig-val">${d.tglPengajuan}</div></div>
    </div>

    <!-- STATUS BOOKING -->
    <div style="display:flex;justify-content:space-between;align-items:center;padding:.75rem 1rem;background:${sb};border:1.5px solid ${sc}44;border-radius:.8rem;margin-bottom:.75rem;">
      <span style="font-size:.83rem;font-weight:700;color:#374151;">Status Booking</span>
      <span style="font-size:.8rem;font-weight:800;color:${sc};">${sl}</span>
    </div>

    <!-- BUKTI PEMBAYARAN -->
    ${buktiHtml}

    <!-- ALASAN BATAL -->
    ${d.alasan ? `
    <div style="background:#f8fafd;border:1px solid #e4e9f0;border-radius:.8rem;padding:.8rem 1rem;display:flex;gap:.6rem;">
      <span>💬</span>
      <div>
        <div style="font-size:.72rem;font-weight:700;color:#8fa3b8;margin-bottom:.2rem;">Alasan Pembatalan</div>
        <div style="font-size:.82rem;color:#374151;">${d.alasan}</div>
      </div>
    </div>` : ''}
  `;

  document.getElementById('modalDetail').style.display = 'flex';

  // Update jam check-in tiap 30 detik
  clearInterval(window._jamInterval);
  window._jamInterval = setInterval(() => {
    const el = document.getElementById('jamCheckinModal');
    if (!el) { clearInterval(window._jamInterval); return; }
    el.textContent = jamSekarang();
  }, 30000);
}

// ── LIGHTBOX BUKTI ──
function bukaLightbox(src) {
  const lb = document.createElement('div');
  lb.style.cssText = 'position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,.9);z-index:9999999;display:flex;align-items:center;justify-content:center;cursor:zoom-out;';
  lb.innerHTML = `
    <img src="${src}" style="max-width:92vw;max-height:88vh;border-radius:.85rem;box-shadow:0 20px 60px rgba(0,0,0,.5);">
    <div style="position:absolute;top:1rem;right:1.2rem;color:#fff;font-size:2rem;cursor:pointer;line-height:1;background:rgba(255,255,255,.15);border-radius:50%;width:40px;height:40px;display:flex;align-items:center;justify-content:center;">✕</div>`;
  lb.onclick = () => document.body.removeChild(lb);
  document.body.appendChild(lb);
}

// ── MODAL BATAL ──
function bukaModalBatal(bookingId, namaKost) {
  document.getElementById('formBatal').action = `/user/booking/${bookingId}/cancel`;
  document.getElementById('modalBatalKost').textContent = '🏠 ' + namaKost;
  document.getElementById('modalBatal').style.display = 'flex';
  document.querySelectorAll('.alasan-item').forEach(i => { i.style.borderColor='#e4e9f0'; i.style.background='#fff'; i.style.color='#444'; });
  document.getElementById('alasanBatalInput').value = '';
  document.getElementById('alasanLainWrap').style.display = 'none';
  document.getElementById('btnKonfirmasiBatal').disabled = true;
  document.getElementById('btnKonfirmasiBatal').style.opacity = '.5';
}
function pilihAlasan(alasan, el) {
  document.querySelectorAll('.alasan-item').forEach(i => { i.style.borderColor='#e4e9f0'; i.style.background='#fff'; i.style.color='#444'; });
  el.style.borderColor='#e8401c'; el.style.background='#fff5f2'; el.style.color='#e8401c';
  if (alasan==='lainnya') {
    document.getElementById('alasanLainWrap').style.display='block';
    document.getElementById('alasanBatalInput').value='';
    document.getElementById('btnKonfirmasiBatal').disabled=true;
    document.getElementById('btnKonfirmasiBatal').style.opacity='.5';
  } else {
    document.getElementById('alasanLainWrap').style.display='none';
    document.getElementById('alasanBatalInput').value=alasan;
    document.getElementById('btnKonfirmasiBatal').disabled=false;
    document.getElementById('btnKonfirmasiBatal').style.opacity='1';
  }
}
document.getElementById('alasanLainText')?.addEventListener('input', function() {
  const ada = this.value.trim().length > 0;
  document.getElementById('alasanBatalInput').value = this.value;
  document.getElementById('btnKonfirmasiBatal').disabled = !ada;
  document.getElementById('btnKonfirmasiBatal').style.opacity = ada?'1':'.5';
});

// ── MODAL REVIEW ──
function bukaModalReview(bookingId, namaKost) {
  document.getElementById('reviewBookingId').value = bookingId;
  document.getElementById('reviewNamaKost').textContent = '🏠 ' + namaKost;
  document.querySelectorAll('#modalReview .star-input').forEach(i => i.value = '');
  document.querySelectorAll('#modalReview .star').forEach(s => s.style.color = '#d1d5db');
  document.querySelectorAll('#modalReview .star-label').forEach(l => l.textContent = '');
  document.getElementById('formReview').querySelector('textarea').value = '';
  document.getElementById('modalReview').style.display = 'flex';
}
function tutupModalReview() { document.getElementById('modalReview').style.display = 'none'; }

document.querySelectorAll('#modalReview .star-group').forEach(group => {
  const stars = group.querySelectorAll('.star');
  const input = group.parentElement.querySelector('.star-input');
  const label = group.parentElement.querySelector('.star-label');
  stars.forEach(star => {
    star.addEventListener('mouseover', function() {
      const val = +this.dataset.val;
      stars.forEach(s => s.style.color = +s.dataset.val <= val ? '#f59e0b' : '#d1d5db');
      if(label) label.textContent = starLabels[val];
    });
    star.addEventListener('mouseout', function() {
      const cur = input ? +input.value : 0;
      stars.forEach(s => s.style.color = +s.dataset.val <= cur ? '#f59e0b' : '#d1d5db');
      if(label) label.textContent = cur ? starLabels[cur] : '';
    });
    star.addEventListener('click', function() {
      const val = +this.dataset.val;
      if(input) input.value = val;
      stars.forEach(s => s.style.color = +s.dataset.val <= val ? '#f59e0b' : '#d1d5db');
      if(label) label.textContent = starLabels[val];
    });
  });
});

document.getElementById('formReview').addEventListener('submit', function(e) {
  e.preventDefault();
  const inputs = this.querySelectorAll('.star-input');
  for(let inp of inputs) {
    if(!inp.value) {
      Swal.fire({ icon:'warning', title:'Oops!', text:'Lengkapi semua penilaian bintang dulu ya!', confirmButtonColor:'#e8401c' });
      return;
    }
  }
  const formData = new FormData(this);
  const btn = document.getElementById('btnKirimReview');
  btn.disabled = true;
  btn.innerHTML = '<i class="bi bi-hourglass-split"></i> Mengirim...';
  fetch('{{ route("user.review.store") }}', {
    method: 'POST',
    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    if(data.success) {
      tutupModalReview();
      Swal.fire({ icon:'success', title:'Review Terkirim! 🎉', timer:2000, showConfirmButton:false }).then(() => location.reload());
    } else {
      Swal.fire({ icon:'error', title:'Gagal', text: data.error ?? 'Terjadi kesalahan.', confirmButtonColor:'#e8401c' });
    }
  })
  .finally(() => { btn.disabled=false; btn.innerHTML='<i class="bi bi-send"></i> Kirim Review'; });
});

// ── HAPUS FAVORIT ──
function hapusFavorit(id, el) {
  Swal.fire({
    title:'Hapus Favorit?', text:'Yakin ingin menghapus dari favorit?', icon:'warning',
    showCancelButton:true, confirmButtonColor:'#e8401c', cancelButtonColor:'#8fa3b8',
    confirmButtonText:'Ya, Hapus', cancelButtonText:'Batal',
  }).then(result => {
    if(result.isConfirmed) {
      fetch(`/user/favorit/${id}`, {
        method:'DELETE',
        headers:{ 'X-CSRF-TOKEN':'{{ csrf_token() }}', 'Accept':'application/json' }
      }).then(res => res.json()).then(data => {
        if(data.success) {
          el.closest('.col-12.col-md-6').remove();
          Swal.fire({ title:'Terhapus!', icon:'success', timer:1500, showConfirmButton:false });
        }
      });
    }
  });
}
</script>
</body>
</html>