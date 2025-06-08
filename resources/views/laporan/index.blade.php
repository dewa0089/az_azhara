@extends('layout.main')
@section('main', 'laporan')

@section('content')
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Laporan Barang</h4>

        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>No</th>
                <th>Keterangan</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>Laporan Barang Elektronik</td>
                <td>
                  <a href="{{ url('/laporan/elektronik') }}" target="_blank" class="btn btn-primary">
                    Cetak
                  </a>
                </td>
              </tr>
              <tr>
                <td>2</td>
                <td>Laporan Barang Mobiler</td>
                <td>
                 <a href="{{ url('/laporan/mobiler') }}" target="_blank" class="btn btn-primary">
                    Cetak
                  </a>
                </td>
              </tr>
              <tr>
                <td>3</td>
                <td>Laporan Barang Lainnya</td>
                <td>
                 <a href="{{ url('/laporan/lainnya') }}" target="_blank" class="btn btn-primary">
                    Cetak
                  </a>
                </td>
              </tr>
              <tr>
                <td>4</td>
                <td>Laporan Inventaris Barang Kecil</td>
                <td>
                  <a href="{{ url('/laporan/barangKecil') }}" target="_blank" class="btn btn-primary">
                    Cetak
                  </a>
                </td>
              </tr>
              <tr>
                <td>5</td>
                <td>Laporan Inventaris Peminjaman Barang</td>
                <td>
                  <a href="{{ url('/laporan/peminjaman') }}" target="_blank" class="btn btn-primary">
                    Cetak
                  </a>
                </td>
              </tr>
              <tr>
                <td>6</td>
                <td>Laporan Inventaris Pengembalian Barang</td>
                <td>
                  <a href="{{ url('/laporan/pengembalian') }}" target="_blank" class="btn btn-primary">
                    Cetak
                  </a>
                </td>
              </tr>
              <tr>
                <td>7</td>
                <td>Laporan Inventaris Barang Rusak</td>
                <td>
                  <a href="{{ url('/laporan/rusak') }}" target="_blank" class="btn btn-primary">
                    Cetak
                  </a>
                </td>
              </tr>
              <tr>
                <td>8</td>
                <td>Laporan Inventaris Pemusnaan Barang</td>
                <td>
                  <a href="{{ url('/laporan/pemusnaan') }}" target="_blank" class="btn btn-primary">
                    Cetak
                  </a>
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
