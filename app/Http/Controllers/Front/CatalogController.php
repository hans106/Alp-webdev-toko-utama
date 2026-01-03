<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <--- PENTING: Buat ngecek login Admin
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class CatalogController extends Controller
{
    // Halaman Home (Landing Page)
    public function home()
    {
        return view('front.home');
    }

    // Halaman Katalog (List Produk)
    public function index(Request $request)
    {
        // 🚨 CEGAT ADMIN: Kalau Admin iseng buka katalog, lempar ke List Admin
        if (Auth::check() && Auth::user()->role === 'admin') {
            return redirect()->route('admin.products.index')->with('success', 'Admin dialihkan ke area pengelolaan.');
        }

        // Mulai query
        $query = Product::with(['category', 'brand']);

        // 1. SEARCH (Pencarian Nama)
        if ($request->has('search') && $request->search != null) {
            $search = strtolower($request->search);
            // Pakai whereRaw biar case-insensitive (huruf besar kecil dianggap sama)
            $query->where('name', 'like', '%' . $search . '%');
        }

        // 2. FILTER KATEGORI (Dropdown / Sidebar)
        if ($request->has('category') && $request->category != null) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // 3. FILTER BRAND (Dropdown / Sidebar)
        if ($request->has('brand') && $request->brand != null) {
            $query->whereHas('brand', function ($q) use ($request) {
                $q->where('slug', $request->brand);
            });
        }

        // 4. FILTER HARGA MAX (Input Range / Number)
        if ($request->filled('max_price')) {
            $maxPrice = $request->max_price;
            $query->where('price', '<=', $maxPrice);
        }

        // 5. SORTING (Default: Terbaru)
        $query->latest();

        // Eksekusi Query (Pagination 12 item per halaman)
        $products = $query->paginate(12)->withQueryString();

        // Ambil Data Pendukung buat Dropdown Filter di View
        $categories = Category::all();
        $brands = Brand::all();

        // Optional: Kalau Abang pakai fitur "Showcase per Brand" di bagian bawah katalog
        $groupedProducts = Brand::with(['products' => function($q) {
            $q->latest()->take(4); 
        }])->whereHas('products')->get();

        // Preload user favorites to avoid N+1 queries
        $userFavorites = collect();
        if (Auth::check()) {
            $userFavorites = \App\Models\Wishlist::where('user_id', Auth::id())
                ->pluck('product_id')
                ->flip(); // Flip untuk quick lookup by product_id
        }

        // Kirim ke View
        return view('front.catalog', compact('products', 'categories', 'brands', 'groupedProducts', 'userFavorites'));
    }

    // Halaman Detail Produk
    public function show($slug)
    {
        // Cari produk berdasarkan slug
        // Kita HAPUS 'productImages' biar gak error relation
        $product = Product::with(['category', 'brand'])
            ->where('slug', $slug)
            ->firstOrFail();

        // 🚨 CEGAT ADMIN: Kalau Admin buka detail produk, langsung arahkan ke EDIT page
        if (Auth::check() && Auth::user()->role === 'admin') {
            return redirect()->route('admin.products.edit', $product->id);
        }

        // Cari produk terkait (rekomendasi) berdasarkan kategori yang sama
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id) // Jangan tampilkan produk yang sedang dibuka
            ->take(4)
            ->get();

        // Load product reviews and average rating
        $reviews = $product->reviews()->with('user')->latest()->get();
        $avgRating = $product->reviews()->avg('rating') ?? 0;

        // Check if current user has this product in wishlist (favorite)
        $isFavorited = false;
        if (Auth::check()) {
            $isFavorited = \App\Models\Wishlist::where('user_id', Auth::id())
                ->where('product_id', $product->id)
                ->exists();
        }

        return view('front.detail', compact('product', 'relatedProducts', 'reviews', 'avgRating', 'isFavorited'));
    }
}