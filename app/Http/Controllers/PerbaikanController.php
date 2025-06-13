<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Perbaikan;
use App\Models\Rusak;
use Illuminate\Support\Str;
use App\Helpers\ActivityHelper;

class PerbaikanController extends Controller
{
    public function index()
    {
        $perbaikan = Perbaikan::with(['rusak.elektronik', 'rusak.mobiler', 'rusak.lainnya'])
            ->orderBy('tanggal_perbaikan', 'desc')
            ->get();

        return view('perbaikan.index', compact('perbaikan'));
    }

    public function create(Request $request)
    {
        $rusak_id = $request->query('rusak_id');
        $rusak = Rusak::findOrFail($rusak_id);

        return view('perbaikan.create', compact('rusak'));
    }

  public function store(Request $request)
{
    $validated = $request->validate([
        'rusak_id' => 'required|exists:rusaks,id',
    ]);

    $rusak = Rusak::findOrFail($request->rusak_id);

    // Ubah status jadi "Dalam Perbaikan"
    $rusak->status = 'Dalam Perbaikan';
    $rusak->save();

    ActivityHelper::log('Status Perbaikan', 'Barang rusak ID ' . $rusak->id . ' statusnya diubah menjadi Dalam Perbaikan');

    return redirect()->route('rusak.index')->with('success', 'Status barang diubah menjadi Dalam Perbaikan. Silakan tekan tombol "Selesai" jika perbaikan telah selesai.');
}




    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'rusak_id' => 'required|exists:rusaks,id',
            'tanggal_perbaikan' => 'required|date',
            'biaya_perbaikan' => 'required|integer', // ⚠️ ubah ke 'integer' jika memang itu biaya dalam rupiah
            'jumlah_perbaikan' => 'required|integer|min:1',
            'keterangan' => 'nullable|string',
            'status' => 'nullable|string'
        ]);

        $perbaikan = Perbaikan::findOrFail($id);
        $perbaikan->update($validated);

        ActivityHelper::log('Update Perbaikan', 'Data Perbaikan ID ' . $perbaikan->id . ' berhasil diperbarui');

        return redirect()->route('perbaikan.index')->with('success', 'Data perbaikan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $perbaikan = Perbaikan::findOrFail($id);
        $perbaikanId = $perbaikan->id;
        $perbaikan->delete();

        ActivityHelper::log('Hapus Perbaikan', 'Data Perbaikan ID ' . $perbaikanId . ' berhasil dihapus');

        return redirect()->route('perbaikan.index')->with('success', 'Data perbaikan berhasil dihapus.');
    }


   public function selesaikanPerbaikan($rusak_id)
{
    $rusak = Rusak::findOrFail($rusak_id);

    if ($rusak->status !== 'Dalam Perbaikan') {
        return redirect()->back()->withErrors(['msg' => 'Barang ini belum berstatus Dalam Perbaikan.']);
    }

    return view('perbaikan.create', compact('rusak'));
}

public function selesaikanPerbaikanStore(Request $request)
{
    $validated = $request->validate([
        'rusak_id' => 'required|exists:rusaks,id',
        'tanggal_perbaikan' => 'required|date',
        'biaya_perbaikan' => 'required|integer',
        'jumlah_perbaikan' => 'required|integer|min:1',
        'keterangan' => 'nullable|string'
    ]);

    $rusak = Rusak::findOrFail($validated['rusak_id']);

    // Simpan ke tabel perbaikan
    Perbaikan::create([
        'id' => Str::uuid(),
        'rusak_id' => $rusak->id,
        'tanggal_perbaikan' => $validated['tanggal_perbaikan'],
        'biaya_perbaikan' => $validated['biaya_perbaikan'],
        'jumlah_perbaikan' => $validated['jumlah_perbaikan'],
        'keterangan' => $validated['keterangan'] ?? '',
        'status' => 'Selesai'
    ]);

    // Update status barang rusak
    $rusak->status = 'Selesai Diperbaiki';
    $rusak->save();

    ActivityHelper::log('Selesaikan Perbaikan', 'Barang rusak ID ' . $rusak->id . ' diselesaikan dan data dimasukkan ke perbaikan');

    return redirect()->route('perbaikan.index')->with('success', 'Data perbaikan berhasil disimpan.');
}




}
