<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Penjualan;
use App\Models\Pengeluaran;
use App\Models\StokMasuk;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Penjualan hari ini
        $penjualanHariIni = Penjualan::whereDate('tanggal', today())
            ->where('status_bayar', '!=', 'hutang')
            ->sum('total_harga');

        // Laba hari ini
        $labaHariIni = Penjualan::whereDate('tanggal', today())
            ->where('status_bayar', '!=', 'hutang')
            ->sum('laba_kotor');

        // Pengeluaran hari ini
        $pengeluaranHariIni = Pengeluaran::whereDate('tanggal', today())
            ->sum('jumlah');

        // Total transaksi hari ini
        $totalTransaksi = Penjualan::whereDate('tanggal', today())->count();

        // Penjualan bulan ini
        $penjualanBulanIni = Penjualan::whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->where('status_bayar', '!=', 'hutang')
            ->sum('total_harga');

        // Laba bersih bulan ini
        $labaKotorBulan = Penjualan::whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->where('status_bayar', '!=', 'hutang')
            ->sum('laba_kotor');

        $pengeluaranBulan = Pengeluaran::whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->sum('jumlah');

        $labaBersihBulan = $labaKotorBulan - $pengeluaranBulan;

        // Stok produk
        $stokAman    = Produk::where('status', 'aktif')->where('stok', '>', DB::raw('stok_minimum'))->count();
        $stokMenipis = Produk::where('status', 'aktif')->where('stok', '>', 0)->whereColumn('stok', '<=', 'stok_minimum')->count();
        $stokHabis   = Produk::where('status', 'aktif')->where('stok', 0)->count();

        // Produk stok menipis / habis untuk peringatan
        $peringatanStok = Produk::where('status', 'aktif')
            ->whereColumn('stok', '<=', 'stok_minimum')
            ->orderBy('stok')
            ->take(5)
            ->get();

        // Transaksi terbaru
        $transaksiTerbaru = Penjualan::with('pelanggan')
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        // Grafik penjualan 7 hari terakhir
        $grafikPenjualan = Penjualan::selectRaw('DATE(tanggal) as tgl, SUM(total_harga) as total, SUM(laba_kotor) as laba')
            ->where('tanggal', '>=', now()->subDays(6))
            ->where('status_bayar', '!=', 'hutang')
            ->groupBy('tgl')
            ->orderBy('tgl')
            ->get();

        return view('dashboard.index', compact(
            'penjualanHariIni', 'labaHariIni', 'pengeluaranHariIni', 'totalTransaksi',
            'penjualanBulanIni', 'labaBersihBulan',
            'stokAman', 'stokMenipis', 'stokHabis',
            'peringatanStok', 'transaksiTerbaru', 'grafikPenjualan'
        ));
    }
}
