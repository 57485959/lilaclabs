@extends('layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="row g-3 mb-4">
    {{-- Stat Cards --}}
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
            <div class="label">Laba Hari Ini</div>
            <div class="value">Rp {{ number_format($labaHariIni,0,',','.') }}</div>
            <div class="sub">Setelah modal</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stat-card" style="background:linear-gradient(135deg,#ef4444,#dc2626)">
            <div class="icon">💸</div>
            <div class="label">Pengeluaran Hari Ini</div>
            <div class="value">Rp {{ number_format($pengeluaranHariIni,0,',','.') }}</div>
            <div class="sub">Biaya operasional</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stat-card" style="background:linear-gradient(135deg,#6366f1,#4f46e5)">
            <div class="icon">📅</div>
            <div class="label">Laba Bersih Bulan Ini</div>
            <div class="value @if($labaBersihBulan < 0) text-warning @endif">
                Rp {{ number_format($labaBersihBulan,0,',','.') }}
            </div>
            <div class="sub">Pendapatan: Rp {{ number_format($penjualanBulanIni,0,',','.') }}</div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    {{-- Status Stok --}}
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
                    <div style="font-size:12px;font-weight:600;color:#6c757d;margin-bottom:8px;">⚠️ Perlu Restok</div>
                    @foreach($peringatanStok as $p)
                    <div class="d-flex justify-content-between align-items-center py-1 border-bottom">
                        <span style="font-size:13px">{{ $p->nama_produk }}</span>
                        <span class="badge {{ $p->stok == 0 ? 'badge-habis' : 'badge-menipis' }}" style="font-size:11px">
                            {{ $p->stok }} {{ $p->satuan }}
                        </span>
                    </div>
                    @endforeach
                @else
                    <div class="text-center text-muted" style="font-size:13px;padding:12px 0">✅ Semua stok aman</div>
                @endif
            </div>
        </div>
    </div>

    {{-- Transaksi Terbaru --}}
    <div class="col-md-8">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                🧾 Transaksi Terbaru
                <a href="{{ route('penjualan.index') }}" style="font-size:12px;color:#f59e0b;">Lihat semua →</a>
            </div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th class="ps-3">Kode</th>
                            <th>Pelanggan</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transaksiTerbaru as $t)
                        <tr>
                            <td class="ps-3" style="font-size:12px;font-family:monospace">{{ $t->kode_transaksi }}</td>
                            <td style="font-size:13px">{{ $t->pelanggan?->nama ?? 'Umum' }}</td>
                            <td style="font-size:13px;font-weight:600">Rp {{ number_format($t->total_harga,0,',','.') }}</td>
                            <td>
                                <span class="badge {{ $t->status_bayar == 'lunas' ? 'badge-aman' : 'badge-menipis' }}" style="font-size:11px">
                                    {{ ucfirst($t->status_bayar) }}
                                </span>
                            </td>
                            <td style="font-size:12px;color:#6c757d">{{ $t->tanggal->format('d/m/Y') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">Belum ada transaksi</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Quick Actions --}}
<div class="card">
    <div class="card-header">⚡ Aksi Cepat</div>
    <div class="card-body">
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('penjualan.create') }}" class="btn btn-madu">🧾 Catat Penjualan</a>
            <a href="{{ route('stok.create') }}" class="btn btn-outline-warning">📦 Catat Stok Masuk</a>
            <a href="{{ route('pengeluaran.create') }}" class="btn btn-outline-danger">💸 Catat Pengeluaran</a>
            <a href="{{ route('laporan.laba-rugi') }}" class="btn btn-outline-secondary">📈 Lihat Laba Rugi</a>
        </div>
    </div>
</div>
@endsection
