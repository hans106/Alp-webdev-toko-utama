<?php

namespace App\Http\Controllers\Admin; 

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\ActivityLog; // ✅ WAJIB IMPORT LOG
use App\Models\OrderChecklist;
use App\Models\OrderChecklistItem;
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

        // Update status jadi 'accepted' (diterima oleh admin)
        $oldStatus = $order->status;
        $order->update(['status' => 'accepted']);

        // --- 📹 REKAM CCTV (ORDER DITERIMA) ---
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'APPROVE ORDER',
            'description' => "Menerima Pesanan #{$order->id}. Status: '{$oldStatus}' -> 'accepted'."
        ]);
        // ------------------------------------

        // Create a checklist record so admin_penjualan can immediately check items
        $existing = OrderChecklist::where('order_id', $order->id)->first();
        if (! $existing) {
            $itemsCount = $order->orderItems()->sum('qty');
            $checklist = OrderChecklist::create([
                'order_id' => $order->id,
                'admin_id' => Auth::id(),
                'recipient_name' => $order->user->name ?? 'Pelanggan',
                'items_count' => $itemsCount,
                'status' => 'belum_selesai',
                'sent_at' => null
            ]);

            foreach ($order->orderItems as $oi) {
                OrderChecklistItem::create([
                    'order_checklist_id' => $checklist->id,
                    'product_id' => $oi->product_id,
                    'qty_required' => $oi->qty,
                    // assume ordered quantity is correct and mark it checked so it can be printed immediately
                    'qty_checked' => $oi->qty,
                    'status' => 'checked',
                ]);
            }

            // Since we marked all items as checked, mark checklist as done
            $checklist->status = 'sudah_fix';
            $checklist->save();

            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'CREATE CHECKLIST ON APPROVE',
                'description' => "Checklist for Order #{$order->id} created when order was accepted. Items: {$itemsCount}."
            ]);
        }

        return redirect()->back()->with('success', 'Pesanan Diterima! ✅ Pelanggan dapat melakukan pembayaran sekarang');
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

        // Allow sending virtual nota when order is accepted or already paid
        if(in_array($order->status, ['paid','settlement','capture','accepted'])){
            // Simpan status lama buat laporan
            $oldStatus = $order->status;

            // Update status jadi 'nota_sent'
            $order->update(['status' => 'nota_sent']);

            // Reuse checklist if it exists; otherwise create and mark sent
            $checklist = OrderChecklist::where('order_id', $order->id)->first();
            $itemsCount = $order->orderItems()->sum('qty');
            if (! $checklist) {
                $checklist = OrderChecklist::create([
                    'order_id' => $order->id,
                    'admin_id' => Auth::id(),
                    'recipient_name' => $order->user->name,
                    'items_count' => $itemsCount,
                    'sent_at' => now(),
                    'status' => 'belum_selesai'
                ]);

                foreach ($order->orderItems as $oi) {
                    OrderChecklistItem::create([
                        'order_checklist_id' => $checklist->id,
                        'product_id' => $oi->product_id,
                        'qty_required' => $oi->qty,
                        // assume ordered quantity is correct and mark it checked so it can be printed immediately
                        'qty_checked' => $oi->qty,
                        'status' => 'checked',
                    ]);
                }
            } else {
                // Ensure any previously-created items that weren't checked are set to checked (allow print)
                foreach ($checklist->items as $it) {
                    if ($it->qty_checked < $it->qty_required) {
                        $it->qty_checked = $it->qty_required;
                        $it->status = 'checked';
                        $it->save();
                    }
                }

                $checklist->update(['sent_at' => now(), 'items_count' => $itemsCount]);
            }

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