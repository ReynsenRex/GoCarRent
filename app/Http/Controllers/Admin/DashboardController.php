<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Promo;
use App\Models\Booking;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $bookings = Booking::with(['user', 'car'])
            ->where('status', Booking::STATUS_PENDING)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('admin.dashboard', compact('bookings'));
    }
}
