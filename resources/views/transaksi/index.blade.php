@extends('layouts.app')
@section('title','Transaksi')
@section('page-title','Transaksi Penjualan')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div style="color:#6c757d;font-size:13px">Riwayat semua transaksi penjualan</div>
    <a href="{{ route('transaksi.create') }}" class="btn btn-madu">+ Catat Transaksi</a>
</div>
<div class="card">
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th class="ps-3">No. Invoice</th>
                    <th>Tanggal</th>
                    <th>Pelanggan</th>
                    <th>Subtotal</th>
                    <th>Ongkir</th>
                    <th>Grandtotal</th>
                    <th>Metode</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksi as $t)
                <tr>
                    <td class="ps-3" style="font-family:monospace;font-size:12px">{{ $t->id_transaksi }}</td>
                    <td style="font-size:13px">{{ $t->tanggal_transaksi->format('d/m/Y') }}</td>
                    <td style="font-size:13px">{{ $t->pelanggan?->nama_pelanggan ?? 'Umum' }}</td>
                    <td style="font-size:13px">Rp {{ number_format($t->subtotal,0,',','.') }}</td>
                    <td style="font-size:13px;color:#6c757d">Rp {{ number_format($t->ongkir,0,',','.') }}</td>
                    <td style="font-size:13px;font-weight:600;color:#d97706">Rp {{ number_format($t->grandtotal,0,',','.') }}</td>
                    <td style="font-size:12px">{{ $t->metode_bayar }}</td>
                    <td>
                        <span class="badge {{ $t->status_bayar=='Lunas' ? 'badge-aman' : 'badge-menipis' }}" style="font-size:11px">
                            {{ $t->status_bayar }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('transaksi.show', $t->id_transaksi) }}" class="btn btn-sm btn-outline-secondary" style="font-size:11px">Detail</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="9" class="text-center text-muted py-4">Belum ada transaksi</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($transaksi->hasPages())
    <div class="card-footer bg-white">{{ $transaksi->links() }}</div>
    @endif
</div>
@endsection
