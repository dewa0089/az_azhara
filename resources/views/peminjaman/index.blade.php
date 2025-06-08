@extends('layout.main')
@section('main', 'peminjaman')

@section('content')
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="row mb-1">
          <div class="col">
            <h4 class="card-title">Peminjaman Barang</h4>
          </div>
          <div class="col text-end d-flex align-items-end justify-content-end">
            <a href="{{ route('peminjaman.create') }}" class="btn btn-success mdi mdi-upload btn-icon-prepend">
              Ajukan Peminjaman
            </a>
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
                <th>Tanggal Peminjaman</th>
                <th>Tanggal Batas Pengembalian</th>
                <th>Status</th>
                @if(in_array(Auth::user()->role, ['A']))
                <th>Aksi</th>
                @endif
              </tr>
            </thead>
            <tbody>
              @forelse ($peminjaman as $item)
              <tr>
                 <td>{{ $loop->iteration }}</td>                
                  <td>{{ $item['nama_peminjam'] }}</td>
                  <td>{{ $item['barang']['kode_barang'] }}</td>
                  <td>{{ $item['barang']['nama_barang'] }}</td>
                  <td>{{ $item['jumlah_peminjam'] }}</td>
                  {{-- <td><img src="gambar/{{ $item['barang']['gambar_barang'] }}" class="rounded-circle" width="70px" /> </td> --}}
                  <td>{{ $item['tgl_peminjam'] }}</td>
                  <td>{{ $item['tgl_kembali'] }}</td>
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
                @if(in_array(Auth::user()->role, ['A']))
               <td>
  <div class="d-flex justify-content-start">
    @if($item->status == 'Menunggu Persetujuan')
      <form action="{{ route('peminjaman.setujui', $item->id) }}" method="POST" style="margin-right: 10px;">
        @csrf
        @method('PATCH')
        <button class="btn btn-sm btn-success">Setujui</button>
      </form>
      <form action="{{ route('peminjaman.tolak', $item->id) }}" method="POST" style="margin-right: 10px;">
        @csrf
        @method('PATCH')
        <button class="btn btn-sm btn-warning">Tolak</button>
      </form>
      <form action="{{ route('peminjaman.batalkan', $item->id) }}" method="POST">
        @csrf
        @method('PATCH')
        <button class="btn btn-sm btn-danger">Batalkan</button>
      </form>
    @else
      <span class="text-muted">Tidak ada aksi</span>
    @endif
  </div>
</td>    
@endif    
              </tr>
              @empty
  <tr>
    <td colspan="9" class="text-center">Tidak ada data Peminjaman.</td>
  </tr>
              @endforelse
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
