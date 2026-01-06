@extends('layouts.admin')

@section('title', 'Edit Product')

@section('content')
    <div class="max-w-4xl mx-auto pb-12">

        {{-- 1. HEADER & BACK BUTTON --}}
        <div class="flex flex-col md:flex-row justify-between items-end gap-4 mb-8 px-1">
            <div>
                <a href="{{ route('admin.products.index') }}" 
                   class="inline-flex items-center text-slate-400 hover:text-[#800000] transition-colors mb-4 text-sm font-bold uppercase tracking-widest group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Catalogue
                </a>
                <h1 class="text-4xl font-serif font-bold text-[#800000]">
                    Edit <span class="text-[#E1B56A] italic">Product</span>
                </h1>
                <div class="h-1 w-20 bg-[#E1B56A] mt-2 rounded-full"></div>
            </div>
        </div>

        {{-- 2. CARD FORM --}}
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-[#E1B56A]/30 relative">
            
            {{-- Decorative Top Line --}}
            <div class="absolute top-0 left-0 right-0 h-2 bg-gradient-to-r from-[#800000] via-[#E1B56A] to-[#800000]"></div>

            <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="p-8 md:p-10">
                @csrf
                @method('PUT')

                {{-- Grid Layout --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                    {{-- KOLOM KIRI: Upload Gambar --}}
                    <div class="md:col-span-1">
                        <label class="block text-xs font-bold text-[#800000] uppercase tracking-widest mb-3">Product Image</label>
                        
                        <div class="bg-[#FDFBF7] rounded-2xl p-4 border border-[#E1B56A]/20">
                            {{-- Logic Tampilkan Gambar Lama --}}
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
                            
                            <div class="relative w-full aspect-square bg-white rounded-xl overflow-hidden border border-slate-100 shadow-inner mb-4 flex items-center justify-center group">
                                <img src="{{ $imgSrc }}" class="w-full h-full object-contain p-2 transition-transform duration-500 group-hover:scale-110" onerror="this.onerror=null;this.src='{{ asset('logo/logo_utama.jpeg') }}';">
                                <div class="absolute inset-0 bg-black/5 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                    <span class="text-xs font-bold bg-white/90 px-3 py-1 rounded-full shadow-sm text-slate-600">Current View</span>
                                </div>
                            </div>

                            {{-- Input Upload Baru --}}
                            <div class="relative group cursor-pointer">
                                <div class="border-2 border-dashed border-[#E1B56A] rounded-xl p-4 text-center hover:bg-[#E1B56A]/10 transition-colors bg-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto mb-1 text-[#E1B56A]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                    </svg>
                                    <span class="text-xs font-bold text-[#800000] block">Change Image</span>
                                    <span class="text-[10px] text-slate-400 block mt-1">Click to upload new</span>
                                </div>
                                <input type="file" name="image_main" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                            </div>
                            @error('image_main')
                                <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- KOLOM KANAN: Form Input --}}
                    <div class="md:col-span-2 space-y-6">

                        {{-- Nama Produk --}}
                        <div>
                            <label class="block text-xs font-bold text-[#800000] uppercase tracking-widest mb-2">Product Name</label>
                            <input type="text" name="name" value="{{ old('name', $product->name) }}" required
                                class="w-full bg-[#FDFBF7] border border-slate-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#800000] focus:border-[#800000] outline-none text-slate-800 font-serif font-bold text-lg transition-all placeholder:font-sans">
                        </div>

                        {{-- Grid Category & Brand --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-bold text-[#800000] uppercase tracking-widest mb-2">Category</label>
                                <div class="relative">
                                    <select name="category_id" required class="w-full bg-[#FDFBF7] border border-slate-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#800000] outline-none appearance-none text-slate-700 font-medium">
                                        <option value="">Select Category</option>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                                                {{ $cat->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-[#E1B56A]">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-[#800000] uppercase tracking-widest mb-2">Brand</label>
                                <div class="relative">
                                    <select name="brand_id" required class="w-full bg-[#FDFBF7] border border-slate-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#800000] outline-none appearance-none text-slate-700 font-medium">
                                        <option value="">Select Brand</option>
                                        @foreach($brands as $brand)
                                            <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>
                                                {{ $brand->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-[#E1B56A]">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Grid Price & Stock --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-bold text-[#800000] uppercase tracking-widest mb-2">Price (IDR)</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-3.5 text-[#E1B56A] font-bold font-serif">Rp</span>
                                    <input type="number" name="price" value="{{ old('price', $product->price) }}" required
                                        class="w-full bg-[#FDFBF7] border border-slate-200 rounded-xl pl-12 pr-4 py-3 focus:ring-2 focus:ring-[#800000] outline-none text-slate-800 font-bold font-mono">
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-[#800000] uppercase tracking-widest mb-2">Stock</label>
                                <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required
                                    class="w-full bg-[#FDFBF7] border border-slate-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#800000] outline-none text-slate-800 font-bold font-mono">
                            </div>
                        </div>

                        {{-- Deskripsi --}}
                        <div>
                            <label class="block text-xs font-bold text-[#800000] uppercase tracking-widest mb-2">Description</label>
                            <textarea name="description" rows="5" required
                                class="w-full bg-[#FDFBF7] border border-slate-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#800000] outline-none text-slate-600 leading-relaxed resize-none">{{ old('description', $product->description) }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center justify-end gap-4 mt-10 pt-6 border-t border-dashed border-slate-200">
                    <a href="{{ route('admin.products.index') }}" 
                       class="px-6 py-3 text-slate-500 hover:text-[#800000] hover:bg-[#800000]/5 rounded-xl text-sm font-bold uppercase tracking-wide transition-all">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-8 py-3 bg-gradient-to-r from-[#800000] to-[#600000] text-white rounded-xl shadow-lg hover:shadow-[#800000]/30 hover:-translate-y-1 transition-all text-sm font-bold uppercase tracking-widest flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Save Changes
                    </button>
                </div>

            </form>
        </div>
    </div>
@endsection