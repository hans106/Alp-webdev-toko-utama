@extends('layouts.admin')

@section('page-title')
    Pesanan Masuk
@endsection

@section('content')

    {{-- Header Halaman --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Pesanan Masuk</h2>
            <p class="text-gray-500 text-sm">Kelola transaksi yang masuk dari pembeli.</p>
        </div>
    </div>

    {{-- Tabel Pesanan --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider border-b border-gray-100">
                    <th class="p-4 font-semibold">ID Order</th>
                    <th class="p-4 font-semibold">Pembeli</th>
                    <th class="p-4 font-semibold">Total Bayar</th>
                    <th class="p-4 font-semibold text-center">Status</th>
                    <th class="p-4 font-semibold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($orders as $order)
                <tr class="hover:bg-gray-50 transition-colors">
                    {{-- ID Order --}}
                    <td class="p-4 font-mono text-sm text-blue-600 font-bold">
                        #{{ $order->invoice_code ?? $order->id }}
                    </td>

                    {{-- Info Pembeli --}}
                    <td class="p-4">
                        <p class="font-bold text-gray-800">{{ $order->user->name ?? 'Guest' }}</p>
                        <p class="text-xs text-gray-500">{{ $order->user->email ?? '-' }}</p>
                    </td>

                    {{-- Total Harga --}}
                    <td class="p-4 font-medium text-gray-800">
                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                    </td>

                    {{-- Status Order --}}
                    <td class="p-4 text-center">
                        @if($order->status == 'paid' || $order->status == 'settlement' || $order->status == 'capture')
                            <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold">LUNAS</span>
                        @elseif($order->status == 'pending')
                            <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-bold">PENDING</span>
                        @elseif($order->status == 'nota_sent')
                            <span class="px-3 py-1 rounded-full bg-indigo-100 text-indigo-700 text-xs font-bold">NOTA TERKIRIM</span>
                        @elseif($order->status == 'sent')
                            <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-bold">DIKIRIM</span>
                        @else
                            <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-700 text-xs font-bold">{{ strtoupper($order->status) }}</span>
                        @endif
                    </td>

                    {{-- Tombol Aksi --}}
                    <td class="p-4 text-right">
                        {{-- Logika Tombol Pending (Terima/Tolak) --}}
                        @if($order->status == 'pending')
                            <div class="flex gap-2 justify-end">
                                <form action="{{ route('admin.orders.approve', $order->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Terima pesanan ini?')">
                                    @csrf
                                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-lg text-xs font-bold shadow-md transition-all">
                                        ✓ Terima
                                    </button>
                                </form>
                                <button type="button" onclick="openRejectModal({{ $order->id }})" class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg text-xs font-bold shadow-md transition-all">
                                    ✕ Tolak
                                </button>
                            </div>
                        {{-- Logika Tombol Kirim (Status Lunas) --}}
                        @elseif($order->status == 'paid' || $order->status == 'settlement' || $order->status == 'capture')
                            <form action="{{ route('admin.orders.ship', $order->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin mau kirim nota virtual ini?')">
                                @csrf
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-xs font-bold shadow-md transition-all flex items-center gap-2 ml-auto">
                                    <span>Kirim Nota</span> ✉️
                                </button>
                            </form>
                        @elseif($order->status == 'sent')
                            <span class="text-xs text-gray-400 italic">Sedang dalam pengiriman</span>
                        @else
                            <span class="text-xs text-gray-400 italic">-</span>
                        @endif
                    </td>
                </tr>

                {{-- Catatan pembeli: tampilkan sebagai card terpisah jika ada catatan --}}
                @if(!empty($order->notes))
                <tr>
                    <td colspan="5" class="p-4">
                        <div class="bg-white border rounded-lg p-4 shadow-sm">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="font-bold">{{ $order->user->name ?? 'Guest' }}</p>
                                    <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i') }}</p>
                                </div>
                                <div class="text-sm text-gray-700">
                                    {{ $order->notes }}
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @endif
                @empty
                <tr>
                    <td colspan="5" class="p-8 text-center text-gray-400">
                        <div class="flex flex-col items-center">
                            <svg class="w-12 h-12 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            <p>Belum ada pesanan masuk.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        {{-- Pagination --}}
        <div class="p-4 border-t border-gray-100 bg-gray-50">
            {{ $orders->links() }}
        </div>
    </div>

@endsection

{{-- Modal Tolak Pesanan --}}
<div id="rejectModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg p-6 w-96">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Tolak Pesanan</h3>
        
        <form id="rejectForm" method="POST">
            @csrf
            
            <div class="mb-4">
                <label for="reason" class="block text-sm font-medium text-gray-700 mb-2">Alasan Penolakan</label>
                <select name="reason" id="reason" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                    <option value="">-- Pilih Alasan --</option>
                    <option value="belum_bayar">Belum Bayar</option>
                    <option value="scan_invalid">Scan/Bukti Invalid</option>
                    <option value="stok_habis">Stok Habis</option>
                    <option value="lainnya">Lainnya (Masukan Manual)</option>
                </select>
            </div>

            <div id="customReasonDiv" class="mb-4 hidden">
                <label for="customReason" class="block text-sm font-medium text-gray-700 mb-2">Alasan Lainnya</label>
                <textarea name="custom_reason" id="customReason" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent" placeholder="Masukkan alasan penolakan..."></textarea>
            </div>

            <div class="flex gap-3 justify-end">
                <button type="button" onclick="closeRejectModal()" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold rounded-lg transition-all">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-bold rounded-lg transition-all">
                    Tolak Pesanan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openRejectModal(orderId) {
    document.getElementById('rejectModal').classList.remove('hidden');
    document.getElementById('rejectForm').action = `/admin/orders/${orderId}/reject`;
    document.getElementById('reason').value = '';
    document.getElementById('customReason').value = '';
    document.getElementById('customReasonDiv').classList.add('hidden');
}

function closeRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
}

// Show custom reason input when "Lainnya" is selected
document.addEventListener('DOMContentLoaded', function() {
    const reasonSelect = document.getElementById('reason');
    if (reasonSelect) {
        reasonSelect.addEventListener('change', function() {
            const customReasonDiv = document.getElementById('customReasonDiv');
            if (this.value === 'lainnya') {
                customReasonDiv.classList.remove('hidden');
                document.getElementById('customReason').required = true;
            } else {
                customReasonDiv.classList.add('hidden');
                document.getElementById('customReason').required = false;
            }
        });
    }
});

// Close modal when clicking outside
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('rejectModal');
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeRejectModal();
            }
        });
    }
});
</script>