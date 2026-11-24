<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Purpose; // Ini penting agar garis merah hilang
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat Akun Admin
        // Menggunakan firstOrCreate agar tidak error jika dijalankan berulang
        User::firstOrCreate(
            ['email' => 'admin@bsi.co.id'],
            [
                'name' => 'Administrator BSI',
                'password' => Hash::make('passwordbaru123'),
            ]
        );

        // 2. Buat Data Tujuan Kunjungan
        $purposes = [
            'Maintenance Server',
            'Pengecekan Jaringan',
            'Audit Rutin',
            'Instalasi Perangkat',
            'Lainnya'
        ];

        foreach ($purposes as $p) {
            Purpose::firstOrCreate(['name' => $p]);
        }
    }
}
