@extends('layouts.main')

@section('content')
<div class="container mx-auto px-4 md:px-12 py-12">
    <h1 class="text-3xl font-bold mb-8 text-slate-800">Keranjang Belanja</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-6">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-4 rounded-xl mb-6">{{ session('error') }}</div>
    @endif

    @if($carts->count() > 0)
    <div class="flex flex-col lg:flex-row gap-8">
        <div class="w-full lg:w-2/3">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                @foreach($carts as $cart)
                <div class="flex items-center gap-4 p-6 border-b border-slate-100 last:border-0">
                    <div class="w-20 h-20 bg-slate-50 rounded-lg overflow-hidden flex-shrink-0">
                        <img src="{{ asset($cart->product->image) }}" class="w-full h-full object-contain">
                    </div>
                    
                    <div class="flex-grow">
                        <h3 class="font-bold text-slate-800">{{ $cart->product->name }}</h3>
                        <p class="text-primary font-bold">Rp {{ number_format($cart->product->price, 0, ',', '.') }}</p>
                        <p class="text-xs text-slate-500">Sisa Stok: {{ $cart->product->stock }}</p>
                    </div>

                    <div class="flex items-center gap-3">
                        <form action="{{ route('cart.update', $cart->id) }}" method="POST">
                            @csrf @method('PUT')
                            <input type="hidden" name="type" value="minus">
                            <button type="submit" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 flex items-center justify-center font-bold text-slate-600">-</button>
                        </form>
                        <span class="font-bold w-4 text-center">{{ $cart->qty }}</span>
                        <form action="{{ route('cart.update', $cart->id) }}" method="POST">
                            @csrf @method('PUT')
                            <input type="hidden" name="type" value="plus">
                            <button type="submit" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 flex items-center justify-center font-bold text-slate-600">+</button>
                        </form>
                    </div>

                    <form action="{{ route('cart.destroy', $cart->id) }}" method="POST" onsubmit="return confirm('Hapus barang ini?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-rose-500 hover:text-rose-700 p-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                        </button>
                    </form>
                </div>
                @endforeach
            </div>
        </div>

        <div class="w-full lg:w-1/3">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 sticky top-24">
                <h3 class="text-xl font-bold mb-4">Ringkasan</h3>
                <div class="flex justify-between mb-2 text-slate-600">
                    <span>Total Barang</span>
                    <span>{{ $carts->sum('qty') }} pcs</span>
                </div>
                <div class="flex justify-between mb-6 text-xl font-extrabold text-slate-900">
                    <span>Total Harga</span>
                    <span>Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                </div>
                
                <a href="#" class="block w-full bg-gradient-to-r from-primary to-indigo-600 text-white text-center font-bold py-4 rounded-xl hover:shadow-lg transition">
                    Lanjut Pembayaran
                </a>
                
                <a href="{{ route('catalog') }}" class="block w-full text-center mt-4 text-slate-500 hover:text-primary font-bold text-sm">
                    Lanjut Belanja
                </a>
            </div>
        </div>
    </div>
    @else
        <div class="text-center py-20">
            <p class="text-slate-500 mb-4">Keranjang belanjaanmu kosong nih.</p>
            <a href="{{ route('catalog') }}" class="bg-primary text-white px-6 py-3 rounded-xl font-bold">Mulai Belanja</a>
        </div>
    @endif
</div>
@endsection