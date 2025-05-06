<?php

namespace App\Http\Controllers;

use App\Models\Rusak;
use Illuminate\Http\Request;

class RusakController extends Controller
{
    public function index()
    {
        $rusak = Rusak::all();
        return view("rusak.index")->with("rusak", $rusak);
    }

    public function create()
    {
        return view("rusak.create");
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'pengembalian_id' => 'required',
        ]);

        // Simpan data ke database
        Rusak::create($validated);

        return redirect()->route('rusak.index')->with('success', 'Data Barang berhasil disimpan');
    }

    public function edit($id)
    {
        $rusak = Rusak::find($id);
        return view('rusak.edit', compact('rusak'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'pengembalian_id' => 'required',
        ]);

        // Update data ke database
        Rusak::find($id)->update($validated);

        return redirect()->route('rusak.index')->with('success', 'Data Barang berhasil diupdate');
    }

    public function destroy($id)
    {
        Rusak::find($id)->delete();
        return redirect()->route('rusak.index')->with('success', 'Data Barang berhasil dihapus');
    }
}
