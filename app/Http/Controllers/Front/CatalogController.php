<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand; // <--- JANGAN LUPA IMPORT INI

class CatalogController extends Controller
{
    public function home(){
        return view('front.home');
    }
    public function index(Request $request)
    {
        // Mulai query
        $query = Product::with(['category', 'brand']);

        // 1. SEARCH (Pencarian Nama)
        if ($request->has('search') && $request->search != null) {
            $search = strtolower($request->search);
            $query->whereRaw('LOWER(name) LIKE ?', ['%' . $search . '%']);
        }

        // 2. FILTER KATEGORI
        if ($request->has('category') && $request->category != null) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // 3. FILTER BRAND (BARU!) ✅
        if ($request->has('brand') && $request->brand != null) {
            $query->whereHas('brand', function ($q) use ($request) {
                $q->where('slug', $request->brand);
            });
        }

        // 4. FILTER HARGA MAX (BARU!) ✅
        if ($request->filled('max_price')) {
            $maxPrice = $request->max_price;
            $query->where('price', '<=', $maxPrice);
        }

        // 5. SORTING (Opsional)
        // Kalau abang mau sorting berdasarkan nama atau harga juga bisa
        $query->latest();
        // Eksekusi Query
        $products = $query->paginate(12)->withQueryString();

        $groupedProducts = Brand::with(['products' => function($q) {
            $q->latest()->take(4); // Ambil maks 4 produk per brand biar rapi
        }])->whereHas('products')->get();

        // Ambil Data Pendukung buat Dropdown
        $categories = Category::all();
        $brands = Brand::all(); // <--- INI YANG TADI KURANG (Penyebab Error)

        // Kirim ke View (Jangan lupa masukkan 'brands' ke compact)
        return view('front.catalog', compact('products', 'categories', 'brands', 'groupedProducts'));
    }

    public function show($slug)
    {
        // Cari produk berdasarkan slug
        // Kita load juga 'productImages' (slide foto) dan 'reviews' (komentar)
        $product = Product::with(['category', 'brand'])
            ->where('slug', $slug)
            ->firstOrFail();

        // Cari produk terkait (rekomendasi) berdasarkan kategori yang sama
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id) // Jangan tampilkan produk yang sedang dibuka
            ->take(4)
            ->get();

        return view('front.detail', compact('product', 'relatedProducts'));
    }
}
