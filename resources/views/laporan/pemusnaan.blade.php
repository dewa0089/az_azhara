<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Laporan Barang Pemusnaan</title>
  <style>
    body {
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      margin: 40px;
      color: #222;
      background-color: #fff;
    }
    .report-title {
      text-align: center;
      font-size: 24px;
      font-weight: 700;
      margin-bottom: 30px;
      text-transform: uppercase;
      letter-spacing: 1.5px;
      color: #333;
    }
    table.static {
      width: 100%;
      border-collapse: collapse;
      margin: 0 auto;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    table.static th,
    table.static td {
      border: 1px solid #666;
      padding: 10px 12px;
      text-align: center;
      vertical-align: middle;
      font-size: 14px;
    }
    table.static th {
      background-color: #f0f0f0;
      font-weight: 600;
      color: #444;
    }
    table.static tbody tr:nth-child(even) {
      background-color: #fafafa;
    }
    .text-end {
      text-align: right;
      padding-right: 15px;
    }
    .fw-bold {
      font-weight: 700;
    }
    /* Responsive & print-friendly */
    @media print {
      body {
        margin: 0mm;
        color-adjust: exact;
        -webkit-print-color-adjust: exact;
      }
      table.static th {
        background-color: #f0f0f0 !important;
        -webkit-print-color-adjust: exact;
      }
      /* Remove shadow for print */
      table.static {
        box-shadow: none;
      }
    }
  </style>
  <link rel="icon" href="{{ asset('images/favicon.png') }}">
</head>
<body>
  <div class="form-group">
    <p class="report-title">Laporan Barang Inventaris Pemusnaan</p>
    <table class="static" rules="all" border="1" >
      <thead>
        <tr>
                <th>No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Merk</th>
                <th>Type</th>
                <th>Tanggal Peroleh Barang</th>
                <th>Tanggal Rusak</th>
                <th>Tanggal Pemusnaan</th>
                <th>Asal Usul</th>
                <th>Cara Perolehan</th>
                <th>Jumlah dimusnakan</th>
                <th>Gambar Barang Rusak</th>
                <th>Gambar Pemusnaan Barang</th>
                <th>Harga/Unit</th>
                <th>Total Harga</th>
                <th>Keterangan</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($pemusnaan as $item)
         @php
                  $barang = $item->rusak->elektronik ?? $item->rusak->mobiler ?? $item->rusak->lainnya;
              @endphp
        <tr>
          <td>{{ $loop->iteration }}</td>
                  <td>{{ $barang->kode_barang ?? '-' }}</td>
                  <td>{{ $barang->nama_barang ?? '-' }}</td>
                  <td>{{ $barang->merk ?? '-' }}</td>
                  <td>{{ $barang->type ?? '-' }}</td>
                  <td>{{ $barang->tgl_peroleh ?? '-' }}</td>
                  <td>{{ $item->rusak->tgl_rusak }}</td>
                  <td>{{ $item->tanggal_pemusnaan ?? '-' }}</td>
                  <td>{{ $barang->asal_usul ?? '-' }}</td>
                  <td>{{ $barang->cara_peroleh ?? '-' }}</td>
                  <td>{{ $item->jumlah_pemusnaan }}</td>
                 <td>
                     @if(!empty($item->rusak->gambar_brg_rusak) && file_exists(public_path('gambar/' . $item->rusak->gambar_brg_rusak)))
                        <img src="{{ asset('gambar/' . $item->rusak->gambar_brg_rusak) }}" alt="Gambar Rusak" width="80">
                    @else
                        Tidak ada gambar
                    @endif
                  </td>
                  <td>
                      @if($item->gambar_pemusnaan)
                          <img src="{{ asset('gambar/' . $item->gambar_pemusnaan) }}" width="80">
                      @else
                          Tidak ada gambar
                      @endif
                  </td>
                  <td>Rp {{ number_format($barang->harga_perunit ?? 0, 0, ',', '.') }}</td>
                  <td>Rp {{ number_format(($barang->harga_perunit ?? 0) * $item->jumlah_pemusnaan, 0, ',', '.') }}</td>
                  <td>{{ $item->keterangan ?? '-' }}</td>
        </tr>
        @empty
  <tr>
    <td colspan="17" class="text-center">Tidak ada data Pemusnaan.</td>
  </tr>
        @endforelse
        
      </tbody>
    </table>
  </div>

<script>
  window.onload = function () {
    setTimeout(function () {
      window.print();
    }, 800);
  };
</script>

</body>
</html>
