@extends('layouts.main')

@section('content')
<div class="container mx-auto px-4 md:px-12 py-12">
    
    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-800">Detail Pesanan</h1>
            <p class="text-slate-500 mt-1">Invoice: <span class="font-mono font-bold text-primary">#{{ $order->invoice_code }}</span></p>
        </div>
        <a href="{{ route('orders.index') }}" class="text-slate-600 hover:text-primary flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Riwayat
        </a>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        
        {{-- KOLOM KIRI: Informasi Pesanan --}}
        <div class="lg:col-span-2 space-y-6">
            
            {{-- Status Order --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <h2 class="text-lg font-bold text-slate-800 mb-4">Status Pesanan</h2>
                
                <div class="flex items-center gap-3">
                    @if ($order->status == 'pending')
                        <span class="bg-yellow-100 text-yellow-700 px-4 py-2 rounded-full text-sm font-bold border border-yellow-200">
                            ⏳ Menunggu Pembayaran
                        </span>
                    @elseif($order->status == 'paid' || $order->status == 'settlement')
                        <span class="bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-bold border border-green-200">
                            ✅ Pembayaran Berhasil
                        </span>
                    @elseif($order->status == 'expire')
                        <span class="bg-red-100 text-red-700 px-4 py-2 rounded-full text-sm font-bold border border-red-200">
                            ⛔ Kadaluarsa
                        </span>
                    @elseif($order->status == 'cancelled')
                        <span class="bg-slate-100 text-slate-700 px-4 py-2 rounded-full text-sm font-bold border border-slate-200">
                            ❌ Dibatalkan
                        </span>
                    @else
                        <span class="bg-gray-100 text-gray-700 px-4 py-2 rounded-full text-sm font-bold border border-gray-200">
                            {{ strtoupper($order->status) }}
                        </span>
                    @endif
                </div>

                <div class="mt-4 text-sm text-slate-600">
                    <p><strong>Tanggal Pesanan:</strong> {{ $order->created_at->format('d M Y, H:i') }}</p>
                    @if($order->paid_at)
                        <p><strong>Tanggal Pembayaran:</strong> {{ $order->paid_at->format('d M Y, H:i') }}</p>
                    @endif
                </div>
            </div>

            {{-- Daftar Produk --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <h2 class="text-lg font-bold text-slate-800 mb-4">Produk yang Dipesan</h2>
                
                <div class="space-y-4">
                    @foreach($order->orderItems as $item)
                        <div class="flex gap-4 pb-4 border-b border-slate-100 last:border-0">
                            @php
                                $imgSrc = null;
                                $imgPath = $item->product->image_main ?? $item->product->image ?? null;
                                
                                // 1) Full URL (http/https)
                                if ($imgPath && preg_match('/^https?:\/\//i', $imgPath)) {
                                    $imgSrc = $imgPath;
                                }
                                // 2) Path ada di public langsung (products/xxx.jpg)
                                elseif ($imgPath && file_exists(public_path($imgPath))) {
                                    $imgSrc = asset($imgPath);
                                }
                                // 3) Cek di public/products/
                                elseif ($imgPath && file_exists(public_path('products/' . $imgPath))) {
                                    $imgSrc = asset('products/' . $imgPath);
                                }
                                // 4) Fallback ke logo
                                else {
                                    $imgSrc = asset('logo/logo_utama.jpeg');
                                }
                            @endphp
                            
                            @if($imgSrc)
                                <img src="{{ $imgSrc }}" 
                                     alt="{{ $item->product->name }}" 
                                     class="w-20 h-20 object-cover rounded-lg"
                                     onerror="this.onerror=null; this.src='{{ asset('logo/logo_utama.jpeg') }}';">
                            @else
                                <div class="w-20 h-20 bg-slate-100 rounded-lg flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                            
                            <div class="flex-1">
                                <h3 class="font-bold text-slate-800">{{ $item->product->name }}</h3>
                                <p class="text-sm text-slate-500">{{ $item->qty }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                <p class="text-sm font-bold text-primary mt-1">Rp {{ number_format($item->qty * $item->price, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6 pt-6 border-t border-slate-200">
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-bold text-slate-800">Total Tagihan</span>
                        <span class="text-2xl font-extrabold text-primary">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            {{-- Print Nota (jika sudah paid) --}}
            @if(in_array($order->status, ['paid', 'settlement']))
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-2xl shadow-sm border border-green-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-green-800">Pembayaran Berhasil!</h3>
                            <p class="text-sm text-green-600 mt-1">Anda dapat mencetak nota pesanan Anda</p>
                        </div>
                        <button onclick="window.open('{{ route('orders.print', $order->id) }}', '_blank')" 
                                class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl font-bold flex items-center gap-2 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                            </svg>
                            Print Nota
                        </button>
                    </div>
                </div>
            @endif

        </div>

        {{-- KOLOM KANAN: Pembayaran --}}
        <div class="space-y-6">
            
            {{-- Panel Pembayaran --}}
            @if($order->status == 'pending')
                <div class="bg-white rounded-2xl shadow-lg border-2 border-indigo-200 p-6 sticky top-6">
                    <h2 class="text-lg font-bold text-slate-800 mb-4">💳 Pembayaran</h2>
                    
                    <div class="bg-indigo-50 rounded-xl p-4 mb-4">
                        <p class="text-sm text-indigo-700 mb-2">Total yang harus dibayar:</p>
                        <p class="text-3xl font-extrabold text-indigo-900">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                    </div>

                    @if(!empty($order->snap_token))
                        {{-- Tombol Bayar Sekarang --}}
                        <button id="pay-button" 
                                class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-6 py-4 rounded-xl font-bold text-lg shadow-lg shadow-indigo-200 transition flex items-center justify-center gap-2 mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                            Bayar Sekarang
                        </button>

                        {{-- Tombol Refresh Token --}}
                        <form action="{{ route('orders.reset', $order->id) }}" method="POST" class="w-full">
                            @csrf
                            <button type="submit" 
                                    class="w-full bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-3 rounded-xl font-medium text-sm transition flex items-center justify-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                Perbarui Link Pembayaran
                            </button>
                        </form>
                    @else
                        {{-- Jika token belum ada atau sedang loading --}}
                        <div class="space-y-3">
                            <div class="text-center py-4">
                                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-indigo-600 mx-auto mb-3"></div>
                                <p class="text-sm text-slate-600">Mempersiapkan pembayaran...</p>
                            </div>
                            
                            {{-- Tombol Generate Token --}}
                            <form action="{{ route('orders.reset', $order->id) }}" method="POST" class="w-full">
                                @csrf
                                <button type="submit" 
                                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-3 rounded-xl font-medium text-sm transition">
                                    🔄 Muat Pembayaran
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            @elseif(in_array($order->status, ['paid', 'settlement']))
                <div class="bg-green-50 rounded-2xl border-2 border-green-200 p-6">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-green-800 mb-2">Pembayaran Lunas</h3>
                        <p class="text-sm text-green-600">Terima kasih telah melakukan pembayaran!</p>
                    </div>
                </div>
            @else
                <div class="bg-slate-50 rounded-2xl border border-slate-200 p-6">
                    <div class="text-center">
                        <h3 class="text-lg font-bold text-slate-800 mb-2">Status: {{ strtoupper($order->status) }}</h3>
                        <p class="text-sm text-slate-600">Pesanan ini tidak dapat diproses.</p>
                    </div>
                </div>
            @endif

        </div>

    </div>
</div>

{{-- Midtrans Snap Script --}}
@if($order->status == 'pending' && !empty($order->snap_token))
{{-- Tentukan URL Snap berdasarkan konfigurasi midtrans --}}
@php
    // Jika di .env MIDTRANS_IS_PRODUCTION=true, pakai link Production (app.midtrans.com)
    // Jika false, pakai link Sandbox (app.sandbox.midtrans.com)
    $snapUrl = config('midtrans.is_production') 
        ? 'https://app.midtrans.com/snap/snap.js' 
        : 'https://app.sandbox.midtrans.com/snap/snap.js';
@endphp

<script src="{{ $snapUrl }}" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    document.getElementById('pay-button').addEventListener('click', function () {
        snap.pay('{{ $order->snap_token }}', {
            onSuccess: function(result) {
                console.log('success', result);
                alert('Pembayaran berhasil!');
                location.reload();
            },
            onPending: function(result) {
                console.log('pending', result);
                alert('Pembayaran menunggu konfirmasi.');
                location.reload();
            },
            onError: function(result) {
                console.log('error', result);
                alert('Pembayaran gagal!');
            },
            onClose: function() {
                console.log('customer closed the popup without finishing the payment');
            }
        });
    });
</script>
@endif

@endsection