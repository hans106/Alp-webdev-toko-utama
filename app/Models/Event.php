<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    // Izinkan kolom ini diisi
    protected $fillable = [
        'title',
        'location',
        'event_date',
        'image',
        'description',
    ];

    // OPSIONAL: Biar Laravel otomatis tahu ini kolom tanggal
    protected $casts = [
        'event_date' => 'date',
    ];
}