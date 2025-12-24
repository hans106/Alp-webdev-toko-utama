@extends('layouts.main')

@section('content')
<div class="container mx-auto px-4 py-8">
    
    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Detail Supplier</h1>
            <p class="text-gray-500 text-sm">Dashboard Admin / Supplier & Distributor / Lihat</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.suppliers.edit', $supplier) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg font-bold hover:bg-indigo-700 transition">
                Edit
            </a>
            <a href="{{ route('admin.suppliers.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-bold hover:bg-gray-300 transition">
                Kembali
            </a>
        </div>
    </div>

    {{-- ALERT SUKSES --}}
    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm" role="alert">
            <p class="font-bold">Berhasil!</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    {{-- DETAIL SUPPLIER --}}
    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-200">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Nama --}}
            <div>
                <label class="block text-sm font-bold text-gray-600 mb-2">Nama Supplier</label>
                <p class="text-lg font-bold text-gray-900">{{ $supplier->name }}</p>
            </div>

            {{-- Telepon --}}
            <div>
                <label class="block text-sm font-bold text-gray-600 mb-2">Telepon</label>
                <p class="text-lg text-gray-700">
                    @if($supplier->phone)
                        <a href="tel:{{ $supplier->phone }}" class="text-blue-600 hover:underline">{{ $supplier->phone }}</a>
                    @else
                        <span class="text-gray-400">-</span>
                    @endif
                </p>
            </div>

            {{-- Alamat --}}
            <div class="md:col-span-2">
                <label class="block text-sm font-bold text-gray-600 mb-2">Alamat</label>
                <p class="text-base text-gray-700 whitespace-pre-wrap">
                    @if($supplier->address)
                        {{ $supplier->address }}
                    @else
                        <span class="text-gray-400">-</span>
                    @endif
                </p>
            </div>

            {{-- Tanggal Dibuat --}}
            <div>
                <label class="block text-sm font-bold text-gray-600 mb-2">Dibuat Pada</label>
                <p class="text-sm text-gray-600">{{ $supplier->created_at->format('d/m/Y H:i') }}</p>
            </div>

            {{-- Tanggal Diperbarui --}}
            <div>
                <label class="block text-sm font-bold text-gray-600 mb-2">Diperbarui Pada</label>
                <p class="text-sm text-gray-600">{{ $supplier->updated_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>

        {{-- Tombol Hapus --}}
        <div class="mt-8 pt-6 border-t">
            <form action="{{ route('admin.suppliers.destroy', $supplier) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus supplier ini? Data restock yang terkait akan dihapus.');" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-red-700 transition">
                    Hapus Supplier
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
