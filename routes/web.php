<?php

use Illuminate\Support\Facades\Route;

// Import semua controller yang dibutuhkan
use App\Http\Controllers\BarangController;
use App\Http\Controllers\RusakController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\PemusnaanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ElektronikController;
use App\Http\Controllers\MobilerController;
use App\Http\Controllers\LainnyaController;

// Route halaman login awal (guest)
Route::get('/', function () {
    return view('auth.login');
});

// Group route yang harus login (middleware auth)
Route::middleware(['auth'])->group(function () {

    // Resource controller standar
    Route::resource('barang', BarangController::class);
    Route::resource('peminjaman', PeminjamanController::class);
    Route::resource('rusak', RusakController::class);
    Route::resource('pemusnaan', PemusnaanController::class);
    Route::resource('user', UserController::class);
    Route::resource('history', HistoryController::class);
    Route::resource('laporan', LaporanController::class);
    Route::resource('elektronik', ElektronikController::class);
    Route::resource('lainnya', LainnyaController::class);
    Route::resource('mobiler', MobilerController::class);

    // **PengembalianController: khusus route create dengan parameter id**
    // Harus didefinisikan dulu agar tidak tertimpa oleh resource route
    Route::get('/pengembalian/create/{id}', [PengembalianController::class, 'create'])->name('pengembalian.create.id');

    // Resource controller untuk pengembalian
    Route::resource('pengembalian', PengembalianController::class)->except(['create']);

    // Route khusus untuk aksi setujui pengembalian, method PUT/PATCH
    Route::put('/pengembalian/setujui/{id}', [PengembalianController::class, 'setujui'])->name('pengembalian.setujui');

    // Route khusus aksi persetujuan peminjaman
    Route::patch('/peminjaman/{id}/setujui', [PeminjamanController::class, 'setujui'])->name('peminjaman.setujui');
    Route::patch('/peminjaman/{id}/tolak', [PeminjamanController::class, 'tolak'])->name('peminjaman.tolak');
    Route::patch('/peminjaman/{id}/batalkan', [PeminjamanController::class, 'batalkan'])->name('peminjaman.batalkan');


    Route::put('/rusak/{id}/ajukan-pemusnahan', [RusakController::class, 'ajukanPemusnahan'])->name('rusak.ajukanPemusnahan');

    Route::put('/pemusnaan/{id}/laksanakan', [PemusnaanController::class, 'laksanakan'])->name('pemusnaan.laksanakan');

    // Untuk tampilkan form pemusnahan
Route::get('/pemusnaan/create', [PemusnaanController::class, 'create'])->name('pemusnaan.create');

// Untuk menyimpan data pemusnahan
Route::post('/pemusnaan/store', [PemusnaanController::class, 'store'])->name('pemusnaan.store');



});

// Auth routes (login, register, etc)
Auth::routes();

// Dashboard route, hanya bisa diakses oleh role tertentu
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['checkRole:A,U'])
    ->name('dashboard');
