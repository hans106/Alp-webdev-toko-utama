<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    // ==========================================
    // 1. DAFTAR SUPPLIER (READ)
    // ==========================================
    public function index(Request $request)
    {
        $query = Supplier::query();

        // Filter pencarian nama/telepon
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('name', 'like', '%' . $search . '%')
                  ->orWhere('phone', 'like', '%' . $search . '%');
        }

        $suppliers = $query->latest()->paginate(10)->withQueryString();

        return view('admin.suppliers.index', compact('suppliers'));
    }

    // ==========================================
    // 2. TAMPILKAN FORM TAMBAH (CREATE)
    // ==========================================
    public function create()
    {
        return view('admin.suppliers.create');
    }

    // ==========================================
    // 3. SIMPAN SUPPLIER BARU (STORE)
    // ==========================================
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:suppliers',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        Supplier::create($validated);

        return redirect()
            ->route('admin.suppliers.index')
            ->with('success', 'Supplier berhasil ditambahkan.');
    }

    // ==========================================
    // 4. TAMPILKAN DETAIL SUPPLIER (SHOW)
    // ==========================================
    public function show(Supplier $supplier)
    {
        return view('admin.suppliers.show', compact('supplier'));
    }

    // ==========================================
    // 5. TAMPILKAN FORM EDIT (EDIT)
    // ==========================================
    public function edit(Supplier $supplier)
    {
        return view('admin.suppliers.edit', compact('supplier'));
    }

    // ==========================================
    // 6. UPDATE SUPPLIER (UPDATE)
    // ==========================================
    public function update(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:suppliers,name,' . $supplier->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        $supplier->update($validated);

        return redirect()
            ->route('admin.suppliers.show', $supplier)
            ->with('success', 'Supplier berhasil diperbarui.');
    }

    // ==========================================
    // 7. HAPUS SUPPLIER (DESTROY)
    // ==========================================
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return redirect()
            ->route('admin.suppliers.index')
            ->with('success', 'Supplier berhasil dihapus.');
    }
}
