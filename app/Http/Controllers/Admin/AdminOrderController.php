<?php

namespace App\Http\Controllers\Admin; 

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\ActivityLog; // ✅ WAJIB IMPORT LOG
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // ✅ WAJIB IMPORT AUTH

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(10);
        return view('admin.orders.rekap', compact('orders'));
    }

    // FUNGSI TERIMA PESANAN (Validasi pembayaran, scan QR valid) + LOG
    public function approve($id) 
    {
        $order = Order::findOrFail($id);

        // Hanya order dengan status 'pending' yang bisa diterima
        if($order->status !== 'pending'){
            return redirect()->back()->with('error', 'Pesanan tidak bisa diterima. Status harus "pending"!');
        }

        // Update status jadi 'paid' (validasi pembayaran berhasil)
        $oldStatus = $order->status;
        $order->update(['status' => 'paid']);

        // --- 📹 REKAM CCTV (ORDER DITERIMA) ---
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'APPROVE ORDER',
            'description' => "Menerima & Validasi Pesanan #{$order->id} (pembayaran valid). Status: '{$oldStatus}' -> 'paid'."
        ]);
        // ------------------------------------
        
        return redirect()->back()->with('success', 'Pesanan Diterima! ✅ Status berubah menjadi PAID');
    }

    // FUNGSI TOLAK PESANAN (Belum bayar, scan invalid, pending) + LOG
    public function reject($id, Request $request) 
    {
        $order = Order::findOrFail($id);

        // Hanya order dengan status 'pending' yang bisa ditolak
        if($order->status !== 'pending'){
            return redirect()->back()->with('error', 'Pesanan tidak bisa ditolak. Status harus "pending"!');
        }

        $reason = $request->input('reason', 'Tidak ada alasan ditentukan');

        // Update status jadi 'cancelled' (tolak pesanan)
        $oldStatus = $order->status;
        $order->update(['status' => 'cancelled']);

        // --- 📹 REKAM CCTV (ORDER DITOLAK) ---
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'REJECT ORDER',
            'description' => "Menolak Pesanan #{$order->id}. Alasan: {$reason}. Status: '{$oldStatus}' -> 'cancelled'."
        ]);
        // ------------------------------------
        
        return redirect()->back()->with('success', 'Pesanan Ditolak! ❌ Pelanggan akan dihubungi untuk konfirmasi ulang');
    }

    // FUNGSI KIRIM BARANG (+ LOG)
    public function ship($id) 
    {
        $order = Order::findOrFail($id);

        if($order->status == 'paid' || $order->status == 'settlement'){
            // Simpan status lama buat laporan
            $oldStatus = $order->status;

            // Update status jadi 'nota_sent'
            $order->update(['status' => 'nota_sent']);

            // Buat virtual nota / checklist
            $itemsCount = $order->orderItems()->sum('qty');
            \App\Models\OrderChecklist::create([
                'order_id' => $order->id,
                'admin_id' => Auth::id(),
                'recipient_name' => $order->user->name,
                'items_count' => $itemsCount,
                'sent_at' => now()
            ]);

            // --- 📹 REKAM CCTV (NOTA DIKIRIM) ---
            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'SEND VIRTUAL NOTA',
                'description' => "Kirim Nota Virtual untuk Pesanan #{$order->id} kepada {$order->user->name} (Items: {$itemsCount}). Status: '{$oldStatus}' -> 'nota_sent'."
            ]);
            // ------------------------------------

            return redirect()->back()->with('success', 'Nota Virtual Berhasil Dikirim ke Checklist.');
        }
        return redirect()->back()->with('error', 'Pesanan Belum Lunas atau Sudah Dikirim!');
    }
}