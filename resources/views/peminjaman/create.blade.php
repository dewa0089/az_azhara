@extends('layout.main')
@section('title', 'Tambah Peminjaman')

@section('content')
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Peminjaman Barang</h4>
                <p class="card-description">
                    Formulir Pengajuan
                </p>
                <form action="{{ route('peminjaman.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="nama_peminjam">Nama Peminjam</label>
                        <input type="text" class="form-control" name="nama_peminjam" placeholder="Nama Peminjam">

                        <label for="barang_id">Kode Barang</label>
                        <select name="barang_id" id="barang_id" class="form-control">
                            <option selected disabled>Pilih</option>
                            @foreach ($barang as $item)
                                <option value="{{ $item->id }}"
                                    data-nama="{{ $item->nama_barang }}"
                                    data-harga="{{ $item->harga_barang }}"
                                    data-gambar="{{ asset('gambar/' . $item->gambar_barang) }}">
                                    {{ $item->kode_barang }}
                                </option>
                            @endforeach
                        </select>

                        <label for="nama_barang">Nama Barang</label>
                        <input type="text" class="form-control" id="nama_barang" name="nama_barang" readonly>

                        <label for="jumlah_peminjam">Jumlah Peminjaman</label>
                        <input type="text" class="form-control" name="jumlah_peminjam" placeholder="Jumlah Peminjaman">

                        <label for="harga_barang">Harga Barang</label>
                        <input type="text" class="form-control" id="harga_barang" name="harga_barang" readonly>

                        <label for="gambar_barang">Gambar Barang</label><br>
                        <img id="gambar_barang_preview" src="#" alt="Gambar Barang" style="max-width: 150px; display: none;"><br>

                        <label for="tgl_peminjam">Tanggal Peminjaman</label>
                        <input type="date" class="form-control" name="tgl_peminjam" placeholder="Tanggal Peminjaman">
                        <br>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Simpan</button>
                    <a href="{{ url('peminjaman') }}" class="btn btn-light">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- JavaScript untuk update nama_barang, harga_barang, dan gambar --}}
<script>
    document.getElementById('barang_id').addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        const nama = selectedOption.getAttribute('data-nama');
        const harga = selectedOption.getAttribute('data-harga');
        const gambar = selectedOption.getAttribute('data-gambar');

        document.getElementById('nama_barang').value = nama || '';
        document.getElementById('harga_barang').value = harga || '';

        if (gambar) {
            const gambarPreview = document.getElementById('gambar_barang_preview');
            gambarPreview.src = gambar;
            gambarPreview.style.display = 'block';
        }
    });
</script>
@endsection
