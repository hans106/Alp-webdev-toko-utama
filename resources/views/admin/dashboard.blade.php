@extends('layouts.admin')

@section('page-title')
    Dashboard Executive
@endsection

@section('content')
    <div class="space-y-8">

        {{-- 1. WELCOME SECTION (Sapaan buat Bos) --}}
        <div
            class="bg-gradient-to-r from-[#A41025] to-red-800 text-white rounded-2xl p-8 shadow-xl relative overflow-hidden">
            <div class="relative z-10">
                <h2 class="text-3xl font-bold mb-2">Welcome, {{ Auth::user()->name }}</h2>
                <p class="text-red-100 text-lg">Performa Toko Utama.</p>
            </div>
            {{-- Hiasan Background --}}
            <div class="absolute right-0 bottom-0 opacity-10 transform translate-x-10 translate-y-10">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-64 w-64" viewBox="0 0 20 20" fill="currentColor">
                    <path
                        d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z" />
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
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Stok Menipis (Alert) --}}
            @php
                $lowStockCount = \App\Models\Product::where('stock', '<', 5)->count();
            @endphp
            <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition p-6 border-l-4 border-yellow-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium uppercase tracking-wider">Stok Menipis</p>
                        <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $lowStockCount }}</h3>
                    </div>
                    <div class="p-3 bg-yellow-50 rounded-full text-yellow-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                </div>
                @if ($lowStockCount > 0)
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
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
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
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                </div>
            </div>

        </div>

        {{-- 3. AREA AUDIT TRAIL / LOG AKTIVITAS (Desain Baru Lebih Ganteng) --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            {{-- Header Card --}}
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                <h3 class="font-bold text-gray-800 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Aktivitas Terbaru
                </h3>
                <span class="bg-indigo-100 text-indigo-600 text-xs font-bold px-3 py-1 rounded-full animate-pulse">
                    Live Record
                </span>
            </div>

            {{-- Content --}}
            <div class="p-0">
                @if ($logs->count() > 0)
                    <div class="divide-y divide-gray-100">
                        @foreach ($logs as $log)
                            {{-- LOGIC WARNA & ICON DINAMIS --}}
                            @php
                                $iconBg = 'bg-gray-100 text-gray-600'; // Default
                                $iconSvg =
                                    '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';

                                if (Str::contains($log->action, 'ORDER')) {
                                    // Kalau Order (Hijau + Icon Keranjang)
                                    $iconBg = 'bg-green-100 text-green-600';
                                    $iconSvg =
                                        '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>';
                                } elseif (Str::contains($log->action, 'DELETE')) {
                                    // Kalau Hapus (Merah + Icon Sampah)
                                    $iconBg = 'bg-red-100 text-red-600';
                                    $iconSvg =
                                        '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>';
                                } elseif (Str::contains($log->action, 'UPDATE')) {
                                    // Kalau Edit (Kuning + Icon Pensil)
                                    $iconBg = 'bg-yellow-100 text-yellow-600';
                                    $iconSvg =
                                        '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>';
                                } elseif (Str::contains($log->action, 'CREATE')) {
                                    // Kalau Tambah Baru (Biru + Icon Plus)
                                    $iconBg = 'bg-blue-100 text-blue-600';
                                    $iconSvg =
                                        '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>';
                                }
                            @endphp

                            <div class="p-4 hover:bg-gray-50 transition duration-200 flex items-start gap-4">
                                {{-- 1. ICON (Otomatis Berubah Warna) --}}
                                <div
                                    class="flex-shrink-0 w-10 h-10 rounded-full {{ $iconBg }} flex items-center justify-center shadow-sm">
                                    {!! $iconSvg !!}
                                </div>

                                {{-- 2. KONTEN TENGAH --}}
                                <div class="flex-1 min-w-0">
                                    <div class="flex justify-between items-start">
                                        <p class="text-sm font-bold text-gray-800">
                                            {{ $log->user->name ?? 'User Tak Dikenal' }}
                                        </p>
                                        <span class="text-xs text-gray-400 whitespace-nowrap ml-2">
                                            {{ $log->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-0.5">
                                        <span class="font-semibold uppercase tracking-wide text-[10px] text-gray-400">
                                            {{ $log->action }}
                                        </span>
                                    </p>
                                    <p class="text-sm text-gray-600 mt-1 leading-relaxed">
                                        {{ $log->description }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    {{-- Footer (Optional View All) --}}
                    <div class="bg-gray-50 p-3 text-center border-t border-gray-100">
                        <a href="#" class="text-xs text-indigo-600 font-semibold hover:text-indigo-800 transition">
                            Lihat Semua Aktivitas &rarr;
                        </a>
                    </div>
                @else
                    {{-- TAMPILAN KOSONG (Illustration) --}}
                    <div class="text-center py-16">
                        <div
                            class="mx-auto w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4 shadow-inner">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h4 class="text-gray-800 font-bold text-lg">No Activities</h4>
                        <p class="text-gray-500 text-sm mt-1 max-w-xs mx-auto">This Security System doesnt have any activity</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection