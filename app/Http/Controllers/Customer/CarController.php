<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Services\CarSearchService;
use App\Services\CarAvailabilityService;
use Illuminate\Http\Request;
use App\Models\Promo;
use Carbon\Carbon;

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
            'location',
            'transmission',
            'fuel_type',
            'capacity',
            'min_price',
            'max_price',
            'brand',
            'search',
            'start_date',
            'end_date'
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

        // Ambil semua promo aktif (bisa tambahkan where jika hanya ingin yang masih berlaku)
        $promos = Promo::all();

        return view('customer.cars.show', compact('car', 'availabilityCalendar', 'bookedDates', 'priceCalculation', 'promos'));
    }

    public function showPopularCars()
    {
        // Ambil semua mobil yang tersedia
        $cars = Car::where('availability_status', 'available')->get();

        return view('home', compact('cars')); // Ganti 'home' sesuai blade-mu
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
            'promo_code' => 'nullable|string|exists:promos,code', // Tambah validasi promo_code
        ]);

        try {
            $car = Car::findOrFail($request->car_id);

            $start = Carbon::parse($request->start_date);
            $end = Carbon::parse($request->end_date);
            $days = $start->diffInDays($end);

            $pricePerDay = $car->price_per_day;
            $subtotal = $days * $pricePerDay;

            $discount = 0;

            // Cek promo berdasarkan code yang dipilih user (jika ada)
            if ($request->filled('promo_code')) {
                $promo = Promo::where('code', $request->promo_code)->first();
                if ($promo) {
                    $discount = ($subtotal * $promo->discount_pct) / 100;
                }
            }

            $afterDiscount = $subtotal - $discount;
            $tax = $afterDiscount * 0.10;
            $total = $afterDiscount + $tax;

            $isAvailable = $this->availabilityService->isDateRangeAvailable(
                $request->car_id,
                $request->start_date,
                $request->end_date
            );

            return response()->json([
                'success' => true,
                'available' => $isAvailable,
                'calculation' => [
                    'days' => $days,
                    'price_per_day' => $pricePerDay,
                    'subtotal' => $subtotal,
                    'discount' => $discount,
                    'tax' => $tax,
                    'total' => $total,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan dalam perhitungan harga.',
                'error' => $e->getMessage()
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
