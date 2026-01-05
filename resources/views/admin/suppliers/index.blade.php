@extends('layouts.admin')

@section('page-title')
    Manajemen Supplier
@endsection

@section('content')
    {{-- TOMBOL TAMBAH --}}
    <div class="mb-6 flex justify-end">
        <a href="{{ route('admin.suppliers.create') }}" class="bg-green-600 text-white px-6 py-2.5 rounded-xl hover:bg-green-700 transition font-bold shadow-md flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            Tambah Supplier Baru
        </a>
    </div>

    {{-- ALERT SUKSES --}}
    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm" role="alert">
            <p class="font-bold">Berhasil!</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    {{-- FORM PENCARIAN (hanya cari berdasarkan nama) --}}
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 mb-8">
        <form action="{{ route('admin.suppliers.index') }}" method="GET">
            <div class="flex gap-4 items-end">
                <div class="flex-1">
                    <input type="text" name="search" value="{{ request('search') }}" 
                        placeholder="Cari nama supplier..."
                        class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#A41025] focus:border-transparent transition">
                </div>
                <button type="submit" class="bg-[#1A0C0C] text-white px-6 py-2 rounded-xl font-bold hover:bg-[#2d1515] transition">
                    Cari
                </button>
            </div>
        </form>
    </div>

    {{-- TABEL SUPPLIER --}}
    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">
                      
        <table class="w-full">
            <thead class="bg-[#1A0C0C] text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Nama Supplier</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">No. Telepon</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($suppliers as $supplier)
                <tr class="hover:bg-gray-50 transition">
                    {{-- Kolom Nama --}}
                    <td class="px-6 py-4">
                        <div class="text-sm font-bold text-gray-900">{{ $supplier->name }}</div>
                    </td>

                    {{-- Kolom Telepon --}}
                    <td class="px-6 py-4 text-sm text-gray-600">
                        {{ $supplier->phone ?? '-' }}
                    </td>
                    
                    {{-- Kolom Aksi --}}
                    <td class="px-6 py-4 text-sm font-medium">
                        <div class="flex gap-2">
                            {{-- Tombol EDIT --}}
                            <a href="{{ route('admin.suppliers.edit', $supplier) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 px-3 py-1 rounded-md transition font-medium">Edit</a>
                            
                            {{-- Tombol DELETE --}}
                            <form action="{{ route('admin.suppliers.destroy', $supplier) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus supplier ini?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 px-3 py-1 rounded-md transition font-medium">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="2" class="px-6 py-10 text-center text-gray-500">
                        <div class="flex flex-col items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 8.646 4 4 0 010-8.646M9 9H3m18 0h-6" />
                            </svg>
                            <p>Belum ada supplier. Silakan tambah supplier baru.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- PAGINATION --}}
    <div class="mt-6">
        {{ $suppliers->links() }}
    </div>
@endsection
