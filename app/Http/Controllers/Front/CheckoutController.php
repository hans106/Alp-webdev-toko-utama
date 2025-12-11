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

        // VALIDASI: Wajib isi alamat dan nomor HP
        $request->validate([
            'address' => 'required|string|min:10',
            'phone' => 'required|numeric|min_digits:10', // WAJIB ANGKA
            'notes' => 'nullable|string'
        ]);

        // PERBAIKAN PENTING: Tampung hasil transaksi ke variabel $order
        $order = DB::transaction(function () use ($request) {
            $user = Auth::user();
            $carts = Cart::with('product')->where('user_id', $user->id)->get();

            $totalPrice = 0;
            foreach ($carts as $cart) {
                // PERBAIKAN: Pakai 'qty'
                $totalPrice += $cart->product->price * $cart->qty;
            }

            // --- TRIK GABUNG ALAMAT & NO HP ---
            $fullAddress = $request->address . " (No HP: " . $request->phone . ")";

            // BUAT ORDER
            // Saya namakan $newOrder biar jelas
            $newOrder = Order::create([
                'user_id' => $user->id,
                'invoice_code' => 'INV-' . strtoupper(Str::random(10)),
                'total_price' => $totalPrice,
                'payment_status' => '1',
                'delivery_status' => 'pending',
                'address' => $fullAddress, 
            ]);

            // PINDAHKAN ITEM
            foreach ($carts as $cart) {
                OrderItem::create([
                    'order_id' => $newOrder->id,
                    'product_id' => $cart->product_id,
                    'product_name' => $cart->product->name,
                    'qty' => $cart->qty, // Sudah benar pakai qty
                    'price' => $cart->product->price,
                ]);
            }

            // KOSONGKAN CART
            Cart::where('user_id', $user->id)->delete();

            // PENTING: Kembalikan objek order keluar dari fungsi transaksi
            return $newOrder;
        });

        // Redirect langsung ke Halaman Detail Pesanan (Nota)
        // Sekarang variabel $order sudah dikenali karena di-return dari transaction di atas
        return redirect()->route('orders.show', $order->id)->with('success', 'Pesanan berhasil! Silakan lakukan pembayaran.');
    }
}