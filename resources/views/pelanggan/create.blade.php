@extends('layouts.app')
@section('title','Tambah Pelanggan')
@section('page-title','Pelanggan')
@section('content')

<div style="display:flex;align-items:center;gap:10px;margin-bottom:16px">
    <a href="{{ route('pelanggan.index') }}" style="font-size:20px;color:#3d2b1a;text-decoration:none">←</a>
    <h2 style="font-size:18px;font-weight:700;color:#3d2b1a">Tambah Pelanggan</h2>
</div>

<div class="card">
    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif
    <form action="{{ route('pelanggan.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label class="form-label">Nama Pelanggan</label>
            <input type="text" name="nama_pelanggan" class="form-control"
                   placeholder="Nama lengkap pelanggan"
                   value="{{ old('nama_pelanggan') }}" required>
        </div>
        <div class="form-group">
            <label class="form-label">Nomor HP <span style="color:#9b8878">(opsional)</span></label>
            <input type="text" name="no_hp" class="form-control"
                   placeholder="08xxx" value="{{ old('no_hp') }}">
        </div>
        <div class="form-group">
            <label class="form-label">Alamat <span style="color:#9b8878">(opsional)</span></label>
            <textarea name="alamat" class="form-control" rows="3"
                      placeholder="Alamat lengkap">{{ old('alamat') }}</textarea>
        </div>
        <div style="display:flex;gap:10px;margin-top:8px">
            <a href="{{ route('pelanggan.index') }}" class="btn btn-outline">Batal</a>
            <button type="submit" class="btn btn-amber">💾 Simpan</button>
        </div>
    </form>
</div>
@endsection
