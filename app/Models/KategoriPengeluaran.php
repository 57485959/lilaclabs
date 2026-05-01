<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriPengeluaran extends Model
{
    protected $table    = 'kategori_pengeluaran';
    public $timestamps  = false;

    protected $fillable = ['nama_kategori', 'deskripsi'];

    public function pengeluaran()
    {
        return $this->hasMany(Pengeluaran::class, 'kategori_id');
    }
}
