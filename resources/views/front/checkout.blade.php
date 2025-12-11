@extends('layouts.main')

@section('content')
<div class="container mx-auto px-4 md:px-12 py-12">
    
    <div class="mb-6">
        <a href="{{ route('cart.index') }}" class="inline-flex items-center gap-2 text-slate-500 hover:text-primary transition font-bold">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            <span>Kembali ke Keranjang</span>
        </a>
    </div>

    <h1 class="text-3xl font-bold mb-8 text-slate-800">Checkout Pengiriman</h1>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative mb-6">
            <strong class="font-bold">Waduh! Ada yang kurang nih:</strong>
            <ul class="mt-2 list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="flex flex-col lg:flex-row gap-8">
        <div class="w-full lg:w-2/3">
            <form action="{{ route('checkout.process') }}" method="POST" class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
                @csrf
                
                <h3 class="text-xl font-bold mb-6 text-slate-800 border-b border-slate-100 pb-4">Data Penerima</h3>
                
                <div class="mb-6">
                    <label class="block font-bold text-slate-700 mb-2 text-sm">Nama Penerima</label>
                    <input type="text" value="{{ Auth::user()->name }}" class="w-full bg-slate-100 border border-slate-200 rounded-xl px-4 py-3 text-slate-500 font-medium cursor-not-allowed" readonly>
                </div>

                <div class="mb-6">
                    <label class="block font-bold text-slate-700 mb-2 text-sm">Nomor WhatsApp / HP Aktif <span class="text-red-500">*</span></label>
                    <input type="number" name="phone" value="{{ old('phone') }}" class="w-full bg-white border border-slate-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary outline-none transition" placeholder="Contoh: 081234567890" required>
                    <p class="text-xs text-slate-400 mt-1">*Wajib angka, minimal 10 digit.</p>
                </div>

                <div class="mb-6">
                    <label class="block font-bold text-slate-700 mb-2 text-sm">Alamat Lengkap Pengiriman <span class="text-red-500">*</span></label>
                    <textarea name="address" rows="3" class="w-full bg-white border border-slate-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary outline-none transition" placeholder="Jalan, Nomor Rumah, RT/RW, Kelurahan, Patokan..." required>{{ old('address') }}</textarea>
                    <p class="text-xs text-slate-400 mt-1">*Tulis alamat lengkap minimal 10 huruf.</p>
                </div>

                <div class="mb-8">
                    <label class="block font-bold text-slate-700 mb-2 text-sm">Catatan (Opsional)</label>
                    <input type="text" name="notes" value="{{ old('notes') }}" class="w-full bg-white border border-slate-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary outline-none transition" placeholder="Contoh: Pagar warna hitam">
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-primary to-indigo-600 text-white font-bold py-4 rounded-xl hover:shadow-lg transition transform hover:-translate-y-0.5 text-lg">
                    Buat Pesanan
                </button>
            </form>
        </div>

        <div class="w-full lg:w-1/3">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 sticky top-24">
                <h3 class="text-xl font-bold mb-4">Ringkasan Barang</h3>
                
                <div class="space-y-4 mb-6 max-h-80 overflow-y-auto pr-2">
                    @foreach($carts as $cart)
                    <div class="flex gap-3 items-start border-b border-slate-50 pb-3 last:border-0">
                        <div class="w-12 h-12 bg-slate-50 rounded-lg overflow-hidden flex-shrink-0 border border-slate-200">
                            <img src="{{ asset($cart->product->image) }}" class="w-full h-full object-contain">
                        </div>
                        <div class="flex-grow text-sm">
                            <p class="font-bold text-slate-700 line-clamp-1">{{ $cart->product->name }}</p>
                            <div class="flex justify-between mt-1 text-slate-500">
                                <span>{{ $cart->qty }} x Rp {{ number_format($cart->product->price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="border-t border-slate-200 pt-4 flex justify-between items-center">
                    <span class="font-bold text-slate-600">Total Tagihan</span>
                    <span class="text-2xl font-extrabold text-primary">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection