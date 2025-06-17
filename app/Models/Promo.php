<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'description',
        'discount_pct',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'discount_pct' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the discount amount for a given total.
     */
    public function getDiscountAmount($total)
    {
        return $total * ($this->discount_pct / 100);
    }

    /**
     * Get the final amount after discount.
     */
    public function getFinalAmount($total)
    {
        return $total - $this->getDiscountAmount($total);
    }

    /**
     * Scope to find active promos (you can add more conditions as needed).
     */
    public function scopeActive($query)
    {
        return $query->where('discount_pct', '>', 0);
    }
}