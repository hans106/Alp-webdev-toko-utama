<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\Storage; // Wajib ada buat hapus/simpan gambar

class ProductController extends Controller
{

    // 1. DAFTAR PRODUK (READ)
    public function index()
    {
        $products = Product::with(['category', 'brand'])->latest()->paginate(10);
        return view('admin.products.manage', compact('products'));
    }
    // 2. FORM TAMBAH (CREATE)
    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.products.create', compact('categories', 'brands'));
    }

    // 3. PROSES SIMPAN (STORE)
    public function store(Request $request)
    {
        // 1. Validasi
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'brand_id'    => 'required|exists:brands,id',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'description' => 'required|string',
            // Wajib image_main (bukan image biasa)
            'image_main'  => 'required|image|mimes:png,jpg,jpeg|max:2048', 
        ]);

        // 2. Buat Slug
        $validated['slug'] = Str::slug($request->name);

        // 3. Upload Gambar
        if ($request->hasFile('image_main')) {
            // Simpan ke folder: storage/app/public/products
            // Nanti diakses lewat: public/storage/products
            $path = $request->file('image_main')->store('products', 'public');
            $validated['image_main'] = $path;
        }

        // 4. Simpan ke Database
        Product::create($validated);

        return redirect()->route('admin.products.index')->with('success', 'Produk Berhasil Ditambahkan!');
    }

    // 4. FORM EDIT
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        $brands = Brand::all();

        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }


    // 5. PROSES UPDATE
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // 1. Validasi
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required',
            'brand_id'    => 'required',
            'price'       => 'required|numeric|min:100',
            'stock'       => 'required|integer|min:0',
            'description' => 'required',
            // Pakai Nullable (karena user gak wajib ganti foto pas ngedit)
            'image_main'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048', 
        ]);

        $validated['slug'] = Str::slug($request->name);

        // 2. Cek Ganti Gambar
        if ($request->hasFile('image_main')) {
            
            // Hapus gambar lama biar server gak penuh
            if ($product->image_main) {
                Storage::disk('public')->delete($product->image_main);
            }

            // Upload gambar baru
            $path = $request->file('image_main')->store('products', 'public');
            $validated['image_main'] = $path;
        }

        // 3. Update Data
        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Produk Berhasil Diupdate!');
    }

    // ==========================================
    // 6. HAPUS (DESTROY)
    // ==========================================
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Hapus file fisik gambar
        if ($product->image_main) {
            Storage::disk('public')->delete($product->image_main);
        }

        // Hapus data di database
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produk Berhasil Dihapus!');
    }
}