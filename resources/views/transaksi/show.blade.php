@extends('layouts.app')
@section('title','Detail Transaksi')
@section('page-title','Kasir')
@section('content')

<div style="display:flex;align-items:center;gap:10px;margin-bottom:16px">
    <a href="{{ route('transaksi.index') }}" style="font-size:20px;color:#3d2b1a;text-decoration:none">←</a>
    <h2 style="font-size:18px;font-weight:700;color:#3d2b1a">Detail Transaksi</h2>
</div>

{{-- Header Info --}}
<div class="card">
    <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:12px">
        <div>
            <div style="font-family:monospace;font-size:14px;font-weight:700;color:#5c3d1e;margin-bottom:4px">
                {{ $transaksi->id_transaksi }}
            </div>
            <div style="font-size:12px;color:#7a6152">
                {{ $transaksi->tanggal_transaksi?->format('d M Y') }}
            </div>
        </div>
        <span class="badge {{ $transaksi->status_bayar=='Lunas'?'badge-green':($transaksi->status_bayar=='DP'?'badge-amber':'badge-red') }}">
            {{ $transaksi->status_bayar }}
        </span>
    </div>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
        <div>
            <div style="font-size:11px;color:#9b8878;font-weight:700;text-transform:uppercase;margin-bottom:2px">Pelanggan</div>
            <div style="font-size:13px;font-weight:600;color:#3d2b1a">{{ $transaksi->pelanggan?->nama_pelanggan ?? 'Umum' }}</div>
        </div>
        <div>
            <div style="font-size:11px;color:#9b8878;font-weight:700;text-transform:uppercase;margin-bottom:2px">Metode Bayar</div>
            <div style="font-size:13px;font-weight:600;color:#3d2b1a">{{ $transaksi->metode_bayar }}</div>
        </div>
        <div>
            <div style="font-size:11px;color:#9b8878;font-weight:700;text-transform:uppercase;margin-bottom:2px">Kasir</div>
            <div style="font-size:13px;font-weight:600;color:#3d2b1a">{{ $transaksi->user->nama }}</div>
        </div>
    </div>
</div>

{{-- Detail Produk --}}
<div class="card">
    <p class="section-title">🍶 Produk yang Dibeli</p>
    @foreach($transaksi->detail as $d)
    <div style="display:flex;justify-content:space-between;align-items:center;padding:10px 0;border-bottom:1px solid #e8ddd5">
        <div>
            <div style="font-size:14px;font-weight:600;color:#3d2b1a">{{ $d->produk->nama_produk }}</div>
            <div style="font-size:12px;color:#7a6152">
                {{ $d->qty }} × Rp {{ number_format($d->harga_saat_transaksi,0,',','.') }}
            </div>
        </div>
        <div style="font-size:14px;font-weight:700;color:#d97706">
            Rp {{ number_format($d->subtotal,0,',','.') }}
        </div>
    </div>
    @endforeach

    <div style="margin-top:12px">
        <div style="display:flex;justify-content:space-between;font-size:13px;color:#7a6152;margin-bottom:6px">
            <span>Subtotal</span>
            <span>Rp {{ number_format($transaksi->subtotal,0,',','.') }}</span>
        </div>
        <div style="display:flex;justify-content:space-between;font-size:13px;color:#7a6152;margin-bottom:10px">
            <span>Ongkos Kirim</span>
            <span>Rp {{ number_format($transaksi->ongkir,0,',','.') }}</span>
        </div>
        <div style="display:flex;justify-content:space-between;padding-top:10px;border-top:1px solid #e8ddd5">
            <span style="font-size:16px;font-weight:700;color:#3d2b1a">Total</span>
            <span style="font-size:18px;font-weight:700;color:#d97706">
                Rp {{ number_format($transaksi->grandtotal,0,',','.') }}
            </span>
        </div>
    </div>
</div>

{{-- Aksi --}}
<div style="display:flex;gap:10px;margin-bottom:40px">
    <a href="{{ route('transaksi.cetak', $transaksi->id_transaksi) }}"
       class="btn btn-amber" style="flex:1;justify-content:center" target="_blank">
        🖨️ Cetak Struk
    </a>
</div>

@endsection
