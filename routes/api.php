<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\BarangApiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Anggota;
use App\Http\Controllers\Api\PeminjamanController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\KategoriController;
use App\Http\Controllers\Api\RuanganApi;

/*
|----------------------------------------------------------------------
| API Routes
|----------------------------------------------------------------------
| Here is where you can register API routes for your application.
| These routes are loaded by the RouteServiceProvider within a group
| which is assigned the "api" middleware group. Enjoy building your API!
*/

Route::post('/register', [\App\Http\Controllers\Api\AuthController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);

// Route to get the authenticated user
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('ruangan')->group(function () {
    Route::get('/', [RuanganApi::class, 'index']);
    Route::post('/', [RuanganApi::class, 'store']);
    Route::get('/{id}', [RuanganApi::class, 'show']);
    Route::put('/{id}', [RuanganApi::class, 'update']);
    Route::delete('/{id}', [RuanganApi::class, 'destroy']);
});

// Anggota API Routes
Route::prefix('anggota')->group(function () {
    Route::get('/', [Anggota::class, 'index']);
    Route::post('/', [Anggota::class, 'store']);
    Route::get('/{id}', [Anggota::class, 'show']);
    Route::put('/{id}', [Anggota::class, 'update']);
    Route::delete('/{id}', [Anggota::class, 'destroy']);
});

// Barang API Routes
Route::prefix('barang')->group(function () {
    Route::get('/', [BarangApiController::class, 'index']);
    Route::get('/create-kode', [BarangApiController::class, 'createKode']); // untuk generate kode otomatis
    Route::post('/', [BarangApiController::class, 'store']);
    Route::get('/{id}', [BarangApiController::class, 'show']);
    Route::put('/{id}', [BarangApiController::class, 'update']);
    Route::delete('/{id}', [BarangApiController::class, 'destroy']);
});

// Peminjaman API Routes
Route::prefix('peminjaman')->group(function () {
    Route::get('/', [PeminjamanController::class, 'index']);               // List semua peminjaman
    Route::post('/', [PeminjamanController::class, 'store']);              // Simpan data peminjaman baru
    Route::get('/{code}', [PeminjamanController::class, 'show']);          // Detail satu peminjaman (berdasarkan kode)
    Route::put('/{code}', [PeminjamanController::class, 'update']);        // Update peminjaman berdasarkan kode
    Route::delete('/{code}', [PeminjamanController::class, 'destroy']);    // Hapus peminjaman (berdasarkan kode)
});

// Kategori API Routes
Route::prefix('kategori')->group(function () {
    Route::get('/', [KategoriController::class, 'index']);                // List semua kategori
    Route::post('/', [KategoriController::class, 'store']);               // Simpan kategori baru
    Route::get('/{id}', [KategoriController::class, 'show']);             // Detail kategori berdasarkan ID
    Route::put('/{id}', [KategoriController::class, 'update']);           // Update kategori berdasarkan ID
    Route::delete('/{id}', [KategoriController::class, 'destroy']);       // Hapus kategori berdasarkan ID
});

// User authentication routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout']);
    Route::get('/profile', [UserController::class, 'profile']);
});
