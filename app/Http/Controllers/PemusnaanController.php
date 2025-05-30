<?php

namespace App\Http\Controllers;

use App\Models\Pemusnaan;
use App\Models\Rusak;
use Illuminate\Http\Request;

class PemusnaanController extends Controller
{
    public function index()
    {
        $pemusnaan = Pemusnaan::with(['rusak.elektronik', 'rusak.mobiler', 'rusak.lainnya'])->get();
        return view('pemusnaan.index', compact('pemusnaan'));
    }

    public function create(Request $request)
    {
        $rusak_id = $request->query('rusak_id');
        $rusak = Rusak::findOrFail($rusak_id);
        return view('pemusnaan.create', compact('rusak'));
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'rusak_id' => 'required|exists:rusaks,id',
        'tanggal_pemusnaan' => 'required|date',
        'jumlah_pemusnaan' => 'required|integer|min:1',
        'gambar_pemusnaan' => 'nullable|image|mimes:jpg,jpeg,png',
        'keterangan' => 'required|string'
    ]);

    $rusak = Rusak::findOrFail($request->rusak_id);

    // ✅ Validasi tambahan agar jumlah tidak bisa dimanipulasi
    if ((int) $request->jumlah_pemusnaan !== $rusak->jumlah_brg_rusak) {
        return back()->withErrors(['jumlah_pemusnaan' => 'Jumlah pemusnaan harus sama dengan jumlah barang rusak.']);
    }

    if ($request->hasFile('gambar_pemusnaan')) {
        $imageName = time() . '.' . $request->file('gambar_pemusnaan')->extension();
        $request->file('gambar_pemusnaan')->move(public_path('gambar'), $imageName);
    } else {
        $imageName = null;
    }

    // Simpan data ke pemusnaan
    Pemusnaan::create([
        'rusak_id' => $request->rusak_id,
        'tanggal_pemusnaan' => $request->tanggal_pemusnaan,
        'jumlah_pemusnaan' => $request->jumlah_pemusnaan,
        'gambar_pemusnaan' => $imageName,
        'keterangan' => $request->keterangan,
    ]);

    // Ubah status barang rusak menjadi 'Dimusnahkan'
    $rusak->status = 'Dimusnahkan';
    $rusak->save();

    return redirect()->route('pemusnaan.index')->with('success', 'Pemusnaan berhasil dan status barang rusak diperbarui.');
}



    public function edit($id)
    {
        $pemusnaan = Pemusnaan::findOrFail($id);
        return view('pemusnaan.edit', compact('pemusnaan'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'rusak_id' => 'required|exists:rusaks,id',
            'tanggal_pemusnaan' => 'required|date',
            'jumlah_pemusnaan' => 'required|integer',
            'gambar_pemusnaan' => 'nullable|image|mimes:jpg,jpeg,png',
            'keterangan' => 'required|string'
        ]);

        $pemusnaan = Pemusnaan::findOrFail($id);

        // Jika ada gambar baru di-upload
        if ($request->hasFile('gambar_pemusnaan')) {
            $imageName = time() . '.' . $request->file('gambar_pemusnaan')->extension();
            $request->file('gambar_pemusnaan')->move(public_path('gambar'), $imageName);
            $validated['gambar_pemusnaan'] = $imageName;
        }

        $pemusnaan->update($validated);

        return redirect()->route('pemusnaan.index')->with('success', 'Data pemusnaan berhasil diupdate.');
    }

    public function destroy($id)
    {
        $pemusnaan = Pemusnaan::findOrFail($id);
        $pemusnaan->delete();
        return redirect()->route('pemusnaan.index')->with('success', 'Data pemusnaan berhasil dihapus.');
    }

}
