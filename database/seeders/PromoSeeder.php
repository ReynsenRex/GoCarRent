<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Promo;

class PromoSeeder extends Seeder
{
    public function run(): void
    {
        Promo::insert([
            [
                'code' => 'DISC10',
                'description' => 'Diskon 10% untuk semua kendaraan',
                'discount_pct' => 10.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'LEBARAN15',
                'description' => 'Diskon spesial Lebaran 15%',
                'discount_pct' => 15.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'NEWUSER20',
                'description' => 'Diskon 20% untuk pengguna baru',
                'discount_pct' => 20.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}