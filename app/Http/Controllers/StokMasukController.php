<?php

namespace App\Http\Controllers;

use App\Models\StokMasuk;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StokMasukController extends Controller
{
    public function index()
    {
        $stokMasuk = StokMasuk::with(['produk', 'user'])
            ->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        return view('stok.index', compact('stokMasuk'));
    }

    public function create()
    {
        $produk = Produk::where('status', 'aktif')->orderBy('nama_produk')->get();
        return view('stok.create', compact('produk'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'produk_id'           => 'required|exists:produk,id',
            'tanggal'             => 'required|date',
            'jumlah'              => 'required|integer|min:1',
            'harga_beli_per_unit' => 'required|numeric|min:0',
            'sumber'              => 'required|in:panen,pembelian,lainnya',
            'keterangan'          => 'nullable|string',
        ]);

        $total = $request->jumlah * $request->harga_beli_per_unit;

        DB::transaction(function () use ($request, $total) {
            StokMasuk::create([
                'produk_id'           => $request->produk_id,
                'user_id'             => auth()->id(),
                'tanggal'             => $request->tanggal,
                'jumlah'              => $request->jumlah,
                'harga_beli_per_unit' => $request->harga_beli_per_unit,
                'total_biaya'         => $total,
                'sumber'              => $request->sumber,
                'keterangan'          => $request->keterangan,
            ]);
            // Update stok produk (trigger MySQL sudah handle, tapi ini sebagai fallback)
            Produk::where('id', $request->produk_id)
                ->increment('stok', $request->jumlah);
        });

        return redirect()->route('stok.index')->with('success', 'Stok masuk berhasil dicatat.');
    }
}
