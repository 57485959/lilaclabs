@extends('layouts.app')
@section('title','Edit Produk')
@section('page-title','Edit Produk')
@section('content')
<div class="row justify-content-center">
<div class="col-md-6">
<div class="card">
    <div class="card-header">✏️ Edit: {{ $produk->nama_produk }}</div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger mb-3">{{ $errors->first() }}</div>
        @endif
        <form action="{{ route('produk.update', $produk->id_produk) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Produk</label>
                <input type="text" name="nama_produk" class="form-control" value="{{ old('nama_produk', $produk->nama_produk) }}" required>
            </div>
            <div class="row mb-3">
                <div class="col-6">
                    <label class="form-label fw-semibold">Jenis Asal</label>
                    <select name="jenis_asal" class="form-select" required>
                        <option value="Supplier" {{ old('jenis_asal',$produk->jenis_asal)=='Supplier'?'selected':'' }}>🏭 Supplier</option>
                        <option value="Ternak"   {{ old('jenis_asal',$produk->jenis_asal)=='Ternak'?'selected':'' }}>🐝 Ternak Sendiri</option>
                    </select>
                </div>
                <div class="col-6">
                    <label class="form-label fw-semibold">Ukuran Kemasan</label>
                    <input type="text" name="ukuran_kemasan" class="form-control" value="{{ old('ukuran_kemasan', $produk->ukuran_kemasan) }}" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-6">
                    <label class="form-label fw-semibold">Harga Jual (Rp)</label>
                    <input type="number" name="harga_jual" class="form-control" min="0" value="{{ old('harga_jual', $produk->harga_jual) }}" required>
                </div>
                <div class="col-6">
                    <label class="form-label fw-semibold">Harga Modal (Rp)</label>
                    <input type="number" name="harga_modal" class="form-control" min="0" value="{{ old('harga_modal', $produk->harga_modal) }}" required>
                </div>
            </div>
            <div class="mb-3 p-3 rounded-3" style="background:#fef3c7">
                <small class="text-muted">Stok saat ini</small>
                <div style="font-size:20px;font-weight:700;color:#d97706">{{ $produk->stok }}</div>
                <small class="text-muted" style="font-size:11px">*Stok hanya bisa ditambah lewat menu Pembelian Stok</small>
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold">Minimum Stok</label>
                <input type="number" name="minimum_stok" class="form-control" min="0" value="{{ old('minimum_stok', $produk->minimum_stok) }}" required>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-madu px-4">💾 Simpan Perubahan</button>
                <a href="{{ route('produk.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
</div>
</div>
@endsection
