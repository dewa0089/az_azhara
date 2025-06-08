<?php

namespace App\Http\Controllers;

use App\Models\Pengembalian;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use App\Helpers\ActivityHelper;

class PengembalianController extends Controller
{
    public function index()
{
    $user = auth()->user();

    $statusOrder = ['Menunggu Persetujuan', 'Belum Dikembalikan', 'Disetujui'];

    if (in_array($user->role, ['A', 'K', 'W'])) {
        // Untuk admin, kepala sekolah, wakil kepala sekolah
        $pengembalian = Pengembalian::with(['peminjaman.barang'])
            ->orderByRaw("FIELD(status, '" . implode("','", $statusOrder) . "')")
            ->get();
    } else {
        // Untuk user biasa
        $pengembalian = Pengembalian::whereHas('peminjaman', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->with(['peminjaman.barang'])
            ->orderByRaw("FIELD(status, '" . implode("','", $statusOrder) . "')")
            ->get();
    }

    return view('pengembalian.index', compact('pengembalian'));
}



    public function edit($id)
    {
        $pengembalian = Pengembalian::with(['peminjaman.barang'])->findOrFail($id);
        return view('pengembalian.edit', compact('pengembalian'));
    }

   public function update(Request $request, $id)
{
    $validated = $request->validate([
        'jumlah_brg_baik' => 'required|integer|min:0',
        'jumlah_brg_rusak' => 'required|integer|min:0',
        'jumlah_brg_hilang' => 'required|integer|min:0',
        'tgl_pengembalian' => 'required|date',
    ]);

    $pengembalian = Pengembalian::with(['peminjaman.barang'])->findOrFail($id);
    $jumlahDipinjam = $pengembalian->peminjaman->jumlah_peminjam;

    $totalDikembalikan = $validated['jumlah_brg_baik'] + $validated['jumlah_brg_rusak'] + $validated['jumlah_brg_hilang'];

    if ($totalDikembalikan > $jumlahDipinjam) {
        return back()->withErrors([
            'total_pengembalian' => 'Jumlah total pengembalian tidak sesuai dengan jumlah peminjaman yaitu ' . $jumlahDipinjam
        ])->withInput();
    }

    $pengembalian->update([
        'jumlah_brg_baik' => $validated['jumlah_brg_baik'],
        'jumlah_brg_rusak' => $validated['jumlah_brg_rusak'],
        'jumlah_brg_hilang' => $validated['jumlah_brg_hilang'],
        'tgl_pengembalian' => $validated['tgl_pengembalian'],
        'status' => 'Menunggu Persetujuan',
    ]);

    ActivityHelper::log(
        'Pengajuan Pengembalian',
        'Pengembalian untuk barang ' . $pengembalian->peminjaman->barang->nama_barang . ' telah diajukan.'
    );

    return redirect()->route('pengembalian.index')->with('success', 'Pengajuan pengembalian berhasil diajukan.');
}

    public function destroy($id)
    {
        $pengembalian = Pengembalian::with(['peminjaman.barang'])->findOrFail($id);
        $namaBarang = $pengembalian->peminjaman->barang->nama_barang;

        $pengembalian->delete();

        // Log aktivitas
        ActivityHelper::log(
            'Hapus Pengembalian',
            'Data pengembalian barang ' . $namaBarang . ' telah dihapus.'
        );

        return redirect()->route('pengembalian.index')->with('success', 'Data Barang berhasil dihapus');
    }

    public function setujui($id)
    {
        $pengembalian = Pengembalian::with('peminjaman.barang')->findOrFail($id);

        // Update status jadi "Disetujui"
        $pengembalian->status = 'Disetujui';

        // Ambil data barang terkait
        $barang = $pengembalian->peminjaman->barang;

        if ($barang) {
            // Tambahkan jumlah barang baik ke stok
            if ($pengembalian->jumlah_brg_baik > 0) {
                $barang->jumlah_barang += $pengembalian->jumlah_brg_baik;
            }

            // Tambahkan jumlah barang rusak dan hilang ke properti barang
            if ($pengembalian->jumlah_brg_rusak > 0) {
                $barang->jumlah_rusak += $pengembalian->jumlah_brg_rusak;
            }

            if ($pengembalian->jumlah_brg_hilang > 0) {
                $barang->jumlah_hilang += $pengembalian->jumlah_brg_hilang;
            }

            $barang->save();
        }

        $pengembalian->save();

        // Log aktivitas
        ActivityHelper::log(
            'Persetujuan Pengembalian',
            'Pengembalian barang ' . $barang->nama_barang . ' telah disetujui. Stok dan status diperbarui.'
        );

        return redirect()->route('pengembalian.index')->with('success', 'Pengembalian disetujui dan data barang diperbarui.');
    }
}
