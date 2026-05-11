@extends('layouts.app')
@section('title','Edit Produk')
@section('page-title','Produk')
@section('content')

<div style="display:flex;align-items:center;gap:10px;margin-bottom:16px">
    <a href="{{ route('produk.index') }}" style="font-size:20px;color:#3d2b1a;text-decoration:none">←</a>
    <h2 style="font-size:18px;font-weight:700;color:#3d2b1a">Edit Produk</h2>
</div>

<div class="card">
    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif
    <form action="{{ route('produk.update', $produk->id_produk) }}" method="POST">
        @csrf @method('PUT')

        <div class="form-group">
            <label class="form-label">Nama Produk</label>
            <input type="text" name="nama_produk" class="form-control"
                   value="{{ old('nama_produk', $produk->nama_produk) }}" required>
        </div>

        <div class="form-group">
            <label class="form-label">Jenis Produk</label>
            <select name="jenis_asal" class="form-control" required>
                <option value="Supplier" {{ old('jenis_asal',$produk->jenis_asal)=='Supplier'?'selected':'' }}>🏭 Supplier</option>
                <option value="Ternak"   {{ old('jenis_asal',$produk->jenis_asal)=='Ternak'?'selected':'' }}>🐝 Ternak Sendiri</option>
            </select>
        </div>

        <div class="form-group">
            <label class="form-label">Ukuran Kemasan</label>
            <input type="text" name="ukuran_kemasan" class="form-control"
                   value="{{ old('ukuran_kemasan', $produk->ukuran_kemasan) }}" required>
        </div>

        <div class="form-group">
            <label class="form-label">Harga Jual</label>
            <div style="position:relative">
                <span style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#7a6152;font-size:13px">Rp</span>
                <input type="number" name="harga_jual" class="form-control"
                       style="padding-left:36px" min="0"
                       value="{{ old('harga_jual', $produk->harga_jual) }}" required>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Harga Modal</label>
            <div style="position:relative">
                <span style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#7a6152;font-size:13px">Rp</span>
                <input type="number" name="harga_modal" class="form-control"
                       style="padding-left:36px" min="0"
                       value="{{ old('harga_modal', $produk->harga_modal) }}" required>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Minimum Stok</label>
            <input type="number" name="minimum_stok" class="form-control"
                   min="0" value="{{ old('minimum_stok', $produk->minimum_stok) }}" required>
            <small style="font-size:11px;color:#9b8878">Batas peringatan stok menipis</small>
        </div>

        {{-- Info stok --}}
        <div style="background:#fef3c7;border-radius:12px;padding:12px 14px;margin-bottom:16px">
            <div style="font-size:12px;color:#92400e;font-weight:600;margin-bottom:2px">Stok Saat Ini</div>
            <div style="font-size:20px;font-weight:700;color:#d97706">{{ $produk->stok }}</div>
            <div style="font-size:11px;color:#9b8878;margin-top:2px">*Stok hanya bisa ditambah lewat menu Pembelian Stok</div>
        </div>

        <div style="display:flex;gap:10px">
            <a href="{{ route('produk.index') }}" class="btn btn-outline" style="flex:1;justify-content:center">Batal</a>
            <button type="submit" class="btn btn-amber" style="flex:2;justify-content:center">💾 Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
