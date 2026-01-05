<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderChecklistItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_checklist_id',
        'product_id',
        'qty_required',
        'qty_checked',
        'status',
        'notes'
    ];

    public function checklist()
    {
        return $this->belongsTo(OrderChecklist::class, 'order_checklist_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
