<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;
use App\Helpers\ActivityHelper;
use App\Models\Elektronik;
use App\Models\Mobiler;
use App\Models\Lainnya;
use App\Models\Barang;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\Rusak;
use App\Models\Pemusnaan;

class LaporanController extends Controller
{
    public function index()
    {
        return view('laporan.index'); // pastikan ada file view-nya
    }
    
    public function cetakElektronik()
    {
        $elektronikCetak = Elektronik::all();
        $totalHarga = $elektronikCetak->sum('total_harga');

        // Log aktivitas
        ActivityHelper::log('Cetak Laporan', 'Laporan elektronik berhasil dicetak');

        return view("laporan.elektronik", [
            'elektronik' => $elektronikCetak,
            'totalHarga' => $totalHarga
        ]);
    }

    public function cetakMobiler()
    {
        $mobilerCetak = Mobiler::all();
        $totalHarga = $mobilerCetak->sum('total_harga');

        // Log aktivitas
        ActivityHelper::log('Cetak Laporan', 'Laporan mobiler berhasil dicetak');

        return view("laporan.mobiler", [
            'mobiler' => $mobilerCetak,
            'totalHarga' => $totalHarga
        ]);
    }

    public function cetakLainnya()
    {
        $lainnyaCetak = Lainnya::all();
        $totalHarga = $lainnyaCetak->sum('total_harga');

        // Log aktivitas
        ActivityHelper::log('Cetak Laporan', 'Laporan lainnya berhasil dicetak');

        return view("laporan.lainnya", [
            'lainnya' => $lainnyaCetak,
            'totalHarga' => $totalHarga
        ]);
    }

    public function cetakBarangKecil()
    {
        $barangCetak = Barang::all();
        $totalHarga = $barangCetak->sum('total_harga');

        // Log aktivitas
        ActivityHelper::log('Cetak Laporan', 'Laporan barang kecil berhasil dicetak');

        return view("laporan.barangKecil", [
            'barang' => $barangCetak,
            'totalHarga' => $totalHarga
        ]);
    }

    public function cetakPeminjaman()
    {
        $peminjamanCetak = Peminjaman::all();

        // Log aktivitas
        ActivityHelper::log('Cetak Laporan', 'Laporan peminjaman berhasil dicetak');

        return view("laporan.peminjaman", [
            'peminjaman' => $peminjamanCetak,
        ]);
    }

    public function cetakPengembalian()
    {
        $pengembalianCetak = Pengembalian::all();

        // Log aktivitas
        ActivityHelper::log('Cetak Laporan', 'Laporan pengembalian berhasil dicetak');

        return view("laporan.pengembalian", [
            'pengembalian' => $pengembalianCetak,
        ]);
    }

    public function cetakPemusnaan()
    {
        $pemusnaanCetak = Pemusnaan::all();
        $totalHarga = $pemusnaanCetak->sum('total_harga');

        // Log aktivitas
        ActivityHelper::log('Cetak Laporan', 'Laporan pemusnaan berhasil dicetak');

        return view("laporan.pemusnaan", [
            'pemusnaan' => $pemusnaanCetak,
            'totalHarga' => $totalHarga
        ]);
    }

    public function cetakBarangRusak()
    {
        $barangRusakCetak = Rusak::all();

        // Log aktivitas
        ActivityHelper::log('Cetak Laporan', 'Laporan barang rusak berhasil dicetak');

        return view("laporan.rusak", [
            'rusak' => $barangRusakCetak,
        ]);
    }
}
