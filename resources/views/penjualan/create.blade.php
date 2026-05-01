@extends('layouts.app')
@section('title','Catat Penjualan')
@section('page-title','Catat Transaksi Penjualan')
@section('content')

<div class="row">
<div class="col-md-8">
<div class="card mb-3">
    <div class="card-header">🧾 Detail Produk yang Dijual</div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger mb-3">{{ $errors->first() }}</div>
        @endif
        <form action="{{ route('penjualan.store') }}" method="POST" id="form-penjualan">
            @csrf

            {{-- Item produk --}}
            <div id="item-container">
                <div class="item-row border rounded-3 p-3 mb-2" style="background:#fafafa">
                    <div class="row g-2 align-items-end">
                        <div class="col-md-5">
                            <label class="form-label fw-semibold" style="font-size:12px">Produk</label>
                            <select name="produk_id[]" class="form-select produk-select" required style="font-size:13px">
                                <option value="">-- Pilih Produk --</option>
                                @foreach($produk as $p)
                                <option value="{{ $p->id }}" data-harga="{{ $p->harga_jual }}" data-stok="{{ $p->stok }}" data-satuan="{{ $p->satuan }}">
                                    {{ $p->nama_produk }} (Stok: {{ $p->stok }})
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-semibold" style="font-size:12px">Jumlah</label>
                            <input type="number" name="jumlah[]" class="form-control jumlah-input" min="1" value="1" required style="font-size:13px">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold" style="font-size:12px">Subtotal</label>
                            <div class="form-control bg-light subtotal-display" style="font-size:13px;font-weight:600;color:#d97706">Rp 0</div>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-outline-danger btn-sm w-100 btn-hapus">✕ Hapus</button>
                        </div>
                    </div>
                </div>
            </div>

            <button type="button" class="btn btn-outline-warning btn-sm mb-3" id="btn-tambah-item">+ Tambah Produk Lain</button>

            {{-- Ringkasan --}}
            <div class="p-3 rounded-3 mb-3" style="background:#fef3c7">
                <div class="d-flex justify-content-between mb-1">
                    <span style="font-size:13px">Subtotal</span>
                    <strong id="display-subtotal">Rp 0</strong>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span style="font-size:13px">Diskon</span>
                    <div style="width:120px"><input type="number" name="diskon" id="diskon" class="form-control form-control-sm" value="0" min="0" placeholder="0"></div>
                </div>
                <hr class="my-2">
                <div class="d-flex justify-content-between">
                    <span style="font-size:15px;font-weight:700">Total Bayar</span>
                    <strong style="font-size:18px;color:#d97706" id="display-total">Rp 0</strong>
                </div>
            </div>
</div>
</div>
</div>

<div class="col-md-4">
<div class="card mb-3">
    <div class="card-header">👤 Info Pelanggan <span class="text-muted" style="font-size:11px">(opsional)</span></div>
    <div class="card-body">
        <div class="mb-3">
            <label class="form-label fw-semibold" style="font-size:12px">Nama Pelanggan</label>
            <input type="text" name="nama_pelanggan" class="form-control" placeholder="Kosongkan jika umum" style="font-size:13px" value="{{ old('nama_pelanggan') }}">
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold" style="font-size:12px">Nomor HP</label>
            <input type="text" name="nomor_hp" class="form-control" placeholder="08xxx" style="font-size:13px" value="{{ old('nomor_hp') }}">
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header">💳 Info Pembayaran</div>
    <div class="card-body">
        <div class="mb-3">
            <label class="form-label fw-semibold" style="font-size:12px">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', date('Y-m-d')) }}" required style="font-size:13px">
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold" style="font-size:12px">Status Bayar</label>
            <select name="status_bayar" class="form-select" style="font-size:13px">
                <option value="lunas">✅ Lunas</option>
                <option value="dp">🕐 DP / Uang Muka</option>
                <option value="hutang">⚠️ Hutang</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold" style="font-size:12px">Metode Bayar</label>
            <select name="metode_bayar" class="form-select" style="font-size:13px">
                <option value="tunai">💵 Tunai</option>
                <option value="transfer">🏦 Transfer</option>
                <option value="lainnya">📋 Lainnya</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold" style="font-size:12px">Keterangan</label>
            <textarea name="keterangan" class="form-control" rows="2" style="font-size:13px" placeholder="Opsional...">{{ old('keterangan') }}</textarea>
        </div>
        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-madu">💾 Simpan Transaksi</button>
            <a href="{{ route('penjualan.index') }}" class="btn btn-outline-secondary">Batal</a>
        </div>
    </div>
</div>
</div>
</div>
        </form>

<template id="item-template">
    <div class="item-row border rounded-3 p-3 mb-2" style="background:#fafafa">
        <div class="row g-2 align-items-end">
            <div class="col-md-5">
                <label class="form-label fw-semibold" style="font-size:12px">Produk</label>
                <select name="produk_id[]" class="form-select produk-select" required style="font-size:13px">
                    <option value="">-- Pilih Produk --</option>
                    @foreach($produk as $p)
                    <option value="{{ $p->id }}" data-harga="{{ $p->harga_jual }}" data-stok="{{ $p->stok }}" data-satuan="{{ $p->satuan }}">
                        {{ $p->nama_produk }} (Stok: {{ $p->stok }})
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold" style="font-size:12px">Jumlah</label>
                <input type="number" name="jumlah[]" class="form-control jumlah-input" min="1" value="1" required style="font-size:13px">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold" style="font-size:12px">Subtotal</label>
                <div class="form-control bg-light subtotal-display" style="font-size:13px;font-weight:600;color:#d97706">Rp 0</div>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-outline-danger btn-sm w-100 btn-hapus">✕ Hapus</button>
            </div>
        </div>
    </div>
</template>

<script>
function hitungSemua() {
    let subtotal = 0;
    document.querySelectorAll('.item-row').forEach(row => {
        const sel    = row.querySelector('.produk-select');
        const jml    = parseInt(row.querySelector('.jumlah-input').value) || 0;
        const harga  = sel.selectedIndex > 0 ? parseFloat(sel.options[sel.selectedIndex].dataset.harga) : 0;
        const sub    = harga * jml;
        row.querySelector('.subtotal-display').textContent = 'Rp ' + sub.toLocaleString('id-ID');
        subtotal += sub;
    });
    const diskon = parseInt(document.getElementById('diskon').value) || 0;
    document.getElementById('display-subtotal').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
    document.getElementById('display-total').textContent    = 'Rp ' + (subtotal - diskon).toLocaleString('id-ID');
}

document.getElementById('btn-tambah-item').addEventListener('click', () => {
    const tpl  = document.getElementById('item-template').innerHTML;
    const div  = document.createElement('div');
    div.innerHTML = tpl;
    document.getElementById('item-container').appendChild(div.firstElementChild);
    bindEvents();
});

function bindEvents() {
    document.querySelectorAll('.produk-select, .jumlah-input').forEach(el => {
        el.removeEventListener('change', hitungSemua);
        el.removeEventListener('input', hitungSemua);
        el.addEventListener('change', hitungSemua);
        el.addEventListener('input',  hitungSemua);
    });
    document.querySelectorAll('.btn-hapus').forEach(btn => {
        btn.onclick = function() {
            if (document.querySelectorAll('.item-row').length > 1) {
                this.closest('.item-row').remove();
                hitungSemua();
            }
        };
    });
}

document.getElementById('diskon').addEventListener('input', hitungSemua);
bindEvents();
</script>
@endsection
