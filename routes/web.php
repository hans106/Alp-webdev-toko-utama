<?php

use Illuminate\Support\Facades\Route;

// ==========================================
// DAFTAR IMPORT CONTROLLER
// ==========================================
use App\Http\Controllers\AuthController; 
use App\Http\Controllers\Admin\EmployeeController;

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
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\API\MidtransCallbackController;
use App\Http\Controllers\Admin\OrderChecklistController; // Import Controller Checklist

// ==========================================
// PENTING: IMPORT MIDDLEWARE CUSTOM
// ==========================================
use App\Http\Middleware\CheckRole; 

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
    Route::get('/my-orders/check-status/{id}', [FrontOrderController::class, 'checkPaymentStatus'])->name('orders.check_status'); 
    Route::get('/my-orders/print/{id}', [FrontOrderController::class, 'printNota'])->name('orders.print');
    Route::post('/my-orders/reset-token/{id}', [FrontOrderController::class, 'resetToken'])->name('orders.reset');
    Route::get('/my-orders/generate-snap/{id}', [FrontOrderController::class, 'generateSnap'])->name('orders.generate_snap');
});


// ==========================================
// 3. AREA ADMIN PANEL
// ==========================================

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {

    // Dashboard (Bisa diakses semua admin)
    Route::get('/', [ProductController::class, 'dashboard'])
        ->name('dashboard')
        ->middleware(CheckRole::class . ':master,inventory,admin_penjualan');

    // --------------------------------------------------------
    // GROUP 1: KHUSUS MASTER (Full Access)
    // --------------------------------------------------------
    Route::middleware([CheckRole::class . ':master'])->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('employees', EmployeeController::class)->except(['create', 'edit', 'show']);
        Route::resource('events', EventController::class)->except(['create', 'edit', 'show']);
    });

    // --------------------------------------------------------
    // GROUP 2: DIVISI GUDANG (Inventory + Master)
    // --------------------------------------------------------
    // Produk & Supplier & Restock
    Route::middleware(CheckRole::class . ':master,inventory')->group(function () {
        Route::resource('products', ProductController::class);
        Route::resource('suppliers', SupplierController::class);
        
        // Restock
        Route::prefix('restocks')->name('restocks.')->group(function () {
            Route::get('/', [RestockController::class, 'index'])->name('index');
            Route::get('/create', [RestockController::class, 'create'])->name('create');
            Route::post('/', [RestockController::class, 'store'])->name('store');
            Route::get('/{restock}', [RestockController::class, 'show'])->name('show');
            Route::get('/{restock}/edit', [RestockController::class, 'edit'])->name('edit');
            Route::put('/{restock}', [RestockController::class, 'update'])->name('update');
            Route::delete('/{restock}', [RestockController::class, 'destroy'])->name('destroy');
            
            // Checklist Restock (Barang Masuk)
            Route::get('/{restock}/checklist', [RestockController::class, 'checklist'])->name('checklist');
            Route::post('/{restock}/checklist', [RestockController::class, 'updateChecklist'])->name('checklist.update');
        });
    });

    // --------------------------------------------------------
    // GROUP 3: DIVISI PENJUALAN (Admin Penjualan + Master)
    // --------------------------------------------------------
    
    // A. ORDER / PESANAN MASUK (INI YANG TADI HILANG BANG!)
    Route::prefix('orders')->name('orders.')
        ->middleware(CheckRole::class . ':master,admin_penjualan')
        ->group(function() {
            // Halaman Tabel Pesanan Masuk
            Route::get('/', [AdminOrderController::class, 'index'])->name('index');
            
            // Action Tombol "Kirim ke Checklist"
            Route::post('/{id}/send-checklist', [AdminOrderController::class, 'sendToChecklist'])
                ->name('send_checklist');
        });

    // B. CHECKLIST NOTA / BARANG KELUAR
    Route::prefix('checklists')->name('checklists.')
        ->middleware(CheckRole::class . ':master,admin_penjualan') 
        ->group(function () {
            Route::get('/', [OrderChecklistController::class, 'index'])->name('index');
            Route::get('/{checklist}', [OrderChecklistController::class, 'show'])->name('show');
            Route::post('/item/{item}/toggle', [OrderChecklistController::class, 'toggleItem'])->name('item.toggle');
            Route::post('/{checklist}/status', [OrderChecklistController::class, 'updateStatus'])->name('status.update');
            Route::post('/{checklist}/send', [OrderChecklistController::class, 'send'])->name('send');
            Route::get('/{checklist}/print', [OrderChecklistController::class, 'print'])->name('print');
    });

});