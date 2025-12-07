<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\ProductImage;



class Product extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function productImages()
    {
        return $this->hasMany(ProductImage::class);
        // PENTING: Pastikan nama file modelnya ProductImage.php (bukan ProdcutImage)
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
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
}
