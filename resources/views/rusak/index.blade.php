@extends('layout.main')
@section('main', 'barang_rusak')

@section('content')
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="row mb-1">
          <div class="col">
            <h4 class="card-title">Aset Barang Sekolah</h4>
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
                  Jumlah Barang Rusak
                </th>
                <th>
                  Harga Barang
                </th>
                <th>
                  Gambar Barang Rusak
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
             <tr></tr>
       
             
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
