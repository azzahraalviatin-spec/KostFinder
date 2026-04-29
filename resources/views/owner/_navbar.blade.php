{{-- ============================================================
     _navbar.blade.php  –  KostFinder Panel Owner
     ============================================================ --}}

<style>
  .topbar {
    height: 70px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 1.5rem;
    background: #fff;
    border-bottom: 1px solid #f0f3f8;
  }
  .topbar-left {
    display: flex;
    align-items: center;
    gap: 1rem;
  }
  .topbar-right {
    display: flex;
    align-items: center;
    gap: 1.2rem;
  }
  .search-box {
    display: flex;
    align-items: center;
    gap: .6rem;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    padding: 0 1rem;
    border-radius: 999px;
    height: 42px;
    width: 280px;
    transition: all .2s;
  }
  .search-box:focus-within {
    background: #fff;
    border-color: var(--primary);
    box-shadow: 0 0 0 4px rgba(232, 64, 28, 0.08);
  }
  .search-box input {
    border: none;
    background: transparent;
    font-size: .85rem;
    color: var(--dark);
    width: 100%;
    outline: none;
  }
  .icon-btn {
    width: 42px;
    height: 42px;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    background: #fff;
    color: #64748b;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all .2s;
    position: relative;
    text-decoration: none;
  }
  .icon-btn:hover {
    background: #f8fafc;
    color: var(--primary);
    border-color: var(--primary);
    transform: translateY(-2px);
  }
  .icon-btn i { font-size: 1.2rem; }
  .notif-dot {
    position: absolute;
    top: 10px;
    right: 10px;
    width: 8px;
    height: 8px;
    background: #ef4444;
    border: 2px solid #fff;
    border-radius: 50%;
  }
  .sidebar-toggle-btn {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    border: none;
    background: #fff5f2;
    color: var(--primary);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    cursor: pointer;
    transition: all .2s;
  }
  .sidebar-toggle-btn:hover { background: var(--primary); color: #fff; }

  @media (max-width: 768px) {
    .topbar-left span { display: none; }
    .search-box { width: 150px; }
  }
</style>

<div class="topbar">
  {{-- KIRI: toggle + tanggal --}}
  <div class="topbar-left">
    <button class="sidebar-toggle-btn" onclick="toggleSidebar()">
      <i class="bi bi-list"></i>
    </button>
    <div style="display: flex; flex-direction: column;">
      <span style="font-size: .85rem; font-weight: 700; color: #1e293b;">
        {{ now()->translatedFormat('l, d F Y') }}
      </span>
      <span style="font-size: .7rem; color: #94a3b8; font-weight: 500;">Panel Pemilik Kost</span>
    </div>
  </div>

  {{-- KANAN: search + notif + gear --}}
  <div class="topbar-right">
    {{-- SEARCH --}}
    @php
      $searchEnabled = request()->routeIs('owner.kost.*', 'owner.kamar.*', 'owner.booking.index');
    @endphp
    <div style="position:relative;">
      <div class="search-box" style="{{ !$searchEnabled ? 'opacity: 0.6; cursor:not-allowed;' : '' }}">
        <i class="bi bi-search" style="color: {{ $searchEnabled ? '#64748b' : '#cbd5e1' }};"></i>
        <input type="text"
               id="globalSearch"
               autocomplete="off"
               placeholder="{{ $searchEnabled ? 'Cari kost atau kamar...' : 'Pencarian tidak tersedia' }}"
               {{ !$searchEnabled ? 'disabled' : '' }}>
      </div>
      <div id="searchDropdown" style="display:none;position:absolute;top:calc(100% + 10px);right:0;width:320px;background:#fff;border-radius:1rem;border:1px solid #e2e8f0;box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);z-index:9999;overflow:hidden;">
        <div id="searchResults" style="max-height:350px;overflow-y:auto;"></div>
      </div>
    </div>

    {{-- NOTIFIKASI --}}
    @php
      $notifCount = \App\Models\Booking::whereHas('room.kost', fn($q) => $q->where('owner_id', auth()->id()))
        ->where('status_booking','pending')->count();
    @endphp
    <div style="position:relative;">
      <button class="icon-btn" id="notifBtn" onclick="toggleNotif()" title="Notifikasi">
        <i class="bi bi-bell"></i>
        @if($notifCount > 0)
          <span class="notif-dot" id="notifDot"></span>
        @endif
      </button>

      <div id="notifDropdown" style="display:none;position:absolute;top:calc(100% + 10px);right:0;width:320px;background:#fff;border-radius:1rem;border:1px solid #e2e8f0;box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);z-index:9999;overflow:hidden;">
        <div style="padding:1rem; border-bottom:1px solid #f1f5f9; display:flex; justify-content:space-between; align-items:center; background: #f8fafc;">
          <span style="font-size:.85rem; font-weight:800; color:#1e293b;">Notifikasi</span>
          @if($notifCount > 0)
            <span style="background:#ef4444; color:#fff; font-size:.65rem; font-weight:700; padding:.2rem .6rem; border-radius:999px;">{{ $notifCount }} baru</span>
          @endif
        </div>

        <div style="max-height:350px; overflow-y:auto;">
          @php
            $notifBookings = \App\Models\Booking::whereHas('room.kost', fn($q) => $q->where('owner_id', auth()->id()))
              ->where('status_booking','pending')
              ->with(['user','room.kost'])
              ->latest()->take(10)->get();
          @endphp

          @forelse($notifBookings as $nb)
            <a href="{{ route('owner.booking.index') }}"
               style="display:flex; align-items:flex-start; gap:.8rem; padding:1rem; text-decoration:none; border-bottom:1px solid #f1f5f9; transition:all .2s; background:#fff;"
               onmouseover="this.style.background='#f8fafc'"
               onmouseout="this.style.background='#fff'">
              <div style="width:36px; height:36px; border-radius:10px; background:#fff5f2; display:flex; align-items:center; justify-content:center; flex-shrink:0; font-size:1rem;">📋</div>
              <div style="flex:1; min-width:0;">
                <div style="font-size:.8rem; font-weight:700; color:#1e293b;">Booking Baru</div>
                <div style="font-size:.75rem; color:#64748b; margin-top:.2rem; line-height: 1.4;">
                  <strong>{{ $nb->user->name ?? 'User' }}</strong> memesan di <strong>{{ optional($nb->room->kost)->nama_kost ?? 'Kost' }}</strong>
                </div>
                <div style="font-size:.65rem; color:#94a3b8; margin-top:.4rem; display:flex; align-items:center; gap:.3rem;">
                   <i class="bi bi-clock"></i> {{ $nb->created_at->diffForHumans() }}
                </div>
              </div>
            </a>
          @empty
            <div style="text-align:center; padding:3rem 1.5rem; color:#94a3b8;">
              <i class="bi bi-bell-slash" style="font-size:2rem; display:block; margin-bottom:.5rem; opacity:.2;"></i>
              <div style="font-size:.85rem;">Tidak ada notifikasi baru</div>
            </div>
          @endforelse
        </div>

        @if($notifCount > 0)
          <div style="padding:.8rem; background:#f8fafc; text-align:center; border-top: 1px solid #f1f5f9;">
            <a href="{{ route('owner.booking.index') }}" style="font-size:.78rem; color:var(--primary); font-weight:700; text-decoration:none;">
              Lihat Semua Aktivitas <i class="bi bi-arrow-right ms-1"></i>
            </a>
          </div>
        @endif
      </div>
    </div>

    {{-- GEAR --}}
    <a href="{{ route('owner.pengaturan') }}" class="icon-btn" title="Pengaturan Akun">
      <i class="bi bi-person-gear"></i>
    </a>
  </div>
</div>

{{-- ── BANNER VERIFIKASI ── --}}
@if(auth()->user()->status_verifikasi_identitas !== 'disetujui')
  @php
    $vs = auth()->user()->status_verifikasi_identitas;
    $bannerStyle = match($vs) {
      'pending' => 'background:#fffbeb;border:1px solid #fde68a;border-left:4px solid #f59e0b;',
      'ditolak' => 'background:#fef2f2;border:1px solid #fecaca;border-left:4px solid #dc2626;',
      default   => 'background:#fff5f2;border:1px solid #ffd0c0;border-left:4px solid var(--primary);',
    };
    $bannerColor = match($vs) {
      'pending' => 'color:#b45309;',
      'ditolak' => 'color:#dc2626;',
      default   => 'color:#be3f1d;',
    };
    $bannerIcon  = match($vs) { 'pending' => '⏳', 'ditolak' => '❌', default => '⚠️' };
    $bannerTitle = match($vs) {
      'pending' => 'Identitas Sedang Direview Admin',
      'ditolak' => 'Verifikasi Ditolak',
      default   => 'Identitas Belum Diverifikasi',
    };
    $bannerDesc  = match($vs) {
      'pending' => 'Kost kamu belum tampil di halaman publik. Proses verifikasi maksimal 1×24 jam.',
      'ditolak' => auth()->user()->catatan_verifikasi ?? 'Dokumen tidak memenuhi syarat. Silakan upload ulang.',
      default   => 'Kost kamu tidak akan muncul di halaman publik sampai identitas diverifikasi admin.',
    };
    $btnLabel = $vs === 'ditolak' ? 'Upload Ulang' : 'Verifikasi Sekarang';
  @endphp
  <div style="margin:.75rem 1.5rem;padding:.85rem 1.2rem;border-radius:.75rem;display:flex;align-items:center;gap:.85rem;{{ $bannerStyle }}">
    <span style="font-size:1.3rem;flex-shrink:0;">{{ $bannerIcon }}</span>
    <div style="flex:1;">
      <div style="font-size:.85rem;font-weight:700;{{ $bannerColor }}">{{ $bannerTitle }}</div>
      <div style="font-size:.78rem;color:#888;margin-top:.15rem;">{{ $bannerDesc }}</div>
    </div>
    <a href="{{ route('owner.pengaturan') }}"
       style="background:var(--primary);color:#fff;font-size:.78rem;font-weight:700;padding:.45rem 1rem;border-radius:.5rem;text-decoration:none;white-space:nowrap;flex-shrink:0;">
      {{ $btnLabel }}
    </a>
  </div>
@endif

{{-- ── MODAL HAPUS ── --}}
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border:none;border-radius:1rem;overflow:hidden;box-shadow:0 20px 60px rgba(0,0,0,.15);">

      <div style="background:linear-gradient(135deg,#e8401c,#ff7043);padding:1.4rem 1.5rem;position:relative;">
        <div class="d-flex align-items-center gap-3">
          <div style="width:42px;height:42px;background:rgba(255,255,255,.2);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <i class="bi bi-trash3-fill" style="color:#fff;font-size:1.1rem;"></i>
          </div>
          <div>
            <h6 style="color:#fff;font-weight:800;margin:0;font-size:.95rem;">Konfirmasi Hapus</h6>
            <p style="color:rgba(255,255,255,.75);font-size:.73rem;margin:0;">Tindakan ini tidak dapat dibatalkan</p>
          </div>
        </div>
        <button type="button" data-bs-dismiss="modal"
          style="position:absolute;top:.9rem;right:1rem;background:rgba(255,255,255,.2);border:none;width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;cursor:pointer;color:#fff;font-size:.8rem;"
          onmouseover="this.style.background='rgba(255,255,255,.35)'"
          onmouseout="this.style.background='rgba(255,255,255,.2)'">
          <i class="bi bi-x-lg"></i>
        </button>
      </div>

      <div style="padding:1.4rem 1.5rem;background:#fff;">
        <div style="background:#fff5f2;border:1px solid #ffd0c0;border-radius:.65rem;padding:1rem 1.1rem;display:flex;align-items:flex-start;gap:.75rem;">
          <i class="bi bi-exclamation-triangle-fill" style="color:var(--primary);font-size:1.1rem;flex-shrink:0;margin-top:.1rem;"></i>
          <p style="margin:0;font-size:.83rem;color:var(--dark);font-weight:500;line-height:1.5;" id="deleteConfirmText">
            Anda yakin ingin menghapus data ini?
          </p>
        </div>
      </div>

      <div style="padding:.9rem 1.5rem 1.3rem;background:#fff;display:flex;gap:.7rem;justify-content:flex-end;border-top:1px solid #f0f3f8;">
        <button type="button" data-bs-dismiss="modal"
          style="background:#fff;border:1.5px solid var(--line);color:#555;font-size:.82rem;font-weight:600;padding:.5rem 1.2rem;border-radius:.6rem;cursor:pointer;"
          onmouseover="this.style.borderColor='#aab4be'"
          onmouseout="this.style.borderColor='var(--line)'">
          <i class="bi bi-x me-1"></i> Batal
        </button>
        <button type="button" id="deleteConfirmYes"
          style="background:linear-gradient(135deg,#e8401c,#ff7043);border:none;color:#fff;font-size:.82rem;font-weight:700;padding:.5rem 1.3rem;border-radius:.6rem;cursor:pointer;box-shadow:0 4px 14px rgba(232,64,28,.35);"
          onmouseover="this.style.transform='translateY(-1px)'"
          onmouseout="this.style.transform='translateY(0)'">
          <i class="bi bi-trash3 me-1"></i> Ya, Hapus
        </button>
      </div>

    </div>
  </div>
</div>

<script>
  (() => {
    let pendingForm = null;
    const getModal = () => {
      const el = document.getElementById('deleteConfirmModal');
      return el && typeof bootstrap !== 'undefined' ? bootstrap.Modal.getOrCreateInstance(el) : null;
    };
    document.addEventListener('submit', e => {
      const form = e.target;
      if (!form.matches('.js-confirm-delete')) return;
      if (form.dataset.confirmed === '1') { form.dataset.confirmed = '0'; return; }
      e.preventDefault();
      pendingForm = form;
      document.getElementById('deleteConfirmText').textContent = form.dataset.deleteMessage || 'Anda yakin ingin menghapus data ini?';
      getModal()?.show();
    });
    document.addEventListener('click', e => {
      if (!e.target.closest('#deleteConfirmYes') || !pendingForm) return;
      pendingForm.dataset.confirmed = '1';
      const f = pendingForm; pendingForm = null;
      getModal()?.hide();
      f.requestSubmit();
    });
  })();

  function toggleNotif() {
    const d = document.getElementById('notifDropdown');
    document.getElementById('searchDropdown').style.display = 'none';
    d.style.display = d.style.display === 'none' ? 'block' : 'none';
  }

  document.addEventListener('click', e => {
    if (!e.target.closest('#notifBtn') && !e.target.closest('#notifDropdown'))
      document.getElementById('notifDropdown').style.display = 'none';
    if (!e.target.closest('.search-box') && !e.target.closest('#searchDropdown'))
      document.getElementById('searchDropdown').style.display = 'none';
  });

  const searchInput    = document.getElementById('globalSearch');
  const searchDropdown = document.getElementById('searchDropdown');
  const searchResults  = document.getElementById('searchResults');

  searchInput?.addEventListener('input', function() {
    const q = this.value.trim();
    if (q.length < 2) { searchDropdown.style.display = 'none'; return; }
    searchResults.innerHTML = '<div style="padding:.8rem 1rem;font-size:.8rem;color:var(--muted);">Mencari...</div>';
    searchDropdown.style.display = 'block';
    fetch(`/owner/search?q=${encodeURIComponent(q)}`)
      .then(r => r.json())
      .then(data => {
        if (!data.length) {
          searchResults.innerHTML = '<div style="padding:1.2rem 1rem;text-align:center;font-size:.8rem;color:var(--muted);"><i class="bi bi-search" style="display:block;font-size:1.3rem;margin-bottom:.3rem;opacity:.3;"></i>Tidak ditemukan</div>';
          return;
        }
        searchResults.innerHTML = data.map(item => `
          <a href="${item.url}" style="display:flex;align-items:center;gap:.7rem;padding:.65rem 1rem;text-decoration:none;border-bottom:1px solid #f8fafd;background:#fff;"
             onmouseover="this.style.background='#f8fafd'" onmouseout="this.style.background='#fff'">
            <div style="width:30px;height:30px;border-radius:.4rem;background:#fff5f2;display:flex;align-items:center;justify-content:center;font-size:.8rem;flex-shrink:0;">${item.icon}</div>
            <div>
              <div style="font-size:.8rem;font-weight:600;color:var(--dark);">${item.title}</div>
              <div style="font-size:.72rem;color:var(--muted);">${item.subtitle}</div>
            </div>
          </a>
        `).join('');
      })
      .catch(() => {
        searchResults.innerHTML = '<div style="padding:.8rem 1rem;font-size:.8rem;color:var(--muted);">Gagal mencari</div>';
      });
  });

  searchInput?.addEventListener('focus', function() {
    if (this.value.trim().length >= 2) searchDropdown.style.display = 'block';
  });
</script>