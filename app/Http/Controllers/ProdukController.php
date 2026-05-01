<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        $produk = Produk::orderBy('nama_produk')->get();
        return view('produk.index', compact('produk'));
    }

    public function create()
    {
        return view('produk.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk'  => 'required|string|max:150',
            'satuan'       => 'required|string|max:20',
            'harga_jual'   => 'required|numeric|min:0',
            'harga_beli'   => 'required|numeric|min:0',
            'stok_minimum' => 'required|integer|min:0',
        ]);

        Produk::create($request->all());
        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Produk $produk)
    {
        return view('produk.edit', compact('produk'));
    }

    public function update(Request $request, Produk $produk)
    {
        $request->validate([
            'nama_produk'  => 'required|string|max:150',
            'satuan'       => 'required|string|max:20',
            'harga_jual'   => 'required|numeric|min:0',
            'harga_beli'   => 'required|numeric|min:0',
            'stok_minimum' => 'required|integer|min:0',
        ]);

        $produk->update($request->all());
        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Produk $produk)
    {
        $produk->update(['status' => 'nonaktif']);
        return redirect()->route('produk.index')->with('success', 'Produk berhasil dinonaktifkan.');
    }
}
