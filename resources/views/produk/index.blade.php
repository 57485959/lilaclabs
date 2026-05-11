@extends('layouts.app')
@section('title','Produk')
@section('page-title','Produk')
@section('content')

<div class="page-header">
    <h2>Produk</h2>
    <p>Kelola data produk madu Anda</p>
</div>

<div class="search-box">
    <span class="search-icon">🔍</span>
    <input type="text" placeholder="Cari produk..." id="searchInput" onkeyup="filterProduk()">
</div>

@forelse($produk as $p)
<div class="produk-card searchable" data-search="{{ strtolower($p->nama_produk) }}">
    <div class="produk-img">🍯</div>
    <div class="produk-info" style="flex:1">
        <h4>{{ $p->nama_produk }}</h4>
        <div class="produk-meta">
            Jenis: {{ $p->jenis_asal }} • {{ $p->ukuran_kemasan }}
        </div>
        <div class="produk-meta" style="margin-top:3px">
            Harga Jual: <strong>Rp {{ number_format($p->harga_jual,0,',','.') }}</strong>
        </div>
        <div class="produk-meta">
            Harga Modal: Rp {{ number_format($p->harga_modal,0,',','.') }}
        </div>
        <div class="produk-meta" style="margin-top:4px">
            Stok: <span class="badge badge-{{ $p->status_stok=='aman'?'green':($p->status_stok=='menipis'?'amber':'red') }}">{{ $p->stok }}</span>
        </div>
    </div>
    <div class="produk-actions" style="flex-direction:column">
        <a href="{{ route('produk.edit', $p->id_produk) }}" class="btn btn-outline" style="font-size:11px;padding:5px 10px;margin-bottom:5px">✏️</a>
        <form action="{{ route('produk.destroy', $p->id_produk) }}" method="POST" onsubmit="return confirm('Hapus produk ini?')">
            @csrf @method('DELETE')
            <button class="btn btn-danger" style="font-size:11px;padding:5px 10px">🗑️</button>
        </form>
    </div>
</div>
@empty
<div style="text-align:center;padding:40px 0;color:#9b8878">
    <div style="font-size:40px;margin-bottom:8px">🍶</div>
    <p>Belum ada produk</p>
</div>
@endforelse

<button class="fab" onclick="window.location='{{ route('produk.create') }}'">+</button>

<script>
function filterProduk() {
    const q = document.getElementById('searchInput').value.toLowerCase();
    document.querySelectorAll('.searchable').forEach(el => {
        el.style.display = el.dataset.search.includes(q) ? '' : 'none';
    });
}
</script>
@endsection
