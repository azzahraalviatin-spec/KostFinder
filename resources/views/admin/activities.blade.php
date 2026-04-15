@extends('admin.layout')

@section('title', 'Monitoring Aktivitas')
@section('page_title', 'Monitoring Aktivitas Sistem')
@section('page_subtitle', 'Riwayat pengguna yang masuk ke sistem')

@section('content')
<style>
    .activity-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 24px;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
        border: 1px solid #eef2f7;
    }

    .activity-search .form-control {
        height: 50px;
        border-radius: 14px;
        border: 1px solid #dbe2ea;
        font-size: 15px;
        padding-left: 18px;
        box-shadow: none;
    }

    .activity-search .form-control:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 0.15rem rgba(59, 130, 246, 0.12);
    }

    .btn-soft {
        border-radius: 12px;
        padding: 10px 18px;
        font-weight: 600;
    }

    .activity-table {
        border-collapse: separate;
        border-spacing: 0 10px;
    }

    .activity-table thead th {
        border: none !important;
        font-size: 13px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        padding: 0 14px 10px;
    }

    .activity-table tbody tr {
        background: #f8fafc;
        transition: all 0.2s ease;
    }

    .activity-table tbody tr:hover {
        background: #eef4ff;
        transform: translateY(-1px);
    }

    .activity-table tbody td {
        border: none !important;
        padding: 16px 14px;
        vertical-align: middle;
    }

    .activity-table tbody tr td:first-child {
        border-top-left-radius: 14px;
        border-bottom-left-radius: 14px;
    }

    .activity-table tbody tr td:last-child {
        border-top-right-radius: 14px;
        border-bottom-right-radius: 14px;
    }

    .user-name {
        font-weight: 600;
        color: #0f172a;
        margin-bottom: 2px;
    }

    .user-sub {
        font-size: 13px;
        color: #94a3b8;
    }

    .time-main {
        font-weight: 600;
        color: #0f172a;
    }

    .time-sub {
        font-size: 13px;
        color: #94a3b8;
    }

    .badge-role {
        padding: 8px 12px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
        display: inline-block;
        min-width: 78px;
        text-align: center;
    }

    .badge-admin {
        background: #fee2e2;
        color: #b91c1c;
    }

    .badge-owner {
        background: #fef3c7;
        color: #b45309;
    }

    .badge-user {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .badge-system {
        background: #e2e8f0;
        color: #475569;
    }

    .number-badge {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: #e0ecff;
        color: #2563eb;
        font-weight: 700;
        font-size: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .empty-state {
        padding: 40px 20px;
        text-align: center;
        color: #94a3b8;
    }

    nav[aria-label="pagination"] svg,
    .pagination svg {
        width: 16px !important;
        height: 16px !important;
    }
</style>

<div class="activity-card">
    <form method="GET" action="{{ route('admin.activities') }}" class="row g-3 mb-4 activity-search">
        <div class="col-lg-8">
            <input type="text" name="q" value="{{ request('q') }}" class="form-control"
                placeholder="Cari nama pengguna atau role...">
        </div>
        <div class="col-lg-4 d-flex gap-2">
            <button type="submit" class="btn btn-primary btn-soft px-4">Cari</button>
            <a href="{{ route('admin.activities') }}" class="btn btn-outline-secondary btn-soft px-4">Reset</a>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table activity-table align-middle mb-0">
            <thead>
                <tr>
                    <th style="width: 70px;">No</th>
                    <th>Pengguna</th>
                    <th style="width: 160px;">Role</th>
                    <th style="width: 240px;">Waktu</th>
                </tr>
            </thead>
            <tbody>
                @forelse($activities as $index => $item)
                    @php
                        $role = strtolower($item->actor->role ?? 'system');
                        $number = ($activities->firstItem() ?? 1) + $index;
                    @endphp
                    <tr>
                        <td>
                            <div class="number-badge">{{ $number }}</div>
                        </td>

                        <td>
                            <div class="user-name">{{ $item->actor->name ?? 'System' }}</div>
                            <div class="user-sub">Aktivitas tercatat di sistem</div>
                        </td>

                        <td>
                            @if($role == 'admin')
                                <span class="badge-role badge-admin">Admin</span>
                            @elseif($role == 'owner')
                                <span class="badge-role badge-owner">Owner</span>
                            @elseif($role == 'user')
                                <span class="badge-role badge-user">User</span>
                            @else
                                <span class="badge-role badge-system">System</span>
                            @endif
                        </td>

                        <td>
                            <div class="time-main">{{ $item->created_at?->format('d M Y') }}</div>
                            <div class="time-sub">{{ $item->created_at?->format('H:i:s') }}</div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">
                            <div class="empty-state">
                                Belum ada log aktivitas yang tersedia.
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4 d-flex justify-content-end">
        {{ $activities->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection