<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. SUPER ADMIN
        User::firstOrCreate([
            'email' => 'master@tokoUtama.com',
        ], [
            'name' => 'Owner (Super Admin)',
            'password' => Hash::make('master123'),
            'role' => 'master',
        ]);

        // 2. INVENTORY
        User::firstOrCreate([
            'email' => 'inventory@tokoUtama.com',
        ], [
            'name' => 'Staff Gudang',
            'password' => Hash::make('inventory123'),
            'role' => 'inventory',
        ]);

        // 3. ADMIN PENJUALAN
        User::firstOrCreate([
            'email' => 'penjualan@tokoUtama.com',
        ], [
            'name' => 'Staff Kasir',
            'password' => Hash::make('penjualan123'),
            'role' => 'admin_penjualan',
        ]);

        // 4. CUSTOMER
        User::firstOrCreate([
            'email' => 'budi@gmail.com',
        ], [
            'name' => 'Budi Pembeli',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);
    }
}