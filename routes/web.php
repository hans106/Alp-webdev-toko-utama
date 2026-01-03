<?php

use Illuminate\Support\Facades\Route;

// ==========================================
// DAFTAR IMPORT CONTROLLER
// ==========================================
use App\Http\Controllers\AuthController; 
use App\Http\Controllers\Admin\EmployeeController; // Pastikan ini ada

// 1. Controller Area Depan (Pembeli)
use App\Http\Controllers\Front\CatalogController;
use App\Http\Controllers\Front\PageController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\Front\OrderController as FrontOrderController; 
use App\Http\Controllers\Front\ProductInteractionController;
use App\Http\Controllers\Front\FavoritesController;

// 2. Controller Area Belakang (Admin)
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\RestockController;
use App\Http\Controllers\Admin\RestockVerificationController;
use App\Http\Controllers\Admin\UserController; // Pastikan ini ada
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\API\MidtransCallbackController;


// ==========================================
// 1. AREA PUBLIK (Bisa Diakses Siapa Saja)
// ==========================================

Route::get('/', [CatalogController::class, 'home'])->name('home');
Route::get('/tentang-kami', [PageController::class, 'about'])->name('about');
Route::get('/katalog', [CatalogController::class, 'index'])->name('catalog');
Route::get('/produk/{slug}', [CatalogController::class, 'show'])->name('front.product');

// Product interactions: reviews and favorites
Route::post('/produk/{id}/review', [ProductInteractionController::class, 'storeReview'])
    ->name('product.review.store')->middleware('auth');

Route::post('/produk/{id}/favorite', [ProductInteractionController::class, 'toggleFavorite'])
    ->name('product.favorite.toggle')->middleware('auth');

// Favorites modal endpoints
Route::get('/favorites/list', [FavoritesController::class, 'list'])
    ->name('favorites.list')->middleware('auth');
Route::delete('/favorites/remove/{wishlistId}', [FavoritesController::class, 'remove'])
    ->name('favorites.remove')->middleware('auth');

// Authentication
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ==========================================
// MIDTRANS CALLBACK (Public - Tanpa Auth)
// ==========================================
Route::post('/midtrans-callback', [MidtransCallbackController::class, 'callback'])
    ->name('midtrans.callback')
    ->withoutMiddleware(['web']);  // Bypass CSRF jika diperlukan


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

    Route::get('/my-orders/reset-token/{id}', [FrontOrderController::class, 'resetToken'])->name('orders.reset');
});


// ==========================================
// 3. AREA ADMIN PANEL
// ==========================================


Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {

    // Dashboard accessible by all 3 admin roles (superadmin, inventory, cashier)
    Route::get('/', [ProductController::class, 'dashboard'])->name('dashboard')->middleware('role:superadmin,inventory,cashier');

    // --------------------------------------------------------
    // GROUP 1: KHUSUS SUPER ADMIN (Full Access)
    // --------------------------------------------------------
    Route::middleware(['role:superadmin'])->group(function () {
        
        // 2. Manajemen User
        Route::resource('users', UserController::class);
        // 3. Manajemen Pegawai (Employee - Profil Web)
        Route::resource('employees', EmployeeController::class)->except(['create', 'edit', 'show']);
        // 4. Manajemen Event
        Route::resource('events', EventController::class)->except(['create', 'edit', 'show']);
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

    // Restock Verification (Checklist Nota Harga)
    Route::prefix('restock-verifications')->name('restock-verifications.')->middleware('role:superadmin,cashier')->group(function () {
        Route::get('/', [RestockVerificationController::class, 'index'])->name('index');
        Route::get('/{verification}/edit', [RestockVerificationController::class, 'edit'])->name('edit');
        Route::put('/{verification}', [RestockVerificationController::class, 'update'])->name('update');
    });

    // --------------------------------------------------------
    // GROUP 3: DIVISI KASIR (Cashier + Super Admin)
    // --------------------------------------------------------
    Route::get('/orders', [AdminOrderController::class, 'index'])
        ->name('orders.index')
        ->middleware('role:superadmin,cashier');
    
    // Approve (accept) order
    Route::post('/orders/{id}/approve', [AdminOrderController::class, 'approve'])
        ->name('orders.approve')
        ->middleware('role:superadmin,cashier');
    
    // Reject order
    Route::post('/orders/{id}/reject', [AdminOrderController::class, 'reject'])
        ->name('orders.reject')
        ->middleware('role:superadmin,cashier');
        
    Route::post('/orders/{id}/ship', [AdminOrderController::class, 'ship'])
        ->name('orders.ship')
        ->middleware('role:superadmin,cashier');

});