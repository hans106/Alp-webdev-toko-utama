@extends('layouts.admin')

@section('page-title')
    Dashboard Admin
@endsection

@section('content')
    <div class="mb-8">
        <p class="text-gray-600 mb-6">Kelola dan pantau semua produk toko Anda</p>

        {{-- Search & Filter Box --}}
        <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-200 mb-10">
            <form action="{{ route('admin.dashboard') }}" method="GET" class="flex flex-col lg:flex-row gap-4 items-center">

                {{-- Search Bar --}}
                <div class="w-full lg:w-1/3 relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-4 top-3.5 text-gray-400"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>

                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk..."
                        class="w-full bg-white border border-gray-200 rounded-xl
                pl-12 pr-4 py-3 focus:ring-2 focus:ring-[#A41025] 
                text-gray-900 placeholder-gray-400 outline-none font-medium">
                </div>

                {{-- Category --}}
                <div class="w-full lg:w-1/4">
                    <select name="category" onchange="this.form.submit()"
                        class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3
                focus:ring-2 focus:ring-[#A41025] outline-none cursor-pointer
                text-gray-900 appearance-none font-medium">
                        <option value="">All Category</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Brand --}}
                <div class="w-full lg:w-1/4">
                    <select name="brand" onchange="this.form.submit()"
                        class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3
                focus:ring-2 focus:ring-[#A41025] outline-none cursor-pointer
                text-gray-900 appearance-none font-medium">
                        <option value="">All Brand</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->slug }}" {{ request('brand') == $brand->slug ? 'selected' : '' }}>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Search Button --}}
                <button type="submit"
                    class="w-full lg:w-auto bg-gradient-to-r from-[#A41025] to-[#F4A236]
            text-white font-bold px-8 py-3 rounded-xl hover:shadow-lg
            transition transform hover:-translate-y-0.5">
                    Search
                </button>
            </form>
        </div>

        {{-- Add Product Button --}}
        <div class="mb-6 flex justify-end">
            <a href="{{ route('admin.products.create') }}"
                class="bg-gradient-to-r from-green-500 to-green-600 text-white font-bold px-6 py-2.5 rounded-xl
                hover:shadow-lg transition transform hover:-translate-y-0.5 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Produk
            </a>
        </div>

        {{-- Products Table --}}
        @if ($products->count() > 0)
            <div class="overflow-x-auto bg-white rounded-lg shadow-md">
                <table class="w-full">
                    <thead>
                        <tr class="bg-[#1A0C0C] text-white">
                            <th class="px-4 py-3 text-left font-semibold">Produk</th>
                            <th class="px-4 py-3 text-left font-semibold">Kategori</th>
                            <th class="px-4 py-3 text-left font-semibold">Brand</th>
                            <th class="px-4 py-3 text-right font-semibold">Harga</th>
                            <th class="px-4 py-3 text-center font-semibold">Stok</th>
                            <th class="px-4 py-3 text-center font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $item)
                            <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                                {{-- Produk --}}
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset($item->image_main) }}" alt="{{ $item->name }}"
                                            class="w-12 h-12 object-contain rounded-lg bg-gray-100">
                                        <div>
                                            <p class="font-bold text-[#1A0C0C]">{{ $item->name }}</p>
                                            <p class="text-xs text-gray-600">{{ Str::limit($item->description, 40) }}</p>
                                        </div>
                                    </div>
                                </td>

                                {{-- Kategori --}}
                                <td class="px-4 py-3">
                                    <span
                                        class="text-[10px] font-bold text-[#A41025] uppercase tracking-wider
                                    bg-red-100 px-2 py-1 rounded-md inline-block">
                                        {{ $item->category->name }}
                                    </span>
                                </td>

                                {{-- Brand --}}
                                <td class="px-4 py-3 text-[#1A0C0C] font-medium">
                                    {{ $item->brand->name }}
                                </td>

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
