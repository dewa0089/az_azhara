<?php

namespace App\Http\Controllers;

use App\Models\Pengembalian;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
  public function index()
{
    // Mengambil semua data pengembalian beserta relasi peminjaman dan barangnya
    $pengembalian = Pengembalian::with(['peminjaman.barang'])->get();

    return view('pengembalian.index', compact('pengembalian'));
}


    public function create($id)
    {
        $peminjaman = Peminjaman::with('barang')->findOrFail($id);
        return view('pengembalian.create', compact('peminjaman'));
    }

    public function edit($id)
    {
        $pengembalian = Pengembalian::with(['peminjaman.barang'])->findOrFail($id);
        return view('pengembalian.edit', compact('pengembalian'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'jumlah_brg_baik' => 'required|integer|min:0',
            'jumlah_brg_rusak' => 'required|integer|min:0',
            'jumlah_brg_hilang' => 'required|integer|min:0',
            'tgl_pengembalian' => 'required|date',
        ]);

        $pengembalian = Pengembalian::findOrFail($id);
        $pengembalian->update([
            'jumlah_brg_baik' => $validated['jumlah_brg_baik'],
            'jumlah_brg_rusak' => $validated['jumlah_brg_rusak'],
            'jumlah_brg_hilang' => $validated['jumlah_brg_hilang'],
            'tgl_pengembalian' => $validated['tgl_pengembalian'],
            'status' => 'Menunggu Persetujuan',
        ]);

        return redirect()->route('pengembalian.index')->with('success', 'Pengajuan pengembalian berhasil diajukan.');
    }

    public function destroy($id)
    {
        Pengembalian::findOrFail($id)->delete();
        return redirect()->route('pengembalian.index')->with('success', 'Data Barang berhasil dihapus');
    }

    public function setujui($id)
{
    $pengembalian = Pengembalian::with('peminjaman.barang')->findOrFail($id);

    // Update status jadi "Disetujui"
    $pengembalian->status = 'Disetujui';

    // Update stok barang berdasarkan jumlah barang baik yang dikembalikan
    $barang = $pengembalian->peminjaman->barang;

    if ($barang && $pengembalian->jumlah_brg_baik > 0) {
        $barang->jumlah_barang += $pengembalian->jumlah_brg_baik;
        $barang->save();
    }

    $pengembalian->save();

    return redirect()->route('pengembalian.index')->with('success', 'Pengembalian disetujui dan stok barang diperbarui.');
}

}
