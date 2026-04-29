@extends('admin.layout')

@section('title', 'Detail User')
@section('page_title', 'Detail User')

@section('content')
<div class="container-fluid">

  {{-- TOMBOL KEMBALI --}}
  <div class="mb-4 d-flex align-items-center justify-content-between">
    <a href="{{ route('admin.users') }}"
       class="text-decoration-none d-inline-flex align-items-center gap-2"
       style="background:linear-gradient(135deg,#e8401c,#ff7043);color:#fff;font-size:.85rem;font-weight:600;padding:.5rem 1.2rem;border-radius:.6rem;box-shadow:0 4px 14px rgba(232,64,28,.35);transition:all .2s;"
       onmouseover="this.style.background='linear-gradient(135deg,#cb3518,#e8401c)';this.style.transform='translateY(-1px)'"
       onmouseout="this.style.background='linear-gradient(135deg,#e8401c,#ff7043)';this.style.transform='translateY(0)'">
      <i class="bi bi-arrow-left-circle-fill" style="font-size:1rem;"></i>
      Kembali ke Monitoring User
    </a>
    <div style="font-size:.78rem;color:#8fa3b8;">
      <i class="bi bi-people me-1"></i> Monitoring User /
      <span style="color:#1e2d3d;font-weight:600;">{{ $user->name }}</span>
    </div>
  </div>

  @if(session('status'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="font-size:.85rem;">
      {{ session('status') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  <div class="row g-3">

    {{-- KOLOM KIRI --}}
    <div class="col-md-4">

      {{-- PROFIL CARD --}}
      <div class="card border-0 shadow-sm mb-3" style="border-radius:1rem;overflow:hidden;">
        {{-- HEADER GRADASI --}}
        <div style="background:linear-gradient(135deg,#e8401c,#ff7043);padding:1.5rem;text-align:center;">
          @if($user->foto_profil)
            <img src="{{ asset('storage/'.$user->foto_profil) }}"
                 style="width:80px;height:80px;border-radius:50%;object-fit:cover;border:3px solid rgba(255,255,255,.5);margin-bottom:.75rem;">
          @else
            <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2"
                 style="width:80px;height:80px;background:rgba(255,255,255,.25);color:#fff;font-size:2rem;font-weight:800;">
              {{ strtoupper(substr($user->name,0,1)) }}
            </div>
          @endif
          <div style="color:#fff;font-weight:800;font-size:1.1rem;">{{ $user->name }}</div>
          <div style="color:rgba(255,255,255,.8);font-size:.78rem;">{{ $user->email }}</div>
          <div class="mt-2">
            <span style="background:rgba(255,255,255,.2);color:#fff;font-size:.72rem;font-weight:700;padding:.25rem .75rem;border-radius:999px;border:1px solid rgba(255,255,255,.3);">
              {{ $user->status_akun === 'aktif' ? '✅ Aktif' : '⛔ Nonaktif' }}
            </span>
          </div>
        </div>

        {{-- INFO --}}
        <div class="p-3">
          @php
            $infoItems = [
              ['icon' => 'bi-phone', 'label' => 'No HP', 'value' => $user->no_hp ?? '-'],
              ['icon' => 'bi-gender-ambiguous', 'label' => 'Jenis Kelamin', 'value' => ucfirst($user->jenis_kelamin ?? '-')],
              ['icon' => 'bi-calendar3', 'label' => 'Tanggal Lahir', 'value' => $user->tanggal_lahir ? \Carbon\Carbon::parse($user->tanggal_lahir)->format('d M Y') : '-'],
              ['icon' => 'bi-briefcase', 'label' => 'Pekerjaan', 'value' => ucfirst($user->pekerjaan ?? '-')],
              ['icon' => 'bi-geo-alt', 'label' => 'Kota Asal', 'value' => $user->kota ?? '-'],
              ['icon' => 'bi-mortarboard', 'label' => 'Pendidikan', 'value' => strtoupper($user->pendidikan ?? '-')],
              ['icon' => 'bi-clock-history', 'label' => 'Tanggal Daftar', 'value' => $user->created_at->format('d M Y H:i')],
            ];
          @endphp

          @foreach($infoItems as $item)
          <div class="d-flex align-items-center gap-3 py-2" style="border-bottom:1px solid #f0f3f8;">
            <div style="width:32px;height:32px;background:#fff5f2;border-radius:.5rem;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
              <i class="bi {{ $item['icon'] }}" style="color:#e8401c;font-size:.85rem;"></i>
            </div>
            <div>
              <div style="font-size:.68rem;color:#8fa3b8;font-weight:600;">{{ $item['label'] }}</div>
              <div style="font-size:.83rem;color:#1e2d3d;font-weight:600;">{{ $item['value'] }}</div>
            </div>
          </div>
          @endforeach
        </div>
      </div>

      {{-- VERIFIKASI IDENTITAS CARD --}}
      <div class="card border-0 shadow-sm" style="border-radius:1rem;overflow:hidden;">
        <div style="padding:.9rem 1.2rem;border-bottom:1px solid #f0f3f8;display:flex;align-items:center;gap:.6rem;">
          <div style="width:32px;height:32px;background:#fff5f2;border-radius:.5rem;display:flex;align-items:center;justify-content:center;">
            <i class="bi bi-person-vcard" style="color:#e8401c;"></i>
          </div>
          <span style="font-weight:700;font-size:.9rem;color:#1e2d3d;">Verifikasi Identitas</span>
        </div>

        <div class="p-3">
          @php
            $status = $user->status_verifikasi_identitas ?? 'belum';
            $statusConfig = match($status) {
              'disetujui' => ['bg' => '#f0fdf4', 'border' => '#bbf7d0', 'color' => '#16a34a', 'text' => '✅ Disetujui'],
              'pending'   => ['bg' => '#fffbeb', 'border' => '#fde68a', 'color' => '#b45309', 'text' => '⏳ Menunggu Review'],
              'ditolak'   => ['bg' => '#fef2f2', 'border' => '#fecaca', 'color' => '#dc2626', 'text' => '❌ Ditolak'],
              default     => ['bg' => '#f8fafd', 'border' => '#e4e9f0', 'color' => '#8fa3b8', 'text' => '— Belum Upload'],
            };
          @endphp

          <div style="background:{{ $statusConfig['bg'] }};border:1px solid {{ $statusConfig['border'] }};border-radius:.65rem;padding:.6rem 1rem;margin-bottom:1rem;display:flex;align-items:center;gap:.5rem;">
            <span style="font-size:.82rem;font-weight:700;color:{{ $statusConfig['color'] }};">{{ $statusConfig['text'] }}</span>
          </div>

          <div class="mb-3">
            <div style="font-size:.7rem;color:#8fa3b8;font-weight:600;margin-bottom:.3rem;">JENIS IDENTITAS</div>
            <div style="font-size:.85rem;font-weight:700;color:#1e2d3d;">{{ strtoupper($user->jenis_identitas ?? '-') }}</div>
          </div>

          @if($user->foto_ktp)
          <div class="mb-3">
            <div style="font-size:.7rem;color:#8fa3b8;font-weight:600;margin-bottom:.5rem;">FOTO IDENTITAS</div>
            <div style="position:relative;border-radius:.65rem;overflow:hidden;border:1px solid #e4e9f0;cursor:pointer;"
                 onclick="window.open('{{ asset('storage/'.$user->foto_ktp) }}','_blank')">
              <img src="{{ asset('storage/'.$user->foto_ktp) }}" style="width:100%;display:block;">
              <div style="position:absolute;inset:0;background:rgba(0,0,0,.3);display:flex;align-items:center;justify-content:center;opacity:0;transition:opacity .2s;"
                   onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0'">
                <span style="color:#fff;font-size:.8rem;font-weight:700;"><i class="bi bi-zoom-in me-1"></i>Perbesar</span>
              </div>
            </div>
            <small style="font-size:.7rem;color:#8fa3b8;">Klik untuk perbesar</small>
          </div>
          @endif

          @if($status === 'pending')
          <div class="d-flex gap-2 mt-2">
            <form method="POST" action="{{ route('admin.users.verify', $user->id) }}" class="flex-fill">
              @csrf @method('PATCH')
              <button type="submit"
                style="width:100%;background:linear-gradient(135deg,#16a34a,#22c55e);border:none;color:#fff;font-size:.82rem;font-weight:700;padding:.5rem;border-radius:.55rem;cursor:pointer;box-shadow:0 4px 10px rgba(22,163,74,.3);">
                <i class="bi bi-check-circle me-1"></i> Setujui
              </button>
            </form>
            <button type="button"
              style="flex:1;background:linear-gradient(135deg,#dc2626,#ef4444);border:none;color:#fff;font-size:.82rem;font-weight:700;padding:.5rem;border-radius:.55rem;cursor:pointer;box-shadow:0 4px 10px rgba(220,38,38,.3);"
              onclick="document.getElementById('formTolak').style.display='block';this.style.display='none'">
              <i class="bi bi-x-circle me-1"></i> Tolak
            </button>
          </div>

          <div id="formTolak" style="display:none;margin-top:.75rem;">
            <form method="POST" action="{{ route('admin.users.reject', $user->id) }}">
              @csrf @method('PATCH')
              <textarea name="catatan" rows="2" class="form-control mb-2"
                placeholder="Tulis alasan penolakan..." required
                style="font-size:.82rem;border-radius:.5rem;border-color:#e4e9f0;"
                onfocus="this.style.borderColor='#e8401c'" onblur="this.style.borderColor='#e4e9f0'"></textarea>
              <button type="submit"
                style="width:100%;background:linear-gradient(135deg,#dc2626,#ef4444);border:none;color:#fff;font-size:.82rem;font-weight:700;padding:.5rem;border-radius:.55rem;cursor:pointer;">
                <i class="bi bi-x-circle me-1"></i> Konfirmasi Tolak
              </button>
            </form>
          </div>
          @endif

          @if($user->catatan_verifikasi)
          <div style="margin-top:.75rem;background:#fef2f2;border:1px solid #fecaca;border-radius:.55rem;padding:.65rem .85rem;font-size:.8rem;color:#dc2626;">
            <strong>Catatan:</strong> {{ $user->catatan_verifikasi }}
          </div>
          @endif

        </div>
      </div>

    </div>

    {{-- KOLOM KANAN --}}
    <div class="col-md-8">

      {{-- STAT --}}
      <div class="row g-3 mb-3">
        <div class="col-md-6">
          <div class="card border-0 shadow-sm p-3" style="border-radius:1rem;">
            <div style="display:flex;align-items:center;gap:.85rem;">
              <div style="width:46px;height:46px;background:#fff5f2;border-radius:.75rem;display:flex;align-items:center;justify-content:center;font-size:1.3rem;">📋</div>
              <div>
                <div style="font-size:1.6rem;font-weight:800;color:#1e2d3d;line-height:1;">{{ $totalBooking }}</div>
                <div style="font-size:.75rem;color:#8fa3b8;">Total Booking</div>
                <div style="font-size:.7rem;color:#e8401c;font-weight:600;">Aktivitas user</div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card border-0 shadow-sm p-3" style="border-radius:1rem;">
            <div style="display:flex;align-items:center;gap:.85rem;">
              <div style="width:46px;height:46px;background:#f0fdf4;border-radius:.75rem;display:flex;align-items:center;justify-content:center;font-size:1.3rem;">
                {{ $user->status_akun === 'aktif' ? '✅' : '⛔' }}
              </div>
              <div>
                <div style="font-size:1.1rem;font-weight:800;color:{{ $user->status_akun === 'aktif' ? '#16a34a' : '#dc2626' }};line-height:1.2;">
                  {{ ucfirst($user->status_akun ?? 'aktif') }}
                </div>
                <div style="font-size:.75rem;color:#8fa3b8;">Status Akun</div>
                <div style="font-size:.7rem;color:#8fa3b8;">
                  {{ $user->status_akun === 'aktif' ? 'User dapat booking' : 'User tidak dapat booking' }}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- RIWAYAT BOOKING --}}
      <div class="card border-0 shadow-sm" style="border-radius:1rem;overflow:hidden;">
        <div style="padding:.9rem 1.2rem;border-bottom:1px solid #f0f3f8;display:flex;align-items:center;gap:.6rem;">
          <div style="width:32px;height:32px;background:#fff5f2;border-radius:.5rem;display:flex;align-items:center;justify-content:center;">
            <i class="bi bi-journal-check" style="color:#e8401c;"></i>
          </div>
          <span style="font-weight:700;font-size:.9rem;color:#1e2d3d;">Riwayat Booking</span>
        </div>

        @if($bookings->isEmpty())
          <div class="text-center py-5">
            <i class="bi bi-inbox" style="font-size:40px;color:#cbd5e1;"></i>
            <p class="text-muted mt-2 mb-0" style="font-size:.85rem;">Belum ada booking</p>
          </div>
        @else
          <div class="table-responsive">
            <table class="table mb-0 align-middle">
              <thead>
                <tr>
                  <th style="font-size:.68rem;font-weight:700;color:#8fa3b8;background:#f8fafd;border:0;padding:.7rem 1rem;">KOST</th>
                  <th style="font-size:.68rem;font-weight:700;color:#8fa3b8;background:#f8fafd;border:0;padding:.7rem 1rem;">KAMAR</th>
                  <th style="font-size:.68rem;font-weight:700;color:#8fa3b8;background:#f8fafd;border:0;padding:.7rem 1rem;">TANGGAL MASUK</th>
                  <th style="font-size:.68rem;font-weight:700;color:#8fa3b8;background:#f8fafd;border:0;padding:.7rem 1rem;">STATUS</th>
                </tr>
              </thead>
              <tbody>
                @foreach($bookings as $b)
                <tr>
                  <td style="font-size:.82rem;font-weight:600;color:#1e2d3d;padding:.7rem 1rem;border-color:#f0f3f8;">
                    {{ $b->room->kost->nama_kost ?? '-' }}
                  </td>
                  <td style="font-size:.82rem;color:#555;padding:.7rem 1rem;border-color:#f0f3f8;">
                    No. {{ $b->room->nomor_kamar ?? '-' }}
                  </td>
                  <td style="font-size:.82rem;color:#555;padding:.7rem 1rem;border-color:#f0f3f8;">
                    {{ \Carbon\Carbon::parse($b->tanggal_masuk)->format('d M Y') }}
                  </td>
                  <td style="padding:.7rem 1rem;border-color:#f0f3f8;">
                    @php
                      $bc = match($b->status_booking) {
                        'diterima' => ['bg'=>'#f0fdf4','color'=>'#16a34a','border'=>'#bbf7d0'],
                        'pending'  => ['bg'=>'#fff7ed','color'=>'#ea580c','border'=>'#fed7aa'],
                        'ditolak'  => ['bg'=>'#fef2f2','color'=>'#dc2626','border'=>'#fecaca'],
                        'selesai'  => ['bg'=>'#f0f9ff','color'=>'#0284c7','border'=>'#bae6fd'],
                        default    => ['bg'=>'#f8fafd','color'=>'#8fa3b8','border'=>'#e4e9f0'],
                      };
                    @endphp
                    <span style="background:{{ $bc['bg'] }};color:{{ $bc['color'] }};border:1px solid {{ $bc['border'] }};font-size:.72rem;font-weight:700;padding:.2rem .65rem;border-radius:999px;">
                      {{ ucfirst($b->status_booking) }}
                    </span>
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
</div>
@endsection