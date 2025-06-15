<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Booking;
use App\Models\User;
use App\Models\Car;
use Carbon\Carbon;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Get all users (excluding admin if you want)
        $users = User::where('role_id', '!=', '1')->get();
        
        // Get all cars
        $cars = Car::all();
        
        if ($users->isEmpty() || $cars->isEmpty()) {
            $this->command->warn('Please make sure you have users and cars in the database before running this seeder.');
            return;
        }

        $statuses = ['pending', 'approved', 'rejected', 'in_progress', 'completed', 'cancelled'];
        
        // Create bookings for the past 12 months and next 3 months
        $startDate = Carbon::now()->subMonths(12);
        $endDate = Carbon::now()->addMonths(3);
        
        $bookings = [];
        
        // Generate 150 bookings
        for ($i = 0; $i < 150; $i++) {
            $user = $users->random();
            $car = $cars->random();
            
            // Random start date within our range
            $bookingStartDate = Carbon::createFromTimestamp(
                rand($startDate->timestamp, $endDate->timestamp)
            );
            
            // End date is 1-14 days after start date
            $bookingEndDate = $bookingStartDate->copy()->addDays(rand(1, 14));
            
            // Calculate total price based on car price and duration
            $duration = $bookingStartDate->diffInDays($bookingEndDate) + 1;
            $totalPrice = $car->price_per_day * $duration;
            
            // Add some variation to the price (discounts/surcharges)
            $priceVariation = rand(-10, 20); // -10% to +20%
            $totalPrice = $totalPrice * (1 + ($priceVariation / 100));
            
            // Determine status based on date
            $status = $this->determineStatus($bookingStartDate, $bookingEndDate);
            
            // Generate notes for some bookings
            $notes = $this->generateNotes($status);
            
            $bookings[] = [
                'user_id' => $user->id,
                'car_id' => $car->id,
                'start_date' => $bookingStartDate->format('Y-m-d'),
                'end_date' => $bookingEndDate->format('Y-m-d'),
                'total_price' => round($totalPrice, 2),
                'status' => $status,
                'notes' => $notes,
                'created_at' => $bookingStartDate->copy()->subDays(rand(1, 30)),
                'updated_at' => Carbon::now(),
            ];
        }
        
        // Insert bookings in chunks for better performance
        collect($bookings)->chunk(50)->each(function ($chunk) {
            Booking::insert($chunk->toArray());
        });
        
        $this->command->info('Bookings seeded successfully!');
        $this->command->info('Total bookings created: ' . count($bookings));
        
        // Show status distribution
        $statusCounts = collect($bookings)->countBy('status');
        $this->command->info('Status distribution:');
        foreach ($statusCounts as $status => $count) {
            $this->command->info("  {$status}: {$count}");
        }
    }
    
    /**
     * Determine booking status based on dates
     */
    private function determineStatus(Carbon $startDate, Carbon $endDate): string
    {
        $now = Carbon::now();
        
        // Past bookings
        if ($endDate->isPast()) {
            return collect(['completed', 'completed', 'completed', 'cancelled', 'rejected'])->random();
        }
        
        // Current bookings
        if ($startDate->isPast() && $endDate->isFuture()) {
            return collect(['in_progress', 'in_progress', 'approved'])->random();
        }
        
        // Future bookings
        if ($startDate->isFuture()) {
            // More recent bookings are more likely to be pending
            $daysUntilStart = $now->diffInDays($startDate);
            
            if ($daysUntilStart <= 7) {
                return collect(['pending', 'pending', 'approved', 'rejected'])->random();
            } elseif ($daysUntilStart <= 30) {
                return collect(['pending', 'approved', 'approved', 'rejected'])->random();
            } else {
                return collect(['pending', 'approved', 'cancelled'])->random();
            }
        }
        
        return 'pending';
    }
    
    /**
     * Generate realistic notes based on status
     */
    private function generateNotes(?string $status): ?string
    {
        // Only add notes to some bookings (60% chance)
        if (rand(1, 100) > 60) {
            return null;
        }
        
        $notes = [
            'pending' => [
                'Menunggu konfirmasi pembayaran',
                'Dokumen belum lengkap',
                'Sedang diproses tim admin',
                'Perlu verifikasi identitas',
                'Menunggu konfirmasi ketersediaan mobil',
            ],
            'approved' => [
                'Pembayaran telah dikonfirmasi',
                'Semua dokumen lengkap',
                'Mobil siap untuk digunakan',
                'Silakan datang ke kantor untuk pengambilan kunci',
                'Terima kasih atas kepercayaan Anda',
            ],
            'rejected' => [
                'Dokumen tidak valid',
                'Pembayaran gagal',
                'Mobil tidak tersedia pada tanggal yang diminta',
                'Tidak memenuhi syarat rental',
                'Data pribadi tidak sesuai',
            ],
            'in_progress' => [
                'Mobil sedang digunakan customer',
                'Dalam perjalanan',
                'Hubungi customer service jika ada kendala',
                'Pastikan mengembalikan dengan kondisi baik',
            ],
            'completed' => [
                'Rental selesai dengan baik',
                'Mobil dikembalikan dalam kondisi baik',
                'Terima kasih telah menggunakan layanan kami',
                'Deposit dikembalikan penuh',
                'Semoga puas dengan layanan kami',
            ],
            'cancelled' => [
                'Dibatalkan oleh customer',
                'Tidak ada kabar dari customer',
                'Customer mengubah rencana perjalanan',
                'Dibatalkan karena cuaca buruk',
                'Customer menemukan alternatif lain',
            ],
        ];
        
        $statusNotes = $notes[$status] ?? ['Catatan umum'];
        
        return collect($statusNotes)->random();
    }
}