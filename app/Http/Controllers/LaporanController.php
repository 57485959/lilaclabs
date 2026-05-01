<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\Pengeluaran;
use App\Models\Produk;
use App\Models\StokMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function labaRugi(Request $request)
    {
        $bulan = $request->bulan ?? now()->format('Y-m');
        [$tahun, $bln] = explode('-', $bulan);

        $pendapatan = Penjualan::whereMonth('tanggal', $bln)
            ->whereYear('tanggal', $tahun)
            ->where('status_bayar', '!=', 'hutang')
            ->sum('total_harga');

        $hpp = Penjualan::whereMonth('tanggal', $bln)
            ->whereYear('tanggal', $tahun)
            ->where('status_bayar', '!=', 'hutang')
            ->sum('total_hpp');

        $labaKotor = $pendapatan - $hpp;

        $pengeluaran = Pengeluaran::whereMonth('tanggal', $bln)
            ->whereYear('tanggal', $tahun)
            ->sum('jumlah');

        $labaBersih = $labaKotor - $pengeluaran;

        // Rincian pengeluaran per kategori
        $rincianPengeluaran = Pengeluaran::with('kategori')
            ->whereMonth('tanggal', $bln)
            ->whereYear('tanggal', $tahun)
            ->selectRaw('kategori_id, SUM(jumlah) as total')
            ->groupBy('kategori_id')
            ->get();

        // Transaksi penjualan bulan ini
        $transaksi = Penjualan::with('pelanggan')
            ->whereMonth('tanggal', $bln)
            ->whereYear('tanggal', $tahun)
            ->orderBy('tanggal')
            ->get();

        return view('laporan.laba-rugi', compact(
            'bulan', 'pendapatan', 'hpp', 'labaKotor',
            'pengeluaran', 'labaBersih', 'rincianPengeluaran', 'transaksi'
        ));
    }

    public function stok()
    {
        $produk = Produk::where('status', 'aktif')
            ->orderByRaw("CASE WHEN stok = 0 THEN 0 WHEN stok <= stok_minimum THEN 1 ELSE 2 END")
            ->orderBy('nama_produk')
            ->get();

        $riwayatStok = StokMasuk::with(['produk', 'user'])
            ->orderBy('tanggal', 'desc')
            ->take(20)
            ->get();

        return view('laporan.stok', compact('produk', 'riwayatStok'));
    }

    public function penjualan(Request $request)
    {
        $bulan = $request->bulan ?? now()->format('Y-m');
        [$tahun, $bln] = explode('-', $bulan);

        $penjualan = Penjualan::with(['pelanggan', 'detail.produk'])
            ->whereMonth('tanggal', $bln)
            ->whereYear('tanggal', $tahun)
            ->orderBy('tanggal', 'desc')
            ->get();

        $produkTerlaris = DB::table('detail_penjualan as dp')
            ->join('produk as p', 'p.id', '=', 'dp.produk_id')
            ->join('penjualan as pj', 'pj.id', '=', 'dp.penjualan_id')
            ->whereMonth('pj.tanggal', $bln)
            ->whereYear('pj.tanggal', $tahun)
            ->selectRaw('p.nama_produk, SUM(dp.jumlah) as total_terjual, SUM(dp.subtotal) as total_pendapatan, SUM(dp.laba_item) as total_laba')
            ->groupBy('p.id', 'p.nama_produk')
            ->orderBy('total_terjual', 'desc')
            ->get();

        return view('laporan.penjualan', compact('bulan', 'penjualan', 'produkTerlaris'));
    }
}
