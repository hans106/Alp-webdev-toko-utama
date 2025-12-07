@extends('layouts.main')

@section('content')
    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
        <h1 class="text-2xl font-bold">Katalog Produk</h1>
        
        <form action="{{ url()->current() }}" method="GET" class="flex w-full md:w-auto gap-2">
            @if(request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif

            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari barang..." 
                class="border border-gray-300 rounded-lg px-4 py-2 w-full md:w-64 focus:ring-2 focus:ring-blue-500">
            
            <select name="sort" onchange="this.form.submit()" class="border border-gray-300 rounded-lg px-4 py-2 cursor-pointer">
                <option value="">Urutkan</option>
                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Termurah</option>
                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Termahal</option>
            </select>
        </form>
    </div>

    <div class="flex flex-col md:flex-row gap-8">
        <aside class="w-full md:w-1/5">
            <div class="bg-white p-4 rounded-xl shadow-sm border">
                <h3 class="font-bold mb-4 text-gray-700">Kategori</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="/" class="block px-3 py-2 rounded-lg {{ !request('category') ? 'bg-blue-50 text-blue-700 font-bold' : 'text-gray-600 hover:bg-gray-50' }}">
                            Semua Produk
                        </a>
                    </li>
                    @foreach($categories as $cat)
                        <li>
                            <a href="?category={{ $cat->slug }}" class="block px-3 py-2 rounded-lg {{ request('category') == $cat->slug ? 'bg-blue-50 text-blue-700 font-bold' : 'text-gray-600 hover:bg-gray-50' }}">
                                {{ $cat->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </aside>

        <div class="w-full md:w-4/5">
            @if($products->count() > 0)
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($products as $item)
                        <div class="bg-white rounded-xl shadow-sm border hover:shadow-md transition group">
                            <a href="{{ route('front.product', $item->slug) }}" class="block relative h-48 overflow-hidden rounded-t-xl bg-gray-100 p-4">
                                <img src="{{ asset($item->image) }}" alt="{{ $item->name }}" class="w-full h-full object-contain group-hover:scale-105 transition duration-300">
                            </a>

                            <div class="p-4">
                                <span class="text-xs text-gray-500 mb-1 block">{{ $item->category->name }}</span>
                                <a href="{{ route('front.product', $item->slug) }}" class="font-semibold text-gray-800 hover:text-blue-600 line-clamp-2 min-h-[3rem]">
                                    {{ $item->name }}
                                </a>
                                <div class="mt-3 flex justify-between items-end">
                                    <div class="text-blue-600 font-bold text-lg">
                                        Rp {{ number_format($item->price, 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            @else
                <div class="text-center py-12 bg-white rounded-xl border border-dashed">
                    <p class="text-gray-500">Produk tidak ditemukan.</p>
                    <a href="/" class="text-blue-600 font-medium mt-2 inline-block">Reset Filter</a>
                </div>
            @endif
        </div>
    </div>
@endsection