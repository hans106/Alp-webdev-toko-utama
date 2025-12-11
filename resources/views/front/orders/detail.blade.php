@extends('layouts.main')

@section('content')
<div class="container mx-auto px-4 md:px-12 py-12">
    
    <a href="{{ route('orders.index') }}" class="inline-flex items-center gap-2 text-slate-500 hover:text-primary mb-8 font-bold group">
        <div class="p-2 bg-slate-100 rounded-lg group-hover:bg-indigo-50 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
        </div>
        <span>Kembali ke Riwayat</span>
    </a>

    <div class="flex flex-col lg:flex-row gap-8">
        
        <div class="w-full lg:w-2/3">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                    <div>
                        <p class="text-xs text-slate-500 uppercase tracking-wider font-bold">Nomor Invoice</p>
                        <h2 class="font-bold text-lg text-slate-800">{{ $order->invoice_code }}</h2>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-slate-500 uppercase tracking-wider font-bold">Tanggal Pesanan</p>
                        <span class="text-sm font-bold text-slate-700">{{ $order->created_at->format('d F Y, H:i') }}</span>
                    </div>
                </div>

                <div class="p-6 space-y-6">
                    @foreach($order->orderItems as $item)
                    <div class="flex gap-4 items-start">
                        <div class="w-16 h-16 bg-white border border-slate-200 rounded-lg p-1 flex-shrink-0">
                            <img src="{{ asset($item->product->image) }}" class="w-full h-full object-contain">
                        </div>
                        
                        <div class="flex-grow">
                            <h4 class="font-bold text-slate-800 text-sm md:text-base">{{ $item->product_name }}</h4>
                            <p class="text-sm text-slate-500 mt-1">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                        </div>
                        
                        <div class="font-bold text-slate-800">
                            Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="p-6 bg-slate-50 border-t border-slate-100">
                    <h3 class="font-bold text-slate-800 mb-2 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        Alamat Pengiriman
                    </h3>
                    <p class="text-slate-600 leading-relaxed ml-7 text-sm">{{ $order->address }}</p>
                </div>
            </div>
        </div>

        <div class="w-full lg:w-1/3">
            <div class="bg-white p-6 rounded-2xl shadow-lg shadow-indigo-100 border border-slate-100 sticky top-24">
                <h3 class="text-xl font-bold mb-6">Status Pembayaran</h3>
                
                <div class="mb-6 pb-6 border-b border-slate-100">
                    <p class="text-sm text-slate-500 mb-1">Total Tagihan</p>
                    <p class="text-3xl font-extrabold text-primary">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                </div>

                @if($order->payment_status == '1')
                    <div class="bg-yellow-50 text-yellow-800 p-4 rounded-xl mb-6 text-sm font-medium border border-yellow-200 flex gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <div>
                            Pesanan berhasil dibuat. Silakan selesaikan pembayaran agar barang segera dikirim.
                        </div>
                    </div>
                    
                    <button id="pay-button" class="w-full bg-gradient-to-r from-primary to-indigo-600 text-white font-bold py-4 rounded-xl hover:shadow-lg hover:shadow-indigo-500/30 transition transform hover:-translate-y-0.5 flex justify-center items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
                        Bayar Sekarang
                    </button>

                @elseif($order->payment_status == '2')
                    <div class="bg-green-50 text-green-700 p-4 rounded-xl mb-4 text-center font-bold border border-green-200 flex flex-col items-center gap-2">
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        </div>
                        Pembayaran Lunas
                    </div>
                    <p class="text-center text-xs text-slate-400">Terima kasih sudah berbelanja!</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection