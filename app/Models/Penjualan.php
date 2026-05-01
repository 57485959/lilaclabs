<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $table = 'penjualan';

    protected $fillable = [
        'kode_transaksi', 'pelanggan_id', 'user_id', 'tanggal',
        'total_harga', 'total_hpp', 'laba_kotor', 'diskon',
        'status_bayar', 'metode_bayar', 'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function detail()
    {
        return $this->hasMany(DetailPenjualan::class, 'penjualan_id');
    }

    public static function generateKode(): string
    {
        $today = now()->format('Ymd');
        $last  = self::whereDate('tanggal', today())->count() + 1;
        return 'TRX-' . $today . '-' . str_pad($last, 3, '0', STR_PAD_LEFT);
    }
}
