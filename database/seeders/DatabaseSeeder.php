<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Panggil teman-temannya di sini secara berurutan
        $this->call([
            UserSeeder::class,      // Bikin User
            ProductSeeder::class,   // Bikin Kategori, Brand, & Produk
            EmployeeSeeder::class,  // Bikin Karyawan
            SupplierSeeder::class,  // Bikin Supplier
            RestockSeeder::class,   // Bikin Data Restock
            EventSeeder::class,     // Bikin Event (Yang baru tadi)
        ]);
    }
}