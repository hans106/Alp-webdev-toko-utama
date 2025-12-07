<?php

use Illuminate\Support\Facades\Route;
// Panggil Controller Front (Punya Teman & Abang buat Guest)
use App\Http\Controllers\Front\CatalogController;
// Panggil Controller Admin (Punya Abang buat Create Data)
use App\Http\Controllers\Admin\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di sini tempat mendaftarkan semua alamat URL website Toko Utama.
|
*/

// ==========================================
// 1. AREA DEPAN (GUEST / PEMBELI)
// ==========================================

// Halaman Utama (Home) -> Tampilan sambutan toko
Route::get('/', [CatalogController::class, 'home'])->name('home');

// Halaman Katalog -> List semua rokok, sembako, dll
Route::get('/katalog', [CatalogController::class, 'index'])->name('catalog');

// Halaman Detail Produk -> Klik salah satu barang
Route::get('/produk/{slug}', [CatalogController::class, 'show'])->name('front.product');


// ==========================================
// 2. AREA BELAKANG (ADMIN / KELUARGA)
// ==========================================

// Kita grup pakai prefix 'admin' biar URL-nya rapi (contoh: /admin/products)
Route::prefix('admin')->name('admin.')->group(function () {
    
    // Halaman Dashboard List Produk (READ Admin)
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');

    // Halaman Form Tambah Produk (CREATE)
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');

    // Proses Simpan Data ke Database (STORE)
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');

});