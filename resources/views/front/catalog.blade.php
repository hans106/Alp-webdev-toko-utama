@extends('layouts.main')

@section('content')
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Produk</h1>
        <p class="text-gray-500 mt-2">Temukan kebutuhan harianmu di sini</p>
    </div>

    <div class="bg-white p-4 rounded-xl shadow-sm border mb-8">
        <form action="{{ url()->current() }}" method="GET" class="flex flex-col md:flex-row gap-4 items-center justify-center">
            
            <div class="w-full md:w-1/3">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari barang..." 
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
            </div>

            <div class="w-full md:w-1/4">
                <select name="category" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none cursor-pointer">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="w-full md:w-1/4 relative">
                <span class="absolute left-3 top-2 text-gray-500 text-sm">Max Rp</span>
                <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="0" 
                    class="w-full border border-gray-300 rounded-lg pl-16 pr-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
            </div>

            <button type="submit" class="w-full md:w-auto bg-blue-600 text-white font-bold px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                Filter
            </button>
        </form>
    </div>

    <div class="w-full">
        @if($products->count() > 0)
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
                @foreach($products as $item)
                    <div class="bg-white rounded-xl shadow-sm border hover:shadow-md transition group h-full flex flex-col">
                        <a href="{{ route('front.product', $item->slug) }}" class="block relative h-48 overflow-hidden rounded-t-xl bg-gray-100 p-4">
                            <img src="{{ asset($item->image) }}" alt="{{ $item->name }}" class="w-full h-full object-contain group-hover:scale-105 transition duration-300">
                        </a>
                        <div class="p-4 flex flex-col flex-grow">
                            <span class="text-xs text-gray-500 mb-1 block">{{ $item->category->name }}</span>
                            <a href="{{ route('front.product', $item->slug) }}" class="font-semibold text-gray-800 hover:text-blue-600 line-clamp-2 mb-2">
                                {{ $item->name }}
                            </a>
                            <div class="mt-auto text-blue-600 font-bold text-lg">
                                Rp {{ number_format($item->price, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $products->links() }}
            </div>
        @else
            <div class="text-center py-12 bg-gray-50 rounded-xl border border-dashed">
                <p class="text-gray-500">Produk tidak ditemukan.</p>
                <a href="{{ route('catalog') }}" class="text-blue-600 font-medium mt-2 inline-block">Reset Filter</a>
            </div>
        @endif
    </div>
@endsection