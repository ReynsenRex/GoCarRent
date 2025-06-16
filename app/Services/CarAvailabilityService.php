<?php

namespace App\Services;

use App\Models\Booking;
use Carbon\Carbon;
use DatePeriod;
use DateTime;
use DateInterval;

class CarAvailabilityService
{
    /**
     * Get booked dates for a specific car
     */
    public function getBookedDates(int $carId, int $days = 90): array
    {
        $bookings = Booking::where('car_id', $carId)
            ->whereIn('status', ['pending', 'approved', 'in_progress'])
            ->get(['start_date', 'end_date']);

        $bookedDates = [];
        
        foreach ($bookings as $booking) {
            $period = new DatePeriod(
                new DateTime($booking->start_date),
                new DateInterval('P1D'),
                (new DateTime($booking->end_date))->modify('+1 day')
            );
            
            foreach ($period as $date) {
                $bookedDates[] = $date->format('Y-m-d');
            }
        }

        return array_unique($bookedDates);
    }

    /**
     * Generate availability calendar for frontend
     */
    public function getAvailabilityCalendar(int $carId, int $days = 90): array
    {
        $bookedDates = $this->getBookedDates($carId, $days);
        $availabilityData = [];
        $today = Carbon::today();

        for ($i = 0; $i < $days; $i++) {
            $date = $today->copy()->addDays($i);
            $dateStr = $date->format('Y-m-d');
            $availabilityData[$dateStr] = !in_array($dateStr, $bookedDates);
        }

        return $availabilityData;
    }

    /**
     * Check if a date range is available
     */
    public function isDateRangeAvailable(int $carId, string $startDate, string $endDate): bool
    {
        $bookedDates = $this->getBookedDates($carId);
        
        $period = new DatePeriod(
            new DateTime($startDate),
            new DateInterval('P1D'),
            (new DateTime($endDate))->modify('+1 day')
        );

        foreach ($period as $date) {
            if (in_array($date->format('Y-m-d'), $bookedDates)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get available dates in a specific month
     */
    public function getAvailableDatesInMonth(int $carId, int $year, int $month): array
    {
        $startDate = Carbon::create($year, $month, 1);
        $endDate = $startDate->copy()->endOfMonth();
        $bookedDates = $this->getBookedDates($carId);
        
        $availableDates = [];
        $current = $startDate->copy();
        
        while ($current <= $endDate) {
            if (!in_array($current->format('Y-m-d'), $bookedDates)) {
                $availableDates[] = $current->format('Y-m-d');
            }
            $current->addDay();
        }
        
        return $availableDates;
    }
}