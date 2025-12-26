<header class="bg-white shadow-sm h-16 flex items-center justify-between px-6 z-20 flex-shrink-0">
    <div class="flex items-center gap-4">
        <button class="md:hidden text-gray-500 hover:text-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
        <h2 class="text-xl font-bold text-gray-800">Admin Panel</h2>
    </div>

    <div class="flex items-center gap-4">
        <span class="text-sm text-gray-500">Halo, <b>{{ Auth::user()->name ?? 'Admin' }}</b> 👋</span>
    </div>
</header>