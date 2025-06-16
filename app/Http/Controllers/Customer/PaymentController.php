<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    /**
     * Show payment form
     */
    public function create($bookingId)
    {
        $booking = Booking::where('user_id', Auth::id())
            ->where('status', 'approved')
            ->with(['car'])
            ->findOrFail($bookingId);

        // Check if payment already exists
        if ($booking->payment) {
            return redirect()->route('customer.bookings.index')
                ->with('error', 'Pembayaran sudah dilakukan untuk pemesanan ini.');
        }

        return view('customer.payments.create', compact('booking'));
    }

    /**
     * Process payment - Auto complete payment and redirect to bookings
     */
    public function store(Request $request, $bookingId)
    {
        $request->validate([
            'payment_method' => 'required|in:cash,bank_transfer,credit_card,debit_card,e_wallet',
            'payment_proof' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $booking = Booking::where('user_id', Auth::id())
            ->where('status', 'approved')
            ->findOrFail($bookingId);

        // Check if payment already exists
        if ($booking->payment) {
            return redirect()->route('customer.bookings.index')
                ->with('error', 'Pembayaran sudah dilakukan untuk pemesanan ini.');
        }

        try {
            $transactionId = null;
            
            DB::transaction(function () use ($request, $booking, &$transactionId) {
                // Handle file upload if exists
                $proofPath = null;
                if ($request->hasFile('payment_proof')) {
                    $proofPath = $request->file('payment_proof')->store('payment-proofs', 'public');
                }

                // Generate transaction ID
                $transactionId = Payment::generateTransactionId();

                // Create payment record with auto-completion
                Payment::create([
                    'booking_id' => $booking->id,
                    'payment_method' => $request->payment_method,
                    'payment_status' => 'paid', // Auto complete payment
                    'amount' => $booking->total_price,
                    'transaction_id' => $transactionId,
                    'paid_at' => now(),
                    'payment_proof' => $proofPath,
                ]);

                // Update booking status to in_progress
                $booking->update(['status' => 'in_progress']);

                // Update car status to rented if car has this field
                if ($booking->car && method_exists($booking->car, 'update')) {
                    try {
                        $booking->car->update(['availability_status' => 'rented']);
                    } catch (\Exception $e) {
                        // Car update failed, but payment succeeded - log it
                        \Log::warning('Failed to update car status after payment', [
                            'booking_id' => $booking->id,
                            'car_id' => $booking->car->id,
                            'error' => $e->getMessage()
                        ]);
                    }
                }
            });

            // Redirect to bookings list with success message
            return redirect()->route('customer.bookings.index')
                ->with('success', 'Pembayaran berhasil diproses! Transaction ID: ' . $transactionId . '. Mobil siap untuk digunakan.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memproses pembayaran. Silakan coba lagi.')
                ->withInput();
        }
    }

    /**
     * Show payment details
     */
    public function show($bookingId)
    {
        $booking = Booking::where('user_id', Auth::id())
            ->with(['car', 'payment'])
            ->findOrFail($bookingId);

        if (!$booking->payment) {
            return redirect()->route('customer.bookings.index')
                ->with('error', 'Pembayaran tidak ditemukan untuk pemesanan ini.');
        }

        return view('customer.payments.show', compact('booking'));
    }
}