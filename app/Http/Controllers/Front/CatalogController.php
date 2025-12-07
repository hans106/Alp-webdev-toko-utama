<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class CatalogController extends Controller
{
    public function home()
    {
        return view('front.home');
    }
    public function index(Request $request)
    {
        // 1. Mulai Query Produk
        // Kita pakai 'with' untuk Eager Loading (Mencegah N+1 Problem)
        $query = Product::with(['category', 'brand']);

        // 2. Logika Search (Kalau ada input 'keyword' di search bar)
        if ($request->has('search') && $request->search != null) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // 3. Logika Filter Kategori (Kalau user klik kategori tertentu)
        if ($request->has('category') && $request->category != null) {
            // Cari produk yang punya kategori dengan slug tertentu
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // 4. Logika Sorting (Termurah / Terbaru)
        if ($request->sort == 'price_asc') {
            $query->orderBy('price', 'asc'); // Termurah
        } elseif ($request->sort == 'price_desc') {
            $query->orderBy('price', 'desc'); // Termahal
        } else {
            $query->latest(); // Default: Terbaru (created_at desc)
        }

        // 5. Eksekusi dengan Pagination (12 produk per halaman)
        // withQueryString() penting biar pas pindah halaman, filter gak hilang
        $products = $query->paginate(12)->withQueryString();

        // Ambil data kategori buat ditampilkan di sidebar filter
        $categories = Category::all();

        return view('front.catalog', compact('products', 'categories'));
    }

    public function show($slug)
    {
        // Cari produk berdasarkan slug
        // Kita load juga 'productImages' (slide foto) dan 'reviews' (komentar)
        $product = Product::with(['category', 'brand', 'productImages', 'reviews'])
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
