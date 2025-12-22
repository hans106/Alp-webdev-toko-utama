@extends('layouts.main')

@section('content')
<div class="container mx-auto px-4 md:px-12 py-12">

    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
        <div>
            <div class="flex items-center gap-3">
                <div class="bg-indigo-100 p-3 rounded-xl text-indigo-600">
                    {{-- Icon: Clipboard Document List --}}
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-slate-800">Rekapan Pesanan</h1>
                    <p class="text-slate-500">Pantau pembayaran masuk & kirim barang.</p>
                </div>
            </div>
        </div>
        
        {{-- Alert Notifikasi --}}
        @if(session('success'))
            <div class="flex items-center gap-2 bg-green-100 text-green-700 px-4 py-3 rounded-xl font-bold border border-green-200 shadow-sm animate-pulse">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                </svg>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="flex items-center gap-2 bg-red-100 text-red-700 px-4 py-3 rounded-xl font-bold border border-red-200">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                </svg>
                {{ session('error') }}
            </div>
        @endif
    </div>

    {{-- Tabel Pesanan --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 uppercase text-xs tracking-wider">
                        <th class="p-4 font-bold">Invoice</th>
                        <th class="p-4 font-bold">Pembeli</th>
                        <th class="p-4 font-bold">Total</th>
                        <th class="p-4 font-bold text-center">Status</th>
                        <th class="p-4 font-bold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($orders as $order)
                        <tr class="hover:bg-slate-50 transition duration-200">
                            
                            {{-- Kolom Invoice --}}
                            <td class="p-4">
                                <span class="font-bold text-indigo-600 flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-indigo-400">
                                        <path fill-rule="evenodd" d="M4.5 2A1.5 1.5 0 003 3.5v13A1.5 1.5 0 004.5 18h11a1.5 1.5 0 001.5-1.5V7.621a1.5 1.5 0 00-.44-1.06l-4.12-4.122A1.5 1.5 0 0011.378 2H4.5zm2.25 8.5a.75.75 0 000 1.5h6.5a.75.75 0 000-1.5h-6.5zm0 3a.75.75 0 000 1.5h6.5a.75.75 0 000-1.5h-6.5z" clip-rule="evenodd" />
                                    </svg>
                                    #{{ $order->invoice_code }}
                                </span>
                                <div class="text-xs text-slate-400 font-normal mt-1 ml-5">
                                    {{ $order->created_at->format('d M Y H:i') }}
                                </div>
                            </td>

                            {{-- Kolom Pembeli --}}
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                            <path d="M10 8a3 3 0 100-6 3 3 0 000 6zM3.465 14.493a1.23 1.23 0 00.41 1.412A9.957 9.957 0 0010 18c2.31 0 4.438-.784 6.131-2.1.43-.333.604-.903.408-1.41a7.002 7.002 0 00-13.074.003z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-700">{{ $order->user->name ?? 'User Dihapus' }}</div>
                                        <div class="text-xs text-slate-500">{{ $order->user->email ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>

                            {{-- Kolom Harga --}}
                            <td class="p-4 font-bold text-slate-800">
                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                            </td>

                            {{-- Kolom Status (DENGAN ICON) --}}
                            <td class="p-4 text-center">
                                @if($order->status == 'pending')
                                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-bold border border-yellow-200">
                                        {{-- Icon Jam --}}
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-13a.75.75 0 00-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 000-1.5h-3.25V5z" clip-rule="evenodd" />
                                        </svg>
                                        Belum Bayar
                                    </span>
                                
                                @elseif($order->status == 'paid' || $order->status == 'settlement' || $order->status == 'capture')
                                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold border border-green-200">
                                        {{-- Icon Centang / Uang --}}
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                        </svg>
                                        Lunas
                                    </span>
                                
                                @elseif($order->status == 'sent')
                                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold border border-blue-200">
                                        {{-- Icon Truck --}}
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                                            <path d="M6.5 3c-1.051 0-2.093.04-3.125.117A3.25 3.25 0 001 6.375v6.125c0 1.341.83 2.5 2 2.969V17.5c0 .621.504 1.125 1.125 1.125h1.75a1.125 1.125 0 001.125-1.125v-1.75h6v1.75c0 .621.504 1.125 1.125 1.125h1.75a1.125 1.125 0 001.125-1.125v-2.031c1.17-.469 2-1.628 2-2.969V9.675c0-.64-.234-1.259-.66-1.735l-2.663-2.993A3.375 3.375 0 0015.663 3.5H14.5V3h-8z" />
                                        </svg>
                                        Dikirim
                                    </span>
                                
                                @elseif($order->status == 'done')
                                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-bold border border-gray-200">
                                        {{-- Icon Selesai --}}
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                                            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                        </svg>
                                        Selesai
                                    </span>
                                
                                @else
                                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-bold border border-red-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $order->status }}
                                    </span>
                                @endif
                            </td>

                            {{-- Kolom Tombol Aksi --}}
                            <td class="p-4 text-center">
                                @if($order->status == 'paid' || $order->status == 'settlement' || $order->status == 'capture')
                                    <form action="{{ route('admin.orders.ship', $order->id) }}" method="POST">
                                        @csrf 
                                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-md text-sm transition transform hover:-translate-y-0.5 flex items-center gap-2 mx-auto">
                                            {{-- Icon Kirim Paket --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                                <path d="M6.5 3c-1.051 0-2.093.04-3.125.117A3.25 3.25 0 001 6.375v6.125c0 1.341.83 2.5 2 2.969V17.5c0 .621.504 1.125 1.125 1.125h1.75a1.125 1.125 0 001.125-1.125v-1.75h6v1.75c0 .621.504 1.125 1.125 1.125h1.75a1.125 1.125 0 001.125-1.125v-2.031c1.17-.469 2-1.628 2-2.969V9.675c0-.64-.234-1.259-.66-1.735l-2.663-2.993A3.375 3.375 0 0015.663 3.5H14.5V3h-8z" />
                                            </svg>
                                            Kirim Barang
                                        </button>
                                    </form>
                                
                                @elseif($order->status == 'pending')
                                    <span class="text-xs text-slate-400 italic flex items-center justify-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Nunggu Transfer
                                    </span>
                                
                                @elseif($order->status == 'sent')
                                    <span class="text-xs text-blue-600 font-bold flex items-center justify-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                                            <path fill-rule="evenodd" d="M2.24 6.8a.75.75 0 001.06-.04l1.95-2.1 1.95 2.1a.75.75 0 101.1-1.02l-2.5-2.7a.75.75 0 00-1.1 0l-2.5 2.7a.75.75 0 00.04 1.06zm6.12-2.26a.75.75 0 001.1 1.02l1.95-2.1 1.95 2.1a.75.75 0 001.06-1.06l-2.5-2.7a.75.75 0 00-1.1 0l-2.5 2.7zm-2.12 7.24a.75.75 0 00-1.06.04l-1.95 2.1-1.95-2.1a.75.75 0 00-1.1 1.02l2.5 2.7a.75.75 0 001.1 0l2.5-2.7a.75.75 0 00-.04-1.06zm6.12 2.26a.75.75 0 00-1.1-1.02l-1.95 2.1-1.95-2.1a.75.75 0 00-1.06 1.06l2.5 2.7a.75.75 0 001.1 0l2.5-2.7z" clip-rule="evenodd" />
                                        </svg>
                                        Sedang OTW
                                    </span>
                                @endif
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-12 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center">
                                    {{-- Icon Inbox Kosong --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 text-slate-300 mb-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                                    </svg>
                                    <p class="font-medium">Belum ada pesanan masuk, Juragan.</p>
                                    <p class="text-sm text-slate-400 mt-1">Santai dulu sambil ngopi ☕</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $orders->links() }}
    </div>
</div>
@endsection