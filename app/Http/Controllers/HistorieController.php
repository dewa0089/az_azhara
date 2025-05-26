<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\Request;

class HistorieController extends Controller
{
    public function index()
    {
        // Ambil semua history dengan relasi item (polymorphic)
        $histories = History::with('item')->latest()->get();

        return view('history.index', compact('histories'));
    }
}

