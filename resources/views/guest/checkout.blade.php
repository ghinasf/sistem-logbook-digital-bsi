@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card card-shadow border-top border-5 border-success">
            <div class="card-body text-center p-5">
                <div class="mb-4">
                    <img src="https://img.icons8.com/color/96/ok--v1.png" alt="Success">
                </div>

                <h3 class="fw-bold text-success">CHECK-IN BERHASIL!</h3>
                <p class="text-muted">Status Anda saat ini: <br>
                <span class="badge bg-success fs-6 mt-2">SEDANG DI RUANG SERVER</span></p>

                <hr class="my-4">

                <div class="text-start bg-light p-4 rounded mb-4 border">
                    <div class="row mb-2">
                        <div class="col-4 text-muted small">NAMA TAMU</div>
                        <div class="col-8 fw-bold text-dark">{{ $logbook->guest->name }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4 text-muted small">INSTANSI</div>
                        <div class="col-8 fw-bold text-dark">{{ $logbook->guest->institution }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4 text-muted small">TUJUAN</div>
                        <div class="col-8 fw-bold text-dark">{{ $logbook->purpose->name }}</div>
                    </div>
                    <div class="row">
                        <div class="col-4 text-muted small">JAM MASUK</div>
                        <div class="col-8 fw-bold text-success">{{ \Carbon\Carbon::parse($logbook->check_in)->format('H:i') }} WIB</div>
                    </div>
                </div>

                <div class="alert alert-warning d-flex align-items-center" role="alert">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16">
                        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                    </svg>
                    <div class="small text-start">
                        Mohon jangan tutup halaman ini. Tekan tombol di bawah jika pekerjaan telah selesai.
                    </div>
                </div>

                <button type="button" class="btn btn-danger btn-lg w-100 py-3 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#confirmModal">
                    CHECK-OUT
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-white border-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center pb-5 pt-0 px-5">
                <div class="mb-3 text-warning">
                    <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="currentColor" class="bi bi-question-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                        <path d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286zm1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94z"/>
                    </svg>
                </div>

                <h4 class="fw-bold mb-3">Konfirmasi Check-Out</h4>
                <p class="text-muted mb-4">
                    Apakah Anda yakin seluruh kegiatan di Ruang Server telah selesai? Waktu keluar akan dicatat oleh sistem secara otomatis.
                </p>

                <div class="d-flex justify-content-center gap-2 w-100">
                    <button type="button" class="btn btn-light btn-lg px-4 w-50 fw-bold border" data-bs-dismiss="modal">
                        Batal
                    </button>

                    <form action="{{ route('guest.checkout-process', $logbook->id) }}" method="POST" class="w-50">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-lg w-100 fw-bold">
                            Ya, Selesai
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
