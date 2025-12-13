<?php

use Illuminate\Support\Facades\Route;
// Panggil Controller Front (Punya Teman & Abang buat Guest)
use App\Http\Controllers\Front\CatalogController;
// Panggil Controller Admin (Punya Abang buat Create Data)
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Front\PageController;


// ==========================================
// 1. AREA DEPAN (GUEST / PEMBELI)
// ==========================================

// Halaman Utama (Home) -> Tampilan sambutan toko
Route::get('/', [CatalogController::class, 'home'])->name('home');
Route::get('/tentang-kami', [PageController::class, 'about'])->name('about');

use App\Http\Controllers\AuthController;

// --- AUTHENTICATION ---
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
// Halaman Katalog -> List semua rokok, sembako, dll
Route::get('/katalog', [CatalogController::class, 'index'])->name('catalog');
// Halaman Detail Produk -> Klik salah satu barang
Route::get('/produk/{slug}', [CatalogController::class, 'show'])->name('front.product');


// ==========================================
// 2. AREA BELAKANG (ADMIN / KELUARGA)
// ==========================================


Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/products', [App\Http\Controllers\Admin\ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [App\Http\Controllers\Admin\ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [App\Http\Controllers\Admin\ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [App\Http\Controllers\Admin\ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [App\Http\Controllers\Admin\ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [App\Http\Controllers\Admin\ProductController::class, 'destroy'])->name('products.destroy');
});



// --- ROUTE KERANJANG (Harus Login) ---
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [App\Http\Controllers\Front\CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [App\Http\Controllers\Front\CartController::class, 'store'])->name('cart.store');
    Route::put('/cart/update/{id}', [App\Http\Controllers\Front\CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/delete/{id}', [App\Http\Controllers\Front\CartController::class, 'destroy'])->name('cart.destroy');
    
    Route::get('/orders', [App\Http\Controllers\Front\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [App\Http\Controllers\Front\OrderController::class, 'show'])->name('orders.show');

    // --- ROUTE CHECKOUT (Harus Login) ---
Route::get('/checkout', [App\Http\Controllers\Front\CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [App\Http\Controllers\Front\CheckoutController::class, 'process'])->name('checkout.process');
});
