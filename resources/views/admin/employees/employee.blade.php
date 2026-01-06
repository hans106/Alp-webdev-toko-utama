@extends('layouts.admin')

@section('title', 'Select Your Employee')

@section('content')
    {{-- Pastikan Alpine.js dimuat --}}
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
            background: #E1B56A; /* Gold Scrollbar */
            border-radius: 10px;
        }
        .hide-scroll::-webkit-scrollbar-thumb:hover {
            background: #800000; /* Maroon on Hover */
        }
    </style>

    {{-- Main Container --}}
    <div x-data="{ showModal: false, editMode: false, currentEmployee: {} }" class="flex flex-col h-[calc(100vh-100px)]">

        {{-- HEADER (Premium Style) --}}
        <div class="mb-8 px-1">
            <div class="flex flex-col md:flex-row justify-between items-end gap-4">
                <div>
                    <h1 class="text-4xl font-serif font-bold text-[#800000] tracking-wide">
                        <span class="text-[#E1B56A] font-sans font-light">Select Your</span> Employee
                    </h1>
                    <div class="h-1.5 w-32 bg-gradient-to-r from-[#800000] to-[#E1B56A] mt-2 mb-2 rounded-full"></div>
                    <p class="text-slate-600 text-sm">Geser ke kanan untuk memilih personel tim Anda.</p>
                </div>
                
                {{-- Legend / Status Indicator --}}
                <div class="flex gap-4 text-xs font-bold uppercase tracking-widest text-slate-400">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-emerald-500 shadow-[0_0_10px_rgba(16,185,129,0.5)]"></span> Active
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

        {{-- SCROLL AREA (CHARACTER SELECTION) --}}
        <div class="flex-1 overflow-x-auto hide-scroll pb-12 pt-4 px-2 flex items-center gap-8">

            {{-- 1. KARTU RECRUIT NEW (Premium Dashed) --}}
            <div @click="showModal = true; editMode = false; currentEmployee = {}"
                class="group min-w-[280px] h-[480px] border-2 border-dashed border-[#E1B56A]/50 bg-[#FDFBF7] rounded-3xl flex flex-col items-center justify-center cursor-pointer hover:border-[#800000] hover:bg-[#800000]/5 transition-all duration-300 transform hover:-translate-y-2 hover:shadow-[0_20px_40px_-15px_rgba(128,0,0,0.2)] relative shrink-0">
                
                <div class="w-24 h-24 bg-white border border-[#E1B56A]/30 rounded-full flex items-center justify-center mb-6 group-hover:scale-110 group-hover:border-[#800000] transition-all duration-300 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-[#E1B56A] group-hover:text-[#800000] transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
                <h3 class="text-2xl font-serif font-bold text-[#800000] group-hover:text-[#600000]">Recruit New</h3>
                <p class="text-xs font-bold uppercase tracking-widest text-[#E1B56A] mt-2">Tambah Personel</p>
            </div>

            {{-- 2. LOOPING KARTU PEGAWAI --}}
            @forelse($employees as $emp)
                <div class="group relative min-w-[300px] h-[480px] bg-slate-900 rounded-3xl shadow-2xl overflow-hidden flex-shrink-0 transform transition-all duration-500 hover:-translate-y-4 hover:shadow-[0_25px_50px_-12px_rgba(128,0,0,0.5)] border border-[#E1B56A]/20">

                    {{-- Foto Background (NATURAL COLOR) --}}
                    <div class="absolute inset-0 z-0">
                        @if ($emp->image_photo)
                            {{-- Opacity dihapus agar foto cerah alami --}}
                            <img src="{{ asset('employee/' . $emp->image_photo) }}"
                                class="w-full h-full object-cover object-top scale-100 group-hover:scale-110 transition-transform duration-700 ease-in-out">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($emp->name) }}&background=random&size=512"
                                class="w-full h-full object-cover object-top scale-100 group-hover:scale-110 transition-transform duration-700 ease-in-out">
                        @endif
                        
                        {{-- Gradient Overlay (UBAH JADI HITAM NETRAL AGAR FOTO ASLI) --}}
                        {{-- Hanya menggelapkan bagian bawah agar teks putih terbaca --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent opacity-80 group-hover:opacity-100 transition-opacity duration-500"></div>
                        
                        {{-- Top Highlight Line (Tetap Emas) --}}
                        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-transparent via-[#E1B56A] to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    </div>

                    {{-- Status Badge --}}
                    <div class="absolute top-5 right-5 z-20">
                        <div class="bg-black/30 backdrop-blur-md border border-[#E1B56A]/50 text-[#E1B56A] text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider shadow-lg flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            Active
                        </div>
                    </div>

                    {{-- Info Pegawai (Bottom) --}}
                    <div class="absolute bottom-0 left-0 w-full p-8 z-20 flex flex-col justify-end h-full">
                        <div class="transform translate-y-12 group-hover:translate-y-0 transition-transform duration-500 ease-out">
                            
                            {{-- Jabatan --}}
                            <p class="text-[#E1B56A] font-bold text-xs uppercase tracking-[0.2em] mb-2 drop-shadow-md border-l-2 border-[#E1B56A] pl-2">
                                {{ $emp->position }}
                            </p>
                            
                            {{-- Nama --}}
                            <h2 class="text-3xl font-serif font-bold text-white leading-none mb-3 drop-shadow-lg">
                                {{ $emp->name }}
                            </h2>
                            
                            {{-- Kontak --}}
                            <p class="text-slate-300 text-sm flex items-center gap-2 mb-6 opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-100">
                                <svg class="w-4 h-4 text-[#E1B56A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                {{ $emp->phone ?? '-' }}
                            </p>

                            {{-- Tombol Aksi (Tetap Premium Maroon/Gold) --}}
                            <div class="flex gap-3 opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-150">
                                <button @click="showModal = true; editMode = true; currentEmployee = {{ $emp }}"
                                    class="flex-1 bg-white hover:bg-[#E1B56A] text-[#800000] hover:text-white font-bold py-2.5 rounded-lg text-xs uppercase tracking-wide transition-all shadow-lg border border-white">
                                    Edit
                                </button>
                                <form action="{{ route('admin.employees.destroy', $emp->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin memecat pegawai ini?');" class="flex-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="w-full bg-[#800000] hover:bg-red-900 text-white font-bold py-2.5 rounded-lg text-xs uppercase tracking-wide transition-colors shadow-lg border border-[#800000]">
                                        Delete
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
                            <svg class="w-8 h-8 text-[#800000]/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                        <p class="text-slate-500 italic">Belum ada pegawai direkrut.</p>
                    </div>
                </div>
            @endforelse
            
            {{-- Spacer Kanan --}}
            <div class="min-w-[50px]"></div>
        </div>

        {{-- MODAL FORM (Premium Style - Tetap Sama) --}}
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
                <div class="bg-white rounded-2xl shadow-[0_0_50px_rgba(225,181,106,0.2)] w-full max-w-md p-0 overflow-hidden relative z-10 border border-[#E1B56A]/30 transform scale-100 transition-all">
                    
                    {{-- Modal Header --}}
                    <div class="bg-[#800000] p-6 text-center relative overflow-hidden">
                        <div class="absolute -right-6 -top-6 w-24 h-24 bg-[#E1B56A]/20 rounded-full blur-xl"></div>
                        <div class="absolute -left-6 -bottom-6 w-24 h-24 bg-[#E1B56A]/20 rounded-full blur-xl"></div>
                        
                        <h2 class="text-2xl font-serif font-bold text-white relative z-10" x-text="editMode ? 'Edit Profile' : 'New Recruit'"></h2>
                        <p class="text-[#E1B56A] text-xs uppercase tracking-widest mt-1 relative z-10">Employee Management</p>
                    </div>

                    {{-- Form --}}
                    <div class="p-8">
                        <form method="POST"
                            :action="editMode ? '{{ url('admin/employees') }}/' + currentEmployee.id : '{{ route('admin.employees.store') }}'"
                            enctype="multipart/form-data">
                            @csrf
                            <template x-if="editMode">
                                <input type="hidden" name="_method" value="PUT">
                            </template>

                            <div class="space-y-5">
                                <div>
                                    <label class="block text-xs font-bold text-[#800000] uppercase mb-1 ml-1">Nama Lengkap</label>
                                    <input type="text" name="name" :value="currentEmployee.name" required placeholder="Ex: John Doe"
                                        class="w-full bg-[#FDFBF7] border border-slate-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-[#800000] focus:border-[#800000] outline-none text-slate-800 font-medium transition-all">
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-[#800000] uppercase mb-1 ml-1">Jabatan</label>
                                    <input type="text" name="position" :value="currentEmployee.position" required placeholder="Ex: Manager"
                                        class="w-full bg-[#FDFBF7] border border-slate-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-[#800000] focus:border-[#800000] outline-none text-slate-800 font-medium transition-all">
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-[#800000] uppercase mb-1 ml-1">No HP</label>
                                    <input type="text" name="phone" :value="currentEmployee.phone" required placeholder="0812..."
                                        class="w-full bg-[#FDFBF7] border border-slate-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-[#800000] focus:border-[#800000] outline-none text-slate-800 font-medium transition-all">
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-[#800000] uppercase mb-1 ml-1">Foto Profil</label>
                                    <div class="relative">
                                        <input type="file" name="image_photo" accept="image/*"
                                            class="w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-[#800000]/10 file:text-[#800000] hover:file:bg-[#800000]/20 transition-all border border-slate-200 rounded-lg p-1 bg-[#FDFBF7]">
                                    </div>
                                    <p class="text-[10px] text-slate-400 mt-1 ml-1 italic">*Biarkan kosong jika tidak ingin mengubah foto</p>
                                </div>
                            </div>

                            <div class="flex justify-end gap-3 pt-8 mt-4 border-t border-dashed border-slate-200">
                                <button type="button" @click="showModal = false"
                                    class="px-6 py-2.5 text-slate-500 hover:text-slate-800 hover:bg-slate-50 rounded-lg text-sm font-bold transition-all">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="px-6 py-2.5 bg-gradient-to-r from-[#800000] to-[#600000] text-white rounded-lg hover:shadow-lg font-bold text-sm transition-all flex items-center gap-2 border border-[#800000]">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Simpan Data
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection