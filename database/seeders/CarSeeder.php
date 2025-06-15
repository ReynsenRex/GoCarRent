<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Car;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cars = [
            [
                'brand' => 'Toyota',
                'model' => 'Avanza',
                'year' => 2023,
                'transmission' => 'manual',
                'price_per_day' => 250000.00,
                'availability_status' => 'available',
                'image_url' => 'https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?w=500',
                'description' => 'Comfortable family car with 7 seats, perfect for family trips',
                // 'license_plate' => 'B 1234 ABC',
                'capacity' => 7,
                'fuel_type' => 'Petrol',
            ],
            [
                'brand' => 'Honda',
                'model' => 'Civic',
                'year' => 2022,
                'transmission' => 'automatic',
                'price_per_day' => 400000.00,
                'availability_status' => 'available',
                'image_url' => 'https://images.unsplash.com/photo-1606664515524-ed2f786a0bd6?w=500',
                'description' => 'Stylish sedan with automatic transmission and excellent fuel efficiency',
                // 'license_plate' => 'B 5678 DEF',
                'capacity' => 5,
                'fuel_type' => 'Petrol',
            ],
            [
                'brand' => 'Mitsubishi',
                'model' => 'Pajero',
                'year' => 2021,
                'transmission' => 'automatic',
                'price_per_day' => 600000.00,
                'availability_status' => 'available',
                'image_url' => 'https://images.unsplash.com/photo-1544636331-e26879cd4d9b?w=500',
                'description' => 'Powerful SUV for adventure trips and off-road experiences',
                // 'license_plate' => 'B 9012 GHI',
                'capacity' => 7,
                'fuel_type' => 'Diesel',
            ],
            [
                'brand' => 'Suzuki',
                'model' => 'Ertiga',
                'year' => 2023,
                'transmission' => 'manual',
                'price_per_day' => 220000.00,
                'availability_status' => 'available',
                'image_url' => 'https://images.unsplash.com/photo-1502877338535-766e1452684a?w=500',
                'description' => 'Economical MPV with good fuel consumption',
                // 'license_plate' => 'B 3456 JKL',
                'capacity' => 7,
                'fuel_type' => 'Petrol',
            ],
            [
                'brand' => 'Daihatsu',
                'model' => 'Xenia',
                'year' => 2022,
                'transmission' => 'manual',
                'price_per_day' => 200000.00,
                'availability_status' => 'rented',
                'image_url' => 'https://images.unsplash.com/photo-1503736334956-4c8f8e92946d?w=500',
                'description' => 'Affordable family car with spacious interior',
                // 'license_plate' => 'B 7890 MNO',
                'capacity' => 7,
                'fuel_type' => 'Petrol',
            ],
            [
                'brand' => 'Nissan',
                'model' => 'X-Trail',
                'year' => 2020,
                'transmission' => 'automatic',
                'price_per_day' => 500000.00,
                'availability_status' => 'maintenance',
                'image_url' => 'https://images.unsplash.com/photo-1552519507-da3b142c6e3d?w=500',
                'description' => 'Premium SUV with advanced safety features',
                // 'license_plate' => 'B 2468 PQR',
                'capacity' => 7,
                'fuel_type' => 'Petrol',
            ],
        ];

        foreach ($cars as $car) {
            Car::create($car);
        }
    }
}
