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
                <input type="text" name="nama_produk" class="form-control" placeholder="Contoh: Madu Hutan Murni" value="{{ old('nama_produk') }}" required>
            </div>
            <div class="row mb-3">
                <div class="col-6">
                    <label class="form-label fw-semibold">Jenis Asal</label>
                    <select name="jenis_asal" class="form-select" required>
                        <option value="">-- Pilih --</option>
                        <option value="Supplier" {{ old('jenis_asal')=='Supplier'?'selected':'' }}>🏭 Supplier</option>
                        <option value="Ternak"   {{ old('jenis_asal')=='Ternak'?'selected':'' }}>🐝 Ternak Sendiri</option>
                    </select>
                </div>
                <div class="col-6">
                    <label class="form-label fw-semibold">Ukuran Kemasan</label>
                    <input type="text" name="ukuran_kemasan" class="form-control" placeholder="Contoh: 330ml, 500gr" value="{{ old('ukuran_kemasan') }}" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-6">
                    <label class="form-label fw-semibold">Harga Jual (Rp)</label>
                    <input type="number" name="harga_jual" id="harga-jual" class="form-control" min="0" value="{{ old('harga_jual') }}" required placeholder="0">
                </div>
                <div class="col-6">
                    <label class="form-label fw-semibold">Harga Modal (Rp)</label>
                    <input type="number" name="harga_modal" id="harga-modal" class="form-control" min="0" value="{{ old('harga_modal') }}" required placeholder="0">
                </div>
            </div>
            <div class="mb-3 p-3 rounded-3" style="background:#f0fdf4">
                <div style="font-size:12px;color:#065f46;font-weight:600">Estimasi Margin per Unit</div>
                <div style="font-size:20px;font-weight:700;color:#10b981" id="margin">Rp 0</div>
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold">Minimum Stok</label>
                <input type="number" name="minimum_stok" class="form-control" min="0" value="{{ old('minimum_stok', 5) }}" required>
                <small class="text-muted" style="font-size:11px">Batas peringatan stok menipis</small>
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
    const j = parseInt(document.getElementById('harga-jual').value) || 0;
    const m = parseInt(document.getElementById('harga-modal').value) || 0;
    const margin = j - m;
    document.getElementById('margin').textContent = 'Rp ' + margin.toLocaleString('id-ID');
    document.getElementById('margin').style.color = margin >= 0 ? '#10b981' : '#ef4444';
}
document.getElementById('harga-jual').addEventListener('input', hitungMargin);
document.getElementById('harga-modal').addEventListener('input', hitungMargin);
</script>
@endsection
