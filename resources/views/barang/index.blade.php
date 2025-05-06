@extends('layout.main')
@section('main', 'barang')

@section('content')
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="row mb-1">
          <div class="col">
            <h4 class="card-title">Aset Barang Sekolah</h4>
          </div>
          <div class="col text-end d-flex align-items-end justify-content-end">
            <a href="{{ route('barang.create')}}" class="btn btn-success mdi mdi-upload btn-icon-prepend">
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
                  Jumlah Barang
                </th>
                <th>
                  Harga Barang
                </th>
                <th>
                  Gambar Barang
                </th>
                <th>
                  Tanggal Barang Di beli
                </th>
                <th>
                  Keterangan
                </th>
                <th>
                  Aksi
                </th>
              </tr>
            </thead>
            <tbody>
              @foreach ($barang as $item)
              <tr>
                 <td>{{ $loop->iteration }}</td>                
                  <td>{{ $item['kode_barang'] }}</td>
                  <td>{{ $item['nama_barang'] }}</td>
                  <td>{{ $item['jumlah_barang'] }}</td>
                  <td>{{ $item['harga_barang'] }}</td>
                  <td><img src="gambar/{{ $item['gambar_barang'] }}" class="rounded-circle" width="70px" />
                  </td>
                  <td>{{ $item['tgl_peroleh'] }}</td>
                  <td>{{ $item['keterangan'] }}</td>
                  <td>
                      <div class="d-flex justify-content-center">
                        <a href="{{ route('barang.edit', $item->id) }}">
                          <button class="btn btn-success btn-sm mx-3">Edit</button>
                      </a>
                      <form method="POST" action="{{ route('barang.destroy', $item->id) }}">
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
