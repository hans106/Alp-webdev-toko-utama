@extends('layouts.admin')

@section('page-title')
    Checklist Restock
@endsection

@section('content')
    <div class="max-w-2xl mx-auto">
    
    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Checklist Restock</h1>
            <p class="text-gray-500 text-sm">Dashboard Admin / Restock / Checklist</p>
        </div>
        <a href="{{ route('admin.restocks.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-bold hover:bg-gray-300 transition">
            Kembali
        </a>
    </div>

    {{-- ALERT SUKSES --}}
    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm" role="alert">
            <p class="font-bold">Berhasil!</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    {{-- ALERT ERROR --}}
    @if($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm" role="alert">
            <p class="font-bold">Terjadi Kesalahan!</p>
            <ul class="list-disc list-inside text-sm mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- CHECKLIST FORM --}}
    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-200">
        
        {{-- INFORMASI RESTOCK --}}
        <div class="mb-8">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Informasi Restock</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Produk --}}
                <div>
                    <label class="block text-sm font-bold text-gray-600 mb-2">Produk</label>
                    <div class="flex items-center gap-4">
                        @php
                            $imgSrc = null;
                            $imgPath = $restock->product->image_main ?? null;
                            if ($imgPath && preg_match('/^https?:\/\//i', $imgPath)) {
                                $imgSrc = $imgPath;
                            } elseif ($imgPath && file_exists(public_path($imgPath))) {
                                $imgSrc = asset($imgPath);
                            } elseif ($imgPath && file_exists(public_path('products/' . $imgPath))) {
                                $imgSrc = asset('products/' . $imgPath);
                            } else {
                                $imgSrc = asset('logo/logo_utama.jpeg');
                            }
                        @endphp
                        <div class="w-20 h-20 bg-slate-50 rounded-lg overflow-hidden border border-slate-200 flex-shrink-0">
                            <img src="{{ $imgSrc }}" alt="{{ $restock->product->name }}" class="w-full h-full object-contain" onerror="this.onerror=null;this.src='{{ asset('logo/logo_utama.jpeg') }}';">
                        </div>
                        <div>
                            <div class="text-base font-bold text-gray-900">{{ $restock->product->name }}</div>
                            <div class="text-xs text-gray-400">SKU: {{ $restock->product->slug }}</div>
                        </div>
                    </div>
                </div>

                {{-- Supplier --}}
                <div>
                    <label class="block text-sm font-bold text-gray-600 mb-2">Supplier</label>
                    <div class="text-base font-bold text-gray-900">{{ $restock->supplier->name }}</div>
                    <div class="text-xs text-gray-600">{{ $restock->supplier->phone ?? '-' }}</div>
                </div>

                {{-- Jumlah Restock --}}
                <div>
                    <label class="block text-sm font-bold text-gray-600 mb-2">Jumlah Restock</label>
                    <div class="text-2xl font-bold text-indigo-600">{{ $restock->qty }}</div>
                </div>

                {{-- Tanggal --}}
                <div>
                    <label class="block text-sm font-bold text-gray-600 mb-2">Tanggal Restock</label>
                    <div class="text-base text-gray-900">{{ \Carbon\Carbon::parse($restock->date)->format('d/m/Y') }}</div>
                </div>
            </div>
        </div>

        {{-- CHECKLIST FORM --}}
        <form action="{{ route('admin.restocks.checklist.update', $restock) }}" method="POST" class="mt-8">
            @csrf
            @method('POST')

            <div class="border-t pt-8">
                <h2 class="text-lg font-bold text-gray-800 mb-6">Status Checklist</h2>

                {{-- Checked Qty --}}
                <div class="mb-6">
                    <label for="checked_qty" class="block text-sm font-bold text-gray-700 mb-2">
                        Jumlah Yang Dicek <span class="text-red-600">*</span>
                    </label>
                    <div class="flex items-center gap-4">
                        <input 
                            type="number" 
                            id="checked_qty" 
                            name="checked_qty" 
                            min="0" 
                            max="{{ $restock->qty }}"
                            value="{{ old('checked_qty', $restock->checked_qty ?? 0) }}"
                            class="w-24 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        />
                        <span class="text-gray-600">dari <span class="font-bold">{{ $restock->qty }}</span> unit</span>
                    </div>
                    @error('checked_qty')
                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Checklist Status --}}
                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-700 mb-3">
                        Status Checklist <span class="text-red-600">*</span>
                    </label>
                    <div class="space-y-3">
                        <label class="flex items-center cursor-pointer">
                            <input 
                                type="radio" 
                                name="checklist_status" 
                                value="belum_selesai"
                                {{ old('checklist_status', $restock->checklist_status ?? 'belum_selesai') === 'belum_selesai' ? 'checked' : '' }}
                                class="w-4 h-4 text-indigo-600 cursor-pointer"
                            />
                            <span class="ml-3 text-gray-700">Belum Selesai</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <input 
                                type="radio" 
                                name="checklist_status" 
                                value="sudah_fix"
                                {{ old('checklist_status', $restock->checklist_status ?? 'belum_selesai') === 'sudah_fix' ? 'checked' : '' }}
                                class="w-4 h-4 text-indigo-600 cursor-pointer"
                            />
                            <span class="ml-3 text-gray-700">Sudah Fix</span>
                        </label>
                    </div>
                    @error('checklist_status')
                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Checklist Notes --}}
                <div class="mb-6">
                    <label for="checklist_notes" class="block text-sm font-bold text-gray-700 mb-2">
                        Catatan Checklist
                        <span class="text-gray-500 text-xs font-normal">(diperlukan jika status Sudah Fix)</span>
                    </label>
                    <textarea 
                        id="checklist_notes" 
                        name="checklist_notes" 
                        rows="4"
                        placeholder="Masukkan catatan checklist..."
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 resize-none"
                    >{{ old('checklist_notes', $restock->checklist_notes ?? '') }}</textarea>
                    @error('checklist_notes')
                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- ACTION BUTTONS --}}
            <div class="flex gap-3 mt-8 pt-6 border-t">
                <button 
                    type="submit" 
                    class="bg-indigo-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-indigo-700 transition"
                >
                    Simpan Checklist
                </button>
                <a 
                    href="{{ route('admin.restocks.index') }}" 
                    class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg font-bold hover:bg-gray-300 transition"
                >
                    Batal
                </a>
            </div>
        </form>
    </div>

    </div>
@endsection
