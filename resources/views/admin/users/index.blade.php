@extends('layouts.admin')

@section('page-title', 'Manajemen Pengguna')

@section('content')
    <div class="max-w-7xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-lg font-semibold text-slate-700">Daftar Pengguna</h3>
                <p class="text-sm text-gray-500">Kelola akun pengguna aplikasi (hanya untuk Superadmin).</p>
            </div>
            <div class="flex items-center gap-3">
                <form method="GET" action="" class="flex items-center">
                    <input type="text" name="q" placeholder="Cari nama atau email..." value="{{ request('q') }}"
                        class="px-4 py-2 rounded-lg border border-slate-200 bg-white text-slate-600 focus:outline-none focus:ring-2 focus:ring-[#A41025]" />
                    <button type="submit" class="ml-2 px-4 py-2 rounded-lg bg-[#A41025] text-white hover:bg-[#8f0f20]">Cari</button>
                </form>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-xl overflow-hidden">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-[#A41025] text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold">#</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Nama</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Email</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Role</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Dibuat</th>
                        <th class="px-6 py-3 text-right text-sm font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-100">
                    @forelse ($users as $index => $user)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 text-sm text-slate-600">{{ $users->firstItem() + $index }}</td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-slate-800">{{ $user->name }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600">{{ $user->email }}</td>
                            <td class="px-6 py-4 text-sm capitalize">{{ $user->role }}</td>
                            <td class="px-6 py-4 text-sm text-slate-500">{{ $user->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="#" class="px-3 py-1 rounded-lg bg-slate-100 text-slate-700 text-sm">Lihat</a>
                                    <a href="#" class="px-3 py-1 rounded-lg bg-[#A41025] text-white text-sm">Edit</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-slate-500">Belum ada pengguna.</td>
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
