@extends('layouts.app')
@section('title','Detail Penjualan')
@section('page-title','Detail Transaksi')
@section('content')
<div class="row justify-content-center">
<div class="col-md-8">
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>🧾 {{ $penjualan->kode_transaksi }}</span>
        <a href="{{ route('penjualan.index') }}" class="btn btn-sm btn-outline-secondary">← Kembali</a>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-6"><small class="text-muted">Tanggal</small><div class="fw-semibold">{{ $penjualan->tanggal->format('d/m/Y') }}</div></div>
            <div class="col-6"><small class="text-muted">Pelanggan</small><div class="fw-semibold">{{ $penjualan->pelanggan?->nama ?? 'Umum' }}</div></div>
            <div class="col-6 mt-2"><small class="text-muted">Status Bayar</small><div><span class="badge {{ $penjualan->status_bayar=='lunas'?'badge-aman':'badge-menipis' }}">{{ ucfirst($penjualan->status_bayar) }}</span></div></div>
            <div class="col-6 mt-2"><small class="text-muted">Metode Bayar</small><div class="fw-semibold">{{ ucfirst($penjualan->metode_bayar) }}</div></div>
        </div>
        <table class="table table-bordered" style="font-size:13px">
            <thead class="table-light"><tr><th>Produk</th><th>Jumlah</th><th>Harga Jual</th><th>Subtotal</th><th>Laba</th></tr></thead>
            <tbody>
                @foreach($penjualan->detail as $d)
                <tr>
                    <td>{{ $d->produk->nama_produk }}</td>
                    <td>{{ $d->jumlah }} {{ $d->produk->satuan }}</td>
                    <td>Rp {{ number_format($d->harga_jual,0,',','.') }}</td>
                    <td>Rp {{ number_format($d->subtotal,0,',','.') }}</td>
                    <td style="color:#10b981">Rp {{ number_format($d->laba_item,0,',','.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot class="fw-bold">
                <tr><td colspan="3" class="text-end">Total</td><td>Rp {{ number_format($penjualan->total_harga,0,',','.') }}</td><td style="color:#10b981">Rp {{ number_format($penjualan->laba_kotor,0,',','.') }}</td></tr>
            </tfoot>
        </table>
        @if($penjualan->keterangan)<div class="text-muted" style="font-size:13px">📝 {{ $penjualan->keterangan }}</div>@endif
    </div>
</div>
</div>
</div>
@endsection
