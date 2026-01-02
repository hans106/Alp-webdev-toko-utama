<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductReview extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'product_id', 'rating', 'comment'];

    // Relasi: Review ditulis oleh siapa? (User)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Review untuk produk apa? (Product)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
