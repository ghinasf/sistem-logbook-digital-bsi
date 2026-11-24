@extends('layouts.app')

@section('content')
<nav class="navbar navbar-expand-lg navbar-light bg-white rounded shadow-sm mb-4 px-3">
    <div class="container-fluid px-0">
        <a class="navbar-brand fw-bold" href="#" style="color: #00a39e;">
            Admin Panel
        </a>
        <div class="d-flex gap-3">
            <a href="{{ route('admin.dashboard') }}" class="nav-link fw-bold text-dark">Dashboard</a>
            <a href="{{ route('admin.visitors') }}" class="nav-link text-muted">Data Tamu</a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="btn btn-sm btn-outline-danger">Logout</button>
            </form>
        <a href="{{ route('admin.profile') }}" class="btn btn-sm btn-outline-dark d-flex align-items-center" title="Ganti Password">
        <i class="fas fa-user-cog"></i>
        <span class="d-none d-md-inline ms-1">Profil</span>
    </a>
        </div>
    </div>
</nav>

<div class="row mb-4">
    <div class="col-md-12">
        <div class="card card-shadow h-100">
            <div class="card-body">
                <h6 class="fw-bold text-secondary mb-3">Statistik Kunjungan (7 Hari Terakhir)</h6>

                <div style="height: 350px; width: 100%;">
                    <canvas id="visitorChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card card-shadow mb-5">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-bold">Kunjungan Hari Ini ({{ \Carbon\Carbon::now()->format('d M Y') }})</h6>

        <form action="{{ route('admin.dashboard') }}" method="GET" class="d-flex">
            <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Cari nama/instansi..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-sm btn-dark">Cari</button>
        </form>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0 align-middle">
            <thead class="bg-light">
                <tr>
                    <th class="ps-4">Jam Masuk</th>
                    <th>Nama Tamu</th>
                    <th>Instansi</th>
                    <th>Tujuan</th>
                    <th>Status</th>
                    <th>Jam Keluar</th>
                </tr>
            </thead>
            <tbody>
                @forelse($todaysLogbooks as $log)
                <tr>
                    <td class="ps-4">{{ \Carbon\Carbon::parse($log->check_in)->format('H:i') }}</td>
                    <td class="fw-bold">{{ $log->guest->name }}</td>
                    <td>{{ $log->guest->institution }}</td>
                    <td><span class="badge bg-secondary">{{ $log->purpose->name }}</span></td>
                    <td>
                        @if($log->status == 'Di Ruang Server')
                            <span class="badge bg-success">Sedang Bertugas</span>
                        @else
                            <span class="badge bg-secondary">Selesai</span>
                        @endif
                    </td>
                    <td>{{ $log->check_out ? \Carbon\Carbon::parse($log->check_out)->format('H:i') : '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">Belum ada tamu hari ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('visitorChart').getContext('2d');

    // Gradien Warna BSI (Tosca/Turquoise)
    let gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(0, 163, 158, 0.5)'); // Warna BSI Pudar Atas
    gradient.addColorStop(1, 'rgba(255, 255, 255, 0.0)'); // Putih Bawah

    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartData->pluck('date')) !!},
            datasets: [{
                label: 'Jumlah Tamu',
                data: {!! json_encode($chartData->pluck('count')) !!},
                borderColor: '#00a39e',       // WARNA UTAMA BSI (Hijau Tosca)
                backgroundColor: gradient,
                borderWidth: 3,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#00a39e',  // Warna titik BSI
                pointRadius: 5,
                pointHoverRadius: 7,
                fill: true,
                tension: 0.1                  // Garis Tegas/Lurus (Sesuai Referensi)
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, // Penting agar ikut tinggi container 350px
            plugins: {
                legend: { display: false },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    backgroundColor: 'rgba(0, 163, 158, 0.9)', // Tooltip warna BSI
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    suggestedMax: 5,
                    ticks: {
                        stepSize: 1, // Angka Bulat
                        color: '#6c757d'
                    },
                    grid: {
                        borderDash: [5, 5],
                        color: '#e9ecef'
                    }
                },
                x: {
                    ticks: {
                        color: '#6c757d'
                    },
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
</script>
@endsection
