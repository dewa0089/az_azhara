@extends('layout.main')
@section('title', 'Tambah Barang')

@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Peminjaman Barang</h4>
                    <p class="card-description">
                        Formulir Pengajuan
                    </p>
                    <form class="forms-sample" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="nama">Nama Peminjam</label>
                            <input type="text" class="form-control" name="nama" placeholder="Nama Peminjam">
                            <label for="npm">Kode Barang</label>
                            <input type="text" class="form-control" name="npm" placeholder="Kode Barang"
                                value="{{ old('npm') }}">
                            <label for="tmpt_lahir">Nama Barang</label>
                            <input type="text" class="form-control" name="tmpt_lahir" placeholder="Jumlah Barang">
                            <label for="tmpt_lahir">Harga Barang</label>
                            <input type="text" class="form-control" name="jk" placeholder="Harga Barang">
                            <label for="tmpt_lahir">Jumlah Peminjaman</label>
                            <input type="text" class="form-control" name="jk" placeholder="Jumlah Peminjaman">
                            <label for="tgl_lahir">Tanggal Peminjaman</label>
                            <input type="text" class="form-control" name="tgl_lahir" placeholder="Tanggal Peroleh">
                            <br>
                            @error('npm')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                            @error('nama')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                            @error('tmpt_lahir')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                            @error('tgl_lahir')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                            @error('foto')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                            @error('prodi_id')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror

                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Simpan</button>
                        <a href="{{ url('barang') }}" class="btn btn-light">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
