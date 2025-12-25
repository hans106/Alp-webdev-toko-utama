<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Restock extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'product_id',
        'date',
        'qty',
        'buy_price'
    ];

    public function supplier(): BelongsTo {
        return $this->belongsTo(Supplier::class);
    }

    public function product(): BelongsTo {
        return $this->belongsTo(Product::class);
    }
}
