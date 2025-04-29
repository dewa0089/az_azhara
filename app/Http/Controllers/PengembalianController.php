<?php

namespace App\Http\Controllers;


use App\Models\Pengembalian;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    public function index()
    {
        $pengembalian = Pengembalian::all();
        return view("pengembalian.index")->with("pengembalian", $pengembalian);
    }

    public function create()
    {
        return view("pengembalian.create");
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'jumlah_pengembalian' => 'required|integer',
            'jumlah_barang_rusak' => 'required|integer',
            'tanggal_pengembalian' => 'required|date',
            'status' => 'required',
            'peminjaman_id' => 'required',
        ]);

        // Simpan data ke database
        Pengembalian::create($validated);

        return redirect()->route('pengembalian.index')->with('success', 'Data Barang berhasil disimpan');
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
