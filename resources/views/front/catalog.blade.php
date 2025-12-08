@extends('layouts.main')

@section('content')
    <div class="container mx-auto px-4 md:px-12 py-12">

        <div class="text-center mb-10">
            <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight mb-2">Product</h1>
            <p class="text-slate-500">Temukan produk terbaik dengan harga tetangga.</p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-lg shadow-slate-200/50 border border-slate-100 mb-10">
            <form action="{{ url()->current() }}" method="GET" class="flex flex-col lg:flex-row gap-4 items-center">

                <div class="w-full lg:flex-2/4 relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-4 top-3.5 text-slate-400"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-12 pr-4 py-3 focus:ring-2 focus:ring-primary outline-none transition font-medium text-slate-700">
                </div>

                <div class="w-full lg:w-1/4">
                    <select name="category" onchange="this.form.submit()"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary outline-none cursor-pointer font-medium text-slate-700 appearance-none">
                        <option value="">All Category</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>
                                {{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="w-full lg:w-1/4">
                    <select name="brand" onchange="this.form.submit()"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary outline-none cursor-pointer font-medium text-slate-700 appearance-none">
                        <option value="">All Brand</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->slug }}" {{ request('brand') == $brand->slug ? 'selected' : '' }}>
                                {{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="w-full lg:w-1/4 relative">
                    <span class="absolute left-4 top-3.5 text-slate-500 font-bold text-sm">Rp</span>
                    <input type="number" name="max_price" value="{{ request('max_price') }}"
                        placeholder="Batas Harga Tertinggi"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-10 pr-4 py-3 focus:ring-2 focus:ring-primary outline-none transition font-medium text-slate-700 placeholder-slate-400"
                        min="0">
                </div>

                <button type="submit"
                    class="w-full lg:w-auto bg-gradient-to-r from-primary to-indigo-600 text-white font-bold px-8 py-3 rounded-xl hover:shadow-lg transition transform hover:-translate-y-0.5">
                    Search
                </button>
            </form>
        </div>

        @if(request('search') || request('category') || request('brand') || request('max_price'))
        
            {{-- TAMPILAN 1: MODE FILTER (GRID BIASA) --}}
            {{-- Ini muncul kalau user sedang mencari sesuatu --}}
            
            <div class="mb-6">
                <h2 class="font-bold text-xl text-slate-800">Hasil Pencarian</h2>
            </div>

            @if($products->count() > 0)
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 md:gap-8">
                    @foreach($products as $item)
                        {{-- INCLUDE CARD PRODUK (Sama seperti sebelumnya) --}}
                        @include('front.partials.product-card', ['item' => $item]) 
                        {{-- PENTING: Kalau error 'view not found', copy paste manual kodingan card produk di sini --}}
                    @endforeach
                </div>
                <div class="mt-12">
                    {{ $products->links() }}
                </div>
            @else
                <div class="text-center py-20 bg-slate-50 rounded-3xl border border-dashed border-slate-300">
                    <p class="text-slate-500">Produk tidak ditemukan.</p>
                    <a href="{{ route('catalog') }}" class="text-primary font-bold mt-2 inline-block hover:underline">Reset Filter</a>
                </div>
            @endif

        @else

            {{-- TAMPILAN 2: MODE GROUPING (RAK PER BRAND) --}}
            {{-- Ini muncul kalau user baru buka halaman (Default) --}}

            <div class="space-y-16">
                @foreach($groupedProducts as $brandGroup)
                    <div class="border-b border-slate-100 pb-12 last:border-0">
                        
                        <div class="flex justify-between items-end mb-6">
                            <div>
                                <h2 class="text-2xl font-extrabold text-slate-900">{{ $brandGroup->name }}</h2>
                                <p class="text-slate-500 text-sm">Pilihan terbaik dari {{ $brandGroup->name }}</p>
                            </div>
                            <a href="{{ route('catalog', ['brand' => $brandGroup->slug]) }}" class="text-sm font-bold text-primary hover:text-indigo-800 transition">
                                Lihat Semua &rarr;
                            </a>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                            @foreach($brandGroup->products as $item)
                                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-xl transition duration-300 group flex flex-col h-full overflow-hidden">
                                    <a href="{{ route('front.product', $item->slug) }}" class="block relative h-40 bg-slate-50 overflow-hidden">
                                        <img src="{{ asset($item->image) }}" alt="{{ $item->name }}" class="w-full h-full object-contain p-4 group-hover:scale-110 transition duration-500">
                                    </a>
                                    <div class="p-4 flex flex-col flex-grow">
                                        <div class="mb-1">
                                            <span class="text-[10px] font-bold text-primary uppercase bg-indigo-50 px-2 py-1 rounded-md">{{ $item->category->name }}</span>
                                        </div>
                                        <a href="{{ route('front.product', $item->slug) }}" class="text-sm font-bold text-slate-800 hover:text-primary line-clamp-2 mb-2">
                                            {{ $item->name }}
                                        </a>
                                        <div class="mt-auto flex justify-between items-center">
                                            <div class="text-base font-extrabold text-slate-900">
                                                Rp {{ number_format($item->price, 0, ',', '.') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

        @endif
    </div>
@endsection
