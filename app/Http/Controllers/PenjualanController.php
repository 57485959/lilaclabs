<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use App\Models\Pelanggan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    public function index()
    {
        $penjualan = Penjualan::with('pelanggan')
            ->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        return view('penjualan.index', compact('penjualan'));
    }

    public function create()
    {
        $produk     = Produk::where('status', 'aktif')->where('stok', '>', 0)->orderBy('nama_produk')->get();
        $pelanggan  = Pelanggan::orderBy('nama')->get();
        return view('penjualan.create', compact('produk', 'pelanggan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal'      => 'required|date',
            'status_bayar' => 'required|in:lunas,hutang,dp',
            'metode_bayar' => 'required|in:tunai,transfer,lainnya',
            'produk_id'    => 'required|array|min:1',
            'produk_id.*'  => 'exists:produk,id',
            'jumlah.*'     => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request) {
            // Buat atau ambil pelanggan
            $pelangganId = null;
            if ($request->nama_pelanggan) {
                $pelanggan = Pelanggan::firstOrCreate(
                    ['nama' => $request->nama_pelanggan],
                    ['nomor_hp' => $request->nomor_hp ?? null]
                );
                $pelangganId = $pelanggan->id;
            }

            // Hitung total
            $totalHarga = 0;
            $totalHpp   = 0;
            $items      = [];

            foreach ($request->produk_id as $i => $produkId) {
                $produk   = Produk::findOrFail($produkId);
                $jumlah   = $request->jumlah[$i];
                $subtotal = $produk->harga_jual * $jumlah;
                $hpp      = $produk->harga_beli * $jumlah;
                $laba     = $subtotal - $hpp;

                $totalHarga += $subtotal;
                $totalHpp   += $hpp;

                $items[] = [
                    'produk_id'  => $produkId,
                    'jumlah'     => $jumlah,
                    'harga_jual' => $produk->harga_jual,
                    'harga_beli' => $produk->harga_beli,
                    'subtotal'   => $subtotal,
                    'laba_item'  => $laba,
                ];

                // Kurangi stok
                $produk->decrement('stok', $jumlah);
            }

            $diskon     = $request->diskon ?? 0;
            $labaKotor  = ($totalHarga - $diskon) - $totalHpp;

            // Simpan header penjualan
            $penjualan = Penjualan::create([
                'kode_transaksi' => Penjualan::generateKode(),
                'pelanggan_id'   => $pelangganId,
                'user_id'        => auth()->id(),
                'tanggal'        => $request->tanggal,
                'total_harga'    => $totalHarga - $diskon,
                'total_hpp'      => $totalHpp,
                'laba_kotor'     => $labaKotor,
                'diskon'         => $diskon,
                'status_bayar'   => $request->status_bayar,
                'metode_bayar'   => $request->metode_bayar,
                'keterangan'     => $request->keterangan,
            ]);

            // Simpan detail
            foreach ($items as $item) {
                $penjualan->detail()->create($item);
            }

            // Update total pembelian pelanggan
            if ($pelangganId) {
                Pelanggan::where('id', $pelangganId)
                    ->increment('total_pembelian', $totalHarga - $diskon);
            }
        });

        return redirect()->route('penjualan.index')->with('success', 'Transaksi penjualan berhasil dicatat.');
    }

    public function show(Penjualan $penjualan)
    {
        $penjualan->load(['pelanggan', 'user', 'detail.produk']);
        return view('penjualan.show', compact('penjualan'));
    }
}
