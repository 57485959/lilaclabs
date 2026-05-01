@extends('layouts.app')
@section('title','Penjualan')
@section('page-title','Pencatatan Penjualan')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <div style="color:#6c757d;font-size:13px">Riwayat transaksi penjualan madu</div>
    <a href="{{ route('penjualan.create') }}" class="btn btn-madu">+ Catat Penjualan</a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th class="ps-3">Kode Transaksi</th>
                    <th>Tanggal</th>
                    <th>Pelanggan</th>
                    <th>Total</th>
                    <th>Laba Kotor</th>
                    <th>Bayar</th>
                    <th>Metode</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($penjualan as $p)
                <tr>
                    <td class="ps-3" style="font-family:monospace;font-size:12px">{{ $p->kode_transaksi }}</td>
                    <td style="font-size:13px">{{ $p->tanggal->format('d/m/Y') }}</td>
                    <td style="font-size:13px">{{ $p->pelanggan?->nama ?? 'Umum' }}</td>
                    <td style="font-size:13px;font-weight:600">Rp {{ number_format($p->total_harga,0,',','.') }}</td>
                    <td style="font-size:13px;color:#10b981;font-weight:600">Rp {{ number_format($p->laba_kotor,0,',','.') }}</td>
                    <td>
                        <span class="badge {{ $p->status_bayar=='lunas' ? 'badge-aman' : ($p->status_bayar=='dp' ? 'badge-menipis' : 'badge-habis') }}" style="font-size:11px">
                            {{ ucfirst($p->status_bayar) }}
                        </span>
                    </td>
                    <td style="font-size:12px;color:#6c757d">{{ ucfirst($p->metode_bayar) }}</td>
                    <td>
                        <a href="{{ route('penjualan.show',$p->id) }}" class="btn btn-sm btn-outline-secondary" style="font-size:11px">Detail</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center text-muted py-4">Belum ada transaksi penjualan</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($penjualan->hasPages())
    <div class="card-footer bg-white">{{ $penjualan->links() }}</div>
    @endif
</div>
@endsection
