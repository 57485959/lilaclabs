@extends('layouts.app')
@section('title','Catat Pengeluaran')
@section('page-title','Catat Pengeluaran')
@section('content')
<div class="row justify-content-center">
<div class="col-md-6">
<div class="card">
    <div class="card-header">💸 Form Pencatatan Pengeluaran</div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger mb-3">{{ $errors->first() }}</div>
        @endif
        <form action="{{ route('pengeluaran.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-semibold">Kategori</label>
                <select name="kategori" class="form-select" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($kategoriList as $k)
                    <option value="{{ $k }}" {{ old('kategori')==$k?'selected':'' }}>{{ $k }}</option>
                    @endforeach
                </select>
                <small class="text-muted" style="font-size:11px">Botol / Label / Segel / Madu</small>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Tanggal</label>
                <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', date('Y-m-d')) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Jumlah Pengeluaran (Rp)</label>
                <input type="number" name="jumlah_pengeluaran" class="form-control" min="1" value="{{ old('jumlah_pengeluaran') }}" required placeholder="0">
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold">Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="3" required placeholder="Contoh: Beli botol 100 pcs Rp 2.000/pcs...">{{ old('keterangan') }}</textarea>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-madu px-4">💾 Simpan</button>
                <a href="{{ route('pengeluaran.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
</div>
</div>
@endsection
