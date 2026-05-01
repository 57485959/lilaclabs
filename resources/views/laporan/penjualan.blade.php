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
    <div class="card-header">🏆 Produk Terlaris</div>
    <div class="card-body p-0">
        <table class="table mb-0" style="font-size:12px">
            <thead><tr><th class="ps-3">#</th><th>Produk</th><th>Terjual</th><th>Laba</th></tr></thead>
            <tbody>
                @forelse($produkTerlaris as $i => $p)
                <tr>
                    <td class="ps-3">{{ $i+1 }}</td>
                    <td>{{ $p->nama_produk }}</td>
                    <td><strong>{{ $p->total_terjual }}</strong></td>
                    <td style="color:#10b981">Rp {{ number_format($p->total_laba,0,',','.') }}</td>
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
            <thead><tr><th class="ps-3">Kode</th><th>Tanggal</th><th>Pelanggan</th><th>Total</th><th>Laba</th><th>Status</th></tr></thead>
            <tbody>
                @forelse($penjualan as $p)
                <tr>
                    <td class="ps-3" style="font-family:monospace">{{ $p->kode_transaksi }}</td>
                    <td>{{ $p->tanggal->format('d/m') }}</td>
                    <td>{{ $p->pelanggan?->nama ?? 'Umum' }}</td>
                    <td>Rp {{ number_format($p->total_harga,0,',','.') }}</td>
                    <td style="color:#10b981">Rp {{ number_format($p->laba_kotor,0,',','.') }}</td>
                    <td><span class="badge {{ $p->status_bayar=='lunas'?'badge-aman':'badge-menipis' }}" style="font-size:10px">{{ ucfirst($p->status_bayar) }}</span></td>
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
