@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold text-secondary">Manajemen Akun Admin</h4>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
                </a>
            </div>

            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <div class="card shadow-sm border-0">
                <div class="card-header text-white fw-bold py-3" style="background-color: #00a39e;">
                    <i class="fas fa-key me-2"></i> Ganti Password
                </div>
                <div class="card-body p-4">

                    <form action="{{ route('admin.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-bold small text-muted">Password Saat Ini</label>
                            <input type="password" name="current_password"
                                   class="form-control @error('current_password') is-invalid @enderror"
                                   placeholder="Masukkan password lama Anda">

                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <div class="mb-3">
                            <label class="form-label fw-bold small text-muted">Password Baru</label>
                            <input type="password" name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Minimal 6 karakter">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" class="form-control"
                                   placeholder="Ulangi password baru">
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-dark fw-bold">
                                <i class="fas fa-save me-2"></i> Simpan Perubahan
                            </button>
                        </div>

                    </form>
                </div>
            </div>

            <div class="card mt-4 border-0 bg-light">
                <div class="card-body">
                    <h6 class="fw-bold">Info Login</h6>
                    <p class="mb-1 text-muted small">Nama: {{ Auth::user()->name }}</p>
                    <p class="mb-0 text-muted small">Email: {{ Auth::user()->email }}</p>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
