<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk';

    protected $fillable = [
        'nama_produk', 'satuan', 'harga_jual', 'harga_beli',
        'stok', 'stok_minimum', 'deskripsi', 'status',
    ];

    public function stokMasuk()
    {
        return $this->hasMany(StokMasuk::class, 'produk_id');
    }

    public function detailPenjualan()
    {
        return $this->hasMany(DetailPenjualan::class, 'produk_id');
    }

    public function getStatusStokAttribute(): string
    {
        if ($this->stok == 0) return 'habis';
        if ($this->stok <= $this->stok_minimum) return 'menipis';
        return 'aman';
    }
}
