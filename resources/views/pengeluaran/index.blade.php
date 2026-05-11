@extends('layouts.app')
@section('title','Pengeluaran')
@section('page-title','Pengeluaran')
@section('content')

<div class="page-header">
    <h2>Pengeluaran</h2>
    <p>Catatan biaya operasional bisnis</p>
</div>

@forelse($pengeluaran as $p)
<div class="trx-card">
    <div class="trx-row">
        <div>
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px">
                <span class="badge badge-amber">{{ $p->kategori }}</span>
                <span style="font-size:12px;color:#7a6152">📅 {{ $p->tanggal?->format('d M Y') }}</span>
            </div>
            <div style="font-size:13px;color:#3d2b1a">{{ $p->keterangan }}</div>
            <div style="font-size:11px;color:#9b8878;margin-top:4px">Dicatat: {{ $p->user->nama }}</div>
        </div>
        <div style="text-align:right;flex-shrink:0">
            <div style="font-size:16px;font-weight:700;color:#ef4444">
                Rp {{ number_format($p->jumlah_pengeluaran,0,',','.') }}
            </div>
        </div>
    </div>
    <div style="margin-top:10px">
        <form action="{{ route('pengeluaran.destroy', $p->id_pengeluaran) }}" method="POST"
              onsubmit="return confirm('Hapus data ini?')">
            @csrf @method('DELETE')
            <button class="btn btn-danger" style="font-size:12px;padding:6px 14px">🗑️ Hapus</button>
        </form>
    </div>
</div>
@empty
<div style="text-align:center;padding:40px 0;color:#9b8878">
    <div style="font-size:40px;margin-bottom:8px">💸</div>
    <p>Belum ada catatan pengeluaran</p>
</div>
@endforelse

@if($pengeluaran->hasPages())
<div style="margin-top:8px">{{ $pengeluaran->links() }}</div>
@endif

<button class="fab" onclick="window.location='{{ route('pengeluaran.create') }}'">+</button>
@endsection
