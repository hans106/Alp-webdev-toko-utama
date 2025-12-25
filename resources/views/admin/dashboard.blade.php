@extends('layouts.admin')

@section('page-title')
    Dashboard Executive
@endsection

@section('content')
<div class="space-y-8">
    
    {{-- 1. WELCOME SECTION (Sapaan buat Bos) --}}
    <div class="bg-gradient-to-r from-[#A41025] to-red-800 text-white rounded-2xl p-8 shadow-xl relative overflow-hidden">
        <div class="relative z-10">
            <h2 class="text-3xl font-bold mb-2">Selamat Datang, {{ Auth::user()->name }}! 👋</h2>
            <p class="text-red-100 text-lg">Berikut adalah ringkasan performa toko Anda hari ini.</p>
        </div>
        {{-- Hiasan Background --}}
        <div class="absolute right-0 bottom-0 opacity-10 transform translate-x-10 translate-y-10">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-64 w-64" viewBox="0 0 20 20" fill="currentColor">
                <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z" />
            </svg>
        </div>
    </div>

    {{-- 2. STATISTICS CARDS (Ringkasan Angka) --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        
        {{-- Total Produk --}}
        <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition p-6 border-l-4 border-[#A41025]">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium uppercase tracking-wider">Total Produk</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $products->total() }}</h3>
                </div>
                <div class="p-3 bg-red-50 rounded-full text-[#A41025]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Stok Menipis (Alert) --}}
        @php
            // Hitung manual produk yang stoknya < 5
            $lowStockCount = \App\Models\Product::where('stock', '<', 5)->count();
        @endphp
        <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition p-6 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium uppercase tracking-wider">Stok Menipis</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $lowStockCount }}</h3>
                </div>
                <div class="p-3 bg-yellow-50 rounded-full text-yellow-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
            </div>
            @if($lowStockCount > 0)
                <p class="text-xs text-red-500 mt-2 font-semibold">Segera lakukan restock!</p>
            @endif
        </div>

        {{-- Total Supplier --}}
        <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium uppercase tracking-wider">Total Supplier</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ \App\Models\Supplier::count() }}</h3>
                </div>
                <div class="p-3 bg-blue-50 rounded-full text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Total Order (Sementara) --}}
        <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium uppercase tracking-wider">Pesanan Masuk</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ \App\Models\Order::count() }}</h3>
                </div>
                <div class="p-3 bg-green-50 rounded-full text-green-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
        </div>

    </div>

    {{-- 3. AREA AUDIT TRAIL / LOG AKTIVITAS (Coming Soon) --}}
    {{-- Sesuai SRS: Melihat siapa yang mengubah harga atau menghapus barang --}}
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Aktivitas Terkini (Audit Trail)
            </h3>
            <span class="bg-gray-100 text-gray-500 text-xs font-bold px-3 py-1 rounded-full">Real-time CCTV</span>
        </div>

        {{-- Placeholder Tabel Audit Trail --}}
        <div class="text-center py-12 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200">
            <div class="mx-auto w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
            </div>
            <p class="text-gray-500 font-medium">Belum ada aktivitas tercatat.</p>
            <p class="text-gray-400 text-sm">Fitur pencatatan log (siapa mengubah apa) akan muncul di sini.</p>
        </div>
    </div>

</div>
@endsection