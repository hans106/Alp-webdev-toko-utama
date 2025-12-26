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
            'email' => 'superadmin@tokoUtama.com',
        ], [
            'name' => 'Owner (Super Admin)',
            'password' => Hash::make('superadmin123'),
            'role' => 'superadmin',
        ]);

        // 2. INVENTORY
        User::firstOrCreate([
            'email' => 'inventory@tokoUtama.com',
        ], [
            'name' => 'Staff Gudang',
            'password' => Hash::make('inventory123'),
            'role' => 'inventory',
        ]);

        // 3. CASHIER
        User::firstOrCreate([
            'email' => 'kasir@tokoUtama.com',
        ], [
            'name' => 'Staff Kasir',
            'password' => Hash::make('kasir123'),
            'role' => 'cashier',
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