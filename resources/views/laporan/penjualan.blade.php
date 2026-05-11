@extends('layouts.app')
@section('title','Laporan Penjualan')
@section('page-title','Laporan')
@section('content')

<div style="display:flex;align-items:center;gap:10px;margin-bottom:16px">
    <a href="{{ route('laporan.index') }}" style="font-size:20px;color:#3d2b1a;text-decoration:none">←</a>
    <h2 style="font-size:18px;font-weight:700;color:#3d2b1a">Laporan Transaksi</h2>
</div>

<div class="card">
    <form method="GET" style="display:flex;gap:10px;align-items:flex-end">
        <div style="flex:1">
            <label class="form-label">Pilih Bulan</label>
            <input type="month" name="bulan" class="form-control" value="{{ $bulan }}">
        </div>
        <button type="submit" class="btn btn-amber">Tampilkan</button>
    </form>
</div>

{{-- Produk Terlaris --}}
@if($produkTerlaris->count())
<p class="section-title">🏆 Produk Terlaris</p>
@foreach($produkTerlaris as $i => $p)
<div style="background:#fff;border-radius:12px;padding:12px 14px;border:1px solid #e8ddd5;margin-bottom:8px;display:flex;align-items:center;gap:12px">
    <div style="width:28px;height:28px;border-radius:50%;background:#fef3c7;display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:700;color:#d97706;flex-shrink:0">
        {{ $i+1 }}
    </div>
    <div style="flex:1">
        <div style="font-size:13px;font-weight:600;color:#3d2b1a">{{ $p->nama_produk }}</div>
        <div style="font-size:11px;color:#7a6152">{{ $p->ukuran_kemasan }}</div>
    </div>
    <div style="text-align:right">
        <div style="font-size:14px;font-weight:700;color:#d97706">{{ $p->total_terjual }} terjual</div>
        <div style="font-size:11px;color:#7a6152">Rp {{ number_format($p->total_pendapatan,0,',','.') }}</div>
    </div>
</div>
@endforeach
@endif

{{-- Daftar Transaksi --}}
<p class="section-title">🧾 Semua Transaksi</p>
@forelse($transaksi as $t)
<div class="trx-card">
    <div class="trx-row">
        <div>
            <div style="font-family:monospace;font-size:12px;font-weight:700;color:#5c3d1e">{{ $t->id_transaksi }}</div>
            <div style="font-size:12px;color:#7a6152;margin-top:3px">
                👤 {{ $t->pelanggan?->nama_pelanggan ?? 'Umum' }} •
                📅 {{ $t->tanggal_transaksi?->format('d M Y') }}
            </div>
        </div>
        <div style="text-align:right">
            <div style="font-size:14px;font-weight:700;color:#d97706">Rp {{ number_format($t->grandtotal,0,',','.') }}</div>
            <span class="badge {{ $t->status_bayar=='Lunas'?'badge-green':'badge-amber' }}" style="font-size:10px">{{ $t->status_bayar }}</span>
        </div>
    </div>
</div>
@empty
<div style="text-align:center;padding:30px 0;color:#9b8878;font-size:13px">Belum ada transaksi</div>
@endforelse

@endsection
