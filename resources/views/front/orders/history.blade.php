@extends('layouts.main')

@section('content')
    <div class="container mx-auto px-4 md:px-12 py-12">
        <h1 class="text-3xl font-bold mb-8 text-slate-800">Riwayat Pesanan Saya</h1>

        @if ($orders->count() > 0)
            <div class="space-y-6">
                @foreach ($orders as $order)
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition">
                        
                        {{-- Container Utama --}}
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">

                            {{-- BAGIAN KIRI: Info Order --}}
                            <div class="flex flex-col sm:flex-row gap-4 w-full md:w-auto">
                                

                                {{-- 2. INFO ORDER --}}
                                <div>
                                    <div class="flex items-center gap-3 mb-2">
                                        <span class="font-bold text-slate-800 text-lg">#{{ $order->invoice_code }}</span>
                                        <span class="text-xs text-slate-500">{{ $order->created_at->format('d M Y, H:i') }}</span>
                                    </div>

                                    <div class="flex items-center gap-2 flex-wrap">
                                        {{-- LOGIKA BADGE STATUS --}}
                                        @if ($order->status == 'pending')
                                            <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-bold border border-yellow-200">
                                                ⏳ Menunggu Pembayaran
                                            </span>
                                        @elseif($order->status == 'paid' || $order->status == 'settlement' || $order->status == 'capture')
                                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold border border-green-200">
                                                ✅ Lunas
                                            </span>
                                        @elseif($order->status == 'expire')
                                            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold border border-red-200">
                                                ⛔ Kadaluarsa
                                            </span>
                                        @elseif($order->status == 'cancel' || $order->status == 'deny')
                                            <span class="bg-slate-100 text-slate-700 px-3 py-1 rounded-full text-xs font-bold border border-slate-200">
                                                ❌ Dibatalkan
                                            </span>
                                        @else
                                            <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-bold border border-gray-200">
                                                {{ $order->status }}
                                            </span>
                                        @endif
                                    </div>
                                    
                                    {{-- Nama Produk Utama --}}
                                    @if($order->orderItems->count() > 0)
                                        <p class="text-sm text-slate-600 mt-2 line-clamp-1 font-medium">
                                            {{ $order->orderItems->first()->product->name }} 
                                            @if($order->orderItems->count() > 1)
                                                <span class="text-slate-400 text-xs ml-1">+{{ $order->orderItems->count() - 1 }} lainnya</span>
                                            @endif
                                        </p>
                                    @endif
                                </div>
                            </div>

                            {{-- BAGIAN KANAN: Harga & Tombol --}}
                            <div class="flex flex-col items-end gap-3 w-full md:w-auto mt-4 md:mt-0">
                                <div class="text-right">
                                    <span class="text-sm text-slate-500 block">Total Tagihan</span>
                                    <span class="text-xl font-extrabold text-primary">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                                </div>

                                {{-- TOMBOL AKSI PINTAR --}}
                                <a href="{{ route('orders.show', $order->id) }}"
                                    class="inline-flex justify-center items-center gap-2 px-6 py-3 rounded-xl font-bold text-sm transition w-full md:w-auto
                                    {{ $order->status == 'pending' 
                                        ? 'bg-indigo-600 text-white hover:bg-indigo-700 shadow-lg shadow-indigo-200' 
                                        : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                                    
                                    @if ($order->status == 'pending')
                                        Bayar Sekarang
                                    @else
                                        Lihat Detail
                                    @endif
                                    
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        @else
            {{-- Tampilan Kosong --}}
            <div class="text-center py-20 bg-slate-50 rounded-3xl border border-dashed border-slate-300">
                <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-800 mb-2">Belum Ada Pesanan</h3>
                <p class="text-slate-500 mb-6">Kamu belum pernah belanja disini nih.</p>
                <a href="{{ route('front.index') }}" class="bg-primary text-white px-8 py-3 rounded-xl font-bold hover:shadow-lg transition">
                    Mulai Belanja Sekarang
                </a>
            </div>
        @endif
    </div>

    {{-- CSS Fix Footer Melayang --}}
    <style>
        body { display: flex; flex-direction: column; min-height: 100vh; }
        main, .content-wrapper { flex: 1; }
    </style>
@endsection