@extends('layouts.app')
@section('title','Tambah Produk')
@section('page-title','Tambah Produk Baru')
@section('content')

<div class="row justify-content-center">
<div class="col-md-6">
<div class="card">
    <div class="card-header">🍶 Form Tambah Produk</div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger mb-3">{{ $errors->first() }}</div>
        @endif
        <form action="{{ route('produk.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Produk</label>
                <input type="text" name="nama_produk" class="form-control"
                       placeholder="Contoh: Madu Hutan Murni 330ml"
                       value="{{ old('nama_produk') }}" required>
            </div>
            <div class="row mb-3">
                <div class="col-6">
                    <label class="form-label fw-semibold">Satuan</label>
                    <select name="satuan" class="form-select" required>
                        <option value="botol" {{ old('satuan','botol')=='botol'?'selected':'' }}>Botol</option>
                        <option value="kg"     {{ old('satuan')=='kg'?'selected':'' }}>Kg</option>
                        <option value="liter"  {{ old('satuan')=='liter'?'selected':'' }}>Liter</option>
                        <option value="pcs"    {{ old('satuan')=='pcs'?'selected':'' }}>Pcs</option>
                    </select>
                </div>
                <div class="col-6">
                    <label class="form-label fw-semibold">Stok Minimum</label>
                    <input type="number" name="stok_minimum" class="form-control"
                           min="0" value="{{ old('stok_minimum', 5) }}" required>
                    <small class="text-muted" style="font-size:11px">Batas peringatan stok menipis</small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-6">
                    <label class="form-label fw-semibold">Harga Jual (Rp)</label>
                    <input type="number" name="harga_jual" class="form-control"
                           min="0" value="{{ old('harga_jual') }}" required placeholder="0">
                </div>
                <div class="col-6">
                    <label class="form-label fw-semibold">Harga Beli / HPP (Rp)</label>
                    <input type="number" name="harga_beli" class="form-control"
                           min="0" value="{{ old('harga_beli') }}" required placeholder="0">
                    <small class="text-muted" style="font-size:11px">Modal per satuan</small>
                </div>
            </div>

            {{-- Preview margin --}}
            <div class="mb-3 p-3 rounded-3" style="background:#f0fdf4">
                <div style="font-size:12px;color:#065f46;font-weight:600">Estimasi Margin per Unit</div>
                <div style="font-size:20px;font-weight:700;color:#10b981" id="margin-preview">Rp 0</div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Deskripsi <span class="text-muted">(opsional)</span></label>
                <textarea name="deskripsi" class="form-control" rows="2"
                          placeholder="Keterangan singkat tentang produk...">{{ old('deskripsi') }}</textarea>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-madu px-4">💾 Simpan Produk</button>
                <a href="{{ route('produk.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
</div>
</div>

<script>
function hitungMargin() {
    const jual  = parseInt(document.querySelector('[name=harga_jual]').value) || 0;
    const beli  = parseInt(document.querySelector('[name=harga_beli]').value) || 0;
    const margin = jual - beli;
    document.getElementById('margin-preview').textContent = 'Rp ' + margin.toLocaleString('id-ID');
    document.getElementById('margin-preview').style.color = margin >= 0 ? '#10b981' : '#ef4444';
}
document.querySelector('[name=harga_jual]').addEventListener('input', hitungMargin);
document.querySelector('[name=harga_beli]').addEventListener('input', hitungMargin);
</script>
@endsection
