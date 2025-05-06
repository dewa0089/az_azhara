@extends('layout.main')
@section('main', 'pengembalian')

@section('content')
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="row mb-1">
          <div class="col">
            <h4 class="card-title">Pengembalian Barang</h4>
          </div>
        </div>         
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Peminjam</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Harga Barang</th>
                <th>Gambar Barang</th>
                <th>Jumlah Peminjaman</th>
                <th>Jumlah Pengembalian</th>
                <th>Jumlah Rusak</th>
                <th>Jumlah Hilang</th>
                <th>Tanggal Pengembalian</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($pengembalian as $item)
              <tr>
                <td>{{ $loop->iteration }}</td> 
                <td>{{ $item->peminjaman->nama_peminjam }}</td>               
                <td>{{ $item->peminjaman->barang->kode_barang }}</td>
                <td>{{ $item->peminjaman->barang->nama_barang }}</td>
                <td>Rp{{ number_format($item->peminjaman->barang->harga_barang, 0, ',', '.') }}</td>
                <td>
                  <img src="{{ asset('gambar/' . $item->peminjaman->barang->gambar_barang) }}" class="rounded-circle" width="70px" alt="Gambar Barang" />
                </td>
                <td>{{ $item->peminjaman->jumlah_peminjam }}</td>
                <td>{{ $item->jumlah_pengembalian }}</td>
                <td>{{ $item->jumlah_barang_rusak }}</td>
                <td>{{ $item->jumlah_barang_hilang }}</td>
                <td>{{ $item->tanggal_pengembalian ? \Carbon\Carbon::parse($item->tanggal_pengembalian)->format('d-m-Y') : '-' }}</td>
                <td>
                  <span class="badge 
                    @if($item->status == 'Disetujui') bg-success 
                    @elseif($item->status == 'Ditolak') bg-danger 
                    @elseif($item->status == 'Dibatalkan') bg-secondary 
                    @else bg-warning text-dark 
                    @endif">
                    {{ $item->status }}
                  </span>
                </td>
                <td>
                  @if($item->status === 'Belum Dikembalikan')
                  <a href="{{ route('pengembalian.create.id', $item->peminjaman->id) }}" class="btn btn-success">Ajukan Pengembalian</a>
                  @else
                    <span class="text-muted">Sudah diproses</span>
                  @endif
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  @if (Session::get('success'))
    toastr.success("{{ Session::get('success') }}")
  @endif
</script>
@endsection
