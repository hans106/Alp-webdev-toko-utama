<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    // 1. Tampilkan Halaman Checkout
    public function index()
    {
        if (Auth::user()->role !== 'customer') {
            return redirect()->route('home')->with('error', 'Maaf, Admin tidak boleh ikut belanja!');
        }

        // Ambil keranjang user
        $carts = Cart::with('product')->where('user_id', Auth::id())->get();

        // Kalau keranjang kosong, tendang balik
        if ($carts->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang masih kosong, belum bisa checkout.');
        }

        // Hitung Total Bayar
        $totalPrice = 0;
        foreach ($carts as $cart) {
            // PERBAIKAN: Pakai 'qty', bukan 'quantity'
            $totalPrice += $cart->product->price * $cart->qty; 
        }

        return view('front.checkout', compact('carts', 'totalPrice'));
    }

    // 2. Proses Simpan Pesanan
    public function process(Request $request)
    {
        if (Auth::user()->role !== 'customer') {
            abort(403);
        }

        // VALIDASI INPUT
        $request->validate([
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
        ]);

        $user = Auth::user();
        $carts = Cart::with('product')->where('user_id', $user->id)->get();

        if ($carts->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong.');
        }

        // HITUNG TOTAL
        $totalPrice = 0;
        foreach ($carts as $cart) {
            $totalPrice += $cart->product->price * $cart->qty;
        }

        // --- MULAI TRANSAKSI ---
        $order = DB::transaction(function () use ($carts, $user, $request, $totalPrice) {
            
            // Gabung Alamat & No HP
            $fullAddress = $request->address . " (No HP: " . $request->phone . ")";

            // 1. BUAT ORDER
            $newOrder = Order::create([
                'user_id' => $user->id,
                'invoice_code' => 'INV-' . strtoupper(Str::random(10)),
                'total_price' => $totalPrice,
                'payment_status' => '1', // Asumsi langsung lunas/menunggu bayar
                'delivery_status' => 'pending',
                'address' => $fullAddress, 
            ]);

            // 2. PINDAHKAN ITEM KE ORDER DETAILS
            foreach ($carts as $cart) {
                OrderItem::create([
                    'order_id' => $newOrder->id,
                    'product_id' => $cart->product_id,
                    'product_name' => $cart->product->name,
                    'qty' => $cart->qty,
                    'price' => $cart->product->price,
                ]);
            }

            // 3. KOSONGKAN KERANJANG
            Cart::where('user_id', $user->id)->delete();

            // ==========================================
            // 📹 PASANG CCTV (AUDIT TRAIL) DISINI BANG!
            // ==========================================
            ActivityLog::create([
                'user_id' => $user->id,
                'action'  => 'CREATE ORDER',
                'description' => "Checkout Order #" . $newOrder->invoice_code . " (Rp " . number_format($newOrder->total_price) . ")"
            ]);
            // ==========================================

            return $newOrder;
        });

        return redirect()->route('orders.show', $order->id)->with('success', 'Pesanan berhasil! Silakan lakukan pembayaran.');
    }
}