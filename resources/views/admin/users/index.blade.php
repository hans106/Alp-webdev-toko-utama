@extends('layouts.admin')

@section('page-title', 'Manajemen Pengguna')

@section('content')
    <div class="max-w-7xl mx-auto">
        {{-- Header & Search --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-lg font-semibold text-slate-700">Daftar Pengguna</h3>
                <p class="text-sm text-gray-500">Kelola akun pengguna aplikasi.</p>
            </div>
            <div class="flex items-center gap-3">
                {{-- Form Pencarian --}}
                <form method="GET" action="{{ route('admin.users.index') }}" class="flex items-center">
                    <input type="text" name="search" placeholder="Cari nama / email..." value="{{ request('search') }}"
                        class="px-4 py-2 rounded-lg border border-slate-200 bg-white text-slate-600 focus:outline-none focus:ring-2 focus:ring-[#A41025]" />
                    <button type="submit" class="ml-2 px-4 py-2 rounded-lg bg-[#A41025] text-white hover:bg-[#8f0f20] transition">
                        Cari
                    </button>
                </form>
            </div>
        </div>

        {{-- Alert Notifikasi --}}
        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-4 bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm">
                {{ session('error') }}
            </div>
        @endif

        {{-- Tabel User --}}
        <div class="bg-white shadow-md rounded-xl overflow-hidden">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-[#A41025] text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold">No</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Nama</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Email</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Role</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Dibuat</th>
                        <th class="px-6 py-3 text-right text-sm font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-100">
                    @forelse ($users as $index => $user)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4 text-sm text-slate-600">{{ $users->firstItem() + $index }}</td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-slate-800">{{ $user->name }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600">{{ $user->email }}</td>
                            <td class="px-6 py-4 text-sm">
                                @if(in_array($user->role, ['superadmin', 'inventory', 'cashier']))
                                    <span class="px-2 py-1 rounded-full bg-slate-100 text-slate-600 text-xs font-bold border border-slate-200 uppercase">
                                        {{ $user->role }}
                                    </span>
                                @else
                                    <span class="px-2 py-1 rounded-full bg-green-100 text-green-600 text-xs font-bold border border-green-200 uppercase">
                                        User
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-500">{{ $user->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-right">
                                {{-- LOGIKA TOMBOL DELETE: --}}
                                {{-- Hanya muncul jika role BUKAN superadmin, inventory, atau cashier --}}
                                @if(!in_array($user->role, ['superadmin', 'inventory', 'cashier']))
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Hapus user ini? Data tidak bisa dikembalikan.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1 rounded-lg bg-[#A41025] text-white text-xs hover:bg-[#8f0f20] transition shadow">
                                            Delete
                                        </button>
                                    </form>
                                @else
                                    <span class="text-xs text-slate-400 italic flex justify-end items-center gap-1 cursor-not-allowed" title="Role Utama tidak bisa dihapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                            <path fill-rule="evenodd" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z" clip-rule="evenodd" />
                                        </svg>
                                        Protected
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                                Belum ada data pengguna ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $users->withQueryString()->links() }}
        </div>
    </div>
@endsection