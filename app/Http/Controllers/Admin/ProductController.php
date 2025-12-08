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
    // ... (Fungsi store di atas biarkan) ...

    // 5. FITUR EDIT (Tampilkan Form Edit)
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        $brands = Brand::all();

        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    // 6. FITUR UPDATE (Simpan Perubahan)
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // Validasi (Image jadi nullable, karena kalau gak ganti gambar gapapa)
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required',
            'brand_id' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', 
        ]);

        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description,
        ];

        // Cek apakah user upload gambar baru?
        if ($request->hasFile('image')) {
            // 1. Hapus gambar lama (KECUALI kalau gambar dari seeder/dummy kadang gak ada filenya, kita cek dulu)
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }

            // 2. Upload gambar baru
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('products'), $imageName);
            
            // 3. Masukkan ke array data
            $data['image'] = 'products/' . $imageName;
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk Berhasil Diupdate!');
    }
}