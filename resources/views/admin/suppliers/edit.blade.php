@extends('layouts.admin')

@section('page-title')
    Edit Supplier
@endsection

@section('content')
    {{-- TAMBAHAN: 'mx-auto' biar form-nya ke tengah --}}
    <div class="max-w-2xl mx-auto">

        {{-- FORM EDIT SUPPLIER --}}
        <div class="bg-white p-8 rounded-xl shadow-md border border-gray-200">
            <form action="{{ route('admin.suppliers.update', $supplier) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Nama Supplier --}}
                <div class="mb-6">
                    <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Nama Supplier <span class="text-red-500">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name', $supplier->name) }}" 
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
                    <input type="tel" id="phone" name="phone" value="{{ old('phone', $supplier->phone) }}" 
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
                        class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#A41025] focus:border-transparent @error('address') border-red-500 @enderror">{{ old('address', $supplier->address) }}</textarea>
                    @error('address')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tombol Submit & Kembali --}}
                <div class="flex gap-3 pt-4 border-t border-gray-100">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg font-bold hover:bg-blue-700 transition shadow-md">
                        Update Supplier
                    </button>
                    <a href="{{ route('admin.suppliers.index') }}" class="bg-gray-100 text-gray-600 px-6 py-2.5 rounded-lg font-bold hover:bg-gray-200 transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection