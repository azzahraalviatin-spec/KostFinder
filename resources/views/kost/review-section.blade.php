{{--
=======================================================================
  PARTIAL: resources/views/partials/kost/review-section.blade.php
  CARA PAKAI di show.blade.php:
    Ganti seluruh blok <div id="sec-review" ...> ... </div>
    dengan satu baris:
      @include('partials.kost.review-section')
  VARIABEL YANG DIBUTUHKAN (sudah tersedia dari controller show):
    $kost  →  dengan relasi reviews.user, reviews.reply, reviews.booking.room
=======================================================================
--}}

@php
  $rvTotal   = $kost->reviews->count();
  $rvAvg     = $rvTotal ? round($kost->reviews->avg('rating'), 1) : 0;
  $rvPuas    = $rvTotal ? round($kost->reviews->where('rating','>=',4)->count() / $rvTotal * 100) : 0;
  $rvDgFoto  = $kost->reviews->filter(fn($r) => !empty($r->foto_review))->count();

  /* ── Auto-generate keyword dari komentar ── */
  $rvWords = [];
  $rvStop  = ['yang','dengan','untuk','tidak','dalam','sudah','masih','kamar','sangat',
              'banget','juga','kos','kost','pemilik','bisa','saya','aku','ini','itu',
              'ada','dari','dan','atau','tapi','jadi','sudah','lebih','cukup','sekali',
              'akan','karena','serta','juga','memang','seperti','kalau'];
  foreach ($kost->reviews as $rv) {
    if (!$rv->komentar) continue;
    foreach (preg_split('/\s+/', strtolower(strip_tags($rv->komentar))) as $w) {
      $w = preg_replace('/[^a-z0-9]/', '', $w);
      if (strlen($w) > 4 && !in_array($w, $rvStop)) $rvWords[] = $w;
    }
  }
  $rvKw = array_count_values($rvWords);
  arsort($rvKw);
  $rvKeywords = [];
  foreach ($rvKw as $word => $cnt) {
    if ($cnt >= 2 && count($rvKeywords) < 6) $rvKeywords[$word] = $cnt;
  }
  /* fallback jika komentar kurang */
  if (empty($rvKeywords)) {
    $rvKeywords = ['bersih'=>0,'nyaman'=>0,'strategis'=>0,'aman'=>0,'ramah'=>0];
  }
@endphp

{{-- ════════════════════════════════════════════
     A. SECTION REVIEW — tampilan ringkas
     ════════════════════════════════════════════ --}}
<div id="sec-review" class="sec mb-1">

  {{-- ── Header ── --}}
  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:.8rem;">
    <div class="sec-title mb-0">⭐ Penilaian Kos
      @if($rvTotal > 0)
        <span style="font-size:.78rem;font-weight:400;color:var(--text-muted);">({{ number_format($rvTotal) }})</span>
      @endif
    </div>
    @if($rvTotal > 0)
      <button class="rv-btn-all" onclick="rvBukaModal()">
        Lihat Semua <i class="bi bi-chevron-right" style="font-size:.7rem;"></i>
      </button>
    @endif
  </div>

  @if($rvTotal > 0)

    {{-- ── Rating Summary Bar ── --}}
    <div class="rv-summary-card">
      <div style="text-align:center;min-width:62px;">
        <div class="rv-big-score">{{ $rvAvg }}</div>
        <div class="rv-stars-color" style="font-size:.78rem;margin:.18rem 0;">
          @for($i=1;$i<=5;$i++)
            <i class="bi bi-star{{ $i <= round($rvAvg) ? '-fill' : ($i - $rvAvg < 1 ? '-half' : '') }}"></i>
          @endfor
        </div>
        <div style="font-size:.65rem;color:#888;">dari 5</div>
      </div>
      <div style="flex:1;">
        @for($s=5;$s>=1;$s--)
          @php $c=$kost->reviews->where('rating',$s)->count(); $p=$rvTotal>0?($c/$rvTotal)*100:0; @endphp
          <div style="display:flex;align-items:center;gap:.4rem;margin-bottom:.2rem;">
            <span style="font-size:.68rem;color:#666;width:8px;text-align:right;">{{ $s }}</span>
            <i class="bi bi-star-fill rv-stars-color" style="font-size:.58rem;flex-shrink:0;"></i>
            <div class="rv-bar-bg"><div class="rv-bar-fill" style="width:{{ $p }}%;"></div></div>
            <span style="font-size:.65rem;color:#888;width:14px;">{{ $c }}</span>
          </div>
        @endfor
        <div style="font-size:.7rem;color:#555;margin-top:.4rem;font-weight:600;">
          {{ $rvPuas }}% penghuni merasa puas
        </div>
      </div>
    </div>

    {{-- ── Tag Keyword highlight ── --}}
    <div class="rv-tag-row">
      @foreach($rvKeywords as $kw => $cnt)
        <span class="rv-tag {{ $loop->first ? 'act' : '' }}"
              onclick="rvTagClick(this,'{{ $kw }}')">
          {{ ucfirst($kw) }}
          @if($cnt >= 2)<span style="opacity:.7;">({{ $cnt }})</span>@endif
        </span>
      @endforeach
    </div>

    {{-- ── Search bar ── --}}
    <div class="rv-searchbar">
      <i class="bi bi-search" style="color:#bbb;font-size:.8rem;flex-shrink:0;"></i>
      <input type="text" id="rvQ" placeholder="Cari ulasan penghuni..." oninput="rvDoFilter()">
      <button id="rvClearBtn" onclick="document.getElementById('rvQ').value='';rvDoFilter();"
        style="display:none;border:none;background:none;color:#aaa;font-size:.8rem;cursor:pointer;padding:0 2px;">✕</button>
    </div>

    {{-- ── Filter Tab ── --}}
    <div class="rv-ftab-row" id="rvFtabRow">
      <div class="rv-ftab act" onclick="rvSetFilter('all',this)">Semua ({{ $rvTotal }})</div>
      @if($rvDgFoto > 0)
        <div class="rv-ftab" onclick="rvSetFilter('foto',this)">Dgn Foto ({{ $rvDgFoto }})</div>
      @endif
      @for($s=5;$s>=3;$s--)
        @php $cs = $kost->reviews->where('rating',$s)->count(); @endphp
        @if($cs > 0)
          <div class="rv-ftab" onclick="rvSetFilter('star{{ $s }}',this)">
            ★ {{ $s }} ({{ $cs }})
          </div>
        @endif
      @endfor
    </div>

    {{-- ── Daftar Review (3 tampil) ── --}}
    <div id="rvList">
      @php $rvShown = 0; @endphp
      @foreach($kost->reviews->sortByDesc('created_at') as $rv)
        @php
          $rvFotoArr = [];
          if (!empty($rv->foto_review)) {
            $rvFotoArr = is_array($rv->foto_review)
              ? $rv->foto_review
              : (json_decode($rv->foto_review, true) ?: []);
          }
          $rvHasFoto = count($rvFotoArr) > 0;
          $rvShown++;
        @endphp
        <div class="rv-card"
             data-rating="{{ $rv->rating }}"
             data-foto="{{ $rvHasFoto ? '1' : '0' }}"
             data-text="{{ strtolower($rv->komentar ?? '') }}"
             style="{{ $rvShown > 3 ? 'display:none;' : '' }}">
          @include('partials.kost._review-card', [
            'rv'        => $rv,
            'rvFotoArr' => $rvFotoArr,
          ])
        </div>
      @endforeach
    </div>

    {{-- Empty state setelah filter ── --}}
    <div id="rvEmpty" style="display:none;text-align:center;padding:1.5rem 0;color:var(--text-muted);">
      <div style="font-size:1.8rem;">🔍</div>
      <div style="font-size:.8rem;margin-top:.4rem;">Tidak ada ulasan yang cocok</div>
    </div>

    {{-- ── Tombol lihat lebih banyak ── --}}
    @if($rvTotal > 3)
      <div style="text-align:center;margin-top:.8rem;" id="rvMoreWrap">
        <button class="rv-btn-more" onclick="rvBukaModal()">
          <i class="bi bi-chat-square-text"></i>
          Lihat {{ $rvTotal - 3 }} ulasan lainnya →
        </button>
      </div>
    @endif

  @else

    {{-- ── Empty State ── --}}
    <div style="text-align:center;padding:2rem 0;">
      <div style="font-size:2.5rem;margin-bottom:.5rem;">⭐</div>
      <div style="font-weight:700;font-size:.85rem;color:var(--dark);margin-bottom:.25rem;">Belum ada ulasan</div>
      <div style="font-size:.76rem;color:var(--text-muted);">
        Jadilah penghuni pertama yang memberi ulasan untuk kos ini!
      </div>
    </div>

  @endif
</div>{{-- /sec-review --}}


{{-- ════════════════════════════════════════════
     B. MODAL LIHAT SEMUA ULASAN
     Taruh sebelum closing </div> wrap utama
     ════════════════════════════════════════════ --}}
@if($rvTotal > 0)
<div id="rvModalBg"
     onclick="if(event.target===this)rvTutupModal()"
     style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:10000;align-items:flex-end;justify-content:center;">

  <div id="rvModalSheet" style="background:#fff;border-radius:1.1rem 1.1rem 0 0;width:100%;max-width:700px;max-height:92vh;display:flex;flex-direction:column;">

    {{-- Header modal --}}
    <div style="display:flex;align-items:center;justify-content:space-between;padding:.9rem 1.1rem;border-bottom:1px solid #f0f3f8;flex-shrink:0;">
      <div style="font-size:.92rem;font-weight:800;color:var(--dark);">⭐ Ulasan Penghuni Kos</div>
      <button onclick="rvTutupModal()" style="width:30px;height:30px;border-radius:50%;border:1px solid #e4e9f0;background:#f5f6fa;font-size:.85rem;cursor:pointer;display:flex;align-items:center;justify-content:center;color:#555;">✕</button>
    </div>

    {{-- Rating summary modal --}}
    <div style="display:flex;align-items:center;gap:1.4rem;padding:.9rem 1.1rem;border-bottom:1px solid #f0f3f8;background:linear-gradient(135deg,#fffbf0,#fff8e0);flex-shrink:0;">
      <div style="text-align:center;min-width:80px;">
        <div style="font-size:2.9rem;font-weight:900;color:#f59e0b;line-height:1;">{{ $rvAvg }}</div>
        <div class="rv-stars-color" style="font-size:.85rem;margin:.22rem 0;">
          @for($i=1;$i<=5;$i++)<i class="bi bi-star{{ $i<=round($rvAvg)?'-fill':'' }}"></i>@endfor
        </div>
        <div style="font-size:.68rem;color:#888;">dari 5</div>
      </div>
      <div style="flex:1;">
        @for($s=5;$s>=1;$s--)
          @php $c=$kost->reviews->where('rating',$s)->count(); $p=$rvTotal>0?($c/$rvTotal)*100:0; @endphp
          <div style="display:flex;align-items:center;gap:.5rem;margin-bottom:.28rem;">
            <span style="font-size:.7rem;color:#666;width:10px;text-align:right;">{{ $s }}</span>
            <i class="bi bi-star-fill rv-stars-color" style="font-size:.62rem;flex-shrink:0;"></i>
            <div class="rv-bar-bg" style="flex:1;"><div class="rv-bar-fill" style="width:{{ $p }}%;"></div></div>
            <span style="font-size:.68rem;color:#888;width:16px;">{{ $c }}</span>
          </div>
        @endfor
        <div style="font-size:.74rem;font-weight:700;color:#333;margin-top:.45rem;">
          {{ $rvPuas }}% penghuni merasa puas
          <span style="font-weight:400;color:#888;"> · {{ $rvTotal }} ulasan</span>
        </div>
      </div>
    </div>

    {{-- Body scrollable --}}
    <div style="overflow-y:auto;flex:1;padding:.85rem 1.1rem 1.5rem;" id="rvMBody">

      {{-- Filter tab modal --}}
      <div class="rv-ftab-row" id="rvMFtabRow" style="margin-bottom:.65rem;">
        <div class="rv-ftab act" onclick="rvMSetFilter('all',this)">Semua ({{ $rvTotal }})</div>
        @if($rvDgFoto > 0)
          <div class="rv-ftab" onclick="rvMSetFilter('foto',this)">Dgn Foto ({{ $rvDgFoto }})</div>
        @endif
        @for($s=5;$s>=1;$s--)
          @php $cs=$kost->reviews->where('rating',$s)->count(); @endphp
          @if($cs > 0)
            <div class="rv-ftab" onclick="rvMSetFilter('star{{ $s }}',this)">★ {{ $s }} ({{ $cs }})</div>
          @endif
        @endfor
      </div>

      {{-- Search modal --}}
      <div class="rv-searchbar" style="margin-bottom:.65rem;">
        <i class="bi bi-search" style="color:#bbb;font-size:.8rem;flex-shrink:0;"></i>
        <input type="text" id="rvMQ" placeholder="Cari ulasan..." oninput="rvMDoFilter()">
        <button id="rvMClearBtn" onclick="document.getElementById('rvMQ').value='';rvMDoFilter();"
          style="display:none;border:none;background:none;color:#aaa;font-size:.8rem;cursor:pointer;padding:0 2px;">✕</button>
      </div>

      {{-- Keyword tags modal --}}
      <div class="rv-tag-row" style="margin-bottom:.85rem;">
        @foreach($rvKeywords as $kw => $cnt)
          <span class="rv-tag" onclick="rvMTagClick(this,'{{ $kw }}')">
            {{ ucfirst($kw) }}
            @if($cnt >= 2)<span style="opacity:.7;">({{ $cnt }})</span>@endif
          </span>
        @endforeach
      </div>

      {{-- Semua review list --}}
      <div id="rvMList">
        @foreach($kost->reviews->sortByDesc('created_at') as $rv)
          @php
            $rvFotoArr = [];
            if (!empty($rv->foto_review)) {
              $rvFotoArr = is_array($rv->foto_review)
                ? $rv->foto_review
                : (json_decode($rv->foto_review, true) ?: []);
            }
            $rvHasFoto = count($rvFotoArr) > 0;
          @endphp
          <div class="rv-card"
               data-rating="{{ $rv->rating }}"
               data-foto="{{ $rvHasFoto ? '1' : '0' }}"
               data-text="{{ strtolower($rv->komentar ?? '') }}">
            @include('partials.kost._review-card', [
              'rv'        => $rv,
              'rvFotoArr' => $rvFotoArr,
            ])
          </div>
        @endforeach
      </div>

      <div id="rvMEmpty" style="display:none;text-align:center;padding:2rem 0;color:var(--text-muted);">
        <div style="font-size:1.8rem;">🔍</div>
        <div style="font-size:.8rem;margin-top:.4rem;">Tidak ada ulasan yang cocok</div>
      </div>

    </div>{{-- /rvMBody --}}
  </div>{{-- /rvModalSheet --}}
</div>{{-- /rvModalBg --}}
@endif


{{-- ════════════════════════════════════════════
     C. STYLE — masukkan ke @section('styles')
     ════════════════════════════════════════════ --}}
<style>
/* ── Review Section ── */
.rv-stars-color { color: #f59e0b; }
.rv-summary-card {
  display: flex; align-items: center; gap: 1.1rem;
  background: linear-gradient(135deg,#fffbf0,#fff8e0);
  border: 1px solid #fde68a; border-radius: .7rem;
  padding: .85rem 1.1rem; margin-bottom: .75rem;
}
.rv-big-score { font-size: 2.2rem; font-weight: 900; color: #f59e0b; line-height: 1; }
.rv-bar-bg { background: #f0f3f8; border-radius: 999px; height: 6px; flex: 1; overflow: hidden; }
.rv-bar-fill { background: linear-gradient(90deg,#f59e0b,#fbbf24); border-radius: 999px; height: 6px; transition: width .4s; }
.rv-tag-row { display: flex; gap: .38rem; flex-wrap: nowrap; overflow-x: auto; margin-bottom: .7rem; padding-bottom: 2px; scrollbar-width: none; }
.rv-tag-row::-webkit-scrollbar { display: none; }
.rv-tag { background: #fff8e0; color: #a06000; border: 1px solid #f5d060; border-radius: 999px; font-size: .72rem; padding: .22rem .75rem; cursor: pointer; transition: all .2s; white-space: nowrap; flex-shrink: 0; user-select: none; }
.rv-tag:hover, .rv-tag.act { background: var(--primary); color: #fff; border-color: var(--primary); }
.rv-searchbar { display: flex; align-items: center; gap: .5rem; border: 1.5px solid var(--card-border); border-radius: .52rem; padding: .4rem .8rem; margin-bottom: .65rem; transition: border .2s; }
.rv-searchbar:focus-within { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(232,64,28,.08); }
.rv-searchbar input { border: none; background: none; outline: none; font-size: .78rem; color: #333; width: 100%; }
.rv-ftab-row { display: flex; gap: .35rem; overflow-x: auto; margin-bottom: .8rem; padding-bottom: 2px; scrollbar-width: none; }
.rv-ftab-row::-webkit-scrollbar { display: none; }
.rv-ftab { flex-shrink: 0; padding: .28rem .82rem; border: 1.5px solid var(--card-border); border-radius: 999px; font-size: .72rem; font-weight: 700; cursor: pointer; color: #666; background: #fff; transition: all .2s; white-space: nowrap; user-select: none; }
.rv-ftab:hover { border-color: var(--primary); color: var(--primary); }
.rv-ftab.act { background: var(--primary); color: #fff; border-color: var(--primary); }
.rv-card { padding: .9rem 0; border-bottom: 1px solid #f0f3f8; }
.rv-card:last-child { border-bottom: none; }
.rv-ava { width: 36px; height: 36px; border-radius: 50%; background: var(--primary); color: #fff; font-weight: 700; font-size: .78rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0; overflow: hidden; border: 2px solid var(--primary-light); }
.rv-photo-thumb { width: 68px; height: 68px; border-radius: .5rem; object-fit: cover; border: 1px solid var(--card-border); cursor: pointer; transition: transform .2s, opacity .2s; }
.rv-photo-thumb:hover { transform: scale(1.06); opacity: .9; }
.rv-helpful-btn { display: flex; align-items: center; gap: .28rem; font-size: .69rem; color: var(--text-muted); border: 1px solid var(--card-border); border-radius: 999px; padding: .18rem .55rem; cursor: pointer; background: #fff; transition: all .2s; }
.rv-helpful-btn:hover, .rv-helpful-btn.clicked { border-color: var(--primary); color: var(--primary); }
.rv-reply-box { background: #f8fafc; border-left: 3px solid var(--primary); padding: .6rem .85rem; margin-top: .7rem; border-radius: 0 .42rem .42rem 0; }
.rv-btn-all { display: flex; align-items: center; gap: .3rem; font-size: .76rem; font-weight: 700; color: var(--primary); border: none; background: none; cursor: pointer; padding: 0; }
.rv-btn-all:hover { opacity: .75; }
.rv-btn-more { background: #fff; border: 1.5px solid var(--primary); color: var(--primary); border-radius: 999px; padding: .45rem 1.5rem; font-size: .78rem; font-weight: 700; cursor: pointer; transition: all .2s; display: inline-flex; align-items: center; gap: .4rem; }
.rv-btn-more:hover { background: var(--primary-light); }

/* Modal animation */
@keyframes rvSlideUp { from { transform: translateY(50px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
@keyframes rvFadeIn  { from { opacity: 0; } to { opacity: 1; } }
#rvModalSheet { animation: rvSlideUp .28s ease; }
#rvModalBg.open { animation: rvFadeIn .2s ease; }
</style>


{{-- ════════════════════════════════════════════
     D. JAVASCRIPT — masukkan ke @section('scripts')
     ════════════════════════════════════════════ --}}
<script>
/* ── Buka / Tutup modal ── */
function rvBukaModal() {
  const m = document.getElementById('rvModalBg');
  m.style.display = 'flex';
  document.body.style.overflow = 'hidden';
  /* reset filter modal ke "Semua" */
  document.getElementById('rvMQ').value = '';
  rvMDoFilter();
}
function rvTutupModal() {
  document.getElementById('rvModalBg').style.display = 'none';
  document.body.style.overflow = '';
}
document.addEventListener('keydown', e => {
  if (e.key === 'Escape') rvTutupModal();
});

/* ── Filter review di section utama ── */
let _rvFilter = 'all';
function rvSetFilter(f, el) {
  _rvFilter = f;
  document.querySelectorAll('#rvFtabRow .rv-ftab').forEach(t => t.classList.remove('act'));
  el.classList.add('act');
  rvDoFilter();
}
function rvTagClick(el, kw) {
  document.querySelectorAll('.rv-tag-row:first-of-type .rv-tag').forEach(t => t.classList.remove('act'));
  el.classList.add('act');
  const inp = document.getElementById('rvQ');
  inp.value = inp.value === kw ? '' : kw;
  if (document.getElementById('rvClearBtn')) document.getElementById('rvClearBtn').style.display = inp.value ? 'block' : 'none';
  rvDoFilter();
}
function rvDoFilter() {
  const q = (document.getElementById('rvQ')?.value || '').toLowerCase().trim();
  if (document.getElementById('rvClearBtn')) document.getElementById('rvClearBtn').style.display = q ? 'block' : 'none';
  let shown = 0, total = 0;
  document.querySelectorAll('#rvList .rv-card').forEach((card, i) => {
    total++;
    const ok = rvMatch(card, _rvFilter, q);
    if (ok) shown++;
    card.style.display = ok ? '' : 'none';
  });
  const empty = document.getElementById('rvEmpty');
  if (empty) empty.style.display = (shown === 0) ? '' : 'none';
}

/* ── Filter review di modal ── */
let _rvMFilter = 'all';
function rvMSetFilter(f, el) {
  _rvMFilter = f;
  document.querySelectorAll('#rvMFtabRow .rv-ftab').forEach(t => t.classList.remove('act'));
  el.classList.add('act');
  rvMDoFilter();
}
function rvMTagClick(el, kw) {
  const inp = document.getElementById('rvMQ');
  inp.value = inp.value === kw ? '' : kw;
  if (document.getElementById('rvMClearBtn')) document.getElementById('rvMClearBtn').style.display = inp.value ? 'block' : 'none';
  rvMDoFilter();
}
function rvMDoFilter() {
  const q = (document.getElementById('rvMQ')?.value || '').toLowerCase().trim();
  if (document.getElementById('rvMClearBtn')) document.getElementById('rvMClearBtn').style.display = q ? 'block' : 'none';
  let shown = 0;
  document.querySelectorAll('#rvMList .rv-card').forEach(card => {
    const ok = rvMatch(card, _rvMFilter, q);
    if (ok) shown++;
    card.style.display = ok ? '' : 'none';
  });
  const empty = document.getElementById('rvMEmpty');
  if (empty) empty.style.display = (shown === 0) ? '' : 'none';
}

/* ── Shared match function ── */
function rvMatch(card, filter, q) {
  const rating  = parseInt(card.dataset.rating || '5');
  const hasFoto = card.dataset.foto === '1';
  const text    = (card.dataset.text || '') + ' ' + (card.innerText || '').toLowerCase();
  if (filter === 'foto'  && !hasFoto) return false;
  if (filter.startsWith('star')) {
    const s = parseInt(filter.replace('star', ''));
    if (rating !== s) return false;
  }
  if (q && !text.includes(q)) return false;
  return true;
}

/* ── Tombol Membantu ── */
function rvKlikMembantu(btn) {
  if (btn.classList.contains('clicked')) return;
  btn.classList.add('clicked');
  btn.innerHTML = '<i class="bi bi-hand-thumbs-up-fill"></i> Membantu';
}
</script>