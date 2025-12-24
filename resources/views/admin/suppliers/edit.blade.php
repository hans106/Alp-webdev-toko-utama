@extends('layouts.main')

@section('content')
<div class="container mx-auto px-4 py-8">
    
    {{-- HEADER --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Edit Supplier</h1>
        <p class="text-gray-500 text-sm">Dashboard Admin / Supplier & Distributor / Edit</p>
    </div>

    {{-- FORM EDIT SUPPLIER --}}
    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-200 max-w-2xl">
        <form action="{{ route('admin.suppliers.update', $supplier) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Nama Supplier --}}
            <div class="mb-6">
                <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Nama Supplier <span class="text-red-500">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name', $supplier->name) }}" 
                    placeholder="Contoh: PT. Sumber Dagang"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                    required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Telepon --}}
            <div class="mb-6">
                <label for="phone" class="block text-sm font-bold text-gray-700 mb-2">Telepon</label>
                <input type="tel" id="phone" name="phone" value="{{ old('phone', $supplier->phone) }}" 
                    placeholder="Contoh: 081234567890"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('phone') border-red-500 @enderror">
                @error('phone')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Alamat --}}
            <div class="mb-6">
                <label for="address" class="block text-sm font-bold text-gray-700 mb-2">Alamat</label>
                <textarea id="address" name="address" rows="4" 
                    placeholder="Contoh: Jl. Merdeka No.10, Jakarta"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('address') border-red-500 @enderror">{{ old('address', $supplier->address) }}</textarea>
                @error('address')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tombol Submit & Kembali --}}
            <div class="flex gap-3">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-blue-700 transition">
                    Update Supplier
                </button>
                <a href="{{ route('admin.suppliers.show', $supplier) }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg font-bold hover:bg-gray-300 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
