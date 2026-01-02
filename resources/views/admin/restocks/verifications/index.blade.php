@extends('layouts.admin')

@section('page-title')
    Checklist Nota Harga Restock
@endsection

@section('content')

    {{-- Header Halaman --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">📋 Checklist Nota Harga Restock</h2>
            <p class="text-gray-500 text-sm">Verifikasi nota harga restock dari supplier (Qty × Harga).</p>
        </div>
        <div class="text-right">
            @if($pendingCount > 0)
                <span class="bg-yellow-100 text-yellow-700 px-4 py-2 rounded-full font-bold text-sm">
                    ⏳ {{ $pendingCount }} Menunggu Verifikasi
                </span>
            @endif
        </div>
    </div>

    {{-- Tabel Verifikasi --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider border-b border-gray-100">
                    <th class="p-4 font-semibold">Restock ID</th>
                    <th class="p-4 font-semibold">Produk</th>
                    <th class="p-4 font-semibold">Supplier</th>
                    <th class="p-4 font-semibold text-center">Qty</th>
                    <th class="p-4 font-semibold text-right">Expected Total</th>
                    <th class="p-4 font-semibold text-right">Actual Total</th>
                    <th class="p-4 font-semibold text-center">Status</th>
                    <th class="p-4 font-semibold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($verifications as $verification)
                <tr class="hover:bg-gray-50 transition-colors">
                    {{-- Restock ID --}}
                    <td class="p-4 font-mono text-sm text-blue-600 font-bold">
                        #{{ $verification->restock_id }}
                    </td>

                    {{-- Produk --}}
                    <td class="p-4">
                        <p class="font-bold text-gray-800">{{ $verification->restock->product->name ?? '-' }}</p>
                        <p class="text-xs text-gray-500">Harga Beli: Rp {{ number_format($verification->restock->buy_price, 0, ',', '.') }}</p>
                    </td>

                    {{-- Supplier --}}
                    <td class="p-4 text-gray-700">
                        {{ $verification->restock->supplier->name ?? '-' }}
                    </td>

                    {{-- Qty --}}
                    <td class="p-4 text-center font-medium text-gray-800">
                        {{ $verification->restock->qty }} pcs
                    </td>

                    {{-- Expected Total --}}
                    <td class="p-4 text-right text-gray-800 font-medium">
                        <span class="bg-blue-50 text-blue-700 px-3 py-1 rounded-lg text-sm font-bold">
                            {{ $verification->getExpectedTotalFormatted() }}
                        </span>
                    </td>

                    {{-- Actual Total (dari nota supplier) --}}
                    <td class="p-4 text-right text-gray-800 font-medium">
                        @if($verification->actual_total)
                            <span class="bg-green-50 text-green-700 px-3 py-1 rounded-lg text-sm font-bold">
                                {{ $verification->getActualTotalFormatted() }}
                            </span>
                            @if($verification->matches)
                                <span class="text-green-600 font-bold text-sm block mt-1">✓ Sesuai</span>
                            @elseif($verification->matches === false)
                                <span class="text-red-600 font-bold text-sm block mt-1">✕ Berbeda</span>
                            @endif
                        @else
                            <span class="text-gray-400 italic">-</span>
                        @endif
                    </td>

                    {{-- Status --}}
                    <td class="p-4 text-center">
                        <span class="px-3 py-1 rounded-full text-xs font-bold {{ $verification->getStatusBadgeClass() }}">
                            {{ $verification->getStatusLabel() }}
                        </span>
                    </td>

                    {{-- Aksi --}}
                    <td class="p-4 text-right">
                        <a href="{{ route('admin.restock-verifications.edit', $verification->id) }}" 
                           class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-xs font-bold transition-all">
                            ✏️ Edit
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="p-8 text-center text-gray-400">
                        <div class="flex flex-col items-center">
                            <svg class="w-12 h-12 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            <p>Belum ada data verifikasi.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="p-4 border-t border-gray-100 bg-gray-50">
            {{ $verifications->links() }}
        </div>
    </div>

@endsection
