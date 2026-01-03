<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order; // Saya import di atas biar rapi

class MidtransCallbackController extends Controller
{
    public function callback(Request $request)
    {
        // 1. Ambil Server Key (Pastikan config path-nya benar)
        $serverKey = config('midtrans.server_key');
        // 2. Validasi Signature
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed == $request->signature_key) {
            
            // 3. Cari Order (GANTI 'order_number' JADI 'invoice_code')
            $order = Order::where('invoice_code', $request->order_id)->first();
            
            if (!$order) {
                return response()->json(['message' => 'Order not found'], 404);
            }

            // 4. Tentukan Status Baru (Pakai Match Expression - Mantap!)
            $dataToUpdate = match ($request->transaction_status) {
                'capture', 'settlement' => ['payment_status' => '2'],
                'expire'                => ['payment_status' => '3', 'snap_token' => null],
                'cancel', 'deny'        => ['payment_status' => '4'],
                default                 => [] 
            };

            // 5. Eksekusi Update
            if (!empty($dataToUpdate)) {
                $order->update($dataToUpdate);
            }

            return response()->json(['message' => 'Callback success']);
            
        } else {
            return response()->json(['message' => 'Invalid signature'], 403);
        }
    }
}