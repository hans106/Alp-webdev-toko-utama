<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    // Izinkan semua kolom diisi kecuali ID
    protected $guarded = ['id'];

    // Relasi: Wishlist milik siapa? (User)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Produk apa yang disukai? (Product)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}