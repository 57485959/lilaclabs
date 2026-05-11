@extends('layouts.app')
@section('title','Tambah Transaksi')
@section('page-title','Kasir')
@section('content')

<div style="display:flex;align-items:center;gap:10px;margin-bottom:16px">
    <a href="{{ route('transaksi.index') }}" style="font-size:20px;color:#3d2b1a;text-decoration:none">←</a>
    <h2 style="font-size:18px;font-weight:700;color:#3d2b1a">Tambah Transaksi</h2>
</div>

@if($errors->any())
    <div class="alert alert-danger">{{ $errors->first() }}</div>
@endif

<form action="{{ route('transaksi.store') }}" method="POST" id="form-trx">
@csrf

{{-- Info Pelanggan --}}
<div class="card">
    <p class="section-title">👤 Info Pelanggan <span style="font-size:12px;font-weight:400;color:#9b8878">(opsional)</span></p>
    <div class="form-group">
        <label class="form-label">Nama Pelanggan</label>
        <input type="text" name="nama_pelanggan" class="form-control"
               placeholder="Kosongkan jika pelanggan umum"
               value="{{ old('nama_pelanggan') }}"
               list="list-pelanggan">
        <datalist id="list-pelanggan">
            @foreach($pelanggan as $p)
            <option value="{{ $p->nama_pelanggan }}">
            @endforeach
        </datalist>
    </div>
    <div class="form-group" style="margin-bottom:0">
        <label class="form-label">Nomor HP</label>
        <input type="text" name="no_hp" class="form-control"
               placeholder="08xxx" value="{{ old('no_hp') }}">
    </div>
</div>

{{-- Produk yang dijual --}}
<div class="card">
    <p class="section-title">🍶 Produk yang Dijual</p>
    <div id="item-container">
        <div class="item-row" style="background:#fdf6ee;border:1px solid #e8ddd5;border-radius:12px;padding:14px;margin-bottom:10px">
            <div class="form-group">
                <label class="form-label">Produk</label>
                <select name="produk_id[]" class="form-control produk-select" required>
                    <option value="">-- Pilih Produk --</option>
                    @foreach($produk as $p)
                    <option value="{{ $p->id_produk }}"
                            data-harga="{{ $p->harga_jual }}"
                            data-stok="{{ $p->stok }}">
                        {{ $p->nama_produk }} — {{ $p->ukuran_kemasan }} (Stok: {{ $p->stok }})
                    </option>
                    @endforeach
                </select>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
                <div class="form-group" style="margin-bottom:0">
                    <label class="form-label">Qty</label>
                    <input type="number" name="qty[]" class="form-control qty-input"
                           min="1" value="1" required>
                </div>
                <div class="form-group" style="margin-bottom:0">
                    <label class="form-label">Subtotal</label>
                    <div class="form-control subtotal-display"
                         style="background:#fff;font-weight:700;color:#d97706">Rp 0</div>
                </div>
            </div>
            <button type="button" class="btn btn-danger btn-hapus"
                    style="margin-top:10px;font-size:12px;padding:6px 12px">✕ Hapus Item</button>
        </div>
    </div>
    <button type="button" class="btn btn-outline" id="btn-tambah-item"
            style="width:100%;justify-content:center">+ Tambah Produk Lain</button>
</div>

{{-- Ringkasan Harga --}}
<div class="card" style="background:#fdf6ee">
    <p class="section-title">💰 Ringkasan Harga</p>
    <div style="display:flex;justify-content:space-between;margin-bottom:8px;font-size:14px">
        <span style="color:#7a6152">Subtotal Produk</span>
        <strong id="display-subtotal">Rp 0</strong>
    </div>
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;font-size:14px">
        <span style="color:#7a6152">Ongkos Kirim</span>
        <input type="number" name="ongkir" id="ongkir"
               style="width:130px;border:1.5px solid #e8ddd5;border-radius:10px;padding:6px 10px;font-size:13px;text-align:right"
               value="0" min="0">
    </div>
    <div style="border-top:1px solid #e8ddd5;padding-top:12px;display:flex;justify-content:space-between">
        <span style="font-size:16px;font-weight:700;color:#3d2b1a">Total</span>
        <strong style="font-size:20px;color:#d97706" id="display-grand">Rp 0</strong>
    </div>
</div>

{{-- Pembayaran --}}
<div class="card">
    <p class="section-title">💳 Pembayaran</p>
    <div class="form-group">
        <label class="form-label">Tanggal</label>
        <input type="date" name="tanggal_transaksi" class="form-control"
               value="{{ old('tanggal_transaksi', date('Y-m-d')) }}" required>
    </div>
    <div class="form-group">
        <label class="form-label">Status Bayar</label>
        <select name="status_bayar" class="form-control" required>
            <option value="Lunas">✅ Lunas</option>
            <option value="Belum Lunas">⚠️ Belum Lunas</option>
            <option value="DP">🕐 DP / Uang Muka</option>
        </select>
    </div>
    <div class="form-group" style="margin-bottom:0">
        <label class="form-label">Metode Bayar</label>
        <select name="metode_bayar" class="form-control" required>
            <option value="Tunai">💵 Tunai</option>
            <option value="Transfer Bank">🏦 Transfer Bank</option>
            <option value="COD">🚚 COD</option>
            <option value="QRIS">📱 QRIS</option>
        </select>
    </div>
</div>

<div style="display:flex;gap:10px;margin-bottom:80px">
    <a href="{{ route('transaksi.index') }}" class="btn btn-outline" style="flex:1;justify-content:center">Batal</a>
    <button type="submit" class="btn btn-amber" style="flex:2;justify-content:center">💾 Simpan Transaksi</button>
</div>

</form>

<template id="item-tpl">
    <div class="item-row" style="background:#fdf6ee;border:1px solid #e8ddd5;border-radius:12px;padding:14px;margin-bottom:10px">
        <div class="form-group">
            <label class="form-label">Produk</label>
            <select name="produk_id[]" class="form-control produk-select" required>
                <option value="">-- Pilih Produk --</option>
                @foreach($produk as $p)
                <option value="{{ $p->id_produk }}"
                        data-harga="{{ $p->harga_jual }}"
                        data-stok="{{ $p->stok }}">
                    {{ $p->nama_produk }} — {{ $p->ukuran_kemasan }} (Stok: {{ $p->stok }})
                </option>
                @endforeach
            </select>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
            <div class="form-group" style="margin-bottom:0">
                <label class="form-label">Qty</label>
                <input type="number" name="qty[]" class="form-control qty-input" min="1" value="1" required>
            </div>
            <div class="form-group" style="margin-bottom:0">
                <label class="form-label">Subtotal</label>
                <div class="form-control subtotal-display" style="background:#fff;font-weight:700;color:#d97706">Rp 0</div>
            </div>
        </div>
        <button type="button" class="btn btn-danger btn-hapus" style="margin-top:10px;font-size:12px;padding:6px 12px">✕ Hapus Item</button>
    </div>
</template>

<script>
function hitung() {
    let sub = 0;
    document.querySelectorAll('.item-row').forEach(row => {
        const sel  = row.querySelector('.produk-select');
        const qty  = parseInt(row.querySelector('.qty-input').value) || 0;
        const hrg  = sel.selectedIndex > 0
            ? parseFloat(sel.options[sel.selectedIndex].dataset.harga) : 0;
        const s = hrg * qty;
        row.querySelector('.subtotal-display').textContent = 'Rp ' + s.toLocaleString('id-ID');
        sub += s;
    });
    const ongkir = parseInt(document.getElementById('ongkir').value) || 0;
    document.getElementById('display-subtotal').textContent = 'Rp ' + sub.toLocaleString('id-ID');
    document.getElementById('display-grand').textContent    = 'Rp ' + (sub + ongkir).toLocaleString('id-ID');
}

function bindEvents() {
    document.querySelectorAll('.produk-select,.qty-input').forEach(el => {
        el.onchange = hitung; el.oninput = hitung;
    });
    document.querySelectorAll('.btn-hapus').forEach(btn => {
        btn.onclick = function () {
            if (document.querySelectorAll('.item-row').length > 1) {
                this.closest('.item-row').remove(); hitung();
            }
        };
    });
}

document.getElementById('btn-tambah-item').onclick = function () {
    const tpl = document.getElementById('item-tpl').innerHTML;
    const div = document.createElement('div');
    div.innerHTML = tpl;
    document.getElementById('item-container').appendChild(div.firstElementChild);
    bindEvents();
};

document.getElementById('ongkir').oninput = hitung;
bindEvents();
</script>
@endsection
