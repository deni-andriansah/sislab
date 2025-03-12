<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Anggota;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register', [\App\Http\Controllers\Api\AuthController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::middleware('auth:sanctum')->group(function () {

        Route::get('/anggota', [Anggota::class, 'index']);
        Route::post('/anggota', [Anggota::class, 'store']);
        Route::get('/anggota/{id}', [Anggota::class, 'show']);
        Route::put('/anggota/{id}', [Anggota::class, 'update']);
        Route::delete('/anggota/{id}', [Anggota::class, 'destroy']);

    Route::post('/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout']);
});
