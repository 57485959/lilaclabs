<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\PembelianStokController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PengaturanController;

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

    // Transaksi
    Route::get('/transaksi',              [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/tambah',       [TransaksiController::class, 'create'])->name('transaksi.create');
    Route::post('/transaksi',             [TransaksiController::class, 'store'])->name('transaksi.store');
    Route::get('/transaksi/{id}',         [TransaksiController::class, 'show'])->name('transaksi.show');
    Route::get('/transaksi/{id}/cetak',   [TransaksiController::class, 'cetak'])->name('transaksi.cetak');

    // Pelanggan
    Route::get('/pelanggan',        [PelangganController::class, 'index'])->name('pelanggan.index');
    Route::get('/pelanggan/tambah', [PelangganController::class, 'create'])->name('pelanggan.create');
    Route::post('/pelanggan',       [PelangganController::class, 'store'])->name('pelanggan.store');
    Route::delete('/pelanggan/{pelanggan}', [PelangganController::class, 'destroy'])->name('pelanggan.destroy');

    // Pembelian Stok
    Route::get('/pembelian',        [PembelianStokController::class, 'index'])->name('pembelian.index');
    Route::get('/pembelian/tambah', [PembelianStokController::class, 'create'])->name('pembelian.create');
    Route::post('/pembelian',       [PembelianStokController::class, 'store'])->name('pembelian.store');

    // Pengeluaran
    Route::get('/pengeluaran',           [PengeluaranController::class, 'index'])->name('pengeluaran.index');
    Route::get('/pengeluaran/tambah',    [PengeluaranController::class, 'create'])->name('pengeluaran.create');
    Route::post('/pengeluaran',          [PengeluaranController::class, 'store'])->name('pengeluaran.store');
    Route::delete('/pengeluaran/{pengeluaran}', [PengeluaranController::class, 'destroy'])->name('pengeluaran.destroy');

    // Laporan
    Route::get('/laporan',            [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/laba-rugi',  [LaporanController::class, 'labaRugi'])->name('laporan.laba-rugi');
    Route::get('/laporan/stok',       [LaporanController::class, 'stok'])->name('laporan.stok');
    Route::get('/laporan/penjualan',  [LaporanController::class, 'penjualan'])->name('laporan.penjualan');

    // Pengaturan
    Route::get('/pengaturan',        [PengaturanController::class, 'index'])->name('pengaturan.index');
    Route::get('/pengaturan/edit',   [PengaturanController::class, 'edit'])->name('pengaturan.edit');
    Route::put('/pengaturan',        [PengaturanController::class, 'update'])->name('pengaturan.update');
});
