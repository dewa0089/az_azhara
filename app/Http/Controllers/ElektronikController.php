<?php

namespace App\Http\Controllers;

use App\Models\Elektronik;
use Illuminate\Http\Request;
use App\Helpers\ActivityHelper;

class ElektronikController extends Controller
{
public function index(Request $request)
{
    $search = $request->input('search');

    if ($search) {
        $elektronik = Elektronik::where('nama_barang', 'like', "%{$search}%")
            ->orWhere('kode_barang', 'like', "%{$search}%")
            ->orWhere('merk', 'like', "%{$search}%")
            ->orWhere('type', 'like', "%{$search}%")
            ->get();
    } else {
        $elektronik = Elektronik::all();
    }
     // Hitung total harga dari data yang ditampilkan (baik semua data atau hasil pencarian)
    $totalHarga = $elektronik->sum('total_harga');

    // Pastikan $totalHarga dikirim ke view bersama $elektronik
    return view("inventaris.elektronik.index", compact('elektronik', 'totalHarga'));
}


    public function create()
    {
        return view("inventaris.elektronik.create");
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'kode_barang' => 'required|unique:elektroniks',
            'nama_barang' => 'required',
            'merk' => 'required',
            'type' => 'required',
            'tgl_peroleh' => 'required',
            'asal_usul' => 'required',
            'cara_peroleh' => 'required',
            'jumlah_brg' => 'required',
            'harga_perunit' => 'required',
            'total_harga' => 'nullable|numeric'
        ]);

        // Proses upload gambar jika ada
        // if ($request->hasFile('gambar_barang')) {
        //     $imageName = time() . '.' . $request->file('gambar_barang')->extension();
        //     $request->file('gambar_barang')->move(public_path('gambar'), $imageName);
        //     $validated['gambar_barang'] = $imageName;
        // }

    // Simpan data ke database dan tangkap hasilnya
    $elektronik = Elektronik::create($validated);

    // simpan riwayat
    ActivityHelper::log('Tambah Barang', 'Elektronik ' . $elektronik->nama_barang . ' berhasil ditambahkan');

        return redirect()->route('elektronik.index')->with('success', 'Data Barang Elektronik berhasil disimpan');
    }

    public function edit($id)
    {
        $elektronik = Elektronik::find($id);
        return view('inventaris.elektronik.edit', compact('elektronik'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'kode_barang' => 'required|unique:elektroniks,kode_barang,' . $id,
            'nama_barang' => 'required',
            'merk' => 'required',
            'type' => 'required',
            'tgl_peroleh' => 'required',
            'asal_usul' => 'required',
            'cara_peroleh' => 'required',
            'jumlah_brg' => 'required',
            'harga_perunit' => 'required',
            'total_harga' => 'nullable|numeric'
        ]);

        // Proses upload gambar jika ada
        // if ($request->hasFile('gambar_barang')) {
        //     $imageName = time() . '.' . $request->file('gambar_barang')->extension();
        //     $request->file('gambar_barang')->move(public_path('gambar'), $imageName);
        //     $validated['gambar_barang'] = $imageName;
        // }

        // Update data ke database
        Elektronik::find($id)->update($validated);

        return redirect()->route('elektronik.index')->with('success', 'Data Barang Elektronik berhasil diupdate');
    }

    public function destroy($id)
    {
        Elektronik::find($id)->delete();
        return redirect()->route('elektronik.index')->with('success', 'Data Barang Elektronik berhasil dihapus');
    }
}
