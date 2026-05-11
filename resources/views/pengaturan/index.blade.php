@extends('layouts.app')
@section('title','Pengaturan')
@section('page-title','Pengaturan')
@section('content')

{{-- Informasi Bisnis --}}
<p class="section-title">Informasi Bisnis</p>
<div class="card">
    <div style="display:flex;align-items:center;gap:16px;margin-bottom:16px">
        <div style="width:72px;height:72px;border-radius:16px;background:#fef3c7;display:flex;align-items:center;justify-content:center;font-size:36px;flex-shrink:0">🍯</div>
        <div style="flex:1">
            <h4 style="font-size:16px;font-weight:700;color:#3d2b1a;margin-bottom:4px">
                {{ $pengaturan->nama_bisnis ?? 'Dadi Madu' }}
            </h4>
            <p style="font-size:13px;color:#7a6152">{{ $pengaturan->nama_pemilik ?? '-' }}</p>
        </div>
    </div>

    <div style="display:grid;gap:10px">
        <div>
            <div style="font-size:11px;font-weight:700;color:#9b8878;text-transform:uppercase;letter-spacing:.05em;margin-bottom:2px">Nama Pemilik</div>
            <div style="font-size:14px;color:#3d2b1a">{{ $pengaturan->nama_pemilik ?? '-' }}</div>
        </div>
        <div>
            <div style="font-size:11px;font-weight:700;color:#9b8878;text-transform:uppercase;letter-spacing:.05em;margin-bottom:2px">Nomor Telepon</div>
            <div style="font-size:14px;color:#3d2b1a">{{ $pengaturan->nomor_telepon ?? '-' }}</div>
        </div>
        <div>
            <div style="font-size:11px;font-weight:700;color:#9b8878;text-transform:uppercase;letter-spacing:.05em;margin-bottom:2px">Alamat</div>
            <div style="font-size:14px;color:#3d2b1a">{{ $pengaturan->alamat ?? '-' }}</div>
        </div>
    </div>

    <a href="{{ route('pengaturan.edit') }}" class="btn btn-outline" style="margin-top:16px;display:inline-flex">
        ✏️ Ubah
    </a>
</div>

{{-- Ringkasan Bisnis --}}
<p class="section-title">Ringkasan Bisnis</p>
<div class="card">
    <div style="display:grid;gap:12px">
        <div style="display:flex;align-items:center;gap:12px">
            <span style="font-size:24px">📦</span>
            <div>
                <div style="font-size:13px;font-weight:600;color:#3d2b1a">Total Produk</div>
                <div style="font-size:13px;color:#7a6152">{{ $totalProduk }} Produk</div>
            </div>
        </div>
        <div style="display:flex;align-items:center;gap:12px">
            <span style="font-size:24px">👥</span>
            <div>
                <div style="font-size:13px;font-weight:600;color:#3d2b1a">Total Pelanggan</div>
                <div style="font-size:13px;color:#7a6152">{{ $totalPelanggan }} Pelanggan</div>
            </div>
        </div>
        <div style="display:flex;align-items:center;gap:12px">
            <span style="font-size:24px">🧾</span>
            <div>
                <div style="font-size:13px;font-weight:600;color:#3d2b1a">Total Transaksi</div>
                <div style="font-size:13px;color:#7a6152">{{ $totalTransaksi }} Transaksi</div>
            </div>
        </div>
    </div>
</div>

{{-- Pengguna Sistem --}}
<p class="section-title">Pengguna Sistem</p>
<div class="card" style="padding:0;overflow:hidden">
    @foreach($users as $u)
    <div style="display:flex;align-items:center;gap:12px;padding:14px 16px;border-bottom:1px solid #e8ddd5;{{ $loop->last ? 'border-bottom:none' : '' }}">
        <div style="width:40px;height:40px;border-radius:50%;background:#fef3c7;display:flex;align-items:center;justify-content:center;font-size:20px;flex-shrink:0">
            👤
        </div>
        <div style="flex:1">
            <div style="font-size:14px;font-weight:600;color:#3d2b1a">{{ $u->nama }}</div>
            <div style="font-size:12px;color:#7a6152;text-transform:capitalize">{{ $u->role }}</div>
        </div>
        <span class="badge {{ $u->id_user === auth()->user()->id_user ? 'badge-green' : 'badge-gray' }}">
            {{ $u->id_user === auth()->user()->id_user ? 'Aktif' : 'Lainnya' }}
        </span>
    </div>
    @endforeach
</div>

@endsection
