<?php

namespace App\Http\Controllers;

use App\Models\BarangRusak;
use Illuminate\Http\Request;

class BarangRusakController extends Controller
{
    public function index()
    {
        $barangRusak = BarangRusak::all();
        return view("barangRusak.index")->with("barangRusak", $barangRusak);
    }

    public function create()
    {
        return view("barangRusak.create");
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'pengembalian_id' => 'required',
        ]);

        // Simpan data ke database
        BarangRusak::create($validated);

        return redirect()->route('barangRusak.index')->with('success', 'Data Barang berhasil disimpan');
    }

    public function edit($id)
    {
        $barangRusak = BarangRusak::find($id);
        return view('barangRusak.edit', compact('barangRusak'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'pengembalian_id' => 'required',
        ]);

        // Update data ke database
        BarangRusak::find($id)->update($validated);

        return redirect()->route('barangRusak.index')->with('success', 'Data Barang berhasil diupdate');
    }

    public function destroy($id)
    {
        BarangRusak::find($id)->delete();
        return redirect()->route('barangRusak.index')->with('success', 'Data Barang berhasil dihapus');
    }
}
