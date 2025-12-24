@extends('layouts.admin')

@section('page-title')
    Tambah Supplier Baru
@endsection

@section('content')
    <div class="max-w-2xl">
        {{-- FORM TAMBAH SUPPLIER --}}
        <div class="bg-white p-8 rounded-xl shadow-md border border-gray-200">
        <form action="{{ route('admin.suppliers.store') }}" method="POST">
            @csrf

            {{-- Nama Supplier --}}
            <div class="mb-6">
                <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Nama Supplier <span class="text-red-500">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" 
                    placeholder="Contoh: PT. Sumber Dagang"
                    class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#A41025] focus:border-transparent @error('name') border-red-500 @enderror"
                    required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Telepon --}}
            <div class="mb-6">
                <label for="phone" class="block text-sm font-bold text-gray-700 mb-2">Telepon</label>
                <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" 
                    placeholder="Contoh: 081234567890"
                    class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#A41025] focus:border-transparent @error('phone') border-red-500 @enderror">
                @error('phone')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Alamat --}}
            <div class="mb-6">
                <label for="address" class="block text-sm font-bold text-gray-700 mb-2">Alamat</label>
                <textarea id="address" name="address" rows="4" 
                    placeholder="Contoh: Jl. Merdeka No.10, Jakarta"
                    class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#A41025] focus:border-transparent @error('address') border-red-500 @enderror">{{ old('address') }}</textarea>
                @error('address')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tombol Submit & Kembali --}}
            <div class="flex gap-3">
                <button type="submit" class="bg-green-600 text-white px-6 py-2.5 rounded-lg font-bold hover:bg-green-700 transition shadow-md">
                    Simpan Supplier
                </button>
                <a href="{{ route('admin.suppliers.index') }}" class="bg-gray-300 text-gray-700 px-6 py-2.5 rounded-lg font-bold hover:bg-gray-400 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection
