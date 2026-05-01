@extends('layouts.app')
@section('title','Edit Produk')
@section('page-title','Edit Produk')
@section('content')

<div class="row justify-content-center">
<div class="col-md-6">
<div class="card">
    <div class="card-header">✏️ Edit Produk: {{ $produk->nama_produk }}</div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger mb-3">{{ $errors->first() }}</div>
        @endif
        <form action="{{ route('produk.update', $produk->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Produk</label>
                <input type="text" name="nama_produk" class="form-control"
                       value="{{ old('nama_produk', $produk->nama_produk) }}" required>
            </div>
            <div class="row mb-3">
                <div class="col-6">
                    <label class="form-label fw-semibold">Satuan</label>
                    <select name="satuan" class="form-select" required>
                        @foreach(['botol','kg','liter','pcs'] as $s)
                        <option value="{{ $s }}" {{ old('satuan',$produk->satuan)==$s ? 'selected':'' }}>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6">
                    <label class="form-label fw-semibold">Stok Minimum</label>
                    <input type="number" name="stok_minimum" class="form-control"
                           min="0" value="{{ old('stok_minimum', $produk->stok_minimum) }}" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-6">
                    <label class="form-label fw-semibold">Harga Jual (Rp)</label>
                    <input type="number" name="harga_jual" class="form-control"
                           min="0" value="{{ old('harga_jual', $produk->harga_jual) }}" required>
                </div>
                <div class="col-6">
                    <label class="form-label fw-semibold">Harga Beli / HPP (Rp)</label>
                    <input type="number" name="harga_beli" class="form-control"
                           min="0" value="{{ old('harga_beli', $produk->harga_beli) }}" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Status</label>
                <select name="status" class="form-select">
                    <option value="aktif"    {{ old('status',$produk->status)=='aktif'?'selected':'' }}>Aktif</option>
                    <option value="nonaktif" {{ old('status',$produk->status)=='nonaktif'?'selected':'' }}>Nonaktif</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold">Deskripsi <span class="text-muted">(opsional)</span></label>
                <textarea name="deskripsi" class="form-control" rows="2">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
            </div>
            <div class="mb-3 p-3 rounded-3" style="background:#fef3c7">
                <small class="text-muted">Stok saat ini</small>
                <div style="font-size:20px;font-weight:700;color:#d97706">{{ $produk->stok }} {{ $produk->satuan }}</div>
                <small class="text-muted" style="font-size:11px">*Stok hanya bisa diubah lewat menu Stok Masuk</small>
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
