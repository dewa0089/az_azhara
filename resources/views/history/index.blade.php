@extends('layout.main')
@section('main', 'history')

@section('content')
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">History Kegiatan</h4>
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
                  Kode Barang
                </th>
                <th>
                  Jenis Kegiatan
                </th>
                <th>
                  Tanggal Kegiatan
                </th>
                <th>
                  Waktu Kegiatan
                </th>
                <th>
                  Status
                </th>
              </tr>
            </thead>
            <tbody>
              <tbody>
@foreach($histories as $index => $history)
<tr>
  <td>{{ $index + 1 }}</td>
  <td>{{ $history->item->nama_barang ?? '-' }}</td>
  <td>{{ $history->item->kode_barang ?? '-' }}</td>
  <td>{{ ucfirst($history->jenis_kegiatan) }}</td>
  <td>{{ $history->tanggal_kegiatan }}</td>
  <td>{{ $history->waktu_kegiatan }}</td>
  <td>{{ ucfirst($history->status) }}</td>
</tr>
@endforeach
</tbody>

             
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
