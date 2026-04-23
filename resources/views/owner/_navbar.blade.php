{{-- ============================================================
     _navbar.blade.php  –  KostFinder Panel Owner
     ============================================================ --}}

<div class="topbar">

{{-- KIRI: toggle + tanggal (tanpa garis/divider) --}}
<div class="topbar-left">
  <button class="sidebar-toggle-btn" onclick="toggleSidebar()">
    <i class="bi bi-list"></i>
  </button>
  <span style="font-size:.85rem;font-weight:600;color:var(--dark);">
    {{ now()->translatedFormat('l, d F Y') }}
  </span>
</div>

  {{-- KANAN: search + notif + gear --}}
  <div class="topbar-right">

    {{-- SEARCH --}}
    @php
      $searchEnabled = request()->routeIs('owner.kost.*', 'owner.kamar.*', 'owner.booking.index');
    @endphp
    <div style="position:relative;">
      <div class="search-box" style="{{ !$searchEnabled ? 'background:#f3f4f6;cursor:not-allowed;' : '' }}">
        <i class="bi bi-search" style="font-size:.85rem;color:{{ $searchEnabled ? 'var(--muted)' : '#c5cdd8' }};"></i>
        <input type="text"
               id="globalSearch"
               autocomplete="off"
               placeholder="{{ $searchEnabled ? 'Cari kost atau kamar...' : 'Pencarian tidak tersedia' }}"
               {{ !$searchEnabled ? 'disabled' : '' }}>
      </div>
      <div id="searchDropdown" style="display:none;position:absolute;top:calc(100% + 6px);right:0;width:280px;background:#fff;border-radius:.75rem;border:1px solid var(--line);box-shadow:0 8px 24px rgba(0,0,0,.1);z-index:9999;overflow:hidden;">
        <div id="searchResults" style="max-height:300px;overflow-y:auto;"></div>
      </div>
    </div>

    {{-- NOTIFIKASI --}}
    @php
      $notifCount = \App\Models\Booking::whereHas('room.kost', fn($q) => $q->where('owner_id', auth()->id()))
        ->where('status_booking','pending')->count();
    @endphp
    <div style="position:relative;">
      <button class="icon-btn" id="notifBtn" onclick="toggleNotif()">
        <i class="bi bi-bell"></i>
        @if($notifCount > 0)
          <span class="notif-dot" id="notifDot"></span>
        @endif
      </button>

      <div id="notifDropdown" style="display:none;position:absolute;top:calc(100% + 6px);right:0;width:300px;background:#fff;border-radius:.75rem;border:1px solid var(--line);box-shadow:0 8px 24px rgba(0,0,0,.1);z-index:9999;overflow:hidden;">
        <div style="padding:.75rem 1rem;border-bottom:1px solid #f0f3f8;display:flex;justify-content:space-between;align-items:center;">
          <span style="font-size:.82rem;font-weight:700;color:var(--dark);">Notifikasi</span>
          @if($notifCount > 0)
            <span style="background:var(--primary);color:#fff;font-size:.65rem;font-weight:700;padding:.15rem .5rem;border-radius:999px;">{{ $notifCount }} baru</span>
          @endif
        </div>

        <div style="max-height:320px;overflow-y:auto;">
          @php
            $notifBookings = \App\Models\Booking::whereHas('room.kost', fn($q) => $q->where('owner_id', auth()->id()))
              ->where('status_booking','pending')
              ->with(['user','room.kost'])
              ->latest()->take(10)->get();
          @endphp

          @forelse($notifBookings as $nb)
            <a href="{{ route('owner.booking.index') }}"
               style="display:flex;align-items:flex-start;gap:.7rem;padding:.75rem 1rem;text-decoration:none;border-bottom:1px solid #f8fafd;transition:background .15s;background:#fff;"
               onmouseover="this.style.background='#f8fafd'"
               onmouseout="this.style.background='#fff'">
              <div style="width:32px;height:32px;border-radius:50%;background:#fff5f2;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:.85rem;">📋</div>
              <div style="flex:1;min-width:0;">
                <div style="font-size:.8rem;font-weight:600;color:var(--dark);">Booking Baru Masuk</div>
                <div style="font-size:.73rem;color:var(--muted);margin-top:.15rem;">
                  {{ $nb->user->name ?? '—' }} → {{ optional($nb->room->kost)->nama_kost ?? '—' }}
                </div>
                <div style="font-size:.7rem;color:#bbb;margin-top:.1rem;">{{ $nb->created_at->diffForHumans() }}</div>
              </div>
              <span style="background:#fff7ed;color:#ea580c;font-size:.65rem;font-weight:700;padding:.15rem .5rem;border-radius:999px;flex-shrink:0;">Pending</span>
            </a>
          @empty
            <div style="text-align:center;padding:2rem 1rem;color:var(--muted);font-size:.82rem;">
              <i class="bi bi-bell-slash" style="font-size:1.5rem;display:block;margin-bottom:.4rem;opacity:.3;"></i>
              Tidak ada notifikasi baru
            </div>
          @endforelse
        </div>

        @if($notifCount > 0)
          <div style="padding:.6rem 1rem;border-top:1px solid #f0f3f8;text-align:center;">
            <a href="{{ route('owner.booking.index') }}" style="font-size:.78rem;color:var(--primary);font-weight:600;text-decoration:none;">
              Lihat Semua Booking →
            </a>
          </div>
        @endif
      </div>
    </div>

    {{-- GEAR --}}
    <a href="{{ route('owner.pengaturan') }}" class="icon-btn">
      <i class="bi bi-gear"></i>
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