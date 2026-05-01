@extends('layouts.app')
@section('title','Laporan Stok')
@section('page-title','Laporan Stok Produk')
@section('content')
<div class="row g-3">
<div class="col-md-7">
<div class="card">
    <div class="card-header">🗃️ Kondisi Stok Semua Produk</div>
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead><tr><th class="ps-3">Produk</th><th>Satuan</th><th>Stok</th><th>Min. Stok</th><th>Nilai Stok</th><th>Status</th></tr></thead>
            <tbody>
                @foreach($produk as $p)
                <tr>
                    <td class="ps-3" style="font-size:13px;font-weight:500">{{ $p->nama_produk }}</td>
                    <td style="font-size:13px">{{ $p->satuan }}</td>
                    <td style="font-size:13px;font-weight:700">{{ number_format($p->stok) }}</td>
                    <td style="font-size:12px;color:#6c757d">{{ $p->stok_minimum }}</td>
                    <td style="font-size:13px">Rp {{ number_format($p->stok * $p->harga_beli,0,',','.') }}</td>
                    <td>
                        <span class="badge badge-{{ $p->status_stok }}" style="font-size:11px">
                            {{ ucfirst($p->status_stok) }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>
<div class="col-md-5">
<div class="card">
    <div class="card-header">📋 Riwayat Stok Masuk Terbaru</div>
    <div class="card-body p-0">
        <table class="table mb-0" style="font-size:12px">
            <thead><tr><th class="ps-3">Tanggal</th><th>Produk</th><th>Jumlah</th><th>Sumber</th></tr></thead>
            <tbody>
                @forelse($riwayatStok as $r)
                <tr>
                    <td class="ps-3">{{ $r->tanggal->format('d/m/Y') }}</td>
                    <td>{{ $r->produk->nama_produk }}</td>
                    <td>+{{ $r->jumlah }}</td>
                    <td><span class="badge badge-aman" style="font-size:10px">{{ ucfirst($r->sumber) }}</span></td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center text-muted py-3">Belum ada riwayat</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</div>
</div>
@endsection
