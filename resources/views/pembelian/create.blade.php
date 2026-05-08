@extends('layouts.app')
@section('title','Catat Pembelian Stok')
@section('page-title','Catat Pembelian Stok')
@section('content')
<div class="row justify-content-center">
<div class="col-md-6">
<div class="card">
    <div class="card-header">📦 Form Pembelian Stok</div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger mb-3">{{ $errors->first() }}</div>
        @endif
        <form action="{{ route('pembelian.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-semibold">Produk</label>
                <select name="id_produk" class="form-select" required id="produk-sel">
                    <option value="">-- Pilih Produk --</option>
                    @foreach($produk as $p)
                    <option value="{{ $p->id_produk }}" data-modal="{{ $p->harga_modal }}" {{ old('id_produk')==$p->id_produk?'selected':'' }}>
                        {{ $p->nama_produk }} — {{ $p->ukuran_kemasan }} (Stok: {{ $p->stok }})
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
                    <label class="form-label fw-semibold">Supplier</label>
                    <input type="text" name="supplier" class="form-control" placeholder="Nama supplier (opsional)" value="{{ old('supplier') }}">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-6">
                    <label class="form-label fw-semibold">Jumlah</label>
                    <input type="number" name="jumlah" id="jumlah" class="form-control" min="1" value="{{ old('jumlah') }}" required placeholder="0">
                </div>
                <div class="col-6">
                    <label class="form-label fw-semibold">Harga Beli per Unit (Rp)</label>
                    <input type="number" name="harga_beli" id="harga-beli" class="form-control" min="0" value="{{ old('harga_beli') }}" required placeholder="0">
                </div>
            </div>
            <div class="mb-3 p-3 rounded-3" style="background:#fef3c7">
                <div style="font-size:12px;color:#92400e;font-weight:600">Total Biaya Pembelian</div>
                <div style="font-size:22px;font-weight:700;color:#d97706" id="total-biaya">Rp 0</div>
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold">Keterangan <span class="text-muted">(opsional)</span></label>
                <textarea name="keterangan" class="form-control" rows="2" placeholder="Contoh: Pembelian batch #3, stok menipis...">{{ old('keterangan') }}</textarea>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-madu px-4">💾 Simpan</button>
                <a href="{{ route('pembelian.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
</div>
</div>
<script>
function hitung() {
    const j = parseInt(document.getElementById('jumlah').value) || 0;
    const h = parseInt(document.getElementById('harga-beli').value) || 0;
    document.getElementById('total-biaya').textContent = 'Rp ' + (j * h).toLocaleString('id-ID');
}
document.getElementById('jumlah').addEventListener('input', hitung);
document.getElementById('harga-beli').addEventListener('input', hitung);
document.getElementById('produk-sel').addEventListener('change', function() {
    const modal = this.options[this.selectedIndex].dataset.modal || 0;
    document.getElementById('harga-beli').value = modal;
    hitung();
});
</script>
@endsection
