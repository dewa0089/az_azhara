<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\RusakController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\PemusnaanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('barang', BarangController::class);
    Route::resource('peminjaman', PeminjamanController::class);

    // ✅ Tambahkan route ini sebelum resource('pengembalian') agar tidak tertimpa
    Route::get('/pengembalian/create/{id}', [PengembalianController::class, 'create'])->name('pengembalian.create.id');

    Route::resource('pengembalian', PengembalianController::class);
    Route::resource('rusak', RusakController::class);
    Route::resource('pemusnaan', PemusnaanController::class);
    Route::resource('user', UserController::class);
    Route::resource('history', HistoryController::class);
    Route::resource('laporan', LaporanController::class);

    // ✅ Route untuk aksi persetujuan peminjaman
    Route::patch('/peminjaman/{id}/setujui', [PeminjamanController::class, 'setujui'])->name('peminjaman.setujui');
    Route::patch('/peminjaman/{id}/tolak', [PeminjamanController::class, 'tolak'])->name('peminjaman.tolak');
    Route::patch('/peminjaman/{id}/batalkan', [PeminjamanController::class, 'batalkan'])->name('peminjaman.batalkan');
});

Auth::routes();

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['checkRole:A,U'])
    ->name('dashboard');
