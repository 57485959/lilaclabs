<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use App\Models\KategoriPengeluaran;
use Illuminate\Http\Request;

class PengeluaranController extends Controller
{
    public function index()
    {
        $pengeluaran = Pengeluaran::with(['kategori', 'user'])
            ->orderBy('tanggal', 'desc')
            ->paginate(15);
        return view('pengeluaran.index', compact('pengeluaran'));
    }

    public function create()
    {
        $kategori = KategoriPengeluaran::orderBy('nama_kategori')->get();
        return view('pengeluaran.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategori_pengeluaran,id',
            'tanggal'     => 'required|date',
            'jumlah'      => 'required|numeric|min:1',
            'keterangan'  => 'required|string',
        ]);

        Pengeluaran::create([
            'kategori_id' => $request->kategori_id,
            'user_id'     => auth()->id(),
            'tanggal'     => $request->tanggal,
            'jumlah'      => $request->jumlah,
            'keterangan'  => $request->keterangan,
        ]);

        return redirect()->route('pengeluaran.index')->with('success', 'Pengeluaran berhasil dicatat.');
    }

    public function destroy(Pengeluaran $pengeluaran)
    {
        $pengeluaran->delete();
        return redirect()->route('pengeluaran.index')->with('success', 'Data pengeluaran dihapus.');
    }
}
