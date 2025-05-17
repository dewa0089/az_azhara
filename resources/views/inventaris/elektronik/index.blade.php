@extends('layout.main')
@section('main', 'elektronik')

@section('content')
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="row mb-1">
          <div class="col">
            <h4 class="card-title">Aset Barang Elektronik Sekolah</h4>
          </div>
          <div class="col text-end d-flex align-items-end justify-content-end">
            <a href="{{ route('elektronik.create')}}" class="btn btn-success mdi mdi-upload btn-icon-prepend">
              Tambah Data
            </a>
          </div>
        </div>           
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>
                  No
                </th>
                <th>
                  Kode Barang
                </th>
                <th>
                  Nama Barang
                </th>
                <th>
                  Merk
                </th>
                <th>
                  Type
                </th>
                <th>
                  Tanggal Peroleh Barang
                </th>
                <th>
                  Asal Usul
                </th>
                <th>
                  Cara Perolehan
                </th>
                <th>
                  Jumlah Barang
                </th>
                <th>
                  Harga Per Unit Barang
                </th>
                <th>
                  Total Harga
                </th>
                <th>
                  Aksi
                </th>
              </tr>
            </thead>
            <tbody>
              @foreach ($elektronik as $item)
              <tr>
                 <td>{{ $loop->iteration }}</td>                
                  <td>{{ $item['kode_barang'] }}</td>
                  <td>{{ $item['nama_barang'] }}</td>
                  <td>{{ $item['merk'] }}</td>
                  <td>{{ $item['type'] }}</td>
                  {{-- <td><img src="gambar/{{ $item['gambar_barang'] }}" class="rounded-circle" width="70px" />
                  </td> --}}
                  <td>{{ $item['tgl_peroleh'] }}</td>
                  <td>{{ $item['asal_usul'] }}</td>
                  <td>{{ $item['cara_peroleh'] }}</td>
                  <td>{{ $item['jumlah_brg'] }}</td>
                  <td>Rp {{ number_format($item['harga_perunit'], 0, ',', '.') }}</td>
                  <td>Rp {{ number_format($item['total_harga'], 0, ',', '.') }}</td>
                  <td>
                      <div class="d-flex justify-content-center">
                        <a href="{{ route('elektronik.edit', $item->id) }}">
                          <button class="btn btn-success btn-sm mx-3">Edit</button>
                      </a>
                      <form method="POST" action="{{ route('elektronik.destroy', $item->id) }}">
                          @method('delete')
                          @csrf
                          <button type="submit" class="btn btn-danger btn-sm show_confirm"
                              data-toggle="tooltip" title='Delete'
                              data-nama='{{ $item->nama_barang }}'>Hapus Data</button>
                      </form>
                          </form>
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
