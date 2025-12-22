<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\Storage; 

class ProductController extends Controller
{
    // ==========================================
    // 0. DASHBOARD ADMIN (Dashboard dengan Search & Filter)
    // ==========================================
    public function dashboard(Request $request)
    {
        // Mulai Query Builder
        $query = Product::with(['category', 'brand']);

        // --- LOGIC FILTER PENCARIAN ---

        // 1. Filter Nama (Search)
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // 2. Filter Kategori (menggunakan slug dari frontend)
        if ($request->has('category') && $request->category != '') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // 3. Filter Brand (menggunakan slug dari frontend)
        if ($request->has('brand') && $request->brand != '') {
            $query->whereHas('brand', function ($q) use ($request) {
                $q->where('slug', $request->brand);
            });
        }

        // 4. Filter Harga Maksimal
        if ($request->has('max_price') && $request->max_price != '') {
            $query->where('price', '<=', $request->max_price);
        }

        // Ambil data (Pagination 15 per halaman & Simpan history filter saat pindah halaman)
        $products = $query->latest()->paginate(15)->withQueryString();

        // Ambil data Kategori & Brand untuk Dropdown di Dashboard
        $categories = Category::all();
        $brands = Brand::all();

        return view('admin.dashboard', compact('products', 'categories', 'brands'));
    }

    // ==========================================
    // 1. DAFTAR PRODUK + FILTER (READ)
    // ==========================================
    public function index(Request $request)
    {
        // Mulai Query Builder
        $query = Product::with(['category', 'brand']);

        // --- LOGIC FILTER PENCARIAN ---

        // 1. Filter Nama (Search)
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // 2. Filter Kategori
        if ($request->has('category_id') && $request->category_id != '') {
            $query->where('category_id', $request->category_id);
        }

        // 3. Filter Brand
        if ($request->has('brand_id') && $request->brand_id != '') {
            $query->where('brand_id', $request->brand_id);
        }

        // 4. Filter Harga Maksimal
        if ($request->has('price_max') && $request->price_max != '') {
            $query->where('price', '<=', $request->price_max);
        }

        // Ambil data (Pagination 10 per halaman & Simpan history filter saat pindah halaman)
        $products = $query->latest()->paginate(10)->withQueryString();

        // Ambil data Kategori & Brand untuk Dropdown di Halaman Manage
        $categories = Category::all();
        $brands = Brand::all();

        // 👇 PERUBAHAN DISINI BANG: Kita panggil view 'manage'
        return view('admin.products.manage', compact('products', 'categories', 'brands'));
    }

    // ==========================================
    // 2. FORM TAMBAH (CREATE)
    // ==========================================
    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.products.create', compact('categories', 'brands'));
    }

    // ==========================================
    // 3. PROSES SIMPAN (STORE)
    // ==========================================
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'brand_id'    => 'required|exists:brands,id',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'description' => 'required|string',
            'image_main'  => 'required|image|mimes:png,jpg,jpeg|max:2048', 
        ]);

        $validated['slug'] = Str::slug($request->name);

        if ($request->hasFile('image_main')) {
            $path = $request->file('image_main')->store('products', 'public');
            $validated['image_main'] = $path;
        }

        Product::create($validated);

        return redirect()->route('admin.products.index')->with('success', 'Produk Berhasil Ditambahkan!');
    }

    // ==========================================
    // 4. FORM EDIT
    // ==========================================
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        $brands = Brand::all();

        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    // ==========================================
    // 5. PROSES UPDATE
    // ==========================================
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required',
            'brand_id'    => 'required',
            'price'       => 'required|numeric|min:100',
            'stock'       => 'required|integer|min:0',
            'description' => 'required',
            'image_main'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048', 
        ]);

        $validated['slug'] = Str::slug($request->name);

        if ($request->hasFile('image_main')) {
            if ($product->image_main) {
                Storage::disk('public')->delete($product->image_main);
            }
            $path = $request->file('image_main')->store('products', 'public');
            $validated['image_main'] = $path;
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Produk Berhasil Diupdate!');
    }

    // ==========================================
    // 6. HAPUS (DESTROY)
    // ==========================================
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->image_main) {
            Storage::disk('public')->delete($product->image_main);
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produk Berhasil Dihapus!');
    }
}