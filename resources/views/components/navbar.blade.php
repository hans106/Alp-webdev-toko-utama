<nav x-data="{ open: false }" class="bg-[#1A0C0C] text-[#F7D9B5] sticky top-0 z-50 shadow-lg border-b border-[#3b1d1d]">
    <div class="max-w-7xl mx-auto px-6 lg:px-12 py-5">
        <div class="flex justify-between items-center">

            {{-- 1. LOGO --}}
            <a href="{{ route('home') }}" class="flex items-center gap-3 group z-50 relative">
                <img src="{{ asset('logo/Logo_Utama.jpeg') }}" alt="Logo"
                    class="h-10 w-auto object-contain rounded-lg group-hover:scale-105 transition duration-300 shadow-sm">
                <span class="text-xl md:text-2xl font-extrabold text-amber-400 leading-none">
                    Toko<span class="text-white">Utama</span>
                </span>
            </a>

            {{-- 2. DESKTOP MENU (Hidden di Mobile) --}}
            <div class="hidden md:flex space-x-10 items-center">
                <a href="{{ route('home') }}"
                    class="text-amber-200 hover:text-amber-400 font-medium transition {{ request()->routeIs('home') ? 'text-amber-400 font-semibold' : '' }}">
                    Beranda
                </a>

                @if(!Auth::check() || Auth::user()->role === 'customer')
                    <a href="{{ route('catalog') }}"
                        class="text-amber-200 hover:text-amber-400 font-medium transition {{ request()->routeIs('catalog') ? 'text-amber-400 font-semibold' : '' }}">
                        Belanja
                    </a>
                @endif

                @auth
                    @if (Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}"
                            class="text-rose-300 hover:text-rose-100 font-bold transition flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                            </svg>
                            Area Admin
                        </a>
                    @endif
                @endauth
            </div>

            {{-- 3. DESKTOP RIGHT MENU (Cart & Auth) --}}
            <div class="hidden md:flex items-center gap-6">
                @if(!Auth::check() || Auth::user()->role !== 'admin')
                    @php
                        $cartCount = Auth::check() ? \App\Models\Cart::where('user_id', Auth::id())->sum('qty') : 0;
                    @endphp
                    <a href="{{ route('cart.index') }}" class="relative text-amber-200 hover:text-amber-400 transition group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 group-hover:scale-110 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        @if ($cartCount > 0)
                            <span class="absolute -top-1.5 -right-1.5 bg-rose-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full shadow-sm animate-bounce">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>
                @endif

                @auth
                    <div class="relative group">
                        <button class="font-semibold text-amber-200 hover:text-amber-400 flex items-center gap-2 transition">
                            <span>{{ Auth::user()->name }}</span>
                            @if(Auth::user()->role === 'admin')
                                <span class="bg-rose-600 text-white text-[10px] px-1.5 py-0.5 rounded uppercase tracking-wider">Admin</span>
                            @endif
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="absolute right-0 mt-4 w-48 bg-white rounded-xl shadow-xl py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 border border-slate-100 transform translate-y-2 group-hover:translate-y-0">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-left px-5 py-2.5 text-sm text-rose-600 hover:bg-rose-50 font-medium transition">
                                    Keluar Akun
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="flex items-center gap-4">
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-amber-200 hover:text-amber-400 transition">Masuk</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 rounded-xl bg-gradient-to-br from-amber-400 to-amber-500 hover:from-amber-500 hover:to-amber-600 text-maroon-900 font-semibold transition shadow-md hover:shadow-lg">Daftar</a>
                    </div>
                @endauth
            </div>

            {{-- 4. MOBILE HAMBURGER BUTTON --}}
            <div class="md:hidden flex items-center gap-4">
                <button id="mobile-menu-btn" class="text-amber-200 hover:text-white focus:outline-none p-1 border border-transparent rounded active:bg-[#3b1d1d] transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- 5. MOBILE MENU (HORIZONTAL SCROLL) --}}
    {{-- Ini bagian 'Horizontal' yang Abang minta --}}
    <div id="mobile-menu" class="hidden md:hidden bg-[#241212] border-t border-[#3b1d1d] transition-all duration-300 ease-in-out">
        
        {{-- Container Flex Row + Overflow-X-Auto biar bisa digeser ke samping --}}
        <div class="flex items-center gap-4 px-6 py-4 overflow-x-auto whitespace-nowrap hide-scrollbar">
            
            {{-- Link Beranda --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2 px-4 py-2 bg-[#1A0C0C] border border-[#3b1d1d] rounded-full text-amber-200 hover:text-white hover:border-amber-400 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                Beranda
            </a>
            
            @if(!Auth::check() || Auth::user()->role === 'customer')
                {{-- Link Belanja --}}
                <a href="{{ route('catalog') }}" class="flex items-center gap-2 px-4 py-2 bg-[#1A0C0C] border border-[#3b1d1d] rounded-full text-amber-200 hover:text-white hover:border-amber-400 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                    Belanja
                </a>
            @endif

            @if(!Auth::check() || (Auth::check() && Auth::user()->role !== 'admin'))
                {{-- Link Keranjang --}}
                @php $cartCountMobile = Auth::check() ? \App\Models\Cart::where('user_id', Auth::id())->sum('qty') : 0; @endphp
                <a href="{{ route('cart.index') }}" class="flex items-center gap-2 px-4 py-2 bg-[#1A0C0C] border border-[#3b1d1d] rounded-full text-amber-200 hover:text-white hover:border-amber-400 transition relative">
                    <span>Keranjang</span>
                    @if ($cartCountMobile > 0)
                        <span class="ml-1 bg-rose-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">{{ $cartCountMobile }}</span>
                    @endif
                </a>
            @endif

            @auth
                @if (Auth::user()->role === 'admin')
                    {{-- Link Admin --}}
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-4 py-2 bg-rose-900/20 border border-rose-800/50 rounded-full text-rose-300 hover:text-rose-100 hover:border-rose-500 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z" /><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" /></svg>
                        Area Admin
                    </a>
                @endif
                
                {{-- Tombol Logout --}}
                <form action="{{ route('logout') }}" method="POST" class="inline-block">
                    @csrf
                    <button type="submit" class="flex items-center gap-2 px-4 py-2 bg-[#1A0C0C] border border-rose-900/50 rounded-full text-rose-400 hover:bg-rose-900/20 hover:text-rose-200 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                        Logout
                    </button>
                </form>
            @else
                {{-- Tombol Login --}}
                <a href="{{ route('login') }}" class="flex items-center gap-2 px-6 py-2 border border-amber-900 rounded-full text-amber-200 hover:bg-amber-900/50 transition">
                    Masuk
                </a>
                {{-- Tombol Daftar --}}
                <a href="{{ route('register') }}" class="flex items-center gap-2 px-6 py-2 bg-amber-500 rounded-full text-[#1A0C0C] font-bold hover:bg-amber-400 transition">
                    Daftar
                </a>
            @endauth
        </div>
    </div>
</nav>

{{-- CSS Tambahan untuk menyembunyikan scrollbar tapi tetap bisa di-scroll --}}
<style>
    .hide-scrollbar::-webkit-scrollbar {
        display: none;
    }
    .hide-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>

<script>
    const btn = document.getElementById('mobile-menu-btn');
    const menu = document.getElementById('mobile-menu');

    btn.addEventListener('click', () => {
        menu.classList.toggle('hidden');
    });
</script>