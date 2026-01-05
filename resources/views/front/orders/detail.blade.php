@extends('layouts.main')

@section('content')
    <div class="container mx-auto px-4 md:px-12 py-12">

        {{-- Tombol Kembali --}}
        <a href="{{ route('orders.index') }}" class="inline-flex items-center gap-2 text-slate-500 hover:text-primary mb-8 font-bold group">
            <div class="p-2 bg-slate-100 rounded-lg group-hover:bg-indigo-50 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </div>
            <span>Kembali ke Riwayat</span>
        </a>

        <div class="flex flex-col lg:flex-row gap-8">

            {{-- BAGIAN KIRI: Detail Item --}}
            <div class="w-full lg:w-2/3">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                    
                    {{-- Header Status --}}
                    <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                        <div>
                            <p class="text-xs text-slate-500 font-bold uppercase tracking-wider mb-1">Nomor Invoice</p>
                            <p class="text-lg font-bold text-slate-800">#{{ $order->invoice_code }}</p>
                        </div>
                        <div>
                            @if ($order->status == 'pending')
                                <span class="bg-yellow-100 text-yellow-700 px-4 py-2 rounded-full text-xs font-bold border border-yellow-200">Pending</span>
                            @elseif($order->status == 'paid' || $order->status == 'settlement' || $order->status == 'capture')
                                <span class="bg-green-100 text-green-700 px-4 py-2 rounded-full text-xs font-bold border border-green-200">Lunas</span>
                            @elseif($order->status == 'expire')
                                <span class="bg-red-100 text-red-700 px-4 py-2 rounded-full text-xs font-bold border border-red-200">Expired</span>
                            @else
                                <span class="bg-gray-100 text-gray-700 px-4 py-2 rounded-full text-xs font-bold border border-gray-200">{{ $order->status }}</span>
                            @endif
                        </div>
                    </div>

                    {{-- List Produk --}}
                    <div class="p-6">
                        <h3 class="font-bold text-slate-800 mb-4">Produk yang Dibeli</h3>
                        <div class="space-y-6">
                            @foreach ($order->orderItems as $item)
                                <div class="flex items-center gap-4 border-b border-slate-50 pb-4 last:border-0 last:pb-0">
                                    {{-- Foto Produk Kecil --}}
                                    <div class="w-20 h-20 bg-slate-100 rounded-xl overflow-hidden border border-slate-200 flex-shrink-0">
                                        <img src="{{ asset( $item->product->image_main ) }}" 
                                             alt="{{ $item->product->name }}" 
                                             class="w-full h-full object-cover"
                                             onerror="this.onerror=null; this.src='https://via.placeholder.com/150?text=Produk';">
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-bold text-slate-800 text-lg">{{ $item->product->name }}</h4>
                                        <p class="text-slate-500 text-sm">Rp {{ number_format($item->product->price, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Info Pengiriman --}}
                    <div class="p-6 bg-slate-50 border-t border-slate-100">
                        <h3 class="font-bold text-slate-800 mb-3">Informasi Pengiriman</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-slate-500 mb-1">Penerima</p>
                                <p class="font-bold text-slate-700">{{ Auth::user()->name }}</p>
                            </div>
                            <div>
                                <p class="text-slate-500 mb-1">Alamat Email</p>
                                <p class="font-bold text-slate-700">{{ Auth::user()->email }}</p>
                            </div>
                            <div class="md:col-span-2">
                                <p class="text-slate-500 mb-1">Catatan / Alamat</p>
                                <p class="font-bold text-slate-700">
                                    {{ $order->address ?? 'Alamat Default User' }} {{-- Sesuaikan dengan kolom alamat di DB --}}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- BAGIAN KANAN: Pembayaran / Nota --}}
            <div class="w-full lg:w-1/3">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 sticky top-24">
                    <h3 class="font-bold text-slate-800 text-lg mb-4">Ringkasan Pembayaran</h3>

                    <div class="space-y-3 mb-6 text-sm">
                        <div class="flex justify-between text-slate-600">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-slate-600">
                            <span>Pajak / Biaya Layanan</span>
                            <span>Rp 0</span>
                        </div>
                        <div class="border-t border-dashed border-slate-200 my-2 pt-2 flex justify-between font-bold text-lg text-slate-800">
                            <span>Total Bayar</span>
                            <span>Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    {{-- LOGIC TOMBOL BAYAR VS NOTA --}}
                    @if ($order->status == 'paid' || $order->status == 'settlement' || $order->status == 'capture')
                        
                        {{-- TAMPILAN NOTA LUNAS --}}
                        <div class="bg-green-50 border border-green-200 rounded-xl p-5 text-center mb-4">
                            <div class="flex justify-center mb-3">
                                <div class="bg-green-100 p-2 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                            </div>
                            <h4 class="font-bold text-green-800 text-lg">Pembayaran Berhasil!</h4>
                            <p class="text-xs text-green-600 mt-1">Terima kasih sudah berbelanja.</p>
                        </div>
                        
                        <button onclick="window.print()" class="w-full py-3 bg-slate-800 text-white rounded-xl font-bold hover:bg-slate-700 transition flex justify-center items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                            </svg>
                            Cetak Nota
                        </button>

                    @elseif($order->status == 'cancelled' || $order->status == 'expire')
                        
                        {{-- TAMPILAN BATAL --}}
                        <div class="bg-red-50 border border-red-200 rounded-xl p-4 text-center">
                            <span class="text-red-600 font-bold">Pesanan Dibatalkan / Kadaluarsa</span>
                        </div>

                    @else
                        
                        {{-- TAMPILAN TOMBOL BAYAR (Midtrans) --}}
                        <button id="pay-button" class="w-full py-3 bg-indigo-600 text-white rounded-xl font-bold shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition transform hover:-translate-y-1">
                            Bayar Sekarang
                        </button>
                        <p class="text-xs text-center text-slate-400 mt-3">
                            Pembayaran aman & otomatis diverifikasi
                        </p>

                    @endif

                </div>
            </div>
        </div>
    </div>

    {{-- SCRIPT MIDTRANS --}}
    @if($order->status == 'pending')
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
        <script type="text/javascript">
            var payButton = document.getElementById('pay-button');
            if (payButton) {
                payButton.addEventListener('click', function() {
                    @if ($order->snap_token)
                        window.snap.pay('{{ $order->snap_token }}', {
                            onSuccess: function(result) {
                                alert("Pembayaran Berhasil!");
                                window.location.reload();
                            },
                            onPending: function(result) {
                                alert("Menunggu Pembayaran!");
                                window.location.reload();
                            },
                            onError: function(result) {
                                alert("Pembayaran Gagal!");
                                location.reload();
                            },
                            onClose: function() {
                                alert('Anda menutup popup pembayaran.');
                            }
                        });
                    @else
                        alert("Token pembayaran belum siap. Refresh halaman.");
                        location.reload();
                    @endif
                });
            }
        </script>
    @endif

@endsection