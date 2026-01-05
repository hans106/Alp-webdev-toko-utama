<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Restock;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\ActivityLog; // ✅ Import Log
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth; // ✅ WAJIB IMPORT AUTH

class RestockController extends Controller
{
    // ==========================================
    // 1. DAFTAR RESTOCK (READ)
    // ==========================================
    public function index(Request $request)
    {
        $query = Restock::with(['supplier', 'product'])->latest();

        // Filter pencarian produk/supplier
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('product', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            })->orWhereHas('supplier', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });
        }

        if ($request->has('supplier_id') && $request->supplier_id != '') {
            $query->where('supplier_id', $request->supplier_id);
        }

        if ($request->has('product_id') && $request->product_id != '') {
            $query->where('product_id', $request->product_id);
        }

        $restocks = $query->paginate(10)->withQueryString();
        $suppliers = Supplier::all();
        $products = Product::all();

        return view('admin.restocks.index', compact('restocks', 'suppliers', 'products'));
    }

    // ==========================================
    // 2. FORM TAMBAH (CREATE)
    // ==========================================
    public function create()
    {
        $suppliers = Supplier::all();
        $products = Product::all();

        return view('admin.restocks.create', compact('suppliers', 'products'));
    }

    // ==========================================
    // 3. SIMPAN RESTOCK (STORE + LOG)
    // ==========================================
    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'product_id'  => 'required|exists:products,id',
            'qty'         => 'required|integer|min:1|max:30', // ✅ Max 30 barang
            'buy_price'   => 'required|numeric|min:0',
            'date'        => 'required|date',
        ]);

        // Atomic transaction: create restock + increment product stock + LOG
        DB::transaction(function () use ($validated) {
            // 1. Simpan Data Restock
            $restock = Restock::create($validated);
            
            // 2. Ambil data produk & supplier buat dicatat namanya di log
            $product = Product::findOrFail($validated['product_id']);
            $supplier = Supplier::findOrFail($validated['supplier_id']);
            
            // 3. Tambah Stok Produk
            $oldStock = $product->stock;
            $product->increment('stock', $validated['qty']);
            $newStock = $product->stock; // Stok setelah ditambah

            // --- 📹 REKAM CCTV (STORE) ---
            ActivityLog::create([
                'user_id' => Auth::id(),
                'action'  => 'RESTOCK BARANG',
                'description' => "Beli {$product->name} (Qty: {$validated['qty']}) dari {$supplier->name}. Total Stok: {$oldStock} -> {$newStock}."
            ]);
            // -----------------------------

        });

        return redirect()
            ->route('admin.restocks.index')
            ->with('success', 'Restock berhasil dicatat & Stok bertambah.');
    }

    // ==========================================
    // 4. DETAIL RESTOCK (SHOW)
    // ==========================================
    public function show(Restock $restock)
    {
        $restock->load(['supplier', 'product']);
        return view('admin.restocks.show', compact('restock'));
    }

    // ==========================================
    // CHECKLIST RESTOCK (GET)
    // ==========================================
    public function checklist(Restock $restock)
    {
        $restock->load(['supplier', 'product']);
        return view('admin.restocks.checklist', compact('restock'));
    }

    // ==========================================
    // CHECKLIST RESTOCK (POST/UPDATE)
    // ==========================================
    public function updateChecklist(Request $request, Restock $restock)
    {
        $validated = $request->validate([
            'checked_qty' => "required|integer|min:0|max:{$restock->qty}",
            'checklist_status' => 'required|in:belum_selesai,sudah_fix',
            'checklist_notes' => 'nullable|string|max:500'
        ]);

        $restock->update([
            'checked_qty' => $validated['checked_qty'],
            'checklist_status' => $validated['checklist_status'],
            'checklist_notes' => $validated['checklist_notes'] ?? null,
        ]);

        // Log activity
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'CHECKLIST RESTOCK',
            'description' => "Checklist Restock #{$restock->id} oleh " . Auth::user()->name
                . ". Checked: {$validated['checked_qty']}/{$restock->qty}. Status: {$validated['checklist_status']}"
        ]);

        return redirect()->route('admin.restocks.index')->with('success', 'Checklist Restock disimpan.');
    }

    // ==========================================
    // 5. FORM EDIT (EDIT)
    // ==========================================
    public function edit(Restock $restock)
    {
        $suppliers = Supplier::all();
        $products = Product::all();

        return view('admin.restocks.edit', compact('restock', 'suppliers', 'products'));
    }

    // ==========================================
    // 6. UPDATE RESTOCK (UPDATE + LOG)
    // ==========================================
    public function update(Request $request, Restock $restock)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'product_id'  => 'required|exists:products,id',
            'qty'         => 'required|integer|min:1',
            'buy_price'   => 'required|numeric|min:0',
            'date'        => 'required|date',
        ]);

        DB::transaction(function () use ($restock, $validated) {
            $oldQty = $restock->qty;
            $newQty = $validated['qty'];
            $qtyDiff = $newQty - $oldQty;

            // Update Restock
            $restock->update($validated);

            // Adjust Stock
            if ($qtyDiff != 0) {
                $restock->product->increment('stock', $qtyDiff);
            }

            // --- 📹 REKAM CCTV (UPDATE) ---
            $productName = $restock->product->name ?? 'Unknown Product';
            $logMsg = "Edit Data Restock {$productName}.";
            
            if ($qtyDiff != 0) {
                $logMsg .= " Koreksi Qty: {$oldQty} -> {$newQty} (Selisih: {$qtyDiff}).";
            } else {
                $logMsg .= " Perubahan data administrasi (harga/tanggal).";
            }

            ActivityLog::create([
                'user_id' => Auth::id(),
                'action'  => 'UPDATE RESTOCK',
                'description' => $logMsg
            ]);
            // -----------------------------
        });

        return redirect()
            ->route('admin.restocks.show', $restock)
            ->with('success', 'Restock berhasil diperbarui.');
    }

    // ==========================================
    // 7. HAPUS RESTOCK (DESTROY + LOG)
    // ==========================================
    public function destroy(Restock $restock)
    {
        // Ambil data dulu sebelum dihapus buat log
        $product = $restock->product; 
        $productName = $product->name ?? 'Item Terhapus';
        $qty = $restock->qty;

        DB::transaction(function () use ($restock, $product, $productName, $qty) {
            
            // Hapus data restock
            $restock->delete();
            
            // Kurangi stok produk (Kembalikan stok)
            if($product) {
                $product->decrement('stock', $qty);
            }

            // --- 📹 REKAM CCTV (DELETE) ---
            ActivityLog::create([
                'user_id' => Auth::id(),
                'action'  => 'BATAL/HAPUS RESTOCK',
                'description' => "Membatalkan Restock {$productName}. Stok otomatis dikurangi {$qty} pcs."
            ]);
            // -----------------------------
        });

        return redirect()
            ->route('admin.restocks.index')
            ->with('success', 'Restock dihapus & Stok dikurangi kembali.');
    }
}