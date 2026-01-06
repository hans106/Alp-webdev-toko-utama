@extends('layouts.admin')

@section('title', 'Manage Events')

@section('content')
    {{-- Alpine JS --}}
    @once
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @endonce

    <style>
        /* Custom Scrollbar Premium - Maroon/Gold Theme */
        .hide-scroll::-webkit-scrollbar {
            height: 8px;
        }
        .hide-scroll::-webkit-scrollbar-track {
            background: #FDFBF7;
            border-radius: 10px;
        }
        .hide-scroll::-webkit-scrollbar-thumb {
            background: #E1B56A;
            border-radius: 10px;
        }
        .hide-scroll::-webkit-scrollbar-thumb:hover {
            background: #800000;
        }
    </style>

    <div x-data="{ showModal: false, editMode: false, currentEvent: {} }" class="flex flex-col h-[calc(100vh-100px)]">

        {{-- HEADER (Premium Style) --}}
        <div class="mb-8 px-1">
            <div class="flex flex-col md:flex-row justify-between items-end gap-4">
                <div>
                    <h1 class="text-4xl font-serif font-bold text-[#800000] tracking-wide">
                        <span class="text-[#E1B56A] font-sans font-light">Upcoming</span> Events
                    </h1>
                    <div class="h-1.5 w-32 bg-gradient-to-r from-[#800000] to-[#E1B56A] mt-2 mb-2 rounded-full"></div>
                    <p class="text-slate-600 text-sm">Kelola jadwal acara dan kegiatan eksklusif.</p>
                </div>

                {{-- Legend / Status --}}
                <div class="flex gap-4 text-xs font-bold uppercase tracking-widest text-slate-400">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-[#E1B56A] animate-pulse"></span> Scheduled
                    </div>
                </div>
            </div>
        </div>

        {{-- ALERT SUKSES --}}
        @if (session('success'))
            <div class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded-r-lg shadow-sm flex items-center gap-3 animate-fade-in-down">
                <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <p class="font-bold text-sm uppercase tracking-wide">Sukses</p>
                    <p class="text-sm">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        {{-- SCROLL AREA --}}
        <div class="flex-1 overflow-x-auto hide-scroll pb-12 pt-4 px-2 flex items-center gap-8">

            {{-- 1. KARTU ADD EVENT (Premium Dashed) --}}
            <div @click="showModal = true; editMode = false; currentEvent = {}"
                class="group min-w-[300px] h-[480px] border-2 border-dashed border-[#E1B56A]/50 bg-[#FDFBF7] rounded-3xl flex flex-col items-center justify-center cursor-pointer hover:border-[#800000] hover:bg-[#800000]/5 transition-all duration-300 transform hover:-translate-y-2 hover:shadow-[0_20px_40px_-15px_rgba(128,0,0,0.2)] relative shrink-0">
                
                <div class="w-24 h-24 bg-white border border-[#E1B56A]/30 rounded-full flex items-center justify-center mb-6 group-hover:scale-110 group-hover:border-[#800000] transition-all duration-300 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-[#E1B56A] group-hover:text-[#800000] transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
                <h3 class="text-2xl font-serif font-bold text-[#800000] group-hover:text-[#600000]">New Event</h3>
                <p class="text-xs font-bold uppercase tracking-widest text-[#E1B56A] mt-2">Buat Jadwal Baru</p>
            </div>

            {{-- 2. LOOPING KARTU EVENT --}}
            @forelse($events as $event)
                <div class="group relative min-w-[320px] h-[480px] bg-[#2B0A0A] rounded-3xl shadow-2xl overflow-hidden flex-shrink-0 transform transition-all duration-500 hover:-translate-y-4 hover:shadow-[0_25px_50px_-12px_rgba(128,0,0,0.5)] border border-[#E1B56A]/20">

                    {{-- Foto Banner (NATURAL COLOR) --}}
                    <div class="absolute inset-0 h-full w-full z-0 bg-slate-900">
                        @if ($event->image)
                            <img src="{{ asset('events/' . $event->image) }}" alt="{{ $event->title }}" 
                                class="h-full w-full object-cover object-center scale-100 group-hover:scale-110 transition-transform duration-700 ease-in-out">
                        @else
                            {{-- Placeholder Pattern jika tidak ada gambar --}}
                            <div class="h-full w-full bg-[#2B0A0A] flex items-center justify-center relative overflow-hidden">
                                <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#E1B56A 1px, transparent 1px); background-size: 20px 20px;"></div>
                                <span class="text-[#E1B56A]/30 text-4xl font-serif font-bold">Event</span>
                            </div>
                        @endif

                        {{-- Gradient Overlay (Hitam Natural agar teks terbaca) --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/50 to-transparent opacity-90 group-hover:opacity-100 transition-opacity duration-500"></div>
                        
                        {{-- Top Highlight Line (Gold) --}}
                        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-transparent via-[#E1B56A] to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    </div>

                    {{-- Tanggal Badge (Glassmorphism Gold) --}}
                    <div class="absolute top-5 left-5 z-20">
                        <div class="bg-black/40 backdrop-blur-md border border-[#E1B56A]/60 text-white text-center px-4 py-3 rounded-2xl shadow-lg group-hover:bg-[#800000]/80 group-hover:border-[#E1B56A] transition-colors duration-300">
                            <p class="text-[10px] uppercase font-bold tracking-widest text-[#E1B56A] mb-1">
                                {{ \Carbon\Carbon::parse($event->event_date)->format('M') }}
                            </p>
                            <p class="text-3xl font-serif font-bold leading-none text-white">
                                {{ \Carbon\Carbon::parse($event->event_date)->format('d') }}
                            </p>
                        </div>
                    </div>

                    {{-- Info Event (Bottom) --}}
                    <div class="absolute bottom-0 left-0 w-full p-8 z-20 flex flex-col justify-end h-full">
                        <div class="transform translate-y-12 group-hover:translate-y-0 transition-transform duration-500 ease-out">
                            
                            {{-- Lokasi --}}
                            <div class="flex items-center gap-2 mb-3 text-[#E1B56A] text-xs font-bold uppercase tracking-widest drop-shadow-md">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                {{ $event->location }}
                            </div>

                            {{-- Judul --}}
                            <h2 class="text-2xl font-serif font-bold text-white leading-tight mb-3 drop-shadow-lg line-clamp-2">
                                {{ $event->title }}
                            </h2>

                            {{-- Deskripsi --}}
                            <p class="text-slate-300 text-sm mb-6 line-clamp-2 opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-100 font-light leading-relaxed">
                                {{ $event->description ?? 'No description available.' }}
                            </p>

                            {{-- Tombol Aksi --}}
                            <div class="flex gap-3 opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-150">
                                <button @click="showModal = true; editMode = true; currentEvent = {{ $event }}"
                                    class="flex-1 bg-white hover:bg-[#E1B56A] text-[#800000] hover:text-white font-bold py-2.5 rounded-lg text-xs uppercase tracking-wide transition-all shadow-lg border border-white">
                                    Edit
                                </button>
                                <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST"
                                    onsubmit="return confirm('Hapus event ini?');" class="flex-1">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="w-full bg-[#800000] hover:bg-red-900 text-white font-bold py-2.5 rounded-lg text-xs uppercase tracking-wide transition-colors shadow-lg border border-[#800000]">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="flex items-center justify-center h-[450px] px-10 border border-[#E1B56A]/20 rounded-3xl bg-[#FDFBF7]">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-[#800000]/10 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-[#800000]/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <p class="text-slate-500 italic">Belum ada agenda event.</p>
                    </div>
                </div>
            @endforelse
            
            {{-- Spacer Kanan --}}
            <div class="min-w-[50px]"></div>
        </div>

        {{-- MODAL FORM (Premium Style) --}}
        <div x-show="showModal" style="display: none;" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 overflow-y-auto">
             
            {{-- Backdrop --}}
            <div class="fixed inset-0 bg-[#2B0A0A]/90 backdrop-blur-sm" @click="showModal = false"></div>

            {{-- Modal Content --}}
            <div class="relative flex items-center justify-center min-h-screen p-4">
                <div class="bg-white rounded-2xl shadow-[0_0_50px_rgba(225,181,106,0.2)] w-full max-w-lg p-0 overflow-hidden relative z-10 border border-[#E1B56A]/30 transform scale-100 transition-all">
                    
                    {{-- Modal Header --}}
                    <div class="bg-[#800000] p-6 text-center relative overflow-hidden">
                        <div class="absolute -right-6 -top-6 w-24 h-24 bg-[#E1B56A]/20 rounded-full blur-xl"></div>
                        <div class="absolute -left-6 -bottom-6 w-24 h-24 bg-[#E1B56A]/20 rounded-full blur-xl"></div>
                        
                        <h2 class="text-2xl font-serif font-bold text-white relative z-10" x-text="editMode ? 'Edit Event' : 'Create Event'"></h2>
                        <p class="text-[#E1B56A] text-xs uppercase tracking-widest mt-1 relative z-10">Agenda Management</p>
                    </div>

                    {{-- Form --}}
                    <div class="p-8">
                        <form method="POST"
                            :action="editMode ? '{{ url('admin/events') }}/' + currentEvent.id : '{{ route('admin.events.store') }}'"
                            enctype="multipart/form-data">
                            @csrf
                            <template x-if="editMode">
                                <input type="hidden" name="_method" value="PUT">
                            </template>

                            <div class="space-y-5">
                                {{-- Judul --}}
                                <div>
                                    <label class="block text-xs font-bold text-[#800000] uppercase mb-1 ml-1">Judul Event</label>
                                    <input type="text" name="title" :value="currentEvent.title" required placeholder="Ex: Annual Gala Dinner"
                                        class="w-full bg-[#FDFBF7] border border-slate-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-[#800000] focus:border-[#800000] outline-none text-slate-800 font-medium transition-all">
                                </div>

                                {{-- Grid --}}
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold text-[#800000] uppercase mb-1 ml-1">Tanggal</label>
                                        <input type="date" name="event_date"
                                            :value="currentEvent.event_date ? currentEvent.event_date.split('T')[0] : ''" required
                                            class="w-full bg-[#FDFBF7] border border-slate-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-[#800000] focus:border-[#800000] outline-none text-slate-800 font-medium transition-all">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-[#800000] uppercase mb-1 ml-1">Lokasi</label>
                                        <input type="text" name="location" :value="currentEvent.location" required placeholder="Ex: Main Hall"
                                            class="w-full bg-[#FDFBF7] border border-slate-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-[#800000] focus:border-[#800000] outline-none text-slate-800 font-medium transition-all">
                                    </div>
                                </div>

                                {{-- Deskripsi --}}
                                <div>
                                    <label class="block text-xs font-bold text-[#800000] uppercase mb-1 ml-1">Deskripsi</label>
                                    <textarea name="description" rows="3" x-model="currentEvent.description" placeholder="Detail acara..."
                                        class="w-full bg-[#FDFBF7] border border-slate-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-[#800000] focus:border-[#800000] outline-none text-slate-800 font-medium transition-all resize-none"></textarea>
                                </div>

                                {{-- Upload --}}
                                <div>
                                    <label class="block text-xs font-bold text-[#800000] uppercase mb-1 ml-1">Banner Image</label>
                                    <div class="relative">
                                        <input type="file" name="image" accept="image/*"
                                            class="w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-[#800000]/10 file:text-[#800000] hover:file:bg-[#800000]/20 transition-all border border-slate-200 rounded-lg p-1 bg-[#FDFBF7]">
                                    </div>
                                </div>
                            </div>

                            {{-- Footer --}}
                            <div class="flex justify-end gap-3 pt-8 mt-4 border-t border-dashed border-slate-200">
                                <button type="button" @click="showModal = false"
                                    class="px-6 py-2.5 text-slate-500 hover:text-slate-800 hover:bg-slate-50 rounded-lg text-sm font-bold transition-all">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="px-6 py-2.5 bg-gradient-to-r from-[#800000] to-[#600000] text-white rounded-lg hover:shadow-lg font-bold text-sm transition-all flex items-center gap-2 border border-[#800000]">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Simpan Event
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection