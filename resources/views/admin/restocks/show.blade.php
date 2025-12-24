@extends('layouts.main')

@section('content')
<div class="container mx-auto px-4 py-8">
    
    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Detail Restock</h1>
            <p class="text-gray-500 text-sm">Dashboard Admin / Restock / Lihat</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.restocks.edit', $restock) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg font-bold hover:bg-indigo-700 transition">
                Edit
            </a>
            <a href="{{ route('admin.restocks.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-bold hover:bg-gray-300 transition">
                Kembali
            </a>
        </div>
    </div>

    {{-- ALERT SUKSES --}}
    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm" role="alert">
            <p class="font-bold">Berhasil!</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    {{-- DETAIL RESTOCK --}}
    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-200">
        
        {{-- Section Informasi Umum --}}
        <div class="mb-8">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Informasi Restock</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Produk --}}
                <div>
                    <label class="block text-sm font-bold text-gray-600 mb-2">Produk</label>
                    <div class="text-base font-bold text-gray-900">{{ $restock->product->name }}</div>
                    <div class="text-xs text-gray-400">SKU: {{ $restock->product->slug }}</div>
                </div>

                {{-- Supplier --}}
                <div>
                    <label class="block text-sm font-bold text-gray-600 mb-2">Supplier</label>
                    <div class="text-base font-bold text-gray-900">{{ $restock->supplier->name }}</div>
                    <div class="text-xs text-gray-600">{{ $restock->supplier->phone ?? '-' }}</div>
                </div>

                {{-- Jumlah Masuk --}}
                <div>
                    <label class="block text-sm font-bold text-gray-600 mb-2">Jumlah Masuk</label>
                    <div class="text-2xl font-bold text-green-600">+{{ $restock->qty }}</div>
                </div>

                {{-- Harga Modal --}}
                <div>
                    <label class="block text-sm font-bold text-gray-600 mb-2">Harga Modal (per unit)</label>
                    <div class="text-lg font-bold text-gray-900">Rp {{ number_format($restock->buy_price, 0, ',', '.') }}</div>
                </div>

                {{-- Total Modal --}}
                <div>
                    <label class="block text-sm font-bold text-gray-600 mb-2">Total Modal</label>
                    <div class="text-lg font-bold text-blue-600">Rp {{ number_format($restock->qty * $restock->buy_price, 0, ',', '.') }}</div>
                </div>

                {{-- Tanggal --}}
                <div>
                    <label class="block text-sm font-bold text-gray-600 mb-2">Tanggal Restock</label>
                    <div class="text-base text-gray-900">{{ \Carbon\Carbon::parse($restock->date)->format('d/m/Y') }}</div>
                </div>

                {{-- Tanggal Dibuat --}}
                <div>
                    <label class="block text-sm font-bold text-gray-600 mb-2">Dicatat Pada</label>
                    <div class="text-sm text-gray-600">{{ $restock->created_at->format('d/m/Y H:i') }}</div>
                </div>

                {{-- Tanggal Diperbarui --}}
                <div>
                    <label class="block text-sm font-bold text-gray-600 mb-2">Diperbarui Pada</label>
                    <div class="text-sm text-gray-600">{{ $restock->updated_at->format('d/m/Y H:i') }}</div>
                </div>
            </div>
        </div>

        {{-- Section Info Produk Terkini --}}
        <div class="border-t pt-8">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Status Produk Saat Ini</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Stok Produk --}}
                <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                    <div class="text-sm font-bold text-gray-600 mb-1">Stok Produk</div>
                    <div class="text-3xl font-bold text-green-600">{{ $restock->product->stock }}</div>
                </div>

                {{-- Harga Jual --}}
                <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                    <div class="text-sm font-bold text-gray-600 mb-1">Harga Jual</div>
                    <div class="text-2xl font-bold text-blue-600">Rp {{ number_format($restock->product->price, 0, ',', '.') }}</div>
                </div>

                {{-- Margin --}}
                <div class="bg-purple-50 p-4 rounded-lg border border-purple-200">
                    <div class="text-sm font-bold text-gray-600 mb-1">Margin per unit</div>
                    <div class="text-2xl font-bold text-purple-600">Rp {{ number_format($restock->product->price - $restock->buy_price, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>

        {{-- Tombol Hapus --}}
        <div class="mt-8 pt-6 border-t">
            <form action="{{ route('admin.restocks.destroy', $restock) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin? Restock ini akan dihapus dan stok produk akan berkurang ' + {{ $restock->qty }} + ' unit.');" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-red-700 transition">
                    Hapus Restock
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
