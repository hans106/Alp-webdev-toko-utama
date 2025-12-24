@extends('layouts.main')

@section('content')
<div class="container mx-auto px-4 py-8">
    
    {{-- 1. HEADER & TOMBOL TAMBAH --}}
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Kelola Produk</h1>
            <p class="text-gray-500 text-sm">Dashboard Admin / Management Stock</p>
        </div>
        
        <a href="{{ route('admin.products.create') }}" class="bg-blue-600 text-white px-6 py-2 rounded-xl hover:bg-blue-700 transition font-bold shadow-lg flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            Tambah Produk Baru
        </a>
    </div>

    {{-- 2. ALERT SUKSES --}}
    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm" role="alert">
            <p class="font-bold">Berhasil!</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    {{-- 3. FORM PENCARIAN & FILTER (FITUR BARU) --}}
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200 mb-8">
        {{-- Form ini akan mengirim data ke method index di ProductController --}}
        {{-- Pastikan route ini sesuai dengan route index abang (bisa 'admin.products.index' atau 'products.index') --}}
        <form action="{{ route('admin.products.index') }}" method="GET">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                
                {{-- Search Bar --}}
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" 
                        placeholder="Cari nama produk..."
                        class="w-full pl-10 pr-4 py-2 border rounded-xl focus:ring-blue-500 focus:border-blue-500 transition">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>

                {{-- Filter Kategori --}}
                <select name="category_id" class="w-full py-2 px-4 border rounded-xl focus:ring-blue-500 focus:border-blue-500 bg-white transition">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>

                {{-- Filter Brand --}}
                <select name="brand_id" class="w-full py-2 px-4 border rounded-xl focus:ring-blue-500 focus:border-blue-500 bg-white transition">
                    <option value="">Semua Brand</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>
                            {{ $brand->name }}
                        </option>
                    @endforeach
                </select>

                {{-- Tombol Action --}}
                <div class="flex gap-2">
                    <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-xl font-bold hover:bg-gray-900 transition flex-1">
                        Cari
                    </button>
                </div>
            </div>
        </form>
    </div>
        </form>
    </div>

    {{-- 4. TABEL PRODUK --}}
    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Photo</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Produk's Name</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Category & Brand</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Stock</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($products as $product)
                    <tr class="hover:bg-gray-50 transition">
                        {{-- Kolom Foto --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="h-12 w-12 rounded-lg border overflow-hidden bg-gray-100 relative">
                                {{-- Pastikan pakai asset() --}}
                                @if($product->image_main)
                                    <img src="{{ asset($product->image_main) }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                                @else
                                    <span class="flex items-center justify-center h-full text-xs text-gray-400">No Img</span>
                                @endif
                            </div>
                        </td>
                        
                        {{-- Kolom Nama --}}
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-gray-900">{{ $product->name }}</div>
                            <div class="text-xs text-gray-400">Slug: {{ $product->slug }}</div>
                        </td>

                        {{-- Kolom Kategori & Brand --}}
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ $product->category->name }}
                            </span>
                            <div class="text-xs text-gray-500 mt-1">{{ $product->brand->name ?? 'No Brand' }}</div>
                        </td>

                        {{-- Kolom Harga --}}
                        <td class="px-6 py-4 text-sm font-bold text-gray-900">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </td>

                        {{-- Kolom Stok --}}
                        <td class="px-6 py-4">
                            @if($product->stock <= 20)
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 animate-pulse">
                                    {{ $product->stock }} (Menipis)
                                </span>
                            @else
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    {{ $product->stock }} Available
                                </span>
                            @endif
                        </td>
                        
                        {{-- Kolom Aksi --}}
                        <td class="px-6 py-4 text-sm font-medium">
                            <div class="flex gap-2">
                                {{-- Tombol EDIT --}}
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 px-3 py-1 rounded-md transition">Edit</a>
                                
                                {{-- Tombol DELETE --}}
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 px-3 py-1 rounded-md transition">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                                <p>Belum ada produk. Silakan tambah produk baru.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- 5. PAGINATION --}}
    <div class="mt-6">
        {{ $products->links() }}
    </div>
</div>
@endsection