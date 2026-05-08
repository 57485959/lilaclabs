<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table      = 'user';
    protected $primaryKey = 'id_user';
    public $timestamps = false;

    protected $fillable = [
        'nama', 'username', 'password', 'role',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function casts(): array
    {
        return ['password' => 'hashed'];
    }

    public function isPemilik(): bool
    {
        return $this->role === 'pemilik';
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id_user', 'id_user');
    }

    public function pembelianStok()
    {
        return $this->hasMany(PembelianStok::class, 'id_user', 'id_user');
    }

    public function pengeluaran()
    {
        return $this->hasMany(Pengeluaran::class, 'id_user', 'id_user');
    }
}
