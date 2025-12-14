<?php

use Illuminate\Support\Facades\Route;

// --- IMPORT CONTROLLER ---
use App\Http\Controllers\Front\CatalogController;
use App\Http\Controllers\Front\PageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\OrderController;
use App\Http\Controllers\Front\CheckoutController;


// ==========================================
// 1. AREA DEPAN (GUEST / PEMBELI)
// ==========================================

// Halaman Utama (Home) -> Tampilan sambutan toko
Route::get('/', [CatalogController::class, 'home'])->name('home');
Route::get('/tentang-kami', [PageController::class, 'about'])->name('about');


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


Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    
    // Dashboard Admin dengan Search & Filter
    Route::get('/', [ProductController::class, 'dashboard'])->name('dashboard');
    
    // Manage Products dengan prefix route name 'admin.products.*'
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/', [ProductController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ProductController::class, 'update'])->name('update');
        Route::delete('/{id}', [ProductController::class, 'destroy'])->name('destroy');
    });

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
