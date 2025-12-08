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
        // Mulai query dari produk
        $query = Product::with(['category', 'brand']);

        // 1. FILTER KATEGORI (Perbaikan)
        if ($request->has('category') && $request->category != null) {
            // Kita cari kategori berdasarkan SLUG yang dikirim dari form
            $slug = $request->category;

            $query->whereHas('category', function ($q) use ($slug) {
                $q->where('slug', $slug);
            });
        }

        // 2. SEARCH (Pencarian Nama)
        if ($request->has('search') && $request->search != null) {
            $search = strtolower($request->search);
            $query->whereRaw('LOWER(name) LIKE ?', ['%' . $search . '%']);
        }

        // 3. FILTER HARGA MAX
        if ($request->has('max_price') && $request->max_price != null) {
            $query->where('price', '<=', $request->max_price);
        }

        // 4. SORTING
        if ($request->sort == 'price_asc') {
            $query->orderBy('price', 'asc');
        } elseif ($request->sort == 'price_desc') {
            $query->orderBy('price', 'desc');
        } else {
            $query->latest();
        }

        $products = $query->paginate(12)->withQueryString();
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
