@extends('layouts.app')
@section('title','Pelanggan')
@section('page-title','Pelanggan')
@section('content')

<div class="page-header">
    <h2>Daftar Pelanggan</h2>
</div>

<div class="search-box">
    <span class="search-icon">🔍</span>
    <input type="text" placeholder="Cari pelanggan..." id="searchInput" onkeyup="filterPelanggan()">
</div>

@forelse($pelanggan as $p)
<div class="pelanggan-card searchable" data-search="{{ strtolower($p->nama_pelanggan) }}">
    <div class="pelanggan-avatar">👤</div>
    <div class="pelanggan-info">
        <h4>{{ $p->nama_pelanggan }}</h4>
        <p>Transaksi Terakhir:
            @if($p->transaksi->count())
                {{ $p->transaksi->sortByDesc('create_at')->first()->tanggal_transaksi?->format('d M Y') }}
            @else
                -
            @endif
        </p>
        @if($p->no_hp)<p>📱 {{ $p->no_hp }}</p>@endif
    </div>
</div>
@empty
<div style="text-align:center;padding:40px 0;color:#9b8878">
    <div style="font-size:40px;margin-bottom:8px">👥</div>
    <p>Belum ada pelanggan</p>
</div>
@endforelse

<button class="fab" onclick="window.location='{{ route('pelanggan.create') }}'">+</button>

<script>
function filterPelanggan() {
    const q = document.getElementById('searchInput').value.toLowerCase();
    document.querySelectorAll('.searchable').forEach(el => {
        el.style.display = el.dataset.search.includes(q) ? '' : 'none';
    });
}
</script>
@endsection
