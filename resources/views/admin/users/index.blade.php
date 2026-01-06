@extends('layouts.admin')

@section('page-title', 'Manajemen Pengguna')

@section('content')
    <div class="max-w-7xl mx-auto">
        
        {{-- Header & Search --}}
        <div class="flex flex-col md:flex-row items-start md:items-end justify-between mb-8 gap-4">
            <div>
                <h3 class="text-3xl font-serif font-bold text-[#800000] tracking-wide">Daftar Pengguna</h3>
                <div class="h-1 w-20 bg-gradient-to-r from-[#E1B56A] to-transparent mt-2 mb-2 rounded-full"></div>
                <p class="text-slate-600 text-sm">Kelola akun dan hak akses pengguna aplikasi.</p>
            </div>
            
            <div class="w-full md:w-auto">
                {{-- Form Pencarian --}}
                <form method="GET" action="{{ route('admin.users.index') }}" class="flex items-center gap-2 w-full">
                    <div class="relative w-full md:w-64">
                        <input type="text" name="search" placeholder="Cari nama / email..." value="{{ request('search') }}"
                            class="w-full px-4 py-2.5 rounded-lg border border-[#E1B56A]/30 bg-white text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#800000] focus:border-transparent shadow-sm placeholder-slate-400 text-sm transition-all" />
                        <svg class="w-4 h-4 absolute right-3 top-3 text-[#E1B56A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <button type="submit" class="px-5 py-2.5 rounded-lg bg-[#800000] text-white hover:bg-[#600000] transition-all shadow-md text-sm font-bold border border-[#800000]">
                        Cari
                    </button>
                </form>
            </div>
        </div>

        {{-- Alert Notifikasi --}}
        @if(session('success'))
            <div class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 px-4 py-3 rounded-r-lg text-sm shadow-sm flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded-r-lg text-sm shadow-sm flex items-center gap-2">
                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ session('error') }}
            </div>
        @endif

        {{-- TAMPILAN DESKTOP (Tabel) --}}
        <div class="hidden md:block bg-white rounded-2xl shadow-[0_10px_40px_-15px_rgba(0,0,0,0.1)] border border-[#E1B56A]/20 overflow-hidden">
            <table class="min-w-full divide-y divide-[#E1B56A]/10 text-left">
                <thead class="bg-[#800000] text-white">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider border-b-2 border-[#E1B56A]">No</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider border-b-2 border-[#E1B56A]">Nama</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider border-b-2 border-[#E1B56A]">Email</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider border-b-2 border-[#E1B56A]">Role</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider border-b-2 border-[#E1B56A]">Dibuat</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider border-b-2 border-[#E1B56A] text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E1B56A]/10 bg-white">
                    @forelse ($users as $index => $user)
                        <tr class="hover:bg-[#FDFBF7] transition-colors duration-200">
                            <td class="px-6 py-4 text-sm text-[#800000] font-mono font-bold">{{ $users->firstItem() + $index }}</td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-800">{{ $user->name }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600">{{ $user->email }}</td>
                            <td class="px-6 py-4 text-sm">
                                @if(in_array($user->role, ['master', 'inventory', 'admin_penjualan']))
                                    <span class="px-3 py-1 rounded-full bg-[#2B0A0A] text-[#E1B56A] text-[10px] font-bold border border-[#E1B56A]/30 uppercase tracking-wide shadow-sm">
                                        {{ $user->role }}
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-[10px] font-bold border border-emerald-200 uppercase tracking-wide shadow-sm">
                                        User
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-500">{{ $user->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-right">
                                @if(!in_array($user->role, ['master', 'inventory', 'admin_penjualan']))
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Hapus user ini? Data tidak bisa dikembalikan.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-4 py-1.5 rounded-lg bg-white border border-red-200 text-red-600 text-xs font-bold hover:bg-red-50 hover:text-red-700 transition shadow-sm">
                                            Delete
                                        </button>
                                    </form>
                                @else
                                    <span class="px-3 py-1.5 rounded-lg bg-slate-50 text-slate-400 text-xs font-bold border border-slate-100 inline-flex items-center gap-1 cursor-not-allowed opacity-70">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z" clip-rule="evenodd" /></svg>
                                        Protected
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    <p>Belum ada data pengguna ditemukan.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- TAMPILAN MOBILE/TABLET (Card View) --}}
        <div class="grid grid-cols-1 md:hidden gap-4">
            @forelse ($users as $index => $user)
            <div class="bg-white rounded-xl shadow-sm border border-[#E1B56A]/20 p-5 relative overflow-hidden">
                {{-- Aksen Dekorasi Kiri --}}
                <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-[#800000]"></div>
                
                <div class="flex justify-between items-start mb-3 pl-3">
                    <div>
                        <p class="text-[10px] uppercase tracking-widest text-slate-400 font-bold mb-1">User #{{ $users->firstItem() + $index }}</p>
                        <h4 class="font-bold text-slate-800 text-lg">{{ $user->name }}</h4>
                        <p class="text-xs text-[#E1B56A] italic">{{ $user->email }}</p>
                    </div>
                    {{-- Role Badge --}}
                    <div>
                        @if(in_array($user->role, ['master', 'inventory', 'admin_penjualan']))
                            <span class="px-2 py-1 rounded-md bg-[#2B0A0A] text-[#E1B56A] text-[10px] font-bold border border-[#E1B56A]/30 uppercase">
                                {{ $user->role }}
                            </span>
                        @else
                            <span class="px-2 py-1 rounded-md bg-emerald-100 text-emerald-700 text-[10px] font-bold border border-emerald-200 uppercase">
                                User
                            </span>
                        @endif
                    </div>
                </div>

                <div class="border-t border-slate-100 my-3 pl-3"></div>

                <div class="flex justify-between items-center pl-3">
                    <div class="text-xs text-slate-500">
                        Join: <span class="font-semibold text-slate-700">{{ $user->created_at->format('d M Y') }}</span>
                    </div>

                    {{-- Aksi Mobile --}}
                    <div>
                        @if(!in_array($user->role, ['master', 'inventory', 'admin_penjualan']))
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Hapus user ini? Data tidak bisa dikembalikan.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1.5 rounded-lg bg-red-50 text-red-600 border border-red-200 text-xs font-bold hover:bg-red-600 hover:text-white transition">
                                    Hapus Akun
                                </button>
                            </form>
                        @else
                            <span class="text-slate-400 text-xs flex items-center gap-1 italic">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z" clip-rule="evenodd" /></svg>
                                Protected
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="bg-white rounded-xl border border-slate-200 p-8 text-center text-slate-500">
                Belum ada data pengguna.
            </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-6 p-4 border-t border-[#E1B56A]/20 bg-[#FDFBF7] rounded-xl">
            {{ $users->withQueryString()->links() }}
        </div>
    </div>
@endsection