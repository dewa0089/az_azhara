<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;
use App\Helpers\ActivityHelper;

class LaporanController extends Controller
{
    public function index()
    {
        return view('laporan.index'); // pastikan ada file view-nya
    }
}
