@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">

        <div class="p-4 mb-5 rounded-4 shadow-sm position-relative overflow-hidden hero-bsi text-center">
            <div class="circle-decoration-1"></div>
            <div class="circle-decoration-2"></div>

            <div class="position-relative" style="z-index: 2;">
                <h1 class="fw-bold mb-3 mt-2">Assalamu’alaikum,</h1>

                <h5 class="fw-normal text-white mb-4 mx-auto lh-base px-3" style="max-width: 800px;">
                    Demi menjaga keamanan & ketertiban area vital perbankan,
                    seluruh tamu vendor maupun petugas internal <strong>wajib</strong> melakukan registrasi sebelum memasuki area server.
                </h5>

                <div class="d-inline-flex align-items-center bg-white bg-opacity-10 px-3 py-2 rounded-pill border border-white border-opacity-10 small shadow-sm mb-2">
                    <i class="bi bi-calendar-check me-2"></i>
                    {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                </div>
            </div>
        </div>

        @if(session('error'))
            <div class="alert alert-danger mb-4 text-center shadow-sm border-0 border-start border-5 border-danger py-2 small">
                <strong>Akses Ditolak.</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row justify-content-center g-4">

            <div class="col-md-5 col-lg-4">
                <a href="{{ route('guest.index') }}" class="text-decoration-none">
                    <div class="card h-100 border-0 shadow-sm hover-card menu-card-guest text-center">
                        <div class="card-body p-4">
                            <div class="d-inline-flex align-items-center justify-content-center bg-success bg-opacity-10 text-success rounded-circle mb-3" style="width: 70px; height: 70px;">
                                <i class="bi bi-person-vcard-fill fs-2"></i>
                            </div>

                            <h5 class="fw-bold text-dark mb-2">Registrasi Tamu</h5>
                            <p class="text-muted small mb-3">
                                Menu untuk Vendor / Tamu Eksternal yang akan berkunjung.
                            </p>

                            <span class="btn btn-outline-success btn-sm rounded-pill px-4 fw-bold">
                                Mulai Check-In
                            </span>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-5 col-lg-4">
                <a href="{{ route('login') }}" class="text-decoration-none">
                    <div class="card h-100 border-0 shadow-sm hover-card menu-card-admin text-center">
                        <div class="card-body p-4">
                            <div class="d-inline-flex align-items-center justify-content-center bg-secondary bg-opacity-10 text-secondary rounded-circle mb-3" style="width: 70px; height: 70px;">
                                <i class="bi bi-shield-lock-fill fs-2"></i>
                            </div>

                            <h5 class="fw-bold text-dark mb-2">Login Internal</h5>
                            <p class="text-muted small mb-3">
                                Akses khusus untuk Petugas IT / Admin Kantor.
                            </p>

                            <span class="btn btn-outline-secondary btn-sm rounded-pill px-4 fw-bold">
                                Login Petugas
                            </span>
                        </div>
                    </div>
                </a>
            </div>

        </div>

        </div>
</div>

<style>
    .hero-bsi {
        background: linear-gradient(135deg, #00a39e 0%, #007a76 100%);
        color: white;
    }
    .circle-decoration-1 {
        position: absolute; top: -50px; left: -50px; width: 150px; height: 150px;
        background: rgba(255,255,255,0.1); border-radius: 50%;
    }
    .circle-decoration-2 {
        position: absolute; bottom: -50px; right: -50px; width: 150px; height: 150px;
        background: rgba(255,255,255,0.1); border-radius: 50%;
    }
    .hover-card { transition: transform 0.2s ease, box-shadow 0.2s ease; background-color: #fff; }
    .hover-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important; }
    .menu-card-guest:hover { border-bottom: 4px solid #198754 !important; }
    .menu-card-admin:hover { border-bottom: 4px solid #6c757d !important; }
</style>
@endsection
