<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    BarangController,
    RusakController,
    PeminjamanController,
    PengembalianController,
    PemusnaanController,
    UserController,
    HistorieController,
    LaporanController,
    DashboardController,
    ElektronikController,
    MobilerController,
    LainnyaController
};
use App\Http\Controllers\Auth\ResetPasswordController;

// Halaman login awal
Route::get('/', fn() => view('auth.login'));

// Auth bawaan Laravel
Auth::routes();

// 🔐 Reset Password Custom (Verifikasi Kode)
Route::get('password/forgot', fn() => view('auth.passwords.email'))->name('password.request');

Route::post('password/email', [ResetPasswordController::class, 'sendResetCode'])->name('password.email');
Route::post('password/resend-code', [ResetPasswordController::class, 'sendResetCode'])->name('password.resend-code');

Route::get('password/verify-code', [ResetPasswordController::class, 'showVerifyCodeForm'])->name('password.verify-code.form');
Route::post('password/verify-code', [ResetPasswordController::class, 'verifyCode'])->name('password.verify-code');

Route::get('password/reset', [ResetPasswordController::class, 'showResetForm'])->name('password.reset.form');
Route::post('password/reset', [ResetPasswordController::class, 'resetPassword'])->name('password.reset');


// 📊 Dashboard - Hanya untuk user login (semua role)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'checkRole:A,U,K,W'])
    ->name('dashboard');

// Semua route di bawah hanya untuk user yang sudah login
Route::middleware(['auth'])->group(function () {

    // 👤 Admin, Kepala Sekolah, Wakil
    Route::middleware('checkRole:A,K,W')->group(function () {
        Route::resource('user', UserController::class);
        Route::resource('laporan', LaporanController::class);
        Route::resource('elektronik', ElektronikController::class);
        Route::resource('mobiler', MobilerController::class);
        Route::resource('lainnya', LainnyaController::class);
    });

    // 📦 Admin & User biasa (Peminjaman/Pengembalian)
    Route::middleware('checkRole:A,U')->group(function () {
        Route::resource('barang', BarangController::class);
        Route::resource('peminjaman', PeminjamanController::class);
        Route::resource('pengembalian', PengembalianController::class)->except(['create']);
        Route::get('/pengembalian/create/{id}', [PengembalianController::class, 'create'])->name('pengembalian.create.id');
    });

    // ✅ Otorisasi Peminjaman/Pengembalian oleh Kepala/Wakil/Admin
    Route::middleware('checkRole:A,K,W')->group(function () {
        Route::patch('/peminjaman/{id}/setujui', [PeminjamanController::class, 'setujui'])->name('peminjaman.setujui');
        Route::patch('/peminjaman/{id}/tolak', [PeminjamanController::class, 'tolak'])->name('peminjaman.tolak');
        Route::put('/pengembalian/setujui/{id}', [PengembalianController::class, 'setujui'])->name('pengembalian.setujui');
    });

    // ⚠️ Barang Rusak & Pemusnahan
    Route::middleware('checkRole:A,K,W')->group(function () {
        Route::resource('rusak', RusakController::class);
        Route::put('/rusak/{id}/ajukan-pemusnahan', [RusakController::class, 'ajukanPemusnahan'])->name('rusak.ajukanPemusnahan');

        Route::resource('pemusnaan', PemusnaanController::class);
        Route::put('/pemusnaan/{id}/laksanakan', [PemusnaanController::class, 'laksanakan'])->name('pemusnaan.laksanakan');
        Route::get('/pemusnaan/create', [PemusnaanController::class, 'create'])->name('pemusnaan.create');
        Route::post('/pemusnaan/store', [PemusnaanController::class, 'store'])->name('pemusnaan.store');
    });

    // 🕓 Riwayat
    Route::middleware('checkRole:A,U,K,W')->group(function () {
        Route::resource('history', HistorieController::class);
    });

    // ❌ Peminjam bisa batalkan peminjaman
    Route::patch('/peminjaman/{id}/batalkan', [PeminjamanController::class, 'batalkan'])->name('peminjaman.batalkan');
});
