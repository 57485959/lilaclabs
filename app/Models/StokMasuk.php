<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StokMasuk extends Model
{
    protected $table = 'stok_masuk';
    public $timestamps = false;

    protected $fillable = [
        'produk_id', 'user_id', 'tanggal', 'jumlah',
        'harga_beli_per_unit', 'total_biaya', 'sumber', 'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
