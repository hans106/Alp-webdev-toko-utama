@extends('layouts.main')

@section('content')

    <section class="relative h-[600px] flex items-center justify-center overflow-hidden mb-16">
        
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1604719312566-b7cb966348e7?q=80&w=2574&auto=format&fit=crop" 
                 alt="Background Toko" 
                 class="w-full h-full object-cover">
            
            <div class="absolute inset-0 bg-slate-900/60"></div>
        </div>

        <div class="relative z-10 container mx-auto px-6 text-center text-white">
            <h1 class="text-5xl md:text-7xl font-extrabold mb-6 tracking-tight drop-shadow-lg">
                Toko Utama
            </h1>
            <p class="text-xl md:text-2xl font-medium text-slate-100 max-w-3xl mx-auto mb-10 leading-relaxed drop-shadow-md">
                Lengkapi kebutuhan harianmu dengan harga tetangga, kualitas juara. <br>
                Melayani sepenuh hati sejak 1959.
            </p>
            <a href="{{ route('catalog') }}" class="inline-block bg-gradient-to-r from-primary to-indigo-600 text-white font-bold py-4 px-12 rounded-full hover:shadow-lg hover:shadow-indigo-500/50 transition transform hover:-translate-y-1 text-lg">
                Belanja Sekarang
            </a>
        </div>
    </section>

    <section class="container mx-auto px-6 lg:px-12 mb-24">
        <div class="flex flex-col md:flex-row items-center gap-12 bg-white rounded-3xl p-8 md:p-12 shadow-xl shadow-slate-200/50 border border-slate-100">
            
            <div class="w-full md:w-1/2 h-64 md:h-96 rounded-2xl overflow-hidden relative group">
                <img src="https://images.unsplash.com/photo-1578575437130-527eed3abbec?q=80&w=2670&auto=format&fit=crop" 
                     class="w-full h-full object-cover group-hover:scale-105 transition duration-500" alt="Sejarah Toko">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex items-end p-6">
                    <span class="text-white font-bold text-lg">Sejak 1959</span>
                </div>
            </div>

            <div class="w-full md:w-1/2">
                <span class="text-primary font-bold tracking-wider uppercase text-sm bg-indigo-50 px-3 py-1 rounded-full">Cerita Kami</span>
                <h2 class="text-3xl font-bold text-slate-900 mt-4 mb-6">Perjalanan Toko Utama</h2>
                <p class="text-slate-600 text-lg leading-relaxed mb-6">
                    Usaha keluarga ini mulai berdiri pada tahun 1959. Berawal saat itu masih banyak petani palawija di Karanganyar, Karangpandan, Jumapolo dan sekitarnya...
                </p>
                
                <button onclick="openModal()" class="text-primary font-bold hover:text-indigo-800 flex items-center gap-2 group text-lg">
                    Baca Sejarah Lengkap
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:translate-x-1 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                </button>
            </div>
        </div>
    </section>

    <section class="container mx-auto px-6 lg:px-12 mb-24">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            
            <div class="bg-indigo-600 rounded-3xl p-10 text-white shadow-xl shadow-indigo-200 relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white opacity-10 rounded-full blur-2xl transform translate-x-10 -translate-y-10 group-hover:scale-150 transition duration-700"></div>
                
                <div class="relative z-10">
                    <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center text-3xl mb-6">
                        👁️
                    </div>
                    <h2 class="text-3xl font-bold mb-4">Visi Kami</h2>
                    <p class="text-indigo-100 text-lg leading-relaxed">
                        "Menjadi mitra terpercaya dalam memenuhi kebutuhan sehari-hari masyarakat."
                    </p>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-10 border border-slate-100 shadow-xl shadow-slate-200/50 relative overflow-hidden group">
                <div class="absolute bottom-0 left-0 w-32 h-32 bg-primary opacity-5 rounded-full blur-2xl transform -translate-x-10 translate-y-10 group-hover:scale-150 transition duration-700"></div>

                <div class="relative z-10">
                    <div class="w-14 h-14 bg-indigo-50 text-primary rounded-xl flex items-center justify-center text-3xl mb-6">
                        🚀
                    </div>
                    <h2 class="text-3xl font-bold text-slate-900 mb-4">Misi Kami</h2>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3">
                            <span class="bg-green-100 text-green-600 rounded-full p-1 mt-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg></span>
                            <span class="text-slate-600 text-lg">Menyediakan produk berkualitas tinggi.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="bg-green-100 text-green-600 rounded-full p-1 mt-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg></span>
                            <span class="text-slate-600 text-lg">Memberikan harga yang kompetitif & miring.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="bg-green-100 text-green-600 rounded-full p-1 mt-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg></span>
                            <span class="text-slate-600 text-lg">Mengutamakan pelayanan maksimal & kekeluargaan.</span>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </section>

    <section class="container mx-auto px-6 lg:px-12 mb-24">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-slate-900 mb-4">Kenapa Belanja di Toko Utama?</h2>
            <p class="text-slate-500 text-lg">Komitmen kami untuk kepuasan Anda.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-8 rounded-3xl shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-indigo-500/10 transition border border-slate-100 text-center group">
                <div class="w-16 h-16 bg-indigo-100 text-primary rounded-2xl flex items-center justify-center mx-auto mb-6 text-3xl group-hover:scale-110 transition">
                    🤝
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">Pelayanan Kekeluargaan</h3>
                <p class="text-slate-600 leading-relaxed">
                    Dikenal pelayanannya yang baik karena pemilik (owner) ikut langsung melayani pembeli dengan sepenuh hati.
                </p>
            </div>

            <div class="bg-white p-8 rounded-3xl shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-indigo-500/10 transition border border-slate-100 text-center group">
                <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center mx-auto mb-6 text-3xl group-hover:scale-110 transition">
                    🏷️
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">Harga Lebih Miring</h3>
                <p class="text-slate-600 leading-relaxed">
                    Dikenal sebagai toko yang menjual barang dagangannya dengan harga lebih murah dibanding toko sejenis.
                </p>
            </div>

            <div class="bg-white p-8 rounded-3xl shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-indigo-500/10 transition border border-slate-100 text-center group">
                <div class="w-16 h-16 bg-amber-100 text-amber-600 rounded-2xl flex items-center justify-center mx-auto mb-6 text-3xl group-hover:scale-110 transition">
                    ✨
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">Kualitas Terjamin</h3>
                <p class="text-slate-600 leading-relaxed">
                    Rata-rata produk yang dijual memiliki kualitas yang baik dan stok barang selalu baru (Fresh Stock).
                </p>
            </div>
        </div>
    </section>

    <div id="historyModal" class="fixed inset-0 z-[100] hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm transition-opacity opacity-0" id="modalBackdrop"></div>
        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-2xl opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" id="modalPanel">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 border-b border-slate-100">
                        <div class="flex items-start justify-between">
                            <h3 class="text-2xl font-bold leading-6 text-slate-900" id="modal-title">Sejarah Toko Utama</h3>
                            <button onclick="closeModal()" class="text-slate-400 hover:text-rose-500 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>
                    </div>
                    <div class="bg-white px-4 py-6 sm:p-8 max-h-[60vh] overflow-y-auto text-slate-600 leading-relaxed space-y-4 text-justify">
                        <p>Usaha keluarga ini mulai berdiri pada tahun <strong>1959</strong>. Berawal saat itu masih banyak petani palawija di Karanganyar, Karangpandan, Jumapolo dan sekitarnya. Hasil pertanian adalah beras, jagung, kedele, dan kacang hijau.</p>
                        <p><strong>Bp. Liem Kong Hong</strong> dan istrinya <strong>Ibu Meliati</strong> mengelola usaha dengan menerima hasil pertanian tersebut dari Petani (semacam pengepul). Kemudian setelah terkumpul cukup banyak kemudian dijual ke kota Solo, diangkut dengan pedati sapi.</p>
                        <p>Lokasi usaha awal di Selatan Pasar Karanganyar yang sekarang menjadi Taman Pancasila. Karena dekat pasar dan pasar tersebut serta area terminal (tahun 1970-an) menjadi salah satu pusat perekonomian Karanganyar, usaha mengalami peningkatan. Produk yang dijual mulai bervariasi sesuai permintaan pasar seperti Minyak tanah, minyak goreng, tapioka, dan gandum.</p>
                        <p>Usaha ini banyak dikenal dengan nama <strong>"Toko Nyah Waing"</strong> (nama lain Ibu Meliati), sampai sekarangpun terkadang pelanggan lama atau masyarakat asli Karanganyar menyebutnya demikian.</p>
                        <p>Tahun 1982 Bp Liem Kong Hong meninggal dunia, bisnis usaha dipegang sepenuhnya oleh Ibu Meliati dan dibantu putra putrinya (Ivan Purnomo dan Iin Salim). Seiring dengan berjalannya waktu dan perubahan zaman, usaha inipun menjadi semacam toko grosiran sembako.</p>
                        <p>Oleh Bp. Ivan Purnomo usaha ini diberi nama/brand <strong>Toko Utama</strong>. Barang barang yang dijualpun semakin bervariasi selain menyediakan 9 bahan pokok juga menyediakan barang barang consumer good lainnya.</p>
                        <p>Di tahun 1990an permintaan produk rokok semakin meningkat, perputaran di barang dagangan ini meningkat pesat sehingga produk rokok di toko ini mencapai 40% dari seluruh produk yang dijual. Toko ini menjadi dikenal sebagai toko grosir rokok besar untuk wilayah Karanganyar sampai sekarang.</p>
                        <div class="bg-indigo-50 p-4 rounded-xl border border-indigo-100 mt-4"><h4 class="font-bold text-primary mb-2">Motto Kami:</h4><ul class="list-disc list-inside font-medium text-slate-700"><li>Melayani dan untung bersama</li><li>Selalu baru dan lebih murah/miring harga</li></ul></div>
                    </div>
                    <div class="bg-slate-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 border-t border-slate-100">
                        <button type="button" onclick="closeModal()" class="inline-flex w-full justify-center rounded-xl bg-primary px-5 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-indigo-700 sm:ml-3 sm:w-auto transition">Tutup Cerita</button>
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
            setTimeout(() => { modal.classList.add('hidden'); }, 300);
        }
        window.onclick = function(event) { if (event.target == modalBackdrop) { closeModal(); } }
    </script>

@endsection