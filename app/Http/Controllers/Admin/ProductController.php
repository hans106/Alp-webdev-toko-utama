<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ActivityLog; // <--- WAJIB IMPORT INI (MODEL LOG)
use Illuminate\Http\Request;
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\Storage; 
use Illuminate\Support\Facades\Auth; // <--- WAJIB IMPORT INI (AUTH)

class ProductController extends Controller
{
    // ==========================================
    // 0. DASHBOARD ADMIN
    // ==========================================
    public function dashboard(Request $request)
    {
        $query = Product::with(['category', 'brand']);

        // --- FILTER ---
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        if ($request->has('category') && $request->category != '') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }
        if ($request->has('brand') && $request->brand != '') {
            $query->whereHas('brand', function ($q) use ($request) {
                $q->where('slug', $request->brand);
            });
        }
        if ($request->has('max_price') && $request->max_price != '') {
            $query->where('price', '<=', $request->max_price);
        }

        $products = $query->latest()->paginate(15)->withQueryString();
        $categories = Category::all();
        $brands = Brand::all();

        return view('admin.dashboard', compact('products', 'categories', 'brands'));
    }

    // ==========================================
    // 1. DAFTAR PRODUK (MANAGE)
    // ==========================================
    public function index(Request $request)
    {
        $query = Product::with(['category', 'brand']);

        // --- FILTER ---
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        if ($request->has('category_id') && $request->category_id != '') {
            $query->where('category_id', $request->category_id);
        }
        if ($request->has('brand_id') && $request->brand_id != '') {
            $query->where('brand_id', $request->brand_id);
        }
        if ($request->has('price_max') && $request->price_max != '') {
            $query->where('price', '<=', $request->price_max);
        }

        $products = $query->latest()->paginate(10)->withQueryString();
        $categories = Category::all();
        $brands = Brand::all();

        return view('admin.products.manage', compact('products', 'categories', 'brands'));
    }

    // ==========================================
    // 2. FORM TAMBAH
    // ==========================================
    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.products.create', compact('categories', 'brands'));
    }

    // ==========================================
    // 3. STORE (SIMPAN + CATAT LOG)
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

        $product = Product::create($validated);

        // --- 📹 REKAM CCTV (CREATE) ---
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'CREATE PRODUCT',
            'description' => 'Menambahkan produk baru: ' . $product->name
        ]);
        // -----------------------------

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
    // 5. UPDATE (UPDATE + CATAT LOG)
    // ==========================================
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // Simpan data lama buat bukti sejarah
        $oldName = $product->name;
        $oldPrice = $product->price;
        $oldStock = $product->stock;

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

        // --- 📹 REKAM CCTV (UPDATE) ---
        // Kita catat kalau ada perubahan harga atau stok yang sensitif
        $logMessage = 'Mengupdate produk ' . $oldName . '.';
        
        if ($oldPrice != $request->price) {
            $logMessage .= ' Harga: ' . number_format($oldPrice) . ' -> ' . number_format($request->price) . '.';
        }
        if ($oldStock != $request->stock) {
            $logMessage .= ' Stok: ' . $oldStock . ' -> ' . $request->stock . '.';
        }

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'UPDATE PRODUCT',
            'description' => $logMessage
        ]);
        // -----------------------------

        return redirect()->route('admin.products.index')->with('success', 'Produk Berhasil Diupdate!');
    }

    // ==========================================
    // 6. DESTROY (HAPUS + CATAT LOG)
    // ==========================================
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $namaProduk = $product->name; // Simpan nama sebelum dihapus

        if ($product->image_main) {
            Storage::disk('public')->delete($product->image_main);
        }

        $product->delete();

        // --- 📹 REKAM CCTV (DELETE) ---
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'DELETE PRODUCT',
            'description' => 'Menghapus produk permanen: ' . $namaProduk
        ]);
        // -----------------------------

        return redirect()->route('admin.products.index')->with('success', 'Produk Berhasil Dihapus!');
    }
}