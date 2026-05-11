<?php

namespace Database\Seeders;

use App\Models\Pengaturan;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'nama' => 'Administrator',
                'password' => Hash::make('password123'),
                'role' => 'pemilik',
            ]
        );

        Pengaturan::updateOrCreate(
            ['id' => 1],
            [
                'nama_bisnis' => 'Dadi Madu',
                'nama_pemilik' => 'Pemilik Dadi Madu',
                'nomor_telepon' => null,
                'alamat' => null,
            ]
        );
    }
}
