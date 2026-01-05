<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Wishlist;

class FavoritesController extends Controller
{
    /**
     * Get all favorites for the current user
     * GET /favorites/list
     */
    public function list(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'customer') {
            return response()->json(['success' => false, 'error' => 'Unauthorized'], 403);
        }

        $favorites = Wishlist::where('user_id', Auth::id())
            ->with('product')
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'favorites' => $favorites->map(fn($fav) => [
                'id' => $fav->id,
                'product' => [
                    'id' => $fav->product->id,
                    'name' => $fav->product->name,
                    'slug' => $fav->product->slug,
                    'price' => $fav->product->price,
                    'image_main' => (function() use ($fav) {
                        $imgPath = $fav->product->image_main ?? null;
                        if ($imgPath && preg_match('/^https?:\/\//i', $imgPath)) return $imgPath;
                        if ($imgPath && file_exists(public_path($imgPath))) return asset($imgPath);
                        if ($imgPath && file_exists(public_path('products/' . $imgPath))) return asset('products/' . $imgPath);
                        return asset('logo/logo_utama.jpeg');
                    })(),
                ]
            ])
        ]);
    }

    /**
     * Remove a favorite (wishlist item)
     * DELETE /favorites/remove/{wishlistId}
     */
    public function remove(Request $request, $wishlistId)
    {
        if (!Auth::check() || Auth::user()->role !== 'customer') {
            return response()->json(['success' => false, 'error' => 'Unauthorized'], 403);
        }

        $wishlist = Wishlist::where('id', $wishlistId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $wishlist->delete();

        return response()->json(['success' => true]);
    }
}
