<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
use HasFactory;
    
    protected $guarded = ['id']; // Biar semua kolom bisa diisi
    // Cart punya 1 Produk
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    // Cart milik 1 User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
