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

    // 2. TAMBAH KE KERANJANG (Support redirect back atau JSON untuk AJAX)
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
            if ($existingCart->qty < $product->stock) {
                $existingCart->qty += 1;
                $existingCart->save();
            } else {
                if ($request->expectsJson()) {
                    return response()->json(['error' => 'Stok tidak cukup'], 422);
                }
                return redirect()->back()->with('error', 'Stok tidak cukup!');
            }
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $id,
                'qty' => 1 
            ]);
        }

        if ($request->expectsJson()) {
            $cart = Cart::where('user_id', Auth::id())
                        ->where('product_id', $id)
                        ->first();
            return response()->json([
                'success' => true,
                'message' => 'Barang masuk keranjang!',
                'cart' => $cart,
                'cartCount' => Cart::where('user_id', Auth::id())->count()
            ]);
        }

        return redirect()->back()->with('success', 'Barang masuk keranjang!');
    }

    // 3. UPDATE JUMLAH (+/-) dengan validasi stock dan auto-remove jika qty < 1
    public function update(Request $request, $id)
    {
        $cart = Cart::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $product = $cart->product;
        
        if ($request->type == 'minus') {
            if ($cart->qty > 1) {
                $cart->decrement('qty');
            } else {
                // Qty < 1, hapus dari cart
                $cart->delete();
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Barang dihapus dari keranjang',
                        'newQty' => 0,
                        'cartCount' => Cart::where('user_id', Auth::id())->count()
                    ]);
                }
                return redirect()->back()->with('success', 'Barang dihapus dari keranjang.');
            }
        } elseif ($request->type == 'plus') {
            if ($cart->qty < $product->stock) {
                $cart->increment('qty');
            } else {
                if ($request->expectsJson()) {
                    return response()->json(['error' => 'Stok tidak cukup!'], 422);
                }
                return redirect()->back()->with('error', 'Stok mentok bang!');
            }
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'newQty' => $cart->qty,
                'cartCount' => Cart::where('user_id', Auth::id())->count()
            ]);
        }

        return redirect()->back();
    }

    // 4. HAPUS ITEM
    public function destroy($id)
    {
        $cart = Cart::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $cart->delete();
        
        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Barang dihapus dari keranjang.',
                'cartCount' => Cart::where('user_id', Auth::id())->count()
            ]);
        }
        
        return redirect()->back()->with('success', 'Barang dihapus dari keranjang.');
    }
}