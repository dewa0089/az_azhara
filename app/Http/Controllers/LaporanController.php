<?php

namespace App\Http\Controllers;

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
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index()
    {
        return view('laporan.index');
    }

    private function applyFilter($query, $request)
    {
        $now = Carbon::now();

        switch ($request->filter) {
            case 'bulan':
                $query->whereYear('created_at', $now->year)
                      ->whereMonth('created_at', $now->month);
                break;
            case 'tahun':
                $query->whereYear('created_at', $now->year);
                break;
            case 'semua':
            default:
                // Tidak difilter
                break;
        }

        return $query;
    }

    public function cetakElektronik(Request $request)
    {
        $query = Elektronik::query();
        $elektronikCetak = $this->applyFilter($query, $request)->orderBy('created_at', 'desc')->get();
        $totalHarga = $elektronikCetak->sum('total_harga');

        ActivityHelper::log('Cetak Laporan', 'Laporan Inventaris Barang Besar Elektronik berhasil dicetak');

        return view("laporan.elektronik", compact('elektronikCetak', 'totalHarga'))->with('elektronik', $elektronikCetak);
    }

    public function cetakMobiler(Request $request)
    {
        $query = Mobiler::query();
        $mobilerCetak = $this->applyFilter($query, $request)->orderBy('created_at', 'desc')->get();
        $totalHarga = $mobilerCetak->sum('total_harga');

        ActivityHelper::log('Cetak Laporan', 'Laporan Inventaris Barang Mobiler berhasil dicetak');

        return view("laporan.mobiler", compact('mobilerCetak', 'totalHarga'))->with('mobiler', $mobilerCetak);
    }

    public function cetakLainnya(Request $request)
    {
        $query = Lainnya::query();
        $lainnyaCetak = $this->applyFilter($query, $request)->orderBy('created_at', 'desc')->get();
        $totalHarga = $lainnyaCetak->sum('total_harga');

        ActivityHelper::log('Cetak Laporan', 'Laporan Inventaris Barang Lainnya berhasil dicetak');

        return view("laporan.lainnya", compact('lainnyaCetak', 'totalHarga'))->with('lainnya', $lainnyaCetak);
    }

    public function cetakBarangKecil(Request $request)
    {
        $query = Barang::query();
        $barangCetak = $this->applyFilter($query, $request)->orderBy('created_at', 'desc')->get();
        $totalHarga = $barangCetak->sum('total_harga');

        ActivityHelper::log('Cetak Laporan', 'Laporan Inventaris Barang Kecil berhasil dicetak');

        return view("laporan.barangKecil", compact('barangCetak', 'totalHarga'))->with('barang', $barangCetak);
    }

    public function cetakPeminjaman(Request $request)
    {
        $query = Peminjaman::query();
        $peminjamanCetak = $this->applyFilter($query, $request)->orderBy('created_at', 'desc')->get();

        ActivityHelper::log('Cetak Laporan', 'Laporan Peminjaman Inventaris Barang Kecil berhasil dicetak');

        return view("laporan.peminjaman", compact('peminjamanCetak'))->with('peminjaman', $peminjamanCetak);
    }

    public function cetakPengembalian(Request $request)
    {
        $query = Pengembalian::query();
        $pengembalianCetak = $this->applyFilter($query, $request)->orderBy('created_at', 'desc')->get();

        ActivityHelper::log('Cetak Laporan', 'Laporan Pengembalian Inventaris Barang Kecil berhasil dicetak');

        return view("laporan.pengembalian", compact('pengembalianCetak'))->with('pengembalian', $pengembalianCetak);
    }

    public function cetakPemusnaan(Request $request)
    {
        $query = Pemusnaan::query();
        $pemusnaanCetak = $this->applyFilter($query, $request)->orderBy('created_at', 'desc')->get();
        $totalHarga = $pemusnaanCetak->sum('total_harga');

        ActivityHelper::log('Cetak Laporan', 'Laporan Pemusnaan Inventaris Barang Besar berhasil dicetak');

        return view("laporan.pemusnaan", compact('pemusnaanCetak', 'totalHarga'))->with('pemusnaan', $pemusnaanCetak);
    }

    public function cetakBarangRusak(Request $request)
    {
        $query = Rusak::query();
        $barangRusakCetak = $this->applyFilter($query, $request)->orderBy('created_at', 'desc')->get();

        ActivityHelper::log('Cetak Laporan', 'Laporan Inventaris Barang Besar Rusak berhasil dicetak');

        return view("laporan.rusak", compact('barangRusakCetak'))->with('rusak', $barangRusakCetak);
    }
}
