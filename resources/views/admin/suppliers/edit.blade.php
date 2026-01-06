@extends('layouts.admin')

@section('page-title')
    Edit Supplier
@endsection

@section('content')
    <div class="max-w-2xl mx-auto mt-6">

        {{-- CARD CONTAINER --}}
        {{-- Perubahan: Shadow dipertebal (shadow-xl) dan rounded diperbesar --}}
        <div class="bg-white rounded-2xl shadow-xl border border-gray-300 overflow-hidden">

            {{-- HEADER SOLID (Baru) --}}
            {{-- Ini memberikan kesan tegas bahwa ini adalah form edit --}}
            <div class="bg-[#A41025] px-8 py-6 border-b border-red-800">
                <h2 class="text-white text-xl font-bold flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white/90" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit Data Supplier
                </h2>
                <p class="text-red-100 text-sm mt-1 ml-8">Perbarui informasi detail supplier di sini.</p>
            </div>

            {{-- FORM BODY --}}
            <div class="p-8 bg-white">
                <form action="{{ route('admin.suppliers.update', $supplier) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Nama Supplier --}}
                    <div class="mb-6">
                        <label for="name" class="block text-sm font-bold text-gray-800 mb-2">Nama Supplier <span class="text-red-600">*</span></label>
                        {{-- Perubahan: bg-gray-50 agar input terlihat padat (tidak tembus pandang) --}}
                        <input type="text" id="name" name="name" value="{{ old('name', $supplier->name) }}" 
                            placeholder="Contoh: PT. Sumber Dagang"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-gray-900 focus:bg-white focus:ring-2 focus:ring-[#A41025] focus:border-transparent transition-all @error('name') border-red-500 bg-red-50 @enderror"
                            required>
                        @error('name')
                            <p class="text-red-600 text-sm mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Telepon --}}
                    <div class="mb-6">
                        <label for="phone" class="block text-sm font-bold text-gray-800 mb-2">Telepon</label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone', $supplier->phone) }}" 
                            placeholder="Contoh: 081234567890"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-gray-900 focus:bg-white focus:ring-2 focus:ring-[#A41025] focus:border-transparent transition-all @error('phone') border-red-500 bg-red-50 @enderror">
                        @error('phone')
                            <p class="text-red-600 text-sm mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Alamat --}}
                    <div class="mb-8">
                        <label for="address" class="block text-sm font-bold text-gray-800 mb-2">Alamat</label>
                        <textarea id="address" name="address" rows="4" 
                            placeholder="Contoh: Jl. Merdeka No.10, Jakarta"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-gray-900 focus:bg-white focus:ring-2 focus:ring-[#A41025] focus:border-transparent transition-all @error('address') border-red-500 bg-red-50 @enderror">{{ old('address', $supplier->address) }}</textarea>
                        @error('address')
                            <p class="text-red-600 text-sm mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="flex items-center gap-4 border-t border-gray-100 pt-6">
                        <button type="submit" class="bg-[#A41025] text-white px-8 py-3 rounded-lg font-bold hover:bg-red-800 transition shadow-lg transform active:scale-95">
                            Simpan Perubahan
                        </button>
                        <a href="{{ route('admin.suppliers.index') }}" class="px-6 py-3 rounded-lg font-bold text-gray-600 hover:bg-gray-100 transition border border-gray-300 hover:border-gray-400">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection