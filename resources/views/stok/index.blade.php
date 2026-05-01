@extends('layouts.app')
@section('title','Stok Masuk')
@section('page-title','Pencatatan Stok Masuk')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <div style="color:#6c757d;font-size:13px">Riwayat penambahan stok (panen & pembelian)</div>
    <a href="{{ route('stok.create') }}" class="btn btn-madu">+ Catat Stok Masuk</a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th class="ps-3">Tanggal</th>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Harga Beli/Unit</th>
                    <th>Total Biaya</th>
                    <th>Sumber</th>
                    <th>Dicatat Oleh</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($stokMasuk as $s)
                <tr>
                    <td class="ps-3" style="font-size:13px">{{ $s->tanggal->format('d/m/Y') }}</td>
                    <td style="font-size:13px;font-weight:500">{{ $s->produk->nama_produk }}</td>
                    <td style="font-size:13px">{{ number_format($s->jumlah) }} {{ $s->produk->satuan }}</td>
                    <td style="font-size:13px">Rp {{ number_format($s->harga_beli_per_unit,0,',','.') }}</td>
                    <td style="font-size:13px;font-weight:600;color:#d97706">Rp {{ number_format($s->total_biaya,0,',','.') }}</td>
                    <td>
                        <span class="badge {{ $s->sumber == 'panen' ? 'badge-aman' : 'badge-menipis' }}" style="font-size:11px">
                            {{ ucfirst($s->sumber) }}
                        </span>
                    </td>
                    <td style="font-size:12px;color:#6c757d">{{ $s->user->nama }}</td>
                    <td style="font-size:12px;color:#6c757d">{{ $s->keterangan ?? '-' }}</td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center text-muted py-4">Belum ada catatan stok masuk</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($stokMasuk->hasPages())
    <div class="card-footer bg-white">{{ $stokMasuk->links() }}</div>
    @endif
</div>
@endsection
