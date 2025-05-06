@extends('layout.main')
@section('title', 'Tambah Pengembalian')

@section('content')
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Pengembalian Barang</h4>
                <p class="card-description">Formulir Pengembalian</p>

                <form action="{{ route('pengembalian.store') }}" method="POST" id="pengembalianForm">
                    @csrf
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if ($peminjaman)
                        {{-- Hidden input --}}
                        <input type="hidden" name="peminjaman_id" value="{{ $peminjaman->id }}">
                        <input type="hidden" id="jumlah_peminjam" value="{{ $peminjaman->jumlah_peminjam }}">

                        <div class="form-group">
                            
                            <label>Nama Peminjam</label>
<input type="text" class="form-control" value="{{ $peminjaman->nama_peminjam }}" readonly>

                            <label>Nama Barang</label>
                            <input type="text" class="form-control" value="{{ $peminjaman->barang->nama_barang }}" readonly>

                            <label>Kode Barang</label>
                            <input type="text" class="form-control" value="{{ $peminjaman->barang->kode_barang }}" readonly>

                            <label>Harga Barang</label>
                            <input type="text" class="form-control" value="Rp {{ number_format($peminjaman->barang->harga_barang, 0, ',', '.') }}" readonly>

                            <label>Jumlah Peminjaman</label>
                            <input type="text" class="form-control" id="total_peminjaman_display" value="{{ $peminjaman->jumlah_peminjam }}" readonly>

                            <label>Tanggal Peminjaman</label>
                            <input type="date" class="form-control" value="{{ $peminjaman->tgl_peminjam }}" readonly>

                            <label>Gambar Barang</label><br>
                            <img src="{{ asset('gambar/' . $peminjaman->barang->gambar_barang) }}" alt="Gambar Barang" style="max-width: 150px;"><br>
                        </div>

                        {{-- Form Input --}}
                        <div class="form-group">
                            <label for="tanggal_pengembalian">Tanggal Pengembalian</label>
                            <input type="date" name="tanggal_pengembalian" class="form-control" required>

                            <label for="jumlah_pengembalian">Jumlah Dikembalikan</label>
                            <input type="number" name="jumlah_pengembalian" id="jumlah_pengembalian" class="form-control" min="0" required>

                            <label for="jumlah_barang_rusak">Jumlah Rusak</label>
                            <input type="number" name="jumlah_barang_rusak" id="jumlah_barang_rusak" class="form-control" min="0" required>

                            <label for="jumlah_barang_hilang">Jumlah Hilang</label>
                            <input type="number" name="jumlah_barang_hilang" id="jumlah_barang_hilang" class="form-control" min="0" required>

                            <small id="total_warning" class="text-danger" style="display: none;">
                                Total tidak boleh melebihi jumlah peminjaman.
                            </small>
                        </div>

                        <button type="submit" class="btn btn-primary mr-2">Simpan</button>
                        <a href="{{ route('pengembalian.index') }}" class="btn btn-light">Batal</a>
                    @else
                        <div class="alert alert-danger">
                            Data peminjaman tidak ditemukan.
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('pengembalianForm');
        const maxJumlah = parseInt(document.getElementById('jumlah_peminjam').value);

        const kembaliInput = document.getElementById('jumlah_pengembalian');
        const rusakInput = document.getElementById('jumlah_barang_rusak');
        const hilangInput = document.getElementById('jumlah_barang_hilang');
        const warning = document.getElementById('total_warning');

        function validateTotal() {
            const valKembali = parseInt(kembaliInput.value) || 0;
            const valRusak = parseInt(rusakInput.value) || 0;
            const valHilang = parseInt(hilangInput.value) || 0;

            const total = valKembali + valRusak + valHilang;

            if (total > maxJumlah) {
                warning.style.display = 'block';
                return false;
            } else {
                warning.style.display = 'none';
                return true;
            }
        }

        kembaliInput.addEventListener('input', validateTotal);
        rusakInput.addEventListener('input', validateTotal);
        hilangInput.addEventListener('input', validateTotal);

        form.addEventListener('submit', function (e) {
            if (!validateTotal()) {
                e.preventDefault();
                alert('Total jumlah tidak boleh melebihi jumlah peminjaman.');
            }
        });
    });
</script>
@endsection
