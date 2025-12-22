<?php

namespace App\Http\Controllers\Admin; 

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    
    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(10);
        
        // PERBAIKAN: Pakai 'admin.orders.index' (sesuai nama folder orders pakai 's')
        return view('admin.orders.index', compact('orders'));
    }
    public function ship($id) 
    {
        $order = Order::findOrFail($id);
        if($order->status == 'paid' || $order->status == 'settlement'){
            
            $order->update(['status' => 'sent']);
            
            return redirect()->back()->with('success', 'Pesanan Berhasil Dikirim! 🚚');
        }

        return redirect()->back()->with('error', 'Pesanan Belum Lunas atau Sudah Dikirim!');
    }
}