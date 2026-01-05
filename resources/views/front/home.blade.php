@extends('layouts.main')

@section('content')
    {{-- BAGIAN 1: HERO SECTION --}}
    <section class="relative h-[600px] flex items-center justify-center overflow-hidden mb-16">

        <div class="absolute inset-0">
            <img src="/Lokasi/Utama_bagian_depan.jpg" alt="Background Toko"
                class="w-full h-full object-cover scale-105 animate-[pulse_8s_ease-in-out_infinite] opacity-90">
            <div class="absolute inset-0 bg-gradient-to-b from-[#2B0A0A]/40 via-[#2B0A0A]/50 to-[#2B0A0A]"></div>
        </div>

        <div class="relative z-10 container mx-auto px-6 text-center text-white mt-10"">
            <h1 class="text-5xl md:text-7xl font-extrabold mb-6 tracking-tight drop-shadow-2xl leading-tight font-serif">
                Toko <span class="text-[#E1B56A] bg-clip-text bg-gradient-to-r from-[#E1B56A] to-[#F6E3C1]">Utama</span>
            </h1>
            <a href="{{ route('catalog') }}"
                class="group relative inline-flex items-center justify-center py-4 px-10 overflow-hidden font-bold text-slate-900 transition-all duration-300 bg-[#E1B56A] rounded-xl hover:bg-[#cfa355] hover:scale-105 hover:shadow-[0_0_30px_rgba(225,181,106,0.5)] border border-[#E1B56A]">

                <span class="relative">Buy the Products Now</span>

                <svg class="w-5 h-5 ml-2 -mr-1 transition-all duration-300 group-hover:translate-x-1" fill="currentColor"
                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                        clip-rule="evenodd"></path>
                </svg>
            </a>
        </div>
    </section>

    {{-- BAGIAN 2: CUPLIKAN SEJARAH --}}
    <section class="container mx-auto px-6 lg:px-12 mb-20 md:mb-32">
        <div class="flex flex-col md:flex-row items-center gap-8 md:gap-16">

            {{-- Image Side (Mobile: Top, iPad: Left) --}}
            <div class="w-full md:w-1/2 relative group">
                <div
                    class="absolute inset-0 bg-[#E1B56A] rounded-3xl rotate-3 group-hover:rotate-6 transition-transform duration-500 opacity-20">
                </div>
                <div
                    class="h-64 md:h-[450px] rounded-3xl overflow-hidden relative shadow-2xl shadow-[#2B0A0A]/20 border border-[#E1B56A]/20 bg-white">
                    <img src="/Lokasi/Utama_bagian_dalam.jpg"
                        class="w-full h-full object-cover group-hover:scale-110 transition duration-1000 ease-out"
                        alt="Sejarah Toko">

                    {{-- Badge Tahun Floating --}}
                    <div
                        class="absolute bottom-6 left-6 bg-white/90 backdrop-blur text-[#800000] px-5 py-3 rounded-xl shadow-lg border-l-4 border-[#800000]">
                        <span class="font-bold text-2xl font-serif">1955</span>
                    </div>
                </div>
            </div>

            {{-- Text Side --}}
            <div class="w-full md:w-1/2">
                <div class="flex items-center gap-3 mb-4">
                    <span class="h-px w-12 bg-[#800000]"></span>
                    <span class="text-[#800000] font-bold tracking-widest uppercase text-xs">ABOUT US</span>
                </div>

                <h2 class="text-3xl md:text-5xl font-bold text-[#2B0A0A] mb-6 font-serif leading-tight">
                    Toko <span class="italic text-[#800000]">Utama.</span>
                </h2>

                <p class="text-slate-600 text-base md:text-lg leading-relaxed mb-8 text-justify">
                    Bermula dari sebuah gudang kecil penampung hasil bumi pada tahun 1955,
                    <span class="font-bold text-[#800000]">Toko Utama</span> telah bertransformasi menjadi pusat
                    perbelanjaan modern di Karanganyar. Kami memadukan kenyamanan modern dengan kehangatan tradisional yang
                    tak lekang oleh waktu.
                </p>

                <a href="{{ route('about') }}"
                    class="inline-flex items-center gap-3 text-[#800000] font-bold hover:text-[#581313] transition-colors text-lg group">
                    <span class="border-b-2 border-[#800000]/30 group-hover:border-[#800000] pb-1 transition-all">Baca
                        Sejarah Lengkap</span>
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 group-hover:translate-x-2 transition-transform duration-300" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>
        </div>
    </section>


    {{-- BAGIAN 3: VISI & MISI (Layout Hemat Tempat: Icon Kiri - Teks Kanan) --}}
    <section class="container mx-auto px-4 md:px-6 lg:px-12 mb-12 md:mb-32">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-10">

            {{-- CARD VISI --}}
            <div
                class="bg-gradient-to-br from-[#800000] to-[#4A0404] rounded-2xl p-4 md:p-14 text-white shadow-xl relative overflow-hidden group border border-[#E1B56A]/20">
                {{-- Flex Row di HP (Kiri-Kanan), Flex Col di Desktop (Atas-Bawah) --}}
                <div class="relative z-10 flex flex-row md:flex-col items-center md:items-start gap-4 md:gap-0">

                    {{-- Icon Wrapper --}}
                    <div
                        class="flex-shrink-0 w-12 h-12 md:w-16 md:h-16 bg-white/10 border border-white/10 rounded-xl flex items-center justify-center md:mb-8 backdrop-blur-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="#E1B56A" class="w-6 h-6 md:w-8 md:h-8 al">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>

                    {{-- Text Content --}}
                    <div>
                        <h3 class="text-[#E1B56A] tracking-widest uppercase text-[10px] md:text-sm font-bold mb-1 md:mb-2">
                            Visi Kami</h3>
                        <p class="text-sm md:text-3xl font-serif italic leading-snug md:leading-relaxed text-white/90">
                            "Menjadi mitra keluarga terpercaya dalam kebutuhan sehari-hari."
                        </p>
                    </div>
                </div>
            </div>

            {{-- CARD MISI (Fixed Position: Icon Kiri Full) --}}
            <div class="bg-white rounded-2xl p-4 md:p-14 border border-slate-100 shadow-lg relative overflow-hidden">
                <div class="relative z-10">
                    {{-- Flex Row di HP: Icon Kiri, Konten Kanan --}}
                    <div class="flex flex-row md:flex-col items-start gap-4 md:gap-0">

                        {{-- Icon Wrapper (Kiri di HP, Atas di Desktop) --}}
                        <div
                            class="flex-shrink-0 w-12 h-12 md:w-16 md:h-16 bg-[#800000]/5 rounded-xl flex items-center justify-center md:mb-8 mt-5 md:mt-0">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="#800000" class="w-6 h-6 md:w-8 md:h-8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
                            </svg>
                        </div>

                        {{-- Wrapper Konten (Judul & List) --}}
                        <div class="flex-1">
                            <h3
                                class="text-[#800000] tracking-widest uppercase text-[10px] md:text-sm font-bold mb-2 md:mb-4">
                                Misi Kami</h3>

                            <ul class="space-y-2 md:space-y-5">
                                <li class="flex items-start gap-2 md:gap-4">
                                    <span
                                        class="flex-shrink-0 w-4 h-4 md:w-6 md:h-6 rounded-full bg-[#800000] flex items-center justify-center mt-0.5 md:mt-1 shadow-md">
                                        <svg class="w-2.5 h-2.5 md:w-3.5 md:h-3.5 text-white" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </span>
                                    <span class="text-slate-700 text-xs md:text-lg leading-tight md:leading-normal">Produk
                                        lengkap & berkualitas tinggi.</span>
                                </li>
                                <li class="flex items-start gap-2 md:gap-4">
                                    <span
                                        class="flex-shrink-0 w-4 h-4 md:w-6 md:h-6 rounded-full bg-[#800000] flex items-center justify-center mt-0.5 md:mt-1 shadow-md">
                                        <svg class="w-2.5 h-2.5 md:w-3.5 md:h-3.5 text-white" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </span>
                                    <span class="text-slate-700 text-xs md:text-lg leading-tight md:leading-normal">Harga
                                        kompetitif</span>
                                </li>
                                <li class="flex items-start gap-2 md:gap-4">
                                    <span
                                        class="flex-shrink-0 w-4 h-4 md:w-6 md:h-6 rounded-full bg-[#800000] flex items-center justify-center mt-0.5 md:mt-1 shadow-md">
                                        <svg class="w-2.5 h-2.5 md:w-3.5 md:h-3.5 text-white" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </span>
                                    <span
                                        class="text-slate-700 text-xs md:text-lg leading-tight md:leading-normal">Pelayanan
                                        ramah & sepenuh hati.</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- BAGIAN 4: KEUNGGULAN (Tanpa Judul Header - Langsung Card) --}}
    <section class="container mx-auto px-4 md:px-6 lg:px-12 mb-12 md:mb-32">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3 md:gap-8">

            {{-- Card 1 --}}
            <div
                class="bg-white p-4 md:p-8 rounded-xl border border-slate-100 shadow-sm hover:shadow-lg transition-all duration-300 group">
                {{-- Flex Row (HP) -> Col (Desktop) --}}
                <div class="flex flex-row md:flex-col items-center md:items-center text-left md:text-center gap-4">
                    <div
                        class="flex-shrink-0 w-12 h-12 md:w-16 md:h-16 bg-[#800000]/5 text-[#800000] rounded-xl flex items-center justify-center group-hover:bg-[#800000] group-hover:text-white transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6 md:w-8 md:h-8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm md:text-xl font-bold text-[#2B0A0A] mb-1 md:mb-3">Pelayanan Keluarga</h3>
                        <p class="text-slate-500 text-xs md:text-base leading-relaxed">
                            Melayani dengan hati, seperti keluarga sendiri.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Card 2 --}}
            <div
                class="bg-white p-4 md:p-8 rounded-xl border border-slate-100 shadow-sm hover:shadow-lg transition-all duration-300 group">
                <div class="flex flex-row md:flex-col items-center md:items-center text-left md:text-center gap-4">
                    <div
                        class="flex-shrink-0 w-12 h-12 md:w-16 md:h-16 bg-[#C5A059]/10 text-[#C5A059] rounded-xl flex items-center justify-center group-hover:bg-[#C5A059] group-hover:text-white transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6 md:w-8 md:h-8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm md:text-xl font-bold text-[#2B0A0A] mb-1 md:mb-3">Harga Murah</h3>
                        <p class="text-slate-500 text-xs md:text-base leading-relaxed">
                            Harga bersaing, hemat untuk belanja bulanan.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Card 3 --}}
            <div
                class="bg-white p-4 md:p-8 rounded-xl border border-slate-100 shadow-sm hover:shadow-lg transition-all duration-300 group">
                <div class="flex flex-row md:flex-col items-center md:items-center text-left md:text-center gap-4">
                    <div
                        class="flex-shrink-0 w-12 h-12 md:w-16 md:h-16 bg-slate-100 text-slate-600 rounded-xl flex items-center justify-center group-hover:bg-[#2B0A0A] group-hover:text-[#E1B56A] transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6 md:w-8 md:h-8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm md:text-xl font-bold text-[#2B0A0A] mb-1 md:mb-3">Kualitas Terjamin</h3>
                        <p class="text-slate-500 text-xs md:text-base leading-relaxed">
                            Produk dicek ketat demi kepuasan Anda.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
