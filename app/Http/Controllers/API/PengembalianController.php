<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    public function index()
    {
        $pengembalian = Pengembalian::with('pengembalian')->get();
        return response()->json($pengembalian, Response::HTTP_OK);
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
        Pengembalian::create($validate);
        $response['success'] = true;
        $response['message'] = 'Pengembalian Berhasil Disimpan';
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

        $pengembalian = Pengembalian::where('id', $id)->update($validate);
        if ($pengembalian) {
            $response['success'] = true;
            $response['message'] = $request->nama_peminjam . ' berhasil diperbarui.';
            return response()->json($response, Response::HTTP_OK);
        } else {
            $response['success'] = false;
            $response['message'] = $request->nama_peminjam . ' Gagal diPerbaharui.';
            return response()->json($response, Response::HTTP_NOT_FOUND);
        }
    }

    public function destroy($id)
    {
        $pengembalian = Pengembalian::where('id', $id);
        if (count($pengembalian->get()) > 0) {
            $peminjaman = Pengembalian::where('barang_id', $id)->get();
            if (count($peminjaman)) {
                $response['success'] = false;
                $response['message'] = 'Data Fakultas tidak diizinkan dihapus dikarenakan digunakan ditabel prodi.';
                return response()->json($response, Response::HTTP_NOT_FOUND);
            } else {
                $pengembalian->delete();
                $response['success'] = true;
                $response['message'] = 'Fakultas berhasil dihapus.';
                return response()->json($response, Response::HTTP_OK);
            }
        } else {
            $response['success'] = false;
            $response['message'] = 'Fakultas tidak ditemukan.';
            return response()->json($response, Response::HTTP_NOT_FOUND);
        }
    }
}
