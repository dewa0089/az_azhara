<?php

namespace App\Http\Controllers;

use App\Models\Pengembalian;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    public function index()
    {
        // Mengambil pengembalian beserta data peminjaman dan barang yang terkait
        $pengembalian = Pengembalian::with('peminjaman.barang')->get();
        return view("pengembalian.index", compact('pengembalian'));
    }

    public function create($id)
    {
        $peminjaman = Peminjaman::with('barang')->findOrFail($id);
        return view('pengembalian.create', compact('peminjaman'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'peminjaman_id' => 'required',
            'tanggal_pengembalian' => 'required|date',
            'jumlah_pengembalian' => 'required|integer|min:1',
            'jumlah_barang_rusak' => 'required|integer|min:0',
            'jumlah_barang_hilang' => 'required|integer|min:0',
        ]);

        // Ambil data peminjaman
        $peminjaman = Peminjaman::find($request->peminjaman_id);

        // Validasi jumlah pengembalian tidak melebihi jumlah peminjaman
        if ($request->jumlah_pengembalian > $peminjaman->jumlah_peminjam) {
            return back()->withErrors(['jumlah_pengembalian' => 'Jumlah pengembalian tidak boleh lebih dari jumlah peminjaman.']);
        }

        // Validasi jumlah barang rusak dan hilang tidak melebihi jumlah yang dipinjam
        if ($request->jumlah_barang_rusak + $request->jumlah_barang_hilang > $peminjaman->jumlah_peminjam) {
            return back()->withErrors(['jumlah_barang_rusak' => 'Jumlah barang rusak dan hilang tidak boleh lebih dari jumlah yang dipinjam.']);
        }

        // Simpan data pengembalian
        $pengembalian = Pengembalian::create([
            'peminjaman_id' => $request->peminjaman_id,
            'tanggal_pengembalian' => $request->tanggal_pengembalian,
            'jumlah_pengembalian' => $request->jumlah_pengembalian,
            'jumlah_barang_rusak' => $request->jumlah_barang_rusak,
            'jumlah_barang_hilang' => $request->jumlah_barang_hilang,
            'status' => 'Menunggu Persetujuan',  // Status pengembalian adalah menunggu persetujuan
        ]);

        // Update status peminjaman
        $peminjaman->status = 'Pengembalian Diminta';
        $peminjaman->save();

        return redirect()->route('pengembalian.index')->with('success', 'Data pengembalian berhasil disimpan dan menunggu persetujuan.');
    }

    public function edit($id)
    {
        $pengembalian = Pengembalian::find($id);
        return view('pengembalian.edit', compact('pengembalian'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'jumlah_pengembalian' => 'required',
            'jumlah_barang_rusak' => 'required',
            'jumlah_barang_hilang' => 'required',
            'tanggal_pengembalian' => 'required',
            'status' => 'required',
            'peminjaman_id' => 'required',
        ]);

        // Update data ke database
        Pengembalian::find($id)->update($validated);

        return redirect()->route('pengembalian.index')->with('success', 'Data Barang berhasil diupdate');
    }

    public function destroy($id)
    {
        Pengembalian::find($id)->delete();
        return redirect()->route('pengembalian.index')->with('success', 'Data Barang berhasil dihapus');
    }
}
