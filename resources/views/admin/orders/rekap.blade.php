@extends('layouts.admin')

@section('page-title')
    Pesanan Masuk
@endsection

@section('content')

    {{-- Header Halaman (Premium Style) --}}
    <div class="flex flex-col md:flex-row justify-between items-end mb-8 gap-4">
        <div>
            <h2 class="text-3xl font-serif font-bold text-[#800000] tracking-wide">
                Pesanan Masuk
            </h2>
            <div class="h-1 w-24 bg-gradient-to-r from-[#E1B56A] to-transparent mt-2 mb-2 rounded-full"></div>
            <p class="text-slate-600 text-sm">Kelola transaksi dan pembayaran pelanggan.</p>
        </div>
    </div>

    {{-- Tabel Pesanan Wrapper --}}
    <div class="bg-white rounded-2xl shadow-[0_10px_40px_-15px_rgba(0,0,0,0.1)] border border-[#E1B56A]/20 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                {{-- Table Head: Maroon Background, White/Gold Text --}}
                <thead>
                    <tr class="bg-[#800000] text-white text-xs uppercase tracking-widest">
                        <th class="p-5 font-bold border-b-2 border-[#E1B56A]">ID Order</th>
                        <th class="p-5 font-bold border-b-2 border-[#E1B56A]">Pembeli</th>
                        <th class="p-5 font-bold border-b-2 border-[#E1B56A]">Total Bayar</th>
                        <th class="p-5 font-bold border-b-2 border-[#E1B56A] text-center">Status</th>
                        <th class="p-5 font-bold border-b-2 border-[#E1B56A] text-right min-w-[200px]">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E1B56A]/10">
                    @forelse($orders as $order)
                    {{-- Row Hover Effect: Soft Cream --}}
                    <tr class="hover:bg-[#FDFBF7] transition-colors duration-200 group">
                        
                        {{-- ID Order --}}
                        <td class="p-5">
                            <span class="font-mono text-sm font-bold text-[#800000] bg-[#800000]/5 px-2 py-1 rounded border border-[#800000]/10">
                                #{{ $order->invoice_code ?? $order->id }}
                            </span>
                        </td>

                        {{-- Info Pembeli --}}
                        <td class="p-5">
                            <p class="font-bold text-slate-800 text-base">{{ $order->user->name ?? 'Guest' }}</p>
                            <p class="text-xs text-[#E1B56A] italic mt-0.5">{{ $order->user->email ?? '-' }}</p>
                        </td>

                        {{-- Total Harga --}}
                        <td class="p-5">
                            <span class="font-serif font-bold text-lg text-[#2B0A0A]">
                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                            </span>
                        </td>

                        {{-- Status Order (Styled Badges) --}}
                        <td class="p-5 text-center">
                            @if($order->status == 'paid' || $order->status == 'settlement' || $order->status == 'capture')
                                <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200 text-xs font-bold shadow-sm inline-block w-24">
                                    LUNAS
                                </span>
                            @elseif($order->status == 'pending')
                                <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-800 border border-amber-200 text-xs font-bold shadow-sm animate-pulse inline-block w-24">
                                    PENDING
                                </span>
                            @elseif($order->status == 'nota_sent')
                                <span class="px-3 py-1 rounded-full bg-indigo-100 text-indigo-800 border border-indigo-200 text-xs font-bold shadow-sm inline-block w-24">
                                    TERKIRIM
                                </span>
                            @elseif($order->status == 'accepted')
                                <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-800 border border-blue-200 text-xs font-bold shadow-sm inline-block w-24">
                                    DITERIMA
                                </span>
                            @elseif($order->status == 'sent')
                                <span class="px-3 py-1 rounded-full bg-[#800000]/10 text-[#800000] border border-[#800000]/20 text-xs font-bold shadow-sm inline-block w-24">
                                    DIKIRIM
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-600 border border-slate-200 text-xs font-bold inline-block w-24">
                                    {{ strtoupper($order->status) }}
                                </span>
                            @endif
                        </td>

                        {{-- Tombol Aksi --}}
                        <td class="p-5 text-right">
                            {{-- LOGIKA TOMBOL PENDING (Fixed Equal Size) --}}
                            @if($order->status == 'pending')
                                {{-- Gunakan GRID agar lebar dibagi rata 50:50 --}}
                                <div class="grid grid-cols-2 gap-2 w-full max-w-[220px] ml-auto">
                                    
                                    {{-- Tombol Terima (Form dibungkus agar tidak merusak layout) --}}
                                    <form action="{{ route('admin.orders.approve', $order->id) }}" method="POST" class="contents" onsubmit="return confirm('Terima pesanan ini?')">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center justify-center gap-1 bg-emerald-600 hover:bg-emerald-700 text-white py-2 rounded-lg text-xs font-bold shadow-md hover:shadow-lg transition-all border border-emerald-700 h-9">
                                            ✓ Terima
                                        </button>
                                    </form>

                                    {{-- Tombol Tolak --}}
                                    <button type="button" onclick="openRejectModal({{ $order->id }})" class="w-full flex items-center justify-center gap-1 bg-white hover:bg-red-50 text-red-600 border border-red-200 py-2 rounded-lg text-xs font-bold shadow-sm hover:shadow-md transition-all h-9">
                                        ✕ Tolak
                                    </button>
                                </div>

                            {{-- LOGIKA TOMBOL KIRIM NOTA --}}
                            @elseif(in_array($order->status, ['paid','settlement','capture','accepted']))
                                <div class="flex justify-end">
                                    <form action="{{ route('admin.orders.ship', $order->id) }}" method="POST" class="inline-block w-full max-w-[220px]" onsubmit="return confirm('Yakin mau kirim nota virtual ini?')">
                                        @csrf
                                        <button type="submit" class="w-full bg-gradient-to-r from-[#E1B56A] to-[#C5A059] hover:from-[#d4a042] hover:to-[#b88d3f] text-[#2B0A0A] py-2 rounded-lg text-xs font-bold shadow-md hover:shadow-[0_0_15px_rgba(225,181,106,0.4)] transition-all flex items-center justify-center gap-2 border border-[#b88d3f] h-9">
                                            <span>Kirim Nota</span> 
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                                <path d="M3 4a2 2 0 00-2 2v1.161l8.441 4.221a1.25 1.25 0 001.118 0L19 7.162V6a2 2 0 00-2-2H3z" />
                                                <path d="M19 8.839l-7.77 3.885a2.75 2.75 0 01-2.46 0L1 8.839V14a2 2 0 002 2h14a2 2 0 002-2V8.839z" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>

                            @elseif($order->status == 'sent')
                                <span class="text-xs text-slate-400 italic flex items-center justify-end gap-1 h-9">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Terkirim
                                </span>
                            @else
                                <span class="text-xs text-slate-400 italic h-9 flex items-center justify-end">-</span>
                            @endif
                        </td>
                    </tr>

                    {{-- Catatan pembeli --}}
                    @if(!empty($order->notes))
                    <tr class="bg-[#FDFBF7]/50">
                        <td colspan="5" class="px-5 pb-5 pt-0 border-none">
                            <div class="bg-white border-l-4 border-[#E1B56A] rounded-r-lg p-4 shadow-sm mt-[-10px] ml-4">
                                <div class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-[#E1B56A] mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                                    <div>
                                        <p class="text-xs font-bold text-[#800000] uppercase tracking-wide mb-1">Catatan Pesanan:</p>
                                        <p class="text-sm text-slate-700 italic">"{{ $order->notes }}"</p>
                                        <p class="text-[10px] text-slate-400 mt-1">{{ \Carbon\Carbon::parse($order->created_at)->format('d F Y, H:i') }}</p>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endif

                    @empty
                    <tr>
                        <td colspan="5" class="p-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-16 h-16 bg-[#800000]/5 rounded-full flex items-center justify-center mb-4">
                                    <svg class="w-8 h-8 text-[#800000]/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                </div>
                                <p class="text-slate-500 font-medium">Belum ada pesanan masuk saat ini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- Pagination Wrapper --}}
        <div class="p-4 border-t border-[#E1B56A]/20 bg-[#FDFBF7]">
            {{ $orders->links() }}
        </div>
    </div>

@endsection

{{-- Modal Tolak Pesanan (Premium Design) --}}
<div id="rejectModal" class="hidden fixed inset-0 bg-[#2B0A0A]/80 backdrop-blur-sm flex items-center justify-center z-50 transition-opacity duration-300">
    <div class="bg-white rounded-xl shadow-2xl w-96 overflow-hidden border border-[#E1B56A]/50 transform scale-100 transition-transform duration-300">
        {{-- Modal Header --}}
        <div class="bg-[#800000] p-4 flex justify-between items-center">
            <h3 class="text-lg font-bold text-white flex items-center gap-2">
                <svg class="w-5 h-5 text-[#E1B56A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                Tolak Pesanan
            </h3>
            <button onclick="closeRejectModal()" class="text-white/70 hover:text-white">✕</button>
        </div>
        
        <div class="p-6">
            <form id="rejectForm" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label for="reason" class="block text-sm font-bold text-[#800000] mb-2">Alasan Penolakan</label>
                    <div class="relative">
                        <select name="reason" id="reason" required class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-[#800000] focus:border-[#800000] appearance-none bg-slate-50 text-slate-800">
                            <option value="">-- Pilih Alasan --</option>
                            <option value="belum_bayar">Belum Melakukan Pembayaran</option>
                            <option value="scan_invalid">Bukti Pembayaran Tidak Valid</option>
                            <option value="stok_habis">Stok Produk Habis</option>
                            <option value="lainnya">Lainnya (Tulis Manual)</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-[#800000]">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>

                <div id="customReasonDiv" class="mb-6 hidden">
                    <label for="customReason" class="block text-sm font-bold text-[#800000] mb-2">Alasan Lainnya</label>
                    <textarea name="custom_reason" id="customReason" rows="3" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-[#800000] focus:border-[#800000] text-slate-800" placeholder="Jelaskan alasan penolakan..."></textarea>
                </div>

                <div class="flex gap-3 justify-end pt-2">
                    <button type="button" onclick="closeRejectModal()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-lg transition-all text-sm">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-[#800000] hover:bg-[#600000] text-white font-bold rounded-lg transition-all shadow-md text-sm">
                        Konfirmasi Tolak
                    </button>
                </div>
            </form>
        </div>
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