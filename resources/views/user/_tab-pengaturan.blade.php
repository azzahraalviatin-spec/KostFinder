<div class="content-card">
  <div class="content-card-head">Pengaturan</div>
  <div class="content-card-body" style="padding:0;">

    {{-- NOTIFIKASI --}}
    <div class="peng-section">
      <div class="peng-section-head" onclick="toggleNotif()">
        <div style="display:flex;align-items:center;gap:.65rem;">
          <i class="bi bi-bell" style="color:#e8401c;font-size:1rem;"></i>
          <span style="font-weight:700;font-size:.9rem;color:#1a2332;">Notifikasi</span>
        </div>
        <i class="bi bi-chevron-down" id="iconNotif" style="color:#8fa3b8;transition:transform .3s;"></i>
      </div>
      <div id="notifContent" style="display:none;">
        <form method="POST" action="#">
          @csrf @method('PATCH')
          <div class="peng-toggle-row">
            <div>
              <div class="peng-toggle-label">🏠 Tagihan Sewa</div>
              <div class="peng-toggle-sub">Pengingat jatuh tempo tagihan bulanan kos kamu.</div>
            </div>
            <label class="peng-switch">
              <input type="checkbox" name="notif_tagihan" {{ auth()->user()->notif_booking ?? true ? 'checked' : '' }}>
              <span class="peng-slider"></span>
            </label>
          </div>
          <div class="peng-toggle-row">
            <div>
              <div class="peng-toggle-label">📋 Status Booking</div>
              <div class="peng-toggle-sub">Update diterima, ditolak, atau perubahan status booking kamu.</div>
            </div>
            <label class="peng-switch">
              <input type="checkbox" name="notif_booking" {{ auth()->user()->notif_booking ?? true ? 'checked' : '' }}>
              <span class="peng-slider"></span>
            </label>
          </div>
          <div class="peng-toggle-row">
            <div>
              <div class="peng-toggle-label">💳 Konfirmasi Pembayaran</div>
              <div class="peng-toggle-sub">Notifikasi saat pembayaran kamu dikonfirmasi oleh pemilik kos.</div>
            </div>
            <label class="peng-switch">
              <input type="checkbox" name="notif_pembayaran" {{ auth()->user()->notif_pembayaran ?? true ? 'checked' : '' }}>
              <span class="peng-slider"></span>
            </label>
          </div>
          <div class="peng-toggle-row">
            <div>
              <div class="peng-toggle-label">🎁 Promo & Diskon</div>
              <div class="peng-toggle-sub">Info penawaran spesial, voucher, dan diskon dari KostFinder.</div>
            </div>
            <label class="peng-switch">
              <input type="checkbox" name="notif_promo" {{ auth()->user()->notif_promo ?? false ? 'checked' : '' }}>
              <span class="peng-slider"></span>
            </label>
          </div>
          <div class="peng-toggle-row" style="border-bottom:0;">
            <div>
              <div class="peng-toggle-label">💬 Pesan dari Pemilik Kos</div>
              <div class="peng-toggle-sub">Notifikasi chat atau pesan baru dari pemilik kos.</div>
            </div>
            <label class="peng-switch">
              <input type="checkbox" name="notif_chat" {{ auth()->user()->notif_chat ?? true ? 'checked' : '' }}>
              <span class="peng-slider"></span>
            </label>
          </div>
          <div style="padding:.75rem 1.2rem;border-top:1px solid #f0f3f8;">
            <button type="submit" class="btn-simpan-kecil">Simpan Notifikasi</button>
          </div>
        </form>
      </div>
    </div>

    {{-- KEAMANAN AKUN --}}
    <div class="peng-section">
      <div class="peng-section-head" onclick="toggleKeamanan()">
        <div style="display:flex;align-items:center;gap:.65rem;">
          <i class="bi bi-shield-lock" style="color:#e8401c;font-size:1rem;"></i>
          <span style="font-weight:700;font-size:.9rem;color:#1a2332;">Keamanan Akun</span>
        </div>
        <i class="bi bi-chevron-down" id="iconKeamanan" style="color:#8fa3b8;transition:transform .3s;"></i>
      </div>
      <div id="keamananContent" style="display:none;">
        <div style="padding:.75rem 1.2rem;">
          <a href="{{ route('profile.edit') }}" style="display:flex;align-items:center;justify-content:space-between;padding:.75rem 0;border-bottom:1px solid #f8fafd;text-decoration:none;color:#374151;">
            <div>
              <div style="font-size:.85rem;font-weight:600;">🔑 Ubah Password</div>
              <div style="font-size:.75rem;color:#8fa3b8;">Ganti password akun KostFinder kamu</div>
            </div>
            <i class="bi bi-chevron-right" style="color:#c0ccd8;"></i>
          </a>
          <a href="{{ route('profile.edit') }}" style="display:flex;align-items:center;justify-content:space-between;padding:.75rem 0;text-decoration:none;color:#374151;">
            <div>
              <div style="font-size:.85rem;font-weight:600;">📧 Ubah Email</div>
              <div style="font-size:.75rem;color:#8fa3b8;">Ganti alamat email yang terdaftar</div>
            </div>
            <i class="bi bi-chevron-right" style="color:#c0ccd8;"></i>
          </a>
        </div>
      </div>
    </div>

    {{-- BANTUAN --}}
    <div class="peng-section" style="border-bottom:0;">
      <a href="mailto:cs@kostfinder.id" class="peng-section-head" style="text-decoration:none;">
        <div style="display:flex;align-items:center;gap:.65rem;">
          <i class="bi bi-envelope" style="color:#e8401c;font-size:1rem;"></i>
          <div>
            <div style="font-weight:700;font-size:.9rem;color:#1a2332;">Butuh Bantuan?</div>
            <div style="font-size:.75rem;color:#8fa3b8;">cs@kostfinder.id</div>
          </div>
        </div>
        <i class="bi bi-chevron-right" style="color:#c0ccd8;"></i>
      </a>
    </div>

  </div>
</div>

<style>
  .peng-section { border-bottom:1px solid #f0f3f8; }
  .peng-section-head { display:flex; align-items:center; justify-content:space-between; padding:1rem 1.2rem; cursor:pointer; transition:background .15s; }
  .peng-section-head:hover { background:#fafbfd; }
  .peng-toggle-row { display:flex; align-items:center; justify-content:space-between; gap:1rem; padding:.85rem 1.2rem; border-bottom:1px solid #f8fafd; }
  .peng-toggle-label { font-size:.85rem; font-weight:600; color:#1a2332; margin-bottom:.2rem; }
  .peng-toggle-sub { font-size:.75rem; color:#6b7280; max-width:420px; }
  .peng-switch { position:relative; display:inline-block; width:44px; height:24px; flex-shrink:0; }
  .peng-switch input { opacity:0; width:0; height:0; }
  .peng-slider { position:absolute; cursor:pointer; inset:0; background:#d1d5db; border-radius:999px; transition:.3s; }
  .peng-slider:before { position:absolute; content:""; height:18px; width:18px; left:3px; bottom:3px; background:#fff; border-radius:50%; transition:.3s; box-shadow:0 1px 3px rgba(0,0,0,.2); }
  .peng-switch input:checked + .peng-slider { background:#e8401c; }
  .peng-switch input:checked + .peng-slider:before { transform:translateX(20px); }
  .btn-simpan-kecil { background:#e8401c; color:#fff; font-weight:600; border:0; border-radius:.5rem; padding:.45rem 1.2rem; font-size:.82rem; cursor:pointer; }
  .btn-simpan-kecil:hover { background:#cb3518; }
</style>

<script>
  function toggleNotif() {
    const el = document.getElementById('notifContent');
    const icon = document.getElementById('iconNotif');
    const isHidden = el.style.display === 'none';
    el.style.display = isHidden ? 'block' : 'none';
    icon.style.transform = isHidden ? 'rotate(180deg)' : 'rotate(0deg)';
  }
  function toggleKeamanan() {
    const el = document.getElementById('keamananContent');
    const icon = document.getElementById('iconKeamanan');
    const isHidden = el.style.display === 'none';
    el.style.display = isHidden ? 'block' : 'none';
    icon.style.transform = isHidden ? 'rotate(180deg)' : 'rotate(0deg)';
  }
</script>