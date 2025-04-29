<?php

namespace App\Http\Controllers\API;

use App\Models\Barang;
use App\Models\Peminjaman;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BarangController extends Controller
{
    public function index()
    {
        $barang = Barang::all();
        return response()->json($barang, Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'kode_barang' => 'required|unique:barangs',
            'nama_barang' => 'required',
            'jumlah_barang' => 'required',
            'harga_barang' => 'required',
            'gambar_barang' => 'nullable|image',
            'tanggal_beli_barang' => 'required',
            'keterangan' => 'required',
        ]);
        Barang::create($validate);
        $response['success'] = true;
        $response['message'] = 'Barang Berhasil Disimpan';
        return response()->json($response, Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'kode_barang' => 'required|unique:barangs',
            'nama_barang' => 'required',
            'jumlah_barang' => 'required',
            'harga_barang' => 'required',
            'gambar_barang' => 'nullable|image',
            'tanggal_beli_barang' => 'required',
            'keterangan' => 'required',
        ]);

        $barang = Barang::where('id', $id)->update($validate);
        if ($barang) {
            $response['success'] = true;
            $response['message'] = 'Barang ' . $request->kode_barang . ' berhasil diperbarui.';
            return response()->json($response, Response::HTTP_OK);
        } else {
            $response['success'] = false;
            $response['message'] = $request->kode_barang . ' Gagal diPerbaharui.';
            return response()->json($response, Response::HTTP_NOT_FOUND);
        }
    }

    public function destroy($id)
    {
        $barang = Barang::where('id', $id);
        if (count($barang->get()) > 0) {
            $peminjaman = Peminjaman::where('barang_id', $id)->get();
            if (count($peminjaman)) {
                $response['success'] = false;
                $response['message'] = 'Data Barang tidak diizinkan dihapus dikarenakan digunakan ditabel prodi.';
                return response()->json($response, Response::HTTP_NOT_FOUND);
            } else {
                $barang->delete();
                $response['success'] = true;
                $response['message'] = 'Barang berhasil dihapus.';
                return response()->json($response, Response::HTTP_OK);
            }
        } else {
            $response['success'] = false;
            $response['message'] = 'Barang tidak ditemukan.';
            return response()->json($response, Response::HTTP_NOT_FOUND);
        }
    }
}
