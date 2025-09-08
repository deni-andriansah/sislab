<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Import semua Controller biar rapi
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\DetailRuanganController;
use App\Http\Controllers\MBarangController;
use App\Http\Controllers\MRuanganController;
use App\Http\Controllers\LmBarangController;
use App\Http\Controllers\LmRuanganController;
use App\Http\Controllers\PmBarangController;
use App\Http\Controllers\PmRuanganController;
use App\Http\Controllers\PBarangController;
use App\Http\Controllers\PRuanganController;
use App\Http\Controllers\LBarangController;
use App\Http\Controllers\LRuanganController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('auth.login');
});

// ✅ RegisterController harus di-import biar tidak error
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');

// Auth bawaan laravel
Auth::routes(['register' => false]);

Route::get('/home', [HomeController::class, 'index'])->name('home');

// ==========================
// Resource Routes
// ==========================
Route::resource('kategori', KategoriController::class)->middleware('auth');
Route::resource('ruangan', RuanganController::class)->middleware('auth');   // <-- ini penting untuk hapus
Route::resource('anggota', AnggotaController::class)->middleware('auth');
Route::resource('barang', BarangController::class)->middleware('auth');
Route::resource('detail_ruangan', DetailRuanganController::class)->middleware('auth');

Route::resource('m_barang', MBarangController::class)->middleware('auth');
Route::resource('m_ruangan', MRuanganController::class)->middleware('auth');

Route::resource('lm_barang', LmBarangController::class)->middleware('auth');
Route::resource('lm_ruangan', LmRuanganController::class)->middleware('auth');

Route::resource('pm_ruangan', PmRuanganController::class)->middleware('auth');
Route::resource('pm_barang', PmBarangController::class)->except(['show'])->middleware('auth');

// custom edit/update route untuk pm_ruangan
Route::get('/pm_ruangan/{code_peminjaman}/edit', [PmRuanganController::class, 'edit'])->name('pm_ruangan.edit');
Route::put('/pm_ruangan/{code_peminjaman}', [PmRuanganController::class, 'update'])->name('pm_ruangan.update');

// ==========================
// Update status ruangan
// ==========================
Route::get('/ruangan/{id}/pinjam', [RuanganController::class, 'updateStatusDipinjam'])->name('ruangan.updateStatusDipinjam');
Route::get('/ruangan/{id}/kembalikan', [RuanganController::class, 'updateStatusTersedia'])->name('ruangan.updateStatusTersedia');

Route::resource('p_ruangan', PRuanganController::class)->middleware('auth');
Route::resource('p_barang', PBarangController::class)->middleware('auth');
Route::get('/get-detail-peminjaman-barang/{id}', [PBarangController::class, 'getDetailPeminjaman']);

Route::resource('l_barang', LBarangController::class)->middleware('auth');
Route::resource('l_ruangan', LRuanganController::class)->middleware('auth');

Route::get('profile', [HomeController::class, 'profile'])->name('profile.index');

// ==========================
// Export & PDF
// ==========================
Route::get('/pm_barang/view-pdf/{idPeminjaman}', [PmBarangController::class, 'viewPDF'])->name('pm_barang.view-pdf');
Route::get('/pm_ruangan/view-pdf/{idPeminjaman}', [PmRuanganController::class, 'viewPDF'])->name('pm_ruangan.view-pdf');

Route::get('pm_barang/export-barang/{idPeminjaman}', [PmBarangController::class, 'viewBARANG'])->name('pm_barang.view-barang');
Route::get('pm_ruangan/export-ruangan/{idPeminjaman}', [PmRuanganController::class, 'viewruangan'])->name('pm_ruangan.view-ruangan');

// ==========================
// Peminjaman Barang
// ==========================
Route::post('/barang/{id}/pinjam', [BarangController::class, 'pinjam'])->name('barang.pinjam');

// ==========================
// API route anggota by nim
// ==========================
Route::get('/api/anggota/by-nim/{nim}', function ($nim) {
    $anggota = \App\Models\Anggota::where('nim', $nim)->first();
    return response()->json($anggota);
});
