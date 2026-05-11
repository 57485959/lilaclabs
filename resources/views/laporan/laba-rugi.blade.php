@extends('layouts.app')
@section('title','Laporan Laba Rugi')
@section('page-title','Laporan')
@section('content')

<div style="display:flex;align-items:center;gap:10px;margin-bottom:16px">
    <a href="{{ route('laporan.index') }}" style="font-size:20px;color:#3d2b1a;text-decoration:none">←</a>
    <h2 style="font-size:18px;font-weight:700;color:#3d2b1a">Laporan Keuangan</h2>
</div>

<div class="card">
    <form method="GET" style="display:flex;gap:10px;align-items:flex-end">
        <div style="flex:1">
            <label class="form-label">Pilih Bulan</label>
            <input type="month" name="bulan" class="form-control" value="{{ $bulan }}">
        </div>
        <button type="submit" class="btn btn-amber">Tampilkan</button>
    </form>
</div>

{{-- Ringkasan --}}
<div class="stat-row">
    <div class="stat-card">
        <div class="stat-icon">💰</div>
        <div class="stat-label">Pendapatan</div>
        <div class="stat-value" style="font-size:15px">Rp {{ number_format($pendapatan,0,',','.') }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">📦</div>
        <div class="stat-label">Modal Stok</div>
        <div class="stat-value" style="font-size:15px">Rp {{ number_format($modal,0,',','.') }}</div>
    </div>
</div>
<div class="stat-row">
    <div class="stat-card">
        <div class="stat-icon">💸</div>
        <div class="stat-label">Pengeluaran</div>
        <div class="stat-value" style="font-size:15px;color:#ef4444">Rp {{ number_format($pengeluaran,0,',','.') }}</div>
    </div>
    <div class="stat-card" style="background:{{ $labaBersih>=0?'#f0fdf4':'#fff5f5' }}">
        <div class="stat-icon">📈</div>
        <div class="stat-label">Laba Bersih</div>
        <div class="stat-value" style="font-size:15px;color:{{ $labaBersih>=0?'#059669':'#dc2626' }}">
            Rp {{ number_format($labaBersih,0,',','.') }}
        </div>
    </div>
</div>

{{-- Rincian --}}
<div class="card">
    <p class="section-title">📊 Rincian Laporan</p>
    <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #e8ddd5;font-size:13px">
        <span style="color:#7a6152">Pendapatan Penjualan</span>
        <strong>Rp {{ number_format($pendapatan,0,',','.') }}</strong>
    </div>
    <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #e8ddd5;font-size:13px">
        <span style="color:#7a6152">( - ) Modal Pembelian Stok</span>
        <span style="color:#ef4444">Rp {{ number_format($modal,0,',','.') }}</span>
    </div>
    <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #e8ddd5;font-size:13px;font-weight:600">
        <span>Laba Kotor</span>
        <span style="color:#059669">Rp {{ number_format($labaKotor,0,',','.') }}</span>
    </div>
    <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #e8ddd5;font-size:13px">
        <span style="color:#7a6152">( - ) Total Pengeluaran</span>
        <span style="color:#ef4444">Rp {{ number_format($pengeluaran,0,',','.') }}</span>
    </div>
    <div style="display:flex;justify-content:space-between;padding:12px 0;font-size:16px;font-weight:700">
        <span>Laba Bersih</span>
        <span style="color:{{ $labaBersih>=0?'#059669':'#dc2626' }}">Rp {{ number_format($labaBersih,0,',','.') }}</span>
    </div>
</div>

{{-- Pengeluaran per kategori --}}
@if($rincianPengeluaran->count())
<div class="card">
    <p class="section-title">💸 Pengeluaran per Kategori</p>
    @foreach($rincianPengeluaran as $r)
    <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #e8ddd5;font-size:13px">
        <span>{{ $r->kategori }}</span>
        <span style="font-weight:600;color:#ef4444">Rp {{ number_format($r->total,0,',','.') }}</span>
    </div>
    @endforeach
</div>
@endif

{{-- Daftar Transaksi --}}
<div class="card">
    <p class="section-title">🧾 Transaksi Bulan Ini</p>
    @forelse($transaksi as $t)
    <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 0;border-bottom:1px solid #e8ddd5">
        <div>
            <div style="font-family:monospace;font-size:12px;font-weight:600;color:#5c3d1e">{{ $t->id_transaksi }}</div>
            <div style="font-size:11px;color:#7a6152">{{ $t->pelanggan?->nama_pelanggan ?? 'Umum' }}</div>
        </div>
        <div style="text-align:right">
            <div style="font-size:13px;font-weight:600;color:#d97706">Rp {{ number_format($t->grandtotal,0,',','.') }}</div>
            <span class="badge {{ $t->status_bayar=='Lunas'?'badge-green':'badge-amber' }}" style="font-size:10px">{{ $t->status_bayar }}</span>
        </div>
    </div>
    @empty
    <div style="text-align:center;color:#9b8878;padding:20px 0;font-size:13px">Belum ada transaksi</div>
    @endforelse
</div>

@endsection
