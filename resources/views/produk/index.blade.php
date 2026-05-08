@extends('layouts.app')
@section('title','Master Produk')
@section('page-title','Master Produk')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div style="color:#6c757d;font-size:13px">Daftar semua produk madu</div>
    <a href="{{ route('produk.create') }}" class="btn btn-madu">+ Tambah Produk</a>
</div>
<div class="card">
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr><th class="ps-3">Nama Produk</th><th>Jenis Asal</th><th>Kemasan</th><th>Harga Jual</th><th>Harga Modal</th><th>Stok</th><th>Min. Stok</th><th>Status Stok</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                @forelse($produk as $p)
                <tr>
                    <td class="ps-3" style="font-size:13px;font-weight:500">{{ $p->nama_produk }}</td>
                    <td><span class="badge {{ $p->jenis_asal=='Ternak'?'badge-aman':'badge-menipis' }}" style="font-size:11px">{{ $p->jenis_asal }}</span></td>
                    <td style="font-size:13px">{{ $p->ukuran_kemasan }}</td>
                    <td style="font-size:13px;font-weight:600;color:#d97706">Rp {{ number_format($p->harga_jual,0,',','.') }}</td>
                    <td style="font-size:13px;color:#6c757d">Rp {{ number_format($p->harga_modal,0,',','.') }}</td>
                    <td style="font-size:13px;font-weight:700">{{ number_format($p->stok) }}</td>
                    <td style="font-size:12px;color:#6c757d">{{ $p->minimum_stok }}</td>
                    <td><span class="badge badge-{{ $p->status_stok }}" style="font-size:11px">{{ ucfirst($p->status_stok) }}</span></td>
                    <td>
                        <a href="{{ route('produk.edit', $p->id_produk) }}" class="btn btn-sm btn-outline-warning" style="font-size:11px">Edit</a>
                        <form action="{{ route('produk.destroy', $p->id_produk) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus produk ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" style="font-size:11px">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="9" class="text-center text-muted py-4">Belum ada produk</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
