<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderChecklist extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'admin_id',
        'recipient_name',
        'items_count',
        'notes',
        'sent_at'
    ];

    protected $casts = [
        'sent_at' => 'datetime'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
