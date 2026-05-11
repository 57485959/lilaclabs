<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Transaksi — {{ $transaksi->id_transaksi }}</title>
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        body{font-family:'Segoe UI',sans-serif;background:#f5ede0;min-height:100vh;padding:20px}
        .topbar{display:flex;align-items:center;gap:12px;margin-bottom:20px}
        .back-btn{font-size:14px;font-weight:600;color:#3d2b1a;text-decoration:none;display:flex;align-items:center;gap:6px}
        .topbar h2{font-size:18px;font-weight:700;color:#3d2b1a}
        .receipt{background:#fff;border-radius:16px;padding:24px;max-width:420px;margin:0 auto;border:1px solid #e8ddd5}
        .receipt-header{text-align:center;margin-bottom:20px;padding-bottom:16px;border-bottom:1px dashed #e8ddd5}
        .receipt-logo{font-size:36px;margin-bottom:6px}
        .receipt-header h3{font-size:18px;font-weight:700;color:#3d2b1a}
        .receipt-header p{font-size:12px;color:#9b8878}
        .receipt-row{display:flex;justify-content:space-between;padding:6px 0;font-size:13px;border-bottom:1px dashed #e8ddd5}
        .receipt-row .label{color:#7a6152}
        .receipt-row .value{font-weight:600;color:#3d2b1a;text-align:right}
        .receipt-items{margin:12px 0;border-top:1px dashed #e8ddd5;padding-top:12px}
        .receipt-item{margin-bottom:10px;font-size:13px}
        .receipt-item .item-name{font-weight:600;color:#3d2b1a;margin-bottom:2px}
        .receipt-item .item-detail{display:flex;justify-content:space-between;color:#7a6152}
        .receipt-total{border-top:1px dashed #e8ddd5;padding-top:12px;margin-top:12px}
        .total-row{display:flex;justify-content:space-between;font-size:14px;font-weight:700;color:#3d2b1a;margin-bottom:6px}
        .receipt-footer{text-align:center;margin-top:20px;padding-top:16px;border-top:1px dashed #e8ddd5;font-size:12px;color:#9b8878}
        .btn-cetak{width:100%;background:#f59e0b;color:#fff;border:none;border-radius:14px;padding:14px;font-size:15px;font-weight:700;cursor:pointer;margin-top:20px;display:flex;align-items:center;justify-content:center;gap:8px}
        .btn-cetak:hover{background:#d97706}
        @media print {
            body{background:#fff;padding:0}
            .topbar,.btn-cetak{display:none!important}
            .receipt{border:none;box-shadow:none;padding:0}
        }
    </style>
</head>
<body>
<div class="topbar">
    <a href="{{ route('transaksi.show', $transaksi->id_transaksi) }}" class="back-btn">← </a>
    <h2>Cetak Transaksi</h2>
</div>

<div class="receipt">
    <div class="receipt-header">
        <div class="receipt-logo">🍯</div>
        <h3>Dadi Madu</h3>
        <p>{{ $pengaturan->alamat ?? 'Alamat Usaha' }}</p>
    </div>

    <div class="receipt-row">
        <span class="label">ID Transaksi</span>
        <span class="value" style="font-family:monospace">{{ $transaksi->id_transaksi }}</span>
    </div>
    <div class="receipt-row">
        <span class="label">Tanggal Transaksi</span>
        <span class="value">{{ $transaksi->tanggal_transaksi?->format('d M Y H:i') }}</span>
    </div>
    <div class="receipt-row">
        <span class="label">Pelanggan</span>
        <span class="value">{{ $transaksi->pelanggan?->nama_pelanggan ?? 'Umum' }}</span>
    </div>
    <div class="receipt-row">
        <span class="label">Metode Bayar</span>
        <span class="value">{{ $transaksi->metode_bayar }}</span>
    </div>
    <div class="receipt-row">
        <span class="label">Status Bayar</span>
        <span class="value">{{ strtoupper($transaksi->status_bayar) }}</span>
    </div>
    <div class="receipt-row">
        <span class="label">Kasir</span>
        <span class="value">{{ $transaksi->user->nama }}</span>
    </div>

    <div class="receipt-items">
        <div style="font-size:12px;font-weight:700;color:#7a6152;display:grid;grid-template-columns:1fr auto auto;gap:8px;margin-bottom:8px;text-transform:uppercase">
            <span>Produk</span><span>QTY</span><span>Total</span>
        </div>
        @foreach($transaksi->detail as $d)
        <div class="receipt-item">
            <div style="display:grid;grid-template-columns:1fr auto auto;gap:8px;font-size:13px">
                <span style="font-weight:600;color:#3d2b1a">{{ $d->produk->nama_produk }}</span>
                <span style="color:#7a6152">{{ $d->qty }}</span>
                <span style="color:#3d2b1a;font-weight:600">{{ number_format($d->subtotal,0,',','.') }}</span>
            </div>
            <div style="font-size:11px;color:#9b8878">@ Rp {{ number_format($d->harga_saat_transaksi,0,',','.') }}</div>
        </div>
        @endforeach
    </div>

    <div class="receipt-total">
        <div class="total-row" style="font-weight:400;color:#7a6152">
            <span>Sub Total</span>
            <span>Rp{{ number_format($transaksi->subtotal,0,',','.') }}</span>
        </div>
        <div class="total-row" style="font-weight:400;color:#7a6152">
            <span>Ongkir</span>
            <span>Rp{{ number_format($transaksi->ongkir,0,',','.') }}</span>
        </div>
        <div class="total-row" style="font-size:16px">
            <span>TOTAL</span>
            <span style="color:#d97706">Rp{{ number_format($transaksi->grandtotal,0,',','.') }}</span>
        </div>
        @if($transaksi->uang_dibayar ?? false)
        <div class="total-row" style="font-weight:400;color:#7a6152">
            <span>Uang Dibayarkan</span>
            <span>Rp{{ number_format($transaksi->uang_dibayar,0,',','.') }}</span>
        </div>
        <div class="total-row">
            <span>Kembalian</span>
            <span>Rp{{ number_format($transaksi->uang_dibayar - $transaksi->grandtotal,0,',','.') }}</span>
        </div>
        @endif
    </div>

    <div class="receipt-footer">
        <p>Terima kasih telah berbelanja!</p>
        <p>Sehat selalu bersama madu alami.</p>
    </div>

    <button class="btn-cetak" onclick="window.print()">🖨️ Cetak Sekarang</button>
</div>
</body>
</html>
