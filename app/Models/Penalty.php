<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penalty extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'days_late',
        'fine_amount',
        'paid_status',
        'paid_at',
        'reason',
    ];

    protected function casts(): array
    {
        return [
            'fine_amount' => 'decimal:2',
            'days_late' => 'integer',
            'paid_at' => 'datetime',
        ];
    }

    // Relationships
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    // Helper methods
    public function isPaid()
    {
        return $this->paid_status === 'paid';
    }

    public function isUnpaid()
    {
        return $this->paid_status === 'unpaid';
    }
}
