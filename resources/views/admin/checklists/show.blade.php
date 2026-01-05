@extends('layouts.admin')

@section('page-title')
    Checklist Nota #{{ $checklist->id }}
@endsection

@section('content')

    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold">Checklist Nota #{{ $checklist->id }}</h2>
            <p class="text-sm text-gray-500">Order: {{ $checklist->order->invoice_code ?? $checklist->order->id }} — {{ $checklist->recipient_name }}<br>
                <span class="text-xs text-gray-400">Tanggal Pesanan: {{ \Carbon\Carbon::parse($checklist->order->created_at)->format('d/m/Y H:i') }}</span>
            </p>
        </div>
        <div class="flex gap-2">
            <form method="POST" action="{{ route('admin.checklists.status.update', $checklist->id) }}">
                @csrf
                <input type="hidden" name="status" value="sudah_fix">
                <button class="bg-green-600 text-white px-4 py-2 rounded">Tandai Sudah Fix</button>
            </form>
            <form method="POST" action="{{ route('admin.checklists.status.update', $checklist->id) }}">
                @csrf
                <input type="hidden" name="status" value="belum_selesai">
                <button class="bg-yellow-500 text-white px-4 py-2 rounded">Belum Selesai</button>
            </form>

            @php
                $incompleteCount = $checklist->items->filter(function($it){ return $it->qty_checked < $it->qty_required; })->count();
            @endphp

            {{-- Print available only when all items match --}}
            @if($incompleteCount > 0)
                <button class="bg-gray-300 text-gray-500 px-4 py-2 rounded" disabled>Belum Bisa Print</button>
            @else
                <a href="{{ route('admin.checklists.print', $checklist->id) }}" target="_blank" class="bg-primary text-white px-4 py-2 rounded">Print Nota</a>
            @endif
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded mb-4">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
        <h3 class="font-bold mb-4">Daftar Produk</h3>
        <table class="w-full">
            <thead class="text-xs text-gray-500">
                <tr>
                    <th class="p-2 text-left">Produk</th>
                    <th class="p-2 text-center">Qty Dibeli</th>
                    <th class="p-2 text-xs text-gray-500">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($checklist->items as $item)
                <tr class="border-t">
                    <td class="p-2">{{ $item->product->name }}</td>
                    <td class="p-2 text-center">{{ $item->qty_required }}</td>
                    <td class="p-2 text-center text-xs text-gray-500">{{ $item->qty_checked >= $item->qty_required ? 'OK' : 'PENDING' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection