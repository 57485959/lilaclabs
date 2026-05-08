@extends('layouts.app')
@section('title','Laporan Penjualan')
@section('page-title','Laporan Penjualan')
@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <form method="GET" class="d-flex gap-2 align-items-center">
        <label class="fw-semibold" style="font-size:13px;white-space:nowrap">Pilih Bulan:</label>
        <input type="month" name="bulan" class="form-control" value="{{ $bulan }}" style="width:180px">
        <button type="submit" class="btn btn-madu">Tampilkan</button>
    </form>
</div>
<div class="row g-3">
<div class="col-md-5">
<div class="card mb-3">
    <div class="card-header">🏆 Produk Terlaris Bulan Ini</div>
    <div class="card-body p-0">
        <table class="table mb-0" style="font-size:12px">
            <thead><tr><th class="ps-3">#</th><th>Produk</th><th>Terjual</th><th>Pendapatan</th></tr></thead>
            <tbody>
                @forelse($produkTerlaris as $i => $p)
                <tr>
                    <td class="ps-3 fw-bold" style="color:#f59e0b">{{ $i+1 }}</td>
                    <td>{{ $p->nama_produk }}</td>
                    <td><strong>{{ $p->total_terjual }}</strong></td>
                    <td>Rp {{ number_format($p->total_pendapatan,0,',','.') }}</td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center text-muted py-3">Belum ada data</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</div>
<div class="col-md-7">
<div class="card">
    <div class="card-header">🧾 Semua Transaksi Bulan Ini</div>
    <div class="card-body p-0">
        <table class="table mb-0" style="font-size:12px">
            <thead><tr><th class="ps-3">No. Invoice</th><th>Tanggal</th><th>Pelanggan</th><th>Grandtotal</th><th>Metode</th><th>Status</th></tr></thead>
            <tbody>
                @forelse($transaksi as $t)
                <tr>
                    <td class="ps-3" style="font-family:monospace">{{ $t->id_transaksi }}</td>
                    <td>{{ $t->tanggal_transaksi->format('d/m') }}</td>
                    <td>{{ $t->pelanggan?->nama_pelanggan ?? 'Umum' }}</td>
                    <td class="fw-semibold" style="color:#d97706">Rp {{ number_format($t->grandtotal,0,',','.') }}</td>
                    <td>{{ $t->metode_bayar }}</td>
                    <td><span class="badge {{ $t->status_bayar=='Lunas'?'badge-aman':'badge-menipis' }}" style="font-size:10px">{{ $t->status_bayar }}</span></td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-3">Belum ada transaksi</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</div>
</div>
@endsection
