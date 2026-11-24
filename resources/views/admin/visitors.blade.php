@extends('layouts.app')

@section('content')
<nav class="navbar navbar-expand-lg navbar-light bg-white rounded shadow-sm mb-4 px-3">
    <div class="container-fluid px-0">
        <a class="navbar-brand fw-bold" href="#" style="color: #00a39e;">Admin Panel</a>
        <div class="d-flex gap-3">
            <a href="{{ route('admin.dashboard') }}" class="nav-link text-muted">Dashboard</a>
            <a href="{{ route('admin.visitors') }}" class="nav-link fw-bold text-dark">Data Tamu</a>
       </div>
    </div>
</nav>

<div class="card card-shadow mb-5">
    <div class="card-header bg-white py-3">
        <div class="row align-items-center">
            <div class="col-md-4">
                <h6 class="mb-0 fw-bold">Riwayat Seluruh Kunjungan</h6>
            </div>
            <div class="col-md-8">
                <form action="{{ route('admin.visitors') }}" method="GET" class="d-flex justify-content-end gap-2">

                    <input type="date" name="date" class="form-control form-control-sm" style="max-width: 150px;" value="{{ request('date') }}">

                    <div class="input-group input-group-sm" style="max-width: 250px;">
                        <input type="text" name="search" class="form-control" placeholder="Cari Nama / NIK..." value="{{ request('search') }}">
                        <button type="submit" class="btn btn-dark">Cari</button>
                    </div>

                    @if(request('search') || request('date'))
                        <a href="{{ route('admin.visitors') }}" class="btn btn-sm btn-outline-secondary d-flex align-items-center">Reset</a>
                    @endif
                </form>
            </div>
        </div>
    </div>

    <div class="bg-light p-3 border-bottom">
        <form action="{{ route('admin.export') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-auto">
                <label class="small fw-bold text-muted">Dari</label>
                <input type="date" name="start_date" class="form-control form-control-sm" required value="{{ date('Y-m-01') }}">
            </div>
            <div class="col-auto">
                <label class="small fw-bold text-muted">Sampai</label>
                <input type="date" name="end_date" class="form-control form-control-sm" required value="{{ date('Y-m-d') }}">
            </div>
            <div class="col-auto">
                <select name="format" class="form-select form-select-sm">
                    <option value="excel">Excel (.xlsx)</option>
                    <option value="pdf">PDF (.pdf)</option>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-sm btn-success fw-bold"><i class="bi bi-download"></i> Unduh</button>
            </div>
        </form>
    </div>

    @if(session('success'))
        <div class="alert alert-success m-3">{{ session('success') }}</div>
    @endif

    <div class="card-body p-0">
        <table class="table table-hover mb-0 align-middle">
            <thead class="bg-light">
                <tr>
                    <th class="ps-4">Tanggal</th>
                    <th>Nama Tamu</th>
                    <th>Instansi</th>
                    <th>NIK</th>
                    <th>Tujuan</th>
                    <th>Durasi</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logbooks as $log)
                <tr>
                    <td class="ps-4">{{ \Carbon\Carbon::parse($log->check_in)->format('d M Y') }}</td>
                    <td>
                        <div class="fw-bold">{{ $log->guest->name }}</div>
                        <small class="text-muted">{{ $log->guest->phone }}</small>
                    </td>
                    <td>{{ $log->guest->institution }}</td>
                    <td>{{ $log->guest->id_number }}</td>
                    <td>{{ $log->purpose->name }}</td>
                    <td>
                        @if($log->check_out)
                            {{ \Carbon\Carbon::parse($log->check_in)->diffForHumans(\Carbon\Carbon::parse($log->check_out), true) }}
                        @else
                            <span class="badge bg-warning text-dark">Belum Selesai</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-1">
                            <a href="{{ route('admin.logbook.show', $log->id) }}" class="btn btn-sm btn-info text-white" title="Lihat Detail">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                    <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                </svg>
                            </a>

                            <button type="button" class="btn btn-sm btn-outline-danger"
                                    data-bs-toggle="modal" data-bs-target="#deleteModal"
                                    onclick="setDeleteAction('{{ route('admin.visitors.destroy', $log->id) }}')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                    <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">Data tidak ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-3">
            {{ $logbooks->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-body text-center pb-5 pt-4 px-5">
                <h4 class="fw-bold mb-3">Hapus Data?</h4>
                <p class="text-muted mb-4">Data akan dihapus permanen.</p>
                <div class="d-flex justify-content-center gap-2">
                    <button type="button" class="btn btn-light border px-4" data-bs-dismiss="modal">Batal</button>
                    <form id="deleteForm" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger px-4">Ya, Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>function setDeleteAction(url) { document.getElementById('deleteForm').action = url; }</script>
@endsection
