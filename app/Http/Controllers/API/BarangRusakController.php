<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BarangRusakController extends Controller
{
    public function index()
    {
        $barangRusak = BarangRusak::with('barangRusak')->get();
        return response()->json($barangRusak, Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'pengembalian_id' => 'required',
        ]);
        BarangRusak::create($validate);
        $response['success'] = true;
        $response['message'] = 'Barang Rusak Berhasil Disimpan';
        return response()->json($response, Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'pengembalian_id' => 'required',
        ]);

        $barangRusak = BarangRusak::where('id', $id)->update($validate);
        if ($barangRusak) {
            $response['success'] = true;
            $response['message'] = $request->pengembalian_id . ' berhasil diperbarui.';
            return response()->json($response, Response::HTTP_OK);
        } else {
            $response['success'] = false;
            $response['message'] = $request->pengembalian_id . ' Gagal diPerbaharui.';
            return response()->json($response, Response::HTTP_NOT_FOUND);
        }
    }

    public function destroy($id)
    {
        $barangRusak = BarangRusak::where('id', $id);
        if (count($barangRusak->get()) > 0) {
            $barangRusak = BarangRusak::where('barang_id', $id)->get();
            if (count($pengembalian)) {
                $response['success'] = false;
                $response['message'] = 'Data Barang Rusak tidak diizinkan dihapus dikarenakan digunakan ditabel prodi.';
                return response()->json($response, Response::HTTP_NOT_FOUND);
            } else {
                $barangRusak->delete();
                $response['success'] = true;
                $response['message'] = 'Barang Rusak berhasil dihapus.';
                return response()->json($response, Response::HTTP_OK);
            }
        } else {
            $response['success'] = false;
            $response['message'] = 'Barang Rusak tidak ditemukan.';
            return response()->json($response, Response::HTTP_NOT_FOUND);
        }
    }
}
