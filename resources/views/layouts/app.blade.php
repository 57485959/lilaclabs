<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dadi Madu') — Sistem Pencatatan</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        :root { --madu: #f59e0b; --madu-dark: #d97706; --madu-light: #fef3c7; }
        body { background: #f8f9fa; font-family: 'Segoe UI', sans-serif; }
        .sidebar { width: 240px; min-height: 100vh; background: #1a1a2e; position: fixed; top: 0; left: 0; z-index: 100; }
        .sidebar-brand { padding: 20px; background: var(--madu); text-align: center; }
        .sidebar-brand h5 { color: #fff; font-weight: 700; margin: 0; font-size: 18px; letter-spacing: 1px; }
        .sidebar-brand small { color: rgba(255,255,255,.8); font-size: 11px; }
        .nav-section { padding: 12px 16px 4px; font-size: 10px; font-weight: 600; color: rgba(255,255,255,.3); text-transform: uppercase; letter-spacing: 1px; }
        .sidebar .nav-link { color: rgba(255,255,255,.65); padding: 9px 20px; display: flex; align-items: center; gap: 10px; font-size: 14px; transition: all .2s; text-decoration: none; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background: rgba(245,158,11,.15); color: var(--madu); border-right: 3px solid var(--madu); }
        .sidebar .nav-link i { width: 18px; text-align: center; }
        .main-content { margin-left: 240px; padding: 24px; min-height: 100vh; }
        .topbar { background: #fff; border-bottom: 1px solid #e9ecef; padding: 12px 24px; margin: -24px -24px 24px; display: flex; align-items: center; justify-content: space-between; }
        .page-title { font-size: 20px; font-weight: 600; color: #1a1a2e; margin: 0; }
        .card { border: none; box-shadow: 0 1px 4px rgba(0,0,0,.08); border-radius: 12px; }
        .card-header { background: #fff; border-bottom: 1px solid #f0f0f0; border-radius: 12px 12px 0 0 !important; padding: 16px 20px; font-weight: 600; }
        .btn-madu { background: var(--madu); color: #fff; border: none; }
        .btn-madu:hover { background: var(--madu-dark); color: #fff; }
        .badge-aman    { background: #d1fae5; color: #065f46; }
        .badge-menipis { background: #fef3c7; color: #92400e; }
        .badge-habis   { background: #fee2e2; color: #991b1b; }
        .stat-card { border-radius: 14px; padding: 20px; color: #fff; position: relative; overflow: hidden; }
        .stat-card .icon { font-size: 36px; opacity: .25; position: absolute; right: 16px; top: 12px; }
        .stat-card .label { font-size: 12px; opacity: .8; margin-bottom: 4px; }
        .stat-card .value { font-size: 22px; font-weight: 700; }
        .stat-card .sub { font-size: 11px; opacity: .75; margin-top: 2px; }
        .table th { font-size: 12px; font-weight: 600; color: #6c757d; text-transform: uppercase; letter-spacing: .5px; border-top: none; }
        .alert-success { background: #d1fae5; border: none; color: #065f46; border-radius: 10px; }
        .alert-danger  { background: #fee2e2; border: none; color: #991b1b; border-radius: 10px; }
    </style>
</head>
<body>
<div class="sidebar">
    <div class="sidebar-brand">
        <h5>🍯 DADI MADU</h5>
        <small>Sistem Pencatatan Bisnis</small>
    </div>
    <nav class="mt-2">
        <div class="nav-section">Menu Utama</div>
        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i>📊</i> Dashboard
        </a>

        <div class="nav-section">Pencatatan</div>
        <a href="{{ route('pembelian.index') }}" class="nav-link {{ request()->routeIs('pembelian.*') ? 'active' : '' }}">
            <i>📦</i> Pembelian Stok
        </a>
        <a href="{{ route('transaksi.index') }}" class="nav-link {{ request()->routeIs('transaksi.*') ? 'active' : '' }}">
            <i>🧾</i> Transaksi Penjualan
        </a>
        <a href="{{ route('pengeluaran.index') }}" class="nav-link {{ request()->routeIs('pengeluaran.*') ? 'active' : '' }}">
            <i>💸</i> Pengeluaran
        </a>

        <div class="nav-section">Laporan</div>
        <a href="{{ route('laporan.laba-rugi') }}" class="nav-link {{ request()->routeIs('laporan.laba-rugi') ? 'active' : '' }}">
            <i>📈</i> Laba Rugi
        </a>
        <a href="{{ route('laporan.stok') }}" class="nav-link {{ request()->routeIs('laporan.stok') ? 'active' : '' }}">
            <i>🗃️</i> Laporan Stok
        </a>
        <a href="{{ route('laporan.penjualan') }}" class="nav-link {{ request()->routeIs('laporan.penjualan') ? 'active' : '' }}">
            <i>📋</i> Laporan Penjualan
        </a>

        <div class="nav-section">Master Data</div>
        <a href="{{ route('produk.index') }}" class="nav-link {{ request()->routeIs('produk.*') ? 'active' : '' }}">
            <i>🍶</i> Produk
        </a>

        <div class="mt-4 px-3">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-sm w-100"
                    style="background:rgba(255,255,255,.1);color:rgba(255,255,255,.65);border:1px solid rgba(255,255,255,.15);">
                    🚪 Keluar
                </button>
            </form>
            <div class="text-center mt-2" style="font-size:11px;color:rgba(255,255,255,.3);">
                {{ auth()->user()->nama }}<br>
                <span style="text-transform:capitalize">{{ auth()->user()->role }}</span>
            </div>
        </div>
    </nav>
</div>

<div class="main-content">
    <div class="topbar">
        <h1 class="page-title">@yield('page-title','Dashboard')</h1>
        <div style="font-size:13px;color:#6c757d;">📅 {{ now()->isoFormat('dddd, D MMMM Y') }}</div>
    </div>

    @if(session('success'))
        <div class="alert alert-success mb-3">✅ {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger mb-3">❌ {{ session('error') }}</div>
    @endif

    @yield('content')
</div>
</body>
</html>
