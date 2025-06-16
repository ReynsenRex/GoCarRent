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
                'image_url' => 'cars/' . 'avanza.jpg',
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
                'image_url' => 'cars/' . 'civic.jpg',
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
                'image_url' => 'cars/' . 'pajero.jpg',
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
                'image_url' => 'cars/' . 'ertiga.jpg',
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
                'image_url' => 'cars/' . 'xenia.jpg',
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
                'image_url' => 'cars/' . 'x-trail.jpg',
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
