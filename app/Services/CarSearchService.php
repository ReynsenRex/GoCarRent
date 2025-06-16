<?php

namespace App\Services;

use App\Models\Car;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class CarSearchService
{
    protected $availabilityService;

    public function __construct(CarAvailabilityService $availabilityService)
    {
        $this->availabilityService = $availabilityService;
    }

    /**
     * Search cars with filters
     */
    public function searchCars(array $filters = []): Builder
    {
        $query = Car::where('availability_status', 'available');

        // Filter by location (if you have location field)
        if (!empty($filters['location'])) {
            $query->where('location', $filters['location']);
        }

        // Filter by transmission
        if (!empty($filters['transmission'])) {
            $query->where('transmission', $filters['transmission']);
        }

        // Filter by fuel type
        if (!empty($filters['fuel_type'])) {
            $query->where('fuel_type', $filters['fuel_type']);
        }

        // Filter by capacity
        if (!empty($filters['capacity'])) {
            $query->where('capacity', '>=', $filters['capacity']);
        }

        // Filter by price range
        if (!empty($filters['min_price'])) {
            $query->where('price_per_day', '>=', $filters['min_price']);
        }

        if (!empty($filters['max_price'])) {
            $query->where('price_per_day', '<=', $filters['max_price']);
        }

        // Filter by brand
        if (!empty($filters['brand'])) {
            $query->where('brand', 'ILIKE', "%{$filters['brand']}%");
        }

        // Search by keywords
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('brand', 'ILIKE', "%{$search}%")
                  ->orWhere('model', 'ILIKE', "%{$search}%");
            });
        }

        return $query;
    }

    /**
     * Get available cars for specific date range
     */
    public function getAvailableCarsForDateRange(string $startDate, string $endDate, array $filters = [])
    {
        $cars = $this->searchCars($filters)->get();
        $availableCars = collect();

        foreach ($cars as $car) {
            if ($this->availabilityService->isDateRangeAvailable($car->id, $startDate, $endDate)) {
                $availableCars->push($car);
            }
        }

        return $availableCars;
    }

    /**
     * Calculate rental price
     */
    public function calculateRentalPrice(int $carId, string $startDate, string $endDate): array
    {
        $car = Car::findOrFail($carId);
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);
        $days = $start->diffInDays($end) + 1;
        
        $subtotal = $car->price_per_day * $days;
        $tax = $subtotal * 0.1; // 10% tax
        $total = $subtotal + $tax;

        return [
            'days' => $days,
            'price_per_day' => $car->price_per_day,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total
        ];
    }
}