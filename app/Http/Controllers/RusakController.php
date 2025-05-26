<?php

namespace App\Http\Controllers;

use App\Models\Rusak;
use App\Models\Elektronik;
use App\Models\Mobiler;
use App\Models\Lainnya;
use Illuminate\Http\Request;

class RusakController extends Controller
{
    public function index()
    {
        $rusak = Rusak::all();
        return view("rusak.index", compact("rusak"));
    }

    public function create()
    {
        $rusak = Rusak::all();
        $elektronik = Elektronik::all();
        $mobiler = Mobiler::all();
        $lainnya = Lainnya::all();

        return view('rusak.create', compact('rusak', 'elektronik', 'mobiler', 'lainnya'));
    }

    public function store(Request $request)
{
    $request->validate([
        'jenis_brg_rusak' => 'required',
        'jumlah_brg_rusak' => 'required|integer|min:1',
        'gambar_brg_rusak' => 'required|image|mimes:jpeg,png,jpg,gif',
        'tgl_rusak' => 'required|date',
        'keterangan' => 'required|string',
        'elektronik_id' => 'nullable|exists:elektroniks,id',
        'mobiler_id' => 'nullable|exists:mobilers,id',
        'lainnya_id' => 'nullable|exists:lainnyas,id',
    ]);

    $data = $request->all();
    $data['status'] = 'Rusak';

    // Upload gambar
    if ($request->hasFile('gambar_brg_rusak')) {
        $file = $request->file('gambar_brg_rusak');
        $fileName = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('gambar'), $fileName);
        $data['gambar_brg_rusak'] = $fileName;
    }

    // Kurangi jumlah barang dari inventaris sesuai jenis
    $jumlahRusak = (int)$request->jumlah_brg_rusak;

    if ($request->jenis_brg_rusak === 'elektronik' && $request->elektronik_id) {
        $barang = Elektronik::find($request->elektronik_id);
        if ($barang && $barang->jumlah_brg >= $jumlahRusak) {
            $barang->jumlah_brg -= $jumlahRusak;
            $barang->save();
        }
    } elseif ($request->jenis_brg_rusak === 'mobiler' && $request->mobiler_id) {
        $barang = Mobiler::find($request->mobiler_id);
        if ($barang && $barang->jumlah_brg >= $jumlahRusak) {
            $barang->jumlah_brg -= $jumlahRusak;
            $barang->save();
        }
    } elseif ($request->jenis_brg_rusak === 'lainnya' && $request->lainnya_id) {
        $barang = Lainnya::find($request->lainnya_id);
        if ($barang && $barang->jumlah_brg >= $jumlahRusak) {
            $barang->jumlah_brg -= $jumlahRusak;
            $barang->save();
        }
    }

    // Simpan data rusak
    Rusak::create($data);

    return redirect()->route('rusak.index')->with('success', 'Data Barang Rusak berhasil disimpan');
}


    public function edit($id)
    {
        $rusak = Rusak::findOrFail($id);
        $elektronik = Elektronik::all();
        $mobiler = Mobiler::all();
        $lainnya = Lainnya::all();
        return view('rusak.edit', compact('rusak', 'elektronik', 'mobiler', 'lainnya'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jenis_brg_rusak' => 'required',
            'jumlah_brg_rusak' => 'required|integer|min:1',
            'gambar_brg_rusak' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'tgl_rusak' => 'required|date',
            'keterangan' => 'required|string',
            'status' => 'required|string',
            'elektronik_id' => 'nullable|exists:elektroniks,id',
            'mobiler_id' => 'nullable|exists:mobilers,id',
            'lainnya_id' => 'nullable|exists:lainnyas,id',
        ]);

        $rusak = Rusak::findOrFail($id);
        $data = $request->except('gambar_brg_rusak');

        if ($request->hasFile('gambar_brg_rusak')) {
            if ($rusak->gambar_brg_rusak && file_exists(public_path('gambar/' . $rusak->gambar_brg_rusak))) {
                unlink(public_path('gambar/' . $rusak->gambar_brg_rusak));
            }
            $file = $request->file('gambar_brg_rusak');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('gambar'), $fileName);
            $data['gambar_brg_rusak'] = $fileName;
        }

        $rusak->update($data);

        return redirect()->route('rusak.index')->with('success', 'Data Rusak berhasil diperbarui');
    }

    public function destroy($id)
    {
        $rusak = Rusak::findOrFail($id);
        if ($rusak->gambar_brg_rusak && file_exists(public_path('gambar/' . $rusak->gambar_brg_rusak))) {
            unlink(public_path('gambar/' . $rusak->gambar_brg_rusak));
        }
        $rusak->delete();
        return redirect()->route('rusak.index')->with('success', 'Data Rusak berhasil dihapus');
    }
}
