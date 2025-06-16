<?php

namespace App\Services;

use App\Models\Car;
use Carbon\Carbon;

class BookingPriceService
{
    /**
     * Calculate total price for a booking
     */
    public function calculatePrice(Car $car, string $startDate, string $endDate): float
    {
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);
        $days = $start->diffInDays($end) + 1;
        
        return $car->price_per_day * $days;
    }

    /**
     * Calculate duration in days
     */
    public function calculateDuration(string $startDate, string $endDate): int
    {
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);
        
        return $start->diffInDays($end) + 1;
    }

    /**
     * Get price breakdown
     */
    public function getPriceBreakdown(Car $car, string $startDate, string $endDate): array
    {
        $duration = $this->calculateDuration($startDate, $endDate);
        $totalPrice = $this->calculatePrice($car, $startDate, $endDate);

        return [
            'duration' => $duration,
            'price_per_day' => $car->price_per_day,
            'total_price' => $totalPrice,
            'formatted_total' => number_format($totalPrice, 0, ',', '.')
        ];
    }
}