@extends('layouts.app')
@section('title','Catat Pengeluaran')
@section('page-title','Pengeluaran')
@section('content')

<div style="display:flex;align-items:center;gap:10px;margin-bottom:16px">
    <a href="{{ route('pengeluaran.index') }}" style="font-size:20px;color:#3d2b1a;text-decoration:none">←</a>
    <h2 style="font-size:18px;font-weight:700;color:#3d2b1a">Catat Pengeluaran</h2>
</div>

<div class="card">
    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <form action="{{ route('pengeluaran.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label class="form-label">Kategori</label>
            <select name="kategori" class="form-control" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($kategoriList as $k)
                <option value="{{ $k }}" {{ old('kategori')==$k?'selected':'' }}>{{ $k }}</option>
                @endforeach
            </select>
            <small style="font-size:11px;color:#9b8878">Botol / Label / Segel / Madu</small>
        </div>

        <div class="form-group">
            <label class="form-label">Tanggal</label>
            <input type="date" name="tanggal" class="form-control"
                   value="{{ old('tanggal', date('Y-m-d')) }}" required>
        </div>

        <div class="form-group">
            <label class="form-label">Jumlah Pengeluaran</label>
            <div style="position:relative">
                <span style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#7a6152;font-size:13px">Rp</span>
                <input type="number" name="jumlah_pengeluaran" class="form-control"
                       style="padding-left:36px" min="1"
                       value="{{ old('jumlah_pengeluaran') }}" required placeholder="0">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Keterangan</label>
            <textarea name="keterangan" class="form-control" rows="3" required
                      placeholder="Contoh: Beli botol 100 pcs @Rp2.000, bayar listrik...">{{ old('keterangan') }}</textarea>
        </div>

        <div style="display:flex;gap:10px">
            <a href="{{ route('pengeluaran.index') }}" class="btn btn-outline" style="flex:1;justify-content:center">Batal</a>
            <button type="submit" class="btn btn-amber" style="flex:2;justify-content:center">💾 Simpan</button>
        </div>
    </form>
</div>
@endsection
