@extends('layouts.app')
@section('title','Pengeluaran')
@section('page-title','Pencatatan Pengeluaran')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div style="color:#6c757d;font-size:13px">Catatan biaya & pengeluaran operasional</div>
    <a href="{{ route('pengeluaran.create') }}" class="btn btn-madu">+ Catat Pengeluaran</a>
</div>
<div class="card">
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead><tr><th class="ps-3">Tanggal</th><th>Kategori</th><th>Keterangan</th><th>Jumlah</th><th>Dicatat Oleh</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse($pengeluaran as $p)
                <tr>
                    <td class="ps-3" style="font-size:13px">{{ $p->tanggal->format('d/m/Y') }}</td>
                    <td><span class="badge badge-menipis" style="font-size:11px">{{ $p->kategori->nama_kategori }}</span></td>
                    <td style="font-size:13px">{{ $p->keterangan }}</td>
                    <td style="font-size:13px;font-weight:600;color:#ef4444">Rp {{ number_format($p->jumlah,0,',','.') }}</td>
                    <td style="font-size:12px;color:#6c757d">{{ $p->user->nama }}</td>
                    <td>
                        <form action="{{ route('pengeluaran.destroy',$p->id) }}" method="POST" onsubmit="return confirm('Hapus data ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" style="font-size:11px">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">Belum ada catatan pengeluaran</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($pengeluaran->hasPages())
    <div class="card-footer bg-white">{{ $pengeluaran->links() }}</div>
    @endif
</div>
@endsection
