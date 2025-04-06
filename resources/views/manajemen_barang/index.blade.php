@extends('layout.main')
@section('main', 'barang')

@section('content')
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Aset Barang Sekolah</h4>
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>
                  No
                </th>
                <th>
                  Nama Barang
                </th>
                <th>
                  Jumlah Barang
                </th>
                <th>
                  Kondisi Barang
                </th>
                <th>
                  Gambar Barang
                </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="py-1">
                  1
                </td>
                <td>
                  Meja
                </td>
                <td>
                  5
                </td>
                <td>
                  <div class="progress">
                      <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </td>
                <td>
                  <img src="images/faces/face1.jpg" alt="image"/>
                </td>
              </tr>
             
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
