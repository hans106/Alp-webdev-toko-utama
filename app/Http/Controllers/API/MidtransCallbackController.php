<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Order;

class MidtransCallbackController extends Controller
{
    /**
     * Handle Midtrans payment notification callback
     * Endpoint: POST /midtrans-callback
     */
    public function callback(Request $request)
    {
        // 1. Ambil Server Key dari config
        $serverKey = config('midtrans.server_key');
        
        // 2. Validasi Signature Key untuk keamanan
        $hashed = hash(
            "sha512", 
            $request->order_id . $request->status_code . $request->gross_amount . $serverKey
        );

        // 3. Cek apakah signature valid
        if ($hashed !== $request->signature_key) {
            Log::warning('Midtrans Callback: Invalid signature', [
                'order_id' => $request->order_id,
                'ip' => $request->ip()
            ]);
            
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        // 4. Cari Order berdasarkan invoice_code
        $order = Order::where('invoice_code', $request->order_id)->first();
        
        if (!$order) {
            Log::error('Midtrans Callback: Order not found', [
                'order_id' => $request->order_id
            ]);
            
            return response()->json(['message' => 'Order not found'], 404);
        }

        // 5. Tentukan Status Baru berdasarkan transaction_status dari Midtrans
        $newStatus = match ($request->transaction_status) {
            'capture', 'settlement' => 'paid',      // Pembayaran berhasil
            'pending'               => 'pending',   // Menunggu pembayaran
            'expire'                => 'expire',    // Kadaluarsa
            'cancel', 'deny'        => 'cancelled', // Dibatalkan
            default                 => null
        };

        // 6. Update Order jika ada perubahan status
        if ($newStatus) {
            $oldStatus = $order->status;
            
            $order->update([
                'status' => $newStatus,
                'paid_at' => in_array($newStatus, ['paid']) ? now() : $order->paid_at,
                'snap_token' => null, // Hapus snap_token setelah transaksi selesai
            ]);
            
            // Log perubahan status untuk tracking
            Log::info('Midtrans Callback: Order status updated', [
                'order_id' => $order->id,
                'invoice_code' => $order->invoice_code,
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
                'transaction_status' => $request->transaction_status,
                'payment_type' => $request->payment_type ?? null,
            ]);
        }

        return response()->json([
            'message' => 'Callback success',
            'order_id' => $order->invoice_code,
            'status' => $newStatus
        ]);
    }
}