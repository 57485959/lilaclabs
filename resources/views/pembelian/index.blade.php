@extends('layouts.app')
@section('title','Pembelian Stok')
@section('page-title','Pembelian Stok')
@section('content')

<div class="page-header">
    <h2>Pembelian Stok</h2>
    <p>Riwayat pembelian stok dari supplier</p>
</div>

@forelse($pembelian as $p)
<div class="trx-card">
    <div class="trx-row">
        <div>
            <div style="font-size:14px;font-weight:700;color:#3d2b1a">{{ $p->produk->nama_produk }}</div>
            <div style="font-size:12px;color:#7a6152;margin-top:3px">
                📦 +{{ $p->jumlah }} unit •
                {{ $p->supplier ? '🏭 '.$p->supplier.' •' : '' }}
                📅 {{ $p->tanggal?->format('d M Y') }}
            </div>
        </div>
        <div style="text-align:right">
            <div style="font-size:15px;font-weight:700;color:#d97706">Rp {{ number_format($p->total,0,',','.') }}</div>
            <div style="font-size:11px;color:#9b8878">@ Rp {{ number_format($p->harga_beli,0,',','.') }}</div>
        </div>
    </div>
    @if($p->keterangan)
    <div style="font-size:12px;color:#7a6152;margin-top:6px;padding-top:6px;border-top:1px solid #e8ddd5">
        📝 {{ $p->keterangan }}
    </div>
    @endif
    <div style="font-size:11px;color:#9b8878;margin-top:6px">Dicatat: {{ $p->user->nama }}</div>
</div>
@empty
<div style="text-align:center;padding:40px 0;color:#9b8878">
    <div style="font-size:40px;margin-bottom:8px">📦</div>
    <p>Belum ada pembelian stok</p>
</div>
@endforelse

@if($pembelian->hasPages())
<div style="margin-top:8px">{{ $pembelian->links() }}</div>
@endif

<button class="fab" onclick="window.location='{{ route('pembelian.create') }}'">+</button>
@endsection
