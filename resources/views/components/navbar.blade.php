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

            {{-- 2. DESKTOP MENU --}}
            <div class="hidden md:flex space-x-10 items-center">
                <a href="{{ route('home') }}"
                    class="text-amber-200 hover:text-amber-400 font-medium transition {{ request()->routeIs('home') ? 'text-amber-400 font-semibold' : '' }}">
                    Beranda
                </a>

                {{-- Menu Belanja (Muncul untuk Guest atau Customer) --}}
                @if (!Auth::check() || Auth::user()->role === 'customer')
                    <a href="{{ route('catalog') }}"
                        class="text-amber-200 hover:text-amber-400 font-medium transition {{ request()->routeIs('catalog') ? 'text-amber-400 font-semibold' : '' }}">
                        Belanja
                    </a>
                @endif

                {{-- === MENU ACTIVITY (LOGIKA BARU - STYLE AMBER) === --}}
                @auth
                    <a href="{{ url('/my-orders') }}"
                        class="text-amber-200 hover:text-amber-400 font-medium transition {{ request()->is('my-orders*') ? 'text-amber-400 font-semibold' : '' }}">
                        Activity
                    </a>
                @endauth
            </div>

            {{-- 3. DESKTOP RIGHT MENU (Cart & Auth) --}}
            <div class="hidden md:flex items-center gap-6">

                {{-- Icon Favorit (Wishlist) - hanya untuk customer --}}
                @auth
                    @if (Auth::user()->role === 'customer')
                        <button id="favorites-btn" type="button"
                            class="relative text-amber-200 hover:text-amber-400 transition group" title="Favorit">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 group-hover:scale-110 transition"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                            <span id="favorites-count" class="absolute -top-1.5 -right-1.5 bg-rose-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full shadow-sm hidden">0</span>
                        </button>
                    @endif
                @endauth
                
                {{-- Icon Keranjang --}}
                @if (!Auth::check() || Auth::user()->role !== 'master') 
                    @php
                        $cartCount = Auth::check() ? \App\Models\Cart::where('user_id', Auth::id())->sum('qty') : 0;
                    @endphp
                    <a href="{{ route('cart.index') }}"
                        class="relative text-amber-200 hover:text-amber-400 transition group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 group-hover:scale-110 transition"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        @if ($cartCount > 0)
                            <span
                                class="absolute -top-1.5 -right-1.5 bg-rose-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full shadow-sm animate-bounce">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>
                @endif

                

                @auth
                    {{-- Dropdown User --}}
                    <div class="relative group">
                        <button
                            class="font-semibold text-amber-200 hover:text-amber-400 flex items-center gap-2 transition">
                            <span>{{ Auth::user()->name }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-300" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        {{-- Isi Dropdown --}}
                        <div
                            class="absolute right-0 mt-4 w-48 bg-white rounded-xl shadow-xl py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 border border-slate-100 transform translate-y-2 group-hover:translate-y-0">
                            
                            @if (in_array(Auth::user()->role, ['master', 'inventory', 'admin_penjualan']))
                                {{-- Link Dashboard Admin --}}
                                <a href="{{ route('admin.dashboard') }}"
                                    class="block px-5 py-2.5 text-sm text-gray-700 hover:bg-gray-50 font-medium">
                                    Dashboard Staff
                                </a>
                            @endif

                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-5 py-2.5 text-sm text-rose-600 hover:bg-rose-50 font-medium transition">
                                    Keluar Akun
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    {{-- Tombol Login/Register --}}
                    <div class="flex items-center gap-4">
                        <a href="{{ route('login') }}"
                            class="text-sm font-semibold text-amber-200 hover:text-amber-400 transition">Masuk</a>
                        <a href="{{ route('register') }}"
                            class="px-4 py-2 rounded-xl bg-gradient-to-br from-amber-400 to-amber-500 hover:from-amber-500 hover:to-amber-600 text-maroon-900 font-semibold transition shadow-md hover:shadow-lg">Daftar</a>
                    </div>
                @endauth
            </div>

            {{-- 4. MOBILE HAMBURGER BUTTON --}}
            <div class="md:hidden flex items-center gap-4">
                <button id="mobile-menu-btn"
                    class="text-amber-200 hover:text-white focus:outline-none p-1 border border-transparent rounded active:bg-[#3b1d1d] transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- 5. MOBILE MENU (HORIZONTAL SCROLL) --}}
    <div id="mobile-menu"
        class="hidden md:hidden bg-[#241212] border-t border-[#3b1d1d] transition-all duration-300 ease-in-out">

        <div class="flex items-center gap-4 px-6 py-4 overflow-x-auto whitespace-nowrap hide-scrollbar">

            {{-- Link Beranda --}}
            <a href="{{ route('home') }}"
                class="flex items-center gap-2 px-4 py-2 bg-[#1A0C0C] border border-[#3b1d1d] rounded-full text-amber-200 hover:text-white hover:border-amber-400 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Beranda
            </a>

            @if (!Auth::check() || Auth::user()->role === 'customer')
                {{-- Link Belanja --}}
                <a href="{{ route('catalog') }}"
                    class="flex items-center gap-2 px-4 py-2 bg-[#1A0C0C] border border-[#3b1d1d] rounded-full text-amber-200 hover:text-white hover:border-amber-400 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    Belanja
                </a>
            @endif

            {{-- === MENU ACTIVITY MOBILE (FIXED STYLE) === --}}
            @auth
                <a href="{{ url('/my-orders') }}"
                    class="flex items-center gap-2 px-4 py-2 bg-[#1A0C0C] border border-[#3b1d1d] rounded-full text-amber-200 hover:text-white hover:border-amber-400 transition {{ request()->is('my-orders*') ? 'border-amber-400 text-amber-400' : '' }}">
                    {{-- Ikon Clipboard List --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Activity
                </a>
            @endauth


            @if (!Auth::check() || (Auth::check() && Auth::user()->role !== 'superadmin'))
                {{-- Link Keranjang --}}
                @php $cartCountMobile = Auth::check() ? \App\Models\Cart::where('user_id', Auth::id())->sum('qty') : 0; @endphp
                <a href="{{ route('cart.index') }}"
                    class="flex items-center gap-2 px-4 py-2 bg-[#1A0C0C] border border-[#3b1d1d] rounded-full text-amber-200 hover:text-white hover:border-amber-400 transition relative">
                    <span>Keranjang</span>
                    @if ($cartCountMobile > 0)
                        <span
                            class="ml-1 bg-rose-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">{{ $cartCountMobile }}</span>
                    @endif
                </a>

                {{-- Link Favorit Mobile - hanya untuk customer --}}
                @auth
                    @if (Auth::user()->role === 'customer')
                        <button id="favorites-btn-mobile" type="button"
                            class="flex items-center gap-2 px-4 py-2 bg-[#1A0C0C] border border-[#3b1d1d] rounded-full text-amber-200 hover:text-white hover:border-amber-400 transition relative">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                            Favorit
                            <span id="favorites-count-mobile" class="bg-rose-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full hidden">0</span>
                        </button>
                    @endif
                @endauth
            @endif

            @auth
                {{-- Tombol Logout --}}
                <form action="{{ route('logout') }}" method="POST" class="inline-block">
                    @csrf
                    <button type="submit"
                        class="flex items-center gap-2 px-4 py-2 bg-[#1A0C0C] border border-rose-900/50 rounded-full text-rose-400 hover:bg-rose-900/20 hover:text-rose-200 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Logout
                    </button>
                </form>
            @else
                {{-- Tombol Login --}}
                <a href="{{ route('login') }}"
                    class="flex items-center gap-2 px-6 py-2 border border-amber-900 rounded-full text-amber-200 hover:bg-amber-900/50 transition">
                    Masuk
                </a>
                {{-- Tombol Daftar --}}
                <a href="{{ route('register') }}"
                    class="flex items-center gap-2 px-6 py-2 bg-amber-500 rounded-full text-[#1A0C0C] font-bold hover:bg-amber-400 transition">
                    Daftar
                </a>
            @endauth
        </div>
    </div>
</nav>

{{-- CSS & Script --}}
<style>
    .hide-scrollbar::-webkit-scrollbar {
        display: none;
    }

    .hide-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>

{{-- Favorites Modal --}}
<div id="favorites-modal" class="hidden fixed inset-0 bg-black/50 z-[100] flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-96 overflow-hidden flex flex-col">
        {{-- Modal Header --}}
        <div class="bg-[#1A0C0C] px-6 py-4 flex justify-between items-center">
            <h2 class="text-xl font-bold text-amber-400">Produk Favorit Saya</h2>
            <button id="close-favorites-modal" type="button" class="text-amber-200 hover:text-white transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        {{-- Modal Content --}}
        <div id="favorites-list" class="overflow-y-auto flex-1 p-6 space-y-4 bg-[#F8F5F3]">
            <p class="text-center text-[#7c5b58] py-8">Memuat...</p>
        </div>
    </div>
</div>

<script>
    const btn = document.getElementById('mobile-menu-btn');
    const menu = document.getElementById('mobile-menu');

    btn.addEventListener('click', () => {
        menu.classList.toggle('hidden');
    });

    // Favorites modal handler
    const favoritesBtn = document.getElementById('favorites-btn');
    const favoriteBtnMobile = document.getElementById('favorites-btn-mobile');
    const favoritesModal = document.getElementById('favorites-modal');
    const closeFavoritesBtn = document.getElementById('close-favorites-modal');

    function openFavoritesModal() {
        favoritesModal.classList.remove('hidden');
        loadFavorites();
    }

    function closeFavoritesModal() {
        favoritesModal.classList.add('hidden');
    }

    if (favoritesBtn) favoritesBtn.addEventListener('click', openFavoritesModal);
    if (favoriteBtnMobile) favoriteBtnMobile.addEventListener('click', openFavoritesModal);
    if (closeFavoritesBtn) closeFavoritesBtn.addEventListener('click', closeFavoritesModal);

    favoritesModal?.addEventListener('click', function(e) {
        if (e.target === this) closeFavoritesModal();
    });

    function loadFavorites() {
        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        fetch('/favorites/list', {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json'
            }
        })
        .then(r => r.json())
        .then(data => {
            const listContainer = document.getElementById('favorites-list');
            const countElement = document.getElementById('favorites-count');
            const countElementMobile = document.getElementById('favorites-count-mobile');
            
            if (data.success && data.favorites.length > 0) {
                listContainer.innerHTML = data.favorites.map(fav => `
                    <div class="flex items-center justify-between bg-white border border-[#E8D6D0] rounded-lg p-4 hover:shadow-md transition">
                        <div class="flex items-center gap-4 flex-1">
                            <img src="${fav.product.image_main}" alt="${fav.product.name}" class="w-16 h-16 object-contain rounded">
                            <div class="flex-1">
                                <a href="/produk/${fav.product.slug}" class="font-semibold text-[#1A0C0C] hover:text-[#A41025] transition">
                                    ${fav.product.name}
                                </a>
                                <p class="text-[#7c5b58] text-sm">Rp ${Number(fav.product.price).toLocaleString('id-ID')}</p>
                            </div>
                        </div>
                        <button type="button" class="unfavorite-btn ml-4 text-[#A41025] hover:text-[#820c1d] transition" data-wishlist-id="${fav.id}" title="Hapus dari favorit">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M4.318 6.318a4.5 4.5 0 000 6.364L10 16.364l5.682-5.682a4.5 4.5 0 00-6.364-6.364L10 7.636l-.318-.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </button>
                    </div>
                `).join('');
                countElement?.classList.remove('hidden');
                countElement.textContent = data.favorites.length;
                countElementMobile?.classList.remove('hidden');
                countElementMobile.textContent = data.favorites.length;
                
                // Attach unfavorite handlers
                document.querySelectorAll('.unfavorite-btn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        unfavoritProduct(this.dataset.wishlistId);
                    });
                });
            } else {
                listContainer.innerHTML = '<p class="text-center text-[#7c5b58] py-8">Belum ada produk favorit</p>';
                countElement?.classList.add('hidden');
                countElementMobile?.classList.add('hidden');
            }
        })
        .catch(err => {
            console.error(err);
            alert('Gagal memuat favorit');
        });
    }

    function unfavoritProduct(wishlistId) {
        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        fetch(`/favorites/remove/${wishlistId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json'
            }
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                loadFavorites();
            } else {
                alert('Gagal menghapus favorit');
            }
        })
        .catch(err => {
            console.error(err);
            alert('Gagal menghapus favorit');
        });
    }
</script>