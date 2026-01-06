@extends('layouts.admin')

@section('page-title', 'Detail Checklist')

@section('content')

    {{-- HEADER & TOMBOL KEMBALI --}}
    <div class="mb-6">
        <a href="{{ route('admin.checklists.index') }}" class="text-gray-500 hover:text-gray-700 mb-4 inline-block">&larr; Kembali</a>
        <h2 class="text-2xl font-bold">Checklist Nota #{{ $checklist->id }}</h2>
        
        @if($checklist->status == 'sudah_fix')
            <span class="bg-green-100 text-green-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded">SIAP DIPRINT</span>
        @else
            <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded">BELUM SELESAI</span>
        @endif
    </div>

    {{-- TABEL ITEM DENGAN TOMBOL CENTANG SAT-SET --}}
    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200 mb-6">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                <tr>
                    <th class="p-4 border-b">Produk</th>
                    <th class="p-4 border-b text-center">Qty Diminta</th>
                    <th class="p-4 border-b text-center">Status Cek</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($checklist->items as $item)
                <tr class="{{ $item->qty_checked >= $item->qty_required ? 'bg-green-50' : 'bg-white' }} hover:bg-gray-50 transition">
                    <td class="p-4">
                        <div class="font-medium text-gray-900">{{ $item->product->name }}</div>
                        <div class="text-xs text-gray-500">{{ $item->product->sku ?? '-' }}</div>
                    </td>
                    <td class="p-4 text-center font-bold text-gray-700">
                        {{ $item->qty_required }}
                    </td>
                    <td class="p-4 text-center">
                        <form action="{{ route('admin.checklists.item.toggle', $item->id) }}" method="POST">
                            @csrf
                            
                            @if($item->qty_checked >= $item->qty_required)
                                {{-- Tombol Hijau (Sudah OK) --}}
                                <button type="submit" class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-green-500 text-white hover:bg-green-600 transition shadow-sm" title="Klik untuk membatalkan">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                </button>
                            @else
                                {{-- Tombol Abu-abu (Belum OK) --}}
                                <button type="submit" class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gray-200 text-gray-400 hover:bg-gray-300 transition border-2 border-gray-300 border-dashed" title="Klik untuk checklist barang ini">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                </button>
                            @endif
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- TOMBOL AKSI --}}
    <div class="flex justify-end items-center gap-4 bg-white p-4 rounded-xl shadow-sm border border-gray-200">
        
        <div class="text-sm text-gray-500 mr-auto">
            Pastikan semua item tercentang hijau sebelum mencetak.
        </div>

        @if($checklist->status == 'sudah_fix')
            {{-- TOMBOL PRINT FIX: HANYA MEMBUKA TAB BARU --}}
            <a href="{{ route('admin.checklists.print', $checklist->id) }}" 
               target="_blank"
               class="bg-red-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-red-700 transition flex items-center gap-2 shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                CETAK NOTA
            </a>

            {{-- TOMBOL KIRIM: AKAN REDIRECT & KASIH NOTIFIKASI --}}
            <form action="{{ route('admin.checklists.send', $checklist->id) }}" method="POST" onsubmit="return confirm('Kirim barang sekarang? Status order akan berubah jadi SENT.');">
                @csrf
                <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-blue-700 transition shadow-lg">
                    Kirim ke Kurir &rarr;
                </button>
            </form>
        @else
            <button disabled class="bg-gray-300 text-gray-500 px-6 py-3 rounded-lg font-bold cursor-not-allowed flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                CETAK NOTA (Lengkapi Dulu)
            </button>
        @endif
    </div>

@endsection