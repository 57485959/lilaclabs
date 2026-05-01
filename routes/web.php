<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\StokMasukController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\LaporanController;

// Redirect root ke login
Route::get('/', fn() => redirect()->route('login'));

// Auth
Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout',[AuthController::class, 'logout'])->name('logout');

// Semua route di bawah butuh login
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Produk
    Route::resource('produk', ProdukController::class)->except(['show']);

    // Stok masuk
    Route::get('/stok',         [StokMasukController::class, 'index'])->name('stok.index');
    Route::get('/stok/tambah',  [StokMasukController::class, 'create'])->name('stok.create');
    Route::post('/stok',        [StokMasukController::class, 'store'])->name('stok.store');

    // Penjualan
    Route::get('/penjualan',           [PenjualanController::class, 'index'])->name('penjualan.index');
    Route::get('/penjualan/tambah',    [PenjualanController::class, 'create'])->name('penjualan.create');
    Route::post('/penjualan',          [PenjualanController::class, 'store'])->name('penjualan.store');
    Route::get('/penjualan/{penjualan}',[PenjualanController::class, 'show'])->name('penjualan.show');

    // Pengeluaran
    Route::get('/pengeluaran',          [PengeluaranController::class, 'index'])->name('pengeluaran.index');
    Route::get('/pengeluaran/tambah',   [PengeluaranController::class, 'create'])->name('pengeluaran.create');
    Route::post('/pengeluaran',         [PengeluaranController::class, 'store'])->name('pengeluaran.store');
    Route::delete('/pengeluaran/{pengeluaran}', [PengeluaranController::class, 'destroy'])->name('pengeluaran.destroy');

    // Laporan
    Route::get('/laporan/laba-rugi', [LaporanController::class, 'labaRugi'])->name('laporan.laba-rugi');
    Route::get('/laporan/stok',      [LaporanController::class, 'stok'])->name('laporan.stok');
    Route::get('/laporan/penjualan', [LaporanController::class, 'penjualan'])->name('laporan.penjualan');
});
