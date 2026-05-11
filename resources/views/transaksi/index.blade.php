@extends('layouts.app')
@section('title','Kasir')
@section('page-title','Kasir')
@section('content')

<div class="page-header">
    <h2>Kasir</h2>
    <p>Kelola data transaksi penjualan madu Anda</p>
</div>

<div class="search-box">
    <span class="search-icon">🔍</span>
    <input type="text" placeholder="Cari pelanggan, ID transaksi, ..." id="searchInput" onkeyup="filterTrx()">
</div>

<p class="section-title">Daftar Transaksi</p>

<div id="trxList">
@forelse($transaksi as $i => $t)
<div class="trx-card searchable" data-search="{{ strtolower($t->id_transaksi . ' ' . ($t->pelanggan?->nama_pelanggan ?? '')) }}">
    <div class="trx-row">
        <div>
            <div class="trx-id">{{ $t->id_transaksi }}</div>
            <div class="trx-detail" style="margin-top:6px">
                <span>👤 {{ $t->pelanggan?->nama_pelanggan ?? 'Umum' }}</span>
                <span>📅 {{ $t->tanggal_transaksi?->format('d M Y') }}</span>
            </div>
        </div>
        <span class="badge {{ $t->status_bayar=='Lunas'?'badge-green':($t->status_bayar=='DP'?'badge-amber':'badge-red') }}">
            {{ $t->status_bayar }}
        </span>
    </div>
    <div style="display:flex;justify-content:space-between;align-items:center;margin-top:8px">
        <div>
            <div style="font-size:12px;color:#7a6152">Total Harga</div>
            <div style="font-size:16px;font-weight:700;color:#d97706">Rp {{ number_format($t->grandtotal,0,',','.') }}</div>
        </div>
        <div style="font-size:12px;color:#7a6152">{{ ucfirst($t->metode_bayar) }}</div>
    </div>
    <div class="trx-actions">
        <a href="{{ route('transaksi.show', $t->id_transaksi) }}" class="btn btn-outline" style="font-size:12px;padding:7px 14px">✏️ Detail</a>
        <a href="{{ route('transaksi.cetak', $t->id_transaksi) }}" class="btn btn-outline" style="font-size:12px;padding:7px 14px" target="_blank">🖨️ Cetak</a>
    </div>
</div>
@empty
<div style="text-align:center;padding:40px 0;color:#9b8878">
    <div style="font-size:40px;margin-bottom:8px">🧾</div>
    <p>Belum ada transaksi</p>
</div>
@endforelse
</div>

@if(isset($transaksi) && method_exists($transaksi, 'hasPages') && $transaksi->hasPages())
<div style="margin-top:8px">{{ $transaksi->links() }}</div>
@endif

<button class="fab" onclick="window.location='{{ route('transaksi.create') }}'">+</button>

<script>
function filterTrx() {
    const q = document.getElementById('searchInput').value.toLowerCase();
    document.querySelectorAll('.searchable').forEach(el => {
        el.style.display = el.dataset.search.includes(q) ? 'block' : 'none';
    });
}
</script>
@endsection
