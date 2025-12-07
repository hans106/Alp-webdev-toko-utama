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
        $query = Product::with(['category', 'brand']);

        // 1. Search (Nama)
        if ($request->has('search') && $request->search != null) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // 2. Filter Kategori
        if ($request->has('category') && $request->category != null) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // 3. Filter Harga Maksimal (BARU)
        if ($request->has('max_price') && $request->max_price != null) {
            $query->where('price', '<=', $request->max_price);
        }

        // 4. Sorting (Opsional, tetap kita simpan biar rapi)
        if ($request->sort == 'price_asc') {
            $query->orderBy('price', 'asc');
        } elseif ($request->sort == 'price_desc') {
            $query->orderBy('price', 'desc');
        } else {
            $query->latest();
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::all(); // Jangan lupa import model Category

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

    // Delete
    public function destroy($id)
    {

        $product = Product::findOrFail($id);

        if (file_exists(public_path($product->image))) {
            unlink(public_path($product->image));
        }

        // Hapus data dari database
        $product->delete();

        // 4. Balik ke halaman list
        return redirect()->route('admin.products.index')->with('success', 'Produk Berhasil Dihapus!');
    }
}
