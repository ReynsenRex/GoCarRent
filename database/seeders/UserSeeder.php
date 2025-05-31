<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@gocarrent.com',
            'password' => Hash::make('password123'),
            'role_id' => 1, // Admin
            'phone' => '081234567890',
            'address' => 'Jl. Admin No. 1, Jakarta',
        ]);

        User::create([
            'name' => 'Staff User',
            'email' => 'staff@gocarrent.com',
            'password' => Hash::make('password123'),
            'role_id' => 3, // Staff
            'phone' => '081234567891',
            'address' => 'Jl. Staff No. 2, Jakarta',
        ]);

        User::create([
            'name' => 'Customer User',
            'email' => 'customer@gocarrent.com',
            'password' => Hash::make('password123'),
            'role_id' => 2, // Customer
            'phone' => '081234567892',
            'address' => 'Jl. Customer No. 3, Jakarta',
            'license_number' => 'A123456789', // Changed from 'driver_license' to 'license_number'
        ]);

        // Add more sample customers
        User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => Hash::make('password123'),
            'role_id' => 2, // Customer
            'phone' => '081234567893',
            'address' => 'Jl. Customer No. 4, Jakarta',
            'license_number' => 'B987654321',
        ]);

        User::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'password' => Hash::make('password123'),
            'role_id' => 2, // Customer
            'phone' => '081234567894',
            'address' => 'Jl. Customer No. 5, Jakarta',
            'license_number' => 'C456789123',
        ]);
    }
}
