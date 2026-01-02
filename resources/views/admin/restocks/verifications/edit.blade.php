@extends('layouts.admin')

@section('page-title')
    Edit Verifikasi Nota Harga
@endsection

@section('content')

    {{-- Header --}}
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Edit Verifikasi Nota Harga</h2>
        <p class="text-gray-500 text-sm">Restock ID: <span class="font-mono font-bold text-gray-800">#{{ $restock->id }}</span></p>
    </div>

    {{-- Main Card --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- FORM VERIFIKASI (2/3 lebar) --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <form action="{{ route('admin.restock-verifications.update', $verification->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Status --}}
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status Verifikasi</label>
                        <select name="status" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="pending" {{ $verification->status === 'pending' ? 'selected' : '' }}>⏳ Menunggu Verifikasi</option>
                            <option value="verified" {{ $verification->status === 'verified' ? 'selected' : '' }}>✓ Sudah Diverifikasi</option>
                            <option value="rejected" {{ $verification->status === 'rejected' ? 'selected' : '' }}>✕ Ditolak</option>
                        </select>
                    </div>

                    {{-- Actual Total dari Nota --}}
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Total dari Nota Supplier
                            <span class="text-xs text-gray-500">(Rp)</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-3 text-gray-500">Rp</span>
                            <input 
                                type="number" 
                                name="actual_total" 
                                step="0.01"
                                value="{{ $verification->actual_total ?? '' }}"
                                class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="0">
                        </div>
                        <p class="text-xs text-gray-500 mt-2">
                            💡 Masukkan total yang tercatat di nota restock dari supplier
                        </p>
                    </div>

                    {{-- Notes/Catatan --}}
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Verifikasi</label>
                        <textarea 
                            name="notes" 
                            rows="4"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Contoh: Nota sudah diterima, barang sesuai dengan daftar... atau masalah apa jika ditolak?">{{ $verification->notes ?? '' }}</textarea>
                    </div>

                    {{-- Button Submit --}}
                    <div class="flex gap-3">
                        <a href="{{ route('admin.restock-verifications.index') }}" class="px-6 py-3 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold rounded-lg transition-all">
                            ← Kembali
                        </a>
                        <button type="submit" class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg transition-all">
                            ✓ Simpan Verifikasi
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- INFO RESTOCK (1/3 lebar) --}}
        <div class="lg:col-span-1">
            {{-- Restock Details Card --}}
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl shadow-sm border border-blue-200 p-6 mb-6">
                <h3 class="text-lg font-bold text-blue-900 mb-4">📦 Detail Restock</h3>

                <div class="space-y-3">
                    {{-- Produk --}}
                    <div>
                        <p class="text-xs text-blue-700 font-semibold uppercase">Produk</p>
                        <p class="font-bold text-blue-900">{{ $restock->product->name ?? '-' }}</p>
                    </div>

                    {{-- Supplier --}}
                    <div>
                        <p class="text-xs text-blue-700 font-semibold uppercase">Supplier</p>
                        <p class="font-bold text-blue-900">{{ $restock->supplier->name ?? '-' }}</p>
                    </div>

                    {{-- Qty --}}
                    <div>
                        <p class="text-xs text-blue-700 font-semibold uppercase">Jumlah</p>
                        <p class="text-2xl font-bold text-blue-900">{{ $restock->qty }}<span class="text-sm text-blue-700"> pcs</span></p>
                    </div>

                    {{-- Harga Beli --}}
                    <div>
                        <p class="text-xs text-blue-700 font-semibold uppercase">Harga Beli/Pcs</p>
                        <p class="font-bold text-blue-900">Rp {{ number_format($restock->buy_price, 0, ',', '.') }}</p>
                    </div>

                    {{-- Expected Total --}}
                    <div class="bg-white rounded-lg p-3 mt-4">
                        <p class="text-xs text-gray-600 font-semibold uppercase">Total Expected (Qty × Harga)</p>
                        <p class="text-xl font-bold text-green-600">Rp {{ number_format($verification->expected_total, 0, ',', '.') }}</p>
                    </div>

                    {{-- Tanggal Restock --}}
                    <div>
                        <p class="text-xs text-blue-700 font-semibold uppercase">Tanggal Restock</p>
                        <p class="font-bold text-blue-900">
                            {{ \Carbon\Carbon::parse($restock->date)->format('d M Y') }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Comparison Card (jika sudah ada actual_total) --}}
            @if($verification->actual_total)
                <div class="bg-gradient-to-br {{ $verification->matches ? 'from-green-50 to-green-100' : 'from-red-50 to-red-100' }} rounded-2xl shadow-sm border {{ $verification->matches ? 'border-green-200' : 'border-red-200' }} p-6">
                    <h3 class="text-lg font-bold {{ $verification->matches ? 'text-green-900' : 'text-red-900' }} mb-4">
                        {{ $verification->matches ? '✓ Sesuai' : '✕ Berbeda' }}
                    </h3>

                    <div class="space-y-3">
                        <div>
                            <p class="text-xs {{ $verification->matches ? 'text-green-700' : 'text-red-700' }} font-semibold uppercase">Expected Total</p>
                            <p class="font-bold {{ $verification->matches ? 'text-green-900' : 'text-red-900' }}">
                                Rp {{ number_format($verification->expected_total, 0, ',', '.') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs {{ $verification->matches ? 'text-green-700' : 'text-red-700' }} font-semibold uppercase">Actual Total (dari nota)</p>
                            <p class="font-bold {{ $verification->matches ? 'text-green-900' : 'text-red-900' }}">
                                Rp {{ number_format($verification->actual_total, 0, ',', '.') }}
                            </p>
                        </div>
                        @if(!$verification->matches)
                            <div class="border-t {{ $verification->matches ? 'border-green-300' : 'border-red-300' }} pt-3 mt-3">
                                <p class="text-xs {{ $verification->matches ? 'text-green-700' : 'text-red-700' }} font-semibold uppercase">Selisih</p>
                                <p class="font-bold {{ $verification->matches ? 'text-green-900' : 'text-red-900' }}">
                                    Rp {{ number_format(abs($verification->expected_total - $verification->actual_total), 0, ',', '.') }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>

@endsection
