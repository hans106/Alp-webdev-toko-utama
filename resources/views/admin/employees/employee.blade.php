@extends('layouts.admin')

@section('title', 'Select Your Character')

@section('content')
    {{-- Pastikan Alpine.js dimuat (kalau di layout belum ada) --}}
    @once
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @endonce

    <style>
        /* Sembunyikan scrollbar tapi tetap bisa di-scroll */
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

    <div x-data="{ showModal: false, editMode: false, currentEmployee: {} }" class="min-h-screen flex flex-col">

        {{-- HEADER --}}
        <div class="mb-6 px-4">
            <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">
                <span class="text-blue-600">Select</span> Your Employee
            </h1>
            <p class="text-slate-500 text-sm">Geser ke kanan untuk melihat seluruh tim.</p>
        </div>

        {{-- ALERT SUKSES --}}
        @if (session('success'))
            <div class="mx-4 mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm">
                <p class="font-bold">Sukses!</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        {{-- SCROLL AREA --}}
        <div class="flex-1 overflow-x-auto hide-scroll pb-12 px-4 flex items-center gap-6">

            {{-- 1. KARTU RECRUIT NEW --}}
            <div @click="showModal = true; editMode = false; currentEmployee = {}"
                class="group min-w-[280px] h-[450px] border-4 border-dashed border-slate-300 rounded-3xl flex flex-col items-center justify-center cursor-pointer hover:border-blue-500 hover:bg-blue-50 transition-all duration-300 transform hover:-translate-y-2 relative flex-shrink-0">
                <div
                    class="w-20 h-20 bg-slate-200 text-slate-400 rounded-full flex items-center justify-center mb-4 group-hover:bg-blue-500 group-hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-400 group-hover:text-blue-600">Recruit New</h3>
                <p class="text-sm text-slate-400">Tambah Pegawai</p>
            </div>

            {{-- 2. LOOPING KARTU PEGAWAI --}}
            @forelse($employees as $emp)
                <div
                    class="relative min-w-[300px] h-[450px] bg-white rounded-3xl shadow-xl overflow-hidden flex-shrink-0 transform transition-all duration-300 hover:-translate-y-4 hover:shadow-2xl border border-slate-100 group">

                    {{-- Foto Background --}}
                    <div class="absolute inset-0 bg-slate-800">
                        @if ($emp->image_photo)
                            {{-- KODE BARU: Langsung ambil dari folder public/employee --}}
                            <img src="{{ asset('employee/' . $emp->image_photo) }}"
                                class="w-full h-full object-cover opacity-80 group-hover:opacity-100 transition-opacity">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($emp->name) }}&background=random&size=512"
                                class="w-full h-full object-cover opacity-80">
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-90">
                        </div>
                    </div>

                    {{-- Status Badge --}}
                    <div
                        class="absolute top-4 right-4 bg-white/20 backdrop-blur-md border border-white/30 text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                        Active
                    </div>

                    {{-- Info Pegawai --}}
                    <div class="absolute bottom-0 left-0 w-full p-6 text-white">
                        <p class="text-blue-300 font-bold text-xs uppercase tracking-widest mb-1">{{ $emp->position }}</p>
                        <h2 class="text-2xl font-extrabold leading-tight mb-2">{{ $emp->name }}</h2>
                        <p class="text-slate-300 text-sm flex items-center gap-2 mb-4">
                            <span class="text-xs">📞</span> {{ $emp->phone ?? 'No Phone' }}
                        </p>

                        {{-- Tombol Aksi --}}
                        <div
                            class="flex gap-2 mt-4 translate-y-10 group-hover:translate-y-0 transition-transform duration-300 opacity-0 group-hover:opacity-100">
                            <button @click="showModal = true; editMode = true; currentEmployee = {{ $emp }}"
                                class="flex-1 bg-yellow-500 hover:bg-yellow-400 text-black font-bold py-2 rounded-lg text-sm transition-colors">
                                Edit
                            </button>
                            <form action="{{ route('admin.employees.destroy', $emp->id) }}" method="POST"
                                onsubmit="return confirm('Yakin ingin memecat pegawai ini?');" class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-full bg-red-600 hover:bg-red-500 text-white font-bold py-2 rounded-lg text-sm transition-colors">
                                    Pecat
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="flex items-center justify-center h-[450px] px-10 text-slate-400 italic">
                    Belum ada data pegawai...
                </div>
            @endforelse
            <div class="min-w-[50px]"></div>
        </div>

        {{-- MODAL FORM --}}
        <div x-show="showModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto">
            <div class="fixed inset-0 bg-black bg-opacity-70 transition-opacity backdrop-blur-sm"
                @click="showModal = false"></div>

            <div class="relative flex items-center justify-center min-h-screen p-4">
                <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6 relative z-10">
                    <h2 class="text-2xl font-bold mb-1 text-slate-800" x-text="editMode ? 'Edit Employee' : 'Recruit New'">
                    </h2>
                    <p class="text-slate-500 text-sm mb-6">Kelola data anggota tim.</p>

                    {{-- FORM START --}}
                    {{-- Logika: Action URL berubah dinamis pakai AlpineJS --}}
                    <form method="POST"
                        :action="editMode ? '{{ url('admin/employees') }}/' + currentEmployee.id :
                            '{{ route('admin.employees.store') }}'"
                        enctype="multipart/form-data">
                        @csrf
                        {{-- Input Hidden Method PUT untuk Edit --}}
                        <template x-if="editMode">
                            <input type="hidden" name="_method" value="PUT">
                        </template>

                        <div class="mb-4">
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Nama Lengkap</label>
                            <input type="text" name="name" :value="currentEmployee.name" required
                                class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>

                        <div class="mb-4">
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Jabatan</label>
                            <input type="text" name="position" :value="currentEmployee.position" required
                                class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>

                        <div class="mb-4">
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">No HP</label>
                            <input type="text" name="phone" :value="currentEmployee.phone" required
                                class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>

                        <div class="mb-6">
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Foto Profil</label>
                            <input type="file" name="image_photo" accept="image/*"
                                class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-blue-100 file:text-blue-700 hover:file:bg-blue-200">
                        </div>

                        <div class="flex justify-end gap-3 pt-4 border-t">
                            <button type="button" @click="showModal = false"
                                class="px-5 py-2.5 text-slate-600 hover:bg-slate-100 rounded-xl text-sm font-medium">Batal</button>
                            <button type="submit"
                                class="px-5 py-2.5 bg-blue-600 text-white rounded-xl hover:bg-blue-700 font-bold text-sm shadow-lg">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
