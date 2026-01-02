@extends('layouts.main')

@section('content')
    <div class="container mx-auto px-4 md:px-12 py-12">

        <a href="{{ route('orders.index') }}"
            class="inline-flex items-center gap-2 text-slate-500 hover:text-primary mb-8 font-bold group">
            <div class="p-2 bg-slate-100 rounded-lg group-hover:bg-indigo-50 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
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
                            <span
                                class="text-sm font-bold text-slate-700">{{ $order->created_at->format('d F Y, H:i') }}</span>
                        </div>
                    </div>

                    <div class="p-6 space-y-6">
                        @foreach ($order->orderItems as $item)
                            <div class="flex gap-4 items-start">
                                <div class="w-16 h-16 bg-white border border-slate-200 rounded-lg p-1 flex-shrink-0">
                                    <img src="{{ asset('storage/' . $item->product->image) }}"
                                        class="w-full h-full object-contain"
                                        onerror="this.src='https://via.placeholder.com/150'">
                                </div>

                                <div class="flex-grow">
                                    <h4 class="font-bold text-slate-800 text-sm md:text-base">
                                        {{ $item->product->name ?? $item->product_name }}</h4>
                                    <p class="text-sm text-slate-500 mt-1">{{ $item->qty }} x Rp
                                        {{ number_format($item->price, 0, ',', '.') }}</p>
                                </div>

                                <div class="font-bold text-slate-800">
                                    Rp {{ number_format($item->price * $item->qty, 0, ',', '.') }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="p-6 bg-slate-50 border-t border-slate-100">
                        <h3 class="font-bold text-slate-800 mb-2 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Alamat Pengiriman
                        </h3>
                        <p class="text-slate-600 leading-relaxed ml-7 text-sm">
                            {{ $order->address ?? 'Alamat tidak tersedia' }}</p>
                    </div>
                </div>
            </div>

            <div class="w-full lg:w-1/3">
                <div class="bg-white p-6 rounded-2xl shadow-lg shadow-indigo-100 border border-slate-100 sticky top-24">
                    <h3 class="text-xl font-bold mb-6">Status Pembayaran</h3>

                    <div class="mb-6 pb-6 border-b border-slate-100">
                        <p class="text-sm text-slate-500 mb-1">Total Tagihan</p>
                        <p class="text-3xl font-extrabold text-primary">Rp
                            {{ number_format($order->total_price, 0, ',', '.') }}</p>
                    </div>

                    @if ($order->status == 'pending' || $order->payment_status == '1')
                        <div
                            class="bg-yellow-50 text-yellow-800 p-3 rounded-xl mb-4 text-xs font-medium border border-yellow-200 flex gap-2 items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0 mt-0.5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <p>Pesanan dibuat. Segera bayar sebelum expired.</p>
                        </div>

                        <div class="flex gap-2">

                            <button id="pay-button"
                                class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-xl shadow-md hover:shadow-lg transition-all flex justify-center items-center gap-2 group">
                                <span>Bayar Sekarang</span>
                            </button>

                            <a href="{{ route('orders.reset', $order->id) }}"
                                class="flex-none bg-white border-2 border-slate-200 text-slate-500 hover:text-red-600 hover:border-red-200 hover:bg-red-50 font-semibold py-3 px-5 rounded-xl flex justify-center items-center gap-2 transition-all order-1 md:order-2 group"
                                title="Klik jika link pembayaran error">

                                <div class="w-5 h-5 flex items-center justify-center"> <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5 group-hover:rotate-180 transition-transform duration-500"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                </div>

                                <span class="whitespace-nowrap">Refresh Link</span>
                            </a>

                        </div>

                        <p class="text-[10px] text-slate-400 text-right mt-1 mr-1">
                            *Klik icon panah jika tombol bayar error
                        </p>
                    @else
                        <div
                            class="bg-green-50 text-green-700 p-6 rounded-xl mb-4 text-center font-bold border border-green-200 flex flex-col items-center gap-3">
                            <div
                                class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center border-2 border-green-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <span class="text-lg">Pembayaran Lunas</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
    </script>

    <script type="text/javascript">
        var payButton = document.getElementById('pay-button');

        if (payButton) {
            payButton.addEventListener('click', function() {
                // Debugging: Cek di Console browser apakah token ada
                console.log("Snap Token:", '{{ $order->snap_token }}');

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
                            console.log(result);
                        },
                        onClose: function() {
                            alert('Anda menutup popup pembayaran sebelum menyelesaikan transaksi');
                        }
                    });
                @else
                    alert("Maaf, Token Pembayaran belum tersedia. Silakan refresh halaman.");
                    location.reload();
                @endif
            });
        }
    </script>
@endsection
