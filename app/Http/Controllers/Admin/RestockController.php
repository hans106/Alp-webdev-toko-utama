<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Restock;
use App\Models\Supplier;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        // Filter berdasarkan supplier
        if ($request->has('supplier_id') && $request->supplier_id != '') {
            $query->where('supplier_id', $request->supplier_id);
        }

        // Filter berdasarkan produk
        if ($request->has('product_id') && $request->product_id != '') {
            $query->where('product_id', $request->product_id);
        }

        $restocks = $query->paginate(10)->withQueryString();
        $suppliers = Supplier::all();
        $products = Product::all();

        return view('admin.restocks.index', compact('restocks', 'suppliers', 'products'));
    }

    // ==========================================
    // 2. TAMPILKAN FORM TAMBAH (CREATE)
    // ==========================================
    public function create()
    {
        $suppliers = Supplier::all();
        $products = Product::all();

        return view('admin.restocks.create', compact('suppliers', 'products'));
    }

    // ==========================================
    // 3. SIMPAN RESTOCK BARU (STORE)
    // ==========================================
    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'product_id' => 'required|exists:products,id',
            'qty' => 'required|integer|min:1',
            'buy_price' => 'required|numeric|min:0',
            'date' => 'required|date',
        ]);

        // Atomic transaction: create restock + increment product stock
        DB::transaction(function () use ($validated) {
            Restock::create($validated);
            Product::find($validated['product_id'])->increment('stock', $validated['qty']);
        });

        return redirect()
            ->route('admin.restocks.index')
            ->with('success', 'Restock berhasil dicatat. Stok produk otomatis bertambah.');
    }

    // ==========================================
    // 4. TAMPILKAN DETAIL RESTOCK (SHOW)
    // ==========================================
    public function show(Restock $restock)
    {
        $restock->load(['supplier', 'product']);

        return view('admin.restocks.show', compact('restock'));
    }

    // ==========================================
    // 5. TAMPILKAN FORM EDIT (EDIT)
    // ==========================================
    public function edit(Restock $restock)
    {
        $suppliers = Supplier::all();
        $products = Product::all();

        return view('admin.restocks.edit', compact('restock', 'suppliers', 'products'));
    }

    // ==========================================
    // 6. UPDATE RESTOCK (UPDATE)
    // ==========================================
    public function update(Request $request, Restock $restock)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'product_id' => 'required|exists:products,id',
            'qty' => 'required|integer|min:1',
            'buy_price' => 'required|numeric|min:0',
            'date' => 'required|date',
        ]);

        // Atomic transaction: adjust stock based on qty change + update restock
        DB::transaction(function () use ($restock, $validated) {
            $oldQty = $restock->qty;
            $newQty = $validated['qty'];
            $qtyDiff = $newQty - $oldQty;

            // Update restock record
            $restock->update($validated);

            // Adjust stock: if qty increased, add diff; if decreased, subtract diff
            if ($qtyDiff != 0) {
                $restock->product->increment('stock', $qtyDiff);
            }
        });

        return redirect()
            ->route('admin.restocks.show', $restock)
            ->with('success', 'Restock berhasil diperbarui. Stok produk disesuaikan otomatis.');
    }

    // ==========================================
    // 7. HAPUS RESTOCK (DESTROY)
    // ==========================================
    public function destroy(Restock $restock)
    {
        $product = $restock->product;
        $qty = $restock->qty;

        // Atomic transaction: delete restock + decrement product stock
        DB::transaction(function () use ($restock, $product, $qty) {
            $restock->delete();
            $product->decrement('stock', $qty);
        });

        return redirect()
            ->route('admin.restocks.index')
            ->with('success', 'Restock berhasil dihapus. Stok produk otomatis berkurang.');
    }
}
