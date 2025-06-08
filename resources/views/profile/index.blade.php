@extends('layout.app') {{-- atau layouts.main sesuai struktur proyekmu --}}

@section('content')
<div class="container mt-4">
    <h3>Pengaturan Profil</h3>
    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        {{-- Foto Profil --}}
        <div class="form-group">
            <label for="photo">Foto Profil</label><br>
            @if(Auth::user()->photo)
                <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="Foto Profil" width="100" class="mb-2">
            @endif
            <input type="file" class="form-control-file" name="photo" id="photo">
        </div>

        {{-- Nama --}}
        <div class="form-group mt-3">
            <label for="name">Nama</label>
            <input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}">
        </div>

        {{-- Password Baru --}}
        <div class="form-group mt-3">
            <label for="password">Password Baru</label>
            <input type="password" name="password" class="form-control" placeholder="Biarkan kosong jika tidak ingin mengubah">
        </div>

        {{-- Konfirmasi Password --}}
        <div class="form-group mt-3">
            <label for="password_confirmation">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary mt-4">Simpan Perubahan</button>
    </form>
</div>
@endsection
