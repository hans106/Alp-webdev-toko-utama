<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderChecklist;
use App\Models\OrderChecklistItem;


class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user') // <--- GANTI (...) JADI 'user'
            ->whereIn('status', ['paid', 'settlement']) // Hanya status LUNAS
            ->whereNotNull('paid_at')                   // Pastikan tanggal bayar ada
            ->orderBy('paid_at', 'desc')
            ->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Kirim pesanan ke Checklist Nota
     */
    public function sendToChecklist($id)
    {
        $order = Order::with('orderItems.product')->findOrFail($id);

        // Cek apakah order sudah dibayar
        if (!in_array($order->status, ['paid', 'settlement'])) {
            return redirect()->back()->with('error', 'Hanya pesanan yang sudah dibayar yang bisa dikirim ke checklist.');
        }

        // Cek apakah sudah ada checklist untuk order ini
        if ($order->checklist()->exists()) {
            return redirect()->back()->with('info', 'Checklist untuk pesanan ini sudah dibuat sebelumnya.');
        }

        // Buat Checklist baru
        $checklist = OrderChecklist::create([
            'order_id' => $order->id,
            'recipient_name' => $order->user->name,
            'items_count' => $order->orderItems->count(),
            'status' => 'belum_selesai',
        ]);

        // Buat checklist items
        foreach ($order->orderItems as $item) {
            OrderChecklistItem::create([
                'order_checklist_id' => $checklist->id,
                'product_id' => $item->product_id,
                'qty_required' => $item->qty,
                'qty_checked' => 0,
            ]);
        }

        return redirect()->route('admin.checklists.show', $checklist->id)
            ->with('success', 'Pesanan berhasil dikirim ke Checklist Nota!');
    }
}
