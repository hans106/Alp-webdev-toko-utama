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
        // Ambil order beserta item produknya
        $order = Order::with('orderItems.product')
                        ->where('user_id', Auth::id())
                        ->where('id', $id)
                        ->firstOrFail();

        return view('front.orders.detail', compact('order'));
    }
    public function store(Request $request)
    {
        $carts = Cart::where('user_id', Auth::id())->get();

        if($carts->isEmpty()) {
            return redirect()->back()->with('error', 'Keranjang kosong!');
        }

        // 2. Hitung Total Harga
        $totalPrice = 0;
        foreach($carts as $cart) {
            $totalPrice += $cart->product->price * $cart->qty;
        }

        // 3. Mulai Transaksi Database (Biar aman)
        DB::transaction(function () use ($carts, $totalPrice) {
            
            // A. Simpan Order Utama
            $order = Order::create([
                'user_id'     => Auth::id(),
                'total_price' => $totalPrice,
                'status'      => 'pending', // Atau 'paid' tergantung logika abang
                'invoice_number' => 'INV-' . time(), // Contoh nomor invoice
            ]);

            // B. Pindahkan Item dari Cart ke OrderItems
            foreach ($carts as $cart) {
                // Kurangi Stok Produk (Opsional, kalau mau langsung potong stok)
                $cart->product->decrement('stock', $cart->qty);

                // Masukkan ke tabel order_items
                // Pastikan Abang punya model OrderItem ya
                $order->orderItems()->create([
                    'product_id' => $cart->product_id,
                    'qty'        => $cart->qty,
                    'price'      => $cart->product->price,
                ]);
            }

            // C. Kosongkan Keranjang
            Cart::where('user_id', Auth::id())->delete();

            // ==========================================
            // 📹 PASANG CCTV (AUDIT TRAIL) DISINI
            // ==========================================
            ActivityLog::create([
                'user_id' => Auth::id(),
                'action'  => 'ORDER MASUK',
                'description' => "User " . Auth::user()->name . " membuat pesanan baru #" . $order->invoice_number . " senilai Rp " . number_format($totalPrice)
            ]);
            // ==========================================
        });

        return redirect()->route('front.orders.index')->with('success', 'Pesanan berhasil dibuat!');
    }
}
