@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header text-white d-flex justify-content-between align-items-center" style="background-color: #00a39e;">
            <h5 class="mb-0">Detail Kunjungan Tamu</h5>
            <a href="{{ route('admin.visitors') }}" class="btn btn-sm btn-light text-success fw-bold">Kembali</a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 border-end">
                    <h5 class="text-muted mb-3">Data Tamu</h5>
                    <table class="table table-borderless">
                        <tr><th>Nama</th><td>: {{ $logbook->guest->name }}</td></tr>
                        <tr><th>NIK / ID</th><td>: {{ $logbook->guest->id_number }}</td></tr>
                        <tr><th>Instansi</th><td>: {{ $logbook->guest->institution }}</td></tr>
                        <tr><th>Telepon</th><td>: {{ $logbook->guest->phone }}</td></tr>
                    </table>
                </div>
                <div class="col-md-6 ps-4">
                    <h5 class="text-muted mb-3">Data Kunjungan</h5>
                    <table class="table table-borderless">
                        <tr><th>Keperluan</th><td>: <span class="badge bg-info text-dark">{{ $logbook->purpose->name }}</span></td></tr>
                        <tr><th>Jam Masuk</th><td>: {{ \Carbon\Carbon::parse($logbook->check_in)->format('d M Y, H:i') }} WIB</td></tr>
                        <tr><th>Jam Keluar</th>
                            <td>:
                                @if($logbook->check_out)
                                    {{ \Carbon\Carbon::parse($logbook->check_out)->format('d M Y, H:i') }} WIB
                                @else
                                    <span class="badge bg-warning text-dark">Sedang Berkunjung</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
