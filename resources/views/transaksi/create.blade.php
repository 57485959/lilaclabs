@extends('layouts.app')
@section('title','Catat Transaksi')
@section('page-title','Catat Transaksi Penjualan')
@section('content')
<div class="row">
<div class="col-md-8">
<div class="card mb-3">
    <div class="card-header">🧾 Produk yang Dijual</div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger mb-3">{{ $errors->first() }}</div>
        @endif
        <form action="{{ route('transaksi.store') }}" method="POST" id="form-transaksi">
        @csrf

        <div id="item-container">
            <div class="item-row border rounded-3 p-3 mb-2" style="background:#fafafa">
                <div class="row g-2 align-items-end">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold" style="font-size:12px">Produk</label>
                        <select name="produk_id[]" class="form-select produk-select" required style="font-size:13px">
                            <option value="">-- Pilih Produk --</option>
                            @foreach($produk as $p)
                            <option value="{{ $p->id_produk }}" data-harga="{{ $p->harga_jual }}" data-stok="{{ $p->stok }}">
                                {{ $p->nama_produk }} — {{ $p->ukuran_kemasan }} (Stok: {{ $p->stok }})
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-semibold" style="font-size:12px">Qty</label>
                        <input type="number" name="qty[]" class="form-control qty-input" min="1" value="1" required style="font-size:13px">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold" style="font-size:12px">Subtotal</label>
                        <div class="form-control bg-light subtotal-display" style="font-size:13px;font-weight:600;color:#d97706">Rp 0</div>
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-outline-danger btn-sm w-100 btn-hapus">✕</button>
                    </div>
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-outline-warning btn-sm mb-3" id="btn-tambah">+ Tambah Produk</button>

        <div class="p-3 rounded-3 mb-3" style="background:#fef3c7">
            <div class="d-flex justify-content-between mb-1">
                <span style="font-size:13px">Subtotal Produk</span>
                <strong id="display-subtotal">Rp 0</strong>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span style="font-size:13px">Ongkos Kirim</span>
                <div style="width:130px"><input type="number" name="ongkir" id="ongkir" class="form-control form-control-sm" value="0" min="0"></div>
            </div>
            <hr class="my-2">
            <div class="d-flex justify-content-between">
                <span style="font-size:15px;font-weight:700">Grandtotal</span>
                <strong style="font-size:18px;color:#d97706" id="display-grand">Rp 0</strong>
            </div>
        </div>
</div></div>
</div>

<div class="col-md-4">
<div class="card mb-3">
    <div class="card-header">👤 Pelanggan <span class="text-muted" style="font-size:11px">(opsional)</span></div>
    <div class="card-body">
        <div class="mb-3">
            <label class="form-label fw-semibold" style="font-size:12px">Nama Pelanggan</label>
            <input type="text" name="nama_pelanggan" class="form-control" placeholder="Kosongkan jika umum" style="font-size:13px">
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold" style="font-size:12px">No. HP</label>
            <input type="text" name="no_hp" class="form-control" placeholder="08xxx" style="font-size:13px">
        </div>
    </div>
</div>
<div class="card mb-3">
    <div class="card-header">💳 Pembayaran</div>
    <div class="card-body">
        <div class="mb-3">
            <label class="form-label fw-semibold" style="font-size:12px">Tanggal</label>
            <input type="date" name="tanggal_transaksi" class="form-control" value="{{ date('Y-m-d') }}" required style="font-size:13px">
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold" style="font-size:12px">Status Bayar</label>
            <select name="status_bayar" class="form-select" style="font-size:13px">
                <option value="Lunas">✅ Lunas</option>
                <option value="Belum Lunas">⚠️ Belum Lunas</option>
                <option value="DP">🕐 DP</option>
            </select>
        </div>
        <div class="mb-4">
            <label class="form-label fw-semibold" style="font-size:12px">Metode Bayar</label>
            <select name="metode_bayar" class="form-select" style="font-size:13px">
                <option value="Tunai">💵 Tunai</option>
                <option value="Transfer">🏦 Transfer</option>
                <option value="COD">🚚 COD</option>
            </select>
        </div>
        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-madu">💾 Simpan Transaksi</button>
            <a href="{{ route('transaksi.index') }}" class="btn btn-outline-secondary">Batal</a>
        </div>
    </div>
</div>
</div>
</div>
        </form>

<template id="item-tpl">
    <div class="item-row border rounded-3 p-3 mb-2" style="background:#fafafa">
        <div class="row g-2 align-items-end">
            <div class="col-md-6">
                <label class="form-label fw-semibold" style="font-size:12px">Produk</label>
                <select name="produk_id[]" class="form-select produk-select" required style="font-size:13px">
                    <option value="">-- Pilih Produk --</option>
                    @foreach($produk as $p)
                    <option value="{{ $p->id_produk }}" data-harga="{{ $p->harga_jual }}" data-stok="{{ $p->stok }}">
                        {{ $p->nama_produk }} — {{ $p->ukuran_kemasan }} (Stok: {{ $p->stok }})
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold" style="font-size:12px">Qty</label>
                <input type="number" name="qty[]" class="form-control qty-input" min="1" value="1" required style="font-size:13px">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold" style="font-size:12px">Subtotal</label>
                <div class="form-control bg-light subtotal-display" style="font-size:13px;font-weight:600;color:#d97706">Rp 0</div>
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-outline-danger btn-sm w-100 btn-hapus">✕</button>
            </div>
        </div>
    </div>
</template>

<script>
function hitung() {
    let sub = 0;
    document.querySelectorAll('.item-row').forEach(row => {
        const sel  = row.querySelector('.produk-select');
        const qty  = parseInt(row.querySelector('.qty-input').value) || 0;
        const hrg  = sel.selectedIndex > 0 ? parseFloat(sel.options[sel.selectedIndex].dataset.harga) : 0;
        const s    = hrg * qty;
        row.querySelector('.subtotal-display').textContent = 'Rp ' + s.toLocaleString('id-ID');
        sub += s;
    });
    const ongkir = parseInt(document.getElementById('ongkir').value) || 0;
    document.getElementById('display-subtotal').textContent = 'Rp ' + sub.toLocaleString('id-ID');
    document.getElementById('display-grand').textContent    = 'Rp ' + (sub + ongkir).toLocaleString('id-ID');
}
function bind() {
    document.querySelectorAll('.produk-select,.qty-input').forEach(el => {
        el.onchange = hitung; el.oninput = hitung;
    });
    document.querySelectorAll('.btn-hapus').forEach(btn => {
        btn.onclick = function() {
            if (document.querySelectorAll('.item-row').length > 1) {
                this.closest('.item-row').remove(); hitung();
            }
        };
    });
}
document.getElementById('btn-tambah').onclick = () => {
    const tpl = document.getElementById('item-tpl').innerHTML;
    const d   = document.createElement('div');
    d.innerHTML = tpl;
    document.getElementById('item-container').appendChild(d.firstElementChild);
    bind();
};
document.getElementById('ongkir').oninput = hitung;
bind();
</script>
@endsection
