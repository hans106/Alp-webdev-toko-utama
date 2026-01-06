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
        $orders = Order::with('user')
            ->whereIn('status', ['paid', 'settlement']) // Hanya status LUNAS                   // Pastikan tanggal bayar ada                 // Pastikan tanggal bayar ada
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

        if (!in_array($order->status, ['paid', 'settlement'])) {
            return redirect()->back()->with('error', 'Hanya pesanan yang sudah dibayar yang bisa dikirim ke checklist.');
        }

        if ($order->checklist()->exists()) {
            return redirect()->back()->with('info', 'Checklist untuk pesanan ini sudah dibuat sebelumnya.');
        }

        // 2. PERBAIKI BAGIAN INI
        $checklist = OrderChecklist::create([
            'order_id' => $order->id,
            'admin_id' => Auth::id(), // <--- TAMBAHKAN INI (Ambil ID Admin yg login)
            'recipient_name' => $order->user->name,
            'items_count' => $order->orderItems->count(),
            'status' => 'belum_selesai',
        ]);

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
