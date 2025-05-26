<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\Barang;

class PeminjamanController extends Controller
{
    public function index()
{
    // Menampilkan semua data peminjaman, tanpa filter status
    $peminjaman = Peminjaman::with('barang')->get();

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
            'nama_peminjam' => 'required',
            'barang_id' => 'required|exists:barangs,id',
            'kode_barang' => 'required',
            'jumlah_peminjam' => 'required|integer|min:1',
            'tgl_peminjam' => 'required|date',
        ]);

        $tgl_kembali = Carbon::parse($request->tgl_peminjam)->addYear();

        Peminjaman::create([
            'nama_peminjam' => $request->nama_peminjam,
            'barang_id' => $request->barang_id,
            'kode_barang' => $request->kode_barang,
            'jumlah_peminjam' => $request->jumlah_peminjam,
            'tgl_peminjam' => $request->tgl_peminjam,
            'tgl_kembali' => $tgl_kembali->format('Y-m-d'),
            'status' => 'Menunggu Persetujuan',
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil diajukan!');
    }

    public function edit($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $barang = Barang::all();
        return view('peminjaman.edit', compact('peminjaman', 'barang'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_peminjam' => 'required',
            'jumlah_peminjam' => 'required|integer|min:1',
            'tgl_peminjam' => 'required|date',
            'status' => 'required',
            'barang_id' => 'required|exists:barangs,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update($request->all());

        return redirect()->route('peminjaman.index')->with('success', 'Data peminjaman berhasil diperbarui');
    }

    public function destroy($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $barang = Barang::findOrFail($peminjaman->barang_id);

        // Kembalikan stok hanya jika status bukan disetujui
        if ($peminjaman->status !== 'Disetujui') {
            $barang->jumlah_barang += $peminjaman->jumlah_peminjam;
            $barang->save();
        }

        $peminjaman->delete();

        return redirect()->route('peminjaman.index')->with('success', 'Data peminjaman dihapus.');
    }

    public function setujui($id)
    {
        $peminjaman = Peminjaman::with('barang')->findOrFail($id);

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

        // Buat data pengembalian otomatis jika belum ada
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
