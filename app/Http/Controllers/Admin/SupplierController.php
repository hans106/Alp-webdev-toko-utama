<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\ActivityLog; // ✅ Import Model Log
use Illuminate\Support\Facades\Auth; // ✅ Import Auth

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
    // 3. SIMPAN SUPPLIER BARU (STORE + LOG)
    // ==========================================
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:suppliers',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        // Tampung ke variabel $supplier biar bisa diambil namanya buat log
        $supplier = Supplier::create($validated);

        // --- 📹 REKAM CCTV (CREATE) ---
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'CREATE SUPPLIER',
            'description' => 'Menambahkan Supplier baru: ' . $supplier->name
        ]);
        // -----------------------------

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
    // 6. UPDATE SUPPLIER (UPDATE + LOG)
    // ==========================================
    public function update(Request $request, Supplier $supplier)
    {
        // SIMPAN DATA LAMA (BUAT BUKTI SEBELUM BERUBAH)
        $oldName = $supplier->name;
        $oldPhone = $supplier->phone;

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:suppliers,name,' . $supplier->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        $supplier->update($validated);

        // --- 📹 REKAM CCTV (UPDATE) ---
        // Logika mencatat apa saja yang berubah
        $changes = [];
        if ($oldName != $request->name) {
            $changes[] = "Nama: '$oldName' -> '$request->name'";
        }
        if ($oldPhone != $request->phone) {
            $changes[] = "HP: '$oldPhone' -> '$request->phone'";
        }

        // Hanya catat log KALO ada yang berubah
        if (count($changes) > 0) {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'UPDATE SUPPLIER',
                'description' => 'Update Supplier. ' . implode(', ', $changes)
            ]);
        }
        // -----------------------------

        return redirect()
            ->route('admin.suppliers.index') // Saya sarankan balik ke index saja biar rapi
            ->with('success', 'Supplier berhasil diperbarui.');
    }

    // ==========================================
    // 7. HAPUS SUPPLIER (DESTROY + LOG)
    // ==========================================
    public function destroy(Supplier $supplier)
    {
        $namaSupplier = $supplier->name; // Simpan nama sebelum dihapus

        $supplier->delete();

        // --- 📹 REKAM CCTV (DELETE) ---
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'DELETE SUPPLIER',
            'description' => 'Menghapus data Supplier: ' . $namaSupplier
        ]);
        // -----------------------------

        return redirect()
            ->route('admin.suppliers.index')
            ->with('success', 'Supplier berhasil dihapus.');
    }
}