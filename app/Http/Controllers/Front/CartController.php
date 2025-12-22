<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // 1. TAMPILKAN KERANJANG
    public function index()
    {
        $carts = Cart::with('product')->where('user_id', Auth::id())->get();
        
        $totalPrice = 0;
        foreach($carts as $cart) {
            // PERBAIKAN: Pakai 'qty' bukan 'quantity'
            $totalPrice += $cart->product->price * $cart->qty;
        }

        return view('front.cart', compact('carts', 'totalPrice'));
    }

    // 2. TAMBAH KE KERANJANG
    public function store(Request $request, $id)
    {
        if (Auth::user()->role === 'admin') {
            return redirect()->back()->with('error', 'Admin tidak boleh belanja woy!');
        }

        $product = Product::findOrFail($id);

        if ($product->stock < 1) {
            return redirect()->back()->with('error', 'Stok habis bosku!');
        }

        $existingCart = Cart::where('user_id', Auth::id())
                            ->where('product_id', $id)
                            ->first();

        if ($existingCart) {
            $existingCart->qty += 1;
            $existingCart->save();
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $id,
                'qty' => 1 
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Barang masuk keranjang!');
    }

    // 3. UPDATE JUMLAH (+/-)
    public function update(Request $request, $id)
    {
        $cart = Cart::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        
        if ($request->type == 'minus') {
            // PERBAIKAN: qty
            if ($cart->qty > 1) {
                $cart->decrement('qty');
            }
        } else {
            // PERBAIKAN: qty
            if ($cart->qty < $cart->product->stock) {
                $cart->increment('qty');
            } else {
                return redirect()->back()->with('error', 'Stok mentok bang!');
            }
        }

        return redirect()->back();
    }

    // 4. HAPUS ITEM (Tetap sama)
    public function destroy($id)
    {
        $cart = Cart::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $cart->delete();
        return redirect()->back()->with('success', 'Barang dihapus dari keranjang.');
    }
}