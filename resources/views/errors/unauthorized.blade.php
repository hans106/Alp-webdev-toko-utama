@extends('layouts.admin')

@section('page-title')
    Akses Ditolak
@endsection

@section('content')
    {{-- Modal Backdrop --}}
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        {{-- Modal Card --}}
        <div class="bg-white rounded-2xl shadow-2xl p-8 max-w-md w-96">
            {{-- Icon Warning --}}
            <div class="text-center mb-6">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-red-100 mb-4">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4v2m0 4v2M6.343 3.665c.886-.887 2.318-.887 3.204 0l.707.707a1 1 0 001.414 0l.707-.707c.886-.887 2.318-.887 3.204 0l3.464 3.464c.886.887.886 2.318 0 3.204l-.707.707a1 1 0 000 1.414l.707.707c.887.886.887 2.318 0 3.204l-3.464 3.464c-.886.887-2.318.887-3.204 0l-.707-.707a1 1 0 00-1.414 0l-.707.707c-.886.887-2.318.887-3.204 0L3.343 15.464c-.886-.887-.886-2.318 0-3.204l.707-.707a1 1 0 000-1.414l-.707-.707c-.887-.886-.887-2.318 0-3.204l3.464-3.464z"></path>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-800">Akses Ditolak</h2>
            </div>

            {{-- Message --}}
            <div class="text-center mb-6">
                <p class="text-gray-700 font-medium mb-3">
                    ⚠️ Fitur ini hanya dapat diakses oleh:
                </p>
                <div class="bg-primary-50 border-l-4 border-primary p-4 rounded-lg text-left mb-4">
                    @php
                        $rolesText = [
                            'master' => '👤 Super Admin (Pemilik)',
                            'inventory' => '📦 Staff Gudang (Inventory)',
                            'admin_penjualan' => '💳 Staff Kasir (Admin Penjualan)',
                        ];
                        $allowedRoles = $allowedRoles ?? [];
                    @endphp
                    
                    @forelse($allowedRoles as $role)
                        <p class="text-primary font-semibold text-sm">
                            {{ $rolesText[$role] ?? ucfirst($role) }}
                        </p>
                    @empty
                        <p class="text-primary font-semibold text-sm">Tidak ada akses yang tersedia</p>
                    @endforelse
                </div>

                <p class="text-gray-600 text-sm">
                    Akun Anda saat ini: <span class="font-bold text-gray-800">{{ Auth::user()->name ?? 'Unknown' }}</span>
                    <br>
                    Role: <span class="font-bold text-red-600">{{ ucfirst(Auth::user()->role ?? 'unknown') }}</span>
                </p>
            </div>

            {{-- Buttons --}}
            <div class="flex gap-3">
                {{-- Close Button (X) --}}
                <button 
                    type="button" 
                    onclick="goBack()" 
                    class="flex-1 px-4 py-3 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold rounded-lg transition-all">
                    ✕ Tutup
                </button>

                {{-- Login Button --}}
                <a 
                    href="{{ route('login') }}" 
                    class="flex-1 px-4 py-3 bg-primary hover:bg-primary-700 text-white font-bold rounded-lg transition-all text-center">
                    🔓 Gunakan Akun Lain
                </a>
            </div>

            {{-- Footer --}}
            <div class="text-center mt-6 text-xs text-gray-500 border-t pt-4">
                <p>Hubungi administrator jika Anda merasa ini adalah kesalahan.</p>
            </div>
        </div>
    </div>

    <script>
        function goBack() {
            // Kembali ke halaman sebelumnya
            window.history.back();
        }
    </script>
@endsection
