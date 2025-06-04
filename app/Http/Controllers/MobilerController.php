<?php

namespace App\Http\Controllers;

use App\Models\Mobiler;
use Illuminate\Http\Request;
use App\Helpers\ActivityHelper;

class MobilerController extends Controller
{
     public function index()
    {
        $mobiler = Mobiler::all();
        return view("inventaris.mobiler.index")->with("mobiler", $mobiler);
    }

    public function create()
    {
        return view("inventaris.mobiler.create");
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'kode_barang' => 'required|unique:mobilers',
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
        Mobiler::create($validated);

        return redirect()->route('mobiler.index')->with('success', 'Data Barang Mobiler berhasil disimpan');
    }

    public function edit($id)
    {
        $mobiler = Mobiler::find($id);
        return view('inventaris.mobiler.edit', compact('mobiler'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'kode_barang' => 'required|unique:mobilers,kode_barang,' . $id,
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

        // Update data ke database
        Mobiler::find($id)->update($validated);

        return redirect()->route('mobiler.index')->with('success', 'Data Barang Mobiler berhasil diupdate');
    }

    public function destroy($id)
    {
        Mobiler::find($id)->delete();
        return redirect()->route('mobiler.index')->with('success', 'Data Barang berhasil dihapus');
    }
}
