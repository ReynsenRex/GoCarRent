<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Services\CarSearchService;
use App\Services\CarAvailabilityService;
use Illuminate\Http\Request;

class CarController extends Controller
{
    protected $searchService;
    protected $availabilityService;

    public function __construct(CarSearchService $searchService, CarAvailabilityService $availabilityService)
    {
        $this->searchService = $searchService;
        $this->availabilityService = $availabilityService;
    }

    /**
     * Display car listing with search functionality
     */
    public function index(Request $request)
    {
        $filters = $request->only([
            'location', 'transmission', 'fuel_type', 'capacity',
            'min_price', 'max_price', 'brand', 'search',
            'start_date', 'end_date'
        ]);

        // If date range is provided, get available cars
        if (!empty($filters['start_date']) && !empty($filters['end_date'])) {
            $cars = $this->searchService->getAvailableCarsForDateRange(
                $filters['start_date'],
                $filters['end_date'],
                $filters
            );
            $cars = $cars->paginate(12);
        } else {
            // Regular search without date filtering
            $cars = $this->searchService->searchCars($filters)
                ->latest()
                ->paginate(12)
                ->withQueryString();
        }

        // Get filter options for dropdowns
        $filterOptions = $this->getFilterOptions();

        return view('customer.cars.index', compact('cars', 'filterOptions', 'filters'));
    }

    /**
     * Show car details
     */
    public function show($id, Request $request)
    {
        $car = Car::findOrFail($id);
        
        // Get availability calendar for next 90 days
        $availabilityCalendar = $this->availabilityService->getAvailabilityCalendar($car->id);
        
        // Get booked dates for JavaScript
        $bookedDates = $this->availabilityService->getBookedDates($car->id);
        
        // Calculate price if dates provided
        $priceCalculation = null;
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $priceCalculation = $this->searchService->calculateRentalPrice(
                $car->id,
                $request->start_date,
                $request->end_date
            );
        }

        return view('customer.cars.show', compact('car', 'availabilityCalendar', 'bookedDates', 'priceCalculation'));
    }

    /**
     * AJAX endpoint for price calculation
     */
    public function calculatePrice(Request $request)
    {
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
        ]);

        try {
            $calculation = $this->searchService->calculateRentalPrice(
                $request->car_id,
                $request->start_date,
                $request->end_date
            );

            // Check availability
            $isAvailable = $this->availabilityService->isDateRangeAvailable(
                $request->car_id,
                $request->start_date,
                $request->end_date
            );

            return response()->json([
                'success' => true,
                'calculation' => $calculation,
                'available' => $isAvailable
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan dalam perhitungan harga.'
            ], 400);
        }
    }

    /**
     * Get filter options for search form
     */
    private function getFilterOptions(): array
    {
        return [
            'brands' => Car::distinct()->pluck('brand')->sort()->values(),
            'transmissions' => ['manual', 'automatic'],
            'fuel_types' => Car::distinct()->pluck('fuel_type')->sort()->values(),
            'locations' => ['jakarta', 'surabaya', 'bandung', 'medan'], // You can make this dynamic
        ];
    }
}