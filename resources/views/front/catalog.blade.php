@extends('layouts.main')

@section('content')
    <div class="container mx-auto px-4 md:px-12 py-12">

        <div class="text-center mb-10">
            <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight mb-2">Product</h1>
            <p class="text-slate-500">Temukan produk terbaik dengan harga tetangga.</p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-lg shadow-slate-200/50 border border-slate-100 mb-10">
            <form action="{{ url()->current() }}" method="GET" class="flex flex-col lg:flex-row gap-4 items-center">

                <div class="w-full lg:w-1/3 relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-4 top-3.5 text-slate-400"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk..."
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
                    <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Maximum Price"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-10 pr-4 py-3 focus:ring-2 focus:ring-primary outline-none transition font-medium text-slate-700 placeholder-slate-400"
                        min="0">
                </div>

                <button type="submit"
                    class="w-full lg:w-auto bg-gradient-to-r from-primary to-indigo-600 text-white font-bold px-8 py-3 rounded-xl hover:shadow-lg transition transform hover:-translate-y-0.5">
                    Search
                </button>
            </form>
        </div>

        @if ($products->count() > 0)
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 md:gap-8">
                @foreach ($products as $item)
                    <div
                        class="bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-xl transition duration-300 group flex flex-col h-full overflow-hidden">

                        <a href="{{ route('front.product', $item->slug) }}"
                            class="block relative h-48 md:h-56 bg-slate-50 overflow-hidden">
                            <img src="{{ asset($item->image) }}" alt="{{ $item->name }}"
                                class="w-full h-full object-contain p-6 group-hover:scale-110 transition duration-500">
                            @if ($item->stock <= 5)
                                <span
                                    class="absolute top-3 right-3 bg-rose-500 text-white text-[10px] font-bold px-2 py-1 rounded-full shadow-sm">Sisa
                                    {{ $item->stock }}</span>
                            @endif
                        </a>

                        <div class="p-5 flex flex-col flex-1 row">
                            <div class="mb-2">
                                <span
                                    class="text-[10px] font-bold text-primary uppercase tracking-wider bg-indigo-50 px-2 py-1 rounded-md">{{ $item->category->name }}</span>
                            </div>

                            <a href="{{ route('front.product', $item->slug) }}"
                                class="text-base font-bold text-slate-800 hover:text-primary transition line-clamp-2 mb-2 leading-snug">
                                {{ $item->name }}
                            </a>

                            <div class="mt-auto pt-3 border-t border-slate-50 flex justify-between items-center">
                                <div class="text-base md:text-lg font-extrabold text-slate-900">
                                    Rp {{ number_format($item->price, 0, ',', '.') }}
                                </div>
                                <form action="{{ route('cart.store', $item->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="bg-slate-100 text-slate-600 p-2 rounded-lg hover:bg-primary hover:text-white transition shadow-sm"
                                        title="Masukkan Keranjang">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-12">
                {{ $products->links() }}
            </div>
        @else
            <div class="text-center py-20 bg-slate-50 rounded-3xl border border-dashed border-slate-300">
                <p class="text-slate-500">Produk tidak ditemukan.</p>
                <a href="{{ route('catalog') }}" class="text-primary font-bold mt-2 inline-block hover:underline">Reset
                    Filter</a>
            </div>
        @endif

    </div>
@endsection
