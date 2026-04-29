@extends('layouts.user-sidebar')

@section('title', 'Ulasanku')

@section('styles')
<style>
  :root { --primary:#e8401c; --dark:#1e2d3d; }
  .page-wrap { max-width:1100px; margin:0 auto; padding-bottom: 2rem; }

  /* Premium Tabs */
  .review-tabs {
    display: inline-flex; background: #fff; padding: 0.4rem; border-radius: 99px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.02); margin-bottom: 2.5rem; border: 1px solid #f1f5f9;
  }
  .review-tab {
    padding: 0.65rem 1.5rem; font-weight: 700; font-size: .85rem; color: #64748b; 
    text-decoration: none; border-radius: 99px; transition: all .3s ease;
    display: flex; align-items: center; gap: 0.5rem;
  }
  .review-tab:hover { color: #0f172a; }
  .review-tab.active { background: var(--dark); color: #fff; box-shadow: 0 4px 12px rgba(15, 23, 42, 0.15); }
  .badge-count { background: #ef4444; color: #fff; font-size: 0.7rem; font-weight: 800; padding: 2px 8px; border-radius: 99px; }

  /* Pending Grid (Menunggu Diulas) */
  .pending-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 1.5rem; }
  .premium-card { background: #fff; border-radius: 1.25rem; border: 1px solid #f1f5f9; box-shadow: 0 4px 20px rgba(0,0,0,.03); overflow: hidden; transition: all .3s ease; display: flex; flex-direction: column; height: 100%; }
  .premium-card:hover { transform: translateY(-5px); box-shadow: 0 12px 30px rgba(0,0,0,.08); border-color: #e2e8f0; }
  .premium-card-img { width: 100%; height: 160px; object-fit: cover; }
  .premium-card-body { padding: 1.25rem; flex: 1; display: flex; flex-direction: column; }
  .premium-card-title { font-weight: 800; font-size: 1rem; color: var(--dark); margin-bottom: 0.35rem; line-height: 1.3; }
  .premium-card-subtitle { font-size: .8rem; color: #64748b; display: flex; align-items: center; gap: 0.4rem; font-weight: 500; }
  .premium-card-date { font-size: .75rem; color: #94a3b8; font-weight: 600; margin-top: auto; padding-top: 1.25rem; display: flex; align-items: center; gap: 0.3rem; }
  .btn-premium-action { margin-top: 1rem; width: 100%; background: var(--primary); color: #fff; border: 0; padding: 0.75rem; border-radius: 0.75rem; font-weight: 700; font-size: .85rem; transition: background .2s; display: flex; justify-content: center; align-items: center; gap: 0.4rem; }
  .btn-premium-action:hover { background: #cb3518; }

  /* Review List Card (Ulasan Saya) */
  .review-list-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 1.25rem; }
  .review-card { background: #fff; border-radius: 1.25rem; border: 1px solid #f1f5f9; padding: 1.5rem; transition: all .3s ease; box-shadow: 0 4px 15px rgba(0,0,0,.02); display: flex; flex-direction: column; height: 100%; }
  .review-card:hover { box-shadow: 0 8px 25px rgba(0,0,0,.05); border-color: #e2e8f0; transform: translateY(-5px); }
  .review-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem; flex-wrap: wrap; gap: 0.5rem; }
  .review-kost { font-weight: 800; font-size: 1.1rem; color: var(--dark); line-height: 1.3; }
  .review-kamar { font-size: .8rem; color: #64748b; margin-top: 0.25rem; display: flex; align-items: center; gap: 0.3rem; font-weight: 500; }
  
  .badge-status { font-size: .7rem; font-weight: 700; padding: 0.35rem 0.8rem; border-radius: 99px; letter-spacing: 0.3px; display: inline-flex; align-items: center; gap: 0.3rem; }
  .badge-approved { background: #f0fdf4; color: #15803d; border: 1px solid #dcfce7; }
  .badge-pending { background: #fffbeb; color: #b45309; border: 1px solid #fef3c7; }
  .badge-rejected { background: #fef2f2; color: #b91c1c; border: 1px solid #fee2e2; }

  .star-row { display: flex; gap: 3px; align-items: center; margin-bottom: 1rem; }
  .star-row i { font-size: 1.1rem; color: #fbbf24; }
  .star-row i.empty { color: #e2e8f0; }
  .star-score { font-size: .85rem; font-weight: 800; color: #334155; margin-left: 0.5rem; }

  .review-text { flex: 1; font-size: .9rem; color: #475569; line-height: 1.6; background: #f8fafc; padding: 1.25rem; border-radius: 1rem; border: 1px solid #f1f5f9; margin-bottom: 1rem; position: relative; }
  .review-text::before { content: '"'; position: absolute; top: -10px; left: 15px; font-size: 3rem; color: #e2e8f0; font-family: Georgia, serif; line-height: 1; }
  .review-date { font-size: .75rem; color: #94a3b8; font-weight: 600; display: flex; align-items: center; gap: 0.4rem; margin-top: auto; }

  /* Premium Empty State */
  .empty-premium { background: #fff; border-radius: 1.5rem; border: 1.5px dashed #e2e8f0; padding: 4rem 2rem; text-align: center; color: #64748b; display: flex; flex-direction: column; align-items: center; justify-content: center; margin-top: 1rem; }
  .empty-premium i { font-size: 3.5rem; color: #cbd5e1; margin-bottom: 1rem; }
  .empty-premium h4 { font-weight: 800; font-size: 1.25rem; color: var(--dark); margin-bottom: 0.5rem; }
  .empty-premium p { font-size: .9rem; max-width: 400px; margin: 0 auto; line-height: 1.5; }

/* Modal ulasan redesign */
#modalUlasan { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,.6); z-index: 999999; align-items: center; justify-content: center; backdrop-filter: blur(4px); }
.modal-custom-dialog { background: #fff; border-radius: 1.25rem; width: 100%; max-width: 520px; margin: 1rem; box-shadow: 0 20px 60px rgba(0,0,0,.2); max-height: 90vh; overflow-y: auto; }
.modal-custom-header { display: flex; justify-content: space-between; align-items: center; padding: 1.25rem 1.5rem 0.25rem; }
.modal-custom-title { font-weight: 800; font-size: 1.15rem; color: var(--dark); display: flex; align-items: center; gap: 0.5rem; }
.modal-custom-close { background: #fff; border: 1px solid #e4e9f0; border-radius: 50%; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #888; transition: all .2s; }
.modal-custom-close:hover { background: #fef2f2; color: #dc2626; border-color: #fecaca; }
.modal-custom-kost { font-size: .85rem; color: #6b7280; padding: 0 1.5rem; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.4rem; font-weight: 500; }

.modal-custom-body { padding: 0 1.5rem 1.5rem; }
.question-label { font-weight: 700; font-size: .9rem; color: var(--dark); margin-bottom: 0.2rem; }
.question-sub { font-size: .75rem; color: #888; margin-bottom: 0.75rem; }

.rating-main-box { display: flex; gap: 1.5rem; margin-bottom: 1rem; align-items: center; }
.star-main-input { display: flex; gap: 0.4rem; }
.star-main-input i { font-size: 2.4rem; color: #e4e9f0; cursor: pointer; transition: all .2s; }
.star-main-input i.active, .star-main-input i:hover { color: #fbbf24; transform: scale(1.1); }

.rating-score-card { background: #fffaf5; border: 1px solid #ffe4d6; border-radius: 0.75rem; padding: 0.75rem 1rem; text-align: center; width: 100px; display: none; flex-direction: column; justify-content: center; align-items: center; }
.rating-score-card.show { display: flex; }
.rating-score-val { font-size: 1rem; font-weight: 800; color: var(--primary); }
.rating-score-val span { font-size: 1.4rem; }
.rating-score-text { font-size: .75rem; font-weight: 700; color: var(--primary); margin-top: 0.2rem; }

.rating-feedback-box { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 0.5rem; padding: 0.85rem; display: none; gap: 0.75rem; margin-bottom: 1.5rem; align-items: center; }
.rating-feedback-box.show { display: flex; }
.rating-feedback-icon { background: #fff; border-radius: 50%; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0; box-shadow: 0 2px 5px rgba(0,0,0,.05); }
.rating-feedback-content { font-size: .75rem; color: #64748b; line-height: 1.4; }
.rating-feedback-content strong { color: #334155; font-size: .8rem; display: block; }

.comment-area { width: 100%; border: 1px solid #e2e8f0; border-radius: 0.5rem; padding: 0.85rem; font-size: .85rem; color: #334155; resize: none; transition: border-color .2s; outline: none; }
.comment-area:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(232, 64, 28, 0.1); }
.char-counter { text-align: right; font-size: .7rem; color: #94a3b8; margin-top: 0.25rem; }

.aspect-grid { display: flex; flex-direction: column; gap: 0.6rem; border: 1px solid #f1f5f9; border-radius: 0.5rem; padding: 1rem; background: #fafbfc; }
.aspect-item { display: flex; justify-content: space-between; align-items: center; }
.aspect-label { font-size: .78rem; font-weight: 600; color: #475569; display: flex; align-items: center; gap: 0.4rem; width: 110px; }
.aspect-stars { display: flex; gap: 0.2rem; }
.aspect-stars i { font-size: 1rem; color: #e4e9f0; cursor: pointer; transition: all .2s; }
.aspect-stars.rated i.active, .aspect-stars i:hover { color: #94a3b8; }
.aspect-stars.rated-active i.active { color: #fbbf24; }

.modal-actions { display: flex; gap: 0.75rem; margin-top: 1.5rem; }
.btn-modal-cancel { flex: 1; padding: 0.65rem; background: #fff; border: 1px solid #e2e8f0; border-radius: 0.5rem; font-weight: 600; color: #475569; font-size: .85rem; cursor: pointer; transition: all .2s; }
.btn-modal-cancel:hover { background: #f8fafc; color: #0f172a; }
.btn-modal-submit { flex: 1.5; padding: 0.65rem; background: var(--primary); border: 0; border-radius: 0.5rem; font-weight: 700; color: #fff; font-size: .85rem; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.4rem; transition: background .2s; }
.btn-modal-submit:hover { background: #cb3518; }
.btn-modal-submit:disabled { opacity: 0.5; cursor: not-allowed; }
</style>
@endsection

@section('content')

@php
  $user = auth()->user();
  $tab  = request('tab', 'ulasanku');

  // Ulasan yang sudah dibuat
  $ulasan = \App\Models\Review::where('user_id', $user->id)
            ->with(['kost', 'reply'])
            ->latest()
            ->get();

  // Booking selesai yang belum diulas
  $belumDiulas = \App\Models\Booking::where('user_id', $user->id)
      ->where('status_booking', 'selesai')
      ->whereDoesntHave('review')
      ->with(['room.kost'])
      ->get();
@endphp

<div class="page-wrap">
  
  {{-- TABS --}}
  <div class="review-tabs">
    <a href="?tab=menunggu" class="review-tab {{ $tab === 'menunggu' ? 'active' : '' }}">
      <i class="bi bi-clock-history"></i> Menunggu Diulas
      @if($belumDiulas->count())
        <span class="badge-count">{{ $belumDiulas->count() }}</span>
      @endif
    </a>
    <a href="?tab=ulasanku" class="review-tab {{ $tab === 'ulasanku' ? 'active' : '' }}">
      <i class="bi bi-star-fill" style="color: {{ $tab === 'ulasanku' ? '#fbbf24' : 'inherit' }}"></i> Ulasan Saya
    </a>
  </div>

  @if($tab === 'menunggu')
    @if($belumDiulas->count())
      <div class="pending-grid">
        @foreach($belumDiulas as $b)
          <div class="premium-card">
            <img class="premium-card-img" src="{{ asset('storage/' . $b->room->kost->foto_utama) }}" onerror="this.src='https://via.placeholder.com/400x200?text=No+Image'">
            <div class="premium-card-body">
              <div class="premium-card-title">{{ $b->room->kost->nama_kost ?? '-' }}</div>
              <div class="premium-card-subtitle"><i class="bi bi-door-open"></i> Kamar {{ $b->room->nomor_kamar ?? '-' }}</div>
              
              <div class="premium-card-date">
                <i class="bi bi-calendar-check"></i> Selesai: {{ \Carbon\Carbon::parse($b->tanggal_selesai)->translatedFormat('d M Y') }}
              </div>
              
              <button class="btn-premium-action" onclick="bukaModalUlasan({{ $b->id_booking }}, '{{ addslashes($b->room->kost->nama_kost ?? '') }}')">
                <i class="bi bi-star-fill" style="color:#fbbf24;"></i> Beri Ulasan
              </button>
            </div>
          </div>
        @endforeach
      </div>
    @else
      <div class="empty-premium">
        <i class="bi bi-check-circle-fill" style="color: #10b981;"></i>
        <h4>Semua Selesai!</h4>
        <p>Tidak ada booking yang menunggu untuk diulas. Terima kasih sudah berbagi pengalamanmu! 😊</p>
      </div>
    @endif
  @endif

  @if($tab === 'ulasanku')
    @if($ulasan->count())
      <div class="review-list-grid">
        @foreach($ulasan as $u)
          <div class="review-card">
            <div class="review-header">
              <div>
                <div class="review-kost">{{ $u->kost->nama_kost ?? '-' }}</div>
                <div class="review-kamar"><i class="bi bi-geo-alt-fill" style="color:#ef4444;"></i> {{ $u->kost->kota ?? '-' }}</div>
              </div>
              @php
                $st = $u->status ?? 'pending';
                $stClass = match($st) { 'approved' => 'badge-approved', 'rejected' => 'badge-rejected', default => 'badge-pending' };
                $stLabel = match($st) { 'approved' => '✅ Ditampilkan', 'rejected' => '❌ Ditolak', default => '⏳ Menunggu Review' };
              @endphp
              <span class="badge-status {{ $stClass }}">{{ $stLabel }}</span>
            </div>

            <div class="star-row">
              @for($i = 1; $i <= 5; $i++)
                <i class="bi bi-star-fill {{ $i <= ($u->rating ?? 0) ? '' : 'empty' }}"></i>
              @endfor
              <span class="star-score">{{ $u->rating }}/5</span>
            </div>
            
            <div style="font-size:0.75rem; color:#64748b; margin-bottom: 1rem; display: flex; gap: 0.75rem; flex-wrap: wrap;">
              <span>🧹 Kebersihan: <strong>{{ $u->rating_kebersihan ?? 0 }}</strong>/5</span>
              <span>🖥️ Fasilitas: <strong>{{ $u->rating_fasilitas ?? 0 }}</strong>/5</span>
              <span>📍 Lokasi: <strong>{{ $u->rating_lokasi ?? 0 }}</strong>/5</span>
              <span>💰 Harga: <strong>{{ $u->rating_harga ?? 0 }}</strong>/5</span>
            </div>

            <div class="review-text">{{ $u->komentar ?? $u->isi ?? 'Tidak ada komentar.' }}</div>
            
            @if($u->reply)
              <div style="background:#f0f4f8; border-left:3px solid #3b82f6; border-radius:0 8px 8px 0; padding:.85rem 1rem; margin-bottom:1rem;">
                <div style="font-size:.75rem; font-weight:700; color:#3b82f6; margin-bottom:4px;"><i class="bi bi-reply me-1"></i>Balasan dari Pemilik Kos</div>
                <div style="font-size:.85rem; color:#475569;">{{ $u->reply->balasan }}</div>
              </div>
            @endif

            <div class="review-date"><i class="bi bi-calendar-event"></i> Diulas pada {{ \Carbon\Carbon::parse($u->created_at)->translatedFormat('d F Y') }}</div>
          </div>
        @endforeach
      </div>
    @else
      <div class="empty-premium">
        <i class="bi bi-star-half" style="color: #fbbf24;"></i>
        <h4>Belum Ada Ulasan</h4>
        <p>Kamu belum memberikan ulasan apapun. Selesaikan masa sewa kosmu dan bagikan pengalamanmu di sini!</p>
      </div>
    @endif
  @endif

</div>

{{-- MODAL BERI ULASAN REDESIGN --}}
<div id="modalUlasan" onclick="if(event.target===this)tutupModalUlasan()">
  <div class="modal-custom-dialog">
    <div class="modal-custom-header">
      <div class="modal-custom-title">⭐ Beri Ulasan</div>
      <button class="modal-custom-close" onclick="tutupModalUlasan()"><i class="bi bi-x-lg"></i></button>
    </div>
    <div class="modal-custom-kost" id="modalUlasanKost">🏠 kosberkah</div>

    <form id="formUlasan" action="{{ route('user.review.store') }}" method="POST">
      @csrf
      <div class="modal-custom-body">
        <input type="hidden" name="booking_id" id="ulasanBookingId">
        <input type="hidden" name="rating" id="ratingInput" value="0">
        
        <input type="hidden" name="rating_kebersihan" id="rating_kebersihan" value="0">
        <input type="hidden" name="rating_fasilitas" id="rating_fasilitas" value="0">
        <input type="hidden" name="rating_lokasi" id="rating_lokasi" value="0">
        <input type="hidden" name="rating_harga" id="rating_harga" value="0">

        <!-- Penilaian Utama -->
        <div class="question-label">Bagaimana penilaianmu?</div>
        <div class="question-sub">Klik bintang untuk memberikan rating</div>
        
        <div class="rating-main-box">
          <div class="star-main-input" id="mainStars">
            <i class="bi bi-star" data-val="1"></i>
            <i class="bi bi-star" data-val="2"></i>
            <i class="bi bi-star" data-val="3"></i>
            <i class="bi bi-star" data-val="4"></i>
            <i class="bi bi-star" data-val="5"></i>
          </div>
          <div class="rating-score-card" id="scoreCard">
            <div class="rating-score-val"><span id="scoreVal">0</span>/5</div>
            <div class="rating-score-text" id="scoreLabel">Cukup</div>
            <div style="font-size: 1.2rem; margin-top: 0.1rem;" id="scoreEmoji">🙂</div>
          </div>
        </div>

        <div class="rating-feedback-box" id="feedbackBox">
          <div class="rating-feedback-icon" id="feedbackIcon">💡</div>
          <div class="rating-feedback-content">
            <strong id="feedbackTitle">Cukup</strong>
            <span id="feedbackText">Pengalamanmu lumayan, tapi masih ada beberapa hal yang bisa ditingkatkan.</span>
          </div>
        </div>

        <!-- Komentar -->
        <div class="question-label">Ceritakan pengalamanmu</div>
        <div class="question-sub">Ulasanmu sangat berharga untuk pengelola dan calon penghuni lainnya.</div>
        <textarea name="komentar" id="komentarInput" class="comment-area" rows="3" placeholder="Ceritakan pengalamanmu di kos ini..." required></textarea>
        <div class="char-counter"><span id="charCount">0</span>/500</div>

        <!-- Aspek Tambahan -->
        <div class="d-flex justify-content-between align-items-end mt-3 mb-2">
          <div class="question-label mb-0" style="font-size:.85rem;">Beri nilai untuk aspek berikut <span style="font-weight:normal;color:#888;">(opsional)</span></div>
          <div style="font-size:.7rem;color:#aaa;">Klik untuk menilai</div>
        </div>
        
        <div class="aspect-grid">
          <div class="aspect-item">
            <div class="aspect-label">🧹 Kebersihan</div>
            <div class="aspect-stars" data-field="rating_kebersihan">
              <i class="bi bi-star-fill" data-val="1"></i><i class="bi bi-star-fill" data-val="2"></i><i class="bi bi-star-fill" data-val="3"></i><i class="bi bi-star-fill" data-val="4"></i><i class="bi bi-star-fill" data-val="5"></i>
            </div>
          </div>
          <div class="aspect-item">
            <div class="aspect-label">🖥️ Fasilitas</div>
            <div class="aspect-stars" data-field="rating_fasilitas">
              <i class="bi bi-star-fill" data-val="1"></i><i class="bi bi-star-fill" data-val="2"></i><i class="bi bi-star-fill" data-val="3"></i><i class="bi bi-star-fill" data-val="4"></i><i class="bi bi-star-fill" data-val="5"></i>
            </div>
          </div>
          <div class="aspect-item">
            <div class="aspect-label">📍 Lokasi</div>
            <div class="aspect-stars" data-field="rating_lokasi">
              <i class="bi bi-star-fill" data-val="1"></i><i class="bi bi-star-fill" data-val="2"></i><i class="bi bi-star-fill" data-val="3"></i><i class="bi bi-star-fill" data-val="4"></i><i class="bi bi-star-fill" data-val="5"></i>
            </div>
          </div>
          <div class="aspect-item">
            <div class="aspect-label">💰 Harga</div>
            <div class="aspect-stars" data-field="rating_harga">
              <i class="bi bi-star-fill" data-val="1"></i><i class="bi bi-star-fill" data-val="2"></i><i class="bi bi-star-fill" data-val="3"></i><i class="bi bi-star-fill" data-val="4"></i><i class="bi bi-star-fill" data-val="5"></i>
            </div>
          </div>
        </div>

        <div class="modal-actions">
          <button type="button" class="btn-modal-cancel" onclick="tutupModalUlasan()">✕ Batal</button>
          <button type="submit" class="btn-modal-submit" id="btnSubmitUlasan" disabled>⭐ Kirim Ulasan</button>
        </div>
      </div>
    </form>
  </div>
</div>

<section class="mt-5 mb-4">


</section>
@endsection


@section('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {

const modal = document.getElementById('modalUlasan');
const mainStars = document.querySelectorAll('#mainStars i');
const aspectStarContainers = document.querySelectorAll('.aspect-stars');
const ratingInput = document.getElementById('ratingInput');
const btnSubmit = document.getElementById('btnSubmitUlasan');
const formUlasan = document.getElementById('formUlasan');
const komentarInput = document.getElementById('komentarInput');
const charCount = document.getElementById('charCount');

const feedbackData = {
  1: { label: "Sangat Buruk", emoji: "😡", desc: "Pengalamanmu kurang menyenangkan, pasti ada banyak hal yang perlu diperbaiki.", icon: "⚠️" },
  2: { label: "Kurang", emoji: "😕", desc: "Ada beberapa hal yang mengecewakan dan perlu perhatian khusus.", icon: "📉" },
  3: { label: "Cukup", emoji: "🙂", desc: "Pengalamanmu lumayan, tapi masih ada beberapa hal yang bisa ditingkatkan.", icon: "💡" },
  4: { label: "Bagus", emoji: "😊", desc: "Kost ini cukup nyaman dan fasilitasnya berfungsi dengan baik.", icon: "✨" },
  5: { label: "Sangat Bagus", emoji: "🤩", desc: "Pengalaman yang luar biasa! Kost ini sangat direkomendasikan.", icon: "🔥" }
};

window.bukaModalUlasan = function(bookingId, kostName) {
  document.getElementById('ulasanBookingId').value = bookingId;
  document.getElementById('modalUlasanKost').innerHTML = '🏠 ' + kostName;
  modal.style.display = 'flex';
  document.body.style.overflow = 'hidden';
  resetModal();
};

window.tutupModalUlasan = function() {
  modal.style.display = 'none';
  document.body.style.overflow = '';
};

function resetModal() {
  mainStars.forEach(s => { s.className = 'bi bi-star'; s.classList.remove('active'); });
  document.getElementById('scoreCard').classList.remove('show');
  document.getElementById('feedbackBox').classList.remove('show');
  ratingInput.value = "0";
  komentarInput.value = "";
  charCount.innerText = "0";
  btnSubmit.disabled = true;
  
  // Reset aspects
  document.querySelectorAll('input[type=hidden][id^=rating_]').forEach(inp => inp.value = "0");
  aspectStarContainers.forEach(container => {
    container.classList.remove('rated-active', 'rated');
    container.querySelectorAll('i').forEach(s => s.classList.remove('active'));
  });
}

// MAIN RATING LOGIC
mainStars.forEach((star, index) => {
  star.addEventListener('click', () => {
    const val = index + 1;
    ratingInput.value = val;
    btnSubmit.disabled = false;
    
    // Update main stars UI
    mainStars.forEach((s, i) => {
      if(i < val) {
        s.className = 'bi bi-star-fill active';
      } else {
        s.className = 'bi bi-star';
        s.classList.remove('active');
      }
    });

    // Update Score Card & Feedback
    const fData = feedbackData[val];
    document.getElementById('scoreCard').classList.add('show');
    document.getElementById('feedbackBox').classList.add('show');
    document.getElementById('scoreVal').innerText = val;
    document.getElementById('scoreLabel').innerText = fData.label;
    document.getElementById('scoreEmoji').innerText = fData.emoji;
    document.getElementById('feedbackIcon').innerText = fData.icon;
    document.getElementById('feedbackTitle').innerText = fData.label;
    document.getElementById('feedbackText').innerText = fData.desc;

    // Set ALL aspect hidden inputs to this value by default
    document.querySelectorAll('input[type=hidden][id^=rating_]').forEach(inp => {
      inp.value = val;
    });

    // Update aspect UI to reflect default selection
    aspectStarContainers.forEach(container => {
      container.classList.add('rated');
      container.classList.remove('rated-active');
      container.querySelectorAll('i').forEach((s, i) => {
        s.classList.toggle('active', i < val);
      });
    });
  });
});

// ASPECT RATING LOGIC
aspectStarContainers.forEach(container => {
  const stars = container.querySelectorAll('i');
  const fieldName = container.dataset.field;
  const hiddenInput = document.getElementById(fieldName);

  stars.forEach((star, index) => {
    star.addEventListener('click', () => {
      const val = index + 1;
      hiddenInput.value = val;
      container.classList.add('rated-active'); // Make them yellow
      stars.forEach((s, i) => {
        s.classList.toggle('active', i < val);
      });
    });
  });
});

// COMMENT LOGIC
komentarInput.addEventListener('input', function() {
  const len = this.value.length;
  charCount.innerText = len;
  if(len > 500) {
    this.value = this.value.substring(0, 500);
    charCount.innerText = 500;
  }
});

// FORM SUBMIT AJAX
formUlasan.addEventListener('submit', function(e) {
  e.preventDefault();
  
  if (ratingInput.value === "0") {
    Swal.fire({
      icon: 'warning',
      title: 'Tunggu Dulu',
      text: 'Silakan berikan rating bintang utama terlebih dahulu!',
      confirmButtonColor: '#e8401c'
    });
    return;
  }

  const submitBtn = document.getElementById('btnSubmitUlasan');
  const originalText = submitBtn.innerHTML;
  submitBtn.innerHTML = '⏳ Mengirim...';
  submitBtn.disabled = true;

  const formData = new FormData(this);

  fetch(this.action, {
    method: 'POST',
    body: formData,
    headers: {
      'X-Requested-With': 'XMLHttpRequest',
      'Accept': 'application/json'
    }
  })
  .then(async response => {
    const data = await response.json();
    if (!response.ok) {
        let errorMsg = data.error || data.message || "Terjadi kesalahan.";
        if (data.errors) {
            errorMsg = Object.values(data.errors).flat().join('\\n');
        }
        throw new Error(errorMsg);
    }
    return data;
  })
  .then(data => {
    if(data.success || data.message) {
      Swal.fire({
        icon: 'success',
        title: 'Terima Kasih! 🎉',
        text: 'Ulasan Anda berhasil dikirim.',
        showConfirmButton: false,
        timer: 2000
      }).then(() => {
        window.location.reload();
      });
    } else {
      throw new Error(data.error || "Gagal mengirim ulasan.");
    }
  })
  .catch(err => {
    Swal.fire({
      icon: 'error',
      title: 'Gagal Mengirim',
      text: err.message,
      confirmButtonColor: '#e8401c'
    });
    submitBtn.innerHTML = originalText;
    submitBtn.disabled = false;
  });
});

});
</script>
@endsection