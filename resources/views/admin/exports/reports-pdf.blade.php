<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body { font-family: Arial, sans-serif; font-size: 12px; color: #1f2937; background: #fff; }

  .header { background: linear-gradient(135deg, #4f46e5, #7c3aed); color: #fff; padding: 24px 30px; margin-bottom: 24px; }
  .header h1 { font-size: 22px; font-weight: 700; margin-bottom: 4px; }
  .header p { font-size: 11px; opacity: .85; }

  .section { margin-bottom: 22px; padding: 0 10px; }
  .section-title { font-size: 13px; font-weight: 700; color: #4f46e5; border-bottom: 2px solid #e0e7ff; padding-bottom: 6px; margin-bottom: 12px; text-transform: uppercase; letter-spacing: .05em; }

  /* STATS GRID */
  .stats-grid { display: table; width: 100%; border-collapse: collapse; margin-bottom: 6px; }
  .stat-box { display: table-cell; width: 16.6%; padding: 12px 10px; text-align: center; border: 1px solid #e5e7eb; border-radius: 8px; }
  .stat-box.blue { background: #eef2ff; }
  .stat-box.green { background: #ecfdf5; }
  .stat-box.orange { background: #fff7ed; }
  .stat-box.red { background: #fef2f2; }
  .stat-box.purple { background: #faf5ff; }
  .stat-box.dark { background: #f9fafb; }
  .stat-num { font-size: 20px; font-weight: 700; color: #111827; }
  .stat-label { font-size: 10px; color: #6b7280; margin-top: 3px; }

  /* STATUS GRID */
  .status-grid { display: table; width: 100%; border-collapse: separate; border-spacing: 8px; }
  .status-item { display: table-cell; width: 25%; padding: 10px 12px; border-radius: 8px; text-align: center; }
  .status-item.pending { background: #fff7ed; }
  .status-item.diterima { background: #ecfdf5; }
  .status-item.ditolak { background: #fef2f2; }
  .status-item.selesai { background: #eff6ff; }
  .status-num { font-size: 18px; font-weight: 700; }
  .status-label { font-size: 10px; margin-top: 2px; }

  /* TABLE */
  table { width: 100%; border-collapse: collapse; font-size: 10px; }
  thead th { background: #4f46e5; color: #fff; padding: 7px 8px; text-align: left; font-weight: 600; }
  tbody tr:nth-child(even) { background: #f8fafc; }
  tbody tr:nth-child(odd) { background: #fff; }
  tbody td { padding: 6px 8px; border-bottom: 1px solid #e5e7eb; vertical-align: middle; }

  .badge { padding: 2px 8px; border-radius: 999px; font-size: 9px; font-weight: 600; display: inline-block; }
  .badge-pending { background: #fff7ed; color: #c2410c; }
  .badge-diterima { background: #ecfdf5; color: #047857; }
  .badge-ditolak { background: #fef2f2; color: #b91c1c; }
  .badge-selesai { background: #eff6ff; color: #1d4ed8; }
  .badge-belum { background: #f3f4f6; color: #4b5563; }
  .badge-lunas { background: #ecfdf5; color: #047857; }

  /* TOP KOST */
  .top-kost-item { display: table; width: 100%; border: 1px solid #e5e7eb; border-radius: 8px; padding: 10px 12px; margin-bottom: 8px; background: #f8fafc; }
  .rank { display: table-cell; width: 40px; vertical-align: middle; }
  .rank-num { width: 30px; height: 30px; background: #eef2ff; color: #4338ca; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 13px; text-align: center; line-height: 30px; }
  .kost-info { display: table-cell; vertical-align: middle; padding-left: 10px; }
  .kost-name { font-weight: 700; font-size: 11px; color: #111827; }
  .kost-owner { font-size: 10px; color: #6b7280; margin-top: 2px; }
  .kost-stats { display: table-cell; vertical-align: middle; text-align: right; }
  .kost-booking { font-size: 10px; color: #4f46e5; font-weight: 600; }
  .kost-income { font-size: 10px; color: #047857; font-weight: 600; margin-top: 2px; }

  .footer { margin-top: 24px; padding: 12px 10px; border-top: 1px solid #e5e7eb; text-align: center; font-size: 10px; color: #9ca3af; }
</style>
</head>
<body>

{{-- HEADER --}}
<div class="header">
  <h1>📊 Laporan Platform KostFinder</h1>
  <p>Digenerate pada: {{ now()->translatedFormat('d F Y, H:i') }} WIB &nbsp;|&nbsp; Admin: {{ auth()->user()->name ?? 'Admin' }}</p>
</div>

{{-- STATISTIK UTAMA --}}
<div class="section">
  <div class="section-title">Ringkasan Statistik</div>
  <table style="border:0;">
    <tr>
      <td style="padding:6px;width:16.6%;">
        <div style="background:#eef2ff;border-radius:8px;padding:12px;text-align:center;">
          <div style="font-size:20px;font-weight:700;color:#4f46e5;">{{ $totalUsers }}</div>
          <div style="font-size:10px;color:#6b7280;margin-top:3px;">Total User</div>
        </div>
      </td>
      <td style="padding:6px;width:16.6%;">
        <div style="background:#ecfdf5;border-radius:8px;padding:12px;text-align:center;">
          <div style="font-size:20px;font-weight:700;color:#047857;">{{ $totalOwners }}</div>
          <div style="font-size:10px;color:#6b7280;margin-top:3px;">Total Owner</div>
        </div>
      </td>
      <td style="padding:6px;width:16.6%;">
        <div style="background:#fff7ed;border-radius:8px;padding:12px;text-align:center;">
          <div style="font-size:20px;font-weight:700;color:#c2410c;">{{ $totalKosts }}</div>
          <div style="font-size:10px;color:#6b7280;margin-top:3px;">Total Kost</div>
        </div>
      </td>
      <td style="padding:6px;width:16.6%;">
        <div style="background:#fef2f2;border-radius:8px;padding:12px;text-align:center;">
          <div style="font-size:20px;font-weight:700;color:#b91c1c;">{{ $totalBookings }}</div>
          <div style="font-size:10px;color:#6b7280;margin-top:3px;">Total Booking</div>
        </div>
      </td>
      <td style="padding:6px;width:16.6%;">
        <div style="background:#faf5ff;border-radius:8px;padding:12px;text-align:center;">
          <div style="font-size:20px;font-weight:700;color:#7c3aed;">{{ $bookingThisMonth }}</div>
          <div style="font-size:10px;color:#6b7280;margin-top:3px;">Booking Bulan Ini</div>
        </div>
      </td>
      <td style="padding:6px;width:16.6%;">
        <div style="background:#f0fdf4;border-radius:8px;padding:12px;text-align:center;">
          <div style="font-size:13px;font-weight:700;color:#15803d;">Rp {{ number_format($totalPendapatanAdmin ?? 0, 0, ',', '.') }}</div>
          <div style="font-size:10px;color:#6b7280;margin-top:3px;">Pendapatan Admin</div>
        </div>
      </td>
    </tr>
  </table>
</div>

{{-- STATUS BOOKING --}}
<div class="section">
  <div class="section-title">Status Booking</div>
  <table style="border:0;">
    <tr>
      <td style="padding:6px;width:25%;">
        <div style="background:#fff7ed;border-radius:8px;padding:12px;text-align:center;">
          <div style="font-size:18px;font-weight:700;color:#c2410c;">{{ $bookingByStatus['pending'] ?? 0 }}</div>
          <div style="font-size:10px;color:#6b7280;">Pending</div>
        </div>
      </td>
      <td style="padding:6px;width:25%;">
        <div style="background:#ecfdf5;border-radius:8px;padding:12px;text-align:center;">
          <div style="font-size:18px;font-weight:700;color:#047857;">{{ $bookingByStatus['diterima'] ?? 0 }}</div>
          <div style="font-size:10px;color:#6b7280;">Diterima</div>
        </div>
      </td>
      <td style="padding:6px;width:25%;">
        <div style="background:#fef2f2;border-radius:8px;padding:12px;text-align:center;">
          <div style="font-size:18px;font-weight:700;color:#b91c1c;">{{ $bookingByStatus['ditolak'] ?? 0 }}</div>
          <div style="font-size:10px;color:#6b7280;">Ditolak</div>
        </div>
      </td>
      <td style="padding:6px;width:25%;">
        <div style="background:#eff6ff;border-radius:8px;padding:12px;text-align:center;">
          <div style="font-size:18px;font-weight:700;color:#1d4ed8;">{{ $bookingByStatus['selesai'] ?? 0 }}</div>
          <div style="font-size:10px;color:#6b7280;">Selesai</div>
        </div>
      </td>
    </tr>
  </table>
</div>

{{-- BOOKING TERBARU --}}
<div class="section">
  <div class="section-title">Booking Terbaru (20 Terakhir)</div>
  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Penyewa</th>
        <th>Owner</th>
        <th>Nama Kost</th>
        <th>Kamar</th>
        <th>Status</th>
        <th>Pembayaran</th>
        <th>Total</th>
        <th>Komisi Admin</th>
        <th>Waktu</th>
      </tr>
    </thead>
    <tbody>
      @forelse($recentBookings as $i => $item)
      <tr>
        <td>{{ $i + 1 }}</td>
        <td>{{ $item->nama_penyewa }}</td>
        <td>{{ $item->nama_owner }}</td>
        <td>{{ $item->nama_kost }}</td>
        <td>Kamar #{{ $item->nama_kamar }}</td>
        <td>
          <span class="badge badge-{{ $item->status_booking }}">{{ ucfirst($item->status_booking) }}</span>
        </td>
        <td>
          @if($item->status_pembayaran === 'belum')
            <span class="badge badge-belum">Belum</span>
          @elseif($item->status_pembayaran === 'lunas')
            <span class="badge badge-lunas">Lunas</span>
          @else
            <span class="badge badge-pending">Menunggu</span>
          @endif
        </td>
        <td>Rp {{ number_format($item->total_bayar ?? 0, 0, ',', '.') }}</td>
        <td>Rp {{ number_format($item->komisi_admin ?? 0, 0, ',', '.') }}</td>
        <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</td>
      </tr>
      @empty
      <tr>
        <td colspan="10" style="text-align:center;padding:16px;color:#9ca3af;">Belum ada data booking.</td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>

{{-- TOP KOST --}}
<div class="section">
  <div class="section-title">Kost Terlaris Bulan Ini</div>
  @forelse($topKostsThisMonth as $index => $kost)
  <div style="border:1px solid #e5e7eb;border-radius:8px;padding:10px 14px;margin-bottom:8px;background:#f8fafc;">
    <table style="border:0;width:100%;">
      <tr>
        <td style="width:36px;vertical-align:middle;">
          <div style="width:30px;height:30px;background:#eef2ff;color:#4338ca;border-radius:8px;text-align:center;line-height:30px;font-weight:700;font-size:13px;">#{{ $index + 1 }}</div>
        </td>
        <td style="vertical-align:middle;padding-left:10px;">
          <div style="font-weight:700;font-size:11px;color:#111827;">{{ $kost->nama_kost }}</div>
          <div style="font-size:10px;color:#6b7280;">Owner: {{ $kost->nama_owner }}</div>
        </td>
        <td style="text-align:right;vertical-align:middle;">
          <div style="font-size:10px;color:#4f46e5;font-weight:600;">{{ $kost->total_booking }} Booking</div>
          <div style="font-size:10px;color:#047857;font-weight:600;">Rp {{ number_format($kost->total_pemasukan ?? 0, 0, ',', '.') }}</div>
        </td>
      </tr>
    </table>
  </div>
  @empty
  <div style="text-align:center;padding:16px;color:#9ca3af;background:#f9fafb;border-radius:8px;">Belum ada data kost terlaris bulan ini.</div>
  @endforelse
</div>

<div class="footer">
  KostFinder &copy; {{ date('Y') }} &nbsp;|&nbsp; Laporan ini dibuat secara otomatis oleh sistem
</div>

</body>
</html>