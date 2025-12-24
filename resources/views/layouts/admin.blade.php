<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Toko Utama</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">
    <div class="flex min-h-screen">
        {{-- SIDEBAR --}}
        <div class="w-64 bg-[#1A0C0C] text-white shadow-lg flex flex-col">
            {{-- Logo Section --}}
            <div class="px-6 py-6 border-b border-[#A41025]">
                <h1 class="text-xl font-bold text-[#F4A236]">Toko Utama</h1>
                <p class="text-xs text-gray-300 mt-1">Admin Control Panel</p>
            </div>

            {{-- User Info --}}
            <div class="px-6 py-4 border-b border-[#A41025] bg-[#2d1515]">
                <p class="text-sm font-semibold truncate">{{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-400 capitalize">{{ Auth::user()->role }}</p>
            </div>

            {{-- Navigation Menu --}}
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                {{-- Dashboard --}}
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg 
                    {{ request()->routeIs('admin.dashboard') ? 'bg-[#A41025] text-white' : 'text-gray-300 hover:bg-[#2d1515]' }}
                    transition duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9m-9 11l4-4m0 0l4 4m-4-4V3" />
                    </svg>
                    <span class="font-medium">Dashboard</span>
                </a>

                {{-- Divider --}}
                @if (Auth::user()->role === 'superadmin' || Auth::user()->role === 'inventory')
                    <div class="my-2 border-t border-[#A41025] opacity-30"></div>

                    {{-- Management Stock Section --}}
                    <p class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase">Management Stock</p>

                    {{-- Produk --}}
                    <a href="{{ route('admin.products.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg 
                        {{ request()->routeIs('admin.products.*') ? 'bg-[#A41025] text-white' : 'text-gray-300 hover:bg-[#2d1515]' }}
                        transition duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m0 0l8-4 8 4m-8 4v10l-8-4m8 4l8-4m-8 4v10m0 0l-8-4m8 4l8-4" />
                        </svg>
                        <span class="font-medium">Produk</span>
                    </a>

                    {{-- Supplier --}}
                    <a href="{{ route('admin.suppliers.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg 
                        {{ request()->routeIs('admin.suppliers.*') ? 'bg-[#A41025] text-white' : 'text-gray-300 hover:bg-[#2d1515]' }}
                        transition duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        <span class="font-medium">Supplier</span>
                    </a>

                    {{-- Restock --}}
                    <a href="{{ route('admin.restocks.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg 
                        {{ request()->routeIs('admin.restocks.*') ? 'bg-[#A41025] text-white' : 'text-gray-300 hover:bg-[#2d1515]' }}
                        transition duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                        </svg>
                        <span class="font-medium">Restock</span>
                    </a>
                @endif

                {{-- Divider --}}
                @if (Auth::user()->role === 'superadmin' || Auth::user()->role === 'cashier')
                    <div class="my-2 border-t border-[#A41025] opacity-30"></div>

                    {{-- Order Section --}}
                    <p class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase">Order Management</p>

                    {{-- Orders --}}
                    <a href="{{ route('admin.orders.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg 
                        {{ request()->routeIs('admin.orders.*') ? 'bg-[#A41025] text-white' : 'text-gray-300 hover:bg-[#2d1515]' }}
                        transition duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                        </svg>
                        <span class="font-medium">Pesanan</span>
                    </a>
                @endif
            </nav>

            {{-- Logout Button --}}
            <div class="px-4 py-4 border-t border-[#A41025]">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center gap-3 px-4 py-3 rounded-lg bg-red-600 hover:bg-red-700
                        text-white font-medium transition duration-200">
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
            {{-- Top Bar --}}
            <div class="bg-white shadow-sm border-b border-gray-200 px-8 py-4 flex justify-between items-center">
                <h2 class="text-2xl font-bold text-[#1A0C0C]">@yield('page-title', 'Dashboard')</h2>
                <div class="flex items-center gap-4">
                    <span class="text-sm text-gray-600">{{ date('d M Y') }}</span>
                </div>
            </div>

            {{-- Content --}}
            <div class="p-8 flex-1">
                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                @yield('content')
            </div>

            {{-- FOOTER --}}
            <footer class="bg-white border-t border-gray-200 p-4 text-sm text-gray-600">
                <div class="container mx-auto px-4 flex justify-between items-center">
                    <div>© {{ date('Y') }} Toko Utama. All rights reserved.</div>
                    <div class="text-right text-xs text-gray-500">Designed with care · Clean admin UI</div>
                </div>
            </footer>
        </div>
    </div>
</body>

</html>
