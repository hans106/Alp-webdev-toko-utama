@extends('layouts.main')

@section('content')
    <div class="container mx-auto px-4 md:px-12 py-10">

        <div class="mb-6">
            <a href="{{ route('catalog') }}"
                class="inline-flex items-center gap-2 text-slate-500 hover:text-primary transition font-bold group">
                <div class="p-2 bg-slate-100 rounded-full group-hover:bg-indigo-50 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform group-hover:-translate-x-1 transition"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </div>
                <span>Kembali Belanja</span>
            </a>
        </div>

        <h1 class="text-3xl font-bold mb-8 text-slate-800">Keranjang Belanja</h1>

        @if (session('success'))
            <div class="bg-green-100 border border-green-200 text-green-700 p-4 rounded-xl mb-6 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border border-red-200 text-red-700 p-4 rounded-xl mb-6 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                        clip-rule="evenodd" />
                </svg>
                {{ session('error') }}
            </div>
        @endif

        @if ($carts->count() > 0)
            <div class="flex flex-col lg:flex-row gap-8">
                <div class="w-full lg:w-2/3">
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                        @foreach ($carts as $cart)
                            <div
                                class="flex items-center gap-4 p-6 border-b border-slate-100 last:border-0 hover:bg-slate-50 transition">
                                <div
                                    class="w-20 h-20 bg-white border border-slate-200 rounded-lg overflow-hidden flex-shrink-0 p-1">
                                    <img src="{{ asset($cart->product->image_main) }}" class="w-full h-full object-contain">
                                </div>

                                <div class="flex-grow">
                                    <h3 class="font-bold text-slate-800 text-lg">{{ $cart->product->name }}</h3>
                                    <p class="text-primary font-bold">Rp
                                        {{ number_format($cart->product->price, 0, ',', '.') }}</p>
                                    <p class="text-xs text-slate-500 mt-1">Sisa Stok: {{ $cart->product->stock }}</p>
                                </div>

                                <div
                                    class="flex items-center gap-3 bg-slate-50 rounded-full px-2 py-1 border border-slate-200">
                                    <form action="{{ route('cart.update', $cart->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        <input type="hidden" name="type" value="minus">
                                        <button type="submit"
                                            class="w-7 h-7 rounded-full bg-white hover:bg-slate-200 flex items-center justify-center font-bold text-slate-600 shadow-sm transition">-</button>
                                    </form>
                                    <span class="font-bold w-6 text-center text-slate-800">{{ $cart->qty }}</span>
                                    <form action="{{ route('cart.update', $cart->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        <input type="hidden" name="type" value="plus">
                                        <button type="submit"
                                            class="w-7 h-7 rounded-full bg-white hover:bg-slate-200 flex items-center justify-center font-bold text-slate-600 shadow-sm transition">+</button>
                                    </form>
                                </div>

                                <form action="{{ route('cart.destroy', $cart->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin hapus barang ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-slate-400 hover:text-rose-500 p-2 transition"
                                        title="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="w-full lg:w-1/3">
                    <div
                        class="bg-white p-6 rounded-2xl shadow-lg shadow-slate-200/50 border border-slate-100 sticky top-28">
                        <h3 class="text-xl font-bold mb-6 pb-4 border-b border-slate-100">Ringkasan Pesanan</h3>

                        <div class="flex justify-between mb-3 text-slate-600">
                            <span>Total Barang</span>
                            <span class="font-medium">{{ $carts->sum('qty') }} pcs</span>
                        </div>

                        <div class="flex justify-between mb-8 items-end">
                            <span class="font-bold text-slate-800">Total Tagihan</span>
                            <span class="text-2xl font-extrabold text-primary">Rp
                                {{ number_format($totalPrice, 0, ',', '.') }}</span>
                        </div>

                        {{-- TOMBOL CHECKOUT --}}
                        <a href="{{ route('checkout.index') }}"
                            class="block w-full bg-gradient-to-r from-primary to-indigo-700 text-white text-center font-bold py-4 rounded-xl hover:shadow-lg hover:shadow-indigo-500/30 transition transform hover:-translate-y-0.5">
                            Lanjut Pembayaran &rarr;
                        </a>

                        {{-- NOTE: Tombol "Lanjut Belanja" yang di bawah sudah DIHAPUS sesuai request --}}
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-24 bg-slate-50 rounded-3xl border border-dashed border-slate-300">
                <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-slate-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-800 mb-2">Keranjang Kosong</h3>
                <p class="text-slate-500 mb-6">Wah, belum ada belanjaan nih. Yuk cari barang!</p>
                <a href="{{ route('catalog') }}"
                    class="inline-flex items-center gap-2 bg-primary text-white px-8 py-3 rounded-xl font-bold hover:bg-indigo-700 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Katalog
                </a>
            </div>
        @endif
    </div>
@endsection
