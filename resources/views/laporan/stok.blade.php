@extends('layouts.app')
@section('title','Laporan Stok')
@section('page-title','Laporan')
@section('content')

<div style="display:flex;align-items:center;gap:10px;margin-bottom:16px">
    <a href="{{ route('laporan.index') }}" style="font-size:20px;color:#3d2b1a;text-decoration:none">←</a>
    <h2 style="font-size:18px;font-weight:700;color:#3d2b1a">Laporan Stok Produk</h2>
</div>

<p class="section-title">📦 Kondisi Stok Semua Produk</p>
@foreach($produk as $p)
<div class="trx-card">
    <div style="display:flex;justify-content:space-between;align-items:flex-start">
        <div>
            <div style="font-size:14px;font-weight:700;color:#3d2b1a">{{ $p->nama_produk }}</div>
            <div style="font-size:12px;color:#7a6152;margin-top:3px">
                {{ $p->ukuran_kemasan }} •
                <span class="badge {{ $p->jenis_asal=='Ternak'?'badge-green':'badge-amber' }}" style="font-size:10px">{{ $p->jenis_asal }}</span>
            </div>
            <div style="font-size:12px;color:#7a6152;margin-top:4px">
                Nilai Stok: Rp {{ number_format($p->stok * $p->harga_modal,0,',','.') }}
            </div>
        </div>
        <div style="text-align:right">
            <div style="font-size:20px;font-weight:700;color:{{ $p->stok==0?'#dc2626':($p->stok<=$p->minimum_stok?'#d97706':'#059669') }}">
                {{ $p->stok }}
            </div>
            <span class="badge badge-{{ $p->status_stok=='aman'?'green':($p->status_stok=='menipis'?'amber':'red') }}" style="font-size:10px">
                {{ ucfirst($p->status_stok) }}
            </span>
            <div style="font-size:11px;color:#9b8878;margin-top:3px">Min: {{ $p->minimum_stok }}</div>
        </div>
    </div>
</div>
@endforeach

<p class="section-title" style="margin-top:8px">📋 Riwayat Pembelian Stok Terbaru</p>
@forelse($riwayatPembelian as $r)
<div style="background:#fff;border-radius:12px;padding:12px 14px;border:1px solid #e8ddd5;margin-bottom:8px;display:flex;justify-content:space-between;align-items:center">
    <div>
        <div style="font-size:13px;font-weight:600;color:#3d2b1a">{{ $r->produk->nama_produk }}</div>
        <div style="font-size:12px;color:#7a6152">
            📅 {{ $r->tanggal?->format('d M Y') }}
            {{ $r->supplier ? '• 🏭 '.$r->supplier : '' }}
        </div>
    </div>
    <span class="badge badge-green">+{{ $r->jumlah }}</span>
</div>
@empty
<div style="text-align:center;color:#9b8878;padding:20px 0;font-size:13px">Belum ada riwayat</div>
@endforelse

@endsection
