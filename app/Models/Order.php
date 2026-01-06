<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Log;

class Order extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];

    // Cast timestamp fields to Carbon instances so ->format() works in views
    protected $casts = [
        'paid_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function checklist()
    {
        return $this->hasOne(OrderChecklist::class);
    }

    /**
     * Generate Midtrans Snap Token untuk pembayaran
     * Otomatis dipanggil ketika order pending atau user request pembayaran
     */
    public function generateSnapToken()
    {
        // Jika sudah ada snap token yang valid, return langsung
        if (!empty($this->snap_token)) {
            Log::info('Snap token already exists', ['order_id' => $this->id]);
            return $this->snap_token;
        }

        // Validasi config Midtrans
        $serverKey = config('midtrans.server_key');
        $clientKey = config('midtrans.client_key');
        
        if (empty($serverKey) || empty($clientKey)) {
            Log::error('Midtrans config not set!', [
                'server_key' => $serverKey ? 'exists' : 'MISSING',
                'client_key' => $clientKey ? 'exists' : 'MISSING',
            ]);
            return null;
        }

        // Konfigurasi Midtrans
        \Midtrans\Config::$serverKey = $serverKey;
        \Midtrans\Config::$isProduction = config('midtrans.is_production', false);
        \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized', true);
        \Midtrans\Config::$is3ds = config('midtrans.is_3ds', true);

        // Validasi order items
        if ($this->orderItems->isEmpty()) {
            Log::error('Order has no items!', ['order_id' => $this->id]);
            return null;
        }

        // Parameter transaksi
        $params = [
            'transaction_details' => [
                'order_id' => $this->invoice_code . '-' . time(), 
                'gross_amount' => (int) $this->total_price,
            ],
            'customer_details' => [
                'first_name' => $this->user->name ?? 'Customer',
                'email' => $this->user->email ?? 'customer@example.com',
                'phone' => $this->user->phone ?? '08123456789',
            ],
            'item_details' => $this->orderItems->map(function($item) {
                return [
                    'id' => $item->product_id,
                    'price' => (int) $item->price,
                    'quantity' => $item->qty,
                    'name' => $item->product->name ?? 'Product',
                ];
            })->toArray(),
        ];

        Log::info('Generating Snap Token', [
            'order_id' => $this->id,
            'invoice_code' => $this->invoice_code,
            'amount' => $this->total_price,
            'items_count' => $this->orderItems->count(),
        ]);

        try {
            // Generate snap token dari Midtrans
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            
            Log::info('Snap Token Generated Successfully', [
                'order_id' => $this->id,
                'token_preview' => substr($snapToken, 0, 20) . '...'
            ]);
            
            // Simpan snap token ke database
            $this->update(['snap_token' => $snapToken]);
            
            return $snapToken;
            
        } catch (\Exception $e) {
            // Catch semua exception (termasuk Midtrans errors)
            Log::error('Snap Token Generation Error', [
                'order_id' => $this->id,
                'invoice_code' => $this->invoice_code,
                'error_message' => $e->getMessage(),
                'error_code' => $e->getCode(),
                'error_class' => get_class($e),
            ]);
            
            return null;
        }
    }
}