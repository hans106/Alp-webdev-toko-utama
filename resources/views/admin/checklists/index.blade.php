@extends('layouts.admin')

@section('page-title')
    Checklist Nota
@endsection

@section('content')

    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold">Checklist Nota</h2>
            <p class="text-sm text-gray-500">Daftar nota virtual yang dikirim untuk pengecekan produk sebelum dikirim</p>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded mb-4">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">
        <table class="w-full text-left">
            <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                <tr>
                    <th class="p-3">ID</th>
                    <th class="p-3">Order</th>
                    <th class="p-3">Tanggal</th>
                    <th class="p-3">Pelanggan</th>
                    <th class="p-3">Items</th>
                    <th class="p-3">Status</th>
                    <th class="p-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($checklists as $c)
                <tr class="border-b">
                    <td class="p-3 font-mono">#{{ $c->id }}</td>
                    <td class="p-3">{{ $c->order->invoice_code ?? '#' . $c->order->id }}</td>
                    <td class="p-3">{{ \Carbon\Carbon::parse($c->order->created_at)->format('d/m/Y H:i') }}</td>
                    <td class="p-3">{{ $c->recipient_name }}</td>
                    <td class="p-3">{{ $c->items_count }}</td>
                    <td class="p-3">{{ strtoupper($c->status) }}</td>
                    <td class="p-3 text-right">
                        <a href="{{ route('admin.checklists.show', $c->id) }}" class="px-3 py-1 rounded bg-primary-50 text-primary">Lihat</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="p-8 text-center text-gray-500">Belum ada checklist.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $checklists->links() }}</div>

@endsection