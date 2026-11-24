@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card card-shadow mt-5">
            <div class="card-header bg-white text-center py-4">
                <h5 class="fw-bold text-secondary">LOGIN ADMINISTRATOR</h5>
            </div>
            <div class="card-body p-4">
                @if($errors->any())
                    <div class="alert alert-danger">{{ $errors->first() }}</div>
                @endif

                <form action="{{ route('login.process') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control">
                    </div>
                    <div class="mb-4">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-dark w-100 py-2">MASUK DASHBOARD</button>
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
