@extends('layouts.admin')

@section('title', 'Audit Trail')

@section('content')
<div class="container mx-auto px-4 py-6">
    
    {{-- Header dengan Icon SVG --}}
    <div class="mb-6 flex items-center gap-3">
        <div class="p-3 bg-white rounded-lg shadow-sm border border-slate-200">
            {{-- Icon Clipboard List (Pengganti CCTV) --}}
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-rose-600">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z" />
            </svg>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Audit Trail System</h1>
            <p class="text-slate-500 text-sm">Rekaman aktivitas dan perubahan data sensitif.</p>
        </div>
    </div>

    <div class="bg-white shadow-sm rounded-xl overflow-hidden border border-slate-200">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider w-40">Waktu</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider w-56">Pelaku (User)</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider w-32">Aksi</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Deskripsi Detail</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-100">
                    @forelse ($logs as $log)
                        <tr class="hover:bg-slate-50 transition duration-150">
                            {{-- 1. Waktu --}}
                            <td class="px-6 py-4 text-sm whitespace-nowrap">
                                <div class="font-medium text-slate-700">{{ $log->created_at->format('d M Y') }}</div>
                                <div class="text-xs text-slate-400 mt-0.5 flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-13a.75.75 0 00-1.5 0v5c0 .414.336.75.75.75l4 1a.75.75 0 10.368-1.454l-3.618-.905V5z" clip-rule="evenodd" />
                                    </svg>
                                    {{ $log->created_at->format('H:i:s') }}
                                </div>
                            </td>

                            {{-- 2. Pelaku --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-9 w-9 bg-slate-100 rounded-full flex items-center justify-center border border-slate-200">
                                        <span class="text-sm font-bold text-slate-600">
                                            {{ substr($log->user->name ?? '?', 0, 1) }}
                                        </span>
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-semibold text-slate-800">
                                            {{ $log->user->name ?? 'User Terhapus' }}
                                        </div>
                                        <div class="text-xs text-slate-500">
                                            {{ $log->user->role ?? 'Unknown Role' }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- 3. Badge Aksi --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $bgClass = 'bg-slate-100 text-slate-700 border-slate-200'; // Default
                                    
                                    if(str_contains($log->action, 'CREATE')) {
                                        $bgClass = 'bg-emerald-50 text-emerald-700 border-emerald-200';
                                    } elseif(str_contains($log->action, 'UPDATE')) {
                                        $bgClass = 'bg-amber-50 text-amber-700 border-amber-200';
                                    } elseif(str_contains($log->action, 'DELETE')) {
                                        $bgClass = 'bg-rose-50 text-rose-700 border-rose-200';
                                    }
                                @endphp

                                <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-bold rounded-full border {{ $bgClass }}">
                                    {{ $log->action }}
                                </span>
                            </td>

                            {{-- 4. Deskripsi --}}
                            <td class="px-6 py-4 text-sm text-slate-600 leading-relaxed">
                                {{ $log->description }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    {{-- Icon Empty State (SVG Folder Search) --}}
                                    <div class="bg-slate-50 p-4 rounded-full mb-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-slate-400">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-slate-900 font-medium">Belum ada aktivitas</h3>
                                    <p class="text-slate-500 text-sm mt-1">Semua perubahan data akan tercatat di sini.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($logs->hasPages())
        <div class="px-6 py-4 bg-slate-50 border-t border-slate-200">
            {{ $logs->links() }}
        </div>
        @endif
    </div>
</div>
@endsection