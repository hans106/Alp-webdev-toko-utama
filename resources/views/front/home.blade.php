@extends('layouts.main')

@section('content')

    {{-- BAGIAN 1: HERO SECTION --}}
    <section class="relative h-[600px] flex items-center justify-center overflow-hidden mb-16">

        <div class="absolute inset-0">
            <img src="{{ asset('lokasi/Utama_bagian_depan.jpg') }}" alt="Background Toko" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-neutral-900/60"></div>
        </div>

        <div class="relative z-10 container mx-auto px-6 text-center text-white">
            <h1 class="text-5xl md:text-7xl font-extrabold mb-6 tracking-tight drop-shadow-lg leading-tight">
                Toko Utama
            </h1>
            <a href="{{ route('catalog') }}"
                class="inline-block text-white font-semibold py-4 px-12 rounded-xl bg-[#1A1A1A] border border-[#A889FF] shadow-[0_0_10px_rgba(150,120,255,0.35)] hover:shadow-[0_0_16px_rgba(150,120,255,0.55)] transition-all duration-300">
                Buy the Products Now
            </a>
        </div>

    </section>

    {{-- BAGIAN 2: CUPLIKAN SEJARAH --}}
    <section class="container mx-auto px-6 lg:px-12 mb-24">

        <div class="flex flex-col md:flex-row items-center gap-12 bg-white rounded-3xl p-8 md:p-12 shadow-xl shadow-rose-200/40 border border-rose-100">
            <div class="w-full md:w-1/2 h-64 md:h-96 rounded-2xl overflow-hidden relative group">
                <img src="{{ asset('lokasi/Utama_bagian_dalam.jpg') }}"
                    class="w-full h-full object-cover group-hover:scale-105 transition duration-500" alt="Sejarah Toko">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex items-end p-6">
                    <span class="text-white font-bold text-lg">Sejak 1959</span>
                </div>
            </div>

            <div class="w-full md:w-1/2">
                <span class="text-rose-700 font-bold tracking-wider uppercase text-sm bg-rose-100 px-3 py-1 rounded-full">
                    About Us
                </span>
                
                <h2 class="text-3xl font-bold text-slate-900 mt-4 mb-6">History of Utama Shop</h2>
                
                <p class="text-slate-600 text-lg leading-relaxed mb-6">
                    Usaha keluarga ini mulai berdiri pada tahun 1959 di Karanganyar. Berawal dari usaha kecil yang menampung hasil bumi petani, kini berkembang menjadi pusat perbelanjaan modern yang tetap menjaga nilai kekeluargaan.
                </p>

                <a href="{{ route('about') }}" 
                   class="text-rose-700 font-bold hover:text-rose-900 flex items-center gap-2 group text-lg">
                    Baca Sejarah Lengkap
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:translate-x-1 transition"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>
        </div>
    </section>

    {{-- BAGIAN 3: VISI & MISI --}}
    <section class="container mx-auto px-6 lg:px-12 mb-24">
        {{-- Layout: Grid 1 kolom di HP, 2 kolom di Desktop --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8">
            
            {{-- Card Visi --}}
            <div class="bg-rose-700 rounded-3xl p-6 md:p-10 text-white shadow-xl shadow-rose-200/40 relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-24 h-24 md:w-32 md:h-32 bg-white opacity-10 rounded-full blur-2xl transform translate-x-10 -translate-y-10 group-hover:scale-150 transition duration-700"></div>
                <div class="relative z-10">
                    <div class="w-12 h-12 md:w-14 md:h-14 bg-white/20 rounded-xl flex items-center justify-center mb-4 md:mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 md:w-8 md:h-8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h2 class="text-2xl md:text-3xl font-bold mb-2 md:mb-4">Visi</h2>
                    <p class="text-rose-100 text-base md:text-lg leading-relaxed">
                        "Menjadi mitra terpercaya dalam memenuhi kebutuhan sehari-hari masyarakat."
                    </p>
                </div>
            </div>

            {{-- Card Misi --}}
            <div class="bg-white rounded-3xl p-6 md:p-10 border border-rose-100 shadow-xl shadow-rose-100/40 relative overflow-hidden group">
                <div class="absolute bottom-0 left-0 w-24 h-24 md:w-32 md:h-32 bg-rose-200 opacity-10 rounded-full blur-2xl transform -translate-x-10 translate-y-10 group-hover:scale-150 transition duration-700"></div>
                <div class="relative z-10">
                    <div class="w-12 h-12 md:w-14 md:h-14 bg-rose-100 text-rose-700 rounded-xl flex items-center justify-center mb-4 md:mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 md:w-8 md:h-8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.59 14.37a6 6 0 01-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 006.16-12.12A14.98 14.98 0 009.631 8.41m5.96 5.96a14.926 14.926 0 01-5.841 2.58m-.119-8.54a6 6 0 00-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 00-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 01-2.448-2.448 14.9 14.9 0 01.06-.312m-2.24 2.39a4.493 4.493 0 00-1.757 4.306 4.493 4.493 0 004.306-1.758M16.5 9a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                        </svg>
                    </div>
                    <h2 class="text-2xl md:text-3xl font-bold text-slate-900 mb-2 md:mb-4">Misi</h2>
                    <ul class="space-y-3 md:space-y-4">
                        <li class="flex items-start gap-3">
                            <span class="bg-green-100 text-green-600 rounded-full p-1 mt-1 shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </span>
                            <span class="text-slate-600 text-sm md:text-lg">Menyediakan produk berkualitas tinggi.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="bg-green-100 text-green-600 rounded-full p-1 mt-1 shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </span>
                            <span class="text-slate-600 text-sm md:text-lg">Memberikan harga yang kompetitif & miring.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="bg-green-100 text-green-600 rounded-full p-1 mt-1 shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </span>
                            <span class="text-slate-600 text-sm md:text-lg">Mengutamakan pelayanan maksimal.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    {{-- BAGIAN 4: KEUNGGULAN (DESKTOP: CARD CENTER, MOBILE: LIST KIRI-KANAN) --}}
    <section class="container mx-auto px-6 lg:px-12 mb-16 md:mb-24">
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 md:gap-8">

            {{-- Card 1 --}}
            {{-- 
               LOGIKANYA:
               - Flex Row (flex) untuk HP biar icon dikiri, teks dikanan.
               - MD:Block (md:block) untuk Desktop biar balik jadi kotak atas-bawah.
            --}}
            <div class="bg-white p-5 md:p-8 rounded-3xl shadow-lg shadow-rose-100/40 hover:shadow-xl hover:shadow-rose-400/20 transition border border-rose-100 group flex items-center md:block gap-5">
                
                {{-- Icon Container --}}
                {{-- HP: shrink-0 (biar gk gepeng). Desktop: mx-auto, mb-6 (tengah) --}}
                <div class="w-14 h-14 md:w-16 md:h-16 bg-rose-100 text-rose-600 rounded-2xl flex shrink-0 items-center justify-center md:mx-auto md:mb-6 group-hover:scale-110 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 md:w-10 md:h-10">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                    </svg>
                </div>

                {{-- Text Container --}}
                {{-- HP: Text-left. Desktop: Text-center --}}
                <div class="text-left md:text-center">
                    <h3 class="text-lg md:text-xl font-bold text-slate-900 mb-1 md:mb-3">Pelayanan Kekeluargaan</h3>
                    <p class="text-sm md:text-base text-slate-600 leading-snug md:leading-relaxed">
                        Dikenal pelayanannya yang baik dan ramah kepada setiap pelanggan.
                    </p>
                </div>
            </div>

            {{-- Card 2 --}}
            <div class="bg-white p-5 md:p-8 rounded-3xl shadow-lg shadow-emerald-100/40 hover:shadow-xl hover:shadow-emerald-500/20 transition border border-emerald-100 group flex items-center md:block gap-5">
                <div class="w-14 h-14 md:w-16 md:h-16 bg-emerald-100 text-emerald-600 rounded-2xl flex shrink-0 items-center justify-center md:mx-auto md:mb-6 group-hover:scale-110 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 md:w-10 md:h-10">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                    </svg>
                </div>
                <div class="text-left md:text-center">
                    <h3 class="text-lg md:text-xl font-bold text-slate-900 mb-1 md:mb-3">Harga Lebih Miring</h3>
                    <p class="text-sm md:text-base text-slate-600 leading-snug md:leading-relaxed">
                        Dikenal sebagai toko yang menjual barang dengan harga sangat bersaing.
                    </p>
                </div>
            </div>

            {{-- Card 3 --}}
            <div class="bg-white p-5 md:p-8 rounded-3xl shadow-lg shadow-amber-100/40 hover:shadow-xl hover:shadow-amber-500/20 transition border border-amber-100 group flex items-center md:block gap-5">
                <div class="w-14 h-14 md:w-16 md:h-16 bg-amber-100 text-amber-600 rounded-2xl flex shrink-0 items-center justify-center md:mx-auto md:mb-6 group-hover:scale-110 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 md:w-10 md:h-10">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                    </svg>
                </div>
                <div class="text-left md:text-center">
                    <h3 class="text-lg md:text-xl font-bold text-slate-900 mb-1 md:mb-3">Kualitas Terjamin</h3>
                    <p class="text-sm md:text-base text-slate-600 leading-snug md:leading-relaxed">
                        Rata-rata produk yang dijual memiliki kualitas baik dan terpercaya.
                    </p>
                </div>
            </div>

        </div>
    </section>

@endsection