@extends('layouts.app')
@section('title','Dashboard')
@section('page-title','Dashboard')
@section('content')

<div class="row g-3 mb-4">
    <div class="col-md-3 col-6">
        <div class="stat-card" style="background:linear-gradient(135deg,#f59e0b,#d97706)">
            <div class="icon">💰</div>
            <div class="label">Penjualan Hari Ini</div>
            <div class="value">Rp {{ number_format($penjualanHariIni,0,',','.') }}</div>
            <div class="sub">{{ $totalTransaksi }} transaksi</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stat-card" style="background:linear-gradient(135deg,#10b981,#059669)">
            <div class="icon">📈</div>
            <div class="label">Estimasi Laba Hari Ini</div>
            <div class="value">Rp {{ number_format($labaHariIni,0,',','.') }}</div>
            <div class="sub">Pendapatan - Modal - Biaya</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stat-card" style="background:linear-gradient(135deg,#ef4444,#dc2626)">
            <div class="icon">💸</div>
            <div class="label">Pengeluaran Hari Ini</div>
            <div class="value">Rp {{ number_format($pengeluaranHariIni,0,',','.') }}</div>
            <div class="sub">Botol, Label, Segel, Madu</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stat-card" style="background:linear-gradient(135deg,#6366f1,#4f46e5)">
            <div class="icon">📅</div>
            <div class="label">Laba Bersih Bulan Ini</div>
            <div class="value">Rp {{ number_format($labaBersihBulan,0,',','.') }}</div>
            <div class="sub">Pendapatan: Rp {{ number_format($penjualanBulanIni,0,',','.') }}</div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header">🗃️ Status Stok Produk</div>
            <div class="card-body">
                <div class="d-flex justify-content-around text-center mb-3">
                    <div>
                        <div style="font-size:28px;font-weight:700;color:#10b981">{{ $stokAman }}</div>
                        <div style="font-size:12px;color:#6c757d">Aman</div>
                    </div>
                    <div>
                        <div style="font-size:28px;font-weight:700;color:#f59e0b">{{ $stokMenipis }}</div>
                        <div style="font-size:12px;color:#6c757d">Menipis</div>
                    </div>
                    <div>
                        <div style="font-size:28px;font-weight:700;color:#ef4444">{{ $stokHabis }}</div>
                        <div style="font-size:12px;color:#6c757d">Habis</div>
                    </div>
                </div>
                @if($peringatanStok->count())
                    <div style="font-size:12px;font-weight:600;color:#6c757d;margin-bottom:8px">⚠️ Perlu Restok</div>
                    @foreach($peringatanStok as $p)
                    <div class="d-flex justify-content-between align-items-center py-1 border-bottom">
                        <span style="font-size:13px">{{ $p->nama_produk }}</span>
                        <span class="badge {{ $p->stok == 0 ? 'badge-habis' : 'badge-menipis' }}" style="font-size:11px">
                            {{ $p->stok }}
                        </span>
                    </div>
                    @endforeach
                @else
                    <div class="text-center text-muted py-3" style="font-size:13px">✅ Semua stok aman</div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header">💸 Pengeluaran Bulan Ini per Kategori</div>
            <div class="card-body p-0">
                @forelse($pengeluaranKategori as $k)
                <div class="d-flex justify-content-between align-items-center px-3 py-2 border-bottom" style="font-size:13px">
                    <span>{{ $k->kategori }}</span>
                    <span class="fw-semibold text-danger">Rp {{ number_format($k->total,0,',','.') }}</span>
                </div>
                @empty
                <div class="text-center text-muted py-3" style="font-size:13px">Belum ada pengeluaran</div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                🧾 Transaksi Terbaru
                <a href="{{ route('transaksi.index') }}" style="font-size:12px;color:#f59e0b">Lihat semua →</a>
            </div>
            <div class="card-body p-0">
                @forelse($transaksiTerbaru as $t)
                <div class="px-3 py-2 border-bottom">
                    <div class="d-flex justify-content-between">
                        <span style="font-size:12px;font-family:monospace">{{ $t->id_transaksi }}</span>
                        <span class="badge {{ $t->status_bayar=='Lunas' ? 'badge-aman' : 'badge-menipis' }}" style="font-size:10px">{{ $t->status_bayar }}</span>
                    </div>
                    <div class="d-flex justify-content-between mt-1">
                        <span style="font-size:12px;color:#6c757d">{{ $t->pelanggan?->nama_pelanggan ?? 'Umum' }}</span>
                        <span style="font-size:13px;font-weight:600;color:#d97706">Rp {{ number_format($t->grandtotal,0,',','.') }}</span>
                    </div>
                </div>
                @empty
                <div class="text-center text-muted py-3" style="font-size:13px">Belum ada transaksi</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">⚡ Aksi Cepat</div>
    <div class="card-body">
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('transaksi.create') }}" class="btn btn-madu">🧾 Catat Penjualan</a>
            <a href="{{ route('pembelian.create') }}" class="btn btn-outline-warning">📦 Catat Pembelian Stok</a>
            <a href="{{ route('pengeluaran.create') }}" class="btn btn-outline-danger">💸 Catat Pengeluaran</a>
            <a href="{{ route('laporan.laba-rugi') }}" class="btn btn-outline-secondary">📈 Lihat Laba Rugi</a>
        </div>
    </div>
</div>
@endsection
