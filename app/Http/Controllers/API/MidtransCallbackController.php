<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class MidtransCallbackController extends Controller
{
    public function callback(Request $request)
    {
        // 1. Ambil Server Key
        $serverKey = config('midtrans.server_key');
        
        // 2. Validasi Signature
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed == $request->signature_key) {
            
            // 3. Cari Order berdasarkan invoice_code
            $order = Order::where('invoice_code', $request->order_id)->first();
            
            if (!$order) {
                return response()->json(['message' => 'Order not found'], 404);
            }

            // 4. Tentukan Status Baru - DIPERBAIKI: pakai 'status' bukan 'payment_status'
            $newStatus = match ($request->transaction_status) {
                'capture', 'settlement' => 'paid',      // Pembayaran berhasil
                'pending'               => 'pending',   // Menunggu pembayaran
                'expire'                => 'expire',    // Kadaluarsa
                'cancel', 'deny'        => 'cancelled', // Dibatalkan
                default                 => null
            };

            // 5. Update Order
            if ($newStatus) {
                $order->update([
                    'status' => $newStatus,
                    'paid_at' => in_array($newStatus, ['paid']) ? now() : $order->paid_at,
                ]);
                
                // Hapus snap_token jika sudah tidak pending
                if ($newStatus !== 'pending') {
                    $order->update(['snap_token' => null]);
                }
            }

            return response()->json(['message' => 'Callback success']);
            
        } else {
            return response()->json(['message' => 'Invalid signature'], 403);
        }
    }
}