@extends('layouts.admin')

@section('page-title')
    Checklist Restock
@endsection

@section('content')
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200">
        <h1 class="text-xl font-bold mb-4">Checklist Restock #{{ $restock->id }}</h1>

        <div class="mb-6">
            <p><strong>Produk:</strong> {{ $restock->product->name }}</p>
            <p><strong>Supplier:</strong> {{ $restock->supplier->name }}</p>
            <p><strong>Jumlah Masuk:</strong> {{ $restock->qty }}</p>
            <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($restock->date)->format('d/m/Y') }}</p>
        </div>

        <form action="{{ route('admin.restocks.checklist.update', $restock) }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Checked Qty</label>
                    <input type="number" name="checked_qty" min="0" max="{{ $restock->qty }}" value="{{ old('checked_qty', $restock->checked_qty ?? 0) }}" class="mt-1 block w-full border rounded-md px-3 py-2">
                    @error('checked_qty') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="checklist_status" class="mt-1 block w-full border rounded-md px-3 py-2">
                        <option value="belum_selesai" {{ (old('checklist_status', $restock->checklist_status) == 'belum_selesai') ? 'selected' : '' }}>Belum Selesai</option>
                        <option value="sudah_fix" {{ (old('checklist_status', $restock->checklist_status) == 'sudah_fix') ? 'selected' : '' }}>Sudah Fix</option>
                    </select>
                    @error('checklist_status') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Notes</label>
                    <textarea name="checklist_notes" rows="3" class="mt-1 block w-full border rounded-md px-3 py-2">{{ old('checklist_notes', $restock->checklist_notes) }}</textarea>
                    @error('checklist_notes') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mt-4 flex gap-2">
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Simpan Checklist</button>
                <a href="{{ route('admin.restocks.index') }}" class="px-4 py-2 border rounded">Batal</a>
            </div>
        </form>
    </div>
@endsection
