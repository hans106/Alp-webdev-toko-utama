@extends('layouts.main')

@section('content')
    <div class="max-w-6xl mx-auto px-4 md:px-8 py-10">

        <nav class="text-sm font-medium text-slate-500 mb-8 flex items-center gap-2">
            <a href="{{ route('home') }}" class="hover:text-primary transition">Beranda</a> 
            <span class="text-slate-300">/</span> 
            <a href="{{ route('catalog') }}" class="hover:text-primary transition">Katalog</a>
            <span class="text-slate-300">/</span> 
            <span class="text-slate-900">{{ $product->name }}</span>
        </nav>

        <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/60 border border-slate-100 overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-2">
                
                <div class="bg-slate-50 p-8 md:p-12 flex flex-col justify-center items-center border-b md:border-b-0 md:border-r border-slate-100 relative">
                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="w-full h-auto object-contain max-h-[400px] drop-shadow-lg transform hover:scale-105 transition duration-500">
                    
                    @if($product->productImages->count() > 0)
                        <div class="mt-8 flex gap-3 overflow-x-auto w-full justify-center">
                            @foreach($product->productImages as $img)
                                <div class="w-16 h-16 border-2 border-white rounded-xl overflow-hidden shadow-sm cursor-pointer hover:border-primary transition">
                                    <img src="{{ asset($img->image) }}" class="w-full h-full object-cover"> 
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="p-8 md:p-12 flex flex-col">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="bg-indigo-50 text-primary text-xs font-bold px-3 py-1.5 rounded-full uppercase tracking-wider border border-indigo-100">
                            {{ $product->category->name }}
                        </span>
                        <span class="text-slate-400 text-sm font-medium">Brand: {{ $product->brand->name ?? 'Umum' }}</span>
                    </div>

                    <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-4 leading-tight">
                        {{ $product->name }}
                    </h1>

                    <div class="text-4xl font-extrabold text-primary mb-8 tracking-tight">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </div>

                    <div class="prose prose-slate text-slate-600 mb-8 flex-grow leading-relaxed">
                        <h3 class="text-lg font-bold text-slate-800 mb-2">Description:</h3>
                        <p>{{ $product->description }}</p>
                    </div>

                    <div class="mt-auto pt-8 border-t border-slate-100">
                        <div class="flex items-center justify-between mb-6">
                            <span class="text-sm font-bold text-slate-700">Stok Tersisa</span>
                            @if($product->stock > 5)
                                <span class="text-emerald-600 font-bold bg-emerald-50 px-3 py-1 rounded-lg border border-emerald-100">
                                    {{ $product->stock }} pcs
                                </span>
                            @else
                                <span class="text-rose-600 font-bold bg-rose-50 px-3 py-1 rounded-lg border border-rose-100 animate-pulse">
                                    {{ $product->stock }} pcs (Segera Habis!)
                                </span>
                            @endif
                        </div>

                        <button class="w-full bg-gradient-to-r from-primary to-indigo-700 text-white font-bold py-4 px-6 rounded-xl hover:shadow-lg hover:shadow-indigo-500/30 transition transform hover:-translate-y-0.5 flex justify-center items-center gap-3 text-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Add to Cart
                        </button>
                    </div>
                </div>
            </div>
        </div>

        @if(isset($relatedProducts) && $relatedProducts->count() > 0)
            <div class="mt-16">
                <h2 class="text-2xl font-bold mb-8 text-slate-800">Produk Sejenis</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $related)
                        <div class="bg-white rounded-xl border border-slate-100 p-4 hover:shadow-md transition group h-full flex flex-col">
                            <a href="{{ route('front.product', $related->slug) }}" class="block relative h-40 bg-slate-50 rounded-lg mb-3 overflow-hidden">
                                <img src="{{ asset($related->image) }}" class="w-full h-full object-contain p-4 group-hover:scale-110 transition duration-300">
                            </a>
                            <div class="flex flex-col flex-1">
                                <h4 class="font-bold text-slate-800 line-clamp-2 text-sm mb-2 group-hover:text-primary transition">
                                    {{ $related->name }}
                                </h4>
                                <div class="mt-auto text-primary font-bold">
                                    Rp {{ number_format($related->price, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection