<?php

namespace App\Http\Controllers;

use App\Models\Lainnya;
use Illuminate\Http\Request;
use App\Helpers\ActivityHelper;

class LainnyaController extends Controller
{
     public function index()
    {
        $lainnya = Lainnya::all();
        return view("inventaris.lainnya.index")->with("lainnya", $lainnya);
    }

    public function create()
    {
        return view("inventaris.lainnya.create");
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nama_barang' => 'required',
            'merk' => 'required',
            'type' => 'required',
            'tgl_peroleh' => 'required',
            'asal_usul' => 'required',
            'cara_peroleh' => 'required',
            'jumlah_brg' => 'required',
            'harga_perunit' => 'required',
            'total_harga' => 'nullable|numeric',
        ]);

        // Proses upload gambar jika ada
        // if ($request->hasFile('gambar_barang')) {
        //     $imageName = time() . '.' . $request->file('gambar_barang')->extension();
        //     $request->file('gambar_barang')->move(public_path('gambar'), $imageName);
        //     $validated['gambar_barang'] = $imageName;
        // }

        // Simpan data ke database
        Lainnya::create($validated);

        return redirect()->route('lainnya.index')->with('success', 'Data Barang Lainnya berhasil disimpan');
    }

    public function edit($id)
    {
        $lainnya = Lainnya::find($id);
        return view('inventaris.lainnya.edit', compact('lainnya'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'nama_barang' => 'required'.$id,
            'merk' => 'required',
            'type' => 'required',
            'tgl_peroleh' => 'required',
            'asal_usul' => 'required',
            'cara_peroleh' => 'required',
            'jumlah_brg' => 'required',
            'harga_perunit' => 'required',
            'total_harga' => 'nullable|numeric',
        ]);

        // Proses upload gambar jika ada
        if ($request->hasFile('gambar_barang')) {
            $imageName = time() . '.' . $request->file('gambar_barang')->extension();
            $request->file('gambar_barang')->move(public_path('gambar'), $imageName);
            $validated['gambar_barang'] = $imageName;
        }

        // Update data ke database
        Lainnya::find($id)->update($validated);

        return redirect()->route('lainnya.index')->with('success', 'Data Barang Lainnya berhasil diupdate');
    }

    public function destroy($id)
    {
        Lainnya::find($id)->delete();
        return redirect()->route('lainnya.index')->with('success', 'Data Barang Lainnya berhasil dihapus');
    }
}
