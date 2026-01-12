@extends('layouts.admin')

@section('page-title')
    Pesanan Masuk
@endsection

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold">Pesanan Masuk</h2>
            <p class="text-sm text-gray-500">Daftar pesanan yang sudah dibayar dan siap diproses</p>
        </div>
    </div>

    {{-- Alert Messages --}}
    @if (session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    @if (session('info'))
        <div class="bg-blue-50 border-l-4 border-blue-500 text-blue-700 p-4 rounded mb-4">
            {{ session('info') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">
        <table class="w-full text-left">
            <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                <tr>
                    <th class="p-3">Invoice</th>
                    <th class="p-3">Tanggal</th>
                    <th class="p-3">Pelanggan</th>
                    <th class="p-3">Items</th>
                    <th class="p-3">Total</th>
                    <th class="p-3">Status</th>
                    <th class="p-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr class="border-b hover:bg-gray-50">
                        {{-- 1. Invoice --}}
                        <td class="p-3 font-mono text-sm">#{{ $order->invoice_code }}</td>

                        {{-- 2. Tanggal --}}
                        <td class="p-3 text-sm">{{ $order->created_at->format('d/m/Y H:i') }}</td>

                        {{-- 3. Pelanggan --}}
                        <td class="p-3">
                            <div class="font-medium">{{ $order->user->name ?? 'Guest' }}</div>
                            <div class="text-xs text-gray-500">{{ $order->user->email ?? '-' }}</div>
                        </td>

                        {{-- 4. Items Count --}}
                        <td class="p-3 text-center">
                            <span class="bg-gray-100 px-2 py-1 rounded text-sm">
                                {{ $order->orderItems->count() }} item
                            </span>
                        </td>

                        {{-- 5. Total Harga (Cek grand_total atau total_price) --}}
                        <td class="p-3 font-bold text-primary">
                            Rp {{ number_format($order->grand_total ?? $order->total_price, 0, ',', '.') }}
                        </td>

                        {{-- 6. Status --}}
                        <td class="p-3">
                            @if (in_array($order->status, ['paid', 'settlement']))
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">
                                    LUNAS
                                </span>
                            @elseif($order->status == 'processing')
                                <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-bold">
                                    DIPROSES GUDANG
                                </span>
                            @else
                                <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-bold">
                                    {{ strtoupper($order->status) }}
                                </span>
                            @endif
                        </td>

                        {{-- 7. Aksi (Button Logic) --}}
                        <td class="p-3 text-right">
                            @if ($order->checklist)
                                {{-- Jika SUDAH ada checklist --}}
                                <a href="{{ route('admin.checklists.show', $order->checklist->id) }}"
                                   class="inline-block bg-blue-100 text-blue-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-200 transition">
                                    Lihat Checklist
                                </a>
                            @else
                                {{-- Jika BELUM ada checklist --}}
                                <form action="{{ route('admin.orders.send_checklist', $order->id) }}" method="POST" class="inline" onsubmit="return confirm('Kirim pesanan ini ke Gudang?');">
                                    @csrf
                                    <button type="submit"
                                            class="bg-orange-500 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-orange-600 transition shadow-sm">
                                        Kirim ke Checklist
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-8 text-center text-gray-500">
                            <div class="py-8">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-300 mx-auto mb-4"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                                <p class="text-lg font-medium">Belum ada pesanan yang dibayar</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $orders->links() }}
    </div>
@endsection