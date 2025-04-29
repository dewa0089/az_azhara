<?php

namespace App\Http\Controllers;


use App\Models\Pemusnaan;
use Illuminate\Http\Request;

class PemusnaanController extends Controller
{
     public function index()
    {
        $pemusnaan = Pemusnaan::all();
        return view("pemusnaan.index")->with("pemusnaan", $pemusnaan);
    }

    public function create()
    {
        return view("pemusnaan.create");
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'jumlah_pemusnaan' => 'required',
            'tanggal_pemusnaan' => 'required',
            'keterangan' => 'required',
            'status' => 'required',
            'barang_rusak_id' => 'required',
        ]);

        // Simpan data ke database
        Pemusnaan::create($validated);

        return redirect()->route('pemusnaan.index')->with('success', 'Data Barang berhasil disimpan');
    }

    public function edit($id)
    {
        $pemusnaan = Pemusnaan::find($id);
        return view('pemusnaan.edit', compact('pemusnaan'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'jumlah_pemusnaan' => 'required|integer',
            'tanggal_pemusnaan' => 'required|date',
            'keterangan' => 'required',
            'status' => 'required',
            'barang_rusak_id' => 'required',
        ]);

        // Update data ke database
        Pemusnaan::find($id)->update($validated);

        return redirect()->route('pemusnaan.index')->with('success', 'Data Barang berhasil diupdate');
    }

    public function destroy($id)
    {
        Pemusnaan::find($id)->delete();
        return redirect()->route('pemusnaan.index')->with('success', 'Data Barang berhasil dihapus');
    }
}
