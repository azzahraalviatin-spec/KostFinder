@extends('admin.layout')

@section('title', 'Monitoring User')
@section('page_title', 'Monitoring Data User')
@section('page_subtitle', 'Kelola akun user: cari, filter, detail, nonaktifkan, dan hapus')

@section('content')
<div class="card-panel">

  {{-- FILTER --}}
  <form method="GET" action="{{ route('admin.users') }}" class="row g-2 mb-4">
    <div class="col-md-5">
      <div style="position:relative;">
        <i class="bi bi-search" style="position:absolute;left:.75rem;top:50%;transform:translateY(-50%);color:#8fa3b8;font-size:.85rem;"></i>
        <input type="text" name="q" value="{{ request('q') }}" class="form-control"
          placeholder="Cari nama, email, no hp..."
          style="padding-left:2.2rem;border-radius:.6rem;border-color:#e4e9f0;font-size:.85rem;">
      </div>
    </div>
    <div class="col-md-3">
      <select name="status" class="form-select" style="border-radius:.6rem;border-color:#e4e9f0;font-size:.85rem;">
        <option value="">Semua Status</option>
        <option value="aktif" @selected(request('status')==='aktif')>Aktif</option>
        <option value="nonaktif" @selected(request('status')==='nonaktif')>Nonaktif</option>
      </select>
    </div>
    <div class="col-md-4 d-flex gap-2">
      <button type="submit"
        style="background:linear-gradient(135deg,#e8401c,#ff7043);border:none;color:#fff;font-size:.85rem;font-weight:600;padding:.5rem 1.2rem;border-radius:.6rem;cursor:pointer;box-shadow:0 4px 10px rgba(232,64,28,.3);">
        <i class="bi bi-funnel me-1"></i> Filter
      </button>
      <a href="{{ route('admin.users') }}"
        style="background:#fff;border:1.5px solid #e4e9f0;color:#555;font-size:.85rem;font-weight:600;padding:.5rem 1.2rem;border-radius:.6rem;text-decoration:none;display:inline-flex;align-items:center;gap:.4rem;">
        <i class="bi bi-arrow-counterclockwise"></i> Reset
      </a>
    </div>
  </form>

  {{-- SUMMARY --}}
  <div class="row g-3 mb-4">
    <div class="col-md-3">
      <div style="background:#fff5f2;border:1px solid #ffd0c0;border-radius:.75rem;padding:.85rem 1rem;display:flex;align-items:center;gap:.75rem;">
        <div style="width:40px;height:40px;background:#e8401c;border-radius:.6rem;display:flex;align-items:center;justify-content:center;font-size:1.1rem;">👥</div>
        <div>
          <div style="font-size:1.3rem;font-weight:800;color:#1e2d3d;">{{ $users->total() }}</div>
          <div style="font-size:.72rem;color:#8fa3b8;">Total User</div>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:.75rem;padding:.85rem 1rem;display:flex;align-items:center;gap:.75rem;">
        <div style="width:40px;height:40px;background:#16a34a;border-radius:.6rem;display:flex;align-items:center;justify-content:center;font-size:1.1rem;">✅</div>
        <div>
          <div style="font-size:1.3rem;font-weight:800;color:#1e2d3d;">{{ $users->where('status_akun','aktif')->count() }}</div>
          <div style="font-size:.72rem;color:#8fa3b8;">User Aktif</div>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div style="background:#fef2f2;border:1px solid #fecaca;border-radius:.75rem;padding:.85rem 1rem;display:flex;align-items:center;gap:.75rem;">
        <div style="width:40px;height:40px;background:#dc2626;border-radius:.6rem;display:flex;align-items:center;justify-content:center;font-size:1.1rem;">⛔</div>
        <div>
          <div style="font-size:1.3rem;font-weight:800;color:#1e2d3d;">{{ $users->where('status_akun','nonaktif')->count() }}</div>
          <div style="font-size:.72rem;color:#8fa3b8;">User Nonaktif</div>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div style="background:#fffbeb;border:1px solid #fde68a;border-radius:.75rem;padding:.85rem 1rem;display:flex;align-items:center;gap:.75rem;">
        <div style="width:40px;height:40px;background:#f59e0b;border-radius:.6rem;display:flex;align-items:center;justify-content:center;font-size:1.1rem;">⏳</div>
        <div>
          <div style="font-size:1.3rem;font-weight:800;color:#1e2d3d;">{{ $users->where('status_verifikasi_identitas','pending')->count() }}</div>
          <div style="font-size:.72rem;color:#8fa3b8;">Pending Verifikasi</div>
        </div>
      </div>
    </div>
  </div>

  {{-- TABEL --}}
  <div class="table-responsive">
    <table class="table mb-0 align-middle">
      <thead>
        <tr>
          <th style="font-size:.68rem;font-weight:700;color:#8fa3b8;background:#f8fafd;border:0;padding:.75rem 1rem;">USER</th>
          <th style="font-size:.68rem;font-weight:700;color:#8fa3b8;background:#f8fafd;border:0;padding:.75rem 1rem;">KONTAK</th>
          <th style="font-size:.68rem;font-weight:700;color:#8fa3b8;background:#f8fafd;border:0;padding:.75rem 1rem;">STATUS AKUN</th>
          <th style="font-size:.68rem;font-weight:700;color:#8fa3b8;background:#f8fafd;border:0;padding:.75rem 1rem;">VERIFIKASI</th>
          <th style="font-size:.68rem;font-weight:700;color:#8fa3b8;background:#f8fafd;border:0;padding:.75rem 1rem;">TERDAFTAR</th>
          <th style="font-size:.68rem;font-weight:700;color:#8fa3b8;background:#f8fafd;border:0;padding:.75rem 1rem;">AKSI</th>
        </tr>
      </thead>
      <tbody>
        @forelse($users as $user)
        <tr style="border-color:#f0f3f8;">
          {{-- USER --}}
          <td style="padding:.75rem 1rem;">
            <div style="display:flex;align-items:center;gap:.75rem;">
              @if($user->foto_profil)
                <img src="{{ asset('storage/'.$user->foto_profil) }}"
                     style="width:38px;height:38px;border-radius:50%;object-fit:cover;border:2px solid #ffd0c0;flex-shrink:0;">
              @else
                <div style="width:38px;height:38px;border-radius:50%;background:linear-gradient(135deg,#e8401c,#ff7043);color:#fff;font-weight:800;font-size:.9rem;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                  {{ strtoupper(substr($user->name,0,1)) }}
                </div>
              @endif
              <div>
                <div style="font-size:.85rem;font-weight:700;color:#1e2d3d;">{{ $user->name }}</div>
                <div style="font-size:.73rem;color:#8fa3b8;">{{ $user->email }}</div>
              </div>
            </div>
          </td>

          {{-- KONTAK --}}
          <td style="padding:.75rem 1rem;">
            <div style="font-size:.82rem;color:#555;">
              <i class="bi bi-phone" style="color:#8fa3b8;font-size:.75rem;"></i>
              {{ $user->no_hp ?? '-' }}
            </div>
          </td>

          {{-- STATUS AKUN --}}
          <td style="padding:.75rem 1rem;">
            @if($user->status_akun === 'aktif')
              <span style="background:#f0fdf4;color:#16a34a;border:1px solid #bbf7d0;font-size:.72rem;font-weight:700;padding:.25rem .7rem;border-radius:999px;">
                ✅ Aktif
              </span>
            @else
              <span style="background:#f8fafd;color:#8fa3b8;border:1px solid #e4e9f0;font-size:.72rem;font-weight:700;padding:.25rem .7rem;border-radius:999px;">
                ⛔ Nonaktif
              </span>
            @endif
          </td>

          {{-- VERIFIKASI --}}
          <td style="padding:.75rem 1rem;">
            @php
              $v = $user->status_verifikasi_identitas ?? 'belum';
              $vConfig = match($v) {
                'disetujui' => ['bg'=>'#f0fdf4','color'=>'#16a34a','border'=>'#bbf7d0','text'=>'✅ Terverifikasi'],
                'pending'   => ['bg'=>'#fffbeb','color'=>'#b45309','border'=>'#fde68a','text'=>'⏳ Pending'],
                'ditolak'   => ['bg'=>'#fef2f2','color'=>'#dc2626','border'=>'#fecaca','text'=>'❌ Ditolak'],
                default     => ['bg'=>'#f8fafd','color'=>'#8fa3b8','border'=>'#e4e9f0','text'=>'— Belum Upload'],
              };
            @endphp
            <span style="background:{{ $vConfig['bg'] }};color:{{ $vConfig['color'] }};border:1px solid {{ $vConfig['border'] }};font-size:.72rem;font-weight:700;padding:.25rem .7rem;border-radius:999px;white-space:nowrap;">
              {{ $vConfig['text'] }}
            </span>
          </td>

          {{-- TERDAFTAR --}}
          <td style="padding:.75rem 1rem;font-size:.8rem;color:#8fa3b8;">
            {{ $user->created_at?->format('d M Y') }}<br>
            <span style="font-size:.72rem;">{{ $user->created_at?->format('H:i') }}</span>
          </td>

          {{-- AKSI --}}
          <td style="padding:.75rem 1rem;">
            <div class="d-flex gap-1 flex-wrap">
              <a href="{{ route('admin.users.show', $user) }}"
                style="background:#fff5f2;color:#e8401c;border:1px solid #ffd0c0;font-size:.75rem;font-weight:600;padding:.3rem .75rem;border-radius:.45rem;text-decoration:none;white-space:nowrap;">
                <i class="bi bi-eye me-1"></i>Detail
              </a>
              <button type="button"
  onclick="bukaModalToggle({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ $user->status_akun }}')"
  style="background:#fffbeb;color:#b45309;border:1px solid #fde68a;font-size:.75rem;font-weight:600;padding:.3rem .75rem;border-radius:.45rem;cursor:pointer;white-space:nowrap;">
  {{ $user->status_akun === 'aktif' ? '⛔ Nonaktifkan' : '✅ Aktifkan' }}
</button>

<form id="formToggle-{{ $user->id }}"
  method="POST"
  action="{{ route('admin.users.toggle-status', $user) }}"
  style="display:none;">
  @csrf @method('PATCH')
</form>
              <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                onsubmit="return confirm('Hapus akun user {{ $user->name }}?')">
                @csrf @method('DELETE')
                <button type="submit"
                  style="background:#fef2f2;color:#dc2626;border:1px solid #fecaca;font-size:.75rem;font-weight:600;padding:.3rem .75rem;border-radius:.45rem;cursor:pointer;white-space:nowrap;">
                  <i class="bi bi-trash me-1"></i>Hapus
                </button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="6" style="text-align:center;padding:2.5rem;color:#8fa3b8;font-size:.85rem;">
            <i class="bi bi-people" style="font-size:2rem;display:block;margin-bottom:.5rem;opacity:.3;"></i>
            Belum ada user ditemukan
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- PAGINATION --}}
  <div class="mt-3">
    {{ $users->links() }}
  </div>

</div>
{{-- MODAL TOGGLE STATUS --}}
<div class="modal fade" id="modalToggleStatus" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width:420px;">
    <div class="modal-content" style="border-radius:20px;border:none;box-shadow:0 24px 64px rgba(0,0,0,.18);overflow:hidden;">

      {{-- Top section --}}
      <div style="padding:32px 28px 20px;text-align:center;">
        <div id="mtIconRing"
          style="width:64px;height:64px;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 18px;">
          <svg id="mtIconSvg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></svg>
        </div>
        <h5 id="mtJudul" style="font-size:1rem;font-weight:700;color:#1e2d3d;margin:0 0 8px;"></h5>
        <p id="mtDesc" style="font-size:.83rem;color:#6b7a8d;line-height:1.65;margin:0;"></p>

        {{-- User chip --}}
        <div style="display:inline-flex;align-items:center;gap:8px;background:#f8fafd;border:1px solid #e4e9f0;border-radius:999px;padding:6px 14px 6px 8px;margin-top:14px;">
          <div id="mtAvatar" style="width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;color:#fff;flex-shrink:0;"></div>
          <span id="mtNama" style="font-size:.83rem;font-weight:600;color:#1e2d3d;"></span>
        </div>
      </div>

      {{-- Divider --}}
      <hr style="margin:0;border-color:#f0f3f8;">

      {{-- Footer --}}
      <div style="padding:18px 28px;display:flex;gap:10px;">
        <button type="button" data-bs-dismiss="modal"
          style="flex:1;padding:11px;border-radius:10px;border:1.5px solid #e4e9f0;background:#fff;color:#555;font-size:.85rem;font-weight:600;cursor:pointer;">
          Batal
        </button>
        <button type="button" id="mtBtnKonfirm"
          style="flex:1.4;padding:11px;border-radius:10px;border:none;color:#fff;font-size:.85rem;font-weight:600;cursor:pointer;">
          Konfirmasi
        </button>
      </div>

    </div>
  </div>
</div>

<script>
let _formToggleId = null;

function bukaModalToggle(userId, nama, status) {
  _formToggleId = 'formToggle-' + userId;

  const iconRing  = document.getElementById('mtIconRing');
  const iconSvg   = document.getElementById('mtIconSvg');
  const judul     = document.getElementById('mtJudul');
  const desc      = document.getElementById('mtDesc');
  const avatar    = document.getElementById('mtAvatar');
  const namaEl    = document.getElementById('mtNama');
  const btnKonfirm = document.getElementById('mtBtnKonfirm');

  namaEl.textContent  = nama;
  avatar.textContent  = nama.charAt(0).toUpperCase();

  if (status === 'aktif') {
    iconRing.style.background   = '#FCEBEB';
    iconSvg.setAttribute('stroke', '#A32D2D');
    iconSvg.innerHTML = '<circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/>';
    judul.textContent           = 'Nonaktifkan pengguna ini?';
    desc.textContent            = 'Pengguna tidak akan bisa login selama akun dinonaktifkan. Kamu bisa mengaktifkannya kembali kapan saja.';
    avatar.style.background     = '#e8401c';
    btnKonfirm.textContent      = 'Ya, nonaktifkan';
    btnKonfirm.style.background = '#A32D2D';
  } else {
    iconRing.style.background   = '#EAF3DE';
    iconSvg.setAttribute('stroke', '#3B6D11');
    iconSvg.innerHTML = '<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>';
    judul.textContent           = 'Aktifkan pengguna ini?';
    desc.textContent            = 'Pengguna akan bisa login dan menggunakan platform kembali setelah diaktifkan.';
    avatar.style.background     = '#6b7280';
    btnKonfirm.textContent      = 'Ya, aktifkan';
    btnKonfirm.style.background = '#3B6D11';
  }

  new bootstrap.Modal(document.getElementById('modalToggleStatus')).show();
}

document.getElementById('mtBtnKonfirm').addEventListener('click', () => {
  if (_formToggleId) document.getElementById(_formToggleId).submit();
});
</script>
@endsection