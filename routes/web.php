<?php

use Illuminate\Support\Facades\Route;

// ==========================================
// DAFTAR IMPORT CONTROLLER
// ==========================================

// 1. Controller Area Depan (Pembeli)
use App\Http\Controllers\Front\CatalogController;
use App\Http\Controllers\Front\PageController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\Front\OrderController as FrontOrderController; // Saya kasih alias biar gak bingung
use App\Http\Controllers\AuthController;

// 2. Controller Area Belakang (Admin)
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\RestockController;


// ==========================================
// 1. AREA PUBLIK (Bisa Diakses Siapa Saja)
// ==========================================

// Halaman Utama & Info
Route::get('/', [CatalogController::class, 'home'])->name('home');
Route::get('/tentang-kami', [PageController::class, 'about'])->name('about');

// Halaman Katalog & Produk
Route::get('/katalog', [CatalogController::class, 'index'])->name('catalog');
Route::get('/produk/{slug}', [CatalogController::class, 'show'])->name('front.product');

// Authentication (Login/Register)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// ==========================================
// 2. AREA MEMBER (Pembeli Login)
// ==========================================
// Middleware 'auth' = Wajib Login dulu baru bisa masuk sini

Route::middleware(['auth'])->group(function () {
    
    // --- FITUR KERANJANG ---
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [CartController::class, 'store'])->name('cart.store');
    Route::put('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/delete/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
    
    // --- FITUR CHECKOUT & BAYAR ---
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');

    // --- RIWAYAT BELANJA (Punya Pembeli) ---
    // Perhatikan: Ini pakai FrontOrderController
    Route::get('/my-orders', [FrontOrderController::class, 'index'])->name('orders.index');
    Route::get('/my-orders/{id}', [FrontOrderController::class, 'show'])->name('orders.show');
});


// ==========================================
// 3. AREA ADMIN (Bos & Karyawan)
// ==========================================
// Middleware: authenticated users can enter /admin, specific sub-areas require role checks

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {

    // --- DIVISI 1: DASHBOARD (Executive Summary) ---
    // Accessible by superadmin and admin
    Route::get('/', [ProductController::class, 'dashboard'])->name('dashboard')->middleware('role:superadmin,admin');

    // --- DIVISI 2: GUDANG (Management Stock) ---
    // Accessible by superadmin and inventory staff
    Route::prefix('products')->name('products.')->middleware('role:superadmin,inventory')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/', [ProductController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ProductController::class, 'update'])->name('update');
        Route::delete('/{id}', [ProductController::class, 'destroy'])->name('destroy');
    });

    // --- DIVISI 2B: SUPPLIER MANAGEMENT ---
    // Accessible by superadmin and inventory staff
    Route::prefix('suppliers')->name('suppliers.')->middleware('role:superadmin,inventory')->group(function () {
        Route::get('/', [SupplierController::class, 'index'])->name('index');
        Route::get('/create', [SupplierController::class, 'create'])->name('create');
        Route::post('/', [SupplierController::class, 'store'])->name('store');
        Route::get('/{supplier}', [SupplierController::class, 'show'])->name('show');
        Route::get('/{supplier}/edit', [SupplierController::class, 'edit'])->name('edit');
        Route::put('/{supplier}', [SupplierController::class, 'update'])->name('update');
        Route::delete('/{supplier}', [SupplierController::class, 'destroy'])->name('destroy');
    });

    // --- DIVISI 2C: RESTOCK MANAGEMENT ---
    // Accessible by superadmin and inventory staff
    Route::prefix('restocks')->name('restocks.')->middleware('role:superadmin,inventory')->group(function () {
        Route::get('/', [RestockController::class, 'index'])->name('index');
        Route::get('/create', [RestockController::class, 'create'])->name('create');
        Route::post('/', [RestockController::class, 'store'])->name('store');
        Route::get('/{restock}', [RestockController::class, 'show'])->name('show');
        Route::get('/{restock}/edit', [RestockController::class, 'edit'])->name('edit');
        Route::put('/{restock}', [RestockController::class, 'update'])->name('update');
        Route::delete('/{restock}', [RestockController::class, 'destroy'])->name('destroy');
    });

    // --- DIVISI 3: KASIR (Order Management) ---
    // Accessible by superadmin and cashier
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index')->middleware('role:superadmin,cashier');
    Route::post('/orders/{id}/ship', [AdminOrderController::class, 'ship'])->name('orders.ship')->middleware('role:superadmin,cashier');

});