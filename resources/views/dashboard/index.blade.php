@extends('layouts.app')
@section('title','Beranda')
@section('page-title','Beranda')
@section('content')

{{-- Welcome Banner --}}
<div style="background:linear-gradient(135deg,#f5ede0,#fdf6ee);border-radius:16px;padding:20px;margin-bottom:16px;border:1px solid #e8ddd5;display:flex;align-items:center;justify-content:space-between">
    <div>
        <p style="font-size:13px;color:#7a6152;margin-bottom:4px">Selamat Datang di</p>
        <h2 style="font-size:24px;font-weight:700;color:#3d2b1a">DadiMadu 🍯</h2>
    </div>
    <span style="font-size:52px">🐝</span>
</div>

{{-- Overview --}}
<p class="section-title">Overview</p>
<div class="stat-row">
    <div class="stat-card">
        <div class="stat-icon">🍀</div>
        <div class="stat-label">Total Pemasukan</div>
        <div class="stat-value" style="font-size:16px">Rp {{ number_format($penjualanBulanIni,0,',','.') }}</div>
        <div class="stat-sub">Bulan ini</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">🍂</div>
        <div class="stat-label">Total Pengeluaran</div>
        <div class="stat-value" style="font-size:16px">Rp {{ number_format($pengeluaranBulan,0,',','.') }}</div>
        <div class="stat-sub">Bulan ini</div>
    </div>
</div>

{{-- Operasional --}}
<p class="section-title">Operasional</p>

<a href="{{ route('transaksi.index') }}" class="menu-card">
    <span class="menu-icon">🧾</span>
    <div class="menu-info">
        <h4>Kasir</h4>
        <p>Kelola transaksi dengan mudah</p>
    </div>
    <span class="menu-arrow">›</span>
</a>

<a href="{{ route('produk.index') }}" class="menu-card">
    <span class="menu-icon">📦</span>
    <div class="menu-info">
        <h4>Produk</h4>
        <p>Kelola data madu anda.</p>
    </div>
    <span class="menu-arrow">›</span>
</a>

<a href="{{ route('pelanggan.index') }}" class="menu-card">
    <span class="menu-icon">👥</span>
    <div class="menu-info">
        <h4>Pelanggan</h4>
        <p>Kelola data pelanggan.</p>
    </div>
    <span class="menu-arrow">›</span>
</a>

<a href="{{ route('laporan.index') }}" class="menu-card">
    <span class="menu-icon">📊</span>
    <div class="menu-info">
        <h4>Laporan</h4>
        <p>Lihat laporan penjualan, keuangan, dan stok.</p>
    </div>
    <span class="menu-arrow">›</span>
</a>

{{-- Peringatan Stok --}}
@if($peringatanStok->count())
<p class="section-title" style="margin-top:8px">⚠️ Stok Perlu Restok</p>
@foreach($peringatanStok as $p)
<div style="background:#fff;border-radius:14px;padding:14px 16px;border:1px solid #fca5a5;margin-bottom:8px;display:flex;justify-content:space-between;align-items:center">
    <div>
        <div style="font-size:14px;font-weight:600;color:#3d2b1a">{{ $p->nama_produk }}</div>
        <div style="font-size:12px;color:#7a6152">{{ $p->ukuran_kemasan }}</div>
    </div>
    <span class="badge badge-red">Stok: {{ $p->stok }}</span>
</div>
@endforeach
@endif

@endsection
