<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Comment out or remove the factory calls
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Call seeders in the correct order
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            CarSeeder::class,
            BookingSeeder::class,
        ]);
    }
}
