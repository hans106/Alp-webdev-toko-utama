<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('page-title') - Admin Toko Utama</title>
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- Font & Icons --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        /* Custom Scrollbar biar rapi */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="bg-gray-100 font-sans antialiased">

    {{-- WRAPPER UTAMA --}}
    <div class="flex h-screen overflow-hidden">

        {{-- SIDEBAR KIRI --}}
        <aside class="w-64 bg-[#1a1c23] text-white flex-shrink-0 hidden md:flex flex-col border-r border-gray-800">
            
            {{-- LOGO --}}
            <div class="p-6 flex items-center gap-3 border-b border-gray-800">
                <div class="w-10 h-10 bg-orange-500 rounded-lg flex items-center justify-center font-bold text-white text-xl shadow-lg">
                    TU
                </div>
                <div>
                    <h1 class="font-bold text-lg tracking-wide">Toko Utama</h1>
                    <p class="text-xs text-gray-400">Admin Panel System</p>
                </div>
            </div>

            {{-- MENU NAVIGASI --}}
            <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
                
                {{-- Dashboard (FIX: admin.dashboard) --}}
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-800 hover:text-white rounded-lg transition-colors group {{ request()->routeIs('admin.dashboard') ? 'bg-orange-500 text-white shadow-md' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                    <span class="font-medium">Dashboard</span>
                </a>

                {{-- Group: INVENTORY --}}
                <div class="pt-4 pb-2 px-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Inventory & Gudang</div>
                
                {{-- Kelola Produk (FIX: admin.products.index) --}}
                <a href="{{ route('admin.products.index') }}" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-800 hover:text-white rounded-lg transition-colors {{ request()->routeIs('admin.products.*') ? 'bg-gray-800 text-white' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    Kelola Produk
                </a>

                {{-- Data Supplier (FIX: admin.suppliers.index) --}}
                <a href="{{ route('admin.suppliers.index') }}" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-800 hover:text-white rounded-lg transition-colors {{ request()->routeIs('admin.suppliers.*') ? 'bg-gray-800 text-white' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5" />
                    </svg>
                    Data Supplier
                </a>

                {{-- Restock Barang (FIX: admin.restocks.index) --}}
                <a href="{{ route('admin.restocks.index') }}" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-800 hover:text-white rounded-lg transition-colors {{ request()->routeIs('admin.restocks.*') ? 'bg-orange-500 text-white shadow-md' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                    </svg>
                    Restock Barang
                </a>

                {{-- Group: TRANSAKSI --}}
                <div class="pt-4 pb-2 px-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Kasir & Transaksi</div>

                {{-- Pesanan Masuk (FIX: admin.orders.index) --}}
                <a href="{{ route('admin.orders.index') }}" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-800 hover:text-white rounded-lg transition-colors {{ request()->routeIs('admin.orders.*') ? 'bg-orange-500 text-white shadow-md' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    Pesanan Masuk
                </a>

                <div class="pt-4 pb-2 px-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Super Admin</div>

                {{-- Kelola User --}}
                <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-800 hover:text-white rounded-lg transition-colors {{ request()->routeIs('admin.users.*') ? 'bg-orange-500 text-white shadow-md' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    User
                </a>
                
            </nav>

            {{-- FOOTER SIDEBAR --}}
            <div class="p-4 border-t border-gray-800 bg-[#1a1c23]">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-full bg-gray-700 flex items-center justify-center text-sm font-bold">
                        {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                    </div>
                    <div class="overflow-hidden">
                        <p class="text-sm font-bold text-white truncate">{{ Auth::user()->name ?? 'User' }}</p>
                        <p class="text-xs text-gray-500 capitalize">{{ Auth::user()->role ?? 'Staff' }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2 text-xs font-bold text-red-400 bg-red-400/10 hover:bg-red-400/20 rounded-lg transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        {{-- AREA KANAN --}}
        <div class="flex-1 flex flex-col h-screen overflow-hidden relative">
            
            {{-- HEADER ATAS --}}
            <header class="bg-white shadow-sm h-16 flex items-center justify-between px-6 z-20 flex-shrink-0">
                 <div class="flex items-center gap-4">
                     <button class="md:hidden text-gray-500 hover:text-gray-700">
                         <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                         </svg>
                     </button>
                     <h2 class="text-xl font-bold text-gray-800">@yield('page-title', 'Dashboard')</h2>
                 </div>

                 <div class="flex items-center gap-4">
                     <span class="text-sm text-gray-500">Halo, <b>{{ Auth::user()->name ?? 'Admin' }}</b> 👋</span>
                 </div>
            </header>

            {{-- KONTEN UTAMA --}}
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 flex flex-col justify-between">
                <div class="flex-1 p-6">
                    @yield('content')
                </div>
                <footer class="py-6 text-center text-sm text-gray-400 border-t border-gray-200 bg-gray-100">
                    &copy; {{ date('Y') }} Toko Utama POS System. All rights reserved.
                </footer>
            </main>

        </div>
    </div>

</body>
</html>