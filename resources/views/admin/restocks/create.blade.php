@extends('layouts.admin')

@section('page-title')
    Tambah Restock
@endsection

@section('content')
    <div class="max-w-2xl mx-auto my-auto">

    {{-- FORM TAMBAH RESTOCK --}}
    <div class="bg-white p-8 rounded-xl shadow-md border border-gray-200">
        <form action="{{ route('admin.restocks.store') }}" method="POST">
            @csrf

            {{-- Pilih Supplier --}}
            <div class="mb-6">
                <label for="supplier_id" class="block text-sm font-bold text-gray-700 mb-2">Supplier <span class="text-red-500">*</span></label>
                <select id="supplier_id" name="supplier_id" 
                    class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('supplier_id') border-red-500 @enderror"
                    required>
                    <option value="">-- Pilih Supplier --</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                            {{ $supplier->name }} ({{ $supplier->phone ?? '-' }})
                        </option>
                    @endforeach
                </select>
                @error('supplier_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Pilih Produk --}}
            <div class="mb-6">
                <label for="product_id" class="block text-sm font-bold text-gray-700 mb-2">Produk <span class="text-red-500">*</span></label>
                <select id="product_id" name="product_id" 
                    class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('product_id') border-red-500 @enderror"
                    required>
                    <option value="">-- Pilih Produk --</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                            {{ $product->name }} (Stok saat ini: {{ $product->stock }})
                        </option>
                    @endforeach
                </select>
                @error('product_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Jumlah Masuk --}}
            <div class="mb-6">
                <label for="qty" class="block text-sm font-bold text-gray-700 mb-2">Jumlah Masuk <span class="text-red-500">*</span></label>
                <input type="number" id="qty" name="qty" value="{{ old('qty') }}" 
                    placeholder="Contoh: 50"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('qty') border-red-500 @enderror"
                    required min="1">
                @error('qty')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Harga Modal --}}
            <div class="mb-6">
                <label for="buy_price" class="block text-sm font-bold text-gray-700 mb-2">Harga Modal (Rp) <span class="text-red-500">*</span></label>
                <input type="number" id="buy_price" name="buy_price" value="{{ old('buy_price') }}" 
                    placeholder="Contoh: 15000"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('buy_price') border-red-500 @enderror"
                    required step="0.01" min="0">
                @error('buy_price')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tanggal Restock --}}
            <div class="mb-6">
                <label for="date" class="block text-sm font-bold text-gray-700 mb-2">Tanggal Restock <span class="text-red-500">*</span></label>
                <input type="date" id="date" name="date" value="{{ old('date', date('Y-m-d')) }}" 
                    class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('date') border-red-500 @enderror"
                    required>
                @error('date')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Info Box --}}
            <div class="bg-blue-50 border border-blue-200 p-4 rounded-lg mb-6">
                <p class="text-sm text-blue-800"><strong>ℹ️ Info:</strong> Stok produk akan otomatis bertambah sesuai jumlah yang Anda input.</p>
            </div>

            {{-- Tombol Submit & Kembali --}}
            <div class="flex gap-3">
                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-green-700 transition">
                    Simpan Restock
                </button>
                <a href="{{ route('admin.restocks.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg font-bold hover:bg-gray-300 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection
