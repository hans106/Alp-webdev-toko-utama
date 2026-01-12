<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash; // Wajib ada biar Hash::make jalan

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. SUPER ADMIN (Role: master)
        User::updateOrCreate([
            'email' => 'master@tokoUtama.com', // Kunci pencarian
        ], [
            'name' => 'Master Admin',
            'password' => Hash::make('master123'), // Kita HASH manual disini
            'role' => 'master',
            'email_verified_at' => now(),
        ]);

        // 2. STAFF GUDANG (Role: inventory)
        User::updateOrCreate([
            'email' => 'inventory@tokoUtama.com',
        ], [
            'name' => 'Staff Gudang',
            'password' => Hash::make('inventory123'),
            'role' => 'inventory',
            'email_verified_at' => now(),
        ]);

        // 3. ADMIN PENJUALAN (Role: admin_penjualan)
        User::updateOrCreate([
            'email' => 'penjualan@tokoUtama.com',
        ], [
            'name' => 'Staff Kasir',
            'password' => Hash::make('penjualan123'),
            'role' => 'admin_penjualan',
            'email_verified_at' => now(),
        ]);

        // 4. CUSTOMER CONTOH
        User::updateOrCreate([
            'email' => 'budi@gmail.com',
        ], [
            'name' => 'Budi Pembeli',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);
    }
}