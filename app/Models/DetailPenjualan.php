<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPenjualan extends Model
{
    protected $table    = 'detail_penjualan';
    public $timestamps  = false;

    protected $fillable = [
        'penjualan_id', 'produk_id', 'jumlah',
        'harga_jual', 'harga_beli', 'subtotal', 'laba_item',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'penjualan_id');
    }
}
