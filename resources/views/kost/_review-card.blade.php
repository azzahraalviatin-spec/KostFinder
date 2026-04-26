{{--
=======================================================================
  PARTIAL: resources/views/partials/kost/_review-card.blade.php
  Dipanggil dari review-section.blade.php
  Variabel: $rv (Review model), $rvFotoArr (array path foto)
=======================================================================
--}}

@php
  /* warna avatar berdasarkan huruf pertama */
  $rvAvaColors = ['#e8401c','#0369a1','#15803d','#7c3aed','#b45309','#0891b2','#be185d','#4f46e5'];
  $rvAvaIdx    = ord(strtolower(substr($rv->user->name ?? 'a', 0, 1))) % count($rvAvaColors);
  $rvAvaColor  = $rvAvaColors[$rvAvaIdx];

  /* info kamar dari booking */
  $rvRoomInfo = null;
  if (!empty($rv->booking) && !empty($rv->booking->room)) {
    $r = $rv->booking->room;
    $rvRoomInfo = ($r->tipe_kamar ? 'Tipe ' . $r->tipe_kamar : 'Kamar No. ' . $r->nomor_kamar)
                . ' · ' . ucfirst($rv->booking->tipe_durasi ?? 'bulanan');
  }
@endphp

<div style="display:flex;gap:.7rem;align-items:flex-start;">

  {{-- Avatar --}}
  <div class="rv-ava" style="background:{{ $rvAvaColor }};flex-shrink:0;">
    @if($rv->user && $rv->user->foto_profil)
      <img src="{{ asset('storage/' . $rv->user->foto_profil) }}"
           style="width:100%;height:100%;object-fit:cover;" alt="">
    @else
      {{ strtoupper(substr($rv->user->name ?? 'A', 0, 1)) }}
    @endif
  </div>

  {{-- Content --}}
  <div style="flex:1;min-width:0;">

    {{-- Baris atas: nama + tombol membantu --}}
    <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:.5rem;flex-wrap:wrap;">
      <span style="font-size:.83rem;font-weight:700;color:var(--dark);">
        {{ $rv->user->name ?? 'Anonim' }}
      </span>
      <button class="rv-helpful-btn" onclick="rvKlikMembantu(this)">
        <i class="bi bi-hand-thumbs-up"></i> Membantu
      </button>
    </div>

    {{-- Bintang --}}
    <div class="rv-stars-color" style="font-size:.75rem;margin:.2rem 0;">
      @for($i=1;$i<=5;$i++)
        <i class="bi bi-star{{ $i <= $rv->rating ? '-fill' : '' }}"></i>
      @endfor
    </div>

    {{-- Info kamar (dari data booking) --}}
    @if($rvRoomInfo)
      <div style="font-size:.7rem;color:var(--text-muted);margin-bottom:.32rem;display:flex;align-items:center;gap:.3rem;">
        <i class="bi bi-door-open" style="font-size:.68rem;"></i>
        {{ $rvRoomInfo }}
      </div>
    @endif

    {{-- Komentar dengan expand --}}
    @if($rv->komentar)
      @php $rvLong = strlen($rv->komentar) > 200; @endphp
      <div style="position:relative;">
        <p id="rvTxt{{ $rv->id_review ?? $loop->index }}"
           style="font-size:.79rem;color:#555;margin:0;line-height:1.6;
                  {{ $rvLong ? 'display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden;' : '' }}">
          {{ $rv->komentar }}
        </p>
        @if($rvLong)
          <button onclick="rvExpand(this,'rvTxt{{ $rv->id_review ?? $loop->index }}')"
            style="font-size:.72rem;color:var(--primary);border:none;background:none;cursor:pointer;padding:0;margin-top:.2rem;font-weight:600;">
            Selengkapnya ▾
          </button>
        @endif
      </div>
    @endif

    {{-- Foto review --}}
    @if(count($rvFotoArr) > 0)
      <div style="display:flex;gap:.4rem;flex-wrap:wrap;margin-top:.6rem;">
        @foreach($rvFotoArr as $fp)
          <img src="{{ asset('storage/' . ltrim($fp, '/')) }}"
               class="rv-photo-thumb"
               alt="Foto ulasan"
               onclick="bukaLb(0)">
        @endforeach
      </div>
    @endif

    {{-- Balasan pemilik --}}
    @if($rv->reply)
      <div class="rv-reply-box">
        <div style="font-weight:700;font-size:.72rem;color:var(--primary);margin-bottom:.22rem;display:flex;align-items:center;gap:.35rem;">
          <i class="bi bi-reply-fill"></i> Balasan Pemilik Kos
        </div>
        <div style="font-size:.77rem;color:#475569;line-height:1.55;">{{ $rv->reply->balasan }}</div>
      </div>
    @endif

    {{-- Tanggal --}}
    <div style="font-size:.67rem;color:#bbb;margin-top:.38rem;display:flex;align-items:center;gap:.3rem;">
      <i class="bi bi-clock" style="font-size:.63rem;"></i>
      {{ $rv->created_at->translatedFormat('d M Y') }}
      <span style="color:#ddd;">·</span>
      {{ $rv->created_at->diffForHumans() }}
    </div>

  </div>
</div>

@push('scripts_inline')
<script>
function rvExpand(btn, id) {
  const el = document.getElementById(id);
  if (!el) return;
  el.style.webkitLineClamp = 'unset';
  el.style.display = 'block';
  el.style.overflow = 'visible';
  btn.remove();
}
</script>
@endpush