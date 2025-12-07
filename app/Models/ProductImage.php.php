<?php

namespace App\Models; // <--- Cek baris ini, pastikan App\Models

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model // <--- Cek tulisan ini (Jangan Prodcut)
{
    use HasFactory;
    
    protected $guarded = ['id'];
    
    // Opsional: Kalau tabel di database namanya 'product_images' (plural), 
    // Laravel otomatis tahu. Tapi kalau beda, tambahkan:
    // protected $table = 'product_images';
}