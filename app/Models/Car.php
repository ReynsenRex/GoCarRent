<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand',
        'model',
        'year',
        'transmission',
        'price_per_day',
        'availability_status',
        'image_url',
        'description',
        'capacity',
        'fuel_type',
    ];

    protected function casts(): array
    {
        return [
            'price_per_day' => 'decimal:2',
            'year' => 'integer',
            'capacity' => 'integer',
        ];
    }

    // Relationships
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // Helper methods
    public function isAvailable()
    {
        return $this->availability_status === 'available';
    }

    public function isRented()
    {
        return $this->availability_status === 'rented';
    }

    public function inMaintenance()
    {
        return $this->availability_status === 'maintenance';
    }
}
