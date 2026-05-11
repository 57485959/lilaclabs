@extends('layouts.app')
@section('title','Laporan')
@section('page-title','Laporan')
@section('content')

{{-- Summary Stats --}}
<div class="stat-row">
    <div class="stat-card">
        <div class="stat-icon">🍀</div>
        <div class="stat-label">Total Pemasukan</div>
        <div class="stat-value">Rp {{ number_format($pendapatan,0,',','.') }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">🍂</div>
        <div class="stat-label">Total Pengeluaran</div>
        <div class="stat-value">Rp {{ number_format($totalPengeluaran,0,',','.') }}</div>
    </div>
</div>
<div class="stat-row">
    <div class="stat-card">
        <div class="stat-icon">💰</div>
        <div class="stat-label">Laba Bersih</div>
        <div class="stat-value" style="color:{{ $labaBersih>=0?'#059669':'#dc2626' }}">
            Rp {{ number_format($labaBersih,0,',','.') }}
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">📈</div>
        <div class="stat-label">Profit Margin</div>
        <div class="stat-value">
            {{ $pendapatan > 0 ? number_format(($labaBersih/$pendapatan)*100,2) : 0 }}%
        </div>
    </div>
</div>

{{-- Pilih Bulan --}}
<div class="card">
    <form method="GET" style="display:flex;gap:10px;align-items:flex-end">
        <div style="flex:1">
            <label class="form-label">Pilih Bulan</label>
            <input type="month" name="bulan" class="form-control" value="{{ $bulan }}">
        </div>
        <button type="submit" class="btn btn-amber">Tampilkan</button>
    </form>
</div>

{{-- Grafik Ringkasan --}}
<div class="card">
    <p class="section-title">Grafik Ringkasan Keuangan</p>
    <canvas id="chartLaporan" height="200"></canvas>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-top:12px">
        <div style="font-size:12px;color:#7a6152">● Pemasukan<br><strong>Rp {{ number_format($pendapatan,0,',','.') }}</strong></div>
        <div style="font-size:12px;color:#7a6152">● Pengeluaran<br><strong>Rp {{ number_format($totalPengeluaran,0,',','.') }}</strong></div>
        <div style="font-size:12px;color:#7a6152">● Laba Bersih<br><strong>Rp {{ number_format($labaBersih,0,',','.') }}</strong></div>
        <div style="font-size:12px;color:#7a6152">● Margin Profit<br><strong>{{ $pendapatan > 0 ? number_format(($labaBersih/$pendapatan)*100,2) : 0 }}%</strong></div>
    </div>
</div>

{{-- Menu Laporan --}}
<p class="section-title">Jenis Laporan</p>

<a href="{{ route('laporan.laba-rugi') }}" class="menu-card">
    <span class="menu-icon" style="background:#d1fae5;border-radius:12px;padding:8px;font-size:28px">💰</span>
    <div class="menu-info">
        <h4>Laporan Keuangan</h4>
        <p>Rincian pemasukan, pengeluaran, laba, dan arus kas bisnis.</p>
    </div>
    <span class="menu-arrow">›</span>
</a>

<a href="{{ route('laporan.stok') }}" class="menu-card">
    <span class="menu-icon" style="background:#fef3c7;border-radius:12px;padding:8px;font-size:28px">📦</span>
    <div class="menu-info">
        <h4>Laporan Stok Produk</h4>
        <p>Informasi stok produk dan stok habis.</p>
    </div>
    <span class="menu-arrow">›</span>
</a>

<a href="{{ route('laporan.penjualan') }}" class="menu-card">
    <span class="menu-icon" style="background:#ede9fe;border-radius:12px;padding:8px;font-size:28px">🧾</span>
    <div class="menu-info">
        <h4>Laporan Transaksi</h4>
        <p>Informasi daftar transaksi penjualan.</p>
    </div>
    <span class="menu-arrow">›</span>
</a>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<script>
const ctx = document.getElementById('chartLaporan').getContext('2d');
new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ['Pemasukan', 'Pengeluaran', 'Laba Bersih'],
        datasets: [{
            data: [{{ $pendapatan }}, {{ $totalPengeluaran }}, {{ max(0,$labaBersih) }}],
            backgroundColor: ['#10b981','#ef4444','#f59e0b'],
            borderWidth: 2,
            borderColor: '#fff',
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false },
            tooltip: {
                callbacks: {
                    label: ctx => 'Rp ' + ctx.raw.toLocaleString('id-ID')
                }
            }
        }
    }
});
</script>
@endsection
