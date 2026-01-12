<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone', // TAMBAHAN: Biar bisa simpan no hp
        'role',  // TAMBAHAN: Biar bisa set admin/customer
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
        ];
    }

    // --- RELASI ---

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    // TAMBAHAN PENTING: User punya banyak Order (Pesanan)
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // User punya banyak barang Wishlist
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    // User punya banyak Product Reviews
    public function productReviews()
    {
        return $this->hasMany(ProductReview::class);
    }
}