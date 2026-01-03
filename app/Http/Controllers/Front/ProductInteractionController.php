<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductReview;
use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductInteractionController extends Controller
{
    // Store a product review
    public function storeReview(Request $request, $id)
    {
        if (!Auth::check()) {
            return $request->expectsJson() ? response()->json(['error' => 'Unauthenticated'], 401) : redirect()->route('login');
        }

        $product = Product::findOrFail($id);

        $data = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000'
        ]);

        $review = ProductReview::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'rating' => $data['rating'],
            'comment' => $data['comment'] ?? null,
        ]);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'review' => $review]);
        }

        return redirect()->back()->with('success', 'Terima kasih atas ulasan Anda!');
    }

    // Toggle favorite (wishlist) for product
    public function toggleFavorite(Request $request, $id)
    {
        if (!Auth::check()) {
            return $request->expectsJson() ? response()->json(['error' => 'Unauthenticated'], 401) : redirect()->route('login');
        }

        $product = Product::findOrFail($id);

        $existing = Wishlist::where('user_id', Auth::id())->where('product_id', $product->id)->first();

        if ($existing) {
            $existing->delete();
            if ($request->expectsJson()) {
                return response()->json(['success' => true, 'status' => 'removed']);
            }
            return redirect()->back()->with('success', 'Dihapus dari favorit');
        }

        $wish = Wishlist::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
        ]);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'status' => 'added']);
        }

        return redirect()->back()->with('success', 'Ditambahkan ke favorit');
    }
}
