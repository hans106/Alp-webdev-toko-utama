@extends('layouts.front')

@section('content')
    <div class="text-sm text-gray-500 mb-6">
        <a href="/" class="hover:text-blue-600">Beranda</a> 
        <span class="mx-2">/</span> 
        <span class="text-gray-800">{{ $product->name }}</span>
    </div>

    <div class="bg-white rounded-xl shadow-sm border p-6 md:p-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
            <div>
                <div class="bg-gray-100 rounded-xl overflow-hidden mb-4 p-8 border">
                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="w-full h-auto object-contain max-h-[400px]">
                </div>
                <div class="grid grid-cols-4 gap-2">
                    @foreach($product->productImages as $img)
                        <div class="border rounded-lg p-2 cursor-pointer hover:border-blue-500">
                            <img src="{{ asset($img->image_path) }}" class="w-full h-16 object-contain"> 
                        </div>
                    @endforeach
                </div>
            </div>

            <div>
                <span class="bg-blue-100 text-blue-800 text-xs font-bold px-2.5 py-0.5 rounded">{{ $product->category->name }}</span>
                <h1 class="text-3xl font-bold text-gray-900 mt-2 mb-2">{{ $product->name }}</h1>
                <p class="text-gray-500 mb-6">Brand: {{ $product->brand->name ?? 'Umum' }}</p>

                <div class="text-3xl font-bold text-blue-600 mb-6">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </div>

                <div class="prose text-gray-600 mb-8 border-t border-b py-4">
                    <p>{{ $product->description }}</p>
                </div>

                <div class="flex items-center gap-4 mb-6">
                    <div class="text-sm font-semibold">Stok Tersisa: 
                        <span class="{{ $product->stock > 5 ? 'text-green-600' : 'text-red-600' }}">{{ $product->stock }}</span>
                    </div>
                </div>

                <div class="flex gap-4">
                    <button class="flex-1 bg-blue-600 text-white font-bold py-3 px-6 rounded-xl hover:bg-blue-700 transition">
                        + Keranjang
                    </button>
                    <a href="https://wa.me/62812345678?text=Halo%20saya%20mau%20beli%20{{ $product->name }}" target="_blank" class="flex-1 bg-green-500 text-white font-bold py-3 px-6 rounded-xl hover:bg-green-600 text-center transition">
                        Beli via WA
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if($relatedProducts->count() > 0)
        <div class="mt-12">
            <h2 class="text-xl font-bold mb-6">Produk Sejenis</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($relatedProducts as $related)
                    <div class="bg-white rounded-xl shadow-sm border p-4 hover:shadow-md transition">
                        <a href="{{ route('front.product', $related->slug) }}">
                            <img src="{{ asset($related->image) }}" class="w-full h-32 object-contain mb-3">
                            <h4 class="font-semibold text-gray-800 line-clamp-2 text-sm">{{ $related->name }}</h4>
                            <div class="text-blue-600 font-bold mt-2 text-sm">
                                Rp {{ number_format($related->price, 0, ',', '.') }}
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
@endsection