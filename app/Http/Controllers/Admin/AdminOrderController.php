<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderChecklist;
use App\Models\OrderChecklistItem;
use Illuminate\Support\Facades\Auth;

class AdminOrderController extends Controller
{
    public function index()
    {
        // Ambil pesanan yang statusnya LUNAS atau PENDING
        // Kita load relasi 'checklist' biar tombol di view abang bisa berubah (Lihat Checklist / Kirim)
        $orders = Order::with(['user', 'orderItems', 'checklist'])
            ->whereIn('status', ['paid', 'settlement', 'pending']) 
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    public function sendToChecklist($id)
    {
        $order = Order::with('orderItems')->findOrFail($id);

        // 1. Cek dulu, jangan sampai double
        if ($order->checklist()->exists()) {
            return redirect()->back()->with('info', 'Pesanan ini sudah masuk daftar checklist gudang.');
        }

        // 2. Buat Header Checklist
        $checklist = OrderChecklist::create([
            'order_id' => $order->id,
            'admin_id' => Auth::id(), 
            'recipient_name' => $order->user->name,
            'items_count' => $order->orderItems->count(),
            'status' => 'belum_selesai',
        ]);

        // 3. Masukkan item barang ke checklist
        foreach ($order->orderItems as $item) {
            OrderChecklistItem::create([
                'order_checklist_id' => $checklist->id,
                'product_id' => $item->product_id,
                'qty_required' => $item->qty,
                'qty_checked' => 0,
            ]);
        }

        // 4. Ubah status order jadi 'processing' (Tanda sedang diproses gudang)
        // Kalau abang mau ordernya HILANG dari tabel Pesanan Masuk setelah diklik, pakai baris ini:
        $order->update(['status' => 'processing']);

        // Balik ke halaman index dengan pesan sukses
        return redirect()->back()->with('success', 'Pesanan berhasil dikirim ke Tim Gudang!');
    }
}