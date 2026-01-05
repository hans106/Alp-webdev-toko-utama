@extends('layouts.admin')

@section('title', 'Manage Events')

@section('content')
    {{-- Alpine JS --}}
    @once
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @endonce

    <style>
        /* Custom Scrollbar */
        .hide-scroll::-webkit-scrollbar {
            height: 8px;
        }

        .hide-scroll::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 10px;
        }

        .hide-scroll::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .hide-scroll::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>

    <div x-data="{ showModal: false, editMode: false, currentEvent: {} }" class="min-h-screen flex flex-col">

        {{-- HEADER --}}
        <div class="mb-6 px-4">
            <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">
                <span class="text-purple-600">Upcoming</span> Events
            </h1>
            <p class="text-slate-500 text-sm">Kelola jadwal acara dan kegiatan.</p>
        </div>

        {{-- ALERT SUKSES --}}
        @if (session('success'))
            <div class="mx-4 mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm">
                <p class="font-bold">Sukses!</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        {{-- SCROLL AREA (GRID KARTU) --}}
        <div class="flex-1 overflow-x-auto hide-scroll pb-12 px-4 flex items-center gap-6">

            {{-- 1. KARTU TAMBAH EVENT (Dashed Border) --}}
            <div @click="showModal = true; editMode = false; currentEvent = {}"
                class="group min-w-[300px] h-[450px] border-4 border-dashed border-slate-300 rounded-3xl flex flex-col items-center justify-center cursor-pointer hover:border-purple-500 hover:bg-purple-50 transition-all duration-300 transform hover:-translate-y-2 relative flex-shrink-0">
                <div
                    class="w-20 h-20 bg-slate-200 text-slate-400 rounded-full flex items-center justify-center mb-4 group-hover:bg-purple-500 group-hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-400 group-hover:text-purple-600">New Event</h3>
                <p class="text-sm text-slate-400">Buat Jadwal Baru</p>
            </div>

            {{-- 2. LOOPING KARTU EVENT --}}
            @forelse($events as $event)
                <div
                    class="relative min-w-[320px] h-[450px] bg-white rounded-3xl shadow-xl overflow-hidden flex-shrink-0 transform transition-all duration-300 hover:-translate-y-4 hover:shadow-2xl border border-slate-100 group">

                    {{-- Foto Banner --}}
                    <div class="absolute inset-0 bg-slate-800 h-full">

                        @if ($event->image)
                            {{-- Langsung ke folder events --}}
                            <img src="{{ asset('events/' . $event->image) }}" alt="{{ $event->title }}" class="h-full w-full object-cover object-top scale-105 -translate-y-2 transition-transform duration-500 group-hover:scale-110">
                        @else
                            {{-- Placeholder kalau gak ada gambar --}}
                            <div
                                class="h-16 w-16 bg-slate-100 rounded-lg flex items-center justify-center text-xs text-slate-400 border border-slate-200">
                                No Img
                            </div>
                        @endif

                        {{-- Overlay Gelap --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/60 to-transparent opacity-90">
                        </div>
                    </div>

                    {{-- Tanggal Badge (Pojok Kiri Atas) --}}
                    <div
                        class="absolute top-4 left-4 bg-white/20 backdrop-blur-md border border-white/30 text-white text-center px-3 py-2 rounded-xl shadow-lg">
                        <p class="text-xs uppercase font-bold tracking-wider">
                            {{ \Carbon\Carbon::parse($event->event_date)->format('M') }}
                        </p>
                        <p class="text-2xl font-extrabold leading-none">
                            {{ \Carbon\Carbon::parse($event->event_date)->format('d') }}
                        </p>
                    </div>

                    {{-- Info Event (Bagian Bawah) --}}
                    <div class="absolute bottom-0 left-0 w-full p-6 text-white">
                        {{-- Lokasi --}}
                        <div
                            class="flex items-center gap-2 mb-2 text-purple-300 text-xs font-bold uppercase tracking-wider">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            {{ $event->location }}
                        </div>

                        {{-- Judul --}}
                        <h2 class="text-2xl font-extrabold leading-tight mb-2 line-clamp-2">{{ $event->title }}</h2>

                        {{-- Deskripsi --}}
                        <p class="text-slate-300 text-sm mb-4 line-clamp-2">
                            {{ $event->description ?? 'Tidak ada deskripsi.' }}
                        </p>

                        {{-- Tombol Aksi --}}
                        <div
                            class="flex gap-2 mt-4 translate-y-10 group-hover:translate-y-0 transition-transform duration-300 opacity-0 group-hover:opacity-100">
                            {{-- Tombol Edit --}}
                            <button @click="showModal = true; editMode = true; currentEvent = {{ $event }}"
                                class="flex-1 bg-yellow-500 hover:bg-yellow-400 text-black font-bold py-2 rounded-lg text-sm transition-colors">
                                Edit
                            </button>
                            {{-- Form Delete --}}
                            <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST"
                                onsubmit="return confirm('Hapus event ini?');" class="flex-1">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="w-full bg-red-600 hover:bg-red-500 text-white font-bold py-2 rounded-lg text-sm transition-colors">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="flex items-center justify-center h-[450px] px-10 text-slate-400 italic">
                    Belum ada event terjadwal...
                </div>
            @endforelse
            <div class="min-w-[50px]"></div>
        </div>

        {{-- MODAL FORM (Create & Edit) --}}
        <div x-show="showModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto">
            <div class="fixed inset-0 bg-black bg-opacity-70 transition-opacity backdrop-blur-sm"
                @click="showModal = false"></div>

            <div class="relative flex items-center justify-center min-h-screen p-4">
                <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg p-6 relative z-10">
                    <h2 class="text-2xl font-bold mb-1 text-slate-800" x-text="editMode ? 'Edit Event' : 'Create Event'">
                    </h2>
                    <p class="text-slate-500 text-sm mb-6">Atur detail acara.</p>

                    <form method="POST"
                        :action="editMode ? '{{ url('admin/events') }}/' + currentEvent.id :
                            '{{ route('admin.events.store') }}'"
                        enctype="multipart/form-data">
                        @csrf
                        {{-- Method PUT untuk Update --}}
                        <template x-if="editMode">
                            <input type="hidden" name="_method" value="PUT">
                        </template>

                        {{-- Input Judul --}}
                        <div class="mb-4">
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Judul Event</label>
                            <input type="text" name="title" :value="currentEvent.title" required
                                class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 outline-none">
                        </div>

                        {{-- Grid Tanggal & Lokasi --}}
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Tanggal</label>
                                <input type="date" name="event_date"
                                    :value="currentEvent.event_date ? currentEvent.event_date.split('T')[0] : ''" required
                                    class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 outline-none">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Lokasi</label>
                                <input type="text" name="location" :value="currentEvent.location" required
                                    class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 outline-none">
                            </div>
                        </div>

                        {{-- Input Deskripsi --}}
                        <div class="mb-4">
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Deskripsi</label>
                            {{-- Fix: Textarea handling untuk AlpineJS --}}
                            <textarea name="description" rows="3" x-model="currentEvent.description"
                                class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 outline-none resize-none"></textarea>
                        </div>

                        {{-- Input Gambar --}}
                        <div class="mb-6">
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Banner (Opsional)</label>

                            {{-- PERUBAHAN: Ganti text-slate-500 jadi text-slate-900 --}}
                            <input type="file" name="image" accept="image/*"
                                class="w-full text-sm text-slate-900 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-purple-100 file:text-purple-700 hover:file:bg-purple-200">
                        </div>

                        {{-- Tombol Bawah --}}
                        <div class="flex justify-end gap-3 pt-4 border-t">
                            <button type="button" @click="showModal = false"
                                class="px-5 py-2.5 text-slate-600 hover:bg-slate-100 rounded-xl text-sm font-medium">Batal</button>
                            <button type="submit"
                                class="px-5 py-2.5 bg-purple-600 text-white rounded-xl hover:bg-purple-700 font-bold text-sm shadow-lg">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
