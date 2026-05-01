@extends('layouts.app')
@section('title','Laporan Laba Rugi')
@section('page-title','Laporan Laba Rugi')
@section('content')

<div class="d-flex align-items-center gap-3 mb-4">
    <form method="GET" class="d-flex gap-2 align-items-center">
        <label class="fw-semibold" style="font-size:13px;white-space:nowrap">Pilih Bulan:</label>
        <input type="month" name="bulan" class="form-control" value="{{ $bulan }}" style="width:180px">
        <button type="submit" class="btn btn-madu">Tampilkan</button>
    </form>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3 col-6">
        <div class="stat-card" style="background:linear-gradient(135deg,#f59e0b,#d97706)">
            <div class="icon">💰</div>
            <div class="label">Total Pendapatan</div>
            <div class="value">Rp {{ number_format($pendapatan,0,',','.') }}</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stat-card" style="background:linear-gradient(135deg,#6366f1,#4f46e5)">
            <div class="icon">📦</div>
            <div class="label">Total HPP / Modal</div>
            <div class="value">Rp {{ number_format($hpp,0,',','.') }}</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stat-card" style="background:linear-gradient(135deg,#ef4444,#dc2626)">
            <div class="icon">💸</div>
            <div class="label">Total Pengeluaran</div>
            <div class="value">Rp {{ number_format($pengeluaran,0,',','.') }}</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stat-card" style="background:linear-gradient(135deg,{{ $labaBersih >= 0 ? '#10b981,#059669' : '#ef4444,#dc2626' }})">
            <div class="icon">📈</div>
            <div class="label">Laba Bersih</div>
            <div class="value">Rp {{ number_format($labaBersih,0,',','.') }}</div>
            <div class="sub">{{ $labaBersih >= 0 ? '✅ Untung' : '⚠️ Rugi' }}</div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-5">
        <div class="card">
            <div class="card-header">📊 Rincian Laporan</div>
            <div class="card-body p-0">
                <table class="table mb-0" style="font-size:13px">
                    <tbody>
                        <tr><td class="ps-3">Pendapatan Penjualan</td><td class="text-end pe-3 fw-semibold">Rp {{ number_format($pendapatan,0,',','.') }}</td></tr>
                        <tr><td class="ps-3 text-muted">( - ) HPP / Modal</td><td class="text-end pe-3 text-danger">Rp {{ number_format($hpp,0,',','.') }}</td></tr>
                        <tr class="table-light"><td class="ps-3 fw-bold">Laba Kotor</td><td class="text-end pe-3 fw-bold text-success">Rp {{ number_format($labaKotor,0,',','.') }}</td></tr>
                        <tr><td class="ps-3 text-muted">( - ) Total Pengeluaran</td><td class="text-end pe-3 text-danger">Rp {{ number_format($pengeluaran,0,',','.') }}</td></tr>
                        <tr style="background:#fef3c7"><td class="ps-3 fw-bold" style="font-size:15px">Laba Bersih</td><td class="text-end pe-3 fw-bold" style="font-size:15px;color:{{ $labaBersih>=0?'#059669':'#dc2626' }}">Rp {{ number_format($labaBersih,0,',','.') }}</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">💸 Pengeluaran per Kategori</div>
            <div class="card-body p-0">
                @forelse($rincianPengeluaran as $r)
                <div class="d-flex justify-content-between align-items-center px-3 py-2 border-bottom" style="font-size:13px">
                    <span>{{ $r->kategori->nama_kategori }}</span>
                    <span class="fw-semibold text-danger">Rp {{ number_format($r->total,0,',','.') }}</span>
                </div>
                @empty
                <div class="text-center text-muted py-3" style="font-size:13px">Tidak ada pengeluaran</div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-md-7">
        <div class="card">
            <div class="card-header">🧾 Daftar Transaksi Bulan Ini</div>
            <div class="card-body p-0">
                <table class="table mb-0" style="font-size:12px">
                    <thead><tr><th class="ps-3">Kode</th><th>Pelanggan</th><th>Total</th><th>Laba</th><th>Status</th></tr></thead>
                    <tbody>
                        @forelse($transaksi as $t)
                        <tr>
                            <td class="ps-3" style="font-family:monospace">{{ $t->kode_transaksi }}</td>
                            <td>{{ $t->pelanggan?->nama ?? 'Umum' }}</td>
                            <td>Rp {{ number_format($t->total_harga,0,',','.') }}</td>
                            <td style="color:#10b981">Rp {{ number_format($t->laba_kotor,0,',','.') }}</td>
                            <td><span class="badge {{ $t->status_bayar=='lunas'?'badge-aman':'badge-menipis' }}" style="font-size:10px">{{ ucfirst($t->status_bayar) }}</span></td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center text-muted py-3">Belum ada transaksi</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
