@extends('layouts.admin')

@section('content')
<div class="bg-white p-8 max-w-4xl mx-auto shadow-lg print:shadow-none">
    
    {{-- JUDUL NOTA --}}
    <div class="flex justify-between items-center mb-8 border-b pb-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">NOTA PENGIRIMAN</h1>
            <p class="text-gray-500">No. Invoice: {{ $cl->order->invoice_code }}</p>
        </div>
        <div class="text-right">
            <h2 class="font-bold text-xl">{{ config('app.name', 'Toko Utama') }}</h2>
            <p class="text-sm text-gray-500">Tanggal: {{ date('d/m/Y') }}</p>
        </div>
    </div>

    {{-- INFO PENERIMA --}}
    <div class="mb-8">
        <h3 class="font-bold text-gray-700 mb-2">Penerima:</h3>
        <p class="text-lg font-semibold">{{ $cl->recipient_name }}</p>
        <p class="text-gray-600">{{ $cl->order->address ?? '-' }}</p>
    </div>

    {{-- TABEL BARANG --}}
    <table class="w-full mb-8 border border-gray-200">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-3 text-left border-b">Nama Produk</th>
                <th class="p-3 text-center border-b w-24">Qty</th>
                <th class="p-3 text-center border-b w-32">Status Cek</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cl->items as $item)
            <tr class="border-b">
                <td class="p-3">{{ $item->product->name }}</td>
                <td class="p-3 text-center font-bold">{{ $item->qty_checked }}</td>
                <td class="p-3 text-center text-xs">
                    <span class="px-2 py-1 bg-gray-200 rounded">OK</span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- TOMBOL PRINT (HANYA MUNCUL DI LAYAR, HILANG SAAT DI PRINT) --}}
    <div class="mt-8 text-right no-print">
        <button onclick="window.print()" class="bg-gray-800 text-white px-6 py-2 rounded-lg font-bold hover:bg-black transition">
            Print Sekarang
        </button>
    </div>
</div>

<style>
    @media print {
        .no-print, nav, header, footer, aside { display: none !important; }
        body { background: white; }
        .shadow-lg { box-shadow: none !important; }
    }
</style>

{{-- SCRIPT AUTO PRINT (Hapus bagian ini jika tidak ingin print otomatis muncul saat tab dibuka) --}}
<script>
    window.onload = function() {
        window.print();
    }
</script>
@endsection