<?php


use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BarangController;
use App\Http\Controllers\API\BarangRusakController;
use App\Http\Controllers\API\PeminjamanController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

// Route::middleware('auth:sanctum')->get('fakulitas', [FakulitasController::class, 'index']);
// Route::middleware(['auth:sanctum', 'ability:read-fakulitas'])->get('fakulitas', [FakulitasController::class, 'index']);
// Route::middleware(['auth:sanctum', 'ability:create-fakulitas'])->post('fakulitas', [FakulitasController::class, 'store']);
// Route::middleware(['auth:sanctum', 'ability:update-fakulitas'])->patch('fakulitas/{id}', [FakulitasController::class, 'update']);
// Route::middleware(['auth:sanctum', 'ability:delete-fakulitas'])->delete('fakulitas/{id}', [FakulitasController::class, 'destroy']);



Route::get('barang', [BarangController::class, 'index']);
Route::get('barangRusak', [BarangRusakController::class, 'index']);
Route::get('barangRusak', [HistoryController::class, 'index']);
Route::get('barangRusak', [LaporanController::class, 'index']);
Route::get('barangRusak', [PeminjamanController::class, 'index']);
Route::get('barangRusak', [PemusnaanController::class, 'index']);
Route::get('barangRusak', [PengembalianController::class, 'index']);

// //Route Update
// Route::patch('fakulitas/{id}', [FakulitasController::class, 'update']);
// Route::patch('prodi/{id}', [ProdiController::class, 'update']);


// //Route Delete
// Route::delete('fakulitas/{id}', [FakulitasController::class, 'destroy']);
// Route::delete('prodi/{id}', [ProdiController::class, 'destroy']);

// //Route Post
// // Route::post('fakulitas', [FakulitasController::class, 'store']);

// Route::post('prodi', [ProdiController::class, 'store']);

// Route::post('mahasiswa', [MahasiswaController::class, 'store']);
