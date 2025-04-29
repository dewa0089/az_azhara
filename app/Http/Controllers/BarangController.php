<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        $barang = Barang::all();
        return view("barang.index")->with("barang", $barang);
    }

    public function create()
    {
        return view("barang.create");
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'kode_barang' => 'required|unique:barangs',
            'nama_barang' => 'required',
            'jumlah_barang' => 'required',
            'harga_barang' => 'required',
            'gambar_barang' => 'nullable|image',
            'tanggal_beli_barang' => 'required',
            'keterangan' => 'required',
        ]);

        // Proses upload gambar jika ada
        if ($request->hasFile('gambar_barang')) {
            $imageName = time() . '.' . $request->gambar_barang->extension();
            $request->gambar_barang->move(public_path('images'), $imageName);
            $validated['gambar_barang'] = $imageName;
        }

        // Simpan data ke database
        Barang::create($validated);

        return redirect()->route('barang.index')->with('success', 'Data Barang berhasil disimpan');
    }

    public function edit($id)
    {
        $barang = Barang::find($id);
        return view('barang.edit', compact('barang'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'kode_barang' => 'required|unique:barangs,kode_barang,' . $id,
            'nama_barang' => 'required',
            'jumlah_barang' => 'required|integer',
            'harga_barang' => 'required|integer',
            'gambar_barang' => 'nullable|image',
            'tanggal_beli_barang' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        // Proses upload gambar jika ada
        if ($request->hasFile('gambar_barang')) {
            $imageName = time() . '.' . $request->gambar_barang->extension();
            $request->gambar_barang->move(public_path('images'), $imageName);
            $validated['gambar_barang'] = $imageName;
        }

        // Update data ke database
        Barang::find($id)->update($validated);

        return redirect()->route('barang.index')->with('success', 'Data Barang berhasil diupdate');
    }

    public function destroy($id)
    {
        Barang::find($id)->delete();
        return redirect()->route('barang.index')->with('success', 'Data Barang berhasil dihapus');
    }
}
