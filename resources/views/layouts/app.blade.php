<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title','Dadi Madu') — Sistem Pencatatan</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        :root{
            --cream:#fdf6ee;
            --cream2:#f5ede0;
            --amber:#f59e0b;
            --amber-dark:#d97706;
            --brown:#5c3d1e;
            --brown-light:#8b6347;
            --text:#3d2b1a;
            --text2:#7a6152;
            --border:#e8ddd5;
            --white:#ffffff;
            --success:#10b981;
            --danger:#ef4444;
            --info:#6366f1;
        }
        body{font-family:'Segoe UI',sans-serif;background:var(--cream);color:var(--text);min-height:100vh}

        /* TOPBAR */
        .topbar{
            position:fixed;top:0;left:0;right:0;z-index:200;
            background:var(--white);
            padding:12px 20px;
            display:flex;align-items:center;justify-content:space-between;
            border-bottom:1px solid var(--border);
            box-shadow:0 1px 8px rgba(0,0,0,.06);
        }
        .topbar-left{display:flex;align-items:center;gap:12px}
        .btn-menu{
            background:none;border:none;cursor:pointer;
            padding:6px;border-radius:8px;
            font-size:20px;color:var(--brown);
            line-height:1;
        }
        .btn-menu:hover{background:var(--cream2)}
        .page-title-top{font-size:16px;font-weight:600;color:var(--text)}
        .topbar-right{display:flex;align-items:center;gap:10px}
        .user-name{font-size:13px;font-weight:600;color:var(--text);text-align:right;line-height:1.3}
        .user-role{font-size:11px;color:var(--text2)}
        .user-avatar{
            width:36px;height:36px;border-radius:50%;
            background:var(--amber);
            display:flex;align-items:center;justify-content:center;
            font-size:18px;
        }

        /* OVERLAY */
        .overlay{
            display:none;position:fixed;inset:0;z-index:300;
            background:rgba(0,0,0,.4);
        }
        .overlay.show{display:block}

        /* SIDEBAR */
        .sidebar{
            position:fixed;top:0;left:-280px;bottom:0;z-index:400;
            width:260px;background:var(--white);
            transition:left .28s ease;
            overflow-y:auto;
            box-shadow:4px 0 20px rgba(0,0,0,.12);
            display:flex;flex-direction:column;
        }
        .sidebar.open{left:0}
        .sidebar-brand{
            display:flex;align-items:center;gap:10px;
            padding:20px;
            border-bottom:1px solid var(--border);
        }
        .sidebar-brand .bee{font-size:32px}
        .sidebar-brand .brand-text h3{font-size:18px;font-weight:700;color:var(--brown)}
        .sidebar-brand .brand-text p{font-size:11px;color:var(--text2)}
        .nav-section{
            font-size:10px;font-weight:700;color:var(--text2);
            text-transform:uppercase;letter-spacing:.08em;
            padding:16px 20px 6px;
        }
        .nav-item{
            display:flex;align-items:center;gap:12px;
            padding:11px 20px;text-decoration:none;
            color:var(--text2);font-size:14px;font-weight:500;
            border-right:3px solid transparent;
            transition:all .15s;
        }
        .nav-item:hover{background:var(--cream2);color:var(--brown)}
        .nav-item.active{background:var(--cream2);color:var(--amber-dark);border-right-color:var(--amber)}
        .nav-item .nav-icon{font-size:18px;width:24px;text-align:center}
        .sidebar-footer{margin-top:auto;padding:16px 20px;border-top:1px solid var(--border)}
        .btn-logout{
            width:100%;background:var(--cream2);border:1.5px solid var(--border);
            border-radius:12px;padding:10px;font-size:14px;font-weight:600;
            color:var(--brown);cursor:pointer;
            display:flex;align-items:center;justify-content:center;gap:8px;
        }
        .btn-logout:hover{background:#fee2e2;color:var(--danger);border-color:#fca5a5}

        /* MAIN */
        .main{margin-top:64px;padding:20px;max-width:900px;margin-left:auto;margin-right:auto}

        /* CARDS */
        .card{background:var(--white);border-radius:16px;padding:20px;border:1px solid var(--border);margin-bottom:16px}
        .card-sm{background:var(--white);border-radius:14px;padding:16px;border:1px solid var(--border)}
        .section-title{font-size:16px;font-weight:700;color:var(--text);margin-bottom:12px}

        /* STAT CARDS */
        .stat-row{display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:16px}
        .stat-card{background:var(--white);border-radius:14px;padding:16px;border:1px solid var(--border)}
        .stat-card .stat-icon{font-size:24px;margin-bottom:6px}
        .stat-card .stat-label{font-size:12px;color:var(--text2);margin-bottom:4px}
        .stat-card .stat-value{font-size:18px;font-weight:700;color:var(--text)}
        .stat-card .stat-sub{font-size:11px;color:var(--text2);margin-top:2px}

        /* MENU CARD */
        .menu-card{
            display:flex;align-items:center;gap:14px;
            background:var(--white);border-radius:14px;padding:16px 18px;
            border:1px solid var(--border);margin-bottom:10px;
            text-decoration:none;color:var(--text);
            transition:box-shadow .15s,transform .15s;
        }
        .menu-card:hover{box-shadow:0 4px 16px rgba(0,0,0,.1);transform:translateY(-1px)}
        .menu-card .menu-icon{font-size:36px;flex-shrink:0}
        .menu-card .menu-info h4{font-size:15px;font-weight:700;color:var(--text);margin-bottom:2px}
        .menu-card .menu-info p{font-size:12px;color:var(--text2)}
        .menu-card .menu-arrow{margin-left:auto;color:var(--text2);font-size:18px}

        /* BADGES */
        .badge{font-size:11px;padding:3px 10px;border-radius:20px;font-weight:600}
        .badge-green{background:#d1fae5;color:#065f46}
        .badge-amber{background:#fef3c7;color:#92400e}
        .badge-red{background:#fee2e2;color:#991b1b}
        .badge-blue{background:#dbeafe;color:#1e40af}
        .badge-gray{background:var(--cream2);color:var(--text2)}

        /* BUTTONS */
        .btn{border:none;border-radius:12px;padding:10px 20px;font-size:14px;font-weight:600;cursor:pointer;transition:all .15s;display:inline-flex;align-items:center;gap:6px}
        .btn-amber{background:var(--amber);color:#fff}
        .btn-amber:hover{background:var(--amber-dark)}
        .btn-outline{background:var(--white);border:1.5px solid var(--border);color:var(--text)}
        .btn-outline:hover{background:var(--cream2)}
        .btn-danger{background:#fee2e2;color:var(--danger);border:1.5px solid #fca5a5}
        .btn-full{width:100%;justify-content:center;padding:13px}

        /* FAB */
        .fab{
            position:fixed;bottom:24px;right:24px;z-index:100;
            width:56px;height:56px;border-radius:50%;
            background:var(--amber);color:#fff;border:none;
            font-size:26px;cursor:pointer;
            box-shadow:0 4px 16px rgba(245,158,11,.4);
            display:flex;align-items:center;justify-content:center;
            transition:background .15s,transform .15s;
        }
        .fab:hover{background:var(--amber-dark);transform:scale(1.08)}

        /* FORMS */
        .form-group{margin-bottom:16px}
        .form-label{display:block;font-size:13px;font-weight:600;color:var(--text);margin-bottom:6px}
        .form-control{
            width:100%;border:1.5px solid var(--border);border-radius:12px;
            padding:11px 14px;font-size:14px;color:var(--text);
            background:var(--cream);outline:none;transition:border .2s;
        }
        .form-control:focus{border-color:var(--amber);background:var(--white)}
        .form-control::placeholder{color:var(--text2)}
        select.form-control{cursor:pointer}

        /* ALERTS */
        .alert{padding:12px 16px;border-radius:12px;font-size:13px;margin-bottom:16px}
        .alert-success{background:#d1fae5;color:#065f46}
        .alert-danger{background:#fee2e2;color:#991b1b}

        /* TABLE */
        .table-card{background:var(--white);border-radius:16px;border:1px solid var(--border);overflow:hidden;margin-bottom:16px}
        .table-card table{width:100%;border-collapse:collapse}
        .table-card th{font-size:11px;font-weight:700;color:var(--text2);text-transform:uppercase;letter-spacing:.05em;padding:12px 16px;background:var(--cream);border-bottom:1px solid var(--border)}
        .table-card td{font-size:13px;padding:12px 16px;border-bottom:1px solid var(--border);color:var(--text)}
        .table-card tr:last-child td{border-bottom:none}
        .table-card tr:hover td{background:var(--cream)}

        /* TRANSAKSI CARD */
        .trx-card{background:var(--white);border-radius:14px;padding:16px;border:1px solid var(--border);margin-bottom:10px}
        .trx-row{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:6px}
        .trx-id{font-family:monospace;font-size:13px;font-weight:700;color:var(--brown)}
        .trx-actions{display:flex;gap:8px;margin-top:10px}
        .trx-detail{font-size:12px;color:var(--text2);display:flex;gap:16px;flex-wrap:wrap}
        .trx-detail span{display:flex;align-items:center;gap:4px}

        /* PRODUK CARD */
        .produk-card{background:var(--white);border-radius:14px;padding:14px;border:1px solid var(--border);display:flex;align-items:center;gap:14px;margin-bottom:10px}
        .produk-img{width:56px;height:56px;border-radius:12px;background:var(--cream2);display:flex;align-items:center;justify-content:center;font-size:28px;flex-shrink:0}
        .produk-info h4{font-size:14px;font-weight:700;color:var(--text);margin-bottom:3px}
        .produk-info .produk-meta{font-size:12px;color:var(--text2)}
        .produk-actions{margin-left:auto;display:flex;gap:6px}

        /* PELANGGAN CARD */
        .pelanggan-card{background:var(--white);border-radius:14px;padding:14px;border:1px solid var(--border);display:flex;align-items:center;gap:12px;margin-bottom:10px;text-decoration:none}
        .pelanggan-avatar{width:48px;height:48px;border-radius:50%;background:var(--cream2);display:flex;align-items:center;justify-content:center;font-size:24px;flex-shrink:0}
        .pelanggan-info h4{font-size:14px;font-weight:600;color:var(--text)}
        .pelanggan-info p{font-size:12px;color:var(--text2)}

        /* SEARCH */
        .search-box{position:relative;margin-bottom:16px}
        .search-box input{width:100%;border:1.5px solid var(--border);border-radius:12px;padding:10px 14px 10px 40px;font-size:14px;background:var(--white);outline:none;color:var(--text)}
        .search-box input:focus{border-color:var(--amber)}
        .search-icon{position:absolute;left:13px;top:50%;transform:translateY(-50%);font-size:16px;color:var(--text2)}

        /* HEADER SECTION */
        .page-header{background:linear-gradient(135deg,var(--cream2),var(--cream));border-radius:16px;padding:20px;margin-bottom:16px;border:1px solid var(--border)}
        .page-header h2{font-size:22px;font-weight:700;color:var(--text);margin-bottom:4px}
        .page-header p{font-size:13px;color:var(--text2)}
    </style>
</head>
<body>

{{-- TOPBAR --}}
<div class="topbar">
    <div class="topbar-left">
        <button class="btn-menu" onclick="toggleSidebar()" id="menuBtn">☰</button>
        <span class="page-title-top">@yield('page-title','Dashboard')</span>
    </div>
    <div class="topbar-right">
        <div>
            <div class="user-name">{{ auth()->user()->nama }}</div>
            <div class="user-role" style="text-align:right;text-transform:capitalize">{{ auth()->user()->role }}</div>
        </div>
        <div class="user-avatar">👤</div>
    </div>
</div>

{{-- OVERLAY --}}
<div class="overlay" id="overlay" onclick="closeSidebar()"></div>

{{-- SIDEBAR --}}
<div class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <span class="bee">🐝</span>
        <div class="brand-text">
            <h3>DadiMadu</h3>
            <p>Sistem Pencatatan</p>
        </div>
    </div>

    <nav style="flex:1">
        <div class="nav-section">Menu Utama</div>
        <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}" onclick="closeSidebar()">
            <span class="nav-icon">🏠</span> Beranda
        </a>

        <div class="nav-section">Pencatatan</div>
        <a href="{{ route('transaksi.index') }}" class="nav-item {{ request()->routeIs('transaksi.*') ? 'active' : '' }}" onclick="closeSidebar()">
            <span class="nav-icon">🧾</span> Transaksi
        </a>
        <a href="{{ route('produk.index') }}" class="nav-item {{ request()->routeIs('produk.*') ? 'active' : '' }}" onclick="closeSidebar()">
            <span class="nav-icon">🍶</span> Produk
        </a>
        <a href="{{ route('pelanggan.index') }}" class="nav-item {{ request()->routeIs('pelanggan.*') ? 'active' : '' }}" onclick="closeSidebar()">
            <span class="nav-icon">👥</span> Pelanggan
        </a>
        <a href="{{ route('pembelian.index') }}" class="nav-item {{ request()->routeIs('pembelian.*') ? 'active' : '' }}" onclick="closeSidebar()">
            <span class="nav-icon">📦</span> Pembelian Stok
        </a>
        <a href="{{ route('pengeluaran.index') }}" class="nav-item {{ request()->routeIs('pengeluaran.*') ? 'active' : '' }}" onclick="closeSidebar()">
            <span class="nav-icon">💸</span> Pengeluaran
        </a>

        <div class="nav-section">Laporan</div>
        <a href="{{ route('laporan.index') }}" class="nav-item {{ request()->routeIs('laporan.*') ? 'active' : '' }}" onclick="closeSidebar()">
            <span class="nav-icon">📊</span> Laporan
        </a>

        <div class="nav-section">Pengaturan</div>
        <a href="{{ route('pengaturan.index') }}" class="nav-item {{ request()->routeIs('pengaturan.*') ? 'active' : '' }}" onclick="closeSidebar()">
            <span class="nav-icon">⚙️</span> Pengaturan
        </a>
    </nav>

    <div class="sidebar-footer">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-logout">🚪 Keluar</button>
        </form>
    </div>
</div>

{{-- MAIN CONTENT --}}
<div class="main">
    @if(session('success'))
        <div class="alert alert-success">✅ {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">❌ {{ session('error') }}</div>
    @endif

    @yield('content')
</div>

<script>
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('open');
    document.getElementById('overlay').classList.toggle('show');
}
function closeSidebar() {
    document.getElementById('sidebar').classList.remove('open');
    document.getElementById('overlay').classList.remove('show');
}
</script>
</body>
</html>
