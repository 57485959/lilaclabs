<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\PembelianStokController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\LaporanController;

Route::get('/', fn() => redirect()->route('login'));

// Auth
Route::get('/login',   [AuthController::class, 'showLogin'])->name('login');
Route::post('/login',  [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Produk
    Route::resource('produk', ProdukController::class)->except(['show']);

    // Pembelian Stok
    Route::get('/pembelian',        [PembelianStokController::class, 'index'])->name('pembelian.index');
    Route::get('/pembelian/tambah', [PembelianStokController::class, 'create'])->name('pembelian.create');
    Route::post('/pembelian',       [PembelianStokController::class, 'store'])->name('pembelian.store');

    // Transaksi Penjualan
    Route::get('/transaksi',           [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/tambah',    [TransaksiController::class, 'create'])->name('transaksi.create');
    Route::post('/transaksi',          [TransaksiController::class, 'store'])->name('transaksi.store');
    Route::get('/transaksi/{id}',      [TransaksiController::class, 'show'])->name('transaksi.show');

    // Pengeluaran
    Route::get('/pengeluaran',          [PengeluaranController::class, 'index'])->name('pengeluaran.index');
    Route::get('/pengeluaran/tambah',   [PengeluaranController::class, 'create'])->name('pengeluaran.create');
    Route::post('/pengeluaran',         [PengeluaranController::class, 'store'])->name('pengeluaran.store');
    Route::delete('/pengeluaran/{pengeluaran}', [PengeluaranController::class, 'destroy'])->name('pengeluaran.destroy');

    // Laporan
    Route::get('/laporan/laba-rugi',  [LaporanController::class, 'labaRugi'])->name('laporan.laba-rugi');
    Route::get('/laporan/stok',       [LaporanController::class, 'stok'])->name('laporan.stok');
    Route::get('/laporan/penjualan',  [LaporanController::class, 'penjualan'])->name('laporan.penjualan');
});
