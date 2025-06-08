<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Laporan Barang Pengembalian</title>
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
        margin: 10mm 15mm 10mm 15mm;
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
    <p class="report-title">Laporan Barang Inventaris Pengembalian</p>
    <table class="static" rules="all" border="1" >
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
        </tr>
      </thead>
      <tbody>
        @forelse ($pengembalian as $item)
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
        </tr>
        @empty
        <tr>
          <td colspan="11" class="text-center">Tidak ada data Barang Pengembalian.</td>
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
