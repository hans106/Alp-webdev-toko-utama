<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

// --- INI PENTING: Panggil Library Midtrans ---
use Midtrans\Config;
use Midtrans\Snap;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
        return view('front.orders.history', compact('orders'));
    }

    public function show($id)
    {
        // 1. Ambil data order
        $order = Order::with('orderItems.product')
                        ->where('user_id', Auth::id())
                        ->where('id', $id)
                        ->firstOrFail();

        // 2. LOGIC MIDTRANS (WAJIB ADA DISINI)
        // Cek: Jika status pending DAN snap_token belum punya, mintakan ke Midtrans
        if ($order->status == 'pending' && empty($order->snap_token)) {
            
            // Konfigurasi Midtrans
            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = config('midtrans.is_production');
            Config::$isSanitized = true;
            Config::$is3ds = true;

            // Data yang dikirim ke Midtrans
            $params = [
                'transaction_details' => [
                    'order_id' => $order->invoice_code . '-' . rand(), // Tambah angka acak biar unik
                    'gross_amount' => (int) $order->total_price, // Pastikan integer
                ],
                'customer_details' => [
                    'first_name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                ],
            ];

            try {
                // Minta Token
                $snapToken = Snap::getSnapToken($params);
                
                // Simpan Token ke Database
                $order->snap_token = $snapToken;
                $order->save();
                
            } catch (\Exception $e) {
                // Kalau error koneksi, tampilkan errornya (untuk debugging)
                // dd($e->getMessage()); 
            }
        }

        return view('front.orders.detail', compact('order'));
    }

    public function store(Request $request)
    {
        $carts = Cart::where('user_id', Auth::id())->get();

        if($carts->isEmpty()) {
            return redirect()->back()->with('error', 'Keranjang kosong!');
        }

        // Hitung Total Harga
        $totalPrice = 0;
        foreach($carts as $cart) {
            $totalPrice += $cart->product->price * $cart->qty;
        }

        // Mulai Transaksi Database
        DB::transaction(function () use ($carts, $totalPrice) {
            
            // A. Buat Order Baru
            $order = Order::create([
                'user_id'     => Auth::id(),
                'total_price' => $totalPrice,
                'status'      => 'pending',
                'invoice_code'=> 'INV-' . strtoupper(\Illuminate\Support\Str::random(10)), // Perbaikan nama kolom invoice
            ]);

            // B. Pindahkan Item
            foreach ($carts as $cart) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $cart->product_id,
                    'qty'        => $cart->qty,
                    'price'      => $cart->product->price,
                ]);
            }

            // C. Kosongkan Keranjang
            Cart::where('user_id', Auth::id())->delete();

            // D. Log Aktivitas
            ActivityLog::create([
                'user_id' => Auth::id(),
                'action'  => 'ORDER MASUK',
                'description' => "User " . Auth::user()->name . " membuat pesanan baru # " . $order->invoice_code
            ]);
        });

        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dibuat!');
    }
    public function resetToken($id)
    {
        $order = Order::where('user_id', Auth::id())->where('id', $id)->firstOrFail();

        // Cuma boleh reset kalau statusnya masih pending
        if($order->status == 'pending') {
            $order->snap_token = null; // Hapus token lama
            $order->save();
            
            return redirect()->back()->with('success', 'Link pembayaran berhasil diperbarui!');
        }

        return redirect()->back()->with('error', 'Pesanan tidak bisa direset.');
    }

    // Generate Snap Token explicitly via AJAX (Midtrans Sandbox)
    public function generateSnap(Request $request, $id)
    {
        $order = Order::where('user_id', Auth::id())->where('id', $id)->firstOrFail();

        if($order->status != 'pending') {
            return response()->json(['success' => false, 'message' => 'Order tidak dalam status pending'], 400);
        }

        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => $order->invoice_code . '-' . rand(),
                'gross_amount' => (int) $order->total_price,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            $order->snap_token = $snapToken;
            $order->save();

            return response()->json(['success' => true, 'snap_token' => $snapToken]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal membuat token: ' . $e->getMessage()], 500);
        }
    }
}