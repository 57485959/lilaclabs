@extends('layouts.app')
@section('title','Catat Stok Masuk')
@section('page-title','Catat Stok Masuk')
@section('content')

<div class="row justify-content-center">
<div class="col-md-7">
<div class="card">
    <div class="card-header">📦 Form Pencatatan Stok Masuk</div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger mb-3">{{ $errors->first() }}</div>
        @endif
        <form action="{{ route('stok.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-semibold">Produk</label>
                <select name="produk_id" class="form-select" required id="produk-select">
                    <option value="">-- Pilih Produk --</option>
                    @foreach($produk as $p)
                    <option value="{{ $p->id }}" data-harga="{{ $p->harga_beli }}" {{ old('produk_id') == $p->id ? 'selected' : '' }}>
                        {{ $p->nama_produk }} (Stok: {{ $p->stok }} {{ $p->satuan }})
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="row mb-3">
                <div class="col-6">
                    <label class="form-label fw-semibold">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                </div>
                <div class="col-6">
                    <label class="form-label fw-semibold">Sumber</label>
                    <select name="sumber" class="form-select" required>
                        <option value="panen" {{ old('sumber','panen')=='panen' ? 'selected' : '' }}>🌿 Panen Sendiri</option>
                        <option value="pembelian" {{ old('sumber')=='pembelian' ? 'selected' : '' }}>🛒 Pembelian</option>
                        <option value="lainnya" {{ old('sumber')=='lainnya' ? 'selected' : '' }}>📋 Lainnya</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-6">
                    <label class="form-label fw-semibold">Jumlah</label>
                    <input type="number" name="jumlah" id="jumlah" class="form-control" min="1" value="{{ old('jumlah') }}" required placeholder="0">
                </div>
                <div class="col-6">
                    <label class="form-label fw-semibold">Harga Beli per Unit (Rp)</label>
                    <input type="number" name="harga_beli_per_unit" id="harga-beli" class="form-control" min="0" value="{{ old('harga_beli_per_unit') }}" required placeholder="0">
                </div>
            </div>
            <div class="mb-3 p-3 rounded-3" style="background:#fef3c7">
                <div style="font-size:12px;color:#92400e;font-weight:600">Total Biaya Modal</div>
                <div style="font-size:22px;font-weight:700;color:#d97706" id="total-biaya">Rp 0</div>
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold">Keterangan <span class="text-muted">(opsional)</span></label>
                <textarea name="keterangan" class="form-control" rows="2" placeholder="Contoh: Panen kebun belakang, Batch #3...">{{ old('keterangan') }}</textarea>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-madu px-4">💾 Simpan</button>
                <a href="{{ route('stok.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
</div>
</div>

<script>
function hitungTotal() {
    const jumlah = parseInt(document.getElementById('jumlah').value) || 0;
    const harga  = parseInt(document.getElementById('harga-beli').value) || 0;
    const total  = jumlah * harga;
    document.getElementById('total-biaya').textContent = 'Rp ' + total.toLocaleString('id-ID');
}
document.getElementById('jumlah').addEventListener('input', hitungTotal);
document.getElementById('harga-beli').addEventListener('input', hitungTotal);
document.getElementById('produk-select').addEventListener('change', function() {
    const harga = this.options[this.selectedIndex].dataset.harga || 0;
    document.getElementById('harga-beli').value = harga;
    hitungTotal();
});
</script>
@endsection
