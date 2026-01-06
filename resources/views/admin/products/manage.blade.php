@extends('layouts.admin')

@section('title', 'Manage Products')

@section('content')
    {{-- Alpine JS untuk animasi interaksi --}}
    @once
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @endonce

    <div class="min-h-screen pb-12">

        {{-- 1. HEADER & SEARCH --}}
        <div class="flex flex-col xl:flex-row justify-between items-end gap-6 mb-8 px-1">
            
            {{-- Judul Halaman --}}
            <div>
                <h1 class="text-4xl font-serif font-bold text-[#800000] tracking-wide">
                    <span class="text-[#E1B56A] font-sans font-light">Product</span> Catalogue
                </h1>
                <div class="h-1.5 w-24 bg-gradient-to-r from-[#800000] to-[#E1B56A] mt-2 rounded-full"></div>
                <p class="text-slate-500 text-sm mt-1">
                    Menampilkan {{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }} dari total {{ $products->total() }} produk.
                </p>
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.products.create') }}" class="bg-[#800000] hover:bg-[#600000] text-white px-6 py-3 rounded-xl font-bold uppercase tracking-wider text-xs shadow-lg flex items-center gap-2 transition-all transform hover:-translate-y-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add New
                </a>
            </div>
        </div>

        {{-- ALERT (Jika ada pesan sukses) --}}
        @if (session('success'))
            <div class="mb-8 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded-r-lg shadow-sm flex items-center gap-3 animate-fade-in-down">
                <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <p class="font-bold text-sm uppercase tracking-wide">Sukses</p>
                    <p class="text-sm">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        {{-- 2. GRID PRODUK --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-10">

            @forelse($products as $product)
                {{-- Logic Gambar --}}
                @php
                    $imgSrc = null;
                    $imgPath = $product->image_main ?? null;
                    if ($imgPath && preg_match('/^https?:\/\//i', $imgPath)) {
                        $imgSrc = $imgPath;
                    } elseif ($imgPath && file_exists(public_path($imgPath))) {
                        $imgSrc = asset($imgPath);
                    } elseif ($imgPath && file_exists(public_path('products/' . $imgPath))) {
                        $imgSrc = asset('products/' . $imgPath);
                    } else {
                        $imgSrc = asset('logo/logo_utama.jpeg');
                    }
                @endphp

                <div class="group relative h-[420px] bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-[#E1B56A]/20 overflow-hidden flex flex-col">
                    
                    {{-- Bagian Gambar (Atas) --}}
                    <div class="relative h-2/3 overflow-hidden bg-gray-100">
                        <img src="{{ $imgSrc }}" 
                            class="w-full h-full object-cover object-center group-hover:scale-110 transition-transform duration-700"
                            onerror="this.onerror=null;this.src='{{ asset('logo/logo_utama.jpeg') }}';">
                        
                        {{-- Overlay Gelap saat hover --}}
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center gap-2">
                             {{-- Edit Button --}}
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="bg-white text-[#800000] p-3 rounded-full hover:bg-[#E1B56A] hover:text-white transition-colors shadow-lg transform translate-y-4 group-hover:translate-y-0 duration-300" title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            {{-- Delete Button --}}
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Hapus produk ini?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="bg-red-600 text-white p-3 rounded-full hover:bg-red-700 transition-colors shadow-lg transform translate-y-4 group-hover:translate-y-0 duration-300 delay-75" title="Delete">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>

                        {{-- Category Badge --}}
                        <div class="absolute top-3 left-3">
                            <span class="bg-[#800000]/90 text-white text-[10px] font-bold px-2 py-1 rounded shadow-md uppercase tracking-wide">
                                {{ $product->category->name ?? 'Uncategorized' }}
                            </span>
                        </div>
                    </div>

                    {{-- Bagian Info (Bawah) --}}
                    <div class="p-5 flex flex-col justify-between flex-1 bg-gradient-to-b from-white to-[#FDFBF7]">
                        <div>
                            <p class="text-[#E1B56A] text-[10px] font-bold uppercase tracking-widest mb-1">{{ $product->brand->name ?? 'No Brand' }}</p>
                            <h3 class="text-lg font-serif font-bold text-gray-800 leading-tight line-clamp-2 mb-2 group-hover:text-[#800000] transition-colors">
                                {{ $product->name }}
                            </h3>
                        </div>
                        
                        <div class="flex items-end justify-between mt-2 border-t border-dashed border-[#E1B56A]/30 pt-3">
                            <div>
                                <p class="text-xs text-gray-400 mb-0.5">Price</p>
                                <p class="text-lg font-bold text-[#800000]">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-gray-400 mb-0.5">Stock</p>
                                @if($product->stock <= 5)
                                    <span class="text-red-500 font-bold text-sm bg-red-100 px-2 py-0.5 rounded animate-pulse">{{ $product->stock }} Left</span>
                                @else
                                    <span class="text-emerald-600 font-bold text-sm bg-emerald-100 px-2 py-0.5 rounded">{{ $product->stock }} Item</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            @empty
                <div class="col-span-full py-20 text-center bg-[#FDFBF7] rounded-3xl border-2 border-dashed border-[#E1B56A]/30">
                    <div class="inline-block p-4 rounded-full bg-[#E1B56A]/10 mb-4">
                        <svg class="w-10 h-10 text-[#E1B56A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-[#800000]">Belum ada produk</h3>
                    <p class="text-gray-500 text-sm mt-1">Silakan tambahkan produk baru.</p>
                </div>
            @endforelse

        </div>

        {{-- 3. PAGINATION (Bagian yang abang cari) --}}
        @if($products->hasPages())
            <div class="bg-white px-6 py-4 rounded-2xl shadow-sm border border-[#E1B56A]/20 flex items-center justify-between">
                {{-- Styling pagination bawaan Laravel agar sesuai tema (biasanya perlu custom view, tapi ini defaultnya sudah cukup rapi) --}}
                <div class="w-full">
                    {{ $products->links() }}
                </div>
            </div>
            
            {{-- Sedikit CSS Custom untuk mengubah warna Pagination bawaan Tailwind jadi Maroon --}}
            <style>
                nav[role="navigation"] span[aria-current="page"] > span {
                    background-color: #800000 !important; /* Warna Maroon untuk halaman aktif */
                    border-color: #800000 !important;
                    color: white !important;
                }
                nav[role="navigation"] a:hover {
                    background-color: #FDFBF7 !important; /* Warna Cream saat hover */
                    color: #800000 !important;
                }
            </style>
        @endif

    </div>
@endsection