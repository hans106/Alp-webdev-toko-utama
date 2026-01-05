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
use Midtrans\Config;
use Midtrans\Snap;

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
            $totalPrice += $cart->product->price * $cart->qty;
        }

        return view('front.checkout', compact('carts', 'totalPrice'));
    }

    // 2. Proses Simpan Pesanan & GENERATE TOKEN
    public function process(Request $request)
    {
        if (Auth::user()->role !== 'customer') {
            abort(403);
        }

        // VALIDASI INPUT (address must have at least 4 words; phone allow spaces/+, but require at least 10 digits)
        $request->validate([
            'address' => ['required','string', function($attribute, $value, $fail) {
                // Count words more robustly (ignore punctuation)
                $words = preg_split('/\s+/', trim(strip_tags($value)));
                $words = array_filter($words, function($w) {
                    return preg_match('/\p{L}|\p{N}/u', $w);
                });
                if (count($words) < 4) {
                    $fail('Alamat harus terdiri dari minimal 4 kata.');
                }
            }],
            'phone' => ['required','string', function($attribute, $value, $fail) {
                $digits = preg_replace('/\D+/', '', $value);
                if (strlen($digits) < 10) {
                    $fail('Nomor WA harus berisi minimal 10 digit angka.');
                }
            }],
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
        try {
            $order = DB::transaction(function () use ($carts, $user, $request, $totalPrice) {

                // Gabung Alamat & No HP
                $fullAddress = $request->address . " (No HP: " . $request->phone . ")";

                // A. BUAT ORDER - DIPERBAIKI: Gunakan 'status' bukan 'payment_status'/'delivery_status'
                $newOrder = Order::create([
                    'user_id' => $user->id,
                    'invoice_code' => 'INV-' . strtoupper(Str::random(10)),
                    'total_price' => $totalPrice,
                    'status' => 'pending',  // <-- DIPERBAIKI: dari payment_status/delivery_status jadi status
                    'address' => $fullAddress,
                ]);

                // B. PINDAHKAN ITEM KE ORDER DETAILS
                foreach ($carts as $cart) {
                    OrderItem::create([
                        'order_id' => $newOrder->id,
                        'product_id' => $cart->product_id,
                        'product_name' => $cart->product->name,
                        'qty' => $cart->qty,
                        'price' => $cart->product->price,
                    ]);
                }

                // C. KOSONGKAN KERANJANG
                Cart::where('user_id', $user->id)->delete();

                // D. LOG AKTIVITAS (CCTV)
                ActivityLog::create([
                    'user_id' => $user->id,
                    'action'  => 'CREATE ORDER',
                    'description' => "Checkout Order #" . $newOrder->invoice_code . " (Rp " . number_format($newOrder->total_price) . ")"
                ]);

                // ==========================================
                // E. PROSES MIDTRANS (THE MAGIC)
                // ==========================================

                // 1. Set Konfigurasi
                Config::$serverKey = config('midtrans.server_key');
                Config::$isProduction = config('midtrans.is_production', false);
                Config::$isSanitized = true;
                Config::$is3ds = true;

                // 2. Siapkan Parameter Midtrans
                $params = [
                    'transaction_details' => [
                        'order_id' => $newOrder->invoice_code, // Pakai Invoice Code biar unik
                        'gross_amount' => (int) $newOrder->total_price, // Harus Integer
                    ],
                    'customer_details' => [
                        'first_name' => $user->name,
                        'email' => $user->email,
                        'phone' => $request->phone,
                    ],
                ];

                // 3. Minta Token ke Midtrans
                $snapToken = Snap::getSnapToken($params);

                // 4. Simpan Token ke Database Order
                $newOrder->snap_token = $snapToken;
                $newOrder->save();

                return $newOrder;
            });
        } catch (\Exception $e) {
            // Kalau error, kembalikan ke halaman sebelumnya dengan pesan error
            return redirect()->back()->with('error', 'Gagal memproses pesanan: ' . $e->getMessage())->withInput();
        }

        // Redirect ke Halaman Detail Pesanan (Untuk Bayar)
        return redirect()->route('orders.show', $order->id)->with('success', 'Pesanan berhasil dibuat. Silakan bayar sekarang!');
    }
}