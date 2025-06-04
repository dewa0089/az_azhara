@extends('layout.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body">

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p>{{ __('Masukkan email dan kode verifikasi yang sudah dikirim ke email Anda.') }}</p>

                    <form method="POST" action="{{ route('password.verify-code') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('Email Address') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                name="email" value="{{ old('email') }}" required autocomplete="email" autofocus 
                                placeholder="Masukkan email Anda">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="code" class="form-label">{{ __('Kode Verifikasi') }}</label>
                            <input id="code" type="text" class="form-control @error('code') is-invalid @enderror" 
                                name="code" required placeholder="Masukkan kode verifikasi">
                            @error('code')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            {{ __('Verifikasi Kode') }}
                        </button>
                    </form>

                    <hr>
                    <p class="text-muted">
                        {{ __('Jika tidak menerima kode verifikasi, silakan cek folder spam atau kirim ulang kode verifikasi.') }}
                    </p>
                    <form method="POST" action="{{ route('password.resend-code') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">
                            {{ __('Kirim ulang kode verifikasi') }}
                        </button>.
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
