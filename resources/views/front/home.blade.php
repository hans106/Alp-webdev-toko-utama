@extends('layouts.main')

@section('content')

    {{-- BAGIAN 1: HERO SECTION (BANNER ATAS) --}}
    <section class="relative h-[600px] flex items-center justify-center overflow-hidden mb-16">

        <div class="absolute inset-0">
            <img src="{{ asset('lokasi/Utama_bagian_depan.jpg') }}" alt="Background Toko" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-neutral-900/60"></div>
        </div>

        <div class="relative z-10 container mx-auto px-6 text-center text-white">
            <h1 class="text-5xl md:text-7xl font-extrabold mb-6 tracking-tight drop-shadow-lg">
                Toko Utama
            </h1>
            <a href="{{ route('catalog') }}"
                class="inline-block text-white font-semibold py-4 px-12 rounded-xl bg-[#1A1A1A] border border-[#A889FF] shadow-[0_0_10px_rgba(150,120,255,0.35)] hover:shadow-[0_0_16px_rgba(150,120,255,0.55)] transition-all duration-300">
                Buy the Products Now
            </a>
        </div>

    </section>

    {{-- BAGIAN 2: CUPLIKAN SEJARAH (TEASER) --}}
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
                {{-- Badge About Us (Maroon) --}}
                <span class="text-rose-700 font-bold tracking-wider uppercase text-sm bg-rose-100 px-3 py-1 rounded-full">
                    About Us
                </span>
                
                <h2 class="text-3xl font-bold text-slate-900 mt-4 mb-6">History of Utama Shop</h2>
                
                <p class="text-slate-600 text-lg leading-relaxed mb-6">
                    Usaha keluarga ini mulai berdiri pada tahun 1959 di Karanganyar. Berawal dari usaha kecil yang menampung hasil bumi petani...
                </p>

                {{-- TOMBOL BACA SELENGKAPNYA (PINDAH HALAMAN) --}}
                <a href="{{ route('about') }}" 
                   class="text-rose-700 font-bold hover:text-rose-900 flex items-center gap-2 group text-lg">
                    
                    Baca Sejarah Lengkap
                    
                    {{-- Ikon Panah --}}
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
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            {{-- Card Visi --}}
            <div class="bg-rose-700 rounded-3xl p-10 text-white shadow-xl shadow-rose-200/40 relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white opacity-10 rounded-full blur-2xl transform translate-x-10 -translate-y-10 group-hover:scale-150 transition duration-700">
                </div>
                <div class="relative z-10">
                    <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center text-3xl mb-6">👁️</div>
                    <h2 class="text-3xl font-bold mb-4">Visi</h2>
                    <p class="text-rose-100 text-lg leading-relaxed">
                        "Menjadi mitra terpercaya dalam memenuhi kebutuhan sehari-hari masyarakat."
                    </p>
                </div>
            </div>

            {{-- Card Misi --}}
            <div class="bg-white rounded-3xl p-10 border border-rose-100 shadow-xl shadow-rose-100/40 relative overflow-hidden group">
                <div class="absolute bottom-0 left-0 w-32 h-32 bg-rose-200 opacity-10 rounded-full blur-2xl transform -translate-x-10 translate-y-10 group-hover:scale-150 transition duration-700">
                </div>
                <div class="relative z-10">
                    <div class="w-14 h-14 bg-rose-100 text-rose-700 rounded-xl flex items-center justify-center text-3xl mb-6">
                        🚀
                    </div>
                    <h2 class="text-3xl font-bold text-slate-900 mb-4">Misi</h2>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3">
                            <span class="bg-green-100 text-green-600 rounded-full p-1 mt-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </span>
                            <span class="text-slate-600 text-lg">Menyediakan produk berkualitas tinggi.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="bg-green-100 text-green-600 rounded-full p-1 mt-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </span>
                            <span class="text-slate-600 text-lg">Memberikan harga yang kompetitif & miring.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="bg-green-100 text-green-600 rounded-full p-1 mt-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </span>
                            <span class="text-slate-600 text-lg">Mengutamakan pelayanan maksimal & kekeluargaan.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    {{-- BAGIAN 4: KEUNGGULAN --}}
    <section class="container mx-auto px-6 lg:px-12 mb-24">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            {{-- Card 1 --}}
            <div class="bg-white p-8 rounded-3xl shadow-lg shadow-rose-100/40 hover:shadow-xl hover:shadow-rose-400/20 transition border border-rose-100 text-center group">
                <div class="w-16 h-16 bg-rose-100 text-rose-600 rounded-2xl flex items-center justify-center mx-auto mb-6 text-3xl group-hover:scale-110 transition">
                    🤝
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">Pelayanan Kekeluargaan</h3>
                <p class="text-slate-600 leading-relaxed">
                    Dikenal pelayanannya yang baik dan ramah kepada setiap pelanggan.
                </p>
            </div>

            {{-- Card 2 --}}
            <div class="bg-white p-8 rounded-3xl shadow-lg shadow-emerald-100/40 hover:shadow-xl hover:shadow-emerald-500/20 transition border border-emerald-100 text-center group">
                <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center mx-auto mb-6 text-3xl group-hover:scale-110 transition">
                    🏷️
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">Harga Lebih Miring</h3>
                <p class="text-slate-600 leading-relaxed">
                    Dikenal sebagai toko yang menjual barang dengan harga sangat bersaing.
                </p>
            </div>

            {{-- Card 3 --}}
            <div class="bg-white p-8 rounded-3xl shadow-lg shadow-amber-100/40 hover:shadow-xl hover:shadow-amber-500/20 transition border border-amber-100 text-center group">
                <div class="w-16 h-16 bg-amber-100 text-amber-600 rounded-2xl flex items-center justify-center mx-auto mb-6 text-3xl group-hover:scale-110 transition">
                    ✨
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">Kualitas Terjamin</h3>
                <p class="text-slate-600 leading-relaxed">
                    Rata-rata produk yang dijual memiliki kualitas baik dan terpercaya.
                </p>
            </div>

        </div>
    </section>

    {{-- Script Modal SUDAH DIHAPUS karena tidak dipakai lagi --}}

@endsection