<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjaman = Peminjaman::all();
        return response()->json($peminjaman, Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'nama_peminjam' => 'required',
            'jumlah_peminjam' => 'required',
            'tanggal_peminjam' => 'required',
            'status' => 'required',
            'barang_id' => 'required',
        ]);
        Peminjaman::create($validate);
        $response['success'] = true;
        $response['message'] = 'Peminjaman Berhasil Disimpan';
        return response()->json($response, Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'nama_peminjam' => 'required',
            'jumlah_peminjam' => 'required',
            'tanggal_peminjam' => 'required',
            'status' => 'required',
            'barang_id' => 'required',
        ]);

        $peminjaman = Peminjaman::where('id', $id)->update($validate);
        if ($peminjaman) {
            $response['success'] = true;
            $response['message'] = 'Peminjaman ' . $request->nama_peminjam . ' berhasil diperbarui.';
            return response()->json($response, Response::HTTP_OK);
        } else {
            $response['success'] = false;
            $response['message'] = $request->nama_peminjam . ' Gagal diPerbaharui.';
            return response()->json($response, Response::HTTP_NOT_FOUND);
        }
    }

    public function destroy($id)
    {
        $peminjaman = Peminjaman::where('id', $id);
        if (count($peminjaman->get()) > 0) {
            $pengembalian = Pengembalian::where('peminjaman_id', $id)->get();
            if (count($pengembalian)) {
                $response['success'] = false;
                $response['message'] = 'Data Peminjaman tidak diizinkan dihapus dikarenakan digunakan ditabel prodi.';
                return response()->json($response, Response::HTTP_NOT_FOUND);
            } else {
                $peminjaman->delete();
                $response['success'] = true;
                $response['message'] = 'Peminjaman berhasil dihapus.';
                return response()->json($response, Response::HTTP_OK);
            }
        } else {
            $response['success'] = false;
            $response['message'] = 'Peminjaman tidak ditemukan.';
            return response()->json($response, Response::HTTP_NOT_FOUND);
        }
    }
}
