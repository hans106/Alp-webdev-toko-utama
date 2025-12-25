@extends('layouts.admin')

@section('page-title')
    Pesanan Masuk
@endsection

@section('content')

    {{-- Header Halaman --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Pesanan Masuk</h2>
            <p class="text-gray-500 text-sm">Kelola transaksi yang masuk dari pembeli.</p>
        </div>
    </div>

    {{-- Tabel Pesanan --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider border-b border-gray-100">
                    <th class="p-4 font-semibold">ID Order</th>
                    <th class="p-4 font-semibold">Pembeli</th>
                    <th class="p-4 font-semibold">Total Bayar</th>
                    <th class="p-4 font-semibold text-center">Status</th>
                    <th class="p-4 font-semibold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($orders as $order)
                <tr class="hover:bg-gray-50 transition-colors">
                    {{-- ID Order --}}
                    <td class="p-4 font-mono text-sm text-blue-600 font-bold">
                        #{{ $order->invoice_code ?? $order->id }}
                    </td>

                    {{-- Info Pembeli --}}
                    <td class="p-4">
                        <p class="font-bold text-gray-800">{{ $order->user->name ?? 'Guest' }}</p>
                        <p class="text-xs text-gray-500">{{ $order->user->email ?? '-' }}</p>
                    </td>

                    {{-- Total Harga --}}
                    <td class="p-4 font-medium text-gray-800">
                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                    </td>

                    {{-- Status Order --}}
                    <td class="p-4 text-center">
                        @if($order->status == 'paid' || $order->status == 'settlement' || $order->status == 'capture')
                            <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold">LUNAS</span>
                        @elseif($order->status == 'pending')
                            <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-bold">PENDING</span>
                        @elseif($order->status == 'sent')
                            <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-bold">DIKIRIM</span>
                        @else
                            <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-700 text-xs font-bold">{{ strtoupper($order->status) }}</span>
                        @endif
                    </td>

                    {{-- Tombol Aksi --}}
                    <td class="p-4 text-right">
                        {{-- Logika Tombol Kirim --}}
                        @if($order->status == 'paid' || $order->status == 'settlement' || $order->status == 'capture')
                            <form action="{{ route('admin.orders.ship', $order->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin mau kirim barang ini?')">
                                @csrf
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-xs font-bold shadow-md transition-all flex items-center gap-2 ml-auto">
                                    <span>Kirim Barang</span> 🚚
                                </button>
                            </form>
                        @elseif($order->status == 'sent')
                            <span class="text-xs text-gray-400 italic">Sedang dalam pengiriman</span>
                        @else
                            <span class="text-xs text-gray-400 italic">Menunggu Pembayaran</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-8 text-center text-gray-400">
                        <div class="flex flex-col items-center">
                            <svg class="w-12 h-12 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            <p>Belum ada pesanan masuk.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        {{-- Pagination --}}
        <div class="p-4 border-t border-gray-100 bg-gray-50">
            {{ $orders->links() }}
        </div>
    </div>

@endsection