<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PemusnaanController extends Controller
{
    public function index()
    {
        $pemusnaan = Pemusnaan::with('pemusnaan')->get();
        return response()->json($pemusnaan, Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'jumlah_pemusnaan' => 'required',
            'tanggal_pemusnaan' => 'required',
            'keterangan' => 'required',
            'status' => 'required',
            'barang_rusak_id' => 'required',

        ]);
        Pemusnaan::create($validate);
        $response['success'] = true;
        $response['message'] = 'Pemusnaan Berhasil Disimpan';
        return response()->json($response, Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'jumlah_pemusnaan' => 'required',
            'tanggal_pemusnaan' => 'required',
            'keterangan' => 'required',
            'status' => 'required',
            'barang_rusak_id' => 'required',
        ]);

        $pemusnaan = Pemusnaan::where('id', $id)->update($validate);
        if ($pemusnaan) {
            $response['success'] = true;
            $response['message'] = $request->jumlah_pemusnaan . ' berhasil diperbarui.';
            return response()->json($response, Response::HTTP_OK);
        } else {
            $response['success'] = false;
            $response['message'] = $request->jumlah_pemusnaan . ' Gagal diPerbaharui.';
            return response()->json($response, Response::HTTP_NOT_FOUND);
        }
    }

    public function destroy($id)
    {
        $pemusnaan = Pemusnaan::where('id', $id);
        if (count($pemusnaan->get()) > 0) {
            $barangRusak = Pemusnaan::where('barang_id', $id)->get();
            if (count($barangRusak)) {
                $response['success'] = false;
                $response['message'] = 'Data Fakultas tidak diizinkan dihapus dikarenakan digunakan ditabel prodi.';
                return response()->json($response, Response::HTTP_NOT_FOUND);
            } else {
                $pemusnaan->delete();
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
