@extends('layouts.main')

@section('content')
<div class="container mx-auto px-4 py-8">
    
    {{-- Tombol Kembali --}}
    <a href="{{ route('admin.products.index') }}" class="inline-flex items-center text-gray-500 hover:text-blue-600 mb-6 transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Kembali ke Dashboard
    </a>

    <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
        {{-- Header warna Kuning biar beda sama Create --}}
        <div class="bg-yellow-500 px-8 py-4">
            <h1 class="text-xl font-bold text-white">Update Produk</h1>
            <p class="text-yellow-100 text-sm">Update product: {{ $product->name }}</p>
        </div>

        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="p-8">
            @csrf
            @method('PUT') {{-- WAJIB: Method PUT untuk Update --}}

            {{-- Nama Produk --}}
            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">Product Name <span class="text-red-500">*</span></label>
                {{-- old('name', $product->name) artinya: tampilkan inputan terakhir, kalau gak ada tampilkan data dari database --}}
                <input type="text" name="name" value="{{ old('name', $product->name) }}" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition" required>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                {{-- Kategori --}}
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Category <span class="text-red-500">*</span></label>
                    <select name="category_id" class="w-full border border-gray-300 rounded-xl px-4 py-3 bg-white focus:ring-2 focus:ring-yellow-500" required>
                        <option value="">Choose Category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                {{-- Brand --}}
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Brand (Merk) <span class="text-red-500">*</span></label>
                    <select name="brand_id" class="w-full border border-gray-300 rounded-xl px-4 py-3 bg-white focus:ring-2 focus:ring-yellow-500" required>
                        <option value="">Choose Brand</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                {{-- Harga --}}
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Harga (Rp) <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <span class="absolute left-4 top-3 text-gray-500">Rp</span>
                        <input type="number" name="price" value="{{ old('price', $product->price) }}" class="w-full border border-gray-300 rounded-xl pl-10 pr-4 py-3 focus:ring-2 focus:ring-yellow-500" required>
                    </div>
                </div>
                {{-- Stok --}}
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Stok <span class="text-red-500">*</span></label>
                    <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-yellow-500" required>
                </div>
            </div>

            {{-- Deskripsi --}}
            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">Description <span class="text-red-500">*</span></label>
                <textarea name="description" rows="4" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-yellow-500" required>{{ old('description', $product->description) }}</textarea>
            </div>

            {{-- Foto Produk --}}
            <div class="mb-8">
                <label class="block text-gray-700 font-bold mb-2">Product Photo</label>
                
                {{-- Tampilkan Foto Saat Ini --}}
                @if($product->image_main)
                    <div class="mb-3 p-3 bg-gray-50 rounded-lg border border-gray-200 inline-block">
                        <p class="text-xs text-gray-500 mb-2">Image: </p>
                        <img src="{{ asset($product->image_main) }}" alt="Current Image" class="h-32 object-contain rounded">
                    </div>
                @endif

                <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:bg-gray-50 transition cursor-pointer relative mt-2">
                    {{-- Input Name wajib 'image_main' --}}
                    <input type="file" name="image_main" id="image_main" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                    <div class="text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto mb-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span class="font-medium text-yellow-600">Change Image</span>
                        <p class="text-xs mt-1">(Opsional) Biarkan kosong jika tidak mengubah gambar</p>
                    </div>
                </div>
                @error('image_main')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end gap-4">
                <a href="{{ route('admin.products.index') }}" class="text-gray-500 font-bold hover:text-gray-700 transition">Batal</a>
                <button type="submit" class="bg-yellow-500 text-white font-bold py-3 px-8 rounded-xl hover:bg-yellow-600 transition shadow-lg transform hover:scale-105">
                    Update Produk
                </button>
            </div>

        </form>
    </div>
</div>
@endsection