@extends('layouts.admin')

@section('page-title')
    Dashboard
@endsection

@section('content')
<div class="space-y-8">
    {{-- WELCOME SECTION --}}
    <div class="bg-gradient-to-r from-[#A41025] to-red-700 text-white rounded-2xl p-8 shadow-xl">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold mb-2">Selamat Datang! 👋</h2>
                <p class="text-red-100 text-lg">Kelola inventory dan penjualan toko Anda dengan efisien</p>
            </div>
            <div class="text-7xl opacity-20">📊</div>
        </div>
    </div>

    {{-- STATISTICS CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        {{-- Total Produk --}}
        <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition p-6 border-t-4 border-[#A41025]">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <p class="text-gray-600 text-sm font-semibold mb-1">Total Produk</p>
                    <h3 class="text-4xl font-bold text-[#1A0C0C]">{{ $products->total ?? $products->count() }}</h3>
                </div>
                <div class="bg-red-100 p-3 rounded-lg text-2xl">📦</div>
            </div>
            <p class="text-xs text-gray-500">Produk aktif di sistem</p>
        </div>

        {{-- Kategori --}}
        <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition p-6 border-t-4 border-amber-500">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <p class="text-gray-600 text-sm font-semibold mb-1">Kategori</p>
                    <h3 class="text-4xl font-bold text-[#1A0C0C]">{{ $categories->count() }}</h3>
                </div>
                <div class="bg-amber-100 p-3 rounded-lg text-2xl">🏷️</div>
            </div>
            <p class="text-xs text-gray-500">Kategori tersedia</p>
        </div>

        {{-- Brand --}}
        <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition p-6 border-t-4 border-emerald-500">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <p class="text-gray-600 text-sm font-semibold mb-1">Brand</p>
                    <h3 class="text-4xl font-bold text-[#1A0C0C]">{{ $brands->count() }}</h3>
                </div>
                <div class="bg-emerald-100 p-3 rounded-lg text-2xl">💼</div>
            </div>
            <p class="text-xs text-gray-500">Brand yang tersedia</p>
        </div>

        {{-- Low Stock Alert --}}
        <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition p-6 border-t-4 border-orange-500">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <p class="text-gray-600 text-sm font-semibold mb-1">Stok Rendah</p>
                    <h3 class="text-4xl font-bold text-orange-600">{{ \App\Models\Product::where('stock', '<=', 5)->count() }}</h3>
                </div>
                <div class="bg-orange-100 p-3 rounded-lg text-2xl">⚠️</div>
            </div>
            <p class="text-xs text-gray-500">Perlu segera restock</p>
        </div>
    </div>

    {{-- FILTERS SECTION --}}
    <div class="bg-white rounded-xl shadow-lg p-7 border border-gray-200">
        <h3 class="text-lg font-bold text-[#1A0C0C] mb-6">🔍 Filter & Cari Produk</h3>
        <form action="{{ route('admin.dashboard') }}" method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                {{-- Search --}}
                <div class="md:col-span-2">
                    <input type="text" name="search" value="{{ request('search') }}" 
                        placeholder="Cari nama produk..."
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#A41025] focus:border-transparent">
                </div>

                {{-- Category --}}
                <select name="category" class="px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#A41025] cursor-pointer">
                    <option value="">Semua Kategori</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>

                {{-- Brand --}}
                <select name="brand" class="px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#A41025] cursor-pointer">
                    <option value="">Semua Brand</option>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->slug }}" {{ request('brand') == $brand->slug ? 'selected' : '' }}>
                            {{ $brand->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-3 justify-end">
                <a href="{{ route('admin.dashboard') }}" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 font-semibold hover:bg-gray-50 transition">
                    Reset
                </a>
                <button type="submit" class="px-6 py-3 bg-[#A41025] text-white font-semibold rounded-lg hover:bg-[#8f0f20] transition">
                    Cari
                </button>
            </div>
        </form>
    </div>

    {{-- ADD BUTTON --}}
    <div class="flex justify-end">
        <a href="{{ route('admin.products.create') }}" 
            class="bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-bold px-8 py-3 rounded-lg hover:shadow-lg transition inline-flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Produk Baru
        </a>
    </div>

    {{-- PRODUCTS TABLE --}}
    @if ($products->count() > 0)
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-[#1A0C0C] to-[#3d2020] text-white">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-bold">Produk</th>
                        <th class="px-6 py-4 text-left text-sm font-bold">Kategori</th>
                        <th class="px-6 py-4 text-left text-sm font-bold">Brand</th>
                        <th class="px-6 py-4 text-right text-sm font-bold">Harga</th>
                        <th class="px-6 py-4 text-center text-sm font-bold">Stok</th>
                        <th class="px-6 py-4 text-center text-sm font-bold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($products as $item)
                        <tr class="hover:bg-gray-50 transition">
                            {{-- Product Info --}}
                            <td class="px-6 py-4">
                                <div class="flex gap-4 items-start">
                                    <div class="w-16 h-16 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0 flex items-center justify-center">
                                        <img src="{{ asset($item->image_main) }}" alt="{{ $item->name }}" class="w-full h-full object-contain">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="font-bold text-[#1A0C0C] truncate">{{ $item->name }}</p>
                                        <p class="text-xs text-gray-500 truncate">{{ Str::limit($item->description, 45) }}</p>
                                    </div>
                                </div>
                            </td>

                            {{-- Category --}}
                            <td class="px-6 py-4">
                                <span class="inline-block px-3 py-1 text-xs font-bold text-white bg-[#A41025] rounded-full">
                                    {{ $item->category->name }}
                                </span>
                            </td>

                            {{-- Brand --}}
                            <td class="px-6 py-4">
                                <p class="text-sm text-gray-800 font-semibold">{{ $item->brand->name }}</p>
                            </td>

                            {{-- Price --}}
                            <td class="px-6 py-4 text-right">
                                <p class="font-bold text-[#1A0C0C]">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                            </td>

                            {{-- Stock --}}
                            <td class="px-6 py-4 text-center">
                                @if($item->stock <= 5)
                                    <span class="inline-block px-3 py-1 text-xs font-bold text-white bg-red-500 rounded-full">
                                        {{ $item->stock }}
                                    </span>
                                @else
                                    <span class="inline-block px-3 py-1 text-xs font-bold text-white bg-emerald-500 rounded-full">
                                        {{ $item->stock }}
                                    </span>
                                @endif
                            </td>

                            {{-- Actions --}}
                            <td class="px-6 py-4 text-center">
                                <div class="flex gap-2 justify-center">
                                    <a href="{{ route('admin.products.edit', $item->id) }}" 
                                        class="bg-blue-500 hover:bg-blue-600 text-white p-2.5 rounded-lg transition" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white p-2.5 rounded-lg transition" title="Hapus">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="flex justify-center">
            {{ $products->links() }}
        </div>
    @else
        <div class="text-center py-16 bg-white rounded-xl border-2 border-dashed border-gray-300">
            <p class="text-4xl mb-4">📭</p>
            <p class="text-gray-600 font-semibold mb-4">Produk tidak ditemukan</p>
            <a href="{{ route('admin.dashboard') }}" class="text-[#A41025] font-semibold hover:underline">
                Reset Filter
            </a>
        </div>
    @endif
</div>
@endsection