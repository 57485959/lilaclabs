@extends('layouts.app')
@section('title','Pembelian Stok')
@section('page-title','Pencatatan Pembelian Stok')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div style="color:#6c757d;font-size:13px">Riwayat pembelian stok dari supplier</div>
    <a href="{{ route('pembelian.create') }}" class="btn btn-madu">+ Catat Pembelian</a>
</div>
<div class="card">
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr><th class="ps-3">Tanggal</th><th>Produk</th><th>Supplier</th><th>Jumlah</th><th>Harga Beli/Unit</th><th>Total</th><th>Keterangan</th><th>Oleh</th></tr>
            </thead>
            <tbody>
                @forelse($pembelian as $p)
                <tr>
                    <td class="ps-3" style="font-size:13px">{{ $p->tanggal->format('d/m/Y') }}</td>
                    <td style="font-size:13px;font-weight:500">{{ $p->produk->nama_produk }}</td>
                    <td style="font-size:13px">{{ $p->supplier ?? '-' }}</td>
                    <td style="font-size:13px">{{ number_format($p->jumlah) }}</td>
                    <td style="font-size:13px">Rp {{ number_format($p->harga_beli,0,',','.') }}</td>
                    <td style="font-size:13px;font-weight:600;color:#d97706">Rp {{ number_format($p->total,0,',','.') }}</td>
                    <td style="font-size:12px;color:#6c757d">{{ $p->keterangan ?? '-' }}</td>
                    <td style="font-size:12px;color:#6c757d">{{ $p->user->nama }}</td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center text-muted py-4">Belum ada catatan pembelian stok</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($pembelian->hasPages())
    <div class="card-footer bg-white">{{ $pembelian->links() }}</div>
    @endif
</div>
@endsection
