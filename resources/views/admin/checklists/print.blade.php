@extends('layouts.admin')

@section('content')
    <div class="p-8">
        <h1 class="text-xl font-bold">NOTA CHECKLIST #{{ $cl->id }}</h1>
        <p class="text-sm text-gray-600">Order: {{ $cl->order->invoice_code ?? $cl->order->id }} — Pelanggan: {{ $cl->recipient_name }}</p>
        <p class="text-sm text-gray-600">Dikirim: {{ $cl->sent_at ? $cl->sent_at->format('d/m/Y H:i') : '-' }}</p>

        <table class="w-full mt-4 border-collapse">
            <thead>
                <tr>
                    <th class="border p-2 text-left">Produk</th>
                    <th class="border p-2 text-center">Qty</th>
                    <th class="border p-2 text-center">Checked</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cl->order->orderItems as $oi)
                <tr>
                    <td class="p-2 border">{{ $oi->product_name }}</td>
                    <td class="p-2 border text-center">{{ $oi->qty }}</td>
                    <td class="p-2 border text-center">{{ $cl->items->where('product_id', $oi->product_id)->first()->qty_checked ?? 0 }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-6">
            <button onclick="window.print()" class="bg-primary text-white px-4 py-2 rounded">Print</button>
        </div>
    </div>
@endsection