<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\ProdukApiController;
use App\Http\Controllers\Api\TransaksiApiController;
use App\Http\Controllers\Api\PembelianApiController;
use App\Http\Controllers\Api\PengeluaranApiController;
use App\Http\Controllers\Api\LaporanApiController;

/*
|--------------------------------------------------------------------------
| API Routes — Dadi Madu
|--------------------------------------------------------------------------
| Base URL: http://localhost:8000/api/
| Header wajib: Accept: application/json
| Header auth : Authorization: Bearer {token}
*/

// ============================================================
// PUBLIC — Tidak butuh login
// ============================================================
Route::post('/login', [AuthApiController::class, 'login']);

// ============================================================
// PROTECTED — Butuh token (Authorization: Bearer {token})
// ============================================================
Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::post('/logout',  [AuthApiController::class, 'logout']);
    Route::get('/profile',  [AuthApiController::class, 'profile']);

    // Produk
    Route::get('/produk',         [ProdukApiController::class, 'index']);
    Route::get('/produk/{id}',    [ProdukApiController::class, 'show']);
    Route::post('/produk',        [ProdukApiController::class, 'store']);
    Route::put('/produk/{id}',    [ProdukApiController::class, 'update']);
    Route::delete('/produk/{id}', [ProdukApiController::class, 'destroy']);

    // Transaksi Penjualan
    Route::get('/transaksi',      [TransaksiApiController::class, 'index']);
    Route::get('/transaksi/{id}', [TransaksiApiController::class, 'show']);
    Route::post('/transaksi',     [TransaksiApiController::class, 'store']);

    // Pembelian Stok
    Route::get('/pembelian',  [PembelianApiController::class, 'index']);
    Route::post('/pembelian', [PembelianApiController::class, 'store']);

    // Pengeluaran
    Route::get('/pengeluaran',         [PengeluaranApiController::class, 'index']);
    Route::post('/pengeluaran',        [PengeluaranApiController::class, 'store']);
    Route::delete('/pengeluaran/{id}', [PengeluaranApiController::class, 'destroy']);

    // Laporan
    Route::get('/laporan/dashboard',  [LaporanApiController::class, 'dashboard']);
    Route::get('/laporan/laba-rugi',  [LaporanApiController::class, 'labaRugi']);
    Route::get('/laporan/stok',       [LaporanApiController::class, 'stok']);
    Route::get('/laporan/penjualan',  [LaporanApiController::class, 'penjualan']);
});
