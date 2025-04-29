<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{

    public function index()
    {
        $peminjaman = Peminjaman::all();
        return view("peminjaman.index")->with("peminjaman", $peminjaman);
    }

    public function create()
    {
        return view("peminjaman.create");
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nama_peminjam' => 'required',
            'jumlah_peminjam' => 'required',
            'tanggal_peminjam' => 'required',
            'status' => 'required',
            'barang_id' => 'required',
        ]);

        // Simpan data ke database
        Peminjaman::create($validated);

        return redirect()->route('peminjaman.index')->with('success', 'Data Barang berhasil disimpan');
    }

    public function edit($id)
    {
        $peminjaman = Peminjaman::find($id);
        return view('peminjaman.edit', compact('peminjaman'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'nama_peminjam' => 'required',
            'jumlah_peminjam' => 'required|integer',
            'tanggal_peminjam' => 'required|date',
            'status' => 'required',
            'barang_id' => 'required',
        ]);

        // Update data ke database
        Peminjaman::find($id)->update($validated);

        return redirect()->route('peminjaman.index')->with('success', 'Data Barang berhasil diupdate');
    }

    public function destroy($id)
    {
        Peminjaman::find($id)->delete();
        return redirect()->route('peminjaman.index')->with('success', 'Data Barang berhasil dihapus');
    }
}
