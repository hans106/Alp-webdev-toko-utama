<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Toko Utama</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="flex min-h-screen">
        {{-- SIDEBAR --}}
        <div class="w-72 bg-gradient-to-b from-[#1A0C0C] to-[#2d1515] text-white shadow-2xl flex flex-col border-r border-[#A41025]/30">
            {{-- Logo Section --}}
            <div class="px-8 py-8 border-b border-[#A41025]/40 bg-black/20 backdrop-blur-sm">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-[#F4A236] to-[#A41025] flex items-center justify-center font-bold text-white shadow-lg">
                        TU
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-[#F4A236]">Toko Utama</h1>
                        <p class="text-[10px] text-amber-200 font-semibold tracking-widest">ADMIN PANEL</p>
                    </div>
                </div>
            </div>

            {{-- User Info Card --}}
            <div class="px-6 py-5 border-b border-[#A41025]/40 bg-gradient-to-r from-[#A41025]/20 to-transparent">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[#F4A236] to-[#A41025] flex items-center justify-center text-sm font-bold shadow-lg">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="text-sm font-bold text-white truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs bg-[#A41025] text-white px-2 py-0.5 rounded-full inline-block font-semibold capitalize mt-1">
                            {{ Auth::user()->role }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Navigation Menu --}}
            <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
                {{-- Dashboard --}}
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl 
                    {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-[#A41025] to-[#d63347] text-white shadow-lg' : 'text-gray-300 hover:bg-[#3d2020] hover:text-amber-200' }}
                    transition duration-300 group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:scale-110 transition" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9m-9 11l4-4m0 0l4 4m-4-4V3" />
                    </svg>
                    <span class="font-semibold">Dashboard</span>
                </a>

                {{-- Pengguna (Superadmin only) --}}
                @if (Auth::user()->role === 'superadmin')
                    <a href="{{ route('admin.users.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl 
                        {{ request()->routeIs('admin.users.*') ? 'bg-gradient-to-r from-[#A41025] to-[#d63347] text-white shadow-lg' : 'text-gray-300 hover:bg-[#3d2020] hover:text-amber-200' }}
                        transition duration-300 group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:scale-110 transition" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 2a4 4 0 100 8 4 4 0 000-8zM2 18a8 8 0 1116 0H2z" clip-rule="evenodd" />
                        </svg>
                        <span class="font-semibold">Pengguna</span>
                    </a>
                @endif

                {{-- Divider --}}
                @if (Auth::user()->role === 'superadmin' || Auth::user()->role === 'inventory')
                    <div class="my-3 border-t border-[#A41025]/40"></div>

                    {{-- Management Stock Section --}}
                    <p class="px-4 py-2 text-[11px] font-bold text-amber-400 uppercase tracking-widest">📦 Management Stock</p>

                    {{-- Produk --}}
                    <a href="{{ route('admin.products.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl 
                        {{ request()->routeIs('admin.products.*') ? 'bg-gradient-to-r from-[#A41025] to-[#d63347] text-white shadow-lg' : 'text-gray-300 hover:bg-[#3d2020] hover:text-amber-200' }}
                        transition duration-300 group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:scale-110 transition" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m0 0l8-4 8 4m-8 4v10l-8-4m8 4l8-4m-8 4v10m0 0l-8-4m8 4l8-4" />
                        </svg>
                        <span class="font-semibold">Produk</span>
                    </a>

                    {{-- Supplier --}}
                    <a href="{{ route('admin.suppliers.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl 
                        {{ request()->routeIs('admin.suppliers.*') ? 'bg-gradient-to-r from-[#A41025] to-[#d63347] text-white shadow-lg' : 'text-gray-300 hover:bg-[#3d2020] hover:text-amber-200' }}
                        transition duration-300 group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:scale-110 transition" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        <span class="font-semibold">Supplier</span>
                    </a>

                    {{-- Restock --}}
                    <a href="{{ route('admin.restocks.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl 
                        {{ request()->routeIs('admin.restocks.*') ? 'bg-gradient-to-r from-[#A41025] to-[#d63347] text-white shadow-lg' : 'text-gray-300 hover:bg-[#3d2020] hover:text-amber-200' }}
                        transition duration-300 group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:scale-110 transition" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                        </svg>
                        <span class="font-semibold">Restock</span>
                    </a>
                @endif

                {{-- Divider --}}
                @if (Auth::user()->role === 'superadmin' || Auth::user()->role === 'cashier')
                    <div class="my-3 border-t border-[#A41025]/40"></div>

                    {{-- Order Section --}}
                    <p class="px-4 py-2 text-[11px] font-bold text-amber-400 uppercase tracking-widest">💳 Order Management</p>

                    {{-- Orders --}}
                    <a href="{{ route('admin.orders.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl 
                        {{ request()->routeIs('admin.orders.*') ? 'bg-gradient-to-r from-[#A41025] to-[#d63347] text-white shadow-lg' : 'text-gray-300 hover:bg-[#3d2020] hover:text-amber-200' }}
                        transition duration-300 group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:scale-110 transition" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                        </svg>
                        <span class="font-semibold">Pesanan</span>
                    </a>
                @endif
            </nav>

            {{-- Logout Button --}}
            <div class="px-4 py-4 border-t border-[#A41025]/40 bg-black/10">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800
                        text-white font-semibold transition duration-300 transform hover:scale-105 shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>

        {{-- MAIN CONTENT --}}
        <div class="flex-1 overflow-auto flex flex-col">
            {{-- TOP BAR --}}
            <div class="bg-white shadow-md border-b border-gray-200 px-8 py-5 flex justify-between items-center sticky top-0 z-40 backdrop-blur-sm bg-white/95">
                <div>
                    <h2 class="text-3xl font-bold bg-gradient-to-r from-[#1A0C0C] to-[#A41025] bg-clip-text text-transparent">@yield('page-title', 'Dashboard')</h2>
                    <p class="text-sm text-gray-500 mt-1">Kelola dan pantau sistem dengan mudah</p>
                </div>
                <div class="flex items-center gap-6">
                    <div class="text-right">
                        <p class="text-sm font-semibold text-gray-800">{{ date('l, d M Y') }}</p>
                        <p class="text-xs text-gray-500">{{ date('H:i') }}</p>
                    </div>
                </div>
            </div>

            {{-- Content --}}
            <div class="p-8 flex-1 overflow-auto">
                @if ($errors->any())
                    <div class="mb-6 p-4 bg-gradient-to-r from-red-50 to-red-100 border-l-4 border-red-500 text-red-700 rounded-lg shadow-md">
                        <div class="flex items-center gap-3 mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 font-bold" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                            <p class="font-semibold">Terjadi Kesalahan!</p>
                        </div>
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="mb-6 p-4 bg-gradient-to-r from-green-50 to-emerald-100 border-l-4 border-green-500 text-green-700 rounded-lg shadow-md flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <p class="font-semibold">{{ session('success') }}</p>
                    </div>
                @endif

                @yield('content')
            </div>

            {{-- FOOTER --}}
            <footer class="bg-gradient-to-r from-[#1A0C0C] to-[#2d1515] border-t border-[#A41025]/40 text-white px-8 py-6 shadow-lg">
                <div class="max-w-7xl mx-auto">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-6">
                        <div>
                            <h3 class="font-bold text-[#F4A236] mb-2">Toko Utama</h3>
                            <p class="text-sm text-gray-400">Sistem manajemen toko yang modern dan efisien untuk mengelola inventori dan penjualan.</p>
                        </div>
                        <div>
                            <h3 class="font-bold text-[#F4A236] mb-2">Quick Links</h3>
                            <ul class="space-y-1 text-sm text-gray-400">
                                <li><a href="{{ route('admin.dashboard') }}" class="hover:text-amber-300 transition">Dashboard</a></li>
                                <li><a href="{{ route('home') }}" class="hover:text-amber-300 transition">Beranda Toko</a></li>
                            </ul>
                        </div>
                        <div>
                            <h3 class="font-bold text-[#F4A236] mb-2">Dukungan</h3>
                            <p class="text-sm text-gray-400">Butuh bantuan? Hubungi tim support kami.</p>
                        </div>
                    </div>
                    <div class="border-t border-[#A41025]/40 pt-4 flex justify-between items-center text-xs text-gray-400">
                        <div>© {{ date('Y') }} Toko Utama. Semua hak dilindungi.</div>
                        <div class="flex gap-4">
                            <span>v1.0.0</span>
                            <span>Powered by Laravel</span>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</body>

</html>
