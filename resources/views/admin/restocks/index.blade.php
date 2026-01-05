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
            <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
                
                {{-- Search Bar --}}
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" 
                        placeholder="Nama Produk atau Supplier"
                        class="w-full pl-4 pr-4 py-2 border rounded-xl focus:ring-primary focus:border-primary transition">
                </div>

                {{-- Filter Supplier --}}
                <select name="supplier_id" class="w-full py-2 px-2 border rounded-xl focus:ring-primary focus:border-primary bg-white transition">
                    <option value="">Suplier</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" {{ request('supplier_id') == $supplier->id ? 'selected' : '' }}>
                            {{ $supplier->name }}
                        </option>
                    @endforeach
                </select>

                {{-- Filter Produk --}}
                <select name="product_id" class="w-full py-2 px-4 border rounded-xl focus:ring-primary focus:border-primary bg-white transition">
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
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($restocks as $restock)
                    @php $isDone = (
                        $restock->checklist_status === 'sudah_fix' &&
                        (int) ($restock->checked_qty ?? 0) >= 1 &&
                        strlen(trim((string) ($restock->checklist_notes ?? ''))) > 0
                    ); @endphp
                    <tr class="{{ $isDone ? 'bg-emerald-900 text-white' : 'hover:bg-gray-50' }} transition">
                        {{-- Produk --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                @php
                                    $imgSrc = null;
                                    $imgPath = $restock->product->image_main ?? null;
                                    // 1) full URL
                                    if ($imgPath && preg_match('/^https?:\/\//i', $imgPath)) {
                                        $imgSrc = $imgPath;
                                    }
                                    // 2) public path as-is
                                    elseif ($imgPath && file_exists(public_path($imgPath))) {
                                        $imgSrc = asset($imgPath);
                                    }
                                    // 3) public products folder
                                    elseif ($imgPath && file_exists(public_path('products/' . $imgPath))) {
                                        $imgSrc = asset('products/' . $imgPath);
                                    }
                                    // 4) fallback to logo
                                    else {
                                        $imgSrc = asset('logo/logo_utama.jpeg');
                                    }
                                @endphp
                                <div class="w-12 h-12 bg-slate-50 rounded-lg overflow-hidden flex-shrink-0 border border-slate-200">
                                    <img src="{{ $imgSrc }}" class="w-full h-full object-contain" onerror="this.onerror=null;this.src='{{ asset('logo/logo_utama.jpeg') }}';">
                                </div>
                                <div>
                                    <div class="text-sm font-bold {{ $isDone ? 'text-white' : 'text-gray-900' }}">{{ $restock->product->name }}</div>
                                    <div class="text-xs {{ $isDone ? 'text-white/80' : 'text-gray-400' }}">SKU: {{ $restock->product->slug }}</div>
                                </div>
                            </div>
                        </td>

                        {{-- Supplier --}}
                        <td class="px-6 py-4 {{ $isDone ? 'text-white' : 'text-sm text-gray-600' }}">
                            {{ $restock->supplier->name }}
                        </td>

                        {{-- Qty Masuk --}}
                        <td class="px-6 py-4 {{ $isDone ? 'text-white font-bold' : 'text-sm font-bold text-primary' }}">
                            +{{ $restock->qty }}
                        </td>

                        {{-- Tanggal dengan Warning jika lewat --}}
                        <td class="px-6 py-4 text-sm">
                            @php
                                $restockDate = \Carbon\Carbon::parse($restock->date);
                                $isOverdue = $restockDate->isPast();
                            @endphp
                            
                            <div class="flex items-center gap-2">
                                <span class="{{ $isOverdue ? ($isDone ? 'text-white/80' : 'text-red-600 font-bold') : ($isDone ? 'text-white/80' : 'text-gray-600') }}">
                                    {{ $restockDate->format('d/m/Y') }}
                                </span>
                                @if($isOverdue)
                                    <span class="bg-red-100 text-red-700 text-xs font-bold px-2 py-1 rounded-full animate-pulse">
                                        ⚠️ LEWAT JATUH TEMPO
                                    </span>
                                @endif
                            </div>
                        </td>
                        
                        {{-- Kolom Aksi (hanya Read & Delete) --}}
                        <td class="px-6 py-4 text-sm font-medium">
                            <div class="flex items-center gap-2">
                                {{-- Tombol VIEW --}}
                                <a href="{{ route('admin.restocks.show', $restock) }}" class="{{ $isDone ? 'bg-white/10 text-white' : 'text-primary hover:text-primary-700 bg-primary-50' }} px-3 py-1 rounded-md transition">Lihat</a>

                                @if (! $isDone)
                                    {{-- Tombol EDIT --}}
                                    <a href="{{ route('admin.restocks.edit', $restock) }}" class="px-3 py-1 rounded-md text-primary hover:text-primary-700 bg-primary-50 transition">Edit</a>

                                    {{-- Tombol CANCEL (Delete) --}}
                                    <form action="{{ route('admin.restocks.destroy', $restock) }}" method="POST" onsubmit="return confirm('Batal restock ini?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="px-3 py-1 rounded-md bg-red-600 text-white hover:bg-red-500 transition">Batal</button>
                                    </form>

                                    {{-- Tombol CHECKLIST (menggantikan Hapus) --}}
                                    <a href="{{ route('admin.restocks.checklist', $restock) }}" class="flex items-center gap-2 px-3 py-1 rounded-md transition text-yellow-600 hover:text-yellow-800 bg-yellow-50" title="Buka Checklist">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </a>
                                @endif

                                @if($isDone)
                                    <span class="ml-2 inline-flex items-center text-xs font-bold px-2 py-0.5 rounded-full bg-white text-emerald-900" title="Checklist Selesai">Selesai</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-500">
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
