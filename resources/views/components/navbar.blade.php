<nav class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-6 lg:px-12 py-5 flex justify-between items-center">
        
        <a href="{{ route('home') }}" class="text-2xl font-extrabold text-primary tracking-tight">
            Toko<span class="text-slate-900">Utama</span><span class="text-secondary">.</span>
        </a>

        <div class="hidden md:flex space-x-10">
            <a href="{{ route('home') }}" class="text-slate-500 hover:text-primary font-semibold transition {{ request()->routeIs('home') ? 'text-primary' : '' }}">
                Beranda
            </a>
            <a href="{{ route('catalog') }}" class="text-slate-500 hover:text-primary font-semibold transition {{ request()->routeIs('catalog') ? 'text-primary' : '' }}">
                Belanja
            </a>
            @auth
                @if(Auth::user()->role === 'admin')
                <a href="{{ route('admin.products.index') }}" class="text-rose-500 hover:text-rose-700 font-bold transition flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z" /><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" /></svg>
                    Area Admin
                </a>
                @endif
            @endauth
        </div>

        <div class="flex items-center gap-6">
            <a href="#" class="relative text-slate-500 hover:text-primary transition group">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 group-hover:scale-110 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
                <span class="absolute -top-1.5 -right-1.5 bg-rose-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full shadow-sm">0</span>
            </a>

            @auth
                <div class="relative group">
                    <button class="font-bold text-slate-700 hover:text-primary flex items-center gap-2 transition">
                        <span>{{ Auth::user()->name }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <div class="absolute right-0 mt-4 w-48 bg-white rounded-xl shadow-xl py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 border border-slate-100 transform translate-y-2 group-hover:translate-y-0">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full text-left px-5 py-2.5 text-sm text-rose-600 hover:bg-rose-50 font-medium transition">Keluar Akun</button>
                        </form>
                    </div>
                </div>
            @else
                <div class="flex items-center gap-4">
                    <a href="{{ route('login') }}" class="text-sm font-bold text-slate-600 hover:text-primary transition">Masuk</a>
                    <a href="{{ route('register') }}" class="bg-gradient-to-r from-primary to-indigo-600 text-white px-6 py-2.5 rounded-full text-sm font-bold hover:shadow-lg hover:shadow-indigo-500/30 transition transform hover:-translate-y-0.5">
                        Daftar
                    </a>
                </div>
            @endauth
        </div>
    </div>
</nav>