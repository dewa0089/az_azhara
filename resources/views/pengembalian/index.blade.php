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
                <th>Jumlah Peminjaman</th>
                <th>Tanggal Batas Pengembalian</th>
                <th>Jumlah Barang Baik</th>
                <th>Jumlah Barang Rusak</th>
                <th>Jumlah Barang Hilang</th>
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
                <td>{{ $item->peminjaman->jumlah_peminjam }}</td>
                <td>{{ $item->peminjaman->tgl_kembali }}</td>
                <td>{{ $item->jumlah_brg_baik ?? '-' }}</td>
                <td>{{ $item->jumlah_brg_rusak ?? '-' }}</td>
                <td>{{ $item->jumlah_brg_hilang ?? '-' }}</td>
                <td>{{ $item->tgl_pengembalian ?? '-' }}</td>
                <td>
                <span class="badge 
                  @if($item->status == 'Dikembalikan') bg-success 
                  @elseif($item->status == 'Belum Dikembalikan') bg-warning text-dark 
                  @elseif($item->status == 'Menunggu Persetujuan') bg-warning text-dark 
                  @else bg-secondary 
                  @endif">
                  {{ $item->status }}
                </span>
                </td>

                <td>
              <div class="d-flex justify-content-center">
                  @if ($item->status == 'Belum Dikembalikan') 
                      <a href="{{ route('pengembalian.edit', $item->id) }}">
                          <button class="btn btn-success btn-sm mx-2">Ajukan Pengembalian</button>
                      </a>
                  @elseif ($item->status == 'Menunggu Persetujuan')
                      <form action="{{ route('pengembalian.setujui', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menyetujui pengembalian ini?')">
                          @csrf
                          @method('PUT')
                          <button class="btn btn-primary btn-sm">Setujui</button>
                      </form>
                  @else
                      <span class="text-muted">Tidak ada aksi</span>
                  @endif
              </div>
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
