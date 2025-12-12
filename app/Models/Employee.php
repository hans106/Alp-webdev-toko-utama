<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // Tabel ini berdiri sendiri (Standalone) untuk fitur "Tentang Kami"
    // Jadi biasanya tidak butuh relasi 'belongsTo' atau 'hasMany' ke tabel lain.
}