@extends('layouts.main')

@section('content')

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

    <section class="container mx-auto px-6 lg:px-12 mb-24">

        <div
            class="flex flex-col md:flex-row items-center gap-12 bg-white rounded-3xl p-8 md:p-12 shadow-xl shadow-rose-200/40 border border-rose-100">
            <div class="w-full md:w-1/2 h-64 md:h-96 rounded-2xl overflow-hidden relative group">
                <img src="{{ asset('lokasi/Utama_bagian_dalam.jpg') }}"
                    class="w-full h-full object-cover group-hover:scale-105 transition duration-500" alt="Sejarah Toko">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex items-end p-6">
                    <span class="text-white font-bold text-lg">Sejak 1959</span>
                </div>
            </div>

            <div class="w-full md:w-1/2">
                {{-- Badge About Us (Maroon) --}}
                <span
                    class="text-rose-700 font-bold tracking-wider uppercase text-sm bg-rose-100 px-3 py-1 rounded-full">About
                    Us</span>
                <h2 class="text-3xl font-bold text-slate-900 mt-4 mb-6">History of Utama Shop</h2>
                <p class="text-slate-600 text-lg leading-relaxed mb-6">
                    Usaha keluarga ini mulai berdiri pada tahun 1959...
                </p>

                {{-- Tombol Baca Sejarah (Maroon) --}}
                <button onclick="openModal()"
                    class="text-rose-700 font-bold hover:text-rose-900 flex items-center gap-2 group text-lg">
                    Baca Sejarah Lengkap
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:translate-x-1 transition"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </button>
            </div>
        </div>
    </section>

    {{-- VISI & MISI --}}
    <section class="container mx-auto px-6 lg:px-12 mb-24">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            {{-- Card Visi: Full Maroon Premium --}}
            <div
                class="bg-rose-700 rounded-3xl p-10 text-white shadow-xl shadow-rose-200/40 relative overflow-hidden group">
                <div
                    class="absolute top-0 right-0 w-32 h-32 bg-white opacity-10 rounded-full blur-2xl transform translate-x-10 -translate-y-10 group-hover:scale-150 transition duration-700">
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
            <div
                class="bg-white rounded-3xl p-10 border border-rose-100 shadow-xl shadow-rose-100/40 relative overflow-hidden group">
                <div
                    class="absolute bottom-0 left-0 w-32 h-32 bg-rose-200 opacity-10 rounded-full blur-2xl transform -translate-x-10 translate-y-10 group-hover:scale-150 transition duration-700">
                </div>
                <div class="relative z-10">
                    <div
                        class="w-14 h-14 bg-rose-100 text-rose-700 rounded-xl flex items-center justify-center text-3xl mb-6">
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

    {{-- 3 Keunggulan --}}
    <section class="container mx-auto px-6 lg:px-12 mb-24">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            {{-- Card 1 --}}
            <div
                class="bg-white p-8 rounded-3xl shadow-lg shadow-rose-100/40 hover:shadow-xl hover:shadow-rose-400/20 transition border border-rose-100 text-center group">
                <div
                    class="w-16 h-16 bg-rose-100 text-rose-600 rounded-2xl flex items-center justify-center mx-auto mb-6 text-3xl group-hover:scale-110 transition">
                    🤝
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">Pelayanan Kekeluargaan</h3>
                <p class="text-slate-600 leading-relaxed">
                    Dikenal pelayanannya yang baik
                </p>
            </div>

            {{-- Card 2 (Tetap Hijau karena makna harga murah) --}}
            <div
                class="bg-white p-8 rounded-3xl shadow-lg shadow-emerald-100/40 hover:shadow-xl hover:shadow-emerald-500/20 transition border border-emerald-100 text-center group">
                <div
                    class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center mx-auto mb-6 text-3xl group-hover:scale-110 transition">
                    🏷️
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">Harga Lebih Miring</h3>
                <p class="text-slate-600 leading-relaxed">
                    Dikenal sebagai toko yang menjual barang
                </p>
            </div>

            {{-- Card 3 --}}
            <div
                class="bg-white p-8 rounded-3xl shadow-lg shadow-amber-100/40 hover:shadow-xl hover:shadow-amber-500/20 transition border border-amber-100 text-center group">
                <div
                    class="w-16 h-16 bg-amber-100 text-amber-600 rounded-2xl flex items-center justify-center mx-auto mb-6 text-3xl group-hover:scale-110 transition">
                    ✨
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">Kualitas Terjamin</h3>
                <p class="text-slate-600 leading-relaxed">
                    Rata-rata produk yang dijual memiliki kualitas baik
                </p>
            </div>

        </div>
    </section>

    {{-- Sejarah Utama --}}
    <div id="historyModal" class="fixed inset-0 z-[100] hidden" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm transition-opacity opacity-0" id="modalBackdrop"></div>

        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-2xl opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    id="modalPanel">

                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 border-b border-slate-100">
                        <div class="flex items-start justify-between">
                            <h3 class="text-2xl font-bold leading-6 text-slate-900" id="modal-title">Sejarah Toko Utama
                            </h3>
                            <button onclick="closeModal()" class="text-slate-400 hover:text-rose-500 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- isi konten  --}}
                    <div
                        class="bg-white px-4 py-6 sm:p-8 max-h-[60vh] overflow-y-auto text-slate-600 leading-relaxed space-y-4 text-justify">
                        {!! 'Usaha keluarga ini mulai berdiri pada tahun 1959.Berawal saat itu masih banyak petani palawija di Karanganyar,Karangpandan, Jumapolo dan sekitarnya.hasil pertanian adalah beras,jagung,kedele,kacang hijau.
                                                Bp.Liem Kong Hong dan istrinya Ibu Meliati mengelola usaha dengan menerima hasil pertanian tersebut dari Petani ( semacam pengepul).kemudian setelah terkumpul cukup banyak kemudian dijual ke kota Solo, diangkut dengan pedati sapi.
                                                Lokasi usaha awal di Selatan Pasar Karanganyar yang sekarang menjadi Taman Pancasila.
                                                Karena dekat pasar dan pasar tsb  serta area terminal ( th 1970 an) menjadi salah   satu pusat perekonomian Karanganyar,usaha mengalami peningkatan dengan produk yg dijual sesuai permintaan pasar seperti Minyak tanah, minyak goreng, tapioka,gandum mulai dijual ditempat ini.
                                                Usaha ini banyak dikenal dengan nama toko Nyah Waing ( nama lain Ibu Meliati), sampai sekarangpun terkadang pelanggan lama/ masyarakat asli Karanganyar menyebutnya demikian.
                                                
                                                Th 1982 Bp Liem Kong Hong meninggal dunia, bisnis usaha dipegang sepunuhnya oleh Ibu Meliati dan dibantu putra putrinya ( Ivan Purnomo dan Iin Salim)
                                                Seiring dengan berjalannya waktu dan perubahan zaman, usaha inipun menjadi semacam toko grosiran sembako, dimana dari desa desa kecil di Karanganyar dan sekitar membeli barang dagangan di tempat ini untuk dijual kembali di daerah/ kampung/ rumah masing masing.
                                                Oleh Ivan Purnomo usaha ini diberi nama/ brand Toko Utama.
                                                Barang barang yang dijualpun semakin bervariasi selain menyediakan 9 bahan pokok juga menyediakan barang barang consumer good lainnya ( snack, roti, kerupuk, minuman kemasan, kopi, rokok dll) sesuai permintaan pasar.
                                                Di tahun 1990an permintaan produk rokok semakin meningkat,perputaran di barang dagangan ini meningkat pesat sehingga produk rokok di toko ini mencapai 40 % dari seluruh produk yg lain yang dijual.Toko ini menjadi dikenal sebagai toko grosir rokok besar utk wilayah Karanganyar sampai sekarang.
                                                Toko Utama sebagai toko Grosir an semakin hari juga semakin menghadapi tantangan  dari pesaing pesaing usaha sejenis.untuk itu toko Utama berusaha keras untuk tetap bisa eksis dalam pelayanan dan harga yang ditawarkan,sesuai dengan motto selama ini:
                                                -melayani dan untung bersama
                                                -selalu baru dan lebih murah/ miring harga' !!}
                    </div>

                    {{-- close the tabs --}}
                    <div class="bg-slate-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 border-t border-slate-100">
                        <button type="button" onclick="closeModal()"
                            class="inline-flex w-full justify-center rounded-xl bg-rose-700 px-5 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-rose-800 sm:ml-3 sm:w-auto transition">
                            Close
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        const modal = document.getElementById('historyModal');
        const backdrop = document.getElementById('modalBackdrop');
        const panel = document.getElementById('modalPanel');

        function openModal() {
            modal.classList.remove('hidden');
            setTimeout(() => {
                backdrop.classList.remove('opacity-0');
                panel.classList.remove('opacity-0', 'translate-y-4', 'sm:translate-y-0', 'sm:scale-95');
                panel.classList.add('opacity-100', 'translate-y-0', 'sm:scale-100');
            }, 50);
        }

        function closeModal() {
            backdrop.classList.add('opacity-0');
            panel.classList.remove('opacity-100', 'translate-y-0', 'sm:scale-100');
            panel.classList.add('opacity-0', 'translate-y-4', 'sm:translate-y-0', 'sm:scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        window.onclick = function(event) {
            if (event.target == modalBackdrop) {
                closeModal();
            }
        }
    </script>
@endsection
