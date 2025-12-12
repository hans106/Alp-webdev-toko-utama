<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// HAPUS BARIS INI: use App\Models\ProductImage; (Sudah tidak dipakai)

class Product extends Model
{
    use HasFactory;
    
    // Pakai guarded biar aman (semua kolom boleh diisi kecuali ID)
    protected $guarded = ['id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    // Produk bisa ada di banyak Wishlist orang
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class); // Lebih rapi pakai ::class
    }

    public function restocks()
    {
        return $this->hasMany(Restock::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
}