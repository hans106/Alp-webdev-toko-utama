<?php

use Illuminate\Support\Facades\Route;

// ==========================================
// DAFTAR IMPORT CONTROLLER
// ==========================================
use App\Http\Controllers\AuthController; 
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\EmployeeController; // Pastikan ini ada

// 1. Controller Area Depan (Pembeli)
use App\Http\Controllers\Front\CatalogController;
use App\Http\Controllers\Front\PageController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\Front\OrderController as FrontOrderController; 

// 2. Controller Area Belakang (Admin)
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\RestockController;
use App\Http\Controllers\Admin\UserController; // Pastikan ini ada
use App\Http\Controllers\Admin\EventController;


// ==========================================
// 1. AREA PUBLIK (Bisa Diakses Siapa Saja)
// ==========================================

Route::get('/', [CatalogController::class, 'home'])->name('home');
Route::get('/tentang-kami', [PageController::class, 'about'])->name('about');
Route::get('/katalog', [CatalogController::class, 'index'])->name('catalog');
Route::get('/produk/{slug}', [CatalogController::class, 'show'])->name('front.product');

// Authentication
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// ==========================================
// 2. AREA MEMBER (Pembeli Login)
// ==========================================

Route::middleware(['auth'])->group(function () {
    
    // Keranjang
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [CartController::class, 'store'])->name('cart.store');
    Route::put('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/delete/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
    
    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');

    // Riwayat
    Route::get('/my-orders', [FrontOrderController::class, 'index'])->name('orders.index');
    Route::get('/my-orders/{id}', [FrontOrderController::class, 'show'])->name('orders.show');
});


// ==========================================
// 3. AREA ADMIN PANEL
// ==========================================


Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {

    // --------------------------------------------------------
    // GROUP 1: KHUSUS SUPER ADMIN (Full Access)
    // --------------------------------------------------------
    Route::middleware(['role:superadmin'])->group(function () {
        
        // 1. Dashboard Utama
        Route::get('/', [ProductController::class, 'dashboard'])->name('dashboard');
        // 2. Manajemen User (INI YANG ABANG CARI)
        // Pakai resource biar lengkap (Index, Create, Edit, Delete)
        Route::resource('users', UserController::class);
        // 3. Manajemen Pegawai (Employee - Profil Web)
        Route::resource('employees', EmployeeController::class)->except(['create', 'edit', 'show']);
        // 4. Manajemen Event
        Route::resource('events', EventController::class)->except(['create', 'edit', 'show']);
        // 5. Activity Log (CCTV System)
        Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity_logs.index');
    });

    // --------------------------------------------------------
    // GROUP 2: DIVISI GUDANG (Inventory + Super Admin)
    // --------------------------------------------------------
    Route::prefix('products')->name('products.')->middleware('role:superadmin,inventory')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/', [ProductController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ProductController::class, 'update'])->name('update');
        Route::delete('/{id}', [ProductController::class, 'destroy'])->name('destroy');
    });

    // Supplier
    Route::prefix('suppliers')->name('suppliers.')->middleware('role:superadmin,inventory')->group(function () {
        Route::get('/', [SupplierController::class, 'index'])->name('index');
        Route::get('/create', [SupplierController::class, 'create'])->name('create');
        Route::post('/', [SupplierController::class, 'store'])->name('store');
        Route::get('/{supplier}', [SupplierController::class, 'show'])->name('show');
        Route::get('/{supplier}/edit', [SupplierController::class, 'edit'])->name('edit');
        Route::put('/{supplier}', [SupplierController::class, 'update'])->name('update');
        Route::delete('/{supplier}', [SupplierController::class, 'destroy'])->name('destroy');
    });

    // Restock
    Route::prefix('restocks')->name('restocks.')->middleware('role:superadmin,inventory')->group(function () {
        Route::get('/', [RestockController::class, 'index'])->name('index');
        Route::get('/create', [RestockController::class, 'create'])->name('create');
        Route::post('/', [RestockController::class, 'store'])->name('store');
        Route::get('/{restock}', [RestockController::class, 'show'])->name('show');
        Route::get('/{restock}/edit', [RestockController::class, 'edit'])->name('edit');
        Route::put('/{restock}', [RestockController::class, 'update'])->name('update');
        Route::delete('/{restock}', [RestockController::class, 'destroy'])->name('destroy');
    });
    // --------------------------------------------------------
    // GROUP 3: DIVISI KASIR (Cashier + Super Admin)
    // --------------------------------------------------------
    Route::get('/orders', [AdminOrderController::class, 'index'])
        ->name('orders.index')
        ->middleware('role:superadmin,cashier');
        
    Route::post('/orders/{id}/ship', [AdminOrderController::class, 'ship'])
        ->name('orders.ship')
        ->middleware('role:superadmin,cashier');

});