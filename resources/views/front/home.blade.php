@extends('layouts.main') {{-- Panggil layout yang sudah direname --}}

@section('content')

    {{-- Saya pakai padding py-20 dan background abu-abu sebagai placeholder gambar toko --}}
    <section class="relative bg-gray-800 py-24 mb-12 rounded-xl overflow-hidden">
        
        <img src="https://images.unsplash.com/photo-1542838132-92c53300491e?q=80&w=2574&auto=format&fit=crop" 
             class="absolute inset-0 w-full h-full object-cover opacity-40">

        <div class="relative z-10 container mx-auto flex justify-center items-center h-full">
            <div class="bg-white/90 backdrop-blur-sm p-8 md:p-12 rounded-2xl shadow-2xl text-center max-w-2xl">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Toko Utama</h1>
                <p class="text-gray-600 text-lg mb-6">Lengkapi kebutuhan harianmu dengan harga tetangga, kualitas juara.</p>
                <a href="{{ route('catalog') }}" class="inline-block bg-blue-600 text-white font-bold py-3 px-8 rounded-full hover:bg-blue-700 transition transform hover:scale-105">
                    Belanja Sekarang
                </a>
            </div>
        </div>
    </section>

    <section class="container mx-auto px-4 mb-20 text-center">
        <h2 class="text-3xl font-bold text-gray-800 mb-6">Tentang Kami</h2>
        <div class="max-w-3xl mx-auto text-gray-600 leading-relaxed text-lg">
            <p>
                Selamat datang di <strong>Toko Utama</strong>. Kami adalah usaha keluarga yang berdedikasi menyediakan 
                kebutuhan pokok masyarakat dengan pelayanan yang hangat dan bersahabat. 
                Berawal dari toko kelontong sederhana, kini kami hadir secara digital untuk memudahkan 
                Anda berbelanja rokok, sembako, dan jajanan tanpa harus keluar rumah.
            </p>
        </div>
    </section>

    <section class="bg-blue-50 py-16 rounded-xl mb-12">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Kenapa Belanja di Sini?</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition">
                    <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 text-blue-600 text-3xl">
                        💰
                    </div>
                    <h3 class="text-xl font-bold mb-2">Harga Termurah</h3>
                    <p class="text-gray-500">Kami menjamin harga yang kompetitif dan ramah di kantong untuk kebutuhan harian Anda.</p>
                </div>

                <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 text-green-600 text-3xl">
                        ⚡
                    </div>
                    <h3 class="text-xl font-bold mb-2">Proses Cepat</h3>
                    <p class="text-gray-500">Pesan sekarang, kami siapkan langsung. Tanpa ribet, tanpa antri lama.</p>
                </div>

                <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition">
                    <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 text-purple-600 text-3xl">
                        🤝
                    </div>
                    <h3 class="text-xl font-bold mb-2">Pelayanan Kekeluargaan</h3>
                    <p class="text-gray-500">Kami melayani dengan hati seperti keluarga sendiri. Kepuasan Anda adalah prioritas kami.</p>
                </div>
            </div>
        </div>
    </section>

@endsection