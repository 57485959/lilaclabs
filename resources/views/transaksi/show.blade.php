@extends('layouts.app')
@section('title','Detail Transaksi')
@section('page-title','Detail Transaksi')
@section('content')
<div class="row justify-content-center">
<div class="col-md-8">
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>🧾 {{ $transaksi->id_transaksi }}</span>
        <a href="{{ route('transaksi.index') }}" class="btn btn-sm btn-outline-secondary">← Kembali</a>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-6"><small class="text-muted">Tanggal</small><div class="fw-semibold">{{ $transaksi->tanggal_transaksi->format('d/m/Y') }}</div></div>
            <div class="col-6"><small class="text-muted">Pelanggan</small><div class="fw-semibold">{{ $transaksi->pelanggan?->nama_pelanggan ?? 'Umum' }}</div></div>
            <div class="col-6 mt-2"><small class="text-muted">Status Bayar</small><div><span class="badge {{ $transaksi->status_bayar=='Lunas'?'badge-aman':'badge-menipis' }}">{{ $transaksi->status_bayar }}</span></div></div>
            <div class="col-6 mt-2"><small class="text-muted">Metode Bayar</small><div class="fw-semibold">{{ $transaksi->metode_bayar }}</div></div>
        </div>
        <table class="table table-bordered" style="font-size:13px">
            <thead class="table-light"><tr><th>Produk</th><th>Qty</th><th>Harga Satuan</th><th>Subtotal</th></tr></thead>
            <tbody>
                @foreach($transaksi->detail as $d)
                <tr>
                    <td>{{ $d->produk->nama_produk }} ({{ $d->produk->ukuran_kemasan }})</td>
                    <td>{{ $d->qty }}</td>
                    <td>Rp {{ number_format($d->harga_saat_transaksi,0,',','.') }}</td>
                    <td>Rp {{ number_format($d->subtotal,0,',','.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot class="fw-bold">
                <tr><td colspan="3" class="text-end">Subtotal</td><td>Rp {{ number_format($transaksi->subtotal,0,',','.') }}</td></tr>
                <tr><td colspan="3" class="text-end">Ongkos Kirim</td><td>Rp {{ number_format($transaksi->ongkir,0,',','.') }}</td></tr>
                <tr style="background:#fef3c7"><td colspan="3" class="text-end">Grandtotal</td><td style="color:#d97706">Rp {{ number_format($transaksi->grandtotal,0,',','.') }}</td></tr>
            </tfoot>
        </table>
    </div>
</div>
</div>
</div>
@endsection
