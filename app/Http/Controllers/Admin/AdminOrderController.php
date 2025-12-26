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

    // FUNGSI KIRIM BARANG (+ LOG)
    public function ship($id) 
    {
        $order = Order::findOrFail($id);

        if($order->status == 'paid' || $order->status == 'settlement'){
            
            // Simpan status lama buat laporan
            $oldStatus = $order->status;
            
            // Update status jadi 'sent'
            $order->update(['status' => 'sent']);

            // --- 📹 REKAM CCTV (ORDER DIKIRIM) ---
            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'UPDATE STATUS ORDER',
                'description' => "Mengirim Pesanan #{$order->id} (Resi/Pengiriman). Status: '{$oldStatus}' -> 'sent'."
            ]);
            // ------------------------------------
            
            return redirect()->back()->with('success', 'Pesanan Berhasil Dikirim! 🚚');
        }

        return redirect()->back()->with('error', 'Pesanan Belum Lunas atau Sudah Dikirim!');
    }
}