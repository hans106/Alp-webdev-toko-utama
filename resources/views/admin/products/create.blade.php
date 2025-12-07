@extends('layouts.main')

@section('content')
<div class="container mx-auto px-4 py-8">
    
    <a href="{{ route('admin.products.index') }}" class="inline-flex items-center text-gray-500 hover:text-blue-600 mb-6 transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Kembali ke Dashboard
    </a>

    <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
        <div class="bg-blue-600 px-8 py-4">
            <h1 class="text-xl font-bold text-white">Tambah Produk Baru</h1>
            <p class="text-blue-100 text-sm">Isi formulir di bawah ini dengan lengkap.</p>
        </div>

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="p-8">
            @csrf <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">Nama Produk <span class="text-red-500">*</span></label>
                <input type="text" name="name" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" placeholder="Contoh: Indomie Goreng Jumbo" required>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Kategori <span class="text-red-500">*</span></label>
                    <select name="category_id" class="w-full border border-gray-300 rounded-xl px-4 py-3 bg-white focus:ring-2 focus:ring-blue-500" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Brand (Merk) <span class="text-red-500">*</span></label>
                    <select name="brand_id" class="w-full border border-gray-300 rounded-xl px-4 py-3 bg-white focus:ring-2 focus:ring-blue-500" required>
                        <option value="">-- Pilih Brand --</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Harga (Rp) <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <span class="absolute left-4 top-3 text-gray-500">Rp</span>
                        <input type="number" name="price" class="w-full border border-gray-300 rounded-xl pl-10 pr-4 py-3 focus:ring-2 focus:ring-blue-500" placeholder="0" required>
                    </div>
                </div>
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Stok Awal <span class="text-red-500">*</span></label>
                    <input type="number" name="stock" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500" placeholder="0" required>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">Deskripsi Produk <span class="text-red-500">*</span></label>
                <textarea name="description" rows="4" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500" placeholder="Jelaskan detail produk..." required></textarea>
            </div>

            <div class="mb-8">
                <label class="block text-gray-700 font-bold mb-2">Foto Produk <span class="text-red-500">*</span></label>
                <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:bg-gray-50 transition cursor-pointer relative">
                    <input type="file" name="image" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" required>
                    <div class="text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto mb-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span class="font-medium text-blue-600">Klik untuk upload</span> atau drag gambar ke sini
                        <p class="text-xs mt-1">PNG, JPG, JPEG (Max 2MB)</p>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end">
                <button type="submit" class="bg-blue-600 text-white font-bold py-3 px-8 rounded-xl hover:bg-blue-700 transition shadow-lg transform hover:scale-105">
                    Simpan Produk
                </button>
            </div>

        </form>
    </div>
</div>
@endsection