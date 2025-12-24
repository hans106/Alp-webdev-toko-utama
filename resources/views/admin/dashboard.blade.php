@extends('layouts.admin')

@section('page-title')
    Dashboard Admin
@endsection

@section('content')
    <div class="space-y-8">
        {{-- WELCOME MESSAGE --}}
        <div class="bg-gradient-to-r from-[#A41025] to-[#d63347] text-white p-6 rounded-2xl shadow-lg">
            <h3 class="text-2xl font-bold mb-2">Selamat datang, {{ Auth::user()->name }}! 👋</h3>
            <p class="text-amber-100">Pantau dan kelola seluruh sistem toko Anda dengan mudah dan efisien.</p>
        </div>

        {{-- SUMMARY CARDS --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            {{-- Total Produk --}}
            <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-[#A41025] hover:shadow-xl transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-semibold uppercase tracking-wider">Total Produk</p>
                        <p class="text-4xl font-bold text-[#1A0C0C] mt-2">{{ $products->total ?? $products->count() }}</p>
                        <p class="text-xs text-gray-400 mt-1">Produk di sistem</p>
                    </div>
                    <div class="w-16 h-16 bg-gradient-to-br from-[#A41025]/20 to-[#F4A236]/20 rounded-xl flex items-center justify-center text-3xl">
                        📦
                    </div>
                </div>
            </div>

            {{-- Total Kategori --}}
            <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-[#F4A236] hover:shadow-xl transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-semibold uppercase tracking-wider">Kategori</p>
                        <p class="text-4xl font-bold text-[#1A0C0C] mt-2">{{ $categories->count() }}</p>
                        <p class="text-xs text-gray-400 mt-1">Kategori aktif</p>
                    </div>
                    <div class="w-16 h-16 bg-gradient-to-br from-[#F4A236]/20 to-amber-200/20 rounded-xl flex items-center justify-center text-3xl">
                        🏷️
                    </div>
                </div>
            </div>

            {{-- Total Brand --}}
            <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-emerald-500 hover:shadow-xl transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-semibold uppercase tracking-wider">Brand</p>
                        <p class="text-4xl font-bold text-[#1A0C0C] mt-2">{{ $brands->count() }}</p>
                        <p class="text-xs text-gray-400 mt-1">Brand tersedia</p>
                    </div>
                    <div class="w-16 h-16 bg-gradient-to-br from-emerald-200/40 to-teal-200/40 rounded-xl flex items-center justify-center text-3xl">
                        💼
                    </div>
                </div>
            </div>

            {{-- Quick Stats --}}
            <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-blue-500 hover:shadow-xl transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-semibold uppercase tracking-wider">Low Stock</p>
                        <p class="text-4xl font-bold text-red-600 mt-2">{{ \App\Models\Product::where('stock', '<=', 5)->count() }}</p>
                        <p class="text-xs text-gray-400 mt-1">Perlu restock</p>
                    </div>
                    <div class="w-16 h-16 bg-gradient-to-br from-red-200/40 to-pink-200/40 rounded-xl flex items-center justify-center text-3xl">
                        ⚠️
                    </div>
                </div>
            </div>
        </div>

        {{-- Search & Filter Box --}}
        <div class="bg-white p-7 rounded-2xl shadow-lg border border-gray-200">
            <h3 class="text-lg font-bold text-[#1A0C0C] mb-5">🔍 Cari Produk</h3>
            <form action="{{ route('admin.dashboard') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                {{-- Search Bar --}}
                <div class="md:col-span-2 relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-4 top-3.5 text-gray-400"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama produk..."
                        class="w-full bg-white border border-gray-300 rounded-xl pl-12 pr-4 py-3 focus:ring-2 focus:ring-[#A41025] focus:border-transparent
                        text-gray-900 placeholder-gray-400 outline-none font-medium transition">
                </div>

                {{-- Category --}}
                <div class="relative">
                    <select name="category" onchange="this.form.submit()"
                        class="w-full bg-white border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#A41025] focus:border-transparent
                        outline-none cursor-pointer text-gray-900 appearance-none font-medium transition">
                        <option value="">Semua Kategori</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Brand --}}
                <div class="relative">
                    <select name="brand" onchange="this.form.submit()"
                        class="w-full bg-white border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#A41025] focus:border-transparent
                        outline-none cursor-pointer text-gray-900 appearance-none font-medium transition">
                        <option value="">Semua Brand</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->slug }}" {{ request('brand') == $brand->slug ? 'selected' : '' }}>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Search Button --}}
                <button type="submit"
                    class="bg-gradient-to-r from-[#A41025] to-[#d63347] text-white font-bold px-6 py-3 rounded-xl
                    hover:shadow-lg transition transform hover:scale-105 col-span-1 md:col-span-4 lg:col-span-1">
                    Cari
                </button>
            </form>
        </div>

        {{-- Add Product Button --}}
        <div class="flex justify-end">
            <a href="{{ route('admin.products.create') }}"
                class="bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-bold px-8 py-3 rounded-xl
                hover:shadow-lg transition transform hover:scale-105 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Produk Baru
            </a>
        </div>

        {{-- Products Table --}}
        @if ($products->count() > 0)
            <div class="overflow-x-auto bg-white rounded-2xl shadow-lg border border-gray-200">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-[#1A0C0C] to-[#2d1515] text-white">
                            <th class="px-6 py-4 text-left font-bold uppercase text-xs tracking-widest">Produk</th>
                            <th class="px-6 py-4 text-left font-bold uppercase text-xs tracking-widest">Kategori</th>
                            <th class="px-6 py-4 text-left font-bold uppercase text-xs tracking-widest">Brand</th>
                            <th class="px-6 py-4 text-right font-bold uppercase text-xs tracking-widest">Harga</th>
                            <th class="px-6 py-4 text-center font-bold uppercase text-xs tracking-widest">Stok</th>
                            <th class="px-6 py-4 text-center font-bold uppercase text-xs tracking-widest">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($products as $item)
                            <tr class="hover:bg-gradient-to-r hover:from-[#A41025]/5 hover:to-[#F4A236]/5 transition">
                                {{-- Produk --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-14 h-14 bg-gray-100 rounded-lg overflow-hidden flex items-center justify-center">
                                            <img src="{{ asset($item->image_main) }}" alt="{{ $item->name }}"
                                                class="w-full h-full object-contain">
                                        </div>
                                        <div>
                                            <p class="font-bold text-[#1A0C0C]">{{ $item->name }}</p>
                                            <p class="text-xs text-gray-500">{{ Str::limit($item->description, 50) }}</p>
                                        </div>
                                    </div>
                                </td>

                                {{-- Kategori --}}
                                <td class="px-6 py-4">
                                    <span class="text-xs font-bold text-white bg-[#A41025] uppercase tracking-widest px-3 py-1.5 rounded-lg inline-block">
                                        {{ $item->category->name }}
                                    </span>
                                </td>

                                {{-- Brand --}}
                                <td class="px-6 py-4 text-[#1A0C0C] font-semibold">
                                    {{ $item->brand->name }}
                                </td>

                                {{-- Harga --}}
                                <td class="px-6 py-4 text-right">
                                    <span class="font-bold text-[#1A0C0C] text-lg">
                                        Rp {{ number_format($item->price, 0, ',', '.') }}
                                    </span>
                                </td>

                                {{-- Stok --}}
                                <td class="px-6 py-4 text-center">
                                    @if($item->stock <= 5)
                                        <span class="font-bold px-3 py-1.5 rounded-lg text-white bg-gradient-to-r from-red-500 to-red-600 inline-block">
                                            {{ $item->stock }}
                                        </span>
                                    @else
                                        <span class="font-bold px-3 py-1.5 rounded-lg text-white bg-gradient-to-r from-emerald-500 to-teal-600 inline-block">
                                            {{ $item->stock }}
                                        </span>
                                    @endif
                                </td>

                                {{-- Aksi --}}
                                <td class="px-6 py-4">
                                    <div class="flex justify-center gap-3">
                                        <a href="{{ route('admin.products.edit', $item->id) }}"
                                            class="bg-blue-500 hover:bg-blue-600 text-white p-2.5 rounded-lg transition transform hover:scale-110 shadow-md"
                                            title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>

                                        <form action="{{ route('admin.products.destroy', $item->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin hapus produk ini?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-500 hover:bg-red-600 text-white p-2.5 rounded-lg transition transform hover:scale-110 shadow-md"
                                                title="Hapus">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
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

            {{-- Pagination --}}
            <div class="mt-8">
                {{ $products->links() }}
            </div>
        @else
            <div class="text-center py-20 bg-white rounded-2xl border-2 border-dashed border-gray-300 shadow-lg">
                <div class="text-6xl mb-4">📭</div>
                <p class="text-gray-600 font-semibold mb-4">Produk tidak ditemukan.</p>
                <a href="{{ route('admin.dashboard') }}"
                    class="text-[#A41025] font-bold hover:underline inline-block">Reset Filter</a>
            </div>
        @endif
    </div>
@endsection

                                {{-- Harga --}}
                                <td class="px-4 py-3 text-right">
                                    <span class="font-bold text-[#1A0C0C]">
                                        Rp {{ number_format($item->price, 0, ',', '.') }}
                                    </span>
                                </td>

                                {{-- Stok --}}
                                <td class="px-4 py-3 text-center">
                                    <span
                                        class="font-semibold px-3 py-1 rounded-full text-white
                                    {{ $item->stock <= 5 ? 'bg-red-500' : 'bg-green-500' }}">
                                        {{ $item->stock }}
                                    </span>
                                </td>

                                {{-- Aksi --}}
                                <td class="px-4 py-3">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('admin.products.edit', $item->id) }}"
                                            class="bg-blue-500 text-white p-2 rounded-lg hover:bg-blue-600 transition"
                                            title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>

                                        <form action="{{ route('admin.products.destroy', $item->id) }}" method="POST"
                                            onsubmit="return confirm('Hapus produk ini?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-500 text-white p-2 rounded-lg hover:bg-red-600 transition"
                                                title="Hapus">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
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

            {{-- Pagination --}}
            <div class="mt-8">
                {{ $products->links() }}
            </div>
        @else
            <div class="text-center py-20 bg-gray-100 rounded-lg border border-dashed border-gray-300">
                <p class="text-gray-600">Produk tidak ditemukan.</p>
                <a href="{{ route('admin.dashboard') }}"
                    class="text-[#A41025] font-bold mt-2 inline-block hover:underline">Reset Filter</a>
            </div>
        @endif
    </div>
@endsection
