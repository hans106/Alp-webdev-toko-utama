@extends('layouts.admin')

@section('title', 'Manage Suppliers')

@section('content')
    {{-- Alpine JS (Optional, untuk interaksi kecil) --}}
    @once
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @endonce

    <div class="min-h-screen pb-12">

        {{-- 1. HEADER SECTION --}}
        <div class="flex flex-col md:flex-row justify-between items-end gap-6 mb-8 px-1">
            <div>
                <h1 class="text-4xl font-serif font-bold text-[#800000] tracking-wide">
                    <span class="text-[#E1B56A] font-sans font-light">Supplier</span> Data
                </h1>
                <div class="h-1.5 w-24 bg-gradient-to-r from-[#800000] to-[#E1B56A] mt-2 rounded-full"></div>
                <p class="text-slate-500 text-sm mt-1">Kelola data pemasok barang dagangan Anda.</p>
            </div>
            
            {{-- Tombol Tambah --}}
            <a href="{{ route('admin.suppliers.create') }}" 
               class="bg-[#800000] hover:bg-[#600000] text-white px-6 py-3 rounded-xl font-bold uppercase tracking-wider text-xs shadow-lg flex items-center gap-2 transition-all transform hover:-translate-y-1 border border-[#800000]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Tambah Supplier
            </a>
        </div>

        {{-- ALERT SUKSES --}}
        @if(session('success'))
            <div class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded-r-lg shadow-sm flex items-center gap-3">
                <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <p class="font-bold text-sm uppercase tracking-wide">Sukses</p>
                    <p class="text-sm">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        {{-- 2. SEARCH BAR & CONTENT WRAPPER --}}
        <div class="bg-white rounded-2xl shadow-xl border border-[#E1B56A]/20 overflow-hidden">
            
            {{-- Search Header --}}
            <div class="p-6 border-b border-gray-100 bg-[#FDFBF7]">
                <form action="{{ route('admin.suppliers.index') }}" method="GET" class="relative max-w-md">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-[#E1B56A]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" 
                        placeholder="Cari nama supplier..."
                        class="block w-full pl-10 pr-3 py-2.5 border-2 border-[#E1B56A]/30 rounded-xl leading-5 bg-white text-[#800000] placeholder-[#E1B56A]/70 focus:outline-none focus:border-[#800000] focus:ring-0 sm:text-sm transition-colors shadow-sm font-medium">
                    
                    {{-- Tombol Search (Optional, hidden on desktop if enter works, or keep style) --}}
                    <button type="submit" class="absolute right-2 top-1.5 bottom-1.5 bg-[#800000] text-white px-3 rounded-lg text-xs font-bold uppercase tracking-wider hover:bg-[#600000] transition-colors">
                        Cari
                    </button>
                </form>
            </div>

            {{-- 3. PREMIUM TABLE --}}
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-[#800000] text-white">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-widest border-b border-[#600000]">Nama Supplier</th>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-widest border-b border-[#600000]">Kontak</th>
                            <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-widest border-b border-[#600000] w-32">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($suppliers as $supplier)
                            <tr class="hover:bg-[#FDFBF7] transition-colors group">
                                {{-- Nama --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 rounded-full bg-[#E1B56A]/20 flex items-center justify-center text-[#800000] font-bold text-sm mr-3 border border-[#E1B56A]/30">
                                            {{ substr($supplier->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-bold text-gray-900 group-hover:text-[#800000] transition-colors">
                                                {{ $supplier->name }}
                                            </div>
                                            <div class="text-[10px] text-gray-400 uppercase tracking-wide">ID: #{{ $supplier->id }}</div>
                                        </div>
                                    </div>
                                </td>

                                {{-- Kontak --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($supplier->phone)
                                        <div class="flex items-center text-sm text-gray-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-[#E1B56A]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                            </svg>
                                            {{ $supplier->phone }}
                                        </div>
                                    @else
                                        <span class="text-xs text-slate-400 italic">Tidak ada nomor</span>
                                    @endif
                                </td>

                                {{-- Aksi --}}
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex items-center justify-center gap-2 opacity-80 group-hover:opacity-100 transition-opacity">
                                        {{-- Edit --}}
                                        <a href="{{ route('admin.suppliers.edit', $supplier) }}" class="text-[#E1B56A] hover:text-[#800000] p-2 hover:bg-[#E1B56A]/10 rounded-lg transition-all" title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>

                                        {{-- Delete --}}
                                        <form action="{{ route('admin.suppliers.destroy', $supplier) }}" method="POST" onsubmit="return confirm('Hapus supplier {{ $supplier->name }}?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-400 hover:text-red-700 p-2 hover:bg-red-50 rounded-lg transition-all" title="Hapus">
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
                                <td colspan="3" class="px-6 py-12 text-center bg-[#FDFBF7]">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-16 h-16 bg-[#E1B56A]/10 rounded-full flex items-center justify-center mb-4">
                                            <svg class="w-8 h-8 text-[#E1B56A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                        </div>
                                        <h3 class="text-[#800000] font-bold text-lg">Data Supplier Kosong</h3>
                                        <p class="text-slate-500 text-sm mt-1">Belum ada supplier yang ditambahkan.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Footer / Pagination --}}
            @if($suppliers->hasPages())
                <div class="bg-[#FDFBF7] px-6 py-4 border-t border-[#E1B56A]/20">
                    {{ $suppliers->links() }}
                </div>

                {{-- Style Khusus Pagination (Wajib ada biar warnanya Maroon) --}}
                <style>
                    nav[role="navigation"] span[aria-current="page"] > span {
                        background-color: #800000 !important;
                        border-color: #800000 !important;
                        color: white !important;
                    }
                    nav[role="navigation"] a:hover {
                        background-color: #fff !important;
                        color: #800000 !important;
                        border-color: #E1B56A !important;
                    }
                </style>
            @endif
        </div>
    </div>
@endsection