<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use App\Helpers\ActivityHelper;

class BarangController extends Controller
{
    public function index(Request $request)
    {
       $search = $request->input('search');

    if ($search) {
        $barang = Barang::where('nama_barang', 'like', "%{$search}%")
            ->orWhere('kode_barang', 'like', "%{$search}%")
            ->get();
    } else {
        $barang = Barang::all();
    }
    $totalHarga = $barang->sum('total_harga');

   return view("barang.index", compact('barang', 'totalHarga'));
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
        'jumlah_rusak' => 'nullable',
        'jumlah_hilang' => 'nullable',
        'tgl_peroleh' => 'required',
        'harga_perunit' => 'required',
        'total_harga' => 'required',
    ]);

    $validated['jumlah_rusak'] = $validated['jumlah_rusak'] ?? 0;
    $validated['jumlah_hilang'] = $validated['jumlah_hilang'] ?? 0;


    // Simpan data ke database
    $barang = Barang::create($validated);
    
    // simpan riwayat
    ActivityHelper::log('Tambah Barang', 'Barang ' . $barang->nama_barang . ' berhasil ditambahkan');

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
            'jumlah_barang' => 'required',
            'jumlah_rusak' => 'nullable',
            'jumlah_hilang' => 'nullable',
            'tgl_peroleh' => 'required',
            'harga_perunit' => 'required',
            'total_harga' => 'required',
        ]);

        // Proses upload gambar jika ada
        // if ($request->hasFile('gambar_barang')) {
        //     $imageName = time() . '.' . $request->file('gambar_barang')->extension();
        //     $request->file('gambar_barang')->move(public_path('gambar'), $imageName);
        //     $validated['gambar_barang'] = $imageName;
        // }

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
