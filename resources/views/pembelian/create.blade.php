@extends('layouts.app')
@section('title','Catat Pembelian Stok')
@section('page-title','Pembelian Stok')
@section('content')

<div style="display:flex;align-items:center;gap:10px;margin-bottom:16px">
    <a href="{{ route('pembelian.index') }}" style="font-size:20px;color:#3d2b1a;text-decoration:none">←</a>
    <h2 style="font-size:18px;font-weight:700;color:#3d2b1a">Catat Pembelian Stok</h2>
</div>

<div class="card">
    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <form action="{{ route('pembelian.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label class="form-label">Produk</label>
            <select name="id_produk" class="form-control" required id="produk-sel">
                <option value="">-- Pilih Produk --</option>
                @foreach($produk as $p)
                <option value="{{ $p->id_produk }}"
                        data-modal="{{ $p->harga_modal }}"
                        {{ old('id_produk')==$p->id_produk?'selected':'' }}>
                    {{ $p->nama_produk }} — {{ $p->ukuran_kemasan }} (Stok: {{ $p->stok }})
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label class="form-label">Tanggal</label>
            <input type="date" name="tanggal" class="form-control"
                   value="{{ old('tanggal', date('Y-m-d')) }}" required>
        </div>

        <div class="form-group">
            <label class="form-label">Supplier <span style="color:#9b8878">(opsional)</span></label>
            <input type="text" name="supplier" class="form-control"
                   placeholder="Nama supplier / peternak"
                   value="{{ old('supplier') }}">
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
            <div class="form-group">
                <label class="form-label">Jumlah</label>
                <input type="number" name="jumlah" id="jumlah" class="form-control"
                       min="1" value="{{ old('jumlah') }}" required placeholder="0">
            </div>
            <div class="form-group">
                <label class="form-label">Harga Beli/Unit</label>
                <div style="position:relative">
                    <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#7a6152;font-size:12px">Rp</span>
                    <input type="number" name="harga_beli" id="harga-beli" class="form-control"
                           style="padding-left:32px" min="0"
                           value="{{ old('harga_beli') }}" required placeholder="0">
                </div>
            </div>
        </div>

        {{-- Preview total --}}
        <div style="background:#fef3c7;border-radius:12px;padding:14px;margin-bottom:16px">
            <div style="font-size:12px;color:#92400e;font-weight:600;margin-bottom:4px">Total Biaya Pembelian</div>
            <div style="font-size:22px;font-weight:700;color:#d97706" id="total-biaya">Rp 0</div>
        </div>

        <div class="form-group">
            <label class="form-label">Keterangan <span style="color:#9b8878">(opsional)</span></label>
            <textarea name="keterangan" class="form-control" rows="2"
                      placeholder="Contoh: Panen batch #3, stok titipan...">{{ old('keterangan') }}</textarea>
        </div>

        <div style="display:flex;gap:10px">
            <a href="{{ route('pembelian.index') }}" class="btn btn-outline" style="flex:1;justify-content:center">Batal</a>
            <button type="submit" class="btn btn-amber" style="flex:2;justify-content:center">💾 Simpan</button>
        </div>
    </form>
</div>

<script>
function hitung() {
    const j = parseInt(document.getElementById('jumlah').value) || 0;
    const h = parseInt(document.getElementById('harga-beli').value) || 0;
    document.getElementById('total-biaya').textContent = 'Rp ' + (j * h).toLocaleString('id-ID');
}
document.getElementById('jumlah').addEventListener('input', hitung);
document.getElementById('harga-beli').addEventListener('input', hitung);
document.getElementById('produk-sel').addEventListener('change', function () {
    const modal = this.options[this.selectedIndex].dataset.modal || 0;
    document.getElementById('harga-beli').value = modal;
    hitung();
});
</script>
@endsection
