<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        if (Auth::user()->role !== 'customer') {
            return redirect()->route('home')->with('error', 'Maaf, Admin tidak boleh ikut belanja!');
        }
        // Ambil keranjang user
        $carts = Cart::with('product')->where('user_id', Auth::id())->get();
        // Kalau keranjang kosong, tendang balik
        if($carts->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang masih kosong, belum bisa checkout.');
        }

        $totalPrice = 0;
        foreach ($carts as $cart) {
            $totalPrice += $cart->product->price * $cart->quantity;
        }

        return view('front.checkout', compact('carts', 'totalPrice'));
    }
    
    public function process(Request $request)
    {
        if (Auth::user()->role !== 'customer') {
            abort(403);
        }

        // VALIDASI: Wajib isi alamat dan nomor HP
        $request->validate([
            'address' => 'required|string|min:10',
            'phone' => 'required|numeric|min_digits:10', // WAJIB ANGKA
            'notes' => 'nullable|string'
        ]);

        DB::transaction(function () use ($request) {
            $user = Auth::user();
            $carts = Cart::with('product')->where('user_id', $user->id)->get();
            
            $totalPrice = 0;
            foreach($carts as $cart) {
                $totalPrice += $cart->product->price * $cart->qty;
            }

            // --- TRIK GABUNG ALAMAT & NO HP ---
            // Karena kita gak punya kolom 'phone' di tabel orders,
            // Kita simpan di kolom address format: "ALAMAT (No HP: 08xxx)"
            $fullAddress = $request->address . " (No HP: " . $request->phone . ")";

            // BUAT ORDER
            $order = Order::create([
                'user_id' => $user->id,
                'invoice_code' => 'INV-' . strtoupper(Str::random(10)),
                'total_price' => $totalPrice,
                'payment_status' => '1',
                'delivery_status' => 'pending',
                'address' => $fullAddress, // <--- YANG DISIMPAN ALAMAT LENGKAP
                // 'notes' gak perlu disimpan di tabel orders kalau gak ada kolomnya,
                // atau bisa digabung ke address juga kalau mau.
            ]);

            // PINDAHKAN ITEM
            foreach($carts as $cart) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cart->product_id,
                    'product_name' => $cart->product->name,
                    
                    // GANTI 'quantity' JADI 'qty' (Sesuai nama kolom di database)
                    'qty' => $cart->qty, 
                    
                    'price' => $cart->product->price,
                ]);
            }

            // KOSONGKAN CART
            Cart::where('user_id', $user->id)->delete();
        });

        return redirect()->route('home')->with('success', 'Pesanan dibuat! Silakan bayar.');
    }
}
