@extends('layouts.app')
@section('title','Tambah Produk')
@section('page-title','Produk')
@section('content')

<div style="display:flex;align-items:center;gap:10px;margin-bottom:16px">
    <a href="{{ route('produk.index') }}" style="font-size:20px;color:#3d2b1a;text-decoration:none">←</a>
    <h2 style="font-size:18px;font-weight:700;color:#3d2b1a">Tambah Produk</h2>
</div>

<div class="card">
    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif
    <form action="{{ route('produk.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label class="form-label">Nama Produk</label>
            <input type="text" name="nama_produk" class="form-control"
                   placeholder="Contoh : Dadi Madu 100 ml"
                   value="{{ old('nama_produk') }}" required>
        </div>
        <div class="form-group">
            <label class="form-label">Jenis Produk</label>
            <select name="jenis_asal" class="form-control" required>
                <option value="">Pilih Asal Produk</option>
                <option value="Supplier" {{ old('jenis_asal')=='Supplier'?'selected':'' }}>🏭 Supplier</option>
                <option value="Ternak"   {{ old('jenis_asal')=='Ternak'?'selected':'' }}>🐝 Ternak Sendiri</option>
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">Ukuran Kemasan</label>
            <input type="text" name="ukuran_kemasan" class="form-control"
                   placeholder="Contoh : 250 ml"
                   value="{{ old('ukuran_kemasan') }}" required>
        </div>
        <div class="form-group">
            <label class="form-label">Harga Jual</label>
            <div style="position:relative">
                <span style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#7a6152;font-size:13px">Rp</span>
                <input type="number" name="harga_jual" id="hj" class="form-control"
                       style="padding-left:36px" min="0"
                       value="{{ old('harga_jual') }}" required placeholder="0">
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">Harga Modal</label>
            <div style="position:relative">
                <span style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#7a6152;font-size:13px">Rp</span>
                <input type="number" name="harga_modal" id="hm" class="form-control"
                       style="padding-left:36px" min="0"
                       value="{{ old('harga_modal') }}" required placeholder="0">
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">Stok Awal</label>
            <input type="number" name="stok_awal" class="form-control" min="0"
                   value="{{ old('stok_awal', 0) }}">
            <small style="font-size:11px;color:#9b8878">Isi stok awal produk (bisa 0)</small>
        </div>
        <div class="form-group">
            <label class="form-label">Minimum Stok</label>
            <input type="number" name="minimum_stok" class="form-control" min="0"
                   value="{{ old('minimum_stok', 5) }}" required>
            <small style="font-size:11px;color:#9b8878">Batas peringatan stok menipis</small>
        </div>

        {{-- Preview margin --}}
        <div style="background:#f0fdf4;border-radius:12px;padding:14px;margin-bottom:16px">
            <div style="font-size:12px;color:#065f46;font-weight:600;margin-bottom:4px">Estimasi Margin per Unit</div>
            <div style="font-size:20px;font-weight:700;color:#10b981" id="margin">Rp 0</div>
        </div>

        <div style="display:flex;gap:10px">
            <a href="{{ route('produk.index') }}" class="btn btn-outline">Batal</a>
            <button type="submit" class="btn btn-amber">🗸 Simpan</button>
        </div>
    </form>
</div>

<script>
function hitungMargin() {
    const j = parseInt(document.getElementById('hj').value) || 0;
    const m = parseInt(document.getElementById('hm').value) || 0;
    const el = document.getElementById('margin');
    el.textContent = 'Rp ' + (j-m).toLocaleString('id-ID');
    el.style.color = (j-m) >= 0 ? '#10b981' : '#ef4444';
}
document.getElementById('hj').addEventListener('input', hitungMargin);
document.getElementById('hm').addEventListener('input', hitungMargin);
</script>
@endsection
