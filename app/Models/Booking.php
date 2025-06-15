<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'car_id',
        'start_date',
        'end_date',
        'total_price',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'total_price' => 'decimal:2',
        ];
    }

    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    // Available statuses
    public static function getStatuses()
    {
        return [
            self::STATUS_PENDING => 'Pending',
            self::STATUS_APPROVED => 'Disetujui',
            self::STATUS_REJECTED => 'Ditolak',
            self::STATUS_COMPLETED => 'Selesai',
            self::STATUS_CANCELLED => 'Dibatalkan',
        ];
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function penalty()
    {
        return $this->hasOne(Penalty::class);
    }

    // Accessors & Mutators
    public function getDurationAttribute()
    {
        return $this->start_date->diffInDays($this->end_date) + 1;
    }

    public function getStatusLabelAttribute()
    {
        $statuses = self::getStatuses();
        return $statuses[$this->status] ?? ucfirst($this->status);
    }

    public function getStatusColorAttribute()
    {
        switch ($this->status) {
            case self::STATUS_PENDING:
                return 'warning';
            case self::STATUS_APPROVED:
                return 'success';
            case self::STATUS_REJECTED:
                return 'danger';
            case self::STATUS_COMPLETED:
                return 'primary';
            case self::STATUS_CANCELLED:
                return 'secondary';
            default:
                return 'light';
        }
    }

    // Helper methods for status checking
    public function isPending()
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isApproved()
    {
        return $this->status === self::STATUS_APPROVED;
    }

    public function isRejected()
    {
        return $this->status === self::STATUS_REJECTED;
    }

    public function isCompleted()
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    public function isCancelled()
    {
        return $this->status === self::STATUS_CANCELLED;
    }

    // Check if booking can be approved
    public function canBeApproved()
    {
        return $this->isPending();
    }

    // Check if booking can be rejected
    public function canBeRejected()
    {
        return $this->isPending();
    }

    // Check if booking can be completed
    public function canBeCompleted()
    {
        return $this->isApproved();
    }

    // Check if booking can be cancelled
    public function canBeCancelled()
    {
        return in_array($this->status, [self::STATUS_PENDING, self::STATUS_APPROVED]);
    }

    // Check if booking can be deleted
    public function canBeDeleted()
    {
        return in_array($this->status, [self::STATUS_PENDING, self::STATUS_CANCELLED]);
    }

    // Check if booking can be edited
    public function canBeEdited()
    {
        return !in_array($this->status, [self::STATUS_COMPLETED, self::STATUS_REJECTED]);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', self::STATUS_APPROVED);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', self::STATUS_COMPLETED);
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', [self::STATUS_PENDING, self::STATUS_APPROVED]);
    }

    public function scopeByDateRange($query, $startDate = null, $endDate = null)
    {
        if ($startDate) {
            $query->whereDate('start_date', '>=', $startDate);
        }
        
        if ($endDate) {
            $query->whereDate('end_date', '<=', $endDate);
        }
        
        return $query;
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByCar($query, $carId)
    {
        return $query->where('car_id', $carId);
    }

    // Boot method for model events
    protected static function boot()
    {
        parent::boot();

        // Auto-set status to pending when creating new booking
        static::creating(function ($booking) {
            if (empty($booking->status)) {
                $booking->status = self::STATUS_PENDING;
            }
        });

        // Update car status when booking status changes
        static::updated(function ($booking) {
            if ($booking->isDirty('status')) {
                $booking->updateCarStatus();
            }
        });
    }

    // Update car status based on booking status
    public function updateCarStatus()
    {
        switch ($this->status) {
            case self::STATUS_APPROVED:
                $this->car->update(['status' => 'booked']);
                break;
                
            case self::STATUS_COMPLETED:
            case self::STATUS_REJECTED:
            case self::STATUS_CANCELLED:
                // Only update to available if no other active bookings for this car
                $activeBookings = self::where('car_id', $this->car_id)
                    ->whereIn('status', [self::STATUS_PENDING, self::STATUS_APPROVED])
                    ->where('id', '!=', $this->id)
                    ->count();
                    
                if ($activeBookings === 0) {
                    $this->car->update(['status' => 'available']);
                }
                break;
        }
    }

    // Calculate and update total price
    public function calculateTotalPrice()
    {
        if ($this->car && $this->start_date && $this->end_date) {
            $duration = $this->duration;
            $this->total_price = $this->car->price_per_day * $duration;
            return $this->total_price;
        }
        
        return 0;
    }

    // Check if booking dates overlap with another booking
    public function hasDateConflict()
    {
        return self::where('car_id', $this->car_id)
            ->where('id', '!=', $this->id)
            ->whereIn('status', [self::STATUS_PENDING, self::STATUS_APPROVED])
            ->where(function ($query) {
                $query->whereBetween('start_date', [$this->start_date, $this->end_date])
                    ->orWhereBetween('end_date', [$this->start_date, $this->end_date])
                    ->orWhere(function ($q) {
                        $q->where('start_date', '<=', $this->start_date)
                          ->where('end_date', '>=', $this->end_date);
                    });
            })
            ->exists();
    }

    // Get formatted price
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->total_price, 0, ',', '.');
    }

    // Get formatted date range
    public function getDateRangeAttribute()
    {
        return $this->start_date->format('d/m/Y') . ' - ' . $this->end_date->format('d/m/Y');
    }
}