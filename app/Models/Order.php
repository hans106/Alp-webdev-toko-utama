<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Midtrans\Config;
use Midtrans\Snap;

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Generate Midtrans Snap Token untuk pembayaran
     * Otomatis dipanggil ketika order diterima atau user request pembayaran
     */
    public function generateSnapToken()
    {
        // Jangan generate ulang jika sudah ada token
        if (!empty($this->snap_token)) {
            return $this->snap_token;
        }

        // Config Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Prepare transaction data
        $params = [
            'transaction_details' => [
                'order_id' => $this->invoice_code . '-' . time(),
                'gross_amount' => (int) $this->total_price,
            ],
            'customer_details' => [
                'first_name' => $this->user->name ?? 'Pelanggan',
                'email' => $this->user->email ?? 'noemail@toko.local',
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            $this->snap_token = $snapToken;
            $this->save();
            
            return $snapToken;
        } catch (\Exception $e) {
            \Log::error('Midtrans Snap Token Error: ' . $e->getMessage(), ['order_id' => $this->id]);
            return null;
        }
    }
}
