<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ActivityLog;
use App\Models\Supplier;
use App\Models\Order;       // <--- Tambah ini (biar bisa hitung pesanan masuk)
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\Storage; 
use Illuminate\Support\Facades\Auth; // <--- WAJIB IMPORT INI (AUTH)

class ProductController extends Controller
{
    // ==========================================
    // 0. DASHBOARD ADMIN (SUDAH DIPERBAIKI)
    // ==========================================
    public function dashboard(Request $request)
    {
        // --- BAGIAN 1: LOGIKA FILTER PRODUK (BAWAAN ABANG) ---
        $query = Product::with(['category', 'brand']);

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

        // --- BAGIAN 2: LOGIKA STATISTIK (TAMBAHAN BARU) ---
        $totalProduct  = Product::count();
        $stokMenipis   = Product::where('stock', '<', 5)->count();
        $totalSupplier = Supplier::count();
        // Hitung order hari ini
        $pesananMasuk  = Order::whereDate('created_at', now())->count(); 

        // --- BAGIAN 3: AMBIL DATA AUDIT TRAIL (INI KUNCINYA!) ---
        // Ambil 10 aktivitas terakhir dari SIAPAPUN (Admin/Customer)
        $logs = ActivityLog::with('user')
                    ->latest()
                    ->take(10)
                    ->get();

        // --- BAGIAN 4: KIRIM SEMUA KE VIEW ---
        return view('admin.dashboard', compact(
            'products', 'categories', 'brands', // Data Produk
            'totalProduct', 'stokMenipis', 'totalSupplier', 'pesananMasuk', // Data Kotak Statistik
            'logs' // <--- INI WAJIB ADA BIAR AUDIT TRAIL MUNCUL
        ));
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
            // Move uploaded file to public/products so images are publicly accessible
            $file = $request->file('image_main');
            $filename = time() . '_' . preg_replace('/[^A-Za-z0-9\-_.]/', '_', $file->getClientOriginalName());
            $file->move(public_path('products'), $filename);
            $validated['image_main'] = 'products/' . $filename;
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
            // Remove previous public file if it exists
            if ($product->image_main && file_exists(public_path($product->image_main))) {
                @unlink(public_path($product->image_main));
            }

            // Move uploaded file to public/products so images are publicly accessible
            $file = $request->file('image_main');
            $filename = time() . '_' . preg_replace('/[^A-Za-z0-9\-_.]/', '_', $file->getClientOriginalName());
            $file->move(public_path('products'), $filename);
            $validated['image_main'] = 'products/' . $filename;
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

        if ($product->image_main && file_exists(public_path($product->image_main))) {
            @unlink(public_path($product->image_main));
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