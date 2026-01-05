{{-- 1. Panggil Layout (Kode Panjang Tadi) --}}
@extends('layouts.admin')

{{-- 2. Ganti Judul Tab Browser --}}
@section('page-title')
    Kelola Produk
@endsection

{{-- 3. Isi Konten Utamanya (Tabel Produk) --}}
@section('content')

    {{-- Header Halaman --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Manajemen Produk</h2>
            <p class="text-gray-500 text-sm">Kelola daftar barang dagangan toko.</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="bg-[#F4A236] hover:bg-[#d68515] text-white px-5 py-2.5 rounded-xl shadow-lg transition-all flex items-center gap-2 font-medium">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            Tambah Produk
        </a>
    </div>

    {{-- Tabel Produk --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider border-b border-gray-100">
                    <th class="p-4 font-semibold">Foto & Nama Produk</th>
                    <th class="p-4 font-semibold">Kategori</th>
                    <th class="p-4 font-semibold">Harga</th>
                    <th class="p-4 font-semibold">Stok</th>
                    <th class="p-4 font-semibold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($products as $product)
                <tr class="hover:bg-gray-50 transition-colors group">
                    <td class="p-4">
                        <div class="flex items-center gap-3">
                            {{-- Foto Produk Kecil --}}
                            <div class="w-12 h-12 rounded-lg bg-gray-100 overflow-hidden border border-gray-200">
                                @php
                                    $imgSrc = null;
                                    $imgPath = $product->image_main ?? null;
                                    if ($imgPath && preg_match('/^https?:\/\//i', $imgPath)) {
                                        $imgSrc = $imgPath;
                                    } elseif ($imgPath && file_exists(public_path($imgPath))) {
                                        $imgSrc = asset($imgPath);
                                    } elseif ($imgPath && file_exists(public_path('products/' . $imgPath))) {
                                        $imgSrc = asset('products/' . $imgPath);
                                    } else {
                                        $imgSrc = asset('logo/logo_utama.jpeg');
                                    }
                                @endphp
                                <img src="{{ $imgSrc }}" class="w-full h-full object-cover" onerror="this.onerror=null;this.src='{{ asset('logo/logo_utama.jpeg') }}';">
                            </div>
                            <div>
                                <p class="font-bold text-gray-800">{{ $product->name }}</p>
                                <p class="text-xs text-gray-500">{{ $product->brand->name ?? '-' }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="p-4 text-sm text-gray-600">
                        <span class="px-2 py-1 rounded-md bg-gray-100 text-xs font-medium">
                            {{ $product->category->name ?? 'Tanpa Kategori' }}
                        </span>
                    </td>
                    <td class="p-4 font-medium text-gray-800">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </td>
                    <td class="p-4">
                        @if($product->stock <= 5)
                            <span class="text-red-600 font-bold text-sm flex items-center gap-1">
                                {{ $product->stock }}
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        @else
                            <span class="text-green-600 font-bold text-sm">{{ $product->stock }}</span>
                        @endif
                    </td>
                    <td class="p-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="text-gray-400 hover:text-primary transition p-2 rounded-lg hover:bg-primary-50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Yakin hapus barang ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-gray-400 hover:text-red-600 transition p-2 rounded-lg hover:bg-red-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-8 text-center text-gray-400">
                        Belum ada data produk. Silakan tambah produk baru.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        {{-- Pagination (Navigasi Halaman 1, 2, 3...) --}}
        @if($products->hasPages())
            <div class="p-4 border-t border-gray-100 bg-gray-50">
                {{ $products->links() }}
            </div>
        @endif
    </div>

@endsection