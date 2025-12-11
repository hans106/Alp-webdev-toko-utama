@extends('layouts.main')

@section('content')
<div class="container mx-auto px-4 md:px-12 py-12">
    <h1 class="text-3xl font-bold mb-8 text-slate-800">Riwayat Pesanan Saya</h1>

    @if($orders->count() > 0)
        <div class="space-y-6">
            @foreach($orders as $order)
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        
                        <div>
                            <div class="flex items-center gap-3 mb-2">
                                <span class="font-bold text-slate-800 text-lg">#{{ $order->invoice_code }}</span>
                                <span class="text-xs text-slate-500">{{ $order->created_at->format('d M Y, H:i') }}</span>
                            </div>
                            
                            <div class="flex items-center gap-2">
                                @if($order->payment_status == '1')
                                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-bold border border-yellow-200">
                                        Menunggu Pembayaran
                                    </span>
                                @elseif($order->payment_status == '2')
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold border border-green-200">
                                        Lunas
                                    </span>
                                @elseif($order->payment_status == '3')
                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold border border-red-200">
                                        Kadaluarsa
                                    </span>
                                @else
                                    <span class="bg-slate-100 text-slate-700 px-3 py-1 rounded-full text-xs font-bold border border-slate-200">
                                        Dibatalkan
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="flex flex-col items-end gap-2">
                            <span class="text-sm text-slate-500">Total Tagihan</span>
                            <span class="text-xl font-extrabold text-primary">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                            
                            <a href="{{ route('orders.show', $order->id) }}" class="inline-flex items-center gap-2 bg-indigo-50 text-primary px-5 py-2.5 rounded-xl font-bold text-sm hover:bg-primary hover:text-white transition">
                                Lihat Detail & Bayar
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-20 bg-slate-50 rounded-3xl border border-dashed border-slate-300">
            <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-2">Belum Ada Pesanan</h3>
            <p class="text-slate-500 mb-6">Kamu belum pernah belanja di Toko Utama nih.</p>
            <a href="{{ route('catalog') }}" class="bg-primary text-white px-8 py-3 rounded-xl font-bold hover:shadow-lg transition">
                Mulai Belanja Sekarang
            </a>
        </div>
    @endif
</div>
@endsection