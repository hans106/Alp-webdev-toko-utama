@extends('layouts.admin')

@section('page-title')
    Manajemen Restock
@endsection

@section('content')
    
    {{-- HEADER & TOMBOL TAMBAH --}}
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Manajemen Restock</h1>
            <p class="text-gray-500 text-sm">Dashboard Admin / Pencatatan Barang Masuk dari Supplier</p>
        </div>
        
        <a href="{{ route('admin.restocks.create') }}" class="bg-green-600 text-white px-6 py-2 rounded-xl hover:bg-green-700 transition font-bold shadow-lg flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            Tambah Restock
        </a>
    </div>

    {{-- ALERT SUKSES --}}
    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm" role="alert">
            <p class="font-bold">Berhasil!</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    {{-- FORM PENCARIAN & FILTER --}}
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200 mb-8">
        <form action="{{ route('admin.restocks.index') }}" method="GET">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                
                {{-- Search Bar --}}
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" 
                        placeholder="Cari nama produk/supplier..."
                        class="w-full pl-4 pr-4 py-2 border rounded-xl focus:ring-blue-500 focus:border-blue-500 transition">
                </div>

                {{-- Filter Supplier --}}
                <select name="supplier_id" class="w-full py-2 px-4 border rounded-xl focus:ring-blue-500 focus:border-blue-500 bg-white transition">
                    <option value="">Semua Supplier</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" {{ request('supplier_id') == $supplier->id ? 'selected' : '' }}>
                            {{ $supplier->name }}
                        </option>
                    @endforeach
                </select>

                {{-- Filter Produk --}}
                <select name="product_id" class="w-full py-2 px-4 border rounded-xl focus:ring-blue-500 focus:border-blue-500 bg-white transition">
                    <option value="">Semua Produk</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>
                            {{ $product->name }}
                        </option>
                    @endforeach
                </select>

                {{-- Tombol Cari --}}
                <div>
                    <button type="submit" class="bg-gray-800 text-white px-6 py-2 rounded-xl font-bold hover:bg-gray-900 transition w-full">
                        Cari
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- TABEL RESTOCK --}}
    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Produk</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Supplier</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Qty Masuk</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Harga Modal</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($restocks as $restock)
                    <tr class="hover:bg-gray-50 transition">
                        {{-- Produk --}}
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-gray-900">{{ $restock->product->name }}</div>
                            <div class="text-xs text-gray-400">SKU: {{ $restock->product->slug }}</div>
                        </td>

                        {{-- Supplier --}}
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $restock->supplier->name }}
                        </td>

                        {{-- Qty Masuk --}}
                        <td class="px-6 py-4 text-sm font-bold text-blue-600">
                            +{{ $restock->qty }}
                        </td>

                        {{-- Harga Modal --}}
                        <td class="px-6 py-4 text-sm text-gray-600">
                            Rp {{ number_format($restock->buy_price, 0, ',', '.') }}
                        </td>

                        {{-- Tanggal --}}
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ \Carbon\Carbon::parse($restock->date)->format('d/m/Y') }}
                        </td>
                        
                        {{-- Kolom Aksi --}}
                        <td class="px-6 py-4 text-sm font-medium">
                            <div class="flex gap-2">
                                {{-- Tombol VIEW --}}
                                <a href="{{ route('admin.restocks.show', $restock) }}" class="text-blue-600 hover:text-blue-900 bg-blue-50 px-3 py-1 rounded-md transition">Lihat</a>
                                
                                {{-- Tombol EDIT --}}
                                <a href="{{ route('admin.restocks.edit', $restock) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 px-3 py-1 rounded-md transition">Edit</a>
                                
                                {{-- Tombol DELETE --}}
                                <form action="{{ route('admin.restocks.destroy', $restock) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin? Stok produk akan berkurang.');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 px-3 py-1 rounded-md transition">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                                <p>Belum ada restock. Silakan tambah restock baru.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- PAGINATION --}}
    <div class="mt-6">
        {{ $restocks->links() }}
    </div>
@endsection
