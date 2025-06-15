<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Car;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'car'])
            ->orderBy('created_at', 'desc');

        // Filter by status if provided
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter by date range if provided
        if ($request->has('start_date') && $request->start_date != '') {
            $query->whereDate('start_date', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date != '') {
            $query->whereDate('end_date', '<=', $request->end_date);
        }

        $bookings = $query->paginate(10);

        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cars = Car::where('status', 'available')->get();
        $users = User::where('role', 'user')->get();
        
        return view('admin.bookings.create', compact('cars', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'notes' => 'nullable|string',
        ]);

        // Calculate total price
        $car = Car::findOrFail($request->car_id);
        $startDate = new \DateTime($request->start_date);
        $endDate = new \DateTime($request->end_date);
        $duration = $startDate->diff($endDate)->days + 1;
        $totalPrice = $car->price_per_day * $duration;

        Booking::create([
            'user_id' => $request->user_id,
            'car_id' => $request->car_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'total_price' => $totalPrice,
            'status' => 'pending',
            'notes' => $request->notes,
        ]);

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Pemesanan berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $booking = Booking::with(['user', 'car', 'payment', 'penalty'])->findOrFail($id);
        
        return view('admin.bookings.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $booking = Booking::with(['user', 'car'])->findOrFail($id);
        $cars = Car::where('status', 'available')
            ->orWhere('id', $booking->car_id)
            ->get();
        $users = User::where('role', 'user')->get();
        
        return view('admin.bookings.edit', compact('booking', 'cars', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $booking = Booking::findOrFail($id);
        
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:pending,approved,rejected,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        // Recalculate total price if dates or car changed
        if ($request->car_id != $booking->car_id || 
            $request->start_date != $booking->start_date || 
            $request->end_date != $booking->end_date) {
            
            $car = Car::findOrFail($request->car_id);
            $startDate = new \DateTime($request->start_date);
            $endDate = new \DateTime($request->end_date);
            $duration = $startDate->diff($endDate)->days + 1;
            $totalPrice = $car->price_per_day * $duration;
        } else {
            $totalPrice = $booking->total_price;
        }

        $booking->update([
            'user_id' => $request->user_id,
            'car_id' => $request->car_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'total_price' => $totalPrice,
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Pemesanan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $booking = Booking::findOrFail($id);
        
        // Only allow deletion if booking is pending or cancelled
        if (!in_array($booking->status, ['pending', 'cancelled'])) {
            return redirect()->route('admin.bookings.index')
                ->with('error', 'Pemesanan tidak dapat dihapus karena sudah diproses');
        }

        $booking->delete();

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Pemesanan berhasil dihapus');
    }

    /**
     * Approve booking
     */
    public function approve(string $id)
    {
        $booking = Booking::findOrFail($id);
        
        if ($booking->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'Pemesanan tidak dapat disetujui karena status bukan pending');
        }

        DB::transaction(function () use ($booking) {
            $booking->update(['status' => 'approved']);
            
            // Update car status to booked
            $booking->car->update(['status' => 'booked']);
        });

        return redirect()->back()
            ->with('success', 'Pemesanan berhasil disetujui');
    }

    /**
     * Reject booking
     */
    public function reject(Request $request, string $id)
    {
        $booking = Booking::findOrFail($id);
        
        if ($booking->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'Pemesanan tidak dapat ditolak karena status bukan pending');
        }

        $booking->update([
            'status' => 'rejected',
            'notes' => $request->notes ?? $booking->notes
        ]);

        return redirect()->back()
            ->with('success', 'Pemesanan berhasil ditolak');
    }

    /**
     * Complete booking
     */
    public function complete(string $id)
    {
        $booking = Booking::findOrFail($id);
        
        if ($booking->status !== 'approved') {
            return redirect()->back()
                ->with('error', 'Pemesanan tidak dapat diselesaikan karena status bukan approved');
        }

        DB::transaction(function () use ($booking) {
            $booking->update(['status' => 'completed']);
            
            // Update car status back to available
            $booking->car->update(['status' => 'available']);
        });

        return redirect()->back()
            ->with('success', 'Pemesanan berhasil diselesaikan');
    }

    /**
     * Cancel booking
     */
    public function cancel(Request $request, string $id)
    {
        $booking = Booking::findOrFail($id);
        
        if (!in_array($booking->status, ['pending', 'approved'])) {
            return redirect()->back()
                ->with('error', 'Pemesanan tidak dapat dibatalkan');
        }

        DB::transaction(function () use ($booking, $request) {
            $booking->update([
                'status' => 'cancelled',
                'notes' => $request->notes ?? $booking->notes
            ]);
            
            // Update car status back to available if it was booked
            if ($booking->car->status === 'booked') {
                $booking->car->update(['status' => 'available']);
            }
        });

        return redirect()->back()
            ->with('success', 'Pemesanan berhasil dibatalkan');
    }

    /**
     * Get booking statistics
     */
    public function statistics()
    {
        // Get database connection type to use appropriate syntax
        $dbDriver = DB::getDriverName();
        
        if ($dbDriver === 'pgsql') {
            // PostgreSQL syntax
            $monthlyBookings = Booking::selectRaw('EXTRACT(MONTH FROM created_at) as month, COUNT(*) as count')
                ->whereRaw('EXTRACT(YEAR FROM created_at) = ?', [date('Y')])
                ->groupBy(DB::raw('EXTRACT(MONTH FROM created_at)'))
                ->pluck('count', 'month');
        } else {
            // MySQL syntax (default)
            $monthlyBookings = Booking::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                ->whereYear('created_at', date('Y'))
                ->groupBy('month')
                ->pluck('count', 'month');
        }

        $stats = [
            'total_bookings' => Booking::count(),
            'pending_bookings' => Booking::where('status', 'pending')->count(),
            'approved_bookings' => Booking::where('status', 'approved')->count(),
            'completed_bookings' => Booking::where('status', 'completed')->count(),
            'rejected_bookings' => Booking::where('status', 'rejected')->count(),
            'cancelled_bookings' => Booking::where('status', 'cancelled')->count(),
            'total_revenue' => Booking::where('status', 'completed')->sum('total_price'),
            'monthly_bookings' => $monthlyBookings,
        ];

        // Get recent bookings for display (use paginate for links method)
        $bookings = Booking::with(['user', 'car'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.statistics', compact('stats', 'bookings'));
    }
}