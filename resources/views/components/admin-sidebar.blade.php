<aside class="w-64 bg-[#1a1c23] text-white flex-shrink-0 hidden md:flex flex-col border-r border-gray-800">

    {{-- 1. LOGO --}}
    <div class="p-4 flex items-center gap-3 border-b border-gray-800 h-16 flex-shrink-0">
        <div class="w-8 h-8 bg-orange-500 rounded-lg flex items-center justify-center font-bold text-white text-lg shadow-lg">
            <img src="{{ asset('logo/logo_utama.jpeg') }}" alt="Logo" class="w-full h-full object-cover">
        </div>
        <div>
            <h1 class="font-bold text-base tracking-wide">Toko Utama</h1>
            <p class="text-[10px] text-gray-400 leading-tight">Admin Panel</p>
        </div>
    </div>

    {{-- MENU NAVIGASI --}}
    <nav class="flex-1 overflow-y-auto py-3 px-3 space-y-0.5 text-sm custom-scrollbar">

        {{-- Dashboard --}}
        <a href="{{ route('admin.dashboard') }}"
            class="flex items-center px-3 py-2 text-gray-300 hover:bg-gray-800 hover:text-white rounded-lg transition-colors group {{ request()->routeIs('admin.dashboard') ? 'bg-orange-500 text-white shadow-md' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
            </svg>
            <span class="font-medium">Dashboard</span>
        </a>

                {{-- Group: ADMIN --}}
        <div class="pt-3 pb-1 px-3 text-[10px] font-bold text-gray-500 uppercase tracking-wider">Super Admin</div>

        <a href="{{ route('admin.users.index') }}"
            class="flex items-center px-3 py-2 text-gray-300 hover:bg-gray-800 hover:text-white rounded-lg transition-colors {{ request()->routeIs('admin.users.*') ? 'bg-orange-500 text-white shadow-md' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            User
        </a>
        
        {{-- MENU PEGAWAI (SUDAH DIPERBAIKI) --}}
        <a href="{{ route('admin.employees.index') }}"
            class="flex items-center px-3 py-2 text-gray-300 hover:bg-gray-800 hover:text-white rounded-lg transition-colors group {{ request()->routeIs('admin.employees.*') ? 'bg-orange-500 text-white shadow-md' : '' }}">
            
            {{-- Icon Dasi / ID Card --}}
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0c0 .884-.956 2.99-3 3.5M13 14h.01M10 14h.01M7 14h.01" />
            </svg>
            <span class="font-medium">Pegawai</span>
        </a>

        <a href="{{ route('admin.events.index') }}"
            class="flex items-center px-3 py-2 text-gray-300 hover:bg-gray-800 hover:text-white rounded-lg transition-colors group {{ request()->routeIs('admin.events.*') ? 'bg-orange-500 text-white shadow-md' : '' }}">
            {{-- Icon Kalender --}}
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <span class="font-medium">Events</span>
        </a>

        {{-- Group: INVENTORY --}}
        <div class="pt-3 pb-1 px-3 text-[10px] font-bold text-gray-500 uppercase tracking-wider">Inventory</div>

        <a href="{{ route('admin.products.index') }}"
            class="flex items-center px-3 py-2 text-gray-300 hover:bg-gray-800 hover:text-white rounded-lg transition-colors {{ request()->routeIs('admin.products.*') ? 'bg-gray-800 text-white' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
            </svg>
            Kelola Produk
        </a>

        <a href="{{ route('admin.suppliers.index') }}"
            class="flex items-center px-3 py-2 text-gray-300 hover:bg-gray-800 hover:text-white rounded-lg transition-colors {{ request()->routeIs('admin.suppliers.*') ? 'bg-gray-800 text-white' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5" />
            </svg>
            Data Supplier
        </a>

        <a href="{{ route('admin.restocks.index') }}"
            class="flex items-center px-3 py-2 text-gray-300 hover:bg-gray-800 hover:text-white rounded-lg transition-colors {{ request()->routeIs('admin.restocks.*') ? 'bg-orange-500 text-white shadow-md' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
            </svg>
            Restock Barang
        </a>





        {{-- Group: TRANSAKSI --}}
        <div class="pt-3 pb-1 px-3 text-[10px] font-bold text-gray-500 uppercase tracking-wider">Admin Penjualan</div>

        <a href="{{ route('admin.orders.index') }}"
            class="flex items-center px-3 py-2 text-gray-300 hover:bg-gray-800 hover:text-white rounded-lg transition-colors {{ request()->routeIs('admin.orders.*') ? 'bg-orange-500 text-white shadow-md' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
            </svg>
            Pesanan Masuk
        </a>
        <a href="{{ route('admin.restock-verifications.index') }}"
            class="flex items-center px-3 py-2 text-gray-300 hover:bg-gray-800 hover:text-white rounded-lg transition-colors {{ request()->routeIs('admin.restock-verifications.*') ? 'bg-orange-500 text-white shadow-md' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
            </svg>
            Checklist Nota
        </a>


    </nav>

    {{-- FOOTER SIDEBAR --}}
    <div class="p-3 border-t border-gray-800 bg-[#1a1c23] flex-shrink-0">
        <div class="flex items-center gap-3 mb-2">
            <div class="w-8 h-8 rounded-full bg-gray-700 flex items-center justify-center text-xs font-bold">
                {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
            </div>
            <div class="overflow-hidden">
                <p class="text-sm font-bold text-white truncate">{{ Auth::user()->name ?? 'User' }}</p>
                <p class="text-[10px] text-gray-500 capitalize">{{ Auth::user()->role ?? 'Staff' }}</p>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="w-full flex items-center justify-center gap-2 px-3 py-1.5 text-[10px] font-bold text-red-400 bg-red-400/10 hover:bg-red-400/20 rounded-lg transition-colors uppercase tracking-wider">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                Logout
            </button>
        </form>
    </div>
</aside>