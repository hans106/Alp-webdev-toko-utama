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

// --- Library Midtrans ---
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;

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

        // 2. Auto-generate token jika pending dan belum ada token (silent, no error message)
        if ($order->status == 'pending' && empty($order->snap_token)) {
            $order->generateSnapToken();
            $order->refresh(); // Reload data dari DB
        }

        return view('front.orders.detail', compact('order'));
    }

    public function printNota($id)
    {
        $order = Order::with(['orderItems.product', 'user'])
                        ->where('user_id', Auth::id())
                        ->where('id', $id)
                        ->firstOrFail();

        // Hanya bisa print jika sudah dibayar
        if (!in_array($order->status, ['paid', 'settlement'])) {
            return redirect()->back()->with('error', 'Nota hanya bisa dicetak untuk pesanan yang sudah dibayar.');
        }

        return view('front.orders.print_nota', compact('order'));
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
                'invoice_code'=> 'INV-' . strtoupper(\Illuminate\Support\Str::random(10)),
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

        if($order->status == 'pending') {
            // Hapus token lama dan generate baru
            $order->update(['snap_token' => null]);
            $order->generateSnapToken();
            $order->refresh();
            
            // Redirect langsung tanpa flash message
            return redirect()->route('orders.show', $order->id);
        }

        return redirect()->back();
    }

    public function generateSnap(Request $request, $id)
    {
        $order = Order::where('user_id', Auth::id())->where('id', $id)->firstOrFail();

        if($order->status != 'pending') {
            return response()->json(['success' => false, 'message' => 'Order tidak dapat menerima pembayaran saat ini.' ], 400);
        }

        // Generate atau regenerate snap token
        $snapToken = $order->generateSnapToken();

        if ($snapToken) {
            return response()->json(['success' => true, 'snap_token' => $snapToken]);
        } else {
            return response()->json(['success' => false, 'message' => 'Gagal membuat token pembayaran. Silakan coba lagi.'], 500);
        }
    }

    /**
     * CEK STATUS PEMBAYARAN LANGSUNG KE MIDTRANS API
     * Ini solusi untuk development tanpa callback URL
     */
    public function checkPaymentStatus($id)
    {
        $order = Order::where('user_id', Auth::id())->where('id', $id)->firstOrFail();

        // Hanya cek jika status masih 'pending'
        if ($order->status != 'pending') {
            return redirect()->back()->with('info', 'Status pembayaran sudah: ' . strtoupper($order->status));
        }

        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');

        try {
            // Cek status ke Midtrans API
            $response = Transaction::status($order->invoice_code);
            
            $transactionStatus = $response->transaction_status ?? null;
            $fraudStatus = $response->fraud_status ?? null;

            // Update status berdasarkan response
            $newStatus = match ($transactionStatus) {
                'capture' => ($fraudStatus == 'accept') ? 'paid' : 'pending',
                'settlement' => 'paid',
                'pending' => 'pending',
                'deny', 'cancel' => 'cancelled',
                'expire' => 'expire',
                default => null
            };

            if ($newStatus && $newStatus != 'pending') {
                $order->update([
                    'status' => $newStatus,
                    'paid_at' => ($newStatus == 'paid') ? now() : null,
                    'snap_token' => null,
                ]);
                
                return redirect()->back()->with('success', 'Status pembayaran diperbarui: ' . strtoupper($newStatus));
            }

            return redirect()->back()->with('info', 'Status pembayaran masih: PENDING. Silakan selesaikan pembayaran.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Tidak dapat mengecek status: ' . $e->getMessage());
        }
    }
}