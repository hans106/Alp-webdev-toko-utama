@extends('layouts.main')

@section('content')

    {{-- ========================================== --}}
    {{-- BAGIAN 1: HEADER JUDUL --}}
    {{-- ========================================== --}}
    <section class="bg-rose-50 py-16 mb-12">
        <div class="container mx-auto px-6 text-center">
            <span class="text-rose-600 font-bold tracking-wider uppercase text-sm">About Us</span>
            <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 mt-2 mb-4">
                History of Toko Utama
            </h1>
            <div class="w-24 h-1 bg-rose-600 mx-auto rounded-full"></div>
        </div>
    </section>

    {{-- ========================================== --}}
    {{-- BAGIAN 2: SEJARAH LENGKAP --}}
    {{-- ========================================== --}}
    <section class="container mx-auto px-6 lg:px-12 mb-24">
        <div class="flex flex-col lg:flex-row gap-12 items-start">
            
            {{-- Foto Sejarah --}}
            <div class="w-full lg:w-1/2 sticky top-24">
                <div class="relative rounded-3xl overflow-hidden shadow-2xl shadow-slate-200 border-4 border-white transform rotate-2 hover:rotate-0 transition duration-500">
                    {{-- Pastikan file gambar ini ada di public/lokasi/ --}}
                    <img src="/Lokasi/Utama_bagian_dalam.jpg" alt="Foto Sejarah Toko" class="w-full h-auto object-cover">
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-6 text-white">
                        <p class="font-bold text-lg">1955</p>
                        <p class="text-sm text-slate-300">CX22+C36, Karanganyar, Central Java.</p>
                    </div>
                </div>
            </div>

            {{-- Teks Cerita --}}
            <div class="w-full lg:w-1/2 text-slate-600 text-lg leading-relaxed space-y-6 text-justify">
                <p>
                    Usaha keluarga ini mulai berdiri pada <strong class="text-rose-700">tahun 1959</strong>. Berawal saat itu masih banyak petani palawija di Karanganyar, Karangpandan, Jumapolo dan sekitarnya. Hasil pertanian adalah beras, jagung, kedele, kacang hijau.
                </p>
                <p>
                    <strong>Bp. Liem Kong Hong</strong> dan istrinya <strong>Ibu Meliati</strong> mengelola usaha dengan menerima hasil pertanian tersebut dari Petani (semacam pengepul). Kemudian setelah terkumpul cukup banyak kemudian dijual ke kota Solo, diangkut dengan pedati sapi.
                </p>
                <p>
                    Lokasi usaha awal di Selatan Pasar Karanganyar yang sekarang menjadi Taman Pancasila. Karena dekat pasar dan pasar tsb serta area terminal (th 1970 an) menjadi salah satu pusat perekonomian Karanganyar, usaha mengalami peningkatan dengan produk yg dijual sesuai permintaan pasar seperti Minyak tanah, minyak goreng, tapioka, gandum mulai dijual ditempat ini.
                </p>
                <div class="bg-rose-50 p-5 rounded-xl border-l-4 border-rose-500 text-slate-700 italic">
                    "Usaha ini banyak dikenal dengan nama <strong>toko Nyah Waing</strong> (nama lain Ibu Meliati), sampai sekarangpun terkadang pelanggan lama/masyarakat asli Karanganyar menyebutnya demikian."
                </div>
                <p>
                    <strong class="text-rose-700">Th 1982</strong> Bp Liem Kong Hong meninggal dunia, bisnis usaha dipegang sepunuhnya oleh Ibu Meliati dan dibantu putra putrinya (Ivan Purnomo dan Iin Salim).
                </p>
                <p>
                    Seiring dengan berjalannya waktu dan perubahan zaman, usaha inipun menjadi semacam toko grosiran sembako, dimana dari desa desa kecil di Karanganyar dan sekitar membeli barang dagangan di tempat ini untuk dijual kembali di daerah/kampung/rumah masing masing.
                </p>
                <p>
                    Oleh <strong>Bp. Ivan Purnomo</strong> usaha ini diberi nama/brand <strong>Toko Utama</strong>. Barang barang yang dijualpun semakin bervariasi selain menyediakan 9 bahan pokok juga menyediakan barang barang consumer good lainnya (snack, roti, kerupuk, minuman kemasan, kopi, rokok dll) sesuai permintaan pasar.
                </p>
                <p>
                    Di tahun 1990an permintaan produk rokok semakin meningkat, perputaran di barang dagangan ini meningkat pesat sehingga produk rokok di toko ini mencapai 40% dari seluruh produk yg lain yang dijual. Toko ini menjadi dikenal sebagai toko grosir rokok besar utk wilayah Karanganyar sampai sekarang.
                </p>
                <p>
                    Toko Utama sebagai toko Grosiran semakin hari juga semakin menghadapi tantangan dari pesaing pesaing usaha sejenis. Untuk itu toko Utama berusaha keras untuk tetap bisa eksis dalam pelayanan dan harga yang ditawarkan, sesuai dengan motto selama ini:
                </p>
                <ul class="space-y-2 mt-2 font-bold text-rose-700 list-none">
                    <li class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Melayani dan untung bersama
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Selalu baru dan lebih murah/miring harga
                    </li>
                </ul>
            </div>
        </div>
    </section>

    {{-- ========================================== --}}
    {{-- BAGIAN 2.5: EVENT GALLERY (SISIPAN BARU) --}}
    {{-- ========================================== --}}
    <section class="bg-white py-16 border-t border-slate-100">
        <div class="container mx-auto px-6">
            
            <div class="text-center mb-10">
                <span class="text-rose-600 font-bold tracking-wider uppercase text-xs">Our Journey</span>
                <h2 class="text-3xl font-bold text-slate-900 mt-1">Momen Berharga</h2>
                <div class="w-16 h-1 bg-rose-600 mx-auto rounded-full mt-3"></div>
            </div>

            {{-- AMBIL DATA LANGSUNG DARI MODEL (Cara Cepat Tanpa Ubah Controller) --}}
            @php
                // Mengambil data event dari database yang sudah di-seed
                $events = \App\Models\Event::orderBy('event_date', 'desc')->get();
            @endphp

            @if($events->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($events as $event)
                                @php
                                    $imageUrl = null;
                                    // Prefer storage disk 'public' (storage/app/public/events -> public/storage/events after storage:link)
                                    if ($event->image && \Illuminate\Support\Facades\Storage::disk('public')->exists('events/' . $event->image)) {
                                        $imageUrl = \Illuminate\Support\Facades\Storage::url('events/' . $event->image);
                                    }

                                    if (! $imageUrl) {
                                        $imageUrl = 'https://ui-avatars.com/api/?name=' . urlencode($event->title) . '&background=111827&color=fff&size=1024';
                                    }
                                @endphp

                        <div class="group relative overflow-hidden rounded-2xl shadow-lg cursor-pointer h-72"
                             onclick="openModal('{{ $imageUrl }}', '{{ $event->title }}', '{{ $event->location }}', '{{ \Carbon\Carbon::parse($event->event_date)->isoFormat('D MMMM Y') }}', '{{ $event->description }}')">
                            
                            {{-- Gambar --}}
                               <img src="{{ $imageUrl }}" 
                                   alt="{{ $event->title }}" 
                                   class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500">
                            
                            {{-- Overlay --}}
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-6">
                                <span class="text-rose-400 text-xs font-bold uppercase tracking-wider mb-1">
                                    {{ \Carbon\Carbon::parse($event->event_date)->year }}
                                </span>
                                <h3 class="text-white font-bold text-lg leading-tight">{{ $event->title }}</h3>
                                <p class="text-gray-300 text-sm flex items-center gap-1 mt-1">
                                    📍 {{ $event->location }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-10 bg-slate-50 rounded-xl">
                    <p class="text-slate-500">Belum ada foto dokumentasi.</p>
                </div>
            @endif

        </div>
    </section>

    {{-- MODAL POPUP (HTML untuk Lightbox) --}}
    <div id="imageModal" class="fixed inset-0 z-50 hidden bg-black/95 backdrop-blur-sm flex items-center justify-center p-4 transition-opacity duration-300">
        <button onclick="closeModal()" class="absolute top-6 right-6 text-white hover:text-rose-500 transition z-50">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <div class="max-w-5xl w-full bg-white rounded-2xl overflow-hidden flex flex-col md:flex-row shadow-2xl animate-fade-in-up">
            <div class="w-full md:w-2/3 bg-black flex items-center justify-center relative">
                <img id="modalImage" src="" class="max-h-[80vh] w-auto object-contain">
            </div>
            <div class="w-full md:w-1/3 p-8 flex flex-col justify-center bg-white border-l border-slate-100">
                <span id="modalDate" class="text-rose-600 font-bold text-sm tracking-widest uppercase mb-2">DATE</span>
                <h3 id="modalTitle" class="text-2xl font-extrabold text-slate-800 mb-4 leading-tight">Title</h3>
                <div class="flex items-start gap-2 text-slate-500 mb-4">
                    <span>📍</span>
                    <p id="modalLocation" class="text-sm font-medium">Location</p>
                </div>
                <p id="modalDesc" class="text-slate-600 text-sm leading-relaxed italic border-t pt-4 border-slate-100">
                    Description...
                </p>
            </div>
        </div>
    </div>

    {{-- SCRIPT POPUP --}}
    <script>
        function openModal(imageSrc, title, location, date, desc) {
            document.getElementById('modalImage').src = imageSrc;
            document.getElementById('modalTitle').innerText = title;
            document.getElementById('modalLocation').innerText = location;
            document.getElementById('modalDate').innerText = date;
            document.getElementById('modalDesc').innerText = desc ? desc : "Tidak ada deskripsi.";
            
            document.getElementById('imageModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('imageModal').classList.add('hidden');
        }

        // Close on click outside
        document.getElementById('imageModal').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });
        
        // Close on Esc key
        document.addEventListener('keydown', function(e) {
            if(e.key === "Escape") closeModal();
        });
    </script>


    {{-- ========================================== --}}
    {{-- BAGIAN 3: TIM KAMI (BIG ROLES) --}}
    {{-- ========================================== --}}
    <section class="bg-slate-50 py-20 border-t border-slate-200">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-slate-900">BIG ROLES</h2>
                <p class="text-slate-500 mt-2">Welcome to Toko Utama</p>
            </div>

            @php
                $bossTitles = ['Owner (Pemilik)', 'Co-Owner & Finance', 'Operational Manager'];

                // Filter: Ambil yang jabatannya ada di daftar Boss
                $leaders = $employees->filter(function($emp) use ($bossTitles) {
                    return in_array($emp->position, $bossTitles);
                });

                // Filter: Ambil sisanya (Staff biasa)
                $staff = $employees->reject(function($emp) use ($bossTitles) {
                    return in_array($emp->position, $bossTitles);
                });
            @endphp

            {{-- The Boss --}}
            @if($leaders->count() > 0)
                <div class="flex flex-wrap justify-center gap-8 mb-16">
                    @foreach($leaders as $emp)
                        <div class="w-full md:w-1/3 lg:w-1/4 bg-white rounded-2xl shadow-xl shadow-rose-100/50 hover:shadow-2xl transition duration-300 overflow-hidden group border-2 border-rose-100 transform hover:-translate-y-2">
                            
                            {{-- Foto Boss --}}
                            <div class="h-80 overflow-hidden bg-gray-200 relative">
                                @if($emp->image_photo)
                                    {{-- NOTE: Pastikan gambar ada di public/employee/ --}}
                                    <img src="{{ asset('employee/' . $emp->image_photo) }}" 
                                         alt="{{ $emp->name }}" 
                                         class="w-full h-full object-cover object-top group-hover:scale-105 transition duration-500">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($emp->name) }}&background=e11d48&color=fff&size=512" 
                                         class="w-full h-full object-cover">
                                @endif
                                
                                <div class="absolute top-4 right-4 bg-rose-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg">
                                    LEADERSHIP
                                </div>
                            </div>

                            <div class="p-6 text-center">
                                <h3 class="text-2xl font-bold text-slate-800 mb-1">{{ $emp->name }}</h3>
                                <p class="text-rose-600 font-bold text-sm uppercase tracking-wide mb-4">
                                    {{ $emp->position }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- Divider --}}
            @if($leaders->count() > 0 && $staff->count() > 0)
                <div class="w-full flex items-center justify-center mb-12 opacity-50">
                    <div class="h-px bg-slate-300 w-32"></div>
                    <span class="mx-4 text-slate-900 text-sm uppercase tracking-widest">Employee</span>
                    <div class="h-px bg-slate-300 w-32"></div>
                </div>
            @endif

            {{-- Staff Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @forelse($staff as $emp)
                    <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition duration-300 overflow-hidden group border border-slate-100">
                        <div class="h-64 overflow-hidden bg-gray-200 relative">
                            @if($emp->image_photo)
                                <img src="{{ asset('employee/' . $emp->image_photo) }}" 
                                     alt="{{ $emp->name }}" 
                                     class="w-full h-full object-cover object-top group-hover:scale-105 transition duration-500">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($emp->name) }}&background=64748b&color=fff&size=512" 
                                     class="w-full h-full object-cover">
                            @endif
                        </div>

                        <div class="p-6 text-center">
                            <h3 class="text-lg font-bold text-slate-800 mb-1">{{ $emp->name }}</h3>
                            <p class="text-slate-500 font-medium text-xs uppercase tracking-wide mb-4">
                                {{ $emp->position }}
                            </p>
                        </div>
                    </div>
                @empty
                    @if($leaders->count() == 0)
                        <div class="col-span-full text-center py-10">
                            <p class="text-slate-500 italic">Belum ada data karyawan.</p>
                        </div>
                    @endif
                @endforelse
            </div>

        </div>
    </section>

@endsection