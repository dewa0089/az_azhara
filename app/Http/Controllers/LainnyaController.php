<?php

namespace App\Http\Controllers;

use App\Models\Lainnya;
use Illuminate\Http\Request;
use App\Helpers\ActivityHelper;

class LainnyaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        if ($search) {
            $lainnya = Lainnya::where('nama_barang', 'like', "%{$search}%")
                ->orWhere('kode_barang', 'like', "%{$search}%")
                ->orWhere('merk', 'like', "%{$search}%")
                ->orWhere('type', 'like', "%{$search}%")
                ->get();
        } else {
            $lainnya = Lainnya::all();
        }

        $totalHarga = $lainnya->sum('total_harga');

        return view("inventaris.lainnya.index", compact('lainnya', 'totalHarga'));
    }

    public function create()
    {
        return view("inventaris.lainnya.create");
    }

    public function store(Request $request)
    {
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

        $lainnya = Lainnya::create($validated);

        // Simpan riwayat aktivitas
        ActivityHelper::log('Tambah Barang', 'Barang lainnya ' . $lainnya->nama_barang . ' berhasil ditambahkan');

        return redirect()->route('lainnya.index')->with('success', 'Data Barang Lainnya berhasil disimpan');
    }

    public function edit($id)
    {
        $lainnya = Lainnya::find($id);
        return view('inventaris.lainnya.edit', compact('lainnya'));
    }

    public function update(Request $request, $id)
    {
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

        if ($request->hasFile('gambar_barang')) {
            $imageName = time() . '.' . $request->file('gambar_barang')->extension();
            $request->file('gambar_barang')->move(public_path('gambar'), $imageName);
            $validated['gambar_barang'] = $imageName;
        }

        $lainnya = Lainnya::find($id);
        $lainnya->update($validated);

        // Simpan riwayat aktivitas
        ActivityHelper::log('Edit Barang', 'Barang lainnya ' . $lainnya->nama_barang . ' berhasil diupdate');

        return redirect()->route('lainnya.index')->with('success', 'Data Barang Lainnya berhasil diupdate');
    }

    public function destroy($id)
    {
        $lainnya = Lainnya::find($id);
        $nama = $lainnya->nama_barang;
        $lainnya->delete();

        // Simpan riwayat aktivitas
        ActivityHelper::log('Hapus Barang', 'Barang lainnya ' . $nama . ' berhasil dihapus');

        return redirect()->route('lainnya.index')->with('success', 'Data Barang Lainnya berhasil dihapus');
    }
}
