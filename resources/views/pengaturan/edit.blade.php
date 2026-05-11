@extends('layouts.app')
@section('title','Edit Pengaturan')
@section('page-title','Pengaturan')
@section('content')

<div class="page-header">
    <h2>Ubah Informasi Bisnis</h2>
</div>

<div class="card">
    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif
    <form action="{{ route('pengaturan.update') }}" method="POST">
        @csrf @method('PUT')
        <div class="form-group">
            <label class="form-label">Nama Bisnis</label>
            <input type="text" name="nama_bisnis" class="form-control"
                   value="{{ old('nama_bisnis', $pengaturan->nama_bisnis ?? '') }}"
                   placeholder="Contoh: Dadi Madu" required>
        </div>
        <div class="form-group">
            <label class="form-label">Nama Pemilik</label>
            <input type="text" name="nama_pemilik" class="form-control"
                   value="{{ old('nama_pemilik', $pengaturan->nama_pemilik ?? '') }}"
                   placeholder="Nama pemilik usaha">
        </div>
        <div class="form-group">
            <label class="form-label">Nomor Telepon</label>
            <input type="text" name="nomor_telepon" class="form-control"
                   value="{{ old('nomor_telepon', $pengaturan->nomor_telepon ?? '') }}"
                   placeholder="+62812-345-678-9123">
        </div>
        <div class="form-group">
            <label class="form-label">Alamat</label>
            <textarea name="alamat" class="form-control" rows="3"
                      placeholder="Alamat lengkap usaha">{{ old('alamat', $pengaturan->alamat ?? '') }}</textarea>
        </div>
        <div style="display:flex;gap:10px;margin-top:8px">
            <button type="submit" class="btn btn-amber px-4">💾 Simpan</button>
            <a href="{{ route('pengaturan.index') }}" class="btn btn-outline">Batal</a>
        </div>
    </form>
</div>
@endsection
