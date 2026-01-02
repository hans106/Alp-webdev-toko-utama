<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RestockVerification extends Model
{
    protected $fillable = [
        'restock_id',
        'verified_by',
        'status',
        'notes',
        'expected_total',
        'actual_total',
        'matches',
        'verified_at'
    ];

    protected $casts = [
        'verified_at' => 'datetime',
        'matches' => 'boolean',
        'expected_total' => 'decimal:2',
        'actual_total' => 'decimal:2'
    ];

    // Relation ke Restock
    public function restock()
    {
        return $this->belongsTo(Restock::class);
    }

    // Relation ke User (yang verify)
    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    // Helper: Format expected total
    public function getExpectedTotalFormatted()
    {
        return $this->expected_total ? 'Rp ' . number_format($this->expected_total, 0, ',', '.') : '-';
    }

    // Helper: Format actual total
    public function getActualTotalFormatted()
    {
        return $this->actual_total ? 'Rp ' . number_format($this->actual_total, 0, ',', '.') : '-';
    }

    // Helper: Status badge class
    public function getStatusBadgeClass()
    {
        return match($this->status) {
            'pending' => 'bg-yellow-100 text-yellow-700',
            'verified' => 'bg-green-100 text-green-700',
            'rejected' => 'bg-red-100 text-red-700',
            default => 'bg-gray-100 text-gray-700'
        };
    }

    // Helper: Status label
    public function getStatusLabel()
    {
        return match($this->status) {
            'pending' => 'Menunggu Verifikasi',
            'verified' => 'Sudah Diverifikasi',
            'rejected' => 'Ditolak',
            default => strtoupper($this->status)
        };
    }
}
