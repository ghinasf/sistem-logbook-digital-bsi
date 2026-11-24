@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        @if (session('success'))
            <div class="alert alert-success text-center">
                {{ session('success') }}
            </div>
        @endif

        <div class="card card-shadow">
            <div class="card-header bg-white text-center py-3">
                <h5 class="mb-0 fw-bold">FORM REGISTRASI TAMU</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('guest.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nomor Identitas (KTP/SIM) <span class="text-danger">*</span></label>
                            <input type="text" name="id_number" class="form-control" required placeholder="Masukkan No. KTP/SIM">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" required placeholder="Nama sesuai KTP">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Asal Instansi / Vendor <span class="text-danger">*</span></label>
                            <input type="text" name="institution" class="form-control" required placeholder="Contoh: PT. Telkom">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nomor Telepon <span class="text-danger">*</span></label>
                            <input type="text" name="phone" class="form-control" required placeholder="08xxxxxxxxxx">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Tujuan Kunjungan <span class="text-danger">*</span></label>
                        <select name="purpose_id" class="form-select" required>
                            <option value="">-- Pilih Tujuan --</option>
                            @foreach($purposes as $purpose)
                                <option value="{{ $purpose->id }}">{{ $purpose->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-bsi btn-lg fw-bold">
                            CHECK-IN
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="text-center mt-4">
    <a href="{{ route('home') }}" class="text-secondary text-decoration-none fw-bold small">
        <i class="bi bi-arrow-left"></i> KEMBALI KE MENU UTAMA
    </a>
</div>
    </div>
</div>
@endsection
