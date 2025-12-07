<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;  
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str; // Buat bikin slug (Indomie Goreng -> indomie-goreng)
use Illuminate\Support\Facades\Storage; // Buat hapus gambar lama (nanti)

class ProductController extends Controller
{
    // ==========================================
    // 1. FITUR READ (Lihat Daftar Barang)
    // ==========================================
    public function index()
    {
        // Ambil data produk terbaru
        // 'with' gunanya biar query hemat (Eager Loading)
        $products = Product::with(['category', 'brand'])->latest()->paginate(10);
        
        return view('admin.products.manage', compact('products'));
    }

    // ==========================================
    // 2. FITUR CREATE (Tampilkan Form)
    // ==========================================
    public function create()
    {
        // Kita butuh data Kategori & Brand buat pilihan di form
        $categories = Category::all();
        $brands = Brand::all();
        
        return view('admin.products.create', compact('categories', 'brands'));
    }

    // ==========================================
    // 3. FITUR STORE (Proses Simpan ke DB)
    // ==========================================
    public function store(Request $request)
    {
        // 1. Validasi Inputan
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'brand_id'    => 'required|exists:brands,id',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'description' => 'required|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Max 2MB
        ]);

        // 2. Bikin Slug Otomatis
        $validated['slug'] = Str::slug($request->name);
        
        // 3. Default Status Aktif
        // $validated['is_active'] = 1;

        // 4. Proses Upload Gambar (Jika ada)
        if ($request->hasFile('image')) {
            // Ambil filenya
            $file = $request->file('image');
            // Bikin nama unik: 1700000_indomie.jpg
            $filename = time() . '_' . $file->getClientOriginalName();
            // Pindahkan ke folder public/products
            $file->move(public_path('products'), $filename);
            
            // Simpan path-nya ke array data buat masuk database
            $validated['image'] = 'products/' . $filename;
        }

        // 5. Simpan ke Database
        Product::create($validated);

        // 6. Balik ke Halaman List + Pesan Sukses
        return redirect()->route('admin.products.index')->with('success', 'Produk Berhasil Ditambahkan!');
    }
}