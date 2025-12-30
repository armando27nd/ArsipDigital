@extends('layouts.auth')

@section('content')
{{-- Pindahkan div.login-box dari auth.blade.php ke sini --}}
<div class="login-box">
    <div class="login-logo text-center">
        <img src="{{ asset('img-pemkab.png') }}" alt="Logo" height="80" class="mb-2">
        <h4><b>Sistem Arsip & Laporan</b></h4> {{-- Hapus text-white karena sudah diatur di CSS .login-logo --}}
    </div>

    <!-- <div class="card rounded-lg shadow"> -->
    <div class="label_card">
        <div>
            <p class="login-box-msg">Login untuk memulai sesi Anda</p>

            @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="input-group mb-3">
                    <input id="username" type="text" name="username" value="{{ old('username') }}" required autofocus
                        class="form-control @error('username') is-invalid @enderror" placeholder="Username">
                    <div class="input-group-append">
                        <div class="input-group-text"><i class="fas fa-user"></i></div>
                    </div>
                    @error('username')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="input-group mb-3">
                    <input id="password" type="password" name="password" required
                        class="form-control @error('password') is-invalid @enderror" placeholder="Password">
                    <div class="input-group-append">
                        <div class="input-group-text"><i class="fas fa-lock"></i></div>
                    </div>
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn-primary">Login</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Hapus footer login di sini karena sudah dipindahkan ke auth.blade.php --}}
    {{-- <div class="text-center mt-3">
        <small class="text-white">© {{ date('Y') }} Sistem Arsip & Laporan</small>
    </div> --}}
</div>
@endsection
