<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('merk', App\Http\Controllers\MerkController::class)->middleware('auth');
Route::resource('kategori', App\Http\Controllers\KategoriController::class)->middleware('auth');
Route::resource('ruangan', App\Http\Controllers\RuanganController::class)->middleware('auth');
Route::resource('kondisi', App\Http\Controllers\KondisiController::class)->middleware('auth');
Route::resource('barang', App\Http\Controllers\BarangController::class)->middleware('auth');
Route::resource('detail_ruangan', App\Http\Controllers\DetailRuanganController::class)->middleware('auth');

Route::resource('m_barang', App\Http\Controllers\MBarangController::class)->middleware('auth');
Route::resource('m_ruangan', App\Http\Controllers\MruanganController::class)->middleware('auth');

Route::resource('lm_barang', App\Http\Controllers\LmBarangController::class)->middleware('auth');
Route::resource('lm_ruangan', App\Http\Controllers\LmRuanganController::class)->middleware('auth');

Route::resource('pm_ruangan', App\Http\Controllers\PmRuanganController::class)->middleware('auth');
Route::resource('pm_barang', App\Http\Controllers\PmBarangController::class)->middleware('auth');

Route::resource('l_barang', App\Http\Controllers\LBarangController::class)->middleware('auth');
Route::resource('l_ruangan', App\Http\Controllers\LRuanganController::class)->middleware('auth');

Route::post('pm_barang/export-pm_barang', [App\Http\Controllers\PmBarangController::class, 'viewPDF'])->name('pm_barang.view-pdf');
Route::post('pm_ruangan/export-pm_ruangan', [App\Http\Controllers\PmRuanganController::class, 'viewPDF'])->name('pm_ruangan.view-pdf');

Route::post('pm_barang/cetak-pm_barang', [App\Http\Controllers\PmBarangController::class, 'viewBARANG'])->name('pm_barang.view-barang');
Route::post('pm_ruangan/cetak-pm_ruangan', [App\Http\Controllers\PmRuanganController::class, 'viewRUANGAN'])->name('pm_ruangan.view-ruangan');
