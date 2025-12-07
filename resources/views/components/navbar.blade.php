<nav class="bg-white shadow-sm sticky top-0 z-50 border-b border-gray-100">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
        <a href="{{ route('home') }}" class="text-2xl font-bold text-blue-600 hover:text-blue-700 transition">
            Toko<span class="text-gray-900">Utama</span>
        </a>

        <div class="hidden md:flex space-x-8">
            <a href="{{ route('home') }}" class="text-gray-600 hover:text-blue-600 font-medium transition {{ request()->routeIs('home') ? 'text-blue-600' : '' }}">
                Beranda
            </a>
            <a href="{{ route('catalog') }}" class="text-gray-600 hover:text-blue-600 font-medium transition {{ request()->routeIs('catalog') ? 'text-blue-600' : '' }}">
                Belanja
            </a>
            <a href="{{ route('admin.products.index') }}" class="text-gray-500 hover:text-red-600 font-medium transition">
                Area Admin
            </a>
        </div>

        <div class="flex items-center space-x-4">
            <a href="#" class="relative text-gray-600 hover:text-blue-600 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <span class="absolute -top-2 -right-2 bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">0</span>
            </a>
            
            <div class="h-6 w-px bg-gray-300 mx-2"></div>

            <a href="#" class="text-sm font-semibold text-gray-700 hover:text-blue-600">Masuk</a>
        </div>
    </div>
</nav>
