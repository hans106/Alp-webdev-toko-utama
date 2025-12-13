@extends('layouts.main')

@section('content')

    {{-- BAGIAN 1: HEADER JUDUL --}}
    <section class="bg-rose-50 py-16 mb-12">
        <div class="container mx-auto px-6 text-center">
            <span class="text-rose-600 font-bold tracking-wider uppercase text-sm">Tentang Kami</span>
            <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 mt-2 mb-4">
                Perjalanan Toko Utama
            </h1>
            <div class="w-24 h-1 bg-rose-600 mx-auto rounded-full"></div>
        </div>
    </section>

    {{-- BAGIAN 2: SEJARAH LENGKAP (Teks Asli Punya Abang) --}}
    <section class="container mx-auto px-6 lg:px-12 mb-24">
        <div class="flex flex-col lg:flex-row gap-12 items-start">
            
            {{-- Foto Sejarah (Sebelah Kiri) --}}
            <div class="w-full lg:w-1/2 sticky top-24">
                <div class="relative rounded-3xl overflow-hidden shadow-2xl shadow-slate-200 border-4 border-white transform rotate-2 hover:rotate-0 transition duration-500">
                    {{-- Pakai foto bagian dalam toko sebagai ilustrasi sejarah --}}
                    <img src="{{ asset('lokasi/Utama_bagian_dalam.jpg') }}" alt="Foto Sejarah Toko" class="w-full h-auto object-cover">
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-6 text-white">
                        <p class="font-bold text-lg">Kenangan Masa Lalu</p>
                        <p class="text-sm text-slate-300">Awal mula berdirinya toko keluarga.</p>
                    </div>
                </div>
            </div>

            {{-- Teks Cerita (Sebelah Kanan) --}}
            <div class="w-full lg:w-1/2 text-slate-600 text-lg leading-relaxed space-y-6 text-justify">
                
                <p>
                    <strong class="text-rose-700">Tahun 1959.</strong> Usaha keluarga ini mulai berdiri. Berawal saat itu masih banyak petani palawija di Karanganyar, Karangpandan, Jumapolo dan sekitarnya. Hasil pertanian saat itu adalah beras, jagung, kedelai, dan kacang hijau.
                </p>

                <p>
                    <strong>Bp. Liem Kong Hong</strong> dan istrinya <strong>Ibu Meliati</strong> mengelola usaha dengan menerima hasil pertanian tersebut dari Petani (semacam pengepul). Setelah terkumpul cukup banyak, kemudian dijual ke kota Solo, diangkut dengan pedati sapi. Lokasi usaha awal berada di Selatan Pasar Karanganyar yang sekarang menjadi Taman Pancasila.
                </p>

                <p>
                    Karena dekat pasar dan area terminal (tahun 1970-an) menjadi salah satu pusat perekonomian Karanganyar, usaha mengalami peningkatan. Produk yang dijual mulai menyesuaikan permintaan pasar seperti Minyak tanah, minyak goreng, tapioka, dan gandum. Usaha ini banyak dikenal dengan nama <strong>"Toko Nyah Waing"</strong> (nama panggilan Ibu Meliati), sampai sekarang pun pelanggan lama atau masyarakat asli Karanganyar masih menyebutnya demikian.
                </p>

                <div class="bg-rose-50 p-6 rounded-xl border-l-4 border-rose-500 italic text-slate-700">
                    "Toko Nyah Waing menjadi saksi bisu perkembangan ekonomi Karanganyar dari masa ke masa."
                </div>

                <p>
                    Tahun 1982, Bp. Liem Kong Hong meninggal dunia. Bisnis usaha dipegang sepenuhnya oleh Ibu Meliati dibantu putra-putrinya (Ivan Purnomo dan Iin Salim). Seiring berjalannya waktu, usaha ini berkembang menjadi toko grosiran sembako. Desa-desa kecil di Karanganyar membeli barang dagangan di sini untuk dijual kembali.
                </p>

                <p>
                    Oleh Bp. Ivan Purnomo, usaha ini diberi nama baru: <strong>Toko Utama</strong>. Barang yang dijual semakin bervariasi, mulai dari 9 bahan pokok hingga <em>consumer goods</em> (snack, roti, minuman kemasan, kopi, rokok, dll).
                </p>
                
                <p>
                    Di tahun 1990-an, permintaan produk rokok meningkat pesat hingga mencapai 40% dari seluruh penjualan. Toko ini pun dikenal sebagai Grosir Rokok besar di wilayah Karanganyar. Meski persaingan semakin ketat, Toko Utama terus berusaha eksis dengan motto: <br>
                    <span class="font-bold text-rose-700">"Melayani dan Untung Bersama, Selalu Baru dan Lebih Miring Harganya."</span>
                </p>
            </div>
        </div>
    </section>

    {{-- BAGIAN 3: TIM KAMI (Data Karyawan dari Database) --}}
    <section class="bg-slate-50 py-20">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-slate-900">Keluarga Besar Toko Utama</h2>
                <p class="text-slate-500 mt-2">Orang-orang hebat di balik pelayanan kami.</p>
            </div>

            {{-- Grid Karyawan --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                
                @forelse($employees as $emp)
                    <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition duration-300 overflow-hidden group border border-slate-100">
                        
                        {{-- Foto --}}
                        <div class="h-64 overflow-hidden bg-gray-200 relative">
                            @if($emp->image_photo)
                                <img src="{{ asset('storage/' . $emp->image_photo) }}" 
                                     alt="{{ $emp->name }}" 
                                     class="w-full h-full object-cover object-top group-hover:scale-105 transition duration-500">
                            @else
                                {{-- Fallback Foto kalau belum upload --}}
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($emp->name) }}&background=e11d48&color=fff&size=512" 
                                     class="w-full h-full object-cover">
                            @endif
                        </div>

                        {{-- Info --}}
                        <div class="p-6 text-center">
                            <h3 class="text-xl font-bold text-slate-800 mb-1">{{ $emp->name }}</h3>
                            <p class="text-rose-600 font-medium text-sm uppercase tracking-wide mb-4">
                                {{ $emp->position }}
                            </p>
                            
                            {{-- Nomor HP (Jika ada) --}}
                            @if($emp->phone)
                            <div class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-slate-100 text-slate-600 rounded-full text-sm w-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                {{ $emp->phone }}
                            </div>
                            @endif
                        </div>
                    </div>
                @empty
                    {{-- Kalau Database Kosong --}}
                    <div class="col-span-full text-center py-10">
                        <p class="text-slate-500 italic">Belum ada data karyawan yang ditampilkan.</p>
                    </div>
                @endforelse

            </div>
        </div>
    </section>

@endsection