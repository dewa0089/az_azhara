<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\Barang;


class PeminjamanController extends Controller
{


    // public function index()
    // {
    //     $peminjaman = Peminjaman::all();
    //     return view("peminjaman.index")->with("peminjaman", $peminjaman);
    // }

    public function index()
    {
        // Mengambil hanya data peminjaman yang statusnya BUKAN 'Disetujui'
        $peminjaman = Peminjaman::with('barang')
                        ->where('status', '!=', 'Disetujui')
                        ->get();
    
        return view("peminjaman.index", compact("peminjaman"));
    }
    public function create()
    {
        $barang = Barang::all();
        return view('peminjaman.create', compact('barang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_peminjam' => 'required|string|max:255',
            'barang_id' => 'required|exists:barangs,id',
            'jumlah_peminjam' => 'required|integer|min:1',
            'tgl_peminjam' => 'required|date',
        ]);

        $barang = Barang::findOrFail($request->barang_id);

        if ($request->jumlah_peminjam > $barang->jumlah_barang) {
            return back()->withErrors(['jumlah_peminjam' => 'Jumlah melebihi stok yang tersedia.']);
        }

        Peminjaman::create([
            'nama_peminjam' => $request->nama_peminjam,
            'barang_id' => $request->barang_id,
            'jumlah_peminjam' => $request->jumlah_peminjam,
            'tgl_peminjam' => $request->tgl_peminjam,
            'status' => 'Menunggu Persetujuan',
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil disimpan.');
    }

    public function edit($id)
    {
        $peminjaman = Peminjaman::find($id);
        return view('peminjaman.edit', compact('peminjaman'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_peminjam' => 'required',
            'jumlah_peminjam' => 'required|integer',
            'tgl_peminjam' => 'required|date',
            'status' => 'required',
            'barang_id' => 'required',
            'user_id' => 'required',
        ]);

        Peminjaman::find($id)->update($validated);

        return redirect()->route('peminjaman.index')->with('success', 'Data Barang berhasil diupdate');
    }

    public function destroy($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $barang = Barang::findOrFail($peminjaman->barang_id);

        $barang->jumlah_barang += $peminjaman->jumlah_peminjam;
        $barang->save();

        $peminjaman->delete();

        return redirect()->route('peminjaman.index')->with('success', 'Data peminjaman dihapus dan stok dikembalikan.');
    }

    public function setujui($id)
{
    $peminjaman = Peminjaman::findOrFail($id);

    if ($peminjaman->status === 'Disetujui') {
        return redirect()->back()->with('warning', 'Peminjaman sudah disetujui sebelumnya.');
    }

    $barang = $peminjaman->barang;

    if ($barang->jumlah_barang < $peminjaman->jumlah_peminjam) {
        return redirect()->back()->withErrors(['stok' => 'Stok barang tidak mencukupi untuk menyetujui.']);
    }

    $barang->jumlah_barang -= $peminjaman->jumlah_peminjam;
    $barang->save();

    $peminjaman->status = 'Disetujui';
    $peminjaman->save();

    // Cek apakah sudah ada pengembalian
    if (!$peminjaman->pengembalian) {
        Pengembalian::create([
            'id' => Str::uuid(),
            'peminjaman_id' => $peminjaman->id,
            'jumlah_pengembalian' => 0,
            'jumlah_barang_rusak' => 0,
            'jumlah_barang_hilang' => 0,
            'tanggal_pengembalian' => null,
            'status' => 'Belum Dikembalikan',
        ]);
    }

    return redirect()->back()->with('success', 'Peminjaman disetujui dan data pengembalian dibuat.');
}

    public function tolak($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->status = 'Ditolak';
        $peminjaman->save();
        return redirect()->back()->with('success', 'Peminjaman ditolak.');
    }

    public function batalkan($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->status = 'Dibatalkan';
        $peminjaman->save();
        return redirect()->back()->with('success', 'Peminjaman dibatalkan.');
    }
}
