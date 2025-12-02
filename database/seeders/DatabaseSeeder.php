<?php

namespace Database\Seeders;

// --- BAGIAN INI YANG TADI KURANG BANG ---
use App\Models\User;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // <--- INI OBATNYA
use App\Models\Product;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        // User::factory(10)->create();

        // Admin akun (Father)
        User::create([
            'name' => 'Admin',
            'email' => 'admin@tokoUtama.com',
            'password' => Hash::make('admin123'), // Passwordnya ini
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Hansvere',
            'email' => 'hansvere@tokoUtama.com',
            'password' => Hash::make('hansvere123'), // Passwordnya ini
            'role' => 'admin',
        ]);
        // 3. Bikin Akun Customer (Contoh Pembeli)
        User::create([
            'name' => 'Budi Pembeli',
            'email' => 'budi@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);

        // 4. Bikin Kategori Awal (Biar gak kosong pas input barang)
        Category::create(['name' => 'Sembako', 'slug' => 'sembako']);
        Category::create(['name' => 'Minuman', 'slug' => 'minuman']);
        Category::create(['name' => 'Jajanan', 'slug' => 'jajanan']);
        Category::create(['name' => 'Sabun & Deterjen', 'slug' => 'sabun-deterjen']);

        // 5. Bikin Brand Awal
        Brand::create(['name' => 'Indofood', 'slug' => 'indofood']);
        Brand::create(['name' => 'Unilever', 'slug' => 'unilever']);
        Brand::create(['name' => 'Wings Food', 'slug' => 'wings-food']);
        Brand::create(['name' => 'Mayora', 'slug' => 'mayora']);
        
                // Produk Asli 1
        Product::create([
            'name' => 'Djarum 76',
            'slug' => 'Rokok Djarum 76',
            'category_id' => 1, // Pastikan ID kategori Sembako/Mie
            'brand_id' => 1, // Pastikan ID Indofood
            'price' => 50000,
            'stock' => 100,
            'description' => 'Peringatan: Rokok mengandung zat adiktif yang berbahaya bagi kesehatan.',
            'image' => 'djarum76.jpg' // File gambarnya abang taruh manual di folder public
        ]);
        // Produk Asli 2
        Product::create([
            'name' => 'Teh Botol Sosro',
            'slug' => 'Teh Botol Sosro 500ml',
            'category_id' => 2, // Pastikan ID kategori Minuman
            'brand_id' => 2, // Pastikan ID Unilever
            'price' => 7000,
            'stock' => 200,
            'description' => 'Teh Botol Sosro adalah minuman teh siap saji yang menyegarkan.',
            'image' => 'tehbotol.jpg' // File gambarnya abang taruh manual di folder public
        ]);

    }
}
