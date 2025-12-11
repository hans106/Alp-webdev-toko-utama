<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

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
}
