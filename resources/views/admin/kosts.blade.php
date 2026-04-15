@extends('admin.layout')

@section('title', 'Monitoring Kos')
@section('page_title', 'Monitoring Data Kos')
@section('page_subtitle', 'Kelola data kos: detail, verifikasi, nonaktifkan, hapus')

@section('content')
<div class="card-panel">
    <form method="GET" action="{{ route('admin.kosts') }}" class="row g-2 mb-3">
        <div class="col-md-4">
            <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari nama kos/kota/alamat">
        </div>
        <div class="col-md-2">
            <select name="status" class="form-select">
                <option value="">Status kos</option>
                <option value="aktif" @selected(request('status') === 'aktif')>Aktif</option>
                <option value="nonaktif" @selected(request('status') === 'nonaktif')>Nonaktif</option>
            </select>
        </div>
        <div class="col-md-2">
            <select name="verified" class="form-select">
                <option value="">Verifikasi</option>
                <option value="ya" @selected(request('verified') === 'ya')>Terverifikasi</option>
                <option value="tidak" @selected(request('verified') === 'tidak')>Belum</option>
            </select>
        </div>
        <div class="col-md-4 d-flex gap-2">
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="{{ route('admin.kosts') }}" class="btn btn-outline-secondary">Reset</a>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-sm align-middle mb-0">
            <thead>
                <tr>
                    <th>Nama Kos</th>
                    <th>Owner</th>
                    <th>Kota</th>
                    <th>Tipe</th>
                    <th>Kamar</th>
                    <th>Harga Mulai</th>
                    <th>Verifikasi</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kosts as $kost)
                <tr>
                    <td>{{ $kost->nama_kost }}</td>
                    <td>{{ $kost->owner->name ?? '-' }}</td>
                    <td>{{ $kost->kota }}</td>
                    <td>{{ $kost->tipe_kost }}</td>
                    <td>{{ $kost->rooms_count }}</td>
                    <td>Rp {{ number_format((int) $kost->harga_mulai, 0, ',', '.') }}</td>
                    <td>
                        <span class="badge {{ $kost->is_verified ? 'text-bg-success' : 'text-bg-warning' }}">
                            {{ $kost->is_verified ? 'Terverifikasi' : 'Belum' }}
                        </span>
                    </td>
                    <td>
                        <span class="badge {{ $kost->status === 'aktif' ? 'text-bg-success' : 'text-bg-secondary' }}">
                            {{ $kost->status }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.kosts.show', $kost) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                            @if(! $kost->is_verified)
                                <form method="POST" action="{{ route('admin.kosts.verify', $kost) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-outline-success">Verifikasi</button>
                                </form>
                            @endif
                            <form method="POST" action="{{ route('admin.kosts.toggle-status', $kost) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-outline-warning">
                                    {{ $kost->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.kosts.destroy', $kost) }}" onsubmit="return confirm('Hapus data kos ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center text-muted">Belum ada data kos.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">
        {{ $kosts->links() }}
    </div>
</div>
@endsection
