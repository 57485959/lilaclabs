@extends('layouts.app')
@section('title','Catat Pengeluaran')
@section('page-title','Catat Pengeluaran')
@section('content')
<div class="row justify-content-center">
<div class="col-md-6">
<div class="card">
    <div class="card-header">💸 Form Pencatatan Pengeluaran</div>
    <div class="card-body">
        @if($errors->any())<div class="alert alert-danger mb-3">{{ $errors->first() }}</div>@endif
        <form action="{{ route('pengeluaran.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-semibold">Kategori Pengeluaran</label>
                <select name="kategori_id" class="form-select" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($kategori as $k)
                    <option value="{{ $k->id }}" {{ old('kategori_id')==$k->id ? 'selected':'' }}>{{ $k->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Tanggal</label>
                <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', date('Y-m-d')) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Jumlah (Rp)</label>
                <input type="number" name="jumlah" class="form-control" min="1" value="{{ old('jumlah') }}" required placeholder="0">
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold">Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="3" required placeholder="Contoh: Beli botol 100 pcs, bayar listrik bulan Oktober...">{{ old('keterangan') }}</textarea>
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
