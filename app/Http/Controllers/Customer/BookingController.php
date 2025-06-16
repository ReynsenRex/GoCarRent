<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Booking;
use App\Services\CarAvailabilityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    protected $availabilityService;

    public function __construct(CarAvailabilityService $availabilityService)
    {
        $this->availabilityService = $availabilityService;
    }

    /**
     * Store booking
     */
    public function store(Request $request)
    {
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'notes' => 'nullable|string|max:500',
        ]);

        $car = Car::findOrFail($request->car_id);

        // Check availability using service
        if (!$this->availabilityService->isDateRangeAvailable(
            $car->id, 
            $request->start_date, 
            $request->end_date
        )) {
            return back()->withErrors(['date' => 'Tanggal yang dipilih tidak tersedia.']);
        }

        // Calculate price
        $startDate = new \DateTime($request->start_date);
        $endDate = new \DateTime($request->end_date);
        $duration = $startDate->diff($endDate)->days + 1;
        $subtotal = $duration * $car->price_per_day;
        $tax = $subtotal * 0.1; // 10% tax
        $totalPrice = $subtotal + $tax;

        DB::transaction(function () use ($request, $totalPrice) {
            Booking::create([
                'user_id' => Auth::id(),
                'car_id' => $request->car_id,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'total_price' => $totalPrice,
                'status' => 'pending',
                'notes' => $request->notes,
            ]);
        });

        return redirect()->route('customer.bookings.index')
            ->with('success', 'Pemesanan berhasil dibuat! Menunggu konfirmasi admin.');
    }

    /**
     * Display user bookings
     */
    public function index()
    {
        $bookings = Booking::where('user_id', Auth::id())
            ->with(['car', 'payment'])
            ->latest()
            ->paginate(10);

        return view('customer.bookings.index', compact('bookings'));
    }

    /**
     * Show booking details
     */
    public function show($id)
    {
        $booking = Booking::where('user_id', Auth::id())
            ->with(['car', 'payment', 'penalty'])
            ->findOrFail($id);

        return view('customer.bookings.show', compact('booking'));
    }

    /**
     * Cancel booking
     */
    public function cancel($id)
    {
        $booking = Booking::where('user_id', Auth::id())->findOrFail($id);

        // Only allow cancellation for pending bookings
        if ($booking->status !== 'pending') {
            return redirect()->route('customer.bookings.index')
                ->with('error', 'Pemesanan tidak dapat dibatalkan karena sudah diproses.');
        }

        DB::transaction(function () use ($booking) {
            $booking->update([
                'status' => 'cancelled',
                'notes' => $booking->notes . ' - Dibatalkan oleh customer pada ' . now()->format('d M Y H:i')
            ]);
        });

        return redirect()->route('customer.bookings.index')
            ->with('success', 'Pemesanan berhasil dibatalkan.');
    }
}
