<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Pelanggan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::with('pelanggan')
            ->orderBy('create_at', 'desc')
            ->paginate(15);
        return view('transaksi.index', compact('transaksi'));
    }

    public function create()
    {
        $produk    = Produk::where('stok', '>', 0)->orderBy('nama_produk')->get();
        $pelanggan = Pelanggan::orderBy('nama_pelanggan')->get();
        return view('transaksi.create', compact('produk', 'pelanggan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_transaksi' => 'required|date',
            'status_bayar'      => 'required|string',
            'metode_bayar'      => 'required|string',
            'produk_id'         => 'required|array|min:1',
            'qty'               => 'required|array|min:1',
            'qty.*'             => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request) {
            // Buat atau ambil pelanggan
            $pelangganId = null;
            if ($request->nama_pelanggan) {
                $pelanggan = Pelanggan::firstOrCreate(
                    ['nama_pelanggan' => $request->nama_pelanggan],
                    ['no_hp' => $request->no_hp ?? null]
                );
                $pelangganId = $pelanggan->id_pelanggan;
            }

            // Hitung subtotal dari semua item
            $subtotal = 0;
            $items    = [];

            foreach ($request->produk_id as $i => $produkId) {
                $produk  = Produk::findOrFail($produkId);
                $qty     = $request->qty[$i];
                $sub     = $produk->harga_jual * $qty;
                $subtotal += $sub;

                $items[] = [
                    'id_produk'           => $produkId,
                    'qty'                 => $qty,
                    'harga_saat_transaksi'=> $produk->harga_jual,
                    'subtotal'            => $sub,
                ];

                // Kurangi stok
                $produk->decrement('stok', $qty);
            }

            $ongkir    = $request->ongkir ?? 0;
            $grandtotal = $subtotal + $ongkir;

            // Simpan transaksi — id_transaksi di-generate trigger MySQL
            $transaksi = Transaksi::create([
                'id_transaksi'      => '', // akan diganti trigger
                'id_pelanggan'      => $pelangganId,
                'id_user'           => auth()->user()->id_user,
                'tanggal_transaksi' => $request->tanggal_transaksi,
                'ongkir'            => $ongkir,
                'metode_bayar'      => $request->metode_bayar,
                'status_bayar'      => $request->status_bayar,
                'subtotal'          => $subtotal,
                'grandtotal'        => $grandtotal,
            ]);

            // Ambil id_transaksi yang baru dibuat oleh trigger
            $idTransaksi = DB::table('transaksi')
                ->where('id_user', auth()->user()->id_user)
                ->orderBy('create_at', 'desc')
                ->value('id_transaksi');

            // Simpan detail
            foreach ($items as $item) {
                DetailTransaksi::create(array_merge(
                    $item,
                    ['id_transaksi' => $idTransaksi]
                ));
            }
        });

        return redirect()->route('transaksi.index')
            ->with('success', 'Transaksi berhasil dicatat.');
    }

    public function show($id)
    {
        $transaksi = Transaksi::with(['pelanggan', 'user', 'detail.produk'])
            ->findOrFail($id);
        return view('transaksi.show', compact('transaksi'));
    }
}
