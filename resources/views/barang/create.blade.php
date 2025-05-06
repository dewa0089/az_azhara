@extends('layout.main')
@section('title', 'Tambah Barang')

@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Manajemen Barang</h4>
                    <p class="card-description">
                        Tambah Barang
                    </p>
                    <form class="forms-sample" method="POST" action="{{ route('barang.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="kode_barang">Kode Barang</label>
                            <input type="text" class="form-control" name="kode_barang" placeholder="Kode Barang"
                                value="{{ old('kode_barang') }}">
                            @error('kode_barang')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror

                            <label for="nama_barang">Nama Barang</label>
                            <input type="text" class="form-control" name="nama_barang" placeholder="Nama Barang"
                                value="{{ old('nama_barang') }}">
                            @error('nama_barang')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror

                            <label for="jumlah_barang">Jumlah Barang</label>
                            <input type="number" class="form-control" name="jumlah_barang" placeholder="Jumlah Barang"
                                value="{{ old('jumlah_barang') }}">
                            @error('jumlah_barang')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror

                            <label for="harga_barang">Harga Barang</label>
                            <input type="number" class="form-control" name="harga_barang" placeholder="Harga Barang"
                                value="{{ old('harga_barang') }}">
                            @error('harga_barang')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror

                            <label for="gambar_barang">Gambar Barang</label>
                            <input type="file" class="form-control" name="gambar_barang">
                            @error('gambar_barang')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror

                            <label for="tgl_peroleh">Tanggal Peroleh</label>
                            <input type="date" class="form-control" name="tgl_peroleh" value="{{ old('tgl_peroleh') }}">
                            @error('tgl_peroleh')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror

                            <label for="keterangan">Keterangan</label>
                            <input type="text" class="form-control" name="keterangan" placeholder="Keterangan"
                                value="{{ old('keterangan') }}">
                            @error('keterangan')
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
