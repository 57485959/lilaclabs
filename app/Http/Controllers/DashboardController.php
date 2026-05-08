<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\Pengeluaran;
use App\Models\PembelianStok;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Penjualan hari ini
        $penjualanHariIni = Transaksi::whereDate('tanggal_transaksi', today())
            ->where('status_bayar', 'Lunas')
            ->sum('grandtotal');

        // Total transaksi hari ini
        $totalTransaksi = Transaksi::whereDate('tanggal_transaksi', today())->count();

        // Pengeluaran hari ini
        $pengeluaranHariIni = Pengeluaran::whereDate('tanggal', today())
            ->sum('jumlah_pengeluaran');

        // Penjualan bulan ini
        $penjualanBulanIni = Transaksi::whereMonth('tanggal_transaksi', now()->month)
            ->whereYear('tanggal_transaksi', now()->year)
            ->where('status_bayar', 'Lunas')
            ->sum('grandtotal');

        // Modal pembelian stok bulan ini
        $modalBulanIni = PembelianStok::whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->sum('total');

        // Pengeluaran bulan ini
        $pengeluaranBulan = Pengeluaran::whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->sum('jumlah_pengeluaran');

        // Laba bersih bulan ini
        $labaBersihBulan = $penjualanBulanIni - $modalBulanIni - $pengeluaranBulan;

        // Laba hari ini (estimasi)
        $modalHariIni = PembelianStok::whereDate('tanggal', today())->sum('total');
        $labaHariIni  = $penjualanHariIni - $modalHariIni - $pengeluaranHariIni;

        // Status stok
        $stokAman    = Produk::where('stok', '>', DB::raw('minimum_stok'))->count();
        $stokMenipis = Produk::where('stok', '>', 0)->whereColumn('stok', '<=', 'minimum_stok')->count();
        $stokHabis   = Produk::where('stok', 0)->count();

        // Peringatan stok menipis/habis
        $peringatanStok = Produk::whereColumn('stok', '<=', 'minimum_stok')
            ->orderBy('stok')
            ->take(5)
            ->get();

        // Transaksi terbaru
        $transaksiTerbaru = Transaksi::with('pelanggan')
            ->orderBy('create_at', 'desc')
            ->take(6)
            ->get();

        // Pengeluaran per kategori bulan ini
        $pengeluaranKategori = Pengeluaran::whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->selectRaw('kategori, SUM(jumlah_pengeluaran) as total')
            ->groupBy('kategori')
            ->get();

        return view('dashboard.index', compact(
            'penjualanHariIni', 'labaHariIni', 'pengeluaranHariIni', 'totalTransaksi',
            'penjualanBulanIni', 'labaBersihBulan',
            'stokAman', 'stokMenipis', 'stokHabis',
            'peringatanStok', 'transaksiTerbaru', 'pengeluaranKategori'
        ));
    }
}
