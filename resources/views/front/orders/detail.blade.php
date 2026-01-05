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

        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl">
                <strong class="font-bold">Berhasil!</strong>
                <p class="text-sm mt-1">{{ session('success') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl">
                <strong class="font-bold">Error!</strong>
                <p class="text-sm mt-1">{{ session('error') }}</p>
            </div>
        @endif

        @if(session('info'))
            <div class="mb-6 bg-primary-50 border border-primary-100 text-primary px-4 py-3 rounded-xl">
                <strong class="font-bold">Info:</strong>
                <p class="text-sm mt-1">{{ session('info') }}</p>
            </div>
        @endif

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
                                <span class="bg-yellow-100 text-yellow-700 px-4 py-2 rounded-full text-xs font-bold border border-yellow-200">⏳ Pending</span>
                            @elseif($order->status == 'paid' || $order->status == 'settlement' || $order->status == 'capture')
                                <span class="bg-green-100 text-green-700 px-4 py-2 rounded-full text-xs font-bold border border-green-200">✅ Lunas</span>
                            @elseif($order->status == 'expire')
                                <span class="bg-red-100 text-red-700 px-4 py-2 rounded-full text-xs font-bold border border-red-200">⛔ Expired</span>
                            @elseif($order->status == 'cancelled')
                                <span class="bg-gray-100 text-gray-700 px-4 py-2 rounded-full text-xs font-bold border border-gray-200">❌ Dibatalkan</span>
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
                                    {{-- Foto Produk --}}
                                    @php
                                        $imgSrc = null;
                                        $imgPath = $item->product->image_main ?? null;
                                        if ($imgPath && preg_match('/^https?:\/\//i', $imgPath)) {
                                            $imgSrc = $imgPath;
                                        } elseif ($imgPath && file_exists(public_path($imgPath))) {
                                            $imgSrc = asset($imgPath);
                                        } elseif ($imgPath && file_exists(public_path('products/' . $imgPath))) {
                                            $imgSrc = asset('products/' . $imgPath);
                                        } else {
                                            $imgSrc = asset('logo/logo_utama.jpeg');
                                        }
                                    @endphp
                                    <div class="w-20 h-20 bg-slate-100 rounded-xl overflow-hidden border border-slate-200 flex-shrink-0">
                                        <img src="{{ $imgSrc }}" 
                                             alt="{{ $item->product->name }}" 
                                             class="w-full h-full object-cover"
                                             onerror="this.onerror=null; this.src='{{ asset('logo/logo_utama.jpeg') }}';">
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-bold text-slate-800 text-lg">{{ $item->product->name }}</h4>
                                        <p class="text-slate-500 text-sm">{{ $item->qty }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-slate-800">Rp {{ number_format($item->qty * $item->price, 0, ',', '.') }}</p>
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
                                <p class="font-bold text-slate-700">{{ $order->address ?? 'Alamat tidak tersedia' }}</p>
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
                            @if($order->paid_at)
                                <p class="text-xs text-green-500 mt-2">Dibayar: {{ $order->paid_at->format('d M Y, H:i') }}</p>
                            @endif
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

                    @elseif($order->status == 'accepted')

                        {{-- TAMPILAN TOMBOL BAYAR (Midtrans) --}}
                        <button id="pay-button" class="w-full py-3 bg-indigo-600 text-white rounded-xl font-bold shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition transform hover:-translate-y-1">
                            Bayar
                        </button>

                        {{-- TOMBOL PERBARUI / GENERATE TOKEN PEMBAYARAN --}}
                        <button id="refresh-token" class="block w-full mt-3 py-3 bg-white border border-slate-200 rounded-xl text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
                            Perbarui Link Pembayaran
                        </button>
                        
                        {{-- TOMBOL CEK STATUS PEMBAYARAN --}}
                        <a href="{{ route('orders.check_status', $order->id) }}" 
                           class="block w-full mt-3 py-3 bg-slate-100 text-slate-700 rounded-xl font-bold hover:bg-slate-200 transition text-center">
                            🔄 Cek Status Pembayaran
                        </a>
                        
                        <p class="text-xs text-center text-slate-400 mt-3">
                            Pembayaran aman & otomatis diverifikasi
                        </p>

                    @elseif($order->status == 'pending')
                        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 text-center mb-3">
                            <p class="font-bold text-yellow-700">Menunggu penerimaan oleh Admin Penjualan.</p>
                            <p class="text-xs text-yellow-600 mt-1">Pembayaran akan dibuka setelah pesanan diterima.</p>
                        </div>
                        <a href="{{ route('orders.check_status', $order->id) }}" class="block w-full mt-3 py-3 bg-gray-100 text-gray-400 rounded-xl font-bold text-center cursor-not-allowed opacity-50">
                            🔄 Cek Status Pembayaran
                        </a>

                    @else
                        <p class="text-sm text-gray-500">Status: {{ $order->status }}</p>
                    @endif

                </div>
            </div>
        </div>
    </div>

    {{-- SCRIPT MIDTRANS --}}
    @if($order->status == 'accepted')
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
        <script type="text/javascript">
            // helper to call generate_snap endpoint
            function generateSnapAjax() {
                return fetch("{{ route('orders.generate_snap', $order->id) }}", {
                    method: 'GET',
                    headers: { 'Accept': 'application/json' }
                }).then(r => r.json());
            }

            // helper to open midtrans snap popup with consistent callbacks
            function openSnap(token) {
                if (!window.snap) {
                    alert('Midtrans Snap belum terload. Coba lagi.');
                    return;
                }

                window.snap.pay(token, {
                    onSuccess: function(result) {
                        alert("Pembayaran Berhasil!");
                        window.location.href = "{{ route('orders.check_status', $order->id) }}";
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
                        alert('Popup ditutup. Klik "Cek Status Pembayaran" untuk memperbarui status.');
                    }
                });
            }

            var payButton = document.getElementById('pay-button');
            if (payButton) {
                payButton.addEventListener('click', function() {
                    @if ($order->snap_token)
                        openSnap('{{ $order->snap_token }}');
                    @else
                        generateSnapAjax()
                        .then(function(data) {
                            if (data.success && data.snap_token) {
                                openSnap(data.snap_token);
                            } else {
                                alert(data.message || 'Gagal membuat token pembayaran.');
                            }
                        })
                        .catch(function(err) {
                            console.error(err);
                            alert('Gagal membuat token pembayaran.');
                        });
                    @endif
                });
            }

            // Refresh / Generate new token button
            var refreshBtn = document.getElementById('refresh-token');
            if (refreshBtn) {
                refreshBtn.addEventListener('click', function() {
                    var btn = this;
                    btn.disabled = true;
                    var orig = btn.innerHTML;
                    btn.innerHTML = 'Membuat...';

                    generateSnapAjax()
                        .then(function(data) {
                            if (data.success && data.snap_token) {
                                alert('Link pembayaran berhasil diperbarui. Pop-up pembayaran akan muncul sekarang.');
                                openSnap(data.snap_token);
                            } else {
                                alert(data.message || 'Gagal memperbarui token pembayaran.');
                            }
                        })
                        .catch(function(err) {
                            console.error(err);
                            alert('Gagal memperbarui token pembayaran.');
                        })
                        .finally(function() {
                            btn.disabled = false;
                            btn.innerHTML = orig;
                        });
                });
            }
        </script>

        @if(session('success') && str_contains(session('success'), 'Pesanan berhasil dibuat'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    setTimeout(function() {
                        const payBtn = document.getElementById('pay-button');
                        if (payBtn) payBtn.click();
                    }, 800);
                });
            </script>
        @endif
    @endif

@endsection